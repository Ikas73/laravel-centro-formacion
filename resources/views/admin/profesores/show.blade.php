@extends('layouts.admin')

@section('title', 'Detalles del Profesor: ' . $profesore->nombre . ' ' . $profesore->apellido1)
@section('page-title', 'Detalles del Profesor')

@section('content')
    {{-- Bloque de Mensajes Flash --}}
    @if (session('success'))
        <div class="mb-6 px-4 py-3 rounded-lg relative bg-gradient-to-r from-green-50 to-green-100 border-l-4 border-green-400 text-green-800 shadow-sm animate-fadeIn" role="alert">
            <div class="flex items-center">
                <i class="bi bi-check-circle-fill text-green-500 mr-3"></i>
                <div><strong class="font-semibold">¡Éxito!</strong> <p class="text-sm mt-1">{{ session('success') }}</p></div>
            </div>
        </div>
    @endif
    @if (session('error'))
         <div class="mb-6 px-4 py-3 rounded-lg relative bg-gradient-to-r from-red-50 to-red-100 border-l-4 border-red-400 text-red-800 shadow-sm animate-fadeIn" role="alert">
            <div class="flex items-center">
                <i class="bi bi-exclamation-triangle-fill text-red-500 mr-3"></i>
                <div><strong class="font-semibold">¡Atención!</strong> <p class="text-sm mt-1">{{ session('error') }}</p></div>
            </div>
        </div>
    @endif

    <div class="bg-white p-6 md:p-8 rounded-xl shadow-lg border border-gray-200">
        {{-- Cabecera con Avatar e Info Principal --}}
        <div class="flex flex-col md:flex-row items-center md:items-start mb-6 pb-6 border-b border-gray-200">
            <div class="flex-shrink-0 mb-4 md:mb-0 md:mr-8">
            {{-- DESPUÉS (con comprobaciones): --}}
@php
    $inicialNombre = (!empty($profesore->nombre)) ? $profesore->nombre[0] : '';
    $inicialApellido = (!empty($profesore->apellido1)) ? $profesore->apellido1[0] : '';
    $nombreParaAvatar = trim($inicialNombre . $inicialApellido);
    // Si después de todo no hay iniciales (ej: nombres vacíos), ponemos un placeholder para el avatar
    if (empty($nombreParaAvatar)) {
        $nombreParaAvatar = 'N A'; // O simplemente "P" de Profesor
    }
@endphp
<img class="h-32 w-32 rounded-full object-cover shadow-md ring-2 ring-indigo-200"
     src="https://ui-avatars.com/api/?name={{ urlencode($nombreParaAvatar) }}&size=128&background=6366F1&color=FFFFFF&bold=true"
     alt="Avatar de {{ $profesore->nombre ?? 'Profesor' }}">
            </div>
            <div class="text-center md:text-left">
                <h2 class="text-3xl font-bold text-gray-900">{{ $profesore->nombre }} {{ $profesore->apellido1 }} {{ $profesore->apellido2 ?? '' }}</h2>
                <p class="text-md text-gray-600 mt-1">ID Profesor (DNI): {{ $profesore->dni ?? 'N/A' }}</p>
                <p class="text-sm text-gray-500 mt-1">{{ $profesore->email ?? 'Email no especificado' }}</p>
            </div>
        </div>

        {{-- Detalles Adicionales en Grid --}}
        <h3 class="text-xl font-semibold text-gray-800 mb-4 mt-6">Información Detallada</h3>
        <dl class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-x-6 gap-y-4 text-sm">
            <div class="bg-gray-50 p-3 rounded-lg">
                <dt class="font-medium text-gray-500">Fecha de Nacimiento</dt>
                <dd class="mt-1 text-gray-900">{{ $profesore->fecha_nacimiento ? \Carbon\Carbon::parse($profesore->fecha_nacimiento)->format('d/m/Y') : 'No especificada' }}</dd>
            </div>
            <div class="bg-gray-50 p-3 rounded-lg">
                <dt class="font-medium text-gray-500">Sexo</dt>
                <dd class="mt-1 text-gray-900">{{ $profesore->sexo ?? 'No especificado' }}</dd>
            </div>
            <div class="bg-gray-50 p-3 rounded-lg">
                <dt class="font-medium text-gray-500">Teléfono</dt>
                <dd class="mt-1 text-gray-900">{{ $profesore->telefono ?? 'No especificado' }}</dd>
            </div>
            <div class="bg-gray-50 p-3 rounded-lg md:col-span-2 lg:col-span-3"> {{-- Dirección ocupa más espacio --}}
                <dt class="font-medium text-gray-500">Dirección</dt>
                <dd class="mt-1 text-gray-900">{{ $profesore->direccion ?? 'No especificada' }}</dd>
            </div>
            <div class="bg-gray-50 p-3 rounded-lg">
                <dt class="font-medium text-gray-500">Nº Seguridad Social</dt>
                <dd class="mt-1 text-gray-900">{{ $profesore->num_seguridad_social ?? 'No especificado' }}</dd>
            </div>
            <div class="bg-gray-50 p-3 rounded-lg">
                <dt class="font-medium text-gray-500">Titulación Académica</dt>
                <dd class="mt-1 text-gray-900">{{ $profesore->titulacion_academica ?? 'No especificada' }}</dd>
            </div>
            <div class="bg-gray-50 p-3 rounded-lg">
                <dt class="font-medium text-gray-500">Especialidad</dt>
                <dd class="mt-1 text-gray-900">{{ $profesore->especialidad ?? 'No especificada' }}</dd>
            </div>
        </dl>

        {{-- Sección de Cursos Impartidos --}}
        <div class="mt-8 pt-6 border-t border-gray-200">
            <h3 class="text-xl font-semibold text-gray-800 mb-4">Cursos Impartidos</h3>
            @if ($profesore->relationLoaded('cursos') && $profesore->cursos->count() > 0)
                <ul class="divide-y divide-gray-100">
                    @foreach ($profesore->cursos as $curso)
                        <li class="py-3">
                            <a href="{{ route('admin.cursos.show', $curso->id) }}" class="font-medium text-indigo-600 hover:text-indigo-800 hover:underline">
                                {{ $curso->nombre }}
                            </a>
                            <span class="text-xs text-gray-500 ml-2">({{ $curso->codigo }})</span>
                            <p class="text-xs text-gray-500">
                                Del {{ $curso->fecha_inicio ? \Carbon\Carbon::parse($curso->fecha_inicio)->format('d/m/Y') : 'N/A' }}
                                al {{ $curso->fecha_fin ? \Carbon\Carbon::parse($curso->fecha_fin)->format('d/m/Y') : 'N/A' }}
                            </p>
                        </li>
                    @endforeach
                </ul>
            @else
                 <p class="text-sm text-gray-500">Este profesor no tiene cursos asignados actualmente.</p>
            @endif
        </div>

        {{-- Botones de Acción --}}
        <div class="mt-8 pt-6 border-t border-gray-200 flex flex-col sm:flex-row justify-end gap-3">
            <a href="{{ route('admin.profesores.index') }}"
               class="px-6 py-2.5 text-sm font-medium text-gray-700 bg-white border border-gray-300 rounded-lg shadow-sm hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 transition-colors text-center">
                Volver a la Lista
            </a>
            <a href="{{ route('admin.profesores.edit', ['profesore' => $profesore]) }}" class="px-6 py-2.5 text-sm font-medium text-white bg-indigo-600 border border-transparent rounded-lg shadow-sm hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 transition-colors text-center">
            Editar Profesor
            </a>
            
        </div>
    </div>
@endsection

@push('scripts')
    {{-- No se necesitan scripts específicos para esta vista por ahora --}}
@endpush