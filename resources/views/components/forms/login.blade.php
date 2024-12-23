
@vite('resources/js/components/passwords/show_password.js')

@error('general')
<x-modals.error-modal modalTitle="Error al iniciar sesión" modalMessage="{{ $message }}"></x-modals.error-modal>
@enderror

@error('email')
<x-modals.error-modal modalTitle="Error al enviar el link de restablecimiento de contraseña" modalMessage="{{ $errors->first('email') }}"></x-modals.error-modal>
@enderror

@if (session('status'))
<x-modals.error-modal modalTitle="Solicitud de restablecimiento de contraseña" modalMessage="{{ session('status') }}"></x-modals.error-modal>
@endif

<section
    class="flex justify-center items-center xl:grid xl:grid-cols-2 xl:justify-items-center pb-12 mb-10 md:mb-0 h-screen xl:pb-0"
    id="login">
    <div class="hidden xl:flex flex-col font-work text-center xl:px-6 ">

        <h1 class="text-7xl/relaxed font-bold ">
            ¡Bienvenido de vuelta!
        </h1>
        <br>
        <h2 class="font-semibold text-5xl/relaxed italic">
            Organiza tu agenda y aprovecha al máximo cada cita
        </h2>
    </div>

    <div class="xl:flex justify-center items-center w-10/12 md:max-xl:w-9/12 xl:h-full xl:w-full xl:bg-purple-600">
        <div id="caja_login"
            class="font-work border-black border-2 shadow-md shadow-black h-auto p-4 w-full  xl:w-7/12 xl:bg-white">

            <form name="fForm" id="form" class="flex flex-col gap-3  
        " action="{{route('users.loginUser')}}" method="post" novalidate>
        @csrf
                <div class="text-center">
                    <h1
                        class=" text-[1.25rem] md:text-3xl font-work font-bold underline decoration-4 underline-offset-8 pb-4 ">
                        Iniciar Sesión</h1>
                </div>

                <div>
                    <label class="pl-1 font-semibold md:text-2xl" for="E-mail">E-mail</label>
                    <div class="flex w-full pt-1 gap-x-3">
                        <x-inputs.input type="email" name="email" placeholder="E-mail..." class="md:text-lg"
                            pattern="^[a-zA-Z0-9._%+-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,}$">
                        </x-inputs.input>

                        <svg class="md:h-14 md:w-14" xmlns="http://www.w3.org/2000/svg" width="1.5rem" height="2rem"
                            viewBox="0 0 24 24">
                            <path fill="#9333ea"
                                d="M20 4H4c-1.1 0-1.99.9-1.99 2L2 18c0 1.1.9 2 2 2h16c1.1 0 2-.9 2-2V6c0-1.1-.9-2-2-2m0 4l-8 5l-8-5V6l8 5l8-5z" />
                        </svg>
                    </div>

                    <x-forms.span-validate class="w-10/12">

                    </x-forms.span-validate>

                </div>

                <div class="pb-2">
                    <label class="pl-1 font-semibold md:text-2xl" for="Password">
                        Contraseña
                    </label>

                    <div class="flex w-full pt-1 pb-2 gap-x-3">
                        <x-inputs.input type="password" name="password" placeholder="Contraseña..." class="md:text-lg">
                        </x-inputs.input>
                        <div class="relative">
                            <button id="togglePassword" type="button"
                                class="absolute inset-y-0 right-0 px-3 py-2 text-gray-600 hover:text-gray-800">
                                <svg class="text-gray-500 hover:text-gray-200" xmlns="http://www.w3.org/2000/svg" width="1.5rem" height="2rem"
                                    viewBox="0 0 24 24">
                                    <path fill="currentColor"
                                        d="M12 9a3 3 0 0 0-3 3a3 3 0 0 0 3 3a3 3 0 0 0 3-3a3 3 0 0 0-3-3m0 8a5 5 0 0 1-5-5a5 5 0 0 1 5-5a5 5 0 0 1 5 5a5 5 0 0 1-5 5m0-12.5C7 4.5 2.73 7.61 1 12c1.73 4.39 6 7.5 11 7.5s9.27-3.11 11-7.5c-1.73-4.39-6-7.5-11-7.5" />
                                </svg>
                                <svg class="hidden text-gray-500 hover:text-gray-200" xmlns="http://www.w3.org/2000/svg" width="1.5rem"
                                    height="1.5rem" viewBox="0 0 24 24">
                                    <path fill="currentColor"
                                        d="M11.83 9L15 12.16V12a3 3 0 0 0-3-3zm-4.3.8l1.55 1.55c-.05.21-.08.42-.08.65a3 3 0 0 0 3 3c.22 0 .44-.03.65-.08l1.55 1.55c-.67.33-1.41.53-2.2.53a5 5 0 0 1-5-5c0-.79.2-1.53.53-2.2M2 4.27l2.28 2.28l.45.45C3.08 8.3 1.78 10 1 12c1.73 4.39 6 7.5 11 7.5c1.55 0 3.03-.3 4.38-.84l.43.42L19.73 22L21 20.73L3.27 3M12 7a5 5 0 0 1 5 5c0 .64-.13 1.26-.36 1.82l2.93 2.93c1.5-1.25 2.7-2.89 3.43-4.75c-1.73-4.39-6-7.5-11-7.5c-1.4 0-2.74.25-4 .7l2.17 2.15C10.74 7.13 11.35 7 12 7" />
                                </svg>
                            </button>
                        </div>
                        <svg class="md:h-14 md:w-14" xmlns="http://www.w3.org/2000/svg" width="1.5rem" height="2rem"
                            viewBox="0 0 24 24">
                            <path fill="#9333ea"
                                d="M12 17a2 2 0 0 0 2-2a2 2 0 0 0-2-2a2 2 0 0 0-2 2a2 2 0 0 0 2 2m6-9a2 2 0 0 1 2 2v10a2 2 0 0 1-2 2H6a2 2 0 0 1-2-2V10a2 2 0 0 1 2-2h1V6a5 5 0 0 1 5-5a5 5 0 0 1 5 5v2zm-6-5a3 3 0 0 0-3 3v2h6V6a3 3 0 0 0-3-3" />
                        </svg>
                    </div>

                    <x-forms.span-validate class="w-10/12">

                    </x-forms.span-validate>

                    <div class="flex justify-end text-sm md:text-lg hover:text-purple-600">
                        <a href="{{route('users.forgotPassword')}}"id="forgotPassword">¿Olvidaste tu contraseña?</a>
                    </div>

                </div>

                <div class="flex gap-2 md:text-xl">
                    <input type="checkbox" name="remember" id="remember" value="Recuerdame">
                    <label for="remember">Recuerdáme</label>
                </div>


                <x-buttons.submit-button id="enviar" name="login" message="Iniciar Sesión"
                    class="w-full text-sm md:text-xl xl:w-3/4">
                </x-buttons.submit-button>

                <div class="flex justify-center text-center font-work pt-2 md:text-xl">
                    <p>¿No tienes una cuenta? <a class="underline font-bold hover:text-purple-600"
                            href="{{route('users.create')}}">Regístrate</a></p>
                </div>
            </form>
        </div>

    </div>
</section>
