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
        Schema::create('time_slots', function (Blueprint $table) {
            // Clave primaria
            $table->id();
        
            // Día de la semana (0 = domingo, 6 = sábado)
            $table->tinyInteger('weekday');
        
            // Hora de inicio y de fin
            $table->time('start_time');
            $table->time('end_time');
        
            // Aula en la que se imparte la clase
            $table->string('room', 50);
        
            // Marcas de tiempo (created_at, updated_at)
            $table->timestamps();
        
            // Índice compuesto para búsquedas rápidas por día, hora y aula
            $table->index(['weekday', 'start_time', 'room']);
        });
        
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('time_slots');
    }
};
