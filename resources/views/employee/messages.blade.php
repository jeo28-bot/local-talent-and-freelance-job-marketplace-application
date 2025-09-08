@extends('layouts.app')

@section('body-class', 'bg-[#F0F0F0] ')

@section('content')
    @include('components.nav')


     <section class="w-ful min-h-[80vh] px-10 py-10 max-sm:py-5 max-sm:px-4 ">
        <div class="xl:w-6xl mx-auto px-5 max-sm:px-3 mb-10">
            <h1 class="sub_title sm:text-xl">Messages</h1>
            <p class="home_p_font mb-5 text-sm">All your chats with clients and companies are organized here.</p>

          

            {{-- Saved Jobs no saved job yet message --}}
            <div class="flex flex-col items-center justify-center py-10 text-center bg-gray-200 rounded-xl">
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
            
                <h2 class="text-xl font-semibold text-gray-800 sub_title_font">No chats yet</h2>
                <p class="text-gray-500 mt-1 home_p_font">Start a chat by applying to a job or replying to an employer.</p>
            </div>


        </div>
        
     </section>

           
@include('components.footer')
    
    
@endsection