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

    <div id="admin" class="flex flex-wrap gap-2 justify-end lg:justify-end items-center pr-4">
        @if ($notifications->isNotEmpty())
        <div id="notificationCounter"
        class="transform translate-x-12 -translate-y-4 bottom-auto left-auto right-0 top-0 z-10 inline-block rotate-0 skew-x-0 skew-y-0 scale-x-100 scale-y-100 whitespace-nowrap rounded-full bg-indigo-700 px-2 py-1 text-center align-baseline text-xs font-bold leading-none text-white">
        {{$notifications->count()}}
      </div>
        @endif
        <div>
            <a id="notificationButton" data-notification="{{route('users.markAllAsRead')}}"  role="button"><svg xmlns="http://www.w3.org/2000/svg" width="2rem"
                    height="2rem" viewBox="0 0 24 24">
                    <path class="hover:fill-purple-600" fill="white"
                        d="M4 19v-2h2v-7q0-2.075 1.25-3.687T10.5 4.2v-.7q0-.625.438-1.062T12 2t1.063.438T13.5 3.5v.7q2 .5 3.25 2.113T18 10v7h2v2zm8 3q-.825 0-1.412-.587T10 20h4q0 .825-.587 1.413T12 22" />
                </svg></a>
        </div>

        <div id="dropdown" class=" h-[200px] hidden absolute top-16 right-5 mt-1 w-48  border-2 stroke-gray-300 bg-white overflow-y-auto">
            <div class="text-center font-noto text-sm ">
                <h1 class="pt-1"><strong>Notificaciones</strong></h1>
            </div>

            <div class="p-6">
                <ul class="flex h-auto flex-col gap-1">
                    @if ($notifications->isNotEmpty())
                        @foreach ($notifications as $notification)
                            <li class="text-sm border-b-2 border-gray-300 py-3">
                                @auth
                                    @if (Auth::user()->role == 'cliente')
                                    {{ $notification->data['message'] }} por el propietario de la peluqueria {{ $notification->data['hairdresser_name'] }}
                                    @else
                                    {{ $notification->data['message'] }} por el cliente {{ $notification->data['client_name'] }} en la 
                                    peluqueria {{ $notification->data['hairdresser_name'] }}
                                    @endif
                                @endauth
                                </li>
                            @endforeach
                        @else
                            <li>No hay notificaciones</li>
                        @endif
                    </ul>
                </div>

            </div>


            <div class="p-2 flex items-center">
                <div class="hidden">
                    Spiderman
                    @auth
                        {{ Auth::user()->name }}
                        {{ $user = Auth::user() }}
                    @endauth
                </div>


                <x-images.image-rounded id="headerAvatar"
                    src="{{ $user->avatar ? asset($user->avatar) : asset('storage/images/default_user_avatar.webp') }}"
                    alt="Imagen de perfil" class="h-14 w-14">
                </x-images.image-rounded>

            </div>
        </div>


    </header>
