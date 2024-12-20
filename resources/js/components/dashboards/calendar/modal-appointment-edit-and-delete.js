"use strict";
import { showErrorMessage } from "./show-calendar";
import { DateTime } from "luxon";
const closeModalListeners = new WeakMap();

export function modalAppointmentEditAndDelete(info, calendar) {
    const event = info.event;
    const client = document.getElementById("client");
    const statusP = document.getElementById("statusSelect");
    const date = document.getElementById("date");
    const form = document.forms["fAppointment"];
    const modal = document.getElementById("editAndDeleteModal");
    const modalTitle = document.getElementById("title");
    const modalMessage = document.getElementById("messages");
    const inputStart = form["start"];
    const selectService = form["service"];
    const inputAppointmentId = form["id_appointment"];
    const updateButton = document.getElementById("updateButton");
    const deleteButton = document.getElementById("deleteButton");
    let isSubmitting = false;


    if (!modal.classList.contains("modal-initialized")) {
        modal.classList.add("modal-initialized");
    
    setupModal(
        event,
        modalTitle,
        modalMessage,
        selectService,
        inputAppointmentId,
        client,
        statusP,
        date,
        inputStart
    );

    updateButton.addEventListener("click", handleUpdateClick);
    deleteButton.addEventListener("click", handleDeleteClick);

    async function handleUpdateClick(e) {
        e.preventDefault();
    
        if (isSubmitting) return;
        isSubmitting = true;
    
        toggleSubmitButtons(true);
    
        try {
            const formData = new FormData(form);
            const { start, end } = prepareFormData(inputStart, formData);
    
            await handleEdit(formData, form);
    
            closeModal(modal);
            calendar?.refetchEvents();
        } catch (error) {
            console.error("Error al cargar el contenido", error);
            closeModal(modal);
            showErrorMessage(error.message);
        } finally {
            isSubmitting = false;
            toggleSubmitButtons(false);
        }
    }

  
        async function handleDeleteClick (e) {
            e.preventDefault();

            if (isSubmitting) return;
            isSubmitting = true;

            toggleSubmitButtons(true);

            try {
                const formData = new FormData(form);
                await handleDelete(formData, form, calendar);
                closeModal(modal);
            } catch (error) {
                console.error("Error al eliminar la cita", error);
                closeModal(modal);
                showErrorMessage(error);
            } finally {
                isSubmitting = false;
                toggleSubmitButtons(false);
            }
        }

    

    const closeButtons = modal.querySelectorAll("[data-modal-hide]");
    closeButtons.forEach((button) => {
        const previousListener = closeModalListeners.get(button);
        if (previousListener) {
            button.removeEventListener("click", previousListener);
        }
        const newListener = () => closeModal(modal);
        button.addEventListener("click", newListener);
        closeModalListeners.set(button, newListener);
    });

    }

    openModal(modal);

    
    function setupModal(
        event,
        modalTitle,
        modalMessage,
        selectService,
        inputAppointmentId,
        client,
        status,
        date,
        start
    ) {
        const startDateTime = DateTime.fromJSDate(event.start);
        const endDateTime = DateTime.fromJSDate(event.end);
        modalTitle.textContent = "Editar cita";
        modalMessage.textContent = "¿Quieres editar la cita?";
        selectService.value = event.extendedProps.service_id;
        inputAppointmentId.value = event.extendedProps.appointment_id;
        client.value = event.extendedProps.client_name ? event.extendedProps.client_name : event.extendedProps.unregistered_client;
        status.value = event.extendedProps.status;
        date.value =
            startDateTime.toFormat("dd/MM/yyyy HH:mm") +
            " - " +
            endDateTime.toFormat("dd/MM/yyyy HH:mm");
        start.value = startDateTime.toFormat("yyyy-MM-dd'T'HH:mm:ss");
    }

    function prepareFormData(inputStart, formData) {
        const start = inputStart.value
            ? DateTime.fromISO(inputStart.value)
            : null;
        let end = null;

        if (start) {
            end = start.plus({ hours: 1 });
            formData.append("start", start.toFormat("yyyy-MM-dd'T'HH:mm:ss"));
            formData.append("end", end.toFormat("yyyy-MM-dd'T'HH:mm:ss"));
        }

        return { start, end };
    }

    function toggleSubmitButtons(disabled) {
        const submitsButton = document.querySelectorAll(
            "button[type='submit']"
        );
        submitsButton.forEach((button) => {
            button.disabled = disabled;
        });
    }

   
    function openModal(modal) {
        if (modal.classList.contains("hidden")) {
            modal.classList.remove("hidden");
        }
    }

    
    function closeModal(modal) {
        modal.classList.add("hidden");
    }

    
    async function handleDelete(formData, form, calendar) {
        const modalDeleteWarning = document.getElementById("deleteWarning");
        const confirmationButton = document.getElementById("confirmation");

        const closeButtons =
            modalDeleteWarning.querySelectorAll("[data-modal-hide]");
        closeButtons.forEach(
            (button) =>
                button.addEventListener("click", () =>
                    closeModal(modalDeleteWarning)
                ),
            { once: true }
        );

        
        openModal(modalDeleteWarning);

        confirmationButton.addEventListener("click", async function () {
            closeModal(modalDeleteWarning);

            const url = form.getAttribute("data-delete");
            try {
                await sendRequest(url, formData);
                calendar?.refetchEvents();
            } catch (error) {
                throw new Error(error);
            }
        }),
            { once: true };
    }


    async function handleEdit(formData, form) {
        const url = form.getAttribute("data-update");

        console.log("Enviando los datos al servidor para editar...");
        try {
            await sendRequest(url, formData);
        } catch (error) {
            console.error("Error al editar la cita:", error);
            throw new Error(error);
        }
    }

   
    async function sendRequest(url, formData) {
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
            throw new Error(`${data.error}`);
        }
        console.log("Operación exitosa.");
    }
}
