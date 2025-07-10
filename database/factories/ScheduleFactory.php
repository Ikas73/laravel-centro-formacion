<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\Curso;
use App\Models\Profesor;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Schedule>
 */
class ScheduleFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'curso_id' => Curso::factory(),
            'profesor_id' => Profesor::factory(),
            'dia_semana' => $this->faker->numberBetween(1, 5),
            'hora_inicio' => $this->faker->time('H:i:s'),
            'hora_fin' => $this->faker->time('H:i:s'),
            'aula' => 'Aula ' . $this->faker->numberBetween(100, 200),
            'is_recurring' => true,
            'is_cancelled' => false,
            'parent_id' => null,
            'original_date' => null,
        ];
    }
}