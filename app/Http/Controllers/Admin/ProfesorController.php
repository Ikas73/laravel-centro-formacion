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
    public function create()
{
    // Podrías pasar listas de opciones para <selects> si las tienes (ej: tipos de titulación, especialidades fijas)
     $opcionesTitulacion = ['Licenciatura', 'Grado', 'Máster', 'Doctorado', 'Ingeniería Técnica', 'Otra'];
     $opcionesEspecialidad = ['Desarrollo Web', 'Bases de Datos', 'Redes', 'Marketing Digital', 'Finanzas', 'Otra'];
     
     return view('admin.profesores.create', compact('opcionesTitulacion', 'opcionesEspecialidad'));

    //return view('admin.profesores.create');
}

/**
 * Almacena un nuevo recurso Profesor creado en el almacenamiento.
 */
public function store(Request $request)
{
    
    $validatedData = $request->validate([
        'nombre' => 'required|string|max:100',
        'apellido1' => 'required|string|max:100',
        'apellido2' => 'nullable|string|max:100',
        'dni' => [
            'required',
            'string',
            'max:15',
            'regex:/^([0-9]{8}[A-Z]|[XYZ][0-9]{7}[A-Z])$/i',
            'unique:profesores,dni',
        ],
        'email' => 'required|email|max:100|unique:profesores,email',
        'fecha_nacimiento' => 'nullable|date|before_or_equal:today',
        'sexo' => 'nullable|string|in:Hombre,Mujer,Otro',
        'direccion' => 'nullable|string',
        'telefono' => 'nullable|string|max:20',
        'num_seguridad_social' => 'nullable|string|max:20|unique:profesores,num_seguridad_social',

        
        'titulacion_academica' => 'nullable|string|in:' . implode(',', Profesor::TITULACIONES_VALIDAS),
        'especialidad' => 'nullable|string|in:' . implode(',', Profesor::ESPECIALIDADES_VALIDAS),
    ]);

    Profesor::create($validatedData);

    return redirect()->route('admin.profesores.index')
                     ->with('success', '¡Profesor añadido correctamente!');
}

// Debes hacer un cambio similar en el método update(), recordando añadir la
// excepción del ID actual si el campo es 'unique', aunque para 'titulacion_academica'
// o 'especialidad' no suelen ser únicos.
public function update(Request $request, Profesor $profesore)
{
    
    $validatedData = $request->validate([
        'nombre' => 'required|string|max:100',
        'apellido1' => 'required|string|max:100',
        'apellido2' => 'nullable|string|max:100',
        'dni' => [
            'required',
            'string',
            'max:15',
            'regex:/^([0-9]{8}[A-Z]|[XYZ][0-9]{7}[A-Z])$/i',
            'unique:profesores,dni,' . $profesore->id, // Ignora el DNI del profesor actual
        ],
        'email' => 'required|email|max:100|unique:profesores,email,' . $profesore->id,
        'fecha_nacimiento' => 'nullable|date|before_or_equal:today',
        'sexo' => 'nullable|string|in:Hombre,Mujer,Otro',
        'direccion' => 'nullable|string',
        'telefono' => 'nullable|string|max:20',
        'num_seguridad_social' => 'nullable|string|max:20|unique:profesores,num_seguridad_social,' . $profesore->id,

        
        'titulacion_academica' => 'nullable|string|in:' . implode(',', Profesor::TITULACIONES_VALIDAS),
        'especialidad' => 'nullable|string|in:' . implode(',', Profesor::ESPECIALIDADES_VALIDAS),
        
    ]);

    $profesore->update($validatedData);

    return redirect()->route('admin.profesores.show', $profesore->id)
                     ->with('success', '¡Profesor actualizado correctamente!');
}

public function destroy(Profesor $profesore) // Asegúrate que la variable es $profesore
{
    try {
        if ($profesore->cursos()->count() > 0) {
            return redirect()->route('admin.profesores.index')
                             ->with('error', "No se puede eliminar el profesor '{$profesore->nombre} {$profesore->apellido1}' porque tiene cursos asignados. Reasigna o elimina esos cursos primero.");
        }

        $nombreCompleto = $profesore->nombre . ' ' . $profesore->apellido1;
        $profesore->delete(); // Intento de eliminación

        return redirect()->route('admin.profesores.index')
                         ->with('success', "Profesor '{$nombreCompleto}' eliminado correctamente.");

    } catch (\Illuminate\Database\QueryException $e) {
        // Loguear el error real para más detalles
        \Illuminate\Support\Facades\Log::error("Error al eliminar profesor (QueryException) ID {$profesore->id}: " . $e->getMessage());
        return redirect()->route('admin.profesores.index')
                         ->with('error', 'No se pudo eliminar el profesor. Error de base de datos o restricción de integridad.');
    } catch (\Exception $e) {
        \Illuminate\Support\Facades\Log::error("Error inesperado al eliminar profesor ID {$profesore->id}: " . $e->getMessage());
        return redirect()->route('admin.profesores.index')
                         ->with('error', 'Ocurrió un error inesperado al intentar eliminar el profesor.');
    }
}


/**
 * Muestra el recurso Profesor especificado.
 */
public function show(Profesor $profesore) // Route Model Binding
{
    // Cargar la relación 'cursos' para tener acceso a los cursos que imparte
    // el profesor en la vista de detalles.
    $profesore->load('cursos');

    return view('admin.profesores.show', compact('profesore'));
}

// En app/Http/Controllers/Admin/ProfesorController.php

public function edit(Profesor $profesore) // Route Model Binding
{
    // Si necesitaras pasar opciones para <select> (ej: lista de especialidades o titulaciones
    // definidas centralmente), las obtendrías aquí y las pasarías con compact().
     $opcionesTitulacion = Profesor::TITULACIONES_VALIDAS; // Si las tienes como constante en el modelo
     $opcionesEspecialidad = Profesor::ESPECIALIDADES_VALIDAS;

    // return view('admin.profesores.edit', compact('profesore', 'opcionesTitulacion', 'opcionesEspecialidad'));
    return view('admin.profesores.edit', compact('profesore'));
}
}