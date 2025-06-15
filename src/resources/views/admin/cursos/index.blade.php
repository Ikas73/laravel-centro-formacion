@extends('layouts.admin')

@section('title', 'Gestión de Cursos')
@section('page-title', 'Gestión de Cursos')

@section('content')
    {{-- Mensajes Flash Mejorados --}}
    @if (session('success'))
        <div class="mb-8 px-6 py-4 rounded-2xl relative bg-gradient-to-r from-emerald-50 via-green-50 to-emerald-50 border border-emerald-200 text-emerald-800 shadow-lg shadow-emerald-100/50 animate-slideInDown" role="alert">
            <div class="flex items-start">
                <div class="flex-shrink-0 mt-0.5">
                    <div class="w-8 h-8 bg-emerald-500 rounded-full flex items-center justify-center shadow-sm">
                        <i class="bi bi-check-lg text-white text-sm font-bold"></i>
                    </div>
                </div>
                <div class="ml-4 flex-1">
                    <div class="text-sm font-semibold text-emerald-900">Operación exitosa</div>
                    <div class="mt-1 text-sm text-emerald-700">{{ session('success') }}</div>
                </div>
                <button type="button" onclick="this.parentElement.parentElement.remove()" 
                        class="flex-shrink-0 ml-4 p-1 rounded-full hover:bg-emerald-200 transition-colors">
                    <i class="bi bi-x text-emerald-600 text-lg"></i>
                </button>
            </div>
        </div>
    @endif
    
    @if (session('error'))
        <div class="mb-8 px-6 py-4 rounded-2xl relative bg-gradient-to-r from-red-50 via-rose-50 to-red-50 border border-red-200 text-red-800 shadow-lg shadow-red-100/50 animate-slideInDown" role="alert">
            <div class="flex items-start">
                <div class="flex-shrink-0 mt-0.5">
                    <div class="w-8 h-8 bg-red-500 rounded-full flex items-center justify-center shadow-sm">
                        <i class="bi bi-exclamation-lg text-white text-sm font-bold"></i>
                    </div>
                </div>
                <div class="ml-4 flex-1">
                    <div class="text-sm font-semibold text-red-900">Atención requerida</div>
                    <div class="mt-1 text-sm text-red-700">{{ session('error') }}</div>
                </div>
                <button type="button" onclick="this.parentElement.parentElement.remove()" 
                        class="flex-shrink-0 ml-4 p-1 rounded-full hover:bg-red-200 transition-colors">
                    <i class="bi bi-x text-red-600 text-lg"></i>
                </button>
            </div>
        </div>
    @endif

    
    {{-- KPIs Compactos con Diseño Premium --}}
    {{-- KPIs Compactos con Diseño Premium OPTIMIZADO --}}
<div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-3 sm:gap-4 mb-8">

{{-- Cursos Activos --}}
<div class="group relative overflow-hidden bg-gradient-to-br from-blue-50 via-white to-blue-50 p-4 rounded-2xl shadow-lg shadow-blue-100/25 border border-blue-100/50 hover:shadow-xl hover:shadow-blue-200/30 transition-all duration-300 hover:-translate-y-1 min-h-[120px]">
    <div class="absolute inset-0 bg-gradient-to-br from-transparent via-blue-50/30 to-blue-100/20 opacity-0 group-hover:opacity-100 transition-opacity duration-300"></div>
    <div class="relative z-10 flex h-full">
        {{-- Icono a la izquierda --}}
        <div class="flex-shrink-0 p-3 bg-gradient-to-br from-blue-500 to-blue-600 rounded-xl shadow-md shadow-blue-500/25 group-hover:shadow-blue-500/40 transition-all duration-300 group-hover:scale-105 h-fit">
            <i class="bi bi-journals text-xl text-white"></i>
        </div>
        
        {{-- Información organizada horizontalmente --}}
        <div class="flex-1 ml-4 flex flex-col justify-center">
            {{-- Fila única: Títulos a la izquierda, número y descripción a la derecha --}}
            <div class="flex justify-between items-start">
                {{-- Títulos --}}
                <div>
                    <div class="text-xs font-medium text-blue-600 uppercase tracking-wide">Cursos</div>
                    <div class="text-xs text-blue-500 font-medium">Activos</div>
                </div>
                {{-- Número principal con descripción debajo --}}
                <div class="text-right">
                    <div class="text-2xl font-bold text-gray-900 group-hover:text-blue-700 transition-colors">
                        {{ $totalCursosActivos ?? $cursos->total() }}
                    </div>
                    <div class="text-xs text-gray-600">
                        cursos disponibles
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

{{-- Media Alumnos --}}
<div class="group relative overflow-hidden bg-gradient-to-br from-emerald-50 via-white to-emerald-50 p-4 rounded-2xl shadow-lg shadow-emerald-100/25 border border-emerald-100/50 hover:shadow-xl hover:shadow-emerald-200/30 transition-all duration-300 hover:-translate-y-1 min-h-[120px]">
    <div class="absolute inset-0 bg-gradient-to-br from-transparent via-emerald-50/30 to-emerald-100/20 opacity-0 group-hover:opacity-100 transition-opacity duration-300"></div>
    <div class="relative z-10 flex h-full">
        {{-- Icono a la izquierda --}}
        <div class="flex-shrink-0 p-3 bg-gradient-to-br from-emerald-500 to-emerald-600 rounded-xl shadow-md shadow-emerald-500/25 group-hover:shadow-emerald-500/40 transition-all duration-300 group-hover:scale-105 h-fit">
            <i class="bi bi-people-fill text-xl text-white"></i>
        </div>
        
        {{-- Información organizada horizontalmente --}}
        <div class="flex-1 ml-4 flex flex-col justify-center">
            {{-- Fila única: Títulos a la izquierda, número y descripción a la derecha --}}
            <div class="flex justify-between items-start">
                {{-- Títulos --}}
                <div>
                    <div class="text-xs font-medium text-emerald-600 uppercase tracking-wide">Media</div>
                    <div class="text-xs text-emerald-500 font-medium">Alumnos/Curso</div>
                </div>
                {{-- Número principal con descripción debajo --}}
                <div class="text-right">
                    <div class="text-2xl font-bold text-gray-900 group-hover:text-emerald-700 transition-colors">
                        {{ $mediaAlumnosPorCurso ?? 'N/A' }}
                    </div>
                    <div class="text-xs text-gray-600">
                        estudiantes promedio
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

{{-- Modalidades --}}
<div class="group relative overflow-hidden bg-gradient-to-br from-purple-50 via-white to-purple-50 p-4 rounded-2xl shadow-lg shadow-purple-100/25 border border-purple-100/50 hover:shadow-xl hover:shadow-purple-200/30 transition-all duration-300 hover:-translate-y-1 min-h-[120px]">
    <div class="absolute inset-0 bg-gradient-to-br from-transparent via-purple-50/30 to-purple-100/20 opacity-0 group-hover:opacity-100 transition-opacity duration-300"></div>
    <div class="relative z-10 flex h-full">
        {{-- Icono a la izquierda --}}
        <div class="flex-shrink-0 p-3 bg-gradient-to-br from-purple-500 to-purple-600 rounded-xl shadow-md shadow-purple-500/25 group-hover:shadow-purple-500/40 transition-all duration-300 group-hover:scale-105 h-fit">
            <i class="bi bi-intersect text-xl text-white"></i>
        </div>
        
        {{-- Información organizada horizontalmente --}}
        <div class="flex-1 ml-4 flex flex-col justify-center">
            {{-- Fila única: Títulos a la izquierda, número y descripción a la derecha --}}
            <div class="flex justify-between items-start">
                {{-- Títulos --}}
                <div>
                    <div class="text-xs font-medium text-purple-600 uppercase tracking-wide">Modalidades</div>
                    <div class="text-xs text-purple-500 font-medium">Disponibles</div>
                </div>
                {{-- Número principal con descripción debajo --}}
                <div class="text-right">
                    <div class="text-2xl font-bold text-gray-900 group-hover:text-purple-700 transition-colors">
                        {{ $opcionesModalidad->count() }}
                    </div>
                    <div class="text-xs text-gray-600">
                        tipos de enseñanza
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

{{-- Profesores --}}
<div class="group relative overflow-hidden bg-gradient-to-br from-amber-50 via-white to-amber-50 p-4 rounded-2xl shadow-lg shadow-amber-100/25 border border-amber-100/50 hover:shadow-xl hover:shadow-amber-200/30 transition-all duration-300 hover:-translate-y-1 min-h-[120px]">
    <div class="absolute inset-0 bg-gradient-to-br from-transparent via-amber-50/30 to-amber-100/20 opacity-0 group-hover:opacity-100 transition-opacity duration-300"></div>
    <div class="relative z-10 flex h-full">
        {{-- Icono a la izquierda --}}
        <div class="flex-shrink-0 p-3 bg-gradient-to-br from-amber-500 to-amber-600 rounded-xl shadow-md shadow-amber-500/25 group-hover:shadow-amber-500/40 transition-all duration-300 group-hover:scale-105 h-fit">
            <i class="bi bi-person-video3 text-xl text-white"></i>
        </div>
        
        {{-- Información organizada horizontalmente --}}
        <div class="flex-1 ml-4 flex flex-col justify-center">
            {{-- Fila única: Títulos a la izquierda, número y descripción a la derecha --}}
            <div class="flex justify-between items-start">
                {{-- Títulos --}}
                <div>
                    <div class="text-xs font-medium text-amber-600 uppercase tracking-wide">Profesores</div>
                    <div class="text-xs text-amber-500 font-medium">Asignados</div>
                </div>
                {{-- Número principal con descripción debajo --}}
                <div class="text-right">
                    <div class="text-2xl font-bold text-gray-900 group-hover:text-amber-700 transition-colors">
                        {{ $opcionesProfesores->count() }}
                    </div>
                    <div class="text-xs text-gray-600">
                        docentes activos
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
</div>



    {{-- Panel de Filtros Compacto --}}
<div class="bg-gradient-to-r from-white via-gray-50/50 to-white rounded-2xl shadow-lg shadow-gray-200/50 border border-gray-200/50 p-4 mb-8 backdrop-blur-sm">
    <form method="GET" action="{{ route('admin.cursos.index') }}" id="filterFormCursos">
        <div class="flex flex-col xl:flex-row justify-between items-start xl:items-center gap-5">
            {{-- Controles de Filtrado --}}
            <div class="flex flex-col lg:flex-row items-stretch lg:items-center gap-4 w-full xl:w-auto">
                {{-- Buscador Compacto --}}
                <div class="relative group">
                    <div class="absolute inset-y-0 left-0 flex items-center pl-4 pointer-events-none z-10">
                        <i class="bi bi-search text-gray-400 group-focus-within:text-indigo-500 transition-colors duration-200"></i>
                    </div>
                    <input type="text" name="search" id="searchCursos"
                           class="block w-full lg:w-96 pl-10 pr-10 py-4 text-sm border-2 border-gray-200 rounded-xl bg-gray-50/50 placeholder-gray-400 focus:outline-none focus:ring-3 focus:ring-indigo-500/20 focus:border-indigo-500 focus:bg-white transition-all duration-300 shadow-inner hover:border-gray-300"
                           placeholder="Buscar cursos por nombre o código..." 
                           value="{{ $searchTerm ?? '' }}" 
                           autocomplete="off">
                    @if($searchTerm)
                        <button type="button" 
                                onclick="document.getElementById('searchCursos').value=''; document.getElementById('filterFormCursos').submit();" 
                                class="absolute inset-y-0 right-0 flex items-center pr-3 text-gray-400 hover:text-red-500 transition-colors duration-200 z-10">
                            <i class="bi bi-x-circle-fill"></i>
                        </button>
                    @endif
                </div>
                
                {{-- Selectores Compactos --}}
                <div class="flex flex-col sm:flex-row gap-3">
                    {{-- Filtro Modalidad --}}
                    <div class="relative group">
                        <select name="modalidad" id="modalidad_filtro" onchange="this.form.submit()"
                                class="block w-full sm:w-54 rounded-xl border-2 border-gray-200 bg-gray-50/50 px-4 py-4 text-sm focus:outline-none focus:ring-3 focus:ring-indigo-500/20 focus:border-indigo-500 focus:bg-white transition-all duration-300 appearance-none cursor-pointer hover:border-gray-300 shadow-inner">
                            <option value="">🎯 Todas las Modalidades</option>
                            @foreach ($opcionesModalidad as $modalidad)
                                <option value="{{ $modalidad }}" {{ ($filtroModalidad == $modalidad) ? 'selected' : '' }}>
                                    {{ $modalidad == 'Online' ? '💻' : ($modalidad == 'Presencial' ? '🏫' : '🔄') }} {{ $modalidad }}
                                </option>
                            @endforeach
                        </select>
                        <div class="absolute inset-y-0 right-0 flex items-center pr-3 pointer-events-none">
                            <i class="bi bi-chevron-down text-gray-400 group-hover:text-gray-600 transition-colors"></i>
                        </div>
                    </div>

                    {{-- Filtro Profesor --}}
                    <div class="relative group">
                        <select name="profesor_id" id="profesor_filtro" onchange="this.form.submit()"
                                class="block w-full sm:w-52 rounded-xl border-2 border-gray-200 bg-gray-50/50 px-4 py-4 text-sm focus:outline-none focus:ring-3 focus:ring-indigo-500/20 focus:border-indigo-500 focus:bg-white transition-all duration-300 appearance-none cursor-pointer hover:border-gray-300 shadow-inner">
                            <option value="">👨‍🏫 Todos los Profesores</option>
                            @foreach ($opcionesProfesores as $profesor)
                                <option value="{{ $profesor->id }}" {{ ($filtroProfesor == $profesor->id) ? 'selected' : '' }}>
                                    {{ $profesor->nombre }} {{ $profesor->apellido1 }}
                                </option>
                            @endforeach
                        </select>
                        <div class="absolute inset-y-0 right-0 flex items-center pr-3 pointer-events-none">
                            <i class="bi bi-chevron-down text-gray-400 group-hover:text-gray-600 transition-colors"></i>
                        </div>
                    </div>

                    {{-- Botón Limpiar Filtros --}}
                    @if($searchTerm || $filtroModalidad || $filtroProfesor)
                        <button type="button" 
                                onclick="window.location.href='{{ route('admin.cursos.index') }}'"
                                class="inline-flex items-center justify-center px-4 py-4 text-sm font-medium rounded-xl text-gray-600 bg-gray-100 border-2 border-gray-200 hover:bg-gray-200 hover:border-gray-300 focus:outline-none focus:ring-3 focus:ring-gray-500/20 transition-all duration-300 shadow-inner hover:shadow-lg"
                                title="Limpiar todos los filtros">
                            <i class="bi bi-arrow-clockwise mr-2"></i>
                            Limpiar
                        </button>
                    @endif
                </div>
            </div>
            
            {{-- Botón Nuevo Curso Compacto --}}
            <div class="flex-shrink-0 w-full sm:w-auto">
                <a href="{{ route('admin.cursos.create') }}" 
                   class="group w-full sm:w-auto inline-flex items-center justify-center px-6 py-4 border-2 border-transparent shadow-lg text-sm font-bold rounded-xl text-white bg-gradient-to-r from-indigo-600 via-indigo-700 to-purple-700 hover:from-indigo-700 hover:via-indigo-800 hover:to-purple-800 focus:outline-none focus:ring-3 focus:ring-indigo-500/30 transition-all duration-300 transform hover:scale-105 hover:shadow-xl hover:shadow-indigo-500/25">
                    <i class="bi bi-plus-lg mr-2 group-hover:scale-110 transition-transform duration-200"></i> 
                    Nuevo Curso
                </a>
            </div>
        </div>
        
        {{-- Información de Resultados Compacta --}}
        @if($cursos->total() > 0)
            <div class="mt-5 pt-4 border-t border-gray-200/50">
                <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center gap-3">
                    <p class="text-xs text-gray-600 bg-gray-50 px-3 py-2 rounded-lg border border-gray-200/50">
                        <i class="bi bi-info-circle mr-1 text-blue-500"></i>
                        Mostrando <span class="font-semibold text-gray-900">{{ $cursos->firstItem() }}-{{ $cursos->lastItem() }}</span> 
                        de <span class="font-semibold text-gray-900">{{ $cursos->total() }}</span> cursos
                    </p>
                    @if($searchTerm || $filtroModalidad || $filtroProfesor) 
                        <span class="px-3 py-2 bg-gradient-to-r from-indigo-100 to-purple-100 text-indigo-800 rounded-lg text-xs font-semibold border border-indigo-200/50 shadow-sm">
                            <i class="bi bi-funnel mr-1"></i>Filtros activos
                        </span>
                    @endif
                </div>
            </div>
        @endif
    </form>
</div>


    {{-- Tabla Premium Responsive --}}
<div class="bg-white rounded-3xl shadow-2xl shadow-gray-200/50 border border-gray-200/100 overflow-hidden backdrop-blur-sm">
    {{-- Wrapper con scroll horizontal suave --}}
    <div class="overflow-x-auto scrollbar-thin scrollbar-thumb-indigo-300 scrollbar-track-gray-100">
        <div class="min-w-full inline-block align-middle">
        <table class="min-w-full divide-y divide-gray-100 border-collapse border border-gray-200/30">
    <thead class="bg-gradient-to-r from-gray-50 via-gray-100 to-gray-50">
        <tr>
            {{-- Columna Curso - Con borde ligero --}}
            <th scope="col" class="sticky left-0 z-20 bg-gray-15000 px-4 py-4 text-left text-xs font-bold text-gray-700 uppercase tracking-wider border-b border-gray-200/50 border-r border-gray-200/30 min-w-[280px]">
                <div class="flex items-center space-x-2">
                    <i class="bi bi-book text-gray-500"></i>
                    <span>Curso</span>
                </div>
            </th>
            
            {{-- Código - Con borde ligero --}}
            <th scope="col" class="hidden sm:table-cell px-4 py-4 text-left text-xs font-bold text-gray-700 uppercase tracking-wider border-b border-gray-200/50 border-r border-gray-200/30 min-w-[120px]">
                <div class="flex items-center space-x-2">
                    <i class="bi bi-hash text-gray-500"></i>
                    <span>Código</span>
                </div>
            </th>
            
            {{-- Modalidad - Con borde ligero --}}
            <th scope="col" class="hidden md:table-cell px-4 py-3 text-left text-xs font-bold text-gray-700 uppercase tracking-wider border-b border-gray-200/50 border-r border-gray-200/30 min-w-[130px]">
                <div class="flex items-center space-x-2">
                    <i class="bi bi-intersect text-gray-500"></i>
                    <span>Modalidad</span>
                </div>
            </th>
            
            {{-- Profesor - Con borde ligero --}}
            <th scope="col" class="hidden lg:table-cell px-4 py-3 text-left text-xs font-bold text-gray-700 uppercase tracking-wider border-b border-gray-200/50 border-r border-gray-200/30 min-w-[180px]">
                <div class="flex items-center space-x-2">
                    <i class="bi bi-person-video3 text-gray-500"></i>
                    <span>Profesor</span>
                </div>
            </th>
            
            {{-- Inscritos - Con borde ligero --}}
            <th scope="col" class="hidden sm:table-cell px-4 py-3 text-center text-xs font-bold text-gray-700 uppercase tracking-wider border-b border-gray-200/50 border-r border-gray-200/30 min-w-[100px]">
                <div class="flex items-center justify-center space-x-2">
                    <i class="bi bi-people text-gray-500"></i>
                    <span>Inscritos</span>
                </div>
            </th>
            
            {{-- Fechas - Con borde ligero --}}
            <th scope="col" class="hidden xl:table-cell px-4 py-3 text-left text-xs font-bold text-gray-700 uppercase tracking-wider border-b border-gray-200/50 border-r border-gray-200/30 min-w-[140px]">
                <div class="flex items-center space-x-2">
                    <i class="bi bi-calendar-range text-gray-500"></i>
                    <span>Fechas</span>
                </div>
            </th>
            
            {{-- Plazas - Con borde ligero --}}
            <th scope="col" class="hidden lg:table-cell px-4 py-3 text-center text-xs font-bold text-gray-700 uppercase tracking-wider border-b border-gray-200/50 border-r border-gray-200/30 min-w-[100px]">
                <div class="flex items-center justify-center space-x-2">
                    <i class="bi bi-diagram-3 text-gray-500"></i>
                    <span>Plazas</span>
                </div>
            </th>
            
            {{-- Acciones - Sin borde derecho --}}
            <th scope="col" class="sticky right-0 z-20 bg-gray-150 px-4 py-3 text-center text-xs font-bold text-gray-700 uppercase tracking-wider border-b border-gray-200/50 min-w-[140px]">
                <div class="flex items-center justify-center space-x-2">
                    <i class="bi bi-gear text-gray-500"></i>
                    <span>Acciones</span>
                </div>
            </th>
        </tr>
    </thead>
    
    <tbody class="bg-white divide-y divide-gray-100/60">
        @forelse ($cursos as $index => $curso)
            <tr class="hover:bg-gradient-to-r hover:from-blue-50/30 hover:via-transparent hover:to-blue-50/30 transition-all duration-300 group border-b border-gray-100/50 {{ $index % 2 == 0 ? 'bg-gray-50/20' : 'bg-white' }}">
                
                {{-- Información del Curso - Con bordes ligeros --}}
                <td class="sticky left-0 z-10 bg-white group-hover:bg-blue-50/30 px-4 py-3 border-r border-gray-200/30 border-b border-gray-100/50">
                    <div class="space-y-1.5">
                        {{-- Título del curso --}}
                        <div class="text-sm font-bold text-gray-900 group-hover:text-indigo-700 transition-colors duration-200 line-clamp-2 max-w-[220px] leading-tight">
                            {{ Str::limit($curso->nombre, 60) }}
                        </div>
                        
                        {{-- Descripción --}}
                        <div class="text-xs text-gray-600 max-w-[220px] line-clamp-1">
                            {{ Str::limit($curso->descripcion, 45) }}
                        </div>
                        
                        {{-- Información adicional para móvil --}}
                        <div class="sm:hidden space-y-1 pt-1.5 border-t border-gray-100">
                            {{-- Código en móvil --}}
                            <div class="flex items-center space-x-2">
                                <span class="text-xs text-gray-500 font-semibold">Código:</span>
                                <code class="text-xs font-mono bg-gray-100 px-2 py-1 rounded">{{ $curso->codigo }}</code>
                            </div>
                            
                            {{-- Modalidad en móvil --}}
                            <div class="flex items-center space-x-2">
                                <span class="text-xs text-gray-500 font-semibold">Modalidad:</span>
                                <span class="inline-flex items-center px-2 py-1 text-xs font-medium rounded-full
                                    {{ $curso->modalidad == 'Online' ? 'bg-sky-100 text-sky-800' : 
                                       ($curso->modalidad == 'Presencial' ? 'bg-emerald-100 text-emerald-800' : 
                                        'bg-purple-100 text-purple-800') }}">
                                    @if($curso->modalidad == 'Online')
                                        <i class="bi bi-laptop mr-1"></i>
                                    @elseif($curso->modalidad == 'Presencial')
                                        <i class="bi bi-building mr-1"></i>
                                    @else
                                        <i class="bi bi-arrow-repeat mr-1"></i>
                                    @endif
                                    {{ $curso->modalidad }}
                                </span>
                            </div>
                            
                            {{-- Inscritos en móvil --}}
                            <div class="flex items-center space-x-2">
                                <span class="text-xs text-gray-500 font-semibold">Inscritos:</span>
                                <span class="inline-flex items-center justify-center w-6 h-6 bg-blue-500 text-white rounded-full text-xs font-bold">
                                    {{ $curso->alumnos_count }}
                                </span>
                            </div>
                        </div>
                    </div>
                </td>
                
                {{-- Código - Con bordes ligeros --}}
                <td class="hidden sm:table-cell px-4 py-3 whitespace-nowrap border-r border-gray-200/30 border-b border-gray-100/50">
                    <div class="inline-flex items-center px-3 py-1.5 rounded-xl bg-gray-100 border border-gray-200/50">
                        <code class="text-sm font-mono font-semibold text-gray-800">{{ $curso->codigo }}</code>
                    </div>
                </td>
                
                {{-- Modalidad - Con bordes ligeros --}}
                <td class="hidden md:table-cell px-4 py-3 whitespace-nowrap border-r border-gray-200/30 border-b border-gray-100/50">
                    <span class="inline-flex items-center px-4 py-1.5 text-sm font-bold rounded-xl shadow-sm
                        {{ $curso->modalidad == 'Online' ? 'bg-gradient-to-r from-sky-100 to-blue-100 text-sky-800 border border-sky-200' : 
                           ($curso->modalidad == 'Presencial' ? 'bg-gradient-to-r from-emerald-100 to-green-100 text-emerald-800 border border-emerald-200' : 
                            'bg-gradient-to-r from-purple-100 to-fuchsia-100 text-purple-800 border border-purple-200') }}">
                        @if($curso->modalidad == 'Online')
                            <i class="bi bi-laptop mr-2"></i>
                        @elseif($curso->modalidad == 'Presencial')
                            <i class="bi bi-building mr-2"></i>
                        @else
                            <i class="bi bi-arrow-repeat mr-2"></i>
                        @endif
                        {{ $curso->modalidad }}
                    </span>
                </td>
                
                {{-- Profesor - Con bordes ligeros --}}
                <td class="hidden lg:table-cell px-4 py-3 whitespace-nowrap border-r border-gray-200/30 border-b border-gray-100/50">
                    <div class="flex items-center space-x-3">
                        <div class="w-7 h-7 bg-gradient-to-br from-indigo-500 to-purple-600 rounded-full flex items-center justify-center shadow-lg">
                            <span class="text-white text-xs font-bold">
                                {{ substr($curso->profesor->nombre ?? 'N', 0, 1) }}{{ substr($curso->profesor->apellido1 ?? 'A', 0, 1) }}
                            </span>
                        </div>
                        <div class="max-w-[120px]">
                            <div class="text-sm font-semibold text-gray-900 truncate">
                                {{ $curso->profesor->nombre ?? 'Sin asignar' }} {{ $curso->profesor->apellido1 ?? '' }}
                            </div>
                        </div>
                    </div>
                </td>
                
                {{-- Alumnos Inscritos - Con bordes ligeros --}}
<td class="hidden sm:table-cell px-4 py-3 whitespace-nowrap text-center border-r border-gray-200/30 border-b border-gray-100/50">
    <div class="inline-flex items-center justify-center">
        <div class="relative">
            <div class="w-8 h-8 bg-gradient-to-br from-blue-500 to-indigo-600 rounded-xl flex items-center justify-center shadow-lg shadow-blue-500/25 group-hover:shadow-blue-500/40 transition-all duration-300">
                <span class="text-white text-sm font-bold">{{ $curso->alumnos_count }}</span>
            </div>
            @if($curso->alumnos_count > 0)
                <div class="absolute -top-0.5 -right-0.5 w-2.5 h-2.5 bg-green-500 rounded-full border-2 border-white shadow-sm"></div>
            @endif
        </div>
    </div>
</td>

                
                {{-- Fechas - Con bordes ligeros --}}
                <td class="hidden xl:table-cell px-4 py-3 whitespace-nowrap border-r border-gray-200/30 border-b border-gray-100/50">
                    <div class="space-y-0.5">
                        <div class="flex items-center text-sm text-gray-700">
                            <i class="bi bi-calendar-event mr-2 text-green-600"></i>
                            {{ $curso->fecha_inicio ? $curso->fecha_inicio->format('d/m/Y') : 'No definida' }}
                        </div>
                        <div class="flex items-center text-sm text-gray-700">
                            <i class="bi bi-calendar-x mr-2 text-red-600"></i>
                            {{ $curso->fecha_fin ? $curso->fecha_fin->format('d/m/Y') : 'No definida' }}
                        </div>
                    </div>
                </td>
                
                {{-- Plazas - Con bordes ligeros --}}
<td class="hidden lg:table-cell px-4 py-3 whitespace-nowrap text-center border-r border-gray-200/30 border-b border-gray-100/50">
    <div class="inline-flex items-center px-2 py-1 rounded-lg bg-orange-100 border border-orange-200/50">
        <span class="text-sm font-semibold text-orange-800">{{ $curso->plazas_maximas }}</span>
        <span class="text-xs text-orange-600 ml-1">plazas</span>
    </div>
</td>

                
{{-- Acciones - Solo borde inferior --}}
<td class="sticky right-0 z-10 bg-white group-hover:bg-blue-50/30 px-3 py-2 whitespace-nowrap text-center border-b border-gray-100/50">
    <div class="flex items-center justify-center space-x-3">
        {{-- Ver --}}
        <a href="{{ route('admin.cursos.show', $curso->id) }}"
           class="group/action p-1 rounded-md bg-blue-100 text-blue-600 hover:bg-blue-600 hover:text-white transition-all duration-300 hover:scale-110 hover:shadow-lg hover:shadow-blue-500/25"
           title="Ver detalles del curso">
            <i class="bi bi-eye-fill w-4 h-4 group-hover/action:scale-110 transition-transform"></i>
        </a>
        
        {{-- Editar --}}
        <a href="{{ route('admin.cursos.edit', $curso->id) }}" 
           class="group/action p-1 rounded-md bg-indigo-100 text-indigo-600 hover:bg-indigo-600 hover:text-white transition-all duration-300 hover:scale-110 hover:shadow-lg hover:shadow-indigo-500/25"
           title="Editar curso">
            <i class="bi bi-pencil-fill w-4 h-4 group-hover/action:scale-110 transition-transform"></i>
        </a>
        
        {{-- Eliminar (con modal) --}}
            <button type="button"
                    onclick="confirmDelete(
                        '{{ route('admin.cursos.destroy', $curso->id) }}',
                        '{{ addslashes($curso->nombre) }}'
                    )"
                    class="group/action p-1 rounded-md bg-red-100 text-red-600 hover:bg-red-600
                        hover:text-white transition-all duration-300 hover:scale-110 hover:shadow-lg
                        hover:shadow-red-500/25"
                    title="Eliminar curso">
                <i class="bi bi-trash-fill w-4 h-4 group-hover/action:scale-110 transition-transform"></i>
            </button>

    </div>
</td>


            </tr>
        @empty
            {{-- Estado vacío sin cambios --}}
            <tr>
                <td colspan="8" class="px-8 py-16 text-center border-b border-gray-100/50">
                    {{-- Contenido del estado vacío igual que antes --}}
                </td>
            </tr>
        @endforelse
    </tbody>
</table>

        </div>
    </div>
</div>


    {{-- Paginación Premium --}}
    @if ($cursos->hasPages())
        <div class="mt-4 bg-gradient-to-r from-white via-gray-50/50 to-white rounded-3xl shadow-2xl shadow-gray-200/50 border border-gray-200/50 p-4 backdrop-blur-sm">
            <div class="flex flex-col sm:flex-row items-center justify-between gap-6">
                <div class="flex items-center space-x-4">
                    <div class="flex items-center px-4 py-2 bg-indigo-50 rounded-xl border border-indigo-200/50">
                        <i class="bi bi-file-earmark-text text-indigo-600 mr-2"></i>
                        <span class="text-sm font-medium text-indigo-800">
                            Página {{ $cursos->currentPage() }} de {{ $cursos->lastPage() }}
                        </span>
                    </div>
                    <div class="text-sm text-gray-600">
                        ({{ $cursos->total() }} cursos en total)
                    </div>
                </div>
                <div class="flex-shrink-0">
                    {{ $cursos->appends(request()->query())->links('vendor.pagination.tailwind') }}
                </div>
            </div>
        </div>
    @endif

<!-- Modal de confirmación de eliminación -->
<x-delete-modal title="Eliminar curso" />
@endsection

@push('styles')
<style>
    /* Animaciones personalizadas */
    @keyframes slideInDown {
        from { opacity: 0; transform: translate3d(0, -100%, 0); }
        to { opacity: 1; transform: translate3d(0, 0, 0); }
    }
    
    .animate-slideInDown {
        animation: slideInDown 0.6s ease-out;
    }
    
    /* Suavizado para transiciones */
    * {
        scroll-behavior: smooth;
    }
    
    /* Estilos personalizados para selectores */
    select option {
        padding: 12px;
        background-color: white;
        color: #374151;
    }
    
    select option:checked {
        background-color: #e0e7ff;
        color: #3730a3;
    }
    
    /* Efectos de hover para las filas de tabla */
    tbody tr:hover {
        transform: translateX(1px);
    }
    
    /* Estilos para scrollbar */
    .overflow-x-auto::-webkit-scrollbar {
        height: 8px;
    }
    
    .overflow-x-auto::-webkit-scrollbar-track {
        background: #f1f5f9;
        border-radius: 10px;
    }
    
    .overflow-x-auto::-webkit-scrollbar-thumb {
        background: linear-gradient(90deg, #6366f1, #8b5cf6);
        border-radius: 10px;
    }
    
    .overflow-x-auto::-webkit-scrollbar-thumb:hover {
        background: linear-gradient(90deg, #4f46e5, #7c3aed);
    }
</style>
@endpush

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    // Auto-dismiss para mensajes flash después de 5 segundos
    const flashMessages = document.querySelectorAll('[role="alert"]');
    flashMessages.forEach(message => {
        setTimeout(() => {
            if (message.parentElement) {
                message.style.transform = 'translateX(100%)';
                message.style.opacity = '0';
                setTimeout(() => message.remove(), 300);
            }
        }, 5000);
    });
    
    // Mejorar la experiencia de búsqueda
    const searchInput = document.getElementById('searchCursos');
    if (searchInput) {
        let searchTimeout;
        searchInput.addEventListener('input', function() {
            clearTimeout(searchTimeout);
            // Auto-submit después de 1 segundo de inactividad
            searchTimeout = setTimeout(() => {
                document.getElementById('filterFormCursos').submit();
            }, 1000);
        });
        
        // Limpiar con Escape
        searchInput.addEventListener('keydown', function(e) {
            if (e.key === 'Escape') {
                this.value = '';
                document.getElementById('filterFormCursos').submit();
            }
        });
    }
    
    // Tooltips para botones de acción
    const actionButtons = document.querySelectorAll('[title]');
    actionButtons.forEach(button => {
        button.addEventListener('mouseenter', function() {
            // Aquí podrías agregar tooltips personalizados si lo deseas
        });
    });
    
    // Efecto de carga suave para la página
    document.body.style.opacity = '0';
    setTimeout(() => {
        document.body.style.transition = 'opacity 0.5s ease-in-out';
        document.body.style.opacity = '1';
    }, 100);
});


</script>
@endpush
