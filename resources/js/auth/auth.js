"use strict";

document.addEventListener("DOMContentLoaded", function () {

    //Se obtiene el formulario de la página con nombre fForm.
    const form = document.forms.fForm;

    //Se añaden los listeners a los campos del formulario.
    form.email.addEventListener("change", () => validateEmail(form.email));
    form.password.addEventListener("change", () =>
        validatePassword(form.password)
    );
    form.password_confirmation.addEventListener("keyup", () =>
        validateConfirmPassword(form.password_confirmation, form.password)
    );
    form.dni.addEventListener("change", () => validateDNI(form.dni));
    form.name.addEventListener("change", () => validateName(form.name));
    form.phone.addEventListener("change", () => validatePhone(form.phone));

  
});

//Función encargada de mostrar feedback al usuario sobre los datos introducidos en los campos del formulario.
function showFeedBack(input, valid, message) {
    const validClass = valid ? "text-green-600" : "text-red-500";
    const span = input.parentElement.parentElement.querySelector("span");
    span.classList.remove("text-green-600", "text-red-500");
    span.classList.add(validClass);
    span.textContent = message;
}
//Función que se encarga de la validación del email.
function validateEmail(input) {
    //Se crea una expresión regular para comparar el dato introducido en el campo del formulario.
    const emailRegex = /^[a-zA-Z0-9._%+-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,}$/;
    if (input.value === "") {
        showFeedBack(input, false, "El campo e-mail no puede estar vacío.");
    } else if (!emailRegex.test(input.value)) {
        showFeedBack(input, false, "Introduce un email válido");
    } else {
        showFeedBack(input, true, "Correcto");
       
    }
}

//Función que se encarga de la validación de la contraseña.
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


//Función que se encarga de la validación de la confirmación de la contraseña.
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

//Función que se encarga de la validación del DNI.
function validateDNI(input) {
    const dniRegex = /^\d{8}[A-Za-z]$/;
    if (input.value === "") {
        showFeedBack(input, false, "El campo DNI no puede estar vacío");
    } else if (!dniRegex.test(input.value)) {
        showFeedBack(
            input,
            false,
            "El DNI introducido no cumple con el patrón establecido. (8 dígitos y una letra)"
        );
    } else {
        showFeedBack(input, true, "Correcto");
    }
}

//Función que se encarga de la validación del nombre.
function validateName(input) {
    if (input.value === "") {
        showFeedBack(input, false, "El campo nombre no puede estar vacío");
    } else {
        showFeedBack(input, true, "Correcto");
    }
}

//Función que se encarga de la validación del número de telefono.
function validatePhone(input) {
    const phoneRegex = /^[69]\d{8}$/;
    if (input.value === "") {
        showFeedBack(
            input,
            false,
            "El teléfono debe tener 9 dígitos y ser numérico."
        );
    } else if (!phoneRegex.test(input.value)) {
        showFeedBack(
            input,
            false,
            "El teléfono debe empezar por 6 o 9 y tener 9 dígitos."
        );
    } else {
        showFeedBack(input, true, "Correcto");
    }
}
