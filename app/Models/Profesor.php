<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Profesor extends Model
{
    use HasFactory;

    public const TITULACIONES_VALIDAS = ['Licenciatura', 'Grado', 'Máster', 'Doctorado', 'Ingeniería Técnica', 'Otra'];
    public const ESPECIALIDADES_VALIDAS = ['Desarrollo Web', 'Bases de Datos', 'Redes', 'Marketing Digital', 'Finanzas', 'Otra'];

    /**
     * La tabla asociada con el modelo.
     *
     * @var string
     */
    protected $table = 'profesores'; // <-- ¡AÑADIR ESTA LÍNEA!

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
        'telefono',
        'email',
        'titulacion_academica',
        'especialidad',
        // No incluir 'id', 'created_at', 'updated_at'
    ];



    /**
    * Obtiene los cursos impartidos por este profesor.
    */
    public function cursos(): HasMany
    {
        // Laravel busca automáticamente la clave foránea 'profesor_id' en la tabla 'cursos'
        // porque el método está en el modelo 'Profesor'.
        return $this->hasMany(Curso::class);
    }

    /**
     * Obtiene los horarios asignados a este profesor.
     *  @return \Illuminate\Database\Eloquent\Relations\HasMany
     *  @throws \Illuminate\Database\Eloquent\Relations\RelationNotFoundException
     * 
     */
    public function schedules()
    {
        return $this->hasMany(Schedule::class, 'profesor_id');
    }

}