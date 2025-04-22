<?php

namespace Database\Factories;

use App\Models\PreinscritoSepe; // Verifica la ruta del modelo
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

class PreinscritoSepeFactory extends Factory
{
    protected $model = PreinscritoSepe::class;

    public function definition(): array
    {
        // Reutilizamos las mismas variables que en AlumnoFactory si aplican
        $situacion = ['Desempleado', 'Empleado', 'Mejora de empleo', 'Otro'];
        $nivel = ['Sin estudios', 'ESO', 'Bachillerato', 'Grado Medio', 'Grado Superior', 'Grado Universitario'];

        return [
            'nombre' => fake()->firstName(),
            'apellido1' => fake()->lastName(),
            'apellido2' => fake()->optional(0.7)->lastName(),
            'dni' => fake()->unique()->numerify('########') . fake()->randomLetter(),
            'fecha_nacimiento' => fake()->dateTimeBetween('-60 years', '-16 years')->format('Y-m-d'),
            'telefono' => fake()->boolean(90) // 90% de probabilidad de tener teléfono
                ? fake()->unique()->numerify('6########') // Si es true, genera
                : null, // Si es false (10%), asigna null
            // --- LÍNEA CORREGIDA ---
            'email' => fake()->boolean(80) // 80% de probabilidad de tener email
                ? fake()->unique()->safeEmail() // Si es true, genera email único
                : null, // Si es false (20%), asigna null

            // --- ¡CORREGIR TAMBIÉN LA DIRECCIÓN! ---
            // Original (incorrecta): 'direccion' => fake()->optional()->streetAddress(),
            // ->optional() sin argumento es 50% de probabilidad
            'direccion' => fake()->boolean(50) ? fake()->streetAddress() : null,
            'localidad' => fake()->city(),
            'provincia' => fake()->state(),
            'cp' => fake()->postcode(),
            'nacionalidad' => fake()->randomElement(['Española', 'Comunitaria', 'Extracomunitaria']),
            'situacion_laboral' => fake()->randomElement($situacion),
            'nivel_formativo' => fake()->randomElement($nivel),
            'fecha_importacion' => fake()->dateTimeThisYear(), // Fecha de importación en este año
        ];
    }
}