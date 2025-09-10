<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
     @vite('resources/css/app.css')

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">
    
    <title>{{ config('app.name', 'Freelanco') }}</title>

    <!-- Fonts -->
    <link rel="dns-prefetch" href="//fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=Nunito" rel="stylesheet">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&display=swap" rel="stylesheet">
    
    

    <!-- Scripts -->
    @vite(['resources/sass/app.scss', 'resources/js/app.js'])
</head>
<body class="@yield('body-class', 'bg-gray-800') ">
    
    <div id="app" class="">
        
{{-- <nav class="bg-white border-b">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex justify-between h-16">
            
            <!-- Left Side (Logo / Nav links) -->
            <div class="flex items-center">
                <a href="{{ url('/') }}" class="text-xl font-bold text-gray-800">
                 <img src="{{asset('assets/logoNoBg.png')}}" alt="logo" class="w-50">
                </a>
            </div>

            <!-- Right Side -->
            <div class="hidden md:flex items-center space-x-4">
                @guest
                    @if (Route::has('login'))
                        <a href="{{ route('login') }}"
                           class="px-4 py-2 rounded-lg bg-blue-600 text-white hover:bg-blue-700 transition">
                            {{ __('Login') }}
                        </a>
                    @endif

                    @if (Route::has('register'))
                        <a href="{{ route('register') }}"
                           class="px-4 py-2 rounded-lg bg-green-600 text-white hover:bg-green-700 transition">
                            {{ __('Register') }}
                        </a>
                    @endif
                @else
                    <div class="relative">
                        <button type="button"
                                class="px-4 py-2 bg-gray-100 rounded-lg hover:bg-gray-200 transition"
                                onclick="document.getElementById('userMenu').classList.toggle('hidden')">
                            {{ Auth::user()->name }}
                        </button>

                        <div id="userMenu"
                             class="absolute right-0 mt-2 w-40 bg-white border rounded-lg shadow-lg hidden">
                            <form id="logout-form" action="{{ route('logout') }}" method="POST">
                                @csrf
                                <button type="submit"
                                        class="block w-full text-left px-4 py-2 text-gray-700 hover:bg-gray-100">
                                    {{ __('Logout') }}
                                </button>
                            </form>
                        </div>
                    </div>
                @endguest
            </div>

            <!-- Mobile Hamburger -->
            <div class="flex items-center md:hidden">
                <button onclick="document.getElementById('mobileMenu').classList.toggle('hidden')"
                        class="text-gray-600 focus:outline-none">
                    ☰
                </button>
            </div>
        </div>
    </div>

    <!-- Mobile Menu -->
    <div id="mobileMenu" class="md:hidden hidden px-4 pb-3 space-y-2">
        @guest
            @if (Route::has('login'))
                <a href="{{ route('login') }}"
                   class="block px-4 py-2 rounded-lg bg-blue-600 text-white hover:bg-blue-700 transition">
                   {{ __('Login') }}
                </a>
            @endif
            @if (Route::has('register'))
                <a href="{{ route('register') }}"
                   class="block px-4 py-2 rounded-lg bg-green-600 text-white hover:bg-green-700 transition">
                   {{ __('Register') }}
                </a>
            @endif
        @else
            <form id="logout-form" action="{{ route('logout') }}" method="POST">
                @csrf
                <button type="submit"
                        class="block w-full text-left px-4 py-2 text-gray-700 hover:bg-gray-100">
                    {{ __('Logout') }}
                </button>
            </form>
        @endguest
    </div>
</nav> --}}


        <main class="">
            @yield('content')
        </main>
    </div>
    
    

  
   
</body>
</html>
