"use strict";
import { closeModal } from "../../modals/close-modal";
import { reloadServicesView, showErrorMessage } from "./services-manage";

//Función que se encarga de crear un servicio.
export function createService(urlView) {
    const createButton = document.getElementById("create");
    const createModal = document.querySelector(".advise-modal");
    const createChild = document.getElementById("child");
    const createModalTitle = document.getElementById("modalTitle");
    const createModalMessage = document.getElementById("message");
    const inputIdHairdresser = document.getElementById("idHairdresser");

    //Se agrega el evento click al botón de crear servicio.
    createButton.addEventListener("click", function () {
        //Se verifica si el modal tiene la clase hidden, si la tiene se le quita y se llama a la función openCreateModal.
        if (createModal.classList.contains("hidden")) {
            openCreateModal(
                createModal,
                createChild,
                createModalTitle,
                createModalMessage
            );
            //Se inicializa el formulario de creación de servicio.
            setupCreateServiceForm(createModal, urlView, inputIdHairdresser);
            createModal.classList.toggle("hidden");
        }
    });
}

//Función que se encarga de abrir el modal de creación de servicio.
function openCreateModal(modal, child, modalTitle, modalMessage) {
    const header = modal.children[0].children[0];
    header.classList.replace("bg-gray-600", "bg-purple-700");
    header.children[0].classList.add("bg-white");

    modal.id = "createModal";
    child.replaceChildren();
    child.insertAdjacentHTML("afterbegin", generateCreateFormHTML());

    modalTitle.textContent = "Creación de servicio";
    modalTitle.classList.replace("text-white", "text-black");
    modalMessage.textContent = "¿Quieres crear un servicio?";
}

//Función que se encarga de generar el formulario de creación de servicio.
function generateCreateFormHTML() {
    return `
        <form class="flex flex-col justify-center gap-2" name="fcreateService" data-form="" method="post">
            <label class="text-white" for="name">Nombre para el servicio</label>
            <input type="text" name="name" id="name" value="">
            <x-forms.span-validate class="w-10/12"></x-forms.span-validate>

            <label class="text-white"  for="description">Descripción</label>
            <textarea name="description" id="description" cols="30" rows="10"></textarea>
            <x-forms.span-validate class="w-10/12"></x-forms.span-validate>

            <label class="text-white" for="price">Precio</label>
            <input class="w-16 p-1 text-sm resize-none" step="0.50" type="number" name="price" value=""
                min="0" placeholder="0.00"
                oninput="this.value = (this.value && !isNaN(this.value)) ? parseFloat(this.value).toFixed(2) : ''">

            <div class="flex justify-center p-4 md:p-5 border-t border-gray-200 rounded-b dark:border-gray-600">
                <button id="send" data-modal-hide="createModal" type="submit" class="py-2.5 px-5 ms-3 text-sm font-medium text-gray-900 focus:outline-none bg-white rounded-lg border border-gray-200 hover:bg-gray-100 hover:text-blue-700 focus:z-10 focus:ring-4 focus:ring-gray-100 dark:focus:ring-gray-700 dark:bg-gray-800 dark:text-gray-400 dark:border-gray-600 dark:hover:text-white dark:hover:bg-gray-700">
                    Crear servicio
                </button>
                <button id="cancel" type="button"
                data-modal-hide="createModal"
                    class="py-2.5 px-5 ms-3 text-sm font-medium text-gray-900 focus:outline-none bg-white rounded-lg border border-gray-200 hover:bg-gray-100 hover:text-blue-700 focus:z-10 focus:ring-4 focus:ring-gray-100 dark:focus:ring-gray-700 dark:bg-gray-800 dark:text-gray-400 dark:border-gray-600 dark:hover:text-white dark:hover:bg-gray-700">
                    Cancelar
                </button>
            </div>
        </form>
    `;
}


//Función que se encarga de inicializar el formulario de creación de servicio.
function setupCreateServiceForm(modal, urlView, inputIdHairdresser) {
    const createServiceForm = document.forms["fcreateService"];
    createServiceForm.addEventListener("submit", async function (e) {
        e.preventDefault();
        const createButton = document.getElementById("create");
        const url = createButton.getAttribute("data-form");
        const formData = new FormData(createServiceForm);
        formData.append(inputIdHairdresser.name, inputIdHairdresser.value);

        try {
            //Se envía la petición fetch con el formulario de creación de servicio.
            await submitCreateServiceForm(url, formData, urlView);
            modal.classList.add('hidden');
            
        } catch (error) {
            modal.classList.add('hidden')
            showErrorMessage(
                error.message ||
                    "Ocurrió un error al crear el servicio. Inténtalo nuevamente.", "Error al crear el servicio"
            );
        }
    });
}

//Función que se encarga de enviar la petición fetch con el formulario de creación de servicio.
async function submitCreateServiceForm(url, formData, urlView) {
    
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
        } else{
            await reloadServicesView(urlView);
        }
       

}
