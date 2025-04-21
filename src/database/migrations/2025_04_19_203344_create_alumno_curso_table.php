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
    Schema::create('alumno_curso', function (Blueprint $table) {
        $table->id();
        $table->foreignId('alumno_id')->constrained('alumnos');
        $table->foreignId('curso_id')->constrained('cursos');
        $table->date('fecha_inscripcion')->default(now());
        $table->decimal('nota', 4, 2)->nullable();
        $table->string('estado', 50)->nullable();
        $table->unique(['alumno_id', 'curso_id']);
        $table->timestamps();
    });
}


    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('alumno_curso');
    }
};
