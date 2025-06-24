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
        // 1. Cargamos los horarios y su relación con el curso y el profesor del curso.
        $schedules = Schedule::with(['curso.profesor'])->get();

        $events = $schedules->map(function ($schedule) {
            
            // 2. Comprobación robusta: ignoramos horarios sin curso o si al curso le faltan fechas.
            if (!$schedule->curso || !$schedule->curso->fecha_inicio || !$schedule->curso->fecha_fin) {
                return null;
            }

            // 3. Construimos el evento usando los datos directamente de $schedule y $schedule->curso
            return [
                'id'          => $schedule->id,
                'title'       => $schedule->curso->nombre,
                'daysOfWeek'  => [$schedule->dia_semana],      // Leído directamente de la tabla 'schedules'
                'startTime'   => $schedule->hora_inicio,     // Leído directamente de la tabla 'schedules'
                'endTime'     => $schedule->hora_fin,        // Leído directamente de la tabla 'schedules'
                'startRecur'  => $schedule->curso->fecha_inicio->format('Y-m-d'),
                'endRecur'    => $schedule->curso->fecha_fin->addDay()->format('Y-m-d'),
                'backgroundColor' => $this->stringToColor($schedule->curso->nombre),
                'borderColor'     => $this->stringToColor($schedule->curso->nombre, -20),
                'extendedProps' => [
                    'profesor' => $schedule->curso->profesor ? $schedule->curso->profesor->nombre . ' ' . $schedule->curso->profesor->apellido1 : 'No asignado',
                    'aula'     => $schedule->aula, // Leído directamente de la tabla 'schedules'
                ]
            ];
        })->filter();

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