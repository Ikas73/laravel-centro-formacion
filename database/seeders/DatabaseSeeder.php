<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Profesor;
use App\Models\Curso;
use App\Models\Schedule;
use App\Models\User;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        $this->command->info("Ejecutando un Seeder de Prueba Simplificado...");

        // Limpiar tablas en el orden correcto para evitar problemas de foreign keys
        Schedule::truncate();
        Curso::truncate();
        Profesor::truncate();
        User::truncate();

        // 1. Crear usuario administrador
        User::factory()->create([
            'name' => 'admin',
            'email' => 'admin@admin.com',
            'password' => bcrypt('admin'),
        ]);
        $this->command->info("✓ Usuario admin creado.");

        // 2. Crear un Profesor de prueba
        $profesor = Profesor::create([
            'nombre' => 'Profesor',
            'apellido1' => 'De',
            'apellido2' => 'Prueba',
            'email' => 'profesor@test.com',
            'telefono' => '123456789',
            'dni' => '12345678X',
        ]);
        $this->command->info("✓ Profesor de prueba creado.");

        // 3. Crear un Curso de prueba y asignarle el profesor anterior
        $curso = Curso::create([
            'nombre' => 'Curso de Test para Cypress',
            'codigo' => 'CYP-001',
            'descripcion' => 'Curso específico para pruebas E2E.',
            'modalidad' => 'Online',
            'nivel' => 'Intermedio',
            'requisitos' => 'Ninguno',
            'fecha_inicio' => '2025-07-01',
            'fecha_fin' => '2025-07-31',
            'horas_totales' => 50,
            'horario' => '09:00-11:00 L-V',
            'centros' => 'Plataforma Online',
            'profesor_id' => $profesor->id,
            'plazas_maximas' => 20,
        ]);
        $this->command->info("✓ Curso de prueba creado.");

        // 4. Crear un Horario de prueba para el curso anterior
        $dias = [1, 3, 5]; // Lunes, Miércoles, Viernes
        foreach ($dias as $dia) {
            Schedule::create([
                'curso_id' => $curso->id,
                'profesor_id' => $profesor->id,
                'dia_semana' => $dia,
                'hora_inicio' => '09:00:00',
                'hora_fin' => '11:00:00',
                'aula' => 'Aula de Test',
            ]);
        }
        $this->command->info("✓ Horarios de prueba creados para Lunes, Miércoles y Viernes.");

        $this->command->info("¡Seeding de prueba completado con éxito!");
    }
}