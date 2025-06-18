<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('schedules', function (Blueprint $table) {
            $table->id();
        
            // Curso
            $table->foreignId('curso_id')
                  ->constrained('cursos')   // ← tabla real
                  ->cascadeOnDelete();
        
            // Profesor
            $table->foreignId('profesor_id')
                  ->constrained('profesores')
                  ->cascadeOnDelete();
        
            // Franja horaria
            $table->foreignId('time_slot_id')
                  ->constrained()
                  ->cascadeOnDelete();
        
            // Ninguna franja se puede duplicar
            $table->unique('time_slot_id');
        
            $table->timestamps();
        });
        
        
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('schedules');
    }
};
