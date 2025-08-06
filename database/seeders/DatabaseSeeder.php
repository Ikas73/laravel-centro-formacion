<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        // Llama únicamente al seeder personalizado para el entorno de pruebas
        $this->call(TestingEnvironmentSeeder::class);
    }
}
