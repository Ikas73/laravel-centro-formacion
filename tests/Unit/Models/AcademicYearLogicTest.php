<?php

namespace Tests\Unit\Models;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use App\Models\AcademicYear;
use PHPUnit\Framework\Attributes\Test; // <-- 1. Añade este 'use'

class AcademicYearLogicTest extends TestCase
{
    use RefreshDatabase;

    #[Test] // <-- 2. Cambia el comentario por este atributo
    public function activating_one_academic_year_automatically_deactivates_others()
    {
        // ... el resto del código del test permanece igual ...
        $activeYear = AcademicYear::factory()->create(['name' => '2023-2024', 'is_active' => true]);
        $year1 = AcademicYear::factory()->create(['name' => '2024-2025', 'is_active' => false]);
        $year2 = AcademicYear::factory()->create(['name' => '2025-2026', 'is_active' => false]);

        $year2->is_active = true;
        $year2->save();
        
        $this->assertFalse($activeYear->fresh()->is_active, 'El año previamente activo no se desactivó.');
        $this->assertFalse($year1->fresh()->is_active, 'Un año que ya era inactivo no debió cambiar.');
        $this->assertTrue($year2->fresh()->is_active, 'El año objetivo no se activó correctamente.');
    }
}