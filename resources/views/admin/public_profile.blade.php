@extends('layouts.app')

@section('body-class', 'bg-[#F0F0F0]')

@section('content')
     @include('components.nav_admin')


    <!-- main content -->
    <section class="w-full  z-0">
        <div class="pt-35 pl-85 max-[1270px]:pl-75 max-lg:pl-7  pr-10 max-sm:pr-5 pb-15">
            {{-- Contents --}}

            <div class="sm:w-2xl mx-auto px-5 max-sm:px-3 mb-10">
            <div class="flex items-center justify-between">
            <a class="sub_title sm:text-4xl text-lg hover:underline cursor-pointer">{{ $user->name  }}</a>

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
            <p class="home_p_font mb-3 text-sm flex items-center gap-2">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-6">
                <path stroke-linecap="round" stroke-linejoin="round" d="M15 10.5a3 3 0 1 1-6 0 3 3 0 0 1 6 0Z" />
                <path stroke-linecap="round" stroke-linejoin="round" d="M19.5 10.5c0 7.142-7.5 11.25-7.5 11.25S4.5 17.642 4.5 10.5a7.5 7.5 0 1 1 15 0Z" />
                </svg>
            {{ $user->address }}</p>

            {{-- working status --}}
            <div class="p_font mb-4">
                @if($isWorking)
                    <span class="p_font px-3 py-1 bg-green-200 text-green-800 rounded-lg shadow-sm text-sm max-sm:px-2 max-sm:text-xs">Currently Working</span>
                @else
                    <span class="p_font px-3 py-1 bg-red-200 text-red-800 rounded-lg shadow-sm text-sm max-sm:px-2 max-sm:text-xs">Not currently working</span>
                @endif
            </div>
            
            {{-- follow, block, send message --}}
            <div class="p_font flex gap-2 items-center mb-4">
                <button class="px-2 py-2 bg-gray-300 rounded-lg cursor-pointer hover:bg-gray-400 hidden
                        @if(Auth::check() && Auth::user()->name === $user->name)
                            opacity-50 cursor-not-allowed pointer-events-none -z-1
                        @endif"
                        @if(Auth::check() && Auth::user()->name === $user->name)
                            disabled
                            title="You can't block or report yourself 😅"
                        @endif            
                >
                + Follow
                </button>
                @if(Auth::check() && Auth::user()->name !== $user->name)
                    <a href="{{ route('admin.chat', ['name' => $user->name]) }}"
                    class="px-2 py-2 bg-blue-300 rounded-lg cursor-pointer hover:bg-blue-400 flex items-center gap-2 max-sm:text-sm max-sm:px-1 max-sm:py-1">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                            stroke-width="1.5" stroke="currentColor" class="size-6 max-sm:size-5">
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
                        class="px-2 py-2 bg-gray-300 text-gray-600 rounded-lg cursor-not-allowed flex items-center gap-2 max-sm:text-sm max-sm:px-1 max-sm:py-1">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                            stroke-width="1.5" stroke="currentColor" class="size-6 max-sm:size-5">
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
                            opacity-50 cursor-not-allowed pointer-events-none -z-1
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
                <button class="p-2 bg-gray-300 rounded-lg cursor-pointer hover:bg-gray-400 flex items-center gap-1 text-red-500">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-5 max-sm:size-4">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M18.364 18.364A9 9 0 0 0 5.636 5.636m12.728 12.728A9 9 0 0 1 5.636 5.636m12.728 12.728L5.636 5.636" />
                    </svg>
                    Block
                </button>
                <button class="p-2 bg-gray-300 rounded-lg cursor-pointer hover:bg-gray-400 flex items-center gap-1">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-6 max-sm:size-4">
                    <path stroke-linecap="round" stroke-linejoin="round" d="m11.25 11.25.041-.02a.75.75 0 0 1 1.063.852l-.708 2.836a.75.75 0 0 0 1.063.853l.041-.021M21 12a9 9 0 1 1-18 0 9 9 0 0 1 18 0Zm-9-3.75h.008v.008H12V8.25Z" />
                    </svg>
                    Report
                </button>
            </div>

            <ul class="border-1 border-gray-300 mb-2"></ul>
            
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
                    <h3 class="home_p_font text-sm mt-2">{{ $totalRatings }} total rating{{ $totalRatings != 1 ? 's' : '' }}</h3>

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
            <div id="skills_added_table" class="flex flex-row flex-wrap gap-2 mb-10 bg-white px-5 py-3 rounded-lg shadow-sm">
                <p class="about_details_p p_font text-gray-600 max-sm:text-sm">
                    {!! nl2br(e($user->about_details ?? 'No details added yet.')) !!}
                </p>

            </div>


        {{-- skills section --}}
       @if(!empty($user->skills))
            <div class="flex items-center justify-between parent_skill_section">
            <h1 class="sub_title sm:text-2xl flex items-center gap-2">
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="size-6">
                    <path fill-rule="evenodd" d="M10.788 3.21c.448-1.077 1.976-1.077 2.424 0l2.082 5.006 5.404.434c1.164.093 1.636 1.545.749 2.305l-4.117 3.527 1.257 5.273c.271 1.136-.964 2.033-1.96 1.425L12 18.354 7.373 21.18c-.996.608-2.231-.29-1.96-1.425l1.257-5.273-4.117-3.527c-.887-.76-.415-2.212.749-2.305l5.404-.434 2.082-5.005Z" clip-rule="evenodd" />
                    </svg>
                Skills</h1>

                <a id="edit_skills" href="#" class="hover:opacity-60 hidden">
                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="size-6 max-sm:size-5">
                <path d="M21.731 2.269a2.625 2.625 0 0 0-3.712 0l-1.157 1.157 3.712 3.712 1.157-1.157a2.625 2.625 0 0 0 0-3.712ZM19.513 8.199l-3.712-3.712-12.15 12.15a5.25 5.25 0 0 0-1.32 2.214l-.8 2.685a.75.75 0 0 0 .933.933l2.685-.8a5.25 5.25 0 0 0 2.214-1.32L19.513 8.2Z" />
                </svg>
                </a>
            </div>
             {{-- skill set --}}
            <div id="skills_added_table" class="flex flex-row flex-wrap gap-2 mb-10">
                @if($user->skills)
                    <div class="flex gap-2 flex-wrap mt-3">
                        @foreach(explode(',', $user->skills) as $skill)
                            <span class="p_font px-3 py-2 bg-white shadow-sm rounded-lg text-sm capitalize hover:bg-gray-200">
                                {{ trim($skill) }}
                            </span>
                        @endforeach
                    </div>
                @else
                     {{-- no skill set yet --}}
                    <div class="flex flex-row flex-wrap gap-2 bg-gray-300 px-10 py-5 rounded-lg max-sm:px-5 max-sm:text-sm w-full">
                        <p class="home_p_font text-gray-600 italic">No skill set yet. Click the edit icon to add your skills.</p>
                    </div>
                @endif
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
                                <p class="home_p_font text-gray-600 italic text-center">No file uploads yet. Click the edit icon to add your files.</p>
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
                                            alt="{{ $img->original_name ?? 'Thumbnail' }}"
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
                                    <p class="home_p_font text-gray-600 italic text-center">No image uploads yet. Click the edit icon to add your files.</p>
                                </div>
                            @endif

                    </div>


             </div>

        </div>
            


        </div>
        
    
    </section>


    <script>
    document.addEventListener('DOMContentLoaded', () => {
        const toggleButton = document.getElementById('block_report_show');
        const dropdown = document.getElementById('block_report_dropdown');

        // Toggle dropdown when button is clicked
        toggleButton.addEventListener('click', (e) => {
            e.stopPropagation(); // prevent click from propagating to document
            dropdown.classList.toggle('hidden');
        });

        // Close dropdown when clicking outside
        document.addEventListener('click', (e) => {
            if (!dropdown.contains(e.target) && !toggleButton.contains(e.target)) {
                dropdown.classList.add('hidden');
            }
        });

        // Optional: Prevent closing dropdown if clicking inside
        dropdown.addEventListener('click', (e) => {
            e.stopPropagation();
        });
    });
    </script>





    

    <script src="{{ asset('js/employee/public_profile.js') }}"></script>
    <script src="{{ asset('js/admin/nav_admin.js') }}"></script>
@endsection
 