{{-- resources/views/admin/schedules/edit.blade.php --}}
@extends('layouts.admin')

@section('title', 'Editar Horario')

@section('content')
    <h1 class="text-2xl font-semibold mb-4">Editar Horario</h1>

    <div class="bg-white p-6 rounded-lg shadow">
        <form action="{{ route('admin.schedules.update', $schedule) }}" method="POST">
            @csrf
            @method('PUT')

            {{-- Selector de Curso --}}
            <div class="mb-4">
                <label for="curso_id" class="block text-sm font-medium text-gray-700">Curso</label>
                <select name="curso_id" id="curso_id" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm">
                    @foreach($cursos as $id => $nombre)
                        <option value="{{ $id }}" @selected(old('curso_id', $schedule->curso_id) == $id)>{{ $nombre }}</option>
                    @endforeach
                </select>
                @error('curso_id') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
            </div>

            {{-- Selector de Profesor --}}
            <div class="mb-4">
                <label for="profesor_id" class="block text-sm font-medium text-gray-700">Profesor</label>
                <select name="profesor_id" id="profesor_id" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm">
                    @foreach($profesores as $id => $nombre)
                        <option value="{{ $id }}" @selected(old('profesor_id', $schedule->profesor_id) == $id)>{{ $nombre }}</option>
                    @endforeach
                </select>
                @error('profesor_id') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
            </div>

            <hr class="my-6">

            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-4">
                {{-- Día de la semana --}}
                <div>
                    <label for="weekday" class="block text-sm font-medium text-gray-700">Día de la semana</label>
                    <select name="weekday" id="weekday" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm">
                        @foreach(['Dom', 'Lun', 'Mar', 'Mié', 'Jue', 'Vie', 'Sáb'] as $index => $dia)
                            <option value="{{ $index }}" @selected(old('weekday', $schedule->timeSlot->weekday) == $index)>{{ $dia }}</option>
                        @endforeach
                    </select>
                    @error('weekday') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                </div>

                {{-- Hora de Inicio (CORREGIDO) --}}
                <div>
                    <label for="start_time" class="block text-sm font-medium text-gray-700">Hora de Inicio</label>
                    <input type="time" name="start_time" id="start_time" value="{{ old('start_time', \Carbon\Carbon::parse($schedule->timeSlot->start_time)->format('H:i')) }}" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm">
                    @error('start_time') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                </div>

                {{-- Hora de Fin (CORREGIDO) --}}
                <div>
                    <label for="end_time" class="block text-sm font-medium text-gray-700">Hora de Fin</label>
                    <input type="time" name="end_time" id="end_time" value="{{ old('end_time', \Carbon\Carbon::parse($schedule->timeSlot->end_time)->format('H:i')) }}" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm">
                    @error('end_time') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                </div>

                {{-- Aula --}}
                <div>
                    <label for="room" class="block text-sm font-medium text-gray-700">Aula</label>
                    <input type="text" name="room" id="room" value="{{ old('room', $schedule->timeSlot->room) }}" placeholder="Ej: Aula 101" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm">
                    @error('room') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                </div>
            </div>

            <div class="flex items-center justify-end mt-6">
                <a href="{{ route('admin.schedules.index') }}" class="text-gray-600 hover:text-gray-900 mr-4">Cancelar</a>
                <button type="submit" class="px-4 py-2 bg-blue-600 text-white rounded hover:bg-blue-700">
                    Actualizar Horario
                </button>
            </div>
        </form>
    </div>
@endsection