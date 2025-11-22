{{-- incoming call modal --}}
    <div id="incomingCallModal" class="modal_bg min-h-screen fixed top-0 z-40 w-full flex items-center justify-center px-5 hidden">
        <div class=" px-5 py-3 bg-white rounded-xl flex flex-col items-center gap-3 shadow-lg max-sm:w-full max-sm:px-3">
            <img src="{{asset('assets/defaultUserPic.png')}}" alt="profile picture" class="w-20 h-20 max-sm:w-15 max-sm:h-15 rounded-full mx-auto border-2 border-gray-400">
            <h2 class="text-xl sub_title_font font-semibold text-center">Incoming call from <span class="text-blue-500">Client</span></h2>
            <div class="flex gap-4">
                <button id="acceptCall" type="button" type="button"
                    class="bg-[#1e2939] cursor-pointer sub_title_font text-green-400 p-2 rounded-full hover:bg-[#374151] max-sm:text-sm">
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="size-6">
                    <path fill-rule="evenodd" d="M1.5 4.5a3 3 0 0 1 3-3h1.372c.86 0 1.61.586 1.819 1.42l1.105 4.423a1.875 1.875 0 0 1-.694 1.955l-1.293.97c-.135.101-.164.249-.126.352a11.285 11.285 0 0 0 6.697 6.697c.103.038.25.009.352-.126l.97-1.293a1.875 1.875 0 0 1 1.955-.694l4.423 1.105c.834.209 1.42.959 1.42 1.82V19.5a3 3 0 0 1-3 3h-2.25C8.552 22.5 1.5 15.448 1.5 6.75V4.5Z" clip-rule="evenodd" />
                    </svg>
                </button>

                <button id="declineCall" type="button" type="button"
                    class="bg-[#1e2939] cursor-pointer sub_title_font text-red-400 p-2 rounded-full hover:bg-[#374151] max-sm:text-sm">
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="size-6 rotate-135">
                    <path fill-rule="evenodd" d="M1.5 4.5a3 3 0 0 1 3-3h1.372c.86 0 1.61.586 1.819 1.42l1.105 4.423a1.875 1.875 0 0 1-.694 1.955l-1.293.97c-.135.101-.164.249-.126.352a11.285 11.285 0 0 0 6.697 6.697c.103.038.25.009.352-.126l.97-1.293a1.875 1.875 0 0 1 1.955-.694l4.423 1.105c.834.209 1.42.959 1.42 1.82V19.5a3 3 0 0 1-3 3h-2.25C8.552 22.5 1.5 15.448 1.5 6.75V4.5Z" clip-rule="evenodd" />
                    </svg>
                </button>

            </div>
        </div>
    </div>

    
<script>
document.getElementById('acceptCall').addEventListener('click', () => {
    const modal = document.getElementById('incomingCallModal');
    modal.classList.add('hidden');
    // redirect to the actual video call page if needed
    window.location.href = `/employee/video-call/${currentCallerId}`;
});

document.getElementById('declineCall').addEventListener('click', () => {
    const modal = document.getElementById('incomingCallModal');
    modal.classList.add('hidden');
});
</script>