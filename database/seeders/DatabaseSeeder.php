<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $this->command->info("Iniciando el proceso de Seeding...");

        // Llamamos a todos los seeders en un único array, en el orden correcto de dependencias.
        $this->call([
            // 1. Entidades base que no dependen de otras (excepto User).
            UserSeeder::class,
            ProfesorSeeder::class,
            AlumnoSeeder::class,
            PreinscritoSepeSeeder::class,

            // 2. Entidades que dependen de las anteriores.
            CursoSeeder::class,          // Depende de Profesores.

            // 3. Tablas pivote o de relación.
            AlumnoCursoSeeder::class,    // Depende de Alumnos y Cursos.

            // 4. Seeder de Horarios.
            //    Este seeder ya crea los TimeSlots que necesita, por lo que no es
            //    necesario llamar a TimeSlotSeeder por separado.
            ScheduleSeeder::class,
        ]);

        $this->command->info("¡Seeding completado con éxito!");
    }
}