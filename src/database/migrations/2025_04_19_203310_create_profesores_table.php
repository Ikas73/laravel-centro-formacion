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
    Schema::create('profesores', function (Blueprint $table) {
        $table->id();
        $table->string('nombre', 100);
        $table->string('apellido1', 100);
        $table->string('apellido2', 100)->nullable();
        $table->string('dni', 15)->unique();
        $table->string('num_seguridad_social', 20)->nullable();
        $table->date('fecha_nacimiento')->nullable();
        $table->string('sexo', 10)->nullable();
        $table->text('direccion')->nullable();
        $table->string('telefono', 20)->nullable();
        $table->string('email', 100)->nullable();
        $table->string('titulacion_academica', 150)->nullable();
        $table->string('especialidad', 100)->nullable();
        $table->timestamps();
    });
}


    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('profesores');
    }
};
