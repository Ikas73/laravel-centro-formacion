<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Curso;
use App\Models\Profesor;
use App\Models\Schedule;

class ScheduleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $this->command->info('----------------------------------------');
        $this->command->info('Iniciando Seeder: Creando horarios de prueba...');
        $this->command->info('----------------------------------------');

        // Limpiamos la tabla para evitar duplicados en ejecuciones repetidas
        Schedule::truncate();

        // Obtenemos todos los cursos y profesores para no consultar en cada iteración
        $cursos = Curso::all();
        $profesores = Profesor::all();

        if ($cursos->isEmpty() || $profesores->isEmpty()) {
            $this->command->error('No se pueden crear horarios porque no hay cursos o profesores. Ejecuta los otros seeders primero.');
            return;
        }

        $dias = [1, 2, 3, 4, 5]; // Lunes a Viernes
        $horasInicio = ['09:00:00', '10:00:00', '11:00:00', '12:00:00', '16:00:00', '17:00:00'];
        $aulas = ['Aula 101', 'Aula 102', 'Laboratorio A', 'Sala de Juntas', 'Aula Virtual 1'];

        for ($i = 0; $i < 20; $i++) {
            $cursoAleatorio = $cursos->random();
            $horaInicioAleatoria = $horasInicio[array_rand($horasInicio)];
            
            Schedule::create([
                'curso_id' => $cursoAleatorio->id,
                'profesor_id' => $profesores->random()->id,
                'dia_semana' => $dias[array_rand($dias)],
                'hora_inicio' => $horaInicioAleatoria,
                'hora_fin' => date('H:i:s', strtotime($horaInicioAleatoria . ' +2 hours')), // Duración de 2 horas
                'aula' => $aulas[array_rand($aulas)],
            ]);
        }
        
        $this->command->info('¡20 franjas horarias creadas con éxito!');
        $this->command->info('----------------------------------------');
        $this->command->info('Seeder de Horarios finalizado.');
        $this->command->info('----------------------------------------');
    }
}