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
        $ratioAlumnoProfesor = ($totalProfesores > 0 && $totalAlumnosActivos > 0) ? round($totalAlumnosActivos / $totalProfesores, 1).':1' : 'N/A';
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

    // En Admin/AlumnoController.php

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

    // En Admin/AlumnoController.php

    /**
     * Almacena un nuevo recurso creado en el almacenamiento.
     */
    public function store(Request $request)
    {
        // ------ 1. Validación de Datos ------
        // Define aquí las reglas de validación para cada campo
        // Asegúrate de que los nombres coincidan con los atributos 'name' del formulario
        $validatedData = $request->validate([
            'nombre' => 'required|string|max:100',
            'apellido1' => 'required|string|max:100',
            'apellido2' => 'nullable|string|max:100', // 'nullable' significa que puede estar vacío
            'dni' => 'required|string|max:15|unique:alumnos,dni', // 'unique:alumnos,dni' asegura que el DNI no exista ya en la tabla 'alumnos'
            'email' => 'required|email|max:100|unique:alumnos,email', // 'email' valida formato y 'unique' para que no se repita
            'fecha_nacimiento' => 'required|date|before_or_equal:today', // Debe ser una fecha y no futura
            'nivel_formativo' => 'required|string|max:100', // Ajusta si usas valores específicos (ej: 'in:ESO,Bachiller,...')
            'estado' => 'required|string|in:Activo,Inactivo,Pendiente,Baja', // Asegura que el estado sea uno de los permitidos
            // Añade aquí todas las demás columnas de tu tabla 'alumnos' que vengan del formulario con sus reglas
            // Por ejemplo:
            // 'num_seguridad_social' => 'nullable|string|max:20|unique:alumnos,num_seguridad_social',
            // 'sexo' => 'nullable|string|in:Hombre,Mujer,Otro',
            // 'direccion' => 'nullable|string',
            // 'cp' => 'nullable|string|max:10',
            // 'localidad' => 'nullable|string|max:100',
            // 'provincia' => 'nullable|string|max:100',
            // 'telefono' => 'nullable|string|max:20',
            // 'nacionalidad' => 'nullable|string|max:50',
            // 'situacion_laboral' => 'nullable|string|max:100',
        ]);

        // ------ 2. Creación del Alumno ------
        // Si la validación pasa, $validatedData contendrá solo los datos validados.
        // Asegúrate de que todos estos campos están en la propiedad $fillable de tu modelo Alumno.
        Alumno::create($validatedData);

        // ------ 3. Redirección con Mensaje de Éxito ------
        return redirect()->route('admin.alumnos.index')
            ->with('success', '¡Alumno añadido correctamente!');
        // 'success' es el nombre de la variable de sesión flash.
    }
    // ... otros métodos ...
}
