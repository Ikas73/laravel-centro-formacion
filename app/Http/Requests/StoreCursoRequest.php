<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class StoreCursoRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true; // Permitimos que cualquier usuario autenticado pueda intentar crear
    }

    public function rules(): array
    {
        return [
            'nombre'         => ['required', 'string', 'max:255'],
            'profesor_id'    => ['nullable', 'exists:profesores,id'],
            'fecha_inicio'   => ['required', 'date'],
            'fecha_fin'      => ['required', 'date', 'after_or_equal:fecha_inicio'],
            'horas_totales'  => ['required', 'integer', 'min:1'],    
            // --- AÑADE Y/O COMPLETA ESTOS CAMPOS ---
        'codigo' => [
            'nullable',
            'string',
            'max:20',
            Rule::unique('cursos', 'codigo') // Asegura que el código sea único en la tabla 'cursos'
        ],
        'descripcion' => 'nullable|string|max:5000', // Un límite más alto para descripciones
        'nivel' => 'nullable|string|max:255',
        'requisitos' => 'nullable|string|max:5000',        
        'horario' => 'nullable|string|max:255',
        'centros' => 'nullable|string|max:255',

        ];
    }
}