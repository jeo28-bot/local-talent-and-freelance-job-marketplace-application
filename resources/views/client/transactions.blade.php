@extends('layouts.app')

@section('body-class', 'bg-[#F0F0F0]')

@section('content')
    @include('components.nav_client')


    <!-- main content -->
    <section class="w-full flex min-h-[80vh] flex-col items-center  px-20 max-sm:px-10 pt-10">

        
    
    </section>



    @include('components.footer_client')

    
    <script src="{{ asset('js/client.js') }}"></script>
@endsection