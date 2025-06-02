@extends('layouts.admin')

@section('title', 'Gestión de Preinscritos')
@section('page-title', 'Lista de Preinscritos')

@section('content')
    {{-- Mensajes Flash --}}
    @if (session('success'))
        <div class="mb-6 px-4 py-3 rounded-lg bg-green-100 border-l-4 border-green-400 text-green-800">...</div>
    @endif
    @if (session('error'))
        <div class="mb-6 px-4 py-3 rounded-lg bg-red-100 border-l-4 border-red-400 text-red-800">...</div>
    @endif

    {{-- KPIs para Preinscritos (Placeholder) --}}
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
        <div class="bg-white p-6 rounded-xl shadow">Total: {{ $preinscritos->total() }}</div>
        {{-- Añadir más KPIs relevantes para preinscritos aquí --}}
    </div>

    {{-- Filtros y Buscador (Basado en el de Profesores, adaptar campos y placeholders) --}}
    <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6 mb-8">
        <form method="GET" action="{{ route('admin.preinscritos.index') }}" id="filterFormPreinscritos">
            <div class="flex flex-col lg:flex-row justify-between items-start lg:items-center gap-6">
                <div class="flex flex-col sm:flex-row items-stretch sm:items-center gap-4 w-full lg:w-auto">
                    <div class="relative group">
                        <div class="absolute inset-y-0 left-0 flex items-center pl-4 pointer-events-none"><i class="bi bi-search text-gray-400"></i></div>
                        <input type="text" name="search" id="searchPreinscritos"
                               class="block w-full sm:w-72 pl-11 pr-10 py-3 border border-gray-300 rounded-lg bg-gray-50 focus:outline-none focus:ring-2 focus:ring-indigo-500"
                               placeholder="Buscar por nombre, DNI o email..." value="{{ $searchTerm ?? '' }}" autocomplete="off">
                        @if($searchTerm)
                            <button type="button" onclick="document.getElementById('searchPreinscritos').value=''; document.getElementById('filterFormPreinscritos').submit();" class="absolute inset-y-0 right-0 flex items-center pr-4 text-gray-400 hover:text-gray-600"><i class="bi bi-x-lg"></i></button>
                        @endif
                    </div>
                    {{-- Aquí irían los <select> para filtrar por estado_pre si lo implementas --}}
                    <button type="submit" class="btn-primary-tailwind"> {{-- Reemplaza con tu clase de botón Tailwind --}}
                        <i class="bi bi-funnel mr-2"></i>Aplicar
                    </button>
                     @if($searchTerm {{-- || $filtroEstadoPre --}})
                        <a href="{{ route('admin.preinscritos.index') }}" class="btn-secondary-tailwind"> {{-- Reemplaza --}}
                            <i class="bi bi-arrow-clockwise"></i>
                        </a>
                    @endif
                </div>
                <div class="flex-shrink-0 w-full sm:w-auto">
                    <a href="{{ route('admin.preinscritos.create') }}" class="btn-indigo-tailwind"> {{-- Reemplaza --}}
                        <i class="bi bi-plus-lg mr-2"></i> Nuevo Preinscrito
                    </a>
                </div>
            </div>
             @if($preinscritos->total() > 0)
                <div class="mt-4 pt-4 border-t border-gray-100"><p class="text-sm text-gray-600">Mostrando {{ $preinscritos->firstItem() }}-{{ $preinscritos->lastItem() }} de {{ $preinscritos->total() }} preinscritos.</p></div>
            @endif
        </form>
    </div>

    {{-- Tabla de Preinscritos --}}
    <div class="bg-white rounded-xl shadow-sm border border-gray-200 overflow-hidden">
        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-gray-200">
                <thead class="bg-gray-50">
                    <tr>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Nombre Completo</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">DNI</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Email</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Teléfono</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Nivel Formativo</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Fecha Import.</th>
                        {{-- <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Estado</th> --}}
                        <th class="px-6 py-3 text-center text-xs font-medium text-gray-500 uppercase tracking-wider">Acciones</th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-100">
                    @forelse ($preinscritos as $preinscrito)
                        <tr class="hover:bg-gray-50">
                            <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">{{ $preinscrito->nombre }} {{ $preinscrito->apellido1 }} {{ $preinscrito->apellido2 }}</td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">{{ $preinscrito->dni }}</td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">{{ $preinscrito->email ?? 'N/A' }}</td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">{{ $preinscrito->telefono ?? 'N/A' }}</td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">{{ $preinscrito->nivel_formativo ?? 'N/A' }}</td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">{{ $preinscrito->fecha_importacion ? $preinscrito->fecha_importacion->format('d/m/Y H:i') : 'N/A' }}</td>
                            {{-- Columna Estado (si la tienes) --}}
                            {{-- <td class="px-6 py-4 whitespace-nowrap">
                                <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-yellow-100 text-yellow-800">{{ $preinscrito->estado ?? 'Pendiente' }}</span>
                            </td> --}}
                            <td class="px-6 py-4 whitespace-nowrap text-center text-sm">
                                <div class="flex items-center justify-center space-x-2">
                                    {{-- Botón Convertir a Alumno --}}
                                    <form action="{{ route('admin.preinscritos.convertir', $preinscrito->id) }}" method="POST" class="inline" onsubmit="return confirm('¿Estás seguro de convertir este preinscrito en alumno?');">
                                        @csrf
                                        <button type="submit" class="text-green-500 hover:text-green-700" title="Convertir a Alumno"><i class="bi bi-person-plus-fill"></i></button>
                                    </form>
                                    <a href="{{ route('admin.preinscritos.show', $preinscrito->id) }}" class="text-blue-500 hover:text-blue-700" title="Ver Detalles"><i class="bi bi-eye-fill"></i></a>
                                    <a href="{{ route('admin.preinscritos.edit', $preinscrito->id) }}" class="text-indigo-500 hover:text-indigo-700" title="Editar"><i class="bi bi-pencil-fill"></i></a>
                                    <form action="{{ route('admin.preinscritos.destroy', $preinscrito->id) }}" method="POST" class="inline" onsubmit="return confirm('¿Seguro que quieres eliminar este preinscrito?');">
                                        @csrf @method('DELETE')
                                        <button type="submit" class="text-red-500 hover:text-red-700" title="Eliminar"><i class="bi bi-trash-fill"></i></button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="8" class="px-6 py-12 text-center text-sm text-gray-500">No se encontraron preinscritos.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    {{-- Paginación --}}
    @if ($preinscritos->hasPages())
        <div class="mt-8 px-6 py-4 bg-white rounded-xl shadow-sm">
            {{ $preinscritos->appends(request()->query())->links() }}
        </div>
    @endif
@endsection

@push('scripts')
    {{-- Scripts específicos si son necesarios más adelante --}}
@endpush