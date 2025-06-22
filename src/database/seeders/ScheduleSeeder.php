<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\TimeSlot;
use App\Models\Schedule;
use App\Models\Curso;
use App\Models\Profesor;

class ScheduleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Limpiamos las tablas para evitar duplicados en ejecuciones repetidas
        Schedule::truncate();
        TimeSlot::truncate();

        // Obtenemos algunos cursos y profesores para asociar.
        // Asegúrate de tener al menos 2 cursos y 2 profesores en tu BD
        $curso1 = Curso::first();
        $curso2 = Curso::skip(1)->first();
        $profesor1 = Profesor::first();
        $profesor2 = Profesor::skip(1)->first();

        if (!$curso1 || !$profesor1) {
            $this->command->info('No hay suficientes cursos o profesores para ejecutar el ScheduleSeeder. Saltando.');
            return;
        }

        // Creamos algunas franjas horarias y horarios
        $slotsData = [
            ['weekday' => 1, 'start_time' => '09:00', 'end_time' => '11:00', 'room' => 'Aula 101'],
            ['weekday' => 1, 'start_time' => '11:00', 'end_time' => '13:00', 'room' => 'Aula 102'],
            ['weekday' => 2, 'start_time' => '16:00', 'end_time' => '18:00', 'room' => 'Aula 101'],
            ['weekday' => 3, 'start_time' => '10:00', 'end_time' => '12:00', 'room' => 'Laboratorio B'],
            ['weekday' => 4, 'start_time' => '18:00', 'end_time' => '20:00', 'room' => 'Aula 205'],
        ];

        foreach ($slotsData as $index => $slot) {
            $timeSlot = TimeSlot::create($slot);
            Schedule::create([
                'curso_id' => ($index % 2 == 0) ? $curso1->id : $curso2->id,
                'profesor_id' => ($index % 2 == 0) ? $profesor1->id : $profesor2->id,
                'time_slot_id' => $timeSlot->id,
            ]);
        }
    }
}