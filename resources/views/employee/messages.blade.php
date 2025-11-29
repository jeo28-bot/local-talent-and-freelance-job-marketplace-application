@extends('layouts.app')

@section('body-class', 'bg-[#F0F0F0] ')

@section('content')
    @include('components.nav_employee')


     <section class="w-ful min-h-[80vh] px-10 py-10 max-sm:py-5 max-sm:px-4 ">
        <div class="xl:w-6xl mx-auto px-5 max-sm:px-3 mb-10">
            <h1 class="sub_title sm:text-xl">Messages</h1>
            <p class="home_p_font mb-5 text-sm">All your chats with clients and companies are organized here.</p>

             {{-- show chats --}}
            <div id="recentChatsContainer" data-page="{{ $chatUsers->currentPage() }}" class="gap-5 flex flex-col mb-10">
                @foreach ($chatUsers as $chat)
                    <a href="{{ route('employee.chat', ['name' => $chat['user']->name]) }}" 
                        class="p_font flex items-center gap-3 bg-white py-3 px-5 max-sm:px-2 max-sm:py-2 shadow-md rounded-lg cursor-pointer hover:bg-gray-100 relative max-sm:gap-2">
                        
                        {{-- Optional: new message indicator --}}
                        {{-- <div class="p-1.5 rounded-full bg-red-500 absolute -ml-3"></div> --}}

                        <img src="{{ $chat['user']->profile_pic 
                            ? asset('storage/' . $chat['user']->profile_pic)
                            : asset('assets/defaultUserPic.png') }}" 
                            alt="{{ $chat['user']->name }}" 
                            class="h-12 w-12 rounded-full border-2 border-gray-400 max-sm:h-10 max-sm:w-10">


                        <div class="w-full flex items-center gap-3 max-sm:flex-col max-sm:items-start">
                            <div class="flex flex-col">
                                <h1 class="font-semibold text-blue-500">{{ $chat['user']->name }}</h1>
                                <p class="text-gray-500 text-sm truncate w-[200px]">{{ $chat['last_message'] }}</p>
                            </div>

                            <div class="ml-auto text-xs text-gray-400">
                                {{ $chat['time'] }}
                            </div>
                        </div>
                    </a> 
                @endforeach
            </div>
          
        {{-- Custom Pagination --}}
        <div id="posting_pagination" class="w-full mx-auto flex items-center max-sm:flex-col max-sm:items-center gap-2">
            <h3 class="home_p_font text-sm max-sm:text-xs">
                Showing {{ $chatUsers->firstItem() }} to {{ $chatUsers->lastItem() }} of {{ $chatUsers->total() }} results
            </h3>

            <div class="flex ml-auto gap-2 max-sm:ml-0">
                {{-- Previous button --}}
                @if($chatUsers->onFirstPage())
                    <button disabled class="cursor-not-allowed opacity-50 job_posting_button bg-[#1E2939] text-white px-5 py-2 rounded-lg text-sm max-sm:text-xs">Previous</button>
                @else
                    <a href="{{ $chatUsers->previousPageUrl() }}" class="job_posting_button bg-[#1E2939] text-white px-5 py-2 rounded-lg text-sm max-sm:text-xs">Previous</a>
                @endif

                {{-- Next button --}}
                @if($chatUsers->hasMorePages())
                    <a href="{{ $chatUsers->nextPageUrl() }}" class="job_posting_button bg-[#1E2939] text-white px-5 py-2 rounded-lg text-sm max-sm:text-xs">Next</a>
                @else
                    <button disabled class="cursor-not-allowed opacity-50 job_posting_button bg-[#1E2939] text-white px-5 py-2 rounded-lg text-sm max-sm:text-xs">Next</button>
                @endif
            </div>
        </div>
            


        </div>
        
     </section>

     {{-- modal section --}}

     {{-- script section --}}

    <script>
    document.addEventListener('DOMContentLoaded', () => {
        const messagesContainer = document.querySelector('#recentChatsContainer');
        let currentPage = parseInt(messagesContainer.dataset.page) || 1;
        const perPage = 5;

        async function fetchRecentChats(page = 1) {
            try {
                const response = await fetch(`{{ route('employee.messages.fetch') }}`); // use the non-paginated one
                const data = await response.json();

                if (!Array.isArray(data) || data.length === 0) {
                    messagesContainer.innerHTML = `
                        <div class="flex flex-col items-center justify-center py-10 text-center bg-gray-200 rounded-xl">
                            <h2 class="text-xl font-semibold text-gray-800 sub_title_font">No chats yet</h2>
                            <p class="text-gray-500 mt-1 home_p_font">Start a chat by applying to a job or replying to an employer.</p>
                        </div>
                    `;
                    return;
                }

                // Paginate on the frontend (like your old setup)
                const start = (page - 1) * perPage;
                const end = start + perPage;
                const paginatedChats = data.slice(start, end);

                // Clear and re-render
                messagesContainer.innerHTML = '';
                paginatedChats.forEach(chat => {
                    const chatItem = `
                        <a href="/employee/chat/${chat.name}" 
                            class="p_font flex items-center gap-3 bg-white py-3 px-5 max-sm:px-2 max-sm:py-2 shadow-md rounded-lg cursor-pointer hover:bg-gray-100 relative max-sm:gap-2">

                            ${chat.has_unseen 
                                ? '<div class="absolute left-1 top-1 h-3 w-3 rounded-full bg-red-500"></div>'
                                : ''}
                                 <img src="${chat.profile_pic}" alt="${chat.name}" class="h-12 w-12 rounded-full border-2 border-gray-400 max-sm:h-10 max-sm:w-10">
                            <div class="w-full flex items-center gap-3 max-sm:flex-col max-sm:items-start">
                                <div class="flex flex-col">
                                    <h1 class="font-semibold text-blue-500">${chat.name}</h1>
                                    <p class="text-gray-500 text-sm truncate w-[200px]">${chat.latest_message ?? 'No messages yet'}</p>
                                </div>
                                <div class="ml-auto text-xs text-gray-400">${chat.time ?? ''}</div>
                            </div>
                        </a>
                    `;
                    messagesContainer.insertAdjacentHTML('beforeend', chatItem);
                });

                // Update dataset
                messagesContainer.dataset.page = page;
            } catch (err) {
                console.error('Error fetching messages:', err);
            }
        }

        // 🔹 Fetch every 3 seconds (live refresh)
        setInterval(() => fetchRecentChats(currentPage), 3000);

        // 🔹 Initial fetch
        fetchRecentChats(currentPage);
    });
    </script>


    



           
@include('components.footer_employee')
    
    
@endsection