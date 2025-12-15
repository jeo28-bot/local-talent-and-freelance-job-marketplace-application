@extends('layouts.app')

@section('body-class', 'bg-[#F0F0F0] ')

@section('content')
    @include('components.nav_client')


     <section class="w-ful min-h-[80vh] px-10 py-10 max-sm:py-5 max-sm:px-4">
        {{-- when blocked show this --}}
        @if($isBlockedByUser)
            <div class="lg:w-2xl mx-auto px-5 max-sm:px-3 mb-10">
                <div class="flex flex-col items-center bg-white p-10 rounded-lg shadow-sm">
                    <img 
                        src="{{ $user->profile_pic ? asset('storage/' . $user->profile_pic) : asset('assets/defaultUserPic.png') }}" 
                        alt="blocked user" 
                        class="w-40 h-40 max-sm:w-30 max-sm:h-30 rounded-full border-3 bg-[#1e2939] border-gray-400 my-3 shadow-sm cursor-pointer">
                    
                    <h1 class="sub_title sm:text-4xl text-lg text-center mt-5 mb-3">
                        User <span class="text-blue-500">{{ $user->name }}</span> is not available.
                    </h1>
                    <p class="home_p_font text-center text-gray-600 max-sm:text-sm">
                        You cannot view the profile details or interact with this user. Try again later.
                    </p>
                </div>
            </div>
        @else

        {{-- content --}}
        <div class="lg:w-2xl mx-auto px-5 max-sm:px-3 mb-10">
            <div class="flex items-center justify-between">
                <div class="flex items-center">
                    <a class="sub_title sm:text-4xl text-lg hover:underline cursor-pointer">{{ $user->name  }}</a>
                    {{-- User status indicator --}}
                        @php
                            $status = trim(strtolower($user->status)); // make sure it's normalized
                        @endphp

                        <span class="relative group p-1.5 rounded-full ml-2 {{ $status === 'online' ? 'bg-green-400' : 'bg-gray-400' }}">
                            <span class="absolute bottom-full mt-2 hidden group-hover:block 
                                        px-2 py-1 text-xs text-white bg-[#1e2939] rounded 
                                        opacity-0 group-hover:opacity-100 transition-opacity duration-200 p_font">
                                {{ ucfirst($status) }} {{-- Will show Online or Offline --}}
                            </span>
                        </span>
                </div>

            <img 
                src="{{ $user->profile_pic ? asset('storage/' . $user->profile_pic) : asset('assets/defaultUserPic.png') }}" 
                alt="profile pic" 
                class="profile_pic_clicked w-30 h-30 max-sm:w-20 max-sm:h-20 rounded-full border-3 bg-[#1e2939] border-gray-400 my-3 shadow-sm cursor-pointer">
                    
            </div>

            {{-- mail, phone, address section --}}
            <p class="home_p_font mb-1 text-sm flex items-center gap-2">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-6">
                <path stroke-linecap="round" stroke-linejoin="round" d="M21.75 6.75v10.5a2.25 2.25 0 0 1-2.25 2.25h-15a2.25 2.25 0 0 1-2.25-2.25V6.75m19.5 0A2.25 2.25 0 0 0 19.5 4.5h-15a2.25 2.25 0 0 0-2.25 2.25m19.5 0v.243a2.25 2.25 0 0 1-1.07 1.916l-7.5 4.615a2.25 2.25 0 0 1-2.36 0L3.32 8.91a2.25 2.25 0 0 1-1.07-1.916V6.75" />
                </svg>
            {{ $user->email }}</p>
            <p class="home_p_font mb-1 text-sm flex items-center gap-2">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-6">
                <path stroke-linecap="round" stroke-linejoin="round" d="M2.25 6.75c0 8.284 6.716 15 15 15h2.25a2.25 2.25 0 0 0 2.25-2.25v-1.372c0-.516-.351-.966-.852-1.091l-4.423-1.106c-.44-.11-.902.055-1.173.417l-.97 1.293c-.282.376-.769.542-1.21.38a12.035 12.035 0 0 1-7.143-7.143c-.162-.441.004-.928.38-1.21l1.293-.97c.363-.271.527-.734.417-1.173L6.963 3.102a1.125 1.125 0 0 0-1.091-.852H4.5A2.25 2.25 0 0 0 2.25 4.5v2.25Z" />
                </svg>
           {{ $user->phoneNum }}</p>
            <p class="home_p_font mb-5 text-sm flex items-center gap-2">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-6">
                <path stroke-linecap="round" stroke-linejoin="round" d="M15 10.5a3 3 0 1 1-6 0 3 3 0 0 1 6 0Z" />
                <path stroke-linecap="round" stroke-linejoin="round" d="M19.5 10.5c0 7.142-7.5 11.25-7.5 11.25S4.5 17.642 4.5 10.5a7.5 7.5 0 1 1 15 0Z" />
                </svg>
            {{ $user->address }}</p>
            
     
            @if($blockedByViewer)
                <p class="p-2 rounded-lg text-center p_font mb-4 bg-red-200 text-red-600 border border-red-400 flex items-center justify-center gap-1 max-sm:text-sm"> 
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-5">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M18.364 18.364A9 9 0 0 0 5.636 5.636m12.728 12.728A9 9 0 0 1 5.636 5.636m12.728 12.728L5.636 5.636" />
                    </svg>
                    Blocked
                </p>
            @endif

            
            {{-- follow, block, send message --}}
            <div class="p_font flex gap-2 items-center mb-4">
                <button class="hidden px-2 py-2 bg-gray-300 rounded-lg cursor-pointer hover:bg-gray-400
                        @if(Auth::check() && Auth::user()->name === $user->name)
                            opacity-50 cursor-not-allowed pointer-events-none
                        @endif"
                        @if(Auth::check() && Auth::user()->name === $user->name)
                            disabled
                            title="You can't block or report yourself 😅"
                        @endif            
                >
                + Follow
                </button>
                @if(Auth::check() && Auth::user()->name !== $user->name)
                    <a href="{{ route('client.chat', ['name' => $user->name]) }}"
                    class="px-2 py-2 bg-blue-300 rounded-lg cursor-pointer hover:bg-blue-400 flex items-center gap-2">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                            stroke-width="1.5" stroke="currentColor" class="size-6">
                            <path stroke-linecap="round" stroke-linejoin="round"
                                d="M7.5 8.25h9m-9 3H12m-9.75 1.51c0 1.6 1.123 2.994 2.707 3.227 
                                1.129.166 2.27.293 3.423.379.35.026.67.21.865.501L12 21l2.755-4.133
                                a1.14 1.14 0 0 1 .865-.501 48.172 48.172 0 0 0 3.423-.379
                                c1.584-.233 2.707-1.626 2.707-3.228V6.741
                                c0-1.602-1.123-2.995-2.707-3.228A48.394 48.394 0 0 0 12 3
                                c-2.392 0-4.744.175-7.043.513C3.373 3.746 2.25 5.14 2.25 6.741v6.018Z"/>
                        </svg>
                        Message
                    </a>
                @else
                    <button disabled
                        class="px-2 py-2 bg-gray-300 text-gray-600 rounded-lg cursor-not-allowed flex items-center gap-2">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                            stroke-width="1.5" stroke="currentColor" class="size-6">
                            <path stroke-linecap="round" stroke-linejoin="round"
                                d="M7.5 8.25h9m-9 3H12m-9.75 1.51c0 1.6 1.123 2.994 2.707 3.227 
                                1.129.166 2.27.293 3.423.379.35.026.67.21.865.501L12 21l2.755-4.133
                                a1.14 1.14 0 0 1 .865-.501 48.172 48.172 0 0 0 3.423-.379
                                c1.584-.233 2.707-1.626 2.707-3.228V6.741
                                c0-1.602-1.123-2.995-2.707-3.228A48.394 48.394 0 0 0 12 3
                                c-2.392 0-4.744.175-7.043.513C3.373 3.746 2.25 5.14 2.25 6.741v6.018Z"/>
                        </svg>
                        Message
                    </button>
                @endif
                <button
                        id="block_report_show"
                        class="p-1 bg-gray-300 rounded-lg cursor-pointer hover:bg-gray-400 ml-auto
                        @if(Auth::check() && Auth::user()->name === $user->name)
                            opacity-50 cursor-not-allowed pointer-events-none
                        @endif"
                        @if(Auth::check() && Auth::user()->name === $user->name)
                            disabled
                            title="You can't block or report yourself 😅"
                        @endif
                    >
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                        stroke-width="1.5" stroke="currentColor" class="size-6">
                        <path stroke-linecap="round" stroke-linejoin="round"
                            d="M6.75 12a.75.75 0 1 1-1.5 0 .75.75 0 0 1 1.5 0ZM12.75 12a.75.75 0 1 1-1.5 0 .75.75 0 0 1 1.5 0ZM18.75 12a.75.75 0 1 1-1.5 0 .75.75 0 0 1 1.5 0Z" />
                    </svg>
                </button>

            </div>
                {{-- block and report dropdown --}}
                <div class="flex flex-col p-2 gap-2 p_font absolute -mt-3 ml-130 max-lg:right-15 max-sm:right-7 bg-white border border-gray-300 rounded-lg shadow-lg max-sm:text-sm hidden" id="block_report_dropdown">
                    @if(!$blockedByViewer)
                        <button 
                            id="block_user_btn"
                            class="p-2 bg-gray-300 rounded-lg cursor-pointer hover:bg-gray-400 flex items-center gap-1 text-red-500!"
                            data-user-id="{{ $user->id }}">
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-5 max-sm:size-4">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M18.364 18.364A9 9 0 0 0 5.636 5.636m12.728 12.728A9 9 0 0 1 5.636 5.636m12.728 12.728L5.636 5.636" />
                            </svg>
                            Block
                        </button>
                    @else
                         <button 
                            id="unblock_user_btn"
                            class="p-2 bg-gray-300 rounded-lg cursor-pointer hover:bg-gray-400 flex items-center gap-1 text-red-500!"
                            data-user-id="{{ $user->id }}">
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-5 max-sm:size-4">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M18.364 18.364A9 9 0 0 0 5.636 5.636m12.728 12.728A9 9 0 0 1 5.636 5.636m12.728 12.728L5.636 5.636" />
                            </svg>
                            Unblock
                        </button>
                    @endif

                    <button id="report_user_btn" class="p-2 bg-gray-300 rounded-lg cursor-pointer hover:bg-gray-400 flex items-center gap-1">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-6 max-sm:size-4">
                            <path stroke-linecap="round" stroke-linejoin="round" d="m11.25 11.25.041-.02a.75.75 0 0 1 1.063.852l-.708 2.836a.75.75 0 0 0 1.063.853l.041-.021M21 12a9 9 0 1 1-18 0 9 9 0 0 1 18 0Zm-9-3.75h.008v.008H12V8.25Z" />
                        </svg>
                        Report
                    </button>
                </div>

                {{-- ratings section --}}
                @php
                    $ratings = $user->receivedRatings;
                    $averageRating = $ratings->avg('rating'); // average rating
                    $totalRatings = $ratings->count();       // total number of ratings
                    $fullStars = floor($averageRating);      // full stars to show
                    $halfStar = $averageRating - $fullStars >= 0.5; // whether to show a half star
                @endphp

                <div class="gap-2 mb-5">
                    {{-- stars and ratings --}}
                    <div class="flex text-blue-400 items-center">
                        @for ($i = 1; $i <= 5; $i++)
                            @if ($i <= $fullStars)
                                {{-- solid star --}}
                                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="size-6 max-sm:size-5">
                                    <path fill-rule="evenodd" d="M10.788 3.21c.448-1.077 1.976-1.077 2.424 0l2.082 5.006 5.404.434c1.164.093 1.636 1.545.749 2.305l-4.117 3.527 1.257 5.273c.271 1.136-.964 2.033-1.96 1.425L12 18.354 7.373 21.18c-.996.608-2.231-.29-1.96-1.425l1.257-5.273-4.117-3.527c-.887-.76-.415-2.212.749-2.305l5.404-.434 2.082-5.005Z" clip-rule="evenodd"></path>
                                </svg>
                            @elseif ($i == $fullStars + 1 && $halfStar)
                                {{-- half star (optional: you can style as needed or just show full) --}}
                                <svg xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 24 24" class="size-6 max-sm:size-5">
                                    <path d="M12 3l3 6 6 .5-4.5 4 1.5 6L12 17.5 6 20 7.5 14.5 3 10.5l6-.5 3-6z"/>
                                </svg>
                            @else
                                {{-- outline star --}}
                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-6 max-sm:size-5">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M11.48 3.499a.562.562 0 0 1 1.04 0l2.125 5.111a.563.563 0 0 0 .475.345l5.518.442c.499.04.701.663.321.988l-4.204 3.602a.563.563 0 0 0-.182.557l1.285 5.385a.562.562 0 0 1-.84.61l-4.725-2.885a.562.562 0 0 0-.586 0L6.982 20.54a.562.562 0 0 1-.84-.61l1.285-5.386a.562.562 0 0 0-.182-.557l-4.204-3.602a.562.562 0 0 1 .321-.988l5.518-.442a.563.563 0 0 0 .475-.345L11.48 3.5Z"/>
                                </svg>
                            @endif
                        @endfor

                        {{-- ratings count --}}
                        <span class="p_font text-gray-600 ml-2 text-sm">({{ number_format($averageRating, 1) }}/5.0)</span>
                    </div>
                     {{-- total ratings --}}
                    <a href="{{ route('client.ratings', ['username' => $user->name]) }}"
                    class="home_p_font text-sm mt-2 cursor-pointer hover:text-black! hover:underline">
                        {{ $totalRatings }} total rating{{ $totalRatings != 1 ? 's' : '' }}
                    </a><br>

                    {{-- write and edit a review button --}}
                    @php
                        $existingReview = $user->receivedRatings
                            ->where('reviewer_id', auth()->id())
                            ->first();
                    @endphp

                    @if($existingReview)
                        {{-- edit a review button --}}
                        <button id="edit_review_button" class="p-2 rounded-lg p_font bg-blue-400 text-white hover:bg-blue-500 mt-2 max-sm:text-sm 
                            @if(Auth::check() && Auth::user()->name === $user->name)
                                opacity-50 cursor-not-allowed pointer-events-none
                            @endif">
                            Edit my review
                        </button>
                    @else
                        {{-- write a review button --}}
                        <button id="write_review_button" class="p-2 rounded-lg p_font bg-blue-400 text-white hover:bg-blue-500 mt-2 max-sm:text-sm 
                            @if(Auth::check() && Auth::user()->name === $user->name)
                                opacity-50 cursor-not-allowed pointer-events-none
                            @endif">
                            Write a review
                        </button>
                    @endif
                </div>

            {{-- about section --}}
            <div class="flex items-center justify-between mb-2">
                <h1 class="sub_title sm:text-2xl flex items-center gap-2">
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="size-6">
                    <path fill-rule="evenodd" d="M2.25 12c0-5.385 4.365-9.75 9.75-9.75s9.75 4.365 9.75 9.75-4.365 9.75-9.75 9.75S2.25 17.385 2.25 12Zm8.706-1.442c1.146-.573 2.437.463 2.126 1.706l-.709 2.836.042-.02a.75.75 0 0 1 .67 1.34l-.04.022c-1.147.573-2.438-.463-2.127-1.706l.71-2.836-.042.02a.75.75 0 1 1-.671-1.34l.041-.022ZM12 9a.75.75 0 1 0 0-1.5.75.75 0 0 0 0 1.5Z" clip-rule="evenodd" />
                    </svg>

                About</h1>

                <button id="edit_about_button" href="#" class="hover:opacity-60 cursor-pointer hidden">
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="size-6 max-sm:size-4">
                    <path d="M21.731 2.269a2.625 2.625 0 0 0-3.712 0l-1.157 1.157 3.712 3.712 1.157-1.157a2.625 2.625 0 0 0 0-3.712ZM19.513 8.199l-3.712-3.712-12.15 12.15a5.25 5.25 0 0 0-1.32 2.214l-.8 2.685a.75.75 0 0 0 .933.933l2.685-.8a5.25 5.25 0 0 0 2.214-1.32L19.513 8.2Z" />
                    </svg>
                </button>
            </div>
             {{-- about texts --}}
                @if (!empty(auth()->user()->about_details))
                    <div id="skills_added_table" class="flex flex-row flex-wrap gap-2 mb-10 bg-white px-5 py-3 rounded-lg shadow-sm">
                        <p class="about_details_p p_font max-sm:text-sm">
                           {!! nl2br(e($user->about_details ?? 'No details added yet.')) !!}
                        </p>
                    </div>
                @else
                    <div class="flex flex-row flex-wrap gap-2 bg-gray-300 px-10 py-5 rounded-lg max-sm:px-5 max-sm:text-sm mb-5">
                        <p class="home_p_font text-gray-600 italic text-center">
                            No about details added yet.
                        </p>
                    </div>
                @endif

        
             {{-- credentials section --}}
            <div class="flex items-center justify-between mb-3">
                <h1 class="sub_title sm:text-2xl flex items-center gap-2 ">
                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="size-6">
                        <path d="M5.625 1.5c-1.036 0-1.875.84-1.875 1.875v17.25c0 1.035.84 1.875 1.875 1.875h12.75c1.035 0 1.875-.84 1.875-1.875V12.75A3.75 3.75 0 0 0 16.5 9h-1.875a1.875 1.875 0 0 1-1.875-1.875V5.25A3.75 3.75 0 0 0 9 1.5H5.625Z" />
                        <path d="M12.971 1.816A5.23 5.23 0 0 1 14.25 5.25v1.875c0 .207.168.375.375.375H16.5a5.23 5.23 0 0 1 3.434 1.279 9.768 9.768 0 0 0-6.963-6.963Z" />
                        </svg>
                    Credentials</h1>

                <a id="edit_credentials" href="#" class="hover:opacity-60 hidden">
                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="size-6 max-sm:size-4">
                <path d="M21.731 2.269a2.625 2.625 0 0 0-3.712 0l-1.157 1.157 3.712 3.712 1.157-1.157a2.625 2.625 0 0 0 0-3.712ZM19.513 8.199l-3.712-3.712-12.15 12.15a5.25 5.25 0 0 0-1.32 2.214l-.8 2.685a.75.75 0 0 0 .933.933l2.685-.8a5.25 5.25 0 0 0 2.214-1.32L19.513 8.2Z" />
                </svg>
                </a>
            </div>


        {{-- credentials Files, Images section --}}
             <div class="mb-5">
                {{-- file uploads --}}
                <h1 class="sub_title_font text-1sm">File Uploads</h1>
                    <div class="p-4 bg-gray-300 rounded-lg shadow-sm mb-4 flex flex-col gap-3">
                         @forelse($user->uploads->where('type','file') as $file)
                        <div class="p_font flex items-center bg-white px-4 py-2 rounded-xl gap-2 shadow-sm cursor-pointer hover:bg-gray-200">
                            {{-- File icon --}}
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                stroke-width="1.5" stroke="currentColor" class="size-8 max-sm:size-8 flex">
                                <path stroke-linecap="round" stroke-linejoin="round"
                                    d="M19.5 14.25v-2.625a3.375 3.375 0 0 0-3.375-3.375h-1.5A1.125 1.125 0 0 1 13.5 7.125v-1.5a3.375 3.375 0 0 0-3.375-3.375H8.25m0 12.75h7.5m-7.5 3H12M10.5 2.25H5.625c-.621 0-1.125.504-1.125 1.125v17.25c0 .621.504 1.125 1.125 1.125h12.75c.621 0 1.125-.504 1.125-1.125V11.25a9 9 0 0 0-9-9Z" />
                            </svg>

                            {{-- File name (click to download) --}}
                            <a href="{{ asset('storage/' . $file->path) }}" target="_blank"
                            class="file_name hover:underline text-sm w-120 overflow-hidden text-nowrap">
                                {{ $file->original_name }}
                            </a>

                            {{-- Ellipsis icon for delete menu --}}
                            <button class="open-delete-modal cursor-pointer hidden" 
                                    data-url="{{ route('uploads.destroy', $file->id) }}">
                                <svg xmlns="http://www.w3.org/2000/svg" fill="none"
                                    viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor"
                                    class="size-8 max-sm:size-6 flex ml-auto hover:bg-red-400 rounded-full">
                                    <path stroke-linecap="round" stroke-linejoin="round"
                                        d="M6.75 12a.75.75 0 1 1-1.5 0 .75.75 0 0 1 1.5 0ZM12.75 12a.75.75 0 1 1-1.5 0 .75.75 0 0 1 1.5 0ZM18.75 12a.75.75 0 1 1-1.5 0 .75.75 0 0 1 1.5 0Z" />
                                </svg>
                            </button>

                        </div>
                         @empty
                            <div class="flex flex-row flex-wrap gap-2 bg-gray-300 px-10 py-5 rounded-lg max-sm:px-5 max-sm:text-sm">
                                <p class="home_p_font text-gray-600 italic text-center">No file uploads yet. </p>
                            </div>
                        @endforelse
                    </div>

                {{-- images uploads --}}
                <h1 class="sub_title_font text-1sm">Image Uploads</h1>
                    <div class="p-4 bg-gray-300 rounded-lg shadow-s mb-4">

                       @php
                            $images = $user->uploads->where('type', 'image');
                        @endphp

                        @if ($images->count() > 0)
                            {{-- big preview (default to first image) --}}
                            <div class="flex justify-end-safe">
                            <img id="bigPreview"
                                src="{{ Storage::url($images->first()->path) }}"
                                alt="Preview"
                                class="w-full rounded-lg shadow-lg cursor-pointer mb-2">
                                {{-- image delete button --}}
                                <button id="deleteImageBtn" type="button" class="absolute mt-2 mr-2 hidden">
                                    <svg xmlns="http://www.w3.org/2000/svg" fill="none"
                                        viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor"
                                        class="size-8 text-white max-sm:size-6 flex ml-auto hover:bg-red-400 bg-[#0000005e] rounded-full cursor-pointer">
                                        <path stroke-linecap="round" stroke-linejoin="round"
                                            d="M6.75 12a.75.75 0 1 1-1.5 0 .75.75 0 0 1 1.5 0ZM12.75 12a.75.75 0 1 1-1.5 0 .75.75 0 0 1 1.5 0ZM18.75 12a.75.75 0 1 1-1.5 0 .75.75 0 0 1 1.5 0Z" />
                                    </svg>
                                </button>

                            </div>

                            <!-- Fullscreen image modal -->
                            <div id="imageModal" 
                                class="fixed inset-0 bg-[#000000b0] flex items-center justify-center hidden z-50 py-20 px-5">
                                <img id="modalImage" src="" 
                                    class="max-w-full max-h-full rounded-lg shadow-lg">
                                <button id="closeImageModal" 
                                    class="absolute top-4 right-4 text-white text-3xl font-bold cursor-pointer hover:text-gray-400">
                                    &times;
                                </button>
                            </div>


                            {{-- thumbnails --}}
                            <div class="flex gap-4 overflow-x-auto p-3 bg-gray-200 shadow-sm rounded-lg">
                                @foreach ($images as $img)
                                <div class="flex flex-col items-center">
                                    <img src="{{ Storage::url($img->path) }}"
                                        alt="Thumbnail"
                                        data-id="{{ $img->id }}"
                                        class="w-32 h-32 flex-shrink-0 rounded-lg shadow-lg cursor-pointer hover:scale-105 transition thumbnail">

                                    {{-- Show image name --}}
                                        <p class="text-xs text-gray-600 mt-1 w-32 text-center truncate p_font">
                                            {{ $img->original_name ?? 'Untitled' }}
                                        </p>
                                </div>
                                @endforeach
                            </div>

                            @else
                                <div class="flex flex-row flex-wrap gap-2 bg-gray-300 px-10 py-5 rounded-lg max-sm:px-5 max-sm:text-sm">
                                    <p class="home_p_font text-gray-600 italic text-center">No image uploads yet. </p>
                                </div>
                            @endif

                    </div>


             </div>

        </div>
        @endif
        
     </section>
     

    {{-- modal section --}}

    {{-- write review modal --}}
    <div id="review_modal" class="review_modal modal_bg fixed top-0 left-0 w-full h-full z-50 max-sm:px-6 hidden">
      {{-- menu control --}}
        <div class="w-2xl max-lg:w-xl max-sm:w-full mt-20 mx-auto p-5 max-sm:p-4 bg-gray-200 opacity-100 rounded-xl shadow-sm">
            {{-- modal sub title and close button --}}
            <div class="flex justify-between items-center mb-2">
                <h3 class="sub_title_font max-sm:text-sm">Describe your review below:</h3>
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" id="close_review_modal" class="size-5 cursor-pointer  hover:bg-red-400! rounded-sm max-sm:size-4 bg-gray-300!">
                <path stroke-linecap="round" stroke-linejoin="round" d="M6 18 18 6M6 6l12 12" />
                </svg>
            </div>
                <form id="reportForm" action="{{ $existingReview ? route('reviews.update', $existingReview->id) : route('reviews.store', $user->id) }}" method="POST" class="w-full bg-white p-3 rounded-lg shadow-sm">
                    @csrf
                    @if($existingReview)
                        @method('PUT')
                    @endif
                    <input type="hidden" name="rating" id="rating_value" value="{{ $existingReview->rating ?? '' }}">

                    <div class="input_control flex flex-col mb-3">
                        <h1 class="p_font max-sm:text-sm lg:text-xl font-semibold!">{{ $user->name }}</h1>
                        <h3 class="home_p_font max-sm:text-sm">{{ $user->email }}</h3>
                    </div>

                    {{-- stars and ratings --}}
                    <div class="flex text-blue-400 items-center mb-2">
                        {{-- ratings  --}}
                        <span class="p_font text-gray-600 text-sm mr-2">Your rate: </span>
                        {{-- stars --}}
                        {{-- solid star --}}
                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" aria-hidden="true" data-slot="icon" class="size-6 max-sm:size-5 hover:scale-110 cursor-pointer star_rating" data-value="1">
                        <path fill-rule="evenodd" d="M10.788 3.21c.448-1.077 1.976-1.077 2.424 0l2.082 5.006 5.404.434c1.164.093 1.636 1.545.749 2.305l-4.117 3.527 1.257 5.273c.271 1.136-.964 2.033-1.96 1.425L12 18.354 7.373 21.18c-.996.608-2.231-.29-1.96-1.425l1.257-5.273-4.117-3.527c-.887-.76-.415-2.212.749-2.305l5.404-.434 2.082-5.005Z" clip-rule="evenodd"></path>
                        </svg>
                        {{-- solid star --}}
                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" aria-hidden="true" data-slot="icon" class="size-6 max-sm:size-5 hover:scale-110 cursor-pointer star_rating" data-value="2">
                        <path fill-rule="evenodd" d="M10.788 3.21c.448-1.077 1.976-1.077 2.424 0l2.082 5.006 5.404.434c1.164.093 1.636 1.545.749 2.305l-4.117 3.527 1.257 5.273c.271 1.136-.964 2.033-1.96 1.425L12 18.354 7.373 21.18c-.996.608-2.231-.29-1.96-1.425l1.257-5.273-4.117-3.527c-.887-.76-.415-2.212.749-2.305l5.404-.434 2.082-5.005Z" clip-rule="evenodd"></path>
                        </svg>
                        {{-- solid star --}}
                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" aria-hidden="true" data-slot="icon" class="size-6 max-sm:size-5 hover:scale-110 cursor-pointer star_rating" data-value="3">
                        <path fill-rule="evenodd" d="M10.788 3.21c.448-1.077 1.976-1.077 2.424 0l2.082 5.006 5.404.434c1.164.093 1.636 1.545.749 2.305l-4.117 3.527 1.257 5.273c.271 1.136-.964 2.033-1.96 1.425L12 18.354 7.373 21.18c-.996.608-2.231-.29-1.96-1.425l1.257-5.273-4.117-3.527c-.887-.76-.415-2.212.749-2.305l5.404-.434 2.082-5.005Z" clip-rule="evenodd"></path>
                        </svg>
                        {{-- solid star --}}
                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" aria-hidden="true" data-slot="icon" class="size-6 max-sm:size-5 hover:scale-110 cursor-pointer star_rating" data-value="4">
                        <path fill-rule="evenodd" d="M10.788 3.21c.448-1.077 1.976-1.077 2.424 0l2.082 5.006 5.404.434c1.164.093 1.636 1.545.749 2.305l-4.117 3.527 1.257 5.273c.271 1.136-.964 2.033-1.96 1.425L12 18.354 7.373 21.18c-.996.608-2.231-.29-1.96-1.425l1.257-5.273-4.117-3.527c-.887-.76-.415-2.212.749-2.305l5.404-.434 2.082-5.005Z" clip-rule="evenodd"></path>
                        </svg>
                        {{-- solid star --}}
                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" aria-hidden="true" data-slot="icon" class="size-6 max-sm:size-5 hover:scale-110 cursor-pointer star_rating" data-value="5">
                        <path fill-rule="evenodd" d="M10.788 3.21c.448-1.077 1.976-1.077 2.424 0l2.082 5.006 5.404.434c1.164.093 1.636 1.545.749 2.305l-4.117 3.527 1.257 5.273c.271 1.136-.964 2.033-1.96 1.425L12 18.354 7.373 21.18c-.996.608-2.231-.29-1.96-1.425l1.257-5.273-4.117-3.527c-.887-.76-.415-2.212.749-2.305l5.404-.434 2.082-5.005Z" clip-rule="evenodd"></path>
                        </svg>
                    </div>
                    
                    <div class="input_control flex flex-col mb-3 w-full">
                        <label for="report_message" class=" mb-1 home_p_font text-black! max-sm:text-sm">
                            Message <span class="text-gray-400">(optional)</span>
                        </label>
                        <textarea id="report_message" name="message" class="p-2 w-full border-2 border-gray-400 rounded-lg max-sm:text-sm">{{ $existingReview->message ?? '' }}</textarea>
                    </div>
                    
                    <div class="flex">
                        <input type="submit" value="Submit Review" class="cursor-pointer p_font bg-[#1E2939] text-white px-7 py-3 max-sm:py-3 max-sm:px-5 rounded-lg hover:opacity-90 max-sm:text-sm text-center ml-auto">
                    </div>
                </form>

       </div>
    </div>

    {{-- review modal JS --}}
    <script>
    document.addEventListener('DOMContentLoaded', () => {

        const openBtn = document.getElementById('write_review_button') || document.getElementById('edit_review_button');
        const modal    = document.getElementById('review_modal');
        const closeBtn = document.getElementById('close_review_modal');
        const stars    = document.querySelectorAll('.star_rating');
        const ratingInput = document.getElementById('rating_value');

        if (!openBtn || !modal) return;

        /* =========================
        OPEN / CLOSE MODAL
        ========================== */

        openBtn.addEventListener('click', () => {
            modal.classList.remove('hidden');
        });

        closeBtn.addEventListener('click', () => {
            modal.classList.add('hidden');
        });

        // click outside modal content
        modal.addEventListener('click', (e) => {
            if (e.target === modal) {
                modal.classList.add('hidden');
            }
        });

        // ESC key
        document.addEventListener('keydown', (e) => {
            if (e.key === 'Escape') {
                modal.classList.add('hidden');
            }
        });

        /* =========================
        STAR RATING LOGIC
        ========================== */

        stars.forEach(star => {
            star.addEventListener('click', () => {
                const value = star.dataset.value;
                ratingInput.value = value;

                stars.forEach(s => {
                    if (s.dataset.value <= value) {
                        s.classList.add('text-blue-400');
                        s.classList.remove('text-gray-400');
                    } else {
                        s.classList.add('text-gray-400');
                        s.classList.remove('text-blue-400');
                    }
                });
            });
        });

        const initialRating = parseInt(ratingInput.value);
        if (initialRating) {
            stars.forEach(s => {
                if (s.dataset.value <= initialRating) {
                    s.classList.add('text-blue-400');
                    s.classList.remove('text-gray-400');
                } else {
                    s.classList.add('text-gray-400');
                    s.classList.remove('text-blue-400');
                }
            });
        }

    });
    </script>
    {{-- reload when submit review --}}
    <script>
    document.addEventListener('DOMContentLoaded', () => {

        const form = document.getElementById('reportForm');
        if (!form) return;

        form.addEventListener('submit', () => {
            // close the modal immediately (optional)
            document.getElementById('review_modal').classList.add('hidden');

            // reload page after form is submitted
            setTimeout(() => {
                window.location.reload();
            }, 100); // small delay to let the form submit
        });

    });
    </script>

    {{-- edit review modal --}}
    <div id="edit_review_modal" class="edit_review_modal modal_bg fixed top-0 left-0 w-full h-full z-50 max-sm:px-6 hidden">
      {{-- menu control --}}
        <div class="w-2xl max-lg:w-xl max-sm:w-full mt-20 mx-auto p-5 max-sm:p-4 bg-gray-200 opacity-100 rounded-xl shadow-sm">
            {{-- modal sub title and close button --}}
            <div class="flex justify-between items-center mb-2">
                <h3 class="sub_title_font max-sm:text-sm">Describe your review below:</h3>
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" id="close_review_modal" class="size-5 cursor-pointer  hover:bg-red-400! rounded-sm max-sm:size-4 bg-gray-300!">
                <path stroke-linecap="round" stroke-linejoin="round" d="M6 18 18 6M6 6l12 12" />
                </svg>
            </div>
                <form id="edit_review_form" action="" method="POST" class="w-full bg-white p-3 rounded-lg shadow-sm">
                    @csrf
                    <input type="hidden" name="rating" id="rating_value">

                    <div class="input_control flex flex-col mb-3">
                        <h1 class="p_font max-sm:text-sm lg:text-xl font-semibold!">{{ $user->name }}</h1>
                        <h3 class="home_p_font max-sm:text-sm">{{ $user->email }}</h3>
                    </div>

                    {{-- stars and ratings --}}
                    <div class="flex text-blue-400 items-center mb-2">
                        {{-- ratings  --}}
                        <span class="p_font text-gray-600 text-sm mr-2">Your rate: </span>
                        {{-- stars --}}
                        {{-- solid star --}}
                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" aria-hidden="true" data-slot="icon" class="size-6 max-sm:size-5 hover:scale-110 cursor-pointer star_rating" data-value="1">
                        <path fill-rule="evenodd" d="M10.788 3.21c.448-1.077 1.976-1.077 2.424 0l2.082 5.006 5.404.434c1.164.093 1.636 1.545.749 2.305l-4.117 3.527 1.257 5.273c.271 1.136-.964 2.033-1.96 1.425L12 18.354 7.373 21.18c-.996.608-2.231-.29-1.96-1.425l1.257-5.273-4.117-3.527c-.887-.76-.415-2.212.749-2.305l5.404-.434 2.082-5.005Z" clip-rule="evenodd"></path>
                        </svg>
                        {{-- solid star --}}
                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" aria-hidden="true" data-slot="icon" class="size-6 max-sm:size-5 hover:scale-110 cursor-pointer star_rating" data-value="2">
                        <path fill-rule="evenodd" d="M10.788 3.21c.448-1.077 1.976-1.077 2.424 0l2.082 5.006 5.404.434c1.164.093 1.636 1.545.749 2.305l-4.117 3.527 1.257 5.273c.271 1.136-.964 2.033-1.96 1.425L12 18.354 7.373 21.18c-.996.608-2.231-.29-1.96-1.425l1.257-5.273-4.117-3.527c-.887-.76-.415-2.212.749-2.305l5.404-.434 2.082-5.005Z" clip-rule="evenodd"></path>
                        </svg>
                        {{-- solid star --}}
                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" aria-hidden="true" data-slot="icon" class="size-6 max-sm:size-5 hover:scale-110 cursor-pointer star_rating" data-value="3">
                        <path fill-rule="evenodd" d="M10.788 3.21c.448-1.077 1.976-1.077 2.424 0l2.082 5.006 5.404.434c1.164.093 1.636 1.545.749 2.305l-4.117 3.527 1.257 5.273c.271 1.136-.964 2.033-1.96 1.425L12 18.354 7.373 21.18c-.996.608-2.231-.29-1.96-1.425l1.257-5.273-4.117-3.527c-.887-.76-.415-2.212.749-2.305l5.404-.434 2.082-5.005Z" clip-rule="evenodd"></path>
                        </svg>
                        {{-- solid star --}}
                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" aria-hidden="true" data-slot="icon" class="size-6 max-sm:size-5 hover:scale-110 cursor-pointer star_rating" data-value="4">
                        <path fill-rule="evenodd" d="M10.788 3.21c.448-1.077 1.976-1.077 2.424 0l2.082 5.006 5.404.434c1.164.093 1.636 1.545.749 2.305l-4.117 3.527 1.257 5.273c.271 1.136-.964 2.033-1.96 1.425L12 18.354 7.373 21.18c-.996.608-2.231-.29-1.96-1.425l1.257-5.273-4.117-3.527c-.887-.76-.415-2.212.749-2.305l5.404-.434 2.082-5.005Z" clip-rule="evenodd"></path>
                        </svg>
                        {{-- solid star --}}
                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" aria-hidden="true" data-slot="icon" class="size-6 max-sm:size-5 hover:scale-110 cursor-pointer star_rating" data-value="5">
                        <path fill-rule="evenodd" d="M10.788 3.21c.448-1.077 1.976-1.077 2.424 0l2.082 5.006 5.404.434c1.164.093 1.636 1.545.749 2.305l-4.117 3.527 1.257 5.273c.271 1.136-.964 2.033-1.96 1.425L12 18.354 7.373 21.18c-.996.608-2.231-.29-1.96-1.425l1.257-5.273-4.117-3.527c-.887-.76-.415-2.212.749-2.305l5.404-.434 2.082-5.005Z" clip-rule="evenodd"></path>
                        </svg>
                    </div>
                    
                    <div class="input_control flex flex-col mb-3 w-full">
                        <label for="report_message" class=" mb-1 home_p_font text-black! max-sm:text-sm">
                            Message <span class="text-gray-400">(optional)</span>
                        </label>
                        <textarea id="report_message" name="message" class="p-2 w-full border-2 border-gray-400 rounded-lg max-sm:text-sm"></textarea> 
                    </div>
                    
                    <div class="flex">
                        <input type="submit" value="Submit Review" class="cursor-pointer p_font bg-[#1E2939] text-white px-7 py-3 max-sm:py-3 max-sm:px-5 rounded-lg hover:opacity-90 max-sm:text-sm text-center ml-auto">
                    </div>
                </form>

       </div>
    </div>


    

     
    {{-- block modal warning --}}
    <div id="block_user" class="hidden modal_bg min-h-screen fixed top-0 z-40 w-full flex items-center justify-center px-5">
        <div class="px-5 py-3 bg-white rounded-xl -mt-20">
            <h2 class="text-xl sub_title_font font-semibold mb-2">Block this user?</h2>
            <p class="home_p_font text-gray-600 mb-3">
                You can still unblock the user after the action. <br>
                Are you sure you want to block this?
            </p>

            <div class="flex gap-2 justify-end">
                <button id="cancel_block" type="button"
                    class="bg-[#1e2939] cursor-pointer sub_title_font text-blue-400 px-4 py-2 rounded-lg hover:bg-[#374151] max-sm:text-sm">
                    Cancel
                </button>
            
                <button type="button" id="confirm_block"
                    class="bg-[#1e2939] cursor-pointer sub_title_font text-red-400 px-4 py-2 rounded-lg hover:bg-[#374151] max-sm:text-sm">
                    Block
                </button>
            </div>
        </div>
    </div>


    {{-- unblock modal warning --}}
    <div id="unblock_user" class="hidden modal_bg min-h-screen fixed top-0 z-40 w-full flex items-center justify-center px-5">
        <div class="px-5 py-3 bg-white rounded-xl -mt-20">
            <h2 class="text-xl sub_title_font font-semibold mb-2">Unblock this user?</h2>
            <p class="home_p_font text-gray-600 mb-3">
                You can still block the user after the action. <br>
                Are you sure you want to unblock this?
            </p>

            <div class="flex gap-2 justify-end">
                <button id="cancel_unblock" type="button"
                    class="bg-[#1e2939] cursor-pointer sub_title_font text-blue-400 px-4 py-2 rounded-lg hover:bg-[#374151] max-sm:text-sm">
                    Cancel
                </button>
            
                <button type="button" id="confirm_unblock"
                    class="bg-[#1e2939] cursor-pointer sub_title_font text-red-400 px-4 py-2 rounded-lg hover:bg-[#374151] max-sm:text-sm">
                    Unblock
                </button>
            </div>
        </div>
    </div>


    {{-- report modal --}}
    <div class="report_modal fixed top-0 left-0 w-full h-full z-50 max-sm:px-6 hidden">
      {{-- menu control --}}
        <div class="w-2xl max-lg:w-xl max-sm:w-full mt-20 mx-auto p-5 max-sm:p-4 bg-gray-200 opacity-100 rounded-xl shadow-sm">
            {{-- modal sub title and close button --}}
            <div class="flex justify-between items-center mb-2">
                <h3 class="sub_title_font max-sm:text-sm">Describe your problem below:</h3>
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" id="close_report_modal" class="size-5 cursor-pointer  hover:bg-red-400! rounded-sm max-sm:size-4 bg-gray-300!">
                <path stroke-linecap="round" stroke-linejoin="round" d="M6 18 18 6M6 6l12 12" />
                </svg>
            </div>
                <form id="reportForm" action="{{ route('reports.store') }}" method="POST" class="w-full bg-white p-3 rounded-lg shadow-sm">
                    @csrf
                    <input type="hidden" name="reportable_id" value="{{ $user->id }}">
                    <input type="hidden" name="reportable_type" value="App\Models\User">

                    <div class="input_control flex flex-col mb-3">
                        <h1 class="p_font max-sm:text-sm lg:text-xl font-semibold!">{{ $user->name }}</h1>
                        <h3 class="home_p_font max-sm:text-sm">{{ $user->email }}</h3>
                    </div>
                    
                    <div class="input_control flex flex-col mb-3 w-full">
                        <label for="report_message" class=" mb-1 home_p_font text-black! max-sm:text-sm">
                            Message <span class="text-gray-400">(optional)</span>
                        </label>
                        <textarea id="report_message" name="message" class="p-2 w-full border-2 border-gray-400 rounded-lg max-sm:text-sm"></textarea> 
                    </div>
                    
                    <div class="flex">
                        <input type="submit" value="Submit Report" class="cursor-pointer p_font bg-[#1E2939] text-white px-7 py-3 max-sm:py-3 max-sm:px-5 rounded-lg hover:opacity-90 max-sm:text-sm text-center ml-auto">
                    </div>
                </form>

       </div>
    </div>

    {{-- scripts --}}

    {{-- block modal --}}
    <script>
    document.addEventListener('DOMContentLoaded', () => {
        const blockBtn = document.getElementById('block_user_btn');
        const blockModal = document.getElementById('block_user');
        const cancelBlock = document.getElementById('cancel_block');
        const confirmBlock = document.getElementById('confirm_block');

        if (!blockBtn || !blockModal || !cancelBlock || !confirmBlock) return;

        const csrfToken = document.querySelector('meta[name="csrf-token"]').content;

        // Open modal on click
        blockBtn.addEventListener('click', () => {
            blockModal.classList.remove('hidden');
        });

        // Close modal
        cancelBlock.addEventListener('click', () => {
            blockModal.classList.add('hidden');
        });

        // Confirm block
        confirmBlock.addEventListener('click', async () => {
            const userId = blockBtn.dataset.userId;

            try {
                const response = await fetch(`/client/block/${userId}`, {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': csrfToken,
                        'Accept': 'application/json'
                    }
                });

                const data = await response.json();

                if (data.success) {
                    blockModal.classList.add('hidden');
                    location.reload(); // refresh page so Unblock button appears
                } else {
                    alert(data.message || 'Failed to block user.');
                }
            } catch (err) {
                console.error('Block error:', err);
                alert('An error occurred while blocking the user.');
            }
        });

        // Close modal when clicking outside
        blockModal.addEventListener('click', (e) => {
            if (e.target === blockModal) {
                blockModal.classList.add('hidden');
            }
        });
    });
    </script>

    {{-- unblock modal --}}
    <script>
    document.addEventListener('DOMContentLoaded', () => {
        const unblockBtn = document.getElementById('unblock_user_btn');
        const unblockModal = document.getElementById('unblock_user');
        const cancelUnblock = document.getElementById('cancel_unblock');
        const confirmUnblock = document.getElementById('confirm_unblock');

        if (!unblockBtn || !unblockModal || !cancelUnblock || !confirmUnblock) return;

        const csrfToken = document.querySelector('meta[name="csrf-token"]').content;

        // Open modal
        unblockBtn.addEventListener('click', () => {
            unblockModal.classList.remove('hidden');
        });

        // Cancel modal
        cancelUnblock.addEventListener('click', () => {
            unblockModal.classList.add('hidden');
        });

        // Confirm unblock
        confirmUnblock.addEventListener('click', async () => {
            const userId = unblockBtn.dataset.userId;

            try {
                const response = await fetch(`/client/unblock/${userId}`, {
                    method: 'DELETE',
                    headers: {
                        'X-CSRF-TOKEN': csrfToken,
                        'Accept': 'application/json'
                    }
                });

                const data = await response.json();

                if (data.success) {
                    unblockModal.classList.add('hidden');
                    location.reload(); // refresh page to update button/profile
                } else {
                    alert(data.message || 'Failed to unblock user.');
                }

            } catch (err) {
                console.error('Unblock error:', err);
                alert('An error occurred while unblocking the user.');
            }
        });

        // Close modal when clicking outside
        unblockModal.addEventListener('click', (e) => {
            if (e.target === unblockModal) {
                unblockModal.classList.add('hidden');
            }
        });
    });
    </script>





    {{-- drowndown option --}}
    <script>
    document.addEventListener('DOMContentLoaded', () => {
        const reportButton = document.querySelector('#report_user_btn');
        const reportModal = document.querySelector('.report_modal');
        const closeReportModal = document.getElementById('close_report_modal');
        const reportForm = document.getElementById('reportForm');

        // open modal
        reportButton.addEventListener('click', () => {
            reportModal.classList.remove('hidden');
        });

        // close modal
        closeReportModal.addEventListener('click', () => {
            reportModal.classList.add('hidden');
        });

        // submit report via AJAX
        reportForm.addEventListener('submit', async (e) => {
            e.preventDefault(); // ✅ STOP normal form submission

            const formData = new FormData(reportForm);
            const response = await fetch(reportForm.action, {
                method: 'POST',
                headers: { 'X-CSRF-TOKEN': formData.get('_token') },
                body: formData
            });

            const data = await response.json();

            if (data.success) {
                alert(data.message);
                location.reload(); // ✅ refresh the page
            } else {
                alert('Something went wrong. Please try again.');
            }
        });
    });
    </script>

  

    
           
@include('components.footer_client')
<script src="{{ asset('js/client/public_profile.js') }}"></script>

@endsection