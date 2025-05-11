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
    // --- Obtener Datos ---
    $totalAlumnos = \App\Models\Alumno::count();
    $totalProfesores = \App\Models\Profesor::count();
    $totalCursos = \App\Models\Curso::count();
    $totalPreinscritos = PreinscritoSepe::count(); // ¡Nuevo dato!

    // --- Datos de EJEMPLO para Gráficos (REEMPLAZAR con lógica real) ---
    $totalAlumnosChicos = \App\Models\Alumno::where('sexo', 'Hombre')->count(); // Ejemplo
    $totalAlumnosChicas = $totalAlumnos - $totalAlumnosChicos; // Ejemplo

    // Datos para asistencia (Placeholder - necesitarás lógica real)
    $asistenciaLabels = ['Lun', 'Mar', 'Mié', 'Jue', 'Vie'];
    $asistenciaPresente = [85, 90, 88, 92, 80];
    $asistenciaAusente = [15, 10, 12, 8, 20];

    // TODO: Obtener datos para eventos, anuncios...

    return view('admin.dashboard', compact(
        'totalAlumnos',
        'totalProfesores',
        'totalCursos',
        'totalPreinscritos',
        'totalAlumnosChicos', // Pasar datos para gráfico de género
        'totalAlumnosChicas', // Pasar datos para gráfico de género
        'asistenciaLabels',   // Pasar datos para gráfico de asistencia
        'asistenciaPresente',
        'asistenciaAusente'
        // ... pasar más datos aquí ...
    ));
}
}