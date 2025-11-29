{{-- Incoming Video Call Modal --}}
<div id="incomingCallModal" class="hidden fixed inset-0 modal_bg flex items-center justify-center z-50 p_font">
    <div class="bg-white rounded-lg p-6 w-96 text-center flex flex-col items-center shadow-lg">
        <h2 class="text-lg font-bold mb-4">Incoming Call</h2>
        <img id="callerImage" src="{{ asset('assets/defaultUserPic.png') }}" class="border-2 border-gray-200 rounded-full w-20 h-20">
        <p id="callerName" class="mb-6">Client...</p>
        <div class="flex justify-around gap-2">
            <button id="acceptCallBtn" class="bg-green-500 text-white px-4 py-2 rounded hover:bg-green-600">Accept</button>
            <button id="declineCallBtn" class="bg-red-500 text-white px-4 py-2 rounded hover:bg-red-600">Decline</button>
        </div>
    </div>
</div>

<audio id="callRingtone" src="{{ asset('assets/phone-ringtone.mp3') }}" loop></audio>

<script>
if (!window.incomingCallInitialized) {  // <--- GUARD
    window.incomingCallInitialized = true;

    const modal = document.getElementById('incomingCallModal');
    const callerNameEl = document.getElementById('callerName');
    const acceptBtn = document.getElementById('acceptCallBtn');
    const declineBtn = document.getElementById('declineCallBtn');
    const ringtone = document.getElementById('callRingtone');
    const callerImage = document.getElementById('callerImage');

    setInterval(async () => {
        try {
            let res = await fetch('/chat/unread-vc');
            let data = await res.json();

            if (data.length) {
                let msg = data[0];

                modal.classList.remove('hidden');
                ringtone.currentTime = 0;
                ringtone.play();
                callerNameEl.textContent = msg.sender_name;
                callerImage.src = msg.sender_profile;

                acceptBtn.onclick = async () => {
                    ringtone.pause();
                    modal.classList.add('hidden'); // hide modal immediately

                    // Mark as read
                    await fetch(`/chat/mark-vc-read/${msg.id}`, {
                        method: 'POST',
                        headers: { "X-CSRF-TOKEN": document.querySelector('meta[name="csrf-token"]').content }
                    });

                    // Redirect to VC link
                    const urlMatch = msg.content.match(/https?:\/\/[^\s]+/);
                    if (urlMatch) window.location.href = urlMatch[0];
                };


                declineBtn.onclick = async () => {
                    ringtone.pause();
                    modal.classList.add('hidden');
                    await fetch(`/chat/mark-vc-read/${msg.id}`, {
                        method: 'POST',
                        headers: { "X-CSRF-TOKEN": document.querySelector('meta[name="csrf-token"]').content }
                    });
                };
            }
        } catch (e) {
            console.error('Error fetching unread VC:', e);
        }
    }, 3000);
}
</script>
