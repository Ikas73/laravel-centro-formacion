<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\PreinscritoSepe;
use App\Models\Alumno;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Carbon\Carbon;
use Illuminate\Validation\Rule;
use App\Rules\NotExistsInTables; 

class PreinscritoSepeController extends Controller
{
    public function index(Request $request)
    {
        $searchTerm = $request->input('search');
        $filtroEstadoPre = $request->input('estado_pre');

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

        $totalPreinscritos = PreinscritoSepe::count();
        $preinscritosPendientes = PreinscritoSepe::where('estado', 'Pendiente')->count();
        $importadosHoy = PreinscritoSepe::whereRaw('DATE(COALESCE(fecha_importacion, created_at)) = ?', [Carbon::today()->toDateString()])->count();
        $preinscritosConvertidos = PreinscritoSepe::where('estado', 'Convertido')->count();

        $opcionesEstadoPre = PreinscritoSepe::select('estado')
                                ->whereNotNull('estado')
                                ->where('estado', '!=', '')
                                ->distinct()
                                ->orderBy('estado')
                                ->pluck('estado');

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
        Log::info("Accediendo a PreinscritoSepeController@create");
        // Opciones para los <select> del formulario
        $opcionesSexo = ['Hombre', 'Mujer', 'Otro'];
        $opcionesNivelFormativo = ['Sin estudios', 'ESO', 'Bachillerato', 'Grado Medio', 'Grado Superior', 'Grado Universitario', 'Máster', 'Doctorado'];
        $opcionesSituacionLaboral = ['Empleado a tiempo completo', 'Empleado a tiempo parcial', 'Desempleado', 'Estudiante', 'Jubilado', 'Autónomo'];
        $opcionesEstadoPreinscrito = ['Pendiente', 'Contactado', 'Interesado', 'Convertido', 'Rechazado'];

        return view('admin.preinscritos.create', compact(
            'opcionesSexo',
            'opcionesNivelFormativo',
            'opcionesSituacionLaboral',
            'opcionesEstadoPreinscrito'
        ));
    }

    public function store(Request $request)
    {
        Log::info("Datos recibidos para crear Preinscrito:", $request->all());
    
        $opcionesValidasSexo = ['Hombre', 'Mujer', 'Otro'];
        $opcionesValidasNivelFormativo = ['Sin estudios', 'ESO', 'Bachillerato', 'Grado Medio', 'Grado Superior', 'Grado Universitario', 'Máster', 'Doctorado'];
        $opcionesValidasSituacionLaboral = ['Empleado a tiempo completo', 'Empleado a tiempo parcial', 'Desempleado', 'Estudiante', 'Jubilado', 'Autónomo'];
        $opcionesValidasEstadoPreinscrito = ['Pendiente', 'Contactado', 'Interesado', 'Convertido', 'Rechazado'];
    
        $validatedData = $request->validate([
            'nombre' => 'required|string|max:100',
            'apellido1' => 'required|string|max:100',
            'apellido2' => 'nullable|string|max:100',
            'dni' => [
                'required', 'string', 'max:15',
                'regex:/^([0-9]{8}[A-Z]|[XYZ][0-9]{7}[A-Z])$/i',
                'unique:preinscritos_sepe,dni', // Regla 'unique' simple para 'store'
            ],
            'email' => 'nullable|email|max:100|unique:preinscritos_sepe,email',
            'sexo' => ['nullable', 'string', Rule::in($opcionesValidasSexo)],
            'fecha_nacimiento' => 'nullable|date|before_or_equal:today',
            'nacionalidad' => 'nullable|string|max:50',
            'num_seguridad_social' => 'nullable|string|max:20|unique:preinscritos_sepe,num_seguridad_social',
            'direccion' => 'nullable|string',
            'telefono' => 'nullable|string|max:20',
            'cp' => 'nullable|string|max:10',
            'localidad' => 'nullable|string|max:100',
            'provincia' => 'nullable|string|max:100',
            'nivel_formativo' => ['nullable', 'string', Rule::in($opcionesValidasNivelFormativo)],
            'situacion_laboral' => ['nullable', 'string', Rule::in($opcionesValidasSituacionLaboral)],
            'estado' => ['required', 'string', Rule::in($opcionesValidasEstadoPreinscrito)],
            'fecha_importacion' => 'nullable|date_format:Y-m-d\TH:i',
        ]);
    
        if (empty($validatedData['fecha_importacion'])) {
            $validatedData['fecha_importacion'] = now();
        } else {
            $validatedData['fecha_importacion'] = Carbon::parse($validatedData['fecha_importacion'])->format('Y-m-d H:i:s');
        }
    
        try {
            PreinscritoSepe::create($validatedData);
            return redirect()->route('admin.preinscritos.index')->with('success', 'Preinscrito añadido correctamente.');
        } catch (\Exception $e) {
            Log::error("Error al crear PreinscritoSepe: " . $e->getMessage(), ['exception' => $e]);
            return redirect()->back()->withInput()->with('error', 'Hubo un error al guardar el preinscrito.');
        }
    }
    

    /**
     * Muestra el recurso PreinscritoSepe especificado.
     */
    public function show(PreinscritoSepe $preinscrito) // Route Model Binding
    {
        Log::info("Mostrando detalles para Preinscrito ID: " . $preinscrito->id);
        // No hay relaciones complejas que cargar para un preinscrito por ahora,
        // a menos que lo hayas asociado a un curso de interés, etc.

        return view('admin.preinscritos.show', compact('preinscrito'));
    }

    /**
     * Muestra el formulario para editar el Preinscrito especificado.
     */
    public function edit(PreinscritoSepe $preinscrito) // Route Model Binding
    {
        Log::info("Accediendo a PreinscritoSepeController@edit para preinscrito ID " . $preinscrito->id);

        // Pasa las opciones necesarias para los <select> en tu edit.blade.php
        $opcionesValidasSexo = ['Hombre', 'Mujer', 'Otro'];
        $opcionesValidasNivelFormativo = ['Sin estudios', 'ESO', 'Bachillerato', 'Grado Medio', 'Grado Superior', 'Grado Universitario', 'Máster', 'Doctorado'];
        $opcionesValidasSituacionLaboral = ['Empleado a tiempo completo', 'Empleado a tiempo parcial', 'Desempleado', 'Estudiante', 'Jubilado', 'Autónomo'];
        $opcionesValidasEstadoPreinscrito = ['Pendiente', 'Contactado', 'Interesado', 'Convertido', 'Rechazado'];

        return view('admin.preinscritos.edit', compact(
            'preinscrito',
            'opcionesValidasSexo',
            'opcionesValidasNivelFormativo',
            'opcionesValidasSituacionLaboral',
            'opcionesValidasEstadoPreinscrito'
        ));
    }

    /**
     * Actualiza el Preinscrito especificado en el almacenamiento.
     */
    public function update(Request $request, PreinscritoSepe $preinscrito)
    {
        Log::info("Recibiendo datos para PreinscritoSepe@update para ID " . $preinscrito->id, $request->all());

        $opcionesValidasSexo = ['Hombre', 'Mujer', 'Otro'];
        $opcionesValidasNivelFormativo = ['Sin estudios', 'ESO', 'Bachillerato', 'Grado Medio', 'Grado Superior', 'Grado Universitario', 'Máster', 'Doctorado'];
        $opcionesValidasSituacionLaboral = ['Empleado a tiempo completo', 'Empleado a tiempo parcial', 'Desempleado', 'Estudiante', 'Jubilado', 'Autónomo'];
        $opcionesValidasEstadoPreinscrito = ['Pendiente', 'Contactado', 'Interesado', 'Convertido', 'Rechazado'];

        $validatedData = $request->validate([
            'nombre' => 'required|string|max:100',
            'apellido1' => 'required|string|max:100',
            'apellido2' => 'nullable|string|max:100',
            'dni' => [
                'required', 'string', 'max:15', 'regex:/^([0-9]{8}[A-Z]|[XYZ][0-9]{7}[A-Z])$/i',
                Rule::unique('preinscritos_sepe', 'dni')->ignore($preinscrito->id), // Correcto para update
            ],
            'email' => [
                'nullable', 'email', 'max:100',
                Rule::unique('preinscritos_sepe', 'email')->ignore($preinscrito->id), // Correcto para update
            ],
            'sexo' => ['nullable', 'string', Rule::in($opcionesValidasSexo)],
            'fecha_nacimiento' => 'nullable|date|before_or_equal:today',
            'nacionalidad' => 'nullable|string|max:50',
            'num_seguridad_social' => [
                'nullable', 'string', 'max:20',
                Rule::unique('preinscritos_sepe', 'num_seguridad_social')->ignore($preinscrito->id), // Correcto para update
            ],
            'direccion' => 'nullable|string',
            'telefono' => 'nullable|string|max:20',
            'cp' => 'nullable|string|max:10',
            'localidad' => 'nullable|string|max:100',
            'provincia' => 'nullable|string|max:100',
            'nivel_formativo' => ['nullable', 'string', Rule::in($opcionesValidasNivelFormativo)],
            'situacion_laboral' => ['nullable', 'string', Rule::in($opcionesValidasSituacionLaboral)],
            'estado' => ['required', 'string', Rule::in($opcionesValidasEstadoPreinscrito)],
            'fecha_importacion' => 'nullable|date_format:Y-m-d\TH:i',
        ]);

        if ($request->filled('fecha_importacion')) {
            $validatedData['fecha_importacion'] = Carbon::parse($request->input('fecha_importacion'))->format('Y-m-d H:i:s');
        } else {
            if ($request->has('fecha_importacion') && !$request->filled('fecha_importacion')) {
                unset($validatedData['fecha_importacion']);
            }
        }

        try {
            $preinscrito->update($validatedData);
            return redirect()->route('admin.preinscritos.show', $preinscrito->id)
                            ->with('success', 'Preinscrito actualizado correctamente.');
        } catch (\Exception $e) {
            Log::error("Error al actualizar PreinscritoSepe ID " . $preinscrito->id . ": " . $e->getMessage(), ['exception' => $e]);
            return redirect()->back()->withInput()->with('error', 'Hubo un error al actualizar el preinscrito.');
        }
    }

    /**
     * Elimina el Preinscrito especificado del almacenamiento.
     */
    public function destroy(PreinscritoSepe $preinscrito) // Route Model Binding
    {
        Log::info("Intentando eliminar Preinscrito ID: {$preinscrito->id}");
        try {
            $nombreCompleto = $preinscrito->nombre . ' ' . $preinscrito->apellido1;
            $preinscrito->delete();
            Log::info("Preinscrito ID {$preinscrito->id} ('{$nombreCompleto}') eliminado.");
            return redirect()->route('admin.preinscritos.index')->with('success', "Preinscrito '{$nombreCompleto}' eliminado correctamente.");
        } catch (\Exception $e) {
            Log::error("Error al eliminar Preinscrito ID {$preinscrito->id}: " . $e->getMessage());
            return redirect()->route('admin.preinscritos.index')->with('error', 'No se pudo eliminar el preinscrito.');
        }
    }

   
    /**
     * Convierte un PreinscritoSepe a Alumno.
     */
    public function convertirAAlumno(PreinscritoSepe $preinscrito)
    {
        Log::info("Intentando convertir Preinscrito ID {$preinscrito->id} a Alumno.");

        /* -----------------------------------------------------------------
         | 1) Cortocircuito si YA está convertido
         *-----------------------------------------------------------------*/
        if ($preinscrito->estado === 'Convertido') {
            return back()->with('error', 'Este preinscrito ya fue convertido.');
        }

        /* -----------------------------------------------------------------
         | 2) Comprobar si existe otro alumno con mismo DNI o e-mail
         *-----------------------------------------------------------------*/
        $alumnoExistente = Alumno::where('dni', $preinscrito->dni)
            ->orWhere(function ($q) use ($preinscrito) {
                if ($preinscrito->email) {
                    $q->where('email', $preinscrito->email);
                }
            })
            ->first();

        if ($alumnoExistente) {
            Log::warning("Conversión abortada: duplicado DNI/Email (Alumno ID {$alumnoExistente->id}).");
            return back()->with('error',
                'Ya existe un alumno con el mismo DNI o correo electrónico.');
        }

        /* -----------------------------------------------------------------
         | 3) Preparar datos para el nuevo alumno
         *-----------------------------------------------------------------*/
        $datosNuevoAlumno = [
            'nombre'              => $preinscrito->nombre,
            'apellido1'           => $preinscrito->apellido1,
            'apellido2'           => $preinscrito->apellido2,
            'dni'                 => $preinscrito->dni,
            'email'               => $preinscrito->email,
            'telefono'            => $preinscrito->telefono,
            'fecha_nacimiento'    => $preinscrito->fecha_nacimiento,
            'sexo'                => $preinscrito->sexo,
            'direccion'           => $preinscrito->direccion,
            'cp'                  => $preinscrito->cp,
            'localidad'           => $preinscrito->localidad,
            'provincia'           => $preinscrito->provincia,
            'nacionalidad'        => $preinscrito->nacionalidad,
            'situacion_laboral'   => $preinscrito->situacion_laboral,
            'nivel_formativo'     => $preinscrito->nivel_formativo,
            'num_seguridad_social'=> $preinscrito->num_seguridad_social,
            'estado'              => 'Activo',   // estado inicial en la tabla alumnos
        ];

        /* -----------------------------------------------------------------
         | 4) Ejecución atómica
         *-----------------------------------------------------------------*/
        DB::beginTransaction();

        try {
            // 4a. Crear alumno
            $alumno = Alumno::create($datosNuevoAlumno);

            // 4b. Marcar preinscrito
            $preinscrito->update([
                'estado'     => 'Convertido',
                'alumno_id'  => $alumno->id,
            ]);

            DB::commit();

            Log::info("Preinscrito ID {$preinscrito->id} -> Alumno ID {$alumno->id} OK.");
            return redirect()
                ->route('admin.alumnos.show', $alumno->id)
                ->with('success',
                    "Preinscrito '{$preinscrito->nombre} {$preinscrito->apellido1}' convertido correctamente.");

        } catch (\Throwable $e) {
            DB::rollBack();
            Log::error("Error al convertir Preinscrito ID {$preinscrito->id}: {$e->getMessage()}",
                       ['exception' => $e]);
            return back()->with('error',
                'Ocurrió un error inesperado al convertir el preinscrito.');
        }
    }


    
}