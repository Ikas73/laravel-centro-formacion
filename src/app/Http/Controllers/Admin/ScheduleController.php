<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreScheduleRequest;
use App\Http\Requests\UpdateScheduleRequest; // Lo usaremos pronto
use App\Models\Schedule;
use App\Models\Curso;
use App\Models\Profesor;
use App\Models\TimeSlot;
// Eliminamos 'Request' si no se usa directamente.

class ScheduleController extends Controller
{
    public function index()
    {
        $schedules = Schedule::with(['curso', 'profesor', 'timeSlot'])
                     ->paginate(15);
        return view('admin.schedules.index', compact('schedules'));
    }

    public function create()
    {
        // Ya no pasamos los '$slots'. El usuario los creará dinámicamente.
        return view('admin.schedules.create', [
            'cursos'     => Curso::pluck('nombre', 'id'),
            'profesores' => Profesor::pluck('nombre', 'id'),
        ]);
    }

    public function store(StoreScheduleRequest $request)
    {
        // 1. Validar los datos de entrada (ya lo hace StoreScheduleRequest)
        $validated = $request->validated();

        // 2. Encontrar o crear la franja horaria (TimeSlot)
        $timeSlot = TimeSlot::firstOrCreate(
            [
                'weekday'    => $validated['weekday'],
                'start_time' => $validated['start_time'],
                'end_time'   => $validated['end_time'],
                'room'       => $validated['room'],
            ]
        );

        // 3. Crear el Horario (Schedule) usando el ID de la franja horaria
        Schedule::create([
            'curso_id'     => $validated['curso_id'],
            'profesor_id'  => $validated['profesor_id'],
            'time_slot_id' => $timeSlot->id,
        ]);

        return to_route('admin.schedules.index')
               ->with('success', 'Horario creado correctamente.');
    }

    public function edit(Schedule $schedule)
    {
        // Eager-load la relación timeSlot para tener los datos disponibles en la vista
        $schedule->load('timeSlot');

        return view('admin.schedules.edit', [
            'schedule'   => $schedule,
            'cursos'     => Curso::pluck('nombre', 'id'),
            'profesores' => Profesor::pluck('nombre', 'id'),
        ]);
    }

    public function update(UpdateScheduleRequest $request, Schedule $schedule)
    {
        $validated = $request->validated();

        // Misma lógica que en 'store': encuentra o crea la franja horaria.
        $timeSlot = TimeSlot::firstOrCreate(
            [
                'weekday'    => $validated['weekday'],
                'start_time' => $validated['start_time'],
                'end_time'   => $validated['end_time'],
                'room'       => $validated['room'],
            ]
        );

        // Actualiza el horario existente para que apunte al nuevo (o existente) time_slot_id
        $schedule->update([
            'curso_id'     => $validated['curso_id'],
            'profesor_id'  => $validated['profesor_id'],
            'time_slot_id' => $timeSlot->id,
        ]);

        return to_route('admin.schedules.index')
               ->with('success', 'Horario actualizado correctamente.');
    }

    public function destroy(Schedule $schedule)
    {
        $schedule->delete();
        return back()->with('success', 'Horario eliminado.');
    }
}