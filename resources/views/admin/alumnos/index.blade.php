@extends('layouts.admin')

@section('title', 'Gestión de Alumnos')
@section('page-title', 'Gestión de Alumnos')

@section('content')
    {{-- Mensajes Flash de Sesión - Diseño mejorado --}}
    @if (session('success'))
        <div class="mb-6 px-4 py-3 rounded-lg relative bg-gradient-to-r from-green-50 to-green-100 border-l-4 border-green-400 text-green-800 shadow-sm animate-fadeIn" role="alert">
            <div class="flex items-center">
                <i class="bi bi-check-circle-fill text-green-500 mr-3"></i>
                <div>
                    <strong class="font-semibold">¡Éxito!</strong>
                    <p class="text-sm mt-1">{{ session('success') }}</p>
                </div>
            </div>
        </div>
    @endif
    @if (session('error'))
        <div class="mb-6 px-4 py-3 rounded-lg relative bg-gradient-to-r from-red-50 to-red-100 border-l-4 border-red-400 text-red-800 shadow-sm animate-fadeIn" role="alert">
            <div class="flex items-center">
                <i class="bi bi-exclamation-triangle-fill text-red-500 mr-3"></i>
                <div>
                    <strong class="font-semibold">¡Atención!</strong>
                    <p class="text-sm mt-1">{{ session('error') }}</p>
                </div>
            </div>
        </div>
    @endif

    <!-- KPIs / Tarjetas de Resumen - Diseño mejorado -->
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
        <div class="bg-gradient-to-br from-white to-gray-50 p-6 rounded-xl shadow-sm border border-gray-100 hover:shadow-md transition-all duration-200 group">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-xs font-semibold text-gray-600 uppercase tracking-wider mb-2">Alumnos Activos</p>
                    <p class="text-3xl font-bold text-gray-900">{{ $totalAlumnosActivos ?? '0' }}</p>
                </div>
                <div class="p-3 bg-green-100 rounded-lg group-hover:bg-green-200 transition-colors duration-200">
                    <i class="bi bi-person-check-fill text-2xl text-green-600"></i>
                </div>
            </div>
        </div>
        
        <div class="bg-gradient-to-br from-white to-gray-50 p-6 rounded-xl shadow-sm border border-gray-100 hover:shadow-md transition-all duration-200 group">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-xs font-semibold text-gray-600 uppercase tracking-wider mb-2">Nuevos Este Mes</p>
                    <p class="text-3xl font-bold text-gray-900">{{ $nuevosAlumnosEsteMes ?? '0' }}</p>
                </div>
                <div class="p-3 bg-blue-100 rounded-lg group-hover:bg-blue-200 transition-colors duration-200">
                    <i class="bi bi-person-plus-fill text-2xl text-blue-600"></i>
                </div>
            </div>
        </div>
        
        <div class="bg-gradient-to-br from-white to-gray-50 p-6 rounded-xl shadow-sm border border-gray-100 hover:shadow-md transition-all duration-200 group">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-xs font-semibold text-gray-600 uppercase tracking-wider mb-2">Ratio Alumno-Profesor</p>
                    <p class="text-3xl font-bold text-gray-900">{{ $ratioAlumnoProfesor ?? 'N/A' }}</p>
                </div>
                <div class="p-3 bg-purple-100 rounded-lg group-hover:bg-purple-200 transition-colors duration-200">
                    <i class="bi bi-diagram-3-fill text-2xl text-purple-600"></i>
                </div>
            </div>
        </div>
        
        <div class="bg-gradient-to-br from-white to-gray-50 p-6 rounded-xl shadow-sm border border-gray-100 hover:shadow-md transition-all duration-200 group">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-xs font-semibold text-gray-600 uppercase tracking-wider mb-2">Tasa de Asistencia</p>
                    <p class="text-3xl font-bold text-green-600">{{ $tasaAsistencia ?? 'N/A' }}</p>
                </div>
                <div class="p-3 bg-orange-100 rounded-lg group-hover:bg-orange-200 transition-colors duration-200">
                    <i class="bi bi-calendar-check-fill text-2xl text-orange-600"></i>
                </div>
            </div>
        </div>
    </div>

    <!-- Filtros y Herramientas - Diseño mejorado -->
    <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6 mb-8">
        <form method="GET" action="{{ route('admin.alumnos.index') }}" id="filterForm">
            <div class="flex flex-col lg:flex-row justify-between items-start lg:items-center gap-6">
                <div class="flex flex-col sm:flex-row items-stretch sm:items-center gap-4 w-full lg:w-auto">
                    <!-- Buscador mejorado -->
                    <div class="relative group">
                        <div class="absolute inset-y-0 left-0 flex items-center pl-4">
                            <i class="bi bi-search text-gray-400 group-focus-within:text-indigo-500 transition-colors duration-200"></i>
                        </div>
                        <input type="text" 
                               name="search" 
                               id="search" 
                               class="block w-full sm:w-80 pl-11 pr-4 py-3 border border-gray-300 rounded-lg bg-gray-50 placeholder-gray-500 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-transparent focus:bg-white transition-all duration-200 text-sm"
                               placeholder="Buscar por nombre o ID..." 
                               value="{{ $searchTerm ?? '' }}"
                               autocomplete="off">
                        @if($searchTerm ?? false)
                            <button type="button" 
                                    onclick="clearSearch()" 
                                    class="absolute inset-y-0 right-0 flex items-center pr-4 text-gray-400 hover:text-gray-600">
                                <i class="bi bi-x-lg"></i>
                            </button>
                        @endif
                    </div>
                    
                    <!-- Filtro de grado mejorado -->
                    <div class="relative">
                        <select name="grado" 
                                id="grado" 
                                class="block w-full sm:w-48 rounded-lg border border-gray-300 bg-gray-50 px-4 py-3 text-sm focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-transparent focus:bg-white transition-all duration-200 appearance-none cursor-pointer">
                            <option value="">🎓 Todos los Grados</option>
                            @foreach ($opcionesGrado as $grado)
                                <option value="{{ $grado }}" {{ ($filtroGrado == $grado) ? 'selected' : '' }}>
                                    {{ $grado }}
                                </option>
                            @endforeach
                        </select>
                        
                    </div>
                    
                    <!-- Filtro de estado mejorado -->
                    <div class="relative">
                        <select name="estado_filtro" 
                                id="estado_filtro" 
                                class="block w-full sm:w-48 rounded-lg border border-gray-300 bg-gray-50 px-4 py-3 text-sm focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-transparent focus:bg-white transition-all duration-200 appearance-none cursor-pointer">
                            <option value="">📊 Todos los Estados</option>
                            @foreach ($opcionesEstado as $estado)
                                <option value="{{ $estado }}" {{ ($filtroEstado == $estado) ? 'selected' : '' }}>
                                    {{ $estado }}
                                </option>
                            @endforeach
                        </select>
                        
                    </div>
                    
                    <!-- Botones de acción -->
                    <div class="flex gap-2">
                        <button type="submit" 
                                class="inline-flex items-center justify-center px-6 py-3 border border-gray-300 shadow-sm text-sm font-medium rounded-lg text-gray-700 bg-white hover:bg-gray-50 hover:border-gray-400 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 transition-all duration-200">
                            <i class="bi bi-funnel mr-2"></i>
                            Aplicar
                        </button>
                        @if(($searchTerm ?? false) || ($filtroGrado ?? false) || ($filtroEstado ?? false))
                            <a href="{{ route('admin.alumnos.index') }}" 
                               class="inline-flex items-center justify-center px-4 py-3 text-sm font-medium rounded-lg text-gray-500 bg-gray-100 hover:bg-gray-200 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-gray-500 transition-all duration-200"
                               title="Limpiar filtros">
                                <i class="bi bi-arrow-clockwise"></i>
                            </a>
                        @endif
                    </div>
                </div>
                
                <!-- Botón principal mejorado -->
                <div class="flex-shrink-0 w-full sm:w-auto">
                    <a href="{{ route('admin.alumnos.create') }}" 
                       class="w-full sm:w-auto inline-flex items-center justify-center px-6 py-3 border border-transparent shadow-sm text-sm font-semibold rounded-lg text-white bg-gradient-to-r from-indigo-600 to-indigo-700 hover:from-indigo-700 hover:to-indigo-800 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 transition-all duration-200 transform hover:scale-105">
                        <i class="bi bi-plus-lg mr-2"></i> 
                        Nuevo Alumno
                    </a>
                </div>
            </div>
            
            <!-- Información de resultados -->
            @if($alumnos->total() > 0)
                <div class="mt-4 pt-4 border-t border-gray-100">
                    <p class="text-sm text-gray-600">
                        <i class="bi bi-info-circle mr-1"></i>
                        Mostrando {{ $alumnos->firstItem() }}-{{ $alumnos->lastItem() }} de {{ $alumnos->total() }} alumnos
                        @if(($searchTerm ?? false) || ($filtroGrado ?? false) || ($filtroEstado ?? false))
                            <span class="ml-2 px-2 py-1 bg-indigo-100 text-indigo-800 rounded-full text-xs font-medium">
                                Filtros activos
                            </span>
                        @endif
                    </p>
                </div>
            @endif
        </form>
    </div>

    <!-- Tabla de Alumnos - Diseño mejorado -->
    <div class="bg-white rounded-xl shadow-sm border border-gray-200 overflow-hidden">
        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-gray-200">
                <thead class="bg-gradient-to-r from-gray-50 to-gray-100">
                    <tr>
                        <th scope="col" class="px-6 py-4 text-left text-xs font-bold text-gray-600 uppercase tracking-wider">
                            <div class="flex items-center space-x-1">
                                <i class="bi bi-person-fill"></i>
                                <span>Alumno</span>
                            </div>
                        </th>
                        <th scope="col" class="px-6 py-4 text-left text-xs font-bold text-gray-600 uppercase tracking-wider">
                            <div class="flex items-center space-x-1">
                                <i class="bi bi-card-text"></i>
                                <span>ID Alumno</span>
                            </div>
                        </th>
                        <th scope="col" class="px-6 py-4 text-left text-xs font-bold text-gray-600 uppercase tracking-wider">
                            <div class="flex items-center space-x-1">
                                <i class="bi bi-mortarboard"></i>
                                <span>Grado/Año</span>
                            </div>
                        </th>
                        <th scope="col" class="px-6 py-4 text-left text-xs font-bold text-gray-600 uppercase tracking-wider">
                            <div class="flex items-center space-x-1">
                                <i class="bi bi-envelope"></i>
                                <span>Email</span>
                            </div>
                        </th>
                        <th scope="col" class="px-6 py-4 text-center text-xs font-bold text-gray-600 uppercase tracking-wider">
                            <div class="flex items-center justify-center space-x-1">
                                <i class="bi bi-circle-fill"></i>
                                <span>Estado</span>
                            </div>
                        </th>
                        <th scope="col" class="px-6 py-4 text-center text-xs font-bold text-gray-600 uppercase tracking-wider">
                            Acciones
                        </th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-100">
                    @forelse ($alumnos as $alumno)
                        <tr class="hover:bg-gray-50 transition-colors duration-150 group">
                            <td class="px-6 py-5 whitespace-nowrap">
                                <div class="flex items-center">
                                    <div class="flex-shrink-0 h-12 w-12">
                                        <img class="h-12 w-12 rounded-full ring-2 ring-gray-200 group-hover:ring-indigo-300 transition-all duration-200" 
                                             src="https://ui-avatars.com/api/?name={{ urlencode($alumno->nombre . ' ' . $alumno->apellido1) }}&color=7F9CF5&background=EBF4FF&font-size=0.33" 
                                             alt="Avatar de {{ $alumno->nombre }}">
                                    </div>
                                    <div class="ml-4">
                                        <div class="text-sm font-semibold text-gray-900 group-hover:text-indigo-600 transition-colors duration-200">
                                            {{ $alumno->nombre }} {{ $alumno->apellido1 }} {{ $alumno->apellido2 }}
                                        </div>
                                        <div class="text-xs text-gray-500 mt-1 flex items-center">
                                            <i class="bi bi-calendar3 mr-1"></i>
                                            Inscrito {{ $alumno->created_at ? $alumno->created_at->format('M Y') : 'Fecha no disponible' }}
                                        </div>
                                    </div>
                                </div>
                            </td>
                            <td class="px-6 py-5 whitespace-nowrap">
                                <div class="text-sm text-gray-900 font-mono">{{ $alumno->dni ?? 'N/A' }}</div>
                            </td>
                            <td class="px-6 py-5 whitespace-nowrap">
                                @if($alumno->nivel_formativo)
                                    <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-medium bg-indigo-100 text-indigo-800">
                                        {{ $alumno->nivel_formativo }}
                                    </span>
                                @else
                                    <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-medium bg-gray-100 text-gray-600">
                                        No especificado
                                    </span>
                                @endif
                            </td>
                            <td class="px-6 py-5 whitespace-nowrap">
                                @if($alumno->email)
                                    <div class="text-sm text-gray-700">
                                        <a href="mailto:{{ $alumno->email }}" 
                                           class="hover:text-indigo-600 transition-colors duration-200 flex items-center">
                                            <i class="bi bi-envelope-fill mr-1 text-xs"></i>
                                            {{ $alumno->email }}
                                        </a>
                                    </div>
                                @else
                                    <span class="text-sm text-gray-400">Sin email</span>
                                @endif
                            </td>
                            <td class="px-6 py-5 whitespace-nowrap text-center">
                                @php
                                    $estado = $alumno->estado ?? 'Desconocido';
                                    $badgeClass = 'bg-gray-100 text-gray-800';
                                    $iconClass = 'bi-question-circle';
                                    if ($estado === 'Activo') {
                                        $badgeClass = 'bg-green-100 text-green-800';
                                        $iconClass = 'bi-check-circle-fill';
                                    } elseif ($estado === 'Inactivo') {
                                        $badgeClass = 'bg-red-100 text-red-800';
                                        $iconClass = 'bi-x-circle-fill';
                                    } elseif ($estado === 'Pendiente') {
                                        $badgeClass = 'bg-yellow-100 text-yellow-800';
                                        $iconClass = 'bi-clock-fill';
                                    }
                                @endphp
                                <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-semibold {{ $badgeClass }}">
                                    <i class="bi {{ $iconClass }} mr-1"></i>
                                    {{ $estado }}
                                </span>
                            </td>
                            <td class="px-6 py-5 whitespace-nowrap text-center">
                                <div class="flex items-center justify-center space-x-2">
                                    <a href="{{ route('admin.alumnos.show', $alumno->id) }}" 
                                       class="inline-flex items-center justify-center h-8 w-8 rounded-lg text-gray-400 hover:text-blue-600 hover:bg-blue-50 transition-all duration-200 group/btn"
                                       title="Ver detalles">
                                        <i class="bi bi-eye-fill group-hover/btn:scale-110 transition-transform duration-200"></i>
                                    </a>
                                    <a href="{{ route('admin.alumnos.edit', $alumno->id) }}" 
                                       class="inline-flex items-center justify-center h-8 w-8 rounded-lg text-gray-400 hover:text-indigo-600 hover:bg-indigo-50 transition-all duration-200 group/btn"
                                       title="Editar información">
                                        <i class="bi bi-pencil-fill group-hover/btn:scale-110 transition-transform duration-200"></i>
                                    </a>
                                    <button type="button" 
                                            onclick="confirmDelete('{{ route('admin.alumnos.destroy', $alumno->id) }}', '{{ addslashes($alumno->nombre . ' ' . $alumno->apellido1) }}')"
                                            class="inline-flex items-center justify-center h-8 w-8 rounded-lg text-gray-400 hover:text-red-600 hover:bg-red-50 transition-all duration-200 group/btn"
                                            title="Eliminar alumno">
                                        <i class="bi bi-trash-fill group-hover/btn:scale-110 transition-transform duration-200"></i>
                                    </button>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="px-6 py-12 text-center">
                                <div class="flex flex-col items-center justify-center space-y-4">
                                    <div class="p-4 bg-gray-100 rounded-full">
                                        <i class="bi bi-person-x text-4xl text-gray-400"></i>
                                    </div>
                                    <div class="text-center">
                                        <h3 class="text-lg font-medium text-gray-900 mb-2">No hay alumnos</h3>
                                        <p class="text-sm text-gray-500 mb-4">
                                            @if(($searchTerm ?? false) || ($filtroGrado ?? false) || ($filtroEstado ?? false))
                                                No se encontraron alumnos que coincidan con los criterios de búsqueda.
                                            @else
                                                Aún no has agregado ningún alumno al sistema.
                                            @endif
                                        </p>
                                        @if(!($searchTerm ?? false) && !($filtroGrado ?? false) && !($filtroEstado ?? false))
                                            <a href="{{ route('admin.alumnos.create') }}" 
                                               class="inline-flex items-center px-4 py-2 border border-transparent text-sm font-medium rounded-lg text-white bg-indigo-600 hover:bg-indigo-700 transition-colors duration-200">
                                                <i class="bi bi-plus-lg mr-2"></i>
                                                Agregar primer alumno
                                            </a>
                                        @else
                                            <button type="button" 
                                                    onclick="clearFilters()" 
                                                    class="inline-flex items-center px-4 py-2 border border-gray-300 text-sm font-medium rounded-lg text-gray-700 bg-white hover:bg-gray-50 transition-colors duration-200">
                                                <i class="bi bi-arrow-clockwise mr-2"></i>
                                                Limpiar filtros
                                            </button>
                                        @endif
                                    </div>
                                </div>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    <!-- Paginación mejorada -->
    @if ($alumnos->hasPages())
        <div class="mt-8 px-6 py-4 bg-white rounded-xl shadow-sm border border-gray-200">
            <div class="flex items-center justify-between">
                <div class="text-sm text-gray-500">
                    Página {{ $alumnos->currentPage() }} de {{ $alumnos->lastPage() }}
                </div>
                <div class="pagination-wrapper">
                    {{ $alumnos->appends(request()->query())->links() }}
                </div>
            </div>
        </div>
    @endif

<!-- Modal de confirmación de eliminación -->
<x-delete-modal title="Eliminar Alumno" />
@endsection

@push('styles')
<style>
    .animate-fadeIn {
        animation: fadeIn 0.5s ease-in-out;
    }
    
    @keyframes fadeIn {
        from { opacity: 0; transform: translateY(-10px); }
        to { opacity: 1; transform: translateY(0); }
    }
    
    .pagination-wrapper .pagination {
        display: flex;
        list-style: none;
        border-radius: 0.5rem;
        padding: 0;
        margin: 0;
    }
    
    .pagination-wrapper .pagination li {
        margin: 0 2px;
    }
    
    .pagination-wrapper .pagination li a,
    .pagination-wrapper .pagination li span {
        display: flex;
        align-items: center;
        justify-content: center;
        padding: 0.5rem 0.75rem;
        text-decoration: none;
        color: #6b7280;
        background-color: white;
        border: 1px solid #d1d5db;
        border-radius: 0.375rem;
        transition: all 0.2s;
        font-size: 0.875rem;
    }
    
    .pagination-wrapper .pagination li a:hover {
        background-color: #f3f4f6;
        color: #374151;
    }
    
    .pagination-wrapper .pagination li.active span {
        background-color: #4f46e5;
        color: white;
        border-color: #4f46e5;
    }
    


    
</style>
@endpush

@push('scripts')
<script>
    // Función para limpiar búsqueda
    function clearSearch() {
        document.getElementById('search').value = '';
        document.getElementById('filterForm').submit();
    }
    
    // Función para limpiar todos los filtros
    function clearFilters() {
        window.location.href = '{{ route("admin.alumnos.index") }}';
    }
         
    // Auto-submit en cambio de filtros
    document.getElementById('grado').addEventListener('change', function() {
        document.getElementById('filterForm').submit();
    });
    
    document.getElementById('estado_filtro').addEventListener('change', function() {
        document.getElementById('filterForm').submit();
    });
    
    // Feedback visual al enviar formulario
    document.getElementById('filterForm').addEventListener('submit', function() {
        const submitBtn = this.querySelector('button[type="submit"]');
        const originalText = submitBtn.innerHTML;
        submitBtn.innerHTML = '<i class="bi bi-arrow-clockwise animate-spin mr-2"></i>Aplicando...';
        submitBtn.disabled = true;
        
        setTimeout(() => {
            submitBtn.innerHTML = originalText;
            submitBtn.disabled = false;
        }, 2000);
    });
    

</script>
@endpush
