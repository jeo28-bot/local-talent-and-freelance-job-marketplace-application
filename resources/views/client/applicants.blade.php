@extends('layouts.app')

@section('body-class', 'bg-[#F0F0F0]')

@section('content')
    @include('components.nav_client')


    <!-- main content -->
    <section class="w-full flex min-h-[80vh] flex-col items-center  px-20 max-lg:px-10 max-sm:px-5 pt-10 max-lg:pt-5">
        <div class="xl:w-6xl  mx-auto px-5 max-sm:px-2 mb-10 w-full max-lg:px-0 ">
            <h1 class="sub_title sm:text-xl">Applicants</h1>
            <p class="home_p_font mb-5 text-sm">Manage and review freelancers who applied to your job postings.</p>

            
            {{-- no applicants yet --}}
            @if ($applications->isEmpty())
            <div class="w-full h-[300px] flex flex-col justify-center items-center border-2 border-dashed border-gray-400 rounded-lg mt-10 ">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-15 mb-2 text-gray-400">
                <path stroke-linecap="round" stroke-linejoin="round" d="M18 18.72a9.094 9.094 0 0 0 3.741-.479 3 3 0 0 0-4.682-2.72m.94 3.198.001.031c0 .225-.012.447-.037.666A11.944 11.944 0 0 1 12 21c-2.17 0-4.207-.576-5.963-1.584A6.062 6.062 0 0 1 6 18.719m12 0a5.971 5.971 0 0 0-.941-3.197m0 0A5.995 5.995 0 0 0 12 12.75a5.995 5.995 0 0 0-5.058 2.772m0 0a3 3 0 0 0-4.681 2.72 8.986 8.986 0 0 0 3.74.477m.94-3.197a5.971 5.971 0 0 0-.94 3.197M15 6.75a3 3 0 1 1-6 0 3 3 0 0 1 6 0Zm6 3a2.25 2.25 0 1 1-4.5 0 2.25 2.25 0 0 1 4.5 0Zm-13.5 0a2.25 2.25 0 1 1-4.5 0 2.25 2.25 0 0 1 4.5 0Z" />
                </svg>
                <p class="p_font text-gray-500 text-center p-5">No applicants yet. Check back later!</p>
            </div>
            @else

            {{-- table div --}}
            <div id="table_div" class="overflow-x-auto shadow-lg rounded-lg ">
            <table class="w-full min-w-[700px] shadow-lg rounded-lg overflow-hidden">
                <thead class="bg-gray-200 ">
                    <tr class="bg-gray-300">
                        <th class="px-4 py-2 text-left sub_title_font font-semibold! uppercase text-sm">User Name</th>
                        <th class="px-4 py-2 text-left sub_title_font font-semibold! uppercase text-sm">Full Name</th>
                        <th class="px-4 py-2 text-left sub_title_font font-semibold! uppercase text-sm">Job Title</th>
                        <th class="px-4 py-2 text-left sub_title_font font-semibold! uppercase text-sm">Application Date</th>
                        <th class="px-4 py-2 text-left sub_title_font font-semibold! uppercase text-sm">Status</th>
                        <th class="px-4 py-2 text-left sub_title_font font-semibold! uppercase text-sm">Actions</th>
                        <th class="px-4 py-2 text-left sub_title_font font-semibold! uppercase text-sm">View & Drop</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($applications as $application)
                    <tr class="border-b-2 border-gray-300 py-2 hover:bg-gray-200 ">
                        <td class="px-4 py-2 p_font max-lg:text-sm">
                            <a href="#" class="underline text-blue-700 hover:text-blue-400">
                                {{ $application->user ? $application->user->name : $application->full_name }}
                            </a>

                        </td>
                        <td class="px-4 py-2 p_font max-lg:text-sm capitalize">    
                                {{ $application->full_name }}
                        </td>
                        <td class="px-4 py-2 p_font max-lg:text-sm">
                            @if ($application->job)
                                <a href="{{ route('client.jobs.show', Str::slug($application->job->job_title)) }}" 
                                class="hover:underline text-blue-700 hover:text-blue-400">
                                    {{ $application->job->job_title }}
                                </a>
                            @else
                                N/A
                            @endif
                        </td>
                        <td class="px-4 py-2 p_font max-lg:text-sm ">
                            {{ $application->created_at->format('Y-m-d') }}
                        </td>
                        <td class="px-4 py-2 p_font text-sm 
                            {{ $application->status == 'pending' ? 'text-orange-600' : ($application->status == 'accepted' ? 'text-green-600' : 'text-red-600') }}">
                              <span class="p-2 bg-amber-50 rounded-lg {{ $application->status == 'pending' ? 'border-1 border-amber-600 bg-orange-200' : ($application->status == 'accepted' ? 'border-1 border-green-600 bg-green-200' : 'border-1 border-red-600 bg-red-200') }}">{{ ucfirst($application->status) }}</span>
                        </td>

                        <td class="px-4 py-2 p_font max-lg:text-sm capitalize flex max-xl:flex-col">
                           <form action="{{ route('applications.updateStatus', $application->id) }}" method="POST" class="inline">
                                @csrf
                                <input type="hidden" name="status" value="accepted">
                                <button type="submit" class="bg-[#1e2939] px-3 py-2 rounded mr-1 button_font text-sm text-green-400 cursor-pointer hover:opacity-80 max-[1280px]:w-full max-[1280px]:mb-1">Accept</button>
                            </form>

                            <form action="{{ route('applications.updateStatus', $application->id) }}" method="POST" class="inline">
                                @csrf
                                <input type="hidden" name="status" value="rejected">
                                <button type="submit" class="bg-[#1e2939] px-3 py-2 rounded button_font text-sm text-red-400 cursor-pointer hover:opacity-80 max-[1280px]:w-full">Reject</button>
                            </form>
                        </td>
                        <td class="px-4 py-2 p_font max-lg:text-sm">
                            <div class="flex gap-1">
                                    <button
                                    class="view_applicant_button bg-[#1e2939] p-2 rounded-lg cursor-pointer hover:opacity-70"
                                    data-username="{{ $application->user ? e($application->user->name) : e($application->full_name) }}"
                                    data-fullname="{{ e($application->full_name) }}"
                                    data-email="{{ e($application->email ?? 'N/A') }}"
                                    data-phone="{{ e($application->phone_num ?? 'N/A') }}"
                                    data-message="{{ e($application->message ?? 'No message provided') }}"
                                    data-status="{{ $application->status }}"
                                    >

                                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-5 text-green-500">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M2.036 12.322a1.012 1.012 0 0 1 0-.639C3.423 7.51 7.36 4.5 12 4.5c4.638 0 8.573 3.007 9.963 7.178.07.207.07.431 0 .639C20.577 16.49 16.64 19.5 12 19.5c-4.638 0-8.573-3.007-9.963-7.178Z" />
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 1 1-6 0 3 3 0 0 1 6 0Z" />
                                        </svg>
                                    </button>
                                    <form action="{{ route('applications.destroy', $application->id) }}" method="POST" class="delete-applicant-form">
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

                            </div>
                        </td>

                    </tr>
                    @endforeach
                    <!-- More rows as needed -->
                </tbody>
            </table>
            </div>
            @endif

            

        </div>
    </section>

    {{-- modal section --}}
    {{-- view applicant details modal --}}
    <div id="view_applicant" class="modal_bg fixed top-0 left-0 w-full h-full z-50 max-sm:px-6 max-lg:px-20 hidden">
      {{-- menu control --}}
        <div class="max-h-[80vh] overflow-y-auto lg:w-2xl mt-20 mx-auto p-5 max-sm:p-4 bg-gray-200 opacity-100 rounded-xl shadow-sm max-lg:mt-15">
            {{-- modal sub title and close button --}}
            <div class="flex justify-between items-center mb-2">
                <h3 class="sub_title_font max-sm:text-sm">Viewing Applicant Details</h3>
                <svg id="" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" id="close_quick_apply" class="close_view_applicant size-5 cursor-pointer  hover:bg-red-400! rounded-sm max-sm:size-4 bg-gray-300!">
                <path stroke-linecap="round" stroke-linejoin="round" d="M6 18 18 6M6 6l12 12" />
                </svg>
            </div>
             <div class="w-full bg-white p-3 rounded-lg shadow-sm ">

                <div class="input_control flex flex-col mb-1">
                    <label for="fullName" class="home_p_font text-black! max-sm:text-sm">
                        Username: <span id="applicant_username" class="text-blue-500 font-semibold!">—</span>
                    </label>
                </div>
                <div class="input_control flex flex-col mb-3">
                    <label for="fullName" class="home_p_font text-black! max-sm:text-sm">
                        Status: <span id="applicant_status" class="font-semibold p-1 rounded " >—</span>
                    </label>
                </div>

                <div class="input_control flex flex-col mb-3">
                    <label for="fullName" class="mb-1 home_p_font text-black! max-sm:text-sm">Full Name <span class="text-red-500">*</span></label>
                    <h3 id="applicant_fullname" class="capitalize text-lg sub_title_font p-2 bg-gray-200 rounded-lg max-sm:text-sm text-gray-800"></h3>
                </div>
                <div class="input_control flex flex-col mb-3">
                    <label for="email" class=" mb-1 home_p_font text-black! max-sm:text-sm">Email <span class="text-red-500">*</span></label>
                    <h3 id="applicant_email" class="text-lg sub_title_font p-2 bg-gray-200 rounded-lg max-sm:text-sm text-gray-800"></h3>
                </div>
                <div class="input_control flex flex-col mb-3 w-full">
                    <label for="phoneNum" class=" mb-1 home_p_font text-black! max-sm:text-sm">Phone Number <span class="text-red-500">*</span></label>
                    <h3 id="applicant_phone" class="text-lg sub_title_font p-2 bg-gray-200 rounded-lg max-sm:text-sm text-gray-800"></h3>
                </div>
                <div class="input_control flex flex-col mb-3 w-full">
                    <label for="message" class=" mb-1 home_p_font text-black! max-sm:text-sm">Message <span class="text-gray-400">(optional)</span></label>
                    <textarea id="applicant_message" rows="4" class="text-lg sub_title_font p-2 bg-gray-200 rounded-lg max-sm:text-sm text-gray-800" disabled></textarea>
                </div>
                
                <div class="flex">
                <button id="" class="close_view_applicant p_font cursor-pointer bg-[#1E2939] text-white px-7 py-3 max-sm:py-3 max-sm:px-5 rounded-lg hover:opacity-90 max-sm:text-sm text-center ml-auto">Close</button>
                </div>
             </div>
       </div>
    </div>


    {{-- delete modal warning --}}
    <div id="delete_job_warning" class="hidden modal_bg min-h-screen fixed top-0 z-40 w-full flex items-center justify-center px-5">
        <div class="px-5 py-3 bg-white rounded-xl -mt-20">
            <h2 class="text-xl sub_title_font font-semibold mb-2">Delete Applicant?</h2>
            <p class="home_p_font text-gray-600 mb-5">This action cannot be undone. <br>Are you sure you want to delete this applicant?</p>

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


    @include('components.footer_client')

    
    <script src="{{ asset('js/client.js') }}"></script>
    <script src="{{ asset('js/client/applicants.js') }}"></script>
@endsection