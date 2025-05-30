<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Profesor;
use App\Models\Curso; // Necesario para el KPI de cursos por profesor
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB; // Para búsqueda insensible
use Illuminate\Support\Facades\Log;

class ProfesorController extends Controller
{
    public function index(Request $request)
    {
        $searchTerm = $request->input('search');
        $filtroEspecialidad = $request->input('especialidad'); // Para el nuevo filtro

        $query = Profesor::query();

        // Aplicar filtro de búsqueda por nombre, DNI, email, etc.
        if ($searchTerm) {
            $lowerSearchTerm = strtolower($searchTerm);
            $query->where(function ($q) use ($lowerSearchTerm) {
                $q->where(DB::raw('LOWER(nombre)'), 'LIKE', "%{$lowerSearchTerm}%")
                  ->orWhere(DB::raw('LOWER(apellido1)'), 'LIKE', "%{$lowerSearchTerm}%")
                  ->orWhere(DB::raw('LOWER(apellido2)'), 'LIKE', "%{$lowerSearchTerm}%")
                  ->orWhere(DB::raw('LOWER(dni)'), 'LIKE', "%{$lowerSearchTerm}%")
                  ->orWhere(DB::raw('LOWER(email)'), 'LIKE', "%{$lowerSearchTerm}%");
                // Podrías añadir búsqueda por especialidad aquí también si quieres que el campo de texto busque en especialidades
                // ->orWhere(DB::raw('LOWER(especialidad)'), 'LIKE', "%{$lowerSearchTerm}%");
            });
        }

        // NUEVO: Aplicar filtro por Especialidad
        if ($filtroEspecialidad) {
            $query->where('especialidad', $filtroEspecialidad);
        }

        $profesores = $query->withCount('cursos') // NUEVO: Contar cursos para mostrar en la tabla
                            ->orderBy('apellido1', 'asc')
                            ->orderBy('nombre', 'asc')
                            ->paginate(7) // Ajusta a 7 para que quepa como en la imagen
                            ->appends($request->query()); // Mantener todos los parámetros de la URL en la paginación
        $totalProfesores = Profesor::count();
        

        // NUEVO: Obtener opciones para el filtro de especialidad
        $opcionesEspecialidad = Profesor::select('especialidad')
                                    ->whereNotNull('especialidad')
                                    ->where('especialidad', '!=', '')
                                    ->distinct()
                                    ->orderBy('especialidad')
                                    ->pluck('especialidad');
        $activosEsteMes = $totalProfesores;
        $totalEspecialidades = $opcionesEspecialidad->count();
        

        // KPIs (Ejemplos basados en la imagen)
        
        // Media Cursos/Profesor: Necesitaríamos el total de cursos asignados
        // Esto es un cálculo más complejo, por ahora un placeholder o un cálculo simple.
        // $totalCursosAsignados = Curso::whereNotNull('profesor_id')->count();
        // $mediaCursosPorProfesor = ($totalProfesores > 0) ? round($totalCursosAsignados / $totalProfesores, 1) : 0;
        // Por simplicidad, usaremos un placeholder hasta tener una mejor lógica para "cursos asignados a ESTOS profesores"
        // Cálculo más preciso para media de cursos
        $profesoresConCursos = Profesor::withCount('cursos')->get();
        $totalCursosAsignados = $profesoresConCursos->sum('cursos_count');
        $mediaCursosPorProfesor = ($totalProfesores > 0) ? round($totalCursosAsignados / $totalProfesores, 1) : 0;

        
        

        return view('admin.profesores.index', compact(
            'profesores',
            'searchTerm',
            'opcionesEspecialidad',   // Pasar opciones de filtro
            'filtroEspecialidad',     // Pasar filtro seleccionado
            'totalProfesores',        // KPI
            'mediaCursosPorProfesor', // KPI
            'totalEspecialidades',    // KPI
            'activosEsteMes'          // KPI
        ));
    }

    // ... Asegúrate que los otros métodos CRUD (create, store, show, edit, update, destroy)
    //     están presentes, aunque sea con un return "" o return view("...") vacío por ahora,
    //     para que las rutas resource no den error si se intenta acceder a ellas.
    //     Ya los implementaste antes, así que deberían estar bien.
}