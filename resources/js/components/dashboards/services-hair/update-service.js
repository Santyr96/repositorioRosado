"use strict";
import { closeModal } from "../../modals/close-modal";
import { reloadServicesView, showErrorMessage } from "./services-manage";

//Función que se encarga de la actualización de un servicio.
export function updateService(urlView) {
    const updateForms = document.querySelectorAll(".updateForm");
    const updateModal = document.querySelector(".advise-modal");
    const updateChild = document.getElementById("child");
    const updateModalTitle = document.getElementById("modalTitle");
    const updateModalMessage = document.getElementById("message");

    //Función que se encarga de abrir el modal de actualización de servicio.
    function openUpdateModal(trUpdate, url, urlView) {
        if (updateModal.classList.contains("hidden")) {
            updateModal.children[0].children[0].classList.replace(
                "bg-gray-600",
                "bg-purple-700"
            );
            updateModal.children[0].children[0].children[0].classList.add(
                "bg-white"
            );
            updateModal.id = "updateModal";
            updateChild.replaceChildren();
            updateChild.insertAdjacentHTML("afterbegin", createUpdateForm());

            updateModalTitle.textContent = "Actualización de servicio";
            updateModalTitle.classList.replace("text-white", "text-black");
            updateModalMessage.textContent =
                "¿Quieres actualizar este servicio?";

            fillUpdateForm(trUpdate, url);
            initializeCloseButtons();
        }

        updateModal.classList.toggle("hidden");
    }

    //Función que se encarga de inicializar los botones de cerrar.
    function initializeCloseButtons() {
        closeModal();
    }

    //Función que se encarga de generar el formulario de actualización de servicio.
    function createUpdateForm() {
        return `
            <form class="flex flex-col justify-center gap-2" name="fupdateServiceModal" data-form="" method="post">
                <label class="text-white" for="name">Nombre para el servicio</label>
                <input type="text" name="name" id="name" value="">
                <x-forms.span-validate class="w-10/12"></x-forms.span-validate>

                <label class="text-white" for="description">Descripción</label>
                <textarea name="description" id="description" cols="30" rows="10"></textarea>
                <x-forms.span-validate class="w-10/12"></x-forms.span-validate>

                <label class="text-white" for="price">Precio</label>
                <input class="w-16 p-1 text-sm resize-none" step="0.50" type="number" name="price" value=""
                    min="0" placeholder="0.00"
                    oninput="this.value = (this.value && !isNaN(this.value)) ? parseFloat(this.value).toFixed(2) : ''">

                <div class="flex justify-center p-4 md:p-5 border-t border-gray-200 rounded-b dark:border-gray-600">
                    <button id="send" type="submit" class="py-2.5 px-5 ms-3 text-sm font-medium text-gray-900 focus:outline-none bg-white rounded-lg border border-gray-200 hover:bg-gray-100 hover:text-blue-700 focus:z-10 focus:ring-4 focus:ring-gray-100 dark:focus:ring-gray-700 dark:bg-gray-800 dark:text-gray-400 dark:border-gray-600 dark:hover:text-white dark:hover:bg-gray-700" data-modal-hide="updateModal">
                        Editar servicio
                    </button>
                    <button id="cancel" type="button" class="py-2.5 px-5 ms-3 text-sm font-medium text-gray-900 focus:outline-none bg-white rounded-lg border border-gray-200 hover:bg-gray-100 hover:text-blue-700 focus:z-10 focus:ring-4 focus:ring-gray-100 dark:focus:ring-gray-700 dark:bg-gray-800 dark:text-gray-400 dark:border-gray-600 dark:hover:text-white dark:hover:bg-gray-700" data-modal-hide="updateModal">
                        Cancelar
                    </button>
                </div>
            </form>
        `;
    }

    //Función que se encarga de llenar el formulario de actualización de servicio.
    function fillUpdateForm(trUpdate, url) {
        const tds = trUpdate.querySelectorAll("td");
        const dataMap = new Map();
        tds.forEach((td) => {
            dataMap.set(td.id, td.textContent.trim());
        });

        const updateServiceModalForm = document.forms["fupdateServiceModal"];
        updateServiceModalForm.setAttribute("data-form", url);
        updateServiceModalForm["name"].value = dataMap.get("tdName");
        updateServiceModalForm["description"].value =
            dataMap.get("tdDescription");
        const priceValue = parseFloat(
            String(dataMap.get("tdPrice")).replace(/\s+/g, "").replace("€", "")
        );
        updateServiceModalForm["price"].value = priceValue;

        updateServiceModalForm.addEventListener("submit", async function (e) {
            e.preventDefault();
            const formData = new FormData(this);
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
                    throw new Error(`Error en la solicitud: ${data.error}`);
                }

                await reloadServicesView(urlView);
                
            } catch (error) {
                console.error("Error:", error);
                showErrorMessage(
                    error.message ||
                        "Ocurrió un error al actualizar el servicio. Inténtalo nuevamente.",
                    "Error al actualizar el servicio"
                );
            }
        });
    }

    //Recorre todos los formularios de actualización y agrega el evento submit a cada uno.
    updateForms.forEach((updateForm) => {
        const trUpdate = updateForm.parentElement.parentElement;
        updateForm.addEventListener("submit", function (e) {
            e.preventDefault();
            const url = this.getAttribute("data-form");
            if (!url) {
                console.error(
                    "La URL para actualizar un servicio no está disponible."
                );
                showErrorMessage("Error interno. Intenta más tarde.");
                return;
            }

            openUpdateModal(trUpdate, url, urlView);
        });
    });
}
