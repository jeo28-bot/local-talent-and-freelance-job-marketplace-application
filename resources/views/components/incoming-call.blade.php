<div id="incomingCallModal" class="hidden fixed inset-0 modal_bg flex items-center justify-center z-50 p_font">
    <div class="bg-white rounded-lg p-6 w-96 text-center flex flex-col items-center shadow-lg">
        <h2 class="text-lg font-bold mb-4">Incoming Call</h2>
        <img src="{{asset('assets/defaultUserPic.png')}}" alt="" class="border-2 border-gray-200 rounded-full w-20 max-sm:w-15 h-20 max-sm:h-15 ">
        <p id="callerName" class="mb-6">Client...</p>
        <div class="flex justify-around gap-2">
            <button id="acceptCallBtn" class="bg-green-500 text-white px-4 py-2 rounded hover:bg-green-600">Accept</button>
            <button id="declineCallBtn" class="bg-red-500 text-white px-4 py-2 rounded hover:bg-red-600">Decline</button>
        </div>
    </div>
</div>
