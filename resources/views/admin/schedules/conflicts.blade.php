@extends('layouts.admin')

@section('title', 'Gestión de Conflictos de Horarios')
@section('page-title', 'Panel de Conflictos de Horarios')

@section('content')
<div class="bg-white rounded-3xl shadow-2xl shadow-gray-200/50 border border-gray-200/100 p-6">
    <div class="mb-4">
        <h2 class="text-xl font-bold text-gray-800">Conflictos Detectados</h2>
        <p class="text-gray-600">Se han encontrado {{ count($conflicts) }} conflictos de horarios. Por favor, revíselos y corríjalos para asegurar la integridad del calendario.</p>
    </div>

    @if(count($conflicts) > 0)
        <div class="overflow-x-auto">
            <table class="min-w-full bg-white">
                <thead class="bg-gray-50">
                    <tr>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Tipo de Conflicto</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Horario 1</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Horario 2</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Acciones</th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                    @foreach($conflicts as $conflict)
                        <tr>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-red-100 text-red-800">
                                    {{ $conflict['type'] }}
                                </span>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="text-sm text-gray-900">{{ $conflict['schedule1']->curso->nombre }}</div>
                                <div class="text-sm text-gray-500">{{ $conflict['schedule1']->profesor->nombre_completo ?? 'N/A' }}</div>
                                <div class="text-sm text-gray-500">{{ $conflict['schedule1']->aula }}</div>
                                <div class="text-sm text-gray-500">{{ $conflict['schedule1']->dia_semana_string }}: {{ $conflict['schedule1']->hora_inicio_formatted }} - {{ $conflict['schedule1']->hora_fin_formatted }}</div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="text-sm text-gray-900">{{ $conflict['schedule2']->curso->nombre }}</div>
                                <div class="text-sm text-gray-500">{{ $conflict['schedule2']->profesor->nombre_completo ?? 'N/A' }}</div>
                                <div class="text-sm text-gray-500">{{ $conflict['schedule2']->aula }}</div>
                                <div class="text-sm text-gray-500">{{ $conflict['schedule2']->dia_semana_string }}: {{ $conflict['schedule2']->hora_inicio_formatted }} - {{ $conflict['schedule2']->hora_fin_formatted }}</div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                                <a href="{{ route('admin.schedules.index') }}#{{ $conflict['schedule1']->id }}" class="text-indigo-600 hover:text-indigo-900">Editar</a>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    @else
        <div class="text-center py-10">
            <i class="bi bi-check-circle-fill text-6xl text-green-500"></i>
            <h3 class="mt-4 text-lg font-medium text-gray-900">¡Excelente!</h3>
            <p class="mt-1 text-sm text-gray-600">No se han encontrado conflictos de horarios en el sistema.</p>
        </div>
    @endif
</div>
@endsection
