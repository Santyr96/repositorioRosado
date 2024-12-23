"use strict";

 export function updateAvatar() {
    const modal = document.getElementById("modal");
    const openModal = document.getElementById("avatarUpload");
    const buttonsCloseModal = document.querySelectorAll("[data-modal-hide]");
    const formAvatar = document.forms["avatarForm"];
    const inputFile = formAvatar["avatar"];

    // Abrimos el modal.
    if (openModal) {
        openModal.addEventListener("click", function () {
            modal.classList.remove("hidden");
        });
    }

    // Cerramos el modal.
    if (buttonsCloseModal) {
        buttonsCloseModal.forEach((button) => {
            button.addEventListener("click", function () {
                modal.classList.add("hidden");
                inputFile.value = "";
            });
        });
    }

    // Enviamos la imagen al servidor.
    if (formAvatar && inputFile) {
        //Utilizamos una función asíncrona combinando async/await con fetch/
        formAvatar.addEventListener("submit", async function (e) {
            e.preventDefault();

            //Obtenemos el archivo cargado en el input files.
            const file = inputFile.files[0];

            //Si no existe el archivo, se envía un mensaje de alerta al usuario.
            if (!file) {
                alert("Por favor, selecciona un archivo.");
            }

            //Creación de objeto formData para enviar el archivo al servidor.
            const formData = new FormData();
            formData.append("avatar", file);

            try {
                //Obtenemos la url a la que se enviará la solicitud del formulario, en este caso al controlador del Dashboard.
                const url = this.getAttribute("data-avatar");

                //Si no existe, se informa del error.
                if (!url) {
                    console.error("La URL para subir el avatar no está definida.");
                    alert("Error interno. Intenta más tarde.")
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
                    throw new Error(`Error en la solicitud: ${response.status}`);
                }

                const data = await response.json();

                //Se realiza la carga dinámica de la imagen del avatar sin recargar la página.
                if (data.avatar_url) {
                    const avatarElement = document.getElementById("avatar");
                    const avatarHeaderElement = document.getElementById("headerAvatar");
                    if (avatarElement) {
                        avatarElement.src = data.avatar_url;
                        avatarHeaderElement.src = data.avatar_url;
                    }
                    
                    //Se cierra el modal una vez cargada la imagen para el avatar del usuario.
                    if (modal) {
                        modal.classList.add("hidden");
                    }
                } else {
                    alert("Error al actualizar el avatar.");
                }
            
            } catch (error) {
                console.error("Error:", error);
                alert("Ocurrió un error al subir la imagen. Intenta nuevamente.");
            }
        });
    }
}


