<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class TimeSlotSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
{
    /*
     * PROPÓSITO
     * Generar 6 días (lunes-sábado) × 8 franjas de 2 horas (09-11, 11-13…)
     * Aula fija “Aula 101” para el ejemplo.
     */

    // Array con horas de inicio
    $starts = ['09:00', '11:00', '13:00', '15:00', '17:00', '19:00', '21:00', '23:00'];

    foreach (range(1, 6) as $weekday) {               // 1 = lunes, 6 = sábado
        foreach ($starts as $start) {
            $end = \Carbon\Carbon::parse($start)->addHours(2)->format('H:i');
            \App\Models\TimeSlot::updateOrCreate(
                ['weekday' => $weekday, 'start_time' => $start, 'room' => 'Aula 101'],
                ['end_time' => $end]
            );
        }
    }
}

}
