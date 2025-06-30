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
        // Las reglas son idénticas a las de creación.
        // La lógica para manejar duplicados o conflictos se gestiona en el controlador.
        return [
            // Pasamos el ID del horario actual al constructor de la regla
            'curso_id'     => ['required', 'exists:cursos,id', new SufficientCourseDuration($this->schedule->id)],
            'profesor_id'  => ['required', 'exists:profesores,id'],
            'weekday'      => ['required', 'integer', 'between:0,6'],
            'start_time'   => ['required', 'date_format:H:i', new NoScheduleOverlap($this->schedule->id)],
            'end_time'     => ['required', 'date_format:H:i', 'after:start_time'],
            'room'         => ['required', 'string', 'max:50'],
        ];
    }
}