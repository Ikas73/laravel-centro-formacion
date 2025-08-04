<?php

namespace App\Rules;

use Illuminate\Contracts\Validation\Rule;
use Illuminate\Contracts\Validation\DataAwareRule;
use App\Models\Schedule;
use Illuminate\Support\Facades\Log;

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
        $editType = $this->data['edit_type'] ?? null;
        $originalDate = $this->data['original_date'] ?? null;

        if (is_null($weekday) || is_null($startTime) || is_null($endTime)) {
            return true;
        }

        $query = Schedule::query()
            ->where('dia_semana', $weekday)
            ->where('hora_inicio', '<', $endTime)
            ->where('hora_fin', '>', $startTime)
            ->where('is_cancelled', false); // Excluir eventos cancelados

        $idsToIgnore = [];
        if ($this->scheduleIdToIgnore) {
            $idsToIgnore[] = $this->scheduleIdToIgnore;
        }

        // Si estamos moviendo una sola ocurrencia, debemos ignorar el schedule "padre"
        // en la fecha original para evitar un falso positivo de conflicto.
        if ($editType === 'solo_este' && $originalDate) {
            $currentSchedule = Schedule::with('parent')->find($this->scheduleIdToIgnore);
            
            Log::info('NoScheduleOverlap - Validando movimiento de excepción', [
                'scheduleIdToIgnore' => $this->scheduleIdToIgnore,
                'currentSchedule' => $currentSchedule ? $currentSchedule->toArray() : null,
                'editType' => $editType,
                'originalDate' => $originalDate,
                'newWeekday' => $weekday,
                'newTime' => $startTime . ' - ' . $endTime
            ]);

            if ($currentSchedule) {
                // Si es una excepción (no recurrente con parent_id), agregar el padre
                if (!$currentSchedule->is_recurring && $currentSchedule->parent_id) {
                    $idsToIgnore[] = $currentSchedule->parent_id;
                    Log::info('Agregando parent_id a ignorar', ['parent_id' => $currentSchedule->parent_id]);
                }
                
                // Si es un evento recurrente padre, asegurarnos de ignorarlo
                if ($currentSchedule->is_recurring) {
                    // Ya está en idsToIgnore desde arriba
                    Log::info('Schedule es recurrente (padre)', ['id' => $currentSchedule->id]);
                }
            }
        }
        
        if (!empty($idsToIgnore)) {
            $query->whereNotIn('id', $idsToIgnore);
            Log::info('IDs a ignorar en la validación', ['idsToIgnore' => $idsToIgnore]);
        }

        // Clonamos la consulta base para las comprobaciones específicas
        $baseQuery = clone $query;

        // Verificar conflicto de profesor
        $profesorConflict = false;
        if ($profesorId) {
            $profesorQuery = (clone $baseQuery)->where('profesor_id', $profesorId);
            $profesorConflict = $profesorQuery->exists();
            if ($profesorConflict) {
                $conflictingSchedules = $profesorQuery->get();
                Log::warning('Conflicto de profesor detectado', [
                    'profesor_id' => $profesorId,
                    'conflicting_schedules' => $conflictingSchedules->toArray()
                ]);
            }
        }

        // Verificar conflicto de aula
        $aulaConflict = false;
        if ($room) {
            $aulaQuery = (clone $baseQuery)->where('aula', $room);
            $aulaConflict = $aulaQuery->exists();
            if ($aulaConflict) {
                $conflictingSchedules = $aulaQuery->get();
                Log::warning('Conflicto de aula detectado', [
                    'aula' => $room,
                    'conflicting_schedules' => $conflictingSchedules->toArray()
                ]);
            }
        }

        $this->conflictType = [];
        if ($profesorConflict) {
            $this->conflictType[] = 'profesor';
        }
        if ($aulaConflict) {
            $this->conflictType[] = 'aula';
        }

        return !$profesorConflict && !$aulaConflict;
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
