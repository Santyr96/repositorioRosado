"use strict";
document.addEventListener("DOMContentLoaded", function () {
    const form = document.forms.fForm;
    
    form.email.addEventListener("change", () => validateEmail(form.email));
    form.password.addEventListener("change", () =>
        validatePassword(form.password)
    );
    form.password_confirmation.addEventListener("change", () =>
        validateConfirmPassword(form.password_confirmation, form.password)
    );
});

function validateEmail(input) {
    const emailRegex = /^[a-zA-Z0-9._%+-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,}$/;
    if (input.value === "") {
        showFeedBack(input, false, "El campo e-mail no puede estar vacío.");
    } else if (!emailRegex.test(input.value)) {
        showFeedBack(input, false, "Introduce un email válido");
    } else {
        showFeedBack(input, true, "Correcto");
    }
}

function validatePassword(input) {
    console.log(input.value);
    const passwordRegex =
        /^(?=.*[A-Z])(?=.*[a-z])(?=.*\d)(?=.*[!@#$%^&*()_+]).{8,}$/;
    if (input.value === "") {
        showFeedBack(input, false, "El campo contraseña no puede estar vacío.");
    } else if (!passwordRegex.test(input.value)) {
        showFeedBack(
            input,
            false,
            "Introduce una contraseña válida. Debe tener al menos 8 caracteres, una mayúscula, una minúscula y un número."
        );
    } else {
        showFeedBack(input, true, "Correcto");
    }
}

function validateConfirmPassword(input, password) {
    if ((input.value === "")) {
        showFeedBack(
            input,
            false,
            "El campo confirmar contraseña no puede estar vacío."
        );
    } else if (input.value !== password.value) {
        showFeedBack(input, false, "Las contraseñas no coinciden.");
    } else {
        showFeedBack(input, true, "Correcto");
    }
}

function showFeedBack(input, valid, message) {
    const validClass = valid ? "text-green-600" : "text-red-500";
    const span = input.nextElementSibling;
    span.classList.remove("text-green-600", "text-red-500");
    span.classList.add(validClass);
    span.textContent = message;
}