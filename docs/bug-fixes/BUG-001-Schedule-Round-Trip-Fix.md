# BUG-001: Solución del Bug de "Ida y Vuelta" en Eventos Recurrentes

**Fecha:** 4 de Agosto de 2025  
**Módulo Afectado:** Schedule  
**Severidad:** Alta  
**Estado:** Resuelto  

## 1. Descripción del Problema

### 1.1 Síntomas
- Un usuario puede mover una ocurrencia individual de un evento recurrente a un nuevo horario sin problemas
- Al intentar mover esa misma ocurrencia de vuelta a su horario original, el sistema arroja un error de validación:
  ```
  Conflicto de horario: El profesor y el aula ya están ocupados en este intervalo de tiempo.
  ```

### 1.2 Impacto
- Los usuarios no pueden revertir cambios en eventos recurrentes
- Genera inconsistencias en la gestión de horarios
- Afecta la usabilidad del sistema de calendario

## 2. Análisis Técnico

### 2.1 Estructura de Datos

La tabla `schedules` utiliza un sistema de herencia para manejar eventos recurrentes:

```sql
-- Campos relevantes
parent_id      -- Referencia al evento recurrente padre
is_recurring   -- Boolean: true para reglas, false para excepciones
is_cancelled   -- Boolean: true para cancelaciones
original_date  -- Fecha específica de la excepción/cancelación
```

### 2.2 Flujo del Bug

1. **Estado Inicial:** Evento recurrente (ID: 2) los miércoles de 9:00 a 11:00
2. **Primera Modificación:** Se mueve una ocurrencia del 2025-07-02 a otro horario
   - Se crea una cancelación (ID: 4, is_cancelled: true) para el 2025-07-02
   - Se crea una excepción (ID: 5, is_cancelled: false) con el nuevo horario
3. **Intento de Reversión:** Al mover ID: 5 de vuelta al horario original
   - La validación encuentra la cancelación (ID: 4) que ocupa el horario original
   - Error: La validación no excluye correctamente las cancelaciones

### 2.3 Causa Raíz

La regla de validación `NoScheduleOverlap` no consideraba:
1. Las cancelaciones (`is_cancelled = true`) como eventos inactivos
2. El caso especial de revertir una excepción a su estado original

## 3. Solución Implementada

### 3.1 Modificación en `app/Rules/NoScheduleOverlap.php`

```php
// ANTES
$query = Schedule::query()
    ->where('dia_semana', $weekday)
    ->where('hora_inicio', '<', $endTime)
    ->where('hora_fin', '>', $startTime);

// DESPUÉS
$query = Schedule::query()
    ->where('dia_semana', $weekday)
    ->where('hora_inicio', '<', $endTime)
    ->where('hora_fin', '>', $startTime)
    ->where('is_cancelled', false); // Excluir eventos cancelados
```

**Justificación:** Las cancelaciones son marcadores inactivos que no deben considerarse como conflictos reales.

### 3.2 Modificación en `app/Http/Controllers/Admin/ScheduleController.php`

Se agregó lógica especial en el método `update()` para detectar cuando una excepción vuelve a su horario original:

```php
// Verificar si estamos moviendo la excepción de vuelta a su horario original
if ($parent && 
    $parent->dia_semana == $validated['weekday'] &&
    $parent->hora_inicio == $validated['start_time'] &&
    $parent->hora_fin == $validated['end_time'] &&
    $parent->aula == $validated['room'] &&
    $parent->profesor_id == $validated['profesor_id']) {
    
    // Buscar y eliminar la cancelación correspondiente
    $cancellation = Schedule::where('parent_id', $parent->id)
        ->where('is_cancelled', true)
        ->where('original_date', $schedule->original_date)
        ->first();
        
    if ($cancellation) {
        $cancellation->delete();
    }
    
    // Eliminar la excepción ya que vuelve a su estado original
    $schedule->delete();
    
    return response()->json(['message' => 'El evento ha vuelto a su horario original.']);
}
```

**Justificación:** Cuando una excepción vuelve exactamente a su horario original, el sistema debe:
1. Eliminar la cancelación que marcaba esa fecha como excluida
2. Eliminar la excepción misma, ya que el evento recurrente padre volverá a aplicar en esa fecha

### 3.3 Mejoras Adicionales

1. **Logging Mejorado:** Se añadieron logs detallados para facilitar el debugging:
   ```php
   Log::info('NoScheduleOverlap - Validando movimiento de excepción', [
       'scheduleIdToIgnore' => $this->scheduleIdToIgnore,
       'currentSchedule' => $currentSchedule ? $currentSchedule->toArray() : null,
       // ... más detalles
   ]);
   ```

2. **Relación Parent en el Modelo:** Se agregó la relación `parent()` en `app/Models/Schedule.php`:
   ```php
   public function parent()
   {
       return $this->belongsTo(Schedule::class, 'parent_id');
   }
   ```

## 4. Casos de Prueba

### 4.1 Caso de Prueba Principal
1. Crear evento recurrente los miércoles de 9:00 a 11:00
2. Mover ocurrencia del 2/7 al jueves de 10:00 a 12:00
3. Mover la misma ocurrencia de vuelta al miércoles de 9:00 a 11:00
4. **Resultado esperado:** Operación exitosa, evento vuelve a su estado original

### 4.2 Casos Edge
- Mover excepción a horario diferente del original
- Mover excepción cuando existen múltiples cancelaciones
- Validar conflictos con otros eventos no relacionados

## 5. Prevención Futura

### 5.1 Recomendaciones
1. Implementar tests unitarios para la regla `NoScheduleOverlap`
2. Añadir tests de integración para el flujo completo de excepciones
3. Considerar usar soft deletes para mantener historial de cambios

### 5.2 Código de Test Sugerido
```php
public function test_can_move_exception_back_to_original_schedule()
{
    // Crear evento recurrente
    $recurring = Schedule::factory()->recurring()->create([
        'dia_semana' => 3,
        'hora_inicio' => '09:00',
        'hora_fin' => '11:00'
    ]);
    
    // Mover una ocurrencia
    $response = $this->putJson("/admin/schedules/{$recurring->id}", [
        'edit_type' => 'solo_este',
        'original_date' => '2025-07-02',
        'new_date' => '2025-07-03',
        'weekday' => 4,
        'start_time' => '10:00',
        'end_time' => '12:00',
        // ... otros campos
    ]);
    
    $exception = Schedule::where('parent_id', $recurring->id)
        ->where('is_cancelled', false)
        ->first();
    
    // Mover de vuelta al horario original
    $response = $this->putJson("/admin/schedules/{$exception->id}", [
        'edit_type' => 'solo_este',
        'original_date' => '2025-07-03',
        'new_date' => '2025-07-02',
        'weekday' => 3,
        'start_time' => '09:00',
        'end_time' => '11:00',
        // ... otros campos
    ]);
    
    $response->assertOk();
    $this->assertDatabaseMissing('schedules', [
        'id' => $exception->id
    ]);
}
```

## 6. Conclusión

La solución implementada resuelve el bug de "ida y vuelta" mediante:
1. Exclusión correcta de eventos cancelados en la validación
2. Detección y manejo especial del caso de reversión al horario original
3. Limpieza automática de registros temporales (cancelaciones y excepciones)

Esta solución mantiene la integridad de los datos mientras proporciona una experiencia de usuario fluida y predecible.

---
**Documentado por:** Assistant  
**Revisado por:** [Pendiente]  
**Última actualización:** 4 de Agosto de 2025
