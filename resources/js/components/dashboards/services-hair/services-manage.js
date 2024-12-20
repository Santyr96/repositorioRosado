"use strict";
import { closeModal } from "../../modals/closeModal";
import { createService } from "./create-service";
import { deleteService } from "./delete-service";
import { updateService } from "./update-service";

let globalHairdresserId;

export function showServices() {
    const contentContainer = document.getElementById("content");
    const selectHairdresser = document.forms["fSelectHairdresserServices"];
    selectHairdresser.addEventListener("submit", async function (event) {
        event.preventDefault();
        const url = this.getAttribute("data-form");
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

 function servicesManage() {
    const urlView = document.getElementById("serviceTable").getAttribute("data-url");
    createService(urlView);
    deleteService(urlView);
    updateService(urlView);
}

export function showErrorMessage(message) {
    const modal = document.getElementById("errorModal");
    const errorMessageElement = modal.querySelector("p");
    const errorTitleElement = modal.querySelector("h3");

    //Sí existe el elemento para añadir el mensaje, le añadimos el mensaje.
    if (errorTitleElement) {
        errorTitleElement.textContent = "Error al actualizar el formulario";
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
