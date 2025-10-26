@extends('layouts.app')

@section('body-class', 'bg-[#F0F0F0]')

@section('content')
    @include('components.nav_client')
    

    <!-- main content -->
    <section class="w-full flex min-h-[80vh] flex-col items-center  px-20 max-lg:px-10 max-sm:px-5 max-sm:pt-5 pt-10">
        <div class="xl:w-6xl max-xl:w-full mx-auto px-5 max-sm:px-1 mb-10">
            <div class="flex items-center justify-between max-sm:flex-col max-xl:items-start max-xl:mb-4 mb-5">
                <div>
                    <h1 class="sub_title sm:text-xl">Job Posting</h1>
                    <p class="home_p_font mb-2 text-sm">Easily post your job openings and reach top candidates.</p>
                </div>

                {{-- search input div --}}
                <div class="max-xl:w-full ml-auto">
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="size-6 absolute mt-2 max-sm:mt-2 ml-2 max-sm:size-5 max-sm:ml-1.5">
                    <path fill-rule="evenodd" d="M10.5 3.75a6.75 6.75 0 1 0 0 13.5 6.75 6.75 0 0 0 0-13.5ZM2.25 10.5a8.25 8.25 0 1 1 14.59 5.28l4.69 4.69a.75.75 0 1 1-1.06 1.06l-4.69-4.69A8.25 8.25 0 0 1 2.25 10.5Z" clip-rule="evenodd" />
                    </svg>
                    {{-- search inputs --}}
                    <form action="{{ route('client.postings') }}" method="GET" class="bg-white  shadow-sm rounded-lg max-xl:w-full p_font pr-2 max-sm:text-sm flex items-center">
                            {{-- input 1 job title, skills, company --}}
                            <input type="text" name="q" value="{{ request('q') }}" class=" max-xl:w-full pl-10 max-sm:pl-7 py-2  pr-5 rounded-lg p_font max-sm:text-sm" placeholder="Search job title, skills, company">
                            
                            <span class="w-[1px] h-[30px] bg-gray-500 opacity-50"></span>
                        
                         
                        <div class="max-xl:w-full">
                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-6 xl:hidden absolute mt-2 max-sm:mt-2 ml-2 max-sm:ml-1 max-sm:size-5">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M15 10.5a3 3 0 1 1-6 0 3 3 0 0 1 6 0Z" />
                                <path stroke-linecap="round" stroke-linejoin="round" d="M19.5 10.5c0 7.142-7.5 11.25-7.5 11.25S4.5 17.642 4.5 10.5a7.5 7.5 0 1 1 15 0Z" />
                                </svg>
                                {{-- input 2 more on loction --}}
                                <input type="text" name="location" value="{{ request('location') }}" class="max-xl:pl-10 max-xl:w-full pl-3 py-2 max-sm:pl-7 rounded-lg p_font max-sm:text-sm" placeholder="Remote, address, zone, block">
                        </div>
                    
                        <button class=" p_font px-2 py-1 bg-[#1e2939] rounded-lg text-sm cursor-pointer text-white hover:opacity-80 ml-2">Search</button>
                    </form>

                </div>

                

            </div>

            {{-- no job posted yet message --}}
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
                <h2 class="text-xl font-semibold text-gray-800 sub_title_font">No job postings yet</h2>
                <p class="text-gray-500 mt-1 home_p_font">Please check back later for available job opportunities.</p>
            </div>

            @else
            {{-- job posted --}}
            @foreach($posts as $post)
            {{--  job posted cards --}}
           <div class="bg-white w-full rounded-xl mx-auto shadow-lg px-10 py-6 mb-5 max-lg:px-7 max-sm:py-3 max-sm:px-4">
                <div class="div_control mb-2 flex flex-row items-center justify-between">
                    <a href="{{ route('client.jobs.show', Str::slug($post->job_title)) }}" 
                    class="job_posting_title text-2xl max-sm:text-xl capitalize hover:opacity-70 hover:underline">
                    {{ $post->job_title }}
                    </a>
                        <h4 class="status_holder job_posting_company text-sm  posted_time_before_a_day max-sm:text-xs flex items-center text-blue-5400! bg-amber-200 p-2 rounded-lg shadow-sm cursor-pointer hover:bg-amber-400 max-sm:p-1" data-id="{{ $post->id }}" data-status="{{ $post->status }}">
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
                <a href="{{ route('client.public_profile', $post->client->name) }}" class="job_posting_company text-xl mb-2 max-sm:text-sm capitalize cursor-pointer hover:underline hover:text-blue-700! text-blue-500!">{{ $post->client->name }}</a>

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
                <div class="div_control flex justify-between max-sm:flex-col flex-col ">
                    <div class="div_control max-sm:w-full max-sm:mb-3 ">
                        <div class="div_control flex gap-2 mb-4 max-sm:gap-1 flex-wrap ">
                            @foreach(explode(',', $post->skills_required) as $skill)
                                <h3 class="px-3 py-1 bg-gray-200 rounded-lg job_posting_company hover:bg-gray-300 hover:text-gray-300 max-sm:text-xs max-sm:px-2 capitalize">
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

                       
                        </div>
                    </div>
                
                    
                    {{-- button actions --}}
                    <div class="flex gap-3 max-sm:flex-col max-sm:w-full max-lg:gap-2 ml-auto">
                        {{-- view details button --}}
                        <!-- edit details button -->
                        <button href="" id="edit_job_button" class="edit_job_button job_posting_button cursor-pointer job_posting_button bg-[#1E2939] text-white px-5 py-3 max-sm:py-3 max-sm:px-5 rounded-lg hover:opacity-90 max-sm:text-sm max-sm:w-full text-center max-lg:text-sm max-lg:px-4 max-lg:py-3" data-id="{{ $post->id }}"
                        data-title="{{ $post->job_title }}"
                        data-location="{{ $post->job_location }}"
                        data-type="{{ $post->job_type }}"
                        data-pay="{{ $post->job_pay }}"
                        data-salary="{{ $post->salary_release }}"
                        data-skills="{{ $post->skills_required }}"
                        data-short="{{ $post->short_description }}"
                        data-full="{{ $post->full_description }}">
                            Edit Job
                        </button>
                        <!-- edit details button -->
                        <button href="" id="delete_job_button" class="delete_job_button job_posting_button cursor-pointer job_posting_button bg-red-600 text-white px-5 py-3 max-sm:py-3 max-sm:px-5 rounded-lg hover:opacity-70 max-sm:text-sm max-sm:w-full text-center max-lg:text-sm max-lg:px-4 max-lg:py-3" data-id="{{ $post->id }}">
                            Delete
                        </button>
                    </div>

                </div>
                
           </div>
           @endforeach

           

           @endif

           {{-- end of job posted cards --}}
          

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
        
        </div> 
    </section>

    {{-- post job icon fixed --}}
    <div class="fixed bottom-10 right-10 max-sm:bottom-5 max-sm:right-5 ">
        <button id="post_a_job" class="job-post-btn bg-[#1e2939] p-2 rounded-xl cursor-pointer shadow-gray-400 shadow-sm hover:opacity-70 relative">
            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-10 text-blue-400 max-sm:size-7">
                <path stroke-linecap="round" stroke-linejoin="round" d="M12 9v6m3-3H9m12 0a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z" />
            </svg>
        </button>

        <div id="tooltip-default" class="absolute bottom-full w-[100px] text-center mb-2 left-1/2 transform -translate-x-1/2 px-3 py-2 text-sm font-medium text-white bg-gray-900 rounded-lg shadow-lg opacity-0 pointer-events-none transition-opacity duration-300 z-50 p_font max-sm:text-xs max-sm:px-1 max-sm:w-[75px]">
            Post a Job
        </div>
    </div>




 
    


    {{-- modals section--}}

    {{-- post a job modal --}}
    <div class="modal_bg post_job_modal fixed top-0 left-0 w-full h-full z-50 max-sm:px-6 px-10 hidden">
      {{-- menu control --}}
        <div class="lg:w-3xl max-h-[80vh] overflow-y-auto mt-20 mx-auto p-5 max-sm:p-4 bg-gray-200 opacity-100 rounded-xl shadow-sm">
            {{-- modal sub title and close button --}}
            <div class="flex justify-between items-center mb-2">
                <h3 class="sub_title_font max-sm:text-sm">Enter complete job details to post</h3>
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" id="close_post_job" class="size-5 cursor-pointer  hover:bg-red-400! rounded-sm max-sm:size-5 bg-gray-300!">
                <path stroke-linecap="round" stroke-linejoin="round" d="M6 18 18 6M6 6l12 12" />
                </svg>
            </div>
            
             <form action="{{ route('job_posts.store') }}" method="POST" class="w-full bg-white p-3 rounded-lg shadow-sm ">
              @csrf
                {{-- form fields --}}
                <div class="input_control flex max-sm:flex-col gap-3 mb-3">
                    <div class="input_group flex flex-col w-full">
                        <label for="job_title" class="mb-1 home_p_font text-black! max-sm:text-sm">Job Title <span class="text-red-500">*</span></label>
                        <input type="text" id="job_title" name="job_title" placeholder="Enter specific job title" class="p-2 border-2 border-gray-400 rounded-lg max-sm:text-sm" raequired>
                    </div>
                    <div class="input_group flex flex-col w-full">
                        <label for="job_location" class="mb-1 home_p_font text-black! max-sm:text-sm">Location <span class="home_p_font">(address)</span> <span class="text-red-500">*</span></label>
                        <input type="text" id="job_location" name="job_location" placeholder="Enter complete job location" class="p-2 border-2 border-gray-400 rounded-lg max-sm:text-sm" raequired>
                    </div>
                </div>

                <div class="input_control flex max-sm:flex-col gap-3 mb-3">
                    <div class="input_group flex flex-col w-full">
                        <label for="job_type" class="mb-1 home_p_font text-black! max-sm:text-sm">Job Type <span class="text-red-500">*</span></label>  
                        <select name="job_type" id="job_type" class="p-2 border-2 border-gray-400 rounded-lg max-sm:text-sm capitalize p_font" raequired>
                            <option value="" disabled selected>Select job type</option>
                            <option value="part-time">part-time</option>
                            <option value="contractual">contractual</option>
                            <option value="temporary">temporary</option>
                            <option value="internship">internship</option>
                            <option value="full-time">full-time</option>
                        </select>

                        
                    </div>
                    <div class="input_group flex flex-col w-full">
                        <label for="job_pay" class="mb-1 home_p_font text-black! max-sm:text-sm">Pay <span class="text-red-500">*</span></label>
                        <input type="number" id="job_pay" name="job_pay" placeholder="₱0.00" class="p-2 border-2 border-gray-400 rounded-lg max-sm:text-sm" raequired>
                    </div>
                </div>

                <div class="input_control flex flex-col gap-3 mb-3 ">
                    <div class="input_group flex flex-col w-full">
                        <label for="salary_release" class="mb-1 home_p_font text-black! max-sm:text-sm">Salary Release <span class="text-red-500">*</span></label>
                        <select name="salary_release" id="salary_release" class="p-2 border-2 border-gray-400 rounded-lg max-sm:text-sm capitalize p_font" raequired>
                            <option value="" disabled selected>Select salary release</option>
                            <option value="weekly">weekly</option>
                            <option value="bi-weekly">bi-weekly</option>
                            <option value="monthly">monthly</option>
                            <option value="per-project">per-project</option>
                        </select>

                        
                    </div>
                    <div class="input_group flex flex-col w-full">
                        <label for="skills_required" class="mb-1 home_p_font text-black! max-sm:text-sm">Skills Raequired <span class="text-red-500">*</span> <br><span class="home_p_font text-xs">Separate skills using comma (,)</span></label>
                        <input type="text" id="skills_required" name="skills_required" placeholder="e.g. VA, HR, Data Entry" class="p-2 border-2 border-gray-400 rounded-lg max-sm:text-sm" raequired>
                    </div>
                </div>

                <div class="input_control flex flex-col gap-3 mb-3 ">
                    <div class="input_group flex flex-col w-full">
                        <label for="short_description" class="mb-1 home_p_font text-black! max-sm:text-sm">Short Job Description <span class="text-red-500">*</span></label>
                        <textarea id="short_description" name="short_description" rows="2" placeholder="Provide a short job summary that will appear on the job card." class="p-2 border-2 border-gray-400 rounded-lg max-sm:text-sm" raequired></textarea>
                    </div>
                </div>

                <div class="input_control flex flex-col gap-3 mb-3 ">
                    <div class="input_group flex flex-col w-full">
                        <label for="full_description" class="mb-1 home_p_font text-black! max-sm:text-sm">Full Job Description <span class="text-red-500">*</span></label>
                        <textarea id="full_description" name="full_description" rows="4" placeholder="Provide detailed information about the job role, responsibilities, and requirements." class="p-2 border-2 border-gray-400 rounded-lg max-sm:text-sm" raequired></textarea>
                    </div>
                </div>
                
                
                <div class="flex">
                <input type="submit" value="Post Job" class=" cursor-pointer bg-[#1E2939] text-white px-7 py-3 max-sm:py-3 max-sm:px-5 rounded-lg hover:opacity-90 max-sm:text-sm text-center ml-auto max-sm:w-full button_font">
                </div>
             </form>
       </div>
    </div>

    {{-- edit job modal --}}
    <div class="modal_bg edit_job_modal fixed top-0 left-0 w-full h-full z-50 max-sm:px-6 px-10 hidden">
      {{-- menu control --}}
        <div class="lg:w-3xl max-h-[80vh] overflow-y-auto mt-20 mx-auto p-5 max-sm:p-4 bg-gray-200 opacity-100 rounded-xl shadow-sm">
            {{-- modal sub title and close button --}}
            <div class="flex justify-between items-center mb-2">
                <h3 class="sub_title_font max-sm:text-sm">Enter complete job details to post</h3>
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" id="close_edit_job" class="size-5 cursor-pointer  hover:bg-red-400! rounded-sm max-sm:size-5 bg-gray-300!">
                <path stroke-linecap="round" stroke-linejoin="round" d="M6 18 18 6M6 6l12 12" />
                </svg>
            </div>
             <form action="" method="POST" class="w-full bg-white p-3 rounded-lg shadow-sm ">
              @csrf
              @method('PUT') <!-- important for Laravel to treat this as PUT -->
              <input type="hidden" name="job_id" id="job_id">
                {{-- form fields --}}
                <div class="input_control flex max-sm:flex-col gap-3 mb-3">
                    <div class="input_group flex flex-col w-full">
                        <label for="job_title" class="mb-1 home_p_font text-black! max-sm:text-sm">Job Title <span class="text-red-500">*</span></label>
                        <input type="text" id="job_title" name="job_title" placeholder="Enter specific job title" class="p-2 border-2 border-gray-400 rounded-lg max-sm:text-sm" raequired>
                    </div>
                    <div class="input_group flex flex-col w-full">
                        <label for="job_location" class="mb-1 home_p_font text-black! max-sm:text-sm">Location <span class="home_p_font">(address)</span> <span class="text-red-500">*</span></label>
                        <input type="text" id="job_location" name="job_location" placeholder="Enter complete job location" class="p-2 border-2 border-gray-400 rounded-lg max-sm:text-sm" raequired>
                    </div>
                </div>

                <div class="input_control flex max-sm:flex-col gap-3 mb-3">
                    <div class="input_group flex flex-col w-full">
                        <label for="job_type" class="mb-1 home_p_font text-black! max-sm:text-sm">Job Type <span class="text-red-500">*</span></label>  
                        <select name="job_type" id="job_type" class="p-2 border-2 border-gray-400 rounded-lg max-sm:text-sm capitalize p_font" raequired>
                            <option value="" disabled selected>Select job type</option>
                            <option value="part-time">part-time</option>
                            <option value="contractual">contractual</option>
                            <option value="temporary">temporary</option>
                            <option value="internship">internship</option>
                            <option value="full-time">full-time</option>
                        </select>

                        
                    </div>
                    <div class="input_group flex flex-col w-full">
                        <label for="job_pay" class="mb-1 home_p_font text-black! max-sm:text-sm">Pay <span class="text-red-500">*</span></label>
                        <input type="number" id="job_pay" name="job_pay" placeholder="₱0.00" class="p-2 border-2 border-gray-400 rounded-lg max-sm:text-sm" raequired>
                    </div>
                </div>

                <div class="input_control flex flex-col gap-3 mb-3 ">
                    <div class="input_group flex flex-col w-full">
                        <label for="salary_release" class="mb-1 home_p_font text-black! max-sm:text-sm">Salary Release <span class="text-red-500">*</span></label>
                        <select name="salary_release" id="salary_release" class="p-2 border-2 border-gray-400 rounded-lg max-sm:text-sm capitalize p_font" raequired>
                            <option value="" disabled selected>Select salary release</option>
                            <option value="weekly">weekly</option>
                            <option value="bi-weekly">bi-weekly</option>
                            <option value="monthly">monthly</option>
                            <option value="per-project">per-project</option>
                        </select>

                        
                    </div>
                    <div class="input_group flex flex-col w-full">
                        <label for="skills_required" class="mb-1 home_p_font text-black! max-sm:text-sm">Skills Raequired <span class="text-red-500">*</span> <br><span class="home_p_font text-xs">Separate skills using comma (,)</span></label>
                        <input type="text" id="skills_required" name="skills_required" placeholder="e.g. VA, HR, Data Entry" class="p-2 border-2 border-gray-400 rounded-lg max-sm:text-sm" raequired>
                    </div>
                </div>

                <div class="input_control flex flex-col gap-3 mb-3 ">
                    <div class="input_group flex flex-col w-full">
                        <label for="short_description" class="mb-1 home_p_font text-black! max-sm:text-sm">Short Job Description <span class="text-red-500">*</span></label>
                        <textarea id="short_description" name="short_description" rows="2" placeholder="Provide a short job summary that will appear on the job card." class="p-2 border-2 border-gray-400 rounded-lg max-sm:text-sm" raequired></textarea>
                    </div>
                </div>

                <div class="input_control flex flex-col gap-3 mb-3 ">
                    <div class="input_group flex flex-col w-full">
                        <label for="full_description" class="mb-1 home_p_font text-black! max-sm:text-sm">Full Job Description <span class="text-red-500">*</span></label>
                        <textarea id="full_description" name="full_description" rows="4" placeholder="Provide detailed information about the job role, responsibilities, and requirements." class="p-2 border-2 border-gray-400 rounded-lg max-sm:text-sm" raequired></textarea>
                    </div>
                </div>
                
                <input type="hidden" name="job_id" id="job_id">

                <div class="flex">
                <input type="submit" value="Save" class=" cursor-pointer bg-[#1E2939] text-white px-7 py-3 max-sm:py-3 max-sm:px-5 rounded-lg hover:opacity-90 max-sm:text-sm text-center ml-auto max-sm:w-full button_font">
                </div>
             </form>
       </div>
    </div>

    {{-- delete modal warning --}}
    <div id="delete_job_warning" class="modal_bg min-h-screen fixed top-0 z-40 w-full flex items-center justify-center px-5 hidden">
        <div class=" px-5 py-3 bg-white rounded-xl">
            <h2 class="text-xl sub_title_font font-semibold mb-2">Delete Job Posting?</h2>
            <p class="home_p_font text-gray-600 mb-5">This action cannot be undone. <br>Are you sure you want to delete this job posting?</p>

            <div class="flex gap-2">
                <button id="cancel_delete_job" type="button"
                    class="bg-[#1e2939] cursor-pointer sub_title_font text-blue-400 px-4 py-2 rounded-lg hover:bg-[#374151] max-sm:text-sm">
                    Cancel
                </button>

                <form id="delete_job_form" method="POST" class="inline">
                    @csrf
                    @method('DELETE')
                    <button type="submit" id="delete_job"
                        class="bg-[#1e2939] cursor-pointer sub_title_font text-red-400 px-4 py-2 rounded-lg hover:bg-[#374151] max-sm:text-sm">
                        Delete
                    </button>
                </form>
            </div>
        </div>
    </div>


    {{-- status modal --}}
    <div id="status_modal" class="modal_bg edit_job_modal fixed top-0 left-0 w-full h-full z-50 max-sm:px-6 px-10 hidden">
        <div class="sm:w-xl max-h-[80vh] overflow-y-auto mt-20 mx-auto p-5 max-sm:p-4 bg-gray-200 opacity-100 rounded-xl shadow-sm">
            {{-- modal header --}}
            <div class="flex justify-between items-center mb-2">
                <h3 class="sub_title_font max-sm:text-sm">Job Status</h3>
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" id="close_status_modal" class="size-5 cursor-pointer hover:bg-red-400! rounded-sm max-sm:size-5 bg-gray-300!">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M6 18 18 6M6 6l12 12" />
                </svg>
            </div>

            {{-- modal body --}}
            <div class="px-5 py-3 bg-white shadow-sm rounded-lg">
                <h1 class="p_font text-blue-500 mb-1">
                    Current Status: <span class="uppercase status_text"></span>
                </h1>
                <p class="home_p_font mb-3">Click a button below to change the job status.</p>

                <form id="status_form" action="" method="POST" class="flex gap-2 max-sm:flex-col max-sm:w-full max-lg:gap-2">
                    @csrf
                    @method('PUT')
                    <button type="submit" name="status" value="open" class="px-4 py-2 bg-green-500 rounded-lg text-white button_font hover:opacity-80 cursor-pointer">Open</button>
                    <button type="submit" name="status" value="close" class="px-3 py-2 bg-red-500 rounded-lg text-white button_font hover:opacity-80 cursor-pointer">Close</button>
                    <button type="submit" name="status" value="pause" class="px-3 py-2 bg-gray-500 rounded-lg text-white button_font hover:opacity-80 cursor-pointer">Pause</button>
                </form>
            </div>
        </div>
    </div>



    {{-- end of modals section--}}



    @include('components.footer_client')

    <script src="{{ asset('js/client.js') }}"></script>
@endsection