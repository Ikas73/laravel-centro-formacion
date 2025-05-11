<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // Limpiar tablas antes (opcional, útil para desarrollo)
        // DB::statement('SET FOREIGN_KEY_CHECKS=0;'); // Desactivar claves foráneas (MySQL) - PostgreSQL tiene TRUNCATE ... CASCADE
        // AlumnoCurso::truncate();
        // Curso::truncate();
        // Alumno::truncate();
        // Profesor::truncate();
        // PreinscritoSepe::truncate();
        // DB::statement('SET FOREIGN_KEY_CHECKS=1;'); // Reactivar claves foráneas (MySQL)

        $this->command->info("Iniciando el proceso de Seeding...");

        $this->call([
            // 1. Entidades base sin dependencias externas (o solo User si aplica)
            UserSeeder::class,
            ProfesorSeeder::class,       // Debe ir antes de CursoSeeder
            AlumnoSeeder::class,         // Debe ir antes de AlumnoCursoSeeder
            PreinscritoSepeSeeder::class,// Independiente en este punto

            // 2. Entidades que dependen de las anteriores
            CursoSeeder::class,          // Depende de ProfesorSeeder

            // 3. Entidades de relación (pivote)
            AlumnoCursoSeeder::class,    // Depende de AlumnoSeeder y CursoSeeder
        ]);

        $this->command->info("¡Seeding completado!");
    }
}