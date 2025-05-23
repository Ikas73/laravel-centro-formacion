@extends('layouts.admin')

@section('title', 'Editar Alumno: ' . $alumno->nombre . ' ' . $alumno->apellido1)
@section('page-title', 'Editar Alumno')

@section('content')
<div class="min-h-screen bg-gray-50 py-8">
    <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">
        <!-- Header del formulario -->
        <div class="mb-8">
            <div class="flex items-center space-x-3 mb-2">
                <div class="flex-shrink-0">
                    <div class="w-10 h-10 bg-indigo-100 rounded-full flex items-center justify-center">
                        <svg class="w-6 h-6 text-indigo-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                        </svg>
                    </div>
                </div>
                <div>
                    <h1 class="text-2xl font-bold text-gray-900">Editar Alumno</h1>
                    <p class="text-sm text-gray-600">{{ $alumno->nombre }} {{ $alumno->apellido1 }} {{ $alumno->apellido2 }}</p>
                </div>
            </div>
        </div>

        <!-- Formulario principal -->
        <div class="bg-white shadow-xl rounded-lg overflow-hidden">
            <form method="POST" action="{{ route('admin.alumnos.update', $alumno->id) }}" class="divide-y divide-gray-200">
                @csrf
                @method('PUT')

                <!-- Sección: Información Personal -->
                <div class="px-6 py-8">
                    <div class="flex items-center mb-6">
                        <div class="flex-shrink-0">
                            <div class="w-8 h-8 bg-blue-100 rounded-full flex items-center justify-center">
                                <svg class="w-5 h-5 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                                </svg>
                            </div>
                        </div>
                        <h3 class="ml-3 text-lg font-semibold text-gray-900">Información Personal</h3>
                    </div>

                    <!-- Nombre y Apellidos -->
                    <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-6">
                        <div class="space-y-1">
                            <label for="nombre" class="block text-sm font-semibold text-gray-700">
                                Nombre <span class="text-red-500">*</span>
                            </label>
                            <input type="text" 
                                   name="nombre" 
                                   id="nombre" 
                                   value="{{ old('nombre', $alumno->nombre) }}" 
                                   required
                                   class="block w-full px-4 py-3 border border-gray-300 rounded-lg shadow-sm placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-transparent transition duration-200 ease-in-out">
                            @error('nombre')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>
                        
                        <div class="space-y-1">
                            <label for="apellido1" class="block text-sm font-semibold text-gray-700">
                                Primer Apellido <span class="text-red-500">*</span>
                            </label>
                            <input type="text" 
                                   name="apellido1" 
                                   id="apellido1" 
                                   value="{{ old('apellido1', $alumno->apellido1) }}" 
                                   required
                                   class="block w-full px-4 py-3 border border-gray-300 rounded-lg shadow-sm placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-transparent transition duration-200 ease-in-out">
                            @error('apellido1')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>
                        
                        <div class="space-y-1">
                            <label for="apellido2" class="block text-sm font-semibold text-gray-700">
                                Segundo Apellido
                            </label>
                            <input type="text" 
                                   name="apellido2" 
                                   id="apellido2" 
                                   value="{{ old('apellido2', $alumno->apellido2) }}"
                                   class="block w-full px-4 py-3 border border-gray-300 rounded-lg shadow-sm placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-transparent transition duration-200 ease-in-out">
                            @error('apellido2')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>

                    <!-- DNI, Email y Sexo -->
                    <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-6">
                        <div class="space-y-1">
                            <label for="dni" class="block text-sm font-semibold text-gray-700">
                                DNI/NIE <span class="text-red-500">*</span>
                            </label>
                            <input type="text" 
                                   name="dni" 
                                   id="dni" 
                                   value="{{ old('dni', $alumno->dni) }}" 
                                   required
                                   class="block w-full px-4 py-3 border border-gray-300 rounded-lg shadow-sm placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-transparent transition duration-200 ease-in-out">
                            @error('dni')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>
                        
                        <div class="space-y-1">
                            <label for="email" class="block text-sm font-semibold text-gray-700">
                                Email <span class="text-red-500">*</span>
                            </label>
                            <input type="email" 
                                   name="email" 
                                   id="email" 
                                   value="{{ old('email', $alumno->email) }}" 
                                   required
                                   class="block w-full px-4 py-3 border border-gray-300 rounded-lg shadow-sm placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-transparent transition duration-200 ease-in-out">
                            @error('email')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <div class="space-y-1">
                            <label for="sexo" class="block text-sm font-semibold text-gray-700">
                                Sexo <span class="text-red-500">*</span>
                            </label>
                            <select name="sexo" 
                                    id="sexo" 
                                    required
                                    class="block w-full px-4 py-3 border border-gray-300 rounded-lg shadow-sm focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-transparent transition duration-200 ease-in-out">
                                <option value="" disabled>Selecciona...</option>
                                <option value="Hombre" {{ old('sexo', $alumno->sexo) == 'Hombre' ? 'selected' : '' }}>Hombre</option>
                                <option value="Mujer" {{ old('sexo', $alumno->sexo) == 'Mujer' ? 'selected' : '' }}>Mujer</option>
                                <option value="Otro" {{ old('sexo', $alumno->sexo) == 'Otro' ? 'selected' : '' }}>Otro</option>
                            </select>
                            @error('sexo')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>

                    <!-- Fecha de Nacimiento, Nacionalidad y Seguridad Social -->
                    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                        <div class="space-y-1">
                            <label for="fecha_nacimiento" class="block text-sm font-semibold text-gray-700">
                                Fecha de Nacimiento <span class="text-red-500">*</span>
                            </label>
                            <input type="date" 
                                   name="fecha_nacimiento" 
                                   id="fecha_nacimiento" 
                                   value="{{ old('fecha_nacimiento', $alumno->fecha_nacimiento) }}" 
                                   required
                                   class="block w-full px-4 py-3 border border-gray-300 rounded-lg shadow-sm focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-transparent transition duration-200 ease-in-out">
                            @error('fecha_nacimiento')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <div class="space-y-1">
                            <label for="nacionalidad" class="block text-sm font-semibold text-gray-700">
                                Nacionalidad <span class="text-red-500">*</span>
                            </label>
                            <input type="text" 
                                   name="nacionalidad" 
                                   id="nacionalidad" 
                                   value="{{ old('nacionalidad', $alumno->nacionalidad) }}" 
                                   required
                                   placeholder="Ej: Española"
                                   class="block w-full px-4 py-3 border border-gray-300 rounded-lg shadow-sm placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-transparent transition duration-200 ease-in-out">
                            @error('nacionalidad')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <div class="space-y-1">
                            <label for="num_seguridad_social" class="block text-sm font-semibold text-gray-700">
                                Número Seguridad Social <span class="text-red-500">*</span>
                            </label>
                            <input type="text" 
                                   name="num_seguridad_social" 
                                   id="num_seguridad_social" 
                                   value="{{ old('num_seguridad_social', $alumno->num_seguridad_social) }}" 
                                   required
                                   placeholder="12/34567890/12"
                                   class="block w-full px-4 py-3 border border-gray-300 rounded-lg shadow-sm placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-transparent transition duration-200 ease-in-out">
                            @error('num_seguridad_social')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>
                </div>

                <!-- Sección: Información de Contacto -->
                <div class="px-6 py-8">
                    <div class="flex items-center mb-6">
                        <div class="flex-shrink-0">
                            <div class="w-8 h-8 bg-green-100 rounded-full flex items-center justify-center">
                                <svg class="w-5 h-5 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"></path>
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                </svg>
                            </div>
                        </div>
                        <h3 class="ml-3 text-lg font-semibold text-gray-900">Información de Contacto</h3>
                    </div>

                    <!-- Dirección y Teléfono -->
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
                        <div class="space-y-1">
                            <label for="direccion" class="block text-sm font-semibold text-gray-700">
                                Dirección Completa <span class="text-red-500">*</span>
                            </label>
                            <textarea name="direccion" 
                                      id="direccion" 
                                      rows="3" 
                                      required
                                      placeholder="Calle, número, piso..."
                                      class="block w-full px-4 py-3 border border-gray-300 rounded-lg shadow-sm placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-transparent transition duration-200 ease-in-out resize-none">{{ old('direccion', $alumno->direccion) }}</textarea>
                            @error('direccion')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <div class="space-y-1">
                            <label for="telefono" class="block text-sm font-semibold text-gray-700">
                                Teléfono <span class="text-red-500">*</span>
                            </label>
                            <input type="tel" 
                                   name="telefono" 
                                   id="telefono" 
                                   value="{{ old('telefono', $alumno->telefono) }}" 
                                   required
                                   placeholder="Ej: 694109166"
                                   class="block w-full px-4 py-3 border border-gray-300 rounded-lg shadow-sm placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-transparent transition duration-200 ease-in-out">
                            @error('telefono')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>

                    <!-- CP, Localidad y Provincia -->
                    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                        <div class="space-y-1">
                            <label for="cp" class="block text-sm font-semibold text-gray-700">
                                Código Postal <span class="text-red-500">*</span>
                            </label>
                            <input type="text" 
                                   name="cp" 
                                   id="cp" 
                                   value="{{ old('cp', $alumno->cp) }}" 
                                   required
                                   placeholder="Ej: 28001"
                                   maxlength="5"
                                   class="block w-full px-4 py-3 border border-gray-300 rounded-lg shadow-sm placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-transparent transition duration-200 ease-in-out">
                            @error('cp')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <div class="space-y-1">
                            <label for="localidad" class="block text-sm font-semibold text-gray-700">
                                Localidad <span class="text-red-500">*</span>
                            </label>
                            <input type="text" 
                                   name="localidad" 
                                   id="localidad" 
                                   value="{{ old('localidad', $alumno->localidad) }}" 
                                   required
                                   placeholder="Ej: Madrid"
                                   class="block w-full px-4 py-3 border border-gray-300 rounded-lg shadow-sm placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-transparent transition duration-200 ease-in-out">
                            @error('localidad')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <div class="space-y-1">
                            <label for="provincia" class="block text-sm font-semibold text-gray-700">
                                Provincia <span class="text-red-500">*</span>
                            </label>
                            <input type="text" 
                                   name="provincia" 
                                   id="provincia" 
                                   value="{{ old('provincia', $alumno->provincia) }}" 
                                   required
                                   placeholder="Ej: Madrid"
                                   class="block w-full px-4 py-3 border border-gray-300 rounded-lg shadow-sm placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-transparent transition duration-200 ease-in-out">
                            @error('provincia')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>
                </div>

                <!-- Sección: Información Académica y Laboral -->
                <div class="px-6 py-8">
                    <div class="flex items-center mb-6">
                        <div class="flex-shrink-0">
                            <div class="w-8 h-8 bg-purple-100 rounded-full flex items-center justify-center">
                                <svg class="w-5 h-5 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.746 0 3.332.477 4.5 1.253v13C19.832 18.477 18.246 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"></path>
                                </svg>
                            </div>
                        </div>
                        <h3 class="ml-3 text-lg font-semibold text-gray-900">Información Académica y Laboral</h3>
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                        <div class="space-y-1">
                            <label for="nivel_formativo" class="block text-sm font-semibold text-gray-700">
                                Nivel Formativo <span class="text-red-500">*</span>
                            </label>
                            <select name="nivel_formativo" 
                                    id="nivel_formativo" 
                                    required
                                    class="block w-full px-4 py-3 border border-gray-300 rounded-lg shadow-sm focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-transparent transition duration-200 ease-in-out">
                                <option value="" disabled>Selecciona un nivel...</option>
                                <option value="Sin estudios" {{ old('nivel_formativo', $alumno->nivel_formativo) == 'Sin estudios' ? 'selected' : '' }}>Sin estudios</option>
                                <option value="ESO" {{ old('nivel_formativo', $alumno->nivel_formativo) == 'ESO' ? 'selected' : '' }}>ESO</option>
                                <option value="Bachillerato" {{ old('nivel_formativo', $alumno->nivel_formativo) == 'Bachillerato' ? 'selected' : '' }}>Bachillerato</option>
                                <option value="Grado Medio" {{ old('nivel_formativo', $alumno->nivel_formativo) == 'Grado Medio' ? 'selected' : '' }}>Grado Medio</option>
                                <option value="Grado Superior" {{ old('nivel_formativo', $alumno->nivel_formativo) == 'Grado Superior' ? 'selected' : '' }}>Grado Superior</option>
                                <option value="Grado Universitario" {{ old('nivel_formativo', $alumno->nivel_formativo) == 'Grado Universitario' ? 'selected' : '' }}>Grado Universitario</option>
                                <option value="Máster" {{ old('nivel_formativo', $alumno->nivel_formativo) == 'Máster' ? 'selected' : '' }}>Máster</option>
                                <option value="Doctorado" {{ old('nivel_formativo', $alumno->nivel_formativo) == 'Doctorado' ? 'selected' : '' }}>Doctorado</option>
                            </select>
                            @error('nivel_formativo')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <div class="space-y-1">
                            <label for="situacion_laboral" class="block text-sm font-semibold text-gray-700">
                                Situación Laboral <span class="text-red-500">*</span>
                            </label>
                            <select name="situacion_laboral" 
                                    id="situacion_laboral" 
                                    required
                                    class="block w-full px-4 py-3 border border-gray-300 rounded-lg shadow-sm focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-transparent transition duration-200 ease-in-out">
                                <option value="" disabled>Selecciona...</option>
                                <option value="Empleado a tiempo completo" {{ old('situacion_laboral', $alumno->situacion_laboral) == 'Empleado a tiempo completo' ? 'selected' : '' }}>Empleado a tiempo completo</option>
                                <option value="Empleado a tiempo parcial" {{ old('situacion_laboral', $alumno->situacion_laboral) == 'Empleado a tiempo parcial' ? 'selected' : '' }}>Empleado a tiempo parcial</option>
                                <option value="Desempleado" {{ old('situacion_laboral', $alumno->situacion_laboral) == 'Desempleado' ? 'selected' : '' }}>Desempleado</option>
                                <option value="Estudiante" {{ old('situacion_laboral', $alumno->situacion_laboral) == 'Estudiante' ? 'selected' : '' }}>Estudiante</option>
                                <option value="Autónomo" {{ old('situacion_laboral', $alumno->situacion_laboral) == 'Autónomo' ? 'selected' : '' }}>Autónomo</option>
                                <option value="Jubilado" {{ old('situacion_laboral', $alumno->situacion_laboral) == 'Jubilado' ? 'selected' : '' }}>Jubilado</option>
                            </select>
                            @error('situacion_laboral')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <div class="space-y-1">
                            <label for="estado" class="block text-sm font-semibold text-gray-700">
                                Estado <span class="text-red-500">*</span>
                            </label>
                            <select name="estado" 
                                    id="estado" 
                                    required
                                    class="block w-full px-4 py-3 border border-gray-300 rounded-lg shadow-sm focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-transparent transition duration-200 ease-in-out">
                                <option value="Activo" {{ old('estado', $alumno->estado) == 'Activo' ? 'selected' : '' }}>Activo</option>
                                <option value="Inactivo" {{ old('estado', $alumno->estado) == 'Inactivo' ? 'selected' : '' }}>Inactivo</option>
                                <option value="Pendiente" {{ old('estado', $alumno->estado) == 'Pendiente' ? 'selected' : '' }}>Pendiente</option>
                                <option value="Baja" {{ old('estado', $alumno->estado) == 'Baja' ? 'selected' : '' }}>Baja</option>
                            </select>
                            @error('estado')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>
                </div>

                <!-- Botones de acción -->
                <div class="px-6 py-6 bg-gray-50 flex items-center justify-between">
                    <div class="flex items-center text-sm text-gray-500">
                        <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        </svg>
                        Los campos marcados con <span class="text-red-500">*</span> son obligatorios
                    </div>
                    
                    <div class="flex items-center space-x-4">
                        <a href="{{ route('admin.alumnos.show', $alumno->id) }}" 
                           class="inline-flex items-center px-6 py-3 border border-gray-300 text-sm font-medium rounded-lg text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 transition duration-200 ease-in-out">
                            <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                            </svg>
                            Cancelar
                        </a>
                        
                        <button type="submit"
                                class="inline-flex items-center px-6 py-3 border border-transparent text-sm font-medium rounded-lg text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 shadow-sm transition duration-200 ease-in-out transform hover:scale-105">
                            <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                            </svg>
                            Actualizar Alumno
                        </button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
    // Validación en tiempo real del email
    document.getElementById('email').addEventListener('blur', function() {
        const email = this.value;
        const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
        
        if (email && !emailRegex.test(email)) {
            this.classList.add('border-red-500', 'focus:ring-red-500');
            this.classList.remove('border-gray-300', 'focus:ring-indigo-500');
        } else {
            this.classList.remove('border-red-500', 'focus:ring-red-500');
            this.classList.add('border-gray-300', 'focus:ring-indigo-500');
        }
    });

    // Validación del DNI
    document.getElementById('dni').addEventListener('blur', function() {
        const dni = this.value.toUpperCase();
        const dniRegex = /^[0-9]{8}[TRWAGMYFPDXBNJZSQVHLCKE]$/;
        const nieRegex = /^[XYZ][0-9]{7}[TRWAGMYFPDXBNJZSQVHLCKE]$/;
        
        if (dni && !dniRegex.test(dni) && !nieRegex.test(dni)) {
            this.classList.add('border-red-500', 'focus:ring-red-500');
            this.classList.remove('border-gray-300', 'focus:ring-indigo-500');
        } else {
            this.classList.remove('border-red-500', 'focus:ring-red-500');
            this.classList.add('border-gray-300', 'focus:ring-indigo-500');
        }
    });

    // Validación del teléfono
    document.getElementById('telefono').addEventListener('blur', function() {
        const telefono = this.value;
        const telefonoRegex = /^[6-9][0-9]{8}$/; // Teléfonos españoles
        
        if (telefono && !telefonoRegex.test(telefono)) {
            this.classList.add('border-red-500', 'focus:ring-red-500');
            this.classList.remove('border-gray-300', 'focus:ring-indigo-500');
        } else {
            this.classList.remove('border-red-500', 'focus:ring-red-500');
            this.classList.add('border-gray-300', 'focus:ring-indigo-500');
        }
    });

    // Validación del código postal
    document.getElementById('cp').addEventListener('blur', function() {
        const cp = this.value;
        const cpRegex = /^[0-9]{5}$/;
        
        if (cp && !cpRegex.test(cp)) {
            this.classList.add('border-red-500', 'focus:ring-red-500');
            this.classList.remove('border-gray-300', 'focus:ring-indigo-500');
        } else {
            this.classList.remove('border-red-500', 'focus:ring-red-500');
            this.classList.add('border-gray-300', 'focus:ring-indigo-500');
        }
    });

    // Validación del número de seguridad social
    document.getElementById('num_seguridad_social').addEventListener('blur', function() {
        const nss = this.value;
        const nssRegex = /^[0-9]{2}\/[0-9]{8}\/[0-9]{2}$/;
        
        if (nss && !nssRegex.test(nss)) {
            this.classList.add('border-red-500', 'focus:ring-red-500');
            this.classList.remove('border-gray-300', 'focus:ring-indigo-500');
        } else {
            this.classList.remove('border-red-500', 'focus:ring-red-500');
            this.classList.add('border-gray-300', 'focus:ring-indigo-500');
        }
    });

    // Formateo automático del número de seguridad social
    document.getElementById('num_seguridad_social').addEventListener('input', function() {
        let value = this.value.replace(/\D/g, ''); // Eliminar caracteres no numéricos
        if (value.length >= 2) {
            value = value.substring(0, 2) + '/' + value.substring(2);
        }
        if (value.length >= 11) {
            value = value.substring(0, 11) + '/' + value.substring(11, 13);
        }
        this.value = value;
    });

    // Formateo automático del teléfono (agregar espacios cada 3 dígitos)
    document.getElementById('telefono').addEventListener('input', function() {
        let value = this.value.replace(/\D/g, ''); // Eliminar caracteres no numéricos
        value = value.substring(0, 9); // Limitar a 9 dígitos
        this.value = value;
    });

    // Auto-completar campos relacionados (ejemplo: si es de Madrid, sugerir provincia)
    document.getElementById('localidad').addEventListener('blur', function() {
        const localidad = this.value.toLowerCase();
        const provinciaField = document.getElementById('provincia');
        
        // Mapeo básico de localidades a provincias
        const localidadProvincia = {
            'madrid': 'Madrid',
            'barcelona': 'Barcelona',
            'valencia': 'Valencia',
            'sevilla': 'Sevilla',
            'bilbao': 'Vizcaya',
            'málaga': 'Málaga',
            'murcia': 'Murcia',
            'palma': 'Baleares',
            'las palmas': 'Las Palmas',
            'valladolid': 'Valladolid'
        };
        
        if (localidadProvincia[localidad] && !provinciaField.value) {
            provinciaField.value = localidadProvincia[localidad];
        }
    });
</script>
@endpush