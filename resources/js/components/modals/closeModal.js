"use strict";
const closeModalListeners = new WeakMap();
document.addEventListener("DOMContentLoaded", function () {
    closeModal();
});

export function closeModal() {
    const modal = document.getElementById("errorModal");
    const adviseModal = document.querySelector(".advise-modal");
    const closeButtons = document.querySelectorAll('[data-modal-hide]');

    closeButtons.forEach((button) => {

        const previousListener = closeModalListeners.get(button);
        if (previousListener) {
            button.removeEventListener("click", previousListener);
        }
        const newListener = () => {
            modal.classList.add("hidden");
            adviseModal.classList.add("hidden");
        };

        button.addEventListener("click", newListener);
        closeModalListeners.set(button, newListener);
    });
}
