
@vite('resources/js/components/dashboards/calendar.js')
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    @vite('resources/css/app.css')
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Noto+Sans+JP:wght@100..900&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Work+Sans:ital,wght@0,100..900;1,100..900&display=swap"
        rel="stylesheet">
    <script src="https://kit.fontawesome.com/09f844330b.js" crossorigin="anonymous"></script>
    <script src='https://cdn.jsdelivr.net/npm/fullcalendar@6.1.15/index.global.min.js'></script>
   
    <title>{{ $title }}</title>
</head>

<body class="grid min-h-[100dvh] xl:grid-cols-[1fr_3fr]">
 
    <aside class="hidden xl:flex bg-gray-200 xl:col-start-1">
        <x-dashboards.admin-panel class="xl:static h-full xl:w-full">
            
        </x-dashboards.admin-panel>
    </aside>

   
    <div class="grid grid-rows-[auto_1fr_auto] xl:col-start-2">
        
        <x-dashboards.header>
           
        </x-dashboards.header>

        
        <main class="flex items-center pt-10 flex-col gap-5">
            <div id="title" class="font-noto text-xl md:text-3xl font-bold">
                <h1>
                    Planifica tus citas
                </h1>
            </div>
            <div id="calendar" class="w-[90%] h-[31rem] pb-4 mb-4 px-1 xl:px-4 md:h-[62rem] xl:h-[40rem] 2xl:h-[50rem] 2xl:w-3/4 
            lg:h-[800px] overflow-scroll text-xs/relaxed md:text-lg font-noto border-2 border-black
             bg-purple-500 text-white">
            </div>
        </main>

      
        <footer>
            
        </footer>
    </div>
</body>


</html>
