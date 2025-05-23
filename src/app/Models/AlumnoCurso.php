<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class AlumnoCurso extends Model
{
    use HasFactory; // <-- AÑADIR ESTA LÍNEA

    protected $table = 'alumno_curso';
    // Aquí pueden ir tus propiedades $fillable, $hidden, relaciones, etc.
    // protected $fillable = [...];

    /**
     * Los atributos que son asignables masivamente.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'alumno_id',        // Clave foránea
        'curso_id',         // Clave foránea
        'fecha_inscripcion',
        'nota',
        'estado',
    ];

    /**
     * Obtiene el alumno asociado a esta inscripción.
     */
    public function alumno(): BelongsTo
    {
        // Busca la clave foránea 'alumno_id' en esta tabla ('alumno_curso').
        return $this->belongsTo(Alumno::class);
    }

    /**
     * Obtiene el curso asociado a esta inscripción.
     */
    public function curso(): BelongsTo
    {
        // Busca la clave foránea 'curso_id' en esta tabla ('alumno_curso').
        return $this->belongsTo(Curso::class);
    }
}
