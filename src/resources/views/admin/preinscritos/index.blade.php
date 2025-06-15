@extends('layouts.admin')

@section('title', 'Gestión de Preinscritos')
@section('page-title', 'Lista de Preinscritos')

@section('content')
    {{-- Mensajes Flash --}}
    @if (session('success'))
        <div class="mb-6 px-4 py-3 rounded-lg relative bg-gradient-to-r from-green-50 to-green-100 border-l-4 border-green-400 text-green-800 shadow-sm animate-fadeIn" role="alert">
            <div class="flex items-center"><i class="bi bi-check-circle-fill text-green-500 mr-3"></i><div><strong class="font-semibold">¡Éxito!</strong> <p class="text-sm mt-1">{{ session('success') }}</p></div></div>
        </div>
    @endif
    @if (session('error'))
        <div class="mb-6 px-4 py-3 rounded-lg relative bg-gradient-to-r from-red-50 to-red-100 border-l-4 border-red-400 text-red-800 shadow-sm animate-fadeIn" role="alert">
            <div class="flex items-center"><i class="bi bi-exclamation-triangle-fill text-red-500 mr-3"></i><div><strong class="font-semibold">¡Atención!</strong> <p class="text-sm mt-1">{{ session('error') }}</p></div></div>
        </div>
    @endif

    <!-- KPIs para Preinscritos -->
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
        <div class="bg-gradient-to-br from-white to-gray-50 p-6 rounded-xl shadow-sm border border-gray-100 hover:shadow-md transition-all group">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-xs font-semibold text-gray-600 uppercase tracking-wider mb-2">Total Preinscritos</p>
                    <p class="text-3xl font-bold text-gray-900">{{ $totalPreinscritos ?? $preinscritos->total() }}</p> {{-- Usar la variable específica si se pasa --}}
                </div>
                <div class="p-3 bg-sky-100 rounded-lg group-hover:bg-sky-200 transition-colors">
                    <i class="bi bi-person-lines-fill text-2xl text-sky-600"></i>
                </div>
            </div>
        </div>
        <div class="bg-gradient-to-br from-white to-gray-50 p-6 rounded-xl shadow-sm border border-gray-100 hover:shadow-md transition-all group">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-xs font-semibold text-gray-600 uppercase tracking-wider mb-2">Pendientes</p>
                    <p class="text-3xl font-bold text-gray-900">{{ $preinscritosPendientes ?? '0' }}</p>
                </div>
                 <div class="p-3 bg-yellow-100 rounded-lg group-hover:bg-yellow-200 transition-colors">
                    <i class="bi bi-hourglass-split text-2xl text-yellow-600"></i>
                </div>
            </div>
        </div>
        <div class="bg-gradient-to-br from-white to-gray-50 p-6 rounded-xl shadow-sm border border-gray-100 hover:shadow-md transition-all group">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-xs font-semibold text-gray-600 uppercase tracking-wider mb-2">Importados Hoy</p>
                    <p class="text-3xl font-bold text-gray-900">{{ $importadosHoy ?? '0' }}</p>
                </div>
                 <div class="p-3 bg-purple-100 rounded-lg group-hover:bg-purple-200 transition-colors">
                    <i class="bi bi-calendar-plus-fill text-2xl text-purple-600"></i>
                </div>
            </div>
        </div>
        <div class="bg-gradient-to-br from-white to-gray-50 p-6 rounded-xl shadow-sm border border-gray-100 hover:shadow-md transition-all group">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-xs font-semibold text-gray-600 uppercase tracking-wider mb-2">Convertidos a Alumno</p>
                    <p class="text-3xl font-bold text-gray-900">{{ $preinscritosConvertidos ?? '0' }}</p>
                </div>
                 <div class="p-3 bg-green-100 rounded-lg group-hover:bg-green-200 transition-colors">
                    <i class="bi bi-person-check-fill text-2xl text-green-600"></i>
                </div>
            </div>
        </div>
    </div>

    <!-- Filtros y Herramientas -->
    <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6 mb-8">
        <form method="GET" action="{{ route('admin.preinscritos.index') }}" id="filterFormPreinscritos">
             <div class="flex flex-col lg:flex-row justify-between items-start lg:items-center gap-6">
                <div class="flex flex-col sm:flex-row items-stretch sm:items-center gap-4 w-full lg:w-auto">
                    <div class="relative group">
                        <div class="absolute inset-y-0 left-0 flex items-center pl-4 pointer-events-none"><i class="bi bi-search text-gray-400"></i></div>
                        <input type="text" name="search" id="searchPreinscritos"
                               class="block w-full sm:w-72 pl-11 pr-10 py-3 border border-gray-300 rounded-lg bg-gray-50 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-transparent focus:bg-white transition-all text-sm"
                               placeholder="Buscar por nombre, DNI o email..." value="{{ $searchTerm ?? '' }}" autocomplete="off">
                        @if($searchTerm ?? '') {{-- Añadida comprobación para $searchTerm --}}
                            <button type="button" onclick="document.getElementById('searchPreinscritos').value=''; document.getElementById('filterFormPreinscritos').submit();" class="absolute inset-y-0 right-0 flex items-center pr-4 text-gray-400 hover:text-gray-600"><i class="bi bi-x-lg"></i></button>
                        @endif
                    </div>

                    @if(isset($opcionesEstadoPre) && $opcionesEstadoPre->count() > 0) {{-- Solo mostrar si hay opciones --}}
                    <div class="relative">
                        <select name="estado_pre" id="estado_pre_filtro" onchange="this.form.submit()"
                                class="block w-full sm:w-auto rounded-lg border border-gray-300 bg-gray-50 px-4 py-3 text-sm focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-transparent focus:bg-white transition-all appearance-none cursor-pointer">
                            <option value="">Todos los Estados</option>
                            @foreach ($opcionesEstadoPre as $estado)
                                <option value="{{ $estado }}" {{ ($filtroEstadoPre ?? '') == $estado ? 'selected' : '' }}>{{ $estado }}</option>
                            @endforeach
                        </select>
                        <div class="absolute inset-y-0 right-0 flex items-center pr-3 pointer-events-none"><i class="bi bi-chevron-down text-gray-400"></i></div>
                    </div>
                    @endif

                    @if( ($searchTerm ?? '') || ($filtroEstadoPre ?? '') )
                        <a href="{{ route('admin.preinscritos.index') }}" class="inline-flex items-center justify-center px-4 py-3 text-sm font-medium rounded-lg text-gray-500 bg-gray-100 hover:bg-gray-200" title="Limpiar filtros"><i class="bi bi-arrow-clockwise"></i></a>
                    @else
                        <button type="submit" class="px-6 py-3 text-sm font-medium text-white bg-gray-600 rounded-lg shadow-sm hover:bg-gray-700">Filtrar</button>
                    @endif
                </div>
                <div class="flex-shrink-0 w-full sm:w-auto">
                    <a href="{{ route('admin.preinscritos.create') }}" class="w-full sm:w-auto inline-flex items-center justify-center px-6 py-3 border border-transparent shadow-sm text-sm font-semibold rounded-lg text-white bg-indigo-600 hover:bg-indigo-700">
                        <i class="bi bi-plus-lg mr-2"></i> Nuevo Preinscrito
                    </a>
                </div>
            </div>
            @if($preinscritos->total() > 0)
                <div class="mt-4 pt-4 border-t border-gray-100"><p class="text-sm text-gray-600">Mostrando {{ $preinscritos->firstItem() }}-{{ $preinscritos->lastItem() }} de {{ $preinscritos->total() }} preinscritos.</p></div>
            @endif
        </form>
    </div>

    <!-- Tabla de Preinscritos -->
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
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Fecha Importación</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Estado</th>
                        <th class="px-6 py-3 text-center text-xs font-medium text-gray-500 uppercase tracking-wider">Acciones</th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-100">
                    @forelse ($preinscritos as $preinscrito)
                        <tr class="hover:bg-gray-50">
                            <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">{{ $preinscrito->nombre }} {{ $preinscrito->apellido1 }} {{ $preinscrito->apellido2 ?? '' }}</td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">{{ $preinscrito->dni }}</td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">{{ $preinscrito->email ?? 'N/A' }}</td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">{{ $preinscrito->telefono ?? 'N/A' }}</td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">{{ $preinscrito->nivel_formativo ?? 'N/A' }}</td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                {{ $preinscrito->fecha_importacion ? $preinscrito->fecha_importacion->format('d/m/Y H:i') : ($preinscrito->created_at ? $preinscrito->created_at->format('d/m/Y H:i') : 'N/A') }}
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                @php
                                    $estadoPre = $preinscrito->estado ?? 'Pendiente'; // Valor por defecto
                                    $badgeColorPre = 'bg-gray-100 text-gray-800'; // Default
                                    if ($estadoPre === 'Pendiente') $badgeColorPre = 'bg-yellow-100 text-yellow-800';
                                    elseif ($estadoPre === 'Contactado') $badgeColorPre = 'bg-blue-100 text-blue-800';
                                    elseif ($estadoPre === 'Convertido') $badgeColorPre = 'bg-green-100 text-green-800';
                                    elseif ($estadoPre === 'Rechazado') $badgeColorPre = 'bg-red-100 text-red-800';
                                @endphp
                                <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full {{ $badgeColorPre }}">
                                    {{ $estadoPre }}
                                </span>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-center text-sm">
                                <div class="flex items-center justify-center space-x-2">

                                    {{-- Mostrar solo si el preinscrito aún NO está convertido --}}
                                    @if(($preinscrito->estado ?? 'Pendiente') !== 'Convertido')
                                    {{-- Convertir a Alumno --}}
<button type="button"
        onclick="confirmConvert(
            '{{ route('admin.preinscritos.convertir', $preinscrito->id) }}',
            '{{ addslashes($preinscrito->nombre) }}'
        )"
        class="text-green-500 hover:text-green-700"
        title="Convertir a Alumno">
    <i class="bi bi-person-plus-fill"></i>
</button>

                                    @endif

                                    <a href="{{ route('admin.preinscritos.show', $preinscrito->id) }}" class="text-blue-500 hover:text-blue-700" title="Ver Detalles"><i class="bi bi-eye-fill"></i></a>
                                    <a href="{{ route('admin.preinscritos.edit', $preinscrito->id) }}" class="text-indigo-500 hover:text-indigo-700" title="Editar"><i class="bi bi-pencil-fill"></i></a>
                                    {{-- Botón para eliminar Preinscrito con modal --}}
                                    <button type="button"
                                            {{-- Pasamos la URL de la ruta destroy y el nombre del preinscrito --}}
                                            onclick="confirmDelete(
                                                '{{ route('admin.preinscritos.destroy', $preinscrito->id) }}',
                                                '{{ addslashes($preinscrito->nombre) }}'
                                            )"
                                            class="text-red-500 hover:text-red-700"
                                            title="Eliminar preinscrito">
                                        <i class="bi bi-trash-fill"></i>
                                    </button>

                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="8" class="px-6 py-12 text-center text-sm text-gray-500">
                                <div class="flex flex-col items-center justify-center space-y-3">
                                <i class="bi bi-person-lines-fill text-4xl text-gray-400"></i>
                                <p class="font-semibold">No se encontraron preinscritos.</p>
                                 @if($searchTerm ?? '' || $filtroEstadoPre ?? '')
                                    <p class="text-xs">Prueba a cambiar tus términos de búsqueda o filtros.</p>
                                    <a href="{{ route('admin.preinscritos.index') }}" class="mt-2 inline-flex items-center px-3 py-1.5 border border-gray-300 text-xs font-medium rounded-md text-gray-700 bg-white hover:bg-gray-50">Limpiar filtros</a>
                                @else
                                    <p class="text-xs">Puedes añadir nuevos preinscritos usando el botón superior.</p>
                                @endif
                                </div>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    @if ($preinscritos->hasPages())
        <div class="mt-8 px-6 py-4 bg-white rounded-xl shadow-sm">
            {{ $preinscritos->appends(request()->query())->links() }}
        </div>
    @endif
<!-- Modal de confirmación de eliminación -->
<x-convert-modal title="Convertir a Alumno"/>
<x-delete-modal title="Eliminar preinscrito" />
@endsection

@push('scripts')
<script>
    // Auto-submit para el filtro de estado si se descomenta el select
    // const estadoFiltroSelect = document.getElementById('estado_pre_filtro');
    // if(estadoFiltroSelect) {
    //     estadoFiltroSelect.addEventListener('change', function() {
    //         document.getElementById('filterFormPreinscritos').submit();
    //     });
    // }
    function confirmConvert(url, itemName) {
    // 1 – indicar al formulario la URL correcta
    document.getElementById('convertForm').action = url;

    // 2 – actualizar el texto del cuerpo con el nombre
    const body = document.querySelector('#convertModal .text-sm');
    if (body) {
        body.innerHTML =
            `¿Estás seguro de que quieres convertir <strong>${itemName}</strong> en alumno?<br>` +
            'Esta acción no se puede deshacer.';
    }

    // 3 – mostrar modal
    document.getElementById('convertModal').classList.remove('hidden');
}

function closeConvertModal() {
    document.getElementById('convertModal').classList.add('hidden');
}

</script>
@endpush
