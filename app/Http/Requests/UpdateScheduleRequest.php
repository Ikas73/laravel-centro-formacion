<?php

namespace App\Http\Requests;

use App\Rules\NoScheduleOverlap;
use App\Rules\SufficientCourseDuration;
use Illuminate\Foundation\Http\FormRequest;

class UpdateScheduleRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        // Obtenemos el ID del schedule desde la ruta
        $schedule = $this->route('schedule');
        $scheduleId = $schedule ? $schedule->id : null;
        
        return [
            // Pasamos el ID del horario actual al constructor de la regla
            'curso_id'     => ['required', 'exists:cursos,id', new SufficientCourseDuration($scheduleId)],
            'profesor_id'  => ['required', 'exists:profesores,id'],
            'weekday'      => ['required', 'integer', 'between:0,6'],
            'start_time'   => ['required', 'date_format:H:i', (new NoScheduleOverlap($scheduleId))->setData($this->all())],
            'end_time'     => ['required', 'date_format:H:i', 'after:start_time'],
            'room'         => ['required', 'string', 'max:50'],
            'edit_type'    => ['sometimes', 'string', 'in:toda_la_serie,solo_este'],
            'original_date' => ['required_if:edit_type,solo_este', 'date_format:Y-m-d'],
            'new_date'      => ['required_if:edit_type,solo_este', 'date_format:Y-m-d'],
        ];
    }
}