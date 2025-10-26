@extends('layouts.app')

@section('body-class', 'bg-[#F0F0F0]')

@section('content')
     @include('components.nav_admin')


    <!-- main content -->
    <section class="w-full  z-0">
        <div class="pt-35 pl-85 max-[1270px]:pl-75 max-lg:pl-7  pr-10 max-sm:pr-5 pb-15">
            {{-- Contents --}}

            <div class="sm:w-xl lg:w-2xl mx-auto px-5 max-sm:px-3 mb-10">
            <div class="flex items-center justify-between flex-wrap">
                <div class="flex items-center gap-2">
                   <a href="{{ route('admin.public_profile', ['name' => Auth::user()->name]) }}"
                    class="sub_title sm:text-4xl text-2xl hover:underline cursor-pointer">
                    {{ Auth::user()->name }}
                    </a>



                    
                    {{-- edit user details button --}}
                    <a class="edit_details_button cursor-pointer hover:opacity-50">
                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="size-6 max-sm:size-4">
                        <path d="M21.731 2.269a2.625 2.625 0 0 0-3.712 0l-1.157 1.157 3.712 3.712 1.157-1.157a2.625 2.625 0 0 0 0-3.712ZM19.513 8.199l-3.712-3.712-12.15 12.15a5.25 5.25 0 0 0-1.32 2.214l-.8 2.685a.75.75 0 0 0 .933.933l2.685-.8a5.25 5.25 0 0 0 2.214-1.32L19.513 8.2Z" />
                        </svg>
                    </a>
                </div>
                
             
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

                <button id="edit_about_button" href="#" class="hover:opacity-60 cursor-pointer">
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
                             No about details added yet. Click the edit icon to add about details.
                        </p>
                    </div>
                @endif



            {{-- skills section --}}
            <div class="flex items-center justify-between mb-2">
                <h1 class="sub_title sm:text-2xl flex items-center gap-2">
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="size-6">
                    <path fill-rule="evenodd" d="M10.788 3.21c.448-1.077 1.976-1.077 2.424 0l2.082 5.006 5.404.434c1.164.093 1.636 1.545.749 2.305l-4.117 3.527 1.257 5.273c.271 1.136-.964 2.033-1.96 1.425L12 18.354 7.373 21.18c-.996.608-2.231-.29-1.96-1.425l1.257-5.273-4.117-3.527c-.887-.76-.415-2.212.749-2.305l5.404-.434 2.082-5.005Z" clip-rule="evenodd" />
                    </svg>
                Skills</h1>

                <button id="edit_skills_button" href="#" class="hover:opacity-60 cursor-pointer">
                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="size-6 max-sm:size-4">
                <path d="M21.731 2.269a2.625 2.625 0 0 0-3.712 0l-1.157 1.157 3.712 3.712 1.157-1.157a2.625 2.625 0 0 0 0-3.712ZM19.513 8.199l-3.712-3.712-12.15 12.15a5.25 5.25 0 0 0-1.32 2.214l-.8 2.685a.75.75 0 0 0 .933.933l2.685-.8a5.25 5.25 0 0 0 2.214-1.32L19.513 8.2Z" />
                </svg>
                </button>
            </div>
           
            {{-- skill set --}}
            <div id="skills_added_table" class="flex flex-row flex-wrap gap-2 mb-10">
                @if(Auth::user()->skills)
                    <div class="flex gap-2 flex-wrap mt-3">
                        @foreach(explode(',', Auth::user()->skills) as $skill)
                            <span class="p_font px-3 py-2 bg-white rounded-lg shadow-sm text-sm capitalize hover:bg-gray-200">
                                {{ trim($skill) }}
                            </span>
                        @endforeach
                    </div>
                @else
                     {{-- no skill set yet --}}
                    <div class="flex flex-row flex-wrap gap-2 bg-gray-300 px-10 py-5 rounded-lg max-sm:px-5 max-sm:text-sm w-full">
                        <p class="home_p_font text-gray-600 italic">No skill set yet. Click the edit icon to add your skills.</p>
                    </div>
                        @endif
            </div>

            {{-- credentials section --}}
            <div class="flex items-center justify-between mb-3">
                <h1 class="sub_title sm:text-2xl flex items-center gap-2 ">
                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="size-6">
                        <path d="M5.625 1.5c-1.036 0-1.875.84-1.875 1.875v17.25c0 1.035.84 1.875 1.875 1.875h12.75c1.035 0 1.875-.84 1.875-1.875V12.75A3.75 3.75 0 0 0 16.5 9h-1.875a1.875 1.875 0 0 1-1.875-1.875V5.25A3.75 3.75 0 0 0 9 1.5H5.625Z" />
                        <path d="M12.971 1.816A5.23 5.23 0 0 1 14.25 5.25v1.875c0 .207.168.375.375.375H16.5a5.23 5.23 0 0 1 3.434 1.279 9.768 9.768 0 0 0-6.963-6.963Z" />
                        </svg>
                    Credentials</h1>

                <a id="edit_credentials" href="#" class="hover:opacity-60">
                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="size-6 max-sm:size-4">
                <path d="M21.731 2.269a2.625 2.625 0 0 0-3.712 0l-1.157 1.157 3.712 3.712 1.157-1.157a2.625 2.625 0 0 0 0-3.712ZM19.513 8.199l-3.712-3.712-12.15 12.15a5.25 5.25 0 0 0-1.32 2.214l-.8 2.685a.75.75 0 0 0 .933.933l2.685-.8a5.25 5.25 0 0 0 2.214-1.32L19.513 8.2Z" />
                </svg>
                </a>
            </div>
             
             {{-- credentials Files, Images section --}}
             <div class="mb-5">
                {{-- file uploads --}}
                <h1 class="sub_title_font text-1sm max-sm:text-sm">File Uploads</h1>
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
                            <button class="open-delete-modal cursor-pointer" 
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
                                <p class="home_p_font text-gray-600 italic text-center">No file uploads yet. Click the edit icon to add your files.</p>
                            </div>
                        @endforelse
                    </div>

                {{-- images uploads --}}
                <h1 class="sub_title_font text-1sm max-sm:text-sm">Image Uploads</h1>
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
                                <button id="deleteImageBtn" type="button" class="absolute mt-2 mr-2">
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
                                    <div class="flex flex-col items-center">
                                        <img src="{{ Storage::url($img->path) }}"
                                            alt="{{ $img->original_name ?? 'Thumbnail' }}"
                                            data-id="{{ $img->id }}"
                                            class="w-32 h-32 flex-shrink-0 rounded-lg shadow-lg cursor-pointer hover:scale-105 transition thumbnail">

                                        {{-- Show image name --}}
                                        <p class="text-xs text-gray-600 mt-1 w-32 text-center truncate p_font">
                                            {{ $img->original_name ?? 'Untitled' }}
                                        </p>
                                    </div>
                                @endforeach
                            </div>


                            @else
                                <div class="flex flex-row flex-wrap gap-2 bg-gray-300 px-10 py-5 rounded-lg max-sm:px-5 max-sm:text-sm">
                                    <p class="home_p_font text-gray-600 italic text-center">No image uploads yet. Click the edit icon to add your files.</p>
                                </div>
                            @endif

                    </div>


             </div>
        

            {{-- logout button --}}
                <button id="logout" class="bg-[#1e2939] cursor-pointer sub_title_font text-red-400 px-4 py-2 rounded-lg hover:bg-[#374151] max-sm:text-sm">Log-out</button>

        </div>
            


        </div>
        
    
    </section>

    {{-- modal section --}}

            {{-- delete image upload modal --}}
            <div id="delete_image_warning" class="modal_bg min-h-screen fixed top-0 z-40 w-full flex items-center justify-center px-5 hidden">
                <div class="px-5 py-3 bg-white rounded-xl -mt-20">
                    <h2 class="text-xl sub_title_font font-semibold mb-2">Delete this image?</h2>
                    <p class="home_p_font text-gray-600 mb-5">
                        This action cannot be undone. <br>
                        Are you sure you want to delete this image?
                    </p>

                    <div class="flex gap-2">
                        <button id="cancel_delete_image" type="button"
                            class="bg-[#1e2939] cursor-pointer sub_title_font text-blue-400 px-4 py-2 rounded-lg hover:bg-[#374151] max-sm:text-sm">
                            Cancel
                        </button>

                        <form id="confirm_delete_image_form" method="POST">
                            @csrf
                            @method('DELETE')
                            <button type="submit" id="confirm_delete_image"
                                class="bg-[#1e2939] cursor-pointer sub_title_font text-red-400 px-4 py-2 rounded-lg hover:bg-[#374151] max-sm:text-sm">
                                Delete
                            </button>
                        </form>
                    </div>
                </div>
            </div>

            {{-- delete file upload modal --}}
            <div id="delete_file_warning" class="modal_bg min-h-screen fixed top-0 z-40 w-full flex items-center justify-center px-5 hidden">
                <div class="px-5 py-3 bg-white rounded-xl -mt-20">
                    <h2 class="text-xl sub_title_font font-semibold mb-2">Delete this file?</h2>
                    <p class="home_p_font text-gray-600 mb-5">
                        This action cannot be undone. <br>
                        Are you sure you want to delete this file?
                    </p>

                    <div class="flex gap-2">
                        <button id="cancel_delete_file" type="button"
                            class="bg-[#1e2939] cursor-pointer sub_title_font text-blue-400 px-4 py-2 rounded-lg hover:bg-[#374151] max-sm:text-sm">
                            Cancel
                        </button>

                        <form id="confirm_delete_file_form" method="POST">
                            @csrf
                            @method('DELETE')
                            <button type="submit" id="confirm_delete_file"
                                class="bg-[#1e2939] cursor-pointer sub_title_font text-red-400 px-4 py-2 rounded-lg hover:bg-[#374151] max-sm:text-sm">
                                Delete
                            </button>
                        </form>
                    </div>
                </div>
            </div>

            {{-- ceredential uploads modal --}}
            <div id="ceredential_uploads_modal" class="modal_bg min-h-screen fixed top-0 z-40 w-full flex items-center justify-center px-5 hidden">
                <div class="w-lg px-5 py-3 bg-gray-200 rounded-xl -mt-10">
                    <div class="flex items-center justify-between mb-2">
                        <h1 class="p_font">Upload your credentials</h1>
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" id="close_credential_upload" class="size-5 cursor-pointer  hover:bg-red-400! rounded-sm max-sm:size-5 bg-gray-300!">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M6 18 18 6M6 6l12 12" />
                        </svg>
                    </div>
                    <div class="p-3 bg-white rounded-lg shadow-sm">
                        <form action="{{ route('profile.uploadFiles') }}" method="POST" enctype="multipart/form-data">
                            @csrf
                            <h3 class="p_font mb-2">File Uploads</h3>
                                <input 
                                    id="fileInput"
                                    name="files[]" 
                                    type="file" 
                                    multiple 
                                    class="block w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4
                                        file:rounded-lg file:border-0
                                        file:text-sm bg-gray-300 rounded-lg shadow-lg
                                        file:bg-black file:text-white p_font
                                        hover:file:bg-gray-500"
                                />

                                <!-- Uploaded files list -->
                                <ul id="fileList" class="mt-4 space-y-2 mb-2"></ul>

                            <h3 class="p_font mb-2">Image Uploads</h3>
                                <div class="w-full max-w-md mx-auto">
                                <input 
                                    id="imageInput"
                                    type="file" 
                                    name="images[]" 
                                    multiple 
                                    accept="image/*"
                                    class="block w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4
                                        file:rounded-lg file:border-0
                                        file:text-sm bg-gray-300 rounded-lg shadow-lg
                                        file:bg-black file:text-white p_font
                                        hover:file:bg-gray-500"
                                />

                                <!-- Preview container -->
                                <div id="imagePreview" class="mt-4 flex flex-wrap gap-3"></div>
                                </div>
                            
                           
                                <button type="submit"  id="logout" class="bg-[#1e2939] cursor-pointer sub_title_font text-blue-400 px-4 py-2 rounded-lg hover:bg-[#374151] max-sm:text-sm flex ml-auto ">Save</button>
                        </form>

                    </div>
                    
                    
                </div>
            </div>
            
            {{-- logout modal warning --}} 
            <div id="logout_warning_modal" class="modal_bg min-h-screen fixed top-0 z-40 w-full flex items-center justify-center hidden">
                <div class=" px-5 py-3 bg-white rounded-xl">
                    <h2 class="text-xl sub_title_font font-semibold mb-2">Are you sure?</h2>
                    <p class="home_p_font text-gray-600 mb-5">You will be logged out of your account.</p>

                    <div class="flex gap-2">
                        <button id="cancel_logout" class="bg-[#1e2939] cursor-pointer sub_title_font text-blue-400 px-4 py-2 rounded-lg hover:bg-[#374151] max-sm:text-sm">Cancel</button>

                        <form action="{{ route('logout') }}" method="POST">
                            @csrf
                        <button id="logout" class="bg-[#1e2939] cursor-pointer sub_title_font text-red-400 px-4 py-2 rounded-lg hover:bg-[#374151] max-sm:text-sm">Log-out</button>
                        </form>
                    </div>
                </div>
            </div>

            {{-- edit user details modal --}}
            <div class="edit_user_details_modal modal_bg w-full min-h-screen fixed top-0 z-40 flex items-center justify-center px-5 hidden" id="edit_skill_modal">
                <div class="bg-gray-200 rounded-xl p-3 w-96 max-sm:w-80">
                    <div class="flex items-center justify-between mb-2">
                        <h1 class="p_font">Edit user details</h1>
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" id="close_edit_user_details" class="size-5 cursor-pointer  hover:bg-red-400! rounded-sm max-sm:size-5 bg-gray-300!">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M6 18 18 6M6 6l12 12" />
                        </svg>
                    </div>
                    <form action="{{ route('profile.update') }}" method="POST" class="p-3 bg-white rounded-lg shadow-sm">
                        @csrf
                        {{-- input 1 --}}
                        <div class="input_control">
                            <label for="username" class="p_font">Username: <span class="text-red-400">*</span></label>
                            <input type="text" name="username" id="username" placeholder="Enter your new username" class="p-2 shadow-sm w-full rounded-lg border-2 border-gray-400 mb-2" value="{{ Auth::user()->name }}" required>
                        </div>
                          {{-- input 2 --}}
                        <div class="input_control">
                            <label for="email" class="p_font">Email: <span class="text-red-400">*</span></label>
                            <input type="email" name="email" id="email" placeholder="Enter your new email" class="p-2 shadow-sm w-full rounded-lg border-2 border-gray-400 mb-2" value="{{ Auth::user()->email }}" required>
                        </div>
                          {{-- input 3 --}}
                        <div class="input_control">
                            <label for="phoneNum" class="p_font">Phone #: <span class="text-red-400">*</span></label>
                            <input type="number" name="phoneNum" id="phoneNum" placeholder="Enter your new phone #" class="p-2 shadow-sm w-full rounded-lg border-2 border-gray-400 mb-2" value="{{ Auth::user()->phoneNum }}" required>
                        </div>
                          {{-- input 4 --}}
                        <div class="input_control mb-2">
                            <label for="address" class="p_font">Address <span class="text-red-400">*</span></label>
                            <input type="text" name="address" id="address" placeholder="Enter your new address" class="p-2 shadow-sm w-full rounded-lg border-2 border-gray-400 mb-2" value="{{ Auth::user()->address }}" required>
                        </div>
                        @if(session('success'))
                            <div class="bg-green-100 text-green-700 p-2 rounded-lg mb-3 p_font">
                                {{ session('success') }}
                            </div>
                        @endif

                        
                        <div class="flex">
                        <input type="submit" value="Save" class="save_user_details cursor-pointer bg-[#1E2939] text-white px-4 py-2 max-sm:py-3 max-sm:px-5 rounded-lg hover:opacity-90 max-sm:text-sm text-center ml-auto max-sm:w-full p_font">
                        </div>
                    </form>
                    
                </div>
            </div>

            {{-- edit skill modal section --}}
            <div class="edit_skills_modal modal_bg w-full min-h-screen fixed top-0 z-40 flex items-center justify-center px-5 hidden" id="edit_skill_modal">
                <div class="bg-gray-200 rounded-xl p-5 w-96 max-sm:w-80">
                    <h2 class="sub_title_font text-lg mb-1 max-sm:text-sm">Edit Skills</h2>
                    <form action="{{ route('profile.updateSkills') }}" method="POST" id="skill_form" >
                        @csrf
                        <div class="mb-3 bg-white p-3 rounded-lg shadow-sm">
                            <label for="skills" class="home_p_font mb-1 block max-sm:text-sm">Add your skills (separate with commas)</label>
                            <input 
                                type="text" 
                                name="skills" 
                                id="skills" 
                                value="{{ old('skills', Auth::user()->skills) }}" 
                                class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500 max-sm:text-sm" 
                                placeholder="e.g., Freelance Photography, Nail Technician">

                            {{-- added skills section --}}
                            <div class="py-2 w-full flex gap-2 max-h-40 overflow-y-auto flex-col">
                                @if(Auth::user()->skills)
                                    @foreach(explode(',', Auth::user()->skills) as $skill)
                                        <p class="a_font text-sm px-4 py-2 bg-gray-300 rounded-lg items-center flex">
                                            {{ trim($skill) }}
                                        </p>
                                    @endforeach
                                @endif
                            </div>
                        </div>

                        <div class="flex justify-end gap-2">
                            <button type="button" id="cancel_skill_edit" class="bg-white shadow-sm cursor-pointer sub_title_font text-gray-700 px-4 py-2 rounded-lg hover:bg-gray-400 max-sm:text-sm">Cancel</button>
                            <button type="submit" class="bg-[#1e2939] cursor-pointer sub_title_font shadow-sm text-blue-400 px-4 py-2 rounded-lg hover:bg-[#374151] max-sm:text-sm">Save</button>
                        </div>
                    </form>

                </div>
            </div>

            {{-- upload profile modal --}}
            <div class="profile_pic_modal modal_bg min-h-screen fixed top-0 z-40 w-full flex items-center justify-center px-10 hidden">
                <div class="w-sm px-5 py-3 bg-gray-200 rounded-xl flex items-center flex-col">
                    <div class="flex items-center justify-between w-full mb-2">
                        <h1 class="sub_title_font ">Profile Picture</h1>
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" id="close_profile_pic_modal" class="size-5 cursor-pointer  hover:bg-red-400! rounded-sm max-sm:size-5 bg-gray-300!">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M6 18 18 6M6 6l12 12" />
                        </svg>
                    </div>
                    <div class="p-2 bg-white flex flex-col items-center rounded-lg shadow-sm mb-2 pb-5">
                        <img 
                        src="{{ Auth::user()->profile_pic ? asset('storage/' . Auth::user()->profile_pic) : asset('assets/defaultUserPic.png') }}" 
                        alt="profile pic" 
                        class="w-[100px] h-[100px] max-sm:w-20 max-sm:h-20 rounded-full border-3 bg-[#1e2939] border-gray-400 my-3 shadow-sm">

                        <p class="home_p_font text-sm text-center ">Recommended size: <span class="font-semibold">128×128px (1:1 square)</span>. 
                        Use JPG or PNG under 2MB for best quality.</p>
                            <form action="{{ route('profile.updatePicture') }}" method="POST" enctype="multipart/form-data" class="mt-3 p_font flex flex-col items-center gap-2">
                                @csrf
                                <input type="file" name="profile_pic" id="profile_pic" accept="image/*" class="w-full text-slate-500 font-medium text-sm bg-gray-300 shadow-sm file:cursor-pointer cursor-pointer file:border-0 file:py-2 file:px-4 file:mr-4 file:bg-gray-800 file:hover:bg-gray-700 file:text-white rounded-lg mb-2">
                                
                                <button type="submit" class="bg-[#1e2939] text-white px-4 py-2 rounded-lg hover:opacity-90 cursor-pointer max-sm:text-sm">
                                    Upload New Picture
                                </button>
                            </form>
                    </div>
                </div>  
            </div>

            {{-- edit about modal --}}
            <div class="edit_user_about_modal modal_bg w-full min-h-screen fixed top-0 z-40 flex items-center justify-center px-5 hidden" id="edit_user_about_modal">
                <div class="bg-gray-200 rounded-xl p-3 w-lg max-sm:w-lg">
                    <div class="flex items-center justify-between mb-2">
                        <h1 class="p_font">Edit user about details</h1>
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" id="close_user_about_modal" class="size-5 cursor-pointer  hover:bg-red-400! rounded-sm max-sm:size-5 bg-gray-300!">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M6 18 18 6M6 6l12 12" />
                        </svg>
                    </div>

                   <form action="{{ route('profile.updateAbout') }}" method="POST" class="px-3 py-2 bg-white rounded-lg shadow-sm">
                        @csrf

                        <div class="input_control">
                            <label for="about_details" class="p _font mb-2">About Details:</label>
                            <textarea
                                name="about_details"
                                id="about_details"
                                placeholder="Write something about yourself here..."
                                class="p-2 shadow-sm w-full rounded-lg border-2 border-gray-400 mb-2 h-32">{{ old('about_details', auth()->user()->about_details) }}</textarea>
                        </div>

                        <div class="flex">
                            <input type="submit" value="Save" class="save_user_about cursor-pointer bg-[#1E2939] text-white px-4 py-2 rounded-lg ml-auto p_font">
                        </div>
                    </form>


                </div>
            </div>

            {{-- end of modal section --}}
           



    
    <script src="{{ asset('js/employee.js') }}"></script>   
    <script src="{{ asset('js/employee/profile.js') }}"></script>
    <script src="{{ asset('js/admin/nav_admin.js') }}"></script>
@endsection
 