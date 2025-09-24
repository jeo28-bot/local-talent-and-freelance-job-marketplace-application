@extends('layouts.app')

@section('body-class', 'bg-[#F0F0F0] ')

@section('content')
    @include('components.nav_employee')


     <section class="w-full flex min-h-[80vh] flex-col items-center  px-20 max-lg:px-10 max-sm:px-5 max-sm:pt-5 pt-10">
        <div class="xl:w-6xl max-xl:w-full mx-auto px-5 max-sm:px-2 mb-10">
            <h1 class="sub_title sm:text-xl">Save Jobs</h1>
            <p class="home_p_font mb-5 text-sm">Jobs you’ve marked to check out when the time is right.</p>

            

           {{-- If no saved jobs --}}
            @if ($savedJobs->isEmpty())
                <div id="no_saved_jobs" class="flex flex-col items-center justify-center py-10 text-center bg-gray-200 rounded-xl">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1" stroke="currentColor" class="size-15 text-gray-400 mb-4">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M16.5 3.75V16.5L12 14.25 7.5 16.5V3.75m9 0H18A2.25 2.25 0 0 1 20.25 6v12A2.25 2.25 0 0 1 18 20.25H6A2.25 2.25 0 0 1 3.75 18V6A2.25 2.25 0 0 1 6 3.75h1.5m9 0h-9" />
                    </svg>

                    <h2 class="text-xl  text-gray-800 p_font">No saved jobs yet</h2>
                    <p class="text-gray-500 mt-1 home_p_font">Jobs you save will appear here.</p>
                </div>
            @else

                @foreach ($savedJobs as $job)
                    <div class="bg-white w-full rounded-xl mx-auto shadow-lg px-10 py-6 mb-5 max-lg:px-7 max-sm:py-3 max-sm:px-5">
                            <div class="div_control mb-2 flex flex-row items-center justify-between">
                                <a href="{{ route('employee.jobs.show', Str::slug($job->job_title)) }}" 
                                class="job_posting_title text-2xl max-sm:text-xl capitalize hover:opacity-70 hover:underline">
                                    {{ $job->job_title }}
                                </a>
                                @php
                                                $isSaved = auth()->user()->savedJobs->contains($job->id);
                                            @endphp
                                            <form action="{{ route('employee.jobs.save', $job->id) }}" method="POST">
                                                @csrf
                                                <button type="submit">
                                                    <svg id="save_icon" xmlns="http://www.w3.org/2000/svg" 
                                                        fill="{{ $isSaved ? 'currentColor' : 'none' }}" 
                                                        viewBox="0 0 24 24" stroke-width="1.5" 
                                                        stroke="currentColor" 
                                                        class="size-6 cursor-pointer hover:opacity-60 max-sm:size-5">
                                                        <path stroke-linecap="round" stroke-linejoin="round" 
                                                            d="M17.593 3.322c1.1.128 1.907 1.077 
                                                                1.907 2.185V21L12 17.25 4.5 21V5.507c0-1.108.806-2.057 
                                                                1.907-2.185a48.507 48.507 0 0 1 11.186 0Z" />
                                                    </svg>
                                                </button>
                                            </form>
                            </div>
                         <div class="flex flex-col gap-1">
                            <h2 class="job_posting_company text-xl mb-2 max-sm:text-sm capitalize">{{ $job->client->name }}</h2>

                            <div class="flex items-start  justify-between mb-4 max-sm:flex-col max-sm:gap-3 max-sm:mb-3">
                                <div class="flex flex-col gap-1">
                                    <div class="flex items-center gap-1">
                                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-6 text-[#78818D] max-sm:size-5">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M15 10.5a3 3 0 1 1-6 0 3 3 0 0 1 6 0Z" />
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M19.5 10.5c0 7.142-7.5 11.25-7.5 11.25S4.5 17.642 4.5 10.5a7.5 7.5 0 1 1 15 0Z" />
                                        </svg>
                                        <h4 class="text-[#78818D] text-lg max-sm:text-sm capitalize p_font">{{ $job->job_location }}</h4>
                                    </div>

                                    <div class="flex items-center gap-1">
                                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-6 text-[#78818D] max-sm:size-5">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M20.25 14.15v4.25c0 1.094-.787 2.036-1.872 2.18-2.087.277-4.216.42-6.378.42s-4.291-.143-6.378-.42c-1.085-.144-1.872-1.086-1.872-2.18v-4.25m16.5 0a2.18 2.18 0 0 0 .75-1.661V8.706c0-1.081-.768-2.015-1.837-2.175a48.114 48.114 0 0 0-3.413-.387m4.5 8.006c-.194.165-.42.295-.673.38A23.978 23.978 0 0 1 12 15.75c-2.648 0-5.195-.429-7.577-1.22a2.016 2.016 0 0 1-.673-.38m0 0A2.18 2.18 0 0 1 3 12.489V8.706c0-1.081.768-2.015 1.837-2.175a48.111 48.111 0 0 1 3.413-.387m7.5 0V5.25A2.25 2.25 0 0 0 13.5 3h-3a2.25 2.25 0 0 0-2.25 2.25v.894m7.5 0a48.667 48.667 0 0 0-7.5 0M12 12.75h.008v.008H12v-.008Z" />
                                        </svg>
                                        <h4 class="text-[#78818D] text-lg max-sm:text-sm capitalize p_font">{{ $job->job_type }}</h4>
                                    </div>
                                </div>

                                <div class="">
                                    <h2 class="job_posting_company salary text-xl max-sm:text-sm">
                                        ₱{{ number_format($job->job_pay, 2) }}
                                    </h2>

                                    <h2 class="job_posting_company salary text-right text-xl max-sm:text-sm max-sm:text-left capitalize">
                                        {{ $job->salary_release }}
                                    </h2>
                                </div>
                            </div>
                                <h4 class="job_posting_company text-[#78818D] mb-2 max-sm:text-xs">
                                    {{ $job->short_description }}
                                </h4>
                            <div class="div_control flex justify-between max-sm:flex-col flex-col">
                                <div class="div_control max-sm:w-full max-sm:mb-3">
                                    <div class="div_control flex gap-2 mb-4 max-sm:gap-1 flex-wrap">
                                        @foreach(explode(',', $job->skills_required) as $skill)
                                            <h3 class="px-3 py-1 bg-gray-200 rounded-lg job_posting_company hover:bg-gray-300 hover:text-gray-300 max-sm:text-sm max-sm:px-2 capitalize">
                                                {{ trim($skill) }}
                                            </h3>
                                        @endforeach
                                    </div>

                                    <div class="flex gap-5 max-sm:gap-2 max-sm:flex-col">
                                        <h4 class="job_posting_company text-sm posted_time_before_a_day max-sm:text-xs flex items-center">
                                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="size-5">
                                            <path fill-rule="evenodd" d="M12 2.25c-5.385 0-9.75 4.365-9.75 9.75s4.365 9.75 9.75 9.75 9.75-4.365 9.75-9.75S17.385 2.25 12 2.25ZM12.75 6a.75.75 0 0 0-1.5 0v6c0 .414.336.75.75.75h4.5a.75.75 0 0 0 0-1.5h-3.75V6Z" clip-rule="evenodd" />
                                            </svg>
                                            <span id="posted_time" class=" font-semibold ml-1"> {{ $job->created_at->diffForHumans() }}</span>
                                        </h4>
                                        <h4 class="status_holder job_posting_company text-sm  posted_time_before_a_day max-sm:text-xs flex items-center text-blue-5400! font-semibold! " data-id="{{ $job->id }}" data-status="{{ $job->status }}">
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
                                </div>
                                {{-- button actions --}}
                                <div class="flex gap-3 max-sm:flex-col max-sm:w-full max-lg:gap-2 ml-auto">
                                    <!-- edit details button -->
                                    <a href="{{ route('employee.jobs.show', Str::slug($job->job_title)) }}" id="edit_job_button" class="edit_job_button job_posting_button cursor-pointer job_posting_button bg-[#1E2939] text-white px-5 py-3 max-sm:py-3 max-sm:px-5 rounded-lg hover:opacity-90 max-sm:text-sm max-sm:w-full text-center max-lg:text-sm max-lg:px-4 max-lg:py-3">
                                        Apply Now
                                    </a>                      
                                </div>


                        </div>
                    </div>
                
                </div>
                @endforeach

                {{-- Pagination --}}
                {{ $savedJobs->links() }}
            @endif




        </div>
        
     </section>

           
@include('components.footer_employee')
    
    
@endsection