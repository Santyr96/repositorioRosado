function f(){const e=document.forms.fForm;e.password.addEventListener("change",()=>r(e.password)),e.password_confirmation.addEventListener("keyup",()=>d(e.password_confirmation,e.password)),e.dni.addEventListener("change",()=>c(e.dni)),e.name.addEventListener("change",()=>l(e.name)),e.phone.addEventListener("change",()=>i(e.phone))}function a(e,n,o){const s=n?"text-green-600":"text-red-500",t=e.parentElement.parentElement.querySelector("span");t.classList.remove("text-green-600","text-red-500"),t.classList.add(s),t.textContent=o}function r(e){/^(?=.*[A-Z])(?=.*[a-z])(?=.*\d)(?=.*[!@#$%^&*()_+]).{8,}$/.test(e.value)?a(e,!0,"Correcto"):a(e,!1,"Introduce una contraseña válida. Debe tener al menos 8 caracteres, una mayúscula, una minúscula y un número.")}function d(e,n){e.value!==n.value?a(e,!1,"Las contraseñas no coinciden."):a(e,!0,"Correcto")}function c(e){/^\d{8}[A-Za-z]$/.test(e.value)?a(e,!0,"Correcto"):a(e,!1,"El DNI introducido no cumple con el patrón establecido. (8 dígitos y una letra)")}function l(e){a(e,!0,"Correcto")}function i(e){const n=/^[69]\d{8}$/;e.value===""?a(e,!1,"El teléfono debe tener 9 dígitos y ser numérico."):n.test(e.value)?a(e,!0,"Correcto"):a(e,!1,"El teléfono debe empezar por 6 o 9 y tener 9 dígitos.")}export{f as i};
