<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Alumno;
use App\Models\Curso;
use App\Models\AlumnoCurso;
use Illuminate\Support\Facades\DB; // Para consultas eficientes
use Carbon\Carbon;                 // Para manipulación de fechas

class AlumnoCursoSeeder extends Seeder
{
    /**
     * Ejecuta los seeds para la tabla alumno_curso.
     * Intenta asignar cursos a alumnos de forma aleatoria,
     * respetando las plazas máximas y evitando duplicados.
     */
    public function run(): void
    {
        $this->command->info("----------------------------------------");
        $this->command->info("Iniciando Seeder: Asignando cursos a alumnos...");
        $this->command->info("----------------------------------------");

        // 1. Obtener los IDs de los alumnos existentes
        $alumnosIds = Alumno::pluck('id');

        // 2. Obtener los cursos existentes con los datos necesarios
        // Usamos all() para asegurar que tenemos los objetos completos, luego indexamos por ID.
        $cursos = Curso::all()->keyBy('id');

        // 3. Verificar si hay datos suficientes para continuar
        if ($alumnosIds->isEmpty() || $cursos->isEmpty()) {
            $this->command->warn("-> No se pueden crear inscripciones. Asegúrate de que existen alumnos y cursos creados por los seeders anteriores.");
            return;
        }
        $this->command->line("-> Encontrados " . $alumnosIds->count() . " alumnos y " . $cursos->count() . " cursos.");

        // 4. Preparar datos para validaciones y batch insert
        // Array para guardar las nuevas inscripciones a insertar
        $inscripcionesACrear = [];

        // Mapa para buscar rápidamente inscripciones existentes (evitar violación UNIQUE)
        // Clave: "alumnoId-cursoId", Valor: true
        $inscripcionesExistentesMap = AlumnoCurso::select('alumno_id', 'curso_id')->get()->mapWithKeys(function ($item) {
            return [$item->alumno_id . '-' . $item->curso_id => true];
        });
        $this->command->line("-> Encontradas " . $inscripcionesExistentesMap->count() . " inscripciones previas (si se ejecuta sin migrate:fresh).");


        // Mapa para llevar la cuenta de inscritos actuales por curso (respetar plazas máximas)
        // Clave: curso_id, Valor: numero_de_inscritos_o_pendientes
        $cursosConInscritosMap = AlumnoCurso::select('curso_id', DB::raw('count(*) as total'))
                                        ->whereIn('estado', ['Inscrito', 'Pendiente']) // Solo contar los que ocupan plaza activa
                                        ->groupBy('curso_id')
                                        ->pluck('total', 'curso_id');

        // 5. Definir parámetros para el proceso de asignación
        $inscripcionesCreadasContador = 0;
        $maxInscripcionesPorAlumno = 3; // Límite de cuántos cursos intentaremos asignar a cada alumno

        $this->command->info("-> Intentando asignar hasta $maxInscripcionesPorAlumno cursos por alumno...");

        // 6. Iterar sobre cada alumno para intentar asignarle cursos
        foreach ($alumnosIds as $alumnoId) {
            $cursosAsignadosAEsteAlumno = 0;
            // Barajar los cursos disponibles para variar las asignaciones
            $cursosDisponibles = $cursos->shuffle();

            // Iterar sobre los cursos barajados para este alumno
            foreach ($cursosDisponibles as $cursoId => $curso) {

                // Si ya hemos asignado el máximo permitido a este alumno, pasamos al siguiente
                if ($cursosAsignadosAEsteAlumno >= $maxInscripcionesPorAlumno) {
                    break; // Salir del bucle de cursos para este alumno
                }

                // --- Controles de Seguridad y Lógica de Negocio ---

                // a) Control EXPLÍCITO contra IDs de curso inválidos (<= 0)
                if (!is_numeric($cursoId) || $cursoId <= 0) {
                     $this->command->error("-> ¡Saltando! Detectado curso_id inválido o no numérico: [" . $cursoId . "] para Alumno ID: [$alumnoId]. Revisar lógica de obtención de cursos.");
                     continue; // Pasar al siguiente curso
                }

                // b) Construir clave única para verificar duplicados
                $claveUnica = $alumnoId . '-' . $cursoId;
                if ($inscripcionesExistentesMap->has($claveUnica)) {
                    // $this->command->line("-> Saltando: Alumno [$alumnoId] ya tiene registro para Curso [$cursoId]."); // Descomentar para debug detallado
                    continue; // Ya existe, probar siguiente curso
                }

                // c) Verificar plazas disponibles
                $inscritosActuales = $cursosConInscritosMap->get($cursoId, 0); // Obtener inscritos actuales, 0 si no hay
                if ($inscritosActuales >= $curso->plazas_maximas) {
                    // $this->command->line("-> Saltando: Curso [$cursoId] lleno (Plazas: {$curso->plazas_maximas}, Inscritos: {$inscritosActuales})."); // Descomentar para debug detallado
                    continue; // Curso lleno, probar siguiente curso
                }

                // --- Preparación de Datos para la Nueva Inscripción ---

                // d) Generar estado y nota aleatorios
                $estado = fake()->randomElement(['Inscrito', 'Completado', 'Pendiente']);
                $nota = ($estado === 'Completado') ? fake()->randomFloat(2, 4, 10) : null;

                // e) Generar fecha de inscripción válida usando Carbon
                try {
                    $fechaInicioCursoObj = Carbon::parse($curso->fecha_inicio);
                    $fechaFinCursoObj = Carbon::parse($curso->fecha_fin);

                    $inicioRangoInscripcion = $fechaInicioCursoObj->copy()->subMonth(); // Restar un mes de forma segura

                    // Asegurar que el rango sea válido
                    if ($inicioRangoInscripcion->greaterThan($fechaFinCursoObj)) {
                        $inicioRangoInscripcion = $fechaInicioCursoObj;
                    }

                    $fechaInscripcion = fake()->dateTimeBetween(
                        $inicioRangoInscripcion,
                        $fechaFinCursoObj
                    )->format('Y-m-d');
                } catch (\Exception $e) {
                    // Capturar posible error de parseo de fecha si los datos son incorrectos
                    $this->command->error("-> Error al procesar fechas para Curso ID [$cursoId]: " . $e->getMessage());
                    $fechaInscripcion = now()->format('Y-m-d'); // Usar fecha actual como fallback
                }


                // f) Añadir la nueva inscripción al array para el batch insert
                $inscripcionesACrear[] = [
                    'alumno_id' => $alumnoId,
                    'curso_id' => $cursoId,          // Usar el ID del curso actual
                    'fecha_inscripcion' => $fechaInscripcion,
                    'nota' => $nota,
                    'estado' => $estado,
                    'created_at' => now(),        // Necesario para ::insert()
                    'updated_at' => now(),        // Necesario para ::insert()
                ];

                // --- Actualizar contadores internos para las siguientes iteraciones ---
                $inscripcionesExistentesMap->put($claveUnica, true);        // Marcar como "existente" para este run
                $cursosConInscritosMap->put($cursoId, $inscritosActuales + 1); // Incrementar contador de inscritos para este curso
                $cursosAsignadosAEsteAlumno++;                             // Incrementar contador para este alumno
                $inscripcionesCreadasContador++;                           // Incrementar contador global

            } // Fin loop interno (cursos)
        } // Fin loop externo (alumnos)

        // 7. Realizar la inserción masiva si hay inscripciones para crear
        if (!empty($inscripcionesACrear)) {
            $this->command->info("-> Preparando inserción de [$inscripcionesCreadasContador] nuevas inscripciones...");
            // Usar insert() para alto rendimiento en inserciones masivas
            AlumnoCurso::insert($inscripcionesACrear);
            $this->command->info("-> ¡Inserción completada!");
        } else {
            $this->command->info("-> No se crearon nuevas inscripciones (posiblemente ya existían o cursos llenos).");
        }

        $this->command->info("----------------------------------------");
        $this->command->info("Seeder AlumnoCursoSeeder finalizado.");
        $this->command->info("----------------------------------------");
    }
}