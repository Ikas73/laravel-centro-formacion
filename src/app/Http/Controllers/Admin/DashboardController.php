<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
// Importar los modelos necesarios
use App\Models\Alumno;
use App\Models\Profesor;
use App\Models\Curso;
use App\Models\PreinscritoSepe;
use App\Models\User;
use Illuminate\Support\Facades\Auth; // Para el usuario logueado
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    public function index()
    {
        // --- Obtener Datos para Tarjetas de Resumen (KPIs) ---
        $totalStudents = Alumno::count();
        $availableTeachers = Profesor::count();

        // CÁLCULOS DE CURSOS
        $totalCourses = Curso::count();
        $inactiveCourses = Curso::where('fecha_fin', '<', now())->count(); // Cursos cuya fecha_fin ya pasó

        // CÁLCULO DE PREINSCRITOS
        $pendingPreEnrollments = PreinscritoSepe::where('estado', 'Pendiente')->count(); // Asegúrate que tu seeder crea algunos con este estado


        // --- Obtener Datos para Gráficos ---

        // En DashboardController.php

        // --- NUEVO: 1. Enrollment Trends (Datos Dinámicos) ---

        // 1.1. Generar el rango de los últimos 6 meses de forma robusta
        $enrollmentTrends = collect();
        for ($i = 5; $i >= 0; $i--) { // Iterar desde hace 5 meses hasta el mes actual
            $date = Carbon::now()->subMonths($i);
            $enrollmentTrends->put($date->format('Y-m'), 0); // La clave es 'YYYY-MM', el valor inicial es 0
        }
        // Con este bucle, no se necesita sortKeys() porque se insertan en orden cronológico

        // 1.2. Realizar la consulta a la BD (se mantiene igual)
        $newStudentsData = Alumno::select(
                DB::raw("TO_CHAR(created_at, 'YYYY-MM') as month"),
                DB::raw('count(*) as total')
            )
            // La fecha de inicio del filtro debe coincidir con el primer mes que generamos
            ->where('created_at', '>=', Carbon::now()->subMonths(5)->startOfMonth())
            ->groupBy('month')
            ->orderBy('month', 'asc')
            ->pluck('total', 'month');

        // 1.3. Combinar los datos (se mantiene igual)
        // Esto llenará los valores para los meses que sí tuvieron actividad
        $enrollmentTrends = $enrollmentTrends->merge($newStudentsData);

        // 1.4. Preparar los datos finales para la vista (se mantiene igual)
        $enrollmentLabels = $enrollmentTrends->keys()->map(function ($monthString) {
            return Carbon::createFromFormat('Y-m', $monthString)->translatedFormat('F');
        })->values()->toArray();

        $enrollmentData = $enrollmentTrends->values()->toArray();

        // --- FIN NUEVO CÓDIGO ---

        // 2. Pre-enrollment Status (Doughnut)
        // Usa los mismos nombres de estado que en tu seeder y tabla
        $preEnrollmentStatusData = [
            'pending' => PreinscritoSepe::where('estado', 'Pendiente')->count(),
            'approved' => PreinscritoSepe::where('estado', 'Convertido')->count(), // 'Approved' en el gráfico es 'Convertido' en los datos
            'rejected' => PreinscritoSepe::where('estado', 'Rechazado')->count(),
        ];

        // 3. Students per Course (Barras)
        $topCourses = Curso::withCount('alumnos')
                           ->orderBy('alumnos_count', 'desc')
                           ->take(9) // Tomar los 9 cursos con más alumnos para que coincida con tu gráfico de ejemplo
                           ->get();
        $studentsPerCourseLabels = $topCourses->pluck('nombre');
        $studentsPerCourseData = $topCourses->pluck('alumnos_count');

        // --- Obtener Datos para la Tabla de Aplicaciones Recientes ---
        $recentPreEnrollments = PreinscritoSepe::latest('created_at')->take(5)->get();


        // Pasar todas las variables a la vista
        return view('admin.dashboard', compact(
            // KPIs
            'totalStudents',
            'availableTeachers',
            'pendingPreEnrollments',
            'totalCourses',
            'inactiveCourses',
            // Gráficos
            'enrollmentLabels',
            'enrollmentData',
            'preEnrollmentStatusData',
            'studentsPerCourseLabels',
            'studentsPerCourseData',
            // Tabla
            'recentPreEnrollments'
        ));
    }
}