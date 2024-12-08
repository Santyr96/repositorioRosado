"use strict";
import { closeModal } from "../../modals/closeModal";

export function servicesManage() {
    const table = document.getElementById("tableServices");
    if (!table) {
        return;
    }
    createService();
    deleteService();
    updateService();
}

function createService() {
    const createForm = document.forms["createServicesForm"];
    const table = document.getElementById("tableServices");
    const trCrear = document.getElementById("crear");
    const inputs = trCrear.querySelectorAll("input");
    const textareas = trCrear.querySelector("textarea");
    console.log(trCrear);
    const urlView = table.getAttribute("data-url");
    //Se envía las respuestas del formulario al servidor.
    createForm.addEventListener("submit", async function (e) {
        e.preventDefault();

        //Creación del objeto FormData que se encargará de enviar el valor de los campos al servidor.
        const formData = new FormData();
        inputs.forEach((input) => {
            formData.append(input.name, input.value.trim());
        });
        formData.append(textareas.name, textareas.value);
        console.log(formData);

        //Se imprime en consola los valores de los campos del formulario, para saber que se envia.
        for (const [key, value] of formData.entries()) {
            console.log(`${key}:`, value);
        }

        try {
            //Se obtiene la url a la cuál se enviará el formulario.
            const url = this.getAttribute("data-form");

            //Si no existe la url lo registramos en la consola para saber que existe el problema.
            if (!url) {
                console.error(
                    "La URL para insertar un servicio en la base de datos no esta disponible."
                );
                showErrorMessage("Error interno. Intenta más tarde.");
            }

            //Se obtiene la respuesta asincrona utilizando await junto con fetch.
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

            //Si no hay respuesta se envia un error.
            if (!response.ok) {
                console.log(response.json);
                const data = await response.json();
                throw new Error(`Error en la solicitud: ${data.error}`);
            }
            const data = await response.json();
            console.log(data);
            reloadServicesView(urlView);
        } catch (error) {
            console.error("Error:", error);
            showErrorMessage(
                error.message ||
                    "Ocurrió un error al crear el servicio. Intentalo nuevamente."
            );
        }
    });
}

function deleteService() {
    const deleteForms = document.querySelectorAll(".deleteForm");
    const table = document.getElementById("tableServices");
    const urlView = table.getAttribute("data-url");
    deleteForms.forEach((deleteForm) => {
        deleteForm.addEventListener("submit", async function (e) {
            e.preventDefault();
            try {
                const url = this.getAttribute("data-form");
                if (!url) {
                    console.error(
                        "La URL para eliminar un servicio en la base de datos no esta disponible."
                    );
                    showErrorMessage("Error interno. Intenta más tarde.");
                }
                const response = await fetch(url, {
                    method: "POST",
                    headers: {
                        "X-CSRF-TOKEN": document
                            .querySelector('meta[name="csrf-token"]')
                            .getAttribute("content"),
                    },
                });
                if (!response.ok) {
                    const data = await response.json();
                    throw new Error(`Error en la solicitud: ${data.error}`);
                }
                const data = await response.json();
                console.log(data);
                reloadServicesView(urlView);
            } catch (error) {
                console.error("Error:", error);
                showErrorMessage(
                    error.message ||
                        "Ocurrió un error al eliminar el servicio. Intentalo nuevamente."
                );
            }
        });
    });
}

function updateService() {
    const updateForms = document.querySelectorAll(".updateForm");
    updateForms.forEach((updateForm) => {
        const trUpdate = updateForm.parentElement.parentElement;
        const inputs = trUpdate.querySelectorAll("input");
        const textareas = trUpdate.querySelector("textarea");
        updateForm.addEventListener("submit", async function (e) {
            e.preventDefault();
            //Creación del objeto FormData que se encargará de enviar el valor de los campos al servidor.
            const formData = new FormData();
            inputs.forEach((input) => {
                formData.append(input.name, input.value.trim());
            });
            formData.append(textareas.name, textareas.value);
            console.log(formData);

            //Se imprime en consola los valores de los campos del formulario, para saber que se envia.
            for (const [key, value] of formData.entries()) {
                console.log(`${key}:`, value);
            }
            try {
                const url = this.getAttribute("data-form");
                if (!url) {
                    console.error(
                        "La URL para actualizar un servicio en la base de datos no esta disponible."
                    );
                    showErrorMessage("Error interno. Intenta más tarde.");
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
                    throw new Error(`Error en la solicitud: ${data.error}`);
                }
                const data = await response.json();
                console.log(data);
                showSuccessfulMessage(data.success);
            } catch (error) {
                console.error("Error:", error);
                showErrorMessage(
                    error.message ||
                        "Ocurrió un error al actualizar el servicio. Intentalo nuevamente."
                )
            }
        });
    });
}

function showSuccessfulMessage(message) {
    const modal = document.getElementById("errorModal");
    const successMessageElement = modal.querySelector("p");
    const successTitleElement = modal.querySelector("h3");

    //Sí existe el elemento para añadir el mensaje, le añadimos el mensaje.
    if (successMessageElement) {
        successMessageElement.textContent = message;
    }

    if (successTitleElement) {
        successTitleElement.textContent = "¡Éxito!";
    }
    //Si el modal existe, se muestra al usuario.
    if (modal) {
        modal.classList.toggle("hidden");
    }
    //Se llama a la función para cerrar el modal.
    closeModal();
}

function showErrorMessage(message) {
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

async function reloadServicesView(url) {
    const contentContainer = document.getElementById("content");

    try {
        const response = await fetch(url);

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
