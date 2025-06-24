
// 1. Importamos los componentes necesarios desde los paquetes locales
import { Calendar } from '@fullcalendar/core';
import dayGridPlugin from '@fullcalendar/daygrid';
import timeGridPlugin from '@fullcalendar/timegrid';

// 2. Importamos el CSS de la misma forma
// import '@fullcalendar/core/main.css';

document.addEventListener('DOMContentLoaded', function() {
    var calendarEl = document.getElementById('calendar');
    var calendar = new Calendar(calendarEl, {
        // 3. Definimos los plugins que hemos importado
        plugins: [ dayGridPlugin, timeGridPlugin ],
        
        // El resto de la configuración se mantiene exactamente igual
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
        events: '/admin/schedule/events', // Usamos la ruta relativa, no la helper de Blade

        eventDidMount: function(info) {
            const titleEl = info.el.querySelector('.fc-event-title');
            if (!titleEl) return;
            let extraContent = '';
            if (info.event.extendedProps.profesor) {
                extraContent += `<div class="fc-event-profesor"><i class="bi bi-person-video3"></i> ${info.event.extendedProps.profesor}</div>`;
            }
            if (info.event.extendedProps.aula) {
                extraContent += `<div class="fc-event-aula"><i class="bi bi-geo-alt-fill"></i> ${info.event.extendedProps.aula}</div>`;
            }
            titleEl.insertAdjacentHTML('afterend', extraContent);
        },
    });
    calendar.render();
});