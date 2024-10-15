<x-app-layout>

    <main class="">
        <section class="grid grid-rows-1  xl:grid-cols-[40%,60%]  lg:ml-8  w-full xl:pt-12">
            <div class="mensaje flex flex-col gap-10 items-center py-20 font-noto font-bold">
                <h1 class="text-center text-5xl/relaxed md:text-6xl/loose md:p-11 lg:text-6xl/relaxed">
                    Bienvenidos a <span class="text-purple-600">HairBooker</span>: la agenda digital para peluquerías
                </h1>

                <x-log_in />

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

            <div class="fondo h-52 bg-cover lg:h-96 2xl:h-[40rem]" style="background-image: url('storage/images/onda.svg');">
            </div>


            <div id="casillas" class="pb-24 grid grid-cols-1 md:grid-cols-2 xl:grid-cols-4 xl:pb-32 bg-[#945cf2]">

                <x-cards.polygon-card src="storage/images/notebook_icon.svg" alt="Notebook Icon"
                    title="Gestión de citas" message1="¿Cansado de organizar tus cita a mano?"
                    message2="Optimiza tu tiempo a través de una una solución intuitiva
                            gestionando tus citas de manera eficiente y sencilla, mientras que los
                            clientes pueden reservar fácilmente su próximo servicio en solo unos clicks.
">
                </x-cards.polygon-card>

                <x-cards.polygon-card src="storage/images/watch_icon.svg" alt="Watch Icon"
                    title="Recordatorios automáticos" message1="¿Has olvidado tu reserva?"
                    message2=" Reduce las ausencias con nuestros recordatorios automáticos de citas: HairBooker envía
                            notificaciones a tus clientes, asegurando que estén siempre al tanto de sus próximas
                            visitas.">
                </x-cards.polygon-card>

                <x-cards.polygon-card src="storage/images/relationship_icon.svg" alt="Relationship Icon"
                    title="Conexión Constante" message1="¿Necesitas mantener contacto con tu cliente?"
                    message2="Nuestra plataforma permite un contacto permanente entre propietarios y clientes a través de
                            mensajes directos y notificaciones.
">
                </x-cards.polygon-card>

                <x-cards.polygon-card src="storage/images/analysis_icono.svg" alt="Analysis Icon"
                    title="Análisis del negocio" message1="¿Te gustaría conocer estadísticas sobre tu negocio?"
                    message2="Tendrás acceso a información clave sobre la evolución de tu negocio.
                            Todo esto con el objetivo de que puedas analizar los datos y diseñar una
                            estrategia efectiva que te permita optimizar tus operaciones.">
                </x-cards.polygon-card>



            </div>


        </section>


    </main>

</x-app-layout>
