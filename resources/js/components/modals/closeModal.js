document.addEventListener("DOMContentLoaded", function () {
    closeModal();
});

export function closeModal(){
    const modal = document.getElementById("errorModal")
    let closeButtons = document.querySelectorAll('[data-modal-hide]');
    closeButtons.forEach((button) => {
        button.addEventListener("click", () => {
            modal.classList.add("hidden");
        });
    });
    
}
