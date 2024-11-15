"use strict";

document.addEventListener('DOMContentLoaded', function () {
    const notificationButton = document.getElementById('notificationButton');
    notificationButton.setAttribute('tabindex', '0');
    const dropdown = document.getElementById('dropdown');

    notificationButton.addEventListener('click', function (){
        if (dropdown.classList.contains('hidden')) {
            dropdown.classList.remove('hidden');
        } else {
            dropdown.classList.add('hidden');
        }
    })
    
    notificationButton.addEventListener('blur', function(){
        dropdown.classList.add('hidden');
    })
});