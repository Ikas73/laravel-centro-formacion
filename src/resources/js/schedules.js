// resources/js/schedules.js

import { Calendar } from '@fullcalendar/core';
import timeGridPlugin from '@fullcalendar/timegrid';
import dayGridPlugin from '@fullcalendar/daygrid';

// --- ESTA ES LA FORMA CORRECTA Y ÚNICA NECESARIA ---
// import '@fullcalendar/core/main.css';

document.addEventListener('DOMContentLoaded', function() {
    // ... el resto del código se mantiene exactamente igual ...
    var calendarEl = document.getElementById('calendar');
    if (calendarEl) { 
        var calendar = new Calendar(calendarEl, {
            plugins: [ timeGridPlugin, dayGridPlugin ],
            initialView: 'timeGridWeek',
            locale: 'es', 
            headerToolbar: {
                left: 'prev,next today',
                center: 'title',
                right: 'dayGridMonth,timeGridWeek,timeGridDay'
            },
            firstDay: 1, 
            allDaySlot: false, 
            slotMinTime: "08:00:00", 
            slotMaxTime: "22:00:00",
        });
        calendar.render();
    }
});