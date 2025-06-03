<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\PreinscritoSepe; // Asegúrate que el namespace es App\Models\PreinscritoSepe
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;   // Para la búsqueda con DB::raw()
use Illuminate\Support\Facades\Log;  // Para loguear errores
use Carbon\Carbon; // Descomenta si vuelves a usarlo para KPIs de fecha

class PreinscritoSepeController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
{
    $searchTerm = $request->input('search');
    $filtroEstadoPre = $request->input('estado_pre'); // Para el futuro filtro de estado

    $query = PreinscritoSepe::query();

    if ($searchTerm) {
        $lowerSearchTerm = strtolower($searchTerm);
        $query->where(function ($q) use ($lowerSearchTerm) {
            $q->where(DB::raw('LOWER(nombre)'), 'LIKE', "%{$lowerSearchTerm}%")
              ->orWhere(DB::raw('LOWER(apellido1)'), 'LIKE', "%{$lowerSearchTerm}%")
              ->orWhere(DB::raw('LOWER(dni)'), 'LIKE', "%{$lowerSearchTerm}%")
              ->orWhere(DB::raw('LOWER(email)'), 'LIKE', "%{$lowerSearchTerm}%");
        });
    }

    if ($filtroEstadoPre) {
        $query->where('estado', $filtroEstadoPre);
    }

    $preinscritos = $query->orderBy('fecha_importacion', 'desc')
                           ->orderBy('created_at', 'desc')
                           ->paginate(7)
                           ->appends($request->query());

    // KPIs (asegúrate de que tu modelo PreinscritoSepe tiene la columna 'estado')
    $totalPreinscritos = PreinscritoSepe::count(); // Reemplaza $preinscritos->total() en la vista si usas este
    $preinscritosPendientes = PreinscritoSepe::where('estado', 'Pendiente')->count();
    // $importadosHoy = PreinscritoSepe::whereDate('fecha_importacion', \Carbon\Carbon::today())->count(); // Asumiendo Carbon importado
    $importadosHoy = PreinscritoSepe::whereRaw('DATE(COALESCE(fecha_importacion, created_at)) = ?', [Carbon::today()->toDateString()])->count();
    $preinscritosConvertidos = PreinscritoSepe::where('estado', 'Convertido')->count();

    // Opciones para el filtro de estado
    $opcionesEstadoPre = PreinscritoSepe::select('estado')
                            ->whereNotNull('estado')
                            ->where('estado', '!=', '')
                            ->distinct()
                            ->orderBy('estado')
                            ->pluck('estado');
    // O puedes usar un array fijo si los estados no cambian:
    // $opcionesEstadoPre = collect(['Pendiente', 'Contactado', 'Convertido', 'Rechazado']);


    return view('admin.preinscritos.index', compact(
        'preinscritos',
        'searchTerm',
        'opcionesEstadoPre',
        'filtroEstadoPre',
        'totalPreinscritos',
        'preinscritosPendientes',
        'importadosHoy',
        'preinscritosConvertidos'
    ));
}

    /**
     * Muestra el formulario para crear un nuevo Preinscrito.
     */
    public function create()
    {
        // Si tuvieras <selects> con opciones fijas (ej: para 'estado' o 'nivel_formativo' predefinidos),
        // los pasarías aquí.
        // $opcionesNivel = ['ESO', 'Bachillerato', ...];
        // return view('admin.preinscritos.create', compact('opcionesNivel'));

        Log::info("Accediendo a PreinscritoSepeController@create"); // Log para verificar
        return view('admin.preinscritos.create');
    }

        /**
     * Almacena un nuevo PreinscritoSepe creado en el almacenamiento.
     */
    public function store(Request $request)
    {
        Log::info("Datos recibidos para crear Preinscrito:", $request->all());

        // Opciones válidas para los campos select (para la regla 'in')
        $opcionesValidasSexo = ['Hombre', 'Mujer', 'Otro'];
        $opcionesValidasNivelFormativo = ['Sin estudios', 'ESO', 'Bachillerato', 'Grado Medio', 'Grado Superior', 'Grado Universitario', 'Máster', 'Doctorado'];
        $opcionesValidasSituacionLaboral = ['Empleado a tiempo completo', 'Empleado a tiempo parcial', 'Desempleado', 'Estudiante', 'Jubilado', 'Autónomo'];
        $opcionesValidasEstadoPreinscrito = ['Pendiente', 'Contactado', 'Interesado', 'Convertido', 'Rechazado'];

        $validatedData = $request->validate([
            'nombre' => 'required|string|max:100',
            'apellido1' => 'required|string|max:100',
            'apellido2' => 'nullable|string|max:100',
            'dni' => 'required|string|max:15|regex:/^([0-9]{8}[A-Z]|[XYZ][0-9]{7}[A-Z])$/i|unique:preinscritos_sepe,dni',
            'email' => 'nullable|email|max:100|unique:preinscritos_sepe,email,NULL,id,deleted_at,NULL',
            'sexo' => 'nullable|string|in:' . implode(',', $opcionesValidasSexo),
            'fecha_nacimiento' => 'nullable|date|before_or_equal:today',
            'nacionalidad' => 'nullable|string|max:50',
            'num_seguridad_social' => 'nullable|string|max:20|unique:preinscritos_sepe,num_seguridad_social,NULL,id,deleted_at,NULL',

            'direccion' => 'nullable|string',
            'telefono' => 'nullable|string|max:20',
            'cp' => 'nullable|string|max:10',
            'localidad' => 'nullable|string|max:100',
            'provincia' => 'nullable|string|max:100',

            'nivel_formativo' => 'nullable|string|in:' . implode(',', $opcionesValidasNivelFormativo),
            'situacion_laboral' => 'nullable|string|in:' . implode(',', $opcionesValidasSituacionLaboral),
            'estado' => 'required|string|in:' . implode(',', $opcionesValidasEstadoPreinscrito),
            'fecha_importacion' => 'nullable|date_format:Y-m-d\TH:i', // Para datetime-local
        ]);

        // Si fecha_importacion no se envía o es nula, establecerla a now()
        // El input datetime-local la envía, así que esta lógica puede ser opcional si el campo está siempre presente.
        if (empty($validatedData['fecha_importacion'])) {
            $validatedData['fecha_importacion'] = Carbon::now();
        } else {
            // Convertir el formato de datetime-local a formato de base de datos si es necesario
            $validatedData['fecha_importacion'] = Carbon::parse($validatedData['fecha_importacion'])->format('Y-m-d H:i:s');
        }


        Log::info("Datos validados para crear PreinscritoSepe:", $validatedData);

        try {
            PreinscritoSepe::create($validatedData);
            Log::info("Preinscrito creado exitosamente.");
            return redirect()->route('admin.preinscritos.index')->with('success', 'Preinscrito añadido correctamente.');
        } catch (\Exception $e) {
            Log::error("Error al crear PreinscritoSepe: " . $e->getMessage(), ['exception' => $e]);
            return redirect()->back()
                             ->withInput() // Devuelve los datos antiguos al formulario
                             ->with('error', 'Hubo un error al guardar el preinscrito: ' . $e->getMessage());
        }
    }

    /**
     * Muestra el Preinscrito especificado.
     */
    public function show(PreinscritoSepe $preinscrito) // Route Model Binding
    {
        Log::info("PreinscritoSepeController@show: Accedido para preinscrito ID " . $preinscrito->id);
        // Lógica futura: // return view('admin.preinscritos.show', compact('preinscrito'));
        return "Detalles del preinscrito ID: {$preinscrito->id} (Pendiente de implementar la vista)";
    }

    /**
     * Muestra el formulario para editar el Preinscrito especificado.
     */
    public function edit(PreinscritoSepe $preinscrito) // Route Model Binding
    {
        Log::info("PreinscritoSepeController@edit: Accedido para preinscrito ID " . $preinscrito->id);
        // Lógica futura: // return view('admin.preinscritos.edit', compact('preinscrito'));
        return "Formulario para editar preinscrito ID: {$preinscrito->id} (Pendiente de implementar la vista)";
    }

    /**
     * Actualiza el Preinscrito especificado en el almacenamiento.
     */
    public function update(Request $request, PreinscritoSepe $preinscrito) // Route Model Binding
    {
        Log::info("PreinscritoSepeController@update: Accedido para preinscrito ID " . $preinscrito->id);
        // Lógica futura:
        // $validatedData = $request->validate([...]);
        // $preinscrito->update($validatedData);
        // return redirect()->route('admin.preinscritos.show', $preinscrito->id)->with('success', 'Preinscrito actualizado.');
        return redirect()->route('admin.preinscritos.index')->with('info', 'Funcionalidad de actualizar preinscrito pendiente.');
    }

    /**
     * Elimina el Preinscrito especificado del almacenamiento.
     */
    public function destroy(PreinscritoSepe $preinscrito) // Route Model Binding
    {
        Log::info("PreinscritoSepeController@destroy: Accedido para preinscrito ID " . $preinscrito->id);
        // Lógica futura:
        // $preinscrito->delete();
        // return redirect()->route('admin.preinscritos.index')->with('success', 'Preinscrito eliminado.');
        return redirect()->route('admin.preinscritos.index')->with('info', 'Funcionalidad de eliminar preinscrito pendiente.');
    }

    /**
     * Convierte un Preinscrito a Alumno.
     */
    public function convertirAAlumno(PreinscritoSepe $preinscrito) // Route Model Binding
    {
        Log::info("PreinscritoSepeController@convertirAAlumno: Accedido para preinscrito ID " . $preinscrito->id);
        // Lógica futura:
        // ... (verificar duplicados en Alumno, crear Alumno, actualizar estado de Preinscrito) ...
        // return redirect()->route('admin.alumnos.show', $nuevoAlumno->id)->with('success', 'Preinscrito convertido a Alumno.');
        return redirect()->route('admin.preinscritos.index')->with('info', 'Funcionalidad de convertir a alumno pendiente.');
    }
}