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
        $table->unsignedBigInteger('profesor_id');
        $table->foreign('profesor_id')->references('id')->on('profesores')->onDelete('SET NULL'); // O onDelete('RESTRICT') si no quieres que se borre
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
        $table->foreignId('profesor_id')->constrained('profesores');
        $table->integer('plazas_maximas')->default(20);
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
