<?php

namespace Database\Factories;

use App\Models\Curso; // Verifica la ruta del modelo
use App\Models\Profesor; // Necesario para asignar profesor
use Illuminate\Database\Eloquent\Factories\Factory;
use Carbon\Carbon;

class CursoFactory extends Factory
{
    protected $model = Curso::class;

    public function definition(): array
    {
        $modalidades = ['Presencial', 'Online', 'Semipresencial (Blended)'];
        $niveles = ['Básico', 'Intermedio', 'Avanzado', 'Especialización'];
        $horarios = ['09:00-13:00 L-V (4h)', '16:00-20:00 L-V (4h)', '09:00-15:00 L-V (6h)', '09:00-13:00 y 16:00-20:00 L-J (8h Mixto)', 'Fines de semana (S 09:00-14:00)'];
        $centros = ['Centro Principal - Aula 1', 'Centro Norte - Aula Magna', 'Plataforma Online Moodle', 'Centro Sur - Taller 3'];

        // Asegurarse que existen profesores antes de ejecutar este factory
        $profesorId = Profesor::inRandomOrder()->first()?->id; // Obtiene el ID de un profesor al azar
         // Si no hay profesores, lanza un error o retorna null/default ID? Depende de tu lógica.
         // Para evitar errores, el ProfesorSeeder DEBE ejecutarse antes.
         if(!$profesorId) {
             // Podrías crear un profesor aquí si no existe, pero es mejor asegurar el orden en DatabaseSeeder
             throw new \Exception("No se encontraron profesores para asignar al curso. Asegúrate de ejecutar ProfesorSeeder primero.");
         }

        $fechaInicio = Carbon::create(2025, 7, 1);
        $fechaFin = Carbon::create(2025, 7, 31);


        return [
            'nombre' => fake()->catchPhrase() . ' ' . fake()->jobTitle(), // Nombre de curso inventado
            'codigo' => fake()->unique()->bothify('??###??'), // Código único
            'descripcion' => fake()->paragraph(3),
            'modalidad' => fake()->randomElement($modalidades),
            'nivel' => fake()->randomElement($niveles),
            'requisitos' => fake()->sentence(10),
            'fecha_inicio' => $fechaInicio->format('Y-m-d'),
            'fecha_fin' => $fechaFin->format('Y-m-d'),
            'horas_totales' => fake()->numberBetween(40, 600),
            'horario' => fake()->randomElement($horarios),
            'centros' => fake()->randomElement($centros),
            'profesor_id' => $profesorId, // Asigna el ID del profesor obtenido
            'plazas_maximas' => fake()->numberBetween(15, 25), // Plazas entre 15 y 25
        ];
    }

    /**
     * Indica que el curso debe tener fechas en el pasado (finalizado).
     *
     * @return \Illuminate\Database\Eloquent\Factories\Factory
     */
    public function finalizado()
    {
        return $this->state(function (array $attributes) {
            // Generar fechas de inicio y fin que estén en el pasado
            $fechaFinPasada = Carbon::instance(fake()->dateTimeBetween('-1 year', '-1 week')); // Fecha fin entre hace 1 año y hace 1 semana
            $duracionDias = fake()->numberBetween(30, 180);
            $fechaInicioPasada = $fechaFinPasada->copy()->subDays($duracionDias); // Restar días para obtener inicio

            return [
                'fecha_inicio' => $fechaInicioPasada->format('Y-m-d'),
                'fecha_fin' => $fechaFinPasada->format('Y-m-d'),
            ];
        });
}
}