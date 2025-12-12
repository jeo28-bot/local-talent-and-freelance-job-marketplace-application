@extends('layouts.app')

@section('body-class', 'bg-[#F0F0F0]')

@section('content')
    @include('components.nav_employee')


    <!-- main content -->
    <section class="w-full flex min-h-[80vh] flex-col items-center  px-20 max-lg:px-10 max-sm:px-5 pt-10 max-lg:pt-5 mb-20">
        <div class="xl:w-6xl  mx-auto px-5 max-sm:px-2 mb-10 w-full max-lg:px-0 ">
            <div class="flex items-center justify-between max-lg:flex-col max-lg:gap-2 max-xl:items-start max-xl:mb-4 mb-5">
                <div>
                    <h1 class="sub_title sm:text-xl">Job Applied</h1>
                    <p class="home_p_font text-sm">Manage and review your applied job postings.</p>
                </div>

                {{-- search input div --}}
                <div class="ml-auto max-lg:w-sm max-sm:w-full">
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="size-6 absolute mt-2 max-sm:mt-2 ml-2 max-sm:size-5 max-sm:ml-1.5">
                    <path fill-rule="evenodd" d="M10.5 3.75a6.75 6.75 0 1 0 0 13.5 6.75 6.75 0 0 0 0-13.5ZM2.25 10.5a8.25 8.25 0 1 1 14.59 5.28l4.69 4.69a.75.75 0 1 1-1.06 1.06l-4.69-4.69A8.25 8.25 0 0 1 2.25 10.5Z" clip-rule="evenodd" />
                    </svg>
                    {{-- search inputs --}}
                    <form action="{{ route('employee.applied') }}" method="GET" class="bg-white max-sm:w-full shadow-sm rounded-lg w-sm p_font max-sm:text-sm flex items-center">
                            {{-- input 1 job title, skills, company --}}
                            <input type="text" name="q" value="{{ request('q') }}"  value="" class="  pl-10 max-sm:pl-7 py-2 rounded-lg p_font max-sm:text-sm w-sm max-lg:w-full" placeholder="Search job title, users, status">
                            
                        <button class=" p_font px-2 py-1 bg-[#1e2939] rounded-lg text-sm cursor-pointer text-white hover:opacity-80 ml-2 mr-2">Search</button>
                    </form>
                </div>


            </div>


           
            @if($applications->isNotEmpty())
            <div id="table_div" class="overflow-x-auto shadow-lg rounded-lg mb-5">
                <table class="w-full min-w-[700px] shadow-lg rounded-lg overflow-hidden">
                    <thead class="bg-gray-200 ">
                        <tr class="bg-gray-300">
                            <th class="px-4 py-2 text-left sub_title_font font-semibold! uppercase text-sm"></th>
                            <th class="px-4 py-2 text-left sub_title_font font-semibold! uppercase text-sm  max-sm:text-xs">Application ID</th>
                            {{-- <th class="px-4 py-2 text-left sub_title_font font-semibold! uppercase text-sm">User Name</th> --}}
                            <th class="px-4 py-2 text-left sub_title_font font-semibold! uppercase text-sm">Full Name</th>
                            <th class="px-4 py-2 text-left sub_title_font font-semibold! uppercase text-sm">Job Title</th>
                            <th class="px-4 py-2 text-left sub_title_font font-semibold! uppercase text-sm">Application Date</th>
                            <th class="px-4 py-2 text-left sub_title_font font-semibold! uppercase text-sm">Status</th>
                            <th class="px-4 py-2 text-left sub_title_font font-semibold! uppercase text-sm">Actions</th>
                            <th class="px-4 py-2 text-left sub_title_font font-semibold! uppercase text-sm"></th>
                        </tr>
                    </thead>

                    <tbody>
                        @foreach($applications as $application)
                            <tr class="border-b-2 border-gray-300 py-2 hover:bg-gray-200 ">
                                <td class="px-4 py-2 p_font max-lg:text-sm home_p_font">
                                    {{ $loop->iteration + ($applications->currentPage() - 1) * $applications->perPage() }}
                                </td>
                                <td class="px-4 py-2 p_font max-lg:text-sm capitalize">    
                                    {{ '2025'.$application->id }}
                                </td>
                                {{-- <td class="px-4 py-2 p_font max-lg:text-sm">
                                    <a href="{{ route('employee.public_profile', $application->user->name) }}" class="hover:underline text-blue-700 hover:text-blue-400">
                                        {{ $application->user ? $application->user->name : 'N/A' }}
                                    </a>
                                </td> --}}
                                <td class="px-4 py-2 p_font max-lg:text-sm capitalize">
                                    <a href="{{ route('employee.public_profile', $application->user->name) }}" class="hover:underline text-blue-700 hover:text-blue-400">
                                        {{ $application->full_name ? $application->full_name : 'N/A' }}
                                    </a>    
                                </td>
                                <td class="px-4 py-2 p_font max-lg:text-sm capitalize">    
                                    @if ($application->job)
                                        <a href="{{ route('employee.jobs.show', Str::slug($application->job->job_title)) }}" 
                                        class="hover:underline text-blue-700 hover:text-blue-400">
                                            {{ $application->job->job_title }}
                                        </a>
                                    @else
                                        N/A
                                    @endif
                                </td>
                                <td class="px-4 py-2 p_font max-lg:text-sm capitalize">    
                                    {{ $application->created_at->format('Y-m-d') }}
                                </td>
                                <td class="px-4 py-2 p_font text-sm 
                                    {{ $application->status == 'pending' ? 'text-orange-600' 
                                        : ($application->status == 'accepted' ? 'text-green-600' 
                                        : ($application->status == 'rejected' ? 'text-red-600' 
                                        : 'text-black')) }}">    

                                    <span class="p-2 rounded-lg 
                                        {{ $application->status == 'pending' ? 'border-1 border-amber-600 bg-orange-200' 
                                            : ($application->status == 'accepted' ? 'border-1 border-green-600 bg-green-200' 
                                            : ($application->status == 'rejected' ? 'border-1 border-red-600 bg-red-200' 
                                            : 'border-1 border-black bg-gray-300')) }}">
                                        {{ ucfirst($application->status) }}
                                    </span>
                                </td>

                                <td class="px-4 py-2 p_font max-lg:text-sm capitalize flex max-lg:flex-col max-xl:flex-col"> 
                                    <button type="button" 
                                        class="open-view-applied bg-[#1e2939] px-5 py-2 rounded mr-1 button_font text-sm text-green-400 cursor-pointer hover:opacity-80 max-[1210px]:w-full max-[1210px]:mb-1 mb-1"
                                        data-fullname="{{ $application->full_name }}"
                                        data-email="{{ $application->email }}"
                                        data-phone="{{ $application->phone_num }}"
                                        data-message="{{ $application->message }}">
                                        View
                                    </button>
                                   <form method="POST" class="inline">
                                        @csrf
                                        @method('PATCH')
                                        <button type="button" 
                                            class="open_cancel_application_modal bg-[#1e2939] px-3 py-2 rounded button_font text-sm text-red-400 cursor-pointer hover:opacity-80 max-[1210px]:w-full"
                                            data-id="{{ $application->id }}">
                                            Cancel
                                        </button>
                                    </form>
                                </td>
                                <td class="px-5">
                                    <button type="button" 
                                        class="open-delete-job-applied-modal bg-[#1e2939] p-2 rounded-lg cursor-pointer hover:opacity-70" 
                                        data-id="{{ $application->id }}">
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
        @else
            {{-- no applicants yet --}}
            <div class="w-full h-[300px] flex flex-col justify-center items-center border-2 border-dashed border-gray-400 rounded-lg mt-10">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-15 mb-2 text-gray-400">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M18 18.72a9.094 9.094 0 0 0 3.741-.479 3 3 0 0 0-4.682-2.72m.94 3.198.001.031c0 .225-.012.447-.037.666A11.944 11.944 0 0 1 12 21c-2.17 0-4.207-.576-5.963-1.584A6.062 6.062 0 0 1 6 18.719m12 0a5.971 5.971 0 0 0-.941-3.197m0 0A5.995 5.995 0 0 0 12 12.75a5.995 5.995 0 0 0-5.058 2.772m0 0a3 3 0 0 0-4.681 2.72 8.986 8.986 0 0 0 3.74.477m.94-3.197a5.971 5.971 0 0 0-.94 3.197M15 6.75a3 3 0 1 1-6 0 3 3 0 0 1 6 0Zm6 3a2.25 2.25 0 1 1-4.5 0 2.25 2.25 0 0 1 4.5 0Zm-13.5 0a2.25 2.25 0 1 1-4.5 0 2.25 2.25 0 0 1 4.5 0Z" />
                </svg>
                <p class="p_font text-gray-500 text-center p-5">No applicants yet. Check back later!</p>
            </div>
        @endif

        {{-- Custom Pagination --}}
        @if ($applications->total() > 10)
            <div id="posting_pagination" class="w-full mx-auto flex items-center max-sm:flex-col max-sm:items-center gap-2">
                <h3 class="home_p_font text-sm max-sm:text-xs">
                    {{ $applications->firstItem() ?? 0 }} to {{ $applications->lastItem() ?? 0 }} of {{ $applications->total() ?? 0 }} results
                </h3>

                <div class="flex ml-auto gap-2 max-sm:ml-0">
                    {{-- Previous button --}}
                    @if ($applications->onFirstPage())
                        <button disabled class="cursor-not-allowed opacity-50 job_posting_button bg-[#1E2939] text-white px-5 py-2 max-sm:py-2 max-sm:px-5 rounded-lg text-sm max-sm:text-xs">Previous</button>
                    @else
                        <a href="{{ $applications->previousPageUrl() }}" class="job_posting_button bg-[#1E2939] text-white px-5 py-2 max-sm:py-2 max-sm:px-5 rounded-lg text-sm max-sm:text-xs">Previous</a>
                    @endif

                    {{-- Next button --}}
                    @if ($applications->hasMorePages())
                        <a href="{{ $applications->nextPageUrl() }}" class="job_posting_button bg-[#1E2939] text-white px-5 py-2 max-sm:py-2 max-sm:px-5 rounded-lg hover:opacity-90 text-sm max-sm:text-xs">Next</a>
                    @else
                        <button disabled class="cursor-not-allowed opacity-50 job_posting_button bg-[#1E2939] text-white px-5 py-2 max-sm:py-2 max-sm:px-5 rounded-lg text-sm max-sm:text-xs">Next</button>
                    @endif
                </div>
            </div>
        @endif


        </div>
    </section>



    {{-- modals --}}
    
    {{-- view applied modal --}}
        <div id="view_applied_modal" class="modal_bg fixed top-0 left-0 w-full h-full z-50 max-sm:px-6 hidden">
            <div class="sm:w-2xl mt-20 mx-auto p-5 max-sm:p-4 bg-gray-200 rounded-xl shadow-sm">
                {{-- modal sub title and close button --}}
                <div class="flex justify-between items-center mb-2">
                    <h3 class="sub_title_font max-sm:text-sm">Your details for this job.</h3>
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                        stroke="currentColor" id="close_view_applied" 
                        class="close_applied_modal size-5 cursor-pointer hover:bg-red-400! rounded-sm max-sm:size-4 bg-gray-300!">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M6 18 18 6M6 6l12 12" />
                    </svg>
                </div>
                <form class="w-full bg-white p-3 rounded-lg shadow-sm">
                    <span class="hidden">
                        <div class="input_control flex flex-col mb-3">
                            <label for="modalFullName" class="mb-1 home_p_font text-black! max-sm:text-sm">Full Name *</label>
                            <input type="text" id="modalFullName" class="p-2 border-2 border-gray-400 rounded-lg max-sm:text-sm bg-gray-200" disabled>
                        </div>
                        <div class="input_control flex flex-col mb-3">
                            <label for="modalEmail" class="mb-1 home_p_font text-black! max-sm:text-sm">Your Email *</label>
                            <input type="email" id="modalEmail" class="p-2 border-2 border-gray-400 rounded-lg max-sm:text-sm bg-gray-200" disabled>
                        </div>
                        <div class="input_control flex flex-col mb-3">
                            <label for="modalPhoneNum" class="mb-1 home_p_font text-black! max-sm:text-sm">Your Phone Number *</label>
                            <input type="number" id="modalPhoneNum" class="p-2 w-full border-2 border-gray-400 rounded-lg max-sm:text-sm bg-gray-200" disabled>
                        </div>
                    </span>
                    <div class="input_control flex flex-col mb-3">
                        <label for="modalMessage" class="mb-1 home_p_font text-black! max-sm:text-sm">Message</label>
                        <textarea id="modalMessage" class="p-2 w-full border-2 border-gray-400 rounded-lg max-sm:text-sm bg-gray-200" disabled></textarea>
                    </div>
                    <div class="flex">
                        <button type="button" id="close_view_applied_btn"
                            class="close_applied_modal p_font cursor-pointer bg-[#1E2939] text-white px-7 py-3 rounded-lg hover:opacity-90 max-sm:text-sm text-center ml-auto">
                            Close
                        </button>
                    </div>
                </form>
            </div>
        </div>


     {{-- cancel application modal warning --}}
        <div id="cancel_application_modal" class="modal_bg min-h-screen fixed top-0 z-40 w-full flex items-center justify-center px-5 hidden">
            <div class=" px-5 py-3 bg-white rounded-xl">
                <h2 class="text-xl sub_title_font font-semibold mb-2">Cancel job application?</h2>
                <p class="home_p_font text-gray-600 mb-5">This action cannot be undone. <br>Are you sure you want to cancel this job application?</p>

                <div class="flex gap-2">
                    <button id="close_cancel_application_button" type="button"
                        class="bg-[#1e2939] cursor-pointer sub_title_font text-blue-400 px-4 py-2 rounded-lg hover:bg-[#374151] max-sm:text-sm">
                        No
                    </button>

                    <form id="confirm_cancel_application_form" method="POST" class="inline">
                        @csrf
                        @method('PATCH')
                        <button type="submit" id="confirm_cancel_application_button"
                            class="bg-[#1e2939] cursor-pointer sub_title_font text-red-400 px-4 py-2 rounded-lg hover:bg-[#374151] max-sm:text-sm">
                            Yes
                        </button>
                    </form>

                </div>
            </div>
        </div>

     {{-- delete job applied modal warning --}}
        <div id="delete_job_applied_warning" class="modal_bg min-h-screen fixed top-0 z-40 w-full flex items-center justify-center px-5 hidden">
            <div class="px-5 py-3 bg-white rounded-xl -mt-20">
                <h2 class="text-xl sub_title_font font-semibold mb-2">Delete this job applied row?</h2>
                <p class="home_p_font text-gray-600 mb-5">
                    This action cannot be undone. <br>
                    Are you sure you want to delete this job applied row?
                </p>

                <div class="flex gap-2">
                    <button id="cancel_delete_applied_button" type="button"
                        class="bg-[#1e2939] cursor-pointer sub_title_font text-blue-400 px-4 py-2 rounded-lg hover:bg-[#374151] max-sm:text-sm">
                        Cancel
                    </button>

                    <form id="confirm_delete_applied_form" method="POST">
                        @csrf
                        @method('DELETE')
                        <button type="submit" id="confirm_delete_applied_button"
                            class="bg-[#1e2939] cursor-pointer sub_title_font text-red-400 px-4 py-2 rounded-lg hover:bg-[#374151] max-sm:text-sm">
                            Delete
                        </button>
                    </form>
                </div>
            </div>
        </div>




    @include('components.footer_employee')

    
    <script src="{{ asset('js/employee.js') }}"></script>
    <script src="{{ asset('js/employee/applied.js') }}"></script>
@endsection