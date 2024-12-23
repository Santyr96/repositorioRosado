<div class="flex flex-col items-center gap-2">
    <h1 class="font-work md:text-[2rem]"><strong>Añade tu peluqueria</strong></h1>

    <x-modals.error-modal class="hidden xl:left-40" modalTitle="Error al envíar el formulario"
        modalMessage=""></x-modals.error-modal>

    <form class="flex flex-col gap-5 w-4/5 md:h-full
    " name="HairDresserForm" action="#" method="post"
        data-form="{{ route('dashboard.insertHairDresser') }}">
        @csrf

        {{-- Input para introducir el nombre de la peluquería en el formulario --}}
        <div>
            <label class="pl-1 font-semibold md:text-2xl" for="Name">Nombre</label>
            <div class="flex w-full pt-1 gap-x-3">
                <x-inputs.input type="text" name="name" class="md:text-lg">
                </x-inputs.input>
                <svg xmlns="http://www.w3.org/2000/svg" width="2rem" height="2rem" viewBox="0 0 26 26">
                    <path fill="#9333ea"
                        d="M16.563 15.9c-.159-.052-1.164-.505-.536-2.414h-.009c1.637-1.686 2.888-4.399 2.888-7.07c0-4.107-2.731-6.26-5.905-6.26c-3.176 0-5.892 2.152-5.892 6.26c0 2.682 1.244 5.406 2.891 7.088c.642 1.684-.506 2.309-.746 2.397c-3.324 1.202-7.224 3.393-7.224 5.556v.811c0 2.947 5.714 3.617 11.002 3.617c5.296 0 10.938-.67 10.938-3.617v-.811c0-2.228-3.919-4.402-7.407-5.557" />
                </svg>
            </div>

            <x-forms.span-validate class="w-10/12">

            </x-forms.span-validate>


        </div>


        {{-- Input para introducir el CIF de la peluquería en el formulario --}}

        <div>
            <label class="pl-1 font-semibold md:text-2xl" for="CIF">CIF</label>
            <div class="flex w-full pt-1 gap-x-3">
                <x-inputs.input type="text" name="cif" placeholder="A12345678..." class="md:text-lg">
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
                <x-inputs.input type="phone" name="phone" placeholder="665612234..." class="md:text-lg">
                </x-inputs.input>

                <svg xmlns="http://www.w3.org/2000/svg" width="2rem" height="2rem" viewBox="0 0 24 24">
                    <path fill="#9333ea"
                        d="m16.556 12.906l-.455.453s-1.083 1.076-4.038-1.862s-1.872-4.014-1.872-4.014l.286-.286c.707-.702.774-1.83.157-2.654L9.374 2.86C8.61 1.84 7.135 1.705 6.26 2.575l-1.57 1.56c-.433.432-.723.99-.688 1.61c.09 1.587.808 5 4.812 8.982c4.247 4.222 8.232 4.39 9.861 4.238c.516-.048.964-.31 1.325-.67l1.42-1.412c.96-.953.69-2.588-.538-3.255l-1.91-1.039c-.806-.437-1.787-.309-2.417.317" />
                </svg>
            </div>

            <x-forms.span-validate class="w-10/12">

            </x-forms.span-validate>
        </div>

        {{-- Input para introducir la dirección de la peluqueria en el formulario --}}

        <div>
            <div>
                <label class="pl-1 font-semibold md:text-2xl" for="address">Dirección</label>
                <div class="flex w-full pt-1 gap-x-3">
                    <x-inputs.input type="text" name="address" placeholder="Calle Mayor, 15, 28013, Madrid"
                        class="md:text-lg">
                    </x-inputs.input>

                    <svg xmlns="http://www.w3.org/2000/svg" width="2rem" height="2rem" viewBox="0 0 24 24">
                        <path fill="#9333ea"
                            d="M5 20v-9.15L2.2 13L1 11.4L12 3l4 3.05V4h3v4.35l4 3.05l-1.2 1.6l-2.8-2.15V20h-5v-6h-4v6zm5-9.975h4q0-.8-.6-1.313T12 8.2t-1.4.513t-.6 1.312" />
                    </svg>
                </div>

                <x-forms.span-validate class="w-10/12">

                </x-forms.span-validate>
            </div>
        </div>


        <x-buttons.submit-button id="submit" name="submit" message="Añadir peluquería"
            class="w-4/5 mt-6 text-sm md:text-xl xl:w-3/4">
        </x-buttons.submit-button>


    </form>
