@extends('layouts.app')

@section('body-class', 'bg-[#F0F0F0]')

@section('content')
    @include('components.nav_employee')

        
    <section class="w-full flex min-h-[80vh] flex-col items-center  px-20 max-lg:px-10 max-sm:px-5 max-sm:pt-5 pt-10">
        <div class="xl:w-6xl max-xl:w-full mx-auto px-5 max-sm:px-2 mb-10">
            <div class="flex items-center justify-between max-xl:flex-col max-xl:items-start max-xl:mb-4 mb-5">
                <div>
                    <h1 class="sub_title sm:text-xl">Job Posting</h1>
                    <p class="home_p_font mb-2 text-sm">Easily post your job openings and reach top candidates.</p>
                </div>

                <div class="max-xl:w-full ml-auto">
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="size-6 absolute mt-2 max-sm:mt-1.5 ml-2">
                    <path fill-rule="evenodd" d="M10.5 3.75a6.75 6.75 0 1 0 0 13.5 6.75 6.75 0 0 0 0-13.5ZM2.25 10.5a8.25 8.25 0 1 1 14.59 5.28l4.69 4.69a.75.75 0 1 1-1.06 1.06l-4.69-4.69A8.25 8.25 0 0 1 2.25 10.5Z" clip-rule="evenodd" />
                    </svg>
                    {{-- search inputs --}}
                    <form action="{{ route('employee.postings') }}" method="GET" class="bg-white  shadow-sm rounded-lg max-xl:w-full p_font pr-2 max-sm:text-sm flex items-center">
                            {{-- input 1 job title, skills, company --}}
                            <input type="text" name="q" value="{{ request('q') }}" class=" max-xl:w-full pl-10 py-2  pr-5 rounded-lg p_font max-sm:text-sm" placeholder="Search job title, skills, company">
                            
                            <span class="w-[1px] h-[30px] bg-gray-500 opacity-50"></span>
                        
                         
                        <div class="max-xl:w-full">
                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-6 xl:hidden absolute mt-2 max-sm:mt-1.5 ml-2">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M15 10.5a3 3 0 1 1-6 0 3 3 0 0 1 6 0Z" />
                                <path stroke-linecap="round" stroke-linejoin="round" d="M19.5 10.5c0 7.142-7.5 11.25-7.5 11.25S4.5 17.642 4.5 10.5a7.5 7.5 0 1 1 15 0Z" />
                                </svg>
                                {{-- input 2 more on loction --}}
                                <input type="text" name="location" value="{{ request('location') }}" class="max-xl:pl-10 max-xl:w-full pl-3 py-2  rounded-lg p_font max-sm:text-sm" placeholder="Remote, address, zone, block">
                        </div>
                    
                        <button class=" p_font px-2 py-1 bg-[#1e2939] rounded-lg text-sm cursor-pointer text-white hover:opacity-80 ml-2">Search</button>
                    </form>

                </div>
            </div>
            
 


                {{-- If no jobs --}}
                @if ($posts->isEmpty())
                    <div id="no_job_posted" class="flex flex-col items-center justify-center py-20 text-center bg-gray-200 rounded-xl">
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
                        <h2 class="text-xl font-semibold text-gray-800">No job postings yet</h2>
                        <p class="text-gray-500 mt-1">Please check back later for available job opportunities.</p>
                    </div>
                @else
                
                    {{-- Job cards --}}
                    @foreach($posts as $post)
                        {{--  job posted cards --}}
                    <div class="bg-white w-full rounded-xl mx-auto shadow-lg px-10 py-6 mb-5 max-lg:px-7 max-sm:py-3 max-sm:px-5">
                            <div class="div_control mb-2 flex flex-row items-center justify-between">
                                <a href="{{ route('employee.jobs.show', Str::slug($post->job_title)) }}"
                                class="job_posting_title text-2xl max-sm:text-xl capitalize hover:opacity-70 hover:underline">
                                {{ $post->job_title }}
                                </a>
                                    @php
                                        $isSaved = auth()->user()->savedJobs->contains($post->id);
                                    @endphp
                                    <form action="{{ route('employee.jobs.save', $post->id) }}" method="POST">
                                        @csrf
                                        <button type="submit">
                                            <svg id="save_icon" xmlns="http://www.w3.org/2000/svg" 
                                                fill="{{ $isSaved ? 'currentColor' : 'none' }}" 
                                                viewBox="0 0 24 24" stroke-width="1.5" 
                                                stroke="currentColor" 
                                                class="size-6 cursor-pointer hover:opacity-60 max-sm:size-5">
                                                <path stroke-linecap="round" stroke-linejoin="round" 
                                                    d="M17.593 3.322c1.1.128 1.907 1.077 
                                                        1.907 2.185V21L12 17.25 4.5 21V5.507c0-1.108.806-2.057 
                                                        1.907-2.185a48.507 48.507 0 0 1 11.186 0Z" />
                                            </svg>
                                        </button>
                                    </form>

                            </div>
                            <h2 class="job_posting_company text-xl mb-2 max-sm:text-sm capitalize">{{ $post->client->name }}</h2>

                            <div class="flex items-start  justify-between mb-4 max-sm:flex-col max-sm:gap-3 max-sm:mb-3">
                                <div class="flex flex-col gap-1">
                                    <div class="flex items-center gap-1">
                                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-6 text-[#78818D] max-sm:size-5">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M15 10.5a3 3 0 1 1-6 0 3 3 0 0 1 6 0Z" />
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M19.5 10.5c0 7.142-7.5 11.25-7.5 11.25S4.5 17.642 4.5 10.5a7.5 7.5 0 1 1 15 0Z" />
                                        </svg>
                                        <h4 class="text-[#78818D] text-lg max-sm:text-sm capitalize p_font">{{ $post->job_location }}</h4>
                                    </div>

                                    <div class="flex items-center gap-1">
                                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-6 text-[#78818D] max-sm:size-5">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M20.25 14.15v4.25c0 1.094-.787 2.036-1.872 2.18-2.087.277-4.216.42-6.378.42s-4.291-.143-6.378-.42c-1.085-.144-1.872-1.086-1.872-2.18v-4.25m16.5 0a2.18 2.18 0 0 0 .75-1.661V8.706c0-1.081-.768-2.015-1.837-2.175a48.114 48.114 0 0 0-3.413-.387m4.5 8.006c-.194.165-.42.295-.673.38A23.978 23.978 0 0 1 12 15.75c-2.648 0-5.195-.429-7.577-1.22a2.016 2.016 0 0 1-.673-.38m0 0A2.18 2.18 0 0 1 3 12.489V8.706c0-1.081.768-2.015 1.837-2.175a48.111 48.111 0 0 1 3.413-.387m7.5 0V5.25A2.25 2.25 0 0 0 13.5 3h-3a2.25 2.25 0 0 0-2.25 2.25v.894m7.5 0a48.667 48.667 0 0 0-7.5 0M12 12.75h.008v.008H12v-.008Z" />
                                        </svg>
                                        <h4 class="text-[#78818D] text-lg max-sm:text-sm capitalize p_font">{{ $post->job_type }}</h4>
                                    </div>
                                </div>

                                <div class="">
                                    <h2 class="job_posting_company salary text-xl max-sm:text-sm">
                                        ₱{{ number_format($post->job_pay, 2) }}
                                    </h2>

                                    <h2 class="job_posting_company salary text-right text-xl max-sm:text-sm max-sm:text-left capitalize">
                                        {{ $post->salary_release }}
                                    </h2>
                                </div>
                            </div>
                                <h4 class="job_posting_company text-[#78818D] mb-2 max-sm:text-xs">
                                    {{ $post->short_description }}
                                </h4>
                            <div class="div_control flex justify-between max-sm:flex-col flex-col">
                                <div class="div_control max-sm:w-full max-sm:mb-3">
                                    <div class="div_control flex gap-2 mb-4 max-sm:gap-1 flex-wrap">
                                        @foreach(explode(',', $post->skills_required) as $skill)
                                            <h3 class="px-3 py-1 bg-gray-200 rounded-lg job_posting_company hover:bg-gray-300 hover:text-gray-300 max-sm:text-sm max-sm:px-2 capitalize">
                                                {{ trim($skill) }}
                                            </h3>
                                        @endforeach
                                    </div>

                                    <div class="flex gap-5 max-sm:gap-2 max-sm:flex-col">
                                        <h4 class="job_posting_company text-sm posted_time_before_a_day max-sm:text-xs flex items-center">
                                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="size-5">
                                            <path fill-rule="evenodd" d="M12 2.25c-5.385 0-9.75 4.365-9.75 9.75s4.365 9.75 9.75 9.75 9.75-4.365 9.75-9.75S17.385 2.25 12 2.25ZM12.75 6a.75.75 0 0 0-1.5 0v6c0 .414.336.75.75.75h4.5a.75.75 0 0 0 0-1.5h-3.75V6Z" clip-rule="evenodd" />
                                            </svg>
                                            <span id="posted_time" class=" font-semibold ml-1"> {{ $post->created_at->diffForHumans() }}</span>
                                        </h4>
                                        <h4 class="status_holder job_posting_company text-sm  posted_time_before_a_day max-sm:text-xs flex items-center text-blue-5400! font-semibold! " data-id="{{ $post->id }}" data-status="{{ $post->status }}">
                                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="size-5">
                                            <path fill-rule="evenodd" d="M2.25 12c0-5.385 4.365-9.75 9.75-9.75s9.75 4.365 9.75 9.75-4.365 9.75-9.75 9.75S2.25 17.385 2.25 12Zm13.36-1.814a.75.75 0 1 0-1.22-.872l-3.236 4.53L9.53 12.22a.75.75 0 0 0-1.06 1.06l2.25 2.25a.75.75 0 0 0 1.14-.094l3.75-5.25Z" clip-rule="evenodd" />
                                            </svg>
                                            Status:  <span class="status font-semibold ml-1 uppercase
                                                        @if($post->status === 'open') text-green-600
                                                        @elseif($post->status === 'close') text-red-600
                                                        @elseif($post->status === 'pause') text-gray-600
                                                        @endif"
                                                        data-id="{{ $post->id }}">
                                                        {{ $post->status }}
                                                    </span>
                                        </h4>
                                    </div>
                                </div>
                            
                                
                                {{-- button actions --}}
                                <div class="flex gap-3 max-sm:flex-col max-sm:w-full max-lg:gap-2 ml-auto">
                                    <!-- edit details button -->
                                    <a href="{{ $post->status === 'open' ? route('employee.jobs.show', Str::slug($post->job_title)) : '#' }}"
                                    class="job_posting_button px-5 py-3 rounded-lg text-white text-center 
                                    {{ $post->status === 'open' ? 'bg-[#1E2939] hover:opacity-90 cursor-pointer' : 'bg-gray-400 opacity-60 cursor-not-allowed' }}">
                                    Apply Now
                                    </a>
            
                                </div>

                            </div>
                            
                    </div>
                    @endforeach
                @endif


                
                {{-- Custom Pagination --}}
                @if ($posts->total() > 3)
                    <div id="posting_pagination" class="w-full mx-auto flex items-center max-sm:flex-col max-sm:items-center gap-2">
                        <h3 class="home_p_font text-sm max-sm:text-xs">
                            Showing {{ $posts->firstItem() ?? 0 }} to {{ $posts->lastItem() ?? 0 }} of {{ $posts->total() ?? 0 }} results
                        </h3>

                        <div class="flex ml-auto gap-2 max-sm:ml-0">
                            {{-- Previous button --}}
                            @if ($posts->onFirstPage())
                                <button disabled class="cursor-not-allowed opacity-50 job_posting_button bg-[#1E2939] text-white px-5 py-2 max-sm:py-2 max-sm:px-3 rounded-lg text-sm max-sm:text-xs">Previous</button>
                            @else
                                <a href="{{ $posts->previousPageUrl() }}" class="job_posting_button bg-[#1E2939] text-white px-5 py-2 max-sm:py-2 max-sm:px-3 rounded-lg hover:opacity-90 text-sm max-sm:text-xs">Previous</a>
                            @endif

                            {{-- Next button --}}
                            @if ($posts->hasMorePages())
                                <a href="{{ $posts->nextPageUrl() }}" class="job_posting_button bg-[#1E2939] text-white px-5 py-2 max-sm:py-2 max-sm:px-5 rounded-lg hover:opacity-90 text-sm max-sm:text-xs">Next</a>
                            @else
                                <button disabled class="cursor-not-allowed opacity-50 job_posting_button bg-[#1E2939] text-white px-5 py-2 max-sm:py-2 max-sm:px-5 rounded-lg text-sm max-sm:text-xs">Next</button>
                            @endif
                        </div>
                    </div>
                @endif
                





            {{-- no job posted yet message --}}
            <div class="flex flex-col items-center justify-center py-20 text-center bg-gray-200 rounded-xl hidden">
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
            
                <h2 class="text-xl font-semibold text-gray-800 sub_title_font">No job postings yet</h2>
                <p class="text-gray-500 mt-1 home_p_font">Please check back later for available job opportunities.</p>
            </div>


            {{-- sample 1 job posted --}}
           <div class="bg-white w-full rounded-xl mx-auto shadow-lg px-10 max-sm:px-7 py-6 mb-5 hidden">
                <div class="div_control mb-2 flex flex-row items-center justify-between">
                    <h1 class="job_posting_title text-2xl max-sm:text-xl">Job Title</h1>
                    <svg id="save_icon" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-6 cursor-pointer hover:opacity-60 max-sm:size-5">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M17.593 3.322c1.1.128 1.907 1.077 1.907 2.185V21L12 17.25 4.5 21V5.507c0-1.108.806-2.057 1.907-2.185a48.507 48.507 0 0 1 11.186 0Z" />
                    </svg>
                </div>
                <h2 class="job_posting_company text-xl mb-2 max-sm:text-sm">Company Name</h2>

                <div class="flex items-start  justify-between mb-4 max-sm:flex-col max-sm:gap-3 max-sm:mb-3">
                    <div class="flex flex-col gap-1">
                        <div class="flex items-center gap-1">
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-6 text-[#78818D] max-sm:size-5">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M15 10.5a3 3 0 1 1-6 0 3 3 0 0 1 6 0Z" />
                            <path stroke-linecap="round" stroke-linejoin="round" d="M19.5 10.5c0 7.142-7.5 11.25-7.5 11.25S4.5 17.642 4.5 10.5a7.5 7.5 0 1 1 15 0Z" />
                            </svg>
                            <h4 class="text-[#78818D] text-lg max-sm:text-sm">Location</h4>
                        </div>

                        <div class="flex items-center gap-1">
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-6 text-[#78818D] max-sm:size-5">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M20.25 14.15v4.25c0 1.094-.787 2.036-1.872 2.18-2.087.277-4.216.42-6.378.42s-4.291-.143-6.378-.42c-1.085-.144-1.872-1.086-1.872-2.18v-4.25m16.5 0a2.18 2.18 0 0 0 .75-1.661V8.706c0-1.081-.768-2.015-1.837-2.175a48.114 48.114 0 0 0-3.413-.387m4.5 8.006c-.194.165-.42.295-.673.38A23.978 23.978 0 0 1 12 15.75c-2.648 0-5.195-.429-7.577-1.22a2.016 2.016 0 0 1-.673-.38m0 0A2.18 2.18 0 0 1 3 12.489V8.706c0-1.081.768-2.015 1.837-2.175a48.111 48.111 0 0 1 3.413-.387m7.5 0V5.25A2.25 2.25 0 0 0 13.5 3h-3a2.25 2.25 0 0 0-2.25 2.25v.894m7.5 0a48.667 48.667 0 0 0-7.5 0M12 12.75h.008v.008H12v-.008Z" />
                            </svg>
                            <h4 class="text-[#78818D] text-lg max-sm:text-sm">Job Category</h4>
                        </div>
                    </div>

                    <div class="">
                        <h2 class="job_posting_company salary text-xl max-sm:text-sm">
                        ₱ 25,000 - ₱ 30,000
                        </h2>
                        <h2 class="job_posting_company salary text-right text-xl max-sm:text-sm max-sm:text-left">
                            Salary release
                        </h2>
                    </div>
                </div>
                    <h4 class="job_posting_company text-[#78818D] text-1lg mb-2 max-sm:text-xs">
                        (Short job description Salary release)
                    </h4>
                <div class="div_control flex items-center justify-between max-sm:flex-col ">
                    <div class="div_control max-sm:w-full max-sm:mb-3">
                        <div class="div_control flex gap-2 mb-4 max-sm:gap-1">
                        <h3 class="px-3 py-1 bg-gray-200 rounded-lg job_posting_company hover:bg-gray-300 hover:text-gray-300 max-sm:text-sm max-sm:px-2">Skills</h3>
                        <h3 class="px-3 py-1 bg-gray-200 rounded-lg job_posting_company hover:bg-gray-300 hover:text-gray-300 max-sm:text-sm">Skills</h3>
                        <h3 class="px-3 py-1 bg-gray-200 rounded-lg job_posting_company hover:bg-gray-300 hover:text-gray-300 max-sm:text-sm">Skills</h3>
                        </div>
                        <h4 class="job_posting_company text-sm posted_time_before_a_day max-sm:text-xs flex items-center">
                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="size-5">
                            <path fill-rule="evenodd" d="M12 2.25c-5.385 0-9.75 4.365-9.75 9.75s4.365 9.75 9.75 9.75 9.75-4.365 9.75-9.75S17.385 2.25 12 2.25ZM12.75 6a.75.75 0 0 0-1.5 0v6c0 .414.336.75.75.75h4.5a.75.75 0 0 0 0-1.5h-3.75V6Z" clip-rule="evenodd" />
                            </svg>
                            Posted Time
                        </h4>
                    </div>

                    <a href="{{ route('employee.jobs') }}" class="cursor-pointer job_posting_button bg-[#1E2939] text-white px-10 py-3 max-sm:py-3 max-sm:px-5 rounded-lg hover:opacity-90 max-sm:text-sm max-sm:w-full text-center">
                        Apply Now
                    </a>
                </div>
                
           </div>

          

          

           

           

         {{-- pagination for job posted --}}
            <div id="posting_pagination" class="w-full mx-auto flex items-center max-sm:flex-col max-sm:items-center gap-2 hidden">
                <h3 class="home_p_font text-sm max-sm:text-xs ">Showing 1 to 3 of 10 results</h3>
                <div class="flex ml-auto gap-2 max-sm:ml-0">
                    <button class="cursor-pointer job_posting_button bg-[#1E2939] text-white px-5 py-2 max-sm:py-2 max-sm:px-3 rounded-lg hover:opacity-90 text-sm max-sm:text-xs">Previous</button>
                    <button class="cursor-pointer job_posting_button bg-[#1E2939] text-white px-5 py-2 max-sm:py-2 max-sm:px-5 rounded-lg hover:opacity-90 text-sm max-sm:text-xs">Next</button>
                </div>
            </div>

      
      
        </div>
    </section>


       @include('components.footer_employee')
@endsection