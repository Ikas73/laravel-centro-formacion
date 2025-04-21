<?php

namespace Database\Factories;

use App\Models\Profesor; // Asegúrate que la ruta a tu modelo es correcta
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str; // Para el DNI de ejemplo

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Profesor>
 */
class ProfesorFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Profesor::class; // Especifica el modelo aquí también si es necesario

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        // Lista de titulaciones y especialidades de ejemplo
        $titulaciones = [
            'Licenciatura en Informática', 'Grado en Ingeniería de Software', 'Doctorado en IA',
            'Licenciatura en ADE', 'Grado en Marketing Digital', 'Máster en Finanzas',
            'Licenciatura en Filología Inglesa', 'Grado en Traducción e Interpretación',
            'Ingeniería Técnica Industrial', 'Grado en Electrónica Industrial',
            'Licenciatura en Derecho', 'Máster en Derecho Laboral'
        ];
        $especialidades = [
            'Desarrollo Backend (PHP/Java)', 'Desarrollo Frontend (React/Vue)', 'Bases de Datos SQL/NoSQL',
            'Administración de Empresas', 'Marketing Online y SEO', 'Contabilidad y Fiscalidad',
            'Inglés para Negocios (B2/C1)', 'Metodologías Ágiles (Scrum)',
            'Automatización Industrial', 'Sistemas Embebidos',
            'Derecho Mercantil', 'Prevención de Riesgos Laborales'
        ];

        // Generar sexo para usar nombres apropiados
        $sexo = fake()->randomElement(['Hombre', 'Mujer']);
        $nombre = ($sexo === 'Hombre') ? fake()->firstNameMale() : fake()->firstNameFemale();

        return [
            'nombre' => $nombre,
            'apellido1' => fake()->lastName(),
            'apellido2' => fake()->optional(0.7)->lastName(), // 70% de probabilidad de tener segundo apellido
            // DNI: formato realista (8 números + letra), pero letra aleatoria (no calculada)
            // unique() asegura que no se repitan DNI en esta ejecución del seeder
            'dni' => fake()->unique()->numerify('########') . fake()->randomLetter(),
            // NUSS: formato realista, pero números aleatorios
            'num_seguridad_social' => fake()->unique()->numerify('##/########/##'),
            // Fecha de nacimiento para edades entre 28 y 65 años
            'fecha_nacimiento' => fake()->dateTimeBetween('-65 years', '-28 years')->format('Y-m-d'),
            'sexo' => $sexo,
            'direccion' => fake()->streetAddress(),
            // Teléfono móvil español realista
            'telefono' => fake()->unique()->numerify('6########'), // Empieza por 6
            // Email único basado en nombre/apellido
            'email' => fake()->unique()->safeEmail(),
            'titulacion_academica' => fake()->randomElement($titulaciones),
            'especialidad' => fake()->randomElement($especialidades),
            // created_at y updated_at son manejados automáticamente por Eloquent
        ];
    }
}