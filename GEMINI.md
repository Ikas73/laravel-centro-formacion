# Diario de Trabajo - Gemini

## Objetivo Actual
Corregir la visualización de cursos en el calendario de la funcionalidad 'Schedule'. Actualmente, los cursos no se muestran como eventos que abarcan desde su fecha de inicio hasta su fecha de fin.

## Última Acción Realizada
- Se estableció el protocolo de uso de `GEMINI.md` para dar seguimiento al trabajo entre sesiones.

## Siguientes Pasos
1.  Analizar la implementación actual de la característica 'Schedule'.
2.  Identificar el código responsable de generar y mostrar los eventos en el calendario.
3.  Determinar por qué los eventos de los cursos no se extienden durante todo su período (desde `fecha_inicio` a `fecha_fin`).
4.  Proponer y aplicar una solución.

## Archivos Relevantes
- `app/Models/Schedule.php`
- `app/Models/Curso.php`
- `resources/js/schedules.js`
- `routes/web.php` (para encontrar el controlador asociado)