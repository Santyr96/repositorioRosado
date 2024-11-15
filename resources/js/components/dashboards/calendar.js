"use strict";
import { Calendar } from "@fullcalendar/core";
import esLocale from "@fullcalendar/core/locales/es";

document.addEventListener("DOMContentLoaded", function () {
    var calendarEl = document.getElementById("calendar");

    var calendarHeight = calendarEl.offsetHeight;

    var initialViews = "timeGridDay,Semana,dayGridMonth";
    if (calendarHeight >= 640) {
        initialViews = "timeGridDay,timeGridWeek,dayGridMonth";
    }
    var calendar = new FullCalendar.Calendar(calendarEl, {
        initialView: "timeGridDay",
        aspectRatio: 1,
        headerToolbar: {
            left: "title",
        },
        footerToolbar: {
            center: initialViews,
        },

        dayHeaderFormat: {
            weekday: "short",
            day: "numeric",
        },
        slotLabelFormat: {
            hour: "2-digit",
            minute: "2-digit",
        },
        views: {
            Semana: {
                type: "timeGrid",
                duration: { days: 3 },
            },
        },
        locale: esLocale,
    });

    calendar.render();
});
