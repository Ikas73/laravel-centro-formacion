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
                <tbody class="bg-white divide-y divide-gray-200">
                    @php
                        $demoPreenrollments = $recentPreenrollments ?? [
                            ['name' => 'Maria Garcia', 'course' => 'Advanced Mathematics', 'date' => 'Apr 30, 2025', 'status' => 'Pending'],
                            ['name' => 'Alex Johnson', 'course' => 'Computer Science', 'date' => 'Apr 29, 2025', 'status' => 'Approved'],
                            ['name' => 'James Wilson', 'course' => 'Physics', 'date' => 'Apr 28, 2025', 'status' => 'Rejected'],
                            ['name' => 'Emma Davis', 'course' => 'English Literature', 'date' => 'Apr 27, 2025', 'status' => 'Pending'],
                            ['name' => 'Carlos Mendez', 'course' => 'Chemistry', 'date' => 'Apr 26, 2025', 'status' => 'Approved'],
                        ];
                    @endphp
                    @forelse ($demoPreenrollments as $preinscrito)
                    <tr>
                        <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">{{ $preinscrito['name'] }}</td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">{{ $preinscrito['course'] }}</td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">{{ $preinscrito['date'] }}</td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            @if($preinscrito['status'] === 'Pending')
                                <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-yellow-100 text-yellow-800">Pending</span>
                            @elseif($preinscrito['status'] === 'Approved')
                                <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-green-100 text-green-800">Approved</span>
                            @elseif($preinscrito['status'] === 'Rejected')
                                <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-red-100 text-red-800">Rejected</span>
                            @endif
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                            <a href="#" class="text-gray-400 hover:text-blue-600 me-2" title="Ver"><i class="bi bi-eye-fill"></i></a>
                            <a href="#" class="text-gray-400 hover:text-indigo-600" title="Editar"><i class="bi bi-pencil-fill"></i></a>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="5" class="px-6 py-4 whitespace-nowrap text-sm text-gray-500 text-center">
                            No recent pre-enrollment applications found.
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
            @php
                $asistenciaLabelsPHP = $asistenciaLabels ?? ['Lun', 'Mar', 'Mié', 'Jue', 'Vie'];
                $asistenciaPresentePHP = $asistenciaPresente ?? [85, 90, 88, 92, 80];
                $asistenciaAusentePHP = $asistenciaAusente ?? [15, 10, 12, 8, 20];
                $generoDataPHP = [$totalAlumnosChicos ?? 55, $totalAlumnosChicas ?? 45];
                $enrollmentLabelsPHP = $enrollmentLabels ?? ['November', 'December', 'January', 'February', 'March', 'April'];
                $enrollmentDataPHP = $enrollmentData ?? [85, 72, 90, 88, 95, 82];
                $studentsPerCourseLabelsPHP = $studentsPerCourseLabels ?? ['Mathematics', 'Computer Science', 'Physics', 'Chemistry', 'English', 'History', 'Spanish', 'Biology', 'Art'];
                $studentsPerCourseDataPHP = $studentsPerCourseData ?? [145, 180, 125, 138, 160, 102, 120, 148, 98];
                
            @endphp

            const ctxEnrollment = document.getElementById('enrollmentChart');
            if (ctxEnrollment) {
                 const enrollmentConfig = {
                     type: 'line', data: { labels: @json($enrollmentLabelsPHP), datasets: [{ label: 'Enrollments', data: @json($enrollmentDataPHP), borderColor: 'rgb(59, 130, 246)', tension: 0.1, fill: true, backgroundColor: 'rgba(59, 130, 246, 0.1)' }] },
                     options: { responsive: true, maintainAspectRatio: false, scales: { y: { beginAtZero: false } }, plugins: { legend: { display: false } } }
                 };
                 new Chart(ctxEnrollment, enrollmentConfig);
            } else { console.warn("Canvas 'enrollmentChart' no encontrado."); }

            // PONER ESTE CÓDIGO EN SU LUGAR
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
                            backgroundColor: [
                                'rgb(251, 191, 36)', // Amarillo para Pending
                                'rgb(16, 185, 129)', // Verde para Approved
                                'rgb(239, 68, 68)'  // Rojo para Rejected
                            ],
                            hoverOffset: 4
                        }]
                    },
                    options: {
                        responsive: true,
                        maintainAspectRatio: false,
                        plugins: {
                            legend: {
                                display: false // La leyenda ya está en el HTML
                            }
                        }
                    }
                };
                new Chart(ctxPreenrollmentStatus, preenrollmentConfig);
            } else {
                console.warn("Elemento canvas 'preenrollmentStatusChart' no encontrado.");
            }

            const ctxStudentsPerCourse = document.getElementById('studentsPerCourseChart');
    if (ctxStudentsPerCourse) {
        const studentsConfig = {
            type: 'bar',
            data: {
                // Usa los datos reales del controlador
                labels: @json($studentsPerCourseLabels ?? []),
                datasets: [{
                    label: 'Número de Estudiantes',
                    // Usa los datos reales del controlador
                    data: @json($studentsPerCourseData ?? []),
                    backgroundColor: 'rgb(20, 184, 166)', // Color Teal-500 de Tailwind
                    borderColor: 'rgb(13, 148, 136)',     // Color Teal-600 de Tailwind
                    borderWidth: 1
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                scales: {
                    y: {
                        beginAtZero: true
                    }
                },
                plugins: {
                    legend: {
                        display: false // Ocultamos la leyenda si solo hay una serie de datos
                    }
                }
            }
        };
        new Chart(ctxStudentsPerCourse, studentsConfig);
    } else {
        console.warn("Elemento canvas 'studentsPerCourseChart' no encontrado.");
    }

             const listaEventosElem = document.getElementById('lista-eventos');
             if (listaEventosElem && !listaEventosElem.innerHTML.trim()) {
                  listaEventosElem.innerHTML = '<p class="text-gray-500 text-sm">No hay eventos próximos.</p>';
             }
             const listaAnunciosElem = document.getElementById('lista-anuncios');
             if (listaAnunciosElem && !listaAnunciosElem.innerHTML.trim()) {
                 listaAnunciosElem.innerHTML = '<p class="text-gray-500 text-sm">No hay anuncios recientes.</p>';
             }
        });
    </script>
@endpush