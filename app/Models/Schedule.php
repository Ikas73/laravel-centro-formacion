<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Schedule extends Model
{
    use HasFactory;

    protected $table = 'schedules';
    protected $fillable = [
        'curso_id',
        'dia_semana',
        'hora_inicio',
        'hora_fin',
        'aula',
        'profesor_id',
    ];

    /* — Relaciones inversas — */
    public function curso()
    {
        return $this->belongsTo(Curso::class, 'curso_id');
    }

    public function profesor()
    {
        // CORRECCIÓN: Asegúrate de que aquí se referencia a App\Models\Profesor
        return $this->belongsTo(Profesor::class, 'profesor_id');
    }

    public function timeSlot()
    {
        return $this->belongsTo(TimeSlot::class);
    }
}