<?php

namespace Database\Factories;

use App\Models\AlumnoCurso; // Verifica la ruta del modelo
use App\Models\Alumno; // Necesario
use App\Models\Curso; // Necesario
use Illuminate\Database\Eloquent\Factories\Factory;

class AlumnoCursoFactory extends Factory
{
    protected $model = AlumnoCurso::class;

    public function definition(): array
    {
        // ESTO ES PROBLEMÁTICO: Genera IDs al azar, sin verificar
        // si el par ya existe o si el curso está lleno.
        // ¡La lógica real DEBE estar en el Seeder!
        $alumnoId = Alumno::inRandomOrder()->first()?->id;
        $cursoId = Curso::inRandomOrder()->first()?->id;

        if (!$alumnoId || !$cursoId) {
             throw new \Exception("Asegúrate de que AlumnoSeeder y CursoSeeder se ejecutan primero.");
        }

        $estado = fake()->randomElement(['Inscrito', 'Completado', 'Baja', 'Pendiente']);
        $nota = ($estado === 'Completado') ? fake()->randomFloat(2, 4, 10) : null; // Nota solo si completado

        return [
            'alumno_id' => $alumnoId,
            'curso_id' => $cursoId,
            'fecha_inscripcion' => fake()->dateTimeBetween('-1 year', 'now')->format('Y-m-d'),
            'nota' => $nota,
            'estado' => $estado,
        ];
    }
}