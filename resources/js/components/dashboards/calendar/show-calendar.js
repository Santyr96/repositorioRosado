"use strict";

import { closeModal } from "../../modals/closeModal";
import { Calendar } from "@fullcalendar/core";
import esLocale from "@fullcalendar/core/locales/es";
import { modalAppointmentEdit } from "./modal-appointment";
import { info } from "autoprefixer";

export function showCalendar() {
    const contentContainer = document.getElementById("content");
    const signUpForm = document.forms["fSelectSignUpForm"];
    signUpForm.addEventListener("submit", async function (event) {
        event.preventDefault();
        const url = this.getAttribute("data-form");
        console.log(url);
        const formData = new FormData(this);
        //Se imprime en consola los valores de los campos del formulario, para saber que se envia.
        for (const [key, value] of formData.entries()) {
            console.log(`${key}:`, value);
        }
        try {
            if (!formData.has('hairdresser_id') || formData.get('hairdresser_id') === '') {
                throw new Error("No se ha seleccionado ninguna peluquería");
            }
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
            renderCalendar(formData, this.getAttribute("data-calendar"));
        } catch (error) {
            console.error("Error al cargar el contenido", error);
            showErrorMessage(error);
        }
    });

   
}

export function renderCalendar(formData, url) {
    var calendarEl = document.getElementById("calendar");
    calendarEl.replaceChildren();

    var calendarHeight = calendarEl.offsetHeight;

    var initialViews = "timeGridDay";
    if (calendarHeight >= 640) {
        initialViews = "timeGridDay,timeGridWeek,dayGridMonth";
    }
    var calendar = new FullCalendar.Calendar(calendarEl, {
        initialView: "timeGridDay",
        events: async function (
            fetchInfo,
            successCallback,
            failureCallback
        ) {
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
                    const data = await response.json();
                    throw new Error(`${data.error}`);
                }
                const data = await response.json();
                successCallback(data);
            } catch (error) {
                console.error("Error al cargar los eventos", error);
                failureCallback(error);
            }
        },
        eventClick: function(info) { 
            modalAppointmentEdit(info);
        },
        aspectRatio: 1,
        headerToolbar: {
            left: "title",
        },
        footerToolbar: {
            center: initialViews,
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
            Semana: {
                type: "timeGrid",
                duration: { days: 3 },
            },
        },
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
