<?php

namespace Database\Factories;

use App\Models\Alumno; // Verifica la ruta del modelo
use Illuminate\Database\Eloquent\Factories\Factory;

class AlumnoFactory extends Factory
{
    protected $model = Alumno::class;

    public function definition(): array
    {
        $sexo = fake()->randomElement(['Hombre', 'Mujer']);
        $nombre = ($sexo === 'Hombre') ? fake()->firstNameMale() : fake()->firstNameFemale();
        $situacion = ['Desempleado', 'Empleado a tiempo completo', 'Empleado a tiempo parcial', 'Estudiante', 'Autónomo'];
        $nivel = ['Sin estudios', 'ESO', 'Bachillerato', 'Grado Medio', 'Grado Superior', 'Grado Universitario', 'Máster', 'Doctorado'];

        return [
            'nombre' => $nombre,
            'apellido1' => fake()->lastName(),
            'apellido2' => fake()->optional(0.7)->lastName(),
            'dni' => fake()->unique()->numerify('########').fake()->randomLetter(),
            // 'num_seguridad_social' => fake()->optional(0.8)->unique()->numerify('##/########/##'), // Opcional
            // --- LÍNEA CORREGIDA ---
            'num_seguridad_social' => fake()->boolean(80) // 80% de probabilidad de que sea true
                ? fake()->unique()->numerify('##/########/##') // Si es true, genera el número único
                : null, // Si es false (20%), asigna null
            'fecha_nacimiento' => fake()->dateTimeBetween('-50 years', '-16 years')->format('Y-m-d'),
            'sexo' => $sexo,
            'direccion' => fake()->streetAddress(),
            'cp' => fake()->postcode(),
            'localidad' => fake()->city(),
            'provincia' => fake()->state(), // O usa lista de provincias españolas
            // --- ¡CORREGIR ESTA LÍNEA TAMBIÉN! ---
            // Original (incorrecta): 'telefono' => fake()->optional(0.9)->unique()->numerify('6########'),
            'telefono' => fake()->boolean(90) // 90% de probabilidad de tener teléfono
                ? fake()->unique()->numerify('6########') // Si es true, genera
                : null, // Si es false (10%), asigna null
            'email' => fake()->unique()->safeEmail(),
            'nacionalidad' => fake()->randomElement(['Española', 'Portuguesa', 'Marroquí', 'Colombiana', 'Otra']),
            'situacion_laboral' => fake()->randomElement($situacion),
            'nivel_formativo' => fake()->randomElement($nivel),
            'estado' => fake()->randomElement(['Activo', 'Inactivo', 'Baja', 'Pendiente']), // Ejemplo de estados
        ];
    }
}
