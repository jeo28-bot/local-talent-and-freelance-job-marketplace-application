@extends('layouts.app')

@section('body-class', 'bg-[#F0F0F0]')


     <!-- navigation bar -->
    <nav class="w-full  bg-[#1E2939] text-white flex items-center px-8 max-lg:py-4 max-lg:px-4 max-sm:px-2">
      <div class="flex items-center">
        <a href="{{ route('client.index') }}"><img src="{{asset('assets/logoNoBg.png')}}" alt="logo image" class="w-65 max-xl:w-50 max-sm:w-40"></a>

       <div class=" flex ml-10 gap-5 max-lg:hidden">
        <a href="{{ route('client.index') }}" class="pages_nav a_font px-2 py-8 {{ request()->routeIs('client.index') ? 'selected_nav' : '' }}">Home</a>
        <a href="{{ route('client.postings') }}" class="pages_nav a_font px-2 py-8 {{ request()->routeIs('client.postings') ? 'selected_nav' : '' }}">Job Posting</a>
        <a href="{{ route('client.applicants') }}" class="pages_nav a_font px-2 py-8 {{ request()->routeIs('client.applicants') ? 'selected_nav' : '' }}">Applicants</a>
        
          {{-- transaction dropdown --}}
            <div class="flex relative group">
                <a 
                  class="pages_nav a_font px-2 py-8 flex items-center cursor-default
                  {{ request()->routeIs('client.transactions*') ? 'selected_nav' : '' }}">
                  Transactions 
                  <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4 ml-1 mt-[2px]" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
                  </svg>
                </a>

                <!-- Dropdown -->
                <div class="absolute top-20 left-0 mt-2 w-40 bg-[#1E2939] border border-gray-200 rounded-lg shadow-lg opacity-0 group-hover:opacity-100  z-50 pointer-events-none group-hover:pointer-events-auto">
                  <a href="{{ route('client.transactions.pending') }}" 
                    class="block px-4 py-2 max-sm:text-sm text-white hover:opacity-70 p_font {{ request()->routeIs('client.transactions.pending') ? 'text-blue-400!' : '' }}">
                    Pending
                  </a>
                  <a href="{{ route('client.transactions.completed') }}" 
                    class="block px-4 py-2 max-sm:ext-sm text-white hover:opacity-70 p_font {{ request()->routeIs('client.transactions.completed') ? 'text-blue-400!' : '' }}">
                    Completed
                  </a>
                </div>
            </div>



       </div>
      </div>

      <div class="ml-auto flex items-center gap-8 max-lg:gap-6 max-sm:gap-4">
        <a id="chatIcon" href="{{ route('client.messages') }}" class="pages_nav">
          <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="size-6 max-sm:size-5">
            <path fill-rule="evenodd" d="M4.848 2.771A49.144 49.144 0 0 1 12 2.25c2.43 0 4.817.178 7.152.52 1.978.292 3.348 2.024 3.348 3.97v6.02c0 1.946-1.37 3.678-3.348 3.97a48.901 48.901 0 0 1-3.476.383.39.39 0 0 0-.297.17l-2.755 4.133a.75.75 0 0 1-1.248 0l-2.755-4.133a.39.39 0 0 0-.297-.17 48.9 48.9 0 0 1-3.476-.384c-1.978-.29-3.348-2.024-3.348-3.97V6.741c0-1.946 1.37-3.68 3.348-3.97ZM6.75 8.25a.75.75 0 0 1 .75-.75h9a.75.75 0 0 1 0 1.5h-9a.75.75 0 0 1-.75-.75Zm.75 2.25a.75.75 0 0 0 0 1.5H12a.75.75 0 0 0 0-1.5H7.5Z" clip-rule="evenodd" />
          </svg>
          {{-- new chat indecator --}}
          <div id="newChatIndicator" class="p-1 bg-red-500 absolute rounded-full -mt-6 hidden max-sm:-mt-5.5 max-sm:-ml-1">
          </div>
        </a>
         
        <a id="notifIcon" href="{{ route('client.notifications') }}" class="pages_nav">
          <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="size-6 max-sm:size-5">
            <path fill-rule="evenodd" d="M5.25 9a6.75 6.75 0 0 1 13.5 0v.75c0 2.123.8 4.057 2.118 5.52a.75.75 0 0 1-.297 1.206c-1.544.57-3.16.99-4.831 1.243a3.75 3.75 0 1 1-7.48 0 24.585 24.585 0 0 1-4.831-1.244.75.75 0 0 1-.298-1.205A8.217 8.217 0 0 0 5.25 9.75V9Zm4.502 8.9a2.25 2.25 0 1 0 4.496 0 25.057 25.057 0 0 1-4.496 0Z" clip-rule="evenodd" />
          </svg>
          {{-- new notif indecator --}}
          <div id="newChatNotif" class="p-1 bg-red-500 absolute rounded-full -mt-6 hidden">
          </div>
        </a>

         {{-- new notif indicator --}}
        <script>
          document.addEventListener('DOMContentLoaded', () => {
              const notifDot = document.getElementById('newChatNotif');

              async function checkNewNotifications() {
                  try {
                      let response = await fetch('/client/check-new-notifications');
                      let data = await response.json();

                      if (data.has_new) {
                          notifDot.classList.remove('hidden'); // show red dot
                      } else {
                          notifDot.classList.add('hidden'); // hide red dot
                      }
                  } catch (error) {
                      console.error('Error checking notifications:', error);
                  }
              }

              // Check immediately
              checkNewNotifications();

              // Poll every 5 seconds
              setInterval(checkNewNotifications, 5000);
          });
        </script>



          {{-- profile clicked --}}
          <div id="hover_target" class="flex items-center gap-2 max-lg:hidden">
            <a href="{{route('client.profile')}}" class="pages_nav ">
              <img src="{{ Auth::user()->profile_pic ? asset('storage/' . Auth::user()->profile_pic) : asset('assets/defaultUserPic.png') }}" alt="profile image" class="w-10 h-10 rounded-full border-2 border-gray-400">
            </a>
            {{-- drop down --}}
            <svg id="dropdown_icon" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" aria-hidden="true" data-slot="icon" class="size-6 font-semibold!">
              <path fill-rule="evenodd" d="M12.53 16.28a.75.75 0 0 1-1.06 0l-7.5-7.5a.75.75 0 0 1 1.06-1.06L12 14.69l6.97-6.97a.75.75 0 1 1 1.06 1.06l-7.5 7.5Z" clip-rule="evenodd"></path>
            </svg>
            {{-- dropdown items --}}
            <div id="dropdown_items" class="hidden py-2 px-3 bg-gray-900 absolute shadow-sm right-5 top-20 max-sm:top-20 text-gray-400 p_font rounded-lg w-60 max-sm:w-50 z-50">
                <h1 class="text-sm">{{ Auth::user()->name }}</h1>
                <h3 class="text-xs mb-2">{{ Auth::user()->email }}</h3>
                {{-- links --}}
                <div class="text-sm border-b-1 border-gray-600 mb-2 pb-2">
                  {{-- link 1 --}}
                    <form method="POST" action="{{ route('switch.role') }}" class="flex items-center gap-2 p-2 hover:bg-gray-700 rounded-lg max-sm:text-sm cursor-pointer">
                      @csrf
                      <input type="hidden" name="role" value="employee">
                        <button type="submit" class="flex items-center gap-2  cursor-pointer"> 
                          <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" aria-hidden="true" data-slot="icon" class="size-6 max-sm:size-5">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M7.5 21 3 16.5m0 0L7.5 12M3 16.5h13.5m0-13.5L21 7.5m0 0L16.5 12M21 7.5H7.5"></path>
                          </svg>
                          Switch to Employee
                        </button>
                    </form>
                    {{-- link 2 --}}
                    <a href="{{ route('client.profile') }}" class="flex items-center gap-2 p-2 hover:bg-gray-700 rounded-lg max-sm:text-sm"> <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-6 max-sm:size-5">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M17.982 18.725A7.488 7.488 0 0 0 12 15.75a7.488 7.488 0 0 0-5.982 2.975m11.963 0a9 9 0 1 0-11.963 0m11.963 0A8.966 8.966 0 0 1 12 21a8.966 8.966 0 0 1-5.982-2.275M15 9.75a3 3 0 1 1-6 0 3 3 0 0 1 6 0Z" />
                    </svg>
                    Edit Profile
                    </a>
                    {{-- link 2 --}}
                    <a href="#" class="flex items-center gap-2 p-2 hover:bg-gray-700 rounded-lg  max-sm:text-sm hidden"> 
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-6 max-sm:size-5">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M9.594 3.94c.09-.542.56-.94 1.11-.94h2.593c.55 0 1.02.398 1.11.94l.213 1.281c.063.374.313.686.645.87.074.04.147.083.22.127.325.196.72.257 1.075.124l1.217-.456a1.125 1.125 0 0 1 1.37.49l1.296 2.247a1.125 1.125 0 0 1-.26 1.431l-1.003.827c-.293.241-.438.613-.43.992a7.723 7.723 0 0 1 0 .255c-.008.378.137.75.43.991l1.004.827c.424.35.534.955.26 1.43l-1.298 2.247a1.125 1.125 0 0 1-1.369.491l-1.217-.456c-.355-.133-.75-.072-1.076.124a6.47 6.47 0 0 1-.22.128c-.331.183-.581.495-.644.869l-.213 1.281c-.09.543-.56.94-1.11.94h-2.594c-.55 0-1.019-.398-1.11-.94l-.213-1.281c-.062-.374-.312-.686-.644-.87a6.52 6.52 0 0 1-.22-.127c-.325-.196-.72-.257-1.076-.124l-1.217.456a1.125 1.125 0 0 1-1.369-.49l-1.297-2.247a1.125 1.125 0 0 1 .26-1.431l1.004-.827c.292-.24.437-.613.43-.991a6.932 6.932 0 0 1 0-.255c.007-.38-.138-.751-.43-.992l-1.004-.827a1.125 1.125 0 0 1-.26-1.43l1.297-2.247a1.125 1.125 0 0 1 1.37-.491l1.216.456c.356.133.751.072 1.076-.124.072-.044.146-.086.22-.128.332-.183.582-.495.644-.869l.214-1.28Z" />
                        <path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 1 1-6 0 3 3 0 0 1 6 0Z" />
                        </svg>
                    Account Settings
                    </a>
                </div>

                {{-- links --}}
                <div class="text-sm">
                    {{-- link 1 --}}
                        <a href="#" class="flex items-center gap-2 p-2 hover:bg-gray-700 rounded-lg max-sm:text-sm" onclick="event.preventDefault(); document.getElementById('logout-form').submit();"> 
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-6 max-sm:size-5">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M15.75 9V5.25A2.25 2.25 0 0 0 13.5 3h-6a2.25 2.25 0 0 0-2.25 2.25v13.5A2.25 2.25 0 0 0 7.5 21h6a2.25 2.25 0 0 0 2.25-2.25V15M12 9l-3 3m0 0 3 3m-3-3h12.75" />
                            </svg>
                        Sign out
                        </a>
                        
                        <form id="logout-form" action="{{ route('logout') }}" method="POST" class="hidden">
                            @csrf
                        </form>
                </div>

            </div>
          </div>
          {{-- profile dropdown script --}}
          <script>
          document.addEventListener("DOMContentLoaded", () => {
              const hoverTarget = document.getElementById("hover_target");
              const dropdown = document.getElementById("dropdown_items");
              const icon = document.getElementById("dropdown_icon");

              const arrowDown = `
                  <path fill-rule="evenodd"
                      d="M12.53 16.28a.75.75 0 0 1-1.06 0l-7.5-7.5a.75.75 0 0 1 1.06-1.06L12 14.69l6.97-6.97a.75.75 0 1 1 1.06 1.06l-7.5 7.5Z"
                      clip-rule="evenodd"></path>
              `;

              const arrowUp = `
                  <path fill-rule="evenodd"
                      d="M11.47 7.72a.75.75 0 0 1 1.06 0l7.5 7.5a.75.75 0 1 1-1.06 1.06L12 9.31l-6.97 6.97a.75.75 0 0 1-1.06-1.06l7.5-7.5Z"
                      clip-rule="evenodd"></path>
              `;

              // Show on hover
              hoverTarget.addEventListener("mouseenter", () => {
                  dropdown.classList.remove("hidden");
                  icon.innerHTML = arrowUp;
              });

              // Hide when leaving BOTH the target and the dropdown
              hoverTarget.addEventListener("mouseleave", () => {
                  setTimeout(() => {
                      if (!dropdown.matches(":hover")) {
                          dropdown.classList.add("hidden");
                          icon.innerHTML = arrowDown;
                      }
                  }, 50);
              });

              dropdown.addEventListener("mouseleave", () => {
                  dropdown.classList.add("hidden");
                  icon.innerHTML = arrowDown;
              });
          });
          </script>


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
              <a href="{{ route('client.index') }}" class="pages_nav border-b-1 px-5 py-3 border-gray-500">Home</a>
              <a href="{{ route('client.postings') }}" class="pages_nav border-b-1 px-5 py-3 border-gray-500">Job Posting</a>
              <a href="{{ route('client.applicants') }}" class="pages_nav border-b-1 px-5 py-3 border-gray-500">Applicants</a>
              

              <div class="group">
                  <a class="pages_nav border-b-1 px-5 py-3 border-gray-500 flex items-center cursor-default">
                    Transactions
                    <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4 ml-1 mt-[2px]" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                      <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
                    </svg>
                  </a>

                  {{-- drop down --}}
                  <div class="flex flex-col hidden group-hover:flex">
                    <a href="{{ route('client.transactions.pending') }}" 
                      class="pages_nav border-b-1 px-10 py-3 border-gray-600 text-sm text-gray-400 hover:opacity-70">
                      Pending
                    </a>
                    <a href="{{ route('client.transactions.completed') }}" 
                      class="pages_nav border-b-1 px-10 py-3 border-gray-600 text-sm text-gray-400 hover:opacity-70">
                      Completed
                    </a>
                  </div>
                </div>



              <a href="{{ route('client.profile') }}" class="pages_nav border-b-1 px-5 py-3 border-gray-500">Profile</a>
              <form method="POST" action="{{ route('switch.role') }}" class="pages_nav border-b-1 px-5 py-3 border-gray-500">
                @csrf
                <input type="hidden" name="role" value="employee">
                  <button type="submit" class="flex items-center gap-2  cursor-pointer"> 
                    Switch to <span class="text-yellow-400 font-semibold">Employee</span>
                  </button>
              </form>

              {{-- <a href="#" class="pages_nav border-b-1 px-5 py-3 border-gray-500">Settings</a> --}}
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



    
  {{-- red dot indicator JS --}}
  <script>
  document.addEventListener('DOMContentLoaded', () => {
      const newChatIndicator = document.getElementById('newChatIndicator');
      const isOnChatPage = window.location.pathname.includes('/client/chat/');

      async function checkNewMessages() {
          try {
              const response = await fetch("{{ route('client.messages.fetch') }}");
              const data = await response.json();

              // ✅ Only show red dot if there are unseen messages not sent by the client
              const hasUnseenMessage = data.some(chat =>
                  chat.latest_sender_id !== {{ auth()->id() }} && chat.seen == false
              );

              if (hasUnseenMessage && !isOnChatPage) {
                  newChatIndicator.classList.remove('hidden');
              } else {
                  newChatIndicator.classList.add('hidden');
              }

          } catch (err) {
              console.error('Error checking new messages:', err);
          }
      }

      checkNewMessages();
      setInterval(checkNewMessages, 3000);
  });
  </script>


