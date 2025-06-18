<?php

namespace App\Http\Requests;

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
            'start_time'   => ['required', 'date_format:H:i'],
            // 'after' se asegura de que la hora de fin sea posterior a la de inicio
            'end_time'     => ['required', 'date_format:H:i', 'after:start_time'],
            'room'         => ['required', 'string', 'max:50'],
        ];
    }
}