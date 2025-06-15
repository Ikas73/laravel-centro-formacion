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
     * Convierte un PreinscritoSepe a un nuevo registro de Alumno.
     */
    public function convertirAAlumno(PreinscritoSepe $preinscrito) // Route Model Binding
    {
        Log::info("Intentando convertir Preinscrito ID: {$preinscrito->id} a Alumno.");

        // 1. Verificar si ya existe un Alumno con el mismo DNI o Email
        // Esto ayuda a prevenir duplicados accidentales si se intenta convertir dos veces
        // o si el alumno ya fue registrado manualmente.
        $alumnoExistente = Alumno::where('dni', $preinscrito->dni)
                                ->orWhere(function($query) use ($preinscrito) {
                                    if (!empty($preinscrito->email)) { // Solo buscar por email si el preinscrito tiene uno
                                        $query->where('email', $preinscrito->email);
                                    }
                                })
                                ->first();

        if ($alumnoExistente) {
            Log::warning("Intento de convertir Preinscrito ID: {$preinscrito->id} fallido. Ya existe un Alumno con DNI/Email similar (ID Alumno: {$alumnoExistente->id}).");
            return redirect()->route('admin.preinscritos.show', $preinscrito->id)
                            ->with('error', 'No se pudo convertir. Ya existe un alumno registrado con el mismo DNI o Email.');
        }

        // 2. Mapear y Preparar datos para el nuevo Alumno
        // Asegúrate de que los campos aquí coinciden con las columnas de tu tabla 'alumnos'
        // y con lo que tienes en $fillable del modelo Alumno.
        $datosNuevoAlumno = [
            'nombre' => $preinscrito->nombre,
            'apellido1' => $preinscrito->apellido1,
            'apellido2' => $preinscrito->apellido2,
            'dni' => $preinscrito->dni,
            'email' => $preinscrito->email,
            'telefono' => $preinscrito->telefono,
            'fecha_nacimiento' => $preinscrito->fecha_nacimiento,
            'sexo' => $preinscrito->sexo, // Asumiendo que preinscritos tiene 'sexo'
            'direccion' => $preinscrito->direccion,
            'cp' => $preinscrito->cp,
            'localidad' => $preinscrito->localidad,
            'provincia' => $preinscrito->provincia,
            'nacionalidad' => $preinscrito->nacionalidad,
            'situacion_laboral' => $preinscrito->situacion_laboral,
            'nivel_formativo' => $preinscrito->nivel_formativo,
            'num_seguridad_social' => $preinscrito->num_seguridad_social, // Si preinscritos lo tiene y alumnos también
            'estado' => 'Activo', // Establecer un estado por defecto para el nuevo alumno
            // Añade cualquier otro campo que el modelo Alumno requiera y que no esté en Preinscrito,
            // o que deba tener un valor por defecto al convertirse.
        ];

        try {
            // 4. Crear el nuevo Alumno
            $nuevoAlumno = Alumno::create($datosNuevoAlumno); // Usar los datos validados/mapeados
            Log::info("Preinscrito ID: {$preinscrito->id} convertido a Alumno ID: {$nuevoAlumno->id} exitosamente.");

            // 5. Actualizar estado del Preinscrito o Eliminarlo
            $preinscrito->update(['estado' => 'Convertido']); // Asumiendo que tienes un campo 'estado' en PreinscritoSepe
            // O podrías eliminarlo:
            // $preinscrito->delete();
            Log::info("Estado del Preinscrito ID: {$preinscrito->id} actualizado a 'Convertido'.");


            // 6. Redirigir al perfil del nuevo alumno creado
            return redirect()->route('admin.alumnos.show', $nuevoAlumno->id)
                            ->with('success', "Preinscrito '{$preinscrito->nombre} {$preinscrito->apellido1}' convertido a Alumno (ID: {$nuevoAlumno->id}) correctamente.");

        } catch (\Illuminate\Validation\ValidationException $e) {
            // Esto podría ocurrir si la validación opcional de arriba falla y no la manejaste antes.
            Log::error("Error de validación al crear Alumno desde Preinscrito ID {$preinscrito->id}: " . $e->getMessage(), $e->errors());
            return redirect()->route('admin.preinscritos.show', $preinscrito->id)
                            ->with('error', 'Error de validación al crear el alumno. Revisa los datos del preinscrito.')
                            ->withErrors($e->validator);
        } catch (\Exception $e) {
            Log::error("Error al convertir Preinscrito ID {$preinscrito->id} a Alumno: " . $e->getMessage(), ['exception' => $e]);
            return redirect()->route('admin.preinscritos.index')
                            ->with('error', 'Ocurrió un error inesperado al convertir el preinscrito a alumno.');
        }
    }
}