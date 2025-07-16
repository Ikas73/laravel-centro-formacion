<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Profesor; // Importa tu modelo Profesor

class ProfesorSeeder extends Seeder
{
    public function run(): void
    {
        $this->command->info('Limpiando y creando un único profesor de prueba...');

        Profesor::truncate();

        Profesor::create([
            'nombre' => 'Profesor',
            'apellido1' => 'De',
            'apellido2' => 'Prueba',
            'email' => 'profesor@test.com',
            'telefono' => '123456789',
            'dni' => '12345678X',
        ]);

        $this->command->info('¡Profesor de prueba creado!');
    }
}