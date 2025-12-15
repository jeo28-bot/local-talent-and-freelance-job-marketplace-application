{{-- required profile edit modal --}}
@php
    $user = auth()->user();

    $profileComplete =
        $user->profile_pic &&
        !empty($user->about_details) &&
        ($user->user_type === 'client' || $user->skills) &&
        $user->uploads()->where('type', 'file')->exists() &&
        $user->uploads()->where('type', 'image')->exists();
@endphp

@if(!$profileComplete)
    <div id="update_profile_modal" class=" modal_bg min-h-screen fixed top-0 z-40 w-full flex items-center justify-center px-5 ">
        <div class="px-5 py-3 bg-white rounded-xl -mt-20 w-xl max-h-[700px] overflow-y-auto ">
            <h2 class="text-xl sub_title_font font-semibold! flex items-center gap-2 max-sm:text-lg text-blue-500">
                Please Complete Your Profile
                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                </svg>

                <button id="close_update_profile_modal" class="ml-auto cursor-pointer p-1 rounded-lg hover:bg-gray-200">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" aria-hidden="true" data-slot="icon" class="size-5 max-sm:size-4 " id="">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M6 18 18 6M6 6l12 12"></path>
                    </svg>
                </button>
            </h2>
            <p class="home_p_font max-sm:text-sm mb-2">Please finish setting up your profile first before you can fully use the system.</p>

            {{-- profile remaining setup --}}
            <div class="flex flex-col gap-3 mb-5">
                {{-- profile picture --}}
                    {{-- profile picture --}}
                    @if(Auth::user()->profile_pic)
                        {{-- DONE --}}
                        <div class="w-full p-2 rounded-lg flex items-center justify-between border-2 border-green-300">
                            <h1 class="p_font">Profile Picture</h1>
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                stroke-width="1.5" stroke="currentColor"
                                class="size-6 text-green-500">
                                <path stroke-linecap="round" stroke-linejoin="round"
                                    d="M9 12.75 11.25 15 15 9.75M21 12a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z" />
                            </svg>
                        </div>
                    @else
                        {{-- NOT DONE --}}
                        <div class="w-full p-2 rounded-lg flex items-center justify-between border-2 border-orange-300">
                            <h1 class="p_font">Profile Picture</h1>
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                stroke-width="1.5" stroke="currentColor"
                                class="size-6 text-orange-500">
                                <path stroke-linecap="round" stroke-linejoin="round"
                                    d="M12 9v6m3-3H9m12 0a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z" />
                            </svg>
                        </div>
                    @endif


                 {{-- About --}}
                @if(!empty(auth()->user()->about_details))
                    {{-- DONE --}}
                    <div class="w-full p-2 rounded-lg flex items-center justify-between border-2 border-green-300">
                        <h1 class="p_font">About</h1>
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                            stroke-width="1.5" stroke="currentColor"
                            class="size-6 text-green-500">
                            <path stroke-linecap="round" stroke-linejoin="round"
                                d="M9 12.75 11.25 15 15 9.75M21 12a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z" />
                        </svg>
                    </div>
                @else
                    {{-- NOT DONE --}}
                    <div class="w-full p-2 rounded-lg flex items-center justify-between border-2 border-orange-300">
                        <h1 class="p_font">About</h1>
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                            stroke-width="1.5" stroke="currentColor"
                            class="size-6 text-orange-500">
                            <path stroke-linecap="round" stroke-linejoin="round"
                                d="M12 9v6m3-3H9m12 0a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z" />
                        </svg>
                    </div>
                @endif
                
         
                {{-- Skill set --}}
                @if(Auth::user()->user_type !== 'client')
                    @if(Auth::user()->skills)
                        {{-- DONE --}}
                        <div class="w-full p-2 rounded-lg flex items-center justify-between border-2 border-green-300">
                            <h1 class="p_font">Skill set</h1>
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                stroke-width="1.5" stroke="currentColor"
                                class="size-6 text-green-500">
                                <path stroke-linecap="round" stroke-linejoin="round"
                                    d="M9 12.75 11.25 15 15 9.75M21 12a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z" />
                            </svg>
                        </div>
                    @else
                        {{-- NOT DONE --}}
                        <div class="w-full p-2 rounded-lg flex items-center justify-between border-2 border-orange-300">
                            <h1 class="p_font">Skill set</h1>
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                stroke-width="1.5" stroke="currentColor"
                                class="size-6 text-orange-500">
                                <path stroke-linecap="round" stroke-linejoin="round"
                                    d="M12 9v6m3-3H9m12 0a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z" />
                            </svg>
                        </div>
                    @endif
                @endif

                {{-- file upload check --}}
                @php
                    $hasFileUploads = auth()->user()
                        ->uploads
                        ->where('type', 'file')
                        ->count() > 0;
                @endphp

                <h2 class="home_p_font text-sm font-semibold!">Credentials</h2>

                {{-- file upload --}}
                @if($hasFileUploads)
                    {{-- DONE --}}
                    <div class="w-full p-2 rounded-lg flex items-center justify-between border-2 border-green-300">
                        <h1 class="p_font">File Upload</h1>
                       <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" aria-hidden="true" data-slot="icon" class="size-6 text-green-500">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M9 12.75 11.25 15 15 9.75M21 12a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z"></path>
                        </svg>
                    </div>
                @else
                    {{-- NOT DONE --}}
                    <div class="w-full p-2 rounded-lg flex items-center justify-between border-2 border-orange-300">
                        <h1 class="p_font">File Upload</h1>
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                            stroke-width="1.5" stroke="currentColor"
                            class="size-6 text-orange-500">
                            <path stroke-linecap="round" stroke-linejoin="round"
                                d="M12 9v6m3-3H9m12 0a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z" />
                        </svg>
                    </div>
                @endif


                 {{-- file upload check --}}
                @php
                    $hasImageUploads = auth()->user()
                        ->uploads
                        ->where('type', 'image')
                        ->count() > 0;
                @endphp

                {{-- file upload --}}
                @if($hasImageUploads)
                    {{-- DONE --}}
                    <div class="w-full p-2 rounded-lg flex items-center justify-between border-2 border-green-300">
                        <h1 class="p_font">Image Upload</h1>
                       <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" aria-hidden="true" data-slot="icon" class="size-6 text-green-500">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M9 12.75 11.25 15 15 9.75M21 12a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z"></path>
                        </svg>
                    </div>
                @else
                    {{-- NOT DONE --}}
                    <div class="w-full p-2 rounded-lg flex items-center justify-between border-2 border-orange-300">
                        <h1 class="p_font">Image Upload</h1>
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                            stroke-width="1.5" stroke="currentColor"
                            class="size-6 text-orange-500">
                            <path stroke-linecap="round" stroke-linejoin="round"
                                d="M12 9v6m3-3H9m12 0a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z" />
                        </svg>
                    </div>
                @endif

            </div>
            
            {{-- go to profile edit page button --}}
            <div class="mt-4 mb-2">
                <a 
                    href="{{ Auth::user()->user_type === 'employee' ? url('employee/profile') : url('client/profile') }}"
                    class="px-4 py-2 bg-blue-500 hover:bg-blue-700 text-white rounded-lg p_font"
                >
                    Go to Profile Edit Page
                </a>
            </div>


        </div>
    </div>


    
    <script>
       document.addEventListener('DOMContentLoaded', () => {
        const modal = document.getElementById('update_profile_modal');
        const closeBtn = document.getElementById('close_update_profile_modal');

        if (!modal || !closeBtn) return;

        const closeModal = () => {
            modal.classList.add('hidden');
        };

        // Close button
        closeBtn.addEventListener('click', closeModal);

        // Click anywhere outside the inner modal
        const innerModal = modal.querySelector('div.bg-white'); // your white modal box
        modal.addEventListener('click', e => {
            if (!innerModal.contains(e.target)) closeModal();
        });

        // ESC key
        document.addEventListener('keydown', e => {
            if (e.key === 'Escape') closeModal();
        });
    });

    </script>


@endif







