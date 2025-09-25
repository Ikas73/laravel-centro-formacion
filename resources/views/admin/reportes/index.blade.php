@extends('layouts.admin')

@section('title', 'Reportes')
@section('page-title', 'Panel de Reportes')

@section('content')
<div class="bg-white p-6 md:p-8 rounded-xl shadow-lg border border-gray-200">

    {{-- Encabezado --}}
    <div class="flex flex-col lg:flex-row lg:items-center lg:justify-between gap-6 border-b border-gray-200 pb-6 mb-8">
        <div>
            <h2 class="text-2xl font-bold text-gray-800">Inteligencia del Centro de Formación</h2>
            <p class="mt-2 text-sm text-gray-600 max-w-xl">
                Monitorea indicadores clave y accede a los informes generados por el equipo académico y administrativo.
            </p>
        </div>

        {{-- Filtros rápidos --}}
        <div class="flex flex-wrap gap-3">
            <form method="GET" action="{{ route('admin.reportes.index') }}" class="flex gap-3">
                <select name="period" class="rounded-lg border-gray-300 text-sm focus:border-indigo-500 focus:ring focus:ring-indigo-200 focus:ring-opacity-50">
                    <option value="this_month" @selected(request('period') === 'this_month')>Este mes</option>
                    <option value="last_month" @selected(request('period') === 'last_month')>Mes anterior</option>
                    <option value="quarter" @selected(request('period') === 'quarter')>Último trimestre</option>
                    <option value="year" @selected(request('period') === 'year')>Año en curso</option>
                </select>

                <select name="area" class="rounded-lg border-gray-300 text-sm focus:border-indigo-500 focus:ring focus:ring-indigo-200 focus:ring-opacity-50">
                    <option value="">Todas las áreas</option>
                    <option value="academica" @selected(request('area') === 'academica')>Académica</option>
                    <option value="administrativa" @selected(request('area') === 'administrativa')>Administrativa</option>
                    <option value="logistica" @selected(request('area') === 'logistica')>Logística</option>
                </select>

                <button type="submit" class="inline-flex items-center px-4 py-2 bg-indigo-600 text-white text-sm font-medium rounded-lg hover:bg-indigo-700 transition-colors">
                    <i class="bi bi-funnel-fill mr-2"></i> Filtrar
                </button>
            </form>

            <a href="{{ route('admin.reportes.create') }}" class="inline-flex items-center px-4 py-2 bg-emerald-500 text-white text-sm font-medium rounded-lg hover:bg-emerald-600 transition-colors">
                <i class="bi bi-file-earmark-plus mr-2"></i> Nuevo reporte
            </a>
        </div>
    </div>

    {{-- Métricas resumidas --}}
    <section class="grid grid-cols-1 sm:grid-cols-2 xl:grid-cols-4 gap-5 mb-10">
        <div class="p-5 rounded-xl border border-gray-200 bg-gradient-to-br from-indigo-50 to-white">
            <div class="flex items-center justify-between">
                <p class="text-sm font-semibold text-indigo-600 uppercase tracking-wide">Reportes generados</p>
                <span class="text-indigo-500">
                    <i class="bi bi-bar-chart-line-fill text-xl"></i>
                </span>
            </div>
            <p class="mt-4 text-3xl font-bold text-gray-800">{{ number_format($metrics['reports_total'] ?? 0) }}</p>
            <p class="mt-2 text-xs text-gray-500">
                {{ $metrics['reports_growth_label'] ?? 'Sin variación registrada' }}
            </p>
        </div>

        <div class="p-5 rounded-xl border border-gray-200 bg-gradient-to-br from-amber-50 to-white">
            <div class="flex items-center justify-between">
                <p class="text-sm font-semibold text-amber-600 uppercase tracking-wide">Cursos analizados</p>
                <span class="text-amber-500">
                    <i class="bi bi-mortarboard-fill text-xl"></i>
                </span>
            </div>
            <p class="mt-4 text-3xl font-bold text-gray-800">{{ number_format($metrics['courses_covered'] ?? 0) }}</p>
            <p class="mt-2 text-xs text-gray-500">
                {{ $metrics['courses_coverage_label'] ?? 'Cobertura total del catálogo' }}
            </p>
        </div>

        <div class="p-5 rounded-xl border border-gray-200 bg-gradient-to-br from-emerald-50 to-white">
            <div class="flex items-center justify-between">
                <p class="text-sm font-semibold text-emerald-600 uppercase tracking-wide">Alertas resueltas</p>
                <span class="text-emerald-500">
                    <i class="bi bi-check2-circle text-xl"></i>
                </span>
            </div>
            <p class="mt-4 text-3xl font-bold text-gray-800">{{ number_format($metrics['alerts_resolved'] ?? 0) }}</p>
            <p class="mt-2 text-xs text-gray-500">
                {{ $metrics['alerts_label'] ?? 'Actualizado en tiempo real' }}
            </p>
        </div>

        <div class="p-5 rounded-xl border border-gray-200 bg-gradient-to-br from-rose-50 to-white">
            <div class="flex items-center justify-between">
                <p class="text-sm font-semibold text-rose-600 uppercase tracking-wide">Demandas detectadas</p>
                <span class="text-rose-500">
                    <i class="bi bi-graph-up-arrow text-xl"></i>
                </span>
            </div>
            <p class="mt-4 text-3xl font-bold text-gray-800">{{ number_format($metrics['high_demand_courses'] ?? 0) }}</p>
            <p class="mt-2 text-xs text-gray-500">
                {{ $metrics['high_demand_label'] ?? 'Cursos con cupo al límite' }}
            </p>
        </div>
    </section>

    {{-- Reportes recientes --}}
    <section>
        <div class="flex items-center justify-between mb-4">
            <h3 class="text-xl font-semibold text-gray-800">Reportes generados recientemente</h3>
            <a href="{{ route('admin.reportes.archive') }}" class="text-sm font-medium text-indigo-600 hover:text-indigo-800 hover:underline">
                Ver historial completo
            </a>
        </div>

        @if(!empty($recentReports) && count($recentReports) > 0)
            <div class="overflow-x-auto border border-gray-200 rounded-xl">
                <table class="min-w-full divide-y divide-gray-200">
                    <thead class="bg-gray-50">
                        <tr>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Nombre del reporte</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Área</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Período</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Generado por</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Acciones</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200">
                        @foreach($recentReports as $report)
                            <tr class="hover:bg-gray-50">
                                <td class="px-6 py-4">
                                    <p class="text-sm font-semibold text-gray-900">{{ $report->title }}</p>
                                    <p class="text-xs text-gray-500">{{ $report->description ?? 'Sin descripción' }}</p>
                                </td>
                                <td class="px-6 py-4">
                                    <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-semibold 
                                        @class([
                                            'bg-indigo-100 text-indigo-700' => $report->area === 'academica',
                                            'bg-amber-100 text-amber-700' => $report->area === 'administrativa',
                                            'bg-emerald-100 text-emerald-700' => $report->area === 'logistica',
                                            'bg-gray-100 text-gray-700' => !in_array($report->area, ['academica', 'administrativa', 'logistica'])
                                        ])">
                                        <i class="bi bi-diagram-3 mr-1.5"></i>{{ ucfirst($report->area ?? 'general') }}
                                    </span>
                                </td>
                                <td class="px-6 py-4 text-sm text-gray-600">
                                    {{ $report->period_label ?? 'Período no especificado' }}
                                </td>
                                <td class="px-6 py-4">
                                    <div class="text-sm font-semibold text-gray-900">{{ $report->author->name ?? 'Equipo del sistema' }}</div>
                                    <div class="text-xs text-gray-500">
                                        {{ $report->created_at?->format('d M Y, H:i') }}
                                    </div>
                                </td>
                                <td class="px-6 py-4 text-sm font-medium">
                                    <a href="{{ route('admin.reportes.show', $report) }}" class="text-indigo-600 hover:text-indigo-900 hover:underline mr-4">
                                        <i class="bi bi-eye-fill mr-1"></i> Ver
                                    </a>
                                    @if($report->download_url ?? false)
                                        <a href="{{ $report->download_url }}" class="text-emerald-600 hover:text-emerald-800 hover:underline">
                                            <i class="bi bi-download mr-1"></i> Descargar
                                        </a>
                                    @endif
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        @else
            {{-- Estado vacío --}}
            <div class="text-center py-16">
                <div class="mx-auto flex items-center justify-center h-24 w-24 rounded-full bg-gradient-to-br from-indigo-500 to-purple-600 shadow-lg mb-6">
                    <i class="bi bi-bar-chart text-white text-5xl"></i>
                </div>
                <h4 class="text-2xl font-bold text-gray-800">Aún no has generado reportes</h4>
                <p class="mt-2 text-sm text-gray-600 max-w-md mx-auto">
                    Crea tu primer reporte para visualizar métricas, detectar tendencias y compartir resultados con el equipo.
                </p>
                <a href="{{ route('admin.reportes.create') }}" class="mt-6 inline-flex items-center px-5 py-3 bg-indigo-600 text-white text-sm font-medium rounded-lg hover:bg-indigo-700 transition-colors">
                    <i class="bi bi-file-earmark-richtext mr-2"></i> Crear reporte ahora
                </a>
            </div>
        @endif
    </section>

</div>
@endsection