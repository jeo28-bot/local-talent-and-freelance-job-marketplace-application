@extends('layouts.app')

@section('body-class', 'bg-[#F0F0F0] ')

@section('content')
    @include('components.nav_employee')


    <section class="w-ful min-h-[80vh] px-10 py-10 max-sm:py-5 max-sm:px-4 ">
        <div class="xl:w-4xl mx-auto px-5 max-sm:px-3 mb-10">
            <h1 class="sub_title sm:text-xl">Client Reviews & Ratings</h1>
            <p class="home_p_font mb-5 text-sm">All the clients/companies rating & review are organized here.</p>

            
            @include('components.ratings_card')
        

        </div>
    </section>

   
@include('components.footer_employee')
    
    
@endsection