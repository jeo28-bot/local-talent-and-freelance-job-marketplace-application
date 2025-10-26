@extends('layouts.app')

@section('body-class', 'bg-[#F0F0F0]')

@section('content')
     @include('components.nav_admin')


    <!-- main content -->
    <section class="w-full  z-0">
        <div class="pt-35 pl-85 max-[1270px]:pl-75 max-lg:pl-7  pr-10 max-sm:pr-5 pb-15">
            {{-- padding top --}}
            {{-- title --}}
            <h1 class="home_p_font font-semibold! max-lg:text-sm mb-6">Dashboard</h1>
            {{-- contents --}}

            {{-- cards --}}
            {{-- card section 1 --}}
             <div class="flex gap-5 mb-10 max-sm:flex-col">
                    {{-- card 1 and 2 parent div --}}
                    {{-- total users card #1 --}}
                    <div class="bg-white rounded-lg shadow-md p-6 w-1/2 max-sm:w-full">
                        <h2 class="font-semibold! mb-4 home_p_font max-sm:text-sm">Total Users</h2>
                        <p class="text-3xl font-bold p_font">20</p>
                        {{-- employee and client count parent div --}}
                        <div class="flex gap-5 max-sm:flex-col max-sm:gap-2">
                        {{-- employee count --}}
                            <div class="mt-4 flex flex-col items-center shadow-sm border-t-3 border-blue-400 rounded-lg p-4 w-2/3 max-sm:w-full">
                                <h2 class="font-semibold! mb-4 home_p_font max-lg:text-sm text-center">Employee Count</h2>
                                <span class="p-3 bg-blue-100 text-blue-600 rounded-xl inline-block mb-4">
                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-7">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M15 19.128a9.38 9.38 0 0 0 2.625.372 9.337 9.337 0 0 0 4.121-.952 4.125 4.125 0 0 0-7.533-2.493M15 19.128v-.003c0-1.113-.285-2.16-.786-3.07M15 19.128v.106A12.318 12.318 0 0 1 8.624 21c-2.331 0-4.512-.645-6.374-1.766l-.001-.109a6.375 6.375 0 0 1 11.964-3.07M12 6.375a3.375 3.375 0 1 1-6.75 0 3.375 3.375 0 0 1 6.75 0Zm8.25 2.25a2.625 2.625 0 1 1-5.25 0 2.625 2.625 0 0 1 5.25 0Z" />
                                </svg>
                                </span>
                                <p class="text-3xl font-bold p_font">10</p>
                            </div>
                            {{-- Client count --}}
                            <div class="mt-4 flex flex-col items-center shadow-sm border-t-3 border-red-400 rounded-lg p-4 w-2/3 max-sm:w-full">
                                <h2 class="font-semibold! mb-4 home_p_font  max-lg:text-sm text-center">Client Count</h2>
                                <span class="p-3 bg-red-100 text-red-600 rounded-xl inline-block mb-4">
                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-7">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M20.25 14.15v4.25c0 1.094-.787 2.036-1.872 2.18-2.087.277-4.216.42-6.378.42s-4.291-.143-6.378-.42c-1.085-.144-1.872-1.086-1.872-2.18v-4.25m16.5 0a2.18 2.18 0 0 0 .75-1.661V8.706c0-1.081-.768-2.015-1.837-2.175a48.114 48.114 0 0 0-3.413-.387m4.5 8.006c-.194.165-.42.295-.673.38A23.978 23.978 0 0 1 12 15.75c-2.648 0-5.195-.429-7.577-1.22a2.016 2.016 0 0 1-.673-.38m0 0A2.18 2.18 0 0 1 3 12.489V8.706c0-1.081.768-2.015 1.837-2.175a48.111 48.111 0 0 1 3.413-.387m7.5 0V5.25A2.25 2.25 0 0 0 13.5 3h-3a2.25 2.25 0 0 0-2.25 2.25v.894m7.5 0a48.667 48.667 0 0 0-7.5 0M12 12.75h.008v.008H12v-.008Z" />
                                </svg>
                                </span>
                                <p class="text-3xl font-bold p_font">10</p>
                            </div>
                        </div>
                    </div>

                    {{-- total job posts card #2 --}}
                    <div class="bg-white rounded-lg shadow-md p-6 w-1/2 max-sm:w-full">
                        <h2 class="font-semibold! mb-4 home_p_font max-sm:text-sm">Total Job Posts</h2>
                        <p class="text-3xl font-bold p_font">13</p>
                            {{-- total jobs table div control --}}
                            <div class="mt-4 shadow-sm border-t-3 border-yellow-400 rounded-lg p-2 w-full max-h-48 overflow-x-auto">
                                <table class="w-full max-[1450px]:w-[500px] border-collapse rounded-lg overflow-hidden">
                                    {{-- table header --}}
                                    <thead>
                                        <tr class="bg-gray-100">
                                            <th class="home_p_font text-sm font-semibold! uppercase p-2 max-lg:text-xs">Job Title</th>
                                            <th class="home_p_font text-sm font-semibold! uppercase p-2 max-lg:text-xs">Posted By</th>
                                            <th class="home_p_font text-sm font-semibold! uppercase p-2 max-lg:text-xs">Date Posted</th>
                                            <th class="home_p_font text-sm font-semibold! uppercase p-2 max-lg:text-xs">Status</th>
                                        </tr>
                                    </thead>

                                    <tbody class="divide-y divide-gray-200">
                                        {{-- table data --}}
                                        <tr class="text-center p_font hover:bg-gray-50 max-lg:text-sm">
                                         <td class="p-2">Web Dev</td>
                                         <td class="p-2">Employee</td>
                                         <td class="p-2">09-10-2025</td>
                                         <td class="p-2">Open</td>
                                        </tr>
                                        <tr class="text-center p_font hover:bg-gray-50 max-lg:text-sm">
                                         <td class="p-2">Web Dev</td>
                                         <td class="p-2">Employee</td>
                                         <td class="p-2">09-10-2025</td>
                                         <td class="p-2">Open</td>
                                        </tr>
                                        <tr class="text-center p_font hover:bg-gray-50 max-lg:text-sm">
                                         <td class="p-2">Web Dev</td>
                                         <td class="p-2">Employee</td>
                                         <td class="p-2">09-10-2025</td>
                                         <td class="p-2">Open</td>
                                        </tr>
                                        <tr class="text-center p_font hover:bg-gray-50 max-lg:text-sm">
                                         <td class="p-2">Web Dev</td>
                                         <td class="p-2">Employee</td>
                                         <td class="p-2">09-10-2025</td>
                                         <td class="p-2">Open</td>
                                        </tr>
                                        
                                    </tbody>
                                </table>
                                
                            </div>
                            
                        
                    </div>
                    
            </div>
            {{-- end of card section 1 --}}

            {{-- card section 2 --}}
            <div class="flex gap-5  max-sm:flex-col">
                    {{-- latest activities card #3 --}}
                    <div class="bg-white rounded-lg shadow-md p-6 w-full h-150">
                        <h2 class="font-semibold! mb-2 home_p_font max-sm:text-sm border-b-2 border-gray-300 pb-3">Latest Activity</h2>
                        {{-- activity list parent div --}}
                        <div class="p-2">
                            {{-- activity list --}}
                            <ul class=" p_font max-sm:text-sm overflow-y-auto max-h-120">
                                <h3 class="text-red-400 py-2">October 23, 2025</h3>
                                <li class="p-2 border-b-1 border-gray-300 hover:bg-gray-100">User John Doe registered as Employee.</li>
                                <li class="p-2 border-b-1 border-gray-300 hover:bg-gray-100">User Jane Smith posted a new job titled "Web Developer".</li>
                                <li class="p-2 border-b-1 border-gray-300 hover:bg-gray-100">User Mike Johnson updated his profile information.</li>
                                <li class="p-2 border-b-1 border-gray-300 hover:bg-gray-100">User Emily Davis changed her password.</li>
                                <li class="p-2 border-b-1 border-gray-300 hover:bg-gray-100">User Chris Brown deleted his account.</li>
                                <li class="p-2 border-b-1 border-gray-300 hover:bg-gray-100">User Sarah Wilson applied for the job "Graphic Designer".</li>
                                <h3 class="text-red-400 py-2">October 24, 2025</h3>
                                <li class="p-2 border-b-1 border-gray-300 hover:bg-gray-100">User David Lee uploaded a new portfolio item.</li>
                                <li class="p-2 border-b-1 border-gray-300 hover:bg-gray-100">User Anna Kim sent a message to support.</li>
                                <li class="p-2 border-b-1 border-gray-300 hover:bg-gray-100">User Tom Clark logged in from a new device.</li>
                                <li class="p-2 border-b-1 border-gray-300 hover:bg-gray-100">User Laura Scott updated her notification preferences.</li>
                                <h3 class="text-red-400 py-2">October 24, 2025</h3>
                                <li class="p-2 border-b-1 border-gray-300 hover:bg-gray-100">User David Lee uploaded a new portfolio item.</li>
                                <li class="p-2 border-b-1 border-gray-300 hover:bg-gray-100">User Anna Kim sent a message to support.</li>
                                <li class="p-2 border-b-1 border-gray-300 hover:bg-gray-100">User Tom Clark logged in from a new device.</li>
                                <li class="p-2 border-b-1 border-gray-300 hover:bg-gray-100">User Laura Scott updated her notification preferences.</li>
                                <h3 class="text-red-400 py-2">October 24, 2025</h3>
                                <li class="p-2 border-b-1 border-gray-300 hover:bg-gray-100">User David Lee uploaded a new portfolio item.</li>
                                <li class="p-2 border-b-1 border-gray-300 hover:bg-gray-100">User Anna Kim sent a message to support.</li>
                                <li class="p-2 border-b-1 border-gray-300 hover:bg-gray-100">User Tom Clark logged in from a new device.</li>
                                <li class="p-2 border-b-1 border-gray-300 hover:bg-gray-100">User Laura Scott updated her notification preferences.</li>
                            </ul>
                        
                        </div>
                    </div>

                    {{-- Management Section #3 --}}
                    <div class="bg-white rounded-lg shadow-md p-6 w-1/3 max-xl:w-full max-sm:w-full">
                        <h2 class="font-semibold! mb-2 home_p_font max-sm:text-sm border-b-2 border-gray-300 pb-3">Quick Management Section</h2>
                        {{-- User management parent div --}}
                        <div class="p-2 flex flex-col">
                            {{-- buttons --}}
                            <h1 class="p_font mb-2">User Management</h1>
                            <button class="bg-blue-400 p-2 rounded-lg p_font cursor-pointer hover:bg-blue-500 mb-3 text-white">Manage Employees</button>
                            <button class="bg-red-400 p-2 rounded-lg p_font cursor-pointer hover:bg-red-500 mb- text-white">Manage Clients</button>
                        
                        </div>

                        {{-- Job post management parent div --}}
                        <div class="p-2 flex flex-col">
                            {{-- buttons --}}
                            <h1 class="p_font mb-2">Job Management</h1>
                            <button class="bg-orange-400 p-2 rounded-lg p_font cursor-pointer hover:bg-orange-500 mb-3 text-white">Manage Job Posts</button>
                            
                        </div>

                        {{-- Support management parent div --}}
                        <div class="p-2 flex flex-col">
                            {{-- buttons --}}
                            <h1 class="p_font mb-2">Support Management</h1>
                            <button class="bg-[#1e2939] p-2 rounded-lg p_font cursor-pointer hover:bg-[#3b4759] mb-3 text-white">View All Chats </button>
                            <button class="bg-[#1e2939] p-2 rounded-lg p_font cursor-pointer hover:bg-[#3b4759] mb-3 text-white">View All Reports </button>
                            
                        </div>

                    </div>

                   
                    
            </div>
            {{-- end of card section 2 --}}


        </div>
        
    
    </section>


    

    
    <script src="{{ asset('js/admin/nav_admin.js') }}"></script>
@endsection
 