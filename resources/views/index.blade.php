@extends('layouts.app')



@section('content')

  <header class="text-gray-400 body-font">
    <div class="container mx-auto flex flex-wrap p-5 items-center max-sm:p-3">
        <a href="#" class="flex title-font font-medium items-center text-white ">
          <img src="{{asset('assets/logoNoBg.png')}}" alt="logo" class="w-70 max-lg:w-50 max-sm:w-40">
        </a>
        
        <div class="ml-auto flex flex-wrap gap-5 items-center text-base justify-center max-lg:gap-3 ">
          <a href="{{ route('login') }}" class="cursor-pointer button_font inline-flex items-center bg-transparent border-2 py-2 px-5 focus:outline-none hover:bg-gray-700 rounded-lg text-white md:mt-0 max-lg:px-3 max-lg:text-sm max-sm:px-2 max-sm:text-xs">Login
          </a>
          <a href="{{ route('register') }}" class="cursor-pointer button_font inline-flex items-center py-2 px-5 bg-blue-500 hover:bg-blue-400 focus-visible:outline-blue-500 border-2 focus:outline-none rounded-lg text-white md:mt-0 border-transparent max-lg:px-3 max-lg:text-sm max-sm:px-2 max-sm:text-xs">Sign Up
          </a>
        </div>

    </div>
  </header>

    {{-- hero section --}}
    <section class="relative w-full bg-cover bg-center min-h-[800px] flex" style="background-image: url('{{ asset('assets/bg1.png') }}');">
      <div class="container mx-auto flex px-5 py-15 lg:flex-row flex-col items-center mb-10">
          <div class="lg:flex-grow lg:w-1/2  md:pr-16 flex flex-col lg:items-start md:text-left mb-16 md:mb-0 items-center text-center">
            <h1 class="hero_title max-lg:text-4xl! sm:text-5xl text-3xl mb-4 font-medium text-white leading-18 max-[1280px]:leading-none max-lg:text-center">
            <span class="relative">
                <span class="relative z-10">Jasaan’s First Local</span>
                <span class="absolute inset-0 w-[200px] bg-blue-400 h-3 bottom-1 mt-11 z-0 max-lg:mt-8 max-lg:h-2"></span>
            </span>
            <br class="hidden lg:inline-block">
            Freelance Marketplace
            </h1>

            <p class="mb-8 leading-10 p_font text-gray-300 lg:text-xl max-lg:leading-8">Discover and hire skilled local talent—from makeup artistry to photography—through a secure and accessible platform made for Jasaan’s growing community.</p>

            <div class="flex justify-center gap-5 max-lg:flex max-lg:gap-2 max-lg:mb-10">
              <a href="{{ url('/public_job_postings') }}" class="cursor-pointer button_font inline-flex items-center bg-transparent border-2 py-3 px-5 focus:outline-none hover:bg-gray-700 rounded-xl text-white mt-4 md:mt-0 max-sm:text-sm max-sm:px-2 max-sm:py-2 shadow-lg">See Job Offers
              </a>
              <a href="{{ route('register') }}" class="cursor-pointer button_font inline-flex items-center py-3 px-5 bg-blue-500 hover:bg-blue-400 focus-visible:outline-blue-500 border-2 focus:outline-none rounded-xl text-white mt-4 md:mt-0 border-transparent max-sm:text-sm max-sm:px-2 max-sm:py-2 shadow-lg">Hire Talent
              </a>
            </div>
          </div>
          <div class="w-full lg:w-1/2 max-lg:w-lg max-sm:w-full">
            <img class="object-cover object-center rounded" alt="hero" src="{{asset('assets/hero_image.png')}}">
          </div>
      </div>
    </section>


    

     {{-- How it works --}}
    <section class="relative w-full bg-contain bg-no-repeat bg-center max-lg:bg-[length:120%_auto]" style="background-image: url('{{ asset('assets/bg2.png') }}');">
    <div class="container mx-auto flex px-5 py-15 flex-col items-center mb-40 justify-center mt-20">
        
        <h1 class="hero_title max-lg:text-4xl! sm:text-5xl text-3xl mb-4 font-medium text-white leading-18 max-[1280px]:leading-none text-center">
        <span class="relative">
            <span class="relative z-10">How It Works</span>
            <span class="absolute inset-0 w-[200px] bg-blue-400 h-3 bottom-1 mt-11 z-0 max-lg:mt-8 max-lg:h-2 max-lg:w-[100px]"></span>
        </span>
        
        </h1>
        
        <p class="xl:w-7xl text-center mb-8 leading-10 p_font text-gray-300 lg:text-xl max-lg:leading-8"> Connecting with <span class="font-bold text-blue-400">clients</span> and <span class="font-bold text-blue-400">freelancers</span> takes only a few steps:  
           

        <div class="grid md:grid-cols-3 gap-8 max-sm:flex max-sm:flex-col max-sm:items-center justify-center">
            <!-- Step 1 -->
            <div class="p-6 bg-[#ffffffc9] border-4 border-blue-400 rounded-2xl shadow-md hover:shadow-lg hover:shadow-blue-400 transition py-20 max-sm:py-10 max-sm:w-[90%]">
                <div class="w-14 h-14 mx-auto mb-4 flex items-center justify-center bg-blue-100 text-blue-600 rounded-full text-2xl font-bold">
                1
                </div>
                <h3 class="text-xl font-semibold text-gray-800 mb-2 text-center sub_title">Sign Up</h3>
                <p class="text-gray-600 text-sm text-center p_font">
                Create an account as a client or an employee to start connecting.
                </p>
            </div>

            <!-- Step 2 -->
            <div class="p-6 bg-[#ffffffc9] border-4 border-blue-400 rounded-2xl shadow-md hover:shadow-lg hover:shadow-blue-400 transition py-20 max-sm:py-10 max-sm:w-[90%]">
                <div class="w-14 h-14 mx-auto mb-4 flex items-center justify-center bg-blue-100 text-blue-600 rounded-full text-2xl font-bold">
                2
                </div>
                <h3 class="text-xl font-semibold text-gray-800 mb-2 text-center sub_title">Post or Apply</h3>
                <p class="text-gray-600 text-sm text-center p_font">
                Clients can post job listings, while employees can apply to them.
                </p>
            </div>

            <!-- Step 3 -->
            <div class="p-6 bg-[#ffffffc9] border-4 border-blue-400 rounded-2xl shadow-md hover:shadow-lg hover:shadow-blue-400 transition py-20 max-sm:py-10 max-sm:w-[90%]">
                <div class="w-14 h-14 mx-auto mb-4 flex items-center justify-center bg-blue-100 text-blue-600 rounded-full text-2xl font-bold">
                3
                </div>
                <h3 class="text-xl font-semibold text-gray-800 mb-2 text-center sub_title">Collaborate</h3>
                <p class="text-gray-600 text-sm text-center p_font">
                Work together and complete projects.
                </p>
            </div>


        </div>
      
    </div>
    </section>


    {{-- FAQ--}}
    <section class="relative w-full bg-cover bg-center min-h-[800px] flex items-center justify-center pt-20 max-sm:px-5" style="background-image: url('{{ asset('assets/bg3.png') }}');">
    <div class="container mx-auto flex px-5 py-20 flex-col items-center mb-20 border-2 border-gray-700 bg-[#10182887] rounded-3xl">
        
        <h1 class="hero_title max-lg:text-4xl! sm:text-5xl text-3xl mb-4 font-medium text-white leading-18 max-[1280px]:leading-none text-center">
        <span class="relative">
            <span class="relative z-10 ">Frequently Asked Questions</span>
            <span class="absolute inset-0 w-[200px] bg-blue-400 h-3 bottom-1 mt-11 z-0 max-lg:mt-8 max-lg:h-2 max-lg:w-[100px]"></span>
        </span>
        </h1>

        <div class="grid grid-cols-2 max-lg:grid-cols-1 gap-10 max-lg:flex max-lg:flex-col max-lg:items-center justify-center w-full p-10 rounded-3xl ">
            
            <div class="max-lg:w-full">
                <div class="flow-root ">
                    <div id="faq-container" class="-my-4 flex flex-col divide-y divide-gray-200 ">
                        {{-- faq 1--}}
                        <details class="group py-4 [&_summary::-webkit-details-marker]:hidden">
                        <summary class="flex items-center gap-2 cursor-pointer text-white">
                            
                            <!-- Icon (plus/minus) -->
                            <svg
                            class="size-5 shrink-0 text-blue-200 transition-transform duration-300 group-open:rotate-90"
                            xmlns="http://www.w3.org/2000/svg"
                            fill="none"
                            viewBox="0 0 24 24"
                            stroke="currentColor"
                            >
                            <!-- Plus sign -->
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 5v14m-7-7h14"/>
                            </svg>

                            <h2 class="text-2xl max-lg:text-xl font-medium sub_title">What is this platform all about?</h2>
                        </summary>

                        <p class="text-xl max-lg:text-lg p_font mt-2 text-white">
                            It’s Jasaan’s <span class="font-bold text-blue-200">first local freelance marketplace</span>, built to connect clients with talented freelancers in service-based industries like makeup artistry, nail technology, hair styling, and photography.
                        </p>
                        </details>

                         {{-- faq 2--}}
                        <details class="group py-4 [&_summary::-webkit-details-marker]:hidden">
                        <summary class="flex items-center gap-2 cursor-pointer text-white">
                            
                            <!-- Icon (plus/minus) -->
                            <svg
                            class="size-5 shrink-0 text-blue-200 transition-transform duration-300 group-open:rotate-90"
                            xmlns="http://www.w3.org/2000/svg"
                            fill="none"
                            viewBox="0 0 24 24"
                            stroke="currentColor"
                            >
                            <!-- Plus sign -->
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 5v14m-7-7h14"/>
                            </svg>

                            <h2 class="text-2xl max-lg:text-xl font-medium sub_title"> Why should I choose this marketplace over others?</h2>
                        </summary>

                        <p class="text-xl max-lg:text-lg p_font mt-2 text-white">
                            <ul class="list-disc pl-5">
                                <li class="text-xl max-lg:text-lg p_font mt-2 text-white">It’s <span class="font-bold text-blue-200">locally focused</span> on Jasaan and nearby communities.</li>
                                <li class="text-xl max-lg:text-lg p_font mt-2 text-white">Everything you need—<span class="font-bold text-blue-200">profiles, search, communication, and payments</span>—is in one place.</li>
                                <li class="text-xl max-lg:text-lg p_font mt-2 text-white">The system is designed with <span class="font-bold text-blue-200">safety and transparency</span> in mind, with admin monitoring to protect all users.</li>
                                <li class="text-xl max-lg:text-lg p_font mt-2 text-white">It’s <span class="font-bold text-blue-200">accessible on any device</span>—desktop or mobile browser.</li>
                            </ul>
                        </p>
                        </details>

                         {{-- faq 3--}}
                        <details class="group py-4 [&_summary::-webkit-details-marker]:hidden">
                        <summary class="flex items-center gap-2 cursor-pointer text-white">
                            
                            <!-- Icon (plus/minus) -->
                            <svg
                            class="size-5 shrink-0 text-blue-200 transition-transform duration-300 group-open:rotate-90"
                            xmlns="http://www.w3.org/2000/svg"
                            fill="none"
                            viewBox="0 0 24 24"
                            stroke="currentColor"
                            >
                            <!-- Plus sign -->
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 5v14m-7-7h14"/>
                            </svg>

                            <h2 class="text-2xl max-lg:text-xl font-medium sub_title"> What services are supported?
                            </h2>
                        </summary>

                        <p class="text-xl max-lg:text-lg p_font mt-2 text-white">
                            Currently, the platform caters to <span class="font-bold text-blue-200">local service-based</span> industries, including:
                            <ul class="list-disc pl-5">
                                <li class="text-xl max-lg:text-lg p_font mt-2 text-white">Makeup artistry</li>
                                <li class="text-xl max-lg:text-lg p_font mt-2 text-white">Nail technology</li>
                                <li class="text-xl max-lg:text-lg p_font mt-2 text-white">Hair styling</li>
                                <li class="text-xl max-lg:text-lg p_font mt-2 text-white">Photography</li>
                                <li class="text-xl max-lg:text-lg p_font mt-2 text-white">And more freelance skills offered by the Jasaan community.</li>
                            </ul>
                        </p>
                        </details>

                        {{-- faq 4--}}
                        <details class="group py-4 [&_summary::-webkit-details-marker]:hidden">
                        <summary class="flex items-center gap-2 cursor-pointer text-white">
                            
                            <!-- Icon (plus/minus) -->
                            <svg
                            class="size-5 shrink-0 text-blue-200 transition-transform duration-300 group-open:rotate-90"
                            xmlns="http://www.w3.org/2000/svg"
                            fill="none"
                            viewBox="0 0 24 24"
                            stroke="currentColor"
                            >
                            <!-- Plus sign -->
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 5v14m-7-7h14"/>
                            </svg>

                            <h2 class="text-2xl max-lg:text-xl font-medium sub_title"> How are payments handled?
                            </h2>
                        </summary>

                        <p class="text-xl max-lg:text-lg p_font mt-2 text-white">
                            Payments and payouts are processed <span class="font-bold text-blue-200">directly within the platform</span>, ensuring smooth transactions and timely releases for freelancers.
                        </p>
                        </details>

                        {{-- faq 5--}}
                        <details class="group py-4 [&_summary::-webkit-details-marker]:hidden">
                        <summary class="flex items-center gap-2 cursor-pointer text-white">
                            
                            <!-- Icon (plus/minus) -->
                            <svg
                            class="size-5 shrink-0 text-blue-200 transition-transform duration-300 group-open:rotate-90"
                            xmlns="http://www.w3.org/2000/svg"
                            fill="none"
                            viewBox="0 0 24 24"
                            stroke="currentColor"
                            >
                            <!-- Plus sign -->
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 5v14m-7-7h14"/>
                            </svg>

                            <h2 class="text-2xl max-lg:text-xl font-medium sub_title"> Who oversees the platform?
                            </h2>
                        </summary>

                        <p class="text-xl max-lg:text-lg p_font mt-2 text-white">
                            An <span class="font-bold text-blue-200">administrative team</span> actively monitors activity to ensure fairness, trust, and accountability between freelancers and clients.
                        </p>
                        </details>

                        



                    </div>
                    </div>
            </div>
            
            <img class="w-sm xl:ml-50 max-xl:w-xs max-xl:ml-20 max-lg:ml-0 max-lg:w-70" alt="hero" src="{{asset('assets/FAQimage.png')}}">
            
        </div>
      
    </div>
    </section>

    {{-- About Us --}}
    <section class="relative w-full bg-cover bg-center min-h-[800px] flex items-center justify-center" style="background-image: url('{{ asset('assets/bg4.png') }}');">
    <div class="container mx-auto flex px-5 py-15 flex-col items-center mb-50 w-full">
        
        {{-- about us content --}}
        <h1 class="hero_title max-lg:text-4xl! sm:text-5xl text-3xl mb-4 font-medium text-white leading-18 max-[1280px]:leading-none text-center">
        <span class="relative">
            <span class="relative z-10">About Us</span>
            <span class="absolute inset-0 w-[200px] bg-blue-400 h-3 bottom-1 mt-11 z-0 max-lg:mt-8 max-lg:h-2 max-lg:w-[100px]"></span>
        </span>
        
        </h1>
        
        <p class="xl:w-7xl text-center mb-8 leading-10 p_font text-gray-300 lg:text-xl max-lg:leading-8 p-2 rounded-lg bg-[#10182887]"> Our platform is built to connect talented freelancers with clients who need their skills.  
            Whether you're an <span class="font-bold text-blue-400">employee</span> looking for opportunities  
            or a <span class="font-bold text-blue-400">client</span> searching for the right talent,  
            we provide a simple and reliable space to work together.</p>

        <div class="flex flex-wrap justify-center gap-10">
            <img class="object-cover object-center rounded-3xl w-sm" alt="hero" src="{{asset('assets/about_us_image.png')}}">
            <img class="object-cover object-center rounded-3xl w-sm" alt="hero" src="{{asset('assets/about_us_image2.png')}}">
        </div>
      
    </div>
    </section>

  {{-- feedback --}}
  <section class="text-gray-400  body-font relative mb-40">
      <h1 class="hero_title max-lg:text-4xl! sm:text-5xl text-3xl font-medium text-white leading-18 max-[1280px]:leading-none text-center">
          <span class="relative">
              <span class="relative z-10">Send Us Your Feedback</span>
              <span class="absolute inset-0 w-[200px] bg-blue-400 h-3 bottom-1 mt-11 z-0 max-lg:mt-8 max-lg:h-2 max-lg:w-[100px]"></span>
          </span>
      </h1>

    <div class="container px-5 py-10 mx-auto flex sm:flex-nowrap flex-wrap p_font">
      <div class="lg:w-2/3 md:w-1/2 bg-gray-900 rounded-lg overflow-hidden sm:mr-10 p-10 flex items-end justify-start relative">
        <iframe 
      width="100%" 
      height="100%" 
      title="map" 
      class="absolute inset-0" 
      frameborder="0" 
      marginheight="0" 
      marginwidth="0" 
      scrolling="no"
      src="https://www.google.com/maps?q=Jasaan%2C%20Misamis%20Oriental&z=14&output=embed"
      style="filter: grayscale(1) contrast(1.2) opacity(0.16);">
      </iframe>
        <div class="bg-gray-900 relative flex flex-wrap py-6 rounded shadow-md">
          <div class="lg:w-1/2 px-6">
            <h2 class="title-font font-semibold text-white tracking-widest text-xs">ADDRESS</h2>
            <p class="mt-1">Jasaan Misamis Oriental</p>
          </div>
          <div class="lg:w-1/2 px-6 mt-4 lg:mt-0">
            <h2 class="title-font font-semibold text-white tracking-widest text-xs">EMAIL</h2>
            <a class="text-blue-400 leading-relaxed">freelancoph@email.com</a>
            <h2 class="title-font font-semibold text-white tracking-widest text-xs mt-4">PHONE</h2>
            <p class="leading-relaxed">+63912345678</p>
          </div>
        </div>
      </div>
      <div class="lg:w-1/3 md:w-1/2 flex flex-col md:ml-auto w-full md:py-8 mt-8 md:mt-0">
        <h2 class="text-white text-lg mb-1 font-medium title-font">Feedback</h2>
        <p class="leading-relaxed mb-5">Send your freelanco feedback in this form.</p>
        <div class="relative mb-4">
          <label for="name" class="leading-7 text-sm text-gray-400">Name</label>
          <input type="text" id="name" name="name" class="w-full bg-gray-800 rounded border border-gray-700 focus:border-blue-500 focus:ring-2 focus:ring-blue-900 text-base outline-none text-gray-100 py-1 px-3 leading-8 transition-colors duration-200 ease-in-out">
        </div>
        <div class="relative mb-4">
          <label for="email" class="leading-7 text-sm text-gray-400">Email</label>
          <input type="email" id="email" name="email" class="w-full bg-gray-800 rounded border border-gray-700 focus:border-blue-500 focus:ring-2 focus:ring-blue-900 text-base outline-none text-gray-100 py-1 px-3 leading-8 transition-colors duration-200 ease-in-out">
        </div>
        <div class="relative mb-4">
          <label for="message" class="leading-7 text-sm text-gray-400">Message</label>
          <textarea id="message" name="message" class="w-full bg-gray-800 rounded border border-gray-700 focus:border-blue-500 focus:ring-2 focus:ring-blue-900 h-32 text-base outline-none text-gray-100 py-1 px-3 resize-none leading-6 transition-colors duration-200 ease-in-out"></textarea>
        </div>
        <button type="submit" class="sign_in cursor-pointer flex w-full justify-center rounded-md bg-blue-500 px-3 py-2 text-sm font-semibold text-white hover:bg-blue-400 focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-blue-500 mb-4 max-[640px]:text-sm/6">
                                      {{ __('Send Message') }}
                                  </button>
        <p class="text-xs text-gray-400 text-opacity-90 mt-3">all rights reserverd ©Freelanco.ph</p>
      </div>
    </div>
  </section>
    

    {{-- footer --}}
    <footer class="text-gray-400 bg-gray-900 body-font">
    <div class="container px-5 py-8 mx-auto flex items-center sm:flex-row flex-col">
      <a class="flex title-font font-medium items-center md:justify-start justify-center text-white">
        <img src="{{asset('assets/logoNoBg.png')}}" alt="logo" class="w-70 ">
      </a>
      <p class="text-sm text-gray-400 sm:ml-4 sm:pl-4 sm:border-l-2 sm:border-gray-800 sm:py-2 sm:mt-0 mt-4">© 2025 Freelanco PH
      </p>
      <span class="inline-flex sm:ml-auto sm:mt-0 mt-4 justify-center sm:justify-start">
        <a class="text-gray-400">
          <svg fill="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" class="w-5 h-5" viewBox="0 0 24 24">
            <path d="M18 2h-3a5 5 0 00-5 5v3H7v4h3v8h4v-8h3l1-4h-4V7a1 1 0 011-1h3z"></path>
          </svg>
        </a>
        <a class="ml-3 text-gray-400">
          <svg fill="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" class="w-5 h-5" viewBox="0 0 24 24">
            <path d="M23 3a10.9 10.9 0 01-3.14 1.53 4.48 4.48 0 00-7.86 3v1A10.66 10.66 0 013 4s-4 9 5 13a11.64 11.64 0 01-7 2c9 5 20 0 20-11.5a4.5 4.5 0 00-.08-.83A7.72 7.72 0 0023 3z"></path>
          </svg>
        </a>
        <a class="ml-3 text-gray-400">
          <svg fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" class="w-5 h-5" viewBox="0 0 24 24">
            <rect width="20" height="20" x="2" y="2" rx="5" ry="5"></rect>
            <path d="M16 11.37A4 4 0 1112.63 8 4 4 0 0116 11.37zm1.5-4.87h.01"></path>
          </svg>
        </a>
        <a class="ml-3 text-gray-400">
          <svg fill="currentColor" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="0" class="w-5 h-5" viewBox="0 0 24 24">
            <path stroke="none" d="M16 8a6 6 0 016 6v7h-4v-7a2 2 0 00-2-2 2 2 0 00-2 2v7h-4v-7a6 6 0 016-6zM2 9h4v12H2z"></path>
            <circle cx="4" cy="4" r="2" stroke="none"></circle>
          </svg>
        </a>
      </span>
    </div>
</footer>

    



    

 

@endsection

