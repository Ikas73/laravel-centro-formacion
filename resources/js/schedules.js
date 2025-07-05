import { Calendar } from '@fullcalendar/core';
import timeGridPlugin from '@fullcalendar/timegrid';
import dayGridPlugin from '@fullcalendar/daygrid';
import interactionPlugin from '@fullcalendar/interaction'; // ¡NUEVO! Para detectar clics

import rrulePlugin from '@fullcalendar/rrule';

document.addEventListener('DOMContentLoaded', function() {
    const calendarEl = document.getElementById('calendar');
    let calendar; // Declarar la variable calendar aquí para que sea accesible en todo el ámbito

    // --- OBTENER REFERENCIAS A ELEMENTOS DEL MODAL ---
    const scheduleModal = document.getElementById('scheduleModal');
    const modalTitle = document.getElementById('modalTitle');
    const closeModalBtn = document.getElementById('closeModalBtn');
    const cancelBtn = document.getElementById('cancelBtn');
    const scheduleForm = document.getElementById('scheduleForm');
    const saveBtn = document.getElementById('saveBtn');

    // --- LÓGICA PARA CERRAR EL MODAL ---
    const hideModal = () => {
        if (scheduleModal) {
            scheduleModal.classList.add('hidden');
        }
        // Limpiar errores de validación al cerrar
        document.querySelectorAll('p[id^="error-"]').forEach(p => p.innerText = '');
    };
    
    if(closeModalBtn) closeModalBtn.addEventListener('click', hideModal);
    if(cancelBtn) cancelBtn.addEventListener('click', hideModal);

    // --- INICIALIZACIÓN DEL CALENDARIO ---
    if (calendarEl) {
        const cursos = window.cursosData || [];
        const profesores = window.profesoresData || [];

        const cursoSelect = document.getElementById('curso_id');
        if (cursoSelect) {
            cursos.forEach(curso => {
                cursoSelect.options.add(new Option(curso.nombre, curso.id));
            });
        }

        const profesorSelect = document.getElementById('profesor_id');
        if (profesorSelect) {
            profesores.forEach(profesor => {
                profesorSelect.options.add(new Option(`${profesor.nombre} ${profesor.apellido1}`, profesor.id));
            });
        }

        calendar = new Calendar(calendarEl, {
            plugins: [ timeGridPlugin, dayGridPlugin, interactionPlugin, rrulePlugin ],
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
            events: '/admin/schedule/events',
            
            dateClick: function(info) {
                if(scheduleForm) scheduleForm.reset();
                if(modalTitle) modalTitle.innerText = 'Añadir Nueva Franja Horaria';
                if(saveBtn) saveBtn.innerText = 'Guardar Horario';
                
                const scheduleIdInput = document.getElementById('schedule_id');
                if(scheduleIdInput) scheduleIdInput.value = '';

                const date = new Date(info.dateStr);
                const startTimeInput = document.getElementById('start_time');
                if(startTimeInput) startTimeInput.value = date.toTimeString().substring(0, 5);
                
                const weekdayInput = document.getElementById('weekday');
                if(weekdayInput) {
                    const weekday = date.getDay();
                    weekdayInput.value = (weekday === 0) ? 7 : weekday;
                }

                if(scheduleModal) {
                    scheduleModal.classList.remove('hidden');
                    scheduleModal.classList.remove('-translate-y-10');
                }
            },

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
            }
        });
        
        calendar.render();
    }

    // --- LÓGICA PARA ENVIAR EL FORMULARIO ---
    if (scheduleForm) {
        scheduleForm.addEventListener('submit', function(e) {
            e.preventDefault();

            document.querySelectorAll('p[id^="error-"]').forEach(p => p.innerText = '');

            const formData = new FormData(this);
            const data = Object.fromEntries(formData.entries());
            const csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');

            fetch('/admin/schedules', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': csrfToken,
                    'Accept': 'application/json'
                },
                body: JSON.stringify(data)
            })
            .then(response => response.json().then(data => ({ ok: response.ok, data })))
            .then(({ ok, data }) => {
                if (!ok) {
                    throw data; // Lanza el objeto de error si la respuesta no es 2xx
                }
                hideModal();
                if (calendar) {
                    calendar.refetchEvents();
                }
                console.log('Éxito:', data.message);
            })
            .catch(errorData => {
                if (errorData.errors) {
                    Object.keys(errorData.errors).forEach(key => {
                        const errorP = document.getElementById(`error-${key}`);
                        if (errorP) {
                            errorP.innerText = errorData.errors[key][0];
                        }
                    });
                } else {
                    console.error('Error:', errorData);
                }
            });
        });
    }
});