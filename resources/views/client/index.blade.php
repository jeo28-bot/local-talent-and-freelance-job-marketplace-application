@extends('layouts.app')

@section('body-class', 'bg-[#F0F0F0]')

@section('content')
    @include('components.nav_client')
  
    <!-- main content -->
    <section class="w-full flex min-h-[80vh] flex-col items-center  px-20 max-sm:px-10 pt-10">
      
      <h1 class="home_hero_font text-6xl mb-10 max-lg:text-4xl text-center max-lg:mb-5 capitalize">Welcome, {{ Auth::user()->name }}</h1>
      <h3 class="home_p_font text-center text-3xl max-lg:text-xl leading-10 max-lg:leading-8 mb-20 max-lg:mb-10">Manage your job posts and track applicants easily.</h3>
      
       <!-- Quick Action Buttons Panel -->
        <div class="xl:w-6xl flex justify-center gap-10 rounded-lg mb-10 max-lg:w-full max-lg:flex-col max-lg:items-center max-sm:gap-5 ">
            {{-- Post a Job --}}
            <div class="xl:w-2xl py-5 px-10 bg-white rounded-lg shadow-md flex items-center flex-col hover:scale-105 transition-transform duration-300 max-lg:w-xl max-sm:w-full">
                <div class="p-2 bg-blue-400 rounded-xl mb-2 ">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-10 text-white">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 9v6m3-3H9m12 0a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z" />
                    </svg>
                </div>
                <h2 class="sub_title_font text-xl text-center">Post a Job</h2>
                <p class="home_p_font text-center">Create a new job posting and find the perfect candidate</p>
                <button id="post_a_job" class="mt-4 w-full bg-blue-400 text-white px-4 py-2 rounded-lg hover:bg-blue-500 button_font cursor-pointer">Post a Job</button>
            </div>

              {{-- View My Jobs --}}
            <div class="xl:w-2xl py-5 px-10 bg-white rounded-lg shadow-md flex items-center flex-col hover:scale-105 transition-transform duration-300 max-lg:w-xl max-sm:w-full">
                <div class="p-2 bg-green-500 rounded-xl mb-2 ">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-10 text-white">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M20.25 14.15v4.25c0 1.094-.787 2.036-1.872 2.18-2.087.277-4.216.42-6.378.42s-4.291-.143-6.378-.42c-1.085-.144-1.872-1.086-1.872-2.18v-4.25m16.5 0a2.18 2.18 0 0 0 .75-1.661V8.706c0-1.081-.768-2.015-1.837-2.175a48.114 48.114 0 0 0-3.413-.387m4.5 8.006c-.194.165-.42.295-.673.38A23.978 23.978 0 0 1 12 15.75c-2.648 0-5.195-.429-7.577-1.22a2.016 2.016 0 0 1-.673-.38m0 0A2.18 2.18 0 0 1 3 12.489V8.706c0-1.081.768-2.015 1.837-2.175a48.111 48.111 0 0 1 3.413-.387m7.5 0V5.25A2.25 2.25 0 0 0 13.5 3h-3a2.25 2.25 0 0 0-2.25 2.25v.894m7.5 0a48.667 48.667 0 0 0-7.5 0M12 12.75h.008v.008H12v-.008Z" />
                    </svg>
                </div>
                <h2 class="sub_title_font text-xl text-center">View My Jobs</h2>
                <p class="home_p_font text-center">Manage and track all your posted job listings</p>
                <a href="{{ route('client.postings') }}" class="{{ request()->routeIs('client.postings') ? 'selected_nav' : '' }} mt-4 w-full bg-green-500 text-white px-4 py-2 rounded-lg hover:bg-green-600 button_font cursor-pointer text-center">View All Jobs</a>
            </div>

            
             {{-- View Applicants --}}
            <div class="xl:w-2xl py-5 px-10 bg-white rounded-lg shadow-md flex items-center flex-col hover:scale-105 transition-transform duration-300 max-lg:w-xl max-sm:w-full">
                <div class="p-2 bg-red-400 rounded-xl mb-2 ">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-10 text-white">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M18 18.72a9.094 9.094 0 0 0 3.741-.479 3 3 0 0 0-4.682-2.72m.94 3.198.001.031c0 .225-.012.447-.037.666A11.944 11.944 0 0 1 12 21c-2.17 0-4.207-.576-5.963-1.584A6.062 6.062 0 0 1 6 18.719m12 0a5.971 5.971 0 0 0-.941-3.197m0 0A5.995 5.995 0 0 0 12 12.75a5.995 5.995 0 0 0-5.058 2.772m0 0a3 3 0 0 0-4.681 2.72 8.986 8.986 0 0 0 3.74.477m.94-3.197a5.971 5.971 0 0 0-.94 3.197M15 6.75a3 3 0 1 1-6 0 3 3 0 0 1 6 0Zm6 3a2.25 2.25 0 1 1-4.5 0 2.25 2.25 0 0 1 4.5 0Zm-13.5 0a2.25 2.25 0 1 1-4.5 0 2.25 2.25 0 0 1 4.5 0Z" />
                    </svg>
                </div>
                <h2 class="sub_title_font text-xl text-center">View Applicants</h2>
                <p class="home_p_font text-center">Review and manage applicants across all your jobs</p>
                <a href="{{ route('client.applicants') }}" class="{{ request()->routeIs('client.applicants') ? 'selected_nav' : '' }} mt-4 w-full bg-red-400 text-white px-4 py-2 rounded-lg hover:bg-red-500 button_font cursor-pointer text-center">View Applicants</a>
            </div>

        </div>

      {{-- other added elements in home page for client --}}
      <div class="space-y-10 mb-20 w-4xl max-lg:w-full max-sm:px-3 p_font">

          {{-- Welcome / Hero --}}
          <div class="bg-gradient-to-r from-emerald-500 to-teal-600 text-white rounded-xl p-6 shadow">
              <h1 class="text-2xl font-bold mb-2">
                  Welcome back, {{ auth()->user()->name }} 👋
              </h1>
              <p class="opacity-90 text-sm">
                  Post jobs, find talent, and manage your hires with ease.
              </p>
          </div>

          {{-- Info cards --}}
          <div class="grid grid-cols-3 max-lg:grid-cols-1 gap-4">

              {{-- Card 1 --}}
              <div class="bg-white rounded-lg shadow p-5 flex items-start gap-4">
                  <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" aria-hidden="true" data-slot="icon" class="size-20 text-emerald-500">
                    <path fill-rule="evenodd" d="M4.5 9.75a6 6 0 0 1 11.573-2.226 3.75 3.75 0 0 1 4.133 4.303A4.5 4.5 0 0 1 18 20.25H6.75a5.25 5.25 0 0 1-2.23-10.004 6.072 6.072 0 0 1-.02-.496Z" clip-rule="evenodd"></path>
                  </svg>
                  <div>
                      <h3 class="font-semibold mb-1">Post a Job</h3>
                      <p class="text-sm text-gray-600">
                          Create job posts and start receiving applications instantly.
                      </p>
                  </div>
              </div>

              {{-- Card 2 --}}
              <div class="bg-white rounded-lg shadow p-5 flex items-start gap-4">
                  <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" aria-hidden="true" data-slot="icon" class="size-20 text-emerald-500">
                    <path fill-rule="evenodd" d="M18.685 19.097A9.723 9.723 0 0 0 21.75 12c0-5.385-4.365-9.75-9.75-9.75S2.25 6.615 2.25 12a9.723 9.723 0 0 0 3.065 7.097A9.716 9.716 0 0 0 12 21.75a9.716 9.716 0 0 0 6.685-2.653Zm-12.54-1.285A7.486 7.486 0 0 1 12 15a7.486 7.486 0 0 1 5.855 2.812A8.224 8.224 0 0 1 12 20.25a8.224 8.224 0 0 1-5.855-2.438ZM15.75 9a3.75 3.75 0 1 1-7.5 0 3.75 3.75 0 0 1 7.5 0Z" clip-rule="evenodd"></path>
                  </svg>
                  <div>
                      <h3 class="font-semibold mb-1">Finish Profile</h3>
                      <p class="text-sm text-gray-600">
                          Complete your profile to attract top talent and build trust.
                      </p>
                  </div>
              </div>

              {{-- Card 3 --}}
              <div class="bg-white rounded-lg shadow p-5 flex items-start gap-4">
                  <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor"
                      class="size-20 text-emerald-500">
                      <path fill-rule="evenodd"
                          d="M12 6.75a.75.75 0 0 1 .75.75v3.75h3.75a.75.75 0 0 1 0 1.5H12.75V16.5
                          a.75.75 0 0 1-1.5 0v-3.75H7.5a.75.75 0 0 1 0-1.5h3.75V7.5
                          a.75.75 0 0 1 .75-.75Z"
                          clip-rule="evenodd" />
                  </svg>
                  <div>
                      <h3 class="font-semibold mb-1">Manage Applications</h3>
                      <p class="text-sm text-gray-600">
                          Review applicants, chat with them, and hire with confidence.
                      </p>
                  </div>
              </div>

          </div>

          {{-- Tip card --}}
          <div class="bg-emerald-50 border-l-4 border-emerald-400 rounded-lg p-4">
              <p class="text-sm text-gray-700">
                  💡 <strong>Tip:</strong> Jobs with clear descriptions receive more qualified applicants.
              </p>
          </div>

      </div>


      {{-- category cards --}}
      <span class="hidden">
          <h3 class="home_p_font text-black! text-center text-3xl max-lg:text-xl mb-3">Browse Categories</h3>
      <p class="home_p_font mb-5 text-center">Most popular categories of portal, sorted by popularity</p>

        <div class="category_card_container flex gap-7 max-lg:grid max-lg:grid-cols-2 items-center justify-center mb-20 max-[450px]:flex! max-[450px]:flex-wrap ">
          {{-- card 1 --}}
          <div class="w-[220px] h-[220px] max-sm:w-[180px] max-sm:h-[180px] max-[450px]:w-full! bg-white rounded-xl border-t-3 border-amber-300 shadow-sm flex flex-col items-center justify-center p-3">
            <div class="bg-amber-300 rounded-full p-3 mb-3">
              <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="size-7">
                <path d="M19.006 3.705a.75.75 0 1 0-.512-1.41L6 6.838V3a.75.75 0 0 0-.75-.75h-1.5A.75.75 0 0 0 3 3v4.93l-1.006.365a.75.75 0 0 0 .512 1.41l16.5-6Z" />
                <path fill-rule="evenodd" d="M3.019 11.114 18 5.667v3.421l4.006 1.457a.75.75 0 1 1-.512 1.41l-.494-.18v8.475h.75a.75.75 0 0 1 0 1.5H2.25a.75.75 0 0 1 0-1.5H3v-9.129l.019-.007ZM18 20.25v-9.566l1.5.546v9.02H18Zm-9-6a.75.75 0 0 0-.75.75v4.5c0 .414.336.75.75.75h3a.75.75 0 0 0 .75-.75V15a.75.75 0 0 0-.75-.75H9Z" clip-rule="evenodd" />
              </svg>
            </div>
            <h4 class="sub_title_font mb-2" >Finance</h4>
            <h3 class="home_p_font">(20+)</h3>
          </div>

          {{-- card 2 --}}
          <div class="w-[220px] h-[220px] max-sm:w-[180px] max-sm:h-[180px] max-[450px]:w-full! bg-white rounded-xl border-t-3 border-blue-300 shadow-sm flex flex-col items-center justify-center p-3">
            <div class="bg-blue-300 rounded-full p-3 mb-3">
              <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="size-7">
              <path d="M21.721 12.752a9.711 9.711 0 0 0-.945-5.003 12.754 12.754 0 0 1-4.339 2.708 18.991 18.991 0 0 1-.214 4.772 17.165 17.165 0 0 0 5.498-2.477ZM14.634 15.55a17.324 17.324 0 0 0 .332-4.647c-.952.227-1.945.347-2.966.347-1.021 0-2.014-.12-2.966-.347a17.515 17.515 0 0 0 .332 4.647 17.385 17.385 0 0 0 5.268 0ZM9.772 17.119a18.963 18.963 0 0 0 4.456 0A17.182 17.182 0 0 1 12 21.724a17.18 17.18 0 0 1-2.228-4.605ZM7.777 15.23a18.87 18.87 0 0 1-.214-4.774 12.753 12.753 0 0 1-4.34-2.708 9.711 9.711 0 0 0-.944 5.004 17.165 17.165 0 0 0 5.498 2.477ZM21.356 14.752a9.765 9.765 0 0 1-7.478 6.817 18.64 18.64 0 0 0 1.988-4.718 18.627 18.627 0 0 0 5.49-2.098ZM2.644 14.752c1.682.971 3.53 1.688 5.49 2.099a18.64 18.64 0 0 0 1.988 4.718 9.765 9.765 0 0 1-7.478-6.816ZM13.878 2.43a9.755 9.755 0 0 1 6.116 3.986 11.267 11.267 0 0 1-3.746 2.504 18.63 18.63 0 0 0-2.37-6.49ZM12 2.276a17.152 17.152 0 0 1 2.805 7.121c-.897.23-1.837.353-2.805.353-.968 0-1.908-.122-2.805-.353A17.151 17.151 0 0 1 12 2.276ZM10.122 2.43a18.629 18.629 0 0 0-2.37 6.49 11.266 11.266 0 0 1-3.746-2.504 9.754 9.754 0 0 1 6.116-3.985Z" />
            </svg>
            </div>
            <h4 class="sub_title_font mb-2" >Sale/Marketing</h4>
            <h3 class="home_p_font">(20+)</h3>
          </div>

          {{-- card 3 --}}
          <div class="w-[220px] h-[220px] max-sm:w-[180px] max-sm:h-[180px] max-[450px]:w-full! bg-white rounded-xl border-t-3 border-pink-300 shadow-sm flex flex-col items-center justify-center p-3">
            <div class="bg-pink-300 rounded-full p-3 mb-3">
              <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="size-7">
              <path d="M11.25 4.533A9.707 9.707 0 0 0 6 3a9.735 9.735 0 0 0-3.25.555.75.75 0 0 0-.5.707v14.25a.75.75 0 0 0 1 .707A8.237 8.237 0 0 1 6 18.75c1.995 0 3.823.707 5.25 1.886V4.533ZM12.75 20.636A8.214 8.214 0 0 1 18 18.75c.966 0 1.89.166 2.75.47a.75.75 0 0 0 1-.708V4.262a.75.75 0 0 0-.5-.707A9.735 9.735 0 0 0 18 3a9.707 9.707 0 0 0-5.25 1.533v16.103Z" />
            </svg>
            </div>
            <h4 class="sub_title_font mb-2" >Education/Training</h4>
            <h3 class="home_p_font">(20+)</h3>
          </div>

          {{-- card 4 --}}
          <div class="w-[220px] h-[220px] max-sm:w-[180px] max-sm:h-[180px] max-[450px]:w-full! bg-white rounded-xl border-t-3 border-purple-300 shadow-sm flex flex-col items-center justify-center p-3">
            <div class="bg-purple-300 rounded-full p-3 mb-3">
              <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="size-6">
                <path fill-rule="evenodd" d="M2.25 5.25a3 3 0 0 1 3-3h13.5a3 3 0 0 1 3 3V15a3 3 0 0 1-3 3h-3v.257c0 .597.237 1.17.659 1.591l.621.622a.75.75 0 0 1-.53 1.28h-9a.75.75 0 0 1-.53-1.28l.621-.622a2.25 2.25 0 0 0 .659-1.59V18h-3a3 3 0 0 1-3-3V5.25Zm1.5 0v7.5a1.5 1.5 0 0 0 1.5 1.5h13.5a1.5 1.5 0 0 0 1.5-1.5v-7.5a1.5 1.5 0 0 0-1.5-1.5H5.25a1.5 1.5 0 0 0-1.5 1.5Z" clip-rule="evenodd" />
              </svg>
            </div>
            <h4 class="sub_title_font mb-2" >Finance</h4>
            <h3 class="home_p_font">(20+)</h3>
          </div>

        </div>
      </span>

    </section>


    {{-- modals section--}}
    @include('components.profile_modal')
    @include('components.incoming-call')

    {{-- post a job modal --}}
    <div class="modal_bg post_job_modal fixed top-0 left-0 w-full h-full z-50 max-sm:px-6 px-10 hidden">
      {{-- menu control --}}
        <div class="lg:w-3xl max-h-[80vh] overflow-y-auto mt-20 mx-auto p-5 max-sm:p-4 bg-gray-200 opacity-100 rounded-xl shadow-sm">
            {{-- modal sub title and close button --}}
            <div class="flex justify-between items-center mb-2">
                <h3 class="sub_title_font max-sm:text-sm">Enter complete job details to post</h3>
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" id="close_post_job" class="size-5 cursor-pointer  hover:bg-red-400! rounded-sm max-sm:size-5 bg-gray-300!">
                <path stroke-linecap="round" stroke-linejoin="round" d="M6 18 18 6M6 6l12 12" />
                </svg>
            </div>
            
             <form action="{{ route('job_posts.store') }}" method="POST" class="w-full bg-white p-3 rounded-lg shadow-sm ">
              @csrf
                {{-- form fields --}}
                <div class="input_control flex max-sm:flex-col gap-3 mb-3">
                    <div class="input_group flex flex-col w-full">
                        <label for="job_title" class="mb-1 home_p_font text-black! max-sm:text-sm">Job Title <span class="text-red-500">*</span></label>
                        <input type="text" id="job_title" name="job_title" placeholder="Enter specific job title" class="p-2 border-2 border-gray-400 rounded-lg max-sm:text-sm" required>
                    </div>
                    <div class="input_group flex flex-col w-full">
                        <label for="job_location" class="mb-1 home_p_font text-black! max-sm:text-sm">Location <span class="home_p_font">(address)</span> <span class="text-red-500">*</span></label>
                        <input type="text" id="job_location" name="job_location" placeholder="Enter complete job location" class="p-2 border-2 border-gray-400 rounded-lg max-sm:text-sm" required>
                    </div>
                </div>

                <div class="input_control flex max-sm:flex-col gap-3 mb-3">
                    <div class="input_group flex flex-col w-full">
                        <label for="job_type" class="mb-1 home_p_font text-black! max-sm:text-sm">Job Type <span class="text-red-500">*</span></label>  
                        <select name="job_type" id="job_type" class="p-2 border-2 border-gray-400 rounded-lg max-sm:text-sm capitalize p_font" required>
                            <option value="" disabled selected>Select job type</option>
                            <option value="part-time">part-time</option>
                            <option value="contractual">contractual</option>
                            <option value="temporary">temporary</option>
                            <option value="internship">internship</option>
                            <option value="full-time">full-time</option>
                        </select>

                        
                    </div>
                    <div class="input_group flex flex-col w-full">
                        <label for="job_pay" class="mb-1 home_p_font text-black! max-sm:text-sm">Salary <span class="text-red-500">*</span></label>
                        <input type="number" id="job_pay" name="job_pay" placeholder="₱0.00" class="p-2 border-2 border-gray-400 rounded-lg max-sm:text-sm" required>
                    </div>
                </div>

                <div class="input_control flex flex-col gap-3 mb-3 ">
                    <div class="input_group flex flex-col w-full">
                        <label for="salary_release" class="mb-1 home_p_font text-black! max-sm:text-sm">Salary Release <span class="text-red-500">*</span></label>
                        <select name="salary_release" id="salary_release" class="p-2 border-2 border-gray-400 rounded-lg max-sm:text-sm capitalize p_font" required>
                            <option value="" disabled selected>Select salary release</option>
                            <option value="weekly">weekly</option>
                            <option value="bi-weekly">bi-weekly</option>
                            <option value="monthly">monthly</option>
                            <option value="per-project">per-project</option>
                        </select>

                        
                    </div>
                    <div class="input_group flex flex-col w-full">
                        <label for="skills_required" class="mb-1 home_p_font text-black! max-sm:text-sm">Skills required <span class="text-red-500">*</span> <br><span class="home_p_font text-xs">Separate skills using comma (,)</span></label>
                        <input type="text" id="skills_required" name="skills_required" placeholder="e.g. VA, HR, Data Entry" class="p-2 border-2 border-gray-400 rounded-lg max-sm:text-sm" required>
                    </div>
                </div>

                <div class="input_control flex flex-col gap-3 mb-3 ">
                    <div class="input_group flex flex-col w-full">
                        <label for="short_description" class="mb-1 home_p_font text-black! max-sm:text-sm">Short Job Description <span class="text-red-500">*</span></label>
                        <textarea id="short_description" name="short_description" rows="2" placeholder="Provide a short job summary that will appear on the job card." class="p-2 border-2 border-gray-400 rounded-lg max-sm:text-sm" required></textarea>
                    </div>
                </div>

                <div class="input_control flex flex-col gap-3 mb-3 ">
                    <div class="input_group flex flex-col w-full">
                        <label for="full_description" class="mb-1 home_p_font text-black! max-sm:text-sm">Full Job Description <span class="text-red-500">*</span></label>
                        <textarea id="full_description" name="full_description" rows="4" placeholder="Provide detailed information about the job role, responsibilities, and requirements." class="p-2 border-2 border-gray-400 rounded-lg max-sm:text-sm" required></textarea>
                    </div>
                </div>
                
                
                <div class="flex">
                <input type="submit" value="Post Job" class=" cursor-pointer bg-[#1E2939] text-white px-7 py-3 max-sm:py-3 max-sm:px-5 rounded-lg hover:opacity-90 max-sm:text-sm text-center ml-auto max-sm:w-full button_font">
                </div>
             </form>
       </div>
    </div>

    @include('components.footer_client')

    
    <script src="{{ asset('js/client.js') }}"></script>
@endsection
 