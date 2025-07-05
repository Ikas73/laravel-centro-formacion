<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Curso;
use App\Models\Schedule;
use Carbon\Carbon;

class SyncExistingSchedules extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:sync-existing-schedules';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Sincroniza los horarios antiguos de la tabla cursos a la tabla schedules.';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $this->info('Iniciando la sincronización de horarios existentes...');

        $cursos = Curso::whereNotNull('horario')->get();

        if ($cursos->isEmpty()) {
            $this->info('No se encontraron cursos con horarios definidos para sincronizar.');
            return;
        }

        foreach ($cursos as $curso) {
            $this->line("Procesando curso: '{$curso->nombre}' (ID: {$curso->id})");
            $this->line(" -> Horario a parsear: '{$curso->horario}'");

            $parsedData = $this->parseHorario($curso->horario);

            if (empty($parsedData)) {
                $this->warn("  -> No se pudo interpretar el formato del horario. Saltando...");
                continue;
            }

            foreach ($parsedData as $data) {
                try {
                    Schedule::firstOrCreate(
                        [
                            'curso_id' => $curso->id,
                            'profesor_id' => $curso->profesor_id,
                            'dia_semana' => $data['weekday'],
                            'hora_inicio' => $data['start_time'],
                            'hora_fin' => $data['end_time'],
                            'aula' => $curso->centros ?? 'Aula General'
                        ]
                    );

                    $this->info("  -> Horario creado/encontrado para el día {$data['weekday']} de {$data['start_time']} a {$data['end_time']}.");

                } catch (\Exception $e) {
                    $this->error("  -> Error al procesar el horario para el día {$data['weekday']}: " . $e->getMessage());
                }
            }
        }

        $this->info('Sincronización completada.');
    }

    /**
     * Parsea el string de horario y devuelve un array de datos.
     *
     * @param string $horarioString
     * @return array
     */
    private function parseHorario(string $horarioString): array
    {
        $parsed = [];

        // Caso 1: Formato "HH:MM-HH:MM L-V (Xh)" o "09:00-15:00 L-V (6h)"
        if (preg_match('/(\d{1,2}:\d{2})-(\d{1,2}:\d{2})\s+L-V/i', $horarioString, $matches)) {
            $startTime = Carbon::parse($matches[1])->format('H:i:s');
            $endTime = Carbon::parse($matches[2])->format('H:i:s');
            for ($day = 1; $day <= 5; $day++) { // Lunes a Viernes
                $parsed[] = ['weekday' => $day, 'start_time' => $startTime, 'end_time' => $endTime];
            }
            return $parsed;
        }

        // Caso 2: Formato "HH:MM-HH:MM y HH:MM-HH:MM L-J (Xh Mixto)"
        if (preg_match('/(\d{1,2}:\d{2})-(\d{1,2}:\d{2})\s+y\s+(\d{1,2}:\d{2})-(\d{1,2}:\d{2})\s+L-J/i', $horarioString, $matches)) {
            $startTime1 = Carbon::parse($matches[1])->format('H:i:s');
            $endTime1 = Carbon::parse($matches[2])->format('H:i:s');
            $startTime2 = Carbon::parse($matches[3])->format('H:i:s');
            $endTime2 = Carbon::parse($matches[4])->format('H:i:s');
            for ($day = 1; $day <= 4; $day++) { // Lunes a Jueves
                $parsed[] = ['weekday' => $day, 'start_time' => $startTime1, 'end_time' => $endTime1];
                $parsed[] = ['weekday' => $day, 'start_time' => $startTime2, 'end_time' => $endTime2];
            }
            return $parsed;
        }

        // Caso 3: Formato "Fines de semana (S HH:MM-HH:MM)"
        if (preg_match('/Fines de semana\s+\(S\s+(\d{1,2}:\d{2})-(\d{1,2}:\d{2})\)/i', $horarioString, $matches)) {
            $startTime = Carbon::parse($matches[1])->format('H:i:s');
            $endTime = Carbon::parse($matches[2])->format('H:i:s');
            $parsed[] = ['weekday' => 6, 'start_time' => $startTime, 'end_time' => $endTime]; // Sábado
            return $parsed;
        }

        return $parsed;
    }
}
