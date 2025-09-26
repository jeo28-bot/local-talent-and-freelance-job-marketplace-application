@extends('layouts.app')

@section('body-class', 'bg-[#F0F0F0] ')

@section('content')
    @include('components.nav_client')


     <section class="w-ful min-h-[80vh] px-10 py-10 max-sm:py-5 max-sm:px-4 ">
        <div class="sm:w-2xl mx-auto px-5 max-sm:px-3 mb-10">
            <div class="flex items-center justify-between">
            <a class="sub_title sm:text-4xl text-lg hover:underline cursor-pointer">{{ Auth::user()->name }}</a>

             <img 
                    src="{{ Auth::user()->profile_pic ? asset('storage/' . Auth::user()->profile_pic) : asset('assets/defaultUserPic.png') }}" 
                    alt="profile pic" 
                    class="profile_pic_clicked w-30 h-30 max-sm:w-20 max-sm:h-20 rounded-full border-3 bg-[#1e2939] border-gray-400 my-3 shadow-sm cursor-pointer">
                    
            </div>

            {{-- mail, phone, address section --}}
            <p class="home_p_font mb-1 text-sm flex items-center gap-2">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-6">
                <path stroke-linecap="round" stroke-linejoin="round" d="M21.75 6.75v10.5a2.25 2.25 0 0 1-2.25 2.25h-15a2.25 2.25 0 0 1-2.25-2.25V6.75m19.5 0A2.25 2.25 0 0 0 19.5 4.5h-15a2.25 2.25 0 0 0-2.25 2.25m19.5 0v.243a2.25 2.25 0 0 1-1.07 1.916l-7.5 4.615a2.25 2.25 0 0 1-2.36 0L3.32 8.91a2.25 2.25 0 0 1-1.07-1.916V6.75" />
                </svg>
            {{ Auth::user()->email }}</p>
            <p class="home_p_font mb-1 text-sm flex items-center gap-2">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-6">
                <path stroke-linecap="round" stroke-linejoin="round" d="M2.25 6.75c0 8.284 6.716 15 15 15h2.25a2.25 2.25 0 0 0 2.25-2.25v-1.372c0-.516-.351-.966-.852-1.091l-4.423-1.106c-.44-.11-.902.055-1.173.417l-.97 1.293c-.282.376-.769.542-1.21.38a12.035 12.035 0 0 1-7.143-7.143c-.162-.441.004-.928.38-1.21l1.293-.97c.363-.271.527-.734.417-1.173L6.963 3.102a1.125 1.125 0 0 0-1.091-.852H4.5A2.25 2.25 0 0 0 2.25 4.5v2.25Z" />
                </svg>
            {{ Auth::user()->phoneNum }}</p>
            <p class="home_p_font mb-5 text-sm flex items-center gap-2">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-6">
                <path stroke-linecap="round" stroke-linejoin="round" d="M15 10.5a3 3 0 1 1-6 0 3 3 0 0 1 6 0Z" />
                <path stroke-linecap="round" stroke-linejoin="round" d="M19.5 10.5c0 7.142-7.5 11.25-7.5 11.25S4.5 17.642 4.5 10.5a7.5 7.5 0 1 1 15 0Z" />
                </svg>
            {{ Auth::user()->address }}</p>

        {{-- about section --}}
            <div class="flex items-center justify-between mb-2">
                <h1 class="sub_title sm:text-2xl flex items-center gap-2">
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="size-6">
                    <path fill-rule="evenodd" d="M2.25 12c0-5.385 4.365-9.75 9.75-9.75s9.75 4.365 9.75 9.75-4.365 9.75-9.75 9.75S2.25 17.385 2.25 12Zm8.706-1.442c1.146-.573 2.437.463 2.126 1.706l-.709 2.836.042-.02a.75.75 0 0 1 .67 1.34l-.04.022c-1.147.573-2.438-.463-2.127-1.706l.71-2.836-.042.02a.75.75 0 1 1-.671-1.34l.041-.022ZM12 9a.75.75 0 1 0 0-1.5.75.75 0 0 0 0 1.5Z" clip-rule="evenodd" />
                    </svg>

                About</h1>

                <button id="edit_about_button" href="#" class="hover:opacity-60 cursor-pointer hidden">
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="size-6 max-sm:size-4">
                    <path d="M21.731 2.269a2.625 2.625 0 0 0-3.712 0l-1.157 1.157 3.712 3.712 1.157-1.157a2.625 2.625 0 0 0 0-3.712ZM19.513 8.199l-3.712-3.712-12.15 12.15a5.25 5.25 0 0 0-1.32 2.214l-.8 2.685a.75.75 0 0 0 .933.933l2.685-.8a5.25 5.25 0 0 0 2.214-1.32L19.513 8.2Z" />
                    </svg>
                </button>
            </div>
             {{-- about texts --}}
                @if (!empty(auth()->user()->about_details))
                    <div id="skills_added_table" class="flex flex-row flex-wrap gap-2 mb-10 bg-white px-5 py-3 rounded-lg shadow-sm">
                        <p class="about_details_p p_font max-sm:text-sm">
                            {!! nl2br(e(auth()->user()->about_details)) !!}
                        </p>
                    </div>
                @else
                    <div class="flex flex-row flex-wrap gap-2 bg-gray-300 px-10 py-5 rounded-lg max-sm:px-5 max-sm:text-sm mb-5">
                        <p class="home_p_font text-gray-600 italic text-center">
                            No about details added yet.
                        </p>
                    </div>
                @endif

        
             {{-- credentials section --}}
            <div class="flex items-center justify-between mb-3">
                <h1 class="sub_title sm:text-2xl flex items-center gap-2 ">
                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="size-6">
                        <path d="M5.625 1.5c-1.036 0-1.875.84-1.875 1.875v17.25c0 1.035.84 1.875 1.875 1.875h12.75c1.035 0 1.875-.84 1.875-1.875V12.75A3.75 3.75 0 0 0 16.5 9h-1.875a1.875 1.875 0 0 1-1.875-1.875V5.25A3.75 3.75 0 0 0 9 1.5H5.625Z" />
                        <path d="M12.971 1.816A5.23 5.23 0 0 1 14.25 5.25v1.875c0 .207.168.375.375.375H16.5a5.23 5.23 0 0 1 3.434 1.279 9.768 9.768 0 0 0-6.963-6.963Z" />
                        </svg>
                    Credentials</h1>

                <a id="edit_credentials" href="#" class="hover:opacity-60 hidden">
                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="size-6 max-sm:size-4">
                <path d="M21.731 2.269a2.625 2.625 0 0 0-3.712 0l-1.157 1.157 3.712 3.712 1.157-1.157a2.625 2.625 0 0 0 0-3.712ZM19.513 8.199l-3.712-3.712-12.15 12.15a5.25 5.25 0 0 0-1.32 2.214l-.8 2.685a.75.75 0 0 0 .933.933l2.685-.8a5.25 5.25 0 0 0 2.214-1.32L19.513 8.2Z" />
                </svg>
                </a>
            </div>


        {{-- credentials Files, Images section --}}
             <div class="mb-5">
                {{-- file uploads --}}
                <h1 class="sub_title_font text-1sm">File Uploads</h1>
                    <div class="p-4 bg-gray-300 rounded-lg shadow-sm mb-4 flex flex-col gap-3">
                        @forelse(auth()->user()->uploads->where('type','file') as $file)
                        <div class="p_font flex items-center bg-white px-4 py-2 rounded-xl gap-2 shadow-sm cursor-pointer hover:bg-gray-200">
                            {{-- File icon --}}
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                stroke-width="1.5" stroke="currentColor" class="size-8 max-sm:size-8 flex">
                                <path stroke-linecap="round" stroke-linejoin="round"
                                    d="M19.5 14.25v-2.625a3.375 3.375 0 0 0-3.375-3.375h-1.5A1.125 1.125 0 0 1 13.5 7.125v-1.5a3.375 3.375 0 0 0-3.375-3.375H8.25m0 12.75h7.5m-7.5 3H12M10.5 2.25H5.625c-.621 0-1.125.504-1.125 1.125v17.25c0 .621.504 1.125 1.125 1.125h12.75c.621 0 1.125-.504 1.125-1.125V11.25a9 9 0 0 0-9-9Z" />
                            </svg>

                            {{-- File name (click to download) --}}
                            <a href="{{ asset('storage/' . $file->path) }}" target="_blank"
                            class="file_name hover:underline text-sm w-120 overflow-hidden text-nowrap">
                                {{ $file->original_name }}
                            </a>

                            {{-- Ellipsis icon for delete menu --}}
                            <button class="open-delete-modal cursor-pointer hidden" 
                                    data-url="{{ route('uploads.destroy', $file->id) }}">
                                <svg xmlns="http://www.w3.org/2000/svg" fill="none"
                                    viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor"
                                    class="size-8 max-sm:size-6 flex ml-auto hover:bg-red-400 rounded-full">
                                    <path stroke-linecap="round" stroke-linejoin="round"
                                        d="M6.75 12a.75.75 0 1 1-1.5 0 .75.75 0 0 1 1.5 0ZM12.75 12a.75.75 0 1 1-1.5 0 .75.75 0 0 1 1.5 0ZM18.75 12a.75.75 0 1 1-1.5 0 .75.75 0 0 1 1.5 0Z" />
                                </svg>
                            </button>

                        </div>
                         @empty
                            <div class="flex flex-row flex-wrap gap-2 bg-gray-300 px-10 py-5 rounded-lg max-sm:px-5 max-sm:text-sm">
                                <p class="home_p_font text-gray-600 italic text-center">No file uploads yet. </p>
                            </div>
                        @endforelse
                    </div>

                {{-- images uploads --}}
                <h1 class="sub_title_font text-1sm">Image Uploads</h1>
                    <div class="p-4 bg-gray-300 rounded-lg shadow-s mb-4">

                        @php
                            $images = auth()->user()->uploads->where('type', 'image');
                        @endphp

                        @if ($images->count() > 0)
                            {{-- big preview (default to first image) --}}
                            <div class="flex justify-end-safe">
                            <img id="bigPreview"
                                src="{{ Storage::url($images->first()->path) }}"
                                alt="Preview"
                                class="w-full rounded-lg shadow-lg cursor-pointer mb-2">
                                {{-- image delete button --}}
                                <button id="deleteImageBtn" type="button" class="absolute mt-2 mr-2 hidden">
                                    <svg xmlns="http://www.w3.org/2000/svg" fill="none"
                                        viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor"
                                        class="size-8 text-white max-sm:size-6 flex ml-auto hover:bg-red-400 bg-[#0000005e] rounded-full cursor-pointer">
                                        <path stroke-linecap="round" stroke-linejoin="round"
                                            d="M6.75 12a.75.75 0 1 1-1.5 0 .75.75 0 0 1 1.5 0ZM12.75 12a.75.75 0 1 1-1.5 0 .75.75 0 0 1 1.5 0ZM18.75 12a.75.75 0 1 1-1.5 0 .75.75 0 0 1 1.5 0Z" />
                                    </svg>
                                </button>

                            </div>

                            <!-- Fullscreen image modal -->
                            <div id="imageModal" 
                                class="fixed inset-0 bg-[#000000b0] flex items-center justify-center hidden z-50 py-20 px-5">
                                <img id="modalImage" src="" 
                                    class="max-w-full max-h-full rounded-lg shadow-lg">
                                <button id="closeImageModal" 
                                    class="absolute top-4 right-4 text-white text-3xl font-bold cursor-pointer hover:text-gray-400">
                                    &times;
                                </button>
                            </div>


                            {{-- thumbnails --}}
                            <div class="flex gap-4 overflow-x-auto p-3 bg-gray-200 shadow-sm rounded-lg">
                                @foreach ($images as $img)
                                    <img src="{{ Storage::url($img->path) }}"
                                        alt="Thumbnail"
                                        data-id="{{ $img->id }}"
                                        class="w-32 h-32 flex-shrink-0 rounded-lg shadow-lg cursor-pointer hover:scale-105 transition thumbnail">
                                @endforeach
                            </div>

                            @else
                                <div class="flex flex-row flex-wrap gap-2 bg-gray-300 px-10 py-5 rounded-lg max-sm:px-5 max-sm:text-sm">
                                    <p class="home_p_font text-gray-600 italic text-center">No image uploads yet. </p>
                                </div>
                            @endif

                    </div>


             </div>

        </div>
        
     </section>

  

    
           
@include('components.footer_client')
<script src="{{ asset('js/client/public_profile.js') }}"></script>

@endsection