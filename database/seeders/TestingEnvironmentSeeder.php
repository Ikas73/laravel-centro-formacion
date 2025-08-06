<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use App\Models\User;
use App\Models\Profesor;
use App\Models\Curso;
use App\Models\Alumno;
use App\Models\PreinscritoSepe;
use App\Models\Schedule;

class TestingEnvironmentSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $this->call(RolesAndPermissionsSeeder::class);

        $this->command->info('Iniciando el seeder para el entorno de pruebas manuales...');

        // Desactivar la revisión de claves foráneas para el truncado (sintaxis PostgreSQL)
        DB::statement("SET session_replication_role = 'replica';");

        // Vaciar tablas en el orden correcto para evitar conflictos de claves foráneas
        DB::table('alumno_curso')->truncate();
        Schedule::truncate();
        Curso::truncate();
        Profesor::truncate();
        Alumno::truncate();
        PreinscritoSepe::truncate();
        User::where('email', '!=', 'admin@admin.com')->delete();


        // Reactivar la revisión de claves foráneas (sintaxis PostgreSQL)
        DB::statement("SET session_replication_role = 'origin';");

        // --- Creación de Entidades ---
        $this->command->info('Creando usuarios, profesores, alumnos y cursos...');

        // Crear usuario admin si no existe y asignarle el rol de System Administrator
        $adminUser = User::firstOrCreate(
            ['email' => 'admin@admin.com'],
            [
                'name' => 'Admin',
                'password' => bcrypt('admin'),
            ]
        );
        $adminUser->assignRole('System Administrator');

        // Crear usuario Secretary
        $secretaryUser = User::firstOrCreate(
            ['email' => 'secretary@admin.com'],
            [
                'name' => 'Secretary',
                'password' => bcrypt('admin'),
            ]
        );
        $secretaryUser->assignRole('Secretary');

        // Crear usuario Teacher
        $teacherUser = User::firstOrCreate(
            ['email' => 'teacher@admin.com'],
            [
                'name' => 'Teacher',
                'password' => bcrypt('admin'),
            ]
        );
        $teacherUser->assignRole('Teacher');

        $profesores = Profesor::factory(10)->create();
        $alumnos = Alumno::factory(50)->create();
        $preinscritos = PreinscritoSepe::factory(30)->create();
        $cursos = Curso::factory(15)->create();

        $this->command->info('Entidades base creadas. Generando horarios sin conflictos...');

        // --- Lógica para Generar Horarios Sin Conflictos ---
        $diasSemana = [1, 2, 3, 4, 5]; // Lunes a Viernes
        $franjasHorarias = [
            ['inicio' => '09:00:00', 'fin' => '11:00:00'],
            ['inicio' => '11:00:00', 'fin' => '13:00:00'],
            ['inicio' => '16:00:00', 'fin' => '18:00:00'],
            ['inicio' => '18:00:00', 'fin' => '20:00:00'],
        ];
        $aulasDisponibles = ['Aula 101', 'Aula 102', 'Aula 103', 'Aula 201', 'Aula 202', 'Aula 203'];

        $horariosOcupados = []; // ['dia-hora_inicio-profesor_id'] y ['dia-hora_inicio-aula']

        foreach ($cursos as $curso) {
            $horarioAsignado = false;
            foreach ($diasSemana as $dia) {
                if ($horarioAsignado) break;
                foreach ($franjasHorarias as $franja) {
                    if ($horarioAsignado) break;
                    foreach ($profesores as $profesor) {
                        if ($horarioAsignado) break;
                        foreach ($aulasDisponibles as $aula) {
                            $keyProfesor = "{$dia}-{$franja['inicio']}-{$profesor->id}";
                            $keyAula = "{$dia}-{$franja['inicio']}-{$aula}";

                            if (!isset($horariosOcupados[$keyProfesor]) && !isset($horariosOcupados[$keyAula])) {
                                Schedule::create([
                                    'curso_id' => $curso->id,
                                    'profesor_id' => $profesor->id,
                                    'dia_semana' => $dia,
                                    'hora_inicio' => $franja['inicio'],
                                    'hora_fin' => $franja['fin'],
                                    'aula' => $aula,
                                    'is_recurring' => true,
                                ]);

                                // Marcar recursos como ocupados
                                $horariosOcupados[$keyProfesor] = true;
                                $horariosOcupados[$keyAula] = true;
                                $horarioAsignado = true;
                                break;
                            }
                        }
                    }
                }
            }
        }

        $this->command->info('¡Seeder completado! La base de datos está lista para las pruebas manuales.');
    }
}
