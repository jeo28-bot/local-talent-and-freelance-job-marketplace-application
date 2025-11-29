@extends('layouts.app')

@section('body-class', 'bg-[#F0F0F0]')

@section('content')
     @include('components.nav_admin')


    <!-- main content -->
    <section class="w-full  z-0">
        <div class="pt-35 max-lg:pt-30 max-sm:pt-25 pl-85 max-[1270px]:pl-75 max-lg:pl-7  pr-10 max-sm:pr-5 pb-15">
            {{-- parent div control --}}
            <div class=" w-full flex flex-col items-center">
                {{-- control div --}}
                <div class="xl:w-4xl w-full">
                    {{-- padding top --}}
                    {{-- title & sub title --}}
                    <h1 class="home_p_font font-semibold! max-lg:text-sm text-lg">Inbox</h1>
                    <p class="home_p_font mb-5 text-sm">Manage and review system applications.</p>

                    {{-- show chats --}}
                    <div id="recentChatsContainer" class="gap-5 flex flex-col mb-10 max-sm:mb-5">
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
                                    ->latest('created_at')
                                    ->first();
                            @endphp

                            <a href="{{ route('admin.chat', ['name' => $chatUser->name]) }}" 
                            class="p_font flex items-center gap-3 bg-white py-3 px-5 shadow-md rounded-lg cursor-pointer hover:bg-gray-100 max-sm:px-3">

                                <img src="{{ $chatUser->profile_pic 
                                    ? asset('storage/' . $chatUser->profile_pic) 
                                    : asset('assets/defaultUserPic.png') }}" 
                                    alt="{{ $chatUser->name }}" 
                                    class="h-12 w-12 rounded-full border-2 border-gray-400 max-sm:h-10 max-sm:w-10">

                                <div class="flex max-sm:flex-col w-full items-center max-sm:items-baseline">
                                    <div class="flex flex-col">
                                        <h1 class="font-semibold text-blue-500 max-sm:text-sm">{{ $chatUser->name }}</h1>
                                        <p class="text-gray-500 text-sm truncate w-[200px]">
                                            @if($latestMessage)
                                                {{ $latestMessage->sender_id == $admin->id ? 'You: ' : '' }}
                                                {{ $latestMessage->content }}
                                            @else
                                                No messages yet
                                            @endif
                                        </p>
                                    </div>

                                    @if($latestMessage)
                                        <div class="ml-auto text-xs text-gray-400 ">
                                            {{ $latestMessage->created_at->diffForHumans() }}
                                        </div>
                                    @endif
                                </div>
                            </a>
                        @empty
                            {{-- no messages yet --}}
                            <div class="w-full h-[300px] flex flex-col justify-center items-center border-2 border-dashed border-gray-400 rounded-lg mt-10">
                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-15 mb-2 text-gray-400">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M18 18.72a9.094 9.094 0 0 0 3.741-.479 3 3 0 0 0-4.682-2.72m.94 3.198.001.031c0 .225-.012.447-.037.666A11.944 11.944 0 0 1 12 21c-2.17 0-4.207-.576-5.963-1.584A6.062 6.062 0 0 1 6 18.719m12 0a5.971 5.971 0 0 0-.941-3.197m0 0A5.995 5.995 0 0 0 12 12.75a5.995 5.995 0 0 0-5.058 2.772m0 0a3 3 0 0 0-4.681 2.72 8.986 8.986 0 0 0 3.74.477m.94-3.197a5.971 5.971 0 0 0-.94 3.197M15 6.75a3 3 0 1 1-6 0 3 3 0 0 1 6 0Zm6 3a2.25 2.25 0 1 1-4.5 0 2.25 2.25 0 0 1 4.5 0Zm-13.5 0a2.25 2.25 0 1 1-4.5 0 2.25 2.25 0 0 1 4.5 0Z" />
                                </svg>
                                <p class="p_font text-gray-500 text-center p-5">No messages yet. Check back later!</p>
                            </div>
                        @endforelse
                    </div>

                     {{-- Custom Pagination --}}
                    <div id="posting_pagination" class="w-full mx-auto flex items-center max-sm:flex-col max-sm:items-center gap-2">
                        <h3 class="home_p_font text-sm max-sm:text-xs">
                            Showing {{ $chatUsers->firstItem() ?? 0 }} to {{ $chatUsers->lastItem() ?? 0 }} of {{ $chatUsers->total() }} results
                        </h3>

                        <div class="flex ml-auto gap-2 max-sm:ml-0">
                            {{-- Previous button --}}
                            @if ($chatUsers->onFirstPage())
                                <button disabled class="cursor-not-allowed opacity-50 -z-1 job_posting_button bg-[#1E2939] text-white px-5 py-2 rounded-lg text-sm max-sm:text-xs">Previous</button>
                            @else
                                <a href="{{ $chatUsers->previousPageUrl() }}" class="job_posting_button bg-[#1E2939] text-white px-5 py-2 rounded-lg hover:opacity-90 text-sm max-sm:text-xs">Previous</a>
                            @endif

                            {{-- Next button --}}
                            @if ($chatUsers->hasMorePages())
                                <a href="{{ $chatUsers->nextPageUrl() }}" class="job_posting_button bg-[#1E2939] text-white px-5 py-2 rounded-lg hover:opacity-90 text-sm max-sm:text-xs">Next</a>
                            @else
                                <button disabled class="cursor-not-allowed -z-1 opacity-50 job_posting_button bg-[#1E2939] text-white px-5 py-2 rounded-lg text-sm max-sm:text-xs">Next</button>
                            @endif
                        </div>
                    </div>
                    {{-- ene of pagination --}}


                </div>
                {{-- end control div --}}

                

            </div>
            {{-- end parent div control --}}


           


        </div>
    </section>


    <script>
    document.addEventListener('DOMContentLoaded', () => {
        const messagesContainer = document.querySelector('#recentChatsContainer');
        const currentPage = {{ request()->get('page', 1) }}; // get current page from Laravel pagination

        async function fetchRecentChats() {
            try {
                const response = await fetch(`{{ route('admin.messages.fetch') }}`);
                const data = await response.json();

                if (!Array.isArray(data) || data.length === 0) {
                    messagesContainer.innerHTML = `
                        <div class="flex flex-col items-center justify-center py-10 text-center bg-gray-200 rounded-xl">
                            <h2 class="text-xl font-semibold text-gray-800 sub_title_font">No chats yet</h2>
                            <p class="text-gray-500 mt-1 home_p_font">No conversations yet.</p>
                        </div>
                    `;
                    return;
                }

                // Laravel pagination (server handled) — just show this page
                const start = (currentPage - 1) * 7; // perPage = 3 (matches controller)
                const end = start + 7;
                const paginated = data.slice(start, end);

                messagesContainer.innerHTML = '';
                paginated.forEach(chat => {
                    const chatHTML = `
                        <a href="/admin/chat/${chat.name}"
                            class="chat-item p_font flex items-center gap-3 bg-white py-3 px-5 shadow-md rounded-lg cursor-pointer hover:bg-gray-100 max-sm:px-3 ">

                            ${chat.has_unseen 
                                ? '<div class="h-3 w-3 max-sm:h-2 max-sm:w-2 rounded-full bg-red-500"></div>' 
                                : ''}

                            <img src="${chat.profile_pic}" 
                                alt="${chat.name}" 
                                class="h-12 w-12 rounded-full border-2 border-gray-400 max-sm:h-10 max-sm:w-10">

                            <div class="flex max-sm:flex-col w-full items-center max-sm:items-baseline">
                                <div class="flex flex-col">
                                    <h1 class="font-semibold text-blue-500 max-sm:text-sm">${chat.name}</h1>
                                    <p class="text-gray-500 text-sm truncate w-[200px]">${chat.sender_label}${chat.latest_message}</p>

                                </div>
                                <div class="ml-auto text-xs text-gray-400">${chat.time}</div>
                            </div

                        </a>
                    `;
                    messagesContainer.insertAdjacentHTML('beforeend', chatHTML);
                });
            } catch (err) {
                console.error('Error fetching messages:', err);
            }
        }

        

        // Refresh every 3 seconds
        setInterval(fetchRecentChats, 3000);

        // 🔹 Initial fetch
        fetchRecentChats(currentPage);
    });
    </script>



    <script src="{{ asset('js/admin/nav_admin.js') }}"></script>
@endsection