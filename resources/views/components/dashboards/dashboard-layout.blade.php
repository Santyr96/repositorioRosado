
@vite('resources/js/components/dashboards/calendar.js')
@vite('resources/js/components/profile/load-view-profile.js')
@vite('resources/css/app.css')

<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Noto+Sans+JP:wght@100..900&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Work+Sans:ital,wght@0,100..900;1,100..900&display=swap"
        rel="stylesheet">
    <script src="https://kit.fontawesome.com/09f844330b.js" crossorigin="anonymous"></script>
    <script src='https://cdn.jsdelivr.net/npm/fullcalendar@6.1.15/index.global.min.js'></script>
    <meta name="csrf-token" content="{{ csrf_token() }}">

   
    <title>{{ $title ?? 'Gestión de citas' }}</title>

</head>

<body class="grid min-h-[100dvh] xl:grid-cols-[1fr_3fr]">
 
    <aside class="hidden xl:flex bg-gray-200 xl:col-start-1">
        <x-dashboards.admin-panel class="xl:static h-full xl:w-full">
            
        </x-dashboards.admin-panel>
    </aside>

   
    <div class="grid grid-rows-[auto_1fr_auto] xl:col-start-2">
        
        <x-dashboards.header>
           
        </x-dashboards.header>

        
        <main class="content flex items-center pt-10 flex-col gap-5">
            <div id="content" class="w-full">
                @yield('content')
            </div>
        </main>

      
        <footer>
            
        </footer>
    </div>
</body>


</html>
