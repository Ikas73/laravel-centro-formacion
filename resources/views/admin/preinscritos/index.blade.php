@extends('layouts.admin')

@section('title', 'Gestión de Preinscritos')
@section('page-title', 'Lista de Preinscritos')

@section('content')
    {{-- Mensajes Flash --}}
    @if (session('success'))
        <div class="flex items-center justify-between mb-6 px-4 py-3 rounded-xl relative bg-gradient-to-r from-green-50 to-green-100 border-l-4 border-green-500 text-green-800 shadow-lg animate-fadeIn" role="alert" x-data="{ show: true }" x-show="show" x-transition>
            <div class="flex items-center">
                <i class="bi bi-check-circle-fill text-green-500 mr-3 text-xl"></i>
                <div>
                    <strong class="font-semibold">¡Éxito!</strong>
                    <p class="text-sm mt-1">{{ session('success') }}</p>
                </div>
            </div>
            <button type="button" @click="show = false" class="p-1 text-green-800 hover:bg-green-100 rounded-full">&times;</button>
        </div>
    @endif
    @if (session('error'))
        <div class="flex items-center justify-between mb-6 px-4 py-3 rounded-xl relative bg-gradient-to-r from-red-50 to-red-100 border-l-4 border-red-500 text-red-800 shadow-lg animate-fadeIn" role="alert" x-data="{ show: true }" x-show="show" x-transition>
            <div class="flex items-center">
                <i class="bi bi-exclamation-triangle-fill text-red-500 mr-3 text-xl"></i>
                <div>
                    <strong class="font-semibold">¡Atención!</strong>
                    <p class="text-sm mt-1">{{ session('error') }}</p>
                </div>
            </div>
            <button type="button" @click="show = false" class="p-1 text-red-800 hover:bg-red-100 rounded-full">&times;</button>
        </div>
    @endif

    <!-- KPIs -->
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
        @php
            $kpis = [
                ['label' => 'Total Preinscritos', 'value' => $totalPreinscritos ?? $preinscritos->total(), 'icon' => 'bi-person-lines-fill', 'color' => 'sky'],
                ['label' => 'Pendientes', 'value' => $preinscritosPendientes ?? '0', 'icon' => 'bi-hourglass-split', 'color' => 'yellow'],
                ['label' => 'Importados Hoy', 'value' => $importadosHoy ?? '0', 'icon' => 'bi-calendar-plus-fill', 'color' => 'purple'],
                ['label' => 'Convertidos a Alumno', 'value' => $preinscritosConvertidos ?? '0', 'icon' => 'bi-person-check-fill', 'color' => 'green'],
            ];
        @endphp
        @foreach($kpis as $kpi)
        <div class="bg-white p-6 rounded-xl shadow border border-gray-100 hover:shadow-lg hover:-translate-y-1 transition-all duration-300 group">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm font-semibold text-gray-500 uppercase tracking-wider mb-1">{{ $kpi['label'] }}</p>
                    <p class="text-4xl font-bold text-gray-800">{{ $kpi['value'] }}</p>
                </div>
                <div class="p-4 bg-{{$kpi['color']}}-100 rounded-lg">
                    <i class="bi {{ $kpi['icon'] }} text-3xl text-{{$kpi['color']}}-600"></i>
                </div>
            </div>
        </div>
        @endforeach
    </div>

    <!-- Filtros y Herramientas -->
    <div class="bg-white rounded-xl shadow border border-gray-100 p-6 mb-8">
        <form method="GET" action="{{ route('admin.preinscritos.index') }}" id="filterFormPreinscritos">
            <div class="grid grid-cols-1 md:grid-cols-5 gap-4">
                {{-- Búsqueda principal --}}
                <div class="relative md:col-span-2">
                    <div class="absolute inset-y-0 left-0 flex items-center pl-4 pointer-events-none"><i class="bi bi-search text-gray-400"></i></div>
                    <input type="text" name="search" id="searchPreinscritos"
                           class="block w-full pl-11 pr-10 py-3 border border-gray-300 rounded-lg bg-gray-50 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-transparent transition text-sm"
                           placeholder="Buscar por nombre, DNI, email..." value="{{ $searchTerm ?? '' }}" autocomplete="off">
                    @if($searchTerm ?? '')
                        <button type="button" onclick="document.getElementById('searchPreinscritos').value=''; document.getElementById('filterFormPreinscritos').submit();" class="absolute inset-y-0 right-0 flex items-center pr-4 text-gray-400 hover:text-gray-600" title="Limpiar búsqueda"><i class="bi bi-x-lg"></i></button>
                    @endif
                </div>

                {{-- Filtro de Estado --}}
                @if(isset($opcionesEstadoPre) && $opcionesEstadoPre->count() > 0)
                <div class="relative md:col-span-1">
                    <select name="estado_pre" id="estado_pre_filtro" onchange="this.form.submit()"
                            class="block w-full rounded-lg border border-gray-300 bg-gray-50 px-4 py-3 text-sm focus:outline-none focus:ring-2 focus:ring-indigo-500 appearance-none cursor-pointer">
                        <option value="">Todos los Estados</option>
                        @foreach ($opcionesEstadoPre as $estado)
                            <option value="{{ $estado }}" {{ ($filtroEstadoPre ?? '') == $estado ? 'selected' : '' }}>{{ $estado }}</option>
                        @endforeach
                    </select>
                    <div class="absolute inset-y-0 right-0 flex items-center pr-3 pointer-events-none"><i class="bi bi-chevron-down text-gray-400"></i></div>
                </div>
                @endif
                
                {{-- Botones de Acción --}}
                <div class="md:col-span-2 flex items-center justify-end space-x-3">
                     @if( ($searchTerm ?? '') || ($filtroEstadoPre ?? '') )
                        <a href="{{ route('admin.preinscritos.index') }}" class="inline-flex items-center justify-center px-4 py-3 text-sm font-medium rounded-lg text-gray-600 bg-gray-100 hover:bg-gray-200 transition-colors" title="Limpiar todos los filtros">
                            <i class="bi bi-arrow-clockwise mr-2"></i> Limpiar
                        </a>
                    @endif
                    <a href="{{ route('admin.preinscritos.create') }}" class="w-full sm:w-auto inline-flex items-center justify-center px-5 py-3 border border-transparent shadow-sm text-sm font-semibold rounded-lg text-white bg-indigo-600 hover:bg-indigo-700 transition-colors">
                        <i class="bi bi-plus-lg mr-2"></i> Nuevo Preinscrito
                    </a>
                </div>
            </div>
             @if($preinscritos->total() > 0)
                <div class="mt-5 pt-4 border-t border-gray-100"><p class="text-sm text-gray-600">Mostrando <strong>{{ $preinscritos->firstItem() }}-{{ $preinscritos->lastItem() }}</strong> de <strong>{{ $preinscritos->total() }}</strong> resultados.</p></div>
            @endif
        </form>
    </div>

    <!-- Tabla de Preinscritos - Estilo final -->
    <div class="bg-white rounded-xl shadow overflow-hidden border border-gray-100">
        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-gray-200">
                <thead class="bg-gray-50">
                    <tr>
                        <th class="px-6 py-4 text-left text-xs font-semibold text-gray-500 uppercase tracking-wider">
                            <div class="flex items-center"><i class="bi bi-person-badge mr-2"></i>Nombre Completo</div>
                        </th>
                        <th class="px-6 py-4 text-left text-xs font-semibold text-gray-500 uppercase tracking-wider">
                            <div class="flex items-center"><i class="bi bi-at mr-2"></i>Contacto</div>
                        </th>
                        <th class="px-6 py-4 text-left text-xs font-semibold text-gray-500 uppercase tracking-wider">
                            <div class="flex items-center"><i class="bi bi-mortarboard mr-2"></i>Nivel Formativo</div>
                        </th>
                        <th class="px-6 py-4 text-left text-xs font-semibold text-gray-500 uppercase tracking-wider">
                            <div class="flex items-center"><i class="bi bi-calendar-check mr-2"></i>Fecha</div>
                        </th>
                        <th class="px-6 py-4 text-center text-xs font-semibold text-gray-500 uppercase tracking-wider">
                             <div class="flex items-center justify-center"><i class="bi bi-tag mr-2"></i>Estado</div>
                        </th>
                        <th class="px-6 py-4 text-center text-xs font-semibold text-gray-500 uppercase tracking-wider">
                             <div class="flex items-center justify-center"><i class="bi bi-gear mr-2"></i>Acciones</div>
                        </th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-100">
                    @forelse ($preinscritos as $preinscrito)
                        <!-- INICIO: LÍNEA MODIFICADA PARA FILAS RAYADAS -->
                        <tr class="{{ $loop->even ? 'bg-slate-50' : '' }} hover:bg-indigo-50/50 transition-colors duration-150 group">
                        <!-- FIN: LÍNEA MODIFICADA -->
                            
                            <!-- INICIO: CELDA DE NOMBRE CON AVATAR EXACTO AL EJEMPLO -->
                            <td class="px-6 py-5 whitespace-nowrap">
                                <div class="flex items-center">
                                    <div class="flex-shrink-0 h-12 w-12">
                                        <img class="h-12 w-12 rounded-full ring-2 ring-gray-200 group-hover:ring-indigo-300 transition-all duration-200" 
                                             src="https://ui-avatars.com/api/?name={{ urlencode($preinscrito->nombre . ' ' . $preinscrito->apellido1) }}&color=7F9CF5&background=EBF4FF&font-size=0.33" 
                                             alt="Avatar de {{ $preinscrito->nombre }}">
                                    </div>
                                    <div class="ml-4">
                                        <div class="text-sm font-semibold text-gray-900 group-hover:text-indigo-600 transition-colors duration-200">
                                            {{ $preinscrito->nombre }} {{ $preinscrito->apellido1 }} {{ $preinscrito->apellido2 ?? '' }}
                                        </div>
                                        <div class="text-xs text-gray-500 mt-1">
                                            {{ $preinscrito->dni }}
                                        </div>
                                    </div>
                                </div>
                            </td>
                            <!-- FIN: CELDA DE NOMBRE -->

                            <td class="px-6 py-5 whitespace-nowrap text-sm text-gray-600">
                                @if($preinscrito->email)
                                    <div><i class="bi bi-envelope-fill text-gray-400 mr-2"></i>{{ $preinscrito->email }}</div>
                                @endif
                                @if($preinscrito->telefono)
                                    <div class="mt-1"><i class="bi bi-telephone-fill text-gray-400 mr-2"></i>{{ $preinscrito->telefono }}</div>
                                @endif
                            </td>
                            <td class="px-6 py-5 whitespace-nowrap text-sm text-gray-500">{{ $preinscrito->nivel_formativo ?? 'N/A' }}</td>
                            <td class="px-6 py-5 whitespace-nowrap text-sm text-gray-500">
                                {{ $preinscrito->created_at ? $preinscrito->created_at->format('d/m/Y H:i') : 'N/A' }}
                            </td>
                            <td class="px-6 py-5 whitespace-nowrap text-center">
                                @php
                                    $estadoPre = $preinscrito->estado ?? 'Pendiente';
                                    $badgeColorPre = match ($estadoPre) {
                                        'Pendiente' => 'bg-yellow-100 text-yellow-800',
                                        'Contactado' => 'bg-blue-100 text-blue-800',
                                        'Convertido' => 'bg-green-100 text-green-800',
                                        'Rechazado' => 'bg-red-100 text-red-800',
                                        default => 'bg-gray-100 text-gray-800',
                                    };
                                @endphp
                                <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-semibold {{ $badgeColorPre }}">
                                    {{ $estadoPre }}
                                </span>
                            </td>

                            <!-- INICIO: CELDA DE ACCIONES CON ESTILO DEL EJEMPLO -->
                            <td class="px-6 py-5 whitespace-nowrap text-center">
                                <div class="flex items-center justify-center space-x-2">
                                    @if(($preinscrito->estado ?? 'Pendiente') !== 'Convertido')
                                        <button type="button" onclick="confirmConvert('{{ route('admin.preinscritos.convertir', $preinscrito->id) }}', '{{ addslashes($preinscrito->nombre) }}')" class="inline-flex items-center justify-center h-8 w-8 rounded-lg text-gray-400 hover:text-green-600 hover:bg-green-50 transition-all duration-200 group/btn" title="Convertir a Alumno">
                                            <i class="bi bi-person-plus-fill group-hover/btn:scale-110 transition-transform duration-200"></i>
                                        </button>
                                    @endif
                                    <a href="{{ route('admin.preinscritos.show', $preinscrito->id) }}" class="inline-flex items-center justify-center h-8 w-8 rounded-lg text-gray-400 hover:text-blue-600 hover:bg-blue-50 transition-all duration-200 group/btn" title="Ver Detalles">
                                        <i class="bi bi-eye-fill group-hover/btn:scale-110 transition-transform duration-200"></i>
                                    </a>
                                    <a href="{{ route('admin.preinscritos.edit', $preinscrito->id) }}" class="inline-flex items-center justify-center h-8 w-8 rounded-lg text-gray-400 hover:text-indigo-600 hover:bg-indigo-50 transition-all duration-200 group/btn" title="Editar">
                                        <i class="bi bi-pencil-fill group-hover/btn:scale-110 transition-transform duration-200"></i>
                                    </a>
                                    <button type="button" onclick="confirmDelete('{{ route('admin.preinscritos.destroy', $preinscrito->id) }}', '{{ addslashes($preinscrito->nombre) }}')" class="inline-flex items-center justify-center h-8 w-8 rounded-lg text-gray-400 hover:text-red-600 hover:bg-red-50 transition-all duration-200 group/btn" title="Eliminar preinscrito">
                                        <i class="bi bi-trash-fill group-hover/btn:scale-110 transition-transform duration-200"></i>
                                    </button>
                                </div>
                            </td>
                             <!-- FIN: CELDA DE ACCIONES -->
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="px-6 py-16 text-center text-sm text-gray-500">
                                <div class="flex flex-col items-center justify-center space-y-4">
                                    <i class="bi bi-person-x-fill text-6xl text-gray-300"></i>
                                    <p class="font-semibold text-lg">No se encontraron preinscritos</p>
                                    @if($searchTerm ?? '' || $filtroEstadoPre ?? '')
                                        <p>Prueba a cambiar tus términos de búsqueda o a limpiar los filtros.</p>
                                        <a href="{{ route('admin.preinscritos.index') }}" class="mt-2 inline-flex items-center px-4 py-2 border border-gray-300 text-sm font-medium rounded-md text-gray-700 bg-white hover:bg-gray-50">Limpiar filtros</a>
                                    @else
                                        <p>Puedes empezar añadiendo uno nuevo con el botón de la esquina superior derecha.</p>
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
    @if ($preinscritos->hasPages())
        <div class="mt-8">
            {{ $preinscritos->appends(request()->query())->links() }}
        </div>
    @endif

    <!-- Modales -->
    <x-convert-modal title="Convertir a Alumno"/>
    <x-delete-modal title="Eliminar preinscrito" />
@endsection

@push('scripts')
<script>
    // --- Búsqueda con Debounce ---
    let searchTimeout;
    const searchInput = document.getElementById('searchPreinscritos');
    const filterForm = document.getElementById('filterFormPreinscritos');
    
    if (searchInput && filterForm) {
        searchInput.addEventListener('keyup', (e) => {
            if (['ArrowUp', 'ArrowDown', 'ArrowLeft', 'ArrowRight', 'Tab', 'Enter'].includes(e.key)) {
                return;
            }
            clearTimeout(searchTimeout);
            searchTimeout = setTimeout(() => {
                filterForm.submit();
            }, 500); 
        });
        filterForm.addEventListener('keydown', (e) => {
             if (e.key === 'Enter' && e.target.id === 'searchPreinscritos') {
                e.preventDefault();
             }
        });
    }

    // --- Funciones para Modales ---
    function confirmConvert(url, itemName) {
        const form = document.getElementById('convertForm');
        if (form) form.action = url;
        
        const body = document.querySelector('#convertModal .modal-body-text');
        if (body) {
            body.innerHTML = `¿Estás seguro de que quieres convertir a <strong>${itemName}</strong> en un alumno? Esta acción no se puede deshacer.`;
        }
        
        const modal = document.getElementById('convertModal');
        if (modal) modal.classList.remove('hidden');
    }

    function closeConvertModal() {
        const modal = document.getElementById('convertModal');
        if (modal) modal.classList.add('hidden');
    }
</script>
@endpush