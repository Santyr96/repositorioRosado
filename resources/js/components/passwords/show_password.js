"use strict";

document.addEventListener("DOMContentLoaded", function () {
    const passwordInputs = document.querySelectorAll('input[type="password"]')
    passwordInputs.forEach(input => {
        
        const toggleButton = input.nextElementSibling.querySelector("button");
      
        toggleButton.addEventListener('click', () => {
          if (input.type === 'password') {
            input.type = 'text';  
          } else {
            input.type = 'password';  
          }
        });
      });
});
