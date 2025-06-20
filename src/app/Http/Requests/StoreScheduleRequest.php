<?php

namespace App\Http\Requests;

use App\Rules\NoScheduleOverlap;
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
            // Estas reglas se mantienen
            'curso_id'     => ['required', 'exists:cursos,id'],
            'profesor_id'  => ['required', 'exists:profesores,id'],

            // Nuevas reglas para los campos del formulario
            'weekday'      => ['required', 'integer', 'between:0,6'],
            // Aplicamos la regla a uno de los campos de tiempo
            'start_time'   => ['required', 'date_format:H:i', new NoScheduleOverlap()],
            'end_time'     => ['required', 'date_format:H:i', 'after:start_time'],
            'room'         => ['required', 'string', 'max:50'],
        ];
    }
}