<x-app-layout>
    <main>
        <section id="aboutMe" class="flex flex-col items-center font-noto pt-4 pb-8">
            <header class="pl-4 pr-4">
                <h1 class="text-4xl/loose text-center font-bold">Santiago
                    <span class="text-purple-600">Rosado Ruiz</span>
                </h1>
            </header>

            <article class="flex flex-col items-center justify-center pt-2 lg:gap-5">

                <div class="lg:w-[70%]">
                    <figure class="flex justify-center">
                        <x-imageRounded src="storage/images/pixelart.jpg" alt="Imagen pixelada"
                            class=" border-solid border-2 border-black w-80 min-h-80 md:min-w-80 md:min-h-80 lg:min-w-96 lg:min-h-96  lg:ml-4">
                        </x-imageRounded>
                    </figure>
                </div>
                <div class="text-justify text-xl font-work 2xl:text-3xl leading-relaxed font-medium p-5 md:p-10 ">
                    <p>
                        Me llamo Santiago Rosado Ruiz, soy desarrollador de aplicaciones web con una sólida formación en
                        Desarrollo de Aplicaciones Web, además de haber estudiado Geografía y Ordenación del Territorio
                        en la Universidad de Castilla-La Mancha.
                        <br><br>
                        A lo largo de mi formación he adquirido conocimientos en PHP, Laravel, JavaScript, jQuery, SQL y
                        Java, con los cuales he desarrollado proyectos que me han permitido afianzar mis habilidades en
                        programación backend y frontend.
                        <br><br>
                        Mi objetivo es seguir profundizando en el desarrollo de software moderno, centrándome en
                        arquitecturas como los microservicios y frameworks como Spring Boot, para ofrecer soluciones
                        eficientes y escalables.
                        <br><br>
                        En mi tiempo libre disfruto aplicando mis conocimientos técnicos a mis hobbies, como los juegos
                        de rol, lo que me ayuda a pensar de manera creativa y a resolver problemas desde diferentes
                        perspectivas.
                    </p>
                </div>


                <div class="w-80 flex gap-5 items-center justify-center pt-4">

                    <x-buttons.dynamic-button class="text-xl" href="https://github.com/Santyr96" message="GitHub">
                        <svg xmlns="http://www.w3.org/2000/svg" width="2rem" height="2rem" viewBox="0 0 64 64">
                            <path fill="white"
                                d="M62.2 31C61.6 15.5 48.9 2.8 33.3 2.2c-8.4-.3-16.2 2.7-22.3 8.4c-6 5.8-9.3 13.5-9.3 21.8c0 13.7 9.2 25.7 22.4 29.2c.4.1.7.1 1.1.1c.9 0 1.8-.3 2.5-.9c1-.8 1.6-2 1.6-3.3v-3.2c0-.9.1-4.7.1-5.4c.1-.5.2-.9.5-1.2c.6-.8.7-1.9.3-2.8c-.4-.8-1.2-1.4-2.1-1.4c-.6-.1-1.3-.2-1.8-.4c-.8-.2-1.5-.5-2.3-.9c-.6-.3-1.1-.8-1.6-1.4c-.3-.3-.7-1-1.1-2.3c-.4-1.2-.5-2.4-.5-3.7c0-1.8.5-3.2 1.6-4.4c.6-.7.8-1.6.4-2.4c-.3-.7-.4-1.5-.2-2.5c1.4.5 1.8.8 1.9.9l.1.1c.4.2.7.4 1 .6l.3.2c.5.3 1.2.4 1.8.2c1.6-.4 3.3-.7 4.9-.7c1.7 0 3.3.2 4.9.7c.6.2 1.2.1 1.8-.2l1.1-.7c.7-.4 1.5-.8 2.2-1.1c.2.9.1 1.8-.2 2.6s-.1 1.7.4 2.3c1.1 1.2 1.6 2.6 1.6 4.4c0 1.4-.2 2.6-.5 3.6c-.4 1-.7 1.8-1.2 2.4c-.4.5-1 .9-1.8 1.4c-.8.4-1.5.7-2.3.9c-.5.1-1.2.3-1.9.4h-.1c-.9.2-1.6.8-2 1.6c-.3.8-.3 1.7.3 2.5c.4.5.6 1.3.6 2.2v7.5c0 1.3.6 2.6 1.7 3.3c1.1.8 2.4 1 3.6.6C54.2 57.4 62.9 44.8 62.2 31m-22 26v-7q0-1.35-.3-2.4h.1c1-.3 2.1-.7 3.2-1.3c0 0 .1 0 .1-.1c1.2-.7 2.2-1.5 2.9-2.4c1-1.1 1.5-2.5 2-3.8c.5-1.5.7-3.1.7-5.1c0-2.4-.7-4.6-2-6.4c.4-1.9.2-4-.7-6.2c-.2-.6-.8-1.1-1.4-1.3c-1.1-.4-2.3-.2-3.9.3c-1 .4-2 .9-3 1.4l-.2.3c-3.4-.8-7-.8-10.4 0c-.1-.1-.2-.1-.4-.2c-.6-.4-1.4-.8-2.7-1.3c-1.6-.7-2.9-.9-4.1-.5c-.6.2-1.2.7-1.4 1.4c-.8 2.3-1 4.3-.6 6.2c-1.3 1.8-2 4-2 6.4c0 1.8.2 3.4.7 5s1.1 2.9 1.9 3.8c.9 1.1 1.9 1.9 3 2.5c1 .6 2.1 1 3.2 1.3h.2c-.1.3-.1.7-.2 1v2.9c-2.2-.8-4-1.9-5.6-3.5c-1.2-1.4-2.6-2.7-3.3-3.1c-1.4-.7-2.3.7-2.1 1.5c.3 1 1.7 1.6 2.6 2.4c.9.9 1.1 2.1 1.7 3.1c.9 1.3 4 3 6.6 3v2.3C13.9 54.1 6.3 44 6.3 32.5c0-7.1 2.8-13.7 7.9-18.6C19 9.2 25.4 6.7 32.1 6.7h1c13.3.5 24.1 11.3 24.6 24.5c.6 11.6-6.6 22.2-17.5 25.8">
                            </path>
                        </svg>
                    </x-buttons.dynamic-buttonn>


                    <x-buttons.dynamic-button class="text-xl" href="https://drive.google.com/file/d/1kI3yZpGeNYNegPsE3vPWxZtN6117Q8HH/view?usp=drive_link"
                    download="curriculum_vitae_santiago_rosado_ruiz.pdf" message="CV">
                        <svg xmlns="http://www.w3.org/2000/svg" width="2rem" height="2rem" viewBox="0 0 20 20">
                            <g fill="white">
                                <path
                                    d="M7.8 6.35c.56 0 1.01-.45 1.01-1.01S8.36 4.33 7.8 4.33s-1.01.45-1.01 1.01s.45 1.01 1.01 1.01" />
                                <path fill-rule="evenodd"
                                    d="M9.83 8.55c0-1.08-.91-1.86-2.03-1.86s-2.03.78-2.03 1.86v.51c0 .09.04.18.1.24s.15.1.24.1h3.38c.09 0 .18-.04.24-.1s.1-.15.1-.24zM5.75 11.5a.75.75 0 0 1 .75-.75h7a.75.75 0 0 1 0 1.5h-7a.75.75 0 0 1-.75-.75m0 3a.75.75 0 0 1 .75-.75h7a.75.75 0 0 1 0 1.5h-7a.75.75 0 0 1-.75-.75"
                                    clip-rule="evenodd" />
                                <path fill-rule="evenodd"
                                    d="M2.5 2.5c0-1.102.898-2 2-2h6.69c.562 0 1.092.238 1.465.631l.006.007l4.312 4.702c.359.383.527.884.527 1.36v10.3c0 1.102-.898 2-2 2h-11c-1.102 0-2-.898-2-2zm8.689 0H4.5v15h11V7.192l-4.296-4.685l-.003-.001z"
                                    clip-rule="evenodd" />
                                <path fill-rule="evenodd"
                                    d="M11.19.5a1 1 0 0 1 1 1v4.7h4.31a1 1 0 1 1 0 2h-5.31a1 1 0 0 1-1-1V1.5a1 1 0 0 1 1-1"
                                    clip-rule="evenodd" />
                            </g>
                        </svg>
                    </x-buttons.dynamic-button>

                </div>

            </article>


        </section>
    </main>
</x-app-layout>
