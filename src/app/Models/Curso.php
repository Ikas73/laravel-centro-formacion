<?php

namespace App\Models;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Curso extends Model
{
    use HasFactory; 

    // Aquí pueden ir tus propiedades $fillable, $hidden, relaciones, etc.
    protected $table = 'cursos'; // Nombre de la tabla en la base de datos

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
     * Los atributos que deben ser convertidos a tipos nativos.
     * Esto es útil para que las fechas se traten como objetos Carbon.
     */
    protected $casts = [
        'fecha_inicio' => 'date',
        'fecha_fin' => 'date',
        'plazas_maximas' => 'integer',
        'horas_totales' => 'integer',
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

    /**
    * Obtiene las franjas horarias asociadas a este curso.
    * @return \Illuminate\Database\Eloquent\Relations\HasMany
    * @throws \Illuminate\Database\Eloquent\Relations\RelationNotFoundException
    * Esta relación es 1-a-1, ya que cada curso tiene una única franja horaria.
    */
    public function schedules()
    {
        return $this->hasMany(Schedule::class, 'curso_id');
    }

}
