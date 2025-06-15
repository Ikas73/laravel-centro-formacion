@extends('layouts.admin')
@section('title', 'Perfil de ' . $alumno->nombre . ' ' . $alumno->apellido1)
@section('page-title', 'Perfil del Estudiante')

@push('styles')
<style>
    /* Solo estilos que no se pueden lograr con Tailwind */
    .student-card-gradient {
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
    }
    
    @media print {
        .no-print { display: none !important; }
        .print-friendly { background: #f8fafc !important; color: #1e293b !important; }
    }
</style>
@endpush

@section('content')
{{-- Bloque de Mensajes Flash --}}
    @if (session('success'))
        <div class="mb-4 px-4 py-3 rounded-md relative bg-green-100 border border-green-400 text-green-800" role="alert">
            <strong class="font-bold">¡Éxito!</strong>
            <span class="block sm:inline">{{ session('success') }}</span>
        </div>
    @endif
    @if (session('error'))
        <div class="mb-4 px-4 py-3 rounded-md relative bg-red-100 border border-red-400 text-red-800" role="alert">
            <strong class="font-bold">¡Error!</strong>
            <span class="block sm:inline">{{ session('error') }}</span>
        </div>
    @endif
    {{-- Fin Bloque de Mensajes Flash --}}
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
    <!-- Student Header Card -->
    <div class="student-card-gradient rounded-3xl p-6 md:p-8 text-white mb-8 relative overflow-hidden shadow-2xl">
        <!-- Efecto decorativo con Tailwind -->
        <div class="absolute -top-20 -right-20 w-40 h-40 bg-white/10 rounded-full transform rotate-45"></div>
        <div class="absolute -top-10 -right-10 w-20 h-20 bg-white/5 rounded-full"></div>
        
        <div class="flex flex-col md:flex-row items-center md:items-start relative z-10">
            <!-- Avatar -->
            <div class="flex-shrink-0 mb-6 md:mb-0 md:mr-8">
                <div class="relative">
                    <img class="w-28 h-28 md:w-32 md:h-32 rounded-full border-4 border-white/30 shadow-2xl object-cover"
                         src="https://ui-avatars.com/api/?name={{ urlencode($alumno->nombre . ' ' . $alumno->apellido1) }}&size=200&color=ffffff&background=6366f1&font-size=0.5"
                         alt="Avatar de {{ $alumno->nombre }}">
                    <!-- Status dot -->
                    @php
                        $estado = $alumno->estado ?? 'Desconocido';
                        $dotColor = match($estado) {
                            'Activo' => 'bg-green-400',
                            'Inactivo' => 'bg-red-400',
                            'Pendiente' => 'bg-yellow-400',
                            'Baja' => 'bg-purple-400',
                            default => 'bg-gray-400'
                        };
                    @endphp
                    <div class="absolute -bottom-1 -right-1 w-8 h-8 {{ $dotColor }} rounded-full border-4 border-white shadow-lg"></div>
                </div>
            </div>
            
            <!-- Student Info -->
            <div class="flex-1 text-center md:text-left">
                <h1 class="text-3xl md:text-4xl font-bold mb-2 tracking-tight">
                    {{ $alumno->nombre }} {{ $alumno->apellido1 }} {{ $alumno->apellido2 ?? '' }}
                </h1>
                
                <div class="flex items-center justify-center md:justify-start mb-4 text-white/90">
                    <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H5a2 2 0 00-2 2v9a2 2 0 002 2h14a2 2 0 002-2V8a2 2 0 00-2-2h-5m-4 0V4a2 2 0 011-1h2a2 2 0 011 1v2m-4 0a2 2 0 104 0m-5 8a2 2 0 100-4 2 2 0 000 4zm0 0c1.306 0 2.417.835 2.83 2M9 14a3.001 3.001 0 00-6 0"></path>
                    </svg>
                    ID: {{ $alumno->dni ?? 'N/A' }}
                </div>
                
                <div class="flex flex-col md:flex-row items-center md:items-start space-y-3 md:space-y-0 md:space-x-6">
                    <!-- Status Badge -->
                    <div>
                        @php
                            $statusClasses = match($estado) {
                                'Activo' => 'bg-green-500/20 text-green-100 border-green-400/30',
                                'Inactivo' => 'bg-red-500/20 text-red-100 border-red-400/30',
                                'Pendiente' => 'bg-yellow-500/20 text-yellow-100 border-yellow-400/30',
                                'Baja' => 'bg-purple-500/20 text-purple-100 border-purple-400/30',
                                default => 'bg-gray-500/20 text-gray-100 border-gray-400/30'
                            };
                        @endphp
                        <span class="inline-flex items-center px-4 py-2 rounded-full text-sm font-semibold uppercase tracking-wide border backdrop-blur-sm {{ $statusClasses }}">
                            <div class="w-2 h-2 {{ $dotColor }} rounded-full mr-2 animate-pulse"></div>
                            {{ $estado }}
                        </span>
                    </div>
                    
                    <!-- Contact Info -->
                    @if($alumno->email)
                        <div class="flex items-center text-white/90">
                            <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 4.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path>
                            </svg>
                            <span class="text-sm">{{ $alumno->email }}</span>
                        </div>
                    @endif
                    
                    @if($alumno->telefono)
                        <div class="flex items-center text-white/90">
                            <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"></path>
                            </svg>
                            <span class="text-sm">{{ $alumno->telefono }}</span>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-4 gap-6">
        <!-- Main Content -->
        <div class="lg:col-span-3 space-y-8">
            <!-- Personal Information -->
            <div>
                <h2 class="text-2xl font-bold text-gray-900 mb-6 flex items-center">
                    <div class="w-8 h-8 bg-blue-100 rounded-lg flex items-center justify-center mr-3">
                        <svg class="w-5 h-5 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                        </svg>
                    </div>
                    Información Personal
                </h2>
                
                <div class="grid grid-cols-1 md:grid-cols-2 xl:grid-cols-3 gap-4">
                    <!-- Email -->
                    <div class="bg-white rounded-xl p-6 border border-gray-200 hover:shadow-lg hover:border-gray-300 hover:-translate-y-1 transition-all duration-300 group">
                        <div class="flex items-center text-sm font-semibold text-gray-600 mb-3">
                            <div class="w-8 h-8 bg-blue-100 rounded-lg flex items-center justify-center mr-3 group-hover:bg-blue-200 transition-colors">
                                <svg class="w-4 h-4 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 4.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path>
                                </svg>
                            </div>
                            Email
                        </div>
                        <div class="text-gray-900 font-medium break-words text-sm">
                            {{ $alumno->email ?? 'No especificado' }}
                        </div>
                    </div>
                    
                    <!-- Fecha de Nacimiento -->
                    <div class="bg-white rounded-xl p-6 border border-gray-200 hover:shadow-lg hover:border-gray-300 hover:-translate-y-1 transition-all duration-300 group">
                        <div class="flex items-center text-sm font-semibold text-gray-600 mb-3">
                            <div class="w-8 h-8 bg-green-100 rounded-lg flex items-center justify-center mr-3 group-hover:bg-green-200 transition-colors">
                                <svg class="w-4 h-4 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                                </svg>
                            </div>
                            Fecha de Nacimiento
                        </div>
                        <div class="text-gray-900 font-medium text-sm">
                            {{ $alumno->fecha_nacimiento ? \Carbon\Carbon::parse($alumno->fecha_nacimiento)->format('d/m/Y') : 'No especificada' }}
                            @if($alumno->fecha_nacimiento)
                                <div class="text-xs text-gray-500 mt-1">
                                    ({{ \Carbon\Carbon::parse($alumno->fecha_nacimiento)->age }} años)
                                </div>
                            @endif
                        </div>
                    </div>
                    
                    <!-- Sexo -->
                    <div class="bg-white rounded-xl p-6 border border-gray-200 hover:shadow-lg hover:border-gray-300 hover:-translate-y-1 transition-all duration-300 group">
                        <div class="flex items-center text-sm font-semibold text-gray-600 mb-3">
                            <div class="w-8 h-8 bg-purple-100 rounded-lg flex items-center justify-center mr-3 group-hover:bg-purple-200 transition-colors">
                                <svg class="w-4 h-4 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                                </svg>
                            </div>
                            Sexo
                        </div>
                        <div class="text-gray-900 font-medium text-sm">{{ $alumno->sexo ?? 'No especificado' }}</div>
                    </div>
                    
                    <!-- Nivel Formativo -->
                    <div class="bg-white rounded-xl p-6 border border-gray-200 hover:shadow-lg hover:border-gray-300 hover:-translate-y-1 transition-all duration-300 group">
                        <div class="flex items-center text-sm font-semibold text-gray-600 mb-3">
                            <div class="w-8 h-8 bg-indigo-100 rounded-lg flex items-center justify-center mr-3 group-hover:bg-indigo-200 transition-colors">
                                <svg class="w-4 h-4 text-indigo-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 14l9-5-9-5-9 5 9 5z"></path>
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 14l9-5-9-5-9 5 9 5zm0 0l6.16-3.422a12.083 12.083 0 01.665 6.479A11.952 11.952 0 0012 20.055a11.952 11.952 0 00-6.824-2.998 12.078 12.078 0 01.665-6.479L12 14z"></path>
                                </svg>
                            </div>
                            Nivel Formativo
                        </div>
                        <div class="text-gray-900 font-medium text-sm">{{ $alumno->nivel_formativo ?? 'No especificado' }}</div>
                    </div>
                    
                    <!-- Seguridad Social -->
                    <div class="bg-white rounded-xl p-6 border border-gray-200 hover:shadow-lg hover:border-gray-300 hover:-translate-y-1 transition-all duration-300 group">
                        <div class="flex items-center text-sm font-semibold text-gray-600 mb-3">
                            <div class="w-8 h-8 bg-red-100 rounded-lg flex items-center justify-center mr-3 group-hover:bg-red-200 transition-colors">
                                <svg class="w-4 h-4 text-red-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"></path>
                                </svg>
                            </div>
                            Seguridad Social
                        </div>
                        <div class="text-gray-900 font-medium text-sm">{{ $alumno->num_seguridad_social ?? 'No especificado' }}</div>
                    </div>
                    
                    <!-- Nacionalidad -->
                    <div class="bg-white rounded-xl p-6 border border-gray-200 hover:shadow-lg hover:border-gray-300 hover:-translate-y-1 transition-all duration-300 group">
                        <div class="flex items-center text-sm font-semibold text-gray-600 mb-3">
                            <div class="w-8 h-8 bg-yellow-100 rounded-lg flex items-center justify-center mr-3 group-hover:bg-yellow-200 transition-colors">
                                <svg class="w-4 h-4 text-yellow-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 21v-4m0 0V5a2 2 0 012-2h6.5l1 1H21l-3 6 3 6h-8.5l-1-1H5a2 2 0 00-2 2zm9-13.5V9"></path>
                                </svg>
                            </div>
                            Nacionalidad
                        </div>
                        <div class="text-gray-900 font-medium text-sm">{{ $alumno->nacionalidad ?? 'No especificada' }}</div>
                    </div>
                </div>
            </div>

            <!-- Contact Information -->
            <div>
                <h2 class="text-2xl font-bold text-gray-900 mb-6 flex items-center">
                    <div class="w-8 h-8 bg-blue-100 rounded-lg flex items-center justify-center mr-3">
                        <svg class="w-5 h-5 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"></path>
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"></path>
                        </svg>
                    </div>
                    Información de Contacto
                </h2>
                
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <!-- Address -->
                    <div class="bg-white rounded-xl p-6 border border-gray-200 hover:shadow-lg hover:border-gray-300 hover:-translate-y-1 transition-all duration-300 group">
                        <div class="flex items-center text-sm font-semibold text-gray-600 mb-3">
                            <div class="w-8 h-8 bg-green-100 rounded-lg flex items-center justify-center mr-3 group-hover:bg-green-200 transition-colors">
                                <svg class="w-4 h-4 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"></path>
                                </svg>
                            </div>
                            Dirección Completa
                        </div>
                        <div class="text-gray-900 font-medium">
                            <div class="mb-1">{{ $alumno->direccion ?? 'No especificada' }}</div>
                            @if($alumno->cp || $alumno->localidad || $alumno->provincia)
                                <div class="text-sm text-gray-600">
                                    {{ $alumno->cp }} {{ $alumno->localidad }}, {{ $alumno->provincia }}
                                </div>
                            @endif
                        </div>
                    </div>
                    
                    <!-- Phone -->
                    <div class="bg-white rounded-xl p-6 border border-gray-200 hover:shadow-lg hover:border-gray-300 hover:-translate-y-1 transition-all duration-300 group">
                        <div class="flex items-center text-sm font-semibold text-gray-600 mb-3">
                            <div class="w-8 h-8 bg-blue-100 rounded-lg flex items-center justify-center mr-3 group-hover:bg-blue-200 transition-colors">
                                <svg class="w-4 h-4 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"></path>
                                </svg>
                            </div>
                            Teléfono
                        </div>
                        <div class="text-gray-900 font-medium flex items-center justify-between">
                            <span>{{ $alumno->telefono ?? 'No especificado' }}</span>
                            @if($alumno->telefono)
                                <a href="tel:{{ $alumno->telefono }}" 
                                   class="p-2 text-blue-600 hover:text-blue-800 hover:bg-blue-50 rounded-lg transition-all duration-200">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"></path>
                                    </svg>
                                </a>
                            @endif
                        </div>
                    </div>
                </div>
            </div>

            <!-- Academic and Work Information -->
            <div>
                <h2 class="text-2xl font-bold text-gray-900 mb-6 flex items-center">
                    
                    <div class="w-8 h-8 bg-blue-100 rounded-lg flex items-center justify-center mr-3">
                <svg class="w-5 h-5 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 14l9-5-9-5-9 5 9 5z"></path>
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 14l6.16-3.422a12.083 12.083 0 01.665 6.479A11.952 11.952 0 0012 20.055a11.952 11.952 0 00-6.824-2.998 12.078 12.078 0 01.665-6.479L12 14z"></path>
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 14l9-5-9-5-9 5 9 5z"></path>
                </svg>
            </div>
                    Información Académica y Laboral
                </h2>
                
                <div class="bg-white rounded-xl p-6 border border-gray-200 hover:shadow-lg hover:border-gray-300 hover:-translate-y-1 transition-all duration-300 group">
                    <div class="flex items-center text-sm font-semibold text-gray-600 mb-3">
                    <div class="w-8 h-8 bg-orange-100 rounded-lg flex items-center justify-center mr-3 group-hover:bg-orange-200 transition-colors">
    <svg class="w-4 h-4 text-orange-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20.618 5.984A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016zM12 9v2m0 4h.01"></path>
    </svg>
</div>
                        Situación Laboral
                    </div>
                    <div class="text-gray-900 font-medium">{{ $alumno->situacion_laboral ?? 'No especificada' }}</div>
                </div>
            </div>

            <!-- Academic History -->
            <div>
                <h2 class="text-2xl font-bold text-gray-900 mb-6 flex items-center">
                    <div class="w-8 h-8 bg-blue-100 rounded-lg flex items-center justify-center mr-3">
                        <svg class="w-5 h-5 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"></path>
                        </svg>
                    </div>
                    Historial Académico
                </h2>
                
                
                @if ($alumno->relationLoaded('cursos') && $alumno->cursos->count() > 0)
                    <div class="space-y-4">
                        @foreach ($alumno->cursos as $cursoInscrito)
                            <div class="bg-white border border-gray-200 rounded-xl p-6 hover:shadow-lg hover:border-gray-300 transition-all duration-300">
                                <div class="flex flex-col md:flex-row md:items-center justify-between">

                                    {{-- Parte Izquierda: Nombre del Curso y Datos Pivote --}}
                                    <div class="flex-1">
                                        <h4 class="font-semibold text-gray-900 mb-3">
                                            <a href="{{ route('admin.cursos.show', $cursoInscrito->id) }}"
                                            class="text-blue-600 hover:text-blue-800 hover:underline transition-colors">
                                                {{ $cursoInscrito->nombre }}
                                            </a>
                                        </h4>
                                        <div class="flex flex-wrap items-center gap-4 text-sm text-gray-600">
                                            {{-- ... (tus spans para Estado y Nota se mantienen igual) ... --}}
                                            <span class="flex items-center bg-gray-50 px-3 py-1 rounded-lg">
                                                <i class="bi bi-check-circle-fill text-gray-500 mr-1.5"></i>
                                                Estado: <span class="font-medium text-gray-900 ml-1">{{ $cursoInscrito->pivot->estado ?? 'N/A' }}</span>
                                            </span>
                                            <span class="flex items-center bg-gray-50 px-3 py-1 rounded-lg">
                                                <i class="bi bi-star-fill text-gray-500 mr-1.5"></i>
                                                Nota: <span class="font-medium text-gray-900 ml-1">{{ $cursoInscrito->pivot->nota ?? 'N/A' }}</span>
                                            </span>
                                        </div>
                                    </div>

                                    {{-- Parte Derecha: Badge de Estado y NUEVO Botón de Desinscribir --}}
                                    <div class="mt-4 md:mt-0 md:ml-6 flex items-center space-x-3"> {{-- Contenedor para alinear Badge y Botón --}}
                                        {{-- Badge de Estado (Tu código original, sin cambios) --}}
                                        @php
                                        $estadoCurso = $cursoInscrito->pivot->estado ?? 'N/A';
                                        $badgeClasses = match($estadoCurso) {
                                            'Completado' => 'bg-green-100 text-green-800 border-green-200',
                                            'En Progreso' => 'bg-blue-100 text-blue-800 border-blue-200',
                                            'Abandonado' => 'bg-red-100 text-red-800 border-red-200',
                                            default => 'bg-gray-100 text-gray-800 border-gray-200'
                                        };
                                        @endphp
                                        <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-semibold border {{ $badgeClasses }}">
                                        {{ $estadoCurso }}
                                        </span>

                                        {{-- NUEVO: Formulario para Desinscribir de este curso --}}
                                        <form action="{{ route('admin.alumnos.cursos.desinscribir', ['alumno' => $alumno->id, 'curso' => $cursoInscrito->id]) }}"
      method="POST"
      onsubmit="return confirm('¿Seguro que quieres desinscribir a {{ $alumno->nombre }} del curso \'{{ addslashes($cursoInscrito->nombre) }}\'?');">
    @csrf
    @method('DELETE')

    {{-- BOTÓN MODIFICADO CON CLASES TAILWIND --}}
    <button type="submit"
            class="inline-flex items-center justify-center h-8 w-8 rounded-lg bg-red-500 text-white shadow-sm hover:bg-red-600 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-red-500 transition-all duration-200 group/btn"
            title="Desinscribir de este curso">
        <i class="bi bi-person-x-fill text-lg group-hover/btn:scale-110 transition-transform duration-200"></i>
    </button>

</form>
</form>

                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                @else    
                   <div class="text-center py-16 bg-gray-50 border-2 border-dashed border-gray-300 rounded-xl">
                       <div class="w-16 h-16 bg-gray-200 rounded-full flex items-center justify-center mx-auto mb-4">
                           <svg class="w-8 h-8 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                               <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"></path>
                           </svg>
                       </div>
                       <h3 class="text-lg font-medium text-gray-600 mb-2">Sin cursos registrados</h3>
                       <p class="text-gray-500 max-w-sm mx-auto">Este estudiante aún no tiene cursos asignados en el sistema.</p>
                   </div>
               @endif
           </div>
       </div>

       <!-- Sidebar -->
       <div class="lg:col-span-1 space-y-6 no-print">
           <!-- Quick Actions -->
           <div class="bg-white rounded-xl p-6 border border-gray-200 sticky top-8 shadow-sm">
               <h3 class="font-bold text-gray-800 mb-6 flex items-center">
                   <div class="w-6 h-6 bg-yellow-100 rounded-lg flex items-center justify-center mr-3">
                       <svg class="w-4 h-4 text-yellow-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                           <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"></path>
                       </svg>
                   </div>
                   Acciones Rápidas
               </h3>
               
               <div class="space-y-3">
                   <a href="{{ route('admin.alumnos.edit', $alumno->id) }}" 
                      class="flex items-center justify-center w-full px-4 py-3 bg-blue-600 hover:bg-blue-700 text-white font-semibold rounded-xl transition-all duration-200 transform hover:-translate-y-0.5 hover:shadow-lg group">
                       <svg class="w-4 h-4 mr-2 group-hover:scale-110 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                           <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path>
                       </svg>
                       Editar Perfil
                   </a>
                   
                   <button onclick="openEnrollModal('{{ $alumno->id }}')" 
                           class="flex items-center justify-center w-full px-4 py-3 bg-green-600 hover:bg-green-700 text-white font-semibold rounded-xl transition-all duration-200 transform hover:-translate-y-0.5 hover:shadow-lg group">
                       <svg class="w-4 h-4 mr-2 group-hover:scale-110 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                           <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path>
                       </svg>
                       Inscribir a Curso
                   </button>
                   
                   
                   <button onclick="printProfile()" 
                           class="flex items-center justify-center w-full px-4 py-3 bg-gray-100 hover:bg-gray-200 text-gray-700 font-semibold rounded-xl border border-gray-300 transition-all duration-200 transform hover:-translate-y-0.5 hover:shadow-md group">
                       <svg class="w-4 h-4 mr-2 group-hover:scale-110 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                           <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 17h2a2 2 0 002-2v-4a2 2 0 00-2-2H5a2 2 0 00-2 2v4a2 2 0 002 2h2m2 4h6a2 2 0 002-2v-4a2 2 0 00-2-2H9a2 2 0 00-2 2v4a2 2 0 002 2zm8-12V5a2 2 0 00-2-2H9a2 2 0 00-2 2v4h10z"></path>
                       </svg>
                       Imprimir Perfil
                   </button>
                   
                   <button onclick="exportProfile()" 
                           class="flex items-center justify-center w-full px-4 py-3 bg-gray-100 hover:bg-gray-200 text-gray-700 font-semibold rounded-xl border border-gray-300 transition-all duration-200 transform hover:-translate-y-0.5 hover:shadow-md group">
                       <svg class="w-4 h-4 mr-2 group-hover:scale-110 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                           <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                       </svg>
                       Exportar PDF
                   </button>
               </div>
               
               <!-- Contact Actions -->
               <div class="border-t border-gray-200 pt-6 mt-6">
                   <h4 class="font-semibold text-gray-700 mb-4 text-sm">Contacto Directo</h4>
                   
                   @if($alumno->email)
                   <a href="mailto:{{ $alumno->email }}" 
                      class="flex items-center justify-center w-full px-4 py-3 bg-gray-100 hover:bg-gray-200 text-gray-700 font-semibold rounded-xl border border-gray-300 transition-all duration-200 transform hover:-translate-y-0.5 mb-3 hover:shadow-md group">
                       <svg class="w-4 h-4 mr-2 group-hover:scale-110 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                           <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 4.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path>
                       </svg>
                       Enviar Email
                   </a>
                   @endif
                   
                   @if($alumno->telefono)
                   <a href="tel:{{ $alumno->telefono }}" 
                      class="flex items-center justify-center w-full px-4 py-3 bg-gray-100 hover:bg-gray-200 text-gray-700 font-semibold rounded-xl border border-gray-300 transition-all duration-200 transform hover:-translate-y-0.5 hover:shadow-md group">
                       <svg class="w-4 h-4 mr-2 group-hover:scale-110 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                           <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"></path>
                       </svg>
                       Llamar
                   </a>
                   @endif
               </div>
               

           <!-- Statistics -->
           <div class="border-t border-gray-200 pt-6 mt-6">
           <div class="bg-white rounded-xl p-6 border border-gray-200 shadow-sm">
               <h4 class="font-semibold text-gray-700 mb-6 flex items-center">
                   <div class="w-6 h-6 bg-blue-100 rounded-lg flex items-center justify-center mr-3">
                       <svg class="w-4 h-4 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                           <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"></path>
                       </svg>
                   </div>
                   Estadísticas
               </h4>
               
               <div class="space-y-4">
                   <div class="flex justify-between items-center">
                       <span class="text-sm text-gray-600">Cursos Totales:</span>
                       <span class="font-semibold text-gray-800 bg-gray-100 px-3 py-1.5 rounded-lg text-sm">
                           {{ $alumno->relationLoaded('cursos') ? $alumno->cursos->count() : 0 }}
                       </span>
                   </div>
                   
                   @if($alumno->relationLoaded('cursos') && $alumno->cursos->count() > 0)
                   <div class="flex justify-between items-center">
                       <span class="text-sm text-gray-600">Completados:</span>
                       <span class="font-semibold text-green-700 bg-green-100 px-3 py-1.5 rounded-lg text-sm">
                           {{ $alumno->cursos->where('pivot.estado', 'Completado')->count() }}
                       </span>
                   </div>
                   
                   <div class="flex justify-between items-center">
                       <span class="text-sm text-gray-600">En Progreso:</span>
                       <span class="font-semibold text-blue-700 bg-blue-100 px-3 py-1.5 rounded-lg text-sm">
                           {{ $alumno->cursos->where('pivot.estado', 'En Progreso')->count() }}
                       </span>
                   </div>
                   
                   @php
                       $notasNumericas = $alumno->cursos
                           ->pluck('pivot.nota')
                           ->filter(function($nota) {
                               return is_numeric($nota);
                           });
                       $promedioNotas = $notasNumericas->count() > 0 ? $notasNumericas->avg() : null;
                   @endphp
                   
                   @if($promedioNotas)
                   <div class="flex justify-between items-center">
                       <span class="text-sm text-gray-600">Promedio:</span>
                       @php
                           $promedioColor = $promedioNotas >= 7 ? 'text-green-700 bg-green-100' : ($promedioNotas >= 5 ? 'text-yellow-700 bg-yellow-100' : 'text-red-700 bg-red-100');
                       @endphp
                       <span class="font-semibold px-3 py-1.5 rounded-lg text-sm {{ $promedioColor }}">
                           {{ number_format($promedioNotas, 1) }}
                       </span>
                   </div>
                   @endif
                   @endif
               </div>
           </div>
           <!-- Navigation -->
           <div class="border-t border-gray-200 pt-6 mt-6">
               <h4 class="font-semibold text-gray-700 mb-4 flex items-center">
                   <div class="w-6 h-6 bg-gray-100 rounded-lg flex items-center justify-center mr-3">
                       <svg class="w-4 h-4 text-gray-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                           <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 16l-4-4m0 0l4-4m-4 4h18"></path>
                       </svg>
                   </div>
                   Navegación
               </h4>
               
               <a href="{{ route('admin.alumnos.index') }}" 
                  class="flex items-center justify-center w-full px-4 py-3 bg-gray-100 hover:bg-gray-200 text-gray-700 font-semibold rounded-xl border border-gray-300 transition-all duration-200 transform hover:-translate-y-0.5 hover:shadow-md group">
                   <svg class="w-4 h-4 mr-2 group-hover:scale-110 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                       <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 16l-4-4m0 0l4-4m-4 4h18"></path>
                   </svg>
                   Volver a Lista
               </a>
           
           </div>
           
       </div>
   </div>
</div>
<!-- Modal para Inscribir Alumno a Curso -->
<div id="enrollModal" class="fixed inset-0 bg-gray-600 bg-opacity-50 overflow-y-auto h-full w-full z-50 hidden">
    <div class="relative top-20 mx-auto p-5 border w-full max-w-lg shadow-lg rounded-xl bg-white">
        <div class="mt-3">
            <div class="flex justify-between items-center mb-4">
                <h3 class="text-lg font-semibold text-gray-900">Inscribir Alumno a un Curso</h3>
                <button onclick="closeEnrollModal()" class="text-gray-400 hover:text-gray-600">×</button>
            </div>

            <form id="enrollForm" method="POST"> {{-- La action se establecerá con JS --}}
                @csrf
                <div class="space-y-4">
                    <div>
                        <label for="curso_id" class="block text-sm font-medium text-gray-700">Seleccionar Curso <span class="text-red-500">*</span></label>
                        <select name="curso_id" id="curso_id_select" required
                                class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm">
                            <option value="">Cargando cursos disponibles...</option>
                            {{-- Las opciones se llenarán con JavaScript --}}
                        </select>
                    </div>
                     {{-- Puedes añadir más campos si son necesarios, ej: estado inicial de la inscripción --}}
                     <div>
                        <label for="enroll_status" class="block text-sm font-medium text-gray-700">Estado de la Inscripción</label>
                        <select name="estado" id="enroll_status" class="mt-1 block w-full ...">
                            <option value="Inscrito" selected>Inscrito</option>
                            <option value="Pendiente">Pendiente</option>
                        </select>
                     </div>
                </div>
                <div class="mt-6 flex justify-end space-x-3">
                    <button type="button" onclick="closeEnrollModal()" class="btn-secondary-tailwind">Cancelar</button>
                    <button type="submit" class="btn-indigo-tailwind">Inscribir</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
    const enrollModal = document.getElementById('enrollModal');
    const enrollForm = document.getElementById('enrollForm');
    const cursoSelect = document.getElementById('curso_id_select');

    function openEnrollModal(alumnoId) {
        if (!enrollModal || !enrollForm || !cursoSelect) {
            console.error("Elementos del modal de inscripción no encontrados.");
            return;
        }

        // Establecer la acción del formulario
        const actionUrl = `{{ route('admin.alumnos.cursos.inscribir', ['alumno' => ':id']) }}`.replace(':id', alumnoId);
        enrollForm.action = actionUrl;

        // Limpiar y mostrar "cargando" en el select
        cursoSelect.innerHTML = '<option value="">Cargando cursos...</option>';
        cursoSelect.disabled = true;

        // Mostrar el modal
        enrollModal.classList.remove('hidden');

        // Obtener los cursos disponibles vía AJAX
        const cursosDisponiblesUrl = `{{ route('admin.alumnos.cursos.disponibles', ['alumno' => ':id']) }}`.replace(':id', alumnoId);
        fetch(cursosDisponiblesUrl)
            .then(response => response.json())
            .then(data => {
                cursoSelect.innerHTML = '<option value="" disabled selected>Selecciona un curso</option>'; // Opción por defecto
                if (data.length > 0) {
                    data.forEach(curso => {
                        const option = document.createElement('option');
                        option.value = curso.id;
                        option.textContent = curso.nombre;
                        cursoSelect.appendChild(option);
                    });
                } else {
                     cursoSelect.innerHTML = '<option value="">No hay cursos disponibles para este alumno</option>';
                }
                cursoSelect.disabled = false;
            })
            .catch(error => {
                console.error('Error al cargar los cursos:', error);
                cursoSelect.innerHTML = '<option value="">Error al cargar cursos</option>';
            });
    }

    function closeEnrollModal() {
        if (enrollModal) {
            enrollModal.classList.add('hidden');
        }
    }

    function printProfile() {
       window.print();
   }
   
   function exportProfile() {
       // Puedes implementar la funcionalidad de exportación PDF aquí
       alert('Funcionalidad de exportación a PDF a implementar');
   }
    
</script>
@endpush
   
   