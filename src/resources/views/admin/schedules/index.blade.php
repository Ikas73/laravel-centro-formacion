@extends('layouts.admin')

@section('title', 'Gestión de Horarios')
@section('page-title', 'Calendario de Horarios')

{{-- La sección de styles debe estar vacía o no existir --}}
@push('styles')
@endpush

@section('content')
    <div class="bg-white rounded-3xl shadow-2xl shadow-gray-200/50 border border-gray-200/100 p-6">
        <div id="calendar"></div>
    </div>
@endsection

{{-- La sección de scripts solo debe tener la directiva de Vite --}}
@push('scripts')
    {{-- ¡Importante! Ahora cargamos ambos assets compilados por Vite --}}
    @vite(['resources/js/schedules.js', 'node_modules/@fullcalendar/core/main.css'])
@endpush