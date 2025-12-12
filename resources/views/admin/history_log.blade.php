@extends('layouts.app')

@section('body-class', 'bg-[#F0F0F0]')

@section('content')
     @include('components.nav_admin')


    <!-- main content -->
    <section class="w-full  z-0">
        <div class="pt-35 max-sm:pt-25 pl-85 max-[1270px]:pl-75 max-lg:pl-7  pr-10 max-sm:pr-5 pb-15">
            {{-- padding top --}}
            {{-- title & sub title --}}
            <h1 class="home_p_font font-semibold! max-lg:text-sm text-lg">History Logs</h1>
            <p class="home_p_font mb-5 text-sm">Manage and review system history logs.</p>
             {{-- export and search bar control div --}}
            <div class="flex justify-between max-sm:gap-3 mb-3 max-sm:flex-col-reverse">
                {{-- export to csv button --}}
                <div>
                   <form action="{{ route('admin.history_log.export') }}" method="GET">
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
                <form action="" method="GET" class="group">
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
            {{-- contents --}}
            {{-- cards --}}
            {{-- card section 1 --}}
             @if ($historyLogs->isNotEmpty())
            <div id="table_div" class="overflow-x-auto shadow-lg rounded-lg mb-5">
            <table class="w-full min-w-[700px] shadow-lg rounded-lg overflow-hidden">
                <thead class="bg-gray-200 ">
                    <tr class="bg-gray-300 ">
                        <th class="px-4 py-2 text-left sub_title_font font-semibold! uppercase text-sm max-sm:text-xs">#</th>
                        <th class="px-4 py-2 text-left sub_title_font font-semibold! uppercase text-sm max-sm:text-xs">User ID</th>
                        <th class="px-4 py-2 text-left sub_title_font font-semibold! uppercase text-sm max-sm:text-xs"> Username</th>
                        <th class="px-4 py-2 text-left sub_title_font font-semibold! uppercase text-sm max-sm:text-xs">User Type</th>
                        <th class="px-4 py-2 text-left sub_title_font font-semibold! uppercase text-sm max-sm:text-xs">Details </th>
                        <th class="px-4 py-2 text-left sub_title_font font-semibold! uppercase text-sm max-sm:text-xs"> Created at</th>
                        <th class="px-4 py-2 text-left sub_title_font font-semibold! uppercase text-sm max-sm:text-xs">updated at</th>
                        <th class="px-4 py-2 text-left sub_title_font font-semibold! uppercase text-sm max-sm:text-xs">
                            Action
                        </th>
             
                    </tr>
                </thead>
                
                <tbody>
                    @foreach($historyLogs as $index => $log)
                    <tr class="border-b-2 border-gray-300 py-2 hover:bg-gray-200">
                        <td class="px-4 py-2 p_font max-lg:text-sm home_p_font">
                            {{ $historyLogs->firstItem() + $index }}
                        </td>
                        <td class="px-4 py-2 p_font max-lg:text-sm">
                            {{ $log->user_id }}
                        </td>
                        <td class="px-4 py-2 p_font max-lg:text-sm">
                            <a href="{{ route('admin.public_profile', ['name' => urlencode($log->user?->name)]) }}"  class="hover:underline cursor-pointer text-blue-500">
                                {{ $log->user?->name ?? 'Deleted User' }}
                            </a>
                        </td>
                        <td class="px-4 py-2 p_font max-lg:text-sm">
                            {{ ucfirst($log->user_type) }}
                        </td>
                        <td class="px-4 py-2 p_font max-lg:text-sm">
                            {{ $log->details }}
                        </td>
                        <td class="px-4 py-2 p_font max-lg:text-sm">
                            {{ \Carbon\Carbon::parse($log->created_at)->format('M d, Y - h:i A') }}
                        </td>
                        <td class="px-4 py-2 p_font max-lg:text-sm">
                            {{ \Carbon\Carbon::parse($log->created_at)->format('M d, Y - h:i A') }}
                        </td>
                        <td class="px-4 py-2 p_font max-lg:text-sm">
                            <form action="{{ route('admin.history_log.destroy_log', $log->id) }}" method="POST" class="delete-log-form">
                                @csrf
                                @method('DELETE')
                                <button type="button"
                                    class="open-delete-modal bg-[#1e2939] p-2 rounded-lg cursor-pointer hover:opacity-70"
                                    data-url="{{ route('admin.history_log.destroy_log', $log->id) }}">
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
            @else
                <div class="w-full h-[300px] flex flex-col justify-center items-center border-2 border-dashed border-gray-400 rounded-lg mt-1 hidden">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-15 mb-2 text-gray-400">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M18 18.72a9.094 9.094 0 0 0 3.741-.479 3 3 0 0 0-4.682-2.72m.94 3.198.001.031c0 .225-.012.447-.037.666A11.944 11.944 0 0 1 12 21c-2.17 0-4.207-.576-5.963-1.584A6.062 6.062 0 0 1 6 18.719m12 0a5.971 5.971 0 0 0-.941-3.197m0 0A5.995 5.995 0 0 0 12 12.75a5.995 5.995 0 0 0-5.058 2.772m0 0a3 3 0 0 0-4.681 2.72 8.986 8.986 0 0 0 3.74.477m.94-3.197a5.971 5.971 0 0 0-.94 3.197M15 6.75a3 3 0 1 1-6 0 3 3 0 0 1 6 0Zm6 3a2.25 2.25 0 1 1-4.5 0 2.25 2.25 0 0 1 4.5 0Zm-13.5 0a2.25 2.25 0 1 1-4.5 0 2.25 2.25 0 0 1 4.5 0Z" />
                    </svg>
                    <p class="p_font text-gray-500 text-center p-5">No history log yet. Check back later!</p>
                </div>
            @endif

        {{-- Custom Pagination --}}
        <div id="posting_pagination" class="w-full mx-auto flex items-center max-sm:flex-col max-sm:items-center gap-2">
            <h3 class="home_p_font text-sm max-sm:text-xs">
                {{ $historyLogs->firstItem() }} to {{ $historyLogs->lastItem() }} of {{ $historyLogs->total() }} results
            </h3>

            <div class="flex ml-auto gap-2 max-sm:ml-0">
                {{-- Previous button --}}
                @if($historyLogs->onFirstPage())
                    <button disabled class="-z-1 cursor-not-allowed opacity-50 job_posting_button bg-[#1E2939] text-white px-5 py-2 max-sm:py-2 max-sm:px-5 rounded-lg text-sm max-sm:text-xs">Previous</button>
                @else
                    <a href="{{ $historyLogs->previousPageUrl() }}" class="job_posting_button bg-[#1E2939] text-white px-5 py-2 max-sm:py-2 max-sm:px-5 rounded-lg text-sm max-sm:text-xs">Previous</a>
                @endif

                {{-- Next button --}}
                @if($historyLogs->hasMorePages())
                    <a href="{{ $historyLogs->nextPageUrl() }}" class="job_posting_button bg-[#1E2939] text-white px-5 py-2 max-sm:py-2 max-sm:px-5 rounded-lg hover:opacity-90 text-sm max-sm:text-xs">Next</a>
                @else
                    <button disabled class="-z-1 cursor-not-allowed opacity-50 job_posting_button bg-[#1E2939] text-white px-5 py-2 max-sm:py-2 max-sm:px-5 rounded-lg text-sm max-sm:text-xs">Next</button>
                @endif
            </div>
        </div>
        {{-- end of pagination --}}





        
        </div>
    </section>

    {{-- Modal section --}}


    {{-- delete modal warning --}}
    <div id="delete_log_modal" class="hidden modal_bg min-h-screen fixed top-0 z-40 w-full flex items-center justify-center px-5">
        <div class="px-5 py-3 bg-white rounded-xl -mt-20">
            <h2 class="text-xl sub_title_font font-semibold mb-2">Delete log?</h2>
            <p class="home_p_font text-gray-600 mb-5">
                This action cannot be undone. <br>
                Are you sure you want to delete this log?
            </p>

            <div class="flex gap-2">
                <button type="button" id="cancel_delete_log"
                    class="bg-[#1e2939] cursor-pointer sub_title_font text-blue-400 px-4 py-2 rounded-lg hover:bg-[#374151] max-sm:text-sm">
                    Cancel
                </button>

                <button type="button" id="confirm_delete_log"
                    class="bg-[#1e2939] cursor-pointer sub_title_font text-red-400 px-4 py-2 rounded-lg hover:bg-[#374151] max-sm:text-sm">
                    Delete
                </button>
            </div>
        </div>
    </div>


    {{-- script section--}}

    {{-- delete JS --}}
    <script>
        document.addEventListener('DOMContentLoaded', function() {
        const modal = document.getElementById('delete_log_modal');
        const cancelBtn = document.getElementById('cancel_delete_log');
        const confirmBtn = document.getElementById('confirm_delete_log');
        let currentForm = null;

        // Open modal
        document.querySelectorAll('.open-delete-modal').forEach(btn => {
            btn.addEventListener('click', function() {
                currentForm = btn.closest('form');
                modal.classList.remove('hidden');
            });
        });

        // Cancel button
        cancelBtn.addEventListener('click', function() {
            modal.classList.add('hidden');
            currentForm = null;
        });

        // Confirm delete
        confirmBtn.addEventListener('click', function() {
            if(currentForm) currentForm.submit();
        });
    });
    </script>


  
    <script src="{{ asset('js/admin/nav_admin.js') }}"></script>
@endsection
 