
### **Documento de Diseño y Ejecución: Módulo de Business Intelligence y Automatización (Fase 3)**

**Proyecto:** Sistema de Gestión Educativa
**Módulo:** `Reportes y Notificaciones` (v1.0)
**Destinatario:** Equipo de Desarrollo Backend/Full-Stack
**Autor:** Arquitecto de Software Senior

#### **1. Visión General y Principios Arquitectónicos**

Esta fase marca la transición del sistema desde un registro de datos pasivo a una **plataforma proactiva que genera valor a partir de la información acumulada**. El objetivo es automatizar tareas administrativas repetitivas y proporcionar herramientas de análisis que soporten la toma de decisiones.

**Principios Clave:**

1.  **Rendimiento y Asincronía:** La generación de reportes y el envío de notificaciones son tareas potencialmente lentas. Se ejecutarán en segundo plano utilizando el sistema de **Colas (Queues)** de Laravel para no impactar la experiencia del usuario.
2.  **Modularidad:** Cada reporte y cada notificación se construirá como una clase independiente y reutilizable (Jobs, Notifications, Mailables), garantizando un código limpio y fácil de mantener.
3.  **Testabilidad:** La lógica de negocio de cada reporte y la lógica de disparo de cada notificación deben ser cubiertas por pruebas automatizadas.
4.  **Configurabilidad (Branding):** Todos los documentos generados (PDFs, emails) deben utilizar la información de la institución (logo, nombre) almacenada en la configuración, haciendo uso de nuestro helper `setting()`.

---

### **Hito 3.0: Módulo de Reportes - Generación de Actas en PDF**

**Objetivo:** Permitir a administradores y profesores generar un documento PDF oficial (Acta de Calificaciones) para un curso específico con un solo clic, eliminando la necesidad de crear estos documentos manualmente.

**Justificación Técnica:** Se utilizará la librería `barryvdh/laravel-dompdf`, el estándar de facto en el ecosistema Laravel para la conversión de HTML a PDF. El enfoque consistirá en renderizar una vista Blade estándar con todo el contenido y estilos, y luego pasarla a la librería para su conversión. Esto desacopla completamente el diseño del acta (HTML/CSS) de la lógica de generación de datos (Controlador).

#### **Pasos de Ejecución Detallados (Hito 3.0):**

1.  **Instalación y Configuración de la Librería:**
    *   Ejecutar en la terminal del contenedor `app`:
        ```bash
        docker compose exec app composer require barryvdh/laravel-dompdf
        ```
    *   Laravel registrará automáticamente el Service Provider. No se requiere configuración adicional para un uso básico.

2.  **Creación del Controlador y la Ruta:**
    *   Crear un nuevo controlador para centralizar la lógica de todos los reportes:
        ```bash
        docker compose exec app php artisan make:controller Admin/ReportesController
        ```
    *   En `routes/web.php`, dentro del grupo `admin`, añadir la ruta protegida por un permiso. Necesitaremos crear este permiso primero.

    *   **Acción de Permisos:** En `database/seeders/RolesAndPermissionsSeeder.php`, añade:
        ```php
        Permission::firstOrCreate(['name' => 'generate_reports']);
        // Asigna el permiso al rol de admin y, si aplica, al de profesor
        $adminRole->givePermissionTo('generate_reports');
        $teacherRole->givePermissionTo('generate_reports');
        ```
        Luego, ejecuta `docker compose exec app php artisan db:seed`.

    *   **Definición de la Ruta:**
        ```php
        // En routes/web.php, dentro del grupo admin
        Route::get('/cursos/{curso}/reportes/acta', [ReportesController::class, 'generarActaCurso'])
             ->name('reportes.acta_curso')
             ->middleware('can:generate_reports');
        ```

3.  **Creación de la Vista Blade para el Acta:**
    *   Crea el archivo: `resources/views/admin/reportes/acta_curso.blade.php`.
    *   Pega la siguiente estructura HTML. Es un Blade simple, diseñado para ser renderizado en PDF.

        ```blade
        <!DOCTYPE html>
        <html lang="es">
        <head>
            <meta charset="UTF-g">
            <title>Acta de Calificaciones - {{ $curso->nombre }}</title>
            <style>
                body { font-family: 'Helvetica', sans-serif; font-size: 12px; }
                .header { text-align: center; margin-bottom: 20px; }
                .header h1 { margin: 0; font-size: 18px; }
                .header h2 { margin: 0; font-size: 16px; font-weight: normal; }
                .course-info { margin-bottom: 20px; border: 1px solid #ddd; padding: 10px; border-radius: 5px; }
                table { width: 100%; border-collapse: collapse; }
                th, td { border: 1px solid #ccc; padding: 8px; text-align: left; }
                th { background-color: #f2f2f2; }
                .signatures { margin-top: 50px; }
            </style>
        </head>
        <body>
            <div class="header">
                {{-- Usamos nuestro helper global para el branding --}}
                <h1>{{ setting('institution_name', 'Centro de Formación') }}</h1>
                <h2>Acta Final de Calificaciones</h2>
            </div>

            <div class="course-info">
                <strong>Curso:</strong> {{ $curso->nombre }} ({{ $curso->codigo }})<br>
                <strong>Profesor:</strong> {{ $curso->profesor->nombre_completo ?? 'No asignado' }}<br>
                <strong>Periodo:</strong> {{ $curso->fecha_inicio->format('d/m/Y') }} - {{ $curso->fecha_fin->format('d/m/Y') }}
            </div>

            <table>
                <thead>
                    <tr>
                        <th>Nº</th>
                        <th>Alumno</th>
                        <th>DNI</th>
                        <th>Calificación Final</th>
                        <th>Estado</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($curso->alumnos as $alumno)
                    <tr>
                        <td>{{ $loop->iteration }}</td>
                        <td>{{ $alumno->apellido1 }} {{ $alumno->apellido2 }}, {{ $alumno->nombre }}</td>
                        <td>{{ $alumno->dni }}</td>
                        <td>{{ $alumno->pivot->nota ?? 'N/A' }}</td>
                        <td>{{ $alumno->pivot->estado ?? 'N/A' }}</td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="5" style="text-align: center;">No hay alumnos inscritos en este curso.</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>

            <div class="signatures">
                <p><strong>Firma del Profesor:</strong> _________________________</p>
                <p><strong>Firma del Administrador:</strong> _________________________</p>
            </div>
        </body>
        </html>
        ```

4.  **Implementación de la Lógica en `ReportesController`:**
    *   Abre `app/Http/Controllers/Admin/ReportesController.php`.
    *   Añade el método `generarActaCurso`.

        ```php
        <?php
        namespace App\Http\Controllers\Admin;

        use App\Http\Controllers\Controller;
        use App\Models\Curso;
        use Barryvdh\DomPDF\Facade\Pdf; // <-- Importa la fachada de PDF

        class ReportesController extends Controller
        {
            public function generarActaCurso(Curso $curso)
            {
                // Carga optimizada de relaciones para evitar N+1 queries
                $curso->load('alumnos', 'profesor');

                // Carga la vista Blade y le pasa los datos
                $pdf = Pdf::loadView('admin.reportes.acta_curso', compact('curso'));

                // Descarga el PDF en el navegador del usuario
                return $pdf->download('acta-calificaciones-' . $curso->codigo . '.pdf');
            }
        }
        ```

5.  **Integración en la Interfaz de Usuario:**
    *   Abre `resources/views/admin/cursos/show.blade.php`.
    *   En la sección de "Botones de Acción", añade un nuevo botón para generar el reporte.

        ```html
        {{-- En la sección de botones de admin/cursos/show.blade.php --}}
        <a href="{{ route('admin.reportes.acta_curso', $curso) }}"
           class="px-6 py-2.5 text-sm font-medium text-white bg-teal-600 border border-transparent rounded-lg shadow-sm hover:bg-teal-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-teal-500 transition-colors text-center"
           target="_blank"> {{-- target="_blank" para abrir en una nueva pestaña --}}
            <i class="bi bi-file-earmark-pdf-fill mr-2"></i>Generar Acta
        </a>
        ```

#### **Punto de Verificación (Hito 3.0):**

*   **Pruebas Manuales:**
    1.  Inicia sesión como administrador.
    2.  Navega a la página de detalles de un curso que tenga alumnos y calificaciones.
    3.  Haz clic en el nuevo botón "Generar Acta".
    4.  Verifica que se descargue un archivo PDF.
    5.  Abre el PDF y comprueba que los datos (nombre de la institución, datos del curso, lista de alumnos) son correctos.
*   **Pruebas Automatizadas (Feature Tests):**
    *   Crea un test: `php artisan make:test Reportes/ActaGeneracionTest`
    *   Añade un método de prueba:
        ```php
        <?php
        namespace Tests\Feature\Reportes;

        use Illuminate\Foundation\Testing\RefreshDatabase;
        use Tests\TestCase;
        use App\Models\User;
        use App\Models\Curso;

        class ActaGeneracionTest extends TestCase
        {
            use RefreshDatabase;

            /** @test */
            public function an_authorized_user_can_generate_a_course_acta_pdf()
            {
                // Preparamos el entorno
                $this->seed(); // Ejecuta todos los seeders, incluido el de permisos
                $admin = User::role('System Administrator')->first();
                $curso = Curso::factory()->create();

                // Actuamos
                $response = $this->actingAs($admin)->get(route('admin.reportes.acta_curso', $curso));

                // Verificamos
                $response->assertStatus(200);
                $response->assertHeader('Content-Type', 'application/pdf');
                $response->assertHeader(
                    'Content-Disposition',
                    'attachment; filename="acta-calificaciones-' . $curso->codigo . '.pdf"'
                );
            }
        }
        ```    *   Ejecuta la prueba: `docker compose exec app php artisan test --filter=ActaGeneracionTest`
    *   **¡Hito 3.0 completado y verificado!**