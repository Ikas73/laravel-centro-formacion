<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Curso;
use App\Models\Schedule;

class ScheduleSeeder extends Seeder
{
    public function run(): void
    {
        $this->command->info('Creando un único horario para el curso de prueba...');

        Schedule::truncate();

        $curso = Curso::where('codigo', 'CYP-001')->first();

        if (!$curso) {
            $this->command->error('No se encontró el curso de prueba CYP-001. Ejecuta el CursoSeeder primero.');
            return;
        }

        // Crear un único horario para el curso de prueba
        Schedule::create([
            'curso_id' => $curso->id,
            'profesor_id' => $curso->profesor_id,
            'dia_semana' => 1, // Lunes
            'hora_inicio' => '09:00:00',
            'hora_fin' => '11:00:00',
            'aula' => 'Aula de Test',
        ]);

        $this->command->info('¡Horario de prueba creado!');
    }
}
