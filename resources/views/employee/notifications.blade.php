@extends('layouts.app')

@section('body-class', 'bg-[#F0F0F0] ')

@section('content')
    @include('components.nav')


     <section class="w-ful min-h-[80vh] px-10 py-10 max-sm:py-5 max-sm:px-4 ">
        <div class="xl:w-6xl mx-auto px-5 max-sm:px-3 mb-10">
            <h1 class="sub_title sm:text-xl">Notifications</h1>
            <p class="home_p_font mb-5 text-sm">All your chats with clients and companies are organized here.</p>

          

            {{-- Saved Jobs no saved job yet message --}}
            <div class="flex flex-col items-center justify-center py-10 text-center bg-gray-200 rounded-xl">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-16 h-16 text-gray-400 mb-4">
                <path stroke-linecap="round" stroke-linejoin="round" d="M14.857 17.082a23.848 23.848 0 0 0 5.454-1.31A8.967 8.967 0 0 1 18 9.75V9A6 6 0 0 0 6 9v.75a8.967 8.967 0 0 1-2.312 6.022c1.733.64 3.56 1.085 5.455 1.31m5.714 0a24.255 24.255 0 0 1-5.714 0m5.714 0a3 3 0 1 1-5.714 0M3.124 7.5A8.969 8.969 0 0 1 5.292 3m13.416 0a8.969 8.969 0 0 1 2.168 4.5" />
                </svg>

                <h2 class="text-xl font-semibold text-gray-800 sub_title_font">No notification right now.</h2>
                <p class="text-gray-500 mt-1 home_p_font">This is where we’ll notify you about your job applications and other useful information to help you with your job search.</p>
            </div>


        </div>
        
     </section>

           
@include('components.footer')
    
    
@endsection