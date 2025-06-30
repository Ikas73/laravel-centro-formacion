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
            
            // Relación con el curso
            $table->foreignId('curso_id')
                  ->constrained('cursos')
                  ->onDelete('cascade');
            
            // Columnas para los detalles del horario
            $table->tinyInteger('dia_semana'); // 1=Lunes, 2=Martes...
            $table->time('hora_inicio');
            $table->time('hora_fin');
            $table->string('aula')->nullable();
            
            // Relación opcional con un profesor específico para esta franja
            $table->foreignId('profesor_id')
                  ->nullable()
                  ->constrained('profesores')
                  ->onDelete('set null');
            
            // Timestamps (created_at y updated_at)
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