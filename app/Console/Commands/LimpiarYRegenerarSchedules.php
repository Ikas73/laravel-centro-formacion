<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Schedule;
use Illuminate\Support\Facades\Artisan;

class LimpiarYRegenerarSchedules extends Command
{
    protected $signature = 'schedules:limpiar-regenerar {--force : Forzar la limpieza sin confirmación}';
    protected $description = 'Limpia todos los schedules y los regenera sin conflictos';

    public function handle()
    {
        $this->info('🔧 Iniciando limpieza y regeneración de schedules...');
        
        // Mostrar estadísticas actuales
        $totalSchedules = Schedule::count();
        $this->info("📊 Schedules actuales en base de datos: {$totalSchedules}");
        
        // Confirmar acción si no se usa --force
        if (!$this->option('force')) {
            if (!$this->confirm('¿Estás seguro de que quieres eliminar TODOS los schedules y regenerarlos?')) {
                $this->info('❌ Operación cancelada.');
                return;
            }
        }
        
        $this->warn('🧹 Eliminando todos los schedules...');
        Schedule::truncate();
        $this->info('✅ Schedules eliminados.');
        
        $this->info('🔄 Regenerando schedules con el ScheduleSeeder corregido...');
        
        // Ejecutar el seeder corregido
        try {
            Artisan::call('db:seed', [
                '--class' => 'Database\\Seeders\\ScheduleSeeder',
                '--force' => true
            ]);
            
            $this->info('✅ ScheduleSeeder ejecutado exitosamente.');
            
            // Mostrar nuevas estadísticas
            $nuevosSchedules = Schedule::count();
            $this->info("📊 Nuevos schedules creados: {$nuevosSchedules}");
            
            // Ejecutar diagnóstico automático
            $this->info('🔍 Ejecutando diagnóstico automático...');
            Artisan::call('schedules:diagnosticar');
            $this->line(Artisan::output());
            
        } catch (\Exception $e) {
            $this->error('❌ Error al ejecutar el ScheduleSeeder: ' . $e->getMessage());
            return 1;
        }
        
        $this->info('🎯 Proceso completado exitosamente.');
        return 0;
    }
}
