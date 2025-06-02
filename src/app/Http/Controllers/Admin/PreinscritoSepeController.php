<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Models\PreinscritoSepe;
use Illuminate\Http\Request;

class PreinscritoSepeController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    

public function index(Request $request)
{
    $searchTerm = $request->input('search');
    // $filtroEstadoPre = $request->input('estado_pre'); // Futuro filtro

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

    // if ($filtroEstadoPre) {
    //     $query->where('estado', $filtroEstadoPre);
    // }

    // Ordenar por fecha de importación o creación descendente para ver los más nuevos primero
    $preinscritos = $query->orderBy('fecha_importacion', 'desc')
                           ->orderBy('created_at', 'desc')
                           ->paginate(10) // O el número que prefieras
                           ->appends($request->query());

    // $opcionesEstadoPre = ['Pendiente', 'Contactado', 'Convertido', 'Rechazado']; // Ejemplo para futuro filtro

    return view('admin.preinscritos.index', compact(
        'preinscritos',
        'searchTerm'
        // 'opcionesEstadoPre',
        // 'filtroEstadoPre'
    ));
}

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
{
    $validatedData = $request->validate([
        'nombre' => 'required|string|max:100',
        'apellido1' => 'required|string|max:100',
        'apellido2' => 'nullable|string|max:100',
        'dni' => 'required|string|max:15|unique:preinscritos_sepe,dni', // Único en esta tabla
        'email' => 'nullable|email|max:100|unique:preinscritos_sepe,email', // Puede ser opcional pero único
        'telefono' => 'nullable|string|max:20',
        // ... otros campos como fecha_nacimiento, direccion, localidad, provincia, cp,
        // nacionalidad, situacion_laboral, nivel_formativo, fecha_importacion, estado (si lo tienes)
    ]);
    // Si fecha_importacion no viene del form, la puedes añadir aquí:
    // $validatedData['fecha_importacion'] = now();

    PreinscritoSepe::create($validatedData);
    return redirect()->route('admin.preinscritos.index')->with('success', 'Preinscrito añadido correctamente.');
}

    /**
     * Display the specified resource.
     */
    public function show(PreinscritoSepe $preinscrito)
{
    return view('admin.preinscritos.show', compact('preinscrito'));
}

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(PreinscritoSepe $preinscritoSepe)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, PreinscritoSepe $preinscritoSepe)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(PreinscritoSepe $preinscrito)
{
    // Opción 1: Eliminación simple
    $preinscrito->delete();
    return redirect()->route('admin.preinscritos.index')->with('success', 'Preinscrito eliminado correctamente.');

    // Opción 2: Cambiar estado (si tienes un campo 'estado')
    // $preinscrito->update(['estado' => 'Rechazado']);
    // return redirect()->route('admin.preinscritos.index')->with('success', 'Preinscrito marcado como rechazado.');
}
}
