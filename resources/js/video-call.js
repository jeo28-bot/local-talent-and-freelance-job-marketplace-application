    console.log('Video call JS loaded');

    document.addEventListener('DOMContentLoaded', () => {
        document.querySelectorAll('.video_call_btn').forEach(btn => {
            btn.addEventListener('click', async () => {
                let receiverId = btn.dataset.userId;

                let callerId = btn.dataset.callerId;
                let callerName = encodeURIComponent(btn.dataset.callerName);

                let response = await fetch('/video-call/start', {
                    method: 'POST',
                    headers: { 
                        "Content-Type": "application/json",
                        "X-CSRF-TOKEN": document.querySelector('meta[name="csrf-token"]').content
                    },
                    body: JSON.stringify({ receiver_id: receiverId })
                });

                let data = await response.json();

                window.location.href = `/video-call/join/${data.roomName}?caller_id=${callerId}&caller_name=${callerName}`;
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


