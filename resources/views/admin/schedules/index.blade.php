@extends('layouts.admin')

@section('title', 'Gestión de Horarios')
@section('page-title', 'Calendario de Horarios')

@push('styles')
    {{-- Estilos para el contenido extra en los eventos --}}
    <style>
        .fc-event-profesor, .fc-event-aula {
            font-size: 0.8em;
            margin-top: 2px;
        }
        .fc-event-profesor i, .fc-event-aula i {
            margin-right: 4px;
        }
    </style>
@endpush

@section('content')
    <div class="bg-white rounded-3xl shadow-2xl shadow-gray-200/50 border border-gray-200/100 p-6">
        <div id="calendar"></div>

<!-- Modal para Crear/Editar Horario -->
<div id="scheduleModal" class="fixed inset-0 bg-gray-900 bg-opacity-50 hidden flex items-center justify-center z-50">
    <div class="bg-white rounded-2xl shadow-xl w-full max-w-4xl p-6 transform transition-all -translate-y-10">
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
    </div>
@endsection

@push('scripts')
    {{-- Pasamos los datos del backend a variables de JavaScript --}}
    <script>
        window.cursosData = {!! $cursos->toJson() !!};
        window.profesoresData = {!! $profesores->toJson() !!};
    </script>

    {{-- La única línea necesaria. Vite se encargará de inyectar todo el JS y CSS requerido. --}}
    @vite(['resources/js/schedules.js', 'node_modules/@fullcalendar/core/main.css'])
@endpush