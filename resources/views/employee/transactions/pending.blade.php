@extends('layouts.app')

@section('body-class', 'bg-[#F0F0F0]')

@section('content')
    @include('components.nav_employee')
    
    <section class="w-full min-h-[80vh] px-10 py-10 max-sm:py-5 max-sm:px-4">
        
        {{-- pending earnings cards --}}
        <div class="xl:w-6xl mx-auto px-5 max-sm:px-3 mb-10 pb-10">
            <div class="flex items-center justify-between max-lg:flex-col max-lg:gap-2 max-xl:items-start max-xl:mb-4 mb-5">
                <div>
                    <h1 class="sub_title sm:text-xl">Pending Earnings</h1>
                    <p class="home_p_font text-sm">You can request a payout for your pending earnings once you have completed a job.</p>
                </div>

                {{-- search input div --}}
                <div class="ml-auto max-lg:w-sm max-sm:w-full">
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="size-6 absolute mt-2 max-sm:mt-2 ml-2 max-sm:size-5 max-sm:ml-1.5">
                    <path fill-rule="evenodd" d="M10.5 3.75a6.75 6.75 0 1 0 0 13.5 6.75 6.75 0 0 0 0-13.5ZM2.25 10.5a8.25 8.25 0 1 1 14.59 5.28l4.69 4.69a.75.75 0 1 1-1.06 1.06l-4.69-4.69A8.25 8.25 0 0 1 2.25 10.5Z" clip-rule="evenodd" />
                    </svg>
                    {{-- search inputs --}}
                    <form action="" method="GET" class="bg-white  shadow-sm rounded-lg max-xl:w-full p_font max-sm:text-sm flex items-center">
                            {{-- input 1 job title, skills, company --}}
                            <input type="text" name="q" value=""  value="" class="  pl-10 max-sm:pl-7 py-2 rounded-lg p_font max-sm:text-sm pr-20 w-sm max-lg:w-full" placeholder="Search job title, users, status">
                            
                            
                    
                        <button class=" p_font px-2 py-1 bg-[#1e2939] rounded-lg text-sm cursor-pointer text-white hover:opacity-80 ml-77 max-sm:right-9 absolute ">Search</button>
                    </form>

                </div>


            </div>
       
       

                @if ($transactions->count() > 0)
                {{-- payment card 1 sample --}}
                @foreach ($transactions as $transaction)
                <div class="bg-white rounded-lg shadow-sm mb-5">
                    {{-- Card title --}}
                    <div class="w-full bg-[#1e2939] rounded-t-lg px-4 py-3 flex items-start justify-between">
                        <div>
                            <a href="{{ route('employee.jobs.show', Str::slug($transaction->job_title)) }}" class="sub_title_font text-white sm:text-2xl text-lg cursor-pointer hover:underline">
                                {{ $transaction->job_title }}
                            </a>
                            <br>
                            <a href="{{ route('employee.public_profile', $transaction->client->name) }}" class="home_p_font sm:text-lg text-gray-400 cursor-pointer hover:underline">
                                {{ $transaction->client->name ?? 'Unknown Client' }}
                            </a>
                        </div>
                        {{-- ellipse with drop dropdown --}}
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
                                
                                <!-- delete form -->
                                <form 
                                    action="{{ route('employee.transactions.destroy', $transaction->id) }}" 
                                    method="POST" 
                                    onsubmit="return confirm('Are you sure you want to delete this transaction?')">
                                    @csrf
                                    @method('DELETE')
                                    <button 
                                        type="submit" 
                                        class="w-full text-left px-4 py-2 text-sm text-red-400 hover:bg-gray-700 hover:text-red-300 p_font">
                                        Delete
                                    </button>
                                </form>
                            </div>
                        </div>
                        <script src="//unpkg.com/alpinejs" defer></script>

                    </div>

                    {{-- Card details --}}
                    <div class="px-4 py-3">
                        <div class="flex justify-between items-start">
                            <div>
                                <h2 class="home_p_font max-sm:text-sm">Amount <span class="text-green-700">(₱)</span></h2>
                                <h1 class="title_font text-3xl max-sm:text-2xl font-bold text-green-700 mb-2">
                                    {{ number_format($transaction->amount, 2) }}
                                </h1>
                                <h2 class="home_p_font text-sm text-gray-500 mb-2">
                                    Date: {{ $transaction->created_at->format('M d, Y') }}
                                </h2>
                                <h2 class="home_p_font text-sm text-gray-500 mb-4">
                                    Status: 
                                    @if ($transaction->status === 'pending')
                                        <span class="text-orange-500 font-semibold">Pending</span>
                                    @elseif ($transaction->status === 'paid')
                                        <span class="text-green-500 font-semibold">Paid</span>
                                    @elseif ($transaction->status === 'requested')
                                        <span class="text-blue-500 font-semibold">Requested</span>
                                    @elseif ($transaction->status === 'completed')
                                        <span class="text-gray-600 font-semibold">Completed</span>
                                    @endif
                                </h2>
                            </div>

                            {{-- options button --}}
                            <a href="{{ route('employee.chat', $transaction->client->name) }}" class="p-1.5 rounded-full border border-gray-500 hover:bg-gray-200 max-sm:p-1">
                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-6 max-sm:size-5">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M8.625 12a.375.375 0 1 1-.75 0 .375.375 0 0 1 .75 0Zm0 0H8.25m4.125 0a.375.375 0 1 1-.75 0 .375.375 0 0 1 .75 0Zm0 0H12m4.125 0a.375.375 0 1 1-.75 0 .375.375 0 0 1 .75 0Zm0 0h-.375M21 12c0 4.556-4.03 8.25-9 8.25a9.764 9.764 0 0 1-2.555-.337A5.972 5.972 0 0 1 5.41 20.97a5.969 5.969 0 0 1-.474-.065 4.48 4.48 0 0 0 .978-2.025c.09-.457-.133-.901-.467-1.226C3.93 16.178 3 14.189 3 12c0-4.556 4.03-8.25 9-8.25s9 3.694 9 8.25Z" />
                                </svg>
                            </a>
                        </div>

                       <div class="w-full flex justify-end">
                            @if ($transaction->status === 'pending')
                                <button type="button"
                                    class="bg-[#1e2939] cursor-pointer sub_title_font text-orange-400 px-4 py-2 rounded-lg hover:bg-[#374151] max-sm:text-sm openReqPayoutBtn"
                                    data-transaction-id="{{ $transaction->id }}"
                                    data-job-title="{{ $transaction->job_title }}"
                                    data-amount="{{ number_format($transaction->amount, 2) }}"
                                    data-client-name="{{ $transaction->client->name ?? 'Unknown Client' }}">
                                    Request Payout
                                </button>
                            @else
                                <button class="bg-[#1e2939] sub_title_font text-blue-500 px-4 py-2 rounded-lg max-sm:text-sm opacity-70 cursor-not-allowed">
                                    {{ ucfirst($transaction->status) }}
                                </button>
                            @endif
                        </div>

                    </div>
                </div>
                @endforeach

                {{-- pagination for transactions --}}
                <div class="xl:w-full mx-auto flex items-center max-sm:flex-col max-sm:items-center gap-2 ">
                    <h3 class="home_p_font text-sm max-sm:text-xs ">
                        Showing {{ $transactions->firstItem() ?? 0 }} to {{ $transactions->lastItem() ?? 0 }} of {{ $transactions->total() }} results
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
                {{-- Pending Earnings no transaction yet message --}}
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
                
                    <h2 class="text-xl font-semibold text-gray-800 sub_title_font max-sm:text-lg">No pending earnings yet</h2>
                    <p class="text-gray-500 mt-1 home_p_font max-sm:text-sm">Please check back later.</p>
                </div>
                @endif

          
            
        </div>
            
    </section>

    {{-- modal section --}}

    {{-- request payout modal --}}
    <div id="reqpayoutModal" class="report_modal fixed top-0 left-0 w-full h-full z-50 max-sm:px-6 bg-black/50 flex justify-center items-start overflow-y-auto py-10 hidden">
        <div class="sm:w-lg mt-20 mx-auto p-5 bg-gray-200 rounded-xl shadow-sm">
            <div class="flex justify-between items-center mb-2 gap-5">
                <h3 class="sub_title_font max-sm:text-sm">Input your exact payment details:</h3>
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" id="closeModalBtn" class="size-5 max-sm:size-4 cursor-pointer hover:bg-red-400 rounded-sm bg-gray-300">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M6 18 18 6M6 6l12 12" />
                </svg>
            </div>

            <form id="reqPayoutForm" action="{{ route('employee.transactions.requestPayout') }}" method="POST">
                @csrf
                <input type="hidden" name="transaction_id" id="transaction_id">

                <div class="w-full bg-white p-3 rounded-lg shadow-sm mb-4">
                    <h1 id="modal_job_title" class="p_font text-xl font-semibold text-gray-800 max-sm:text-sm"></h1>
                    <h3 id="modal_client_name" class="home_p_font max-sm:text-sm"></h3>
                    <h3 class="home_p_font max-sm:text-sm mb-2">Amount(₱): <span id="modal_amount" class="text-green-600 font-semibold">12,000</span></h3>

                    <label class="p_font max-sm:text-sm">Payment Method:</label>
                    <select name="payment_method" class="p_font bg-gray-50 border border-gray-300 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 text-blue-500 max-sm:text-xs max-sm:p-1.5 mb-2" required>
                        <option selected disabled>--Choose payment method--</option>
                        <option value="gcash">Gcash</option>
                        <option disabled>Paypal (will be added soon)</option>
                    </select>

                    <label class="p_font max-sm:text-sm">Account number:</label><br>
                    <input type="number" name="reference_no" placeholder="--Account # here--" required class="max-sm:text-sm p-2.5 rounded-lg border border-gray-200 max-sm:p-1.5 w-full mb-2">
                </div>

                <div class="flex">
                    <button id="submitReqPayout" type="submit" class="cursor-pointer p_font bg-[#1E2939] text-white px-7 max-sm:px-5 py-3 rounded-lg hover:opacity-90 ml-auto max-sm:text-sm">
                        Submit
                    </button>
                </div>
            </form>
        </div>
    </div>

    @if (session('success'))
        <script>alert("{{ session('success') }}");</script>
    @endif




   <script>
    document.addEventListener('DOMContentLoaded', () => {
        const modal = document.getElementById('reqpayoutModal');
        const closeBtn = document.getElementById('closeModalBtn');
        const openButtons = document.querySelectorAll('.openReqPayoutBtn');
        const form = document.getElementById('reqPayoutForm');

        openButtons.forEach(btn => {
            btn.addEventListener('click', () => {
                const id = btn.dataset.transactionId;
                const jobTitle = btn.dataset.jobTitle;
                const clientName = btn.dataset.clientName;
                const amount = btn.dataset.amount;

                // Populate modal fields
                document.getElementById('transaction_id').value = id;
                document.getElementById('modal_job_title').textContent = jobTitle;
                document.getElementById('modal_client_name').textContent = clientName;
                document.getElementById('modal_amount').textContent = amount;

                // Show modal
                modal.classList.remove('hidden');
            });
        });

        // Close modal
        closeBtn.addEventListener('click', () => modal.classList.add('hidden'));
    });
    </script>



    @include('components.footer_employee')

@endsection