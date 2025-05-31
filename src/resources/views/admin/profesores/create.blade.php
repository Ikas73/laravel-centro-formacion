@extends('layouts.admin')

@section('title', 'Añadir Nuevo Profesor')
@section('page-title', 'Añadir Nuevo Profesor')

@section('content')
<div class="max-w-4xl mx-auto py-8 px-4 sm:px-6 lg:px-8">
    {{-- Mostrar Errores de Validación Generales (Opcional) --}}
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

    <form method="POST" action="{{ route('admin.profesores.store') }}" class="space-y-8">
        @csrf

        {{-- Información Personal --}}
<div class="bg-white rounded-xl shadow-sm border border-gray-200 overflow-hidden">
    <div class="bg-gradient-to-r from-blue-50 to-indigo-50 px-6 py-4 border-b border-gray-200">
        <div class="flex items-center space-x-3">
            <div class="p-2 bg-blue-100 rounded-lg">
                <svg class="w-5 h-5 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path></svg>
            </div>
            <h2 class="text-lg font-semibold text-gray-900">Información Personal</h2>
        </div>
    </div>
    
    <div class="p-6 space-y-6">
        {{-- Nombre y Apellidos --}}
        <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
            <div class="space-y-1">
                <label for="nombre" class="block text-sm font-medium text-gray-700">Nombre <span class="text-red-500">*</span></label>
                <input type="text" name="nombre" id="nombre" value="{{ old('nombre') }}" required
                       class="w-full px-4 py-2.5 border {{ $errors->has('nombre') ? 'border-red-500 focus:ring-red-500 focus:border-red-500' : 'border-gray-300 focus:ring-indigo-500 focus:border-indigo-500' }} rounded-lg shadow-sm transition-colors">
                @error('nombre') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
            </div>
            <div class="space-y-1">
                <label for="apellido1" class="block text-sm font-medium text-gray-700">Primer Apellido <span class="text-red-500">*</span></label>
                <input type="text" name="apellido1" id="apellido1" value="{{ old('apellido1') }}" required
                       class="w-full px-4 py-2.5 border {{ $errors->has('apellido1') ? 'border-red-500 focus:ring-red-500 focus:border-red-500' : 'border-gray-300 focus:ring-indigo-500 focus:border-indigo-500' }} rounded-lg shadow-sm transition-colors">
                @error('apellido1') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
            </div>
            <div class="space-y-1">
                <label for="apellido2" class="block text-sm font-medium text-gray-700">Segundo Apellido</label>
                <input type="text" name="apellido2" id="apellido2" value="{{ old('apellido2') }}"
                       class="w-full px-4 py-2.5 border {{ $errors->has('apellido2') ? 'border-red-500 focus:ring-red-500 focus:border-red-500' : 'border-gray-300 focus:ring-indigo-500 focus:border-indigo-500' }} rounded-lg shadow-sm transition-colors">
                @error('apellido2') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
            </div>
        </div>

        {{-- DNI, Email, Fecha Nacimiento --}}
        <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
            <div class="space-y-1">
                <label for="dni" class="block text-sm font-medium text-gray-700">DNI/NIE <span class="text-red-500">*</span></label>
                <input type="text" name="dni" id="dni" value="{{ old('dni') }}" required
                       class="w-full px-4 py-2.5 border {{ $errors->has('dni') ? 'border-red-500 focus:ring-red-500 focus:border-red-500' : 'border-gray-300 focus:ring-indigo-500 focus:border-indigo-500' }} rounded-lg shadow-sm transition-colors">
                @error('dni') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
            </div>
            <div class="space-y-1">
                <label for="email" class="block text-sm font-medium text-gray-700">Email <span class="text-red-500">*</span></label>
                <input type="email" name="email" id="email" value="{{ old('email') }}" required
                       class="w-full px-4 py-2.5 border {{ $errors->has('email') ? 'border-red-500 focus:ring-red-500 focus:border-red-500' : 'border-gray-300 focus:ring-indigo-500 focus:border-indigo-500' }} rounded-lg shadow-sm transition-colors">
                @error('email') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
            </div>
            <div class="space-y-1">
                <label for="fecha_nacimiento" class="block text-sm font-medium text-gray-700">Fecha de Nacimiento</label>
                <input type="date" name="fecha_nacimiento" id="fecha_nacimiento" value="{{ old('fecha_nacimiento') }}"
                       class="w-full px-4 py-2.5 border {{ $errors->has('fecha_nacimiento') ? 'border-red-500 focus:ring-red-500 focus:border-red-500' : 'border-gray-300 focus:ring-indigo-500 focus:border-indigo-500' }} rounded-lg shadow-sm transition-colors">
                @error('fecha_nacimiento') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
            </div>
        </div>

        {{-- Sexo, Teléfono y Número Seguridad Social --}}
        <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
            <div class="space-y-1">
                <label for="sexo" class="block text-sm font-medium text-gray-700">Sexo</label>
                <select name="sexo" id="sexo"
                        class="w-full px-4 py-2.5 border {{ $errors->has('sexo') ? 'border-red-500 focus:ring-red-500 focus:border-red-500' : 'border-gray-300 focus:ring-indigo-500 focus:border-indigo-500' }} rounded-lg shadow-sm transition-colors">
                    <option value="" {{ old('sexo') ? '' : 'selected' }}>Seleccionar...</option>
                    <option value="Hombre" {{ old('sexo') == 'Hombre' ? 'selected' : '' }}>Hombre</option>
                    <option value="Mujer" {{ old('sexo') == 'Mujer' ? 'selected' : '' }}>Mujer</option>
                    <option value="Otro" {{ old('sexo') == 'Otro' ? 'selected' : '' }}>Otro</option>
                </select>
                @error('sexo') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
            </div>
            <div class="space-y-1">
                <label for="telefono" class="block text-sm font-medium text-gray-700">Teléfono</label>
                <input type="tel" name="telefono" id="telefono" value="{{ old('telefono') }}"
                       class="w-full px-4 py-2.5 border {{ $errors->has('telefono') ? 'border-red-500 focus:ring-red-500 focus:border-red-500' : 'border-gray-300 focus:ring-indigo-500 focus:border-indigo-500' }} rounded-lg shadow-sm transition-colors"
                       placeholder="Ej: 600123456">
                @error('telefono') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
            </div>
            <div class="space-y-1">
                <label for="num_seguridad_social" class="block text-sm font-medium text-gray-700">Nº Seguridad Social</label>
                <input type="text" name="num_seguridad_social" id="num_seguridad_social" value="{{ old('num_seguridad_social') }}"
                       class="w-full px-4 py-2.5 border {{ $errors->has('num_seguridad_social') ? 'border-red-500 focus:ring-red-500 focus:border-red-500' : 'border-gray-300 focus:ring-indigo-500 focus:border-indigo-500' }} rounded-lg shadow-sm transition-colors"
                       placeholder="Ej: 12/34567890/12">
                @error('num_seguridad_social') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
            </div>
        </div>

        {{-- Dirección --}}
        <div class="space-y-1">
            <label for="direccion" class="block text-sm font-medium text-gray-700">Dirección</label>
            <textarea name="direccion" id="direccion" rows="3"
                      class="w-full px-4 py-2.5 border {{ $errors->has('direccion') ? 'border-red-500 focus:ring-red-500 focus:border-red-500' : 'border-gray-300 focus:ring-indigo-500 focus:border-indigo-500' }} rounded-lg shadow-sm transition-colors resize-none"
                      placeholder="Calle, número, piso, puerta...">{{ old('direccion') }}</textarea>
            @error('direccion') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
        </div>
    </div>
</div>

        {{-- Sección Información Profesional --}}
        <div class="bg-white rounded-xl shadow-sm border border-gray-200 overflow-hidden">
            <div class="bg-gradient-to-r from-green-50 to-emerald-50 px-6 py-4 border-b border-gray-200">
                 <h2 class="text-lg font-semibold text-gray-900">Información Profesional</h2>
            </div>
            <div class="p-6 space-y-6">
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div class="space-y-1">
                        <label for="titulacion_academica" class="block text-sm font-medium text-gray-700">Titulación Académica</label>
                        {{-- Para Titulación --}}
<select name="titulacion_academica" id="titulacion_academica" class="...">
    <option value="">Seleccionar titulación...</option>
    @foreach($opcionesTitulacion as $opcion)
        <option value="{{ $opcion }}" {{ old('titulacion_academica', $profesor->titulacion_academica ?? '') == $opcion ? 'selected' : '' }}>
            {{ $opcion }}
        </option>
    @endforeach
</select>
                    </div>
                    <div class="space-y-1">
                        <label for="especialidad" class="block text-sm font-medium text-gray-700">Especialidad</label>
                        <select name="especialidad" id="especialidad" class="...">
    <option value="">Seleccionar especialidadión...</option>
    @foreach($opcionesEspecialidad as $opcion)
        <option value="{{ $opcion }}" {{ old('especialidad', $profesor->especialidad ?? '') == $opcion ? 'selected' : '' }}>
            {{ $opcion }}
        </option>
    @endforeach
</select>
                    </div>
                </div>
            </div>
        </div>

        {{-- Botones de Acción --}}
        <div class="flex flex-col sm:flex-row justify-end gap-3 pt-4">
            <a href="{{ route('admin.profesores.index') }}"
               class="px-6 py-2.5 text-sm font-medium text-gray-700 bg-white border border-gray-300 rounded-lg shadow-sm hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 transition-colors text-center">
                Cancelar
            </a>
            <button type="submit"
                    class="px-6 py-2.5 text-sm font-medium text-white bg-indigo-600 border border-transparent rounded-lg shadow-sm hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 transition-colors">
                Guardar Profesor
            </button>
        </div>
    </form>
</div>
</div>
@endsection

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    // Formateo y validación básica para DNI/NIE
    const dniInput = document.getElementById('dni');
    if (dniInput) {
        dniInput.addEventListener('input', function() {
            let value = this.value.toUpperCase();
            // Permitir solo números y letras, máximo 9 caracteres
            value = value.replace(/[^A-Z0-9]/g, '').substring(0, 9);
            this.value = value;

            // Validación básica de formato (opcional, para feedback visual inmediato)
            // La validación principal se hará en el backend
            const dniRegex = /^[0-9]{8}[A-Z]$/;
            const nieRegex = /^[XYZ][0-9]{7}[A-Z]$/;
            const parentDiv = this.closest('.space-y-1'); // Para el mensaje de error si lo hubiera

            if (value && !dniRegex.test(value) && !nieRegex.test(value)) {
                this.classList.add('border-red-500', 'focus:ring-red-500', 'focus:border-red-500');
                this.classList.remove('border-gray-300', 'focus:ring-indigo-500', 'focus:border-indigo-500');
                // Opcional: Añadir un mensaje de error de formato en JS
                // if (parentDiv) {
                //     let errorMsg = parentDiv.querySelector('.js-format-error');
                //     if (!errorMsg) {
                //         errorMsg = document.createElement('p');
                //         errorMsg.className = 'text-orange-500 text-xs mt-1 js-format-error';
                //         parentDiv.appendChild(errorMsg);
                //     }
                //     errorMsg.textContent = 'Formato DNI/NIE inválido.';
                // }
            } else {
                this.classList.remove('border-red-500', 'focus:ring-red-500', 'focus:border-red-500');
                this.classList.add('border-gray-300', 'focus:ring-indigo-500', 'focus:border-indigo-500');
                // if (parentDiv) {
                //     const errorMsg = parentDiv.querySelector('.js-format-error');
                //     if (errorMsg) errorMsg.remove();
                // }
            }
        });
    }

    // Formateo automático para número de seguridad social (NUSS)
    const nussInput = document.getElementById('num_seguridad_social'); // Asegúrate que el ID del input es 'num_seguridad_social'
    if (nussInput) {
        nussInput.addEventListener('input', function() {
            let value = this.value.replace(/\D/g, ''); // Eliminar no dígitos
            let formattedValue = '';

            if (value.length > 0) {
                formattedValue = value.substring(0, 2); // Primeros 2 dígitos
                if (value.length > 2) {
                    // Siguientes 8 dígitos (o menos si no hay tantos)
                    formattedValue += '/' + value.substring(2, 10);
                    if (value.length > 10) {
                        // Últimos 2 dígitos (o menos)
                        formattedValue += '/' + value.substring(10, 12);
                    }
                }
            }
            this.value = formattedValue;
        });
    }

    // Formateo para teléfono (solo números, máximo 9 o el que definas)
    const telefonoInput = document.getElementById('telefono'); // Asegúrate que el ID del input es 'telefono'
    if (telefonoInput) {
        telefonoInput.addEventListener('input', function() {
            this.value = this.value.replace(/\D/g, '').substring(0, 9); // Permitir máximo 9 dígitos
        });
    }

    // Puedes añadir aquí formateo para otros campos si es necesario, como CP, etc.
    // Ejemplo para Código Postal (si lo tuvieras como input 'cp_profesor'):
    /*
    const cpInput = document.getElementById('cp_profesor');
    if (cpInput) {
        cpInput.addEventListener('input', function() {
            this.value = this.value.replace(/\D/g, '').substring(0, 5);
        });
    }
    */
});
</script>
@endpush
