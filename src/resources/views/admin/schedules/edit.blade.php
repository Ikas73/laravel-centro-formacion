{{-- resources/views/admin/schedules/edit.blade.php --}}
@extends('layouts.admin')

@section('title', 'Editar Horario')

@section('content')
    <h1 class="text-2xl font-semibold mb-4">Editar Horario</h1>

    <div class="bg-white p-6 rounded-lg shadow">
        <form action="{{ route('admin.schedules.update', $schedule) }}" method="POST">
            @csrf
            @method('PUT')

            {{-- Bloque de Errores (si los hay) --}}
            @if ($errors->any())
                <div x-data="{ show: true }" x-show="show" class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative mb-4" role="alert">
                    <strong class="font-bold">¡Error de validación!</strong>
                    {{-- ... contenido del bloque de errores ... --}}
                </div>
            @endif

            {{-- Bloque de Información del Curso (No editable) --}}
            <div class="mb-6 p-4 bg-blue-50 border border-blue-200 rounded-lg">
                <h3 class="font-bold text-lg text-blue-800 mb-2">Resumen del Curso: {{ $schedule->curso->nombre }}</h3>
                <div class="grid grid-cols-1 md:grid-cols-3 gap-4 text-sm">
                    {{-- ... el contenido del bloque de resumen que ya tienes ... --}}
                </div>
                {{-- Es importante pasar el curso_id de forma oculta para que la validación siga funcionando --}}
                <input type="hidden" name="curso_id" value="{{ $schedule->curso_id }}">
            </div>

            {{-- CAMPO ELIMINADO: Ya no mostramos el selector de Curso --}}

            {{-- Selector de Profesor (Editable) --}}
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
                {{-- Campos de Día, Hora y Aula (Editables) --}}
                {{-- ... aquí va el resto de tu formulario (weekday, start_time, end_time, room) ... --}}
            </div>

            <div class="flex items-center justify-end mt-6">
                <a href="{{ route('admin.schedules.index') }}" class="text-gray-600 hover:text-gray-900 mr-4">Cancelar</a>
                <button type="submit" class="px-4 py-2 bg-blue-600 text-white rounded-hover:bg-blue-700">
                    Actualizar Horario
                </button>
            </div>
        </form>
    </div>
@endsection