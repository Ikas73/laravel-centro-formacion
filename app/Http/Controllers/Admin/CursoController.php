<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Curso; // Importa el modelo Curso
use App\Models\Profesor;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB; // Si planeas usar DB::raw
use Illuminate\Support\Facades\Log;
use App\Http\Requests\StoreCursoRequest; // <-- IMPORTAR
use App\Http\Requests\UpdateCursoRequest; // <-- IMPORTAR

class CursoController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
{
    $searchTerm = $request->input('search');
    $filtroModalidad = $request->input('modalidad');
    $filtroProfesor = $request->input('profesor_id');

    $query = Curso::with('profesor')->withCount('alumnos'); // Cargar relación profesor y conteo de alumnos

    if ($searchTerm) {
        $lowerSearchTerm = strtolower($searchTerm);
        $query->where(function ($q) use ($lowerSearchTerm) {
            $q->where(DB::raw('LOWER(nombre)'), 'LIKE', "%{$lowerSearchTerm}%")
              ->orWhere(DB::raw('LOWER(codigo)'), 'LIKE', "%{$lowerSearchTerm}%");
        });
    }

    if ($filtroModalidad) {
        $query->where('modalidad', $filtroModalidad);
    }

    if ($filtroProfesor) {
        $query->where('profesor_id', $filtroProfesor);
    }

    $cursos = $query->orderBy('nombre', 'asc')->paginate(8)->appends($request->query());

    $opcionesModalidad = Curso::select('modalidad')->whereNotNull('modalidad')->distinct()->orderBy('modalidad')->pluck('modalidad');
    $opcionesProfesores = Profesor::orderBy('apellido1')->orderBy('nombre')->get(['id', 'nombre', 'apellido1']); // Para el select

    return view('admin.cursos.index', compact(
        'cursos',
        'searchTerm',
        'opcionesModalidad',
        'filtroModalidad',
        'opcionesProfesores',
        'filtroProfesor'
    ));
}

    // Aquí deberían estar los otros métodos generados por --resource
    // public function create() { /* ... */ }
    /**
 * Muestra el formulario para crear un nuevo Curso.
 */
public function create()
{
    // Obtener todos los profesores para el dropdown de asignación
    // Ordenarlos para que el select sea más fácil de usar
    $profesores = Profesor::orderBy('apellido1')->orderBy('nombre')->get(['id', 'nombre', 'apellido1']);

    // Podrías pasar otras opciones si las tienes (ej: modalidades fijas, niveles fijos)
    // $opcionesModalidad = ['Online', 'Presencial', 'Semipresencial (Blended)'];
    // $opcionesNivel = ['Básico', 'Intermedio', 'Avanzado'];

    return view('admin.cursos.create', compact(
        'profesores'
        // 'opcionesModalidad',
        // 'opcionesNivel'
    ));
}
    // public function store(Request $request) { /* ... */ }
    public function store(StoreCursoRequest $request)
        {
            // ¡YA NO NECESITAS $request->validate()!
        // Laravel lo hace automáticamente antes de ejecutar este código.
        
        // Simplemente crea el curso usando los datos ya validados.
        Curso::create($request->validated());

        return redirect()->route('admin.cursos.index')
                         ->with('success', 'Curso creado con éxito.');
        }

    // public function show(Curso $curso) { /* ... */ }
    /**
     * Muestra el recurso Curso especificado.
     */
    public function show(Curso $curso) // Route Model Binding
    {
        // Cargar las relaciones necesarias para mostrar en la vista de detalles
        $curso->load(['profesor', 'alumnos']);
        // 'profesor': para mostrar quién imparte el curso.
        // 'alumnos': para listar los alumnos inscritos (usando la relación belongsToMany).

        return view('admin.cursos.show', compact('curso'));
    }

    // public function edit(Curso $curso) { /* ... */ }

    /**
     * Muestra el formulario para editar el Curso especificado.
     */
    public function edit(Curso $curso) // Route Model Binding para $curso
    {
        // Obtener todos los profesores para el dropdown
        $profesores = Profesor::orderBy('apellido1')->orderBy('nombre')->get(['id', 'nombre', 'apellido1']);

        // Opcional: Si Modalidad y Nivel son selects con opciones fijas
        // $opcionesModalidad = ['Online', 'Presencial', 'Semipresencial (Blended)'];
        // $opcionesNivel = ['Básico', 'Intermedio', 'Avanzado'];

        return view('admin.cursos.edit', compact(
            'curso',
            'profesores'
            // 'opcionesModalidad',
            // 'opcionesNivel'
        ));
    }


    public function update(UpdateCursoRequest $request, Curso $curso) // <-- CAMBIAR AQUÍ
    {
        // ¡TAMPOCO NECESITAS $request->validate() AQUÍ!
        
        $curso->update($request->validated());

        return redirect()->route('admin.cursos.index')
                         ->with('success', 'Curso actualizado con éxito.');
    }

    
        // public function destroy(Curso $curso) { /* ... */ }

        /**
         * Elimina el recurso Curso especificado del almacenamiento.
         */
        public function destroy(Curso $curso) // Route Model Binding
        {
            try {
                // Verificar si el curso tiene alumnos inscritos
                // Usamos la relación 'alumnos' que definimos en el modelo Curso
                // o la relación 'inscripciones' si prefieres contar directamente en la tabla pivote.
                if ($curso->alumnos()->count() > 0) { // O $curso->inscripciones()->count() > 0
                    return redirect()->route('admin.cursos.index')
                                    ->with('error', "No se puede eliminar el curso '{$curso->nombre}' porque tiene alumnos inscritos. Desinscribe primero a los alumnos o considera archivar el curso.");
                }

                // Si el curso no tiene alumnos, se puede proceder a eliminar
                $nombreCurso = $curso->nombre;
                $curso->delete();

                return redirect()->route('admin.cursos.index')
                                ->with('success', "Curso '{$nombreCurso}' eliminado correctamente.");

            } catch (\Illuminate\Database\QueryException $e) {
                // Manejar otros errores de base de datos
                Log::error("Error al eliminar curso (QueryException) ID {$curso->id}: " . $e->getMessage());
                return redirect()->route('admin.cursos.index')
                                ->with('error', 'No se pudo eliminar el curso debido a un error en la base de datos o restricciones de integridad. Es posible que aún tenga datos asociados.');
            } catch (\Exception $e) {
                Log::error("Error inesperado al eliminar curso ID {$curso->id}: " . $e->getMessage());
                return redirect()->route('admin.cursos.index')
                                ->with('error', 'Ocurrió un error inesperado al intentar eliminar el curso.');
            }
        }

}