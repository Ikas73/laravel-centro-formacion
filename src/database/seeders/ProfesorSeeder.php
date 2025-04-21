<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Profesor; // Importa tu modelo Profesor

class ProfesorSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Mensaje informativo (opcional)
        $this->command->info('Creando 12 profesores de ejemplo...');

        // Usar el Factory para crear 12 registros de Profesor
        Profesor::factory()->count(12)->create();

        $this->command->info('¡12 profesores creados!');
    }
}