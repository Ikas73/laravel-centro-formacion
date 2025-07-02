<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Curso;
use App\Models\Schedule;

class ScheduleSyncSeeder extends Seeder
{
    public function run(): void
    {
        $this->command->info('========================================');
        $this->command->info('Sincronizando horarios reales de cursos...');
        $this->command->info('========================================');

        // Limpiar la tabla schedules
        Schedule::truncate();

        $cursos = Curso::with('profesor')->get();

        if ($cursos->isEmpty()) {
            $this->command->error('No hay cursos para procesar.');
            return;
        }

        $aulas = ['Aula 101', 'Aula 102', 'Aula 103', 'Laboratorio A', 'Laboratorio B', 'Sala Virtual 1', 'Sala Virtual 2'];
        $processedCount = 0;
        $errorCount = 0;

        foreach ($cursos as $curso) {
            if (!$curso->profesor) {
                $this->command->warn("Curso '{$curso->nombre}' sin profesor asignado. Se omite.");
                continue;
            }

            $schedules = $this->parseHorario($curso->horario);
            
            if (empty($schedules)) {
                $this->command->warn("No se pudo parsear el horario del curso '{$curso->nombre}': {$curso->horario}");
                $errorCount++;
                continue;
            }

            foreach ($schedules as $schedule) {
                Schedule::create([
                    'curso_id' => $curso->id,
                    'profesor_id' => $curso->profesor_id,
                    'dia_semana' => $schedule['dia_semana'],
                    'hora_inicio' => $schedule['hora_inicio'],
                    'hora_fin' => $schedule['hora_fin'],
                    'aula' => $aulas[array_rand($aulas)], // Asignar aula aleatoria
                ]);
            }

            $processedCount++;
            $this->command->info("✓ Procesado: {$curso->nombre}");
        }

        $this->command->info('========================================');
        $this->command->info("✅ Cursos procesados: {$processedCount}");
        $this->command->info("⚠️  Cursos con errores: {$errorCount}");
        $this->command->info("📅 Total de horarios creados: " . Schedule::count());
        $this->command->info('========================================');
    }

    /**
     * Parsea el campo horario del curso y retorna un array con los horarios estructurados
     */
    private function parseHorario(string $horario): array
    {
        $schedules = [];
        
        // Limpiar y normalizar el string
        $horario = trim($horario);
        
        // Patrones de horarios comunes
        $patterns = [
            // Patrón: "09:00-13:00 L-V (4h)"
            '/(\d{2}:\d{2})-(\d{2}:\d{2})\s+L-V/i' => [1, 2, 3, 4, 5], // Lunes a Viernes
            
            // Patrón: "09:00-13:00 L-J (4h)"
            '/(\d{2}:\d{2})-(\d{2}:\d{2})\s+L-J/i' => [1, 2, 3, 4], // Lunes a Jueves
            
            // Patrón: "Fines de semana (S 09:00-14:00)"
            '/S\s+(\d{2}:\d{2})-(\d{2}:\d{2})/i' => [6], // Sábado
            
            // Patrón: "09:00-15:00 L-V (6h)"
            '/(\d{2}:\d{2})-(\d{2}:\d{2})\s+L-V/i' => [1, 2, 3, 4, 5],
        ];

        foreach ($patterns as $pattern => $dias) {
            if (preg_match($pattern, $horario, $matches)) {
                $horaInicio = $matches[1] . ':00';
                $horaFin = $matches[2] . ':00';
                
                foreach ($dias as $dia) {
                    $schedules[] = [
                        'dia_semana' => $dia,
                        'hora_inicio' => $horaInicio,
                        'hora_fin' => $horaFin,
                    ];
                }
                break; // Usar solo el primer patrón que coincida
            }
        }

        // Si no se encontró ningún patrón, intentar parseo manual para casos específicos
        if (empty($schedules)) {
            $schedules = $this->parseHorarioManual($horario);
        }

        return $schedules;
    }

    /**
     * Parseo manual para casos específicos que no coinciden con los patrones regulares
     */
    private function parseHorarioManual(string $horario): array
    {
        $schedules = [];
        
        // Casos específicos basados en los horarios del factory
        switch (true) {
            case stripos($horario, '09:00-13:00 y 16:00-20:00 L-J') !== false:
                // Horario mixto: mañana y tarde de lunes a jueves
                for ($dia = 1; $dia <= 4; $dia++) {
                    $schedules[] = ['dia_semana' => $dia, 'hora_inicio' => '09:00:00', 'hora_fin' => '13:00:00'];
                    $schedules[] = ['dia_semana' => $dia, 'hora_inicio' => '16:00:00', 'hora_fin' => '20:00:00'];
                }
                break;

            case stripos($horario, 'Fines de semana') !== false:
                // Extraer horario de sábado
                if (preg_match('/(\d{2}:\d{2})-(\d{2}:\d{2})/', $horario, $matches)) {
                    $schedules[] = [
                        'dia_semana' => 6, // Sábado
                        'hora_inicio' => $matches[1] . ':00',
                        'hora_fin' => $matches[2] . ':00',
                    ];
                }
                break;

            default:
                // Si nada funciona, asignar un horario por defecto
                $this->command->warn("Horario no reconocido: {$horario}. Usando horario por defecto.");
                $schedules[] = [
                    'dia_semana' => 1, // Lunes
                    'hora_inicio' => '09:00:00',
                    'hora_fin' => '11:00:00',
                ];
                break;
        }

        return $schedules;
    }
}
