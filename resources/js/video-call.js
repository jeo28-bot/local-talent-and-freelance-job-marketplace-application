    console.log('Video call JS loaded');

    document.addEventListener('DOMContentLoaded', () => {
        const loadingModal = document.getElementById('lodaing_modal');

        document.querySelectorAll('.video_call_btn').forEach(btn => {
            btn.addEventListener('click', async () => {

                let receiverId = btn.dataset.userId;
                let callerId = btn.dataset.callerId;
                let callerName = encodeURIComponent(btn.dataset.callerName);

                // Show loading modal
                loadingModal.classList.remove('hidden');

                try {
                    // 1️⃣ Check if user is online
                    let statusResponse = await fetch('/check-user-status', {
                        method: 'POST',
                        headers: {
                            "Content-Type": "application/json",
                            "X-CSRF-TOKEN": document.querySelector('meta[name="csrf-token"]').content
                        },
                        body: JSON.stringify({ user_id: receiverId })
                    });

                    let statusData = await statusResponse.json();
                    console.log("USER STATUS CHECK →", statusData);

                    if (statusData.status !== "online") {
                        alert("❌ The user is currently offline.");
                        loadingModal.classList.add('hidden'); // hide modal
                        return; // stop execution
                    }

                    // 2️⃣ Start the video call
                    let response = await fetch('/video-call/start', {
                        method: 'POST',
                        headers: {
                            "Content-Type": "application/json",
                            "X-CSRF-TOKEN": document.querySelector('meta[name="csrf-token"]').content
                        },
                        body: JSON.stringify({ receiver_id: receiverId })
                    });

                    let data = await response.json();
                    let roomLink = `${window.location.origin}/video-call/join/${data.roomName}?caller_id=${callerId}&caller_name=${callerName}`;

                    // 3️⃣ Send chat message with video call link
                    let parts = window.location.pathname.split('/');
                    let role = parts[1];
                    let chatName = parts[3];
                    let sendURL = `/${role}/chat/${chatName}/send`;

                    await fetch(sendURL, {
                        method: 'POST',
                        headers: {
                            "Content-Type": "application/json",
                            "X-CSRF-TOKEN": document.querySelector('meta[name="csrf-token"]').content
                        },
                        body: JSON.stringify({
                            receiver_id: receiverId,
                            content: `📞 Incoming Video Call — Join here: ${roomLink}`,
                            is_vc: 1
                        })
                    });

                    // 4️⃣ Redirect caller to video call
                    window.location.href = roomLink;

                } catch (error) {
                    console.error("Video call error →", error);
                    alert("❌ Something went wrong. Please try again.");
                    loadingModal.classList.add('hidden'); // hide modal
                }
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


