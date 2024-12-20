"use strict";

import { closeModal } from "../../modals/closeModal";
import { Calendar } from "@fullcalendar/core";
import esLocale from "@fullcalendar/core/locales/es";
import { modalAppointmentEditAndDelete } from "./modal-appointment-edit-and-delete";
import luxonPlugin from "@fullcalendar/luxon";
import { info } from "autoprefixer";
import { modalAppointmentCreate } from "./modal-appointment-create";

let globalHairdresserId;

export function showCalendar() {
    const contentContainer = document.getElementById("content");
    const signUpForm = document.forms["fSelectSignUpForm"];
    signUpForm.addEventListener("submit", async function (event) {
        event.preventDefault();
        const url = this.getAttribute("data-form");
        const formData = new FormData(this);
        for (const [key, value] of formData.entries()) {
            console.log(`${key}:`, value);
        }
        try {
            if (
                !formData.has("hairdresser_id") ||
                formData.get("hairdresser_id") === ""
            ) {
                throw new Error("No se ha seleccionado ninguna peluquería");
            }

            globalHairdresserId = formData.get("hairdresser_id");
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
            if (!response.ok) {
                const data = await response.json();
                console.log(data);
                throw new Error(`${data.error}`);
            }
            const html = await response.text();
            contentContainer.innerHTML = html;
            renderCalendar();
            
        } catch (error) {
            console.error("Error al cargar el contenido", error);
            showErrorMessage(error);
        }
    });
}

export function renderCalendar(f) {
    console.log("http://hairbooker/dashboard/calendar/appointments/"  + globalHairdresserId);
    const eventSourceConfig = {
        url: "http://hairbooker/dashboard/calendar/appointments/" + globalHairdresserId,
        method: "GET",
        extraParams: function () {
            return {
                _token: document
                    .querySelector('meta[name="csrf-token"]')
                    .getAttribute("content"),
            };
        },
        failure: function (error) {
            console.error("Error al cargar los eventos", error);
        },
    };
    var calendarEl = document.getElementById("calendar");

    var calendarHeight = calendarEl.offsetHeight;

    var initialView = "timeGridDay";
    
    var calendar = new FullCalendar.Calendar(calendarEl, {
        initialView: initialView,
        plugins: [luxonPlugin],
        timeZone: "Europe/Madrid",
        eventSources: [eventSourceConfig],
        loading: function (isLoading) {
            if (isLoading) {
                console.log("Cargando eventos...");
            } else {
                console.log("Eventos cargados.");
            }
        },
        eventClick: function (info) {
            //Si el evento pertenece al usuario, se muestra el modal de edición y de eliminación.
            if (info.event.extendedProps.edit) {
                modalAppointmentEditAndDelete(info, calendar);
            }
        },
        dateClick: function (info) {
            modalAppointmentCreate(info, calendar);
        },
        aspectRatio: 1,
        headerToolbar: {
            left: "title",
        },
        footerToolbar: {
            center: initialView,
        },
        dayHeaderFormat: {
            weekday: "short",
            day: "numeric",
        },
        slotLabelFormat: {
            hour: "2-digit",
            minute: "2-digit",
        },
        views: {
            semana: {
                type: "timeGrid",
                duration: { days: 3 },
            },
        },
        slotMinTime: "08:00:00",
        slotMaxTime: "23:00:00",
        minTime: "08:00:00",
        maxTime: "23:00:00",
        allDaySlot: false,
        locale: esLocale,
    });

    calendar.render();
}



export function showErrorMessage(message) {
    const modal = document.getElementById("errorModal");
    const errorMessageElement = modal.querySelector("p");

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
