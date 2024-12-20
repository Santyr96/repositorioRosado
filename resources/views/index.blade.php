<x-app-layout>
    <x-slot:title>
        Inicio
    </x-slot>

    <main">
        <section class="grid grid-rows-1  xl:grid-cols-[40%,60%]  max-lg:lg:ml-8  w-full xl:pt-12">
            <div class="mensaje flex flex-col gap-10 items-center py-20 font-noto font-bold">
                <h1 class="text-center text-5xl/relaxed md:text-6xl/loose md:p-11 lg:text-6xl/relaxed">
                    Bienvenidos a <span class="text-purple-600">HairBooker</span>: la agenda digital para peluquerías
                </h1>

                <x-buttons.dynamic-button href="{{ route('users.login') }}" message="Iniciar Sesión"
                    class="w-52 md:w-64 md:text-2xl">

                </x-buttons.dynamic-button>

            </div>
            <div class="hidden xl:flex m-4 justify-center items-center">
                <img class="h-full w-4/5" src="storage/images/peine.png" alt="mascota">
            </div>
        </section>
        <br><br>

        <section id="solutions">

            <div class="relative bottom-9 text-black text-center lg:pt-36 lg:transform translate-y-16">
                <h1 class="text-xl md:text-4xl xl:text-7xl/normal font-work font-bold">¿Cómo te ayuda HairBooker?</h1>
                <p class="text-xl md:text-2xl xl:text-3xl mt-4">Fácil, estas son las soluciones</p>
            </div>

            <div class="fondo h-52 bg-cover lg:h-96 2xl:h-[40rem]"
                style="background-image: url('storage/images/onda.svg');">
            </div>


            <div id="casillas" class="pb-24 grid grid-cols-1 md:grid-cols-2 xl:grid-cols-4 xl:pb-32 bg-[#945cf2]">

                <x-cards.polygon-card src="storage/images/notebook_icon.svg" alt="Notebook Icon"
                    title="Organiza tus citas fácilmente"
                    message1="¿Te resulta complicado gestionar las reservas manualmente?"
                    message2="Simplifica la gestión de tus citas con nuestra herramienta intuitiva. Tus clientes podrán reservar su próximo servicio con facilidad en solo unos clics.">
                </x-cards.polygon-card>

                <x-cards.polygon-card src="storage/images/watch_icon.svg" alt="Watch Icon"
                    title="Gestión de servicios y horarios" message1="¿Quieres personalizar tus servicios y horarios?"
                    message2="Configura tus horarios y los servicios que ofreces directamente desde nuestra plataforma, adaptándolos a las necesidades de tu negocio.">
                </x-cards.polygon-card>

                <x-cards.polygon-card src="storage/images/calendar_icon.svg" alt="Calendar Icon"
                    title="Visualización en calendario" message1="¿Quieres una forma clara de gestionar tus citas?"
                    message2="Consulta y edita las reservas fácilmente gracias a nuestra vista en calendario, que se actualiza en tiempo real para reflejar cualquier cambio.">
                </x-cards.polygon-card>

                <x-cards.polygon-card src="storage/images/client_management_icon.svg" alt="Client Management Icon"
                    title="Gestión de clientes"
                    message1="¿Quieres administrar la información de tus clientes de manera eficiente?"
                    message2="Organiza y accede fácilmente a los datos de tus clientes, incluyendo su historial de reservas, para ofrecer un servicio más personalizado y profesional.">
                </x-cards.polygon-card>


            </div>


        </section>


        </main>

</x-app-layout>
