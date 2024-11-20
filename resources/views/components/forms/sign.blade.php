@vite('resources/js/auth/auth.js')
@vite('resources/js/components/passwords/show_password.js')



@error('general')
<x-modals.error-modal modalTitle="Error en el registro" modalMessage="{{ $message }}"></x-modals.error-modal>

@enderror

<section class="flex justify-center items-center xl:grid xl:grid-cols-2 xl:justify-items-center  pb-12 h-auto xl:pb-0"
    id="login">
    <div class="hidden xl:flex flex-col font-work  text-center xl:px-6">

        <h1 class="text-7xl/relaxed font-bold ">
            ¿Preparado para sacar el máximo rendimiento a tus citas?
        </h1>
        <br>
        <h2 class="font-semibold text-5xl/relaxed italic">
            Registrate y aprovecha todas las ventajas que te ofrece HairBooker
        </h2>
    </div>

    <div class="xl:flex justify-center items-center w-4/5 md:max-xl:w-9/12 xl:h-full xl:w-full xl:bg-purple-600">
        <div id="caja_sign"
            class="font-work border-black border-2 shadow-md shadow-black h-auto p-2 md:p-12 w-full  xl:w-4/5 xl:mt-10 xl:mb-10 xl:bg-white">

            <form class="flex flex-col gap-5 md:h-full
        " name="fForm" action="{{ route('users.store') }}"
                method="post">
                @csrf
                <div class="text-center">
                    <h1
                        class=" text-[1.25rem] md:text-3xl font-work font-bold underline decoration-4 underline-offset-8 pb-4 ">
                        Registro</h1>
                </div>

                {{-- Input para introducir el nombre el el formulario --}}
                <div>
                    <label class="pl-1 font-semibold md:text-2xl" for="Name">Nombre</label>
                    <div class="flex w-full pt-1 gap-x-3">
                        <x-inputs.input type="text" name="name" placeholder="Nombre..." class="md:text-lg">
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
                        <x-inputs.input type="text" name="dni" placeholder="DNI..." class="md:text-lg">
                        </x-inputs.input>

                        <svg xmlns="http://www.w3.org/2000/svg" width="2rem" height="2rem" viewBox="0 0 24 24">
                            <path fill="#9333ea"
                                d="M2 3h20c1.05 0 2 .95 2 2v14c0 1.05-.95 2-2 2H2c-1.05 0-2-.95-2-2V5c0-1.05.95-2 2-2m12 3v1h8V6zm0 2v1h8V8zm0 2v1h7v-1zm-6 3.91C6 13.91 2 15 2 17v1h12v-1c0-2-4-3.09-6-3.09M8 6a3 3 0 0 0-3 3a3 3 0 0 0 3 3a3 3 0 0 0 3-3a3 3 0 0 0-3-3" />
                        </svg>
                    </div>

                    <x-forms.span-validate class="w-10/12">

                    </x-forms.span-validate>



                </div>

                {{-- Select para seleccionar el sexo en el formulario --}}

                <div>
                    <label class="pl-1 font-semibold md:text-2xl" for="sex">Sexo</label>
                    <div class="flex w-full pt-1 gap-x-3">
                        <x-inputs.select name="sex" placeholder="Elige tu sexo" :options="['' => 'Elige tu sexo', 'masculino' => 'Hombre', 'femenino' => 'Mujer']"></x-inputs.select>
                        <svg xmlns="http://www.w3.org/2000/svg" width="1.58rem" height="2rem" viewBox="0 0 1408 1792">
                            <path fill="#9333ea"
                                d="M1024 32q0-14 9-23t23-9h288q26 0 45 19t19 45v288q0 14-9 23t-23 9h-64q-14 0-23-9t-9-23V218l-254 255q126 158 126 359q0 221-147.5 384.5T640 1404v132h96q14 0 23 9t9 23v64q0 14-9 23t-23 9h-96v96q0 14-9 23t-23 9h-64q-14 0-23-9t-9-23v-96h-96q-14 0-23-9t-9-23v-64q0-14 9-23t23-9h96v-132q-149-16-270.5-103T55 1077.5T2 786q16-204 160-353.5T509 260q118-14 228 19t198 103l255-254h-134q-14 0-23-9t-9-23zM576 1280q185 0 316.5-131.5T1024 832T892.5 515.5T576 384T259.5 515.5T128 832t131.5 316.5T576 1280" />
                        </svg>
                    </div>

                    <x-forms.span-validate class="w-10/12">

                    </x-forms.span-validate>

                </div>

                {{-- Select para seleccionar el rol en el formulario --}}

                <div>
                    <label class="pl-1 font-semibold md:text-2xl" for="rol">Rol</label>
                    <div class="flex w-full pt-1 gap-x-3">
                        <x-inputs.select name="rol" :options="['' => '¿Qué eres?', 'cliente' => 'Cliente', 'propietario' => 'Propietario']"></x-inputs.select>


                        <svg xmlns="http://www.w3.org/2000/svg" width="2rem" height="2rem" viewBox="0 0 24 24">
                            <g fill="none">
                                <path
                                    d="m12.593 23.258l-.011.002l-.071.035l-.02.004l-.014-.004l-.071-.035q-.016-.005-.024.005l-.004.01l-.017.428l.005.02l.01.013l.104.074l.015.004l.012-.004l.104-.074l.012-.016l.004-.017l-.017-.427q-.004-.016-.017-.018m.265-.113l-.013.002l-.185.093l-.01.01l-.003.011l.018.43l.005.012l.008.007l.201.093q.019.005.029-.008l.004-.014l-.034-.614q-.005-.018-.02-.022m-.715.002a.02.02 0 0 0-.027.006l-.006.014l-.034.614q.001.018.017.024l.015-.002l.201-.093l.01-.008l.004-.011l.017-.43l-.003-.012l-.01-.01z" />
                                <path fill="#9333ea"
                                    d="M12 3a3 3 0 0 0-1 5.83V11H8a3 3 0 0 0-3 3v1.17a3.001 3.001 0 1 0 2 0V14a1 1 0 0 1 1-1h8a1 1 0 0 1 1 1v1.17a3.001 3.001 0 1 0 2 0V14a3 3 0 0 0-3-3h-3V8.83A3.001 3.001 0 0 0 12 3" />
                            </g>
                        </svg>
                    </div>

                    <x-forms.span-validate class="w-10/12">

                    </x-forms.span-validate>

                </div>

                {{-- Input para introducir el e-mail en el formulario --}}

                <div>
                    <label class="pl-1 font-semibold md:text-2xl" for="E-mail">E-mail</label>
                    <div class="flex w-full pt-1 gap-x-3">
                        <x-inputs.input type="email" name="email" placeholder="E-mail..." class="md:text-lg">
                        </x-inputs.input>


                        <svg xmlns="http://www.w3.org/2000/svg" width="1.5rem" height="2rem" viewBox="0 0 24 24">
                            <path fill="#9333ea"
                                d="M20 4H4c-1.1 0-1.99.9-1.99 2L2 18c0 1.1.9 2 2 2h16c1.1 0 2-.9 2-2V6c0-1.1-.9-2-2-2m0 4l-8 5l-8-5V6l8 5l8-5z" />
                        </svg>
                    </div>

                    <x-forms.span-validate class="w-10/12">

                    </x-forms.span-validate>
                </div>

                {{-- Input para introducir el número de telefono en el formulario --}}

                <div>
                    <label class="pl-1 font-semibold md:text-2xl" for="phone">Télefono</label>
                    <div class="flex w-full pt-1 gap-x-3">
                        <x-inputs.input type="phone" name="phone" placeholder="Teléfono..." class="md:text-lg">
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
                        Contraseña
                    </label>

                    <div class="flex w-full pt-1 gap-x-3">
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
                            <svg xmlns="http://www.w3.org/2000/svg" width="1.5rem" height="2rem"
                                viewBox="0 0 24 24">
                                <path fill="#9333ea"
                                    d="M12 17a2 2 0 0 0 2-2a2 2 0 0 0-2-2a2 2 0 0 0-2 2a2 2 0 0 0 2 2m6-9a2 2 0 0 1 2 2v10a2 2 0 0 1-2 2H6a2 2 0 0 1-2-2V10a2 2 0 0 1 2-2h1V6a5 5 0 0 1 5-5a5 5 0 0 1 5 5v2zm-6-5a3 3 0 0 0-3 3v2h6V6a3 3 0 0 0-3-3" />
                            </svg>
                        </div>

                        <x-forms.span-validate class="w-10/12">

                        </x-forms.span-validate>


                    </div>


                    <x-buttons.submit-button id="submit" name="submit" message="Registrarse"
                        class="w-full text-sm md:text-xl xl:w-3/4">
                    </x-buttons.submit-button>

                    <div class="flex justify-center text-center font-work pt-2 md:text-xl">
                        <p>¿Ya tienes una cuenta? <a class="underline font-bold hover:text-purple-600"
                                href="#">Iniciar sesión</a></p>

                    </div>




            </form>
        </div>

    </div>
</section>
