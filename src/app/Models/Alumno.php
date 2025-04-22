<?php

namespace App\Models;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Alumno extends Model
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
        'apellido1',
        'apellido2',
        'dni',
        'num_seguridad_social',
        'fecha_nacimiento',
        'sexo',
        'direccion',
        'cp',
        'localidad',
        'provincia',
        'telefono',
        'email',
        'nacionalidad',
        'situacion_laboral',
        'nivel_formativo',
    ];

    /**
    * Obtiene todos los registros de inscripción (tabla alumno_curso) para este alumno.
    */
    public function inscripciones(): HasMany
    {
        // Busca registros en 'alumno_curso' donde 'alumno_id' coincida con el ID de este alumno.
        return $this->hasMany(AlumnoCurso::class);
    }

    /**
    * Obtiene los cursos en los que está inscrito directamente este alumno.
    */
    public function cursos(): BelongsToMany
    {
        // Define una relación muchos-a-muchos con el modelo Curso.
        // El segundo argumento es el nombre de la tabla pivote.
        // Laravel inferirá las claves foráneas 'alumno_id' y 'curso_id' en la tabla pivote.
        // Si quisieras acceder a columnas extra de la tabla pivote (como 'nota', 'estado'),
        // usarías ->withPivot('nota', 'estado').
        return $this->belongsToMany(Curso::class, 'alumno_curso')
                    ->withPivot('fecha_inscripcion', 'nota', 'estado') // Opcional: para acceder a datos de la pivote
                    ->withTimestamps(); // Opcional: si la tabla pivote tiene created_at/updated_at y quieres que Eloquent los maneje
    }
}
