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
        // En el método up() de la nueva migración
        Schema::table('alumnos', function (Blueprint $table) {
            $table->string('estado')->nullable()->after('nivel_formativo'); // O después de la columna que prefieras
            // Podrías poner un default: ->default('Activo');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // En el método down()
        Schema::table('alumnos', function (Blueprint $table) {
            $table->dropColumn('estado');
        });
    }
};
