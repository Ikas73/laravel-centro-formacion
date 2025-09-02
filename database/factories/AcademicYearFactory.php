<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Carbon\Carbon;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\AcademicYear>
 */
class AcademicYearFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        // Genera fechas realistas para un año académico
        $startYear = $this->faker->numberBetween(2020, 2025);
        $startDate = Carbon::create($startYear, 9, 1); // 1 de Septiembre
        $endDate = $startDate->copy()->addMonths(10);  // 10 meses después

        return [
            'name' => 'Año Académico ' . $startYear . '-' . ($startYear + 1),
            'start_date' => $startDate->toDateString(),
            'end_date' => $endDate->toDateString(),
            'is_active' => false, // Por defecto, los creamos inactivos para los tests.
        ];
    }
}