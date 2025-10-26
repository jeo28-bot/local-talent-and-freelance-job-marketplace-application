@extends('layouts.app')

@section('body-class', 'bg-[#F0F0F0] ')

@section('content')
    @include('components.nav_client')


     <section class="w-ful min-h-[80vh] px-10 py-10 max-sm:py-5 max-sm:px-4 ">
        <div class="xl:w-6xl lg:w-full mx-auto px-5 max-sm:px-3 mb-10 ">
            {{-- chat box container --}}
            <div class="flex shadow-lg  rounded-lg overflow-hidden max-sm:flex-col">
                {{-- horizontal chat menu --}}
                <div class=" shadow-md bg-white w-sm border-r border-gray-300 max-sm:w-full max-sm:border-r-0 max-sm:border-b flex flex-col">
                    {{-- title --}}
                    <h1 class="text-3xl font-bold! p_font p-4 bg-[#1e2939] text-white ">Chats</h1>
                    {{-- search bar --}}
                    <div>
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-6 absolute text-gray-400 mt-2 ml-2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="m21 21-5.197-5.197m0 0A7.5 7.5 0 1 0 5.196 5.196a7.5 7.5 0 0 0 10.607 10.607Z" />
                        </svg>
                        <input type="text" placeholder="Search" class="w-full p-2 pl-10 border-b border-gray-300 focus:outline-none">
                    </div>
                    {{-- chat menu --}}
                    <div class="flex flex-col gap-2 overflow-x-auto p-2 w-full max-sm:max-h-50 overflow-auto ">
                        @forelse ($chatUsers as $chatUser)
                            <a href="{{ route('client.chat', ['name' => $chatUser->name]) }}" 
                            class="p-2 rounded-lg hover:bg-gray-200 cursor-pointer flex items-center w-full 
                            {{ request()->is('client/chat/' . $chatUser->name) ? 'bg-gray-200' : 'bg-white hover:bg-gray-200' }}">
                                <img src="{{ $chatUser->profile_pic 
                                        ? asset('storage/' . $chatUser->profile_pic) 
                                        : asset('assets/defaultUserPic.png') }}" 
                                    alt="{{ $chatUser->name }}" alt="" class="w-10 h-10 rounded-full inline-block mr-2 border-2 border-gray-400">
                                <div>
                                    <h2 class="font-bold text-gray-800 p_font">{{ $chatUser->name }}</h2>
                                    <p class="text-gray-600 text-sm truncate w-[150px] p_font">
                                        {{ optional(
                                            \App\Models\Message::where(function ($query) use ($user, $chatUser) {
                                                    $query->where('sender_id', $user->id)
                                                        ->where('receiver_id', $chatUser->id);
                                                })
                                                ->orWhere(function ($query) use ($user, $chatUser) {
                                                    $query->where('sender_id', $chatUser->id)
                                                        ->where('receiver_id', $user->id);
                                                })
                                                ->latest()
                                                ->first()
                                        )->content ?? 'No messages yet' }}
                                    </p>
                                </div>
                            </a>
                        @empty
                            <p class="text-gray-400 p-2 p_font italic">No chats yet</p>
                        @endforelse
                    </div>



                </div>

                {{-- chat box --}}
                <div class=" bg-white w-full ">
                    {{-- chat header --}}
                    <div class="px-4 py-3.5 border-gray-300 border-b flex items-center">
                        <img src="{{ $receiver->profile_pic ? asset('storage/' . $receiver->profile_pic) : asset('assets/defaultUserPic.png') }}" alt="" class="w-10 h-10 rounded-full inline-block mr-2 border-2 border-gray-400">

                        <a href="" class="text-2xl font-bold! p_font  text-blue-500 hover:underline cursor-pointer">{{ $receiver->name }}</a>
                        {{-- ellipse for block and report dropdown --}}
                        <div class="relative ml-auto">
                            <!-- Ellipsis button -->
                            <button id="chat_options_btn" type="button"
                                class="p-1 bg-gray-200 rounded-lg cursor-pointer hover:bg-gray-300 ml-auto">
                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                    stroke-width="1.5" stroke="currentColor" class="size-6">
                                    <path stroke-linecap="round" stroke-linejoin="round"
                                        d="M6.75 12a.75.75 0 1 1-1.5 0 .75.75 0 0 1 1.5 0ZM12.75 12a.75.75 0 1 1-1.5 0 .75.75 0 0 1 1.5 0ZM18.75 12a.75.75 0 1 1-1.5 0 .75.75 0 0 1 1.5 0Z" />
                                </svg>
                            </button>

                            <!-- Dropdown -->
                            <div id="chat_options_menu"
                                class="absolute right-0 mt-2 w-32 bg-white border border-gray-300 rounded-lg shadow-lg  z-50 hidden">
                                <button
                                    class="w-full text-left px-4 py-2 text-sm hover:bg-gray-100 text-red-500 p_font cursor-pointer">Delete</button>
                                <button>
                                <button
                                    class="w-full text-left px-4 py-2 text-sm hover:bg-gray-100 text-red-500 p_font cursor-pointer">Block</button>
                                <button
                                    class="w-full text-left px-4 py-2 text-sm hover:bg-gray-100 text-gray-600 p_font cursor-pointer">Report</button>
                            </div>
                        </div>

                    </div>

                    {{-- chat messages --}}
                    <div id="chatContainer" class="p-4 h-130 overflow-y-auto flex flex-col gap-4 bg-gray-100 p_font">

                        @foreach ($messages as $message)
                            @if ($message->sender_id === Auth::id())
                                {{-- sender (current user) --}}
                                <p class="p-2 bg-blue-300 rounded-lg w-fit max-w-120 max-lg:max-w-90 max-sm:max-w-70 max-sm:text-sm ml-auto break-words">
                                    {{ $message->content }}
                                    <br>
                                    <span class="text-gray-500 text-xs block text-right">
                                        {{ $message->created_at->format('g:i a') }}
                                    </span>
                                </p>

                                
                            @else
                                {{-- receiver --}}
                                <p class="p-2 bg-gray-300 text-left rounded-lg w-fit max-w-120 max-lg:max-w-90 max-sm:max-w-70 max-sm:text-sm break-words">
                                    {{ $message->content }}
                                    <br>
                                    <span class="text-gray-500 text-xs block text-right">
                                        {{ $message->created_at->format('g:i a') }}
                                    </span> 
                                </p>
                            @endif
                            
                        @endforeach
                                
                    </div>



                    {{-- chat input --}}
                    <form id="chatForm" action="{{ route($rolePrefix . '.chat.send', ['name' => $receiver->name]) }}" method="POST" class="p-4 border-t border-gray-300 flex items-center gap-2">
                        @csrf
                        <input id="messageInput" type="text" name="content" placeholder="Type your message..." class="w-full p-2 border border-gray-300 rounded-lg focus:outline-none">
                        <button class="bg-blue-500 text-white px-4 py-2 rounded-lg hover:bg-blue-600 p_font cursor-pointer">Send</button>
                    </form>


                </div>

            </div>

           
        </div>
     </section>

    <script>
        const chatContainer = document.querySelector('#chatContainer');
        const rolePrefix = "{{ $rolePrefix }}";
        const receiverName = "{{ $receiver->name }}";
        const chatMenu = document.querySelector('.flex.flex-col.gap-2.overflow-x-auto'); // the chat list
        let lastMessageCount = {{ count($messages) }};

        async function fetchMessages() {
            try {
                const res = await fetch(`/${rolePrefix}/chat/${receiverName}/messages`);
                if (!res.ok) return;
                const data = await res.json();

                if (data.length !== lastMessageCount) {
                    lastMessageCount = data.length;
                    chatContainer.innerHTML = '';
                    data.forEach(msg => {
                        const bubble = document.createElement('p');
                        const isSender = msg.sender_id === {{ Auth::id() }};
                        bubble.className = isSender
                            ? "p-2 bg-blue-300 rounded-lg w-fit max-w-120 ml-auto break-words"
                            : "p-2 bg-gray-300 rounded-lg w-fit max-w-120 break-words";
                        bubble.innerHTML = `
                            ${msg.content}
                            <br>
                            <span class="text-gray-500 text-xs block text-right">
                                ${new Date(msg.created_at).toLocaleTimeString([], { hour: 'numeric', minute: '2-digit' })}
                            </span>
                        `;
                        chatContainer.appendChild(bubble);
                    });
                    chatContainer.scrollTop = chatContainer.scrollHeight;

                    // ✅ Refresh chat list preview
                    fetchChatMenu();
                }
            } catch (e) {
                console.error('Error fetching messages', e);
            }
        }

        async function fetchChatMenu() {
            try {
                const res = await fetch(`/${rolePrefix}/chats`);
                if (!res.ok) return;
                const html = await res.text();
                // Parse and update the chat list portion only
                const parser = new DOMParser();
                const doc = parser.parseFromString(html, 'text/html');
                const newMenu = doc.querySelector('.flex.flex-col.gap-2.overflow-x-auto');
                if (newMenu && chatMenu) {
                    chatMenu.innerHTML = newMenu.innerHTML;
                }
            } catch (e) {
                console.error('Error fetching chat menu', e);
            }
        }

        // Auto-refresh messages and chat menu every 2 seconds
        setInterval(fetchMessages, 2000);
    </script>


<script>
const deleteBtn = document.querySelector('#chat_options_menu button:first-child');
deleteBtn.addEventListener('click', async () => {
    if (!confirm('Are you sure you want to delete this chat?')) return;

    const rolePrefix = "{{ $rolePrefix }}";
    const receiverName = "{{ $receiver->name }}";

    const res = await fetch(`/${rolePrefix}/chat/${receiverName}/delete`, {
        method: 'DELETE',
        headers: {
            'X-CSRF-TOKEN': document.querySelector('input[name="_token"]').value,
            'X-Requested-With': 'XMLHttpRequest'
        }
    });

    if (res.ok) {
        // ✅ Refresh the current chat page
        location.reload();
    }
});


</script>






@include('components.footer_client')

<script src="{{ asset('js/client.js') }}"></script>
<script src="{{ asset('js/client/chat.js') }}"></script>
<script src="{{ asset('js/client/profile.js') }}"></script>
@endsection