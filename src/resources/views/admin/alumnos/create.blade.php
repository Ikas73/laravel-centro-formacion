@extends('layouts.admin')

@section('title', 'Añadir Nuevo Alumno')
@section('page-title', 'Añadir Nuevo Alumno')

@section('content')
<div class="bg-white p-6 rounded-lg shadow-lg">
    <form method="POST" action="{{ route('admin.alumnos.store') }}">
        @csrf {{-- Directiva de seguridad CSRF --}}

        {{-- Fila para Nombre y Apellidos --}}
        <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-6">
            <div>
                <label for="nombre" class="block text-sm font-medium text-gray-700 mb-1">Nombre<span class="text-red-500">*</span></label>
                <input type="text" name="nombre" id="nombre" value="{{ old('nombre') }}" required
                       class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm">
                {{-- @error('nombre') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror --}}
            </div>
            <div>
                <label for="apellido1" class="block text-sm font-medium text-gray-700 mb-1">Primer Apellido<span class="text-red-500">*</span></label>
                <input type="text" name="apellido1" id="apellido1" value="{{ old('apellido1') }}" required
                       class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm">
            </div>
            <div>
                <label for="apellido2" class="block text-sm font-medium text-gray-700 mb-1">Segundo Apellido</label>
                <input type="text" name="apellido2" id="apellido2" value="{{ old('apellido2') }}"
                       class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm">
            </div>
        </div>

        {{-- Fila para DNI y Email --}}
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
            <div>
                <label for="dni" class="block text-sm font-medium text-gray-700 mb-1">DNI/NIE<span class="text-red-500">*</span></label>
                <input type="text" name="dni" id="dni" value="{{ old('dni') }}" required
                       class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm">
            </div>
            <div>
                <label for="email" class="block text-sm font-medium text-gray-700 mb-1">Email<span class="text-red-500">*</span></label>
                <input type="email" name="email" id="email" value="{{ old('email') }}" required
                       class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm">
            </div>
        </div>

        {{-- Fila para Fecha Nacimiento y Nivel Formativo --}}
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
            <div>
                <label for="fecha_nacimiento" class="block text-sm font-medium text-gray-700 mb-1">Fecha de Nacimiento<span class="text-red-500">*</span></label>
                <input type="date" name="fecha_nacimiento" id="fecha_nacimiento" value="{{ old('fecha_nacimiento') }}" required
                       class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm">
            </div>
            <div>
                <label for="nivel_formativo" class="block text-sm font-medium text-gray-700 mb-1">Nivel Formativo<span class="text-red-500">*</span></label>
                {{-- Ejemplo de <select>, puedes obtener $opcionesNivel del controlador si son muchas --}}
                <select name="nivel_formativo" id="nivel_formativo" required
                        class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm">
                    <option value="" disabled {{ old('nivel_formativo') ? '' : 'selected' }}>Selecciona un nivel...</option>
                    <option value="Sin estudios" {{ old('nivel_formativo') == 'Sin estudios' ? 'selected' : '' }}>Sin estudios</option>
                    <option value="ESO" {{ old('nivel_formativo') == 'ESO' ? 'selected' : '' }}>ESO</option>
                    <option value="Bachillerato" {{ old('nivel_formativo') == 'Bachillerato' ? 'selected' : '' }}>Bachillerato</option>
                    <option value="Grado Medio" {{ old('nivel_formativo') == 'Grado Medio' ? 'selected' : '' }}>Grado Medio</option>
                    <option value="Grado Superior" {{ old('nivel_formativo') == 'Grado Superior' ? 'selected' : '' }}>Grado Superior</option>
                    <option value="Grado Universitario" {{ old('nivel_formativo') == 'Grado Universitario' ? 'selected' : '' }}>Grado Universitario</option>
                    <option value="Máster" {{ old('nivel_formativo') == 'Máster' ? 'selected' : '' }}>Máster</option>
                    <option value="Doctorado" {{ old('nivel_formativo') == 'Doctorado' ? 'selected' : '' }}>Doctorado</option>
                </select>
            </div>
        </div>

        {{-- Fila para Estado (IMPORTANTE: si no tienes la columna 'estado' en la BD, omite este campo o coméntalo) --}}
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
            <div>
                <label for="estado" class="block text-sm font-medium text-gray-700 mb-1">Estado<span class="text-red-500">*</span></label>
                <select name="estado" id="estado" required
                        class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm">
                    {{-- Si pasaste $opcionesEstado desde el controlador:
                    @foreach($opcionesEstado as $opcion)
                        <option value="{{ $opcion }}" {{ old('estado') == $opcion ? 'selected' : '' }}>{{ $opcion }}</option>
                    @endforeach
                    --}}
                    {{-- Opciones fijas si no pasas $opcionesEstado: --}}
                    <option value="Activo" {{ old('estado') == 'Activo' ? 'selected' : '' }}>Activo</option>
                    <option value="Inactivo" {{ old('estado') == 'Inactivo' ? 'selected' : '' }}>Inactivo</option>
                    <option value="Pendiente" {{ old('estado') == 'Pendiente' ? 'selected' : '' }}>Pendiente</option>
                    <option value="Baja" {{ old('estado') == 'Baja' ? 'selected' : '' }}>Baja</option>
                </select>
            </div>
            {{-- Puedes añadir más campos aquí si son necesarios --}}
        </div>

        {{-- Botones de Acción --}}
        <div class="mt-8 flex justify-end gap-3">
            <a href="{{ route('admin.alumnos.index') }}"
               class="px-4 py-2 text-sm font-medium text-gray-700 bg-white border border-gray-300 rounded-md shadow-sm hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                Cancelar
            </a>
            <button type="submit"
                    class="px-4 py-2 text-sm font-medium text-white bg-indigo-600 border border-transparent rounded-md shadow-sm hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                Guardar Alumno
            </button>
        </div>
    </form>
</div>
@endsection

@push('scripts')
{{-- Aquí podrías añadir JS específico para esta página si fuera necesario (ej: validación en cliente) --}}
@endpush