<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateCursoRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true; // Permitimos que cualquier usuario autenticado pueda intentar editar
    }

    public function rules(): array
{
    // Obtener el ID del curso desde la ruta (ej: /cursos/15/edit)
    $cursoId = $this->route('curso')->id;

    return [
        // Campos que ya funcionaban
        'nombre' => 'required|string|max:255',
        'modalidad' => 'required|string|in:Online,Presencial,"Semipresencial (Blended)"',
        'profesor_id' => 'required|exists:profesores,id',
        'plazas_maximas' => 'required|integer|min:1',
        
        // --- AÑADE Y/O COMPLETA ESTOS CAMPOS ---
        'codigo' => [
            'nullable',
            'string',
            'max:20',
            // Ignora la regla 'unique' para el curso que se está editando
            Rule::unique('cursos', 'codigo')->ignore($cursoId) 
        ],
        'descripcion' => 'nullable|string|max:5000',
        'nivel' => 'nullable|string|max:255',
        'requisitos' => 'nullable|string|max:5000',
        'fecha_inicio' => 'nullable|date',
        'fecha_fin' => 'nullable|date|after_or_equal:fecha_inicio',
        'horas_totales' => 'nullable|integer|min:1',
        'horario' => 'nullable|string|max:255',
        'centros' => 'nullable|string|max:255',
    ];
}
}