<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Profesor;

class CursoSeeder extends Seeder
{
    public function run(): void
    {
        $this->command->info("Limpiando y creando un único curso de prueba...");

        // Limpiar cursos anteriores para evitar duplicados
        Curso::truncate();

        // Crear un único curso con datos predecibles
        Curso::create([
            'nombre' => 'Curso de Test para Cypress',
            'codigo' => 'CYP-001',
            'descripcion' => 'Curso específico para pruebas E2E.',
            'modalidad' => 'Online',
            'nivel' => 'Intermedio',
            'requisitos' => 'Ninguno',
            'fecha_inicio' => '2025-07-01',
            'fecha_fin' => '2025-07-31',
            'horas_totales' => 50,
            'horario' => '09:00-11:00 L-V', // Horario que el ScheduleSeeder pueda parsear
            'centros' => 'Plataforma Online',
            'profesor_id' => Profesor::first()->id, // Asigna el primer profesor que encuentre
            'plazas_maximas' => 20,
        ]);

        $this->command->info("¡Curso de prueba creado!");
    }
}