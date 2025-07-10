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
        $allSchedules = Schedule::with(['curso', 'profesor'])->get();

        // 1. Separar las reglas, excepciones y cancelaciones
        $recurringRules = $allSchedules->where('is_recurring', true);
        $exceptions = $allSchedules->where('is_recurring', false)->where('is_cancelled', false);
        $cancellations = $allSchedules->where('is_cancelled', true)->keyBy(function ($item) {
            return $item['parent_id'] . '_' . $item['original_date'];
        });

        $events = collect();

        // 2. Procesar las reglas de recurrencia
        foreach ($recurringRules as $rule) {
            if (!$rule->curso || !$rule->curso->fecha_inicio || !$rule->curso->fecha_fin) {
                continue;
            }

            $diasRrule = ['SU', 'MO', 'TU', 'WE', 'TH', 'FR', 'SA'];
            $diaDeLaSemana = $diasRrule[$rule->dia_semana];
            $dtstart = $rule->curso->fecha_inicio->format('Y-m-d') . 'T' . $rule->hora_inicio;
            $until = $rule->curso->fecha_fin->format('Y-m-d');
            $duration = Carbon::parse($rule->hora_inicio)->diff(Carbon::parse($rule->hora_fin))->format('%H:%I:%S');

            // Encontrar las cancelaciones para esta regla
            $exdates = $allSchedules->where('is_cancelled', true)
                                     ->where('parent_id', $rule->id)
                                     ->map(function ($cancellation) use ($rule) {
                                         // CRÍTICO: Formatear la fecha de exclusión a UTC ISO 8601
                                         $localDateTime = Carbon::parse($cancellation->original_date . ' ' . $rule->hora_inicio, config('app.timezone'));
                                         return $localDateTime->setTimezone('UTC')->format('Y-m-d\TH:i:s\Z');
                                     })
                                     ->values()->all();

            $events->push([
                'id'        => $rule->id,
                'title'     => $rule->curso->nombre,
                'duration'  => $duration,
                'rrule'     => [
                    'freq'    => 'weekly',
                    'byweekday' => [$diaDeLaSemana],
                    'dtstart' => $dtstart,
                    'until'   => $until,
                ],
                'exdate' => $exdates, // Añadir fechas de exclusión
                'extendedProps' => [
                    'profesor' => optional($rule->profesor)->nombre . ' ' . optional($rule->profesor)->apellido1,
                    'aula'     => $rule->aula,
                    'curso_id' => $rule->curso->id
                ],
                'backgroundColor' => $this->stringToColor($rule->curso->nombre),
                'borderColor'     => $this->stringToColor($rule->curso->nombre, -20),
            ]);
        }

        // 3. Procesar las excepciones como eventos individuales
        foreach ($exceptions as $exception) {
            if (!$exception->curso) {
                continue;
            }
            
            // La fecha del evento es la `original_date` y el día de la semana puede haber cambiado
            $startDateTime = Carbon::parse($exception->original_date . ' ' . $exception->hora_inicio);
            $endDateTime = Carbon::parse($exception->original_date . ' ' . $exception->hora_fin);

            // Ajustar la fecha al día de la semana correcto si ha cambiado
            $diaSemanaOriginal = $startDateTime->dayOfWeekIso; // 1-7

            if ($exception->dia_semana != $diaSemanaOriginal) {
                 $diff = $exception->dia_semana - $diaSemanaOriginal;
                 $startDateTime->addDays($diff);
                 $endDateTime->addDays($diff);
            }


            $events->push([
                'id'        => $exception->id,
                'title'     => $exception->curso->nombre,
                'start'     => $startDateTime->format('Y-m-d\TH:i:s'),
                'end'       => $endDateTime->format('Y-m-d\TH:i:s'),
                'extendedProps' => [
                    'profesor' => optional($exception->profesor)->nombre . ' ' . optional($exception->profesor)->apellido1,
                    'aula'     => $exception->aula,
                    'curso_id' => $exception->curso->id,
                    'is_exception' => true // Marcar como excepción
                ],
                'backgroundColor' => $this->stringToColor($exception->curso->nombre, 20), // Tono más claro para excepciones
                'borderColor'     => $this->stringToColor($exception->curso->nombre, 0),
            ]);
        }

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
        $editType = $request->input('edit_type', 'toda_la_serie'); // 'toda_la_serie' o 'solo_este'

        if ($editType === 'toda_la_serie') {
            // Lógica para actualizar la serie completa (comportamiento actual)
            $schedule->update([
                'curso_id'     => $validated['curso_id'],
                'profesor_id'  => $validated['profesor_id'],
                'dia_semana'   => $validated['weekday'],
                'hora_inicio'  => $validated['start_time'],
                'hora_fin'     => $validated['end_time'],
                'aula'         => $validated['room'],
            ]);
        } else {
            // Lógica para editar solo este evento (crear excepción)
            $originalDate = $validated['original_date'];

            // 1. Crear la cancelación para la fecha original.
            // Esto marca la ocurrencia original como "saltada".
            Schedule::create([
                'parent_id'     => $schedule->id,
                'is_recurring'  => false,
                'is_cancelled'  => true,
                'original_date' => $originalDate,
                'curso_id'      => $schedule->curso_id,
                'profesor_id'   => $schedule->profesor_id,
                'dia_semana'    => $schedule->dia_semana, // El día original
                'hora_inicio'   => $schedule->hora_inicio,
                'hora_fin'      => $schedule->hora_fin,
                'aula'          => $schedule->aula,
            ]);

            // 2. Crear la excepción (la nueva ocurrencia en la nueva fecha/hora).
            Schedule::create([
                'parent_id'     => $schedule->id,
                'is_recurring'  => false,
                'is_cancelled'  => false,
                'original_date' => $originalDate, // Referencia a qué día se movió
                'curso_id'      => $validated['curso_id'],
                'profesor_id'   => $validated['profesor_id'],
                'dia_semana'    => $validated['weekday'],
                'hora_inicio'   => $validated['start_time'],
                'hora_fin'      => $validated['end_time'],
                'aula'          => $validated['room'],
            ]);
        }

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