<?php

namespace App\Models;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PreinscritoSepe extends Model
{
    use HasFactory; // <-- AÑADIR ESTA LÍNEA
    protected $table = 'preinscritos_sepe';
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
    'fecha_nacimiento',
    'telefono',
    'email',
    'direccion',
    'localidad',
    'provincia',
    'cp',
    'nacionalidad',
    'situacion_laboral',
    'nivel_formativo',
    'fecha_importacion', // Si este campo se establece programáticamente
];
}
