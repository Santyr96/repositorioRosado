<!DOCTYPE html>
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
    @vite('resources/js/components/flyout_menu.js')
    <title>{{$title}}</title>
</head>

<body>

    <header class="flex justify-center fixed bg-gradient-to-r from-yellow-400 to-red-600 rounded-b-lg shadow-md h-20 w-full z-40 ">
        <nav class=" h-full flex w-full items-center justify-between p-6 lg:px-8" aria-label="Global">
            <div class="flex lg:flex">
                <figure class="container mx-auto">
                    <a href="{{ route('index') }}"><img
                            class="w-2/4 pt-1 hover:animate-rotate-y animate-once animate-ease-in animate-fill-bot"
                            src="{{ asset('storage/images/logo3.png') }}" alt="logo">
                    </a>
                </figure>
            </div>

            <div
                class="container w-[40%] mx-none hidden lg:grid lg:w-2/4 grid-cols-4 justify-items-center items-center text-center ">
                <a href="{{ route('index') }}"
                    class="-mx-3 block rounded-lg px-3 py-2 text-base font-noto font-bold leading-7
                     text-white text-shadow-bottom hover:text-purple-600">
                    Inicio
                </a>

                <a href="{{ route('aboutSantiago') }}"
                    class="-mx-3 block rounded-lg px-3 py-2 text-base font-noto font-bold leading-7
                     text-white text-shadow-bottom hover:text-purple-600">
                    Sobre mí
                </a>


                <a href="{{ url('/') . '#solutions' }}"
                    class="-mx-3 block rounded-lg px-3 py-2 text-base font-noto font-bold leading-7
                     text-white text-shadow-bottom hover:text-purple-600">
                    Aplicación
                </a>

                <div class="w-full -m-0 flex items-center justify-center ">
                    <div class="flex items-center flex-col">
                        <a id="registro" href="#"
                            class="-mx-3 block rounded-lg px-3 py-2 text-base font-noto font-bold leading-7
                         text-white text-shadow-bottom hover:text-purple-600">
                            Iniciar Sesión
                        </a>

                        <div class="z-10 hidden flex-col absolute justify-center
                         mt-14 w-56 rounded-md shadow-lg bg-white ring-1 ring-black ring-opacity-5 animate-fade-down animate-once"
                            role="menu" aria-orientation="vertical" aria-labelledby="menu-button" tabindex="-1">
                            <div class="py-1" role="none">
                                <a href="{{ route('users.login') }}"
                                    class="text-gray-700 block px-4 py-2 font-noto font-bold text-sm hover:bg-gray-100"
                                    role="menuitem">Iniciar Sesión</a>
                            </div>

                            <div class="py-1" role="none">
                                <a href="{{route('users.create')}}"
                                    class="text-gray-700 block px-4 py-2 font-noto font-bold text-sm hover:bg-gray-100"
                                    role="menuitem">Registrarse</a>
                            </div>
                        </div>
                    </div>


                    <svg id="arrow" class="h-10 w-auto fill-white" xmlns="http://www.w3.org/2000/svg"
                        viewBox="0 0 100 100" width="100" height="100">
                        <polygon points="50,70 30,40 70,40" />
                    </svg>


                </div>


            </div>

            <div id="botonDespegable" class="lg:hidden flex">
                <button type="button"
                    class="-m-2.5 inline-flex items-center justify-center rounded-md p-2.5 text-gray-100">
                    <span class="sr-only">Open main menu</span>
                    <svg class="h-6 w-6" fill="white" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor"
                        aria-hidden="true">
                        <path stroke-linecap="round" stroke-linejoin="round"
                            d="M3.75 6.75h16.5M3.75 12h16.5m-16.5 5.25h16.5" />
                    </svg>
                </button>
            </div>
        </nav>


        <div class="hidden lg:hidden" role="dialog" aria-modal="true">

            <div class="fixed inset-0 z-10"></div>
            <div
                class="fixed inset-y-0 right-0 z-10 w-full overflow-y-auto bg-white px-6 py-6 sm:max-w-sm sm:ring-1 sm:ring-gray-900/10">
                <div class="flex items-center justify-between">
                    <button type="button" class="-m-2.5 rounded-md p-2.5 text-gray-700" data-close-button>
                        <span class="sr-only">Close menu</span>
                        <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor"
                            aria-hidden="true">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" />
                        </svg>
                    </button>
                </div>
                <div class="mt-6 flow-root">
                    <div class="-my-6 divide-y divide-gray-500/10">
                        <div class="space-y-2 py-6">
                            <a href="{{ route('index') }}"
                                class="-mx-3 block rounded-lg px-3 py-2 text-base font-noto font-semibold leading-7 text-gray-900 hover:bg-gray-50">Inicio</a>
                            <a href="{{ route('aboutSantiago') }}"
                                class="-mx-3 block rounded-lg px-3 py-2 text-base font-noto font-semibold leading-7 text-gray-900 hover:bg-gray-50">Sobre
                                mí</a>
                            <a href="#solutions"
                                class="-mx-3 block rounded-lg px-3 py-2 text-base font-noto font-semibold leading-7 text-gray-900 hover:bg-gray-50">Aplicación</a>
                        </div>
                        <div class="py-6">
                            <a href="{{ route('users.login') }}"
                                class="-mx-3 block rounded-lg px-3 py-2.5 text-base font-noto font-semibold leading-7 text-gray-900 hover:bg-gray-50">Iniciar
                                Sesión
                            </a>
                            <a href="{{route('users.create')}}"
                                class="-mx-3 block rounded-lg px-3 py-2.5 text-base font-noto font-semibold leading-7 text-gray-900 hover:bg-gray-50">Registrarse</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>

    </header>

    {{ $slot }}

    <x-footer>
    </x-footer>

</body>

</html>
