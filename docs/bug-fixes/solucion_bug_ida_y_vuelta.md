# Solución al Bug de "Ida y Vuelta" en el Módulo Schedule

## Descripción del Problema

El bug consiste en un error de validación que ocurre al gestionar excepciones en eventos recurrentes. Un usuario puede mover una única ocurrencia de un evento recurrente a otro horario, pero intentar moverla de vuelta a su horario original genera un error de validación debido a un conflicto inexistente.

## Análisis del Problema

- **Regla de Validación:** `NoScheduleOverlap` es responsable de asegurar que no haya solapamiento de horarios para profesores y aulas.
- **Lógica de Exclusión:** Fallaba al intentar mover una excepción de vuelta a su horario original, al no excluir correctamente el evento padre de la validación.
- **Evidencia:** Se detectó que al mover una excepción de ida y vuelta, el sistema no ignoraba adecuadamente las cancelaciones creadas.

## Soluciones Implementadas

1. **Exclusión de Cancelaciones:**
   - En la regla `NoScheduleOverlap.php`, se ajustó la lógica para ignorar eventos cancelados en la búsqueda de conflictos con `->where('is_cancelled', false)`.

2. **Gestión de Movimiento a Horario Original:**
   - En `ScheduleController.php`, se añadió una verificación para cuando una excepción se mueve de vuelta a su horario original.
   - **Acciones al detectar movimiento a horario original:**
     - Se elimina la cancelación correspondiente para restaurar el estado original.
     - Se elimina la excepción ya que vuelve a su horario original, logrando un manejo eficiente y correcto del evento.

## Resultado

Estas correcciones aseguran que el sistema maneje correctamente el retorno de excepciones a su horario original sin generar conflictos innecesarios.

---
Este documento es parte de la documentación técnica del proyecto para registro de soluciones de errores.
