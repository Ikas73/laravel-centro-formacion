<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Alumno;
use App\Models\Profesor;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class AlumnoController extends Controller
{
    public function index(Request $request)
    {
        $searchTerm = $request->input('search');
        // --- NUEVO: Obtener valores de filtro de la request ---
        $filtroGrado = $request->input('grado');
        $filtroEstado = $request->input('estado_filtro'); // Usamos 'estado_filtro' para no colisionar con el campo 'estado' del modelo

        $query = Alumno::query();

        // Aplicar filtro de búsqueda
        if ($searchTerm) {
            $lowerSearchTerm = strtolower($searchTerm);
            $query->where(function ($q) use ($lowerSearchTerm) {
                $q->where(DB::raw('LOWER(nombre)'), 'LIKE', "%{$lowerSearchTerm}%")
                  ->orWhere(DB::raw('LOWER(apellido1)'), 'LIKE', "%{$lowerSearchTerm}%")
                  ->orWhere(DB::raw('LOWER(apellido2)'), 'LIKE', "%{$lowerSearchTerm}%")
                  ->orWhere(DB::raw('LOWER(dni)'), 'LIKE', "%{$lowerSearchTerm}%")
                  ->orWhere(DB::raw('LOWER(email)'), 'LIKE', "%{$lowerSearchTerm}%");
            });
        }

        // --- NUEVO: Aplicar filtro por Grado/Nivel Formativo ---
        if ($filtroGrado) {
            $query->where('nivel_formativo', $filtroGrado);
        }

        // --- NUEVO: Aplicar filtro por Estado ---
        // Asegúrate de que tu tabla 'alumnos' tiene una columna 'estado'
        // y que los valores coinciden con los de $opcionesEstado
        if ($filtroEstado) {
            $query->where('estado', $filtroEstado);
        }

        $alumnos = $query->orderBy('apellido1', 'asc')
                         ->orderBy('nombre', 'asc')
                         ->paginate(7)
                         // ¡IMPORTANTE! appends ahora debe incluir todos los filtros y la búsqueda
                         ->appends($request->query()); // Esto incluye search, grado, y estado_filtro si están presentes

        // KPIs
        // $totalAlumnosActivos = Alumno::count(); // Lo que tenías como placeholder
        $totalAlumnosActivos = Alumno::where('estado', 'Activo')->count(); // Ahora debería funcionar
        $nuevosAlumnosEsteMes = 0;
        $totalProfesores = Profesor::count();
        $ratioAlumnoProfesor = ($totalProfesores > 0 && $totalAlumnosActivos > 0) ? round($totalAlumnosActivos / $totalProfesores, 1) . ':1' : 'N/A';
        $tasaAsistencia = '94.5%';

        // --- NUEVO: Obtener opciones para los filtros ---
        // Obtener todos los niveles formativos distintos y no nulos de la tabla alumnos
        $opcionesGrado = Alumno::select('nivel_formativo')
                                ->whereNotNull('nivel_formativo')
                                ->where('nivel_formativo', '!=', '')
                                ->distinct()
                                ->orderBy('nivel_formativo')
                                ->pluck('nivel_formativo');

        // Definir opciones de estado (o podrías obtenerlas de la BD si tienes una tabla de estados)
        // Asegúrate de que estos valores coincidan con los que usas en tu AlumnoFactory y en el badge de la tabla
        $opcionesEstado = ['Activo', 'Inactivo', 'Pendiente', 'Baja'];


        return view('admin.alumnos.index', compact(
            'alumnos',
            'totalAlumnosActivos',
            'nuevosAlumnosEsteMes',
            'ratioAlumnoProfesor',
            'tasaAsistencia',
            'searchTerm',
            'opcionesGrado',     // <--- NUEVO: Pasar opciones de grado
            'opcionesEstado',    // <--- NUEVO: Pasar opciones de estado
            'filtroGrado',       // <--- NUEVO: Pasar filtro de grado seleccionado
            'filtroEstado'       // <--- NUEVO: Pasar filtro de estado seleccionado
        ));
    }
    // ... otros métodos ...
}