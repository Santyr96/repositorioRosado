"use strict";

document.addEventListener("DOMContentLoaded", function () {
    let inputs = document.querySelectorAll("#login input");

    inputs.forEach(function (input) {
        
        input.classList.add("transition-height", "duration-500");

        input.addEventListener("click", function () {
            
             if(input.classList.contains("h-12")){
                input.classList.remove("h-12");
                input.classList.add("h-14");
             } else if(input.classList.contains("h-14")){
                input.classList.remove("h-14");
                input.classList.add("h-12");
             }
            
        });

       

        input.addEventListener("blur", function () {
            
            input.classList.remove("h-14");
            input.classList.add("h-12");
        });
    });
});
