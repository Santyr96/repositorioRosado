document.addEventListener("DOMContentLoaded", function () {
    const modal = document.getElementById("modal");

    console.log

    let closeButtons = document.querySelectorAll('[data-modal-hide]');
    closeButtons.forEach((button) => {
        button.addEventListener("click", () => {
            modal.classList.add("hidden");
        });
    });
});
