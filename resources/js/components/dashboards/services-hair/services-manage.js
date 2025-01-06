"use strict";
import { closeModal } from "../../modals/close-modal";
import { createService } from "./create-service";
import { deleteService } from "./delete-service";
import { updateService } from "./update-service";

//Variable global para almacenar el id de la peluquería seleccionada.
let globalHairdresserId;

//Función para mostrar los servicios de un peluquero.
export function showServices() {
    //Se obtiene el contenedor donde se mostrará el contenido.
    const contentContainer = document.getElementById("content");
    const selectHairdresser = document.forms["fSelectHairdresser"];
    selectHairdresser.addEventListener("submit", async function (event) {
        event.preventDefault();
        const url = this.getAttribute("data-select_services");
        try {
            const formData = new FormData(this);
            globalHairdresserId = formData.get("hairdresser_id");
            if (
                !formData.has("hairdresser_id") ||
                formData.get("hairdresser_id") === ""
            ) {
                throw new Error("No se ha seleccionado ninguna peluquería");
            }

            const response = await fetch(url, {
                method: "POST",
                headers: {
                    
                    "X-CSRF-TOKEN": document
                        .querySelector('meta[name="csrf-token"]')
                        .getAttribute("content"),
                },
                body: formData,
            });

            if (!response.ok) {
                const data = await response.json();
                console.log(data);
                throw new Error(`${data.error}`);
            }
            const html = await response.text();
            contentContainer.innerHTML = html;
            servicesManage();
        } catch (error) {
            console.error("Error al cargar el contenido", error);
            showErrorMessage(error);
        }
    });
}

//Función para gestionar los servicios.
 function servicesManage() {
    const urlView = document.getElementById("serviceTable").getAttribute("data-url");
    createService(urlView);
    deleteService(urlView);
    updateService(urlView);
}

//Función para mostrar un mensaje de error.
export function showErrorMessage(message,title) {
    const modal = document.getElementById("errorModal");
    const errorMessageElement = modal.querySelector("p");
    const errorTitleElement = modal.querySelector("h3");

    //Sí existe el elemento para añadir el mensaje, le añadimos el mensaje.
    if (errorTitleElement) {
        errorTitleElement.textContent = title;
    }

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

//Función para recargar la vista de servicios.
export async function reloadServicesView(url) {
    const contentContainer = document.getElementById("content");
    const formData = new FormData();
    formData.append("hairdresser_id", globalHairdresserId);
    try {
        const response = await fetch(url, {
            method: "POST",
            headers: {
                "X-CSRF-TOKEN": document
                    .querySelector('meta[name="csrf-token"]')
                    .getAttribute("content"),
            },
            body: formData,
        });

        if (!response.ok) {
            console.error("Error en la solicitud");
            throw new Error("Error en la solicitud");
        }
        const html = await response.text();
        contentContainer.innerHTML = html;
        servicesManage();
    } catch (error) {
        console.error("Error al cargar el contenido", error);
        contentContainer.innerText = "Error al cargar el contenido.";
    }
}
