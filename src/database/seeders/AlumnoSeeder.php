<?php

namespace Database\Seeders;

use App\Models\Alumno;
use Illuminate\Database\Seeder; // Importar modelo

class AlumnoSeeder extends Seeder
{
    public function run(): void
    {
        $cantidad = 50; // Define cuántos alumnos crear
        $this->command->info("Creando $cantidad alumnos de ejemplo...");
        Alumno::factory()->count($cantidad)->create();
        $this->command->info("¡$cantidad alumnos creados!");
    }
}
