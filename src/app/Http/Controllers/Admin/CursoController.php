<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Curso; // Importa el modelo Curso
use App\Models\Profesor;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB; // Si planeas usar DB::raw
use Illuminate\Support\Facades\Log;

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

    $cursos = $query->orderBy('nombre', 'asc')->paginate(7)->appends($request->query());

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
    public function store(Request $request)
        {
            // 1. Validación de Datos
            // Ajusta las reglas según tus necesidades (ej: si código es único, etc.)
            $validatedData = $request->validate([
                'nombre' => 'required|string|max:255',
                'codigo' => 'nullable|string|max:20|unique:cursos,codigo',
                'descripcion' => 'nullable|string',
                'modalidad' => 'required|string|in:Online,Presencial,Semipresencial (Blended)', // Si son opciones fijas
                'nivel' => 'nullable|string|max:50',
                'requisitos' => 'nullable|string',
                'fecha_inicio' => 'nullable|date|after_or_equal:today',
                'fecha_fin' => 'nullable|date|after_or_equal:fecha_inicio', // Asegura que fin no sea antes que inicio
                'horas_totales' => 'nullable|integer|min:1',
                'horario' => 'nullable|string|max:100',
                'centros' => 'nullable|string|max:255',
                'profesor_id' => 'required|exists:profesores,id', // Asegura que el profesor_id existe en la tabla profesores
                'plazas_maximas' => 'required|integer|min:1|max:500', // Ejemplo max
            ]);

            // 2. Creación del Curso
            Curso::create($validatedData);

            // 3. Redirección con Mensaje de Éxito
            return redirect()->route('admin.cursos.index')
                             ->with('success', '¡Curso añadido correctamente!');
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


    // public function update(Request $request, Curso $curso) { /* ... */ }
    public function update(Request $request, Curso $curso) // Route Model Binding
        {
            // 1. Validación de Datos (ajusta reglas 'unique' si es necesario)
            $validatedData = $request->validate([
                'nombre' => 'required|string|max:255',
                'codigo' => 'nullable|string|max:20|unique:cursos,codigo,' . $curso->id, // Ignora el código del curso actual
                'descripcion' => 'nullable|string',
                'modalidad' => 'required|string|in:Online,Presencial,Semipresencial (Blended)',
                'nivel' => 'nullable|string|max:50',
                'requisitos' => 'nullable|string',
                'fecha_inicio' => 'nullable|date', // Podrías añadir 'after_or_equal:today' si no se pueden editar a fechas pasadas
                'fecha_fin' => 'nullable|date|after_or_equal:fecha_inicio',
                'horas_totales' => 'nullable|integer|min:1',
                'horario' => 'nullable|string|max:100',
                'centros' => 'nullable|string|max:255',
                'profesor_id' => 'required|exists:profesores,id',
                'plazas_maximas' => 'required|integer|min:1|max:500',
            ]);

            // 2. Actualización del Curso
            $curso->update($validatedData);

            // 3. Redirección con Mensaje de Éxito
            return redirect()->route('admin.cursos.show', $curso->id) // Redirige a la vista de detalles
                             ->with('success', '¡Curso actualizado correctamente!');
        }

    // public function destroy(Curso $curso) { /* ... */ }
}