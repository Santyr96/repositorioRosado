"use strict";

document.addEventListener("DOMContentLoaded", function () {
  tooglePasswordVisibility();
});

//Función que se encarga de mostrar u ocultar la contraseña.
export function tooglePasswordVisibility(){
  
  //Se seleccionan los inputs de tipo password.
  const passwordInputs = document.querySelectorAll('input[type="password"]')

  //Se recorren los inputs para asignar a los botones próximos al input la acción click.
  passwordInputs.forEach(input => {
      
      const toggleButton = input.nextElementSibling.querySelector("button");

      //Si el tipo del input es password, lo cambiamos a text para mostrar al usuario la contraseña.
      toggleButton.addEventListener('click', () => {
        if (input.type === 'password') {
          input.type = 'text';  
        } else {
          input.type = 'password';  
        }
      });
    });
}
