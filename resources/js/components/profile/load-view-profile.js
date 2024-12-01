"use_strict";

import { initValidations } from "../../auth/validateProfile";
import { tooglePasswordVisibility } from "../passwords/show_password";
import { updateAvatar } from "./update_avatar";
import { updateProfile } from "./update_profile";

document.addEventListener("DOMContentLoaded", function () {
    const adminPanel = document.querySelector("aside #adminPanel");
    const links = adminPanel.querySelectorAll("a");
    const contentContainer = document.getElementById("content");

    links.forEach((link) => {
        link.addEventListener("click", async function (f) {
            f.preventDefault();

            const url = this.getAttribute("data-url");

            try {
                const response = await fetch(url);

                if (!response.ok) {
                    throw new Error("Error en la solicitud");
                }

                const html = await response.text();
                contentContainer.innerHTML = html;
                updateAvatar();
                initValidations();
                tooglePasswordVisibility();
                updateProfile();
            } catch (error) {
                console.error("Error al cargar el contenido", error);
                contentContainer.innerText = "Error al cargar el contenido.";
            }
        });
    });
});
