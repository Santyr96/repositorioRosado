"use_strict";

import { tooglePasswordVisibility } from "../passwords/show-password";
import { showCalendar } from "./calendar/show-calendar";
import { showServices } from "./services-hair/services-manage";
import { signupHairdresser } from "./signup/signup-hairdresser";
import { updateAvatar } from "./profile/update-avatar";
import { updateProfile } from "./profile/update-profile";
import { initValidationsHairDresser } from "../../auth/validate-hairdresser";
import { initValidations } from "../../auth/validate-profile";
import { storeHairDresser } from "./hairdresser/insert-hairdresser";

document.addEventListener("DOMContentLoaded", function () {
    const adminPanel = document.querySelector("aside #adminPanel");
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
                        showServices();
                        break;
                    case "signup":
                        signupHairdresser();
                        break;
                    case "appointments":
                        showCalendar();
                        break;
                    case "manage-appointments":
                        showCalendar();
                        break;
                }
            } catch (error) {
                console.error("Error al cargar el contenido", error);
                contentContainer.innerText = "Error al cargar el contenido.";
            }
        });
    });
});
