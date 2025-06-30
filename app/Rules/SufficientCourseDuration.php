<?php

namespace App\Rules;

use Illuminate\Contracts\Validation\Rule;
use Illuminate\Contracts\Validation\DataAwareRule;
use App\Models\Curso;
use App\Models\Schedule;
use Carbon\Carbon;

class SufficientCourseDuration implements Rule, DataAwareRule
{
    protected $data = [];
    protected $scheduleIdToIgnore = null;
    protected $courseTotalHours = 0;

    public function __construct($scheduleIdToIgnore = null)
    {
        $this->scheduleIdToIgnore = $scheduleIdToIgnore;
    }

    public function setData(array $data)
    {
        $this->data = $data;
        return $this;
    }

    public function passes($attribute, $value)
    {
        $cursoId = $this->data['curso_id'] ?? null;
        $startTime = $this->data['start_time'] ?? null;
        $endTime = $this->data['end_time'] ?? null;

        // Si faltan datos básicos, otras reglas se encargarán. No fallamos aquí.
        if (!$cursoId || !$startTime || !$endTime) {
            return true;
        }

        // 1. Obtener la duración total del curso
        $curso = Curso::find($cursoId);
        if (!$curso || !$curso->horas_totales) {
            // Si el curso no tiene horas definidas, no podemos validar.
            return true;
        }
        $this->courseTotalHours = $curso->horas_totales;

        // 2. Calcular la duración del nuevo bloque de horario en horas
        $newHours = Carbon::parse($startTime)->diffInMinutes(Carbon::parse($endTime)) / 60.0;

        // 3. Calcular la suma de horas de los horarios YA existentes para este curso
        $existingHours = Schedule::query()
            ->where('curso_id', $cursoId)
            ->when($this->scheduleIdToIgnore, function ($query) {
                // Si estamos editando, excluimos el horario actual de la suma
                $query->where('id', '!=', $this->scheduleIdToIgnore);
            })
            ->join('time_slots', 'schedules.time_slot_id', '=', 'time_slots.id')
            ->sum(DB::raw('EXTRACT(EPOCH FROM (time_slots.end_time - time_slots.start_time)) / 3600'));

        // 4. Comprobar si el total excede la duración del curso
        return ($existingHours + $newHours) <= $this->courseTotalHours;
    }

    public function message()
    {
        return 'La duración total de los horarios programados no puede exceder las ' . $this->courseTotalHours . ' horas totales del curso.';
    }
}