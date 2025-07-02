<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreScheduleRequest;
use App\Http\Requests\UpdateScheduleRequest;
use App\Models\Schedule;
use App\Models\Curso;
use App\Models\Profesor;
use App\Models\TimeSlot;
use Carbon\Carbon;

class ScheduleController extends Controller
{
    /**
     * Muestra la vista principal del calendario.
     */
    public function index()
    {
        return view('admin.schedules.index');
    }

    /**
     * Obtiene y formatea los eventos para FullCalendar,
     * alineado con la migración real.
     */
    public function fetchEvents()
{
    // Carga los horarios junto con la información del curso y del profesor
    $schedules = Schedule::with(['curso', 'profesor'])->get();

    $events = $schedules->map(function ($schedule) {
        // --- Comprobación de seguridad ---
        // Si un horario no tiene curso o el curso no tiene fechas, no lo podemos dibujar.
        if (!$schedule->curso || !$schedule->curso->fecha_inicio || !$schedule->curso->fecha_fin) {
            return null; // Omitir este evento
        }

        // --- Mapeo del día de la semana ---
        // Tu BD: 1=Lunes, 2=Martes ... 0=Domingo
        // RRULE: MO, TU, WE, TH, FR, SA, SU
        $diasRrule = ['SU', 'MO', 'TU', 'WE', 'TH', 'FR', 'SA'];
        $diaDeLaSemana = $diasRrule[$schedule->dia_semana];

        // --- Formateo de fechas y horas ---
        $dtstart = $schedule->curso->fecha_inicio->format('Y-m-d') . 'T' . $schedule->hora_inicio;
        $until = $schedule->curso->fecha_fin->format('Y-m-d');
        
        // La duración se calcula para que FullCalendar sepa cuánto dura cada evento recurrente
        $duracion = Carbon::parse($schedule->hora_inicio)
                          ->diff(Carbon::parse($schedule->hora_fin))
                          ->format('%H:%I:%S');

        return [
            'id'        => $schedule->id,
            'title'     => $schedule->curso->nombre, // Título del evento
            'duration'  => $duracion,               // Duración de cada ocurrencia
            
            // --- La Magia de la Recurrencia ---
            'rrule'     => [
                'freq'    => 'weekly',        // Frecuencia: semanal
                'byweekday' => [$diaDeLaSemana],  // El día de la semana específico
                'dtstart' => $dtstart,          // Cuándo empieza la primera ocurrencia
                'until'   => $until,            // Cuándo termina la serie de repeticiones
            ],

            // --- Información Extra para mostrar en el evento ---
            'extendedProps' => [
                'profesor' => optional($schedule->profesor)->nombre . ' ' . optional($schedule->profesor)->apellido1,
                'aula'     => $schedule->aula,
                'curso_id' => $schedule->curso->id
            ],

            // --- Colores (opcional pero muy útil) ---
            'backgroundColor' => $this->stringToColor($schedule->curso->nombre),
            'borderColor'     => $this->stringToColor($schedule->curso->nombre, -20),
        ];
    })->filter(); // Elimina los eventos nulos que omitimos

    return response()->json($events);
}
    /**
     * Helper para generar un color consistente a partir de un string.
     */
    private function stringToColor($str, $lightnessAdjustment = 0)
    {
        $hash = 0;
        for ($i = 0; $i < strlen($str); $i++) {
            $hash = ord($str[$i]) + (($hash << 5) - $hash);
        }
        $hue = $hash % 360;
        $lightness = 50 + $lightnessAdjustment;
        return "hsl({$hue}, 80%, {$lightness}%)";
    }
}