@extends('layouts.app')

@section('body-class', 'bg-[#F0F0F0]')

@section('content')
     @include('components.nav_admin')


    <!-- main content -->
    <section class="w-full  z-0">
        <div class="pt-35 max-sm:pt-25 pl-85 max-[1270px]:pl-75 max-lg:pl-7  pr-10 max-sm:pr-5 pb-15">
            {{-- padding top --}}
            {{-- title & sub title --}}
            <h1 class="home_p_font font-semibold! max-lg:text-sm text-lg">Applications</h1>
            <p class="home_p_font mb-5 text-sm">Manage and review system applications.</p>
             {{-- export and search bar control div --}}
            <div class="flex justify-between max-sm:gap-3 mb-3 max-sm:flex-col-reverse">
                {{-- export to csv button --}}
                <div>
                    <form action="{{ route('admin.transactions.export') }}" method="GET">
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
            @if ($transactions->isNotEmpty())
            <div id="table_div" class="overflow-x-auto shadow-lg rounded-lg mb-5">
            <table class="w-full min-w-[700px] shadow-lg rounded-lg overflow-hidden">
                <thead class="bg-gray-200 ">
                    <tr class="bg-gray-300 ">
                        <th class="px-4 py-2 text-left sub_title_font font-semibold! uppercase text-sm max-sm:text-xs">#</th>
                        <th class="px-4 py-2 text-left sub_title_font font-semibold! uppercase text-sm max-sm:text-xs">Transaction ID</th>
                        <th class="px-4 py-2 text-left sub_title_font font-semibold! uppercase text-sm max-sm:text-xs">Employee</th>
                        <th class="px-4 py-2 text-left sub_title_font font-semibold! uppercase text-sm max-sm:text-xs">Client </th>
                        <th class="px-4 py-2 text-left sub_title_font font-semibold! uppercase text-sm max-sm:text-xs">Job Title</th>
                        <th class="px-4 py-2 text-left sub_title_font font-semibold! uppercase text-sm max-sm:text-xs">Amount</th>
                        <th class="px-4 py-2 text-left sub_title_font font-semibold! uppercase text-sm max-sm:text-xs">
                            Status
                        </th>
                        <th class="px-4 py-2 text-left sub_title_font font-semibold! uppercase text-sm max-sm:text-xs">Payment Method</th>
                        <th class="px-4 py-2 text-left sub_title_font font-semibold! uppercase text-sm max-sm:text-xs">Receiving acc no.</th>
                        <th class="px-4 py-2 text-left sub_title_font font-semibold! uppercase text-sm max-sm:text-xs">Transaction Ref No.</th>
                        <th class="px-4 py-2 text-left sub_title_font font-semibold! uppercase text-sm max-sm:text-xs">Payment Date</th>
                        <th class="px-4 py-2 text-left sub_title_font font-semibold! uppercase text-sm max-sm:text-xs"></th>
                    </tr>
                </thead>
                
                <tbody>
                    @forelse ($transactions as $transaction)
                    <tr class="border-b-2 border-gray-300 py-2 hover:bg-gray-200">
                        <td class="px-4 py-2 p_font max-lg:text-sm home_p_font">
                            {{ $transactions->firstItem() + $loop->index }}
                        </td>
                        <td class="px-4 py-2 p_font max-lg:text-sm">
                            {{$transaction->id ?? 'N/A' }}
                        </td>
                        <td class="px-4 py-2 p_font max-lg:text-sm">
                            <a href="{{ route('admin.public_profile', ['name' => urlencode($transaction->employee->name)]) }}" class="hover:underline cursor-pointer text-blue-500">
                                {{ $transaction->employee ? $transaction->employee->name : 'N/A' }}
                            </a>
                        </td>
                        </td>
                        <td class="px-4 py-2 p_font max-lg:text-sm">
                            <a href="{{ route('admin.public_profile', ['name' => urlencode($transaction->client->name)]) }}" class="hover:underline cursor-pointer text-blue-500">
                                {{ $transaction->client ? $transaction->client->name : 'N/A' }}
                            </a>
                        </td>
                        </td>
                        <td class="px-4 py-2 p_font max-lg:text-sm">
                        {{$transaction->job_title ?? 'N/A' }}
                        </td>
                        <td class="px-4 py-2 p_font max-lg:text-sm">
                         ₱{{ number_format($transaction->amount, 2) }}
                        </td>
                        <td class="px-4 py-2 p_font max-lg:text-sm uppercase text-sm font-semibold!">
                            <a class="cursor-pointer open-status-modal hover:opacity-65"
                                data-id="{{ $transaction->id }}"
                                data-status="{{ $transaction->status }}">
                                <span class="p-2 rounded-lg border-1
                                    @if($transaction->status === 'pending') text-orange-600  bg-orange-200  border-orange-500
                                    @elseif($transaction->status === 'completed') text-green-600 bg-green-200  border-green-500
                                    @elseif($transaction->status === 'requested') text-yellow-600 bg-yellow-200  border-yellow-500
                                    @elseif($transaction->status === 'cancelled') text-gray-600 bg-gray-200  border-gray-500
                                    @endif">
                                {{ ucfirst($transaction->status) ?? 'N/A'  }}
                                </span>
                            </a>
                        </td>
                        <td class="px-4 py-2 p_font max-lg:text-sm uppercase text-sm font-semibold!">
                            <span class="
                                @if($transaction->payment_method === 'gcash') text-blue-600  
                                @elseif($transaction->payment_method === 'paymaya') text-green-600 
                                @elseif($transaction->payment_method === 'paypal') text-yellow-600 
                                @else text-gray-600 
                                @endif">
                                {{ $transaction->payment_method ?? 'N/A'  }}
                            </span>
                        </td>
                        <td class="px-4 py-2 p_font max-lg:text-sm">
                        {{ $transaction->reference_no ?? 'N/A' }}
                        </td>
                        <td class="px-4 py-2 p_font max-lg:text-sm">
                        {{ $transaction->transaction_ref_no ?? 'N/A' }}
                        </td>
                        <td class="px-4 py-2 p_font max-lg:text-sm">
                        {{ $transaction->payment_date ? \Carbon\Carbon::parse($transaction->payment_date)->format('M d, Y') : '—' }}
                        </td>
                        <td class="px-4 py-2 p_font max-lg:text-sm">
                            <form action="{{ route('admin.transactions.destroy', $transaction->id) }}" method="POST" class="delete-transaction-form">
                                @csrf
                                @method('DELETE')
                                <button type="button"
                                    class="open-delete-modal bg-[#1e2939] p-2 rounded-lg cursor-pointer hover:opacity-70"
                                    data-id="{{ $transaction->id }}"
                                    data-url="{{ route('admin.transactions.destroy', $transaction->id) }}">
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
                <div class="w-full h-[300px] flex flex-col justify-center items-center border-2 border-dashed border-gray-400 rounded-lg mt-1">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-15 mb-2 text-gray-400">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M18 18.72a9.094 9.094 0 0 0 3.741-.479 3 3 0 0 0-4.682-2.72m.94 3.198.001.031c0 .225-.012.447-.037.666A11.944 11.944 0 0 1 12 21c-2.17 0-4.207-.576-5.963-1.584A6.062 6.062 0 0 1 6 18.719m12 0a5.971 5.971 0 0 0-.941-3.197m0 0A5.995 5.995 0 0 0 12 12.75a5.995 5.995 0 0 0-5.058 2.772m0 0a3 3 0 0 0-4.681 2.72 8.986 8.986 0 0 0 3.74.477m.94-3.197a5.971 5.971 0 0 0-.94 3.197M15 6.75a3 3 0 1 1-6 0 3 3 0 0 1 6 0Zm6 3a2.25 2.25 0 1 1-4.5 0 2.25 2.25 0 0 1 4.5 0Zm-13.5 0a2.25 2.25 0 1 1-4.5 0 2.25 2.25 0 0 1 4.5 0Z" />
                    </svg>
                    <p class="p_font text-gray-500 text-center p-5">No transactions yet. Check back later!</p>
                </div>
            @endforelse
            
           {{-- Custom Pagination --}}
            @if ($transactions->total() > 10)
                <div id="posting_pagination" class="w-full mx-auto flex items-center max-sm:flex-col max-sm:items-center gap-2">
                    <h3 class="home_p_font text-sm max-sm:text-xs">
                         {{ $transactions->firstItem() ?? 0 }} to {{ $transactions->lastItem() ?? 0 }} of {{ $transactions->total() ?? 0 }} results
                    </h3>

                    <div class="flex ml-auto gap-2 max-sm:ml-0">
                        {{-- Previous button --}}
                        @if ($transactions->onFirstPage())
                            <button disabled class="-z-1 cursor-not-allowed opacity-50 job_posting_button bg-[#1E2939] text-white px-5 py-2 max-sm:py-2 max-sm:px-5 rounded-lg text-sm max-sm:text-xs">Previous</button>
                        @else
                            <a href="{{ $transactions->previousPageUrl() }}" class="job_posting_button bg-[#1E2939] text-white px-5 py-2 max-sm:py-2 max-sm:px-5 rounded-lg text-sm max-sm:text-xs">Previous</a>
                        @endif

                        {{-- Next button --}}
                        @if ($transactions->hasMorePages())
                            <a href="{{ $transactions->nextPageUrl() }}" class="job_posting_button bg-[#1E2939] text-white px-5 py-2 max-sm:py-2 max-sm:px-5 rounded-lg hover:opacity-90 text-sm max-sm:text-xs">Next</a>
                        @else
                            <button disabled class="-z-1 cursor-not-allowed opacity-50 job_posting_button bg-[#1E2939] text-white px-5 py-2 max-sm:py-2 max-sm:px-5 rounded-lg text-sm max-sm:text-xs">Next</button>
                        @endif
                    </div>
                </div>
            @endif
            {{-- end of pagination --}}




        
        </div>
    </section>

    {{-- Modal section --}}

    {{-- status modal --}}
    <div id="status_modal" class="modal_bg edit_job_modal fixed top-0 left-0 w-full h-full z-50 max-sm:px-6 px-10 hidden">
        <div class="sm:w-xl max-h-[80vh] overflow-y-auto mt-20 mx-auto p-5 max-sm:p-4 bg-gray-200 opacity-100 rounded-xl shadow-sm">
            {{-- modal header --}}
            <div class="flex justify-between items-center mb-2">
                <h3 class="sub_title_font max-sm:text-sm">Transaction Status</h3>
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

                <form id="status_form" action="" method="POST" class="flex gap-2 max-sm:flex-col max-sm:w-full max-lg:gap-2">
                    @csrf
                    @method('PUT')
                    <button type="submit" name="status" value="pending" class="px-4 py-2 border-1 border-orange-600 uppercase text-sm bg-orange-200 text-orange-600 rounded-lg button_font hover:opacity-80 cursor-pointer font-semibold!">Pending</button>
                    <button type="submit" name="status" value="requested" class="px-4 py-2 border-1 border-yellow-600 uppercase text-sm bg-yellow-200 text-yellow-600 rounded-lg button_font hover:opacity-80 cursor-pointer font-semibold!">requested</button>
                    <button type="submit" name="status" value="completed" class="px-4 py-2 border-1 border-green-600 uppercase text-sm bg-green-200 text-green-600 rounded-lg button_font hover:opacity-80 cursor-pointer font-semibold!">completed</button>
                </form>
            </div>
        </div>
    </div>
    

    {{-- delete modal warning --}}
    <div id="delete_transaction_warning" class="hidden modal_bg min-h-screen fixed top-0 z-40 w-full flex items-center justify-center px-5">
        <div class="px-5 py-3 bg-white rounded-xl -mt-20">
            <h2 class="text-xl sub_title_font font-semibold mb-2">Delete Transaction?</h2>
            <p class="home_p_font text-gray-600 mb-5">This action cannot be undone. <br>Are you sure you want to delete this transaction?</p>

            <div class="flex gap-2">
                <button id="cancel_delete_transaction" type="button"
                    class="bg-[#1e2939] cursor-pointer sub_title_font text-blue-400 px-4 py-2 rounded-lg hover:bg-[#374151] max-sm:text-sm">
                    Cancel
                </button>
            
                <button type="button" id="delete_transaction"
                    class="bg-[#1e2939] cursor-pointer sub_title_font text-red-400 px-4 py-2 rounded-lg hover:bg-[#374151] max-sm:text-sm">
                    Delete
                </button>
            </div>
        </div>
    </div>

    {{-- script section--}}

    <script>
    document.addEventListener('DOMContentLoaded', () => {
        const modal = document.getElementById('status_modal');
        const closeModal = document.getElementById('close_status_modal');
        const statusText = document.querySelector('.status_text');
        const form = document.getElementById('status_form');

        document.querySelectorAll('.open-status-modal').forEach(btn => {
            btn.addEventListener('click', () => {
                const id = btn.dataset.id;
                const currentStatus = btn.dataset.status;

                // Set current status text
                statusText.textContent = currentStatus;

                // Set form action (Laravel route)
                form.action = `/admin/transactions/${id}/update-status`;

                modal.classList.remove('hidden');
            });
        });

        // Close modal
        closeModal.addEventListener('click', () => modal.classList.add('hidden'));
        modal.addEventListener('click', (e) => {
            if (e.target === modal) modal.classList.add('hidden');
        });
    });
    </script>

    <script>
    document.addEventListener('DOMContentLoaded', () => {
        const modal = document.getElementById('delete_transaction_warning');
        const cancelBtn = document.getElementById('cancel_delete_transaction');
        const confirmDeleteBtn = document.getElementById('delete_transaction');
        let deleteUrl = ''; // store the URL dynamically

        // open modal
        document.querySelectorAll('.open-delete-modal').forEach(btn => {
            btn.addEventListener('click', () => {
                deleteUrl = btn.dataset.url;
                modal.classList.remove('hidden');
            });
        });

        // cancel delete
        cancelBtn.addEventListener('click', () => {
            modal.classList.add('hidden');
            deleteUrl = '';
        });

        // background click close
        modal.addEventListener('click', (e) => {
            if (e.target === modal) {
                modal.classList.add('hidden');
                deleteUrl = '';
            }
        });

        // confirm delete
        confirmDeleteBtn.addEventListener('click', () => {
            if (!deleteUrl) return;

            const form = document.createElement('form');
            form.method = 'POST';
            form.action = deleteUrl;

            const csrf = document.createElement('input');
            csrf.type = 'hidden';
            csrf.name = '_token';
            csrf.value = '{{ csrf_token() }}';

            const method = document.createElement('input');
            method.type = 'hidden';
            method.name = '_method';
            method.value = 'DELETE';

            form.appendChild(csrf);
            form.appendChild(method);
            document.body.appendChild(form);
            form.submit();
        });
    });
    </script>



  
    <script src="{{ asset('js/admin/nav_admin.js') }}"></script>
@endsection
 