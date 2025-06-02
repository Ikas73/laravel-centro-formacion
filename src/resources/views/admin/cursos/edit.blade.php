@extends('layouts.admin')

@section('title', 'Editar Curso: ' . $curso->nombre) {{-- CAMBIO: Título dinámico --}}
@section('page-title', 'Editar Curso') {{-- CAMBIO: Título en header --}}

@section('content')
<div class="max-w-4xl mx-auto py-8 px-4 sm:px-6 lg:px-8">
    {{-- ... (Bloque de errores @if ($errors->any()) igual que en create) ... --}}
    @if ($errors->any())
        <div class="mb-6 p-4 bg-red-100 border border-red-400 text-red-700 rounded-lg shadow-sm">
            <strong class="font-bold">¡Atención! Por favor, corrige los errores:</strong>
            <ul class="mt-2 list-disc list-inside text-sm">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    {{-- CAMBIO: Acción del formulario y método PUT --}}
    <form method="POST" action="{{ route('admin.cursos.update', $curso->id) }}" class="space-y-8">
        @csrf
        @method('PUT') {{-- <--- Directiva para simular PUT --}}

        {{-- Sección Información Principal del Curso --}}
        <div class="bg-white rounded-xl shadow-sm border border-gray-200 overflow-hidden">
            <div class="bg-gradient-to-r from-blue-50 to-indigo-50 px-6 py-4 border-b border-gray-200">
                <h2 class="text-lg font-semibold text-gray-900">Información Principal del Curso</h2>
            </div>
            <div class="p-6 space-y-6">
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div class="space-y-1">
                        <label for="nombre" class="block text-sm font-medium text-gray-700">Nombre del Curso <span class="text-red-500">*</span></label>
                        {{-- CAMBIO: Usar old() con el valor actual del curso --}}
                        <input type="text" name="nombre" id="nombre" value="{{ old('nombre', $curso->nombre) }}" required
                               class="w-full px-4 py-2.5 border {{ $errors->has('nombre') ? 'border-red-500 focus:ring-red-500 focus:border-red-500' : 'border-gray-300 focus:ring-indigo-500 focus:border-indigo-500' }} rounded-lg shadow-sm transition-colors">
                        @error('nombre') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                    </div>
                    <div class="space-y-1">
                        <label for="codigo" class="block text-sm font-medium text-gray-700">Código del Curso</label>
                        <input type="text" name="codigo" id="codigo" value="{{ old('codigo', $curso->codigo) }}"
                               class="w-full px-4 py-2.5 border {{ $errors->has('codigo') ? 'border-red-500 focus:ring-red-500 focus:border-red-500' : 'border-gray-300 focus:ring-indigo-500 focus:border-indigo-500' }} rounded-lg shadow-sm transition-colors">
                        @error('codigo') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                    </div>
                </div>
                <div class="space-y-1">
                    <label for="descripcion" class="block text-sm font-medium text-gray-700">Descripción</label>
                    <textarea name="descripcion" id="descripcion" rows="4"
                              class="w-full px-4 py-2.5 border {{ $errors->has('descripcion') ? 'border-red-500 focus:ring-red-500 focus:border-red-500' : 'border-gray-300 focus:ring-indigo-500 focus:border-indigo-500' }} rounded-lg shadow-sm transition-colors resize-none">{{ old('descripcion', $curso->descripcion) }}</textarea>
                    @error('descripcion') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                </div>
            </div>
        </div>

        {{-- Sección Detalles del Curso --}}
        <div class="bg-white rounded-xl shadow-sm border border-gray-200 overflow-hidden">
            <div class="bg-gradient-to-r from-green-50 to-emerald-50 px-6 py-4 border-b border-gray-200">
                 <h2 class="text-lg font-semibold text-gray-900">Detalles del Curso</h2>
            </div>
            <div class="p-6 space-y-6">
                {{-- Repetir para todos los campos del curso: modalidad, nivel, profesor_id, fechas, horas, etc. --}}
                {{-- usando value="{{ old('nombre_campo', $curso->nombre_campo) }}" para inputs --}}
                {{-- y {{ old('nombre_campo', $curso->nombre_campo) == 'valor_opcion' ? 'selected' : '' }} para selects --}}

                <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                    <div class="space-y-1">
                        <label for="modalidad" class="block text-sm font-medium text-gray-700">Modalidad <span class="text-red-500">*</span></label>
                        <select name="modalidad" id="modalidad" required class="w-full px-4 py-2.5 border {{ $errors->has('modalidad') ? 'border-red-500 focus:ring-red-500 focus:border-red-500' : 'border-gray-300 focus:ring-indigo-500 focus:border-indigo-500' }} rounded-lg shadow-sm transition-colors">
                            <option value="" disabled>Seleccionar modalidad...</option>
                            <option value="Online" {{ old('modalidad', $curso->modalidad) == 'Online' ? 'selected' : '' }}>Online</option>
                            <option value="Presencial" {{ old('modalidad', $curso->modalidad) == 'Presencial' ? 'selected' : '' }}>Presencial</option>
                            <option value="Semipresencial (Blended)" {{ old('modalidad', $curso->modalidad) == 'Semipresencial (Blended)' ? 'selected' : '' }}>Semipresencial (Blended)</option>
                        </select>
                        @error('modalidad') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                    </div>
                    <div class="space-y-1">
                        <label for="nivel" class="block text-sm font-medium text-gray-700">Nivel</label>
                        <input type="text" name="nivel" id="nivel" value="{{ old('nivel', $curso->nivel) }}"
                               class="w-full px-4 py-2.5 border {{ $errors->has('nivel') ? 'border-red-500 focus:ring-red-500 focus:border-red-500' : 'border-gray-300 focus:ring-indigo-500 focus:border-indigo-500' }} rounded-lg shadow-sm transition-colors">
                        @error('nivel') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                    </div>
                    <div class="space-y-1">
                        <label for="profesor_id" class="block text-sm font-medium text-gray-700">Profesor Asignado <span class="text-red-500">*</span></label>
                        <select name="profesor_id" id="profesor_id" required
                                class="w-full px-4 py-2.5 border {{ $errors->has('profesor_id') ? 'border-red-500 focus:ring-red-500 focus:border-red-500' : 'border-gray-300 focus:ring-indigo-500 focus:border-indigo-500' }} rounded-lg shadow-sm transition-colors">
                            <option value="" disabled>Seleccionar profesor...</option>
                            @foreach($profesores as $profesor)
                                <option value="{{ $profesor->id }}" {{ old('profesor_id', $curso->profesor_id) == $profesor->id ? 'selected' : '' }}>
                                    {{ $profesor->nombre }} {{ $profesor->apellido1 }}
                                </option>
                            @endforeach
                        </select>
                        @error('profesor_id') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                    </div>
                </div>
                 {{-- ... (Asegúrate de replicar ESTE PATRÓN para fecha_inicio, fecha_fin, horas_totales, horario, plazas_maximas, requisitos, centros) ... --}}
            </div>
        </div>

        {{-- Botones de Acción --}}
        <div class="flex flex-col sm:flex-row justify-end gap-3 pt-4">
            <a href="{{ route('admin.cursos.show', $curso->id) }}" {{-- CAMBIO: Enlaza a la vista show del curso actual --}}
               class="px-6 py-2.5 text-sm font-medium text-gray-700 bg-white border border-gray-300 rounded-lg shadow-sm hover:bg-gray-50 text-center">
                Cancelar
            </a>
            <button type="submit"
                    class="px-6 py-2.5 text-sm font-medium text-white bg-indigo-600 border border-transparent rounded-lg shadow-sm hover:bg-indigo-700">
                Actualizar Curso {{-- CAMBIO: Texto del botón --}}
            </button>
        </div>
    </form>
</div>
Use code with caution.
Blade
</div>
@endsection
@push('scripts')
{{-- Scripts si son necesarios --}}
@endpush