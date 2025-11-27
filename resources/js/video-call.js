    console.log('Video call JS loaded');

   document.addEventListener('DOMContentLoaded', () => {
        document.querySelectorAll('.video_call_btn').forEach(btn => {
            btn.addEventListener('click', async () => {

                let receiverId = btn.dataset.userId;
                let callerId = btn.dataset.callerId;
                let callerName = encodeURIComponent(btn.dataset.callerName);

                // Extract role + chatName from URL
                let parts = window.location.pathname.split('/'); 
                // Example: ['', 'employee', 'chat', 'john_doe']
                let role = parts[1];       // employee OR client OR admin
                let chatName = parts[3];   // john_doe

                // Build correct send URL
                let sendURL = `/${role}/chat/${chatName}/send`;

                // 1. Start the video call
                let response = await fetch('/video-call/start', {
                    method: 'POST',
                    headers: { 
                        "Content-Type": "application/json",
                        "X-CSRF-TOKEN": document.querySelector('meta[name="csrf-token"]').content
                    },
                    body: JSON.stringify({ receiver_id: receiverId })
                });

                let data = await response.json();

                // Build video call room link
                let roomLink = `${window.location.origin}/video-call/join/${data.roomName}?caller_id=${callerId}&caller_name=${callerName}`;

                // 2. Send chat message with video call link
                await fetch(sendURL, {
                    method: 'POST',
                    headers: { 
                        "Content-Type": "application/json",
                        "X-CSRF-TOKEN": document.querySelector('meta[name="csrf-token"]').content
                    },
                    body: JSON.stringify({
                        receiver_id: receiverId,
                        content: `📞 Incoming Video Call — Join here: ${roomLink}`,
                        is_vc: 1 // <--- ADD THIS ONLY
                    })
                });




                // 3. Redirect caller to video call
                window.location.href = roomLink;
            });
        });
    });

    

        


    Echo.private(`user.${USER_ID}`)
        .listen('.incoming-call', (e) => {
            document.getElementById('incomingCallModal').classList.remove('hidden');

            window.incomingRoom = e.roomName;
            window.callerId = e.callerId;

            document.getElementById('callerName').innerText =
                `User #${e.callerId} is calling you...`;
        });

    document.getElementById('acceptCallBtn').onclick = () => {
        window.location.href = `/video-call/join/${window.incomingRoom}`;
    };

    document.getElementById('rejectCallBtn').onclick = () => {
        document.getElementById('incomingCallModal').classList.add('hidden');
    };


