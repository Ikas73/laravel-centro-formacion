{{-- resources/views/admin/schedules/index.blade.php --}}
@extends('layouts.admin')

@section('title', 'Horarios')

@section('content')
    <div class="flex items-center justify-between mb-6">
        <h1 class="text-2xl font-semibold">Horarios</h1>
        <a href="{{ route('admin.schedules.create') }}"
           class="inline-flex items-center px-4 py-2 bg-blue-600 text-white rounded hover:bg-blue-700">
            Nuevo horario
        </a>
    </div>

    @if(session('success'))
        <div class="mb-4 p-4 bg-green-200 text-green-800 rounded">
            {{ session('success') }}
        </div>
    @endif

    <div class="overflow-x-auto bg-white shadow rounded">
        <table class="min-w-full table-auto text-sm">
            <thead class="bg-gray-100">
                <tr>
                    <th class="px-4 py-2 text-left">Curso</th>
                    <th class="px-4 py-2 text-left">Profesor</th>
                    <th class="px-4 py-2 text-left">Día</th>
                    <th class="px-4 py-2 text-left">Hora</th>
                    <th class="px-4 py-2 text-left">Aula</th>
                    <th class="px-4 py-2 text-right">Acciones</th>
                </tr>
            </thead>
            <tbody>
                @forelse($schedules as $schedule)
                    <tr class="border-b">
                        {{-- Columna 1: Curso --}}
                        <td class="px-4 py-2">{{ $schedule->curso->nombre }}</td>

                        {{-- Columna 2: Profesor (CORREGIDO) --}}
                        <td class="px-4 py-2">{{ $schedule->profesor->nombre }}</td>

                        {{-- Columna 3: Día (CORREGIDO) --}}
                        <td class="px-4 py-2">
                            {{ ['Dom', 'Lun', 'Mar', 'Mié', 'Jue', 'Vie', 'Sáb'][$schedule->timeSlot->weekday] ?? 'N/A' }}
                        </td>

                        {{-- Columna 4: Hora (CORREGIDO) --}}
                        <td class="px-4 py-2">
                            {{ \Carbon\Carbon::parse($schedule->timeSlot->start_time)->format('H:i') }}-{{ \Carbon\Carbon::parse($schedule->timeSlot->end_time)->format('H:i') }}
                        </td>

                        {{-- Columna 5: Aula (CORREGIDO) --}}
                        <td class="px-4 py-2">{{ $schedule->timeSlot->room }}</td>

                        {{-- Columna 6: Acciones (CORREGIDO) --}}
                        <td class="px-4 py-2 text-right space-x-2">
                            <a href="{{ route('admin.schedules.edit', $schedule) }}"
                               class="text-blue-600 hover:underline">Editar</a>
                            <form action="{{ route('admin.schedules.destroy', $schedule) }}"
                                  method="POST" class="inline">
                                @csrf @method('DELETE')
                                <button type="submit"
                                        onclick="return confirm('¿Eliminar este horario?')"
                                        class="text-red-600 hover:underline">
                                    Eliminar
                                </button>
                            </form>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="6" class="px-4 py-8 text-center text-gray-500">
                            No se encontraron horarios.
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <div class="mt-4">
        {{ $schedules->links() }}
    </div>
@endsection