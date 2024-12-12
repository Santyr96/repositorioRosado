import { renderCalendar, showErrorMessage } from "./show-calendar";

export async function modalAppointmentEdit(info) {
    const event = info.event;
    const form = document.forms["fAppointment"];
    const modal = document.getElementById("modal");
    const modalTitle = document.getElementById("title");
    const modalMessage = document.getElementById("message");
    const inputStart = form["start"];
    const inputEnd = form["end"];
    const selectService = form["service"];
    const inputAppointmentId = form["id_appointment"];
    const urlCalendar = form.getAttribute("data-calendar");

    modalTitle.textContent = "Editar cita";
    modalMessage.textContent = "¿Quieres editar la cita?";

    inputStart.value = event.start.toISOString();
    inputEnd.value = event.end ? event.end.toISOString() : "";
    selectService.value = event.extendedProps.service_id;
    inputAppointmentId.value = event.extendedProps.appointment_id;

    //Añadimos un listener al formulario.
    form.addEventListener("submit", async function (event) {
        try {
            event.preventDefault();
            const formData = new FormData(this);
            //Se imprime en consola los valores de los campos del formulario, para saber que se envia.
            for (const [key, value] of formData.entries()) {
                console.log(`${key}:`, value);
            }
            let url = changeUrl(event);
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
            renderCalendar(formData,urlCalendar);
        } catch (error) {
            console.error("Error al cargar el contenido", error);
            modal.classList.add("hidden");
            showErrorMessage(error);
        }
    });

    if (modal.classList.contains("hidden")) {
        modal.classList.remove("hidden");
    }

    let closeButtons = modal.querySelectorAll("[data-modal-hide]");
    closeButtons.forEach((button) => {
        button.addEventListener("click", () => {
            modal.classList.add("hidden");
        });
    });
}

//Función que se encarga de cambiar entre la url de delete y update.
function changeUrl(event) {
    const form = document.forms["fAppointment"];
    let url = "";
    let submitter = event.submitter;
    if (submitter) {
        if (submitter.id === "deleteButton") {
            url = form.getAttribute("data-delete");
        } else if (submitter.id === "updateButton") {
            url = form.getAttribute("data-update");
        }
        return url;
    }

    deleteButton.addEventListener("click", function () {
        url = form.getAttribute("data-delete");
    });

    updateButton.addEventListener("click", function () {
        url = form.getAttribute("data-update");
    });

    return url;
}
