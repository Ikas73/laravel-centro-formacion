<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AcademicYear extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'start_date',
        'end_date',
        'is_active',
    ];

    public function gradingPeriods()
    {
        return $this->hasMany(GradingPeriod::class);
    }

    /**
     * The "booted" method of the model.
     *
     * @return void
     */
    protected static function boot(): void
    {
        parent::boot();

        // Se dispara cada vez que un modelo AcademicYear está a punto de ser creado o actualizado.
        static::saving(function ($academicYear) {
            // Verificamos si el campo 'is_active' se está estableciendo a 'true'
            // y si realmente ha cambiado (isDirty) para evitar ejecuciones innecesarias.
            if ($academicYear->is_active && $academicYear->isDirty('is_active')) {
                // Si se cumple la condición, ejecutamos una actualización masiva para poner
                // todos los OTROS años académicos a 'is_active = false'.
                // Esto se hace en una única y eficiente consulta a la base de datos.
                self::where('id', '!=', $academicYear->id)->update(['is_active' => false]);
            }
        });
    }
}