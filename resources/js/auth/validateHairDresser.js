"use strict";

export function initValidationsHairDresser() {
    //Se obtiene el formulario de la página con nombre fForm.
    const form = document.forms.HairDresserForm;

    //Se añaden los listeners a los campos del formulario.
    form.cif.addEventListener("change", () => validateCIF(form.cif));
    form.name.addEventListener("change", () => validateName(form.name));
    form.phone.addEventListener("change", () => validatePhone(form.phone));
    form.address.addEventListener("change", () =>
        validateAddress(form.address)
    );
    form.latitude.addEventListener("change", () =>
        validateLatitude(form.latitude)
    );

    form.longitude.addEventListener("change", () =>
        validateLongitude(form.longitude)
    );
}

//Función encargada de mostrar feedback al usuario sobre los datos introducidos en los campos del formulario.
function showFeedBack(input, valid, message) {
    const validClass = valid ? "text-green-600" : "text-red-500";
    const span = input.parentElement.parentElement.querySelector("span");
    span.classList.remove("text-green-600", "text-red-500");
    span.classList.add(validClass);
    span.textContent = message;
}

//Función que se encarga de la validación del CIF.
function validateCIF(input) {
    //Se crea una expresión regular para comparar el dato introducido en el campo del formulario.
    const cifRegex = /^[ABCDEFGHJKLMNPQRSUVW]\d{8}$/;
    //Si el campo no se corresponde con la expresión regular, se muestra un mensaje de ayuda al usuario.
    if (!cifRegex.test(input.value)) {
        showFeedBack(
            input,
            false,
            "El CIF introducido no cumple con el patrón establecido. (1 letra y 8 digitos)"
        );

        //Si los datos introducidos son correctos, se muestra un mensaje de éxito al usuario.
    } else {
        showFeedBack(input, true, "Correcto");
    }
}

//Función que se encarga de la validación del nombre.
function validateName(input) {
    //Creamos expresión regular para nombre.
    const nameRegex = /^[A-Za-zÀ-ÿ\s]+$/;
    //Si el nombre esta vacío, se muestra mensaje al usuario.
    if (input.value === "") {
        showFeedBack(input, false, "El nombre no puede estar vacío.");
    } else if (input.value.length > 50) {
        showFeedBack(
            input,
            false,
            "El nombre no puede tener más de 50 caracteres."
        );
    } else {
        showFeedBack(input, true, "Correcto");
    }
}

//Función que se encarga de la validación del número de telefono.
function validatePhone(input) {
    //Se crea expresión regular el numero de telefono empiece por 6 o por 9.
    const phoneRegex = /^[69]\d{8}$/;
    //Si el campo esta vacio o el tamaño del numero de telefono no es igual a 9, se muestra un mensaje de ayuda al usuario.
    if (input.value === "") {
        showFeedBack(
            input,
            false,
            "El teléfono debe tener 9 dígitos y ser numérico."
        );
        //Si los datos introducidos son correctos, se muestra un mensaje de éxito al usuario.
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

//Función que se encarga de la validación de la dirección.
function validateAddress(input) {
    //Se crea una expresión regular para que la dirección introducida tenga un patrón establecido -> Calle Mayor, 15, 28013, Madrid
    const addressRegex =
        /^(C\/|Calle )?[A-Za-zÀ-ÿ\s]+,\s?\d{1,3},\s?\d{5},\s?[A-Za-zÀ-ÿ\s]+$/;
    //Si el campo esta vacio, se muestra mensaje al usuario.
    if (input.value === "") {
        showFeedBack(input, false, "La dirección no puede estar vacía.");
    }
    //Si el campo no se corresponde con la expresión regular, se muestra un mensaje de ayuda al usuario.
    else if (!addressRegex.test(input.value)) {
        showFeedBack(
            input,
            false,
            "La dirección introducida no cumple con el patrón establecido. (Calle Mayor, 15, 28013, Madrid)"
        );

        //Si los datos introducidos son correctos, se muestra un mensaje de éxito al usuario.
    } else {
        showFeedBack(input, true, "Correcto");
    }
}
//Función que se encarga de la validación de la latitud.
function validateLatitude(input) {
    //Se crea una expresión regular para que la latitud introducida tenga un patrón establecido -> 40.123456
    const latitudeRegex = /^[-+]?((\d|[1-8]\d)(\.\d+)?|90(\.0+)?)$/;
    //Si el campo esta vacio o el valor introducido no es un número, se muestra un mensaje de ayuda al usuario.
    if (input.value === "" || isNaN(input.value)) {
        showFeedBack(
            input,
            false,
            "El campo latitud no puede estar vacío y debe ser un número."
        );

        //Si el campo no se corresponde con la expresión regular, se muestra un mensaje de ayuda al usuario.
    } else if (!latitudeRegex.test(input.value)) {
        showFeedBack(
            input,
            false,
            "La latitud introducida no cumple con el patrón establecido. (40.123456)"
        );

        //Si los datos introducidos son correctos, se muestra un mensaje de éxito al usuario.
    } else {
        showFeedBack(input, true, "Correcto");
    }
}

//Función que se encaga de la validación de la longitud.
function validateLongitude(input) {
    //Se crea una expresión regular para que la longitud introducida tenga un patrón establecido -> -3.123456
    const longitudeRegex = /^[-+]?((\d|[1-9]\d|1[0-7]\d)(\.\d+)?|180(\.0+)?)$/;
    //Si el campo esta vacio o el valor introducido no es un número, se muestra un mensaje de ayuda al usuario.
    if (input.value === "" || isNaN(input.value)) {
        showFeedBack(
            input,
            false,
            "El campo longitud no puede estar vacío y debe ser un número."
        );

        //Si el campo no se corresponde con la expresión regular, se muestra un mensaje de ayuda al usuario.
    } else if (!longitudeRegex.test(input.value)) {
        showFeedBack(
            input,
            false,
            "La longitud introducida no cumple con el patrón establecido. (-3.123456)"
        );
        //Si los datos introducidos son correctos, se muestra un mensaje de éxito al usuario.
    } else {
        showFeedBack(input, true, "Correcto");
    }
}
