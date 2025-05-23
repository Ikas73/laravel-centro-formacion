@extends('layouts.admin')

@section('title', 'Perfil de ' . $alumno->nombre . ' ' . $alumno->apellido1)
@section('page-title', 'Perfil del Estudiante')

@push('styles')
<style>
    /* Solo estilos mínimos que no se pueden lograr con Tailwind */
    .student-card-gradient {
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
    }
    
    .student-card-bg::before {
        content: '';
        position: absolute;
        top: -50%;
        right: -50%;
        width: 100%;
        height: 100%;
        background: rgba(255, 255, 255, 0.1);
        border-radius: 50%;
        transform: rotate(45deg);
    }
    
    @media print {
        .no-print { display: none !important; }
        .print-friendly { background: #f8fafc !important; color: #1e293b !important; }
    }
</style>
@endpush

@section('content')
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
    <!-- Student Header Card -->
    <div class="student-card-gradient rounded-3xl p-6 md:p-8 text-white mb-8 relative overflow-hidden student-card-bg">
        <div class="flex flex-col md:flex-row items-center md:items-start relative z-10">
            <!-- Avatar -->
            <div class="flex-shrink-0 mb-6 md:mb-0 md:mr-8">
                <img class="w-28 h-28 md:w-32 md:h-32 rounded-full border-4 border-white/30 shadow-2xl object-cover"
                     src="https://ui-avatars.com/api/?name={{ urlencode($alumno->nombre . ' ' . $alumno->apellido1) }}&size=200&color=ffffff&background=6366f1&font-size=0.5"
                     alt="Avatar de {{ $alumno->nombre }}">
            </div>

            <!-- Student Info -->
            <div class="flex-1 text-center md:text-left">
                <h1 class="text-3xl md:text-4xl font-bold mb-2">
                    {{ $alumno->nombre }} {{ $alumno->apellido1 }} {{ $alumno->apellido2 ?? '' }}
                </h1>
                <p class="text-lg opacity-90 mb-4 flex items-center justify-center md:justify-start">
                    <i class="bi bi-credit-card-2-front mr-2"></i>
                    ID: {{ $alumno->dni ?? 'N/A' }}
                </p>

                <div class="flex flex-col md:flex-row items-center md:items-start space-y-3 md:space-y-0 md:space-x-6">
                    <!-- Status Badge -->
                    <div>
                        @php
                            $estado = $alumno->estado ?? 'Desconocido';
                            $statusClasses = match($estado) {
                                'Activo' => 'bg-green-100 text-green-800 border-green-200',
                                'Inactivo' => 'bg-red-100 text-red-800 border-red-200',
                                'Pendiente' => 'bg-yellow-100 text-yellow-800 border-yellow-200',
                                'Baja' => 'bg-purple-100 text-purple-800 border-purple-200',
                                default => 'bg-gray-100 text-gray-800 border-gray-200'
                            };
                        @endphp
                        <span class="inline-flex items-center px-4 py-2 rounded-full text-sm font-semibold uppercase tracking-wide border {{ $statusClasses }}">
                            <i class="bi bi-circle-fill mr-2 text-xs"></i>
                            {{ $estado }}
                        </span>
                    </div>

                    <!-- Contact Info -->
                    @if($alumno->email)
                        <div class="flex items-center opacity-90">
                            <i class="bi bi-envelope mr-2"></i>
                            <span>{{ $alumno->email }}</span>
                        </div>
                    @endif

                    @if($alumno->telefono)
                        <div class="flex items-center opacity-90">
                            <i class="bi bi-telephone mr-2"></i>
                            <span>{{ $alumno->telefono }}</span>
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
                    <i class="bi bi-person-circle mr-3 text-blue-600"></i>
                    Información Personal
                </h2>

                <div class="grid grid-cols-1 md:grid-cols-2 xl:grid-cols-3 gap-4">
                    <!-- Email -->
                    <div class="bg-white rounded-2xl p-6 border border-gray-200 hover:shadow-lg hover:-translate-y-1 transition-all duration-300">
                        <div class="flex items-center text-sm font-semibold text-gray-600 mb-2">
                            <i class="bi bi-envelope-fill mr-2 text-blue-500"></i>
                            Email
                        </div>
                        <div class="text-gray-900 font-medium break-words">{{ $alumno->email ?? 'No especificado' }}</div>
                    </div>

                    <!-- Fecha de Nacimiento -->
                    <div class="bg-white rounded-2xl p-6 border border-gray-200 hover:shadow-lg hover:-translate-y-1 transition-all duration-300">
                        <div class="flex items-center text-sm font-semibold text-gray-600 mb-2">
                            <i class="bi bi-calendar-date mr-2 text-green-500"></i>
                            Fecha de Nacimiento
                        </div>
                        <div class="text-gray-900 font-medium">
                            {{ $alumno->fecha_nacimiento ? \Carbon\Carbon::parse($alumno->fecha_nacimiento)->format('d/m/Y') : 'No especificada' }}
                            @if($alumno->fecha_nacimiento)
                                <div class="text-sm text-gray-500 mt-1">
                                    ({{ \Carbon\Carbon::parse($alumno->fecha_nacimiento)->age }} años)
                                </div>
                            @endif
                        </div>
                    </div>

                    <!-- Sexo -->
                    <div class="bg-white rounded-2xl p-6 border border-gray-200 hover:shadow-lg hover:-translate-y-1 transition-all duration-300">
                        <div class="flex items-center text-sm font-semibold text-gray-600 mb-2">
                            <i class="bi bi-gender-ambiguous mr-2 text-purple-500"></i>
                            Sexo
                        </div>
                        <div class="text-gray-900 font-medium">{{ $alumno->sexo ?? 'No especificado' }}</div>
                    </div>

                    <!-- Nivel Formativo -->
                    <div class="bg-white rounded-2xl p-6 border border-gray-200 hover:shadow-lg hover:-translate-y-1 transition-all duration-300">
                        <div class="flex items-center text-sm font-semibold text-gray-600 mb-2">
                            <i class="bi bi-mortarboard-fill mr-2 text-indigo-500"></i>
                            Nivel Formativo
                        </div>
                        <div class="text-gray-900 font-medium">{{ $alumno->nivel_formativo ?? 'No especificado' }}</div>
                    </div>

                    <!-- Seguridad Social -->
                    <div class="bg-white rounded-2xl p-6 border border-gray-200 hover:shadow-lg hover:-translate-y-1 transition-all duration-300">
                        <div class="flex items-center text-sm font-semibold text-gray-600 mb-2">
                            <i class="bi bi-shield-check mr-2 text-red-500"></i>
                            Seguridad Social
                        </div>
                        <div class="text-gray-900 font-medium">{{ $alumno->num_seguridad_social ?? 'No especificado' }}</div>
                    </div>

                    <!-- Nacionalidad -->
                    <div class="bg-white rounded-2xl p-6 border border-gray-200 hover:shadow-lg hover:-translate-y-1 transition-all duration-300">
                        <div class="flex items-center text-sm font-semibold text-gray-600 mb-2">
                            <i class="bi bi-flag-fill mr-2 text-yellow-500"></i>
                            Nacionalidad
                        </div>
                        <div class="text-gray-900 font-medium">{{ $alumno->nacionalidad ?? 'No especificada' }}</div>
                    </div>
                </div>
            </div>

            <!-- Contact Information -->
            <div>
                <h2 class="text-2xl font-bold text-gray-900 mb-6 flex items-center">
                    <i class="bi bi-geo-alt-fill mr-3 text-blue-600"></i>
                    Información de Contacto
                </h2>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <!-- Address -->
                    <div class="bg-white rounded-2xl p-6 border border-gray-200 hover:shadow-lg hover:-translate-y-1 transition-all duration-300">
                        <div class="flex items-center text-sm font-semibold text-gray-600 mb-2">
                            <i class="bi bi-house-door-fill mr-2 text-green-500"></i>
                            Dirección Completa
                        </div>
                        <div class="text-gray-900 font-medium">
                            {{ $alumno->direccion ?? 'No especificada' }}
                            @if($alumno->cp || $alumno->localidad || $alumno->provincia)
                                <br>
                                <span class="text-sm text-gray-600">
                                    {{ $alumno->cp }} {{ $alumno->localidad }}, {{ $alumno->provincia }}
                                </span>
                            @endif
                        </div>
                    </div>

                    <!-- Phone -->
                    <div class="bg-white rounded-2xl p-6 border border-gray-200 hover:shadow-lg hover:-translate-y-1 transition-all duration-300">
                        <div class="flex items-center text-sm font-semibold text-gray-600 mb-2">
                            <i class="bi bi-telephone-fill mr-2 text-blue-500"></i>
                            Teléfono
                        </div>
                        <div class="text-gray-900 font-medium flex items-center">
                            {{ $alumno->telefono ?? 'No especificado' }}
                            @if($alumno->telefono)
                                <a href="tel:{{ $alumno->telefono }}" class="ml-2 text-blue-600 hover:text-blue-800 transition-colors">
                                    <i class="bi bi-telephone-outbound"></i>
                                </a>
                            @endif
                        </div>
                    </div>
                </div>
            </div>

            <!-- Academic and Work Information -->
            <div>
                <h2 class="text-2xl font-bold text-gray-900 mb-6 flex items-center">
                    <i class="bi bi-briefcase-fill mr-3 text-blue-600"></i>
                    Información Académica y Laboral
                </h2>

                <div class="bg-white rounded-2xl p-6 border border-gray-200 hover:shadow-lg hover:-translate-y-1 transition-all duration-300">
                    <div class="flex items-center text-sm font-semibold text-gray-600 mb-2">
                        <i class="bi bi-person-workspace mr-2 text-orange-500"></i>
                        Situación Laboral
                    </div>
                    <div class="text-gray-900 font-medium">{{ $alumno->situacion_laboral ?? 'No especificada' }}</div>
                </div>
            </div>

            <!-- Academic History -->
            <div>
                <h2 class="text-2xl font-bold text-gray-900 mb-6 flex items-center">
                    <i class="bi bi-journal-bookmark-fill mr-3 text-blue-600"></i>
                    Historial Académico
                </h2>

                @if ($alumno->relationLoaded('cursos') && $alumno->cursos->count() > 0)
                    <div class="space-y-4">
                        @foreach ($alumno->cursos as $cursoInscrito)
                            <div class="bg-gray-50 border border-gray-200 rounded-xl p-4 hover:bg-gray-100 hover:border-gray-300 transition-all duration-200">
                                <div class="flex flex-col md:flex-row md:items-center justify-between">
                                    <div class="flex-1">
                                        <h4 class="font-semibold text-gray-900 mb-2">
                                            <a href="{{ route('admin.cursos.show', $cursoInscrito->id) }}"
                                               class="text-blue-600 hover:text-blue-800 hover:underline transition-colors">
                                                {{ $cursoInscrito->nombre }}
                                            </a>
                                        </h4>
                                        <div class="flex flex-wrap items-center gap-4 text-sm text-gray-600">
                                            <span class="flex items-center">
                                                <i class="bi bi-calendar-check mr-1"></i>
                                                Estado: <strong class="ml-1 text-gray-900">{{ $cursoInscrito->pivot->estado ?? 'N/A' }}</strong>
                                            </span>
                                            <span class="flex items-center">
                                                <i class="bi bi-award mr-1"></i>
                                                Nota: <strong class="ml-1 text-gray-900">{{ $cursoInscrito->pivot->nota ?? 'N/A' }}</strong>
                                            </span>
                                        </div>
                                    </div>
                                    <div class="mt-3 md:mt-0 md:ml-4">
                                        @php
                                            $estadoCurso = $cursoInscrito->pivot->estado ?? 'N/A';
                                            $badgeClasses = match($estadoCurso) {
                                                'Completado' => 'bg-green-100 text-green-800',
                                                'En Progreso' => 'bg-blue-100 text-blue-800',
                                                'Abandonado' => 'bg-red-100 text-red-800',
                                                default => 'bg-gray-100 text-gray-800'
                                            };
                                        @endphp
                                        <span class="px-3 py-1 rounded-full text-xs font-semibold {{ $badgeClasses }}">
                                            {{ $estadoCurso }}
                                        </span>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                @elseif($alumno->relationLoaded('cursos'))
                    <div class="text-center py-12 bg-gray-50 border-2 border-dashed border-gray-300 rounded-xl">
                        <i class="bi bi-journal-x text-4xl text-gray-400 mb-4"></i>
                        <h3 class="text-lg font-medium text-gray-600 mb-2">Sin cursos registrados</h3>
                        <p class="text-gray-500">Este estudiante aún no tiene cursos asignados en el sistema.</p>
                    </div>
                @endif
            </div>
        </div>

        <!-- Sidebar -->
        <div class="lg:col-span-1 space-y-6 no-print">
            <!-- Quick Actions -->
            <div class="bg-white rounded-2xl p-6 border border-gray-200 sticky top-8">
                <h3 class="font-bold text-gray-800 mb-4 flex items-center">
                    <i class="bi bi-lightning-charge-fill mr-2 text-yellow-500"></i>
                    Acciones Rápidas
                </h3>

                <div class="space-y-3">
                    <a href="{{ route('admin.alumnos.edit', $alumno->id) }}" 
                       class="flex items-center justify-center w-full px-4 py-3 bg-blue-600 hover:bg-blue-700 text-white font-semibold rounded-xl transition-all duration-200 hover:-translate-y-0.5 hover:shadow-lg">
                        <i class="bi bi-pencil-square mr-2"></i>
                        Editar Perfil
                    </a>

                    <button onclick="handleEnrollStudent()" 
                            class="flex items-center justify-center w-full px-4 py-3 bg-green-600 hover:bg-green-700 text-white font-semibold rounded-xl transition-all duration-200 hover:-translate-y-0.5 hover:shadow-lg">
                        <i class="bi bi-plus-circle mr-2"></i>
                        Inscribir a Curso
                    </button>

                    <button onclick="printProfile()" 
                            class="flex items-center justify-center w-full px-4 py-3 bg-gray-100 hover:bg-gray-200 text-gray-700 font-semibold rounded-xl border border-gray-300 transition-all duration-200 hover:-translate-y-0.5">
                        <i class="bi bi-printer mr-2"></i>
                        Imprimir Perfil
                    </button>

                    <button onclick="exportProfile()" 
                            class="flex items-center justify-center w-full px-4 py-3 bg-gray-100 hover:bg-gray-200 text-gray-700 font-semibold rounded-xl border border-gray-300 transition-all duration-200 hover:-translate-y-0.5">
                        <i class="bi bi-download mr-2"></i>
                        Exportar PDF
                    </button>
                </div>

                <!-- Contact Actions -->
                <div class="border-t border-gray-200 pt-4 mt-6">
                    <a href="mailto:{{ $alumno->email }}" 
                       class="flex items-center justify-center w-full px-4 py-3 bg-gray-100 hover:bg-gray-200 text-gray-700 font-semibold rounded-xl border border-gray-300 transition-all duration-200 hover:-translate-y-0.5 mb-3">
                        <i class="bi bi-envelope mr-2"></i>
                        Enviar Email
                    </a>

                    @if($alumno->telefono)
                    <a href="tel:{{ $alumno->telefono }}" 
                       class="flex items-center justify-center w-full px-4 py-3 bg-gray-100 hover:bg-gray-200 text-gray-700 font-semibold rounded-xl border border-gray-300 transition-all duration-200 hover:-translate-y-0.5">
                        <i class="bi bi-telephone mr-2"></i>
                        Llamar
                    </a>
                    @endif
                </div>
            </div>

            <!-- Statistics -->
            <div class="bg-white rounded-2xl p-6 border border-gray-200">
                <h4 class="font-semibold text-gray-700 mb-4 flex items-center">
                    <i class="bi bi-graph-up mr-2 text-blue-500"></i>
                    Estadísticas
                </h4>

                <div class="space-y-3">
                    <div class="flex justify-between items-center">
                        <span class="text-sm text-gray-600">Cursos Totales:</span>
                        <span class="font-semibold text-gray-800 bg-gray-100 px-2 py-1 rounded-lg">
                            {{ $alumno->relationLoaded('cursos') ? $alumno->cursos->count() : 0 }}
                        </span>
                    </div>

                    @if($alumno->relationLoaded('cursos') && $alumno->cursos->count() > 0)
                    <div class="flex justify-between items-center">
                        <span class="text-sm text-gray-600">Completados:</span>
                        <span class="font-semibold text-green-600 bg-green-100 px-2 py-1 rounded-lg">
                            {{ $alumno->cursos->where('pivot.estado', 'Completado')->count() }}
                        </span>
                    </div>

                    <div class="flex justify-between items-center">
                        <span class="text-sm text-gray-600">En Progreso:</span>
                        <span class="font-semibold text-blue-600 bg-blue-100 px-2 py-1 rounded-lg">
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
                            $promedioColor = $promedioNotas >= 7 ? 'text-green-600 bg-green-100' : ($promedioNotas >= 5 ? 'text-yellow-600 bg-yellow-100' : 'text-red-600 bg-red-100');
                        @endphp
                        <span class="font-semibold px-2 py-1 rounded-lg {{ $promedioColor }}">
                            {{ number_format($promedioNotas, 1) }}
                        </span>
                    </div>
                    @endif
                    @endif
                </div>
            </div>

            <!-- Navigation -->
            <div class="bg-white rounded-2xl p-6 border border-gray-200">
                <h4 class="font-semibold text-gray-700 mb-4 flex items-center">
                    <i class="bi bi-arrow-left-right mr-2 text-gray-500"></i>
                    Navegación
                </h4>

                <a href="{{ route('admin.alumnos.index') }}" 
                   class="flex items-center justify-center w-full px-4 py-3 bg-gray-100 hover:bg-gray-200 text-gray-700 font-semibold rounded-xl border border-gray-300 transition-all duration-200 hover:-translate-y-0.5">
                    <i class="bi bi-arrow-left mr-2"></i>
                    Volver a Lista
                </a>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
    function handleEnrollStudent() {
        alert('Funcionalidad de inscripción a implementar');
    }

    function printProfile() {
        window.print();
    }

    function exportProfile() {
        alert('Funcionalidad de exportación a PDF a implementar');
    }
</script>
@endpush