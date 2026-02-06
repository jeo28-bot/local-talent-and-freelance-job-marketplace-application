@extends('layouts.app')

@section('body-class', 'bg-[#F0F0F0]')

@section('content')
    @include('components.nav_client')
    

    <!-- main content -->
    <section class="w-full flex min-h-[80vh] flex-col items-center  px-20 max-lg:px-10 max-sm:px-5 max-sm:pt-5 pt-10">
        <div class="xl:w-6xl max-xl:w-full mx-auto px-5 max-sm:px-1 mb-10">
            <div class="flex items-center justify-between max-xl:flex-col max-xl:items-start max-xl:mb-3 mb-2">
                <div>
                    <h1 class="sub_title sm:text-xl">Archived Job Posting</h1>
                    <p class="home_p_font mb-2 text-sm">Easily post your job openings and reach top candidates.</p>
                </div>

                {{-- search input div --}}
                <div class="max-xl:w-full ml-auto">
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="size-6 absolute mt-2 max-sm:mt-2 ml-2 max-sm:size-5 max-sm:ml-1.5">
                    <path fill-rule="evenodd" d="M10.5 3.75a6.75 6.75 0 1 0 0 13.5 6.75 6.75 0 0 0 0-13.5ZM2.25 10.5a8.25 8.25 0 1 1 14.59 5.28l4.69 4.69a.75.75 0 1 1-1.06 1.06l-4.69-4.69A8.25 8.25 0 0 1 2.25 10.5Z" clip-rule="evenodd" />
                    </svg>
                    {{-- search inputs --}}
                    <form action="{{ route('client.arch_jobs') }}" method="GET" class="bg-white  shadow-sm rounded-lg max-xl:w-full p_font pr-2 max-sm:text-sm flex items-center">
                            {{-- input 1 job title, skills, company --}}
                            <input type="text" name="q" value="{{ request('q') }}" class=" max-xl:w-full pl-10 max-sm:pl-7 py-2  pr-5 rounded-lg p_font max-sm:text-sm" placeholder="Search job title, users, status">
                            
                            <span class="w-[1px] h-[30px] bg-gray-500 opacity-50"></span>
                        
                         
                        <div class="max-xl:w-full">
                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-6 xl:hidden absolute mt-2 max-sm:mt-2 ml-2 max-sm:ml-1 max-sm:size-5">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M15 10.5a3 3 0 1 1-6 0 3 3 0 0 1 6 0Z" />
                                <path stroke-linecap="round" stroke-linejoin="round" d="M19.5 10.5c0 7.142-7.5 11.25-7.5 11.25S4.5 17.642 4.5 10.5a7.5 7.5 0 1 1 15 0Z" />
                                </svg>
                                {{-- input 2 more on loction --}}
                                <input type="text" name="location" value="{{ request('location') }}" class="max-xl:pl-10 max-xl:w-full pl-3 py-2 max-sm:pl-7 rounded-lg p_font max-sm:text-sm" placeholder="Remote, address, zone, block">
                        </div>
                    
                        <button class=" p_font px-2 py-1 bg-[#1e2939] rounded-lg text-sm cursor-pointer text-white hover:opacity-80 ml-2">
                            Search
                        </button>
                    </form>

                </div>
            </div>

            {{-- no applicants yet --}}
            @if ($archivedJobs->isEmpty())
            <div class="w-full h-[300px] flex flex-col justify-center items-center border-2 border-dashed border-gray-400 rounded-lg mt-1">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" aria-hidden="true" data-slot="icon" class="size-15 mb-2 text-gray-400 max-sm:size-10">
                <path stroke-linecap="round" stroke-linejoin="round" d="m20.25 7.5-.625 10.632a2.25 2.25 0 0 1-2.247 2.118H6.622a2.25 2.25 0 0 1-2.247-2.118L3.75 7.5M10 11.25h4M3.375 7.5h17.25c.621 0 1.125-.504 1.125-1.125v-1.5c0-.621-.504-1.125-1.125-1.125H3.375c-.621 0-1.125.504-1.125 1.125v1.5c0 .621.504 1.125 1.125 1.125Z"></path>
                </svg>
                <p class="p_font text-gray-500 text-center p-5 max-sm:text-sm">No archived jobs yet. Check back later!</p>
            </div>
            @else


            {{-- table div --}}
            <div id="applicants_table" id="table_div" class="overflow-x-auto shadow-lg rounded-lg  mb-5">
                <table class="w-full min-w-[700px] shadow-lg rounded-lg overflow-hidden">
                    <thead class="bg-gray-200 ">
                        <tr class="bg-gray-300">
                            <th class="px-4 py-2 text-left sub_title_font font-semibold! uppercase text-sm max-sm:text-xs"></th>
                            <th class="px-4 py-2 text-left sub_title_font font-semibold! uppercase text-sm  max-sm:text-xs">Job ID</th>
                            <th class="px-4 py-2 text-left sub_title_font font-semibold! uppercase text-sm  max-sm:text-xs">Job Title</th>
                            <th class="px-4 py-2 text-left sub_title_font font-semibold! uppercase text-sm max-sm:text-xs">Job Location</th>
                            <th class="px-4 py-2 text-left sub_title_font font-semibold! uppercase text-sm max-sm:text-xs">Archived Date</th>
                            <th class="px-4 py-2 text-left sub_title_font font-semibold! uppercase text-sm max-sm:text-xs">Status</th>
                            <th class="px-4 py-2 text-left sub_title_font font-semibold! uppercase text-sm max-sm:text-xs">Actions</th>
                            <th class="px-4 py-2 text-left sub_title_font font-semibold! uppercase text-sm max-sm:text-xs">Drop</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($archivedJobs as $index => $job)
                        <tr  class="applicant_row border-b-2 border-gray-300 py-2 hover:bg-gray-200 ">
                            <td class="px-4 py-2 p_font max-lg:text-sm home_p_font">
                                {{ $loop->iteration + ($archivedJobs->currentPage() - 1) * $archivedJobs->perPage() }}
                            </td>
                            <td class="px-4 py-2 p_font max-lg:text-sm capitalize">    
                                {{ $job->id }}
                            </td>
                            <td class="px-4 py-2 p_font max-lg:text-sm">
                                <span href="" class="font-semibold">
                                    {{ $job->job_title  }}
                                </span>
                            </td>
                            <td class="px-4 py-2 p_font max-lg:text-sm">
                                 {{ $job->job_location  }}
                            </td>
                            <td class="px-4 py-2 p_font max-lg:text-sm ">
                                {{ $job->deleted_at->format('Y-m-d') }}
                            </td>
                            <td class="px-4 py-2 p_font text-sm 
                                ">
                                <span class="px-2 py-1 rounded-full bg-gray-300 text-gray-500 font-semibold">
                                    archived
                                </span>
                            </td>
                            <td class="px-4 py-2 p_font max-lg:text-sm capitalize flex max-xl:flex-col">
                                <button href="" id="edit_job_button" class="edit_job_button bg-[#1e2939] px-3 py-2 rounded mr-1 button_font text-sm text-blue-400 cursor-pointer hover:opacity-80 max-[1280px]:w-full max-[1280px]:mb-1"
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
                                <form action="{{ route('client.restore_archived_job', $job->id) }}" method="POST">
                                    @csrf
                                    @method('PUT')
                                    <button class="bg-[#1e2939] px-3 py-2 rounded button_font text-sm text-yellow-400 cursor-pointer hover:opacity-80 max-[1280px]:w-full">
                                        Restore
                                    </button>
                                </form>
                            </td>
                            <td class="px-4 py-2 p_font max-lg:text-sm">
                                <button type="button" class="delete_job_button delete_job_button open-delete-modal bg-[#1e2939] p-2 rounded-lg cursor-pointer hover:opacity-70" data-id="{{ $job->id }}">
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
                            </td>

                        </tr>
                        @endforeach
                           
                    </tbody>
                   
                </table>
            </div>
            @endif

            {{-- Custom Pagination --}}
            @if ($archivedJobs->total() > 10)
                <div id="posting_pagination" class="w-full mx-auto flex items-center max-sm:flex-col max-sm:items-center gap-2">
                    <h3 class="home_p_font text-sm max-sm:text-xs">
                         {{ $archivedJobs->firstItem() ?? 0 }} to {{ $archivedJobs->lastItem() ?? 0 }} of {{ $archivedJobs->total() ?? 0 }} results
                    </h3>

                    <div class="flex ml-auto gap-2 max-sm:ml-0">
                        {{-- Previous button --}}
                        @if ($archivedJobs->onFirstPage())
                            <button disabled class="cursor-not-allowed opacity-50 job_posting_button bg-[#1E2939] text-white px-5 py-2 max-sm:py-2 max-sm:px-5 rounded-lg text-sm max-sm:text-xs">Previous</button>
                        @else
                            <a href="{{ $archivedJobs->previousPageUrl() }}" class="job_posting_button bg-[#1E2939] text-white px-5 py-2 max-sm:py-2 max-sm:px-5 rounded-lg text-sm max-sm:text-xs">Previous</a>
                        @endif

                        {{-- Next button --}}
                        @if ($archivedJobs->hasMorePages())
                            <a href="{{ $archivedJobs->nextPageUrl() }}" class="job_posting_button bg-[#1E2939] text-white px-5 py-2 max-sm:py-2 max-sm:px-5 rounded-lg hover:opacity-90 text-sm max-sm:text-xs">Next</a>
                        @else
                            <button disabled class="cursor-not-allowed opacity-50 job_posting_button bg-[#1E2939] text-white px-5 py-2 max-sm:py-2 max-sm:px-5 rounded-lg text-sm max-sm:text-xs">Next</button>
                        @endif
                    </div>
                </div>
            @endif


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
             <form id="editJobForm" method="POST" class="w-full bg-white p-3 rounded-lg shadow-sm ">
              @csrf
              @method('PUT') <!-- important for Laravel to treat this as PUT -->
              <input type="hidden" name="job_id" id="job_id">
                {{-- form fields --}}
                <div class="input_control flex max-sm:flex-col gap-3 mb-3">
                    <div class="input_group flex flex-col w-full">
                        <label for="job_title" class="mb-1 home_p_font text-black! max-sm:text-sm">Job Title <span class="text-red-500">*</span></label>
                        <input type="text" id="job_title" name="job_title" placeholder="Enter specific job title" class="p-2 border-2 border-gray-400 rounded-lg max-sm:text-sm" required>
                    </div>
                    <div class="input_group flex flex-col w-full">
                        <label for="job_location" class="mb-1 home_p_font text-black! max-sm:text-sm">Location <span class="home_p_font">(address)</span> <span class="text-red-500">*</span></label>
                        <input type="text" id="job_location" name="job_location" placeholder="Enter complete job location" class="p-2 border-2 border-gray-400 rounded-lg max-sm:text-sm" required>
                    </div>
                </div>

                <div class="input_control flex max-sm:flex-col gap-3 mb-3">
                    <div class="input_group flex flex-col w-full">
                        <label for="job_type" class="mb-1 home_p_font text-black! max-sm:text-sm">Job Type <span class="text-red-500">*</span></label>  
                        <select name="job_type" id="job_type" class="p-2 border-2 border-gray-400 rounded-lg max-sm:text-sm capitalize p_font" required>
                            <option value="" disabled selected>Select job type</option>
                            <option value="part-time">part-time</option>
                            <option value="contractual">contractual</option>
                            <option value="temporary">temporary</option>
                            <option value="internship">internship</option>
                            <option value="full-time">full-time</option>
                        </select>

                        
                    </div>
                    <div class="input_group flex flex-col w-full">
                        <label for="job_pay" class="mb-1 home_p_font text-black! max-sm:text-sm">Salary <span class="text-red-500">*</span></label>
                        <input type="number" id="job_pay" name="job_pay" placeholder="₱0.00" class="p-2 border-2 border-gray-400 rounded-lg max-sm:text-sm" required>
                    </div>
                </div>

                <div class="input_control flex flex-col gap-3 mb-3 ">
                    <div class="input_group flex flex-col w-full">
                        <label for="salary_release" class="mb-1 home_p_font text-black! max-sm:text-sm">Salary Release <span class="text-red-500">*</span></label>
                        <select name="salary_release" id="salary_release" class="p-2 border-2 border-gray-400 rounded-lg max-sm:text-sm capitalize p_font" required>
                            <option value="" disabled selected>Select salary release</option>
                            <option value="weekly">weekly</option>
                            <option value="bi-weekly">bi-weekly</option>
                            <option value="monthly">monthly</option>
                            <option value="per-project">per-project</option>
                        </select>

                        
                    </div>
                    <div class="input_group flex flex-col w-full">
                        <label for="skills_required" class="mb-1 home_p_font text-black! max-sm:text-sm">Skills required <span class="text-red-500">*</span> <br><span class="home_p_font text-xs">Separate skills using comma (,)</span></label>
                        <input type="text" id="skills_required" name="skills_required" placeholder="e.g. VA, HR, Data Entry" class="p-2 border-2 border-gray-400 rounded-lg max-sm:text-sm" required>
                    </div>
                </div>

                <div class="input_control flex flex-col gap-3 mb-3 ">
                    <div class="input_group flex flex-col w-full">
                        <label for="short_description" class="mb-1 home_p_font text-black! max-sm:text-sm">Short Job Description <span class="text-red-500">*</span></label>
                        <textarea id="short_description" name="short_description" rows="2" placeholder="Provide a short job summary that will appear on the job card." class="p-2 border-2 border-gray-400 rounded-lg max-sm:text-sm" required></textarea>
                    </div>
                </div>

                <div class="input_control flex flex-col gap-3 mb-3 ">
                    <div class="input_group flex flex-col w-full">
                        <label for="full_description" class="mb-1 home_p_font text-black! max-sm:text-sm">Full Job Description <span class="text-red-500">*</span></label>
                        <textarea id="full_description" name="full_description" rows="4" placeholder="Provide detailed information about the job role, responsibilities, and requirements." class="p-2 border-2 border-gray-400 rounded-lg max-sm:text-sm" required></textarea>
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
    <div id="delete_warning" class="modal_bg min-h-screen fixed top-0 z-40 w-full flex items-center justify-center px-5 hidden">
        <div class=" px-5 py-3 bg-white rounded-xl">
            <h2 class="text-xl sub_title_font font-semibold mb-2">Delete Job Posting?</h2>
            <p class="home_p_font text-gray-600 mb-3">
                This job posting will be deleted <br>permanently and cannot be restored.
            </p>

            <div class="flex gap-2">
                <button id="cancel_delete" type="button"
                    class="bg-[#1e2939] cursor-pointer sub_title_font text-blue-400 px-4 py-2 rounded-lg hover:bg-[#374151] max-sm:text-sm">
                    Cancel
                </button>

                <form id="delete_form" method="POST" class="inline">
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


        @include('components.footer_client')

    {{-- script section --}}

    {{-- edit modal script --}}
    <script>
        // grab the modal
        const editJobModal = document.querySelector('.edit_job_modal');

        // grab all edit buttons (USE CLASS, NOT ID)
        const editButtons = document.querySelectorAll('.edit_job_button');

        const closeModal = document.getElementById('close_edit_job');
        const form = document.getElementById('editJobForm');

        editButtons.forEach(button => {
            button.addEventListener('click', function () {
                const jobId = this.dataset.id;

                // set form action dynamically
                form.action = `/client/archived/arch_jobs/${jobId}`;

                // fill modal fields
                document.getElementById('job_id').value = jobId;
                document.getElementById('job_title').value = this.dataset.title;
                document.getElementById('job_location').value = this.dataset.location;
                document.getElementById('job_type').value = this.dataset.type;
                document.getElementById('job_pay').value = this.dataset.pay;
                document.getElementById('salary_release').value = this.dataset.salary;
                document.getElementById('skills_required').value = this.dataset.skills;
                document.getElementById('short_description').value = this.dataset.short;
                document.getElementById('full_description').value = this.dataset.full;

                // show modal
                editJobModal.classList.remove('hidden');
            });
        });

        closeModal.addEventListener('click', () => {
            editJobModal.classList.add('hidden');
        });
    </script>


    {{-- delete modal script --}}
    <script>
    document.querySelectorAll('.delete_job_button').forEach(button => {
        button.addEventListener('click', () => {
            const jobId = button.dataset.id;

            const form = document.getElementById('delete_form');
            form.action = `/client/archived/arch_jobs/${jobId}/delete`;

            document.getElementById('delete_warning').classList.remove('hidden');
        });
    });

    document.getElementById('cancel_delete').addEventListener('click', () => {
        document.getElementById('delete_warning').classList.add('hidden');
    });
    </script>


@endsection
                