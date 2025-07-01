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
        $this->command->info('----------------------------------------');
        $this->command->info('Iniciando Seeder: Asignando UN horario por curso...');
        $this->command->info('----------------------------------------');

        // Limpiamos la tabla para empezar de cero en cada ejecución
        Schedule::truncate();

        $cursos = Curso::with('profesor')->get(); // Obtenemos los cursos y su profesor asociado

        if ($cursos->isEmpty()) {
            $this->command->error('No hay cursos para asignar horarios.');
            return;
        }

        $dias = [1, 2, 3, 4, 5]; // Lunes a Viernes
        $horasInicio = ['09:00:00', '11:00:00', '16:00:00', '18:00:00'];
        $aulas = ['Aula 101', 'Aula 102', 'Laboratorio A', 'Sala Virtual 1'];

        // Bucle sobre cada curso
        foreach ($cursos as $curso) {
            
            // Si el curso no tiene un profesor asignado, no podemos crear el horario.
            if (!$curso->profesor) {
                $this->command->warn("El curso '{$curso->nombre}' no tiene profesor. Se omitirá.");
                continue;
            }

            $horaInicioAleatoria = $horasInicio[array_rand($horasInicio)];

            Schedule::create([
                'curso_id' => $curso->id,
                'profesor_id' => $curso->profesor_id, // Usamos el profesor ya asignado al curso
                'dia_semana' => $dias[array_rand($dias)],
                'hora_inicio' => $horaInicioAleatoria,
                'hora_fin' => date('H:i:s', strtotime($horaInicioAleatoria . ' +2 hours')),
                'aula' => $aulas[array_rand($aulas)],
            ]);
        }
        
        $this->command->info('¡' . $cursos->count() . ' franjas horarias creadas (una por curso)!');
        $this->command->info('----------------------------------------');
        $this->command->info('Seeder de Horarios finalizado.');
        $this->command->info('----------------------------------------');
    }
}