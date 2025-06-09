<?php
namespace App\Http\Controllers\Admin;
use App\Http\Controllers\Controller; // Importar el controlador base
use Illuminate\Http\Request;
// Importar modelos que necesitarás para los contadores
use App\Models\Alumno;
use App\Models\Profesor;
use App\Models\Curso;
use App\Models\PreinscritoSepe;
// ... otros modelos necesarios ...
class DashboardController extends Controller
{
    public function index()
    {
        // --- Obtener Datos para KPIs ---
        $totalStudents = Alumno::count();
        $availableTeachers = Profesor::count();
        $pendingPreEnrollments = PreinscritoSepe::where('estado', 'Pendiente')->count();
    
        // --- CÁLCULOS DE CURSOS MODIFICADOS ---
        $totalCourses = Curso::count();
        $inactiveCourses = Curso::where('fecha_fin', '<', now())->count(); // Cursos cuya fecha_fin ya pasó
        // --- FIN CÁLCULOS DE CURSOS MODIFICADOS ---
    
    
        // --- Obtener Datos para Gráficos (El resto se mantiene) ---
        // Enrollment Trends
        $enrollmentLabels = ['November', 'December', 'January', 'February', 'March', 'April'];
        $enrollmentData = [85, 72, 90, 88, 95, 82];
    
        // Pre-enrollment Status        
            $pendingCount = PreinscritoSepe::where('estado', 'Pendiente')->orWhere('estado', 'Interesado')->orWhere('estado', 'Contactado')->count();
            $approvedCount = PreinscritoSepe::where('estado', 'Convertido')->count();
            $rejectedCount = PreinscritoSepe::where('estado', 'Rechazado')->orWhere('estado', 'Baja')->count();

            $preEnrollmentStatusData = [
                'pending' => $pendingCount,
                'approved' => $approvedCount,
                'rejected' => $rejectedCount,
            ];
        
    
        // Students per Course
        $topCourses = Curso::withCount('alumnos')->orderBy('alumnos_count', 'desc')->take(8)->get();
        $studentsPerCourseLabels = $topCourses->pluck('nombre');
        $studentsPerCourseData = $topCourses->pluck('alumnos_count');
    
        // Recent Pre-enrollment Applications
        $recentPreEnrollments = PreinscritoSepe::latest()->take(5)->get();
    
    
        // Pasar todas las variables a la vista
        return view('admin.dashboard', compact(
            // KPIs
            'totalStudents',
            'availableTeachers',
            'pendingPreEnrollments',
            'totalCourses',         // <-- NUEVA VARIABLE
            'inactiveCourses',      // <-- NUEVA VARIABLE
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