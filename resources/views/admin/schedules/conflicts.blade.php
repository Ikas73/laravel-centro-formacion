@extends('layouts.admin')

@section('title', 'Conflictos de Horarios')
@section('page-title', 'Análisis de Conflictos de Horarios')

@section('content')
<div class="bg-white p-6 md:p-8 rounded-xl shadow-lg border border-gray-200">
    {{-- Cabecera de la Sección --}}
    <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center mb-6 pb-4 border-b border-gray-200">
        <div>
            <h2 class="text-2xl font-bold text-gray-800">Conflictos Detectados</h2>
            <p class="text-sm text-gray-600 mt-1">
                Se han encontrado <strong class="font-semibold text-indigo-600">{{ count($conflicts) }}</strong> conflictos de horarios.
            </p>
        </div>
        <a href="{{ route('admin.schedule.index') }}" class="mt-4 sm:mt-0 inline-flex items-center px-4 py-2 bg-indigo-600 text-white text-sm font-medium rounded-lg hover:bg-indigo-700 transition-colors">
            <i class="bi bi-calendar3-week-fill mr-2"></i>
            Ir al Calendario Principal
        </a>
    </div>

    {{-- Contenido Principal --}}
    @if(count($conflicts) > 0)
        {{-- Caso 1: Hay conflictos --}}
        <div class="overflow-x-auto">
            <table class="min-w-full bg-white">
                <thead class="bg-gray-50">
                    <tr>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Tipo de Conflicto</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Horario en Conflicto 1</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Horario en Conflicto 2</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Acciones</th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                    @foreach($conflicts as $conflict)
                        <tr class="hover:bg-gray-50">
                            <td class="px-6 py-4 whitespace-nowrap">
                                <span class="px-3 py-1 inline-flex text-xs leading-5 font-semibold rounded-full bg-red-100 text-red-800">
                                    <i class="bi bi-exclamation-octagon-fill mr-1.5"></i>
                                    {{ $conflict['type'] }}
                                </span>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="text-sm font-semibold text-gray-900">{{ $conflict['schedule1']->curso->nombre }}</div>
                                <div class="text-sm text-gray-500">{{ $conflict['schedule1']->profesor->nombre_completo ?? 'N/A' }}</div>
                                <div class="text-sm text-gray-500">{{ $conflict['schedule1']->aula }} ({{ $conflict['schedule1']->dia_semana_string }}: {{ $conflict['schedule1']->hora_inicio_formatted }} - {{ $conflict['schedule1']->hora_fin_formatted }})</div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="text-sm font-semibold text-gray-900">{{ $conflict['schedule2']->curso->nombre }}</div>
                                <div class="text-sm text-gray-500">{{ $conflict['schedule2']->profesor->nombre_completo ?? 'N/A' }}</div>
                                <div class="text-sm text-gray-500">{{ $conflict['schedule2']->aula }} ({{ $conflict['schedule2']->dia_semana_string }}: {{ $conflict['schedule2']->hora_inicio_formatted }} - {{ $conflict['schedule2']->hora_fin_formatted }})</div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                                <a href="{{ route('admin.schedule.index') }}" class="text-indigo-600 hover:text-indigo-900 hover:underline">Resolver en Calendario</a>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    @else
        {{-- Caso 2: No hay conflictos (Tu caso actual) --}}
        <div class="text-center py-16">
            <div class="mx-auto flex items-center justify-center h-24 w-24 rounded-full bg-gradient-to-br from-green-500 to-emerald-600 shadow-lg mb-6">
                <i class="bi bi-check-lg text-white text-5xl font-bold"></i>
            </div>
            <h3 class="mt-4 text-2xl font-bold text-gray-800">¡Excelente!</h3>
            <p class="mt-2 text-md text-gray-600 max-w-md mx-auto">
                No se han encontrado conflictos de horarios en el sistema. El calendario está correctamente sincronizado.
            </p>
        </div>
    @endif
</div>
@endsection