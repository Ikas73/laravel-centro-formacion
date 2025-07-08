<?php

namespace App\Rules;

use Illuminate\Contracts\Validation\Rule;
use Illuminate\Contracts\Validation\DataAwareRule;
use App\Models\Schedule;

class NoScheduleOverlap implements Rule, DataAwareRule
{
    protected $data = [];
    protected $scheduleIdToIgnore;
    protected $conflictType = [];

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


        if (is_null($weekday) || is_null($startTime) || is_null($endTime)) {
            return true;
        }

        $baseQuery = Schedule::query()
            ->where('dia_semana', $weekday)
            ->where('hora_inicio', '<', $endTime)
            ->where('hora_fin', '>', $startTime);

        if ($this->scheduleIdToIgnore) {
            $baseQuery->where('id', '!=', $this->scheduleIdToIgnore);
        }

        // Verificar conflicto de profesor (si está especificado)
        $profesorConflict = false;
        if ($profesorId) {
            $profesorConflict = (clone $baseQuery)->where('profesor_id', $profesorId)->exists();
        }

        // Verificar conflicto de aula (si está especificada)
        $aulaConflict = false;
        if ($room) {
            $aulaConflict = (clone $baseQuery)->where('aula', $room)->exists();
        }

        // Guardar información sobre el tipo de conflicto para el mensaje
        $this->conflictType = [];
        if ($profesorConflict) $this->conflictType[] = 'profesor';
        if ($aulaConflict) $this->conflictType[] = 'aula';

        // Hay conflicto si el profesor YA está ocupado O si el aula YA está ocupada
        return !($profesorConflict || $aulaConflict);
    }

    public function message()
    {
        if (empty($this->conflictType)) {
            return 'Conflicto de horario detectado.';
        }
        
        if (in_array('profesor', $this->conflictType) && in_array('aula', $this->conflictType)) {
            return 'Conflicto de horario: El profesor y el aula ya están ocupados en este intervalo de tiempo.';
        } elseif (in_array('profesor', $this->conflictType)) {
            return 'Conflicto de horario: El profesor ya tiene una clase programada en este intervalo de tiempo.';
        } else {
            return 'Conflicto de horario: El aula ya está ocupada en este intervalo de tiempo.';
        }
    }
}