<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Database\Seeders\ScheduleSyncSeeder;

class SyncSchedules extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'schedules:sync {--force : Forzar la sincronización sin confirmación}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Sincroniza los horarios reales de los cursos con la tabla schedules';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $this->info('🔄 Comando de Sincronización de Horarios');
        $this->info('=====================================');
        
        if (!$this->option('force')) {
            $confirmed = $this->confirm(
                '⚠️  Esta operación eliminará TODOS los registros de la tabla schedules y los recreará basándose en los horarios de los cursos. ¿Continuar?'
            );
            
            if (!$confirmed) {
                $this->info('❌ Operación cancelada por el usuario.');
                return;
            }
        }

        $this->info('🚀 Iniciando sincronización...');
        
        try {
            // Ejecutar el seeder de sincronización
            $seeder = new ScheduleSyncSeeder();
            $seeder->setCommand($this);
            $seeder->run();
            
            $this->newLine();
            $this->info('✅ Sincronización completada exitosamente!');
            $this->info('📖 Los horarios del calendario ahora coinciden con los horarios reales de los cursos.');
            
        } catch (\Exception $e) {
            $this->error('❌ Error durante la sincronización:');
            $this->error($e->getMessage());
            return 1;
        }

        return 0;
    }
}
