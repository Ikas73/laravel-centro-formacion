@extends('layouts.admin')

@section('title', 'Perfil de ' . $alumno->nombre . ' ' . $alumno->apellido1)
@section('page-title', 'Perfil del Estudiante')

@push('styles')
<style>
    .student-card {
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        border-radius: 20px;
        padding: 2rem;
        color: white;
        margin-bottom: 2rem;
        position: relative;
        overflow: hidden;
    }

    .student-card::before {
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

    .info-card {
        background: white;
        border-radius: 16px;
        padding: 1.5rem;
        box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1);
        border: 1px solid #e2e8f0;
        transition: all 0.3s ease;
        height: 100%;
    }

    .info-card:hover {
        transform: translateY(-2px);
        box-shadow: 0 8px 25px -5px rgba(0, 0, 0, 0.15);
    }

    .info-label {
        font-size: 0.875rem;
        font-weight: 600;
        color: #64748b;
        margin-bottom: 0.5rem;
        display: flex;
        align-items: center;
    }

    .info-value {
        font-size: 1rem;
        font-weight: 500;
        color: #1e293b;
        word-break: break-word;
    }

    .status-badge {
        display: inline-flex;
        align-items: center;
        padding: 0.5rem 1rem;
        border-radius: 50px;
        font-size: 0.875rem;
        font-weight: 600;
        text-transform: uppercase;
        letter-spacing: 0.025em;
    }

    .status-active {
        background: #dcfce7;
        color: #166534;
        border: 1px solid #bbf7d0;
    }

    .status-inactive {
        background: #fee2e2;
        color: #991b1b;
        border: 1px solid #fecaca;
    }

    .status-pending {
        background: #fef3c7;
        color: #92400e;
        border: 1px solid #fde68a;
    }

    .status-baja {
        background: #f3e8ff;
        color: #7c2d12;
        border: 1px solid #e9d5ff;
    }

    .course-card {
        background: #f8fafc;
        border: 1px solid #e2e8f0;
        border-radius: 12px;
        padding: 1rem;
        margin-bottom: 0.75rem;
        transition: all 0.2s ease;
    }

    .course-card:hover {
        background: #f1f5f9;
        border-color: #cbd5e1;
    }

    .quick-actions {
        position: sticky;
        top: 2rem;
        background: white;
        border-radius: 16px;
        padding: 1.5rem;
        box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1);
        border: 1px solid #e2e8f0;
    }

    .action-btn {
        display: flex;
        align-items: center;
        justify-content: center;
        width: 100%;
        padding: 0.75rem 1rem;
        margin-bottom: 0.75rem;
        border-radius: 10px;
        font-weight: 600;
        text-decoration: none;
        transition: all 0.2s ease;
        border: 2px solid transparent;
    }

    .action-btn:last-child {
        margin-bottom: 0;
    }

    .btn-primary {
        background: #3b82f6;
        color: white;
    }

    .btn-primary:hover {
        background: #2563eb;
        transform: translateY(-1px);
        box-shadow: 0 4px 12px rgba(59, 130, 246, 0.4);
    }

    .btn-secondary {
        background: #f8fafc;
        color: #475569;
        border-color: #e2e8f0;
    }

    .btn-secondary:hover {
        background: #f1f5f9;
        border-color: #cbd5e1;
        transform: translateY(-1px);
    }

    .btn-success {
        background: #10b981;
        color: white;
    }

    .btn-success:hover {
        background: #059669;
        transform: translateY(-1px);
        box-shadow: 0 4px 12px rgba(16, 185, 129, 0.4);
    }

    .section-title {
        font-size: 1.5rem;
        font-weight: 700;
        color: #1e293b;
        margin-bottom: 1.5rem;
        display: flex;
        align-items: center;
    }

    .section-title i {
        margin-right: 0.75rem;
        color: #3b82f6;
    }

    .empty-state {
        text-align: center;
        padding: 3rem;
        background: #f8fafc;
        border: 2px dashed #cbd5e1;
        border-radius: 12px;
        color: #64748b;
    }

    .avatar-lg {
        width: 120px;
        height: 120px;
        border-radius: 50%;
        border: 4px solid rgba(255, 255, 255, 0.3);
        box-shadow: 0 8px 32px rgba(0, 0, 0, 0.2);
    }

    @media (max-width: 768px) {
        .student-card {
            padding: 1.5rem;
            text-align: center;
        }

        .info-card {
            margin-bottom: 1rem;
        }
    }
</style>
@endpush

@section('content')
<div class="max-w-7xl mx-auto">
    <div class="student-card">
        <div class="flex flex-col md:flex-row items-center md:items-start relative z-10">
            <div class="flex-shrink-0 mb-6 md:mb-0 md:mr-8">
                <img class="avatar-lg object-cover"
                     src="https://ui-avatars.com/api/?name={{ urlencode($alumno->nombre . ' ' . $alumno->apellido1) }}&size=200&color=ffffff&background=6366f1&font-size=0.5"
                     alt="Avatar de {{ $alumno->nombre }}">
            </div>

            <div class="flex-1 text-center md:text-left">
                <h1 class="text-3xl md:text-4xl font-bold mb-2">
                    {{ $alumno->nombre }} {{ $alumno->apellido1 }} {{ $alumno->apellido2 ?? '' }}
                </h1>
                <p class="text-lg opacity-90 mb-4">
                    <i class="bi bi-credit-card-2-front mr-2"></i>
                    ID: {{ $alumno->dni ?? 'N/A' }}
                </p>

                <div class="flex flex-col md:flex-row items-center md:items-start space-y-3 md:space-y-0 md:space-x-6">
                    <div>
                        @php
                            $estado = $alumno->estado ?? 'Desconocido';
                            $statusClass = 'status-badge ';
                            switch ($estado) {
                                case 'Activo': $statusClass .= 'status-active'; break;
                                case 'Inactivo': $statusClass .= 'status-inactive'; break;
                                case 'Pendiente': $statusClass .= 'status-pending'; break;
                                case 'Baja': $statusClass .= 'status-baja'; break;
                                default: $statusClass .= 'status-inactive';
                            }
                        @endphp
                        <span class="{{ $statusClass }}">
                            <i class="bi bi-circle-fill mr-1" style="font-size: 0.5rem;"></i>
                            {{ $estado }}
                        </span>
                    </div>

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
        <div class="lg:col-span-3 space-y-6">
            <div>
                <h2 class="section-title">
                    <i class="bi bi-person-circle"></i>
                    Información Personal
                </h2>

                <div class="grid grid-cols-1 md:grid-cols-2 xl:grid-cols-3 gap-4">
                    <div class="info-card">
                        <div class="info-label">
                            <i class="bi bi-envelope-fill mr-2 text-blue-500"></i>
                            Email
                        </div>
                        <div class="info-value">{{ $alumno->email ?? 'No especificado' }}</div>
                    </div>

                    <div class="info-card">
                        <div class="info-label">
                            <i class="bi bi-calendar-date mr-2 text-green-500"></i>
                            Fecha de Nacimiento
                        </div>
                        <div class="info-value">
                            {{ $alumno->fecha_nacimiento ? \Carbon\Carbon::parse($alumno->fecha_nacimiento)->format('d/m/Y') : 'No especificada' }}
                            @if($alumno->fecha_nacimiento)
                                <div class="text-sm text-gray-500 mt-1">
                                    ({{ \Carbon\Carbon::parse($alumno->fecha_nacimiento)->age }} años)
                                </div>
                            @endif
                        </div>
                    </div>

                    <div class="info-card">
                        <div class="info-label">
                            <i class="bi bi-gender-ambiguous mr-2 text-purple-500"></i>
                            Sexo
                        </div>
                        <div class="info-value">{{ $alumno->sexo ?? 'No especificado' }}</div>
                    </div>

                    <div class="info-card">
                        <div class="info-label">
                            <i class="bi bi-mortarboard-fill mr-2 text-indigo-500"></i>
                            Nivel Formativo
                        </div>
                        <div class="info-value">{{ $alumno->nivel_formativo ?? 'No especificado' }}</div>
                    </div>

                    <div class="info-card">
                        <div class="info-label">
                            <i class="bi bi-shield-check mr-2 text-red-500"></i>
                            Seguridad Social
                        </div>
                        <div class="info-value">{{ $alumno->num_seguridad_social ?? 'No especificado' }}</div>
                    </div>

                    <div class="info-card">
                        <div class="info-label">
                            <i class="bi bi-flag-fill mr-2 text-yellow-500"></i>
                            Nacionalidad
                        </div>
                        <div class="info-value">{{ $alumno->nacionalidad ?? 'No especificada' }}</div>
                    </div>
                </div>
            </div>

            <div>
                <h2 class="section-title">
                    <i class="bi bi-geo-alt-fill"></i>
                    Información de Contacto
                </h2>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div class="info-card">
                        <div class="info-label">
                            <i class="bi bi-house-door-fill mr-2 text-green-500"></i>
                            Dirección Completa
                        </div>
                        <div class="info-value">
                            {{ $alumno->direccion ?? 'No especificada' }}
                            @if($alumno->cp || $alumno->localidad || $alumno->provincia)
                                <br>
                                <span class="text-sm text-gray-600">
                                    {{ $alumno->cp }} {{ $alumno->localidad }}, {{ $alumno->provincia }}
                                </span>
                            @endif
                        </div>
                    </div>

                    <div class="info-card">
                        <div class="info-label">
                            <i class="bi bi-telephone-fill mr-2 text-blue-500"></i>
                            Teléfono
                        </div>
                        <div class="info-value">
                            {{ $alumno->telefono ?? 'No especificado' }}
                            @if($alumno->telefono)
                                <a href="tel:{{ $alumno->telefono }}" class="ml-2 text-blue-600 hover:text-blue-800">
                                    <i class="bi bi-telephone-outbound"></i>
                                </a>
                            @endif
                        </div>
                    </div>
                </div>
            </div>

            <div>
                <h2 class="section-title">
                    <i class="bi bi-briefcase-fill"></i>
                    Información Académica y Laboral
                </h2>

                <div class="info-card">
                    <div class="info-label">
                        <i class="bi bi-person-workspace mr-2 text-orange-500"></i>
                        Situación Laboral
                    </div>
                    <div class="info-value">{{ $alumno->situacion_laboral ?? 'No especificada' }}</div>
                </div>
            </div>

            <div>
                <h2 class="section-title">
                    <i class="bi bi-journal-bookmark-fill"></i>
                    Historial Académico
                </h2>

                @if ($alumno->relationLoaded('cursos') && $alumno->cursos->count() > 0)
                    <div class="space-y-3">
                        @foreach ($alumno->cursos as $cursoInscrito)
                            <div class="course-card">
                                <div class="flex flex-col md:flex-row md:items-center justify-between">
                                    <div class="flex-1">
                                        <h4 class="font-semibold text-gray-900 mb-1">
                                            <a href="{{ route('admin.cursos.show', $cursoInscrito->id) }}"
                                               class="text-blue-600 hover:text-blue-800 hover:underline">
                                                {{ $cursoInscrito->nombre }}
                                            </a>
                                        </h4>
                                        <div class="flex flex-wrap items-center gap-4 text-sm text-gray-600">
                                            <span class="flex items-center">
                                                <i class="bi bi-calendar-check mr-1"></i>
                                                Estado: <strong class="ml-1">{{ $cursoInscrito->pivot->estado ?? 'N/A' }}</strong>
                                            </span>
                                            <span class="flex items-center">
                                                <i class="bi bi-award mr-1">  </i>
                                                Nota: <strong class="ml-1">{{ $cursoInscrito->pivot->nota ?? 'N/A' }}</strong>
                                            </span>
                                        </div>
                                    </div>
                                    <div class="mt-3 md:mt-0">
                                        @php
                                            $estadoCurso = $cursoInscrito->pivot->estado ?? 'N/A';
                                            $badgeClass = 'px-3 py-1 rounded-full text-xs font-semibold ';
                                            switch($estadoCurso) {
                                                case 'Completado':
                                                    $badgeClass .= 'bg-green-100 text-green-800';
                                                    break;
                                                case 'En Progreso':
                                                    $badgeClass .= 'bg-blue-100 text-blue-800';
                                                    break;
                                                case 'Abandonado':
                                                    $badgeClass .= 'bg-red-100 text-red-800';
                                                    break;
                                                default:
                                                    $badgeClass .= 'bg-gray-100 text-gray-800';
                                            }
                                        @endphp
                                        <span class="{{ $badgeClass }}">{{ $estadoCurso }}</span>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                @elseif($alumno->relationLoaded('cursos'))
                    <div class="empty-state">
                        <i class="bi bi-journal-x text-4xl text-gray-400 mb-3"></i>
                        <h3 class="text-lg font-medium text-gray-600 mb-2">Sin cursos registrados</h3>
                        <p class="text-gray-500">Este estudiante aún no tiene cursos asignados en el sistema.</p>
                    </div>
                @endif
            </div>
        </div>
        <div class="lg:col-span-1">
            <div class="quick-actions">
                <h3 class="font-bold text-gray-800 mb-4 flex items-center">
                    <i class="bi bi-lightning-charge-fill mr-2 text-yellow-500"></i>
                    Acciones Rápidas
                </h3>

                <div class="space-y-3">
                    <a href="{{ route('admin.alumnos.edit', $alumno->id) }}" class="action-btn btn-primary">
                        <i class="bi bi-pencil-square mr-2"></i>
                        Editar Perfil
                    </a>

                    <a href="#" class="action-btn btn-success" onclick="handleEnrollStudent()">
                        <i class="bi bi-plus-circle mr-2"></i>
                        Inscribir a Curso
                    </a>

                    <a href="#" class="action-btn btn-secondary" onclick="printProfile()">
                        <i class="bi bi-printer mr-2"></i>
                        Imprimir Perfil
                    </a>

                    <a href="#" class="action-btn btn-secondary" onclick="exportProfile()">
                        <i class="bi bi-download mr-2"></i>
                        Exportar PDF
                    </a>

                    <div class="border-t pt-3 mt-4">
                        <a href="mailto:{{ $alumno->email }}" class="action-btn btn-secondary">
                            <i class="bi bi-envelope mr-2"></i>
                            Enviar Email
                        </a>

                        @if($alumno->telefono)
                        <a href="tel:{{ $alumno->telefono }}" class="action-btn btn-secondary">
                            <i class="bi bi-telephone mr-2"></i>
                            Llamar
                        </a>
                        @endif
                    </div>
                </div>

                <div class="mt-6 pt-4 border-t border-gray-200">
                    <h4 class="font-semibold text-gray-700 mb-3 flex items-center">
                        <i class="bi bi-graph-up mr-2 text-blue-500"></i>
                        Estadísticas
                    </h4>

                    <div class="space-y-3">
                        <div class="flex justify-between items-center">
                            <span class="text-sm text-gray-600">Cursos Totales:</span>
                            <span class="font-semibold text-gray-800">
                                {{ $alumno->relationLoaded('cursos') ? $alumno->cursos->count() : 0 }}
                            </span>
                        </div>

                        @if($alumno->relationLoaded('cursos') && $alumno->cursos->count() > 0)
                        <div class="flex justify-between items-center">
                            <span class="text-sm text-gray-600">Completados:</span>
                            <span class="font-semibold text-green-600">
                                {{ $alumno->cursos->where('pivot.estado', 'Completado')->count() }}
                            </span>
                        </div>

                        <div class="flex justify-between items-center">
                            <span class="text-sm text-gray-600">En Progreso:</span>
                            <span class="font-semibold text-blue-600">
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
                            <span class="font-semibold {{ $promedioNotas >= 7 ? 'text-green-600' : ($promedioNotas >= 5 ? 'text-yellow-600' : 'text-red-600') }}">
                                {{ number_format($promedioNotas, 1) }}
                            </span>
                        </div>
                        @endif
                        @endif
                    </div>
                </div>
            </div>

            <div class="mt-6">
                <div class="quick-actions">
                    <h4 class="font-semibold text-gray-700 mb-3 flex items-center">
                        <i class="bi bi-arrow-left-right mr-2 text-gray-500"></i>
                        Navegación
                    </h4>

                    <div class="space-y-2">
                        <a href="{{ route('admin.alumnos.index') }}" class="action-btn btn-secondary">
                            <i class="bi bi-arrow-left mr-2"></i>
                            Volver a Lista
                        </a>
                        
                    </div>
                </div>
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

    function navigateStudent(direction) {
        alert(`Navegación ${direction} a implementar`);
    }

    document.addEventListener('DOMContentLoaded', function() {
        if (window.innerWidth <= 768) {
            const infoCards = document.querySelectorAll('.info-card');
            infoCards.forEach(card => {
                card.style.cursor = 'pointer';
                card.addEventListener('click', function() {
                    this.classList.toggle('expanded');
                });
            });
        }
    });

    function filterCourses() {
        const searchTerm = document.getElementById('courseSearch').value.toLowerCase();
        const courses = document.querySelectorAll('.course-card');

        courses.forEach(course => {
            const courseName = course.querySelector('h4').textContent.toLowerCase();
            course.style.display = courseName.includes(searchTerm) ? 'block' : 'none';
        });
    }
</script>
@endpush

@push('styles')
<style>
    @media print {
        .quick-actions,
        .action-btn,
        .content-header,
        .sidebar {
            display: none !important;
        }

        .main-content {
            margin-left: 0 !important;
        }

        .student-card {
            background: #f8fafc !important;
            color: #1e293b !important;
            box-shadow: none !important;
        }

        .info-card {
            box-shadow: none !important;
            border: 1px solid #e2e8f0 !important;
        }

        body {
            background: white !important;
        }
    }

    .info-card,
    .course-card,
    .action-btn {
        transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
    }

    .course-card:hover {
        transform: translateX(4px);
    }

    .info-card:hover .info-label i {
        transform: scale(1.1);
    }

    @media (max-width: 640px) {
        .section-title {
            font-size: 1.25rem;
        }

        .student-card {
            margin-bottom: 1rem;
        }

        .quick-actions {
            position: static;
            margin-top: 2rem;
        }
    }
</style>
@endpush