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
        $schedules = Schedule::with(['curso.profesor'])->get();

        $events = $schedules->map(function ($schedule) {
            if (!$schedule->curso || !$schedule->curso->fecha_inicio || !$schedule->curso->fecha_fin) {
                return null;
            }

            // rrule.js espera un entero para 'byday' (0=Lunes, 6=Domingo).
            // Mapeamos nuestro valor de la BD (0=Domingo, 1=Lunes) al formato de rrule.js.
            $dbToRruleDay = [0 => 6, 1 => 0, 2 => 1, 3 => 2, 4 => 3, 5 => 4, 6 => 5];
            $byday = $dbToRruleDay[$schedule->dia_semana] ?? 0; // Por defecto Lunes si hay error.

            $dtstart = $schedule->curso->fecha_inicio->format('Y-m-d') . 'T' . $schedule->hora_inicio;
            $until = $schedule->curso->fecha_fin->format('Y-m-d');

            return [
                'id'      => $schedule->id,
                'title'   => $schedule->curso->nombre,
                'rrule'   => [
                    'dtstart' => $dtstart,
                    'until'   => $until,
                    'freq'    => 'WEEKLY',
                    'byweekday'   => [$byday],
                ],
                'duration' => Carbon::parse($schedule->hora_inicio)->diff(Carbon::parse($schedule->hora_fin))->format('%H:%I:%S'),
                'backgroundColor' => $this->stringToColor($schedule->curso->nombre),
                'borderColor'     => $this->stringToColor($schedule->curso->nombre, -20),
                'extendedProps' => [
                    'profesor' => $schedule->curso->profesor ? $schedule->curso->profesor->nombre . ' ' . $schedule->curso->profesor->apellido1 : 'No asignado',
                    'aula'     => $schedule->aula,
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