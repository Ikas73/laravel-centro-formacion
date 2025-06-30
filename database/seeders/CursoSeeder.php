<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Curso; // Importar modelo

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