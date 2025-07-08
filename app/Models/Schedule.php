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

    /**
     * Devuelve el día de la semana como un string.
     *
     * @return string
     */
    public function getDiaSemanaStringAttribute()
    {
        $dias = [
            1 => 'Lunes',
            2 => 'Martes',
            3 => 'Miércoles',
            4 => 'Jueves',
            5 => 'Viernes',
            6 => 'Sábado',
            0 => 'Domingo',
            7 => 'Domingo' // Por si se usa 7 en lugar de 0
        ];
        return $dias[$this->dia_semana] ?? 'Día no válido';
    }

    /**
     * Formatea la hora de inicio.
     *
     * @return string
     */
    public function getHoraInicioFormattedAttribute()
    {
        return \Carbon\Carbon::parse($this->hora_inicio)->format('H:i');
    }

    /**
     * Formatea la hora de fin.
     *
     * @return string
     */
    public function getHoraFinFormattedAttribute()
    {
        return \Carbon\Carbon::parse($this->hora_fin)->format('H:i');
    }
}