@extends('layouts.admin')

@section('title', 'Gestión de Cursos')
@section('page-title', 'Gestión de Cursos')

@section('content')
    {{-- Mensajes Flash --}}
    @if (session('success'))
        <div class="mb-6 px-4 py-3 rounded-lg relative bg-gradient-to-r from-green-50 to-green-100 border-l-4 border-green-400 text-green-800 shadow-sm animate-fadeIn" role="alert">
            <div class="flex items-center"><i class="bi bi-check-circle-fill text-green-500 mr-3"></i><div><strong class="font-semibold">¡Éxito!</strong><p class="text-sm mt-1">{{ session('success') }}</p></div></div>
        </div>
    @endif
    @if (session('error'))
        <div class="mb-6 px-4 py-3 rounded-lg relative bg-gradient-to-r from-red-50 to-red-100 border-l-4 border-red-400 text-red-800 shadow-sm animate-fadeIn" role="alert">
            <div class="flex items-center"><i class="bi bi-exclamation-triangle-fill text-red-500 mr-3"></i><div><strong class="font-semibold">¡Atención!</strong><p class="text-sm mt-1">{{ session('error') }}</p></div></div>
        </div>
    @endif

    <!-- KPIs / Tarjetas de Resumen para Cursos -->
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
        {{-- Tarjeta Total Cursos Activos (Ejemplo) --}}
        <div class="bg-gradient-to-br from-white to-gray-50 p-6 rounded-xl shadow-sm border border-gray-100 hover:shadow-md transition-all group">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-xs font-semibold text-gray-600 uppercase tracking-wider mb-2">Cursos Activos</p>
                    <p class="text-3xl font-bold text-gray-900">{{ $totalCursosActivos ?? $cursos->total() }}</p> {{-- Usar variable específica o total paginado --}}
                </div>
                <div class="p-3 bg-blue-100 rounded-lg group-hover:bg-blue-200 transition-colors">
                    <i class="bi bi-journals text-2xl text-blue-600"></i>
                </div>
            </div>
        </div>
        {{-- Tarjeta Media Alumnos/Curso (Placeholder) --}}
        <div class="bg-gradient-to-br from-white to-gray-50 p-6 rounded-xl shadow-sm border border-gray-100 hover:shadow-md transition-all group">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-xs font-semibold text-gray-600 uppercase tracking-wider mb-2">Media Alumnos/Curso</p>
                    <p class="text-3xl font-bold text-gray-900">{{ $mediaAlumnosPorCurso ?? 'N/A' }}</p>
                </div>
                <div class="p-3 bg-green-100 rounded-lg group-hover:bg-green-200 transition-colors">
                    <i class="bi bi-people-fill text-2xl text-green-600"></i>
                </div>
            </div>
        </div>
        {{-- Tarjeta Modalidades Únicas --}}
        <div class="bg-gradient-to-br from-white to-gray-50 p-6 rounded-xl shadow-sm border border-gray-100 hover:shadow-md transition-all group">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-xs font-semibold text-gray-600 uppercase tracking-wider mb-2">Modalidades</p>
                    <p class="text-3xl font-bold text-gray-900">{{ $opcionesModalidad->count() }}</p>
                </div>
                <div class="p-3 bg-purple-100 rounded-lg group-hover:bg-purple-200 transition-colors">
                    <i class="bi bi-intersect text-2xl text-purple-600"></i>
                </div>
            </div>
        </div>
        {{-- Tarjeta Profesores con Cursos --}}
        <div class="bg-gradient-to-br from-white to-gray-50 p-6 rounded-xl shadow-sm border border-gray-100 hover:shadow-md transition-all group">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-xs font-semibold text-gray-600 uppercase tracking-wider mb-2">Profesores Asignados</p>
                    <p class="text-3xl font-bold text-gray-900">{{ $opcionesProfesores->count() }}</p>
                </div>
                <div class="p-3 bg-orange-100 rounded-lg group-hover:bg-orange-200 transition-colors">
                    <i class="bi bi-person-video3 text-2xl text-orange-600"></i>
                </div>
            </div>
        </div>
    </div>

    <!-- Filtros y Herramientas -->
    <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6 mb-8">
        <form method="GET" action="{{ route('admin.cursos.index') }}" id="filterFormCursos">
            <div class="flex flex-col lg:flex-row justify-between items-start lg:items-center gap-6">
                <div class="flex flex-col sm:flex-row items-stretch sm:items-center gap-4 w-full lg:w-auto">
                    {{-- Buscador --}}
                    <div class="relative group">
                        <div class="absolute inset-y-0 left-0 flex items-center pl-4 pointer-events-none"><i class="bi bi-search text-gray-400 group-focus-within:text-indigo-500"></i></div>
                        <input type="text" name="search" id="searchCursos"
                               class="block w-full sm:w-72 pl-11 pr-4 py-3 border border-gray-300 rounded-lg bg-gray-50 placeholder-gray-500 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-transparent focus:bg-white transition-all text-sm"
                               placeholder="Buscar por nombre o código..." value="{{ $searchTerm ?? '' }}" autocomplete="off">
                        @if($searchTerm)
                            <button type="button" onclick="document.getElementById('searchCursos').value=''; document.getElementById('filterFormCursos').submit();" class="absolute inset-y-0 right-0 flex items-center pr-4 text-gray-400 hover:text-gray-600"><i class="bi bi-x-lg"></i></button>
                        @endif
                    </div>
                    
                    {{-- Filtro Modalidad --}}
                    <div class="relative">
                        <select name="modalidad" id="modalidad_filtro" onchange="this.form.submit()"
                                class="block w-full sm:w-auto rounded-lg border border-gray-300 bg-gray-50 px-4 py-3 text-sm focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-transparent focus:bg-white transition-all appearance-none cursor-pointer">
                            <option value="">Todas las Modalidades</option>
                            @foreach ($opcionesModalidad as $modalidad)
                                <option value="{{ $modalidad }}" {{ ($filtroModalidad == $modalidad) ? 'selected' : '' }}>{{ $modalidad }}</option>
                            @endforeach
                        </select>
                        <div class="absolute inset-y-0 right-0 flex items-center pr-3 pointer-events-none"><i class="bi bi-chevron-down text-gray-400"></i></div>
                    </div>

                    {{-- Filtro Profesor --}}
                    <div class="relative">
                        <select name="profesor_id" id="profesor_filtro" onchange="this.form.submit()"
                                class="block w-full sm:w-auto rounded-lg border border-gray-300 bg-gray-50 px-4 py-3 text-sm focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-transparent focus:bg-white transition-all appearance-none cursor-pointer">
                            <option value="">Todos los Profesores</option>
                            @foreach ($opcionesProfesores as $profesor)
                                <option value="{{ $profesor->id }}" {{ ($filtroProfesor == $profesor->id) ? 'selected' : '' }}>{{ $profesor->nombre }} {{ $profesor->apellido1 }}</option>
                            @endforeach
                        </select>
                         <div class="absolute inset-y-0 right-0 flex items-center pr-3 pointer-events-none"><i class="bi bi-chevron-down text-gray-400"></i></div>
                    </div>

                    @if($searchTerm || $filtroModalidad || $filtroProfesor)
                        <a href="{{ route('admin.cursos.index') }}" class="inline-flex items-center justify-center px-4 py-3 text-sm font-medium rounded-lg text-gray-500 bg-gray-100 hover:bg-gray-200 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-gray-500transition-all" title="Limpiar filtros"><i class="bi bi-arrow-clockwise"></i></a>
                    @endif
                </div>
                
                <div class="flex-shrink-0 w-full sm:w-auto">
                    <a href="{{ route('admin.cursos.create') }}" 
                       class="w-full sm:w-auto inline-flex items-center justify-center px-6 py-3 border border-transparent shadow-sm text-sm font-semibold rounded-lg text-white bg-gradient-to-r from-indigo-600 to-indigo-700 hover:from-indigo-700 hover:to-indigo-800 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 transition-all transform hover:scale-105">
                        <i class="bi bi-plus-lg mr-2"></i> Nuevo Curso
                    </a>
                </div>
            </div>
            @if($cursos->total() > 0)
                <div class="mt-4 pt-4 border-t border-gray-100"><p class="text-sm text-gray-600"><i class="bi bi-info-circle mr-1"></i>Mostrando {{ $cursos->firstItem() }}-{{ $cursos->lastItem() }} de {{ $cursos->total() }} cursos @if($searchTerm || $filtroModalidad || $filtroProfesor) <span class="ml-2 px-2 py-1 bg-indigo-100 text-indigo-800 rounded-full text-xs font-medium">Filtros activos</span>@endif</p></div>
            @endif
        </form>
    </div>

    <!-- Tabla de Cursos -->
    <div class="bg-white rounded-xl shadow-sm border border-gray-200 overflow-hidden">
        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-gray-200">
                <thead class="bg-gradient-to-r from-gray-50 to-gray-100">
                    <tr>
                        <th scope="col" class="px-6 py-4 text-left text-xs font-bold text-gray-600 uppercase tracking-wider">Curso</th>
                        <th scope="col" class="px-6 py-4 text-left text-xs font-bold text-gray-600 uppercase tracking-wider">Código</th>
                        <th scope="col" class="px-6 py-4 text-left text-xs font-bold text-gray-600 uppercase tracking-wider">Modalidad</th>
                        <th scope="col" class="px-6 py-4 text-left text-xs font-bold text-gray-600 uppercase tracking-wider">Profesor</th>
                        <th scope="col" class="px-6 py-4 text-center text-xs font-bold text-gray-600 uppercase tracking-wider">Alumnos Insc.</th>
                        <th scope="col" class="px-6 py-4 text-left text-xs font-bold text-gray-600 uppercase tracking-wider">Fechas</th>
                        <th scope="col" class="px-6 py-4 text-center text-xs font-bold text-gray-600 uppercase tracking-wider">Plazas</th>
                        <th scope="col" class="px-6 py-4 text-center text-xs font-bold text-gray-600 uppercase tracking-wider">Acciones</th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-100">
                    @forelse ($cursos as $curso)
                        <tr class="hover:bg-gray-50 transition-colors group">
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="text-sm font-semibold text-gray-900 group-hover:text-indigo-600">{{ $curso->nombre }}</div>
                                <div class="text-xs text-gray-500">{{ Str::limit($curso->descripcion, 50) }}</div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-700 font-mono">{{ $curso->codigo }}</td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <span class="px-2 py-0.5 inline-flex text-xs leading-5 font-semibold rounded-full 
                                    {{ $curso->modalidad == 'Online' ? 'bg-sky-100 text-sky-800' : ($curso->modalidad == 'Presencial' ? 'bg-lime-100 text-lime-800' : 'bg-fuchsia-100 text-fuchsia-800') }}">
                                    {{ $curso->modalidad }}
                                </span>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-700">
                                {{ $curso->profesor->nombre ?? 'N/A' }} {{ $curso->profesor->apellido1 ?? '' }}
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-center">
                               <span class="inline-flex items-center justify-center h-8 w-8 rounded-full text-sm font-semibold bg-blue-100 text-blue-800">
                                    {{ $curso->alumnos_count }} {{-- Viene de withCount('alumnos') --}}
                                </span>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                {{ $curso->fecha_inicio ? $curso->fecha_inicio->format('d/m/Y') : 'N/A' }} -
                                {{ $curso->fecha_fin ? $curso->fecha_fin->format('d/m/Y') : 'N/A' }}
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-center text-sm text-gray-700">{{ $curso->plazas_maximas }}</td>
                            <td class="px-6 py-4 whitespace-nowrap text-center">
                                <div class="flex items-center justify-center space-x-2">
                                    <a href="{{ route('admin.cursos.show', $curso->id) }}" class="text-gray-400 hover:text-blue-600" title="Ver"><i class="bi bi-eye-fill"></i></a>
                                    <a href="{{ route('admin.cursos.edit', $curso->id) }}" class="text-gray-400 hover:text-indigo-600" title="Editar"><i class="bi bi-pencil-fill"></i></a>
                                    <form action="{{ route('admin.cursos.destroy', $curso->id) }}" method="POST" class="inline" onsubmit="return confirm('¿Seguro que quieres eliminar este curso?');">
                                        @csrf @method('DELETE')
                                        <button type="submit" class="text-gray-400 hover:text-red-600" title="Eliminar"><i class="bi bi-trash-fill"></i></button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                             <td colspan="8" class="px-6 py-12 text-center">
                                <div class="flex flex-col items-center justify-center space-y-4">
                                    <div class="p-4 bg-gray-100 rounded-full"><i class="bi bi-journals text-4xl text-gray-400"></i></div>
                                    <h3 class="text-lg font-medium text-gray-900 mb-2">No hay cursos</h3>
                                    <p class="text-sm text-gray-500 mb-4">
                                        @if($searchTerm || $filtroModalidad || $filtroProfesor)
                                            No se encontraron cursos que coincidan con los criterios.
                                        @else
                                            Aún no has agregado ningún curso al sistema.
                                        @endif
                                    </p>
                                    @if(!$searchTerm && !$filtroModalidad && !$filtroProfesor)
                                        <a href="{{ route('admin.cursos.create') }}" class="inline-flex items-center px-4 py-2 border border-transparent text-sm font-medium rounded-lg text-white bg-indigo-600 hover:bg-indigo-700">
                                            <i class="bi bi-plus-lg mr-2"></i>Agregar primer curso
                                        </a>
                                    @else
                                        <a href="{{ route('admin.cursos.index') }}" class="inline-flex items-center px-4 py-2 border border-gray-300 text-sm font-medium rounded-lg text-gray-700 bg-white hover:bg-gray-50">
                                            <i class="bi bi-arrow-clockwise mr-2"></i>Limpiar filtros
                                        </a>
                                    @endif
                                </div>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    {{-- Paginación --}}
    @if ($cursos->hasPages())
        <div class="mt-8 px-6 py-4 bg-white rounded-xl shadow-sm border border-gray-200">
           <div class="flex items-center justify-between">
                <div class="text-sm text-gray-600">Página {{ $cursos->currentPage() }} de {{ $cursos->lastPage() }}</div>
                {{ $cursos->appends(request()->query())->links('vendor.pagination.tailwind') }} {{-- Usando el paginador de Tailwind de Breeze --}}
            </div>
        </div>
    @endif

@endsection

@push('scripts')
<script>
    // Auto-submit de filtros si decides usarlo para los <select> de cursos
    // document.getElementById('modalidad_filtro').addEventListener('change', function() { document.getElementById('filterFormCursos').submit(); });
    // document.getElementById('profesor_filtro').addEventListener('change', function() { document.getElementById('filterFormCursos').submit(); });
</script>
@endpush