<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
{
    Schema::table('preinscritos_sepe', function (Blueprint $table) {
        $table->string('sexo', 20)->nullable();
    });
}

public function down()
{
    Schema::table('preinscritos_sepe', function (Blueprint $table) {
        $table->dropColumn('sexo');
    });
}

};
