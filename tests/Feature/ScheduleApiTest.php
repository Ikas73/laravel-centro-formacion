<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\Models\Curso;
use App\Models\Profesor;
use App\Models\Schedule;
use App\Models\User;
use Carbon\Carbon;

class ScheduleApiTest extends TestCase
{
    use RefreshDatabase;

    /**
     * @test
     * Verifica que la API formatea correctamente una regla de recurrencia,
     * una excepción y una cancelación.
     */
    public function it_correctly_returns_recurrence_rule_with_exception_and_cancellation(): void
    {
        // 1. Arrange (Preparar)
        $profesor = Profesor::factory()->create();
        $curso = Curso::factory()->create([
            'profesor_id' => $profesor->id,
            'fecha_inicio' => '2025-07-01',
            'fecha_fin' => '2025-07-31',
        ]);

        // La regla principal: todos los lunes a las 10:00
        $rule = Schedule::factory()->create([
            'curso_id' => $curso->id,
            'profesor_id' => $profesor->id,
            'dia_semana' => 1, // Lunes
            'hora_inicio' => '10:00:00',
            'hora_fin' => '12:00:00',
            'is_recurring' => true,
        ]);

        // La fecha original que vamos a mover (el segundo lunes del mes)
        $originalDate = '2025-07-14';

        // Registro de cancelación para la fecha original
        Schedule::factory()->create([
            'parent_id' => $rule->id,
            'is_cancelled' => true,
            'original_date' => $originalDate,
            'hora_inicio' => '10:00:00', // Mantenemos la hora para referencia
            'hora_fin' => '12:00:00',
        ]);

        // Registro de excepción (el evento movido al miércoles 16 a las 15:00)
        $exception = Schedule::factory()->create([
            'parent_id' => $rule->id,
            'is_recurring' => false,
            'dia_semana' => 3, // Miércoles
            'hora_inicio' => '15:00:00',
            'hora_fin' => '17:00:00',
            'original_date' => $originalDate, // Guardamos la fecha original
        ]);

        // 2. Act (Actuar)
        $user = User::factory()->create();
        $response = $this->actingAs($user)->getJson(route('admin.schedule.events'));

        // 3. Assert (Verificar)
        $response->assertStatus(200);

        // Verificar que la regla principal está y tiene la `exdate` correcta
        $response->assertJsonFragment([
            'id' => $rule->id,
            'rrule' => [
                'freq' => 'weekly',
                'byweekday' => ['MO'], // Lunes
                'dtstart' => '2025-07-01T10:00:00',
                'until' => '2025-07-31',
            ],
            // CRÍTICO: La fecha de exclusión debe estar en formato UTC (asumiendo que la app corre en UTC+2)
            'exdate' => [
                Carbon::parse('2025-07-14 10:00:00', config('app.timezone'))->setTimezone('UTC')->format('Y-m-d\TH:i:s\Z')
            ]
        ]);

        // Verificar que la excepción está como un evento separado
        $response->assertJsonFragment([
            'id' => $exception->id,
            'start' => '2025-07-16T15:00:00', // El miércoles
            'end' => '2025-07-16T17:00:00',
        ]);

        // Verificar que el evento de cancelación NO se envía al frontend
        $response->assertJsonMissing([
            'is_cancelled' => true,
        ]);
    }
}