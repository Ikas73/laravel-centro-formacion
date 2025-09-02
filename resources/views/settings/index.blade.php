@extends('layouts.admin')

@section('title', 'Configuración General')
@section('page-title', 'Configuración General')

@push('styles')
<style>
    /* Estilo para ocultar elementos hasta que Alpine.js se cargue, evitando parpadeos */
    [x-cloak] { display: none !important; }
</style>
@endpush

@section('content')
    {{-- Mensajes Flash para notificaciones de éxito --}}
    @if (session('success'))
        <div class="mb-6 px-4 py-3 rounded-lg relative bg-green-100 border-l-4 border-green-500 text-green-700" role="alert">
            <strong class="font-bold">¡Éxito!</strong>
            <span class="block sm:inline">{{ session('success') }}</span>
        </div>
    @endif
    
    {{-- Contenedor principal con inicialización de Alpine.js --}}
    {{-- La variable $activeTab viene del controlador --}}
    <div x-data="{ activeTab: '{{ $activeTab }}' }">
    
        <!-- Navegación por Pestañas -->
        <div class="mb-6 border-b border-gray-200">
            <nav class="-mb-px flex space-x-6" aria-label="Tabs">
                
                {{-- Pestaña Institución --}}
                @can('manage_institution_settings')
                <a href="{{ route('settings.index', ['tab' => 'institution']) }}"
                   @click.prevent="activeTab = 'institution'; window.history.pushState({}, '', '{{ route('settings.index', ['tab' => 'institution']) }}')"
                   :class="{ 'border-indigo-500 text-indigo-600': activeTab === 'institution', 'border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300': activeTab !== 'institution' }"
                   class="whitespace-nowrap py-4 px-1 border-b-2 font-medium text-sm transition-colors duration-200">
                    Institución
                </a>
                @endcan

                {{-- Pestaña Académico --}}
                @can('manage_academic_settings')
                <a href="{{ route('settings.index', ['tab' => 'academic']) }}"
                   @click.prevent="activeTab = 'academic'; window.history.pushState({}, '', '{{ route('settings.index', ['tab' => 'academic']) }}')"
                   :class="{ 'border-indigo-500 text-indigo-600': activeTab === 'academic', 'border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300': activeTab !== 'academic' }"
                   class="whitespace-nowrap py-4 px-1 border-b-2 font-medium text-sm transition-colors duration-200">
                    Académico
                </a>
                @endcan

                {{-- Espacio para futuras pestañas, por ejemplo:
                @can('manage_roles')
                <a href="#" @click.prevent="activeTab = 'roles'" ...>Roles y Permisos</a>
                @endcan
                --}}
            </nav>
        </div>

        <!-- Contenido de las Pestañas -->
        <div class="bg-white p-6 md:p-8 rounded-xl shadow-lg border border-gray-200">
        
            {{-- Pestaña de Institución --}}
            <div x-show="activeTab === 'institution'" x-cloak>
                {{-- Incluimos el parcial que creamos --}}
                @include('settings.partials.institution-form')
            </div>

            {{-- Pestaña Académica --}}
            <div x-show="activeTab === 'academic'" x-cloak>
                {{-- Incluimos el parcial que creamos --}}
                @include('settings.partials.academic-years-list')
            </div>

            {{-- Futuro contenido de otras pestañas iría aquí --}}
            {{-- <div x-show="activeTab === 'roles'" x-cloak> ... </div> --}}
        </div>
    </div>
@endsection