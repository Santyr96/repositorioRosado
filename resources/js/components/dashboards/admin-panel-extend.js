"use strict";
import { initValidationsHairDresser } from "../../auth/validateHairDresser";
import { initValidations } from "../../auth/validateProfile";
import { tooglePasswordVisibility } from "../passwords/show_password";
import { updateProfile } from "./profile/update_profile";
import { storeHairDresser } from "./hairdresser/insertHairDresser";
import { updateAvatar } from "./profile/update_avatar";
import { servicesManage } from "./services-hair/services-manage";

document.addEventListener("DOMContentLoaded", function () {
    const extendButton = document.getElementById("extendButton");
    const adminPanel = document.querySelector("header #adminPanel");
    extendButton.setAttribute("tabindex", "0");
    const backButton = adminPanel.querySelector("header button");
    extendButton.addEventListener("click", function () {
        if (adminPanel.classList.contains("hidden")) {
            adminPanel.classList.remove("hidden");
            loadView();

        } else {
            adminPanel.classList.add("hidden");
        }
    });
    backButton.addEventListener("click", function () {
        adminPanel.classList.add("hidden");
    });
});

export function loadView() {
    const adminPanel = document.querySelector("header #adminPanel");
    
    const setupLinks = () => {
        const links = adminPanel.querySelectorAll("a");
        const contentContainer = document.getElementById("content");

        links.forEach((link) => {
            link.addEventListener("click", async function (f) {
                f.preventDefault();

                const url = this.getAttribute("data-url");
                const id = this.id;

                try {
                    const response = await fetch(url);

                    if (!response.ok) {
                        throw new Error("Error en la solicitud");
                    }

                    const html = await response.text();
                    contentContainer.innerHTML = html;

                    switch (id) {
                        case "profile":
                            updateAvatar();
                            initValidations();
                            tooglePasswordVisibility();
                            updateProfile();
                            break;
                        case "create-hairdresser":
                            initValidationsHairDresser();
                            storeHairDresser();
                            break;
                        case "create-service":
                            servicesManage();
                            break;

                    }
                    adminPanel.classList.add("hidden");
                } catch (error) {
                    console.error("Error al cargar el contenido", error);
                    contentContainer.innerText =
                        "Error al cargar el contenido.";
                }
            });
        });
    };
    setupLinks();
}
