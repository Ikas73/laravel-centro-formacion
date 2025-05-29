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
        Log::info("ProfesorController@index fue alcanzado.");

        $searchTerm = $request->input('search');
        $filtroEspecialidad = $request->input('especialidad_filtro'); // Para el filtro

        $query = Profesor::query();

        if ($searchTerm) {
            $lowerSearchTerm = strtolower($searchTerm);
            $query->where(function ($q) use ($lowerSearchTerm) {
                $q->where(DB::raw('LOWER(nombre)'), 'LIKE', "%{$lowerSearchTerm}%")
                  ->orWhere(DB::raw('LOWER(apellido1)'), 'LIKE', "%{$lowerSearchTerm}%")
                  ->orWhere(DB::raw('LOWER(apellido2)'), 'LIKE', "%{$lowerSearchTerm}%")
                  ->orWhere(DB::raw('LOWER(dni)'), 'LIKE', "%{$lowerSearchTerm}%")
                  ->orWhere(DB::raw('LOWER(email)'), 'LIKE', "%{$lowerSearchTerm}%")
                  ->orWhere(DB::raw('LOWER(especialidad)'), 'LIKE', "%{$lowerSearchTerm}%"); // Añadir búsqueda por especialidad
            });
        }

        if ($filtroEspecialidad) {
            $query->where('especialidad', $filtroEspecialidad);
        }

        $profesores = $query->withCount('cursos') // Cargar el conteo de cursos para el KPI
                            ->orderBy('apellido1', 'asc')
                            ->orderBy('nombre', 'asc')
                            ->paginate(10) // O 7 si prefieres menos por página
                            ->appends($request->query()); // Mantener todos los parámetros

        // KPIs (Simplificados)
        $totalProfesores = Profesor::count();
        // $profesoresConMasCursos = Profesor::withCount('cursos')->orderBy('cursos_count', 'desc')->take(1)->first(); // Ejemplo para KPI si quieres
        $mediaCursosPorProfesor = ($totalProfesores > 0) ? round(Curso::count() / $totalProfesores, 1) : 0;

        // Opciones para el filtro de especialidad
        $opcionesEspecialidad = Profesor::select('especialidad')
                                    ->whereNotNull('especialidad')
                                    ->where('especialidad', '!=', '')
                                    ->distinct()
                                    ->orderBy('especialidad')
                                    ->pluck('especialidad');

        return view('admin.profesores.index', compact(
            'profesores',
            'searchTerm',
            'totalProfesores',
            'mediaCursosPorProfesor',
            'opcionesEspecialidad',
            'filtroEspecialidad'
        ));
    }

    // ... Asegúrate que los otros métodos CRUD (create, store, show, edit, update, destroy)
    //     están presentes, aunque sea con un return "" o return view("...") vacío por ahora,
    //     para que las rutas resource no den error si se intenta acceder a ellas.
    //     Ya los implementaste antes, así que deberían estar bien.
}