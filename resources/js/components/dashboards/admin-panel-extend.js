"use strict";
import { initValidations } from '../../auth/validateProfile';
import { tooglePasswordVisibility } from '../passwords/show_password';
import { updateAvatar } from '../profile/update_avatar';
import { updateProfile } from '../profile/update_profile';



document.addEventListener('DOMContentLoaded', function () {
    const extendButton = document.getElementById('extendButton');
    extendButton.setAttribute('tabindex', '0');
    const adminPanel = document.querySelector('header #adminPanel');
    const backButton = adminPanel.querySelector('header button');

 
    const setupLinks = () => {
        const links = adminPanel.querySelectorAll('a');
        const contentContainer = document.getElementById('content');

        links.forEach(link => {
            link.addEventListener('click', async function (f) {
                f.preventDefault();

                const url = this.getAttribute('data-url');

                try {
                    const response = await fetch(url);

                    if (!response.ok) {
                        throw new Error('Error en la solicitud');
                    }

                    const html = await response.text();
                    contentContainer.innerHTML = html;
                    updateAvatar();
                    initValidations();
                    tooglePasswordVisibility();
                    updateProfile();
                } catch (error) {
                    console.error('Error al cargar el contenido', error);
                    contentContainer.innerText = 'Error al cargar el contenido.';
                }
            });
        });
    };

   
    extendButton.addEventListener('click', function () {
        if (adminPanel.classList.contains('hidden')) {
            adminPanel.classList.remove('hidden');
            setupLinks();
        } else {
            adminPanel.classList.add('hidden');
        }
    });

   
    backButton.addEventListener('click', function () {
        adminPanel.classList.add('hidden');
    });
});
