<?php

namespace Database\Seeders;

use App\Models\PreinscritoSepe;
use Illuminate\Database\Seeder; // Importar modelo

class PreinscritoSepeSeeder extends Seeder
{
    public function run(): void
    {
        $cantidad = 25; // Define cuántos preinscritos crear
        $this->command->info("Creando $cantidad preinscritos de ejemplo...");
        PreinscritoSepe::factory()->count($cantidad)->create();
        $this->command->info("¡$cantidad preinscritos creados!");
    }
}
