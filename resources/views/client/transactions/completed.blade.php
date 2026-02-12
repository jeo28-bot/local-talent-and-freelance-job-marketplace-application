@extends('layouts.app')

@section('body-class', 'bg-[#F0F0F0]')

@section('content')
    @include('components.nav_client')
    
    <section class="w-full min-h-[80vh] px-10 py-10 max-sm:py-5 max-sm:px-4">
        
        {{-- pending earnings cards --}}
        <div class="xl:w-6xl mx-auto px-5 max-sm:px-3 mb-10 pb-10">
            <div class="flex items-center justify-between max-lg:flex-col max-lg:gap-2 max-xl:items-start max-xl:mb-4 mb-5">
                <div>
                    <h1 class="sub_title sm:text-xl">Completed Payouts</h1>
                    <p class="home_p_font text-sm">Your completed transactions here, go check them out.</p>
                </div>

                {{-- search input div --}}
                <div class="ml-auto max-lg:w-sm max-sm:w-full">
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="size-6 absolute mt-2 max-sm:mt-2 ml-2 max-sm:size-5 max-sm:ml-1.5">
                    <path fill-rule="evenodd" d="M10.5 3.75a6.75 6.75 0 1 0 0 13.5 6.75 6.75 0 0 0 0-13.5ZM2.25 10.5a8.25 8.25 0 1 1 14.59 5.28l4.69 4.69a.75.75 0 1 1-1.06 1.06l-4.69-4.69A8.25 8.25 0 0 1 2.25 10.5Z" clip-rule="evenodd" />
                    </svg>
                    {{-- search inputs --}}
                    <form action="{{ route('client.transactions.completed') }}" method="GET" class="bg-white shadow-sm rounded-lg max-sm:w-full w-sm p_font max-sm:text-sm flex items-center">
                            <input type="text" name="q" value="{{ request('q') }}" class="  pl-10 max-sm:pl-7 py-2 rounded-lg p_font max-sm:text-sm w-sm max-lg:w-full" placeholder="Search job title, user, status, id">
                        <button type="submit" class=" p_font px-2 py-1 bg-[#1e2939] rounded-lg text-sm cursor-pointer text-white hover:opacity-80 ml-2 mr-2 ">Search</button>
                    </form>

                </div>
            </div>

            {{-- question and archive div --}}
            <div  class="flex items-center justify-between mb-3">
                <button id="openInfoModalBtn" class="p-1 rounded-full bg-[#1e2939] text-blue-400 hover:bg-gray-500 cursor-pointer">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" aria-hidden="true" data-slot="icon" class="size-6 max-lg:size-5">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M9.879 7.519c1.171-1.025 3.071-1.025 4.242 0 1.172 1.025 1.172 2.687 0 3.712-.203.179-.43.326-.67.442-.745.361-1.45.999-1.45 1.827v.75M21 12a9 9 0 1 1-18 0 9 9 0 0 1 18 0Zm-9 5.25h.008v.008H12v-.008Z"></path>
                    </svg>
                </button>

                {{-- archived button --}}
                <div class="flex justify-end">
                    <a href="{{route('client.arch_transactions')}}" class="p_font bg-[#1e2939] text-blue-400 px-5 py-2 rounded-lg hover:opacity-80 max-lg:text-sm! max-sm:px-2 max-sm:py-1.5 flex items-center gap-2">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" aria-hidden="true" data-slot="icon" class="size-6 max-lg:size-5">
                        <path stroke-linecap="round" stroke-linejoin="round" d="m20.25 7.5-.625 10.632a2.25 2.25 0 0 1-2.247 2.118H6.622a2.25 2.25 0 0 1-2.247-2.118L3.75 7.5m8.25 3v6.75m0 0-3-3m3 3 3-3M3.375 7.5h17.25c.621 0 1.125-.504 1.125-1.125v-1.5c0-.621-.504-1.125-1.125-1.125H3.375c-.621 0-1.125.504-1.125 1.125v1.5c0 .621.504 1.125 1.125 1.125Z"></path>
                        </svg>
                        Archived Transactions
                    </a>
                </div>
            </div>
            

            {{-- Only show completed transactions --}}
            @php
                $completedTransactions = $transactions->filter(fn($t) => $t->status === 'completed');
            @endphp

            @if ($completedTransactions->count() > 0)
                @foreach ($completedTransactions as $transaction)
                    <div class="bg-white rounded-lg shadow-sm mb-5 border-green-500">
                        {{-- Card title --}}
                        <div class="w-full rounded-t-lg px-4 py-3 flex items-start justify-between bg-[#1e2939]">
                            <div>
                                <a href="{{ route('client.jobs.show', Str::slug($transaction->job_title)) }}" class="sub_title_font text-white sm:text-2xl text-lg cursor-pointer hover:underline">
                                    {{ $transaction->job_title }}
                                </a><br>
                                <a href="{{ route('client.public_profile', $transaction->employee->name) }}" class="home_p_font sm:text-lg text-gray-200 cursor-pointer hover:underline">
                                    {{ $transaction->employee->name ?? 'Unknown Employee' }}
                                </a>
                            </div>
                            <div x-data="{ open: false }" class="relative">
                                <!-- button -->
                                <button 
                                    @click="open = !open" 
                                    class="cursor-pointer p-1 hover:border-gray-500 border-2 border-transparent rounded-full">
                                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" 
                                        stroke-width="1.5" stroke="currentColor" class="size-6 text-white">
                                    <path stroke-linecap="round" stroke-linejoin="round" 
                                            d="M6.75 12a.75.75 0 1 1-1.5 0 .75.75 0 0 1 1.5 0ZM12.75 12a.75.75 0 1 1-1.5 0 .75.75 0 0 1 1.5 0ZM18.75 12a.75.75 0 1 1-1.5 0 .75.75 0 0 1 1.5 0Z" />
                                    </svg>
                                </button>

                                <!-- dropdown -->
                                <div 
                                    x-show="open" 
                                    @click.outside="open = false"
                                    x-transition 
                                    class="absolute right-0 mt-2 w-28 bg-[#1E2939] border border-gray-600 rounded-lg shadow-lg py-2">
                                    
                                    <!-- archive form -->
                                    <form 
                                        action="{{ route('client.transactions.destroy', $transaction->id) }}" 
                                        method="POST" 
                                        onsubmit="return confirm('Are you sure you want to archive this transaction?')">
                                        @csrf
                                        @method('DELETE')
                                        <button 
                                            type="submit" 
                                            class="w-full text-left px-4 py-2 text-sm text-red-400 hover:bg-gray-700 hover:text-red-300 p_font">
                                            Archive
                                        </button>
                                    </form>
                                </div>
                            </div>
                            <script src="//unpkg.com/alpinejs" defer></script>

                        </div>

                        {{-- Card details --}}
                        <div class="px-4 py-3">
                            <div class="flex justify-between flex-col items-baseline">
                                <div>
                                    <h2 class="home_p_font max-sm:text-sm">
                                        Amount <span class="text-green-700">(₱)</span>
                                    </h2>
                                    <h1 class="title_font text-3xl max-sm:text-2xl font-bold text-green-700 mb-2">
                                        {{ number_format($transaction->amount, 2) }}
                                    </h1>
                                    <h2 class="home_p_font text-sm text-gray-500 mb-2">
                                        Date: {{ $transaction->created_at->format('M d, Y') }}
                                    </h2>
                                    <h2 class="home_p_font text-sm text-gray-500 mb-2">
                                        Status: <span class="text-green-600 font-semibold">Completed</span>
                                    </h2>
                                    <h2 class="home_p_font text-sm text-gray-500 mb-4">
                                        Transaction ID: {{ $transaction->id }}
                                    </h2>
                                </div>

                                {{-- View Details button --}}
                                <button class="viewDetailsBtn bg-[#1e2939] cursor-pointer sub_title_font text-green-500 px-4 py-2 rounded-lg max-sm:text-sm hover:opacity-80 cursor-pointe ml-auto"
                                data-job="{{ $transaction->job_title }}"
                                data-client="{{ $transaction->employee->name }}"
                                data-amount="{{ number_format($transaction->amount, 2) }}"
                                data-date="{{ $transaction->created_at->format('M d, Y') }}"
                                data-status="{{ ucfirst($transaction->status) }}"
                                data-payment="{{ $transaction->payment_method }}"
                                data-payment-date="{{ $transaction->payment_date ? \Carbon\Carbon::parse($transaction->payment_date)->format('M d, Y') : 'N/A' }}"
                                data-reference="{{ $transaction->reference_no }}"
                                data-transaction-ref-no="{{ $transaction->transaction_ref_no }}">
                                    View Details
                                </button>
                            </div>
                        </div>
                    </div>
                @endforeach

                 {{-- pagination for transactions --}}
                <div class="xl:w-full mx-auto flex items-center max-sm:flex-col max-sm:items-center gap-2 ">
                    <h3 class="home_p_font text-sm max-sm:text-xs ">
                         {{ $transactions->firstItem() ?? 0 }} to {{ $transactions->lastItem() ?? 0 }} of {{ $transactions->total() }} results
                    </h3>

                    <div class="flex ml-auto gap-2 max-sm:ml-0">
                        {{-- Previous Button --}}
                        @if ($transactions->onFirstPage())
                            <button class="job_posting_button bg-[#1E2939] text-white px-5 py-2 max-sm:py-2 max-sm:px-5 rounded-lg opacity-60 text-sm max-sm:text-xs cursor-not-allowed" disabled>
                                Previous
                            </button>
                        @else
                            <a href="{{ $transactions->previousPageUrl() }}" class="cursor-pointer job_posting_button bg-[#1E2939] text-white px-5 py-2 max-sm:py-2 max-sm:px-5 rounded-lg hover:opacity-90 text-sm max-sm:text-xs">
                                Previous
                            </a>
                        @endif

                        {{-- Next Button --}}
                        @if ($transactions->hasMorePages())
                            <a href="{{ $transactions->nextPageUrl() }}" class="cursor-pointer job_posting_button bg-[#1E2939] text-white px-5 py-2 max-sm:py-2 max-sm:px-5 rounded-lg hover:opacity-90 text-sm max-sm:text-xs">
                                Next
                            </a>
                        @else
                            <button class="job_posting_button bg-[#1E2939] text-white px-5 py-2 max-sm:py-2 max-sm:px-5 rounded-lg opacity-60 text-sm max-sm:text-xs cursor-not-allowed" disabled>
                                Next
                            </button>
                        @endif
                    </div>
                </div>

            @else
                {{-- If no completed transactions --}}
                <div class="flex flex-col items-center justify-center py-10 text-center bg-gray-200 rounded-xl mb-5">
                    <svg xmlns="http://www.w3.org/2000/svg" 
                        fill="none" viewBox="0 0 24 24" 
                        stroke-width="1.5" stroke="currentColor" 
                        class="size-15 max-sm:size-13 text-gray-400 mb-4">
                        <path stroke-linecap="round" stroke-linejoin="round" 
                            d="M9 13h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 
                                2 0 012-2h5.586a1 1 0 01.707.293l5.414 
                                5.414a1 1 0 01.293.707V20a2 2 0 
                                01-2 2z" />
                    </svg>
                
                    <h2 class="text-xl font-semibold text-gray-800 sub_title_font max-sm:text-lg">No completed payments yet</h2>
                    <p class="text-gray-500 mt-1 home_p_font max-sm:text-sm">Once you complete jobs, they’ll appear here.</p>
                </div>
            @endif


        </div>
    </section>

    {{-- view details modal --}}
    <div id="transactionModal" class="report_modal fixed top-0 left-0 w-full h-full z-50 hidden max-sm:px-6 bg-black/50 flex justify-center items-start overflow-y-auto py-10">
        <div class="sm:w-lg mt-20 mx-auto p-5 bg-gray-200 rounded-xl shadow-sm">
            <div class="flex justify-between items-center mb-2 gap-5">
                <h3 class="sub_title_font max-sm:text-sm">Your transaction card complete details</h3>
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" id="closeModalBtn" class="size-5 max-sm:size-4 cursor-pointer hover:bg-red-400 rounded-sm bg-gray-300">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M6 18 18 6M6 6l12 12" />
                </svg>
            </div>

            <div class="w-full bg-white p-3 rounded-lg shadow-sm mb-4">
                <div class="input_control flex flex-col mb-3 max-sm:mb-1">
                    <h1 id="modalJobTitle" class="p_font text-lg font-semibold text-gray-800 max-sm:text-sm capitalize"></h1>
                    <h3 id="modalClient" class="home_p_font max-sm:text-sm capitalize"></h3>
                </div>

                <h2 class="home_p_font max-sm:text-sm">Amount <span class="text-green-700">(₱)</span></h2>
                <h1 id="modalAmount" class="title_font text-3xl font-bold text-green-700 mb-2 max-sm:text-lg"></h1>

                <h2 class="home_p_font text-sm text-gray-500 mb-2 max-sm:text-sm">Date: <span id="modalDate"></span></h2>
                <h2 class="home_p_font text-sm text-gray-500 mb-2 max-sm:text-sm">Status: <span id="modalStatus" class="text-green-600 font-semibold"></span></h2>
                <h2 class="home_p_font text-sm text-gray-500 mb-2 max-sm:text-sm">Payment Method: <span id="modalPayment" class="text-blue-400 font-semibold uppercase"></span></h2>
                <h2 class="home_p_font text-sm text-gray-500 mb-2 max-sm:text-sm">Payment Date: <span id="modalPaymentDate" class="font-semibold"></span></h2>
                <h2 class="home_p_font text-sm text-gray-500 mb-2 max-sm:text-sm">Account #: <span id="modalRef" class="text-black font-semibold"></span></h2>
                <h2 class="home_p_font text-sm text-gray-500 mb-4 max-sm:text-sm">Transaction Ref #: <span id="modalTransacRef" class="text-black font-semibold"></span></h2>
            </div>

            <div class="flex">
                <button id="closeModalBtn2" class="cursor-pointer p_font bg-[#1E2939] text-white px-7 max-sm:px-5 py-3 rounded-lg hover:opacity-90 ml-auto max-sm:text-sm">Close</button>
            </div>
        </div>
    </div>

    {{-- info modal warning --}}
    <div id="infoModal" class="hidden modal_bg min-h-screen fixed top-0 z-40 w-full flex items-center justify-center px-5">
        <div class="px-5 py-3 bg-white rounded-xl -mt-20 w-lg max-sm:w-full shadow-sm">
            <h2 class="text-xl sub_title_font font-semibold mb-2 flex items-center gap-2 text-blue-500 max-sm:text-lg">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" aria-hidden="true" data-slot="icon" class="size-6">
                <path stroke-linecap="round" stroke-linejoin="round" d="M9.879 7.519c1.171-1.025 3.071-1.025 4.242 0 1.172 1.025 1.172 2.687 0 3.712-.203.179-.43.326-.67.442-.745.361-1.45.999-1.45 1.827v.75M21 12a9 9 0 1 1-18 0 9 9 0 0 1 18 0Zm-9 5.25h.008v.008H12v-.008Z"></path>
                </svg>
                Payment Process 
            </h2>
            <p class="home_p_font text-gray-600 mb-5 max-sm:text-sm">
            Payments on this platform are securely handled by the admin as a trusted middleman.
            The client sends the payment to the platform, where it is temporarily held for safety.
            Once the job is completed and confirmed, the payment is then released to the employee.
            This process ensures protection for both parties and promotes fair and secure transactions.
            </p>
            <div class="flex gap-2">
                <button id="closeInfoModalBtn" type="button"
                    class="bg-[#1e2939] cursor-pointer sub_title_font text-blue-400 px-4 py-2 rounded-lg hover:bg-[#374151] max-sm:text-sm">
                    Close
                </button>

            </div>
        </div>
    </div>

    <script>
        const openInfoModalBtn = document.getElementById('openInfoModalBtn');
        const closeInfoModalBtn = document.getElementById('closeInfoModalBtn');
        const infoModal = document.getElementById('infoModal');

        // Open modal
        openInfoModalBtn.addEventListener('click', () => {
            infoModal.classList.remove('hidden');
        });

        // Close modal
        closeInfoModalBtn.addEventListener('click', () => {
            infoModal.classList.add('hidden');
        });

        // Optional: click outside modal to close
        infoModal.addEventListener('click', (e) => {
            if (e.target === infoModal) {
                infoModal.classList.add('hidden');
            }
        });
    </script>


    {{-- script section --}}
   <script>
    document.addEventListener('DOMContentLoaded', () => {
        const modal = document.getElementById('transactionModal');
        const closeModalBtns = [document.getElementById('closeModalBtn'), document.getElementById('closeModalBtn2')];

        const jobTitle = document.getElementById('modalJobTitle');
        const client = document.getElementById('modalClient');
        const amount = document.getElementById('modalAmount');
        const date = document.getElementById('modalDate');
        const status = document.getElementById('modalStatus');
        const payment = document.getElementById('modalPayment');
        const paymentDate = document.getElementById('modalPaymentDate');
        const ref = document.getElementById('modalRef');
        const transacRef = document.getElementById('modalTransacRef');

        // open modal
        document.querySelectorAll('.viewDetailsBtn').forEach(btn => {
            btn.addEventListener('click', () => {
                jobTitle.innerHTML = '<span class="font-semibold">Job : </span>' + btn.dataset.job;
                client.innerHTML = '<span class="font-semibold">Employee : </span>' + btn.dataset.client;
                amount.textContent = btn.dataset.amount;
                date.textContent = btn.dataset.date;
                status.textContent = btn.dataset.status;
                payment.textContent = btn.dataset.payment;
                paymentDate.textContent = btn.dataset.paymentDate;
                ref.textContent = btn.dataset.reference;

                // ✅ correct key name here
                transacRef.textContent = btn.dataset.transactionRefNo || 'N/A';

                modal.classList.remove('hidden');
            });
        });

        // close modal
        closeModalBtns.forEach(btn => 
            btn.addEventListener('click', () => modal.classList.add('hidden'))
        );

        // click outside to close
        modal.addEventListener('click', (e) => {
            if (e.target === modal) modal.classList.add('hidden');
        });
    });
    </script>

        
    @include('components.footer_client')

@endsection