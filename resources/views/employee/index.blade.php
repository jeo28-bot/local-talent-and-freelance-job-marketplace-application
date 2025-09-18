@extends('layouts.app')

@section('body-class', 'bg-[#F0F0F0]')

@section('content')
    @include('components.nav_employee')
  
    <!-- main content -->
    <section class="w-full flex flex-col items-center  px-20 max-sm:px-10 pt-10">
      
      <h1 class="home_hero_font text-6xl mb-10 max-lg:text-4xl text-center max-lg:mb-5">Find Your Next Opportunity</h1>
      <h3 class="home_p_font text-center text-3xl max-lg:text-xl leading-10 max-lg:leading-8">Search jobs, connect with companies, and take <br>
      the next step in your career journey.</h3>
      
      {{-- home input desktop view --}}
      <div class="home_inputs_container flex mt-10 max-lg:mt-5 max-sm:flex-col max-sm:gap-4 border-2 border-gray-300 rounded-2xl shadow-lga items-center pr-3 max-sm:pr-0 max-[1155px]:hidden mb-20">
        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="size-6 absolute ml-5">
          <path fill-rule="evenodd" d="M10.5 3.75a6.75 6.75 0 1 0 0 13.5 6.75 6.75 0 0 0 0-13.5ZM2.25 10.5a8.25 8.25 0 1 1 14.59 5.28l4.69 4.69a.75.75 0 1 1-1.06 1.06l-4.69-4.69A8.25 8.25 0 0 1 2.25 10.5Z" clip-rule="evenodd" />
        </svg>
        <input type="text" placeholder="Job title, keywords, or company" class="rounded-xl home_input px-6 py-6 max-sm:py-3 max-sm:px-3 max-sm:w-full pl-15 focus:outline-blue-500 w-[400px]">
        <span class="w-[1px] h-[40px] bg-gray-500 opacity-50"></span>
        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="size-6 absolute ml-105">
          <path fill-rule="evenodd" d="m11.54 22.351.07.04.028.016a.76.76 0 0 0 .723 0l.028-.015.071-.041a16.975 16.975 0 0 0 1.144-.742 19.58 19.58 0 0 0 2.683-2.282c1.944-1.99 3.963-4.98 3.963-8.827a8.25 8.25 0 0 0-16.5 0c0 3.846 2.02 6.837 3.963 8.827a19.58 19.58 0 0 0 2.682 2.282 16.975 16.975 0 0 0 1.145.742ZM12 13.5a3 3 0 1 0 0-6 3 3 0 0 0 0 6Z" clip-rule="evenodd" />
        </svg>
        <input type="text" placeholder="Municipality, baranggay, zone" class="rounded-xl home_input px-6 py-6 max-sm:py-3 max-sm:px-3 max-sm:w-full mr-3 pl-15 focus:outline-blue-500  w-[400px]">
        <button class="cursor-pointer button_font bg-[#1E2939] text-blue-400 px-5 py-4 max-sm:py-3 max-sm:px-5 max-sm:w-full rounded-xl hover:opacity-90">Search Jobs</button>
      </div>

      {{-- home input responsive --}}
      <div class="w-2xl max-[715px]:w-full home_inputs_container flex flex-col mt-10 max-lg:mt-5 max-sm:gap-4 items-center min-[1155px]:hidden mb-20 gap-5">

        <div class="input_control w-full">
        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="size-6 absolute ml-5 mt-5 max-sm:ml-3 max-sm:mt-4">
          <path fill-rule="evenodd" d="M10.5 3.75a6.75 6.75 0 1 0 0 13.5 6.75 6.75 0 0 0 0-13.5ZM2.25 10.5a8.25 8.25 0 1 1 14.59 5.28l4.69 4.69a.75.75 0 1 1-1.06 1.06l-4.69-4.69A8.25 8.25 0 0 1 2.25 10.5Z" clip-rule="evenodd" />
        </svg>
        <input type="text" placeholder="Job title, keywords, or company" class="w-full border-2 border-gray-500 rounded-xl home_input py-4 max-sm:pl-10 max-sm:py-3 max-lg:py-4  pl-15 focus:outline-blue-500 ">
        </div>
        
        <div class="input_control w-full">
        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="size-6 absolute ml-5 mt-5 max-sm:ml-3 max-sm:mt-3.5">
          <path fill-rule="evenodd" d="m11.54 22.351.07.04.028.016a.76.76 0 0 0 .723 0l.028-.015.071-.041a16.975 16.975 0 0 0 1.144-.742 19.58 19.58 0 0 0 2.683-2.282c1.944-1.99 3.963-4.98 3.963-8.827a8.25 8.25 0 0 0-16.5 0c0 3.846 2.02 6.837 3.963 8.827a19.58 19.58 0 0 0 2.682 2.282 16.975 16.975 0 0 0 1.145.742ZM12 13.5a3 3 0 1 0 0-6 3 3 0 0 0 0 6Z" clip-rule="evenodd" />
        </svg>
        <input type="text" placeholder="Municipality, baranggay, zone" class="w-full border-2 border-gray-500 rounded-xl home_input py-4 max-sm:py-3 max-sm:pl-10 max-lg:py-4  pl-15 focus:outline-blue-500  ">
        </div>

        <button class="w-full cursor-pointer button_font bg-[#1E2939] text-blue-400 px-5 py-4 max-sm:py-3 max-sm:px-5 rounded-xl hover:opacity-90">Search Jobs</button>
      </div>

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

    </section>

    @include('components.footer_employee')
@endsection
