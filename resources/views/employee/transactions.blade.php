@extends('layouts.app')

@section('body-class', 'bg-[#F0F0F0]')

@section('content')
    @include('components.nav_employee')
    
    <section class="w-full min-h-[80vh] px-10 py-10 max-sm:py-5 max-sm:px-4">
        
        {{-- pending earnings cards --}}
        <div class="xl:w-6xl mx-auto px-5 max-sm:px-3 mb-10 border-b-2 border-gray-300 pb-10">
            <div>
                <h1 class="sub_title sm:text-xl">Pending Earnings</h1>
                <p class="home_p_font mb-5 text-sm">You can request a payout for your pending earnings once you have completed a job.</p>
            </div>
          
            @if ($transactions->count() > 0)
                @php
                    // Filter out completed transactions
                    $filteredTransactions = $transactions->filter(fn($t) => $t->status !== 'completed');
                @endphp

                @if ($filteredTransactions->count() > 0)
                {{-- payment card 1 sample --}}
                @foreach ($filteredTransactions as $transaction)
                <div class="bg-white rounded-lg shadow-sm mb-5">
                    {{-- Card title --}}
                    <div class="w-full bg-[#1e2939] rounded-t-lg px-4 py-3 flex items-start justify-between">
                        <div>
                            <a class="sub_title_font text-white sm:text-2xl text-lg cursor-pointer hover:underline">
                                {{ $transaction->job_title }}
                            </a>
                            <br>
                            <a class="home_p_font sm:text-lg text-gray-400 cursor-pointer hover:underline">
                                {{ $transaction->client->name ?? 'Unknown Client' }}
                            </a>
                        </div>
                        <button class="cursor-pointer p-1 hover:border-gray-500 border-2 border-transparent rounded-full">
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-6 text-white">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M6.75 12a.75.75 0 1 1-1.5 0 .75.75 0 0 1 1.5 0ZM12.75 12a.75.75 0 1 1-1.5 0 .75.75 0 0 1 1.5 0ZM18.75 12a.75.75 0 1 1-1.5 0 .75.75 0 0 1 1.5 0Z" />
                            </svg>
                        </button>
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
                            <a href="#" class="p-1.5 rounded-full border border-gray-500 hover:bg-gray-200 max-sm:p-1">
                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-6 max-sm:size-5">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M8.625 12a.375.375 0 1 1-.75 0 .375.375 0 0 1 .75 0Zm0 0H8.25m4.125 0a.375.375 0 1 1-.75 0 .375.375 0 0 1 .75 0Zm0 0H12m4.125 0a.375.375 0 1 1-.75 0 .375.375 0 0 1 .75 0Zm0 0h-.375M21 12c0 4.556-4.03 8.25-9 8.25a9.764 9.764 0 0 1-2.555-.337A5.972 5.972 0 0 1 5.41 20.97a5.969 5.969 0 0 1-.474-.065 4.48 4.48 0 0 0 .978-2.025c.09-.457-.133-.901-.467-1.226C3.93 16.178 3 14.189 3 12c0-4.556 4.03-8.25 9-8.25s9 3.694 9 8.25Z" />
                                </svg>
                            </a>
                        </div>

                        <div class="w-full flex justify-end">
                            @if ($transaction->status === 'pending')
                                <form action="{{ route('transactions.requestPayout', $transaction->id) }}" method="POST">
                                    @csrf
                                    <button type="submit" class="bg-[#1e2939] cursor-pointer sub_title_font text-orange-400 px-4 py-2 rounded-lg hover:bg-[#374151] max-sm:text-sm">
                                        Request Payout
                                    </button>
                                </form>
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

            @endif
            

           


        </div>

        {{-- Payments Received cards --}}
        <div class="xl:w-6xl mx-auto px-5 max-sm:px-3 mb-10">
            <h1 class="sub_title sm:text-xl">Payment Received</h1>
            <p class="home_p_font mb-5 text-sm">Here are the payments you have received for completed jobs.</p>

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
                                <a class="sub_title_font text-white sm:text-2xl text-lg cursor-pointer hover:underline">
                                    {{ $transaction->job_title }}
                                </a><br>
                                <a class="home_p_font sm:text-lg text-gray-200 cursor-pointer hover:underline">
                                    {{ $transaction->client->name ?? 'Unknown Client' }}
                                </a>
                            </div>
                            <button class="cursor-pointer p-1 hover:border-gray-500 border-2 border-transparent rounded-full">
                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-6 text-white">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M6.75 12a.75.75 0 1 1-1.5 0 .75.75 0 0 1 1.5 0ZM12.75 12a.75.75 0 1 1-1.5 0 .75.75 0 0 1 1.5 0ZM18.75 12a.75.75 0 1 1-1.5 0 .75.75 0 0 1 1.5 0Z" />
                                </svg>
                            </button>
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
                                    <h2 class="home_p_font text-sm text-gray-500 mb-4">
                                        Status: <span class="text-green-600 font-semibold">Completed</span>
                                    </h2>
                                </div>

                                {{-- View Details button --}}
                                <button class="bg-[#1e2939] sub_title_font text-green-500 px-4 py-2 rounded-lg max-sm:text-sm hover:opacity-80 cursor-pointe ml-auto">
                                    View Details
                                </button>
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
    

       @include('components.footer_employee')
@endsection