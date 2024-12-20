"use strict";
import { renderCalendar, showErrorMessage } from "./show-calendar";
import { DateTime } from "luxon";

const closeModalListeners = new WeakMap();

export function modalAppointmentCreate(info, calendar) {
    const form = document.forms["fCreateAppointment"];
    const modal = document.getElementById("createModal");
    let isSubmitting = false;
    const selectedTime = info.date;
    const createButton = document.getElementById("createButton");
    const inputFakeStart = document.getElementById("fakeStart");
    const inputFakeEnd = document.getElementById("fakeEnd");
    const submitButton = form.querySelector("button[type='submit']");
    const madridTime =
        DateTime.fromJSDate(selectedTime).setZone("Europe/Madrid");
    const start = madridTime.toISO();
    const startFormatted = madridTime.toFormat("dd/MM/yyyy HH:mm");
    const endTime = madridTime.plus({ hours: 1 });
    const end = endTime.toISO();
    const endFormatted = endTime.toFormat("dd/MM/yyyy HH:mm");
    const addInputClient = document.getElementById("addInputClient");
    const selectClient = document.getElementById("selectClient");
    

    inputFakeStart.value = startFormatted;
    inputFakeEnd.value = endFormatted;

    if (!modal.classList.contains("modal-initialized")) {
        modal.classList.add("modal-initialized");

        createButton.addEventListener("click", handleCreate);
        addInputClient.addEventListener("click", handleAddInputAddClient);

        function handleAddInputAddClient() {
            const existInputAddClient = document.getElementById("inputAddClient");
            if (existInputAddClient) {
                selectClient.removeAttribute("disabled");
                existInputAddClient.remove();
                return;
            } else{
            selectClient.setAttribute("disabled", "disabled");
            const inputAddClient = document.createElement("input");
            inputAddClient.setAttribute("id", "inputAddClient");
            inputAddClient.setAttribute("type", "text");
            inputAddClient.setAttribute("name", "unregistered_client");
            inputAddClient.setAttribute("placeholder", "Cliente no registrado");
            addInputClient.insertAdjacentElement("afterend", inputAddClient);
            }
        }

        async function handleCreate(e) {
            e.preventDefault();
            if (isSubmitting) return;
            console.log("submit triggered");
            isSubmitting = true;

            const formData = new FormData(form);
            const url = form.getAttribute("data-create");

            formData.delete("startf");
            formData.delete("endf");
            formData.append("start", start);
            formData.append("end", end);

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
                    console.error(data);
                    throw new Error(data.error || "Error desconocido");
                }
                const inputAddClient = document.getElementById("inputAddClient");
                if (inputAddClient) {
                    inputAddClient.remove();
                }
                if(selectClient.hasAttribute("disabled")){
                    selectClient.removeAttribute("disabled");
                }
                modal.classList.add("hidden");

                if (calendar) calendar.refetchEvents();
            } catch (error) {
                console.error(error);
                modal.classList.add("hidden");
                isSubmitting = false;
                showErrorMessage(error);
            } finally {
                isSubmitting = false;
            }
        }

        let closeButtons = modal.querySelectorAll("[data-modal-hide]");

        closeButtons.forEach((button) => {
            const previousListener = closeModalListeners.get(button);
            if (previousListener) {
                button.removeEventListener("click", previousListener);
            }
            const newListener = () => {
                const inputAddClient = document.getElementById("inputAddClient");
                if(selectClient.hasAttribute("disabled")){
                    selectClient.removeAttribute("disabled");
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

    if (modal.classList.contains("hidden")) {
        modal.classList.remove("hidden");
    }
}
