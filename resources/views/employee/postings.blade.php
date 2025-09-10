@extends('layouts.app')

@section('body-class', 'bg-[#F0F0F0]')

@section('content')
    @include('components.nav')

        
    <section class="w-full min-h-[80vh] px-10 py-10 max-sm:py-5 max-sm:px-4">
        <div class="xl:w-6xl mx-auto px-5 max-sm:px-3 mb-10">
            <h1 class="sub_title sm:text-xl">Job Posting</h1>
            <p class="home_p_font mb-5 text-sm">Browse the latest opportunities and apply to jobs that fit your skills.</p>

            {{-- no job posted yet message --}}
            <div class="flex flex-col items-center justify-center py-20 text-center bg-gray-200 rounded-xl hidden">
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
            
                <h2 class="text-xl font-semibold text-gray-800 sub_title_font">No job postings yet</h2>
                <p class="text-gray-500 mt-1 home_p_font">Please check back later for available job opportunities.</p>
            </div>


            {{-- sample 1 job posted --}}
           <div class="bg-white w-full rounded-xl mx-auto shadow-lg px-10 max-sm:px-7 py-6 mb-5 ">
                <div class="div_control mb-2 flex flex-row items-center justify-between">
                    <h1 class="job_posting_title text-2xl max-sm:text-xl">Job Title</h1>
                    <svg id="save_icon" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-6 cursor-pointer hover:opacity-60 max-sm:size-5">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M17.593 3.322c1.1.128 1.907 1.077 1.907 2.185V21L12 17.25 4.5 21V5.507c0-1.108.806-2.057 1.907-2.185a48.507 48.507 0 0 1 11.186 0Z" />
                    </svg>
                </div>
                <h2 class="job_posting_company text-xl mb-2 max-sm:text-sm">Company Name</h2>

                <div class="flex items-start  justify-between mb-4 max-sm:flex-col max-sm:gap-3 max-sm:mb-3">
                    <div class="flex flex-col gap-1">
                        <div class="flex items-center gap-1">
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-6 text-[#78818D] max-sm:size-5">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M15 10.5a3 3 0 1 1-6 0 3 3 0 0 1 6 0Z" />
                            <path stroke-linecap="round" stroke-linejoin="round" d="M19.5 10.5c0 7.142-7.5 11.25-7.5 11.25S4.5 17.642 4.5 10.5a7.5 7.5 0 1 1 15 0Z" />
                            </svg>
                            <h4 class="text-[#78818D] text-lg max-sm:text-sm">Location</h4>
                        </div>

                        <div class="flex items-center gap-1">
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-6 text-[#78818D] max-sm:size-5">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M20.25 14.15v4.25c0 1.094-.787 2.036-1.872 2.18-2.087.277-4.216.42-6.378.42s-4.291-.143-6.378-.42c-1.085-.144-1.872-1.086-1.872-2.18v-4.25m16.5 0a2.18 2.18 0 0 0 .75-1.661V8.706c0-1.081-.768-2.015-1.837-2.175a48.114 48.114 0 0 0-3.413-.387m4.5 8.006c-.194.165-.42.295-.673.38A23.978 23.978 0 0 1 12 15.75c-2.648 0-5.195-.429-7.577-1.22a2.016 2.016 0 0 1-.673-.38m0 0A2.18 2.18 0 0 1 3 12.489V8.706c0-1.081.768-2.015 1.837-2.175a48.111 48.111 0 0 1 3.413-.387m7.5 0V5.25A2.25 2.25 0 0 0 13.5 3h-3a2.25 2.25 0 0 0-2.25 2.25v.894m7.5 0a48.667 48.667 0 0 0-7.5 0M12 12.75h.008v.008H12v-.008Z" />
                            </svg>
                            <h4 class="text-[#78818D] text-lg max-sm:text-sm">Job Category</h4>
                        </div>
                    </div>

                    <div class="">
                        <h2 class="job_posting_company salary text-xl max-sm:text-sm">
                        ₱ 25,000 - ₱ 30,000
                        </h2>
                        <h2 class="job_posting_company salary text-right text-xl max-sm:text-sm max-sm:text-left">
                            Salary release
                        </h2>
                    </div>
                </div>
                    <h4 class="job_posting_company text-[#78818D] text-1lg mb-2 max-sm:text-xs">
                        (Short job description Salary release)
                    </h4>
                <div class="div_control flex items-center justify-between max-sm:flex-col ">
                    <div class="div_control max-sm:w-full max-sm:mb-3">
                        <div class="div_control flex gap-2 mb-4 max-sm:gap-1">
                        <h3 class="px-3 py-1 bg-gray-200 rounded-lg job_posting_company hover:bg-gray-300 hover:text-gray-300 max-sm:text-sm max-sm:px-2">Skills</h3>
                        <h3 class="px-3 py-1 bg-gray-200 rounded-lg job_posting_company hover:bg-gray-300 hover:text-gray-300 max-sm:text-sm">Skills</h3>
                        <h3 class="px-3 py-1 bg-gray-200 rounded-lg job_posting_company hover:bg-gray-300 hover:text-gray-300 max-sm:text-sm">Skills</h3>
                        </div>
                        <h4 class="job_posting_company text-sm posted_time_before_a_day max-sm:text-xs flex items-center">
                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="size-5">
                            <path fill-rule="evenodd" d="M12 2.25c-5.385 0-9.75 4.365-9.75 9.75s4.365 9.75 9.75 9.75 9.75-4.365 9.75-9.75S17.385 2.25 12 2.25ZM12.75 6a.75.75 0 0 0-1.5 0v6c0 .414.336.75.75.75h4.5a.75.75 0 0 0 0-1.5h-3.75V6Z" clip-rule="evenodd" />
                            </svg>
                            Posted Time
                        </h4>
                    </div>

                    <a href="{{ route('employee.applying') }}" class="cursor-pointer job_posting_button bg-[#1E2939] text-white px-10 py-3 max-sm:py-3 max-sm:px-5 rounded-lg hover:opacity-90 max-sm:text-sm max-sm:w-full text-center">
                        Apply Now
                    </a>
                </div>
                
           </div>

           {{-- sample 1 job posted --}}
           <div class="bg-white w-full rounded-xl mx-auto shadow-lg px-10 max-sm:px-7 py-6 mb-5 ">
                <div class="div_control mb-2 flex flex-row items-center justify-between">
                    <h1 class="job_posting_title text-2xl max-sm:text-xl">Job Title</h1>
                    <svg id="save_icon" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-6 cursor-pointer hover:opacity-60 max-sm:size-5">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M17.593 3.322c1.1.128 1.907 1.077 1.907 2.185V21L12 17.25 4.5 21V5.507c0-1.108.806-2.057 1.907-2.185a48.507 48.507 0 0 1 11.186 0Z" />
                    </svg>
                </div>
                <h2 class="job_posting_company text-xl mb-2 max-sm:text-sm">Company Name</h2>

                <div class="flex items-start  justify-between mb-4 max-sm:flex-col max-sm:gap-3 max-sm:mb-3">
                    <div class="flex flex-col gap-1">
                        <div class="flex items-center gap-1">
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-6 text-[#78818D] max-sm:size-5">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M15 10.5a3 3 0 1 1-6 0 3 3 0 0 1 6 0Z" />
                            <path stroke-linecap="round" stroke-linejoin="round" d="M19.5 10.5c0 7.142-7.5 11.25-7.5 11.25S4.5 17.642 4.5 10.5a7.5 7.5 0 1 1 15 0Z" />
                            </svg>
                            <h4 class="text-[#78818D] text-lg max-sm:text-sm">Location</h4>
                        </div>

                        <div class="flex items-center gap-1">
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-6 text-[#78818D] max-sm:size-5">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M20.25 14.15v4.25c0 1.094-.787 2.036-1.872 2.18-2.087.277-4.216.42-6.378.42s-4.291-.143-6.378-.42c-1.085-.144-1.872-1.086-1.872-2.18v-4.25m16.5 0a2.18 2.18 0 0 0 .75-1.661V8.706c0-1.081-.768-2.015-1.837-2.175a48.114 48.114 0 0 0-3.413-.387m4.5 8.006c-.194.165-.42.295-.673.38A23.978 23.978 0 0 1 12 15.75c-2.648 0-5.195-.429-7.577-1.22a2.016 2.016 0 0 1-.673-.38m0 0A2.18 2.18 0 0 1 3 12.489V8.706c0-1.081.768-2.015 1.837-2.175a48.111 48.111 0 0 1 3.413-.387m7.5 0V5.25A2.25 2.25 0 0 0 13.5 3h-3a2.25 2.25 0 0 0-2.25 2.25v.894m7.5 0a48.667 48.667 0 0 0-7.5 0M12 12.75h.008v.008H12v-.008Z" />
                            </svg>
                            <h4 class="text-[#78818D] text-lg max-sm:text-sm">Job Category</h4>
                        </div>
                    </div>

                    <div class="">
                        <h2 class="job_posting_company salary text-xl max-sm:text-sm">
                        ₱ 25,000 - ₱ 30,000
                        </h2>
                        <h2 class="job_posting_company salary text-right text-xl max-sm:text-sm max-sm:text-left">
                            Salary release
                        </h2>
                    </div>
                </div>
                    <h4 class="job_posting_company text-[#78818D] text-1lg mb-2 max-sm:text-xs">
                        (Short job description Salary release)
                    </h4>
                <div class="div_control flex items-center justify-between max-sm:flex-col ">
                    <div class="div_control max-sm:w-full max-sm:mb-3">
                        <div class="div_control flex gap-2 mb-4 max-sm:gap-1">
                        <h3 class="px-3 py-1 bg-gray-200 rounded-lg job_posting_company hover:bg-gray-300 hover:text-gray-300 max-sm:text-sm max-sm:px-2">Skills</h3>
                        <h3 class="px-3 py-1 bg-gray-200 rounded-lg job_posting_company hover:bg-gray-300 hover:text-gray-300 max-sm:text-sm">Skills</h3>
                        <h3 class="px-3 py-1 bg-gray-200 rounded-lg job_posting_company hover:bg-gray-300 hover:text-gray-300 max-sm:text-sm">Skills</h3>
                        </div>
                        <h4 class="job_posting_company text-sm posted_time_before_a_day max-sm:text-xs flex items-center">
                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="size-5">
                            <path fill-rule="evenodd" d="M12 2.25c-5.385 0-9.75 4.365-9.75 9.75s4.365 9.75 9.75 9.75 9.75-4.365 9.75-9.75S17.385 2.25 12 2.25ZM12.75 6a.75.75 0 0 0-1.5 0v6c0 .414.336.75.75.75h4.5a.75.75 0 0 0 0-1.5h-3.75V6Z" clip-rule="evenodd" />
                            </svg>
                            Posted Time
                        </h4>
                    </div>

                    <a href="{{ route('employee.applying') }}" class="cursor-pointer job_posting_button bg-[#1E2939] text-white px-10 py-3 max-sm:py-3 max-sm:px-5 rounded-lg hover:opacity-90 max-sm:text-sm max-sm:w-full text-center">
                        Apply Now
                    </a>
                </div>
                
           </div>

           {{-- sample 1 job posted --}}
           <div class="bg-white w-full rounded-xl mx-auto shadow-lg px-10 max-sm:px-7 py-6 mb-5 ">
                <div class="div_control mb-2 flex flex-row items-center justify-between">
                    <h1 class="job_posting_title text-2xl max-sm:text-xl">Job Title</h1>
                    <svg id="save_icon" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-6 cursor-pointer hover:opacity-60 max-sm:size-5">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M17.593 3.322c1.1.128 1.907 1.077 1.907 2.185V21L12 17.25 4.5 21V5.507c0-1.108.806-2.057 1.907-2.185a48.507 48.507 0 0 1 11.186 0Z" />
                    </svg>
                </div>
                <h2 class="job_posting_company text-xl mb-2 max-sm:text-sm">Company Name</h2>

                <div class="flex items-start  justify-between mb-4 max-sm:flex-col max-sm:gap-3 max-sm:mb-3">
                    <div class="flex flex-col gap-1">
                        <div class="flex items-center gap-1">
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-6 text-[#78818D] max-sm:size-5">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M15 10.5a3 3 0 1 1-6 0 3 3 0 0 1 6 0Z" />
                            <path stroke-linecap="round" stroke-linejoin="round" d="M19.5 10.5c0 7.142-7.5 11.25-7.5 11.25S4.5 17.642 4.5 10.5a7.5 7.5 0 1 1 15 0Z" />
                            </svg>
                            <h4 class="text-[#78818D] text-lg max-sm:text-sm">Location</h4>
                        </div>

                        <div class="flex items-center gap-1">
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-6 text-[#78818D] max-sm:size-5">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M20.25 14.15v4.25c0 1.094-.787 2.036-1.872 2.18-2.087.277-4.216.42-6.378.42s-4.291-.143-6.378-.42c-1.085-.144-1.872-1.086-1.872-2.18v-4.25m16.5 0a2.18 2.18 0 0 0 .75-1.661V8.706c0-1.081-.768-2.015-1.837-2.175a48.114 48.114 0 0 0-3.413-.387m4.5 8.006c-.194.165-.42.295-.673.38A23.978 23.978 0 0 1 12 15.75c-2.648 0-5.195-.429-7.577-1.22a2.016 2.016 0 0 1-.673-.38m0 0A2.18 2.18 0 0 1 3 12.489V8.706c0-1.081.768-2.015 1.837-2.175a48.111 48.111 0 0 1 3.413-.387m7.5 0V5.25A2.25 2.25 0 0 0 13.5 3h-3a2.25 2.25 0 0 0-2.25 2.25v.894m7.5 0a48.667 48.667 0 0 0-7.5 0M12 12.75h.008v.008H12v-.008Z" />
                            </svg>
                            <h4 class="text-[#78818D] text-lg max-sm:text-sm">Job Category</h4>
                        </div>
                    </div>

                    <div class="">
                        <h2 class="job_posting_company salary text-xl max-sm:text-sm">
                        ₱ 25,000 - ₱ 30,000
                        </h2>
                        <h2 class="job_posting_company salary text-right text-xl max-sm:text-sm max-sm:text-left">
                            Salary release
                        </h2>
                    </div>
                </div>
                    <h4 class="job_posting_company text-[#78818D] text-1lg mb-2 max-sm:text-xs">
                        (Short job description Salary release)
                    </h4>
                <div class="div_control flex items-center justify-between max-sm:flex-col ">
                    <div class="div_control max-sm:w-full max-sm:mb-3">
                        <div class="div_control flex gap-2 mb-4 max-sm:gap-1">
                        <h3 class="px-3 py-1 bg-gray-200 rounded-lg job_posting_company hover:bg-gray-300 hover:text-gray-300 max-sm:text-sm max-sm:px-2">Skills</h3>
                        <h3 class="px-3 py-1 bg-gray-200 rounded-lg job_posting_company hover:bg-gray-300 hover:text-gray-300 max-sm:text-sm">Skills</h3>
                        <h3 class="px-3 py-1 bg-gray-200 rounded-lg job_posting_company hover:bg-gray-300 hover:text-gray-300 max-sm:text-sm">Skills</h3>
                        </div>
                        <h4 class="job_posting_company text-sm posted_time_before_a_day max-sm:text-xs flex items-center">
                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="size-5">
                            <path fill-rule="evenodd" d="M12 2.25c-5.385 0-9.75 4.365-9.75 9.75s4.365 9.75 9.75 9.75 9.75-4.365 9.75-9.75S17.385 2.25 12 2.25ZM12.75 6a.75.75 0 0 0-1.5 0v6c0 .414.336.75.75.75h4.5a.75.75 0 0 0 0-1.5h-3.75V6Z" clip-rule="evenodd" />
                            </svg>
                            Posted Time
                        </h4>
                    </div>

                    <a href="{{ route('employee.applying') }}" class="cursor-pointer job_posting_button bg-[#1E2939] text-white px-10 py-3 max-sm:py-3 max-sm:px-5 rounded-lg hover:opacity-90 max-sm:text-sm max-sm:w-full text-center">
                        Apply Now
                    </a>
                </div>
                
           </div>

           

           

         {{-- pagination for job posted --}}
            <div id="posting_pagination" class="w-full mx-auto flex items-center max-sm:flex-col max-sm:items-center gap-2 ">
                <h3 class="home_p_font text-sm max-sm:text-xs ">Showing 1 to 3 of 10 results</h3>
                <div class="flex ml-auto gap-2 max-sm:ml-0">
                    <button class="cursor-pointer job_posting_button bg-[#1E2939] text-white px-5 py-2 max-sm:py-2 max-sm:px-3 rounded-lg hover:opacity-90 text-sm max-sm:text-xs">Previous</button>
                    <button class="cursor-pointer job_posting_button bg-[#1E2939] text-white px-5 py-2 max-sm:py-2 max-sm:px-5 rounded-lg hover:opacity-90 text-sm max-sm:text-xs">Next</button>
                </div>
            </div>

      
      
        </div>
    </section>


       @include('components.footer')
@endsection