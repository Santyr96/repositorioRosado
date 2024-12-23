"use strict";
import { showErrorMessage } from "./show-calendar";
import { DateTime } from "luxon";
const closeModalListeners = new WeakMap();

//Función que maneja la edición y eliminación de una cita
export function modalAppointmentEditAndDelete(info, calendar) {
    //Obtenemos los elementos del DOM necesarios.
    const calendarVar = calendar;
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


    //Si el modal no ha sido inicializado, lo inicializamos. Esto asegura que los listeners no se dupliquen.
    if (!modal.classList.contains("modal-initialized")) {
        modal.classList.add("modal-initialized");
    
    //Agregamos los listeners para los botones de editar y eliminar.
    updateButton.addEventListener("click", handleUpdateClick);
    deleteButton.addEventListener("click", handleDeleteClick);

    //Función que maneja el evento de click en el botón de editar.
    async function handleUpdateClick(e) {
        e.preventDefault();
    
        //Se establece un bloqueo para evitar múltiples envíos del formulario.
        if (isSubmitting) return;
        isSubmitting = true;
    
        //Se deshabilitan los botones de submit.
        toggleSubmitButtons(true);
    
        try {
            //Se obtiene la información del formulario y se prepara para ser enviada.
            const formData = new FormData(form);
            //Se obtiene la fecha de inicio y fin de la cita y se transforma a un formato adecuado.
            const { start, end } = prepareFormData(inputStart, formData);
    
            //Se envía la petición al servidor para editar la cita.
            await handleEdit(formData, form);
    
            //Se actualiza el calendario.
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

  
    //Función que maneja el evento de click en el botón de eliminar.
        async function handleDeleteClick (e) {
            e.preventDefault();

            if (isSubmitting) return;
            isSubmitting = true;

            toggleSubmitButtons(true);

            try {
                handleDelete();
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

    

    //Función que maneja el evento de click en el botón de confirmación de la eliminación.
     function handleDelete() {
        //Se obtiene los elementos del DOM necesarios.
        const modalDeleteWarning = document.getElementById("deleteWarning");
        const confirmationButton = document.getElementById("confirmation");
        //Se muestra el modal de confirmación de eliminación.
        openModal(modalDeleteWarning);

        //Si el modal no ha sido inicializado, lo inicializamos. Esto asegura que los listeners no se dupliquen.
        if(!modalDeleteWarning.classList.contains("modal-initialized")) {
            modalDeleteWarning.classList.add("modal-initialized");
            const closeButtons =
            modalDeleteWarning.querySelectorAll("[data-modal-hide]");
        closeButtons.forEach(
            (button) =>
                button.addEventListener("click", () =>
                    closeModal(modalDeleteWarning)
                )
        );
        //Agregamos el listener para el botón de confirmación de eliminación.
            confirmationButton.addEventListener("click", () =>
                handleDeleteConfirmation()
            );
        }

       
    }
    }

    //Función que maneja la apertura del modal.
    openModal(modal);
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

    //Función que maneja la confirmación de la eliminación de la cita.	
    async function handleDeleteConfirmation() {
        const url = form.getAttribute("data-delete");
        const formData = new FormData(form);
        try {
            await sendRequest(url, formData);
            calendarVar?.refetchEvents();
        } catch (error) {
            throw new Error(error);
        }
    }

    //Función que muestra los datos de la cita a editar en el modal.
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
        if(status){
            status.value = event.extendedProps.status;
        }
        date.value =
            startDateTime.toFormat("dd/MM/yyyy HH:mm") +
            " - " +
            endDateTime.toFormat("dd/MM/yyyy HH:mm");
        start.value = startDateTime.toFormat("yyyy-MM-dd'T'HH:mm:ss");
    }

    //Función que transforma la fecha de inicio y fin de la cita a un formato adecuado para ser enviada.
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

    //Funciónm que se encarga de deshabilitar o habilitar los botones de submit.
    function toggleSubmitButtons(disabled) {
        const submitsButton = document.querySelectorAll(
            "button[type='submit']"
        );
        submitsButton.forEach((button) => {
            button.disabled = disabled;
        });
    }

   //Función que abre un modal.
    function openModal(modal) {
        if (modal.classList.contains("hidden")) {
            modal.classList.remove("hidden");
        }
    }

    //Función que cierra un modal.
    function closeModal(modal) {
        modal.classList.add("hidden");
    }

    
  
    //Función que maneja la petición al servidor para editar la cita.
    async function handleEdit(formData, form) {
        const url = form.getAttribute("data-update");
        try {
            await sendRequest(url, formData);
        } catch (error) {
            console.error("Error al editar la cita:", error);
            throw new Error(error);
        }
    }

   //Función que maneja el envío de la petición al servidor.
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

    }
}
