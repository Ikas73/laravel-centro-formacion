@extends('layouts.admin')

@section('title', 'Dashboard Overview')
@section('page-title', 'Dashboard Overview')

@section('content')
    
    
    <div class="flex flex-wrap justify-between items-center mb-6">
        <h1 class="text-2xl font-semibold text-gray-700">Dashboard Overview</h1>
    </div>
    
    

    <!-- Tarjetas resumen (KPIs) -->
<div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6 mb-6">

{{-- Tarjeta 1: Total Students (se mantiene igual) --}}
<div class="bg-white p-6 rounded-lg shadow-lg flex items-center justify-between">
    <div>
        <p class="text-xs font-medium text-gray-500 uppercase tracking-wider">Total Students</p>
        {{-- Usar la variable correcta del controlador --}}
        <p class="text-3xl font-semibold text-gray-800 mt-1">{{ $totalStudents ?? '0' }}</p>
    </div>
    <div class="bg-blue-100 rounded-full p-3">
        <i class="bi bi-people-fill text-blue-600 text-2xl"></i>
    </div>
</div>

{{-- Tarjeta 2: Total Courses (NUEVA) --}}
<div class="bg-white p-6 rounded-lg shadow-lg flex items-center justify-between">
    <div>
        <p class="text-xs font-medium text-gray-500 uppercase tracking-wider">Total Courses</p>
        <p class="text-3xl font-semibold text-gray-800 mt-1">{{ $totalCourses ?? '0' }}</p>
    </div>
    <div class="bg-green-100 rounded-full p-3">
        <i class="bi bi-journal-bookmark-fill text-green-600 text-2xl"></i>
    </div>
</div>

{{-- Tarjeta 3: Available Teachers (se mantiene igual) --}}
<div class="bg-white p-6 rounded-lg shadow-lg flex items-center justify-between">
    <div>
        <p class="text-xs font-medium text-gray-500 uppercase tracking-wider">Available Teachers</p>
        {{-- Usar la variable correcta del controlador --}}
        <p class="text-3xl font-semibold text-gray-800 mt-1">{{ $availableTeachers ?? '0' }}</p>
    </div>
    <div class="bg-indigo-100 rounded-full p-3">
         <i class="bi bi-person-video3 text-indigo-600 text-2xl"></i>
    </div>
</div>

{{-- Tarjeta 4: Inactive Courses (NUEVA) --}}
<div class="bg-white p-6 rounded-lg shadow-lg flex items-center justify-between">
     <div>
        <p class="text-xs font-medium text-gray-500 uppercase tracking-wider">Inactive Courses</p>
        <p class="text-3xl font-semibold text-gray-800 mt-1">{{ $inactiveCourses ?? '0' }}</p>
    </div>
    <div class="bg-orange-100 rounded-full p-3">
        {{-- Icono de ejemplo: un archivo archivado o un ojo tachado --}}
        <i class="bi bi-archive-fill text-orange-500 text-2xl"></i>
    </div>
</div>

</div> <!-- Fin Grid Tarjetas -->


    <div class="grid grid-cols-1 lg:grid-cols-5 gap-6 mb-6">
        <div class="lg:col-span-3 bg-white p-4 sm:p-6 rounded-lg shadow-lg">
            <h3 class="text-lg font-semibold text-gray-700 mb-4">Enrollment Trends (Last 6 Months)</h3>
            <div class="h-[250px] sm:h-[300px]">
                <canvas id="enrollmentChart"></canvas>
            </div>
        </div>
        <div class="lg:col-span-2 bg-white p-4 sm:p-6 rounded-lg shadow-lg">
            <h3 class="text-lg font-semibold text-gray-700 mb-4">Pre-enrollment Status</h3>
             <div class="mx-auto h-[250px] sm:h-[300px] flex items-center justify-center">
                <canvas id="preenrollmentStatusChart"></canvas>
             </div>
             <div class="flex justify-center gap-4 mt-4 text-xs text-gray-500">
                <span><i class="bi bi-circle-fill text-yellow-400"></i> Pending</span>
                <span><i class="bi bi-circle-fill text-teal-500"></i> Approved</span>
                <span><i class="bi bi-circle-fill text-red-500"></i> Rejected</span>
             </div>
        </div>
    </div>

     <div class="mb-6">
        <div class="bg-white p-4 sm:p-6 rounded-lg shadow-lg">
            <h3 class="text-lg font-semibold text-gray-700 mb-4">Students per Course</h3>
            <div class="h-[300px] sm:h-[350px]">
                <canvas id="studentsPerCourseChart"></canvas>
            </div>
        </div>
    </div>

    <div class="bg-white p-4 sm:p-6 rounded-lg shadow-lg">
        <div class="flex justify-between items-center mb-4">
            <h3 class="text-lg font-semibold text-gray-700">Recent Pre-enrollment Applications</h3>
            <a href="#" class="text-sm text-blue-600 hover:underline font-medium">See All →</a>
        </div>
        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-gray-200">
                <thead class="bg-gray-50">
                    <tr>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Student Name</th>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Course</th>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Date</th>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Status</th>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Actions</th>
                    </tr>
                </thead>
                {{-- En admin/dashboard.blade.php, dentro de la tabla --}}
<tbody class="bg-white divide-y divide-gray-200">
    @forelse ($recentPreEnrollments as $preinscrito)
    <tr>
        {{-- STUDENT NAME --}}
        <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">
            <div class="flex items-center">
                <div class="flex-shrink-0 h-8 w-8">
                    @php
                        $inicialNombre = (!empty($preinscrito->nombre)) ? $preinscrito->nombre[0] : '';
                        $inicialApellido = (!empty($preinscrito->apellido1)) ? $preinscrito->apellido1[0] : '';
                    @endphp
                    <img class="h-8 w-8 rounded-full" src="https://ui-avatars.com/api/?name={{ urlencode($inicialNombre.$inicialApellido) }}&color=7F9CF5&background=EBF4FF" alt="">
                </div>
                <div class="ml-3">
                    {{ $preinscrito->nombre }} {{ $preinscrito->apellido1 }}
                </div>
            </div>
        </td>
        {{-- COURSE --}}
        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
            {{-- Un preinscrito no está ligado a un curso todavía, mostramos su nivel --}}
            {{ $preinscrito->nivel_formativo ?? 'N/A' }}
        </td>
        {{-- DATE --}}
        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
            {{ $preinscrito->created_at->format('M d, Y') }}
        </td>
        {{-- STATUS --}}
        <td class="px-6 py-4 whitespace-nowrap">
            @php
                $estadoPre = $preinscrito->estado ?? 'Pendiente';
                $badgeColorPre = 'bg-yellow-100 text-yellow-800'; // Default a Pendiente
                if ($estadoPre === 'Convertido') $badgeColorPre = 'bg-green-100 text-green-800';
                elseif ($estadoPre === 'Rechazado' || $estadoPre === 'Baja') $badgeColorPre = 'bg-red-100 text-red-800';
                elseif ($estadoPre === 'Contactado' || $estadoPre === 'Interesado') $badgeColorPre = 'bg-blue-100 text-blue-800';
            @endphp
            <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full {{ $badgeColorPre }}">
                {{ $estadoPre }}
            </span>
        </td>
        {{-- ACTIONS --}}
        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-400">
            <a href="{{ route('admin.preinscritos.show', $preinscrito->id) }}" class="hover:text-indigo-600" title="Ver"><i class="bi bi-eye-fill"></i></a>
            <a href="{{ route('admin.preinscritos.edit', $preinscrito->id) }}" class="ml-2 hover:text-indigo-600" title="Editar"><i class="bi bi-pencil-fill"></i></a>
        </td>
    </tr>
    @empty
    <tr>
        <td colspan="5" class="px-6 py-4 whitespace-nowrap text-sm text-gray-500 text-center">
            No hay aplicaciones de preinscripción recientes.
        </td>
    </tr>
    @endforelse
</tbody>
            </table>
        </div>
    </div>
@endsection

@push('scripts')
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            {{--
                El bloque @php aquí puede ser útil para definir valores por defecto
                para TODAS las variables, pero vamos a confiar en que el controlador
                siempre las pasa. Si alguna vez el controlador no pasara una,
                recibirías un error de "Undefined variable", lo cual es bueno
                para detectar problemas.
            --}}

            // --- Gráfico Enrollment Trends (Líneas) ---
            const ctxEnrollment = document.getElementById('enrollmentChart');
            if (ctxEnrollment) {
                 const enrollmentConfig = {
                     type: 'line',
                     data: {
                         // Usar directamente las variables del controlador
                         labels: @json($enrollmentLabels ?? []),
                         datasets: [{
                             label: 'Nuevos Alumnos',
                             // Usar directamente las variables del controlador
                             data: @json($enrollmentData ?? []),
                             borderColor: 'rgb(59, 130, 246)',
                             tension: 0.3, // Un poco más suave
                             fill: true,
                             backgroundColor: 'rgba(59, 130, 246, 0.1)'
                         }]
                     },
                     options: {
                         responsive: true,
                         maintainAspectRatio: false,
                         scales: { y: { beginAtZero: false } },
                         plugins: { legend: { display: false } }
                     }
                 };
                 new Chart(ctxEnrollment, enrollmentConfig);
            } else {
                console.warn("Canvas 'enrollmentChart' no encontrado.");
            }

            // --- Gráfico Pre-enrollment Status (Doughnut) ---
            const ctxPreenrollmentStatus = document.getElementById('preenrollmentStatusChart');
            if (ctxPreenrollmentStatus) {
                const preenrollmentConfig = {
                    type: 'doughnut',
                    data: {
                        labels: ['Pending', 'Approved', 'Rejected'],
                        datasets: [{
                            data: [
                                {{ $preEnrollmentStatusData['pending'] ?? 0 }},
                                {{ $preEnrollmentStatusData['approved'] ?? 0 }},
                                {{ $preEnrollmentStatusData['rejected'] ?? 0 }}
                            ],
                            backgroundColor: ['rgb(251, 191, 36)', 'rgb(16, 185, 129)', 'rgb(239, 68, 68)'],
                            hoverOffset: 4
                        }]
                    },
                    options: { responsive: true, maintainAspectRatio: false, plugins: { legend: { display: false } } }
                };
                new Chart(ctxPreenrollmentStatus, preenrollmentConfig);
            }

            // --- Gráfico Students per Course (Barras) ---
            const ctxStudentsPerCourse = document.getElementById('studentsPerCourseChart');
            if (ctxStudentsPerCourse) {
                const studentsConfig = {
                    type: 'bar',
                    data: {
                        labels: @json($studentsPerCourseLabels ?? []),
                        datasets: [{
                            label: 'Número de Estudiantes',
                            data: @json($studentsPerCourseData ?? []),
                            backgroundColor: 'rgb(20, 184, 166)',
                            borderColor: 'rgb(13, 148, 136)',
                            borderWidth: 1
                        }]
                    },
                    options: { responsive: true, maintainAspectRatio: false, scales: { y: { beginAtZero: true } }, plugins: { legend: { display: false } } }
                };
                new Chart(ctxStudentsPerCourse, studentsConfig);
            }

        });
    </script>
@endpush