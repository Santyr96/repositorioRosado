"use strict";

import { closeModal } from "../../modals/closeModal";


export function signupHairdresser() {
    const signUpForm = document.forms["fFormSignUp"];

    //Se envía las respuestas del formulario al servidor.
    signUpForm.addEventListener("submit", async function (e) {
        e.preventDefault();

        //Creación del objeto FormData que se encargará de enviar el valor de los campos al servidor.
        const formData = new FormData(signUpForm);

        //Se imprime en consola los valores de los campos del formulario, para saber que se envia.
        for (const [key, value] of formData.entries()) {
            console.log(`${key}:`, value);
        }

        try {
            //Se obtiene la url a la cuál se enviará el formulario.
            const url = this.getAttribute("data-form");

            //Si no existe la url lo registramos en la consola para saber que existe el problema.
            if (!url) {
                console.error("La URL para darse de alta en una peluquería no esta disponible.");
                showErrorMessage("Error interno. Intenta más tarde.");
            }

            //Se obtiene la respuesta asincrona utilizando await junto con fetch.
            const response = await fetch(url, {
                method: "POST",
                headers: {
                    //Laraven utiliza el sistema CSFR para los token y añadir mayor seguridad en los formularios.
                    "X-CSRF-TOKEN": document
                        .querySelector('meta[name="csrf-token"]')
                        .getAttribute("content"),
                },
                //Se envia como cuerpo de la solicitud el FormData con el archivo.
                body: formData,
            });

            //Si no hay respuesta se envia un error.
            if (!response.ok) {
                console.log(response.json);
                const data = await response.json();
                console.log(data);
                throw new Error(`${data.error}`);
            }
            
            reloadServicesView(this.getAttribute("data-url"));

        } catch (error) {
            console.error("Error:", error);
            showErrorMessage(error);
        }
    });
}

function showErrorMessage(message) {
    const modal = document.getElementById("errorModal");
    const errorMessageElement = modal.querySelector('p');

    //Sí existe el elemento para añadir el mensaje, le añadimos el mensaje.
    if (errorMessageElement) {
        errorMessageElement.textContent = message;
    }
    //Si el modal existe, se muestra al usuario.
    if (modal) {
        modal.classList.toggle("hidden");
    }

    //Se llama a la función para cerrar el modal.
    closeModal();
}

async function reloadServicesView(url) {
    const contentContainer = document.getElementById("content");

    try {
        const response = await fetch(url);

        if (!response.ok) {
            console.error("Error en la solicitud");
            throw new Error("Error en la solicitud");
        }
        const html = await response.text();
        contentContainer.innerHTML = html;
        signupHairdresser();
    } catch (error) {
        console.error("Error al cargar el contenido", error);
        contentContainer.innerText = "Error al cargar el contenido.";
    }
}