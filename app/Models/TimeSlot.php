<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class TimeSlot extends Model
{
    use HasFactory;

    protected $table = 'time_slots';      // ← explícito, por claridad
    protected $fillable = ['weekday', 'start_time', 'end_time', 'room'];

    /* Relación 1-a-1 (o 1-a-muchos si permites duplicar) */
    public function schedule()
    {
        return $this->hasOne(Schedule::class);
    }
}
