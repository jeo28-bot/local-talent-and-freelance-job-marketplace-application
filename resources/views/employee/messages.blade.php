@extends('layouts.app')

@section('body-class', 'bg-[#F0F0F0] ')

@section('content')
    @include('components.nav_employee')


     <section class="w-ful min-h-[80vh] px-10 py-10 max-sm:py-5 max-sm:px-4 ">
        <div class="xl:w-6xl mx-auto px-5 max-sm:px-3 mb-10">
            <h1 class="sub_title sm:text-xl">Messages</h1>
            <p class="home_p_font mb-5 text-sm">All your chats with clients and companies are organized here.</p>

             {{-- show chats --}}
            <div id="recentChatsContainer" class="gap-5 flex flex-col mb-10">
                @foreach ($chatUsers as $chat)
                    <a href="{{ route('employee.chat', ['name' => $chat['user']->name]) }}" 
                        class="p_font flex items-center gap-3 bg-white py-3 px-5 shadow-md rounded-lg cursor-pointer hover:bg-gray-100 relative">
                        
                        {{-- Optional: new message indicator --}}
                        {{-- <div class="p-1.5 rounded-full bg-red-500 absolute -ml-3"></div> --}}

                        <img src="{{ $chat['user']->profile_pic 
                            ? asset('storage/' . $chat['user']->profile_pic)
                            : asset('assets/defaultUserPic.png') }}" 
                            alt="{{ $chat['user']->name }}" 
                            class="h-12 w-12 rounded-full border-2 border-gray-400">

                        <div class="flex flex-col">
                            <h1 class="font-semibold text-blue-500">{{ $chat['user']->name }}</h1>
                            <p class="text-gray-500 text-sm truncate w-[200px]">{{ $chat['last_message'] }}</p>
                        </div>

                        <div class="ml-auto text-xs text-gray-400">
                            {{ $chat['time'] }}
                        </div>
                    </a>

                 
                    
                @endforeach
            </div>
          

            


        </div>
        
     </section>

    <script>
    document.addEventListener('DOMContentLoaded', () => {
        const messagesContainer = document.querySelector('#recentChatsContainer');

        async function fetchRecentChats() {
            try {
                const response = await fetch("{{ route('employee.messages.fetch') }}");
                const data = await response.json();

                messagesContainer.innerHTML = '';

                if (data.length === 0) {
                    messagesContainer.innerHTML = 
                    `<div class="flex flex-col items-center justify-center py-10 text-center bg-gray-200 rounded-xl">
                        <svg xmlns="http://www.w3.org/2000/svg" 
                            fill="none" viewBox="0 0 24 24" 
                            stroke-width="1.5" stroke="currentColor" 
                            class="w-16 h-16 text-gray-400 mb-4">
                            <path stroke-linecap="round" stroke-linejoin="round" 
                                d="M9 13h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 
                                    2 0 012-2h5.586a1 1 0 01.707.293l5.414 
                                    5.414a1 1 0 01.293.707V20a2 2 0 
                                    01-2 2z" />
                        </svg>
                    
                        <h2 class="text-xl font-semibold text-gray-800 sub_title_font">No chats yet</h2>
                        <p class="text-gray-500 mt-1 home_p_font">Start a chat by applying to a job or replying to an employer.</p>
                    </div>`;
                    return;
                }

                data.forEach(chat => {
                    const chatItem = `
                        <a href="/employee/chat/${chat.name}" 
                            class="p_font flex items-center gap-3 bg-white py-3 px-5 shadow-md rounded-lg cursor-pointer hover:bg-gray-100 relative">

                            <img src="${chat.profile_pic}" 
                                alt="${chat.name}" 
                                class="h-12 w-12 rounded-full border-2 border-gray-400">

                            <div class="flex flex-col">
                                <h1 class="font-semibold text-blue-500">${chat.name}</h1>
                                <p class="text-gray-500 text-sm truncate w-[200px]">${chat.latest_message ?? 'No messages yet'}</p>
                            </div>

                            <div class="ml-auto text-xs text-gray-400">${chat.time ?? ''}</div>
                        </a>
                    `;
                    messagesContainer.insertAdjacentHTML('beforeend', chatItem);
                });
            } catch (err) {
                console.error('Error fetching messages:', err);
            }
        }

        fetchRecentChats(); // initial load
        setInterval(fetchRecentChats, 3000); // auto-refresh every 3 seconds
    });
    </script>

    



           
@include('components.footer_employee')
    
    
@endsection