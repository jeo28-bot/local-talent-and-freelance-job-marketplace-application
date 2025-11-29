@extends('layouts.app')

@section('body-class', 'bg-[#F0F0F0]')

@section('content')
     @include('components.nav_admin')

    @php
        $rolePrefix = 'admin'; 
    @endphp

     

    <!-- main content -->
    <section class="w-full  z-0">
        <div class="pt-35 max-sm:pt-30 pl-85 max-[1270px]:pl-75 max-lg:pl-7  pr-10 max-sm:pr-5 pb-15">
            {{-- chat box container --}}
            <div class="flex shadow-lg  rounded-lg overflow-hidden max-sm:flex-col">
                {{-- horizontal chat menu --}}
                <div class=" shadow-md bg-white w-sm border-r border-gray-300 max-sm:w-full max-sm:border-r-0 max-sm:border-b flex flex-col">
                    {{-- title --}}
                    <h1 class="text-3xl font-bold! p_font p-4 bg-[#1e2939] text-white ">Chats</h1>
                   {{-- search bar --}}
                    <div class="">
                        <svg id="search_icon" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" 
                            stroke-width="1.5" stroke="currentColor" 
                            class="size-6 absolute text-gray-400 mt-2 ml-2 hidden!">
                            <path stroke-linecap="round" stroke-linejoin="round" 
                                d="m21 21-5.197-5.197m0 0A7.5 7.5 0 1 0 5.196 5.196a7.5 7.5 0 0 0 10.607 10.607Z" />
                        </svg>
                        <input id="chat_search" type="text" placeholder="🔍Search..." class="w-full p-3 px-4 border-b border-gray-300 focus:outline-none">
                    </div>




                    {{-- chat menu --}}
                    <div id="chat_menu" class="flex flex-col gap-2 overflow-x-auto p-2 w-full max-sm:max-h-50 overflow-auto max-sm:hidden">
                       @forelse ($chatUsers as $chatUser)
                        @php
                            $latestMessage = \App\Models\Message::where(function ($query) use ($admin, $chatUser) {
                                    $query->where('sender_id', $admin->id)
                                        ->where('receiver_id', $chatUser->id);
                                })
                                ->orWhere(function ($query) use ($admin, $chatUser) {
                                    $query->where('sender_id', $chatUser->id)
                                        ->where('receiver_id', $admin->id);
                                })
                                ->latest()
                                ->first();
                        @endphp

                        <a href="{{ route('admin.chat', ['name' => $chatUser->name]) }}" 
                            class="p-2 rounded-lg hover:bg-gray-200 cursor-pointer flex items-center w-full 
                            {{ request()->is('admin/chat/' . $chatUser->name) ? 'bg-gray-200' : 'bg-white hover:bg-gray-200' }}">
                            <img src="{{ $chatUser->profile_pic 
                                ? asset('storage/' . $chatUser->profile_pic) 
                                : asset('assets/defaultUserPic.png') }}" 
                                alt="{{ $chatUser->name }}" 
                                class="w-10 h-10 rounded-full inline-block mr-2 border-2 border-gray-400">
                            <div>
                                <h2 class="font-bold text-gray-800 p_font">{{ $chatUser->name }}</h2>
                                <p class="text-gray-600 text-sm truncate w-[150px] p_font">
                                    @if($latestMessage)
                                        {{ $latestMessage->sender_id == $admin->id ? 'You: ' : '' }}
                                        {{ $latestMessage->content }}
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

                        <a href="" class="text-2xl font-bold! p_font  text-blue-500 hover:underline cursor-pointer max-sm:text-lg">{{ $receiver->name }}</a>
                        {{-- User status indicator --}}
                        @php
                            $status = trim(strtolower($receiver->status)); // make sure it's normalized
                        @endphp

                        <span class=" group p-1.5 rounded-full ml-2 {{ $status === 'online' ? 'bg-green-400' : 'bg-gray-400' }}">
                            <span class="absolute bottom-full mt-2 hidden group-hover:block 
                                        px-2 py-1 text-xs text-white bg-[#1e2939] rounded 
                                        opacity-0 group-hover:opacity-100 transition-opacity duration-200 p_font">
                                {{ ucfirst($status) }} {{-- Will show Online or Offline --}}
                            </span>
                        </span>

                         <!-- Ellipse for block and report dropdown -->
                        <div class="ml-auto" id="chat_options_wrapper">
                            {{-- video call --}}
                            <button id="video_call" class="p-1 rounded-lg cursor-pointer hover:bg-gray-300 ml-auto">
                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-6">
                                <path stroke-linecap="round" stroke-linejoin="round" d="m15.75 10.5 4.72-4.72a.75.75 0 0 1 1.28.53v11.38a.75.75 0 0 1-1.28.53l-4.72-4.72M4.5 18.75h9a2.25 2.25 0 0 0 2.25-2.25v-9a2.25 2.25 0 0 0-2.25-2.25h-9A2.25 2.25 0 0 0 2.25 7.5v9a2.25 2.25 0 0 0 2.25 2.25Z" />
                                </svg>
                            </button>
                            <!-- Ellipsis button -->
                            <button
                                id="chat_options_btn"
                                type="button"
                                class="p-1 bg-gray-200 rounded-lg cursor-pointer hover:bg-gray-300 ml-auto">
                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                    stroke-width="1.5" stroke="currentColor" class="size-6">
                                    <path stroke-linecap="round" stroke-linejoin="round"
                                        d="M6.75 12a.75.75 0 1 1-1.5 0 .75.75 0 0 1 1.5 0ZM12.75 12a.75.75 0 1 1-1.5 0 .75.75 0 0 1 1.5 0ZM18.75 12a.75.75 0 1 1-1.5 0 .75.75 0 0 1 1.5 0Z" />
                                </svg>
                            </button>
                            

                            <!-- Dropdown -->
                            <div
                                id="chat_options_menu"
                                class="absolute right-15 max-sm:right-10 mt-2  bg-white border border-gray-300 rounded-lg shadow-lg z-50 hidden">
                                <button id="open_delete_modal"
                                    type="button"
                                    class="w-full text-left px-4 py-2 text-sm hover:bg-gray-100 text-red-500 p_font cursor-pointer">
                                    Delete
                                </button>

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


                            {{-- Determine bubble alignment --}}
                            @php
                                $isSender = $message->sender_id === Auth::id();
                                $bubbleClass = $isSender
                                    ? 'bg-blue-300 ml-auto'
                                    : 'bg-gray-300';
                            @endphp


                            {{-- ===========================
                                MESSAGE BUBBLE
                            ============================ --}}
                            <div class="p-2 rounded-lg w-fit max-w-120 max-lg:max-w-90 max-sm:max-w-70 max-sm:text-sm break-words {{ $bubbleClass }}">

                                {{-- 📝 TEXT MESSAGE --}}
                                @if ($message->content)
                                    <p>{!! makeLinksClickable($message->content) !!}</p>
                                @endif

                                {{-- 🖼 IMAGE PREVIEW --}}
                                @if ($message->file_type === 'image')
                                    <div class="mt-2">
                                        <img src="{{ asset('storage/' . $message->file) }}"
                                            class="max-w-60 max-h-60 rounded-lg border cursor-pointer hover:opacity-90"
                                            onclick="window.open('{{ asset('storage/' . $message->file) }}', '_blank')" />
                                    </div>
                                @endif

                                {{-- 📄 FILE PREVIEW / DOWNLOAD --}}
                                @if ($message->file_type === 'file')
                                    <a href="{{ asset('storage/' . $message->file) }}"
                                    download
                                    class="flex items-center gap-2 p-2 mt-2 bg-white rounded-md shadow-sm hover:bg-gray-100 border">

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
                                <span class="text-gray-500 text-xs block text-right mt-1">
                                    {{ $message->created_at->format('g:i a') }}
                                </span>

                            </div>

                        @endforeach
                    </div>


                    

                    {{-- chat input --}}
                    <form id="chatForm" 
                        action="{{ route('admin.send_message', ['name' => $receiver->name]) }}" 
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

                        <input 
                            id="messageInput" 
                            type="text" 
                            name="content" 
                            placeholder="Type your message..." 
                            class="w-full p-2 border border-gray-300 rounded-lg focus:outline-none" required>
                        <button 
                            class="bg-blue-500 text-white px-4 py-2 rounded-lg hover:bg-blue-600 p_font cursor-pointer">
                            Send
                        </button>
                    </form>


                </div>

            </div>
                

        </div>
    </section>

     <!-- Delete Confirmation Modal -->
    <div id="delete_chat_modal" class="hidden modal_bg min-h-screen fixed top-0 z-40 w-full flex items-center justify-center px-5"> 
        <div class="px-5 py-3 bg-white rounded-xl -mt-20">
            <h2 class="text-xl sub_title_font font-semibold mb-2">Delete this whole chat?</h2>
            <p class="home_p_font text-gray-600 mb-5">
                This action cannot be undone. <br>Are you sure you want to delete this?
            </p>
            <div class="flex gap-2">
                <button id="cancel_delete" class="bg-[#1e2939] cursor-pointer sub_title_font text-blue-400 px-4 py-2 rounded-lg hover:bg-[#374151] max-sm:text-sm ml-auto">Cancel</button>

                <form id="delete_chat_form" action="{{ route('admin.deleteUserChat', $receiver->name) }}" method="POST">
                    @csrf
                    @method('DELETE')
                    <button
                        type="submit"
                        class="bg-[#1e2939] cursor-pointer sub_title_font text-red-400 px-4 py-2 rounded-lg hover:bg-[#374151] max-sm:text-sm">
                        Delete
                    </button>
                </form>
            </div>
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', () => {
            const searchInput = document.getElementById('chat_search');
            const chatMenu = document.getElementById('chat_menu');
            const chatLinks = chatMenu.querySelectorAll('a');
            const noChatsText = chatMenu.querySelector('p.text-gray-400');

            // Listen to focus — show menu on mobile
            searchInput.addEventListener('focus', () => {
                if (window.innerWidth <= 640) {
                    chatMenu.classList.remove('max-sm:hidden');
                }
            });

            // Hide if search box loses focus AND is empty
            searchInput.addEventListener('blur', () => {
                setTimeout(() => {
                    if (window.innerWidth <= 640 && searchInput.value.trim() === '') {
                        chatMenu.classList.add('max-sm:hidden');
                    }
                }, 150);
            });

            // Filter users while typing
            searchInput.addEventListener('input', () => {
                const searchTerm = searchInput.value.toLowerCase().trim();
                let hasMatch = false;

                chatLinks.forEach(link => {
                    const name = link.querySelector('h2').textContent.toLowerCase();
                    if (name.includes(searchTerm)) {
                        link.classList.remove('hidden');
                        hasMatch = true;
                    } else {
                        link.classList.add('hidden');
                    }
                });

                // Show/hide "No chats yet" if needed
                if (noChatsText) {
                    noChatsText.style.display = hasMatch ? 'none' : '';
                }

                // Always show menu while typing on mobile
                if (window.innerWidth <= 640) {
                    chatMenu.classList.remove('max-sm:hidden');
                }
            });
        });
    </script>


    <script>
    const openDeleteModalBtn = document.getElementById('open_delete_modal');
    const deleteChatModal = document.getElementById('delete_chat_modal');
    const cancelDeleteBtn = document.getElementById('cancel_delete');

    // Show delete confirmation
    openDeleteModalBtn.addEventListener('click', () => {
        deleteChatModal.classList.remove('hidden');
    });

    // Hide modal when cancel is clicked or outside area
    cancelDeleteBtn.addEventListener('click', () => {
        deleteChatModal.classList.add('hidden');
    });

    deleteChatModal.addEventListener('click', (e) => {
        if (e.target === deleteChatModal) {
            deleteChatModal.classList.add('hidden');
        }
    });

    </script>

     {{-- reload when new message sent --}}
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

        
    

    <script src="{{ asset('js/client/chat.js') }}"></script>
    <script src="{{ asset('js/admin/nav_admin.js') }}"></script>
@endsection