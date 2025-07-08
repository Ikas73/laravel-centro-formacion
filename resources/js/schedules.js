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
    const conflictWarning = document.getElementById('conflictWarning'); // <-- Añadido

    // --- LÓGICA PARA VALIDACIÓN DE CONFLICTOS EN TIEMPO REAL ---
    const checkConflict = async () => {
        const formData = new FormData(scheduleForm);
        const data = Object.fromEntries(formData.entries());

        // No validar si faltan datos clave
        if (!data.start_time || !data.end_time || !data.weekday || (!data.profesor_id && !data.room)) {
            conflictWarning.classList.add('hidden');
            saveBtn.disabled = false;
            return;
        }

        try {
            const response = await fetch('/admin/schedules/check-conflict', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                    'Accept': 'application/json'
                },
                body: JSON.stringify(data)
            });

            const result = await response.json();

            if (result.has_conflict) {
                conflictWarning.innerText = result.message;
                conflictWarning.classList.remove('hidden');
                saveBtn.disabled = true;
            } else {
                conflictWarning.classList.add('hidden');
                saveBtn.disabled = false;
            }
        } catch (error) {
            console.error('Error al verificar conflicto:', error);
            // En caso de error de red, permitir el envío para que valide el backend
            saveBtn.disabled = false; 
        }
    };

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

    // --- Listeners para validación en tiempo real ---
    const fieldsToWatch = ['curso_id', 'profesor_id', 'room', 'weekday', 'start_time', 'end_time'];
    fieldsToWatch.forEach(fieldId => {
        const field = document.getElementById(fieldId);
        if (field) {
            field.addEventListener('change', checkConflict);
        }
    });

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
            editable: true, // <-- Permite arrastrar y redimensionar
            eventResizableFromStart: true, // Permite redimensionar desde el inicio
            droppable: true, // Permite que se "suelten" eventos en el calendario
            
            dateClick: function(info) {
                // Resetear el formulario al estado de CREACIÓN
                scheduleForm.reset();
                scheduleForm.action = '/admin/schedules'; // URL para crear
                document.getElementById('form_method').value = 'POST';
                document.getElementById('schedule_id').value = '';

                // Resetear el select de aulas a la opción por defecto
                const roomSelect = document.getElementById('room');
                if (roomSelect) roomSelect.selectedIndex = 0;

                modalTitle.innerText = 'Añadir Nueva Franja Horaria';
                saveBtn.innerText = 'Guardar Horario';
                
                const date = new Date(info.dateStr);
                const startTimeInput = document.getElementById('start_time');
                if(startTimeInput) startTimeInput.value = date.toTimeString().substring(0, 5);
                
                const weekdayInput = document.getElementById('weekday');
                if(weekdayInput) {
                    // FullCalendar: 0=Dom, 1=Lun... | BD: 1=Lun, ..., 7=Dom
                    let weekday = date.getDay(); // 0 para Domingo, 1 para Lunes...
                    if (weekday === 0) weekday = 7; // Ajustar Domingo a 7
                    weekdayInput.value = weekday;
                }

                if(scheduleModal) {
                    scheduleModal.classList.remove('hidden');
                }
            },

            eventClick: function(info) {
                // 1. Resetear y preparar el formulario para edición
                scheduleForm.reset();
                modalTitle.innerText = 'Editar Horario';
                saveBtn.innerText = 'Actualizar';
                document.getElementById('form_method').value = 'PATCH';
                document.getElementById('schedule_id').value = info.event.id;

                // 2. Construir la URL para obtener datos y para actualizar
                const url = `/admin/schedules/${info.event.id}`;
                scheduleForm.action = url;

                // 3. Hacer fetch para obtener los datos del horario
                fetch(url, {
                    headers: {
                        'Accept': 'application/json',
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                    }
                })
                .then(response => response.json())
                .then(data => {
                    // 4. Poblar el formulario con los datos recibidos
                    document.getElementById('curso_id').value = data.curso_id;
                    document.getElementById('profesor_id').value = data.profesor_id;
                    document.getElementById('start_time').value = data.hora_inicio;
                    document.getElementById('end_time').value = data.hora_fin;
                    document.getElementById('room').value = data.aula;
                    document.getElementById('weekday').value = data.dia_semana;

                    // 5. Mostrar el modal
                    scheduleModal.classList.remove('hidden');
                })
                .catch(error => console.error('Error fetching schedule:', error));
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
            },

            eventDrop: function(info) {
                updateSchedule(info);
            },

            eventResize: function(info) {
                updateSchedule(info);
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
            const method = document.getElementById('form_method').value;

            // La URL se toma dinámicamente del action del formulario
            fetch(this.action, {
                method: 'POST', // Siempre usamos POST
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
                // Si la petición fue exitosa (2xx), siempre cerramos modal y refrescamos
                hideModal();
                if (calendar) {
                    calendar.refetchEvents();
                }
                // Opcional: mostrar un mensaje de éxito si existe
                if (data && data.message) {
                    console.log('Éxito:', data.message);
                }
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

    // --- FUNCIÓN PARA ACTUALIZAR UN HORARIO (DRAG & DROP, RESIZE) ---
    const updateSchedule = async (info) => {
        const event = info.event;
        const scheduleId = event.id;
        const newStartTime = event.start.toTimeString().substring(0, 5);
        const newEndTime = event.end.toTimeString().substring(0, 5);
        const newWeekday = event.start.getDay() === 0 ? 7 : event.start.getDay(); // Ajuste para domingo

        // 1. Obtener los datos originales del schedule para tener el profesor_id y el room
        let originalScheduleData;
        try {
            const response = await fetch(`/admin/schedules/${scheduleId}`);
            originalScheduleData = await response.json();
        } catch (error) {
            console.error('Error fetching original schedule data:', error);
            info.revert();
            alert('No se pudieron obtener los datos originales del horario. No se puede actualizar.');
            return;
        }

        const dataToValidate = {
            schedule_id: scheduleId,
            start_time: newStartTime,
            end_time: newEndTime,
            weekday: newWeekday,
            profesor_id: originalScheduleData.profesor_id,
            room: originalScheduleData.aula
        };

        // 2. Validar el conflicto
        const conflictResponse = await fetch('/admin/schedules/check-conflict', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                'Accept': 'application/json'
            },
            body: JSON.stringify(dataToValidate)
        });
        const conflictResult = await conflictResponse.json();

        if (conflictResult.has_conflict) {
            alert(`Conflicto detectado: ${conflictResult.message}`);
            info.revert(); // Revertir el cambio visual
            return;
        }

        // 3. Si no hay conflicto, actualizar el horario en el backend
        const updateData = {
            curso_id: originalScheduleData.curso_id,
            profesor_id: originalScheduleData.profesor_id,
            room: originalScheduleData.aula,
            start_time: newStartTime, // Sobrescribimos con los nuevos tiempos
            end_time: newEndTime,
            weekday: newWeekday,
            _method: 'PATCH' // Importante para Laravel
        };

        try {
            const updateResponse = await fetch(`/admin/schedules/${scheduleId}`, {
                method: 'POST', // Usar POST para el _method spoofing
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                    'Accept': 'application/json'
                },
                body: JSON.stringify(updateData)
            });

            if (!updateResponse.ok) {
                throw await updateResponse.json();
            }

            console.log('Horario actualizado con éxito');
            calendar.refetchEvents(); // Refrescar el calendario para asegurar consistencia

        } catch (error) {
            console.error('Error al actualizar el horario:', error);
            alert('Ocurrió un error al intentar actualizar el horario.');
            info.revert();
        }
    };
});