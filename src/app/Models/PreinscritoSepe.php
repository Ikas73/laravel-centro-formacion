<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PreinscritoSepe extends Model
{
    use HasFactory;

    protected $table = 'preinscritos_sepe';

    protected $fillable = [
        'nombre',
        'apellido1',
        'apellido2',
        'dni',
        'email',
        'sexo',                 // Añadido
        'fecha_nacimiento',
        'nacionalidad',
        'num_seguridad_social', // Añadido
        'direccion',
        'telefono',
        'cp',
        'localidad',
        'provincia',
        'nivel_formativo',
        'situacion_laboral',
        'estado',               // Añadido
        'fecha_importacion',    // Añadido
    ];

    protected $casts = [
        'fecha_nacimiento' => 'date',
        'fecha_importacion' => 'datetime',
    ];

    // Aquí podrías añadir relaciones si los preinscritos se asocian a algo más (ej: un curso deseado)
}