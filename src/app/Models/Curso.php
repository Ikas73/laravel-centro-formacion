<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Curso extends Model
{
    use HasFactory; // <-- AÑADIR ESTA LÍNEA

    // Aquí pueden ir tus propiedades $fillable, $hidden, relaciones, etc.
    // protected $fillable = [...];

    /**
     * Los atributos que son asignables masivamente.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'nombre',
        'codigo',
        'descripcion',
        'modalidad',
        'nivel',
        'requisitos',
        'fecha_inicio',
        'fecha_fin',
        'horas_totales',
        'horario',
        'centros',
        'profesor_id', // Incluir la clave foránea si se asigna masivamente
        'plazas_maximas',
    ];

    /**
     * Obtiene el profesor que imparte este curso.
     */
    public function profesor(): BelongsTo
    {
        // Laravel busca automáticamente una columna 'profesor_id' en esta tabla ('cursos')
        // para enlazarla con la tabla 'profesores'.
        return $this->belongsTo(Profesor::class);
    }

    /**
     * Obtiene todos los registros de inscripción (tabla alumno_curso) para este curso.
     */
    public function inscripciones(): HasMany
    {
        // Busca registros en 'alumno_curso' donde 'curso_id' coincida con el ID de este curso.
        return $this->hasMany(AlumnoCurso::class);
    }

    /**
     * Obtiene los alumnos inscritos directamente en este curso.
     */
    public function alumnos(): BelongsToMany
    {
        // Define la relación inversa muchos-a-muchos.
        return $this->belongsToMany(Alumno::class, 'alumno_curso')
            ->withPivot('fecha_inscripcion', 'nota', 'estado') // Mismas opciones que antes
            ->withTimestamps(); // Mismas opciones que antes
    }
}
