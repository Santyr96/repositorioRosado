@vite('resources/js/components/dashboards/profile/load-view.js')
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

        <main class="content flex items-center pt-10 flex-col gap-5 overflow-hidden">
            <div id="content" class="w-full">
                <div class="flex flex-col items-center justify-center">
                    <div class="flex flex-col items-center justify-center">
                        <h1 class="text-3xl font-bold font-work text-center">
                            Bienvenido a la sala de operaciones de Hairbooker <br>
                            <span class="text-purple-500">{{ $username }}</span>
                        </h1>

                        <h2 class="font-work w-[85%] self-center pt-10 text-center">
                            Desde aquí, puedes gestionar de forma eficiente todas las operaciones relacionadas con tu
                            negocio. Accede a herramientas como la gestión de citas, servicios y clientes, todo en un
                            entorno diseñado para ofrecerte control total y una experiencia optimizada.
                        </h2>

                        <div class="mt-16 w-[85%] bg-purple-50 p-6 rounded-lg shadow-md">
                            <h3 class="text-xl font-bold text-purple-600 mb-4">¡Recuerda!</h3>
                            <p class="font-work text-gray-700">
                                No olvides dar de alta tu peluquería para que puedas comenzar a gestionar citas y
                                servicios. Además, asegúrate de crear los servicios que ofreces para que tus clientes
                                puedan seleccionarlos al reservar.
                            </p>
                        </div>

                        <footer class="mt-24 text-center text-gray-500 text-sm">
                            <p>Hairbooker - Diseñado para potenciar tu negocio</p>
                        </footer>
                </div>

            </div>
            @yield('content')
    </div>
    </main>


    <footer>

    </footer>
    </div>
</body>


</html>
