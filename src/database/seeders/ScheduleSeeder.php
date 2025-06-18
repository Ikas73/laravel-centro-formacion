<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ScheduleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
{
    /*
     * PROPÓSITO
     * Crear horarios aleatorios evitando colisiones de time_slot_id
     * (porque la columna es UNIQUE).
     */

    $cursos     = \App\Models\Curso::all()->pluck('id');
    $profesores = \App\Models\Profesor::all()->pluck('id');
    $slots      = \App\Models\TimeSlot::all()->pluck('id')->shuffle();

    // Creamos, por ejemplo, 10 horarios
    $quantity = min(10, $slots->count(), $cursos->count());

    for ($i = 0; $i < $quantity; $i++) {
        \App\Models\Schedule::create([
            'curso_id'     => $cursos[$i],
            'profesor_id'  => $profesores->random(),
            'time_slot_id' => $slots[$i],   // sin duplicar
        ]);
    }
}

}
