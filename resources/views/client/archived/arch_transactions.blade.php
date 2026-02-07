@extends('layouts.app')

@section('body-class', 'bg-[#F0F0F0]')

@section('content')
    @include('components.nav_client')


    <!-- main content -->
    <section class="w-full flex min-h-[80vh] flex-col items-center  px-20 max-lg:px-10 max-sm:px-5 pt-10 max-lg:pt-5">
        <div class="xl:w-6xl  mx-auto px-5 max-sm:px-2 mb-10 w-full max-lg:px-0">
            <div class="flex items-center justify-between max-lg:flex-col max-lg:gap-2 max-xl:items-start max-xl:mb-4 mb-5">
                <div>
                    <h1 class="sub_title sm:text-xl">Archived Transactions</h1>
                    <p class="home_p_font text-sm">Manage and review archived transactions.</p>
                </div>

                {{-- search input div --}}
                <div class="ml-auto max-lg:w-sm max-sm:w-full">
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="size-6 absolute mt-2 max-sm:mt-2 ml-2 max-sm:size-5 max-sm:ml-1.5">
                    <path fill-rule="evenodd" d="M10.5 3.75a6.75 6.75 0 1 0 0 13.5 6.75 6.75 0 0 0 0-13.5ZM2.25 10.5a8.25 8.25 0 1 1 14.59 5.28l4.69 4.69a.75.75 0 1 1-1.06 1.06l-4.69-4.69A8.25 8.25 0 0 1 2.25 10.5Z" clip-rule="evenodd" />
                    </svg>
                    {{-- search inputs --}}
                    <form action="{{ route('client.arch_transactions') }}" method="GET" class="bg-white  shadow-sm rounded-lg w-sm max-lg:w-full p_font max-sm:text-sm flex items-center">
                            {{-- input 1 job title, skills, company --}}
                            <input type="text" name="q" 
                            value="{{ request('q') }}" class="  pl-10 max-sm:pl-7 py-2 rounded-lg p_font max-sm:text-sm w-sm max-lg:w-full" placeholder="Search applicant name, job title">
                            
                            
                    
                        <button class=" p_font px-2 py-1 bg-[#1e2939] rounded-lg text-sm cursor-pointer text-white hover:opacity-80 ml-2 mr-2 ">Search</button>
                    </form>
                </div>

            </div>

            {{-- no transactions yet --}}
            @if ($archivedTransactions->isEmpty())
            <div class="w-full h-[300px] flex flex-col justify-center items-center border-2 border-dashed border-gray-400 rounded-lg mt-1">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" aria-hidden="true" data-slot="icon" class="size-15 mb-2 text-gray-400 max-sm:size-10">
                <path stroke-linecap="round" stroke-linejoin="round" d="m20.25 7.5-.625 10.632a2.25 2.25 0 0 1-2.247 2.118H6.622a2.25 2.25 0 0 1-2.247-2.118L3.75 7.5M10 11.25h4M3.375 7.5h17.25c.621 0 1.125-.504 1.125-1.125v-1.5c0-.621-.504-1.125-1.125-1.125H3.375c-.621 0-1.125.504-1.125 1.125v1.5c0 .621.504 1.125 1.125 1.125Z"></path>
                </svg>
                <p class="p_font text-gray-500 text-center p-5 max-sm:text-sm">No archived transactions yet. Check back later!</p>
            </div>
            @else

             
            {{-- table div --}}
            <div id="applicants_table" id="table_div" class="overflow-x-auto shadow-lg rounded-lg  mb-5">
                <table class="w-full min-w-[700px] shadow-lg rounded-lg overflow-hidden">
                    <thead class="bg-gray-200 ">
                        <tr class="bg-gray-300">
                            <th class="px-4 py-2 text-left sub_title_font font-semibold! uppercase text-sm max-sm:text-xs">#</th>
                            <th class="px-4 py-2 text-left sub_title_font font-semibold! uppercase text-sm  max-sm:text-xs">Transaction ID</th>
                            <th class="px-4 py-2 text-left sub_title_font font-semibold! uppercase text-sm  max-sm:text-xs">Employee Name</th>
                            <th class="px-4 py-2 text-left sub_title_font font-semibold! uppercase text-sm max-sm:text-xs">Job Title</th>
                            <th class="px-4 py-2 text-left sub_title_font font-semibold! uppercase text-sm max-sm:text-xs">Amount(₱)</th>
                            <th class="px-4 py-2 text-left sub_title_font font-semibold! uppercase text-sm max-sm:text-xs">Status</th>
                            <th class="px-4 py-2 text-left sub_title_font font-semibold! uppercase text-sm max-sm:text-xs">Payment Method</th>
                            <th class="px-4 py-2 text-left sub_title_font font-semibold! uppercase text-sm max-sm:text-xs">Archived Date</th>
                            <th class="px-4 py-2 text-left sub_title_font font-semibold! uppercase text-sm max-sm:text-xs">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($archivedTransactions as $transaction)
                        <tr class="applicant_row border-b-2 border-gray-300 py-2 hover:bg-gray-200 ">
                            <td class="px-4 py-2 p_font max-lg:text-sm home_p_font">
                                {{ $loop->iteration + ($archivedTransactions->currentPage() - 1) * $archivedTransactions->perPage() }}
                            </td>
                            <td class="px-4 py-2 p_font max-lg:text-sm capitalize">    
                                {{ $transaction->id }}
                            </td>
                            <td class="px-4 py-2 p_font max-lg:text-sm capitalize">    
                                {{ $transaction->employee->name }}
                            </td>
                            <td class="px-4 py-2 p_font max-lg:text-sm capitalize">    
                                {{ $transaction->job_title }}
                            </td>
                            <td class="px-4 py-2 p_font max-lg:text-sm capitalize">    
                                {{ number_format($transaction->amount, 2) }}
                            </td>
                            <td class="px-4 py-2 p_font max-lg:text-sm capitalize">    
                                {{ $transaction->status }}
                            </td>
                            <td class="px-4 py-2 p_font max-lg:text-sm capitalize text-blue-500 font-semibold! {{ $transaction->payment_method ? '' : 'text-gray-500 italic' }} ">    
                                {{ $transaction->payment_method  ?? 'N/A' }}
                            </td>
                            <td class="px-4 py-2 p_font max-lg:text-sm capitalize">    
                                {{ $transaction->deleted_at->format('Y-m-d') }}
                            </td>
                            <td class="px-4 py-2 p_font max-lg:text-sm">
                                <div class="flex gap-1">
                                    <form action="{{ route('client.restore_archived_transaction', $transaction->id) }}"
                                    method="POST">
                                    @csrf
                                    @method('PUT')
                                        <button
                                        class="restore bg-[#1e2939] p-2 rounded-lg cursor-pointer hover:opacity-70">
                                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" aria-hidden="true" data-slot="icon" class="size-5 text-green-500">
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M16.023 9.348h4.992v-.001M2.985 19.644v-4.992m0 0h4.992m-4.993 0 3.181 3.183a8.25 8.25 0 0 0 13.803-3.7M4.031 9.865a8.25 8.25 0 0 1 13.803-3.7l3.181 3.182m0-4.991v4.99"></path>
                                            </svg>
                                        </button>
                                    </form>
                                    
                                    <form action="{{ route('client.force_delete_archived_transaction', $transaction->id) }}" method="POST" class="force-delete-form">
                                        @csrf
                                        @method('DELETE')

                                        <button type="button"
                                            class="open-delete-modal bg-[#1e2939] p-2 rounded-lg cursor-pointer hover:opacity-70"
                                            data-transaction-id="{{ $transaction->id }}">
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
                    </tbody>
                </table>
            </div>
            @endif

            {{-- Custom Pagination --}}
            @if ($archivedTransactions->total() > 10)
                <div id="posting_pagination" class="w-full mx-auto flex items-center max-sm:flex-col max-sm:items-center gap-2">
                    <h3 class="home_p_font text-sm max-sm:text-xs">
                         {{ $archivedTransactions->firstItem() ?? 0 }} to {{ $archivedTransactions->lastItem() ?? 0 }} of {{ $archivedTransactions->total() ?? 0 }} results
                    </h3>

                    <div class="flex ml-auto gap-2 max-sm:ml-0">
                        {{-- Previous button --}}
                        @if ($archivedTransactions->onFirstPage())
                            <button disabled class="cursor-not-allowed opacity-50 job_posting_button bg-[#1E2939] text-white px-5 py-2 max-sm:py-2 max-sm:px-5 rounded-lg text-sm max-sm:text-xs">Previous</button>
                        @else
                            <a href="{{ $archivedTransactions->previousPageUrl() }}" class="job_posting_button bg-[#1E2939] text-white px-5 py-2 max-sm:py-2 max-sm:px-5 rounded-lg text-sm max-sm:text-xs">Previous</a>
                        @endif

                        {{-- Next button --}}
                        @if ($archivedTransactions->hasMorePages())
                            <a href="{{ $archivedTransactions->nextPageUrl() }}" class="job_posting_button bg-[#1E2939] text-white px-5 py-2 max-sm:py-2 max-sm:px-5 rounded-lg hover:opacity-90 text-sm max-sm:text-xs">Next</a>
                        @else
                            <button disabled class="cursor-not-allowed opacity-50 job_posting_button bg-[#1E2939] text-white px-5 py-2 max-sm:py-2 max-sm:px-5 rounded-lg text-sm max-sm:text-xs">Next</button>
                        @endif
                    </div>
                </div>
            @endif

        </div>

    </section>

    @include('components.footer_client')

    {{-- modal section --}}

    {{-- delete modal warning --}}
    <div id="delete_job_warning" class="hidden modal_bg min-h-screen fixed top-0 z-40 w-full flex items-center justify-center px-5">
        <div class="px-5 py-3 bg-white rounded-xl -mt-20">
            <h2 class="text-xl sub_title_font font-semibold mb-2">Delete Transaction?</h2>
            <p class="home_p_font text-gray-600 mb-5">This action cannot be undone. <br>Are you sure you want to delete this transaction?</p>

            <div class="flex gap-2">
                <button id="cancel_delete_applicant" type="button"
                    class="bg-[#1e2939] cursor-pointer sub_title_font text-blue-400 px-4 py-2 rounded-lg hover:bg-[#374151] max-sm:text-sm">
                    Cancel
                </button>
            
                <button type="button" id="delete_confirm"
                    class="bg-[#1e2939] cursor-pointer sub_title_font text-red-400 px-4 py-2 rounded-lg hover:bg-[#374151] max-sm:text-sm">
                    Delete
                </button>
            </div>
        </div>
    </div>

    {{-- script section --}}
    {{-- deletion modal script --}}
    <script>
        document.querySelectorAll('.open-delete-modal').forEach(btn => {
            btn.addEventListener('click', function() {
                const form = this.closest('form');
                const modal = document.getElementById('delete_job_warning');
                modal.classList.remove('hidden');

                modal.querySelector('#delete_confirm').onclick = () => {
                    form.submit();
                }

                modal.querySelector('#cancel_delete_applicant').onclick = () => {
                    modal.classList.add('hidden');
                }
            });
        });
    </script>
    
    <script src="{{ asset('js/client.js') }}"></script>
    <script src="{{ asset('js/client/applicants.js') }}"></script>
@endsection