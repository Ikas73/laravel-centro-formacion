<?php

namespace App\Rules;

// IMPORTAMOS LAS INTERFACES NECESARIAS
use Illuminate\Contracts\Validation\Rule;
use Illuminate\Contracts\Validation\DataAwareRule; // <-- CORRECCIÓN 1: Importar DataAwareRule
use App\Models\Schedule;

class NoScheduleOverlap implements Rule, DataAwareRule // <-- CORRECCIÓN 2: Implementar DataAwareRule
{
    /**
     * Todos los datos del formulario.
     * @var array
     */
    protected $data = [];

    /**
     * El ID del horario que estamos editando, para ignorarlo en la comprobación.
     * @var int|null
     */
    protected $scheduleIdToIgnore;

    public function __construct($scheduleIdToIgnore = null)
    {
        $this->scheduleIdToIgnore = $scheduleIdToIgnore;
    }

    /**
     * Set the data under validation.
     * Este método AHORA SÍ será llamado por Laravel antes de 'passes()'.
     *
     * @param  array  $data
     * @return $this
     */
    public function setData(array $data)
    {
        $this->data = $data;
        return $this;
    }

    /**
     * Determine if the validation rule passes.
     */
    public function passes($attribute, $value)
    {
        // Extraemos los datos del array $this->data
        $weekday = $this->data['weekday'] ?? null;
        $startTime = $value; // El valor del campo actual (start_time)
        $endTime = $this->data['end_time'] ?? null;
        $profesorId = $this->data['profesor_id'] ?? null;
        $room = $this->data['room'] ?? null;

        // Si falta algún dato esencial, la regla no puede ejecutarse, pero otras reglas lo capturarán.
        if (is_null($weekday) || is_null($startTime) || is_null($endTime) || is_null($profesorId) || is_null($room)) {
            return true;
        }

        $query = Schedule::query()
            ->join('time_slots', 'schedules.time_slot_id', '=', 'time_slots.id')
            ->where('time_slots.weekday', $weekday)
            // La condición clave para detectar solapamiento de tiempo:
            // (start1 < end2) AND (end1 > start2)
            ->where('time_slots.start_time', '<', $endTime)
            ->where('time_slots.end_time', '>', $startTime)
            ->where(function ($q) use ($profesorId, $room) {
                $q->where('schedules.profesor_id', $profesorId)
                  ->orWhere('time_slots.room', $room);
            });

        if ($this->scheduleIdToIgnore) {
            $query->where('schedules.id', '!=', $this->scheduleIdToIgnore);
        }

        return !$query->exists();
    }

    /**
     * Get the validation error message.
     */
    public function message()
    {
        return 'Conflicto de horario: El profesor o el aula ya están ocupados en el intervalo de tiempo seleccionado.';
    }
}