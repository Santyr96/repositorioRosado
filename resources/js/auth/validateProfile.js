"use strict";

export function initValidations() {
    //Se obtiene el formulario de la página con nombre fForm.
    const form = document.forms.fForm;

    //Se añaden los listeners a los campos del formulario.
    form.password.addEventListener("change", () =>
        validatePassword(form.password)
    );
    form.password_confirmation.addEventListener("change", () =>
        validateConfirmPassword(form.password_confirmation, form.password)
    );
    form.dni.addEventListener("change", () => validateDNI(form.dni));
    form.name.addEventListener("change", () => validateName(form.name));
    form.phone.addEventListener("change", () => validatePhone(form.phone));
}

//Función encargada de mostrar feedback al usuario sobre los datos introducidos en los campos del formulario.
function showFeedBack(input, valid, message) {
    const validClass = valid ? "text-green-600" : "text-red-500";
    const span = input.parentElement.parentElement.querySelector("span");
    span.classList.remove("text-green-600", "text-red-500");
    span.classList.add(validClass);
    span.textContent = message;
}

//Función que se encarga de la validación de la contraseña.
function validatePassword(input) {
    //Se crea una expresión regular para comparar el dato introducido en el campo del formulario.
    const passwordRegex =
        /^(?=.*[A-Z])(?=.*[a-z])(?=.*\d)(?=.*[!@#$%^&*()_+]).{8,}$/;
    if (!passwordRegex.test(input.value)) {
        showFeedBack(
            input,
            false,
            "Introduce una contraseña válida. Debe tener al menos 8 caracteres, una mayúscula, una minúscula y un número."
        );

        //Si los datos introducidos son correctos, se muestra un mensaje de éxito al usuario.
    } else {
        showFeedBack(input, true, "Correcto");
    }
}

//Función que se encarga de la validación de la confirmación de la contraseña.
function validateConfirmPassword(input, password) {
    //Si los datos introducidos no coinciden, se muestra un mensaje de error al usuario.
    if (input.value !== password.value) {
        showFeedBack(input, false, "Las contraseñas no coinciden.");
        //Si los datos introducidos son correctos, se muestra un mensaje de éxito al usuario.
    } else {
        showFeedBack(input, true, "Correcto");
    }
}

//Función que se encarga de la validación del DNI.
function validateDNI(input) {
    //Se crea una expresión regular para comparar el dato introducido en el campo del formulario.
    const dniRegex = /^\d{8}[A-Za-z]$/;

    //Si el campo no se corresponde con la expresión regular, se muestra un mensaje de ayuda al usuario.
    if (!dniRegex.test(input.value)) {
        showFeedBack(
            input,
            false,
            "El DNI introducido no cumple con el patrón establecido. (8 dígitos y una letra)"
        );

        //Si los datos introducidos son correctos, se muestra un mensaje de éxito al usuario.
    } else {
        showFeedBack(input, true, "Correcto");
    }
}

//Función que se encarga de la validación del nombre.
function validateName(input) {
    showFeedBack(input, true, "Correcto");
}

//Función que se encarga de la validación del número de telefono.
function validatePhone(input) {
    //Si el campo esta vacio o el tamaño del numero de telefono no es igual a 9, se muestra un mensaje de ayuda al usuario.
    if (input.value.length != 9) {
        showFeedBack(
            input,
            false,
            "El teléfono debe tener 9 dígitos y ser numérico."
        );

        //Si los datos introducidos son correctos, se muestra un mensaje de éxito al usuario.
    } else {
        showFeedBack(input, true, "Correcto");
    }
}
