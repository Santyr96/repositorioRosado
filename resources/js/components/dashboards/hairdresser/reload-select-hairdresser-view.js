"use strict";

import { deleteHairdresser } from "./delete-hairdresser";

export async function reloadHairdresserView(url){
    const contentContainer = document.getElementById('content');
    try {
        const response = await fetch(url,{
            method: "GET",
            headers: {
                "X-CSRF-TOKEN": document
                    .querySelector('meta[name="csrf-token"]')
                    .getAttribute("content"),
            },
        });

        if(!response.ok){
            throw new Error("Error en la solicitud");
        }

        const html = await response.text();
        contentContainer.innerHTML = html;

        deleteHairdresser();
    } catch (error) {
        console.error("Error al cargar el contenido", error);
        contentContainer.innerText = "Error al cargar el contenido.";
    }

}