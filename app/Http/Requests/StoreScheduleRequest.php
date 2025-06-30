<?php

namespace App\Http\Requests;

use App\Rules\NoScheduleOverlap;
use App\Rules\SufficientCourseDuration;
use Illuminate\Foundation\Http\FormRequest;

class StoreScheduleRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            /// Aplicamos la nueva regla al curso_id
            'curso_id'     => ['required', 'exists:cursos,id', new SufficientCourseDuration()],
            'profesor_id'  => ['required', 'exists:profesores,id'],
            'weekday'      => ['required', 'integer', 'between:0,6'],
            'start_time'   => ['required', 'date_format:H:i', new NoScheduleOverlap()],
            'end_time'     => ['required', 'date_format:H:i', 'after:start_time'],
            'room'         => ['required', 'string', 'max:50'],
        ];
    }
}