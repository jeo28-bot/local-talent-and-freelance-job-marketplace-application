@extends('layouts.app')

@section('body-class', 'bg-[#F0F0F0]')

@section('content')
     @include('components.nav_admin')


    <!-- main content -->
    <section class="w-full  z-0">
        <div class="pt-35 pl-85 max-[1270px]:pl-75 max-lg:pl-7  pr-10 max-sm:pr-5 pb-15">
            {{-- padding top --}}
            {{-- title & sub title --}}
            <h1 class="home_p_font font-semibold! max-lg:text-sm text-lg">Applications</h1>
            <p class="home_p_font mb-5 text-sm">Manage and review system applications.</p>
             {{-- export and search bar control div --}}
            <div class="flex justify-between max-sm:gap-3 mb-3 max-sm:flex-col-reverse">
                {{-- export to csv button --}}
                <div>
                    <form action="{{ route('admin.applications.export') }}" method="GET">
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
                <form action="{{ route('admin.applications') }}" method="GET" class="group">
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
             @if ($applications->isNotEmpty())
             <div id="table_div" class="overflow-x-auto shadow-lg rounded-lg mb-5">
                <table class="w-full min-w-[700px] shadow-lg rounded-lg overflow-hidden">
                    <thead class="bg-gray-200 ">
                        <tr class="bg-gray-300 ">
                            <th class="px-4 py-2 text-left sub_title_font font-semibold! uppercase text-sm max-sm:text-xs">#</th>
                            <th class="px-4 py-2 text-left sub_title_font font-semibold! uppercase text-sm max-sm:text-xs">User Name</th>
                            <th class="px-4 py-2 text-left sub_title_font font-semibold! uppercase text-sm max-sm:text-xs">Job Title</th>
                            <th class="px-4 py-2 text-left sub_title_font font-semibold! uppercase text-sm max-sm:text-xs">Full Name</th>
                            <th class="px-4 py-2 text-left sub_title_font font-semibold! uppercase text-sm max-sm:text-xs">Email</th>
                            <th class="px-4 py-2 text-left sub_title_font font-semibold! uppercase text-sm max-sm:text-xs">Phone #</th>
                            <th class="px-4 py-2 text-left sub_title_font font-semibold! uppercase text-sm max-sm:text-xs">Applied Date</th>
                            <th class="px-4 py-2 text-left sub_title_font font-semibold! uppercase text-sm max-sm:text-xs">Status</th>
                            <th class="px-4 py-2 text-left sub_title_font font-semibold! uppercase text-sm max-sm:text-xs">Actions</th>
                        </tr>
                    </thead>
                   
                    <tbody>
                         @forelse ($applications as $application)
                        <tr class="border-b-2 border-gray-300 py-2 hover:bg-gray-200 ">
                            <td class="px-4 py-2 p_font max-lg:text-sm home_p_font">
                                {{ $loop->iteration + ($applications->currentPage() - 1) * $applications->perPage() }}
                            </td>
                            <td class="px-4 py-2 p_font max-lg:text-sm">
                                @if ($application->user)
                                    <a href="{{ route('admin.public_profile', ['name' => urlencode($application->user->name)]) }}" 
                                    class="hover:underline text-blue-500 hover:text-blue-400">
                                        {{ $application->user->name }}
                                    </a>
                                @else
                                    <span class="text-gray-500">Unknown User (ID: {{ $application->user_id }})</span>
                                @endif
                            </td>


                            <td class="px-4 py-2 p_font max-lg:text-sm">
                                <a href="{{ route('admin.jobs.show', ['title' => urlencode($application->job->job_title ?? 'Unknown')]) }}" 
                                class="hover:underline text-blue-500 hover:text-blue-400">
                                {{ $application->job ? $application->job->job_title : 'Unknown Job (ID: '.$application->job_id.')' }}
                                </a>
                            </td>
                            <td class="px-4 py-2 p_font max-lg:text-sm capitalize">
                                {{ $application->full_name }}
                            </td>
                            <td class="px-4 py-2 p_font max-lg:text-sm">
                                {{ $application->email }}
                            </td>

                            <td class="px-4 py-2 p_font max-lg:text-sm">
                                {{ $application->phone_num }}
                            </td>
                            <td class="px-4 py-2 p_font max-lg:text-sm">
                                 {{ $application->created_at->format('M d, Y') }}
                            </td>
                            <td class="px-4 py-2 p_font max-lg:text-sm capitalize">
                                <span class="p-2 rounded-lg border-1 
                                    @if($application->status === 'pending') text-orange-600  bg-orange-200  border-orange-500
                                    @elseif($application->status === 'accepted') text-green-600 bg-green-200  border-green-500
                                    @elseif($application->status === 'rejected') text-red-600 bg-red-200  border-red-500
                                    @elseif($application->status === 'cancelled') text-gray-600 bg-gray-200  border-gray-500
                                    @endif">
                                    {{ $application->status }}
                                 </span>
                            </td>
                            <td class="px-4 py-2 p_font max-lg:text-sm flex flex-col text-center">
                                   <button href=""  class="view_applicant_button bg-[#1e2939] px-5 py-2 rounded mr-1 button_font text-sm text-green-400 cursor-pointer hover:opacity-80 mb-1"
                                   data-username="{{ $application->user ? e($application->user->name) : e($application->full_name) }}"
                                    data-fullname="{{ e($application->full_name) }}"
                                    data-email="{{ e($application->email ?? 'N/A') }}"
                                    data-phone="{{ e($application->phone_num ?? 'N/A') }}"
                                    data-message="{{ e($application->message ?? 'No message provided') }}"
                                    data-status="{{ $application->status }}">
                                    View
                                   </button>

                                   <form action="{{ route('applications.destroy', $application->id) }}" method="POST" class="delete-applicant-form px-3 py-2 bg-[#1e2939]  rounded mr-1">
                                        @csrf
                                        @method('DELETE')
                                        <button href="" class="open-delete-modal button_font text-sm text-red-400 cursor-pointer hover:opacity-80">
                                            Delete
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
                        <div class="w-full h-[300px] flex flex-col justify-center items-center border-2 border-dashed border-gray-400 rounded-lg mt-1">
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-15 mb-2 text-gray-400">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M18 18.72a9.094 9.094 0 0 0 3.741-.479 3 3 0 0 0-4.682-2.72m.94 3.198.001.031c0 .225-.012.447-.037.666A11.944 11.944 0 0 1 12 21c-2.17 0-4.207-.576-5.963-1.584A6.062 6.062 0 0 1 6 18.719m12 0a5.971 5.971 0 0 0-.941-3.197m0 0A5.995 5.995 0 0 0 12 12.75a5.995 5.995 0 0 0-5.058 2.772m0 0a3 3 0 0 0-4.681 2.72 8.986 8.986 0 0 0 3.74.477m.94-3.197a5.971 5.971 0 0 0-.94 3.197M15 6.75a3 3 0 1 1-6 0 3 3 0 0 1 6 0Zm6 3a2.25 2.25 0 1 1-4.5 0 2.25 2.25 0 0 1 4.5 0Zm-13.5 0a2.25 2.25 0 1 1-4.5 0 2.25 2.25 0 0 1 4.5 0Z" />
                            </svg>
                            <p class="p_font text-gray-500 text-center p-5">No applicants yet. Check back later!</p>
                        </div>
                         @endforelse



            {{-- Custom Pagination --}}
            @if ($applications->total() > 10)
                <div id="posting_pagination" class="w-full mx-auto flex items-center max-sm:flex-col max-sm:items-center gap-2">
                    <h3 class="home_p_font text-sm max-sm:text-xs">
                        Showing {{ $applications->firstItem() ?? 0 }} to {{ $applications->lastItem() ?? 0 }} of {{ $applications->total() ?? 0 }} results
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
            {{-- ene of pagination --}}


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
    


    

    
    <script src="{{ asset('js/admin/nav_admin.js') }}"></script>
    <script src="{{ asset('js/admin/applications.js') }}"></script>
@endsection
 