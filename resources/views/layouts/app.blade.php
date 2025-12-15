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
        


        <main class="">
            @yield('content')


            
             
        </main>

        
    </div>



    

    <script>
    document.addEventListener('DOMContentLoaded', () => {

        let lastActivity = Date.now();
        let offlineTimeout = null;

        const csrfMeta = document.querySelector('meta[name="csrf-token"]');
        if (!csrfMeta) return;
        const token = csrfMeta.content;

        const activityEvents = ['mousemove', 'keydown', 'click', 'scroll', 'touchstart'];

        activityEvents.forEach(event => {
            document.addEventListener(event, () => {
                lastActivity = Date.now();

                if (offlineTimeout) clearTimeout(offlineTimeout);

                // Set to offline after 15 seconds
                offlineTimeout = setTimeout(async () => {
                    await fetch('/set-offline', {
                        method: 'POST',
                        credentials: 'same-origin',
                        headers: {
                            'X-CSRF-TOKEN': token,
                            'Content-Type': 'application/json'
                        }
                    });
                }, 15000); // 15 seconds
            });
        });

        // Ping backend every 5 seconds if active
        setInterval(async () => {
            const secondsInactive = (Date.now() - lastActivity) / 1000;

            if (secondsInactive <= 15) {
                await fetch('/keep-online', {
                    method: 'POST',
                    credentials: 'same-origin',
                    headers: {
                        'X-CSRF-TOKEN': token,
                        'Content-Type': 'application/json'
                    }
                });
            }
        }, 5000);

    });
    </script>





        

    
    <script src="https://cdn.jsdelivr.net/npm/axios/dist/axios.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/flowbite@4.0.1/dist/flowbite.min.js"></script>

    @vite(['resources/js/video-call.js'])

    



    @include('components.incoming-call')

    
</body>
</html>
