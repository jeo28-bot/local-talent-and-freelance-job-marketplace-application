@extends('layouts.app')

@section('body-class', 'bg-[#F0F0F0]')

@section('content')
    @include('components.nav_client')
    
    <section class="w-ful min-h-[80vh] px-10 py-10 max-sm:py-5 max-sm:px-4 ">

        <div class="xl:w-6xl mx-auto px-5 max-sm:px-3 mb-10 bg-gray-300 shadow-lg rounded-xl p-6">
            <h1 class="sub_title sm:text-xl">Video Call</h1>
            <p class="home_p_font mb-5 text-sm">This is where your video calls will take place.</p>
            
            {{-- container video call --}}
            <div class="w-full h-[500px] bg-black rounded-lg flex items-center justify-center shadow-lg">
                <video id="localVideo" autoplay muted class="w-1/2 h-full rounded-l-lg"></video>
                <video id="remoteVideo" autoplay class="w-1/2 h-full rounded-r-lg"></video>
            </div>
        
            {{-- buttons --}}
            <div class="mt-5 flex flex-row items-center gap-4 justify-center">
                {{-- mic button --}}
                <button class="p-2 bg-[#1e2939] text-white rounded-full hover:bg-[#374151] cursor-pointer ">
                    {{-- open mic icon --}}
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="size-6 max-sm:size-5 hidden">
                    <path d="M8.25 4.5a3.75 3.75 0 1 1 7.5 0v8.25a3.75 3.75 0 1 1-7.5 0V4.5Z" />
                    <path d="M6 10.5a.75.75 0 0 1 .75.75v1.5a5.25 5.25 0 1 0 10.5 0v-1.5a.75.75 0 0 1 1.5 0v1.5a6.751 6.751 0 0 1-6 6.709v2.291h3a.75.75 0 0 1 0 1.5h-7.5a.75.75 0 0 1 0-1.5h3v-2.291a6.751 6.751 0 0 1-6-6.709v-1.5A.75.75 0 0 1 6 10.5Z" />
                    </svg>
                    {{-- close mic icon --}}
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" aria-hidden="true" data-slot="icon" class="size-6 max-sm:size-5">
                    <path d="M12 .75A3.75 3.75 0 0 0 8.25 4.5v.57l7.5 7.5V4.5A3.75 3.75 0 0 0 12 .75zM6 10.5a.75.75 0 0 0-.75.75v1.5a6.751 6.751 0 0 0 6 6.709v2.291h-3a.75.75 0 0 0 0 1.5h7.5a.75.75 0 0 0 0-1.5h-3v-2.291a6.751 6.751 0 0 0 2.635-.895l-1.108-1.107A5.25 5.25 0 0 1 6.75 12.75v-1.5A.75.75 0 0 0 6 10.5zm12 0a.75.75 0 0 0-.75.75v1.5a5.25 5.25 0 0 1-.146 1.174l1.199 1.199a6.751 6.751 0 0 0 .447-2.373v-1.5a.75.75 0 0 0-.75-.75zm-9.75.93v1.32a3.75 3.75 0 0 0 4.875 3.555L8.25 11.43zM3.511 2.451a.75.75 0 0 0-1.06 1.06l18 18a.75.75 0 1 0 1.06-1.06z"></path>
                    </svg>
                </button>
                {{-- end call button --}}
                <button type="button" class="p_font bg-red-500 hover:bg-red-600 text-white font-semibold py-2 px-4 rounded-lg cursor-pointer">
                    End Call
                </button>
                {{-- vid camera button --}}
                <button class="p-2 bg-[#1e2939] text-white rounded-full hover:bg-[#374151] cursor-pointer">
                    {{-- open cam icon --}}
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="size-6 max-sm:size-5 hidden">
                    <path d="M4.5 4.5a3 3 0 0 0-3 3v9a3 3 0 0 0 3 3h8.25a3 3 0 0 0 3-3v-9a3 3 0 0 0-3-3H4.5ZM19.94 18.75l-2.69-2.69V7.94l2.69-2.69c.944-.945 2.56-.276 2.56 1.06v11.38c0 1.336-1.616 2.005-2.56 1.06Z" />
                    </svg>
                    {{-- close cam icon --}}
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="size-6 max-sm:size-5">
                    <path d="M.97 3.97a.75.75 0 0 1 1.06 0l15 15a.75.75 0 1 1-1.06 1.06l-15-15a.75.75 0 0 1 0-1.06ZM17.25 16.06l2.69 2.69c.944.945 2.56.276 2.56-1.06V6.31c0-1.336-1.616-2.005-2.56-1.06l-2.69 2.69v8.12ZM15.75 7.5v8.068L4.682 4.5h8.068a3 3 0 0 1 3 3ZM1.5 16.5V7.682l11.773 11.773c-.17.03-.345.045-.523.045H4.5a3 3 0 0 1-3-3Z" />
                    </svg>
                </button>
            </div>


        </div>
        
    </section>
    

       @include('components.footer_client')
@endsection