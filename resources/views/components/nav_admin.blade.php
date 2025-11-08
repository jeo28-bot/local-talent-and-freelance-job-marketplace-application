{{-- parent div --}}
<div class="flex fixed w-full pointer-events-none">
    {{-- vertical nav --}}
    <div id="vert_nav" class="bg-[#1E2939] w-auto min-h-[100vh] flex flex-col items-center border-r-1 border-gray-600 max-lg:fixed max-lg:w-80 max-sm:w-65 z-50 pointer-events-auto ">
        {{-- logo --}}
        <div class=" px-6 py-2">
        {{-- logo --}}
        <img src="{{asset('assets/logoNoBg.png')}}" alt="logo image" class="w-75 cursor-pointer max-sm:w-60">
        </div>    
        
        {{-- links --}}
        <div class="p_font text-white flex flex-col w-full px-5 gap-2 max-sm:px-3">
            {{-- menu section --}}
            <h1 class="text-sm p_font uppercase text-gray-400 py-2 max-sm:text-xs">Menu</h1>

            {{-- link 1 --}}
            <a href="{{ route('admin.index') }}" class="max-sm:text-sm flex items-center gap-2 py-2 hover:bg-gray-700 px-5 rounded-lg {{ request()->routeIs('admin.index') ? 'admin_selected_nav' : '' }}">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-6 max-sm:size-5">
                <path stroke-linecap="round" stroke-linejoin="round" d="M3.75 6A2.25 2.25 0 0 1 6 3.75h2.25A2.25 2.25 0 0 1 10.5 6v2.25a2.25 2.25 0 0 1-2.25 2.25H6a2.25 2.25 0 0 1-2.25-2.25V6ZM3.75 15.75A2.25 2.25 0 0 1 6 13.5h2.25a2.25 2.25 0 0 1 2.25 2.25V18a2.25 2.25 0 0 1-2.25 2.25H6A2.25 2.25 0 0 1 3.75 18v-2.25ZM13.5 6a2.25 2.25 0 0 1 2.25-2.25H18A2.25 2.25 0 0 1 20.25 6v2.25A2.25 2.25 0 0 1 18 10.5h-2.25a2.25 2.25 0 0 1-2.25-2.25V6ZM13.5 15.75a2.25 2.25 0 0 1 2.25-2.25H18a2.25 2.25 0 0 1 2.25 2.25V18A2.25 2.25 0 0 1 18 20.25h-2.25A2.25 2.25 0 0 1 13.5 18v-2.25Z" />
                </svg>
                Dashboard
            </a>

            {{-- link 2 --}}
            <a id="nav_users" class="max-sm:text-sm nav_link flex items-center gap-2 py-2 hover:bg-gray-700 px-5 rounded-lg cursor-pointer {{ request()->routeIs('admin.users') ? 'admin_selected_nav' : '' }}">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-6 max-sm:size-5">
                <path stroke-linecap="round" stroke-linejoin="round" d="M15 19.128a9.38 9.38 0 0 0 2.625.372 9.337 9.337 0 0 0 4.121-.952 4.125 4.125 0 0 0-7.533-2.493M15 19.128v-.003c0-1.113-.285-2.16-.786-3.07M15 19.128v.106A12.318 12.318 0 0 1 8.624 21c-2.331 0-4.512-.645-6.374-1.766l-.001-.109a6.375 6.375 0 0 1 11.964-3.07M12 6.375a3.375 3.375 0 1 1-6.75 0 3.375 3.375 0 0 1 6.75 0Zm8.25 2.25a2.625 2.625 0 1 1-5.25 0 2.625 2.625 0 0 1 5.25 0Z" />
                </svg>
                Users
                <svg id="nav_users_arrow" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-5 ml-auto max-sm:size-4">
                <path stroke-linecap="round" stroke-linejoin="round" d="m19.5 8.25-7.5 7.5-7.5-7.5" />
                </svg>
            </a>
                {{-- link 2 dropdown items --}}
                <div id="dropdown_users" class="dropdown_items flex flex-col pl-8 hidden max-sm:text-sm">
                     <a href="{{ route('admin.users') }}" 
                    class="py-2 hover:bg-gray-700 px-5 rounded-lg {{ request()->routeIs('admin.users') && !request('search') ? 'admin_selected_nav' : '' }}">
                    View All Users
                    </a>
                     <a href="{{ route('admin.users', ['search' => 'client']) }}" 
                        class="py-2 hover:bg-gray-700 px-5 rounded-lg {{ request('search') === 'client' ? 'admin_selected_nav' : '' }}">
                        View Clients
                        </a>

                        <a href="{{ route('admin.users', ['search' => 'employee']) }}" 
                        class="py-2 hover:bg-gray-700 px-5 rounded-lg {{ request('search') === 'employee' ? 'admin_selected_nav' : '' }}">
                        View Employees
                        </a>
                </div>
            
            {{-- link 3 without dropdown --}}
            <a href="{{ route('admin.job_post') }}" class=" flex items-center gap-2 py-2 hover:bg-gray-700 px-5 rounded-lg max-sm:text-sm cursor-pointer {{ request()->routeIs('admin.job_post') ? 'admin_selected_nav' : '' }}">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-6 max-sm:size-5">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M20.25 14.15v4.25c0 1.094-.787 2.036-1.872 2.18-2.087.277-4.216.42-6.378.42s-4.291-.143-6.378-.42c-1.085-.144-1.872-1.086-1.872-2.18v-4.25m16.5 0a2.18 2.18 0 0 0 .75-1.661V8.706c0-1.081-.768-2.015-1.837-2.175a48.114 48.114 0 0 0-3.413-.387m4.5 8.006c-.194.165-.42.295-.673.38A23.978 23.978 0 0 1 12 15.75c-2.648 0-5.195-.429-7.577-1.22a2.016 2.016 0 0 1-.673-.38m0 0A2.18 2.18 0 0 1 3 12.489V8.706c0-1.081.768-2.015 1.837-2.175a48.111 48.111 0 0 1 3.413-.387m7.5 0V5.25A2.25 2.25 0 0 0 13.5 3h-3a2.25 2.25 0 0 0-2.25 2.25v.894m7.5 0a48.667 48.667 0 0 0-7.5 0M12 12.75h.008v.008H12v-.008Z" />
                    </svg>
                    Job Posts
                </a>
            
             {{-- link 3 with dropdown--}}
            <span class="hidden">
                <a id="nav_jobPosts" class="nav_link flex items-center gap-2 py-2 hover:bg-gray-700 px-5 rounded-lg max-sm:text-sm cursor-pointer">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-6 max-sm:size-5">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M20.25 14.15v4.25c0 1.094-.787 2.036-1.872 2.18-2.087.277-4.216.42-6.378.42s-4.291-.143-6.378-.42c-1.085-.144-1.872-1.086-1.872-2.18v-4.25m16.5 0a2.18 2.18 0 0 0 .75-1.661V8.706c0-1.081-.768-2.015-1.837-2.175a48.114 48.114 0 0 0-3.413-.387m4.5 8.006c-.194.165-.42.295-.673.38A23.978 23.978 0 0 1 12 15.75c-2.648 0-5.195-.429-7.577-1.22a2.016 2.016 0 0 1-.673-.38m0 0A2.18 2.18 0 0 1 3 12.489V8.706c0-1.081.768-2.015 1.837-2.175a48.111 48.111 0 0 1 3.413-.387m7.5 0V5.25A2.25 2.25 0 0 0 13.5 3h-3a2.25 2.25 0 0 0-2.25 2.25v.894m7.5 0a48.667 48.667 0 0 0-7.5 0M12 12.75h.008v.008H12v-.008Z" />
                    </svg>
                    Job Posts
                    <svg id="nav_jobPosts_arrow" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-5 ml-auto">
                    <path stroke-linecap="round" stroke-linejoin="round" d="m19.5 8.25-7.5 7.5-7.5-7.5" />
                    </svg>
                </a>
                    {{-- link 3 dropdown items --}}
                    <div id="dropdown_jobPosts" class="dropdown_items flex flex-col pl-8 hidden max-sm:text-sm">
                        <a href="#" class="py-2 hover:bg-gray-700 px-5 rounded-lg">All Job Posts</a>
                        <a href="#" class="py-2 hover:bg-gray-700 px-5 rounded-lg">Pending Approval</a>
                        <a href="#" class="py-2 hover:bg-gray-700 px-5 rounded-lg">Approved</a>
                    </div>
            </span>
            
            {{-- link 4 --}}
            <a href="{{ route('admin.applications') }}" id="nav_applications" class="flex items-center gap-2 py-2 hover:bg-gray-700 px-5 rounded-lg max-sm:text-sm {{ request()->routeIs('admin.applications') ? 'admin_selected_nav' : '' }}">
               <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-6 max-sm:size-5">
                <path stroke-linecap="round" stroke-linejoin="round" d="M19.5 14.25v-2.625a3.375 3.375 0 0 0-3.375-3.375h-1.5A1.125 1.125 0 0 1 13.5 7.125v-1.5a3.375 3.375 0 0 0-3.375-3.375H8.25m0 12.75h7.5m-7.5 3H12M10.5 2.25H5.625c-.621 0-1.125.504-1.125 1.125v17.25c0 .621.504 1.125 1.125 1.125h12.75c.621 0 1.125-.504 1.125-1.125V11.25a9 9 0 0 0-9-9Z" />
                </svg>
                Applications
            </a>
             {{-- link 5 --}}
            <a href="{{ route('admin.transactions') }}" id="nav_applications" class="flex items-center gap-2 py-2 hover:bg-gray-700 px-5 rounded-lg max-sm:text-sm {{ request()->routeIs('admin.transactions') ? 'admin_selected_nav' : '' }}">
               <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-6 max-sm:size-5">
                <path stroke-linecap="round" stroke-linejoin="round" d="M19.5 12c0-1.232-.046-2.453-.138-3.662a4.006 4.006 0 0 0-3.7-3.7 48.678 48.678 0 0 0-7.324 0 4.006 4.006 0 0 0-3.7 3.7c-.017.22-.032.441-.046.662M19.5 12l3-3m-3 3-3-3m-12 3c0 1.232.046 2.453.138 3.662a4.006 4.006 0 0 0 3.7 3.7 48.656 48.656 0 0 0 7.324 0 4.006 4.006 0 0 0 3.7-3.7c.017-.22.032-.441.046-.662M4.5 12l3 3m-3-3-3 3" />
                </svg>
                Transactions
            </a>

            {{-- support section --}}
            <h1 class="text-sm p_font uppercase text-gray-400 py-2 max-sm:text-xs">Support</h1>
            {{-- link 5 --}}
            <a href="{{route('admin.messages')}}" id="nav_applications" class="flex items-center gap-2 py-2 hover:bg-gray-700 px-5 rounded-lg max-sm:text-sm {{ request()->routeIs('admin.messages') ? 'admin_selected_nav' : '' }}">
               <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-6 max-sm:size-5">
                <path stroke-linecap="round" stroke-linejoin="round" d="M20.25 8.511c.884.284 1.5 1.128 1.5 2.097v4.286c0 1.136-.847 2.1-1.98 2.193-.34.027-.68.052-1.02.072v3.091l-3-3c-1.354 0-2.694-.055-4.02-.163a2.115 2.115 0 0 1-.825-.242m9.345-8.334a2.126 2.126 0 0 0-.476-.095 48.64 48.64 0 0 0-8.048 0c-1.131.094-1.976 1.057-1.976 2.192v4.286c0 .837.46 1.58 1.155 1.951m9.345-8.334V6.637c0-1.621-1.152-3.026-2.76-3.235A48.455 48.455 0 0 0 11.25 3c-2.115 0-4.198.137-6.24.402-1.608.209-2.76 1.614-2.76 3.235v6.226c0 1.621 1.152 3.026 2.76 3.235.577.075 1.157.14 1.74.194V21l4.155-4.155" />
                </svg>

                Chats
            </a>
            {{-- link 6 --}}
            <a href="#" id="nav_applications" class="flex items-center gap-2 py-2 hover:bg-gray-700 px-5 rounded-lg max-sm:text-sm">
               <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-6 max-sm:size-5">
                <path stroke-linecap="round" stroke-linejoin="round" d="M12 9v3.75m9-.75a9 9 0 1 1-18 0 9 9 0 0 1 18 0Zm-9 3.75h.008v.008H12v-.008Z" />
                </svg>
                Reports
            </a>
            
        </div>

        <footer class="text-center text-gray-500 text-sm py-4 border-t border-gray-700 mt-auto px-2 p_font max-sm:text-xs">
            © 2025 Local Talent & Freelance Marketplace. <br> All rights reserved.
        </footer>

        

    </div>

    {{-- modal-bg for horizontal nav --}}
        <div>
        <div id="modal_bg" class="fixed top-0 left-0 w-full h-full modal_bg -z-1 lg:hidden pointer-events-auto "></div>

        </div>

    {{-- horizontal nav --}}
    <div class="pl-7 bg-[#1E2939] h-25 border-b-1 border-gray-600 flex items-center w-full pr-5 max-sm:pl-4 max-sm:pr-2 max-lg:-z-3 pointer-events-auto max-sm:h-20">
        {{-- hamburder button --}}
        <button id="hamburder_button" class="lg:hidden p-2 border-1 border-gray-600 rounded-lg cursor-pointer hover:shadow-sm shadow-white mr-5 max-sm:mr-3">
            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-7 text-white max-lg:size-6 max-sm:size-5">
            <path stroke-linecap="round" stroke-linejoin="round" d="M3.75 6.75h16.5M3.75 12h16.5m-16.5 5.25h16.5" />
            </svg>
        </button>
        {{-- search input --}}
        <div class="max-sm:hidden">
            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-5 text-white absolute mt-3 ml-3">
            <path stroke-linecap="round" stroke-linejoin="round" d="m21 21-5.197-5.197m0 0A7.5 7.5 0 1 0 5.196 5.196a7.5 7.5 0 0 0 10.607 10.607Z" />
            </svg>

            <input type="text" class="p-2 border-2 border-gray-600 rounded-lg bg-[#243145] text-white pl-10 w-90 max-lg:w-60 focus:outline-none focus:border-blue-500" placeholder="Search...">

            <button class="cursor-pointer p-1 absolute bg-[#151e2b] rounded-lg -ml-10 mt-1.5 hover:shadow-sm shadow-white">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-6 text-white">
                <path stroke-linecap="round" stroke-linejoin="round" d="M7.5 3.75H6A2.25 2.25 0 0 0 3.75 6v1.5M16.5 3.75H18A2.25 2.25 0 0 1 20.25 6v1.5m0 9V18A2.25 2.25 0 0 1 18 20.25h-1.5m-9 0H6A2.25 2.25 0 0 1 3.75 18v-1.5M15 12a3 3 0 1 1-6 0 3 3 0 0 1 6 0Z" />
                </svg>
            </button>
        </div>
        {{-- profile and others --}}
        <div class="ml-auto flex gap-3 items-center max-sm:gap-2">
            {{-- inbox --}}
            <div class=" border-1 border-gray-600 rounded-full cursor-pointer hover:shadow-sm shadow-white flex relative">
                {{-- notification dot (hidden by default) --}}
                <div id="notifDot" class="p-1 bg-red-500 rounded-full absolute mt-1 hidden"></div>

                <a href="{{route('admin.inbox')}}" class="p-2">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-6 text-white max-sm:size-5">
                <path stroke-linecap="round" stroke-linejoin="round" d="M8.625 12a.375.375 0 1 1-.75 0 .375.375 0 0 1 .75 0Zm0 0H8.25m4.125 0a.375.375 0 1 1-.75 0 .375.375 0 0 1 .75 0Zm0 0H12m4.125 0a.375.375 0 1 1-.75 0 .375.375 0 0 1 .75 0Zm0 0h-.375M21 12c0 4.556-4.03 8.25-9 8.25a9.764 9.764 0 0 1-2.555-.337A5.972 5.972 0 0 1 5.41 20.97a5.969 5.969 0 0 1-.474-.065 4.48 4.48 0 0 0 .978-2.025c.09-.457-.133-.901-.467-1.226C3.93 16.178 3 14.189 3 12c0-4.556 4.03-8.25 9-8.25s9 3.694 9 8.25Z" />
                </svg>
                </a>
            </div>

            <script>
            document.addEventListener('DOMContentLoaded', () => {
                const notifDot = document.getElementById('notifDot');
                const url = "{{ route('admin.unreadCount') }}";

                async function checkUnread() {
                    try {
                        const res = await fetch(url, { credentials: 'same-origin' });
                        const data = await res.json();

                        if (data.unreadCount > 0) {
                            notifDot.classList.remove('hidden');
                        } else {
                            notifDot.classList.add('hidden');
                        }
                    } catch (err) {
                        console.error('Error checking unread count:', err);
                    }
                }

                // check immediately
                checkUnread();

                // check every 3 seconds while page is visible
                let interval = setInterval(() => {
                    if (!document.hidden) checkUnread();
                }, 3000);

                // if admin switches tab or minimizes window, pause polling
                document.addEventListener('visibilitychange', () => {
                    if (document.hidden) clearInterval(interval);
                    else interval = setInterval(() => checkUnread(), 3000);
                });
            });
            </script>



            {{-- notifaction --}}
            <a class="p-2 border-1 border-gray-600 rounded-full cursor-pointer hover:shadow-sm shadow-white">
            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-6 text-white max-sm:size-5">
            <path stroke-linecap="round" stroke-linejoin="round" d="M14.857 17.082a23.848 23.848 0 0 0 5.454-1.31A8.967 8.967 0 0 1 18 9.75V9A6 6 0 0 0 6 9v.75a8.967 8.967 0 0 1-2.312 6.022c1.733.64 3.56 1.085 5.455 1.31m5.714 0a24.255 24.255 0 0 1-5.714 0m5.714 0a3 3 0 1 1-5.714 0" />
            </svg>
            </a>

            {{-- profile --}}
            <button id="profile_dropdown" class="flex items-center text-gray-400 p_font cursor-pointer">
                <img src="{{ asset('assets/defaultUserPic.png') }}" alt="" class="w-13 max-sm:w-10">
                <h1 class="mr-2 max-sm:text-sm max-sm:hidden">{{ Auth::user()->name }}</h1>
                <svg id="arrow_icon" xmlns="http://www.w3.org/2000/svg" fill="none"
                    viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor"
                    class="size-4 transition-transform duration-200">
                    <path stroke-linecap="round" stroke-linejoin="round"
                        d="m19.5 8.25-7.5 7.5-7.5-7.5" />
                </svg>
            </button>


            {{-- dropdown items --}}
            <div id="dropdown_items" class="py-2 px-3 bg-gray-900 absolute shadow-sm right-5 top-25 max-sm:top-20 text-gray-400 p_font rounded-lg w-60 max-sm:w-50 hidden">
                <h1 class="text-sm">{{ Auth::user()->name }}</h1>
                <h3 class="text-xs mb-2">{{ Auth::user()->email }}</h3>
                {{-- links --}}
                <div class="text-sm border-b-1 border-gray-600 mb-2 pb-2">
                    {{-- link 1 --}}
                    <a href="{{ route('admin.profile') }}" class="flex items-center gap-2 p-2 hover:bg-gray-700 rounded-lg max-sm:text-sm"> <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-6 max-sm:size-5">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M17.982 18.725A7.488 7.488 0 0 0 12 15.75a7.488 7.488 0 0 0-5.982 2.975m11.963 0a9 9 0 1 0-11.963 0m11.963 0A8.966 8.966 0 0 1 12 21a8.966 8.966 0 0 1-5.982-2.275M15 9.75a3 3 0 1 1-6 0 3 3 0 0 1 6 0Z" />
                    </svg>
                    Edit Profile
                    </a>
                    {{-- link 2 --}}
                    <a href="#" class="flex items-center gap-2 p-2 hover:bg-gray-700 rounded-lg  max-sm:text-sm"> 
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

    </div>

</div>
