<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder; // Importar User
use Illuminate\Support\Facades\Hash; // Importar Hash

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $this->command->info('Creando/verificando usuario administrador...');

        User::firstOrCreate(
            ['email' => 'admin@admin.com'], // El email que quieres
            [
                'name' => 'Admin Principal', // El nombre que quieres
                'password' => Hash::make('admin'), // La contraseña que quieres (hasheada)
                'email_verified_at' => now(), // Marcar como verificado
            ]
        );

        $this->command->info('Usuario admin@admin.com procesado.');

        // Opcional: Crear otros usuarios de prueba con factory
        // User::factory()->count(10)->create();
    }
}
