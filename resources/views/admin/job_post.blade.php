@extends('layouts.app')

@section('body-class', 'bg-[#F0F0F0]')

@section('content')
     @include('components.nav_admin')

     <!-- main content -->
    <section class="w-full  z-0">
        <div class="pt-35 max-sm:pt-25 pl-85 max-[1270px]:pl-75 max-lg:pl-7  pr-10 max-sm:pr-5 pb-15">
            {{-- padding top --}}
            {{-- title & sub title --}}
            <h1 class="home_p_font font-semibold! max-lg:text-sm text-lg">Job Posts</h1>
            <p class="home_p_font mb-5 text-sm">Manage and review system job posts.</p>
             {{-- export and search bar control div --}}
            <div class="flex justify-between max-sm:gap-3 mb-3 max-sm:flex-col-reverse">
                {{-- export to csv button --}}
                <div>
                    <form action="{{ route('admin.job_post.export') }}" method="GET">
                        {{-- keep the current search term if any --}}
                        <input type="hidden" name="search" value="{{ request('search') }}">
                        <button type="submit" 
                            class="p_font py-2 px-3 bg-[#1e2939] rounded-lg hover:opacity-70 cursor-pointer text-sm text-green-400 flex items-center gap-2 shadow-lg ">
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" 
                                stroke-width="1.5" stroke="currentColor" class="size-6">
                                <path stroke-linecap="round" stroke-linejoin="round" 
                                    d="M7.5 7.5h-.75A2.25 2.25 0 0 0 4.5 9.75v7.5a2.25 2.25 0 0 0 2.25 2.25h7.5a2.25 2.25 0 0 0 2.25-2.25v-7.5a2.25 2.25 0 0 0-2.25-2.25h-.75m-6 3.75 3 3m0 0 3-3m-3 3V1.5m6 9h.75a2.25 2.25 0 0 1 2.25 2.25v7.5a2.25 2.25 0 0 1-2.25 2.25h-7.5a2.25 2.25 0 0 1-2.25-2.25v-.75" />
                            </svg>
                            Export to CSV
                        </button>
                    </form>
                </div>

                {{-- search bar control --}}
                <form action="{{ route('admin.job_post') }}" method="GET" class="group">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                        stroke-width="1.5" stroke="currentColor"
                        class="size-6 absolute mt-2.5 ml-2 text-gray-500 -z-1 group-hover:z-10 group-focus-within:z-10 max-sm:mt-2">
                        <path stroke-linecap="round" stroke-linejoin="round" 
                                d="m21 21-5.197-5.197m0 0A7.5 7.5 0 1 0 5.196 5.196a7.5 7.5 0 0 0 10.607 10.607Z" />
                    </svg>

                    <input type="text" name="search" value="{{ request('search') }}"
                            class="pl-10 px-4 py-2 pr-20 p_font border-2 border-gray-400 rounded-lg max-sm:text-sm focus:outline-blue-400 max-sm:w-full"
                            placeholder="Search...">

                    <button type="submit"
                            class="px-2 py-1 bg-black text-white rounded-lg text-sm p_font hover:opacity-70 cursor-pointer absolute mt-2 -ml-19 max-sm:mt-1.5 max-sm:-ml-18 -z-1 group-hover:z-10 group-focus-within:z-10">
                        Search
                    </button>
                </form>


            </div> 
            {{--End of export and search bar control div --}}

            {{-- contents --}}
            {{-- cards --}}
            {{-- card section 1 --}}
            @if ($jobPosts->isNotEmpty())
             <div id="table_div" class="overflow-x-auto shadow-lg rounded-lg mb-5">
                <table class="w-full min-w-[700px] shadow-lg rounded-lg overflow-hidden">
                    <thead class="bg-gray-200 ">
                        <tr class="bg-gray-300 ">
                            <th class="px-4 py-2 text-left sub_title_font font-semibold! uppercase text-sm max-sm:text-xs">#</th>
                            <th class="px-4 py-2 text-left sub_title_font font-semibold! uppercase text-sm max-sm:text-xs">Job ID</th>
                            <th class="px-4 py-2 text-left sub_title_font font-semibold! uppercase text-sm max-sm:text-xs">Job Title</th>
                            <th class="px-4 py-2 text-left sub_title_font font-semibold! uppercase text-sm max-sm:text-xs">User<span class="text-gray-500">(Poster)</span></th>
                            <th class="px-4 py-2 text-left sub_title_font font-semibold! uppercase text-sm max-sm:text-xs">Location</th>
                            <th class="px-4 py-2 text-left sub_title_font font-semibold! uppercase text-sm max-sm:text-xs">Job-Type</th>
                            <th class="px-4 py-2 text-left sub_title_font font-semibold! uppercase text-sm max-sm:text-xs">Job-Pay</th>
                            <th class="px-4 py-2 text-left sub_title_font font-semibold! uppercase text-sm max-sm:text-xs">Salary Release</th>
                            <th class="px-4 py-2 text-left sub_title_font font-semibold! uppercase text-sm max-sm:text-xs">Status</th>
                            <th class="px-4 py-2 text-left sub_title_font font-semibold! uppercase text-sm max-sm:text-xs">Created-date</th>
                            <th class="px-4 py-2 text-left sub_title_font font-semibold! uppercase text-sm max-sm:text-xs">Archived</th>
                            <th class="px-4 py-2 text-left sub_title_font font-semibold! uppercase text-sm max-sm:text-xs">Actions</th>
                            <th class="px-4 py-2 text-left sub_title_font font-semibold! uppercase text-sm max-sm:text-xs"></th>
                        </tr>
                    </thead>

                    <tbody>
                        @foreach ($jobPosts as $index => $job)
                        <tr class="border-b-2 border-gray-300 py-2 hover:bg-gray-200">
                            <td class="px-4 py-2 p_font max-lg:text-sm home_p_font">
                                 {{ $jobPosts->firstItem() + $index }}
                            </td>
                            <td class="px-4 py-2 p_font max-lg:text-sm ">
                                <h1>{{ $job->id }}</h1>
                            </td>
                            <td class="px-4 py-2 p_font max-lg:text-sm w-50 break-words">
                                 <a href="{{ route('admin.jobs.show', ['title' => urlencode($job->job_title)]) }}" class="hover:underline text-blue-500 hover:text-blue-400 cursor-pointer">{{ $job->job_title }}</a>
                            </td>
                             <td class="px-4 py-2 p_font max-lg:text-sm ">
                                 <a href="{{ route('admin.public_profile', ['name' => urlencode($job->client->name)]) }}" class="hover:underline text-blue-500 hover:text-blue-400 cursor-pointer">{{ $job->client->name ?? 'N/A' }}</a>
                            </td>
                             <td class="px-4 py-2 p_font max-lg:text-sm ">
                                 <h1>{{ $job->job_location }}</h1>
                            </td>
                             <td class="px-4 py-2 p_font max-lg:text-sm capitalize">
                                 <h1>{{ $job->job_type }}</h1>
                            </td>
                             <td class="px-4 py-2 p_font max-lg:text-sm ">
                                 <h1>₱{{ number_format($job->job_pay, 2) }}</h1>
                            </td>
                             <td class="px-4 py-2 p_font max-lg:text-sm ">
                                 <h1>{{ ucfirst($job->salary_release) }}</h1>
                            </td>
                            <td class="px-4 py-2 p_font max-lg:text-sm ">
                                <button
                                data-id="{{ $job->id }}" 
                                data-status="{{ $job->status }}"
                                  class="open-status-modal cursor-pointer hover:opacity-60"><span class="
                                  @if($job->status === 'open')
                                        text-green-600! p-2 rounded-lg bg-green-200 border-1 border-green-500
                                    @elseif($job->status === 'pause')
                                        text-gray-600! p-2 rounded-lg bg-gray-300 border-1 border-gray-500
                                    @else
                                        text-red-600! p-2 rounded-lg bg-red-200 border-1 border-red-500
                                    @endif
                                  ">
                                    {{ ucfirst($job->status) }}
                                </span></h1>
                            </td>


                             <td class="px-4 py-2 p_font max-lg:text-sm ">
                                 <h1>{{ $job->created_at->format('M d, Y') }}</h1>
                            </td>
                            <td class="px-4 py-2 p_font max-lg:text-sm text-center ">
                                @if($job->deleted_at)
                                    <span class="badge bg-gray-300 border-1 border-gray-600 p_font px-2 py-1 rounded-full text-sm text-gray-600 font-semibold!">Archived</span>
                                @else
                                    <span class="badge bg-blue-300 border-1 border-blue-600 p_font px-2 py-1 rounded-full text-sm text-blue-600 font-semibold!">Active</span>
                                @endif
                            </td>
                             <td class="px-4 py-2 p_font max-lg:text-sm flex flex-col text-center">
                                <a href="{{ $job->deleted_at ? '#' : route('admin.jobs.show', ['title' => urlencode($job->job_title)]) }}" class="bg-[#1e2939] px-5 py-2 rounded mr-1 button_font text-sm text-green-400 cursor-pointer hover:opacity-80 mb-1
                                {{ $job->deleted_at 
                                ? 'text-gray-500 cursor-not-allowed opacity-50 pointer-events-none' 
                                : 'text-green-400 cursor-pointer hover:opacity-80' }} 
                                    ">
                                View
                                </a>
                                <button href=""  id="edit_job_button" class="edit_job_button job_posting_button bg-[#1e2939] px-5 py-2 rounded mr-1 button_font text-sm text-orange-400 cursor-pointer hover:opacity-80 mb-1" 
                                data-id="{{ $job->id }}"
                                data-title="{{ $job->job_title }}"
                                data-location="{{ $job->job_location }}"
                                data-type="{{ $job->job_type }}"
                                data-pay="{{ $job->job_pay }}"
                                data-salary="{{ $job->salary_release }}"
                                data-skills="{{ $job->skills_required }}"
                                data-short="{{ $job->short_description }}"
                                data-full="{{ $job->full_description }}">
                                Edit
                                </button>
                            </td>

                            <td class="pr-4 py-2 p_font max-lg:text-sm ">
                                <form action="{{ route('admin.job_post.destroy', $job->id) }}" method="POST" class="delete-job-form">
                                    @csrf
                                    @method('DELETE')
                                    <button type="button" class="open-delete-modal bg-[#1e2939] p-2 rounded-lg cursor-pointer hover:opacity-70">
                                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" 
                                            stroke-width="1.5" stroke="currentColor" class="size-5 text-red-500">
                                            <path stroke-linecap="round" stroke-linejoin="round"
                                                d="m14.74 9-.346 9m-4.788 0L9.26 9m9.968-3.21
                                                c.342.052.682.107 1.022.166m-1.022-.165L18.16 
                                                19.673a2.25 2.25 0 0 1-2.244 2.077H8.084
                                                a2.25 2.25 0 0 1-2.244-2.077L4.772 5.79
                                                m14.456 0a48.108 48.108 0 0 0-3.478-.397
                                                m-12 .562c.34-.059.68-.114 1.022-.165
                                                m0 0a48.11 48.11 0 0 1 3.478-.397m7.5 
                                                0v-.916c0-1.18-.91-2.164-2.09-2.201
                                                a51.964 51.964 0 0 0-3.32 0c-1.18.037
                                                -2.09 1.022-2.09 2.201v.916m7.5 
                                                0a48.667 48.667 0 0 0-7.5 0" />
                                        </svg>
                                    </button>
                                </form>
                            </td>
                            
                        </tr> 
                         @endforeach
                    </tbody>
                   

                </table>
             </div>
            {{-- end of card section 1 --}}

            @else
            {{-- no applied post yet --}}
            <div class="w-full h-[300px] flex flex-col justify-center items-center border-2 border-dashed border-gray-400 rounded-lg mt-10">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-15 mb-2 text-gray-400">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M18 18.72a9.094 9.094 0 0 0 3.741-.479 3 3 0 0 0-4.682-2.72m.94 3.198.001.031c0 .225-.012.447-.037.666A11.944 11.944 0 0 1 12 21c-2.17 0-4.207-.576-5.963-1.584A6.062 6.062 0 0 1 6 18.719m12 0a5.971 5.971 0 0 0-.941-3.197m0 0A5.995 5.995 0 0 0 12 12.75a5.995 5.995 0 0 0-5.058 2.772m0 0a3 3 0 0 0-4.681 2.72 8.986 8.986 0 0 0 3.74.477m.94-3.197a5.971 5.971 0 0 0-.94 3.197M15 6.75a3 3 0 1 1-6 0 3 3 0 0 1 6 0Zm6 3a2.25 2.25 0 1 1-4.5 0 2.25 2.25 0 0 1 4.5 0Zm-13.5 0a2.25 2.25 0 1 1-4.5 0 2.25 2.25 0 0 1 4.5 0Z" />
                </svg>
                <p class="p_font text-gray-500 text-center p-5">No Applied post yet. Check back later!</p>
            </div>
            @endif
            
            
            {{-- ✅ Custom Pagination --}}
            @if ($jobPosts->total() > 10)
                <div id="users_pagination" class="w-full mx-auto flex items-center max-sm:flex-col max-sm:items-center gap-2 mt-4">
                    <h3 class="home_p_font text-sm max-sm:text-xs">
                         {{ $jobPosts->firstItem() ?? 0 }} to {{ $jobPosts->lastItem() ?? 0 }} of {{ $jobPosts->total() ?? 0 }} results
                    </h3>

                    <div class="flex ml-auto gap-2 max-sm:ml-0">
                        {{-- Previous button --}}
                        @if ($jobPosts->onFirstPage())
                            <button disabled class="-z-1 cursor-not-allowed opacity-50 job_posting_button bg-[#1E2939] text-white px-5 py-2 rounded-lg text-sm">Previous</button>
                        @else
                            <a href="{{ $jobPosts->previousPageUrl() }}" class="job_posting_button bg-[#1E2939] text-white px-5 py-2 rounded-lg text-sm hover:opacity-90">Previous</a>
                        @endif

                        {{-- Next button --}}
                        @if ($jobPosts->hasMorePages())
                            <a href="{{ $jobPosts->nextPageUrl() }}" class="job_posting_button bg-[#1E2939] text-white px-5 py-2 rounded-lg text-sm hover:opacity-90">Next</a>
                        @else
                            <button disabled class="-z-1 cursor-not-allowed opacity-50 job_posting_button bg-[#1E2939] text-white px-5 py-2 rounded-lg text-sm">Next</button>
                        @endif
                    </div>
                </div>
            @endif
            {{-- end of pagination --}}


        </div>
        
    
    </section>

    {{-- modal section --}}

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
                <input type="submit" value="Save" class=" cursor-pointer bg-[#1E2939] text-white px-7 py-3 max-sm:py-3 max-sm:px-5 rounded-lg hover:opacity-90 max-sm:text-sm text-center ml-auto max-sm:w-full button_font" >
                </div>
             </form>
       </div>
    </div>


    {{-- delete modal warning --}}
    <div id="delete_job_warning" class="hidden modal_bg min-h-screen fixed top-0 z-40 w-full flex items-center justify-center px-5">
        <div class="px-5 py-3 bg-white rounded-xl -mt-20">
            <h2 class="text-xl sub_title_font font-semibold mb-2">Delete Job Post?</h2>
            <p class="home_p_font text-gray-600 mb-5">This action cannot be undone. <br>Are you sure you want to delete this job post?</p>

            <div class="flex gap-2">
                <button id="cancel_delete_applicant" type="button"
                    class="bg-[#1e2939] cursor-pointer sub_title_font text-blue-400 px-4 py-2 rounded-lg hover:bg-[#374151] max-sm:text-sm">
                    Cancel
                </button>
            
                <button type="button" id="delete_applicant"
                    class="bg-[#1e2939] cursor-pointer sub_title_font text-red-400 px-4 py-2 rounded-lg hover:bg-[#374151] max-sm:text-sm">
                    Delete
                </button>
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
    
    <script>
    document.addEventListener('DOMContentLoaded', () => {
        const modal = document.getElementById('status_modal');
        const closeModal = document.getElementById('close_status_modal');
        const statusText = document.querySelector('.status_text');
        const form = document.getElementById('status_form');

        // open modal
        document.querySelectorAll('.open-status-modal').forEach(button => {
            button.addEventListener('click', () => {
                const jobId = button.getAttribute('data-id');
                const currentStatus = button.getAttribute('data-status');

                statusText.textContent = currentStatus;
                form.action = `/admin/job-post/${jobId}/status`; // route we'll define next

                modal.classList.remove('hidden');
            });
        });

        // close modal
        closeModal.addEventListener('click', () => modal.classList.add('hidden'));

        // optional: close modal when clicking outside
        modal.addEventListener('click', (e) => {
            if (e.target === modal) modal.classList.add('hidden');
        });
    });
    </script>

    
    
    <script src="{{ asset('js/admin/job_post.js') }}"></script>
    <script src="{{ asset('js/admin/nav_admin.js') }}"></script>
@endsection