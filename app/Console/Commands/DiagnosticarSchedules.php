<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Schedule;
use App\Models\Curso;

class DiagnosticarSchedules extends Command
{
    protected $signature = 'schedules:diagnosticar {--limpiar : Limpiar schedules huérfanos}';
    protected $description = 'Diagnostica problemas con schedules y opcionalmente los limpia';

    public function handle()
    {
        $this->info('🔍 Iniciando diagnóstico de schedules...');
        
        // Buscar schedules huérfanos (sin curso asociado)
        $schedulesHuerfanos = Schedule::whereDoesntHave('curso')->get();
        
        if ($schedulesHuerfanos->count() > 0) {
            $this->warn("⚠️  Encontrados {$schedulesHuerfanos->count()} schedules huérfanos (sin curso asociado):");
            
            foreach ($schedulesHuerfanos as $schedule) {
                $this->line("  - Schedule ID: {$schedule->id}, Curso ID: {$schedule->curso_id}, Aula: {$schedule->aula}");
            }
            
            if ($this->option('limpiar')) {
                $this->warn('🧹 Eliminando schedules huérfanos...');
                $deletedCount = Schedule::whereDoesntHave('curso')->delete();
                $this->info("✅ Eliminados {$deletedCount} schedules huérfanos.");
            }
        } else {
            $this->info('✅ No se encontraron schedules huérfanos.');
        }
        
        // Buscar conflictos de aulas por aula específica
        $aulasProblematicas = [
            'Centro Principal - Aula 1',
            'Centro Sur - Taller 3', 
            'Plataforma Online Moodle'
        ];
        
        $aulaFuncional = 'Centro Norte - Aula Magna';
        
        $this->info('🏫 Analizando conflictos por aula...');
        
        foreach ($aulasProblematicas as $aula) {
            $schedules = Schedule::where('aula', $aula)->get();
            $cursos = Curso::where('centros', $aula)->get();
            
            $this->line("  📍 {$aula}:");
            $this->line("    - Schedules en base de datos: {$schedules->count()}");
            $this->line("    - Cursos con esta aula: {$cursos->count()}");
            
            // Detectar conflictos
            $conflictos = $this->detectarConflictos($schedules);
            if ($conflictos > 0) {
                $this->error("    ❌ Conflictos detectados: {$conflictos}");
            } else {
                $this->info("    ✅ Sin conflictos");
            }
        }
        
        // Analizar el aula funcional
        $schedulesFunc = Schedule::where('aula', $aulaFuncional)->get();
        $cursosFunc = Curso::where('centros', $aulaFuncional)->get();
        
        $this->line("  📍 {$aulaFuncional} (funcional):");
        $this->line("    - Schedules en base de datos: {$schedulesFunc->count()}");
        $this->line("    - Cursos con esta aula: {$cursosFunc->count()}");
        
        $conflictosFunc = $this->detectarConflictos($schedulesFunc);
        if ($conflictosFunc > 0) {
            $this->error("    ❌ Conflictos detectados: {$conflictosFunc}");
        } else {
            $this->info("    ✅ Sin conflictos");
        }
        
        $this->info('🎯 Diagnóstico completado.');
        
        if (!$this->option('limpiar')) {
            $this->comment('💡 Para limpiar schedules huérfanos, ejecuta: php artisan schedules:diagnosticar --limpiar');
        }
    }
    
    private function detectarConflictos($schedules)
    {
        $conflictos = 0;
        
        foreach ($schedules as $i => $schedule1) {
            foreach ($schedules as $j => $schedule2) {
                if ($i >= $j) continue; // Evitar comparar consigo mismo y duplicados
                
                // Verificar si hay solapamiento de tiempo en el mismo día
                if ($schedule1->dia_semana === $schedule2->dia_semana &&
                    $schedule1->hora_inicio < $schedule2->hora_fin &&
                    $schedule1->hora_fin > $schedule2->hora_inicio) {
                    
                    // Conflicto detectado
                    $conflictos++;
                    $this->error("      🔴 Conflicto: Schedule {$schedule1->id} vs {$schedule2->id} en día {$schedule1->dia_semana}");
                }
            }
        }
        
        return $conflictos;
    }
}
