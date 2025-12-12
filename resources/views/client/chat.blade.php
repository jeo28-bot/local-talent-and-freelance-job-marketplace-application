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
                    <div class="flex flex-col gap-2 overflow-x-auto p-2 w-full max-sm:max-h-50 overflow-auto max-sm:hidden">
                        @forelse ($chatUsers as $chatUser)
                            @php
                                $lastMessage = \App\Models\Message::where(function ($query) use ($user, $chatUser) {
                                        $query->where('sender_id', $user->id)
                                            ->where('receiver_id', $chatUser->id);
                                    })
                                    ->orWhere(function ($query) use ($user, $chatUser) {
                                        $query->where('sender_id', $chatUser->id)
                                            ->where('receiver_id', $user->id);
                                    })
                                    ->latest()
                                    ->first();
                            @endphp

                            <a href="{{ route('client.chat', ['name' => $chatUser->name]) }}" 
                            class="p-2 rounded-lg hover:bg-gray-200 cursor-pointer flex items-center w-full 
                            {{ request()->is('client/chat/' . $chatUser->name) ? 'bg-gray-200' : 'bg-white hover:bg-gray-200' }}">
                                <img src="{{ $chatUser->profile_pic 
                                        ? asset('storage/' . $chatUser->profile_pic) 
                                        : asset('assets/defaultUserPic.png') }}" 
                                    alt="{{ $chatUser->name }}" class="w-10 h-10 rounded-full inline-block mr-2 border-2 border-gray-400">

                                <div>
                                    <h2 class="font-bold text-gray-800 p_font">{{ $chatUser->name }}</h2>
                                    <p class="text-gray-600 text-sm truncate w-[150px] p_font">
                                        @if ($lastMessage)
                                            @if ($lastMessage->sender_id === $user->id)
                                                <span class="">You:</span>
                                            @endif
                                            {{ $lastMessage->content }}
                                        @else
                                            No messages yet
                                        @endif
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

                        <a href="{{ route('client.public_profile', ['name' => urlencode($receiver->name)]) }}" class="text-2xl font-bold! p_font  text-blue-500 hover:underline cursor-pointer">{{ $receiver->name }}</a>
                        {{-- User status indicator --}}
                        @php
                            $status = trim(strtolower($receiver->status)); // make sure it's normalized
                        @endphp

                        <span class="relative group p-1.5 rounded-full ml-2 {{ $status === 'online' ? 'bg-green-400' : 'bg-gray-400' }}">
                            <span class="absolute bottom-full mt-2 hidden group-hover:block 
                                        px-2 py-1 text-xs text-white bg-[#1e2939] rounded 
                                        opacity-0 group-hover:opacity-100 transition-opacity duration-200 p_font">
                                {{ ucfirst($status) }} {{-- Will show Online or Offline --}}
                            </span>
                        </span>

                        
                        {{-- ellipse for block and report dropdown --}}
                        <div class="relative ml-auto">
                            {{-- video call --}}
                            <button  data-user-id="{{ $receiver->id }}"
                                    data-caller-id="{{ auth()->id() }}"
                                    data-caller-name="{{ auth()->user()->name }}"
                                    class="video_call_btn p-1 rounded-lg ml-auto
                                        {{ $status !== 'online' || $isBlocked ? 'opacity-50 cursor-not-allowed hover:bg-none' : 'hover:bg-gray-300' }}"
                                    {{ $status !== 'online' || $isBlocked ? 'disabled' : '' }}>
                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-6">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="m15.75 10.5 4.72-4.72a.75.75 0 0 1 1.28.53v11.38a.75.75 0 0 1-1.28.53l-4.72-4.72M4.5 18.75h9a2.25 2.25 0 0 0 2.25-2.25v-9a2.25 2.25 0 0 0-2.25-2.25h-9A2.25 2.25 0 0 0 2.25 7.5v9a2.25 2.25 0 0 0 2.25 2.25Z" />
                                </svg>
                            </button>



                            <!-- Ellipsis button -->
                            <button id="chat_options_btn" type="button"
                                class="p-1 bg-gray-200 rounded-lg cursor-pointer hover:bg-gray-300 ml-auto hidden">
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

                        @php 
                            $previousDate = null; 
                            
                            function makeLinksClickable($text) {
                                // Convert URLs → links
                                return preg_replace(
                                    '/(https?:\/\/[^\s]+)/',
                                    '<a href="$1" target="_blank" class="text-blue-700 underline font-semibold hover:text-blue-900">$1</a>',
                                    e($text)
                                );
                            }
                        @endphp

                        @foreach ($messages as $message)

                            @php
                                $currentDate = $message->created_at->toDateString();
                                $isSender = $message->sender_id === Auth::id();
                                $bubbleClass = $isSender
                                    ? 'bg-blue-300 ml-auto'
                                    : 'bg-gray-300';
                                $hasLink = $message->content && preg_match('/https?:\/\/[^\s]+/', $message->content);
                                $bubbleHighlight = $hasLink ? 'ring-2 ring-blue-400' : '';
                            @endphp
                            

                            {{-- 🔥 DATE HEADER --}}
                            @if ($currentDate !== $previousDate)
                                <div class="flex justify-center my-2">
                                    <span class="text-xs text-gray-500 bg-gray-200 px-3 py-1 rounded-full">
                                        {{ $message->created_at->format('F j, Y') }}
                                    </span>
                                </div>
                                @php $previousDate = $currentDate; @endphp
                            @endif

                            {{-- 🔥 MESSAGE BUBBLE (text + image + files) --}}
                           <div class="p-2 rounded-lg w-fit max-w-120 max-lg:max-w-90 max-sm:max-w-70 max-sm:text-sm break-words {{ $bubbleClass }} {{ $bubbleHighlight }}">


                                {{-- 📝 TEXT --}}
                                @if ($message->content)
                                    <p>{!! makeLinksClickable($message->content) !!}</p>
                                @endif

                                {{-- 🖼 IMAGE PREVIEW --}}
                                @if ($message->file_type === 'image')
                                    <div class="mt-2">
                                        <img
                                            src="{{ asset('storage/' . $message->file) }}"
                                            class="rounded-lg max-w-60 max-h-60 border cursor-pointer hover:opacity-90"
                                            onclick="window.open('{{ asset('storage/' . $message->file) }}', '_blank')"
                                        />
                                    </div>
                                @endif

                                {{-- 📄 FILE (PDF, DOCX, XLSX, ZIP, etc.) --}}
                                @if ($message->file_type === 'file')
                                    <a
                                        href="{{ asset('storage/' . $message->file) }}"
                                        download
                                        class="flex items-center gap-2 p-2 mt-2 bg-white rounded-md shadow-sm hover:bg-gray-100 border"
                                    >
                                        {{-- File Icon --}}
                                        <svg xmlns="http://www.w3.org/2000/svg" fill="none"
                                            viewBox="0 0 24 24" stroke-width="1.5"
                                            stroke="currentColor" class="w-6 h-6">
                                            <path stroke-linecap="round" stroke-linejoin="round"
                                                d="M19.5 14.25v-2.625a3.375 3.375 0 00-3.375-3.375H8.25m0
                                                0L12 4.5m-3.75 4.125L12 12.75m0 0l3.75-4.125M12 
                                                12.75l-3.75 4.125M12 12.75l3.75 4.125" />
                                        </svg>

                                        <span class="text-sm underline truncate max-w-40">
                                            {{ basename($message->file) }}
                                        </span>
                                    </a>
                                @endif

                                {{-- 🕒 TIMESTAMP --}}
                                @php
                                    $time = $message->created_at->timezone('Asia/Manila')->format('g:i a');
                                @endphp
                                <span class="text-gray-500 text-xs block text-right mt-1">
                                    {{ $time }}
                                </span>

                            </div>

                        @endforeach

                    </div>

                    


                    {{-- chat when blocked --}}
                   @if($isBlocked)
                        {{-- chat when blocked --}}
                        <div class="p-4 border-t border-gray-300 flex flex-col items-center gap-1 bg-gray-200">
                            <h1 class="p_font text-sm">This user is unavailable.</h1>
                            <p class="home_p_font text-xs">You can’t message this user right now. Try again later.</p>
                        </div>
                    @else
                        <form id="chatForm"
                            action="{{ route($rolePrefix . '.chat.send', ['name' => $receiver->name]) }}"
                            method="POST"
                            enctype="multipart/form-data"
                            class="p-4 border-t border-gray-300 flex items-center gap-2">

                            @csrf

                            <label for="fileInput" class="hover:bg-gray-300 p-2 rounded-full cursor-pointer">
                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-5 max-sm:size-4">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="m18.375 12.739-7.693 7.693a4.5 4.5 0 0 1-6.364-6.364l10.94-10.94A3 3 0 1 1 19.5 7.372L8.552 18.32m.009-.01-.01.01m5.699-9.941-7.81 7.81a1.5 1.5 0 0 0 2.112 2.13" />
                                </svg>
                            </label>

                            <input id="fileInput"
                                type="file"
                                name="file"
                                class="hidden"
                                onchange="document.getElementById('chatForm').submit()" />

                            <input id="messageInput"
                                type="text"
                                name="content"
                                placeholder="Type your message..."
                                class="w-full p-2 border border-gray-300 rounded-lg focus:outline-none">

                            <button class="bg-blue-500 text-white px-4 py-2 rounded-lg hover:bg-blue-600 p_font cursor-pointer">
                                Send
                            </button>
                        </form>
                    @endif

                    


                </div>

            </div>

           
            

        </div>
     </section>

    {{-- modal section --}}

    {{-- loading modal --}}
    <div id="lodaing_modal" class="hidden modal_bg min-h-screen fixed top-0 z-40 w-full flex items-center justify-center px-5">
       <div class="grid min-h-[140px] w-full place-items-center rounded-lg p-6 ">
            <svg class="text-gray-300 animate-spin" viewBox="0 0 64 64" fill="none" xmlns="http://www.w3.org/2000/svg"
                width="24" height="24">
                <path
                d="M32 3C35.8083 3 39.5794 3.75011 43.0978 5.20749C46.6163 6.66488 49.8132 8.80101 52.5061 11.4939C55.199 14.1868 57.3351 17.3837 58.7925 20.9022C60.2499 24.4206 61 28.1917 61 32C61 35.8083 60.2499 39.5794 58.7925 43.0978C57.3351 46.6163 55.199 49.8132 52.5061 52.5061C49.8132 55.199 46.6163 57.3351 43.0978 58.7925C39.5794 60.2499 35.8083 61 32 61C28.1917 61 24.4206 60.2499 20.9022 58.7925C17.3837 57.3351 14.1868 55.199 11.4939 52.5061C8.801 49.8132 6.66487 46.6163 5.20749 43.0978C3.7501 39.5794 3 35.8083 3 32C3 28.1917 3.75011 24.4206 5.2075 20.9022C6.66489 17.3837 8.80101 14.1868 11.4939 11.4939C14.1868 8.80099 17.3838 6.66487 20.9022 5.20749C24.4206 3.7501 28.1917 3 32 3L32 3Z"
                stroke="currentColor" stroke-width="5" stroke-linecap="round" stroke-linejoin="round"></path>
                <path
                d="M32 3C36.5778 3 41.0906 4.08374 45.1692 6.16256C49.2477 8.24138 52.7762 11.2562 55.466 14.9605C58.1558 18.6647 59.9304 22.9531 60.6448 27.4748C61.3591 31.9965 60.9928 36.6232 59.5759 40.9762"
                stroke="currentColor" stroke-width="5" stroke-linecap="round" stroke-linejoin="round" class="text-gray-900">
                </path>
            </svg>
        </div>
    </div>



    {{-- script section --}}
    


    {{-- Incoming Video Call Modal --}}



    {{-- reload if new message js --}}
    <script>
        const chatContainer = document.querySelector('#chatContainer');
        const rolePrefix = "{{ $rolePrefix }}";
        const receiverName = "{{ $receiver->name }}";
        const chatMenu = document.querySelector('.flex.flex-col.gap-2.overflow-x-auto');
        let lastMessageCount = {{ count($messages) }};

        async function fetchMessages() {
            try {
                const res = await fetch(`/${rolePrefix}/chat/${receiverName}/messages`);
                if (!res.ok) return;

                const data = await res.json();

                if (data.length !== lastMessageCount) {
                    lastMessageCount = data.length;
                    chatContainer.innerHTML = '';

                    let previousDate = null;

                    data.forEach(msg => {
                        const msgDate = new Date(msg.created_at).toISOString().split('T')[0];

                        // 🔥 Date header if day changes
                        if (msgDate !== previousDate) {
                            const dateBox = document.createElement('div');
                            dateBox.className = "flex justify-center my-2";
                            dateBox.innerHTML = `
                                <span class="text-xs text-gray-500 bg-gray-200 px-3 py-1 rounded-full">
                                    ${new Date(msg.created_at).toLocaleDateString('en-US', {
                                        month: 'long', day: 'numeric', year: 'numeric'
                                    })}
                                </span>
                            `;
                            chatContainer.appendChild(dateBox);
                            previousDate = msgDate;
                        }

                        // 🔵 Message bubble
                        const isSender = msg.sender_id === {{ Auth::id() }};
                        const bubble = document.createElement('div');
                        bubble.className = `p-2 rounded-lg w-fit max-w-120 max-lg:max-w-90 max-sm:max-w-70 max-sm:text-sm break-words ${isSender ? 'bg-blue-300 ml-auto' : 'bg-gray-300'}`;

                        let bubbleContent = '';

                        // 📝 Text
                        if (msg.content) {
                            const urlRegex = /(https?:\/\/[^\s]+)/g;
                            const linkedText = msg.content.replace(urlRegex, (url) => {
                                const shortUrl = url.length > 50 ? url.substring(0, 50) + "..." : url;
                                return `<a href="${url}" target="_blank" class="text-blue-600 underline break-all font-semibold">${shortUrl}</a>`;
                            });

                            bubbleContent += `<p>${linkedText}</p>`;
                        }

                        // 🖼 Image preview
                        if (msg.file_type === 'image') {
                            bubbleContent += `
                                <div class="mt-2">
                                    <img src="/storage/${msg.file}"
                                        class="rounded-lg max-w-60 max-h-60 border cursor-pointer hover:opacity-90"
                                        onclick="window.open('/storage/${msg.file}', '_blank')"
                                    />
                                </div>
                            `;
                        }

                        // 📄 File (PDF, DOCX, XLSX, ZIP, etc.)
                        if (msg.file_type === 'file') {
                            const fileName = msg.file.split('/').pop();
                            bubbleContent += `
                                <a href="/storage/${msg.file}" download
                                class="flex items-center gap-2 p-2 mt-2 bg-white rounded-md shadow-sm hover:bg-gray-100 border">
                                    <svg xmlns="http://www.w3.org/2000/svg" fill="none"
                                        viewBox="0 0 24 24" stroke-width="1.5"
                                        stroke="currentColor" class="w-6 h-6">
                                        <path stroke-linecap="round" stroke-linejoin="round"
                                            d="M19.5 14.25v-2.625a3.375 3.375 0 00-3.375-3.375H8.25m0
                                                0L12 4.5m-3.75 4.125L12 12.75m0 0l3.75-4.125M12 
                                                12.75l-3.75 4.125M12 12.75l3.75 4.125" />
                                    </svg>
                                    <span class="text-sm underline truncate max-w-40">${fileName}</span>
                                </a>
                            `;
                        }

                        // 🕒 Time
                        bubbleContent += `
                            <span class="text-gray-500 text-xs block text-right mt-1">
                                ${new Date(msg.created_at).toLocaleTimeString([], { hour: 'numeric', minute: '2-digit' })}
                            </span>
                        `;

                        bubble.innerHTML = bubbleContent;
                        chatContainer.appendChild(bubble);
                    });

                    chatContainer.scrollTop = chatContainer.scrollHeight;
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
                const parser = new DOMParser();
                const doc = parser.parseFromString(html, 'text/html');
                const newMenu = doc.querySelector('.flex.flex-col.gap-2.overflow-x-auto');
                if (newMenu && chatMenu) chatMenu.innerHTML = newMenu.innerHTML;
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

    {{-- filter and show chat menu around max-sm --}}
    <script>
    document.addEventListener('DOMContentLoaded', () => {
        const searchInput = document.querySelector('input[placeholder="Search"]');
        const chatMenu = document.querySelector('.flex.flex-col.gap-2.overflow-x-auto');
        const chatItems = chatMenu.querySelectorAll('a');

        // ✅ show chat menu when focused or typing (mobile only)
        const showChatMenu = () => {
            if (window.innerWidth <= 640) {
                chatMenu.classList.remove('max-sm:hidden', 'hidden');
            }
        };

        // ✅ hide chat menu when blur + empty (mobile only)
        const hideChatMenu = () => {
            if (window.innerWidth <= 640 && searchInput.value.trim() === '') {
                setTimeout(() => {
                    chatMenu.classList.add('max-sm:hidden');
                }, 150);
            }
        };

        // focus → show
        searchInput.addEventListener('focus', showChatMenu);

        // blur → hide if empty
        searchInput.addEventListener('blur', hideChatMenu);

        // input → live filter + auto show
        searchInput.addEventListener('input', () => {
            const query = searchInput.value.toLowerCase();

            chatItems.forEach(item => {
                const name = item.querySelector('h2').textContent.toLowerCase();
                item.style.display = name.includes(query) ? 'flex' : 'none';
            });

            // also show when typing on mobile
            if (query.length > 0) showChatMenu();
        });
    });
    </script>




@include('components.footer_client')

<script src="{{ asset('js/client.js') }}"></script>
<script src="{{ asset('js/client/chat.js') }}"></script>
<script src="{{ asset('js/client/profile.js') }}"></script>
@endsection