"use strict";

document.addEventListener('DOMContentLoaded', function () {
    const extendButton = document.getElementById('extendButton');
    extendButton.setAttribute('tabindex', '0');
    const adminPanel = document.querySelector('header #adminPanel');
    console.log(adminPanel);
    const backButton = adminPanel.querySelector('header button');
    console.log(backButton);

    extendButton.addEventListener('click', function (){
        if (adminPanel.classList.contains('hidden')) {
            adminPanel.classList.remove('hidden');
        } else {
            adminPanel.classList.add('hidden');
        }
    })
    
    backButton.addEventListener('click', function(){
        adminPanel.classList.add('hidden');
    })
});