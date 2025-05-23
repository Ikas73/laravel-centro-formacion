<?php

namespace Database\Seeders;

use App\Models\Curso;
use Illuminate\Database\Seeder; // Importar modelo

class CursoSeeder extends Seeder
{
    public function run(): void
    {
        $cantidad = 15; // Define cuántos cursos crear
        $this->command->info("Creando $cantidad cursos de ejemplo...");
        Curso::factory()->count($cantidad)->create();
        $this->command->info("¡$cantidad cursos creados!");
    }
}
