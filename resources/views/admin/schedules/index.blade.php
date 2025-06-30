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
    </div>
@endsection

@push('scripts')
    {{-- La única línea necesaria. Vite se encargará de inyectar todo el JS y CSS requerido. --}}
    @vite(['resources/js/schedules.js', 'node_modules/@fullcalendar/core/main.css'])
@endpush