@extends('layouts.app')

@section('body-class', 'bg-[#F0F0F0]')

@section('content')
     @include('components.nav_admin')


    <!-- main content -->
    <section class="w-full  z-0">
        <div class="pt-35 max-sm:pt-25 pl-85 max-[1270px]:pl-75 max-lg:pl-7  pr-10 max-sm:pr-5 pb-15">
            {{-- padding top --}}
            {{-- title & sub title --}}
            <h1 class="home_p_font font-semibold! max-lg:text-sm text-lg">Announcements</h1>
            <p class="home_p_font mb-5 text-sm">Manage and review system announcements.</p>
            {{-- export and search bar control div --}}
            <div class="flex justify-between max-sm:gap-3 mb-3 max-sm:flex-col-reverse ">
                {{-- buttons --}}
                <div class="flex gap-2 items-center max-sm:justify-between ">
                    <form action="{{ route('admin.reports.export') }}" method="GET">
                        {{-- Keep current search term if any --}}
                        <input type="hidden" name="search" value="{{ request('search') }}">
                            {{-- export button --}}
                            <button type="submit" 
                                class="p_font py-2 px-3 bg-[#1e2939] rounded-lg hover:opacity-70 cursor-pointer text-sm max-sm:text-xs text-green-400 flex items-center gap-2 shadow-lg hidden">
                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" 
                                    stroke-width="1.5" stroke="currentColor" class="size-6">
                                    <path stroke-linecap="round" stroke-linejoin="round" 
                                        d="M7.5 7.5h-.75A2.25 2.25 0 0 0 4.5 9.75v7.5a2.25 2.25 0 0 0 2.25 2.25h7.5a2.25 2.25 0 0 0 2.25-2.25v-7.5a2.25 2.25 0 0 0-2.25-2.25h-.75m-6 3.75 3 3m0 0 3-3m-3 3V1.5m6 9h.75a2.25 2.25 0 0 1 2.25 2.25v7.5a2.25 2.25 0 0 1-2.25 2.25h-7.5a2.25 2.25 0 0 1-2.25-2.25v-.75" />
                                </svg>
                                Export to CSV
                            </button>
                    </form>
                    {{-- create announcement button --}}
                    <button type="" id="create_announcement_btn"
                        class="p_font py-2 px-3 bg-[#1e2939] rounded-lg hover:opacity-70 cursor-pointer text-sm text-yellow-400 flex items-center gap-2 shadow-lg max-sm:text-xs">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" aria-hidden="true" data-slot="icon" class="size-6">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M10.34 15.84c-.688-.06-1.386-.09-2.09-.09H7.5a4.5 4.5 0 1 1 0-9h.75c.704 0 1.402-.03 2.09-.09m0 9.18c.253.962.584 1.892.985 2.783.247.55.06 1.21-.463 1.511l-.657.38c-.551.318-1.26.117-1.527-.461a20.845 20.845 0 0 1-1.44-4.282m3.102.069a18.03 18.03 0 0 1-.59-4.59c0-1.586.205-3.124.59-4.59m0 9.18a23.848 23.848 0 0 1 8.835 2.535M10.34 6.66a23.847 23.847 0 0 0 8.835-2.535m0 0A23.74 23.74 0 0 0 18.795 3m.38 1.125a23.91 23.91 0 0 1 1.014 5.395m-1.014 8.855c-.118.38-.245.754-.38 1.125m.38-1.125a23.91 23.91 0 0 0 1.014-5.395m0-3.46c.495.413.811 1.035.811 1.73 0 .695-.316 1.317-.811 1.73m0-3.46a24.347 24.347 0 0 1 0 3.46"></path>
                        </svg>
                        Announce
                    </button>
                </div>

                {{-- search bar control --}}
                <form id="searchForm" class="group">
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
            <div id="table_div" class="overflow-x-auto shadow-lg rounded-lg mb-5">
                <table class="w-full min-w-[700px] shadow-lg rounded-lg overflow-hidden">
                    <thead class="bg-gray-200 ">
                        <tr class="bg-gray-300 ">
                            <th class="px-4 py-2 text-left sub_title_font font-semibold! uppercase text-sm max-sm:text-xs">#</th>
                            <th class="px-4 py-2 text-left sub_title_font font-semibold! uppercase text-sm max-sm:text-xs">Announcement ID</th>
                            <th class="px-4 py-2 text-left sub_title_font font-semibold! uppercase text-sm max-sm:text-xs">Title</th>
                            <th class="px-4 py-2 text-left sub_title_font font-semibold! uppercase text-sm max-sm:text-xs">Audience</th>
                            <th class="px-4 py-2 text-left sub_title_font font-semibold! uppercase text-sm max-sm:text-xs">Message</th>
                            <th class="px-4 py-2 text-left sub_title_font font-semibold! uppercase text-sm max-sm:text-xs">Release date</th>
                            <th class="px-4 py-2 text-left sub_title_font font-semibold! uppercase text-sm max-sm:text-xs">Status</th>
                            <th class="px-4 py-2 text-left sub_title_font font-semibold! uppercase text-sm max-sm:text-xs">Created at</th>
                            <th class="px-4 py-2 text-left sub_title_font font-semibold! uppercase text-sm max-sm:text-xs">Updated at</th>
                            <th class="px-4 py-2 text-left sub_title_font font-semibold! uppercase text-sm max-sm:text-xs">Actions</th>
                        </tr>
                    </thead>
                   
                    <tbody>
                        <tr class="border-b-2 border-gray-300 py-2 hover:bg-gray-200">
                            <td class="px-4 py-2 home_p_font max-lg:text-sm p_font">
                                1
                            </td>
                            <td class="px-4 py-2 p_font max-lg:text-sm">
                                22
                            </td>
                            <td class="px-4 py-2 p_font max-lg:text-sm">
                               asd
                            </td>
                            <td class="px-4 py-2 p_font max-lg:text-sm">
                                asd
                            </td>
                            <td class="px-4 py-2 p_font max-lg:text-sm">
                                asd
                            </td>
                            <td class="px-4 py-2 p_font max-lg:text-sm">
                                asd
                            </td>
                            <td class="px-4 py-2 p_font max-lg:text-sm">
                               asd
                            </td>
                            <td class="px-4 py-2 p_font max-lg:text-sm flex max-xl:flex-col text-center gap-1">
                                <button class="view_button bg-[#1e2939] px-5 py-2 rounded mr-1 button_font text-sm text-yellow-400 cursor-pointer hover:opacity-80 mb-1">
                                    Edit
                                </button>
                                <button class="delete_button bg-[#1e2939] px-5 py-2 rounded mr-1 button_font text-sm text-red-400 cursor-pointer hover:opacity-80 mb-1" data-id="">
                                    Delete
                                </button>
                            </td>
                        </tr>
                    </tbody>

                    {{-- fetch and display data to table JS --}}
                    <script>
                    document.addEventListener("DOMContentLoaded", () => {
                        const tbody = document.querySelector("tbody");
                        const prevBtn = document.querySelector("#users_pagination .prev");
                        const nextBtn = document.querySelector("#users_pagination .next");
                        const showingText = document.querySelector("#users_pagination h3");

                        const searchForm = document.getElementById('searchForm');
                        const searchInput = searchForm.querySelector('input[name="search"]');

                        searchForm.addEventListener('submit', (e) => {
                            e.preventDefault(); // prevent full page reload
                            const searchQuery = searchInput.value.trim();
                            fetchAnnouncements(searchQuery); // fetch with search
                        });

                        async function fetchAnnouncements(search = "") {
                            try {
                                const res = await fetch(`http://127.0.0.1:3001/api/announcements?search=${encodeURIComponent(search)}`);
                                data = await res.json();  // update global data array
                                totalPages = Math.ceil(data.length / rowsPerPage);
                                currentPage = 1;          // reset to first page
                                renderPage(currentPage);
                            } catch (err) {
                                console.error("Fetch error:", err);
                            }
                        }


                        let data = [];
                        let currentPage = 1;
                        const rowsPerPage = 10;
                        let totalPages = 1;

                        // Fetch announcements
                        fetchAnnouncements();

                        function renderPage(page) {
                            tbody.innerHTML = "";
                            const start = (page - 1) * rowsPerPage;
                            const end = start + rowsPerPage;
                            const pageData = data.slice(start, end);

                            const noMessagesDiv = document.getElementById('no_messages');
                            const table = document.querySelector('table')
                            const pagination = document.querySelector('#users_pagination')

                            // Show "no messages" if pageData is empty
                            if (pageData.length === 0) {
                                noMessagesDiv.classList.remove('hidden');
                                table.classList.add('hidden'); // optionally hide table
                                pagination.classList.add('hidden');
                            } else {
                                noMessagesDiv.classList.add('hidden');
                                table.classList.remove('hidden'); // show table
                                pagination.classList.remove('hidden');
                            }

                            pageData.forEach((item, index) => {
                                const releaseDateStr = new Date(item.release_date).toLocaleString('en-US', {
                                    month: 'short', day: '2-digit', year: 'numeric',
                                    hour: 'numeric', minute: '2-digit', hour12: true
                                });
                                const createdAtStr = new Date(item.created_at).toLocaleString('en-US', {
                                    month: 'short', day: '2-digit', year: 'numeric',
                                    hour: 'numeric', minute: '2-digit', hour12: true
                                });
                                const updatedAtStr = new Date(item.updated_at).toLocaleString('en-US', {
                                    month: 'short', day: '2-digit', year: 'numeric',
                                    hour: 'numeric', minute: '2-digit', hour12: true
                                });
                                const statusColor = item.status.toLowerCase() === 'active' 
                                ? 'bg-green-200 border-green-600 text-green-600'
                                : item.status.toLowerCase() === 'draft'
                                    ? 'bg-yellow-200 border-yellow-600 text-yellow-600'
                                    : 'bg-red-200 border-red-600 text-red-600';

                                tbody.innerHTML += `

                                    <tr class="border-b-2 border-gray-300 py-2 hover:bg-gray-200">
                                        <td class="px-4 py-2 home_p_font max-lg:text-sm p_font">${start + index + 1}</td>
                                        <td class="px-4 py-2 p_font max-lg:text-sm">${item.id}</td>
                                        <td class="px-4 py-2 p_font max-lg:text-sm capitalize">${item.title}</td>
                                        <td class="px-4 py-2 p_font max-lg:text-sm capitalize">${item.audience}</td>
                                        <td class="px-4 py-2 p_font max-lg:text-sm capitalize">" ${item.message.length > 20 ? item.message.substring(0, 20) + '...' : item.message} "</td>
                                        <td class="px-4 py-2 p_font max-lg:text-sm capitalize">${releaseDateStr}</td>
                                        <td class="px-4 py-2 p_font max-lg:text-sm">
                                            <button 
                                                class="p-2 text-sm font-semibold rounded-lg border-1 cursor-pointer status-btn ${statusColor} hover:opacity-60 capitalize"
                                                data-id="${item.id}"
                                                data-status="${item.status}"
                                            >
                                                ${item.status}
                                            </button>
                                        </td>
                                        <td class="px-4 py-2 p_font max-lg:text-sm capitalize">${createdAtStr}</td>
                                        <td class="px-4 py-2 p_font max-lg:text-sm capitalize">${updatedAtStr}</td>
                                        <td class="px-4 py-2 p_font max-lg:text-sm flex flex-col text-center gap-1">
                                            <button class="edit_button bg-[#1e2939] px-5 py-2 rounded button_font text-sm text-yellow-400 hover:opacity-80 cursor-pointer hover:opacity-70"
                                                data-json='${encodeURIComponent(JSON.stringify(item))}'
                                            >Edit</button>
                                            <button class="delete_button bg-[#1e2939] px-5 py-2 rounded button_font text-sm text-red-400 hover:opacity-80 cursor-pointer hover:opacity-70" data-id="${item.id}">Delete</button>
                                        </td>
                                    </tr>

                                `;
                            });

                            // Update showing text
                            showingText.textContent = `${start + 1} to ${Math.min(end, data.length)} of ${data.length} results`;

                            // Update buttons
                            prevBtn.disabled = page === 1;
                            nextBtn.disabled = page === totalPages;
                        }

                        // Event listeners
                        prevBtn.addEventListener("click", () => {
                            if (currentPage > 1) {
                                currentPage--;
                                renderPage(currentPage);
                            }
                        });

                        nextBtn.addEventListener("click", () => {
                            if (currentPage < totalPages) {
                                currentPage++;
                                renderPage(currentPage);
                            }
                        });
                        
                    });
                    </script>  
                </table>
            </div>
            {{-- end of card section 1 --}}

            {{-- pagination --}}
            <div id="users_pagination" class="w-full mx-auto flex items-center max-sm:flex-col max-sm:items-center gap-2 mt-4">
                <h3 class="home_p_font text-sm max-sm:text-xs">Showing  to  of  results</h3>
                <div class="flex ml-auto gap-2 max-sm:ml-0">
                    <button class="prev job_posting_button bg-[#1E2939] text-white px-5 py-2 rounded-lg text-sm cursor-pointer hover:opacity-70">Previous</button>
                    <button class="next job_posting_button bg-[#1E2939] text-white px-5 py-2 rounded-lg text-sm cursor-pointer hover:opacity-70">Next</button>
                </div>
            </div>
            {{-- end of pagination --}}
            
             {{-- no messages yet --}}
            <div id="no_messages" class="w-full h-[300px] flex flex-col justify-center items-center border-2 border-dashed border-gray-400 rounded-lg hidden">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-15 mb-2 text-gray-400">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M3 3v1.5M3 21v-6m0 0 2.77-.693a9 9 0 0 1 6.208.682l.108.054a9 9 0 0 0 6.086.71l3.114-.732a48.524 48.524 0 0 1-.005-10.499l-3.11.732a9 9 0 0 1-6.085-.711l-.108-.054a9 9 0 0 0-6.208-.682L3 4.5M3 15V4.5" />
                </svg>
                <p class="p_font text-gray-500 text-center p-5">No announcements yet. Check back later!</p>
            </div>

        </div>
    </section>

    {{-- modal section --}}

    {{-- status modal --}}
    <div id="status_modal" class="modal_bg edit_job_modal fixed top-0 left-0 w-full h-full z-50 max-sm:px-6 px-10 hidden">
        <div class="sm:w-xl max-h-[80vh] overflow-y-auto mt-20 mx-auto p-5 max-sm:p-4 bg-gray-200 opacity-100 rounded-xl shadow-sm">
            {{-- modal header --}}
            <div class="flex justify-between items-center mb-2">
                <h3 class="sub_title_font max-sm:text-sm">Announcement Status</h3>
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" id="close_status_modal" class="size-5 cursor-pointer hover:bg-red-400! rounded-sm max-sm:size-5 bg-gray-300!">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M6 18 18 6M6 6l12 12" />
                </svg>
            </div>

            {{-- modal body --}}
            <div class="px-5 py-3 bg-white shadow-sm rounded-lg">
                <h1 class="p_font text-blue-500 mb-1">
                    Current Status: <span class="uppercase status_text"></span>
                </h1>
                <p class="home_p_font mb-3">Click a button below to change the transaction status.</p>

                <form id="status_form" action="" class="flex gap-2 max-sm:flex-col max-sm:w-full max-lg:gap-2">
                    <button type="submit" name="status" value="inactive" class="px-4 py-2 border-1 border-red-600 capitalize text-sm bg-red-200 text-red-600 rounded-lg button_font hover:opacity-80 cursor-pointer font-semibold!">Incative</button>
                    <button type="submit" name="status" value="draft" class="px-4 py-2 border-1 border-yellow-600 capitalize text-sm bg-yellow-200 text-yellow-600 rounded-lg button_font hover:opacity-80 cursor-pointer font-semibold!">draft</button>
                    <button type="submit" name="status" value="active" class="px-4 py-2 border-1 border-green-600 capitalize text-sm bg-green-200 text-green-600 rounded-lg button_font hover:opacity-80 cursor-pointer font-semibold!">active</button>
                </form>
            </div>
        </div>
    </div>

    <script>
    // STATUS MODAL ELEMENTS
    const statusModal = document.getElementById("status_modal");
    const closeStatusModal = document.getElementById("close_status_modal");
    const statusText = document.querySelector(".status_text");
    const statusForm = document.getElementById("status_form");

    let selectedAnnouncementId = null;

    // OPEN STATUS MODAL
    document.addEventListener("click", function (e) {
        if (e.target.classList.contains("status-btn")) {
            const status = e.target.dataset.status;
            selectedAnnouncementId = e.target.dataset.id;

            statusText.textContent = status;
            statusForm.setAttribute("data-id", selectedAnnouncementId);

            statusModal.classList.add("show");
            statusModal.classList.remove("hidden");
        }
    });

    // CLOSE STATUS MODAL
    closeStatusModal.addEventListener("click", () => {
        statusModal.classList.add("hidden");
    });

    // SUBMIT STATUS CHANGE
    statusForm.addEventListener("submit", async function (e) {
        e.preventDefault();

        const newStatus = e.submitter?.value;
        const announcementId = statusForm.getAttribute("data-id");

        try {
            const response = await fetch(`http://127.0.0.1:3001/api/announcements/${announcementId}`, {
                method: "PUT",
                headers: { "Content-Type": "application/json" },
                body: JSON.stringify({ status: newStatus })
            });

            const data = await response.json();

            if (!data.success) throw new Error(data.error || "Update failed");

            // alert("Status updated successfully!");
            statusModal.classList.add("hidden");
            location.reload();
            // Removed loadAnnouncements() because it doesn't exist

        } catch (error) {
            console.error(error);
            alert(error.message || "Something went wrong updating the status.");
        }
    });
    </script>

    {{-- create announce modal --}}
    <div class="report_modal fixed top-0 left-0 w-full h-full z-50 max-lg:px-6 hidden">
      {{-- menu control --}}
        <div class="lg:w-2xl mt-20 mx-auto p-5 max-sm:p-4 bg-gray-200 opacity-100 rounded-xl shadow-sm ">
            {{-- modal sub title and close button --}}
            <div class="flex justify-between items-center mb-2">
                <h3 class="sub_title_font max-sm:text-sm">Create your announcement below:</h3>
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" id="close_report_modal" class="size-5 cursor-pointer  hover:bg-red-400! rounded-sm max-sm:size-4 bg-gray-300!">
                <path stroke-linecap="round" stroke-linejoin="round" d="M6 18 18 6M6 6l12 12" />
                </svg>
            </div>
             <form action="" class="w-full bg-white p-3 rounded-lg shadow-sm max-h-110 overflow-auto">
                {{-- title and type container --}}
                <div class="input_control mb-3 gap-4 max-sm:flex-col max-sm:gap-2">
                    <label class="p_font max-sm:text-sm" for="announcement_title">Announcement title</label>
                    <input type="text" id="announcement_title" class="p-2 w-full border-2 border-gray-400 rounded-lg max-sm:text-sm" placeholder="Your announcement title">
                </div>
                {{-- audience and posted time container --}}
                <div class="input_control flex mb-3 gap-4 max-sm:flex-col max-sm:gap-2">
                    <div class="w-full">
                        <label class="p_font max-sm:text-sm" for="announcement_audience">Audience</label>
                        <input type="text" id="announcement_audience" class="p-2 w-full border-2 border-gray-400 rounded-lg max-sm:text-sm hidden">
                        <select id="announcement_audience_select" class="p-2 w-full border-2 border-gray-400 rounded-lg max-sm:text-sm p_font">
                            <option value="" selected disabled>--Select your audience--</option>
                            <option value="client">Client</option>
                            <option value="employee">Employee</option>
                            <option value="all">All</option>
                        </select>
                    </div>
                    <div class="w-full">
                        <label class="p_font max-sm:text-sm" for="release_date">Release Date</label>
                        
                        <input type="datetime-local" 
                            id="release_date" 
                            name="release_date"
                            class="p-2 w-full border-2 border-gray-400 rounded-lg max-sm:text-sm p_font">
                    </div>
                </div>
                
                <div class="input_control flex flex-col mb-3 w-full">
                    <label for="report_message" class=" mb-1 p_font text-black! max-sm:text-sm">Message</label>
                    <textarea id="report_message" class="p-2 w-full border-2 border-gray-400 rounded-lg max-sm:text-sm" placeholder="Announcement message here" rows="5"></textarea> 
                </div>
                
                <div class="flex">
                <input type="submit" value="Create" class="cursor-pointer bg-[#1E2939] text-white px-7 py-3 max-sm:py-3 max-sm:px-5 rounded-lg hover:opacity-90 max-sm:text-sm text-center ml-auto p_font">
                </div>
             </form>
       </div>
    </div>

    {{-- edit announce modal --}}
    <div class="edit_modal modal_bg fixed top-0 left-0 w-full h-full z-50 max-lg:px-6 hidden">
      {{-- menu control --}}
        <div class="lg:w-2xl mt-20 mx-auto p-5 max-sm:p-4 bg-gray-200 opacity-100 rounded-xl shadow-sm ">
            {{-- modal sub title and close button --}}
            <div class="flex justify-between items-center mb-2">
                <h3 class="sub_title_font max-sm:text-sm">Edit your announcement below:</h3>
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" id="close_edit_modal" class="size-5 cursor-pointer  hover:bg-red-400! rounded-sm max-sm:size-4 bg-gray-300!">
                <path stroke-linecap="round" stroke-linejoin="round" d="M6 18 18 6M6 6l12 12" />
                </svg>
            </div>
             <form action="" class="w-full bg-white p-3 rounded-lg shadow-sm max-h-110 overflow-auto">
                {{-- title and type container --}}
                <div class="input_control mb-3 gap-4 max-sm:flex-col max-sm:gap-2">
                    <label class="p_font max-sm:text-sm" for="edit_announcement_title">Announcement title</label>
                    <input type="text" id="edit_announcement_title" class="p-2 w-full border-2 border-gray-400 rounded-lg max-sm:text-sm" placeholder="Your announcement title">
                </div>
                {{-- audience and posted time container --}}
                <div class="input_control flex mb-3 gap-4 max-sm:flex-col max-sm:gap-2">
                    <div class="w-full">
                        <label class="p_font max-sm:text-sm" for="edit_announcement_audience">Audience</label>
                        <input type="text" id="edit_announcement_audience" class="p-2 w-full border-2 border-gray-400 rounded-lg max-sm:text-sm hidden">
                        <select id="edit_announcement_audience_select" class="p-2 w-full border-2 border-gray-400 rounded-lg max-sm:text-sm p_font">
                            <option value="" selected disabled>--Select your audience--</option>
                            <option value="client">Client</option>
                            <option value="employee">Employee</option>
                            <option value="all">All</option>
                        </select>
                    </div>
                    <div class="w-full">
                        <label class="p_font max-sm:text-sm" for="release_date">Release Date</label>
                        
                        <input type="datetime-local" 
                            id="edit_release_date" 
                            name="edit_release_date"
                            class="p-2 w-full border-2 border-gray-400 rounded-lg max-sm:text-sm p_font">
                    </div>
                </div>
                
                <div class="input_control flex flex-col mb-3 w-full">
                    <label for="edit_message" class=" mb-1 p_font text-black! max-sm:text-sm">Message</label>
                    <textarea id="edit_message" class="p-2 w-full border-2 border-gray-400 rounded-lg max-sm:text-sm" placeholder="Announcement message here" rows="5"></textarea> 
                </div>
                
                <div class="flex">
                <input type="submit" value="Update" class="cursor-pointer bg-[#1E2939] text-yellow-500 px-7 py-3 max-sm:py-3 max-sm:px-5 rounded-lg hover:opacity-90 max-sm:text-sm text-center ml-auto p_font">
                </div>
             </form>
       </div>
    </div>

    {{-- delete modal warning --}}
    <div id="delete_announcement_modal" class="hidden modal_bg min-h-screen fixed top-0 z-40 w-full flex items-center justify-center px-5">
        <div class="px-5 py-3 bg-white rounded-xl -mt-20">
            <h2 class="text-xl sub_title_font font-semibold mb-2">Delete this announcement?</h2>
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

    {{-- script section --}}

    {{-- update mdoal JS --}}
   <script>
    document.addEventListener("DOMContentLoaded", () => {
        const editModal = document.querySelector(".edit_modal");
        const form = editModal.querySelector("form");
        const titleInput = document.getElementById("edit_announcement_title");
        const audienceSelect = document.getElementById("edit_announcement_audience_select");
        const releaseDateInput = document.getElementById("edit_release_date");
        const messageInput = document.getElementById("edit_message");
        const closeEditBtn = document.getElementById("close_edit_modal");

        let currentItemId = null;

        // Convert datetime-local to MySQL DATETIME
        const formatDateForMySQL = dt => dt ? dt.replace("T", " ") + ":00" : null;

        // Open modal
        document.addEventListener("click", e => {
            const btn = e.target.closest(".edit_button");
            if (!btn) return;

            const item = JSON.parse(decodeURIComponent(btn.dataset.json));
            currentItemId = item.id;

            titleInput.value = item.title || "";
            audienceSelect.value = item.audience || "";
            messageInput.value = item.message || "";

            if (item.release_date) {
                const date = new Date(item.release_date);
                const local = new Date(date.getTime() - date.getTimezoneOffset() * 60000)
                    .toISOString().slice(0,16);
                releaseDateInput.value = local;
            } else {
                releaseDateInput.value = "";
            }

            editModal.classList.remove("hidden");
        });

        // Close modal
        closeEditBtn.addEventListener("click", () => editModal.classList.add("hidden"));
        editModal.addEventListener("click", e => { if(e.target === editModal) editModal.classList.add("hidden"); });

        // Submit form
        form.addEventListener("submit", async e => {
            e.preventDefault();
            if (!currentItemId) return;

            const payload = {
                title: titleInput.value.trim(),
                audience: audienceSelect.value,
                message: messageInput.value.trim(),
                release_date: formatDateForMySQL(releaseDateInput.value)
            };

            try {
                const res = await fetch(`http://127.0.0.1:3001/api/announcements/${currentItemId}`, {
                    method: "PUT",
                    headers: {"Content-Type": "application/json"},
                    body: JSON.stringify(payload)
                });

                const data = await res.json();

                if (!res.ok || !data.success) {
                    console.error("Update error:", data);
                    alert("Update failed: " + (data.error || "Unknown"));
                    return;
                }

                editModal.classList.add("hidden");
                location.reload();

            } catch (err) {
                console.error("Fetch error:", err);
                alert("Failed to update announcement. See console.");
            }
        });
    });
    </script>


    
    {{-- announce modal JS --}}
    <script>
    document.addEventListener("DOMContentLoaded", () => {
        const modal = document.querySelector('.report_modal');
        const closeModal = document.getElementById('close_report_modal');
        const announceBtn = document.getElementById('create_announcement_btn');
        const form = modal.querySelector('form');

        // Open modal
        announceBtn.addEventListener('click', () => modal.classList.remove('hidden'));

        // Close modal
        closeModal.addEventListener('click', () => modal.classList.add('hidden'));
        modal.addEventListener('click', e => { if (e.target === modal) modal.classList.add('hidden'); });

        // Handle form submit
        form.addEventListener('submit', async (e) => {
            e.preventDefault();

            const title = document.getElementById('announcement_title').value.trim();
            const audience = document.getElementById('announcement_audience_select').value;
            const releaseDateInput = document.getElementById('release_date').value; // e.g. 2025-12-04T10:30
            const release_date = releaseDateInput ? releaseDateInput.replace('T', ' ') + ':00' : '';
            const message = document.getElementById('report_message').value.trim();

            if (!title || !audience || !release_date || !message) {
                alert("Please fill in all fields.");
                return;
            }

            try {
                const res = await fetch('http://127.0.0.1:3001/api/announcements', {
                    method: 'POST',
                    headers: { 'Content-Type': 'application/json' },
                    body: JSON.stringify({ title, audience, release_date, message })
                });

                const data = await res.json();

                if (data.success) {
                    location.reload();
                } else {
                    alert('Error: ' + data.error);
                }
            } catch (err) {
                console.error(err);
                alert('Failed to save announcement.');
            }
        });
    });
    </script>

    {{-- deletion of announcement JS --}}
    <script>
    document.addEventListener("DOMContentLoaded", () => {
        const modal = document.getElementById("delete_announcement_modal");
        const cancelDeleteBtn = document.getElementById("cancel_delete_applicant");
        const confirmDeleteBtn = document.getElementById("delete_applicant");

        let deleteId = null; // ID of the announcement to delete

        // EVENT DELEGATION: Open modal when any delete button is clicked
        document.addEventListener("click", (e) => {
            if (e.target.classList.contains("delete_button")) {
                deleteId = e.target.dataset.id; // store ID
                modal.classList.remove("hidden"); // show modal
            }
        });

        // Cancel button closes modal
        cancelDeleteBtn.addEventListener("click", () => {
            modal.classList.add("hidden");
            deleteId = null;
        });

        // Confirm delete
        confirmDeleteBtn.addEventListener("click", async () => {
            if (!deleteId) return;

            try {
                const res = await fetch(`http://127.0.0.1:3001/api/announcements/${deleteId}`, {
                    method: "DELETE",
                });

                const data = await res.json();

                if (data.success) {
                    location.reload();
                    // Optionally, remove the row from table without reload:
                    const row = document.querySelector(`.delete_button[data-id='${deleteId}']`).closest('tr');
                    if (row) row.remove();
                } else {
                    alert("Failed to delete announcement: " + data.error);
                }
            } catch (err) {
                console.error(err);
                alert("Error deleting announcement.");
            } finally {
                modal.classList.add("hidden");
                deleteId = null;
            }
        });

        // Click outside modal to close
        modal.addEventListener("click", (e) => {
            if (e.target === modal) {
                modal.classList.add("hidden");
                deleteId = null;
            }
        });
    });
    </script>





    <script src="{{asset('js/admin/messages.js')}}"></script>
    <script src="{{ asset('js/admin/nav_admin.js') }}"></script>
@endsection