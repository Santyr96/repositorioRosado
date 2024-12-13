import { renderCalendar, showErrorMessage } from "./show-calendar";

export function modalAppointmentCreate(info,calendar) {
    const form = document.forms["fCreateAppointment"];
    const modal = document.getElementById("createModal");
    const urlCalendar = form.getAttribute("data-calendar");
    const selectedTime = info.date;
    const inputStart = document.getElementById("start");
    const inputFakeStart = document.getElementById("fakeStart");
    const inputFakeEnd = document.getElementById("fakeEnd");
    const inputEnd = document.getElementById("end");

    //Se convierte  la fecha de inicio a formato válido para el input de nuestro formulario -> datetime-local.
    const start = selectedTime.toISOString();
    console.log(start);

    //Formateamos la fecha de inicio para mostrarla en el input de nuestro formulario.
    const startFormatted = selectedTime.toLocaleString("es-ES", {
        day: "2-digit",
        month: "2-digit",
        year: "numeric",
        hour: "2-digit",
        minute: "2-digit",
        hour12: false,
    });

    //Formateamos de la misma manera la fecha de fin.
    const endFormatted = new Date(
        selectedTime.getTime() + 60 * 60 * 1000
    ).toLocaleString("es-ES", {
        day: "2-digit",
        month: "2-digit",
        year: "numeric",
        hour: "2-digit",
        minute: "2-digit",
        hour12: false,
    });

    //Asignamos las fechas formateadas formateada al input de nuestro formulario.
    inputFakeStart.value = startFormatted;
    inputFakeEnd.value = endFormatted;


    //Establecemos el valor del input de fecha de fin de nuestro formulario sumandole una hora al valor de start.
    const end = new Date(selectedTime.getTime() + 60 * 60 * 1000)
        .toISOString();


    //Añadimos un listener al formulario.
    form.addEventListener("submit", async function (event) {
        event.preventDefault()

        const formData = new FormData(this);

        //Eliminamos los inputs fake.
        formData.delete("startf");
        formData.delete("endf");
        formData.append("start", start);
        formData.append("end", end);

        for (const [key, value] of formData.entries()) {
            console.log(`${key}:`, value);
        }

        let url = form.getAttribute("data-create");

        try{

         const response = await fetch(url, {
            method: "POST",
            headers: {
                "X-CSRF-TOKEN": document
                    .querySelector('meta[name="csrf-token"]')
                    .getAttribute("content"),
            },
            body: formData,
        })
        
        if (!response.ok) {
            console.log(response.json);
            throw new Error(`Error en la solicitud: ${response.status}`);
        }

        if (calendar) {
            calendar.refetchEvents();
        } else {
            console.error("No se encontró la instancia del calendario");
        }


    } catch (error) {
        console.error("Error al cargar el contenido", error);
        modal.classList.add("hidden");
        showErrorMessage(error);
    } 

    

    },
    {once: true});

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
