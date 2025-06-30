<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Alumno; // Importar modelo

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