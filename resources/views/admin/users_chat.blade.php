@extends('layouts.app')

@section('body-class', 'bg-[#F0F0F0]')

@section('content')
     @include('components.nav_admin')

    <!-- main content -->
    <section class="w-full  z-0">
        <div class="pt-35 pl-85 max-[1270px]:pl-75 max-lg:pl-7  pr-10 max-sm:pr-5 pb-15">
                {{-- parent div of chat box --}}
                <div class="rounded-lg flex flex-col items-center shadow-md w-4xl max-xl:w-full m-auto">
                    {{-- chat box --}}
                    <div class=" bg-white w-full">
                        {{-- chat header --}}
                        <div class="px-4 py-3.5 border-gray-300 border-b flex items-center">
                            <img src="{{ $user->profile_pic ? asset('storage/' . $user->profile_pic) : asset('assets/defaultUserPic.png') }}" alt="" class="w-10 h-10 rounded-full inline-block mr-2 border-2 border-gray-400">

                            <a href="{{ route('admin.public_profile', ['name' => urlencode($user->name)]) }}" class="text-2xl font-bold! p_font  text-blue-500 hover:underline cursor-pointer max-sm:text-lg">{{ $user->name }}</a>
                            <!-- Ellipse for block and report dropdown -->
                            <div class="ml-auto" id="chat_options_wrapper">
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
                                    class="absolute right-0 mt-2 w-32 max-sm:w-25 bg-white border border-gray-300 rounded-lg shadow-lg z-50 hidden">
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

                                {{-- 🕒 TIME --}}
                                <span class="text-gray-500 text-xs block text-right mt-1">
                                    {{ $message->created_at->format('g:i a') }}
                                </span>

                            </div>

                        @endforeach

                    </div>


                    </div>

                   
                    {{-- chat footer --}}
                        <div class="bottom-0 left-0 w-full bg-gray-200 border-t border-gray-300 p-3 max-sm:p-2 flex flex-col items-center">
                            <h1 class="font-semibold! home_p_font max-sm:text-sm">View Only</h1>
                            <p class="home_p_font text-sm max-sm:text-xs">You can only view the users chat here</p>
                        </div> 

                </div>

        </div>
    </section>
    

    {{-- delete modal warning --}}
    <div id="delete_chat" class="hidden modal_bg min-h-screen fixed top-0 z-40 w-full flex items-center justify-center px-5">
        <div class="px-5 py-3 bg-white rounded-xl -mt-20">
            <h2 class="text-xl sub_title_font font-semibold mb-2">Delete this whole chat?</h2>
            <p class="home_p_font text-gray-600 mb-5">
                This action cannot be undone. <br>Are you sure you want to delete this?
            </p>

            <div class="flex gap-2">
                <button id="cancel_delete_applicant" type="button"
                    class="bg-[#1e2939] cursor-pointer sub_title_font text-blue-400 px-4 py-2 rounded-lg hover:bg-[#374151] max-sm:text-sm">
                    Cancel
                </button>

                <form action="{{ route('admin.delete_conversation', ['name' => $user->name]) }}" method="POST" id="delete_chat_form">
                    @csrf
                    @method('DELETE')
                    <button type="submit"
                        id="delete_applicant"
                        class="bg-[#1e2939] cursor-pointer sub_title_font text-red-400 px-4 py-2 rounded-lg hover:bg-[#374151] max-sm:text-sm">
                        Delete
                    </button>
                </form>
            </div>
        </div>
    </div>




    <script src="{{ asset('js/admin/chat.js') }}"></script>
    <script src="{{ asset('js/admin/nav_admin.js') }}"></script>
@endsection