<div class="flex flex-col items-center gap-2">
    <h1 class="font-work md:text-[2rem]"><strong>Perfil del usuario</strong></h1>
    <div class="flex flex-col items-center">
        <x-image-rounded id="avatar"
            src="{{ $user->avatar ? asset($user->avatar) : asset('storage/images/default_user_avatar.webp') }}"
            alt="Imagen de perfil" class="h-16 w-16 md:h-40 md:w-40">
        </x-image-rounded>
        <button id="avatarUpload" class="relative bottom-3 p-1 rounded-xl bg-purple-300 hover:bg-purple-500">
            <svg class="md:w-6 md:h-6" xmlns="http://www.w3.org/2000/svg" width="1rem" height="1rem"
                viewBox="0 0 24 24">
                <path fill="white"
                    d="M20.71 7.04c.39-.39.39-1.04 0-1.41l-2.34-2.34c-.37-.39-1.02-.39-1.41 0l-1.84 1.83l3.75 3.75M3 17.25V21h3.75L17.81 9.93l-3.75-3.75z" />
            </svg>
        </button>
        <h3>Hola, {{ $user->name }}</h3>
    </div>

    <x-modals.avatar-modal modalTitle="Carga de imagen"
        modalMessage="Carga una imagen para actualizar el avatar"></x-modals.avatar-modal>
    <x-modals.error-modal class="hidden xl:left-40" modalTitle="Error al envíar el formulario"
        modalMessage=""></x-modals.error-modal>


    <form class="flex flex-col gap-5 w-4/5 md:h-full
    " name="fForm" action="#" method="post"
        data-form="{{ route('profile.updateProfile') }}">
        @csrf

        {{-- Input para introducir el nombre el el formulario --}}
        <div>
            <label class="pl-1 font-semibold md:text-2xl" for="Name">Nombre</label>
            <div class="flex w-full pt-1 gap-x-3">
                <x-inputs.input type="text" name="name" class="md:text-lg" value="{{ $user->name }}">
                </x-inputs.input>
                <svg xmlns="http://www.w3.org/2000/svg" width="2rem" height="2rem" viewBox="0 0 26 26">
                    <path fill="#9333ea"
                        d="M16.563 15.9c-.159-.052-1.164-.505-.536-2.414h-.009c1.637-1.686 2.888-4.399 2.888-7.07c0-4.107-2.731-6.26-5.905-6.26c-3.176 0-5.892 2.152-5.892 6.26c0 2.682 1.244 5.406 2.891 7.088c.642 1.684-.506 2.309-.746 2.397c-3.324 1.202-7.224 3.393-7.224 5.556v.811c0 2.947 5.714 3.617 11.002 3.617c5.296 0 10.938-.67 10.938-3.617v-.811c0-2.228-3.919-4.402-7.407-5.557" />
                </svg>
            </div>

            <x-forms.span-validate class="w-10/12">

            </x-forms.span-validate>


        </div>


        {{-- Input para introducir el DNI en el formulario --}}

        <div>
            <label class="pl-1 font-semibold md:text-2xl" for="dni">DNI</label>
            <div class="flex w-full pt-1 gap-x-3">
                <x-inputs.input type="text" name="dni" placeholder="DNI..." class="md:text-lg"
                    value="{{ $user->dni }}">
                </x-inputs.input>

                <svg xmlns="http://www.w3.org/2000/svg" width="2rem" height="2rem" viewBox="0 0 24 24">
                    <path fill="#9333ea"
                        d="M2 3h20c1.05 0 2 .95 2 2v14c0 1.05-.95 2-2 2H2c-1.05 0-2-.95-2-2V5c0-1.05.95-2 2-2m12 3v1h8V6zm0 2v1h8V8zm0 2v1h7v-1zm-6 3.91C6 13.91 2 15 2 17v1h12v-1c0-2-4-3.09-6-3.09M8 6a3 3 0 0 0-3 3a3 3 0 0 0 3 3a3 3 0 0 0 3-3a3 3 0 0 0-3-3" />
                </svg>
            </div>

            <x-forms.span-validate class="w-10/12">

            </x-forms.span-validate>



        </div>


        {{-- Input para introducir el número de telefono en el formulario --}}

        <div>
            <label class="pl-1 font-semibold md:text-2xl" for="phone">Télefono</label>
            <div class="flex w-full pt-1 gap-x-3">
                <x-inputs.input type="phone" name="phone" placeholder="Teléfono..." class="md:text-lg"
                    value="{{ $user->phone }}">
                </x-inputs.input>

                <svg xmlns="http://www.w3.org/2000/svg" width="2rem" height="2rem" viewBox="0 0 24 24">
                    <path fill="#9333ea"
                        d="m16.556 12.906l-.455.453s-1.083 1.076-4.038-1.862s-1.872-4.014-1.872-4.014l.286-.286c.707-.702.774-1.83.157-2.654L9.374 2.86C8.61 1.84 7.135 1.705 6.26 2.575l-1.57 1.56c-.433.432-.723.99-.688 1.61c.09 1.587.808 5 4.812 8.982c4.247 4.222 8.232 4.39 9.861 4.238c.516-.048.964-.31 1.325-.67l1.42-1.412c.96-.953.69-2.588-.538-3.255l-1.91-1.039c-.806-.437-1.787-.309-2.417.317" />
                </svg>
            </div>

            <x-forms.span-validate class="w-10/12">

            </x-forms.span-validate>
        </div>



        {{-- Input para introducir la contraseña en el formulario en el formulario --}}

        <div class="pb-2">
            <label class="pl-1 font-semibold md:text-2xl" for="Password">
                Nueva Contraseña
            </label>

            <div class="flex w-full pt-1 gap-x-3">
                <x-inputs.input type="password" name="password" placeholder="Contraseña..." class="md:text-lg">
                </x-inputs.input>
                <div class="relative">
                    <button id="togglePassword" type="button"
                        class="absolute inset-y-0 right-0 px-3 py-2 text-gray-600 hover:text-gray-800">
                        <svg class="text-gray-500 hover:text-gray-200" xmlns="http://www.w3.org/2000/svg" width="1.5rem"
                            height="2rem" viewBox="0 0 24 24">
                            <path fill="currentColor"
                                d="M12 9a3 3 0 0 0-3 3a3 3 0 0 0 3 3a3 3 0 0 0 3-3a3 3 0 0 0-3-3m0 8a5 5 0 0 1-5-5a5 5 0 0 1 5-5a5 5 0 0 1 5 5a5 5 0 0 1-5 5m0-12.5C7 4.5 2.73 7.61 1 12c1.73 4.39 6 7.5 11 7.5s9.27-3.11 11-7.5c-1.73-4.39-6-7.5-11-7.5" />
                        </svg>
                        <svg class="hidden text-gray-500 hover:text-gray-200" xmlns="http://www.w3.org/2000/svg"
                            width="1.5rem" height="1.5rem" viewBox="0 0 24 24">
                            <path fill="currentColor"
                                d="M11.83 9L15 12.16V12a3 3 0 0 0-3-3zm-4.3.8l1.55 1.55c-.05.21-.08.42-.08.65a3 3 0 0 0 3 3c.22 0 .44-.03.65-.08l1.55 1.55c-.67.33-1.41.53-2.2.53a5 5 0 0 1-5-5c0-.79.2-1.53.53-2.2M2 4.27l2.28 2.28l.45.45C3.08 8.3 1.78 10 1 12c1.73 4.39 6 7.5 11 7.5c1.55 0 3.03-.3 4.38-.84l.43.42L19.73 22L21 20.73L3.27 3M12 7a5 5 0 0 1 5 5c0 .64-.13 1.26-.36 1.82l2.93 2.93c1.5-1.25 2.7-2.89 3.43-4.75c-1.73-4.39-6-7.5-11-7.5c-1.4 0-2.74.25-4 .7l2.17 2.15C10.74 7.13 11.35 7 12 7" />
                        </svg>
                    </button>
                </div>

                <svg xmlns="http://www.w3.org/2000/svg" width="1.5rem" height="2rem" viewBox="0 0 24 24">
                    <path fill="#9333ea"
                        d="M12 17a2 2 0 0 0 2-2a2 2 0 0 0-2-2a2 2 0 0 0-2 2a2 2 0 0 0 2 2m6-9a2 2 0 0 1 2 2v10a2 2 0 0 1-2 2H6a2 2 0 0 1-2-2V10a2 2 0 0 1 2-2h1V6a5 5 0 0 1 5-5a5 5 0 0 1 5 5v2zm-6-5a3 3 0 0 0-3 3v2h6V6a3 3 0 0 0-3-3" />
                </svg>
            </div>

            <x-forms.span-validate class="w-10/12">

            </x-forms.span-validate>

            <div class="pb-2 pt-2">
                <label class="pl-1 font-semibold md:text-2xl" for="repeatPassword">
                    Repite la contraseña
                </label>

                <div class="flex w-full pt-1 gap-x-3">
                    <x-inputs.input type="password" name="password_confirmation" class="md:text-lg">
                    </x-inputs.input>
                    <div class="relative">
                        <button id="togglePassword" type="button"
                            class="absolute inset-y-0 right-0 px-3 py-2 text-gray-600 hover:text-gray-800">
                            <svg class="text-gray-500 hover:text-gray-200" xmlns="http://www.w3.org/2000/svg"
                                width="1.5rem" height="2rem" viewBox="0 0 24 24">
                                <path fill="currentColor"
                                    d="M12 9a3 3 0 0 0-3 3a3 3 0 0 0 3 3a3 3 0 0 0 3-3a3 3 0 0 0-3-3m0 8a5 5 0 0 1-5-5a5 5 0 0 1 5-5a5 5 0 0 1 5 5a5 5 0 0 1-5 5m0-12.5C7 4.5 2.73 7.61 1 12c1.73 4.39 6 7.5 11 7.5s9.27-3.11 11-7.5c-1.73-4.39-6-7.5-11-7.5" />
                            </svg>
                            <svg class="hidden text-gray-500 hover:text-gray-200" xmlns="http://www.w3.org/2000/svg"
                                width="1.5rem" height="1.5rem" viewBox="0 0 24 24">
                                <path fill="currentColor"
                                    d="M11.83 9L15 12.16V12a3 3 0 0 0-3-3zm-4.3.8l1.55 1.55c-.05.21-.08.42-.08.65a3 3 0 0 0 3 3c.22 0 .44-.03.65-.08l1.55 1.55c-.67.33-1.41.53-2.2.53a5 5 0 0 1-5-5c0-.79.2-1.53.53-2.2M2 4.27l2.28 2.28l.45.45C3.08 8.3 1.78 10 1 12c1.73 4.39 6 7.5 11 7.5c1.55 0 3.03-.3 4.38-.84l.43.42L19.73 22L21 20.73L3.27 3M12 7a5 5 0 0 1 5 5c0 .64-.13 1.26-.36 1.82l2.93 2.93c1.5-1.25 2.7-2.89 3.43-4.75c-1.73-4.39-6-7.5-11-7.5c-1.4 0-2.74.25-4 .7l2.17 2.15C10.74 7.13 11.35 7 12 7" />
                            </svg>
                        </button>
                    </div>
                    <svg xmlns="http://www.w3.org/2000/svg" width="1.5rem" height="2rem" viewBox="0 0 24 24">
                        <path fill="#9333ea"
                            d="M12 17a2 2 0 0 0 2-2a2 2 0 0 0-2-2a2 2 0 0 0-2 2a2 2 0 0 0 2 2m6-9a2 2 0 0 1 2 2v10a2 2 0 0 1-2 2H6a2 2 0 0 1-2-2V10a2 2 0 0 1 2-2h1V6a5 5 0 0 1 5-5a5 5 0 0 1 5 5v2zm-6-5a3 3 0 0 0-3 3v2h6V6a3 3 0 0 0-3-3" />
                    </svg>
                </div>

                <x-forms.span-validate class="w-10/12">

                </x-forms.span-validate>


            </div>


            <x-buttons.submit-button id="submit" name="submit" message="Modificar"
                class="w-4/5 mt-6 text-sm md:text-xl xl:w-3/4">
            </x-buttons.submit-button>
        </div>
