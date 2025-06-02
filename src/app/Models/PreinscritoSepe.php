<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PreinscritoSepe extends Model
{
    use HasFactory;

    /**
     * La tabla asociada con el modelo.
     * Laravel intentará usar 'preinscrito_sepes' si no se especifica.
     * Confirma el nombre real de tu tabla.
     */
    protected $table = 'preinscritos_sepe';

    /**
     * Los atributos que son asignables masivamente.
     */
    protected $fillable = [
        'nombre',
        'apellido1',
        'apellido2',
        'dni',
        'fecha_nacimiento',
        'telefono',
        'email',
        'direccion',    // Asumiendo que este campo se llama 'direccion' en la BD
        'localidad',
        'provincia',
        'cp',           // Asumiendo que este campo se llama 'cp' en la BD
        'nacionalidad',
        'situacion_laboral',
        'nivel_formativo',
        'fecha_importacion', // Si la gestionas programáticamente
        // 'estado', // Añade si tienes una columna 'estado' para preinscritos
    ];

    /**
     * Los atributos que deben ser convertidos a tipos nativos.
     */
    protected $casts = [
        'fecha_nacimiento' => 'date',
        'fecha_importacion' => 'datetime', // O 'date' si solo es la fecha
    ];

    // Aquí podrías añadir relaciones si los preinscritos se asocian a algo más (ej: un curso deseado)
}