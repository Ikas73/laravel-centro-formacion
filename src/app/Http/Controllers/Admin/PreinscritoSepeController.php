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
                           ->paginate(10)
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
        Log::info("PreinscritoSepeController@create: Accedido.");
        // Lógica futura: // return view('admin.preinscritos.create');
        return "Formulario para crear preinscrito (Pendiente de implementar la vista)";
    }

    /**
     * Almacena un nuevo Preinscrito creado.
     */
    public function store(Request $request)
    {
        Log::info("PreinscritoSepeController@store: Accedido.");
        // Lógica futura:
        // $validatedData = $request->validate([...]);
        // PreinscritoSepe::create($validatedData);
        // return redirect()->route('admin.preinscritos.index')->with('success', 'Preinscrito añadido.');
        return redirect()->route('admin.preinscritos.index')->with('info', 'Funcionalidad de guardar preinscrito pendiente.');
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