@extends('layouts.app')

@section('body-class', 'bg-[#F0F0F0]')

@section('content')
    @include('components.nav_client')

    {{-- parent section --}}
    <section class="w-full min-h-[80vh] px-10 py-10 max-sm:py-5 max-sm:px-4">
        
        {{-- pending earnings cards --}}
        <div class="xl:w-6xl mx-auto px-5 max-sm:px-3 mb-10 border-b-2 border-gray-300 pb-10">
            <h1 class="sub_title sm:text-xl">Pending Earnings</h1>
            <p class="home_p_font mb-5 text-sm">You can request a payout for your pending earnings once you have completed a job.</p>

            {{-- payment card 1 sample --}}
            <div class=" bg-white rounded-lg shadow-sm mb-5 ">
                {{-- card title and sub title --}}
                <div class="w-full bg-[#1e2939] rounded-t-lg px-4 py-3">
                    <h1 class="sub_title_font text-white sm:text-2xl">Job Name</h1>
                    <h1 class="home_p_font sm:text-lg text-gray-400!">Company name</h1>
                </div>
                {{-- card details --}}
                <div class="px-4 py-3">
                    <h2 class="home_p_font max-sm:text-sm">Amount (₱)</h2>
                    <h1 class="title_font text-3xl max-sm:text-2xl font-bold text-[#1e2939] mb-2">5,000.00</h1>
                    <h2 class="home_p_font text-sm text-gray-500 mb-4">Date: June 20, 2024</h2>
                    <div class="w-full flex justify-end">
                        <button class="bg-[#1e2939] cursor-pointer sub_title_font text-blue-400 px-4 py-2 rounded-lg hover:bg-[#374151] max-sm:text-sm">Request Payout</button>
                    </div>
                </div>       
            </div>

            {{-- payment card 1 sample --}}
            <div class=" bg-white rounded-lg shadow-sm mb-5 ">
                {{-- card title and sub title --}}
                <div class="w-full bg-[#1e2939] rounded-t-lg px-4 py-3">
                    <h1 class="sub_title_font text-white sm:text-2xl">Job Name</h1>
                    <h1 class="home_p_font sm:text-lg text-gray-400!">Company name</h1>
                </div>
                {{-- card details --}}
                <div class="px-4 py-3">
                    <h2 class="home_p_font max-sm:text-sm">Amount (₱)</h2>
                    <h1 class="title_font text-3xl max-sm:text-2xl font-bold text-[#1e2939] mb-2">5,000.00</h1>
                    <h2 class="home_p_font text-sm text-gray-500 mb-4">Date: June 20, 2024</h2>
                    <div class="w-full flex justify-end">
                        <button class="bg-[#1e2939] cursor-pointer sub_title_font text-blue-400 px-4 py-2 rounded-lg hover:bg-[#374151] max-sm:text-sm">Request Payout</button>
                    </div>
                </div>       
            </div>

            
            

            {{-- Pending Earnings no transaction yet message --}}
            <div class="flex flex-col items-center justify-center py-10 text-center bg-gray-200 rounded-xl hidden">
                <svg xmlns="http://www.w3.org/2000/svg" 
                    fill="none" viewBox="0 0 24 24" 
                    stroke-width="1.5" stroke="currentColor" 
                    class="w-16 h-16 text-gray-400 mb-4">
                    <path stroke-linecap="round" stroke-linejoin="round" 
                        d="M9 13h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 
                            2 0 012-2h5.586a1 1 0 01.707.293l5.414 
                            5.414a1 1 0 01.293.707V20a2 2 0 
                            01-2 2z" />
                </svg>
            
                <h2 class="text-xl font-semibold text-gray-800 sub_title_font">No pending earnings yet</h2>
                <p class="text-gray-500 mt-1 home_p_font">Please check back later.</p>
            </div>

             {{-- pagination for job posted --}}
            <div id="" class="xl:w-full mx-auto flex items-center max-sm:flex-col max-sm:items-center gap-2 ">
                <h3 class="home_p_font text-sm max-sm:text-xs ">Showing 1 to 3 of 10 results</h3>
                <div class="flex ml-auto gap-2 max-sm:ml-0">
                    <button class="cursor-pointer job_posting_button bg-[#1E2939] text-white px-5 py-2 max-sm:py-2 max-sm:px-3 rounded-lg hover:opacity-90 text-sm max-sm:text-xs">Previous</button>
                    <button class="cursor-pointer job_posting_button bg-[#1E2939] text-white px-5 py-2 max-sm:py-2 max-sm:px-5 rounded-lg hover:opacity-90 text-sm max-sm:text-xs">Next</button>
                </div>
            </div>

        </div>

        {{-- Payments Received cards --}}
        <div class="xl:w-6xl mx-auto px-5 max-sm:px-3 mb-10">
            <h1 class="sub_title sm:text-xl">Payment Received</h1>
            <p class="home_p_font mb-5 text-sm">Here are the payments you have received for completed jobs.</p>
            {{-- payment received cards here --}}
            
            {{-- payment card 1 sample --}}
            <div class=" bg-white rounded-lg shadow-sm mb-5 ">
                {{-- card title and sub title --}}
                <div class="w-full bg-[#1e2939] rounded-t-lg px-4 py-3">
                    <h1 class="sub_title_font text-white sm:text-2xl">Job Name</h1>
                    <h1 class="home_p_font sm:text-lg text-gray-400!">Company name</h1>
                </div>
                {{-- card details --}}
                <div class="px-4 py-3">
                    <h2 class="home_p_font max-sm:text-sm">Amount (₱)</h2>
                    <h1 class="title_font text-3xl max-sm:text-2xl font-bold text-[#1e2939] mb-2">5,000.00</h1>
                    <h2 class="home_p_font text-sm text-gray-500 mb-4">Date: June 20, 2024</h2>
                    <div class="w-full flex justify-end">
                        <button class="bg-[#1e2939] cursor-pointer sub_title_font text-blue-400 px-4 py-2 rounded-lg hover:bg-[#374151] max-sm:text-sm">View Details</button>
                    </div>
                </div>       
            </div>

            {{-- Payment Received no transaction yet message --}}
            <div class="flex flex-col items-center justify-center py-10 text-center bg-gray-200 rounded-xl hidden">
                <svg xmlns="http://www.w3.org/2000/svg" 
                    fill="none" viewBox="0 0 24 24" 
                    stroke-width="1.5" stroke="currentColor" 
                    class="w-16 h-16 text-gray-400 mb-4">
                    <path stroke-linecap="round" stroke-linejoin="round" 
                        d="M9 13h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 
                            2 0 012-2h5.586a1 1 0 01.707.293l5.414 
                            5.414a1 1 0 01.293.707V20a2 2 0 
                            01-2 2z" />
                </svg>
            
                <h2 class="text-xl font-semibold text-gray-800 sub_title_font">No payment received yet</h2>
                <p class="text-gray-500 mt-1 home_p_font">Please check back later.</p>
            </div>

            {{-- pagination for job posted --}}
            <div id="" class="xl:w-full mx-auto flex items-center max-sm:flex-col max-sm:items-center gap-2 ">
                <h3 class="home_p_font text-sm max-sm:text-xs ">Showing 1 to 3 of 10 results</h3>
                <div class="flex ml-auto gap-2 max-sm:ml-0">
                    <button class="cursor-pointer job_posting_button bg-[#1E2939] text-white px-5 py-2 max-sm:py-2 max-sm:px-3 rounded-lg hover:opacity-90 text-sm max-sm:text-xs">Previous</button>
                    <button class="cursor-pointer job_posting_button bg-[#1E2939] text-white px-5 py-2 max-sm:py-2 max-sm:px-5 rounded-lg hover:opacity-90 text-sm max-sm:text-xs">Next</button>
                </div>
            </div>

        </div>



    </section>



    @include('components.footer_client')

    
    <script src="{{ asset('js/client.js') }}"></script>
@endsection