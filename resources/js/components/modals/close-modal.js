"use strict";
//Se crea un mapa de listeners para guardar los listeners de los botones de cierre del modal.
const closeModalListeners = new WeakMap();

document.addEventListener("DOMContentLoaded", function () {
    closeModal();
});

//Función que se encarga de cerrar el modal de error y de advise.
export function closeModal() {
    //Se obtienen los elementos del DOM.
    const modal = document.getElementById("errorModal");
    const adviseModal = document.querySelector(".advise-modal");
    const closeButtons = document.querySelectorAll('[data-modal-hide]');

    //Se añade un listener a los botones de cierre del modal.
    closeButtons.forEach((button) => {

        //Se comprueba si ya existe un listener en el botón.
        const previousListener = closeModalListeners.get(button);
        if (previousListener) {
            button.removeEventListener("click", previousListener);
        }
        //Se añade un nuevo listener al botón.
        const newListener = () => {
            modal.classList.add("hidden");
            if (adviseModal){
                adviseModal.classList.add("hidden");
            }
        };

        //Se añade el listener al botón.
        button.addEventListener("click", newListener);
        //Se guarda el listener en el mapa de listeners.
        closeModalListeners.set(button, newListener);
    });
}
