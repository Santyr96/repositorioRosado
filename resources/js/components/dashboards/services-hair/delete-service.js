"use strict";

import { closeModal } from "../../modals/closeModal";
import { reloadServicesView, showErrorMessage } from "./services-manage";

export function deleteService(urlView) {
    const deleteForms = document.querySelectorAll(".deleteForm");
    const confirmationDelete = document.getElementById("confirmation");
    const deleteWarning = document.getElementById("deleteWarning");

 
    confirmationDelete.addEventListener("click", async function () {
        const url = this.getAttribute("data-delete");

        if (!url) {
            showErrorMessage("URL de eliminación no disponible.");
            return;
        }

        try {
            const response = await fetch(url, {
                method: "POST",
                headers: {
                    "X-CSRF-TOKEN": document.querySelector('meta[name="csrf-token"]').getAttribute("content"),
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
                error.message || "Ocurrió un error al eliminar el servicio. Intenta nuevamente."
            );
        }
    });

    
    deleteForms.forEach((deleteForm) => {
        deleteForm.addEventListener("submit", function (e) {
            e.preventDefault();
            const url = this.getAttribute("data-form");

            if (!url) {
                console.error("La URL para eliminar un servicio no está disponible.");
                showErrorMessage("Error interno. Intenta más tarde.");
                return;
            }

            confirmationDelete.setAttribute("data-delete", url);

            if (deleteWarning.classList.contains("hidden")) {
                deleteWarning.classList.toggle("hidden");
            }
        });
    });

    closeModal(); 
}
