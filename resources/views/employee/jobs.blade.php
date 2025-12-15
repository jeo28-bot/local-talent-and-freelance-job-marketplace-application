@extends('layouts.app')

@section('body-class', 'bg-[#F0F0F0]')

@section('content')
    @include('components.nav_employee')

    {{-- applying content container --}}
    <section class="px-15 py-10 max-sm:px-7 max-sm:py-6 w-full parent_container mb-20">
        <div class=" bg-white rounded-xl shadow-lg xl:w-6xl mx-auto">
            <div class="cover_color h-30 bg-[#1E2939] rounded-t-xl max-sm:h-20"></div>
                {{-- div control for the applying content --}}
                <div class="px-10 content_control pt-10 pb-5 max-sm:px-6">
                    {{-- for company profile --}}
                    <img src="{{asset('assets/corporate.jpg')}}" alt="" class="border-2 rounded-xl border-gray-300 w-20 h-20 -mt-20 mb-5 max-sm:w-15 max-sm:h-15 max-sm:-mt-16">
                    {{-- div for job title and save icon --}}
                    <div class="div_control flex flex-row items-center justify-between">
                        <h1 class="job_posting_title text-2xl max-sm:text-xl">{{$job->job_title}}</h1>
                        @php
                            $isSaved = auth()->check() && auth()->user()->savedJobs->contains($job->id);
                        @endphp

                        <form action="{{ route('employee.jobs.save', $job->id) }}" method="POST">
                            @csrf
                            <button type="submit">
                                <svg xmlns="http://www.w3.org/2000/svg"
                                    fill="{{ $isSaved ? 'currentColor' : 'none' }}"
                                    viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor"
                                    class="size-6 cursor-pointer hover:opacity-60 max-sm:size-5">
                                    <path stroke-linecap="round" stroke-linejoin="round"
                                        d="M17.593 3.322c1.1.128 1.907 1.077 
                                            1.907 2.185V21L12 17.25 4.5 21V5.507c0-1.108.806-2.057 
                                            1.907-2.185a48.507 48.507 0 0 1 11.186 0Z" />
                                </svg>
                            </button>
                        </form>
                    </div>
                         <a href="{{ route('employee.public_profile', $job->client->name) }}"
                            class="job_posting_company text-xl mb-2 max-sm:text-sm capitalize cursor-pointer hover:underline hover:text-blue-700! text-blue-500!">
                            {{ $job->client->name }}
                        </a>
                        <br><br>
                    {{-- parent divv for location, job category --}}
                    <div class="flex  justify-between mb-5 max-sm:flex-col max-sm:gap-3 max-sm:mb-3">
                        {{-- div control for location and job cat --}}
                        <div class="flex flex-col gap-1">
                            {{-- for location --}}
                           

                            <div class="flex items-center gap-1">
                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-6 text-[#78818D] max-sm:size-5">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M15 10.5a3 3 0 1 1-6 0 3 3 0 0 1 6 0Z" />
                                <path stroke-linecap="round" stroke-linejoin="round" d="M19.5 10.5c0 7.142-7.5 11.25-7.5 11.25S4.5 17.642 4.5 10.5a7.5 7.5 0 1 1 15 0Z" />
                                </svg>
                                <h4 class="text-[#78818D] text-lg max-sm:text-sm p_font">{{$job->job_location ?? 'No location specified'}}</h4>
                            </div>
                            {{-- for job category --}}
                            <div class="flex items-center gap-1">
                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-6 text-[#78818D] max-sm:size-5">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M20.25 14.15v4.25c0 1.094-.787 2.036-1.872 2.18-2.087.277-4.216.42-6.378.42s-4.291-.143-6.378-.42c-1.085-.144-1.872-1.086-1.872-2.18v-4.25m16.5 0a2.18 2.18 0 0 0 .75-1.661V8.706c0-1.081-.768-2.015-1.837-2.175a48.114 48.114 0 0 0-3.413-.387m4.5 8.006c-.194.165-.42.295-.673.38A23.978 23.978 0 0 1 12 15.75c-2.648 0-5.195-.429-7.577-1.22a2.016 2.016 0 0 1-.673-.38m0 0A2.18 2.18 0 0 1 3 12.489V8.706c0-1.081.768-2.015 1.837-2.175a48.111 48.111 0 0 1 3.413-.387m7.5 0V5.25A2.25 2.25 0 0 0 13.5 3h-3a2.25 2.25 0 0 0-2.25 2.25v.894m7.5 0a48.667 48.667 0 0 0-7.5 0M12 12.75h.008v.008H12v-.008Z" />
                                </svg>
                                <h4 class="text-[#78818D] text-lg max-sm:text-sm p_font">{{$job->job_type}}</h4>
                            </div>
                        </div>
                        {{-- div control for salary and release --}}
                        <div class="">
                            <h2 class="job_posting_company salary text-xl max-sm:text-sm">
                            ₱{{ number_format($job->job_pay, 2) }}
                            </h2>
                            <h2 class="job_posting_company salary text-right text-xl max-sm:text-sm max-sm:text-left capitalize">
                                {{$job->salary_release}}
                            </h2>
                        </div>
                    </div>
                    {{--short job description --}}
                    <h4 class="job_posting_company text-[#78818D] text-1lg mb-2 max-sm:text-xs">
                        {{$job->short_description}}
                    </h4>
                    {{-- parent div for skills, posted time, and apply button --}}
                    <div class="div_control flex items-center justify-between flex-col">
                        <div class="div_control max-sm:w-full max-sm:mb-3 w-full mb-3">
                            <div class="div_control flex gap-2 mb-4 max-sm:gap-1 flex-wrap">
                                 @foreach(explode(',', $job->skills_required) as $skill)
                                    <h3 class="px-3 py-1 bg-gray-200 rounded-lg job_posting_company hover:bg-gray-300 hover:text-gray-300 max-sm:text-sm max-sm:px-2 capitalize">
                                        {{ trim($skill) }}
                                    </h3>
                                @endforeach
                            </div>
                            <h4 class="job_posting_company text-sm posted_time_before_a_day max-sm:text-xs flex items-center mb-1">
                                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="size-5">
                                <path fill-rule="evenodd" d="M12 2.25c-5.385 0-9.75 4.365-9.75 9.75s4.365 9.75 9.75 9.75 9.75-4.365 9.75-9.75S17.385 2.25 12 2.25ZM12.75 6a.75.75 0 0 0-1.5 0v6c0 .414.336.75.75.75h4.5a.75.75 0 0 0 0-1.5h-3.75V6Z" clip-rule="evenodd" />
                                </svg>
                                {{ $job->created_at->diffForHumans() }}
                            </h4>
                             <h4 class="status_holder job_posting_company text-sm  posted_time_before_a_day max-sm:text-xs flex items-center text-blue-5400! " data-id="{{ $job->id }}" data-status="{{ $job->status }}">
                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="size-5">
                            <path fill-rule="evenodd" d="M2.25 12c0-5.385 4.365-9.75 9.75-9.75s9.75 4.365 9.75 9.75-4.365 9.75-9.75 9.75S2.25 17.385 2.25 12Zm13.36-1.814a.75.75 0 1 0-1.22-.872l-3.236 4.53L9.53 12.22a.75.75 0 0 0-1.06 1.06l2.25 2.25a.75.75 0 0 0 1.14-.094l3.75-5.25Z" clip-rule="evenodd" />
                            </svg>
                            Status:  <span class="status font-semibold ml-1 uppercase
                                        @if($job->status === 'open') text-green-600
                                        @elseif($job->status === 'close') text-red-600
                                        @elseif($job->status === 'pause') text-gray-600
                                        @endif"
                                        data-id="{{ $job->id }}">
                                        {{ $job->status }}
                                    </span>

                             </h4>
                        </div>
                       {{-- apply button --}}
                        @if($job->status === 'open')
                            <a id="quick_apply_button" 
                            class="lg:w-2xl sm:w-lg cursor-pointer job_posting_button bg-[#1E2939] text-white px-10 py-3 max-sm:py-3 max-sm:px-5 rounded-lg hover:opacity-90 max-sm:text-sm max-sm:w-full text-center">
                            Quick Apply
                            </a>
                        @else
                            <button disabled 
                            class="lg:w-2xl sm:w-lg job_posting_button bg-gray-400 text-white px-10 py-3 max-sm:py-3 max-sm:px-5 rounded-lg opacity-60 cursor-not-allowed max-sm:text-sm max-sm:w-full text-center">
                            Quick Apply
                            </button>
                        @endif

                    </div>
                    
                </div>

                {{-- job description div --}}
                <div class="py-5 px-10 max-sm:px-6 max-sm:py-3 border-t-2 border-b-2 border-gray-200">
                    <h1 class="job_posting_title text-xl max-sm:text-lg mb-3 max-sm:mb-1">Job Description</h1>
                    <p class="home_p_font text-lg max-sm:text-sm">{{$job->full_description}}</p>
                </div>
                
                {{-- report button --}}
                <div class="py-5 px-10 max-sm:px-6 max-sm:py-3">
                    <button id="report_job" class="cursor-pointer job_posting_button bg-[#1E2939] text-white px-7 py-3 max-sm:py-3 max-sm:px-5 rounded-lg hover:opacity-90 max-sm:text-sm text-center flex gap-3 max-sm:gap-2 items-center">
                         <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-6 max-sm:size-4 text-white">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M3 3v1.5M3 21v-6m0 0 2.77-.693a9 9 0 0 1 6.208.682l.108.054a9 9 0 0 0 6.086.71l3.114-.732a48.524 48.524 0 0 1-.005-10.499l-3.11.732a9 9 0 0 1-6.085-.711l-.108-.054a9 9 0 0 0-6.208-.682L3 4.5M3 15V4.5" />
                        </svg>
                            Report Job
                    </button>      
                </div>

            </div>
        </div>

    </section>

    {{-- modal section --}}

    {{-- quick apply modal --}}
    <div class="quick_apply_modal fixed top-0 left-0 w-full h-full z-50 max-sm:px-6 hidden">
      {{-- menu control --}}
        <div class="sm:w-2xl mt-20 mx-auto p-5 max-sm:p-4 bg-gray-200 opacity-100 rounded-xl shadow-sm">
            {{-- modal sub title and close button --}}
            <div class="flex justify-between items-center mb-2">
                <h3 class="sub_title_font max-sm:text-sm">Send your message to apply</h3>
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" id="close_quick_apply" class="size-5 cursor-pointer  hover:bg-red-400! rounded-sm max-sm:size-4 bg-gray-300!">
                <path stroke-linecap="round" stroke-linejoin="round" d="M6 18 18 6M6 6l12 12" />
                </svg>
            </div>
             <form action="{{ route('applications.store', $job->id) }}" method="POST" class="w-full bg-white p-3 rounded-lg shadow-sm ">
                @csrf
                <span hidden>
                    <div class="input_control flex flex-col mb-3">
                        <label for="fullName" class="mb-1 home_p_font text-black! max-sm:text-sm">Full Name *</label>
                        <input type="text" id="fullName" name="full_name" placeholder="Enter your full name here" class="p-2 border-2 border-gray-400 rounded-lg max-sm:text-sm bg-gray-200 cursor-default" readonly value="{{ auth()->user()->name }}">
                    </div>
                    <div class="input_control flex flex-col mb-3">
                        <label for="email" class=" mb-1 home_p_font text-black! max-sm:text-sm">Email *</label>
                        <input type="email" id="email" name="email" placeholder="Enter your email here" class="p-2 border-2 border-gray-400 rounded-lg max-sm:text-sm bg-gray-200 cursor-default" value="{{ auth()->user()->email }}" readonly >
                    </div>
                    <div class="input_control flex flex-col mb-3 w-full">
                        <label for="phoneNum" class=" mb-1 home_p_font text-black! max-sm:text-sm">Phone Number *</label>
                        <input type="text" id="phoneNum" name="phone_num" placeholder="+63" class="p-2 w-full border-2 border-gray-400 rounded-lg max-sm:text-sm bg-gray-200 cursor-default" value="{{ auth()->user()->phoneNum }}" readonly>
                    </div>
                </span>
                <div class="input_control flex flex-col mb-3 w-full">
                    <label for="message" class=" mb-1 home_p_font text-black! max-sm:text-sm">Message<span class="text-red-400">*</span></label>
                    <textarea id="message" name="message" class="p-2 w-full border-2 border-gray-400 rounded-lg max-sm:text-sm" required></textarea>
                    
                </div>
                
                <div class="flex">
                <input type="submit" value="Submit & Apply" class="p_font cursor-pointer bg-[#1E2939] text-white px-7 py-3 max-sm:py-3 max-sm:px-5 rounded-lg hover:opacity-90 max-sm:text-sm text-center ml-auto">
                </div>
             </form>
       </div>
    </div>

    <input type="hidden" name="reportable_id" value="{{ $job->id }}">
    <input type="hidden" name="reportable_type" value="App\Models\JobPost">


    {{-- report modal --}}
    <div class="report_modal fixed top-0 left-0 w-full h-full z-50 max-sm:px-6 hidden">
      {{-- menu control --}}
        <div class="w-2xl max-lg:w-xl max-sm:w-full mt-20 mx-auto p-5 max-sm:p-4 bg-gray-200 opacity-100 rounded-xl shadow-sm">
            {{-- modal sub title and close button --}}
            <div class="flex justify-between items-center mb-2">
                <h3 class="sub_title_font max-sm:text-sm">Describe your problem below:</h3>
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" id="close_report_modal" class="size-5 cursor-pointer  hover:bg-red-400! rounded-sm max-sm:size-4 bg-gray-300!">
                <path stroke-linecap="round" stroke-linejoin="round" d="M6 18 18 6M6 6l12 12" />
                </svg>
            </div>
             <form id="reportForm" action="{{ route('reports.store') }}" method="POST" class="w-full bg-white p-3 rounded-lg shadow-sm ">
                @csrf
                <input type="hidden" name="reportable_id" value="{{ $job->id }}">
                <input type="hidden" name="reportable_type" value="App\Models\JobPost">

                <div class="input_control flex flex-col mb-3">
                    <h1 class="p_font max-sm:text-sm text-lg font-semibold!">{{ $job->job_title }}</h1>
                    <h3 class="home_p_font max-sm:text-sm"> {{ $job->client->name }}</h3>
                </div>
                
                <div class="input_control flex flex-col mb-3 w-full">
                    <label for="report_message" class=" mb-1 home_p_font text-black! max-sm:text-sm">
                        Message <span class="text-gray-400">(optional)</span>
                    </label>
                    <textarea id="report_message" name="message" class="p-2 w-full border-2 border-gray-400 rounded-lg max-sm:text-sm"></textarea> 
                </div>
                
                <div class="flex">
                    <input type="submit" value="Submit Report" class="cursor-pointer p_font bg-[#1E2939] text-white px-7 py-3 max-sm:py-3 max-sm:px-5 rounded-lg hover:opacity-90 max-sm:text-sm text-center ml-auto">
                </div>
            </form>

       </div>
    </div>

    <script>
    document.querySelector('#reportForm').addEventListener('submit', async (e) => {
        e.preventDefault();
        
        const formData = new FormData(e.target);

        const response = await fetch(e.target.action, {
            method: 'POST',
            headers: {
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
            },
            body: formData
        });

        const result = await response.json();

        if (result.success) {
            alert(result.message);
            document.querySelector('.report_modal').classList.add('hidden');
        }
    });
    </script>

    @include('components.footer_employee')
@endsection