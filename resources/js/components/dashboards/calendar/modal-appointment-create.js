"use strict";
import { renderCalendar, showErrorMessage } from "./show-calendar";
import { DateTime } from "luxon";

const closeModalListeners = new WeakMap();

//Función que maneja la creación de una cita
export function modalAppointmentCreate(info, calendar) {
    //Obtenemos los elementos del DOM necesarios.
    const form = document.forms["fCreateAppointment"];
    const modal = document.getElementById("createModal");
    let isSubmitting = false;
    const selectedTime = info.date;
    const createButton = document.getElementById("createButton");
    const inputFakeStart = document.getElementById("fakeStart");
    const inputFakeEnd = document.getElementById("fakeEnd");
    const madridTime =
        DateTime.fromJSDate(selectedTime).setZone("Europe/Madrid");
    const start = madridTime.toISO();
    const startFormatted = madridTime.toFormat("dd/MM/yyyy HH:mm");
    const endTime = madridTime.plus({ hours: 1 });
    const end = endTime.toISO();
    const startInput = form["start"];
    const endInput = form["end"];
    endInput.value = end;
    startInput.value = start;
    const endFormatted = endTime.toFormat("dd/MM/yyyy HH:mm");
    const addInputClient = document.getElementById("addInputClient");
    const selectClient = document.getElementById("selectClient");

    inputFakeStart.value = startFormatted;
    inputFakeEnd.value = endFormatted;

    //Si el modal no ha sido inicializado, lo inicializamos.Esto asegura que los listeners no se dupliquen.
    if (!modal.classList.contains("modal-initialized")) {
        modal.classList.add("modal-initialized");
        createButton.addEventListener("click", handleCreate);
        if (addInputClient) {
            addInputClient.addEventListener("click", handleAddInputAddClient);
        }

        //Inicializamos los listeners para cerrar el modal.
        initializeCloseModalListeners(modal);
    }

    //Función que maneja la adición de un input para un cliente no registrado.
    function handleAddInputAddClient() {
        //Si el input ya existe, lo eliminamos y habilitamos el select.
        const existInputAddClient = document.getElementById("inputAddClient");
        if (existInputAddClient) {
            selectClient.removeAttribute("disabled");
            existInputAddClient.remove();
            return;
            //Si no existe, lo creamos y deshabilitamos el select.
        } else {
            selectClient.setAttribute("disabled", "disabled");
            const inputAddClient = document.createElement("input");
            inputAddClient.setAttribute("id", "inputAddClient");
            inputAddClient.setAttribute("type", "text");
            inputAddClient.setAttribute("name", "unregistered_client");
            inputAddClient.setAttribute("placeholder", "Cliente no registrado");
            addInputClient.insertAdjacentElement("afterend", inputAddClient);
        }
    }

    //Función que inicializa los listeners para cerrar el modal.
    function initializeCloseModalListeners(modal) {
        let closeButtons = modal.querySelectorAll("[data-modal-hide]");
        closeButtons.forEach((button) => {
            const previousListener = closeModalListeners.get(button);
            if (previousListener) {
                button.removeEventListener("click", previousListener);
            }
            const newListener = () => {
                const inputAddClient =
                    document.getElementById("inputAddClient");
                if (selectClient) {
                    if (selectClient.hasAttribute("disabled")) {
                        selectClient.removeAttribute("disabled");
                    }
                }
                if (inputAddClient) {
                    inputAddClient.remove();
                }
                modal.classList.add("hidden");
            };
            button.addEventListener("click", newListener);
            closeModalListeners.set(button, newListener);
        });
    }

    //Función que maneja la creación de la cita.
    async function handleCreate() {
        //Si ya se está enviando la información, no hacemos nada. Esto evita que se envíen múltiples solicitudes.
        if (isSubmitting) return;
        isSubmitting = true;

        //Obtenemos los datos del formulario y la URL a la que se enviarán.
        const formData = new FormData(form);
        const url = form.getAttribute("data-create");

        try {
            //Enviamos la información al servidor.
            const response = await fetch(url, {
                method: "POST",
                headers: {
                    "X-CSRF-TOKEN": document
                        .querySelector('meta[name="csrf-token"]')
                        .getAttribute("content"),
                },
                body: formData,
            });

            //Si la respuesta no es exitosa, mostramos un mensaje de error.
            if (!response.ok) {
                const data = await response.json();
                throw new Error(data.error || "Error desconocido");
            }
            //Si la respuesta es exitosa, recargamos los eventos del calendario y cerramos el modal.
            //Se limpia el formulario
            const inputAddClient = document.getElementById("inputAddClient");
            //Se eliminan los inputs de cliente no registrado y se habilita el select.
            if (inputAddClient) {
                inputAddClient.remove();
            }
            if (selectClient) {
                if (selectClient.hasAttribute("disabled")) {
                    selectClient.removeAttribute("disabled");
                }
            }
            modal.classList.add("hidden");
            if (calendar) calendar.refetchEvents();
        } catch (error) {
            //Si hay un error, lo mostramos en consola y en un mensaje de error.
            console.error(error);
            modal.classList.add("hidden");
            //Se vuelve a establecer el valor de isSubmitting a false.
            isSubmitting = false;
            //Mostramos un mensaje de error.
            showErrorMessage(error);
        } finally {
            isSubmitting = false;
        }
    }

    //Mostramos el modal.
    if (modal.classList.contains("hidden")) {
        modal.classList.remove("hidden");
    }
}
