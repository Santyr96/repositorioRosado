@vite('resources/js/components/dashboards/notification-extend.js')
@vite('resources/js/components/dashboards/admin-panel-extend.js')

<header class="grid grid-cols-2 bg-gradient-to-r from-yellow-400 to-red-600 rounded-b-lg {{ $class }}">
    <x-dashboards.admin-panel class="hidden">

    </x-dashboards.admin-panel>
    <div class="flex justify-start items-center gap-3">
        <div class="lg:hidden pl-2">
            <button id="extendButton" type="button"
                class="-m-2.5 inline-flex items-center justify-center rounded-md p-2.5 text-gray-100">
                <span class="sr-only">Open main menu</span>
                <svg class="h-6 w-6 hover:stroke-purple-600" fill="white" viewBox="0 0 24 24" stroke-width="1.5"
                    stroke="currentColor" aria-hidden="true">
                    <path stroke-linecap="round" stroke-linejoin="round"
                        d="M3.75 6.75h16.5M3.75 12h16.5m-16.5 5.25h16.5" />
                </svg>
            </button>
        </div>

        <div class="h-full flex items-center md:pl-4">
            <img class="w-10/12 md:w-52 pt-1 hover:animate-rotate-y animate-once animate-ease-in animate-fill-bot"
                src="{{ asset('storage/images/logo3.png') }}" alt="logo">

        </div>
    </div>

    {{-- APARTADO DE NOTIFICACIONES --}}
    <div id="admin" class="flex flex-wrap gap-2 justify-end lg:justify-end items-center pr-4">
        <div>
            <a id="notificationButton" role="button"><svg xmlns="http://www.w3.org/2000/svg" width="2rem"
                    height="2rem" viewBox="0 0 24 24">
                    <path class="hover:fill-purple-600" fill="white"
                        d="M4 19v-2h2v-7q0-2.075 1.25-3.687T10.5 4.2v-.7q0-.625.438-1.062T12 2t1.063.438T13.5 3.5v.7q2 .5 3.25 2.113T18 10v7h2v2zm8 3q-.825 0-1.412-.587T10 20h4q0 .825-.587 1.413T12 22" />
                </svg></a>
        </div>

        <div id="dropdown" class=" hidden absolute top-16 right-5 mt-1 w-48  border-2 stroke-gray-300 bg-white">
            <div class="text-center font-noto text-sm ">
                <h1>Notificaciones</h1>
            </div>

            <div>
                <ul class="flex h-auto flex-col overflow-y-auto">
                    <li>
                        <a class="flex flex-col gap-2.5 border-t border-stroke px-4.5 py-3 hover:bg-gray-100"
                            href="#">
                            <p>Hola</p>
                        </a>
                    </li>
                </ul>
            </div>

        </div>

        {{-- HAY QUE MODIFICAR QUE EL AVATAR SEA EL QUE RECIBE POR PARTE DEL USUARIO SI NO SE PONDRA UNA IMAGEN POR DEFECTO --}}

        <div class="p-2 flex items-center">
            <div class="hidden">
                Spiderman
                @auth
                    {{ Auth::user()->name }}
                    {{ $user = Auth::user() }}
                @endauth
            </div>


            <x-image-rounded id="headerAvatar"
                src="{{ $user->avatar ? asset($user->avatar) : asset('storage/images/default_user_avatar.webp') }}"
                alt="Imagen de perfil" class="h-14 w-14">
            </x-image-rounded>

        </div>
    </div>


</header>
