@extends('layouts.admin')

@section('title', 'Gestión de Profesores')
@section('page-title', 'Gestión de Profesores')

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
                    <p class="text-xs font-semibold text-gray-600 uppercase tracking-wider mb-2">Total Profesores</p>
                    <p class="text-3xl font-bold text-gray-900">{{ $totalProfesores ?? '0' }}</p>
                </div>
                <div class="p-3 bg-blue-100 rounded-lg group-hover:bg-blue-200 transition-colors duration-200">
                    <i class="bi bi-people-fill text-2xl text-blue-600"></i>
                </div>
            </div>
        </div>
        
        <div class="bg-gradient-to-br from-white to-gray-50 p-6 rounded-xl shadow-sm border border-gray-100 hover:shadow-md transition-all duration-200 group">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-xs font-semibold text-gray-600 uppercase tracking-wider mb-2">Media Cursos/Profesor</p>
                    <p class="text-3xl font-bold text-gray-900">{{ number_format($mediaCursosPorProfesor ?? 0, 1) }}</p>
                </div>
                <div class="p-3 bg-green-100 rounded-lg group-hover:bg-green-200 transition-colors duration-200">
                    <i class="bi bi-graph-up text-2xl text-green-600"></i>
                </div>
            </div>
        </div>
        
        <div class="bg-gradient-to-br from-white to-gray-50 p-6 rounded-xl shadow-sm border border-gray-100 hover:shadow-md transition-all duration-200 group">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-xs font-semibold text-gray-600 uppercase tracking-wider mb-2">Especialidades</p>
                    <p class="text-3xl font-bold text-gray-900">{{ count($opcionesEspecialidad ?? []) }}</p>
                </div>
                <div class="p-3 bg-purple-100 rounded-lg group-hover:bg-purple-200 transition-colors duration-200">
                    <i class="bi bi-mortarboard-fill text-2xl text-purple-600"></i>
                </div>
            </div>
        </div>
        
        <div class="bg-gradient-to-br from-white to-gray-50 p-6 rounded-xl shadow-sm border border-gray-100 hover:shadow-md transition-all duration-200 group">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-xs font-semibold text-gray-600 uppercase tracking-wider mb-2">Activos Este Mes</p>
                    <p class="text-3xl font-bold text-gray-900">{{ $totalProfesores ?? '0' }}</p>
                </div>
                <div class="p-3 bg-orange-100 rounded-lg group-hover:bg-orange-200 transition-colors duration-200">
                    <i class="bi bi-activity text-2xl text-orange-600"></i>
                </div>
            </div>
        </div>
    </div>

    <!-- Filtros y Herramientas - Diseño mejorado -->
    <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6 mb-8">
        <form method="GET" action="{{ route('admin.profesores.index') }}" id="filterForm">
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
                               placeholder="Buscar por nombre, DNI o email..." 
                               value="{{ $searchTerm ?? '' }}"
                               autocomplete="off">
                        @if($searchTerm)
                            <button type="button" 
                                    onclick="clearSearch()" 
                                    class="absolute inset-y-0 right-0 flex items-center pr-4 text-gray-400 hover:text-gray-600">
                                <i class="bi bi-x-lg"></i>
                            </button>
                        @endif
                    </div>
                    
                    <!-- Filtro de especialidad mejorado -->
                    <div class="relative">
                        <select name="especialidad" 
                                id="especialidad_filtro" 
                                class="block w-full sm:w-60 rounded-lg border border-gray-300 bg-gray-50 px-4 py-3 text-sm focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-transparent focus:bg-white transition-all duration-200 appearance-none cursor-pointer">
                            <option value="">📚 Todas las Especialidades</option>
                            @foreach ($opcionesEspecialidad as $especialidad)
                                <option value="{{ $especialidad }}" {{ ($filtroEspecialidad == $especialidad) ? 'selected' : '' }}>
                                    {{ $especialidad }}
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
                        @if($searchTerm || $filtroEspecialidad)
                            <a href="{{ route('admin.profesores.index') }}" 
                               class="inline-flex items-center justify-center px-4 py-3 text-sm font-medium rounded-lg text-gray-500 bg-gray-100 hover:bg-gray-200 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-gray-500 transition-all duration-200"
                               title="Limpiar filtros">
                                <i class="bi bi-arrow-clockwise"></i>
                            </a>
                        @endif
                    </div>
                </div>
                
                <!-- Botón principal mejorado -->
                <div class="flex-shrink-0 w-full sm:w-auto">
                    <a href="{{ route('admin.profesores.create') }}" 
                       class="w-full sm:w-auto inline-flex items-center justify-center px-6 py-3 border border-transparent shadow-sm text-sm font-semibold rounded-lg text-white bg-gradient-to-r from-indigo-600 to-indigo-700 hover:from-indigo-700 hover:to-indigo-800 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 transition-all duration-200 transform hover:scale-105">
                        <i class="bi bi-plus-lg mr-2"></i> 
                        Nuevo Profesor
                    </a>
                </div>
            </div>
            
            <!-- Información de resultados -->
            @if($profesores->total() > 0)
                <div class="mt-4 pt-4 border-t border-gray-100">
                    <p class="text-sm text-gray-600">
                        <i class="bi bi-info-circle mr-1"></i>
                        Mostrando {{ $profesores->firstItem() }}-{{ $profesores->lastItem() }} de {{ $profesores->total() }} profesores
                        @if($searchTerm || $filtroEspecialidad)
                            <span class="ml-2 px-2 py-1 bg-indigo-100 text-indigo-800 rounded-full text-xs font-medium">
                                Filtros activos
                            </span>
                        @endif
                    </p>
                </div>
            @endif
        </form>
    </div>

    <!-- Tabla de Profesores - Diseño mejorado -->
    <div class="bg-white rounded-xl shadow-sm border border-gray-200 overflow-hidden">
        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-gray-200">
                <thead class="bg-gradient-to-r from-gray-50 to-gray-100">
                    <tr>
                        <th scope="col" class="px-6 py-4 text-left text-xs font-bold text-gray-600 uppercase tracking-wider">
                            <div class="flex items-center space-x-1">
                                <i class="bi bi-person-fill"></i>
                                <span>Profesor</span>
                            </div>
                        </th>
                        <th scope="col" class="px-6 py-4 text-left text-xs font-bold text-gray-600 uppercase tracking-wider">
                            <div class="flex items-center space-x-1">
                                <i class="bi bi-card-text"></i>
                                <span>DNI</span>
                            </div>
                        </th>
                        <th scope="col" class="px-6 py-4 text-left text-xs font-bold text-gray-600 uppercase tracking-wider">
                            <div class="flex items-center space-x-1">
                                <i class="bi bi-envelope"></i>
                                <span>Email</span>
                            </div>
                        </th>
                        <th scope="col" class="px-6 py-4 text-left text-xs font-bold text-gray-600 uppercase tracking-wider">
                            <div class="flex items-center space-x-1">
                                <i class="bi bi-mortarboard"></i>
                                <span>Especialidad</span>
                            </div>
                        </th>
                        <th scope="col" class="px-6 py-4 text-center text-xs font-bold text-gray-600 uppercase tracking-wider">
                            <div class="flex items-center justify-center space-x-1">
                                <i class="bi bi-book"></i>
                                <span>Cursos</span>
                            </div>
                        </th>
                        <th scope="col" class="px-6 py-4 text-center text-xs font-bold text-gray-600 uppercase tracking-wider">
                            Acciones
                        </th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-100">
                    @forelse ($profesores as $profesor)
                        <tr class="hover:bg-gray-50 transition-colors duration-150 group">
                            <td class="px-6 py-5 whitespace-nowrap">
                                <div class="flex items-center">
                                    <div class="flex-shrink-0 h-12 w-12">
                                        <img class="h-12 w-12 rounded-full ring-2 ring-gray-200 group-hover:ring-indigo-300 transition-all duration-200" 
                                             src="https://ui-avatars.com/api/?name={{ urlencode($profesor->nombre . ' ' . $profesor->apellido1) }}&color=7F9CF5&background=EBF4FF&font-size=0.33" 
                                             alt="Avatar de {{ $profesor->nombre }}">
                                    </div>
                                    <div class="ml-4">
                                        <div class="text-sm font-semibold text-gray-900 group-hover:text-indigo-600 transition-colors duration-200">
                                            {{ $profesor->nombre }} {{ $profesor->apellido1 }} {{ $profesor->apellido2 }}
                                        </div>
                                        <div class="text-xs text-gray-500 mt-1 flex items-center">
                                            <i class="bi bi-mortarboard mr-1"></i>
                                            {{ $profesor->titulacion_academica ?? 'Titulación no especificada' }}
                                        </div>
                                    </div>
                                </div>
                            </td>
                            <td class="px-6 py-5 whitespace-nowrap">
                                <div class="text-sm text-gray-900 font-mono">{{ $profesor->dni }}</div>
                            </td>
                            <td class="px-6 py-5 whitespace-nowrap">
                                <div class="text-sm text-gray-700">
                                    <a href="mailto:{{ $profesor->email }}" 
                                       class="hover:text-indigo-600 transition-colors duration-200 flex items-center">
                                        <i class="bi bi-envelope-fill mr-1 text-xs"></i>
                                        {{ $profesor->email }}
                                    </a>
                                </div>
                            </td>
                            <td class="px-6 py-5 whitespace-nowrap">
                                @if($profesor->especialidad)
                                    <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-medium bg-blue-100 text-blue-800">
                                        {{ $profesor->especialidad }}
                                    </span>
                                @else
                                    <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-medium bg-gray-100 text-gray-600">
                                        Sin especialidad
                                    </span>
                                @endif
                            </td>
                            <td class="px-6 py-5 whitespace-nowrap text-center">
                                <div class="flex items-center justify-center">
                                    <span class="inline-flex items-center justify-center h-8 w-8 rounded-full text-sm font-semibold
                                        {{ $profesor->cursos_count > 0 ? 'bg-green-100 text-green-800' : 'bg-gray-100 text-gray-600' }}">
                                        {{ $profesor->cursos_count }}
                                    </span>
                                </div>
                            </td>
                            <td class="px-6 py-5 whitespace-nowrap text-center">
                                <div class="flex items-center justify-center space-x-2">
                                <a href="{{ route('admin.profesores.show', ['profesore' => $profesor]) }}" class="inline-flex items-center justify-center h-8 w-8 rounded-lg text-gray-400 hover:text-blue-600 hover:bg-blue-50 transition-all duration-200 group/btn"
                                    title="Ver detalles">
                                    <i class="bi bi-eye-fill group-hover/btn:scale-110 transition-transform duration-200"></i>
                                </a>
                                    <a href="{{ route('admin.profesores.edit', ['profesore' => $profesor]) }}" 
                                       class="inline-flex items-center justify-center h-8 w-8 rounded-lg text-gray-400 hover:text-indigo-600 hover:bg-indigo-50 transition-all duration-200 group/btn"
                                       title="Editar información">
                                        <i class="bi bi-pencil-fill group-hover/btn:scale-110 transition-transform duration-200"></i>
                                    </a>
                                    <button type="button" 
                                            onclick="confirmDelete('{{ $profesor->id }}', '{{ $profesor->nombre }} {{ $profesor->apellido1 }}')"
                                            class="inline-flex items-center justify-center h-8 w-8 rounded-lg text-gray-400 hover:text-red-600 hover:bg-red-50 transition-all duration-200 group/btn"
                                            title="Eliminar profesor">
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
                                        <i class="bi bi-people text-4xl text-gray-400"></i>
                                    </div>
                                    <div class="text-center">
                                        <h3 class="text-lg font-medium text-gray-900 mb-2">No hay profesores</h3>
                                        <p class="text-sm text-gray-500 mb-4">
                                            @if($searchTerm || $filtroEspecialidad)
                                                No se encontraron profesores que coincidan con los criterios de búsqueda.
                                            @else
                                                Aún no has agregado ningún profesor al sistema.
                                            @endif
                                        </p>
                                        @if(!$searchTerm && !$filtroEspecialidad)
                                            <a href="{{ route('admin.profesores.create') }}" 
                                               class="inline-flex items-center px-4 py-2 border border-transparent text-sm font-medium rounded-lg text-white bg-indigo-600 hover:bg-indigo-700 transition-colors duration-200">
                                                <i class="bi bi-plus-lg mr-2"></i>
                                                Agregar primer profesor
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
    @if ($profesores->hasPages())
        <div class="mt-8 px-6 py-4 bg-white rounded-xl shadow-sm border border-gray-200">
            <div class="flex items-center justify-between">
                <div class="text-sm text-gray-600">
                    Página {{ $profesores->currentPage() }} de {{ $profesores->lastPage() }}
                </div>
                <div class="pagination-wrapper">
                    {{ $profesores->appends(request()->query())->links() }}
                </div>
            </div>
        </div>
    @endif

    <!-- Modal de confirmación de eliminación -->
    <div id="deleteModal" class="fixed inset-0 bg-gray-600 bg-opacity-50 overflow-y-auto h-full w-full z-50 hidden">
    <div class="relative top-20 mx-auto p-5 border w-96 shadow-lg rounded-xl bg-white">
        <div class="mt-3 text-center">
            <div class="mx-auto flex items-center justify-center h-12 w-12 rounded-full bg-red-100 mb-4">
                <i class="bi bi-exclamation-triangle text-red-600 text-xl"></i>
            </div>
            <h3 class="text-lg font-semibold text-gray-900 mb-2">Eliminar Profesor</h3>
            <p class="text-sm text-gray-500 mb-4">
                ¿Estás seguro de que quieres eliminar a <strong id="profesorName"></strong>?
                Esta acción no se puede deshacer.
            </p>
            <div class="flex justify-center space-x-3">
                <button type="button"
                        onclick="closeDeleteModal()"
                        class="px-4 py-2 bg-gray-300 text-gray-800 text-sm font-medium rounded-lg hover:bg-gray-400 transition-colors duration-200">
                    Cancelar
                </button>
                <form id="deleteForm" method="POST"> {{-- La action se establece con JS --}}
                    @csrf
                    @method('DELETE')
                    <button type="submit"
                            class="px-4 py-2 bg-red-600 text-white text-sm font-medium rounded-lg hover:bg-red-700 transition-colors duration-200">
                        Eliminar
                    </button>
                </form>
            </div>
        </div>
    </div>
</div>

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
        window.location.href = '{{ route("admin.profesores.index") }}';
    }
    
    // Función para confirmar eliminación
    function confirmDelete(profesorId, profesorName) {
        document.getElementById('profesorName').textContent = profesorName;
        document.getElementById('deleteForm').action = '{{ route("admin.profesores.destroy", ["profesore" => ":id"]) }}'.replace(':id', profesorId);
        document.getElementById('deleteModal').classList.remove('hidden');
    }
    
    // Función para cerrar modal de eliminación
    function closeDeleteModal() {
        document.getElementById('deleteModal').classList.add('hidden');
    }
    
    // Cerrar modal con ESC
    document.addEventListener('keydown', function(event) {
        if (event.key === 'Escape') {
            closeDeleteModal();
        }
    });
    
    // Cerrar modal clickeando fuera
    document.getElementById('deleteModal').addEventListener('click', function(event) {
        if (event.target === this) {
            closeDeleteModal();
        }
    });
    
    // Auto-submit en cambio de filtro
    document.getElementById('especialidad_filtro').addEventListener('change', function() {
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
