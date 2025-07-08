<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreScheduleRequest;
use App\Http\Requests\UpdateScheduleRequest;
use App\Models\Schedule;
use App\Models\Curso;
use App\Models\Profesor;
use App\Models\TimeSlot;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Rules\NoScheduleOverlap;

class ScheduleController extends Controller
{
    /**
     * Muestra la vista principal del calendario.
     */
    public function index()
    {
        // Obtenemos los datos necesarios para los selects del formulario del modal
        $cursos = Curso::orderBy('nombre')->get(['id', 'nombre']);
        $profesores = Profesor::orderBy('apellido1')->get(['id', 'nombre', 'apellido1']);
        
        // Obtenemos las aulas únicas de los schedules existentes
        $aulas = Schedule::select('aula')
            ->whereNotNull('aula')
            ->where('aula', '!=', '')
            ->distinct()
            ->orderBy('aula')
            ->pluck('aula')
            ->toArray();

        return view('admin.schedules.index', compact('cursos', 'profesores', 'aulas'));
    }

    /**
     * Obtiene y formatea los eventos para FullCalendar,
     * alineado con la migración real.
     */
    public function fetchEvents()
{
    // Carga los horarios junto con la información del curso y del profesor
    $schedules = Schedule::with(['curso', 'profesor'])->get();

    $events = $schedules->map(function ($schedule) {
        // --- Comprobación de seguridad ---
        // Si un horario no tiene curso o el curso no tiene fechas, no lo podemos dibujar.
        if (!$schedule->curso || !$schedule->curso->fecha_inicio || !$schedule->curso->fecha_fin) {
            return null; // Omitir este evento
        }

        // --- Mapeo del día de la semana ---
        // Tu BD: 1=Lunes, 2=Martes ... 0=Domingo
        // RRULE: MO, TU, WE, TH, FR, SA, SU
        $diasRrule = ['SU', 'MO', 'TU', 'WE', 'TH', 'FR', 'SA'];
        $diaDeLaSemana = $diasRrule[$schedule->dia_semana];

        // --- Formateo de fechas y horas ---
        $dtstart = $schedule->curso->fecha_inicio->format('Y-m-d') . 'T' . $schedule->hora_inicio;
        $until = $schedule->curso->fecha_fin->format('Y-m-d');
        
        // La duración se calcula para que FullCalendar sepa cuánto dura cada evento recurrente
        $duracion = Carbon::parse($schedule->hora_inicio)
                          ->diff(Carbon::parse($schedule->hora_fin))
                          ->format('%H:%I:%S');

        return [
            'id'        => $schedule->id,
            'title'     => $schedule->curso->nombre, // Título del evento
            'duration'  => $duracion,               // Duración de cada ocurrencia
            
            // --- La Magia de la Recurrencia ---
            'rrule'     => [
                'freq'    => 'weekly',        // Frecuencia: semanal
                'byweekday' => [$diaDeLaSemana],  // El día de la semana específico
                'dtstart' => $dtstart,          // Cuándo empieza la primera ocurrencia
                'until'   => $until,            // Cuándo termina la serie de repeticiones
            ],

            // --- Información Extra para mostrar en el evento ---
            'extendedProps' => [
                'profesor' => optional($schedule->profesor)->nombre . ' ' . optional($schedule->profesor)->apellido1,
                'aula'     => $schedule->aula,
                'curso_id' => $schedule->curso->id
            ],

            // --- Colores (opcional pero muy útil) ---
            'backgroundColor' => $this->stringToColor($schedule->curso->nombre),
            'borderColor'     => $this->stringToColor($schedule->curso->nombre, -20),
        ];
    })->filter(); // Elimina los eventos nulos que omitimos

    return response()->json($events);
}

    public function store(StoreScheduleRequest $request)
    {
        $validated = $request->validated();

        // Lógica correcta: crear directamente el Schedule
        Schedule::create([
            'curso_id'     => $validated['curso_id'],
            'profesor_id'  => $validated['profesor_id'],
            'dia_semana'   => $validated['weekday'], // Asegúrate que el request usa 'weekday'
            'hora_inicio'  => $validated['start_time'],
            'hora_fin'     => $validated['end_time'],
            'aula'         => $validated['room'],
        ]);

        return response()->json(['message' => 'Horario creado con éxito.'], 201);
    }

    /**
     * Devuelve los datos de un horario específico para la edición.
     */
    public function show(Schedule $schedule)
    {
        return response()->json([
            'curso_id'    => $schedule->curso_id,
            'profesor_id' => $schedule->profesor_id,
            'hora_inicio' => \Carbon\Carbon::parse($schedule->hora_inicio)->format('H:i'),
            'hora_fin'    => \Carbon\Carbon::parse($schedule->hora_fin)->format('H:i'),
            'aula'        => $schedule->aula,
            'dia_semana'  => $schedule->dia_semana,
        ]);
    }

    /**
     * Actualiza un horario existente en la base de datos.
     */
    public function update(UpdateScheduleRequest $request, Schedule $schedule)
    {
        $validated = $request->validated();

        $schedule->update([
            'curso_id'     => $validated['curso_id'],
            'profesor_id'  => $validated['profesor_id'],
            'dia_semana'   => $validated['weekday'],
            'hora_inicio'  => $validated['start_time'],
            'hora_fin'     => $validated['end_time'],
            'aula'         => $validated['room'],
        ]);

        return response()->json(['message' => 'Horario actualizado con éxito.']);
    }

    /**
     * Verifica si un horario potencial entra en conflicto con los existentes.
     * Reutiliza la lógica de la regla NoScheduleOverlap.
     */
    public function checkConflict(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'start_time'  => ['required', new NoScheduleOverlap($request->input('schedule_id'))],
            'end_time'    => 'required|after:start_time',
            'weekday'     => 'required|integer|between:0,6',
            'profesor_id' => 'nullable|exists:profesores,id',
            'room'        => 'nullable|string|max:255',
            'schedule_id' => 'nullable|exists:schedules,id',
        ]);

        if ($validator->fails()) {
            // Si la validación falla, significa que hay un conflicto.
            return response()->json([
                'has_conflict' => true,
                // Devolvemos el primer mensaje de error de la regla personalizada.
                'message' => $validator->errors()->first('start_time')
            ]);
        }

        // Si la validación pasa, no hay conflicto.
        return response()->json([
            'has_conflict' => false,
            'message' => 'No hay conflictos de horario.'
        ]);
    }

    /**
     * Helper para generar un color consistente a partir de un string.
     */
    private function stringToColor($str, $lightnessAdjustment = 0)
    {
        $hash = 0;
        for ($i = 0; $i < strlen($str); $i++) {
            $hash = ord($str[$i]) + (($hash << 5) - $hash);
        }
        $hue = $hash % 360;
        $lightness = 50 + $lightnessAdjustment;
        return "hsl({$hue}, 80%, {$lightness}%)";
    }

    /**
     * Muestra una vista con todos los conflictos de horarios.
     */
    public function showConflicts()
    {
        $schedules = Schedule::with(['curso', 'profesor'])->orderBy('aula')->orderBy('dia_semana')->orderBy('hora_inicio')->get();
        $conflicts = $this->detectConflicts($schedules);

        return view('admin.schedules.conflicts', compact('conflicts'));
    }

    /**
     * Detecta conflictos de horarios en una colección de schedules.
     *
     * @param \Illuminate\Database\Eloquent\Collection $schedules
     * @return array
     */
    private function detectConflicts($schedules)
    {
        $conflicts = [];
        $checked = [];

        foreach ($schedules as $schedule1) {
            foreach ($schedules as $schedule2) {
                if ($schedule1->id >= $schedule2->id) {
                    continue;
                }

                $isConflict = false;

                // Conflicto de aula
                if ($schedule1->aula === $schedule2->aula &&
                    $schedule1->dia_semana === $schedule2->dia_semana &&
                    $schedule1->hora_inicio < $schedule2->hora_fin &&
                    $schedule1->hora_fin > $schedule2->hora_inicio) {
                    $isConflict = true;
                    $conflictType = 'Aula';
                }

                // Conflicto de profesor
                if ($schedule1->profesor_id && $schedule2->profesor_id &&
                    $schedule1->profesor_id === $schedule2->profesor_id &&
                    $schedule1->dia_semana === $schedule2->dia_semana &&
                    $schedule1->hora_inicio < $schedule2->hora_fin &&
                    $schedule1->hora_fin > $schedule2->hora_inicio) {
                    $isConflict = true;
                    $conflictType = isset($conflictType) ? 'Aula y Profesor' : 'Profesor';
                }

                if ($isConflict) {
                    $keyArray = [$schedule1->id, $schedule2->id];
                    sort($keyArray);
                    $key = implode('-', $keyArray);

                    if (!isset($checked[$key])) {
                        $conflicts[] = [
                            'schedule1' => $schedule1,
                            'schedule2' => $schedule2,
                            'type' => $conflictType
                        ];
                        $checked[$key] = true;
                    }
                }
            }
        }

        return $conflicts;
    }
}