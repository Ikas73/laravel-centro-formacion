@extends('layouts.admin')

@section('title', 'Añadir Nuevo Alumno')
@section('page-title', 'Añadir Nuevo Alumno')

@section('content')
<div class="min-h-screen bg-gray-50 py-8">
    <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">
        {{-- Header --}}
        <div class="mb-8">
            <div class="flex items-center space-x-3">
                <div class="p-3 bg-indigo-100 rounded-lg">
                    <svg class="w-8 h-8 text-indigo-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                    </svg>
                </div>
                <div>
                    <h1 class="text-3xl font-bold text-gray-900">Añadir Nuevo Alumno</h1>
                    <p class="text-gray-600 mt-1">Complete todos los campos marcados con * para registrar al alumno</p>
                </div>
            </div>
        </div>

        @if ($errors->any())
            <div class="mb-4 p-4 bg-red-100 border border-red-400 text-red-700 rounded-md">
                <strong class="font-bold">¡Atención! Por favor, corrija los siguientes errores:</strong>
                <ul class="mt-2 list-disc list-inside text-sm">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form method="POST" action="{{ route('admin.alumnos.store') }}" class="space-y-8">
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
                    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                        <div class="space-y-1">
                            <label for="nombre" class="block text-sm font-medium text-gray-700">Nombre <span class="text-red-500">*</span></label>
                            <input type="text" name="nombre" id="nombre" value="{{ old('nombre') }}" required class="w-full px-4 py-2 border {{ $errors->has('nombre') ? 'border-red-500 focus:ring-red-500 focus:border-red-500' : 'border-gray-300 focus:ring-indigo-500 focus:border-indigo-500' }} rounded-lg transition-colors" placeholder="Ingrese el nombre">
                            @error('nombre') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                        </div>
                        <div class="space-y-1">
                            <label for="apellido1" class="block text-sm font-medium text-gray-700">Primer Apellido <span class="text-red-500">*</span></label>
                            <input type="text" name="apellido1" id="apellido1" value="{{ old('apellido1') }}" required class="w-full px-4 py-2 border {{ $errors->has('apellido1') ? 'border-red-500 focus:ring-red-500 focus:border-red-500' : 'border-gray-300 focus:ring-indigo-500 focus:border-indigo-500' }} rounded-lg transition-colors" placeholder="Primer apellido">
                            @error('apellido1') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                        </div>
                        <div class="space-y-1">
                            <label for="apellido2" class="block text-sm font-medium text-gray-700">Segundo Apellido</label>
                            <input type="text" name="apellido2" id="apellido2" value="{{ old('apellido2') }}" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 transition-colors" placeholder="Segundo apellido (opcional)">
                            @error('apellido2') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                        </div>
                    </div>
                    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                        <div class="space-y-1">
                            <label for="dni" class="block text-sm font-medium text-gray-700">DNI/NIE <span class="text-red-500">*</span></label>
                            <input type="text" name="dni" id="dni" value="{{ old('dni') }}" required class="w-full px-4 py-2 border {{ $errors->has('dni') ? 'border-red-500 focus:ring-red-500 focus:border-red-500' : 'border-gray-300 focus:ring-indigo-500 focus:border-indigo-500' }} rounded-lg transition-colors" placeholder="12345678A">
                            @error('dni') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                        </div>
                        <div class="space-y-1">
                            <label for="email" class="block text-sm font-medium text-gray-700">Email <span class="text-red-500">*</span></label>
                            <input type="email" name="email" id="email" value="{{ old('email') }}" required class="w-full px-4 py-2 border {{ $errors->has('email') ? 'border-red-500 focus:ring-red-500 focus:border-red-500' : 'border-gray-300 focus:ring-indigo-500 focus:border-indigo-500' }} rounded-lg transition-colors" placeholder="ejemplo@correo.com">
                            @error('email') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                        </div>
                        <div class="space-y-1">
                            <label for="sexo" class="block text-sm font-medium text-gray-700">Sexo <span class="text-red-500">*</span></label>
                            <select name="sexo" id="sexo" required class="w-full px-4 py-2 border {{ $errors->has('sexo') ? 'border-red-500 focus:ring-red-500 focus:border-red-500' : 'border-gray-300 focus:ring-indigo-500 focus:border-indigo-500' }} rounded-lg transition-colors">
                                <option value="" disabled {{ old('sexo') ? '' : 'selected' }}>Seleccionar...</option>
                                <option value="Hombre" {{ old('sexo') == 'Hombre' ? 'selected' : '' }}>Hombre</option>
                                <option value="Mujer" {{ old('sexo') == 'Mujer' ? 'selected' : '' }}>Mujer</option>
                                <option value="Otro" {{ old('sexo') == 'Otro' ? 'selected' : '' }}>Otro</option>
                            </select>
                            @error('sexo') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                        </div>
                    </div>
                    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                        <div class="space-y-1">
                            <label for="fecha_nacimiento" class="block text-sm font-medium text-gray-700">Fecha de Nacimiento <span class="text-red-500">*</span></label>
                            <input type="date" name="fecha_nacimiento" id="fecha_nacimiento" value="{{ old('fecha_nacimiento') }}" required class="w-full px-4 py-2 border {{ $errors->has('fecha_nacimiento') ? 'border-red-500 focus:ring-red-500 focus:border-red-500' : 'border-gray-300 focus:ring-indigo-500 focus:border-indigo-500' }} rounded-lg transition-colors">
                            @error('fecha_nacimiento') <p class="text-red-500 text-sm">{{ $message }}</p> @enderror
                        </div>
                        <div class="space-y-1">
                            <label for="nacionalidad" class="block text-sm font-medium text-gray-700">Nacionalidad <span class="text-red-500">*</span></label>
                            <input type="text" name="nacionalidad" id="nacionalidad" value="{{ old('nacionalidad', 'Española') }}" required class="w-full px-4 py-2 border {{ $errors->has('nacionalidad') ? 'border-red-300 focus:ring-red-500 focus:border-red-500' : 'border-gray-300 focus:ring-indigo-500 focus:border-indigo-500' }} rounded-lg transition-colors" placeholder="Española">
                            @error('nacionalidad') <p class="text-red-500 text-sm">{{ $message }}</p> @enderror
                        </div>
                        <div class="space-y-1">
                            <label for="numero_seguridad_social" class="block text-sm font-medium text-gray-700">Número Seguridad Social <span class="text-red-500">*</span></label>
                            <input type="text" name="numero_seguridad_social" id="numero_seguridad_social" value="{{ old('numero_seguridad_social') }}" required class="w-full px-4 py-2 border {{ $errors->has('numero_seguridad_social') ? 'border-red-300 focus:ring-red-500 focus:border-red-500' : 'border-gray-300 focus:ring-indigo-500 focus:border-indigo-500' }} rounded-lg transition-colors" placeholder="12/34567890/12">
                            @error('numero_seguridad_social') <p class="text-red-500 text-sm">{{ $message }}</p> @enderror
                        </div>
                    </div>
                </div>
            </div>

            {{-- Información de Contacto --}}
            <div class="bg-white rounded-xl shadow-sm border border-gray-200 overflow-hidden">
                <div class="bg-gradient-to-r from-green-50 to-emerald-50 px-6 py-4 border-b border-gray-200">
                    <div class="flex items-center space-x-3">
                        <div class="p-2 bg-green-100 rounded-lg">
                            <svg class="w-5 h-5 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"></path></svg>
                        </div>
                        <h2 class="text-lg font-semibold text-gray-900">Información de Contacto</h2>
                    </div>
                </div>
                
                <div class="p-6 space-y-6">
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div class="space-y-1">
                            <label for="direccion_completa" class="block text-sm font-medium text-gray-700">Dirección Completa <span class="text-red-500">*</span></label>
                            <textarea name="direccion_completa" id="direccion_completa" rows="3" required class="w-full px-4 py-2 border {{ $errors->has('direccion_completa') ? 'border-red-300 focus:ring-red-500 focus:border-red-500' : 'border-gray-300 focus:ring-indigo-500 focus:border-indigo-500' }} rounded-lg transition-colors resize-none" placeholder="Calle, número, piso, puerta...">{{ old('direccion_completa') }}</textarea>
                            @error('direccion_completa') <p class="text-red-500 text-sm">{{ $message }}</p> @enderror
                        </div>
                        <div class="space-y-1">
                            <label for="telefono" class="block text-sm font-medium text-gray-700">Teléfono <span class="text-red-500">*</span></label>
                            <input type="tel" name="telefono" id="telefono" value="{{ old('telefono') }}" required class="w-full px-4 py-2 border {{ $errors->has('telefono') ? 'border-red-300 focus:ring-red-500 focus:border-red-500' : 'border-gray-300 focus:ring-indigo-500 focus:border-indigo-500' }} rounded-lg transition-colors" placeholder="600123456">
                            @error('telefono') <p class="text-red-500 text-sm">{{ $message }}</p> @enderror
                        </div>
                    </div>
                    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                        <div class="space-y-1">
                            <label for="codigo_postal" class="block text-sm font-medium text-gray-700">Código Postal <span class="text-red-500">*</span></label>
                            <input type="text" name="codigo_postal" id="codigo_postal" value="{{ old('codigo_postal') }}" required class="w-full px-4 py-2 border {{ $errors->has('codigo_postal') ? 'border-red-300 focus:ring-red-500 focus:border-red-500' : 'border-gray-300 focus:ring-indigo-500 focus:border-indigo-500' }} rounded-lg transition-colors" placeholder="28001">
                            @error('codigo_postal') <p class="text-red-500 text-sm">{{ $message }}</p> @enderror
                        </div>
                        <div class="space-y-1">
                            <label for="localidad" class="block text-sm font-medium text-gray-700">Localidad <span class="text-red-500">*</span></label>
                            <input type="text" name="localidad" id="localidad" value="{{ old('localidad') }}" required class="w-full px-4 py-2 border {{ $errors->has('localidad') ? 'border-red-300 focus:ring-red-500 focus:border-red-500' : 'border-gray-300 focus:ring-indigo-500 focus:border-indigo-500' }} rounded-lg transition-colors" placeholder="Madrid">
                            @error('localidad') <p class="text-red-500 text-sm">{{ $message }}</p> @enderror
                        </div>
                        <div class="space-y-1">
                            <label for="provincia" class="block text-sm font-medium text-gray-700">Provincia <span class="text-red-500">*</span></label>
                            <input type="text" name="provincia" id="provincia" value="{{ old('provincia') }}" required class="w-full px-4 py-2 border {{ $errors->has('provincia') ? 'border-red-300 focus:ring-red-500 focus:border-red-500' : 'border-gray-300 focus:ring-indigo-500 focus:border-indigo-500' }} rounded-lg transition-colors" placeholder="Madrid">
                            @error('provincia') <p class="text-red-500 text-sm">{{ $message }}</p> @enderror
                        </div>
                    </div>
                </div>
            </div>

            {{-- Información Académica y Laboral --}}
            <div class="bg-white rounded-xl shadow-sm border border-gray-200 overflow-hidden">
                <div class="bg-gradient-to-r from-purple-50 to-pink-50 px-6 py-4 border-b border-gray-200">
                    <div class="flex items-center space-x-3">
                        <div class="p-2 bg-purple-100 rounded-lg">
                            <svg class="w-5 h-5 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.746 0 3.332.477 4.5 1.253v13C19.832 18.477 18.246 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"></path></svg>
                        </div>
                        <h2 class="text-lg font-semibold text-gray-900">Información Académica y Laboral</h2>
                    </div>
                </div>
                
                <div class="p-6 space-y-6">
                    {{-- El select 'nivel_formativo' y 'estado' se mantienen aquí, una sola vez --}}
                    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                        <div class="space-y-1">
                            <label for="nivel_formativo" class="block text-sm font-medium text-gray-700">Nivel Formativo <span class="text-red-500">*</span></label>
                            <select name="nivel_formativo" id="nivel_formativo" required class="w-full px-4 py-2 border {{ $errors->has('nivel_formativo') ? 'border-red-500 focus:ring-red-500 focus:border-red-500' : 'border-gray-300 focus:ring-indigo-500 focus:border-indigo-500' }} rounded-lg transition-colors">
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
                            @error('nivel_formativo') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                        </div>

                        <div class="space-y-1">
                            <label for="situacion_laboral" class="block text-sm font-medium text-gray-700">Situación Laboral <span class="text-red-500">*</span></label>
                            <select name="situacion_laboral" id="situacion_laboral" required class="w-full px-4 py-2 border {{ $errors->has('situacion_laboral') ? 'border-red-500 focus:ring-red-500 focus:border-red-500' : 'border-gray-300 focus:ring-indigo-500 focus:border-indigo-500' }} rounded-lg transition-colors">
                                <option value="" disabled {{ old('situacion_laboral') ? '' : 'selected' }}>Seleccionar...</option>
                                <option value="Empleado a tiempo completo" {{ old('situacion_laboral') == 'Empleado a tiempo completo' ? 'selected' : '' }}>Empleado a tiempo completo</option>
                                <option value="Empleado a tiempo parcial" {{ old('situacion_laboral') == 'Empleado a tiempo parcial' ? 'selected' : '' }}>Empleado a tiempo parcial</option>
                                <option value="Desempleado" {{ old('situacion_laboral') == 'Desempleado' ? 'selected' : '' }}>Desempleado</option>
                                <option value="Estudiante" {{ old('situacion_laboral') == 'Estudiante' ? 'selected' : '' }}>Estudiante</option>
                                <option value="Jubilado" {{ old('situacion_laboral') == 'Jubilado' ? 'selected' : '' }}>Jubilado</option>
                                <option value="Autónomo" {{ old('situacion_laboral') == 'Autónomo' ? 'selected' : '' }}>Autónomo</option>
                            </select>
                            @error('situacion_laboral') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                        </div>

                        <div class="space-y-1">
                            <label for="estado" class="block text-sm font-medium text-gray-700">Estado <span class="text-red-500">*</span></label>
                            <select name="estado" id="estado" required class="w-full px-4 py-2 border {{ $errors->has('estado') ? 'border-red-500 focus:ring-red-500 focus:border-red-500' : 'border-gray-300 focus:ring-indigo-500 focus:border-indigo-500' }} rounded-lg transition-colors">
                                <option value="" disabled {{ old('estado') ? '' : 'selected' }}>Seleccionar...</option>
                                <option value="Activo" {{ old('estado') == 'Activo' ? 'selected' : '' }}>Activo</option>
                                <option value="Inactivo" {{ old('estado') == 'Inactivo' ? 'selected' : '' }}>Inactivo</option>
                                <option value="Pendiente" {{ old('estado') == 'Pendiente' ? 'selected' : '' }}>Pendiente</option>
                                <option value="Baja" {{ old('estado') == 'Baja' ? 'selected' : '' }}>Baja</option>
                            </select>
                            @error('estado') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                        </div>
                    </div>
                </div>
            </div>

            {{-- Botones de Acción --}}
            <div class="flex flex-col sm:flex-row justify-end gap-4 pt-6">
                <a href="{{ route('admin.alumnos.index') }}" class="px-6 py-3 text-sm font-medium text-gray-700 bg-white border border-gray-300 rounded-lg shadow-sm hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 transition-colors">
                    <svg class="w-4 h-4 inline mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
                    Cancelar
                </a>
                <button type="submit" class="px-6 py-3 text-sm font-medium text-white bg-indigo-600 border border-transparent rounded-lg shadow-sm hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 transition-colors">
                    <svg class="w-4 h-4 inline mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
                    Guardar Alumno
                </button>
            </div>
        </form>
    </div>
</div>
@endsection

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    const dniInput = document.getElementById('dni');
    if (dniInput) {
        dniInput.addEventListener('input', function() {
            let value = this.value.toUpperCase().replace(/[^A-Z0-9]/g, '').substring(0, 9);
            this.value = value;
            // Validación básica de formato (ya no es estrictamente necesaria si la validación backend es robusta, pero ayuda al UX)
            // const dniRegex = /^[0-9]{8}[A-Z]$/;
            // const nieRegex = /^[XYZ][0-9]{7}[A-Z]$/;
            // if (value && !dniRegex.test(value) && !nieRegex.test(value)) {
            //     this.classList.add('border-red-500', 'focus:ring-red-500', 'focus:border-red-500');
            //     this.classList.remove('border-gray-300', 'focus:ring-indigo-500', 'focus:border-indigo-500');
            // } else {
            //     this.classList.remove('border-red-300', 'focus:ring-red-500', 'focus:border-red-500');
            //     this.classList.add('border-gray-300', 'focus:ring-indigo-500', 'focus:border-indigo-500');
            // }
        });
    }

    const nssInput = document.getElementById('num_seguridad_social');
    if (nssInput) {
        nssInput.addEventListener('input', function() {
            let value = this.value.replace(/\D/g, '');
            let formattedValue = '';
            if (value.length > 0) {
                formattedValue = value.substring(0, 2);
                if (value.length > 2) {
                    formattedValue += '/' + value.substring(2, 10);
                    if (value.length > 10) {
                        formattedValue += '/' + value.substring(10, 12);
                    }
                }
            }
            this.value = formattedValue.substring(0, 15);
        });
    }

    const cpInput = document.getElementById('codigo_postal');
    if (cpInput) {
        cpInput.addEventListener('input', function() {
            this.value = this.value.replace(/\D/g, '').substring(0, 5);
        });
    }

    const telefonoInput = document.getElementById('telefono');
    if (telefonoInput) {
        telefonoInput.addEventListener('input', function() {
            this.value = this.value.replace(/\D/g, '').substring(0, 9);
        });
    }
});
</script>
@endpush