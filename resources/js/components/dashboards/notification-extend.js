"use strict";

document.addEventListener('DOMContentLoaded', function () {
    //Se obtiene los elementos del DOM necesarios.
    const notificationButton = document.getElementById('notificationButton');
    const url = notificationButton.getAttribute('data-notification');
    const notificationCounter = document.getElementById('notificationCounter');
    notificationButton.setAttribute('tabindex', '0');
    const dropdown = document.getElementById('dropdown');
    dropdown.classList.add('z-50');

    //Se agrega el evento click al botón de notificaciones.
    notificationButton.addEventListener('click', function (){
        //Se verifica si el dropdown tiene la clase hidden, si la tiene se la quita, si no se la agrega.
        if (dropdown.classList.contains('hidden')) {
            dropdown.classList.remove('hidden');
        } else {
            dropdown.classList.add('hidden');
        }
    })

    //Se agrega el evento click al botón de notificaciones, donde se hace la petición fetch al servidor.
    notificationButton.addEventListener('click', async function () {
        await fetch(url);
        //Se verifica si el dropdown tiene la clase hidden, si la tiene se la quita, si no se la agrega.
        notificationCounter.classList.add('hidden');
    });
    
    //Se agrega el evento blur al botón de notificaciones, donde se verifica si el dropdown tiene la clase hidden, si la tiene se la agrega.
    notificationButton.addEventListener('blur', function(){
        dropdown.classList.add('hidden');
    })
});