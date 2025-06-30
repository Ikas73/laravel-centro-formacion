<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
{
    Schema::create('cursos', function (Blueprint $table) {
        $table->id();
        $table->string('nombre', 255);
        $table->string('codigo', 20)->nullable();
        $table->text('descripcion')->nullable();
        $table->string('modalidad', 50)->nullable();
        $table->string('nivel', 50)->nullable();
        $table->text('requisitos')->nullable();
        $table->date('fecha_inicio')->nullable();
        $table->date('fecha_fin')->nullable();
        $table->integer('horas_totales')->nullable();
        $table->string('horario', 100)->nullable();
        $table->string('centros', 255)->nullable();        
        $table->integer('plazas_maximas')->default(20);

        // --- ÚNICA Y CORRECTA DEFINICIÓN PARA PROFESOR_ID ---
        $table->foreignId('profesor_id')
              ->nullable() // O quita nullable si es obligatorio
              ->constrained('profesores') // Especifica la tabla a la que hace referencia
              ->nullOnDelete(); // O tu política preferida en eliminación

        $table->timestamps();
    });
}


    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('cursos');
    }
};
