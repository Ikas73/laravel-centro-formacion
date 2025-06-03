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
        $situacion = ['Desempleado', 'Empleado', 'Mejora de empleo', 'Otro'];
        $nivel = ['Sin estudios', 'ESO', 'Bachillerato', 'Grado Medio', 'Grado Superior', 'Grado Universitario'];
        $estadosPreinscrito = ['Pendiente', 'Contactado', 'Interesado', 'No Interesado', 'Convertido']; // Ajusta tus estados

        return [
            'nombre' => fake()->firstName(),
            'apellido1' => fake()->lastName(),
            'apellido2' => fake()->optional(0.7)->lastName(),
            'dni' => fake()->unique()->numerify('########') . fake()->randomLetter(),
            'fecha_nacimiento' => fake()->dateTimeBetween('-60 years', '-16 years')->format('Y-m-d'),
            'telefono' => fake()->boolean(90) ? fake()->unique()->numerify('6########') : null,
            'email' => fake()->boolean(80) ? fake()->unique()->safeEmail() : null,
            'direccion' => fake()->boolean(70) ? fake()->streetAddress() : null,
            'localidad' => fake()->city(),
            'provincia' => fake()->state(), // O usa una lista de provincias españolas
            'cp' => fake()->boolean(80) ? fake()->postcode() : null,
            'nacionalidad' => fake()->randomElement(['Española', 'Comunitaria', 'Extracomunitaria', 'Otra']),
            'situacion_laboral' => fake()->randomElement($situacion),
            'nivel_formativo' => fake()->randomElement($nivel),
            'fecha_importacion' => fake()->dateTimeThisYear(), // O now() si quieres que siempre sea la fecha actual
            'estado' => fake()->randomElement($estadosPreinscrito), // Asegúrate que el campo 'estado' existe en tu $fillable del modelo
        ];
    }
    
}