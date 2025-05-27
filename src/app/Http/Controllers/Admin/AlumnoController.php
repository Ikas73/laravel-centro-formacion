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

/**
 * Muestra el formulario para editar el recurso especificado.
 */
public function edit(Alumno $alumno) // Route Model Binding inyecta el Alumno
{
    // Al igual que en create(), podríamos pasar opciones para <selects> si fuera necesario
    // $opcionesEstado = ['Activo', 'Inactivo', 'Pendiente', 'Baja'];
    // return view('admin.alumnos.edit', compact('alumno', 'opcionesEstado'));

    return view('admin.alumnos.edit', compact('alumno'));
}    

/**
 * Muestra el formulario para crear un nuevo recurso.
 */
public function create()
{
    // Por ahora, solo necesitamos mostrar la vista.
    // Más adelante, si el formulario necesita 'options' para <select> (ej: lista de estados),
    // se pasarían aquí.
    // Por ejemplo, si el estado se elige de una lista fija:
    // $opcionesEstado = ['Activo', 'Inactivo', 'Pendiente', 'Baja'];
    // return view('admin.alumnos.create', compact('opcionesEstado'));

    return view('admin.alumnos.create');
}



/**
 * Muestra el recurso especificado.
 * Gracias al Route Model Binding, Laravel automáticamente busca y
 * nos inyecta el objeto Alumno correspondiente al ID en la URL.
 */
public function show(Alumno $alumno) // Laravel inyecta el objeto Alumno
{
    // Aquí podrías cargar relaciones si las vas a mostrar en la vista de detalle
    // Ejemplo: $alumno->load('cursosInscritos'); // Si tienes una relación así
    // (Asumiendo que $alumno ya tiene la relación 'cursos' definida)
    $alumno->load('cursos'); // Para la relación ManyToMany

    return view('admin.alumnos.show', compact('alumno'));
}


/**
 * Almacena un nuevo recurso creado en el almacenamiento.
 */
public function store(Request $request)
{
    // ------ 1. Validación de Datos ------
    // Asegúrate de que los nombres aquí ('nombre', 'apellido1', etc.)
    // coinciden EXACTAMENTE con los atributos 'name' de tus campos de formulario
    // en create.blade.php.
    $validatedData = $request->validate([
        'nombre' => 'required|string|max:100',
        'apellido1' => 'required|string|max:100',
        'apellido2' => 'nullable|string|max:100',
        'dni' => 'required|string|max:15|unique:alumnos,dni',
        'email' => 'required|email|max:100|unique:alumnos,email',
        'sexo' => 'required|string|in:Hombre,Mujer,Otro', // Validación para el select
        'fecha_nacimiento' => 'required|date|before_or_equal:today',
        'nacionalidad' => 'required|string|max:50',
        'numero_seguridad_social' => 'required|string|max:20|unique:alumnos,num_seguridad_social', // Asegúrate del nombre del campo

        // Campos de la sección "Información de Contacto"
        'direccion_completa' => 'required|string', // Nombre del textarea
        'telefono' => 'required|string|max:20',
        'codigo_postal' => 'required|string|max:10',
        'localidad' => 'required|string|max:100',
        'provincia' => 'required|string|max:100',

        // Campos de la sección "Información Académica y Laboral"
        'nivel_formativo' => 'required|string|max:100',
        'situacion_laboral' => 'required|string|max:100',
        'estado' => 'required|string|in:Activo,Inactivo,Pendiente,Baja',
    ]);

    // ------ 2. Creación del Alumno ------
    // Esto asume que todos los campos en $validatedData están en la propiedad $fillable
    // de tu modelo App\Models\Alumno.
    Alumno::create($validatedData);

    // ------ 3. Redirección con Mensaje de Éxito ------
    return redirect()->route('admin.alumnos.index')
                     ->with('success', '¡Alumno añadido correctamente!');
}

/**
 * Actualiza el recurso especificado en el almacenamiento.
 */
public function update(Request $request, Alumno $alumno) // Inyectar Request y el Alumno a actualizar
{
    // ------ 1. Validación de Datos ------
    // Similar a store(), pero ajusta las reglas 'unique' para ignorar el registro actual
    $validatedData = $request->validate([
        'nombre' => 'required|string|max:100',
        'apellido1' => 'required|string|max:100',
        'apellido2' => 'nullable|string|max:100',
        // Para 'unique', debemos ignorar el DNI/email del alumno actual
        'dni' => 'required|string|max:15|unique:alumnos,dni,' . $alumno->id,
        'email' => 'required|email|max:100|unique:alumnos,email,' . $alumno->id,
        'fecha_nacimiento' => 'required|date|before_or_equal:today',
        'nivel_formativo' => 'required|string|max:100',
        'estado' => 'required|string|in:Activo,Inactivo,Pendiente,Baja',
        // ... añade todas las demás reglas de validación ...
        /* Por ejemplo:
        'num_seguridad_social' => 'nullable|string|max:20|unique:alumnos,num_seguridad_social,' . $alumno->id,
        'sexo' => 'nullable|string|in:Hombre,Mujer,Otro',
        'direccion' => 'nullable|string',
        'cp' => 'nullable|string|max:10',
        'localidad' => 'nullable|string|max:100',
        'provincia' => 'nullable|string|max:100',
        'telefono' => 'nullable|string|max:20',
        'nacionalidad' => 'nullable|string|max:50',
        'situacion_laboral' => 'nullable|string|max:100',
        */
    ]);

    // ------ 2. Actualización del Alumno ------
    $alumno->update($validatedData);

    // ------ 3. Redirección con Mensaje de Éxito ------
    return redirect()->route('admin.alumnos.show', $alumno->id) // Redirige a la vista de detalles del alumno
                     ->with('success', '¡Alumno actualizado correctamente!');
}

// En Admin/AlumnoController.php

/**
 * Elimina el recurso especificado del almacenamiento.
 */
public function destroy(Alumno $alumno) // Route Model Binding inyecta el Alumno
{
    try {
        $nombreCompleto = $alumno->nombre . ' ' . $alumno->apellido1; // Guardar nombre para el mensaje
        $alumno->delete(); // Elimina el alumno de la base de datos

        // Podrías añadir aquí lógica adicional si necesitas eliminar datos relacionados
        // que no se eliminan en cascada (ej: archivos, etc.), aunque las inscripciones
        // en alumno_curso deberían tener ON DELETE CASCADE si quieres que se borren también.

        return redirect()->route('admin.alumnos.index')
                         ->with('success', "Alumno '{$nombreCompleto}' eliminado correctamente.");

    } catch (\Illuminate\Database\QueryException $e) {
        // Manejar errores de base de datos (ej: si hay restricciones de clave foránea que impiden borrar)
        // Loguear el error también es una buena práctica: Log::error($e->getMessage());
        return redirect()->route('admin.alumnos.index')
                         ->with('error', 'No se pudo eliminar el alumno. Es posible que tenga datos asociados (ej: cursos inscritos) que impiden su eliminación o hubo un error en la base de datos.');
    } catch (\Exception $e) {
        // Manejar otros errores inesperados
        // Log::error($e->getMessage());
        return redirect()->route('admin.alumnos.index')
                         ->with('error', 'Ocurrió un error inesperado al intentar eliminar el alumno.');
    }
}
}