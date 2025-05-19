@extends('layouts.admin') {{-- Usar el layout de administración --}}

@section('title', 'Gestión de Alumnos') {{-- Título de la pestaña del navegador --}}

@section('page-title', 'Gestión de Alumnos') {{-- Título que se mostrará en el header del layout admin --}}

@section('content')
    {{-- El layout ya tiene un padding general, pero podemos usar un contenedor si es necesario --}}
    {{-- <div class="container-fluid px-4"> --}}

        {{-- KPIs (Tarjetas de Resumen) - Placeholder --}}
        {{-- Sustituye el div placeholder de KPIs con esto: --}}

<!-- KPIs / Tarjetas de Resumen -->
<div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4 mb-6">

    {{-- Tarjeta 1: Total Alumnos Activos --}}
    <div class="bg-white p-5 rounded-lg shadow">
        <p class="text-xs font-medium text-gray-500 uppercase">Total Alumnos Activos</p>
        <p class="text-3xl font-bold text-gray-800 mt-1">{{ $totalAlumnosActivos ?? '0' }}</p>
        {{-- <p class="text-xs text-green-500 mt-1"><i class="bi bi-arrow-up-short"></i> 5.2% respecto al mes anterior</p> --}}
    </div>

    {{-- Tarjeta 2: Nuevos Alumnos (Este Mes) --}}
    <div class="bg-white p-5 rounded-lg shadow">
        <p class="text-xs font-medium text-gray-500 uppercase">Nuevos Alumnos (Este Mes)</p>
        <p class="text-3xl font-bold text-gray-800 mt-1">{{ $nuevosAlumnosEsteMes ?? '0' }}</p>
        {{-- <p class="text-xs text-green-500 mt-1"><i class="bi bi-arrow-up-short"></i> 12% respecto al mes anterior</p> --}}
    </div>

    {{-- Tarjeta 3: Ratio Alumno-Profesor --}}
    <div class="bg-white p-5 rounded-lg shadow">
        <p class="text-xs font-medium text-gray-500 uppercase">Ratio Alumno-Profesor</p>
        <p class="text-3xl font-bold text-gray-800 mt-1">{{ $ratioAlumnoProfesor ?? 'N/A' }}</p>
        {{-- <p class="text-xs text-gray-400 mt-1">Sin cambios respecto al mes anterior</p> --}}
    </div>

    {{-- Tarjeta 4: Tasa de Asistencia --}}
    <div class="bg-white p-5 rounded-lg shadow">
        <p class="text-xs font-medium text-gray-500 uppercase">Tasa de Asistencia</p>
        <p class="text-3xl font-bold text-green-600 mt-1">{{ $tasaAsistencia ?? 'N/A' }}</p> {{-- Color verde para la tasa --}}
        {{-- <p class="text-xs text-green-500 mt-1"><i class="bi bi-arrow-up-short"></i> 1.2% respecto al mes anterior</p> --}}
    </div>

</div>
<!-- Fin KPIs -->

{{-- Los otros placeholders (Filtros, Tabla, Paginación) --}}

        {{-- Filtros y Buscador - Placeholder --}}
        

<!-- Filtros, Buscador y Botón de Acción -->
{{-- ¡ENVOLVEMOS TODO EN UN ÚNICO FORMULARIO GET! --}}
<form method="GET" action="{{ route('admin.alumnos.index') }}" class="mb-6">
    <div class="flex flex-col sm:flex-row justify-between items-center gap-4">
        {{-- Lado Izquierdo: Buscador y Filtros --}}
        <div class="flex flex-col sm:flex-row items-center gap-3 w-full sm:w-auto">
            {{-- Buscador --}}
            <div class="relative w-full sm:w-64">
                <span class="absolute inset-y-0 left-0 flex items-center pl-3">
                    <i class="bi bi-search text-gray-400"></i>
                </span>
                <input type="text" name="search" id="search"
                       class="block w-full pl-10 pr-3 py-2 border border-gray-300 rounded-md leading-5 bg-white placeholder-gray-500 focus:outline-none focus:placeholder-gray-400 focus:ring-1 focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm"
                       placeholder="Buscar por nombre o ID"
                       value="{{ $searchTerm ?? '' }}"> {{-- Usar $searchTerm pasado del controlador --}}
            </div>

            {{-- Filtro Grados (Dropdown <select>) --}}
            <div class="w-full sm:w-auto">
                <select name="grado" id="grado"
                        class="block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm py-2">
                    <option value="">Todos los Grados</option>
                    @foreach ($opcionesGrado as $grado)
                        <option value="{{ $grado }}" {{ ($filtroGrado == $grado) ? 'selected' : '' }}>
                            {{ $grado }}
                        </option>
                    @endforeach
                </select>
            </div>

            {{-- Filtro Estados (Dropdown <select>) --}}
            <div class="w-full sm:w-auto">
                <select name="estado_filtro" id="estado_filtro"
                        class="block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm py-2">
                    <option value="">Todos los Estados</option>
                    @foreach ($opcionesEstado as $estado)
                        <option value="{{ $estado }}" {{ ($filtroEstado == $estado) ? 'selected' : '' }}>
                            {{ $estado }}
                        </option>
                    @endforeach
                </select>
            </div>

            {{-- Botón para aplicar filtros/búsqueda --}}
            <button type="submit"
                    class="w-full sm:w-auto inline-flex items-center justify-center px-4 py-2 border border-transparent shadow-sm text-sm font-medium rounded-md text-white bg-gray-600 hover:bg-gray-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-gray-500">
                Filtrar/Buscar
            </button>

        </div>

        {{-- Lado Derecho: Botón Añadir Nuevo Alumno (fuera del form de búsqueda/filtros) --}}
        <div class="w-full sm:w-auto flex-shrink-0 mt-3 sm:mt-0">
            <a href="{{ route('admin.alumnos.create') }}"
               class="w-full sm:w-auto inline-flex items-center justify-center px-4 py-2 border border-transparent shadow-sm text-sm font-medium rounded-md text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                <i class="bi bi-plus-lg me-2"></i>
                Añadir Nuevo Alumno
            </a>
        </div>
    </div>
</form>
<!-- Fin Filtros y Buscador -->

{{-- El placeholder de la Tabla de Alumnos sigue igual por ahora --}}

        {{-- Tabla de Alumnos - Placeholder --}}        

<!-- Tabla de Alumnos -->
<div class="bg-white rounded-lg shadow overflow-x-auto"> {{-- Contenedor de la tabla para sombra y overflow --}}
    <table class="min-w-full divide-y divide-gray-200">
        <thead class="bg-gray-50">
            <tr>
                <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                    Alumno
                </th>
                <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                    ID Alumno
                </th>
                <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                    Grado/Año
                </th>
                <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                    Email
                </th>
                <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                    Estado
                </th>
                <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                    Acciones
                </th>
            </tr>
        </thead>
        <tbody class="bg-white divide-y divide-gray-200">
            {{-- Iterar sobre los alumnos pasados desde el controlador --}}
            @forelse ($alumnos as $alumno)
                <tr>
                    <td class="px-6 py-4 whitespace-nowrap">
                        <div class="flex items-center">
                            <div class="flex-shrink-0 h-10 w-10">
                                {{-- Placeholder para Avatar --}}
                                <img class="h-10 w-10 rounded-full" src="https://ui-avatars.com/api/?name={{ urlencode($alumno->nombre . ' ' . $alumno->apellido1) }}&color=7F9CF5&background=EBF4FF" alt="Avatar de {{ $alumno->nombre }}">
                            </div>
                            <div class="ml-4">
                                <div class="text-sm font-medium text-gray-900">
                                    {{ $alumno->nombre }} {{ $alumno->apellido1 }} {{ $alumno->apellido2 }}
                                </div>
                                {{-- <div class="text-xs text-gray-500">Opcional: Otro dato debajo del nombre</div> --}}
                            </div>
                        </div>
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap">
                        <div class="text-sm text-gray-900">{{-- STU-{{ str_pad($alumno->id, 4, '0', STR_PAD_LEFT) }} --}} {{-- Ejemplo de ID formateado --}}
                            {{-- Asumiendo que el DNI puede servir como ID de alumno por ahora --}}
                            {{ $alumno->dni ?? 'N/A' }}
                        </div>
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap">
                        <div class="text-sm text-gray-500">{{ $alumno->nivel_formativo ?? 'N/A' }}</div> {{-- O un campo específico de 'grado' si lo tienes --}}
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap">
                        <div class="text-sm text-gray-500">{{ $alumno->email ?? 'N/A' }}</div>
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap">
                        {{-- Lógica para el badge de estado --}}
                        {{-- Asumiendo que tienes un campo 'estado' en tu modelo Alumno --}}
                        @php
                            $estado = $alumno->estado ?? 'Desconocido'; // Valor por defecto
                            $badgeColor = 'bg-gray-100 text-gray-800'; // Color por defecto
                            if ($estado === 'Activo') {
                                $badgeColor = 'bg-green-100 text-green-800';
                            } elseif ($estado === 'Inactivo') {
                                $badgeColor = 'bg-red-100 text-red-800';
                            } elseif ($estado === 'Pendiente') {
                                $badgeColor = 'bg-yellow-100 text-yellow-800';
                            }
                        @endphp
                        <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full {{ $badgeColor }}">
                            {{ $estado }}
                        </span>
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                        <a href="{{-- route('admin.alumnos.show', $alumno->id) --}}" class="text-gray-400 hover:text-blue-600 mr-3" title="Ver">
                            <i class="bi bi-eye-fill"></i>
                        </a>
                        <a href="{{-- route('admin.alumnos.edit', $alumno->id) --}}" class="text-gray-400 hover:text-indigo-600 mr-3" title="Editar">
                            <i class="bi bi-pencil-fill"></i>
                        </a>
                        {{-- El botón de eliminar usualmente requiere un formulario y confirmación --}}
                        <button type="button" class="text-gray-400 hover:text-red-600" title="Eliminar" onclick="alert('Funcionalidad de eliminar pendiente para Alumno ID: {{ $alumno->id }}')">
                            <i class="bi bi-trash-fill"></i>
                        </button>
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="6" class="px-6 py-4 whitespace-nowrap text-sm text-gray-500 text-center">
                        No se encontraron alumnos que coincidan con la búsqueda o filtros.
                    </td>
                </tr>
            @endforelse
        </tbody>
    </table>
</div>
<!-- Fin Tabla de Alumnos -->

{{-- El placeholder de la Paginación sigue igual por ahora --}}

        {{-- Paginación - Placeholder --}}
        {{-- Sustituye el div placeholder de la Paginación con esto: --}}

<!-- Paginación -->
@if ($alumnos->hasPages())
    <div class="mt-6 px-2 py-3 bg-white rounded-lg shadow">
        {{-- ANTES: {{ $alumnos->links() }} --}}
        {{-- AHORA (para mantener el filtro de búsqueda): --}}
        {{ $alumnos->appends(request()->query())->links() }}
    </div>
@endif
<!-- Fin Paginación -->

{{-- El footer "© 2025 Laravel" está en el layout layouts/admin.blade.php --}}
{{-- Si quieres un footer específico para esta sección, puedes añadirlo aquí,
    pero es más común tener un footer global en el layout. --}}

@endsection {{-- Cierre de @section('content') --}}

@push('scripts')
    {{-- Tus scripts de Chart.js o cualquier otro script específico para esta página --}}
@endpush