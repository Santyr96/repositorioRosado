document.addEventListener("DOMContentLoaded", function () {
    //Obtención de elementos del DOM.
    const registro = document.getElementById("registro");
    const arrow = document.getElementById("arrow");
    const iniciar = registro.nextElementSibling;
    const botonDesplegable = document.getElementById("botonDespegable");
    const menuLateral = document.querySelector('[role="dialog"]');
    const closeButton = document.querySelector("[data-close-button]");

    //Manejo del evento hover del ráton.
    registro.addEventListener("mouseover", function () {
        arrow.classList.add("fill-purple-600");
    });

    //Manejo del evento out del ratón.
    registro.addEventListener("mouseout", function () {
        arrow.classList.remove("fill-purple-600");
    });

    //Función para mostrar el menú con animación.
    const mostrarMenu = () => {
        iniciar.classList.remove("hidden");
        iniciar.classList.add("flex");
    };

    //Función para ocultar el menú con animación.
    const ocultarMenu = () => {
        iniciar.classList.remove("flex");
        iniciar.classList.add("hidden");
    };

    const mostrarMenuLateral = () => {
        menuLateral.classList.remove("hidden");
    };

    const ocultarMenuLateral = () => {
        const menuLateral = document.querySelector('[role="dialog"]');
        menuLateral.classList.add("hidden");
    };

    // Manejo del evento click para mostrar/ocultar el menú
    registro.addEventListener("click", function () {
        if (iniciar.classList.contains("hidden")) {
            mostrarMenu();
        } else {
            ocultarMenu();
        }
    });


    //Manejo del evento click para mostrar u ocultar el menú lateral en pantallas pequeñas.
    botonDesplegable.addEventListener("click", function () {
        if (menuLateral.classList.contains("hidden")) {
            mostrarMenuLateral();
        }
    });

    //Manejo del evento click en el botoón cerrar.
    closeButton.addEventListener("click", function () {
        ocultarMenuLateral();
    });
});
