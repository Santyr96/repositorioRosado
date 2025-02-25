<div id="adminPanel"
    class="absolute z-50 top-[4.5rem] h-auto w-56 md:w-80 grid grid-rows-[auto_1fr_auto] bg-blue-950 text-white font-noto font-bold {{ $class }}">
    <header class="flex px-4 gap-10 md:items-baseline">
        <h1 class="text-center mt-4 xl:text-4xl">Panel de administración</h1>
        <button class="block lg:hidden">
            <svg class="fill-current" width="20" height="18" viewBox="0 0 20 18" fill="none"
                xmlns="http://www.w3.org/2000/svg">
                <path
                    d="M19 8.175H2.98748L9.36248 1.6875C9.69998 1.35 9.69998 0.825 9.36248 0.4875C9.02498 0.15 8.49998 0.15 8.16248 0.4875L0.399976 8.3625C0.0624756 8.7 0.0624756 9.225 0.399976 9.5625L8.16248 17.4375C8.31248 17.5875 8.53748 17.7 8.76248 17.7C8.98748 17.7 9.17498 17.625 9.36248 17.475C9.69998 17.1375 9.69998 16.6125 9.36248 16.275L3.02498 9.8625H19C19.45 9.8625 19.825 9.4875 19.825 9.0375C19.825 8.55 19.45 8.175 19 8.175Z"
                    fill=""></path>
            </svg>
        </button>
    </header>

    <div class="no-scrollbar flex flex-col overflow-y-auto duration-300 ease-linear ">
        <nav class="mt-5 px-4 py-4 lg:mt-9 lg:px-6 text-2xl">
            <div>
                <h3 class="font-work font-medium text-center text-gray-800 bg-white mb-7 xl:text-2xl">Menu</h3>
                <ul class="font-work text-sm flex flex-col gap-4 xl:text-xl ">
                    <li>
                        <a id="profile" class="hover:text-gray-500" href="#"
                            data-url="{{ route('profile') }}">Perfil</a>
                    </li>

                    @auth
                        @if (Auth::user()->role == 'cliente')
                            <li>
                                <a id="appointments" class="hover:text-gray-500" href=""
                                    data-url="{{ route('dashboard.selectSignup') }}">Mis citas</a>
                            </li>

                            <li>
                                <a id="signup" class="hover:text-gray-500" href=""
                                    data-url="{{ route('dashboard.showHairdressers') }}">Darse de alta en peluquería</a>
                            </li>
                        @endif

                    @endauth

                    @auth
                        @if (Auth::user()->role == 'propietario')
                            <li>
                                <a id="create-hairdresser" class="hover:text-gray-500" href="#"
                                    data-url="{{ route('dashboard.hairdresser') }}">Crear peluquería</a>
                            </li>
                            <li>
                                <a id="delete-hairdresser" class="hover:text-gray-500" href="#"
                                data-url="{{ route('dashboard.selectHairdresser') }}">Eliminar peluquería</a>
                            </li>
                            <li><a id="create-service" class="hover:text-gray-500" href="#"
                                    data-url="{{ route('dashboard.selectHairdresser') }}">Gestión de servicios</a></li>

                            <li><a id="manage-appointments" class="hover:text-gray-500" href="#"
                                    data-url="{{ route('dashboard.selectSignup') }}">Gestión de citas</a></li>
                        @endif
                    @endauth


                </ul>
            </div>


            <div>
                <form action="{{ route('users.logout') }}" method="post">
                    @csrf
                    <button type="submit">
                        <h3
                            class="font-work font-medium  text-white hover:text-gray-500 underline mb-4 mt-6 xl:text-2xl">
                            Cerrar Sesión</h3>
                    </button>

                </form>

            </div>

        </nav>

    </div>
</div>
