<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Curso; // Importa el modelo Curso
use App\Models\Profesor;
use App\Models\Schedule;
use Carbon\Carbon;
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
        $curso->load(['profesor', 'alumnos', 'schedules']);
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


    public function update(UpdateCursoRequest $request, Curso $curso)
    {
        // Usar transacción para asegurar consistencia
        DB::beginTransaction();
        
        try {
            // Eliminar horarios antiguos ANTES de actualizar el curso
            $curso->schedules()->delete();
            
            // Actualizar el curso
            $curso->update($request->validated());

            $horarioString = $request->validated()['horario'] ?? null;

            if ($horarioString) {
                $parsedData = $this->parseHorario($horarioString);

                foreach ($parsedData as $data) {
                    Schedule::create([
                        'curso_id' => $curso->id,
                        'profesor_id' => $curso->profesor_id,
                        'dia_semana' => $data['weekday'],
                        'hora_inicio' => $data['start_time'],
                        'hora_fin' => $data['end_time'],
                        'aula' => $curso->centros ?? 'Aula General'
                    ]);
                }
            }
            
            DB::commit();
            
            return redirect()->route('admin.cursos.index')
                             ->with('success', 'Curso actualizado y horarios sincronizados con éxito.');
                             
        } catch (\Exception $e) {
            DB::rollBack();
            Log::error("Error al actualizar curso {$curso->id}: " . $e->getMessage());
            
            return redirect()->back()
                             ->withInput()
                             ->with('error', 'Ocurrió un error al actualizar el curso. Por favor, inténtalo de nuevo.');
        }
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

    /**
     * Parsea el string de horario y devuelve un array de datos.
     *
     * @param string $horarioString
     * @return array
     */
    private function parseHorario(string $horarioString): array
    {
        $parsed = [];

        // Caso 1: Formato "HH:MM-HH:MM L-V (Xh)" o "09:00-15:00 L-V (6h)"
        if (preg_match('/(\d{1,2}:\d{2})-(\d{1,2}:\d{2})\s+L-V/i', $horarioString, $matches)) {
            $startTime = Carbon::parse($matches[1])->format('H:i:s');
            $endTime = Carbon::parse($matches[2])->format('H:i:s');
            for ($day = 1; $day <= 5; $day++) { // Lunes a Viernes
                $parsed[] = ['weekday' => $day, 'start_time' => $startTime, 'end_time' => $endTime];
            }
            return $parsed;
        }

        // Caso 2: Formato "HH:MM-HH:MM y HH:MM-HH:MM L-J (Xh Mixto)"
        if (preg_match('/(\d{1,2}:\d{2})-(\d{1,2}:\d{2})\s+y\s+(\d{1,2}:\d{2})-(\d{1,2}:\d{2})\s+L-J/i', $horarioString, $matches)) {
            $startTime1 = Carbon::parse($matches[1])->format('H:i:s');
            $endTime1 = Carbon::parse($matches[2])->format('H:i:s');
            $startTime2 = Carbon::parse($matches[3])->format('H:i:s');
            $endTime2 = Carbon::parse($matches[4])->format('H:i:s');
            for ($day = 1; $day <= 4; $day++) { // Lunes a Jueves
                $parsed[] = ['weekday' => $day, 'start_time' => $startTime1, 'end_time' => $endTime1];
                $parsed[] = ['weekday' => $day, 'start_time' => $startTime2, 'end_time' => $endTime2];
            }
            return $parsed;
        }

        // Caso 3: Formato "Fines de semana (S HH:MM-HH:MM)"
        if (preg_match('/Fines de semana\s+\(S\s+(\d{1,2}:\d{2})-(\d{1,2}:\d{2})\)/i', $horarioString, $matches)) {
            $startTime = Carbon::parse($matches[1])->format('H:i:s');
            $endTime = Carbon::parse($matches[2])->format('H:i:s');
            $parsed[] = ['weekday' => 6, 'start_time' => $startTime, 'end_time' => $endTime]; // Sábado
            return $parsed;
        }

        return $parsed;
    }

}
