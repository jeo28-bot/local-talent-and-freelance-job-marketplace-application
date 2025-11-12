@extends('layouts.app')

@section('body-class', 'bg-[#F0F0F0]')

@section('content')
     @include('components.nav_admin')


    <!-- main content -->
    <section class="w-full  z-0">
        <div class="pt-35 max-sm:pt-25 pl-85 max-[1270px]:pl-75 max-lg:pl-7  pr-10 max-sm:pr-5 pb-15">
            {{-- padding top --}}
            {{-- title & sub title --}}
            <h1 class="home_p_font font-semibold! max-lg:text-sm text-lg">Reports</h1>
            <p class="home_p_font mb-5 text-sm">Manage and review system reports.</p>
            {{-- export and search bar control div --}}
            <div class="flex justify-between max-sm:gap-3 mb-3 max-sm:flex-col-reverse">
                {{-- export to csv button --}}
                <div>
                    <form action="{{ route('admin.reports.export') }}" method="GET">
                        {{-- Keep current search term if any --}}
                        <input type="hidden" name="search" value="{{ request('search') }}">
                        
                        <button type="submit" 
                            class="p_font py-2 px-3 bg-[#1e2939] rounded-lg hover:opacity-70 cursor-pointer text-sm text-green-400 flex items-center gap-2 shadow-lg">
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
                <form action="{{ route('admin.reports') }}" method="GET" class="group">
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
            @if($reports->isNotEmpty())
            <div id="table_div" class="overflow-x-auto shadow-lg rounded-lg mb-5">
                <table class="w-full min-w-[700px] shadow-lg rounded-lg overflow-hidden">
                    <thead class="bg-gray-200 ">
                        <tr class="bg-gray-300 ">
                            <th class="px-4 py-2 text-left sub_title_font font-semibold! uppercase text-sm max-sm:text-xs">#</th>
                            <th class="px-4 py-2 text-left sub_title_font font-semibold! uppercase text-sm max-sm:text-xs">Report ID</th>
                            <th class="px-4 py-2 text-left sub_title_font font-semibold! uppercase text-sm max-sm:text-xs">Report Type</th>
                            <th class="px-4 py-2 text-left sub_title_font font-semibold! uppercase text-sm max-sm:text-xs">Reported Entity</th>
                            <th class="px-4 py-2 text-left sub_title_font font-semibold! uppercase text-sm max-sm:text-xs">Reported By</th>
                            <th class="px-4 py-2 text-left sub_title_font font-semibold! uppercase text-sm max-sm:text-xs">Message</th>
                            <th class="px-4 py-2 text-left sub_title_font font-semibold! uppercase text-sm max-sm:text-xs">Reported At</th>
                            <th class="px-4 py-2 text-left sub_title_font font-semibold! uppercase text-sm max-sm:text-xs">Actions</th>
                        </tr>
                    </thead>
                   
                    <tbody>
                        @foreach($reports as $index => $report)
                        <tr class="border-b-2 border-gray-300 py-2 hover:bg-gray-200">
                            <td class="px-4 py-2 home_p_font max-lg:text-sm p_font">
                                {{ $reports->firstItem() + $index }}
                            </td>
                            <td class="px-4 py-2 p_font max-lg:text-sm">
                                {{'2025'. $report->id }}
                            </td>
                            <td class="px-4 py-2 p_font max-lg:text-sm">
                                @php
                                    $type = class_basename($report->reportable_type);
                                @endphp

                                @if($type === 'User')
                                    <span class="p-2 bg-green-300 border border-green-500 rounded-lg text-green-700">
                                        {{ $type }}
                                    </span>
                                @elseif($type === 'JobPost')
                                    <span class="p-2 bg-orange-300 border border-orange-500 rounded-lg text-orange-700">
                                        {{ $type }}
                                    </span>
                                @else
                                    <span class="p-2 bg-gray-300 border border-gray-500 rounded-lg text-gray-700">
                                        {{ $type }}
                                    </span>
                                @endif
                            </td>
                            <td class="px-4 py-2 p_font max-lg:text-sm">
                                @if($report->reportable)
                                    @php
                                        $type = class_basename($report->reportable_type);
                                    @endphp

                                    @if($type === 'User')
                                        <a href="{{ route('admin.public_profile', ['name' => urlencode($report->reportable->name)]) }}" class="cursor-pointer text-blue-500 hover:underline">
                                            {{ $report->reportable->name }}
                                        </a>
                                    @elseif($type === 'JobPost')
                                        <a href="{{ url('/admin/jobs/' . urlencode($report->reportable->job_title ?? 'Job #' . $report->reportable_id)) }}" class="cursor-pointer text-blue-500 hover:underline">
                                            {{ $report->reportable->job_title ?? 'Job #' . $report->reportable_id }}
                                        </a>
                                    @else
                                        <span class="p-2 bg-gray-300 border border-gray-500 rounded-lg text-gray-700">
                                            {{ $report->reportable_id }}
                                        </span>
                                    @endif
                                @else
                                    <span class="p-2 bg-gray-300 border border-gray-500 rounded-lg text-gray-700">
                                        {{ $report->reportable_id }}
                                    </span>
                                @endif
                            </td>
                            <td class="px-4 py-2 p_font max-lg:text-sm">
                                <a href="{{ route('admin.public_profile', ['name' => urlencode($report->reporter->name)]) }}" class="text-blue-500 hover:underline">
                                    {{ $report->reporter ? $report->reporter->name : 'N/A' }}
                                </a>
                            </td>
                            <td class="px-4 py-2 p_font max-lg:text-sm truncate" style="max-width: 250px; display: block; white-space: nowrap; overflow: hidden; text-overflow: ellipsis;">
                                "{{ $report->message }}"
                            </td>
                            <td class="px-4 py-2 p_font max-lg:text-sm">
                                {{ $report->created_at->format('M d, Y - h:ia') }}
                            </td>
                            <td class="px-4 py-2 p_font max-lg:text-sm flex max-xl:flex-col text-center gap-1">
                                <button class="view_button bg-[#1e2939] px-5 py-2 rounded mr-1 button_font text-sm text-green-400 cursor-pointer hover:opacity-80 mb-1">
                                    View
                                </button>
                                <button class="delete_button bg-[#1e2939] px-5 py-2 rounded mr-1 button_font text-sm text-red-400 cursor-pointer hover:opacity-80 mb-1" data-id="{{ $report->id }}">
                                    Delete
                                </button>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>

                     @else
                        {{-- no messages yet --}}
                        <div class="w-full h-[300px] flex flex-col justify-center items-center border-2 border-dashed border-gray-400 rounded-lg mt-10">
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-15 mb-2 text-gray-400">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M3 3v1.5M3 21v-6m0 0 2.77-.693a9 9 0 0 1 6.208.682l.108.054a9 9 0 0 0 6.086.71l3.114-.732a48.524 48.524 0 0 1-.005-10.499l-3.11.732a9 9 0 0 1-6.085-.711l-.108-.054a9 9 0 0 0-6.208-.682L3 4.5M3 15V4.5" />
                            </svg>
                            <p class="p_font text-gray-500 text-center p-5">No reports yet. Check back later!</p>
                        </div>
                    @endif
                </table>
            </div>
            {{-- end of card section 1 --}}

            {{-- ✅ Custom Pagination --}}
            @if ($reports->hasPages())
            <div id="users_pagination" class="w-full mx-auto flex items-center max-sm:flex-col max-sm:items-center gap-2 mt-4">
                {{-- Showing x to y of z results --}}
                <h3 class="home_p_font text-sm max-sm:text-xs">
                    Showing {{ $reports->firstItem() ?? 0 }} to {{ $reports->lastItem() ?? 0 }} of {{ $reports->total() }} results
                </h3>

                <div class="flex ml-auto gap-2 max-sm:ml-0">
                    {{-- Previous Button --}}
                    @if ($reports->onFirstPage())
                        <button disabled class="-z-1 cursor-not-allowed opacity-50 job_posting_button bg-[#1E2939] text-white px-5 py-2 rounded-lg text-sm">Previous</button>
                    @else
                        <a href="{{ $reports->previousPageUrl() }}" class="job_posting_button bg-[#1E2939] text-white px-5 py-2 rounded-lg text-sm hover:opacity-90">Previous</a>
                    @endif

                    {{-- Next Button --}}
                    @if ($reports->hasMorePages())
                        <a href="{{ $reports->nextPageUrl() }}" class="job_posting_button bg-[#1E2939] text-white px-5 py-2 rounded-lg text-sm hover:opacity-90">Next</a>
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

    {{-- report modal --}}
    <div class="report_modal fixed top-0 left-0 w-full h-full z-50 max-sm:px-6 hidden">
      {{-- menu control --}}
        <div class="w-2xl max-lg:w-xl max-sm:w-full mt-20 mx-auto p-5 max-sm:p-4 bg-gray-200 opacity-100 rounded-xl shadow-sm">
            {{-- modal sub title and close button --}}
            <div class="flex justify-between items-center mb-2">
                <h3 class="sub_title_font max-sm:text-sm">Report Details:</h3>
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" id="close_report_modal" class="size-5 cursor-pointer  hover:bg-red-400! rounded-sm max-sm:size-4 bg-gray-300!">
                <path stroke-linecap="round" stroke-linejoin="round" d="M6 18 18 6M6 6l12 12" />
                </svg>
            </div>
             <form id="reportForm" action="" method="POST" class="w-full bg-white p-3 rounded-lg shadow-sm ">
                <div class="input_control flex flex-col mb-3">
                    <h1 class="p_font max-sm:text-sm text-lg font-semibold!">Singer(or Client name)</h1>
                    <h3 class="home_p_font max-sm:text-sm"> Client (or user email if not jobpost)</h3>
                </div>
                
                <div class="input_control flex flex-col mb-3 w-full">
                    <label for="report_message" class=" mb-1 home_p_font text-black! max-sm:text-sm">
                        Message <span class="text-gray-400">(optional)</span>
                    </label>
                    <textarea rows="10" id="report_message" name="message" class="p-2 w-full border-2 border-gray-400 rounded-lg max-sm:text-sm bg-gray-200" disabled></textarea> 
                </div>
                
                <div class="flex">
                    <input type="button" value="Close" class="cursor-pointer p_font bg-[#1E2939] text-white px-7 py-3 max-sm:py-3 max-sm:px-5 rounded-lg hover:opacity-90 max-sm:text-sm text-center ml-auto">
                </div>
            </form>

       </div>
    </div>

    {{-- delete modal warning --}}
    <div id="delete_chat" class="hidden modal_bg min-h-screen fixed top-0 z-40 w-full flex items-center justify-center px-5">
        <div class="px-5 py-3 bg-white rounded-xl -mt-20">
            <h2 class="text-xl sub_title_font font-semibold mb-2">Delete this report?</h2>
            <p class="home_p_font text-gray-600 mb-3">This action cannot be undone. <br>Are you sure you want to delete this?</p>

            <div class="flex gap-2 justify-end">
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
            
    <script>
    document.addEventListener('DOMContentLoaded', () => {
        const viewButtons = document.querySelectorAll('.view_button');
        const reportModal = document.querySelector('.report_modal');
        const closeReportModal = reportModal.querySelector('#close_report_modal');
        const closeButton = reportModal.querySelector('input[type="button"]');
        
        // Fields inside modal
        const modalTitle = reportModal.querySelector('h1.p_font');
        const modalSubtitle = reportModal.querySelector('h3.home_p_font');
        const modalMessage = reportModal.querySelector('#report_message');

        viewButtons.forEach((button, index) => {
            button.addEventListener('click', () => {
                // Grab the data from the table row
                const row = button.closest('tr');
                const typeCell = row.querySelector('td:nth-child(3) span').textContent.trim();
                const entityCell = row.querySelector('td:nth-child(4)').textContent.trim();
                const reporterCell = row.querySelector('td:nth-child(5)').textContent.trim();
                const messageCell = row.querySelector('td:nth-child(6)').textContent.trim();

                // Set modal content
                modalTitle.textContent = entityCell;          // Reported entity name
                modalSubtitle.textContent = reporterCell;     // Reporter name/email
                modalMessage.value = messageCell.replace(/"/g, ''); // Remove quotes if any

                // Show modal
                reportModal.classList.remove('hidden');
            });
        });

        // Close modal handlers
        [closeReportModal, closeButton].forEach(el => {
            el.addEventListener('click', () => {
                reportModal.classList.add('hidden');
            });
        });
    });
    </script>

    <script>
    document.addEventListener('DOMContentLoaded', () => {
        const deleteButtons = document.querySelectorAll('.delete_button');
        const deleteModal = document.getElementById('delete_chat');
        const cancelDelete = document.getElementById('cancel_delete_applicant');
        const confirmDelete = document.getElementById('delete_applicant');
        let reportId = null;

        // Open modal when delete button is clicked
        deleteButtons.forEach(btn => {
            btn.addEventListener('click', () => {
                reportId = btn.dataset.id; // get report id
                deleteModal.classList.remove('hidden');
            });
        });

        // Cancel deletion
        cancelDelete.addEventListener('click', () => {
            deleteModal.classList.add('hidden');
            reportId = null;
        });

        // Confirm deletion
        confirmDelete.addEventListener('click', async () => {
            if (!reportId) return;

            try {
                const token = document.querySelector('meta[name="csrf-token"]').getAttribute('content');

                const response = await fetch(`/admin/reports/${reportId}`, {
                    method: 'DELETE',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': token
                    },
                });

                const data = await response.json();

                if (data.success) {
                    deleteModal.classList.add('hidden'); // close modal
                    location.reload(); // reload the page to reflect deletion
                }
            } catch (err) {
                console.error(err);
            }
        });
    });
    </script>




    <script src="{{asset('js/admin/messages.js')}}"></script>
    <script src="{{ asset('js/admin/nav_admin.js') }}"></script>
@endsection