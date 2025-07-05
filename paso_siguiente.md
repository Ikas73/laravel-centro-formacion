¡Perfecto! Este es el siguiente paso lógico y uno de los más satisfactorios. Vamos a hacer que el calendario pase de ser una simple vista a una herramienta de creación interactiva.

Usaremos una técnica moderna: en lugar de recargar la página, el formulario aparecerá en un modal, y la comunicación con el servidor se hará en segundo plano usando AJAX.

---

### **Ejercicio Guiado (Parte 7): Creación Interactiva de Horarios con un Modal**

**Objetivo:** Al hacer clic en una franja horaria vacía, se abrirá un modal para crear un nuevo `Schedule`. Al guardarlo, el evento aparecerá en el calendario al instante, sin recargar la página.

#### **Paso 1: Añadir el Modal a la Vista**

Primero, necesitamos el HTML del modal. Estará oculto por defecto y lo mostraremos con JavaScript.

Abre `resources/views/admin/schedules/index.blade.php` y pega este bloque de código **dentro** de la sección `@section('content')`, pero **después** del `div` del calendario.

```blade
{{-- Pega esto después de <div id="calendar"></div> --}}

<!-- Modal para Crear/Editar Horario -->
<div id="scheduleModal" class="fixed inset-0 bg-gray-900 bg-opacity-50 hidden items-center justify-center z-50">
    <div class="bg-white rounded-2xl shadow-xl w-full max-w-lg p-6 transform transition-all -translate-y-10">
        <div class="flex items-center justify-between pb-4 border-b border-gray-200">
            <h3 id="modalTitle" class="text-xl font-bold text-gray-800">Añadir Nueva Franja Horaria</h3>
            <button id="closeModalBtn" class="p-2 rounded-full hover:bg-gray-200">
                <i class="bi bi-x text-2xl text-gray-600"></i>
            </button>
        </div>

        <form id="scheduleForm" class="mt-6 space-y-4">
            {{-- Campo oculto para el ID del horario (para la edición) --}}
            <input type="hidden" id="schedule_id" name="schedule_id">

            {{-- Fila para Curso y Profesor --}}
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <div>
                    <label for="curso_id" class="block text-sm font-medium text-gray-700 mb-1">Curso</label>
                    <select id="curso_id" name="curso_id" class="w-full px-4 py-2.5 border border-gray-300 rounded-lg shadow-sm focus:ring-indigo-500 focus:border-indigo-500">
                        {{-- Las opciones se llenarán dinámicamente --}}
                    </select>
                    <p id="error-curso_id" class="text-red-500 text-xs mt-1"></p>
                </div>
                <div>
                    <label for="profesor_id" class="block text-sm font-medium text-gray-700 mb-1">Profesor</label>
                    <select id="profesor_id" name="profesor_id" class="w-full px-4 py-2.5 border border-gray-300 rounded-lg shadow-sm focus:ring-indigo-500 focus:border-indigo-500">
                        {{-- Las opciones se llenarán dinámicamente --}}
                    </select>
                    <p id="error-profesor_id" class="text-red-500 text-xs mt-1"></p>
                </div>
            </div>

            {{-- Fila para Horas y Aula --}}
            <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                <div>
                    <label for="start_time" class="block text-sm font-medium text-gray-700 mb-1">Hora Inicio</label>
                    <input type="time" id="start_time" name="start_time" class="w-full px-4 py-2.5 border border-gray-300 rounded-lg shadow-sm focus:ring-indigo-500 focus:border-indigo-500" step="1800">
                    <p id="error-start_time" class="text-red-500 text-xs mt-1"></p>
                </div>
                <div>
                    <label for="end_time" class="block text-sm font-medium text-gray-700 mb-1">Hora Fin</label>
                    <input type="time" id="end_time" name="end_time" class="w-full px-4 py-2.5 border border-gray-300 rounded-lg shadow-sm focus:ring-indigo-500 focus:border-indigo-500" step="1800">
                    <p id="error-end_time" class="text-red-500 text-xs mt-1"></p>
                </div>
                <div>
                    <label for="room" class="block text-sm font-medium text-gray-700 mb-1">Aula</label>
                    <input type="text" id="room" name="room" class="w-full px-4 py-2.5 border border-gray-300 rounded-lg shadow-sm focus:ring-indigo-500 focus:border-indigo-500">
                    <p id="error-room" class="text-red-500 text-xs mt-1"></p>
                </div>
            </div>

            {{-- Campo oculto para el día de la semana --}}
            <input type="hidden" id="weekday" name="weekday">

            {{-- Botones de acción --}}
            <div class="pt-6 flex justify-end gap-3 border-t border-gray-200">
                <button type="button" id="cancelBtn" class="px-6 py-2.5 text-sm font-medium text-gray-700 bg-white border border-gray-300 rounded-lg hover:bg-gray-50">
                    Cancelar
                </button>
                <button type="submit" id="saveBtn" class="px-6 py-2.5 text-sm font-medium text-white bg-indigo-600 rounded-lg hover:bg-indigo-700">
                    Guardar Horario
                </button>
            </div>
        </form>
    </div>
</div>
```

#### **Paso 2: Pasar los Datos para los Selects (Cursos y Profesores)**

Necesitamos que el controlador envíe la lista de cursos y profesores a la vista para poder llenar los menús desplegables del modal.

Modifica el método `index()` en tu `ScheduleController.php`:

```php
// app/Http/Controllers/Admin/ScheduleController.php

// ... (asegúrate de que Curso y Profesor están importados con 'use')

public function index()
{
    // Obtenemos los datos necesarios para los selects del formulario del modal
    $cursos = Curso::orderBy('nombre')->get(['id', 'nombre']);
    $profesores = Profesor::orderBy('apellido1')->get(['id', 'nombre', 'apellido1']);

    return view('admin.schedules.index', compact('cursos', 'profesores'));
}
```

#### **Paso 3: JavaScript para Gestionar el Modal y Enviar Datos**

Esta es la parte más importante. Reemplazaremos el contenido de `resources/js/schedules.js` con una nueva versión que incluye la lógica para abrir el modal, manejar el formulario y comunicarse con el backend.

```javascript
// resources/js/schedules.js

import { Calendar } from '@fullcalendar/core';
import timeGridPlugin from '@fullcalendar/timegrid';
import dayGridPlugin from '@fullcalendar/daygrid';
import interactionPlugin from '@fullcalendar/interaction'; // ¡NUEVO! Para detectar clics

document.addEventListener('DOMContentLoaded', function() {
    // --- OBTENER REFERENCIAS A ELEMENTOS DEL MODAL ---
    const scheduleModal = document.getElementById('scheduleModal');
    const modalTitle = document.getElementById('modalTitle');
    const closeModalBtn = document.getElementById('closeModalBtn');
    const cancelBtn = document.getElementById('cancelBtn');
    const scheduleForm = document.getElementById('scheduleForm');
    const saveBtn = document.getElementById('saveBtn');

    // --- LÓGICA PARA CERRAR EL MODAL ---
    const hideModal = () => scheduleModal.classList.add('hidden');
    closeModalBtn.addEventListener('click', hideModal);
    cancelBtn.addEventListener('click', hideModal);

    // --- INICIALIZACIÓN DEL CALENDARIO ---
    var calendarEl = document.getElementById('calendar');
    if (calendarEl) {
        var calendar = new Calendar(calendarEl, {
            // --- PLUGINS Y CONFIGURACIÓN ---
            plugins: [ timeGridPlugin, dayGridPlugin, interactionPlugin ], // Añadido 'interactionPlugin'
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
            
            // --- EVENTO PARA ABRIR EL MODAL AL HACER CLIC EN UNA FECHA ---
            dateClick: function(info) {
                scheduleForm.reset(); // Limpiar el formulario
                modalTitle.innerText = 'Añadir Nueva Franja Horaria';
                saveBtn.innerText = 'Guardar Horario';

                // Pre-rellenar fecha y hora
                const date = new Date(info.dateStr);
                document.getElementById('start_time').value = date.toTimeString().substring(0, 5);
                document.getElementById('weekday').value = date.getDay() === 0 ? 7 : date.getDay(); // Domingo es 0, lo pasamos a 7

                scheduleModal.classList.remove('hidden');
            },

            eventDidMount: function(info) { /* ... (esta función se queda como estaba) ... */ }
        });
        
        // Cargar las opciones de los selects desde el backend
        const cursos = JSON.parse('{!! $cursos->toJson() !!}');
        const profesores = JSON.parse('{!! $profesores->toJson() !!}');
        
        const cursoSelect = document.getElementById('curso_id');
        cursos.forEach(curso => {
            cursoSelect.options.add(new Option(curso.nombre, curso.id));
        });

        const profesorSelect = document.getElementById('profesor_id');
        profesores.forEach(profesor => {
            profesorSelect.options.add(new Option(`${profesor.nombre} ${profesor.apellido1}`, profesor.id));
        });

        calendar.render();
    }

    // --- LÓGICA PARA ENVIAR EL FORMULARIO ---
    scheduleForm.addEventListener('submit', function(e) {
        e.preventDefault(); // Prevenir recarga de página

        const formData = new FormData(this);
        const data = Object.fromEntries(formData.entries());

        // Obtener el token CSRF (debe estar en tu layout principal)
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
        .then(response => response.json())
        .then(data => {
            if(data.errors) {
                // Manejar errores de validación (mostrarlos en el formulario)
                Object.keys(data.errors).forEach(key => {
                    const errorP = document.getElementById(`error-${key}`);
                    if (errorP) errorP.innerText = data.errors[key][0];
                });
            } else {
                hideModal();
                calendar.refetchEvents(); // ¡La clave! Recarga los eventos para mostrar el nuevo.
                // Aquí podrías añadir una notificación de éxito
            }
        })
        .catch(error => console.error('Error:', error));
    });
});
```
*Aviso: Este código espera que tengas un `meta` tag con el token CSRF en tu layout principal (`layouts/admin.blade.php`), lo cual es estándar en Laravel. Si no lo tienes, añádelo en la sección `<head>`: `<meta name="csrf-token" content="{{ csrf_token() }}">`.*

#### **Paso 4: Adaptar el Método `store()` para AJAX**

Tu método `store()` actual redirige la página, lo cual no funciona con AJAX. Necesitamos que devuelva una respuesta JSON.

Abre `ScheduleController.php` y reemplaza tu método `store()` con este:

```php
// app/Http/Controllers/Admin/ScheduleController.php

public function store(StoreScheduleRequest $request)
{
    $validated = $request->validated();

    // Tu lógica actual para crear el TimeSlot y el Schedule es perfecta.
    $timeSlot = TimeSlot::firstOrCreate([
        'weekday'    => $validated['weekday'],
        'start_time' => $validated['start_time'],
        'end_time'   => $validated['end_time'],
        'room'       => $validated['room'],
    ]);

    Schedule::create([
        'curso_id'     => $validated['curso_id'],
        'profesor_id'  => $validated['profesor_id'],
        'time_slot_id' => $timeSlot->id,
    ]);

    // En lugar de redirigir, devolvemos una respuesta JSON de éxito.
    return response()->json(['message' => 'Horario creado con éxito.'], 201);
}
```

---

**¡Ejercicio 7 Completado!**

Recarga la página. Ahora deberías poder:
1.  Hacer clic en cualquier parte vacía del calendario.
2.  Ver cómo se abre el modal con los campos listos.
3.  Llenar el formulario y hacer clic en "Guardar Horario".
4.  Ver cómo el modal se cierra y el nuevo evento aparece instantáneamente en el calendario.

¡Adelante! Pruébalo y avísame qué tal ha ido.