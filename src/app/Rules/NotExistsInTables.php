<?php

namespace App\Rules;

use Illuminate\Contracts\Validation\InvokableRule; // Para la nueva sintaxis de __invoke
use Illuminate\Support\Facades\DB; // Para interactuar con la base de datos

class NotExistsInTables implements InvokableRule
{
    protected $checks;
    protected $messageFormat;

    /**
     * Create a new rule instance.
     *
     * @param  array  $checks  Array de verificaciones.
     *                         Cada elemento es un array: ['table' => 'nombre_tabla', 'column' => 'nombre_columna', 'label' => 'tipo de entidad']
     *                         Ejemplo: [['table' => 'alumnos', 'column' => 'dni', 'label' => 'alumno'], ['table' => 'profesores', 'column' => 'dni', 'label' => 'profesor']]
     * @param  string $messageFormat (Opcional) Formato del mensaje de error, ej: "El :attribute ya existe como :entity."
     * @return void
     */
    public function __construct(array $checks, string $messageFormat = 'El :attribute ingresado ya existe como :entity registrado.')
    {
        $this->checks = $checks;
        $this->messageFormat = $messageFormat;
    }

    /**
     * Run the validation rule.
     *
     * @param  string  $attribute El nombre del campo que se está validando (ej: 'dni', 'email')
     * @param  mixed  $value El valor del campo que se está validando
     * @param  \Closure(string): \Illuminate\Translation\PotentiallyTranslatedString  $fail La función de callback para marcar el fallo
     * @return void
     */
    public function __invoke($attribute, $value, $fail)
    {
        // Solo realizar la verificación si el valor no está vacío.
        // Esto hace que la regla sea compatible con 'nullable' si se desea.
        if (!empty($value)) {
            foreach ($this->checks as $check) {
                // Validar que la configuración del check es correcta
                if (!isset($check['table']) || !isset($check['column']) || !isset($check['label'])) {
                    // Podrías lanzar una excepción aquí o loguear un error de configuración de la regla
                    continue; // Saltar este check si está mal configurado
                }

                $exists = DB::table($check['table'])
                            ->where($check['column'], $value)
                            // Si las tablas usan SoftDeletes y quieres ignorar los borrados lógicamente:
                            // ->whereNull('deleted_at') // Descomenta si aplica
                            ->exists();

                if ($exists) {
                    // Personalizar el mensaje de error usando el label proporcionado
                    $fail(str_replace([':attribute', ':entity'], [$attribute, $check['label']], $this->messageFormat));
                    return; // Detener la validación en la primera coincidencia encontrada
                }
            }
        }
    }
}