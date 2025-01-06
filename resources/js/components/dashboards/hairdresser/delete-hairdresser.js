"use strict";

import { closeModal } from "../../modals/close-modal";
import { reloadServicesView } from "../services-hair/services-manage";
import { reloadHairdresserView } from "./reload-select-hairdresser-view";


export function deleteHairdresser() {
    const deleteHairdresserForm = document.forms["fSelectHairdresser"];

    //Se envía las respuestas del formulario al servidor.
    deleteHairdresserForm.addEventListener("submit", async function (e) {
        e.preventDefault();

        //Creación del objeto FormData que se encargará de enviar el valor de los campos al servidor.
        const formData = new FormData(deleteHairdresserForm);

        //Obtenemos la url de la vista del formulario para realizar la recarga dinámica de la página una vez se ha eliminado la peluqueria.
        const urlReloadView = this.getAttribute('data-reload');

        try {
            //Se obtiene la url a la cuál se enviará el formulario.
            const url = this.getAttribute("data-delete_hairdresser");

            //Si no existe la url lo registramos en la consola para saber que existe el problema.
            if (!url) {
                console.error("La URL para insertar una peluquería en la base de datos no esta disponible.");
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
            showSuccessfulMessage(data.success,urlReloadView);
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
function showSuccessfulMessage(message,url) {
    const modal = document.getElementById("errorModal");
    const successMessageElement = modal.querySelector('p');
    const successTitleElement = modal.querySelector('h3');
    const errorButton = document.querySelector('.errorButton')

    //Sí existe el elemento para añadir el mensaje, le añadimos el mensaje.
    if (successMessageElement) {
        successMessageElement.textContent = message;
    }

    if(successTitleElement){
        successTitleElement.textContent = "¡Éxito!";
    }
    //Si el modal existe, se muestra al usuario.
    if (modal) {
        modal.classList.toggle("hidden");
    }

    errorButton.addEventListener('click', function(){
        reloadHairdresserView(url);
    })

    //Se llama a la función para cerrar el modal.
    closeModal();
}

