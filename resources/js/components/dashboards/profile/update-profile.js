"use strict";

import { closeModal } from "../../modals/close-modal";

export function updateProfile() {
    const profileForm = document.forms["fForm"];
    const spans = document.querySelectorAll(".validate-span");
    const welcomeMessage = document.getElementById("welcomeMessage")

    //Se envía las respuestas del formulario al servidor.
    profileForm.addEventListener("submit", async function (e) {
        e.preventDefault();

        //Creación del objeto FormData que se encargará de enviar el valor de los campos al servidor.
        const formData = new FormData(profileForm);


        try {
            //Se obtiene la url a la cuál se enviará el formulario.
            const url = this.getAttribute("data-form");

            //Si no existe la url lo registramos en la consola para saber que existe el problema.
            if (!url) {
                console.error("La URL para actualizar el perfil no está definida.");
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
                const data = await response.json();
                throw new Error(data.error);
            }

            const data = await response.json();

            //Se realiza la carga dinámica de los inputs para que aparezcan los nuevos datos introducidos en el formulario.
            if (data) {
                showSuccessfulMessage(data.success);
                spans.forEach((span) => {
                    span.textContent = "";
                });
                welcomeMessage.textContent = "Hola, " + data.username
            } else {
                showErrorMessage("Error al actualizar el perfil.");
            }
        } catch (error) {
            showErrorMessage(error);
        }
    });
}

function showErrorMessage(message) {
    const modal = document.getElementById("errorModal");
    const errorMessageElement = modal.querySelector('p');
    const errorModalTitle = document.getElementById('errorModalTitle');

    //Sí existe el elemento para añadir el mensaje, le añadimos el mensaje.
    if (errorMessageElement) {
        errorMessageElement.textContent = message;
    }

    if(errorModalTitle){
        errorModalTitle.textContent = "Error al envíar el formulario";
    }

    //Si el modal existe, se muestra al usuario.
    if (modal) {
        modal.classList.toggle("hidden");
    }

    //Se llama a la función para cerrar el modal.
    closeModal();
}
function showSuccessfulMessage(message) {
    const modal = document.getElementById("errorModal");
    const successMessageElement = modal.querySelector('p');
    const modalTitle = document.getElementById('errorModalTitle');

    //Sí existe el elemento para añadir el mensaje, le añadimos el mensaje.
    if (successMessageElement) {
        successMessageElement.textContent = message;
    }

    if (modalTitle) {
        modalTitle.textContent = "¡Éxito!";
    }
    //Si el modal existe, se muestra al usuario.
    if (modal) {
        modal.classList.toggle("hidden");
    }
    //Se llama a la función para cerrar el modal.
    closeModal();
}
