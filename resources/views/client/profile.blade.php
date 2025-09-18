@extends('layouts.app')

@section('body-class', 'bg-[#F0F0F0] ')

@section('content')
    @include('components.nav_client')


     <section class="w-ful min-h-[80vh] px-10 py-10 max-sm:py-5 max-sm:px-4 ">
        <div class="sm:w-2xl mx-auto px-5 max-sm:px-3 mb-10">
            <div class="flex items-center justify-between">
            <h1 class="sub_title sm:text-4xl text-lg">{{ Auth::user()->name }}</h1>
            <img src="{{asset('assets/samplePerson.png')}}" alt="profile pic" class="w-30 max-sm:w-20 rounded-full border-2 border-gray-400 my-3">
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

        {{-- skills section --}}
        <div class="flex items-center justify-between ">
          <h1 class="sub_title sm:text-2xl flex items-center gap-2 mb-3">
                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="size-6">
                <path fill-rule="evenodd" d="M10.788 3.21c.448-1.077 1.976-1.077 2.424 0l2.082 5.006 5.404.434c1.164.093 1.636 1.545.749 2.305l-4.117 3.527 1.257 5.273c.271 1.136-.964 2.033-1.96 1.425L12 18.354 7.373 21.18c-.996.608-2.231-.29-1.96-1.425l1.257-5.273-4.117-3.527c-.887-.76-.415-2.212.749-2.305l5.404-.434 2.082-5.005Z" clip-rule="evenodd" />
                </svg>
            About</h1>

            <a id="edit_skills" href="#" class="hover:opacity-60">
            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="size-6 max-sm:size-5">
            <path d="M21.731 2.269a2.625 2.625 0 0 0-3.712 0l-1.157 1.157 3.712 3.712 1.157-1.157a2.625 2.625 0 0 0 0-3.712ZM19.513 8.199l-3.712-3.712-12.15 12.15a5.25 5.25 0 0 0-1.32 2.214l-.8 2.685a.75.75 0 0 0 .933.933l2.685-.8a5.25 5.25 0 0 0 2.214-1.32L19.513 8.2Z" />
            </svg>
            </a>
        </div>
            {{-- no description set yet --}}
             <div class="flex flex-row flex-wrap gap-2 mb-10 bg-gray-300 px-10 py-5 rounded-lg max-sm:px-5 max-sm:text-sm hidden">
                <p class="home_p_font text-gray-600 italic">Set your acount description. Click the edit icon to add your skills.</p>
             </div>
            {{-- skill set --}}
            <div id="skills_added_table" class="flex flex-row flex-wrap gap-2 mb-10 bg-white px-5 py-5 rounded-lg max-sm:px-5 max-sm:text-sm shadow-sm">
                <p class="home_p_font text-black">Lorem ipsum dolor, sit amet consectetur adipisicing elit. Labore accusantium perspiciatis quas cupiditate mollitia veniam delectus magni animi fugiat qui praesentium eum, libero tenetur reprehenderit accusamus maxime expedita distinctio minus.</p>
            </div>

       
        

            {{-- logout button --}}
              
                <button id="logout" class="bg-[#1e2939] cursor-pointer sub_title_font text-red-400 px-4 py-2 rounded-lg hover:bg-[#374151] max-sm:text-sm">Log-out</button>
               
        </div>
        
     </section>

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


     {{-- edit skill modal section --}}
            <div class="modal_bg w-full min-h-screen fixed top-0 z-40 flex items-center justify-center hidden" id="edit_skill_modal">
                <div class="bg-white rounded-xl p-5 w-96 max-sm:w-80">
                    <h2 class="sub_title_font text-xl mb-3">Edit Skills</h2>
                    <form action="#" method="POST" id="skill_form">
                        @csrf
                        <div class="mb-3">
                            <label for="skills" class="home_p_font mb-1 block">Add your skills (separate with commas)</label>
                            <input type="text" name="skills" id="skills" class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500" placeholder="e.g., Freelance Photography, Nail Technician">
                            {{-- added skills section --}}
                            <div class="py-2 w-full flex flex-col gap-2 max-h-40 overflow-y-auto">
                                <p id="added_skills" class="a_font text-sm px-4 py-2 bg-gray-300 rounded-lg w-full flex justify-between items-center">Freelance Photography
                                 <svg id="delete_skill" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="size-6 hover:text-red-400 cursor-pointer">
                                <path fill-rule="evenodd" d="M2.515 10.674a1.875 1.875 0 0 0 0 2.652L8.89 19.7c.352.351.829.549 1.326.549H19.5a3 3 0 0 0 3-3V6.75a3 3 0 0 0-3-3h-9.284c-.497 0-.974.198-1.326.55l-6.375 6.374ZM12.53 9.22a.75.75 0 1 0-1.06 1.06L13.19 12l-1.72 1.72a.75.75 0 1 0 1.06 1.06l1.72-1.72 1.72 1.72a.75.75 0 1 0 1.06-1.06L15.31 12l1.72-1.72a.75.75 0 1 0-1.06-1.06l-1.72 1.72-1.72-1.72Z" clip-rule="evenodd" />
                                </svg>
                                </p>

                                <p id="added_skills" class="a_font text-sm px-4 py-2 bg-gray-300 rounded-lg w-full flex justify-between items-center">Nail Technician
                                 <svg id="delete_skill" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="size-6 hover:text-red-400 cursor-pointer">
                                <path fill-rule="evenodd" d="M2.515 10.674a1.875 1.875 0 0 0 0 2.652L8.89 19.7c.352.351.829.549 1.326.549H19.5a3 3 0 0 0 3-3V6.75a3 3 0 0 0-3-3h-9.284c-.497 0-.974.198-1.326.55l-6.375 6.374ZM12.53 9.22a.75.75 0 1 0-1.06 1.06L13.19 12l-1.72 1.72a.75.75 0 1 0 1.06 1.06l1.72-1.72 1.72 1.72a.75.75 0 1 0 1.06-1.06L15.31 12l1.72-1.72a.75.75 0 1 0-1.06-1.06l-1.72 1.72-1.72-1.72Z" clip-rule="evenodd" />
                                </svg>
                                </p>

                                <p id="added_skills" class="a_font text-sm px-4 py-2 bg-gray-300 rounded-lg w-full flex justify-between items-center">Hairdresser
                                 <svg id="delete_skill" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="size-6 hover:text-red-400 cursor-pointer">
                                <path fill-rule="evenodd" d="M2.515 10.674a1.875 1.875 0 0 0 0 2.652L8.89 19.7c.352.351.829.549 1.326.549H19.5a3 3 0 0 0 3-3V6.75a3 3 0 0 0-3-3h-9.284c-.497 0-.974.198-1.326.55l-6.375 6.374ZM12.53 9.22a.75.75 0 1 0-1.06 1.06L13.19 12l-1.72 1.72a.75.75 0 1 0 1.06 1.06l1.72-1.72 1.72 1.72a.75.75 0 1 0 1.06-1.06L15.31 12l1.72-1.72a.75.75 0 1 0-1.06-1.06l-1.72 1.72-1.72-1.72Z" clip-rule="evenodd" />
                                </svg>
                                </p>

                                <p id="added_skills" class="a_font text-sm px-4 py-2 bg-gray-300 rounded-lg w-full flex justify-between items-center">Hairdresser
                                 <svg id="delete_skill" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="size-6 hover:text-red-400 cursor-pointer">
                                <path fill-rule="evenodd" d="M2.515 10.674a1.875 1.875 0 0 0 0 2.652L8.89 19.7c.352.351.829.549 1.326.549H19.5a3 3 0 0 0 3-3V6.75a3 3 0 0 0-3-3h-9.284c-.497 0-.974.198-1.326.55l-6.375 6.374ZM12.53 9.22a.75.75 0 1 0-1.06 1.06L13.19 12l-1.72 1.72a.75.75 0 1 0 1.06 1.06l1.72-1.72 1.72 1.72a.75.75 0 1 0 1.06-1.06L15.31 12l1.72-1.72a.75.75 0 1 0-1.06-1.06l-1.72 1.72-1.72-1.72Z" clip-rule="evenodd" />
                                </svg>
                                </p>

                                <p id="added_skills" class="a_font text-sm px-4 py-2 bg-gray-300 rounded-lg w-full flex justify-between items-center">Hairdresser
                                 <svg id="delete_skill" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="size-6 hover:text-red-400 cursor-pointer">
                                <path fill-rule="evenodd" d="M2.515 10.674a1.875 1.875 0 0 0 0 2.652L8.89 19.7c.352.351.829.549 1.326.549H19.5a3 3 0 0 0 3-3V6.75a3 3 0 0 0-3-3h-9.284c-.497 0-.974.198-1.326.55l-6.375 6.374ZM12.53 9.22a.75.75 0 1 0-1.06 1.06L13.19 12l-1.72 1.72a.75.75 0 1 0 1.06 1.06l1.72-1.72 1.72 1.72a.75.75 0 1 0 1.06-1.06L15.31 12l1.72-1.72a.75.75 0 1 0-1.06-1.06l-1.72 1.72-1.72-1.72Z" clip-rule="evenodd" />
                                </svg>
                                </p>

                                <p id="added_skills" class="a_font text-sm px-4 py-2 bg-gray-300 rounded-lg w-full flex justify-between items-center">Hairdresser
                                 <svg id="delete_skill" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="size-6 hover:text-red-400 cursor-pointer">
                                <path fill-rule="evenodd" d="M2.515 10.674a1.875 1.875 0 0 0 0 2.652L8.89 19.7c.352.351.829.549 1.326.549H19.5a3 3 0 0 0 3-3V6.75a3 3 0 0 0-3-3h-9.284c-.497 0-.974.198-1.326.55l-6.375 6.374ZM12.53 9.22a.75.75 0 1 0-1.06 1.06L13.19 12l-1.72 1.72a.75.75 0 1 0 1.06 1.06l1.72-1.72 1.72 1.72a.75.75 0 1 0 1.06-1.06L15.31 12l1.72-1.72a.75.75 0 1 0-1.06-1.06l-1.72 1.72-1.72-1.72Z" clip-rule="evenodd" />
                                </svg>
                                </p>

                                
                                
                            </div>
                        </div>
                        
                        <div class="flex justify-end gap-2">
                            <button type="button" id="cancel_skill_edit" class="bg-gray-300 cursor-pointer sub_title_font text-gray-700 px-4 py-2 rounded-lg hover:bg-gray-400 max-sm:text-sm">Cancel</button>
                            <button type="submit" class="bg-[#1e2939] cursor-pointer sub_title_font text-blue-400 px-4 py-2 rounded-lg hover:bg-[#374151] max-sm:text-sm">Save</button>
                        </div>
                    </form>
                </div>

            </div>
           
@include('components.footer_client')
    
<script src="{{ asset('js/client.js') }}"></script>
@endsection