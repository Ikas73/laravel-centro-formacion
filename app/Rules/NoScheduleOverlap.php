<?php

namespace App\Rules;

use Illuminate\Contracts\Validation\Rule;
use Illuminate\Contracts\Validation\DataAwareRule;
use App\Models\Schedule;

class NoScheduleOverlap implements Rule, DataAwareRule
{
    protected $data = [];
    protected $scheduleIdToIgnore;

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
        $weekday = $this->data['weekday'] ?? null;
        $startTime = $value;
        $endTime = $this->data['end_time'] ?? null;
        $profesorId = $this->data['profesor_id'] ?? null;
        $room = $this->data['room'] ?? null;

        if (is_null($weekday) || is_null($startTime) || is_null($endTime) || (is_null($profesorId) && is_null($room))) {
            return true;
        }

        $query = Schedule::query()
            ->where('dia_semana', $weekday)
            ->where('hora_inicio', '< ', $endTime)
            ->where('hora_fin', '>', $startTime)
            ->where(function ($q) use ($profesorId, $room) {
                $q->where('profesor_id', $profesorId)
                  ->orWhere('aula', $room);
            });

        if ($this->scheduleIdToIgnore) {
            $query->where('id', '!=', $this->scheduleIdToIgnore);
        }

        return !$query->exists();
    }

    public function message()
    {
        return 'Conflicto de horario: El profesor o el aula ya están ocupados en el intervalo de tiempo seleccionado.';
    }
}