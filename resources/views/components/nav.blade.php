@extends('layouts.app')

@section('body-class', 'bg-[#F0F0F0]')


     <!-- navigation bar -->
    <nav class="w-full  bg-[#1E2939] text-white flex items-center px-8 max-lg:py-4 max-lg:px-4 max-sm:px-2">
      <div class="flex items-center">
       <img src="{{asset('assets/logoNoBg.png')}}" alt="logo image" class="w-65 max-xl:w-50 max-sm:w-40">

       <div class=" flex ml-10 gap-5 max-lg:hidden">
        <a href="{{ route('employee.index') }}" class="pages_nav a_font px-2 py-8 {{ request()->routeIs('employee.index') ? 'selected_nav' : '' }}">Home</a>
        <a href="{{ route('employee.postings') }}" class="pages_nav a_font px-2 py-8 {{ request()->routeIs('employee.postings') ? 'selected_nav' : '' }}">Job Posting</a>
        <a href="{{ route('employee.transactions') }}" class="pages_nav a_font px-2 py-8 {{ request()->routeIs('employee.transactions') ? 'selected_nav' : '' }}">Transactions</a>
       </div>
      </div>

      <div class="ml-auto flex items-center gap-8 max-lg:gap-6 max-sm:gap-4">
        <a id="saveIcon" href="{{ route('employee.saved') }}" class="pages_nav">
          <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 25 25" fill="currentColor" class="size-6 max-sm:size-5">
          <path fill-rule="evenodd" d="M6.32 2.577a49.255 49.255 0 0 1 11.36 0c1.497.174 2.57 1.46 2.57 2.93V21a.75.75 0 0 1-1.085.67L12 18.089l-7.165 3.583A.75.75 0 0 1 3.75 21V5.507c0-1.47 1.073-2.756 2.57-2.93Z" clip-rule="evenodd" />
          </svg>
        </a>
        <a id="chatIcon" href="{{ route('employee.messages') }}" class="pages_nav">
          <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="size-6 max-sm:size-5">
            <path fill-rule="evenodd" d="M4.848 2.771A49.144 49.144 0 0 1 12 2.25c2.43 0 4.817.178 7.152.52 1.978.292 3.348 2.024 3.348 3.97v6.02c0 1.946-1.37 3.678-3.348 3.97a48.901 48.901 0 0 1-3.476.383.39.39 0 0 0-.297.17l-2.755 4.133a.75.75 0 0 1-1.248 0l-2.755-4.133a.39.39 0 0 0-.297-.17 48.9 48.9 0 0 1-3.476-.384c-1.978-.29-3.348-2.024-3.348-3.97V6.741c0-1.946 1.37-3.68 3.348-3.97ZM6.75 8.25a.75.75 0 0 1 .75-.75h9a.75.75 0 0 1 0 1.5h-9a.75.75 0 0 1-.75-.75Zm.75 2.25a.75.75 0 0 0 0 1.5H12a.75.75 0 0 0 0-1.5H7.5Z" clip-rule="evenodd" />
          </svg>
        </a>
        <a id="notifIcon" href="{{ route('employee.notifications') }}" class="pages_nav">
          <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="size-6 max-sm:size-5">
            <path fill-rule="evenodd" d="M5.25 9a6.75 6.75 0 0 1 13.5 0v.75c0 2.123.8 4.057 2.118 5.52a.75.75 0 0 1-.297 1.206c-1.544.57-3.16.99-4.831 1.243a3.75 3.75 0 1 1-7.48 0 24.585 24.585 0 0 1-4.831-1.244.75.75 0 0 1-.298-1.205A8.217 8.217 0 0 0 5.25 9.75V9Zm4.502 8.9a2.25 2.25 0 1 0 4.496 0 25.057 25.057 0 0 1-4.496 0Z" clip-rule="evenodd" />
          </svg>
          
        </a>

        <a href="{{route('employee.profile')}}" class="pages_nav max-lg:hidden">
          <img src="{{asset('assets/samplePerson.png')}}" alt="profile image" class="w-10 rounded-full border-2 border-white">
        </a>

        <span class="cursor-pointer lg:hidden pages_nav hamburger_menu">
          <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="size-7">
            <path fill-rule="evenodd" d="M3 6.75A.75.75 0 0 1 3.75 6h16.5a.75.75 0 0 1 0 1.5H3.75A.75.75 0 0 1 3 6.75ZM3 12a.75.75 0 0 1 .75-.75h16.5a.75.75 0 0 1 0 1.5H3.75A.75.75 0 0 1 3 12Zm0 5.25a.75.75 0 0 1 .75-.75h16.5a.75.75 0 0 1 0 1.5H3.75a.75.75 0 0 1-.75-.75Z" clip-rule="evenodd" />
          </svg>
        </span>

      </div>

    </nav>

    {{-- hamburger menu popup --}}
    <div class="hamburger_pop_menu fixed top-0 left-0 w-full h-full z-50 lg:hidden hidden">
      {{-- menu control --}}
        <div class="w-sm max-sm:w-full ml-auto  h-full bg-[#1E2939] opacity-100">
            <span class="cursor-pointer absolute top-5 right-5 close_nav_menu ">
              <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="size-7 text-white pages_nav">
                <path fill-rule="evenodd" d="M5.47 5.47a.75.75 0 0 1 1.06 0L12 10.94l5.47-5.47a.75.75 0 1 1 1.06 1.06L13.06 12l5.47 5.47a.75.75 0 1 1-1.06 1.06L12 13.06l-5.47 5.47a.75.75 0 0 1-1.06-1.06L10.94 12 5.47 6.53a.75.75 0 0 1 0-1.06Z" clip-rule="evenodd" />
              </svg>
            </span>

            <div class="flex flex-col h-full text-white pt-20 a_font">
              <a href="{{ route('employee.index') }}" class="pages_nav border-b-1 px-5 py-3 border-gray-500">Home</a>
              <a href="{{ route('employee.postings') }}" class="pages_nav border-b-1 px-5 py-3 border-gray-500">Job Posting</a>
              <a href="{{ route('employee.transactions') }}" class="pages_nav border-b-1 px-5 py-3 border-gray-500">Transactions</a>
              <a href="{{ route('employee.profile') }}" class="pages_nav border-b-1 px-5 py-3 border-gray-500">Profile</a>
              <a href="#" class="pages_nav border-b-1 px-5 py-3 border-gray-500">Settings</a>
              {{-- logout --}}
              <a href="#" 
                class="pages_nav border-b-1 px-5 py-3 border-gray-500"
                onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                Log-out <br> 
                <span class="text-sm text-gray-500">{{ Auth::user()->email }}</span>
              </a>

              <form id="logout-form" action="{{ route('logout') }}" method="POST" class="hidden">
                  @csrf
              </form>

              <a href="#" class=" border-b-1 px-5 py-3 border-gray-500 text-gray-500">©Freelanco 2025</a>
            </div>
       </div>
    </div>

