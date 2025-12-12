@extends('layouts.app')

@section('body-class', 'bg-[#F0F0F0] ')

@section('content')
    @include('components.nav_employee')


    <section class="w-ful min-h-[80vh] px-10 py-10 max-sm:py-5 max-sm:px-4 ">
        <div class="xl:w-6xl mx-auto px-5 max-sm:px-3 mb-10">
            <h1 class="sub_title sm:text-xl">Notifications</h1>
            <p class="home_p_font mb-5 text-sm">All your chats with clients and companies are organized here.</p>

            {{-- ANNOUNCEMENTS --}}
            @foreach ($announcements as $ann)
                <div id="announcement-{{ $ann->id }}" class="relative announcement-item "
                    data-title="{{ $ann->title }}"
                    data-message="{{ $ann->message }}"
                    data-date="{{ $ann->release_date }}">
                    <div class="flex bg-white p-4 cursor-pointer hover:bg-gray-100 max-sm:p-2 rounded-xl mb-4 shadow-sm hover:shadow-md transition-shadow duration-200 border-2 border-red-300">

                        <div class="p-1.5 max-sm:p-1 bg-red-500 absolute rounded-full -mt-2 -ml-2 max-sm:-mt-1 max-sm:-ml-1"></div>

                        <div class="flex items-start w-full">
                            <div class="flex-shrink-0 border-2 border-gray-300 rounded-full">
                                <img src="{{ asset('assets/megaphone.png') }}"
                                    class="w-12 h-12 rounded-full max-sm:w-8 max-sm:h-8">
                            </div>

                            <div class="ml-4">
                                <h3 class="text-lg font-semibold text-gray-800 p_font max-sm:text-sm">
                                    {{ $ann->title }}
                                </h3>

                                <p class="text-gray-600 mt-1 home_p_font text-sm max-sm:text-xs max-sm:pr-4">
                                    {{ strlen($ann->message) > 100 ? substr($ann->message, 0, 100).'...' : $ann->message }}
                                </p>

                                <span class="text-xs text-gray-500 mt-2 block home_p_font">
                                    {{ \Carbon\Carbon::parse($ann->release_date)->diffForHumans() }}
                                </span>
                            </div>
                        </div>
                    </div>

                    <button class="hover:bg-gray-200 p-1 rounded-full absolute top-4 right-4 ">
                        📌
                    </button>
                </div>
            @endforeach

        


            

            {{-- job status notification --}}
            @foreach ($notifications as $note)
                @php
                    // Ensure data is array
                    $noteData = is_array($note->data) ? $note->data : json_decode($note->data, true);
                    $clientId = $noteData['client_id'] ?? null;
                    $applicationId = $noteData['application_id'] ?? null;
                    // Fetch client safely
                    $client = $clientId ? \App\Models\User::find($clientId) : null;
                @endphp

    
            <div class="relative" id="notification-{{ $note->id }}">
                <a href="{{ route('employee.notification.open', ['id' => $note->id]) }}"
                class="flex bg-white p-4 cursor-pointer hover:bg-gray-100 max-sm:p-2 rounded-xl mb-4 shadow-sm hover:shadow-md transition-shadow duration-200">

                    {{-- unread indicator --}}
                    @if (!$note->is_read)
                    <div class="p-1.5 max-sm:p-1 bg-red-500 absolute rounded-full -mt-2 -ml-2 max-sm:-mt-1 max-sm:-ml-1"></div>
                    @endif


                    <div class="flex items-start w-full">
                        <div class="flex-shrink-0 border-2 border-gray-300 rounded-full">
                            <img src="{{ $client && $client->profile_pic 
                        ? asset('storage/' . $client->profile_pic) 
                        : asset('assets/defaultUserPic.png') }}" alt="Client Profile Picture"
                            class="w-12 h-12 rounded-full max-sm:w-8 max-sm:h-8">
                        </div>

                        <div class="ml-4">
                            <h3 class="text-lg font-semibold! text-gray-800 p_font max-sm:text-sm">Job Application</h3>
                            <p class="text-gray-600 mt-1 home_p_font text-sm max-sm:text-xs max-sm:pr-4">
                                {{ $note->body }}
                            </p>
                            <span class="text-xs text-gray-500 mt-2 block home_p_font"> {{ $note->created_at->diffForHumans() }}</span>
                        </div>
                    </div>
                </a>

                {{-- Ellipse + dropdown OUTSIDE the <a> --}}
                <button class="hover:bg-gray-200 p-1 rounded-full absolute top-4 right-4 toggle-dropdown">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-6">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M6.75 12a.75.75 0 1 1-1.5 0 .75.75 0 0 1 1.5 0ZM12.75 12a.75.75 0 1 1-1.5 0 .75.75 0 0 1 1.5 0ZM18.75 12a.75.75 0 1 1-1.5 0 .75.75 0 0 1 1.5 0Z" />
                    </svg>
                </button>

                <div class="bg-white p-2 shadow-xl rounded-lg absolute top-12 right-4 hidden dropdown-menu border-2 border-gray-200 z-10">
                    <button class="text-sm max-sm:text-xs bg-gray-100 hover:bg-gray-200 p-2 rounded-lg text-red-500 delete-btn p_font" data-id="{{ $note->id }}">
                        Delete
                    </button>
                </div>

            </div>
            @endforeach

            

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
                            class="cursor-not-allowed opacity-50 bg-[#1E2939] text-white px-5 py-2 rounded-lg text-sm p_font">
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
                            class="cursor-not-allowed opacity-50 bg-[#1E2939] text-white px-5 py-2 rounded-lg text-sm p_font">
                            Next
                        </button>
                    @endif

                </div>
            </div>
            @endif

            {{-- Saved Jobs no saved job yet message --}}
            <div class="flex flex-col items-center justify-center py-10 text-center bg-gray-200 rounded-xl px-10 hidden">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-16 h-16 text-gray-400 mb-4">
                <path stroke-linecap="round" stroke-linejoin="round" d="M14.857 17.082a23.848 23.848 0 0 0 5.454-1.31A8.967 8.967 0 0 1 18 9.75V9A6 6 0 0 0 6 9v.75a8.967 8.967 0 0 1-2.312 6.022c1.733.64 3.56 1.085 5.455 1.31m5.714 0a24.255 24.255 0 0 1-5.714 0m5.714 0a3 3 0 1 1-5.714 0M3.124 7.5A8.969 8.969 0 0 1 5.292 3m13.416 0a8.969 8.969 0 0 1 2.168 4.5" />
                </svg>

                <h2 class="text-xl font-semibold text-gray-800 sub_title_font">No notification right now.</h2>
                <p class="text-gray-500 mt-1 home_p_font">This is where we’ll notify you about your job applications and other useful information to help you with your job search.</p>
            </div>


        </div>
        
    </section>

     {{-- modal section --}}

    {{-- announcement modal --}}
    <div id="announcement_modal" class=" modal_bg min-h-screen fixed top-0 z-40 w-full flex items-center justify-center px-5 hidden">
        <div class="px-5 py-3 bg-white rounded-xl -mt-20 w-lg">
            <h2 class="text-xl sub_title_font font-semibold mb-2 flex items-center gap-2 max-sm:text-sm text-blue-500">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" aria-hidden="true" data-slot="icon" class="size-6 max-sm:size-5">
                <path stroke-linecap="round" stroke-linejoin="round" d="M10.34 15.84c-.688-.06-1.386-.09-2.09-.09H7.5a4.5 4.5 0 1 1 0-9h.75c.704 0 1.402-.03 2.09-.09m0 9.18c.253.962.584 1.892.985 2.783.247.55.06 1.21-.463 1.511l-.657.38c-.551.318-1.26.117-1.527-.461a20.845 20.845 0 0 1-1.44-4.282m3.102.069a18.03 18.03 0 0 1-.59-4.59c0-1.586.205-3.124.59-4.59m0 9.18a23.848 23.848 0 0 1 8.835 2.535M10.34 6.66a23.847 23.847 0 0 0 8.835-2.535m0 0A23.74 23.74 0 0 0 18.795 3m.38 1.125a23.91 23.91 0 0 1 1.014 5.395m-1.014 8.855c-.118.38-.245.754-.38 1.125m.38-1.125a23.91 23.91 0 0 0 1.014-5.395m0-3.46c.495.413.811 1.035.811 1.73 0 .695-.316 1.317-.811 1.73m0-3.46a24.347 24.347 0 0 1 0 3.46"></path>
                </svg>
                Announcement!

                <button class="ml-auto cursor-pointer p-1 rounded-lg hover:bg-gray-200">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" aria-hidden="true" data-slot="icon" class="size-5 max-sm:size-4 " id="close_announcement_modal_top">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M6 18 18 6M6 6l12 12"></path>
                    </svg>
                </button>
            </h2>
            <h3 class="p_font font-semibold! max-sm:text-sm text-lg mb-2">
                System Update Scheduled (title)
            </h3>
            <p class="p_font text-gray-600 mb-2 max-sm:text-sm">Lorem, ipsum dolor sit amet consectetur adipisicing elit. Illo distinctio repellendus velit fugiat, esse recusandae laborum ullam consequatur laboriosam rerum voluptatem maiores vitae expedita accusamus blanditiis autem rem ipsa pariatur. (messages)</p>
            <h5 class="mb-4 home_p_font text-sm max-sm:text-xs">Dec 20, 2025(date)</h5>


            <button type="button" id="close_announcement_modal_bottom"
                class="bg-[#1e2939] cursor-pointer sub_title_font text-blue-400 px-4 py-2 rounded-lg hover:bg-[#374151] max-sm:text-sm flex ml-auto">
                Close
            </button>

        </div>
    </div>

    {{-- delete modal warning --}}
    <div id="delete_job_warning" class="hidden modal_bg min-h-screen fixed top-0 z-40 w-full flex items-center justify-center px-5">
        <div class="px-5 py-3 bg-white rounded-xl -mt-20">
            <h2 class="text-xl sub_title_font font-semibold mb-2">Delete this notification?</h2>
            <p class="home_p_font text-gray-600 mb-4">This action cannot be undone. <br>Are you sure you want to delete this?</p>

            <!-- Form -->
            <form id="delete_form" method="POST" action="">
                @csrf
                @method('DELETE')
                <input type="hidden" name="notification_id" id="notification_id_input">

                <div class="flex gap-2">
                    <button type="button" id="cancel_delete"
                        class="bg-[#1e2939] cursor-pointer sub_title_font text-blue-400 px-4 py-2 rounded-lg hover:bg-[#374151] max-sm:text-sm">
                        Cancel
                    </button>
                
                    <button type="submit"
                        class="bg-[#1e2939] cursor-pointer sub_title_font text-red-400 px-4 py-2 rounded-lg hover:bg-[#374151] max-sm:text-sm">
                        Delete
                    </button>
                </div>
            </form>
        </div>
    </div>

    {{-- Script section --}}

    {{-- announcement modal JS --}}
    <script>
        document.addEventListener("DOMContentLoaded", () => {
        const modal = document.getElementById("announcement_modal");
        const titleEl = modal.querySelector("h3");
        const messageEl = modal.querySelector("p");
        const dateEl = modal.querySelector("h5");

        const closeBtns = [
            document.getElementById("close_announcement_modal_top"),
            document.getElementById("close_announcement_modal_bottom")
        ];

        document.querySelectorAll(".announcement-item").forEach(item => {
            item.addEventListener("click", () => {
                titleEl.textContent = item.dataset.title;
                messageEl.textContent = item.dataset.message;
                dateEl.textContent = new Date(item.dataset.date).toLocaleDateString('en-US', {
                    year: 'numeric', month: 'short', day: 'numeric'
                });

                modal.classList.remove("hidden");
            });
        });

        closeBtns.forEach(btn => {
            btn.addEventListener("click", () => {
                modal.classList.add("hidden");
            });
        });
    });
    </script>
    
    {{-- delete notification --}}
    <script>
    document.addEventListener("DOMContentLoaded", () => {
        let deleteId = null;

        // Open modal
        document.querySelectorAll(".delete-btn").forEach(btn => {
            btn.addEventListener("click", e => {
                e.stopPropagation();
                deleteId = btn.getAttribute("data-id");

                // Show modal
                document.getElementById("delete_job_warning").classList.remove("hidden");

                // Set form action
                const form = document.getElementById("delete_form");
                form.action = `/employee/notifications/delete/${deleteId}`;

                // Optional: show ID for debugging
                document.getElementById("notification_id_input").value = deleteId;
            });
        });

        // Cancel button
        document.getElementById("cancel_delete").addEventListener("click", () => {
            document.getElementById("delete_job_warning").classList.add("hidden");
            deleteId = null;
        });
    });
    </script>



    {{-- dropdown JS delete --}}
    <script>
        document.addEventListener('DOMContentLoaded', () => {
            document.querySelectorAll('.toggle-dropdown').forEach(btn => {
                btn.addEventListener('click', (e) => {
                    e.stopPropagation(); // prevent closing when clicking inside
                    const dropdown = btn.nextElementSibling;
                    dropdown.classList.toggle('hidden');
                });
            });

            // Close all dropdowns if clicked outside
            document.addEventListener('click', () => {
                document.querySelectorAll('.dropdown-menu').forEach(menu => {
                    menu.classList.add('hidden');
                });
            });
        });
    </script>

           
@include('components.footer_employee')
    
    
@endsection