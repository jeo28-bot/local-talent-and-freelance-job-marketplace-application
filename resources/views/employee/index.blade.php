@extends('layouts.app')

@section('body-class', 'bg-[#F0F0F0]')

@section('content')
    @include('components.nav_employee')
  
    <!-- main content -->
    <section class="w-full min-h-[80vh] flex flex-col items-center  px-20 max-sm:px-10 pt-10">
      
      <h1 class="home_hero_font text-6xl mb-10 max-lg:text-4xl text-center max-lg:mb-5">Find Your Next Opportunity</h1>
      <h3 class="home_p_font text-center text-3xl max-lg:text-xl leading-10 max-lg:leading-8">Search jobs, connect with companies, and take <br>
      the next step in your career journey.</h3>
      
      {{-- home input desktop view --}}
      <form action="{{ route('employee.postings') }}" method="GET" class="home_inputs_container flex mt-10 max-lg:mt-5 max-sm:flex-col max-sm:gap-4 border-2 border-gray-300 rounded-2xl shadow-lga items-center pr-3 max-sm:pr-0 max-[1155px]:hidden mb-20">
          <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="size-6 absolute ml-5">
            <path fill-rule="evenodd" d="M10.5 3.75a6.75 6.75 0 1 0 0 13.5 6.75 6.75 0 0 0 0-13.5ZM2.25 10.5a8.25 8.25 0 1 1 14.59 5.28l4.69 4.69a.75.75 0 1 1-1.06 1.06l-4.69-4.69A8.25 8.25 0 0 1 2.25 10.5Z" clip-rule="evenodd" />
          </svg>
          <input type="text" name="q" placeholder="Job title, keywords, or company" class="rounded-xl home_input px-6 py-6 max-sm:py-3 max-sm:px-3 max-sm:w-full pl-15 focus:outline-blue-500 w-[400px]">
          <span class="w-[1px] h-[40px] bg-gray-500 opacity-50"></span>
          <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="size-6 absolute ml-105">
            <path fill-rule="evenodd" d="m11.54 22.351.07.04.028.016a.76.76 0 0 0 .723 0l.028-.015.071-.041a16.975 16.975 0 0 0 1.144-.742 19.58 19.58 0 0 0 2.683-2.282c1.944-1.99 3.963-4.98 3.963-8.827a8.25 8.25 0 0 0-16.5 0c0 3.846 2.02 6.837 3.963 8.827a19.58 19.58 0 0 0 2.682 2.282 16.975 16.975 0 0 0 1.145.742ZM12 13.5a3 3 0 1 0 0-6 3 3 0 0 0 0 6Z" clip-rule="evenodd" />
          </svg>
          <input type="text" name="location" placeholder="Municipality, baranggay, zone" class="rounded-xl home_input px-6 py-6 max-sm:py-3 max-sm:px-3 max-sm:w-full mr-3 pl-15 focus:outline-blue-500  w-[400px]">
          <button class="cursor-pointer button_font bg-[#1E2939] text-blue-400 px-5 py-4 max-sm:py-3 max-sm:px-5 max-sm:w-full rounded-xl hover:opacity-90">Search Jobs</button>
      </form>

      {{-- home input responsive --}}
      <form action="{{ route('employee.postings') }}" method="GET" class="w-2xl max-[715px]:w-full home_inputs_container flex flex-col mt-10 max-lg:mt-5 max-sm:gap-4 items-center min-[1155px]:hidden mb-10 gap-5">
          <div class="input_control w-full">
            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="size-6 absolute ml-5 mt-5 max-sm:ml-3 max-sm:mt-4">
              <path fill-rule="evenodd" d="M10.5 3.75a6.75 6.75 0 1 0 0 13.5 6.75 6.75 0 0 0 0-13.5ZM2.25 10.5a8.25 8.25 0 1 1 14.59 5.28l4.69 4.69a.75.75 0 1 1-1.06 1.06l-4.69-4.69A8.25 8.25 0 0 1 2.25 10.5Z" clip-rule="evenodd" />
            </svg>
            <input type="text" name="q" placeholder="Job title, keywords, or company" class="w-full border-2 border-gray-500 rounded-xl home_input py-4 max-sm:pl-10 max-sm:py-3 max-lg:py-4  pl-15 focus:outline-blue-500 ">
          </div>
          
          <div class="input_control w-full">
            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="size-6 absolute ml-5 mt-5 max-sm:ml-3 max-sm:mt-3.5">
              <path fill-rule="evenodd" d="m11.54 22.351.07.04.028.016a.76.76 0 0 0 .723 0l.028-.015.071-.041a16.975 16.975 0 0 0 1.144-.742 19.58 19.58 0 0 0 2.683-2.282c1.944-1.99 3.963-4.98 3.963-8.827a8.25 8.25 0 0 0-16.5 0c0 3.846 2.02 6.837 3.963 8.827a19.58 19.58 0 0 0 2.682 2.282 16.975 16.975 0 0 0 1.145.742ZM12 13.5a3 3 0 1 0 0-6 3 3 0 0 0 0 6Z" clip-rule="evenodd" />
            </svg>
            <input type="text" name="location" placeholder="Municipality, baranggay, zone" class="w-full border-2 border-gray-500 rounded-xl home_input py-4 max-sm:py-3 max-sm:pl-10 max-lg:py-4  pl-15 focus:outline-blue-500  ">
          </div>

          <button class="w-full cursor-pointer button_font bg-[#1E2939] text-blue-400 px-5 py-4 max-sm:py-3 max-sm:px-5 rounded-xl hover:opacity-90">Search Jobs</button>
        </form>

        {{-- other added elements in home page for employee --}}
        <div class="space-y-10 mb-20 w-4xl max-lg:w-full max-sm:px-3 p_font">

            {{-- Welcome / Hero --}}
            <div class="bg-gradient-to-r from-blue-500 to-indigo-600 text-white rounded-xl p-6 shadow">
                <h1 class="text-2xl font-bold mb-2">
                    Welcome back, {{ auth()->user()->name }} 👋
                </h1>
                <p class="opacity-90 text-sm">
                    Ready to land your next opportunity? Let’s get you hired.
                </p>
            </div>

            {{-- Info cards --}}
            <div class="grid grid-cols-3 max-lg:grid-cols-1 gap-4 ">

                {{-- Card 1 --}}
                <div class="bg-white rounded-lg shadow p-5 flex items-start gap-4">
                  <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" aria-hidden="true" data-slot="icon" class="size-20 text-blue-500">
                  <path fill-rule="evenodd" d="M7.5 5.25a3 3 0 0 1 3-3h3a3 3 0 0 1 3 3v.205c.933.085 1.857.197 2.774.334 1.454.218 2.476 1.483 2.476 2.917v3.033c0 1.211-.734 2.352-1.936 2.752A24.726 24.726 0 0 1 12 15.75c-2.73 0-5.357-.442-7.814-1.259-1.202-.4-1.936-1.541-1.936-2.752V8.706c0-1.434 1.022-2.7 2.476-2.917A48.814 48.814 0 0 1 7.5 5.455V5.25Zm7.5 0v.09a49.488 49.488 0 0 0-6 0v-.09a1.5 1.5 0 0 1 1.5-1.5h3a1.5 1.5 0 0 1 1.5 1.5Zm-3 8.25a.75.75 0 1 0 0-1.5.75.75 0 0 0 0 1.5Z" clip-rule="evenodd"></path>
                  <path d="M3 18.4v-2.796a4.3 4.3 0 0 0 .713.31A26.226 26.226 0 0 0 12 17.25c2.892 0 5.68-.468 8.287-1.335.252-.084.49-.189.713-.311V18.4c0 1.452-1.047 2.728-2.523 2.923-2.12.282-4.282.427-6.477.427a49.19 49.19 0 0 1-6.477-.427C4.047 21.128 3 19.852 3 18.4Z"></path>
                </svg>
                    <div>
                        <h3 class="font-semibold mb-1">Browse Jobs</h3>
                        <p class="text-sm text-gray-600">
                            Discover new job posts that match your skills and experience.
                        </p>
                    </div>
                </div>

                {{-- Card 2 --}}
                <div class="bg-white rounded-lg shadow p-5 flex items-start gap-4">
                  <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" aria-hidden="true" data-slot="icon" class="size-20 text-blue-500">
                    <path fill-rule="evenodd" d="M18.685 19.097A9.723 9.723 0 0 0 21.75 12c0-5.385-4.365-9.75-9.75-9.75S2.25 6.615 2.25 12a9.723 9.723 0 0 0 3.065 7.097A9.716 9.716 0 0 0 12 21.75a9.716 9.716 0 0 0 6.685-2.653Zm-12.54-1.285A7.486 7.486 0 0 1 12 15a7.486 7.486 0 0 1 5.855 2.812A8.224 8.224 0 0 1 12 20.25a8.224 8.224 0 0 1-5.855-2.438ZM15.75 9a3.75 3.75 0 1 1-7.5 0 3.75 3.75 0 0 1 7.5 0Z" clip-rule="evenodd"></path>
                  </svg>
                    <div>
                        <h3 class="font-semibold mb-1">Complete Your Profile</h3>
                        <p class="text-sm text-gray-600">
                            A complete profile increases your chances of getting hired.
                        </p>
                    </div>
                </div>

                {{-- Card 3 --}}
                <div class="bg-white rounded-lg shadow p-5 flex items-start gap-4">
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" aria-hidden="true" data-slot="icon" class="size-20 text-blue-500">
                    <path fill-rule="evenodd" d="M8.25 6.75a3.75 3.75 0 1 1 7.5 0 3.75 3.75 0 0 1-7.5 0ZM15.75 9.75a3 3 0 1 1 6 0 3 3 0 0 1-6 0ZM2.25 9.75a3 3 0 1 1 6 0 3 3 0 0 1-6 0ZM6.31 15.117A6.745 6.745 0 0 1 12 12a6.745 6.745 0 0 1 6.709 7.498.75.75 0 0 1-.372.568A12.696 12.696 0 0 1 12 21.75c-2.305 0-4.47-.612-6.337-1.684a.75.75 0 0 1-.372-.568 6.787 6.787 0 0 1 1.019-4.38Z" clip-rule="evenodd"></path>
                    <path d="M5.082 14.254a8.287 8.287 0 0 0-1.308 5.135 9.687 9.687 0 0 1-1.764-.44l-.115-.04a.563.563 0 0 1-.373-.487l-.01-.121a3.75 3.75 0 0 1 3.57-4.047ZM20.226 19.389a8.287 8.287 0 0 0-1.308-5.135 3.75 3.75 0 0 1 3.57 4.047l-.01.121a.563.563 0 0 1-.373.486l-.115.04c-.567.2-1.156.349-1.764.441Z"></path>
                  </svg>
                    <div>
                        <h3 class="font-semibold mb-1">Stay Connected</h3>
                        <p class="text-sm text-gray-600">
                            Chat with clients and respond quickly to job offers.
                        </p>
                    </div>
                </div>

            </div>

            {{-- Tip card --}}
            <div class="bg-blue-100 border-l-4 border-blue-400 rounded-lg p-4">
                <p class="text-sm text-gray-700">
                    💡 <strong>Pro tip:</strong> Employees with ratings above <strong>4.5★</strong> get hired faster.
                </p>
            </div>

        </div>

        {{-- announcement float --}}
        <div class="px-5 fixed bottom-5 right-0 flex flex-col gap-4 max-sm:gap-2 z-50">
          @foreach ($announcements as $index => $announcement)
            <div 
              x-data="{ show: false }"
              x-init="setTimeout(() => show = true, {{ $index }} * 500)"
              x-show="show"
              x-transition:enter="transition ease-out duration-300"
              x-transition:enter-start="opacity-0 translate-y-4"
              x-transition:enter-end="opacity-100 translate-y-0"
              x-transition:leave="transition ease-in duration-200"
              x-transition:leave-start="opacity-100"
              x-transition:leave-end="opacity-0"
              class="bg-blue-500 text-white px-4 py-2 rounded-lg shadow-lg w-lg max-sm:w-full"
            >
              <div class="flex items-center justify-between mb-2">
                <h1 class="font-semibold max-sm:text-sm">
                  📢 {{ $announcement->title }}
                </h1>

                <button 
                  @click="show = false"
                  class="bg-blue-600 rounded-sm cursor-pointer hover:bg-blue-400"
                >
                  <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                    stroke-width="1.5" stroke="currentColor" class="size-5">
                    <path stroke-linecap="round" stroke-linejoin="round"
                      d="M6 18 18 6M6 6l12 12" />
                  </svg>
                </button>
              </div>

              <p class="text-sm">
                {{ $announcement->message }}
              </p>
            </div>
          @endforeach
        </div>
        
  
    <script defer src="https://unpkg.com/alpinejs@3.x.x/dist/cdn.min.js"></script>

      {{-- browse category section --}}
      <span class="hidden">
        <h3 class="home_p_font text-black! text-center text-3xl max-lg:text-xl mb-3">Browse Categories</h3>
        <p class="home_p_font mb-5 text-center">Most popular categories of portal, sorted by popularity</p>

        {{-- category cards --}}
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

    @include('components.profile_modal')

    {{-- modal section --}}
    

    {{-- footer section --}}

    @include('components.footer_employee')
@endsection
