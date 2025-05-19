<?php

namespace App\Http\Controllers\Admin; // Asegúrate que el namespace es correcto

use App\Http\Controllers\Controller; // Importar el controlador base
use App\Models\Alumno;           // Importar el modelo Alumno
use App\Models\Profesor;         // Para el KPI de ratio (ejemplo)
use Illuminate\Http\Request;

class AlumnoController extends Controller
{
    /**
     * Muestra una lista del recurso.
     */
    public function index(Request $request) // Añadimos Request para futura búsqueda/filtrado
    {
        // 1. Obtener Alumnos Paginados
        // Por ahora, obtenemos todos. Más adelante añadiremos filtros y búsqueda.
        $alumnos = Alumno::orderBy('apellido1', 'asc')->orderBy('nombre', 'asc')->paginate(7); // Paginado, 10 por página, ordenado

        // 2. Calcular KPIs (Valores iniciales/placeholders)
        $totalAlumnosActivos = Alumno::where('estado', 'Activo')->count(); // Asumiendo que tienes un campo 'estado'
        // Si no tienes 'estado', usa Alumno::count() por ahora
        // $totalAlumnosActivos = Alumno::count();

        $nuevosAlumnosEsteMes = 0; // Placeholder, necesitarás lógica de fechas
        $totalProfesores = Profesor::count();
        $ratioAlumnoProfesor = ($totalProfesores > 0) ? round($totalAlumnosActivos / $totalProfesores, 1) . ':1' : 'N/A';
        $tasaAsistencia = '94.5%'; // Placeholder

        // 3. Pasar datos a la vista
        return view('admin.alumnos.index', compact(
            'alumnos',
            'totalAlumnosActivos',
            'nuevosAlumnosEsteMes',
            'ratioAlumnoProfesor',
            'tasaAsistencia'
        ));
    }

    // ... otros métodos (create, store, show, edit, update, destroy) ...
    // Los dejaremos vacíos o con un simple return view() por ahora.
}