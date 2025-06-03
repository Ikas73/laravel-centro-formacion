@extends('layouts.admin')

@section('title', 'Añadir Nuevo Preinscrito')
@section('page-title', 'Añadir Nuevo Preinscrito')

@section('content')
<div class="max-w-4xl mx-auto py-8 px-4 sm:px-6 lg:px-8">
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

    <form method="POST" action="{{ route('admin.preinscritos.store') }}" class="space-y-8">
        @csrf

        {{-- Sección Información Personal --}}
        <div class="bg-white rounded-xl shadow-sm border border-gray-200 overflow-hidden">
            <div class="bg-gradient-to-r from-sky-50 to-cyan-50 px-6 py-4 border-b border-gray-200"><h2 class="text-lg font-semibold text-gray-900">Información Personal</h2></div>
            <div class="p-6 space-y-6">
                <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                    <div class="space-y-1">
                        <label for="nombre" class="block text-sm font-medium text-gray-700">Nombre <span class="text-red-500">*</span></label>
                        <input type="text" name="nombre" id="nombre_pre" value="{{ old('nombre') }}" required class="form-input @error('nombre') form-input-error @enderror">
                        @error('nombre') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                    </div>
                    <div class="space-y-1">
                        <label for="apellido1" class="block text-sm font-medium text-gray-700">Primer Apellido <span class="text-red-500">*</span></label>
                        <input type="text" name="apellido1" id="apellido1_pre" value="{{ old('apellido1') }}" required class="form-input @error('apellido1') form-input-error @enderror">
                        @error('apellido1') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                    </div>
                    <div class="space-y-1">
                        <label for="apellido2" class="block text-sm font-medium text-gray-700">Segundo Apellido</label>
                        <input type="text" name="apellido2" id="apellido2_pre" value="{{ old('apellido2') }}" class="form-input @error('apellido2') form-input-error @enderror">
                        @error('apellido2') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                    </div>
                </div>
                <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                    <div class="space-y-1">
                        <label for="dni" class="block text-sm font-medium text-gray-700">DNI/NIE <span class="text-red-500">*</span></label>
                        <input type="text" name="dni" id="dni_pre" value="{{ old('dni') }}" required class="form-input @error('dni') form-input-error @enderror">
                        @error('dni') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                    </div>
                    <div class="space-y-1">
                        <label for="email" class="block text-sm font-medium text-gray-700">Email</label>
                        <input type="email" name="email" id="email_pre" value="{{ old('email') }}" class="form-input @error('email') form-input-error @enderror">
                        @error('email') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                    </div>
                    <div class="space-y-1">
                        <label for="fecha_nacimiento" class="block text-sm font-medium text-gray-700">Fecha de Nacimiento</label>
                        <input type="date" name="fecha_nacimiento" id="fecha_nacimiento_pre" value="{{ old('fecha_nacimiento') }}" class="form-input @error('fecha_nacimiento') form-input-error @enderror">
                        @error('fecha_nacimiento') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                    </div>
                </div>
                <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                     <div class="space-y-1">
                        <label for="sexo" class="block text-sm font-medium text-gray-700">Sexo</label>
                        <select name="sexo" id="sexo_pre" class="form-select @error('sexo') form-input-error @enderror">
                            <option value="" {{ old('sexo') == '' ? 'selected' : '' }}>Seleccionar...</option>
                            <option value="Hombre" {{ old('sexo') == 'Hombre' ? 'selected' : '' }}>Hombre</option>
                            <option value="Mujer" {{ old('sexo') == 'Mujer' ? 'selected' : '' }}>Mujer</option>
                            <option value="Otro" {{ old('sexo') == 'Otro' ? 'selected' : '' }}>Otro</option>
                        </select>
                        @error('sexo') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                    </div>
                    <div class="space-y-1">
                        <label for="telefono" class="block text-sm font-medium text-gray-700">Teléfono</label>
                        <input type="tel" name="telefono" id="telefono_pre" value="{{ old('telefono') }}" class="form-input @error('telefono') form-input-error @enderror">
                        @error('telefono') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                    </div>
                    <div class="space-y-1">
                        <label for="num_seguridad_social" class="block text-sm font-medium text-gray-700">Nº Seguridad Social</label>
                        <input type="text" name="num_seguridad_social" id="num_seguridad_social_pre" value="{{ old('num_seguridad_social') }}" class="form-input @error('num_seguridad_social') form-input-error @enderror">
                        @error('num_seguridad_social') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                    </div>
                </div>
            </div>

            {{-- Información de Contacto --}}
            <div class="bg-white rounded-xl shadow-sm border border-gray-200 overflow-hidden">
                <div class="bg-gradient-to-r from-green-50 to-emerald-50 px-6 py-4 border-b border-gray-200"><h2 class="text-lg font-semibold text-gray-900">Información de Contacto</h2></div>
                <div class="p-6 space-y-6">
                    <div class="space-y-1">
                        <label for="direccion" class="block text-sm font-medium text-gray-700">Dirección</label>
                        <textarea name="direccion" id="direccion_pre" rows="3" class="form-input @error('direccion') form-input-error @enderror">{{ old('direccion') }}</textarea>
                        @error('direccion') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                    </div>
                    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                        <div class="space-y-1">
                            <label for="cp" class="block text-sm font-medium text-gray-700">Código Postal</label>
                            <input type="text" name="cp" id="cp_pre" value="{{ old('cp') }}" class="form-input @error('cp') form-input-error @enderror">
                            @error('cp') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                        </div>
                        <div class="space-y-1">
                            <label for="localidad" class="block text-sm font-medium text-gray-700">Localidad</label>
                            <input type="text" name="localidad" id="localidad_pre" value="{{ old('localidad') }}" class="form-input @error('localidad') form-input-error @enderror">
                            @error('localidad') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                        </div>
                        <div class="space-y-1">
                            <label for="provincia" class="block text-sm font-medium text-gray-700">Provincia</label>
                            <input type="text" name="provincia" id="provincia_pre" value="{{ old('provincia') }}" class="form-input @error('provincia') form-input-error @enderror">
                            @error('provincia') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                        </div>
                    </div>
                </div>
            </div>

            {{-- Información Académica y Laboral --}}
            <div class="bg-white rounded-xl shadow-sm border border-gray-200 overflow-hidden">
                <div class="bg-gradient-to-r from-purple-50 to-pink-50 px-6 py-4 border-b border-gray-200"><h2 class="text-lg font-semibold text-gray-900">Información Académica y Laboral</h2></div>
                <div class="p-6 space-y-6">
                    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                        <div class="space-y-1">
                            <label for="nacionalidad" class="block text-sm font-medium text-gray-700">Nacionalidad</label>
                             <input type="text" name="nacionalidad" id="nacionalidad_pre" value="{{ old('nacionalidad') }}" class="form-input @error('nacionalidad') form-input-error @enderror">
                            @error('nacionalidad') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                        </div>
                        <div class="space-y-1">
                            <label for="nivel_formativo" class="block text-sm font-medium text-gray-700">Nivel Formativo</label>
                            <select name="nivel_formativo" id="nivel_formativo_pre" class="form-select @error('nivel_formativo') form-input-error @enderror">
                                <option value="" disabled {{ old('nivel_formativo') ? '' : 'selected' }}>Seleccionar...</option>
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
                            <label for="situacion_laboral" class="block text-sm font-medium text-gray-700">Situación Laboral</label>
                            <select name="situacion_laboral" id="situacion_laboral_pre" class="form-select @error('situacion_laboral') form-input-error @enderror">
                               <option value="" disabled {{ old('situacion_laboral') ? '' : 'selected' }}>Seleccionar...</option>
                               <option value="EmpleadoFP" {{ old('situacion_laboral') == 'Empleado a tiempo completo' ? 'selected' : '' }}>Empleado a tiempo completo</option>
                               <option value="EmpleadoTP" {{ old('situacion_laboral') == 'Empleado a tiempo parcial' ? 'selected' : '' }}>Empleado a tiempo parcial</option>
                               <option value="Desempleado" {{ old('situacion_laboral') == 'Desempleado' ? 'selected' : '' }}>Desempleado</option>
                               <option value="Estudiante" {{ old('situacion_laboral') == 'Estudiante' ? 'selected' : '' }}>Estudiante</option>
                               <option value="Jubilado" {{ old('situacion_laboral') == 'Jubilado' ? 'selected' : '' }}>Jubilado</option>
                               <option value="Autónomo" {{ old('situacion_laboral') == 'Autónomo' ? 'selected' : '' }}>Autónomo</option>
                            </select>
                             @error('situacion_laboral') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                        </div>
                    </div>
                    <div class="grid grid-cols-1 md:grid-cols-3 gap-6"> {{-- Nueva fila para Estado y Fecha Importación --}}
                        <div class="space-y-1">
                            <label for="estado" class="block text-sm font-medium text-gray-700">Estado Preinscripción <span class="text-red-500">*</span></label>
                             <select name="estado" id="estado_pre" required class="form-select @error('estado') form-input-error @enderror">
                                {{-- <option value="" disabled {{ old('estado') ? '' : 'selected' }}>Seleccionar...</option> --}}
                                <option value="Pendiente" {{ old('estado', 'Pendiente') == 'Pendiente' ? 'selected' : '' }}>Pendiente</option>
                                <option value="Contactado" {{ old('estado') == 'Contactado' ? 'selected' : '' }}>Contactado</option>
                                <option value="Interesado" {{ old('estado') == 'Interesado' ? 'selected' : '' }}>Interesado</option>
                                <option value="Convertido" {{ old('estado') == 'Convertido' ? 'selected' : '' }}>Convertido</option>
                                <option value="Rechazado" {{ old('estado') == 'Rechazado' ? 'selected' : '' }}>Rechazado</option>
                            </select>
                             @error('estado') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                        </div>
                        <div class="space-y-1">
                            <label for="fecha_importacion" class="block text-sm font-medium text-gray-700">Fecha Importación</label>
                            <input type="datetime-local" name="fecha_importacion" id="fecha_importacion_pre" value="{{ old('fecha_importacion', now()->format('Y-m-d\TH:i')) }}"
                                   class="form-input @error('fecha_importacion') form-input-error @enderror">
                            @error('fecha_importacion') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                        </div>
                    </div>
                </div>
            </div>

            {{-- Botones de Acción --}}
            <div class="flex flex-col sm:flex-row justify-end gap-3 pt-4">
                <a href="{{ route('admin.preinscritos.index') }}" class="btn-secondary-tailwind text-center">Cancelar</a>
                <button type="submit" class="btn-indigo-tailwind">Guardar Preinscrito</button>
            </div>
        </form>
    </div>
</div>
@endsection

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    const idsSuffix = '_pre';
    const dniInput = document.getElementById('dni' + idsSuffix);
    if (dniInput) { /* ... (código JS de formateo DNI) ... */ }

    const telefonoInput = document.getElementById('telefono' + idsSuffix);
    if (telefonoInput) { /* ... (código JS de formateo Teléfono) ... */ }

    const cpInput = document.getElementById('cp' + idsSuffix);
    if (cpInput) { /* ... (código JS de formateo CP) ... */ }

    const nussInput = document.getElementById('num_seguridad_social' + idsSuffix);
    if (nussInput) { /* ... (código JS de formateo NUSS) ... */ }
});
</script>
@endpush