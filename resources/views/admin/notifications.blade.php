@extends('layouts.app')

@section('body-class', 'bg-[#F0F0F0]')

@section('content')
     @include('components.nav_admin')


    <!-- main content -->
    <section class="w-full  z-0">
        <div class="pt-35 max-sm:pt-25 pl-85 max-[1270px]:pl-75 max-lg:pl-7  pr-10 max-sm:pr-5 pb-15 w-full flex justify-center">
            {{-- padding top --}}
            {{-- control div --}}
                <div class="xl:w-4xl w-full">
                    {{-- export and search bar control div --}}
                    <div class="flex justify-between max-sm:gap-3 mb-3 max-sm:flex-col">
                        <div>
                            {{-- title & sub title --}}
                            <h1 class="home_p_font font-semibold! max-lg:text-sm text-lg">Notifications</h1>
                            <p class="home_p_font text-sm">Manage and review system notifications.</p>
                        </div>

                       

                    </div> 
                    {{--End of export and search bar control div --}}


                    {{-- show notifications --}}
                   

            {{-- Notification List --}}
            @forelse ($notifications as $note)
                    @php
                        // applicant → used for job application notifications
                        $applicantId = $note->data['applicant_id'] ?? null;

                        // employee → used for payout notifications
                        $employeeId = $note->data['employee_id'] ?? null;

                        // Decide which user to display
                        $userId = $applicantId ?: $employeeId;

                        $userData = $userId ? \App\Models\User::find($userId) : null;
                    @endphp

                <div id="notification-{{ $note->id }}" class="p_font flex items-center  bg-white py-3 px-5 shadow-md rounded-lg cursor-pointer hover:bg-gray-100 max-sm:px-3 mb-4 " >
                        <a href="{{ route('admin.notifications.open', $note->id) }}" class="">
                            {{-- unread indicator --}}
                            @if(!$note->is_read)
                                <div class="p-1.5 max-sm:p-1 bg-red-500 w-[5px] rounded-full -mt-2 -ml-2 max-sm:-mt-1 max-sm:-ml-1"></div>
                            @endif

                            <div class="flex items-start w-full">
                                <div class="flex-shrink-0 border-2 border-gray-300 rounded-full">
                                    <img src="{{ $userData && $userData->profile_pic
                                                ? asset('storage/' . $userData->profile_pic)
                                                : asset('assets/defaultUserPic.png') }}" 
                                    class="w-12 h-12 rounded-full max-sm:w-8 max-sm:h-8">
                                </div>

                                <div class="ml-4">
                                    <h3 class="text-lg font-semibold! text-gray-800 p_font max-sm:text-sm">{{ $note->title }}</h3>
                                    <p class="text-gray-600 mt-1 home_p_font text-sm max-sm:text-xs max-sm:pr-4">
                                        {!! nl2br(e($note->body)) !!}
                                    </p>
                                    <span class="text-xs text-gray-500 mt-2 block home_p_font">{{ $note->created_at->diffForHumans() }}</span>
                                </div>
                            </div>
                        </a>

                        <div class="relative -mt-20 ml-auto ">
                            {{-- Ellipse + dropdown OUTSIDE the <a> --}}
                            <button class="hover:bg-gray-200 p-1 absolute rounded-full top-0 right-4 toggle-dropdown">
                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-6">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M6.75 12a.75.75 0 1 1-1.5 0 .75.75 0 0 1 1.5 0ZM12.75 12a.75.75 0 1 1-1.5 0 .75.75 0 0 1 1.5 0ZM18.75 12a.75.75 0 1 1-1.5 0 .75.75 0 0 1 1.5 0Z" />
                                </svg>
                            </button>

                            <div class="bg-white p-2 absolute shadow-xl rounded-lg top-7 right-4  dropdown-menu border-2 border-gray-200 z-10 hidden">
                                <button class="text-sm max-sm:text-xs bg-gray-100 hover:bg-gray-200 p-2 rounded-lg text-red-500 delete-btn p_font" data-id="{{ $note->id }}">
                                    Delete
                                </button>
                            </div>
                        </div>

                    </div>

                    <script>
                        // Toggle dropdown functionality
                        const toggleButtons = document.querySelectorAll('.toggle-dropdown');

                        toggleButtons.forEach(btn => {
                            btn.addEventListener('click', (e) => {
                                e.stopPropagation(); // Prevent click from closing immediately

                                // Find the closest parent div and then the dropdown-menu inside it
                                const dropdown = btn.parentElement.querySelector('.dropdown-menu');

                                // Toggle the 'hidden' class
                                dropdown.classList.toggle('hidden');
                            });
                        });

                        // Click outside to close all dropdowns
                        document.addEventListener('click', () => {
                            document.querySelectorAll('.dropdown-menu').forEach(menu => {
                                if (!menu.classList.contains('hidden')) {
                                    menu.classList.add('hidden');
                                }
                            });
                        });

                        // DELETE notification inside dropdown
                        const deleteButtons = document.querySelectorAll('.delete-btn');

                        deleteButtons.forEach(btn => {
                            btn.addEventListener('click', (e) => {
                                e.stopPropagation(); // Prevent dropdown from closing

                                const noteId = btn.dataset.id;

                                if(confirm('Are you sure you want to delete this notification?')) {
                                    fetch(`/admin/notifications/${noteId}`, {
                                        method: 'DELETE',
                                        headers: {
                                            'X-CSRF-TOKEN': '{{ csrf_token() }}',
                                            'Accept': 'application/json',
                                            'Content-Type': 'application/json'
                                        }
                                    })
                                    .then(res => res.json())
                                    .then(data => {
                                        if(data.success) {
                                            // Remove the notification card from DOM
                                            btn.closest('.relative').remove();
                                            alert(data.message);
                                            location.reload(); // Refresh the page to update the notification list
                                        } else {
                                            alert(data.message);
                                        }
                                    })
                                    .catch(err => {
                                        console.error(err);
                                        alert('Something went wrong!');
                                    });
                                }
                            });
                        });
                    </script>


                 





            

                {{-- job post notification sample --}}
                <a href="#" class="flex bg-white p-4 cursor-pointer hover:bg-gray-100 max-sm:p-2 rounded-xl mb-4 shadow-sm hover:shadow-md transition-shadow duration-200 hidden">
                    {{-- unread indicator --}}
                    <div class="p-1.5 max-sm:p-1 bg-red-500 absolute rounded-full -mt-2 -ml-2 max-sm:-mt-1 max-sm:-ml-1"></div>
                    <div class="flex items-start">
                        <div class="flex-shrink-0">
                            <img src="{{asset('assets/defaultUserPic.png')}}" alt="Company Logo" class="w-12 h-12 rounded-full max-sm:w-8 max-sm:h-8">

                        </div>
                        <div class="ml-4">
                            <h3 class="text-lg font-semibold! text-gray-800 p_font max-sm:text-sm">Job Application</h3>
                            <p class="text-gray-600 mt-1 home_p_font text-sm max-sm:text-xs"><span class="text-blue-400 font-semibold!">Angeline Panhay</span> applied to your <span class="text-red-400 font-semibold!">Grpahic artist</span> job post.</p>
                            <span class="text-xs text-gray-500 mt-2 block home_p_font">2 hours ago</span>
                        </div>
                    </div>
                </a>

                {{-- Application notification sample --}}
                <a href="#" class="flex bg-white p-4 cursor-pointer hover:bg-gray-100 max-sm:p-2 rounded-xl mb-4 shadow-sm hover:shadow-md transition-shadow duration-200 hidden">
                    <div class="flex items-start">
                        <div class="flex-shrink-0">
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-10 max-sm:size-7 text-gray-600">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M14.857 17.082a23.848 23.848 0 0 0 5.454-1.31A8.967 8.967 0 0 1 18 9.75V9A6 6 0 0 0 6 9v.75a8.967 8.967 0 0 1-2.312 6.022c1.733.64 3.56 1.085 5.455 1.31m5.714 0a24.255 24.255 0 0 1-5.714 0m5.714 0a3 3 0 1 1-5.714 0" />
                            </svg>
                        </div>
                        <div class="ml-4">
                            <h3 class="text-lg font-semibold! text-gray-800 p_font max-sm:text-sm">Application Update</h3>
                            <p class="text-gray-600 mt-1 home_p_font text-sm max-sm:text-xs">Your application for the Software Engineer position at TechCorp has been viewed by the hiring manager.</p>
                            <span class="text-xs text-gray-500 mt-2 block home_p_font">2 hours ago</span>
                        </div>
                    </div>
                </a>

                @empty
                    {{-- No notification right now --}}
                    <div class="flex flex-col items-center justify-center py-10 text-center bg-gray-200 rounded-xl">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-16 h-16 text-gray-400 mb-4 max-sm:w-12 max-sm:h-12">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M14.857 17.082a23.848 23.848 0 0 0 5.454-1.31A8.967 8.967 0 0 1 18 9.75V9A6 6 0 0 0 6 9v.75a8.967 8.967 0 0 1-2.312 6.022c1.733.64 3.56 1.085 5.455 1.31m5.714 0a24.255 24.255 0 0 1-5.714 0m5.714 0a3 3 0 1 1-5.714 0M3.124 7.5A8.969 8.969 0 0 1 5.292 3m13.416 0a8.969 8.969 0 0 1 2.168 4.5" />
                        </svg>

                        <h2 class="text-xl font-semibold text-gray-800 sub_title_font max-sm:text-lg">No notification right now.</h2>
                        <p class="text-gray-500 mt-1 home_p_font max-sm:text-sm px-2">This is where we’ll notify you about your job applications and other useful information to help you with your job search.</p>
                    </div>
                @endforelse

                {{-- Custom Pagination --}}
                @if ($notifications->total() > 0)
                <div id="notification_pagination" class="w-full mx-auto flex items-center max-sm:flex-col max-sm:items-center gap-2">

                    <h3 class="home_p_font text-sm max-sm:text-xs">
                        {{ $notifications->firstItem() }} to {{ $notifications->lastItem() }} of {{ $notifications->total() }} results
                    </h3>

                    <div class="flex ml-auto gap-2 max-sm:ml-0">

                        {{-- Previous button --}}
                        @if ($notifications->onFirstPage())
                            <button disabled
                                class="cursor-not-allowed opacity-50 bg-[#1E2939] text-white px-5 py-2 rounded-lg text-sm p_font -z-1 ">
                                Previous
                            </button>
                        @else
                            <a href="{{ $notifications->previousPageUrl() }}"
                                class="bg-[#1E2939] text-white px-5 py-2 rounded-lg text-sm p_font">
                                Previous
                            </a>
                        @endif


                        {{-- Next button --}}
                        @if ($notifications->hasMorePages())
                            <a href="{{ $notifications->nextPageUrl() }}"
                                class="bg-[#1E2939] text-white px-5 py-2 rounded-lg text-sm p_font">
                                Next
                            </a>
                        @else
                            <button disabled
                                class="cursor-not-allowed opacity-50 bg-[#1E2939] text-white px-5 py-2 rounded-lg text-sm p_font -z-1 ">
                                Next
                            </button>
                        @endif

                    </div>
                </div>
                @endif


                
                </div>
        </div>
    </section>

        
    
    <script src="{{ asset('js/admin/nav_admin.js') }}"></script>
    <script src="{{ asset('js/admin/applications.js') }}"></script>
@endsection
 
