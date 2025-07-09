This file is a merged representation of a subset of the codebase, containing files not matching ignore patterns, combined into a single document by Repomix.
The content has been processed where empty lines have been removed, content has been compressed (code blocks are separated by ⋮---- delimiter), security check has been disabled.

# File Summary

## Purpose
This file contains a packed representation of the entire repository's contents.
It is designed to be easily consumable by AI systems for analysis, code review,
or other automated processes.

## File Format
The content is organized as follows:
1. This summary section
2. Repository information
3. Directory structure
4. Repository files (if enabled)
5. Multiple file entries, each consisting of:
  a. A header with the file path (## File: path/to/file)
  b. The full contents of the file in a code block

## Usage Guidelines
- This file should be treated as read-only. Any changes should be made to the
  original repository files, not this packed version.
- When processing this file, use the file path to distinguish
  between different files in the repository.
- Be aware that this file may contain sensitive information. Handle it with
  the same level of security as you would the original repository.

## Notes
- Some files may have been excluded based on .gitignore rules and Repomix's configuration
- Binary files are not included in this packed representation. Please refer to the Repository Structure section for a complete list of file paths, including binary files
- Files matching these patterns are excluded: **/*.test, *.md
- Files matching patterns in .gitignore are excluded
- Files matching default ignore patterns are excluded
- Empty lines have been removed from all files
- Content has been compressed - code blocks are separated by ⋮---- delimiter
- Security check has been disabled - content may contain sensitive information
- Files are sorted by Git change count (files with more changes are at the bottom)

# Directory Structure
```
app/
  Http/
    Controllers/
      Admin/
        AlumnoController.php
        CursoController.php
        DashboardController.php
        EventoController.php
        PreinscritoSepeController.php
        ProfesorController.php
        ScheduleController.php
      Auth/
        AuthenticatedSessionController.php
        ConfirmablePasswordController.php
        EmailVerificationNotificationController.php
        EmailVerificationPromptController.php
        NewPasswordController.php
        PasswordController.php
        PasswordResetLinkController.php
        RegisteredUserController.php
        VerifyEmailController.php
      Controller.php
      EventoController.php
      ProfileController.php
    Requests/
      Auth/
        LoginRequest.php
      ProfileUpdateRequest.php
      StoreCursoRequest.php
      StoreScheduleRequest.php
      UpdateCursoRequest.php
      UpdateScheduleRequest.php
  Models/
    Alumno.php
    AlumnoCurso.php
    Curso.php
    Evento.php
    PreinscritoSepe.php
    Profesor.php
    Schedule.php
    TimeSlot.php
    User.php
  Providers/
    AppServiceProvider.php
  Rules/
    NoScheduleOverlap.php
    NotExistsInTables.php
    SufficientCourseDuration.php
  View/
    Components/
      AppLayout.php
      GuestLayout.php
bootstrap/
  cache/
    .gitignore
  app.php
  providers.php
config/
  app.php
  auth.php
  cache.php
  database.php
  filesystems.php
  logging.php
  mail.php
  queue.php
  services.php
  session.php
database/
  factories/
    AlumnoCursoFactory.php
    AlumnoFactory.php
    CursoFactory.php
    PreinscritoSepeFactory.php
    ProfesorFactory.php
    UserFactory.php
  migrations/
    0001_01_01_000000_create_users_table.php
    0001_01_01_000001_create_cache_table.php
    0001_01_01_000002_create_jobs_table.php
    2025_04_19_203310_create_profesores_table.php
    2025_04_19_203323_create_alumnos_table.php
    2025_04_19_203334_create_cursos_table.php
    2025_04_19_203344_create_alumno_curso_table.php
    2025_04_19_203353_create_preinscritos_sepe_table.php
    2025_05_17_213845_add_estado_to_alumnos_table.php
    2025_06_03_124951_add_estado_to_preinscritos_sepe_table.php
    2025_06_04_123326_add_num_seguridad_social_to_preinscritos_sepe_table.php
    2025_06_04_170305_add_sexo_to_preinscritos_sepe_table.php
    2025_06_15_193251_create_time_slots_table.php
    2025_06_15_193659_create_schedules_table.php
  seeders/
    AlumnoCursoSeeder.php
    AlumnoSeeder.php
    CursoSeeder.php
    DatabaseSeeder.php
    PreinscritoSepeSeeder.php
    ProfesorSeeder.php
    ScheduleSeeder.php
    TimeSlotSeeder.php
    UserSeeder.php
  .gitignore
public/
  .htaccess
  index.php
  robots.txt
resources/
  css/
    admin.css
    app.css
    dashboard-admin.css
    login.css
  js/
    app.js
    bootstrap.js
    particles-config.js
    schedules.js
  views/
    admin/
      alumnos/
        create.blade.php
        edit.blade.php
        index.blade.php
        show.blade.php
      cursos/
        create.blade.php
        edit.blade.php
        index.blade.php
        show.blade.php
      preinscritos/
        create.blade.php
        edit.blade.php
        index_error_placeholder.blade.php
        index.blade.php
        show.blade.php
      profesores/
        create.blade.php
        edit.blade.php
        index.blade.php
        show.blade.php
      schedules/
        create.blade.php
        edit.blade.php
        index.blade.php
      dashboard.blade.php
    auth/
      confirm-password.blade.php
      forgot-password.blade.php
      login.blade.php
      register.blade.php
      reset-password.blade.php
      verify-email.blade.php
    components/
      application-logo.blade.php
      auth-session-status.blade.php
      convert-modal.blade.php
      danger-button.blade.php
      delete-modal.blade.php
      desinscribir-modal.blade.php
      dropdown-link.blade.php
      dropdown.blade.php
      input-error.blade.php
      input-label.blade.php
      modal.blade.php
      nav-link.blade.php
      primary-button.blade.php
      responsive-nav-link.blade.php
      secondary-button.blade.php
      text-input.blade.php
    layouts/
      admin.blade.php
      app.blade.php
      guest.blade.php
      navigation.blade.php
    profile/
      partials/
        delete-user-form.blade.php
        update-password-form.blade.php
        update-profile-information-form.blade.php
      edit.blade.php
    vendor/
      pagination/
        bootstrap-4.blade.php
        bootstrap-5.blade.php
        default.blade.php
        semantic-ui.blade.php
        simple-bootstrap-4.blade.php
        simple-bootstrap-5.blade.php
        simple-default.blade.php
        simple-tailwind.blade.php
        tailwind.blade.php
    welcome.blade.php
routes/
  auth.php
  console.php
  web.php
storage/
  app/
    private/
      .gitignore
    public/
      .gitignore
    .gitignore
  framework/
    cache/
      data/
        .gitignore
      .gitignore
    sessions/
      .gitignore
    testing/
      .gitignore
    views/
      .gitignore
    .gitignore
tests/
  Feature/
    Auth/
      AuthenticationTest.php
      EmailVerificationTest.php
      PasswordConfirmationTest.php
      PasswordResetTest.php
      PasswordUpdateTest.php
      RegistrationTest.php
    ExampleTest.php
    ProfileTest.php
  Unit/
    ExampleTest.php
  TestCase.php
.editorconfig
.env.example
.gitattributes
.gitignore
artisan
composer.json
docker-compose.yml
Dockerfile
package.json
phpunit.xml
postcss.config.js
start-dev-fixed.sh
tailwind.config.js
task.json
vite.config.js
```

# Files

## File: app/Http/Controllers/Admin/AlumnoController.php
```php
namespace App\Http\Controllers\Admin;
use App\Http\Controllers\Controller;
use App\Models\Alumno;
use App\Models\Profesor;
use App\Models\Curso;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
class AlumnoController extends Controller
⋮----
public function index(Request $request)
⋮----
$searchTerm = $request->input('search');
// --- NUEVO: Obtener valores de filtro de la request ---
$filtroGrado = $request->input('grado');
$filtroEstado = $request->input('estado_filtro'); // Usamos 'estado_filtro' para no colisionar con el campo 'estado' del modelo
$query = Alumno::query();
// Aplicar filtro de búsqueda
⋮----
$query->where(function ($q) use ($lowerSearchTerm) {
$q->where(DB::raw('LOWER(nombre)'), 'LIKE', "%{$lowerSearchTerm}%")
->orWhere(DB::raw('LOWER(apellido1)'), 'LIKE', "%{$lowerSearchTerm}%")
->orWhere(DB::raw('LOWER(apellido2)'), 'LIKE', "%{$lowerSearchTerm}%")
->orWhere(DB::raw('LOWER(dni)'), 'LIKE', "%{$lowerSearchTerm}%")
->orWhere(DB::raw('LOWER(email)'), 'LIKE', "%{$lowerSearchTerm}%");
⋮----
// --- NUEVO: Aplicar filtro por Grado/Nivel Formativo ---
⋮----
$query->where('nivel_formativo', $filtroGrado);
⋮----
// --- NUEVO: Aplicar filtro por Estado ---
// Asegúrate de que tu tabla 'alumnos' tiene una columna 'estado'
// y que los valores coinciden con los de $opcionesEstado
⋮----
$query->where('estado', $filtroEstado);
⋮----
$alumnos = $query->orderBy('apellido1', 'asc')
->orderBy('nombre', 'asc')
->paginate(7)
// ¡IMPORTANTE! appends ahora debe incluir todos los filtros y la búsqueda
->appends($request->query()); // Esto incluye search, grado, y estado_filtro si están presentes
// KPIs
// $totalAlumnosActivos = Alumno::count(); // Lo que tenías como placeholder
$totalAlumnosActivos = Alumno::where('estado', 'Activo')->count(); // Ahora debería funcionar
⋮----
$totalProfesores = Profesor::count();
⋮----
// --- NUEVO: Obtener opciones para los filtros ---
// Obtener todos los niveles formativos distintos y no nulos de la tabla alumnos
$opcionesGrado = Alumno::select('nivel_formativo')
->whereNotNull('nivel_formativo')
->where('nivel_formativo', '!=', '')
->distinct()
->orderBy('nivel_formativo')
->pluck('nivel_formativo');
// Definir opciones de estado (o podrías obtenerlas de la BD si tienes una tabla de estados)
// Asegúrate de que estos valores coincidan con los que usas en tu AlumnoFactory y en el badge de la tabla
⋮----
'opcionesGrado',     // <--- NUEVO: Pasar opciones de grado
'opcionesEstado',    // <--- NUEVO: Pasar opciones de estado
'filtroGrado',       // <--- NUEVO: Pasar filtro de grado seleccionado
'filtroEstado'       // <--- NUEVO: Pasar filtro de estado seleccionado
⋮----
/**
     * Muestra el formulario para editar el recurso especificado.
     */
public function edit(Alumno $alumno) // Route Model Binding inyecta el Alumno
⋮----
// Al igual que en create(), podríamos pasar opciones para <selects> si fuera necesario
// $opcionesEstado = ['Activo', 'Inactivo', 'Pendiente', 'Baja'];
// return view('admin.alumnos.edit', compact('alumno', 'opcionesEstado'));
⋮----
/**
     * Muestra el formulario para crear un nuevo recurso.
     */
public function create()
⋮----
// Por ahora, solo necesitamos mostrar la vista.
// Más adelante, si el formulario necesita 'options' para <select> (ej: lista de estados),
// se pasarían aquí.
// Por ejemplo, si el estado se elige de una lista fija:
⋮----
// return view('admin.alumnos.create', compact('opcionesEstado'));
⋮----
/**
     * Muestra el recurso especificado.
     * Gracias al Route Model Binding, Laravel automáticamente busca y
     * nos inyecta el objeto Alumno correspondiente al ID en la URL.
     */
public function show(Alumno $alumno) // Laravel inyecta el objeto Alumno
⋮----
// Aquí podrías cargar relaciones si las vas a mostrar en la vista de detalle
// Ejemplo: $alumno->load('cursosInscritos'); // Si tienes una relación así
// (Asumiendo que $alumno ya tiene la relación 'cursos' definida)
$alumno->load('cursos'); // Para la relación ManyToMany
⋮----
/**
     * Almacena un nuevo recurso creado en el almacenamiento.
     */
public function store(Request $request)
⋮----
// ------ 1. Validación de Datos ------
// Asegúrate de que los nombres aquí ('nombre', 'apellido1', etc.)
// coinciden EXACTAMENTE con los atributos 'name' de tus campos de formulario
// en create.blade.php.
//dd($request->all()); // Para depurar y ver qué datos se están enviando
$validatedData = $request->validate([
⋮----
'sexo' => 'required|string|in:Hombre,Mujer,Otro', // Validación para el select
⋮----
'num_seguridad_social' => 'required|string|max:20|unique:alumnos,num_seguridad_social', // Asegúrate del nombre del campo
// Campos de la sección "Información de Contacto"
'direccion' => 'required|string', // Nombre del textarea
⋮----
// Campos de la sección "Información Académica y Laboral"
⋮----
// ------ 2. Creación del Alumno ------
// Esto asume que todos los campos en $validatedData están en la propiedad $fillable
// de tu modelo App\Models\Alumno.
Alumno::create($validatedData);
// ------ 3. Redirección con Mensaje de Éxito ------
return redirect()->route('admin.alumnos.index')
->with('success', '¡Alumno añadido correctamente!');
⋮----
/**
     * Actualiza el recurso especificado en el almacenamiento.
     */
public function update(Request $request, Alumno $alumno) // Inyectar Request y el Alumno a actualizar
⋮----
// Similar a store(), pero ajusta las reglas 'unique' para ignorar el registro actual
⋮----
// Para 'unique', debemos ignorar el DNI/email del alumno actual
⋮----
// ... añade todas las demás reglas de validación ...
⋮----
/* Por ejemplo:
            */
⋮----
// ------ 2. Actualización del Alumno ------
$alumno->update($validatedData);
⋮----
return redirect()->route('admin.alumnos.show', $alumno->id) // Redirige a la vista de detalles del alumno
->with('success', '¡Alumno actualizado correctamente!');
⋮----
// En Admin/AlumnoController.php
/**
     * Elimina el recurso especificado del almacenamiento.
     */
public function destroy(Alumno $alumno) // Route Model Binding inyecta el Alumno
⋮----
$nombreCompleto = $alumno->nombre . ' ' . $alumno->apellido1; // Guardar nombre para el mensaje
$alumno->delete(); // Elimina el alumno de la base de datos
// Podrías añadir aquí lógica adicional si necesitas eliminar datos relacionados
// que no se eliminan en cascada (ej: archivos, etc.), aunque las inscripciones
// en alumno_curso deberían tener ON DELETE CASCADE si quieres que se borren también.
⋮----
->with('success', "Alumno '{$nombreCompleto}' eliminado correctamente.");
⋮----
// Manejar errores de base de datos (ej: si hay restricciones de clave foránea que impiden borrar)
// Loguear el error también es una buena práctica: Log::error($e->getMessage());
⋮----
->with('error', 'No se pudo eliminar el alumno. Es posible que tenga datos asociados (ej: cursos inscritos) que impiden su eliminación o hubo un error en la base de datos.');
⋮----
// Manejar otros errores inesperados
// Log::error($e->getMessage());
⋮----
->with('error', 'Ocurrió un error inesperado al intentar eliminar el alumno.');
⋮----
/**
     * Obtiene los cursos en los que un alumno NO está inscrito.
     * Devuelve una respuesta JSON para ser usada por AJAX.
     */
public function getCursosDisponibles(Alumno $alumno)
⋮----
// Obtener los IDs de los cursos en los que el alumno YA está inscrito
$cursosInscritosIds = $alumno->cursos()->pluck('cursos.id');
// Obtener los cursos que NO están en la lista de inscritos y que están "activos"
$cursosDisponibles = Curso::whereNotIn('id', $cursosInscritosIds)
->where(function ($query) { // Condición de curso activo
$query->where('fecha_fin', '>=', now())
->orWhereNull('fecha_fin');
⋮----
->orderBy('nombre')
->get(['id', 'nombre']); // Solo necesitamos el ID y el nombre
return response()->json($cursosDisponibles);
⋮----
/**
     * Inscribe (vincula) un alumno a un curso específico.
     */
public function inscribirCurso(Request $request, Alumno $alumno)
⋮----
$request->validate([
⋮----
'estado' => 'nullable|string|in:Inscrito,Pendiente', // Validar el estado si lo envías
⋮----
$cursoId = $request->input('curso_id');
$estadoInscripcion = $request->input('estado', 'Inscrito'); // Valor por defecto 'Inscrito'
// Verificar si ya está inscrito (doble verificación)
if ($alumno->cursos()->where('curso_id', $cursoId)->exists()) {
return redirect()->route('admin.alumnos.show', $alumno->id)
->with('error', 'El alumno ya está inscrito en este curso.');
⋮----
// Inscribir al alumno usando attach() y pasando los datos de la tabla pivote
$alumno->cursos()->attach($cursoId, [
⋮----
->with('success', '¡Alumno inscrito en el curso correctamente!');
⋮----
/**
     * Desvincula (desinscribe) un alumno de un curso específico.
     *
     * @param  \App\Models\Alumno  $alumno
     * @param  \App\Models\Curso  $curso
     * @return \Illuminate\Http\RedirectResponse
     */
public function desinscribirCurso(Alumno $alumno, Curso $curso)
⋮----
Log::info("Intentando desinscribir Alumno ID {$alumno->id} del Curso ID {$curso->id}.");
⋮----
// Llama a la relación 'cursos' del modelo Alumno y usa el método 'detach'
// para eliminar la fila de la tabla pivote que conecta este alumno con este curso.
$alumno->cursos()->detach($curso->id);
// Redirige de vuelta a la página de detalles del alumno con un mensaje de éxito.
⋮----
->with('success', "Alumno '{$alumno->nombre} {$alumno->apellido1}' desinscrito del curso '{$curso->nombre}' correctamente.");
⋮----
// Captura cualquier error inesperado durante el proceso.
Log::error("Error al desinscribir alumno ID {$alumno->id} del curso ID {$curso->id}: " . $e->getMessage());
⋮----
->with('error', 'Ocurrió un error inesperado al intentar desinscribir al alumno.');
```

## File: app/Http/Controllers/Admin/CursoController.php
```php
namespace App\Http\Controllers\Admin;
use App\Http\Controllers\Controller;
use App\Models\Curso; // Importa el modelo Curso
use App\Models\Profesor;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB; // Si planeas usar DB::raw
use Illuminate\Support\Facades\Log;
use App\Http\Requests\StoreCursoRequest; // <-- IMPORTAR
use App\Http\Requests\UpdateCursoRequest; // <-- IMPORTAR
class CursoController extends Controller
⋮----
/**
     * Display a listing of the resource.
     */
public function index(Request $request)
⋮----
$searchTerm = $request->input('search');
$filtroModalidad = $request->input('modalidad');
$filtroProfesor = $request->input('profesor_id');
$query = Curso::with('profesor')->withCount('alumnos'); // Cargar relación profesor y conteo de alumnos
⋮----
$query->where(function ($q) use ($lowerSearchTerm) {
$q->where(DB::raw('LOWER(nombre)'), 'LIKE', "%{$lowerSearchTerm}%")
->orWhere(DB::raw('LOWER(codigo)'), 'LIKE', "%{$lowerSearchTerm}%");
⋮----
$query->where('modalidad', $filtroModalidad);
⋮----
$query->where('profesor_id', $filtroProfesor);
⋮----
$cursos = $query->orderBy('nombre', 'asc')->paginate(8)->appends($request->query());
$opcionesModalidad = Curso::select('modalidad')->whereNotNull('modalidad')->distinct()->orderBy('modalidad')->pluck('modalidad');
$opcionesProfesores = Profesor::orderBy('apellido1')->orderBy('nombre')->get(['id', 'nombre', 'apellido1']); // Para el select
⋮----
// Aquí deberían estar los otros métodos generados por --resource
// public function create() { /* ... */ }
/**
 * Muestra el formulario para crear un nuevo Curso.
 */
public function create()
⋮----
// Obtener todos los profesores para el dropdown de asignación
// Ordenarlos para que el select sea más fácil de usar
$profesores = Profesor::orderBy('apellido1')->orderBy('nombre')->get(['id', 'nombre', 'apellido1']);
// Podrías pasar otras opciones si las tienes (ej: modalidades fijas, niveles fijos)
// $opcionesModalidad = ['Online', 'Presencial', 'Semipresencial (Blended)'];
// $opcionesNivel = ['Básico', 'Intermedio', 'Avanzado'];
⋮----
// 'opcionesModalidad',
// 'opcionesNivel'
⋮----
// public function store(Request $request) { /* ... */ }
public function store(StoreCursoRequest $request)
⋮----
// ¡YA NO NECESITAS $request->validate()!
// Laravel lo hace automáticamente antes de ejecutar este código.
// Simplemente crea el curso usando los datos ya validados.
Curso::create($request->validated());
return redirect()->route('admin.cursos.index')
->with('success', 'Curso creado con éxito.');
⋮----
// public function show(Curso $curso) { /* ... */ }
/**
     * Muestra el recurso Curso especificado.
     */
public function show(Curso $curso) // Route Model Binding
⋮----
// Cargar las relaciones necesarias para mostrar en la vista de detalles
$curso->load(['profesor', 'alumnos']);
// 'profesor': para mostrar quién imparte el curso.
// 'alumnos': para listar los alumnos inscritos (usando la relación belongsToMany).
⋮----
// public function edit(Curso $curso) { /* ... */ }
/**
     * Muestra el formulario para editar el Curso especificado.
     */
public function edit(Curso $curso) // Route Model Binding para $curso
⋮----
// Obtener todos los profesores para el dropdown
⋮----
// Opcional: Si Modalidad y Nivel son selects con opciones fijas
⋮----
public function update(UpdateCursoRequest $request, Curso $curso) // <-- CAMBIAR AQUÍ
⋮----
// ¡TAMPOCO NECESITAS $request->validate() AQUÍ!
$curso->update($request->validated());
⋮----
->with('success', 'Curso actualizado con éxito.');
⋮----
// public function destroy(Curso $curso) { /* ... */ }
/**
         * Elimina el recurso Curso especificado del almacenamiento.
         */
public function destroy(Curso $curso) // Route Model Binding
⋮----
// Verificar si el curso tiene alumnos inscritos
// Usamos la relación 'alumnos' que definimos en el modelo Curso
// o la relación 'inscripciones' si prefieres contar directamente en la tabla pivote.
if ($curso->alumnos()->count() > 0) { // O $curso->inscripciones()->count() > 0
⋮----
->with('error', "No se puede eliminar el curso '{$curso->nombre}' porque tiene alumnos inscritos. Desinscribe primero a los alumnos o considera archivar el curso.");
⋮----
// Si el curso no tiene alumnos, se puede proceder a eliminar
⋮----
$curso->delete();
⋮----
->with('success', "Curso '{$nombreCurso}' eliminado correctamente.");
⋮----
// Manejar otros errores de base de datos
Log::error("Error al eliminar curso (QueryException) ID {$curso->id}: " . $e->getMessage());
⋮----
->with('error', 'No se pudo eliminar el curso debido a un error en la base de datos o restricciones de integridad. Es posible que aún tenga datos asociados.');
⋮----
Log::error("Error inesperado al eliminar curso ID {$curso->id}: " . $e->getMessage());
⋮----
->with('error', 'Ocurrió un error inesperado al intentar eliminar el curso.');
```

## File: app/Http/Controllers/Admin/DashboardController.php
```php
namespace App\Http\Controllers\Admin;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
// Importar los modelos necesarios
use App\Models\Alumno;
use App\Models\Profesor;
use App\Models\Curso;
use App\Models\PreinscritoSepe;
use App\Models\User;
use Illuminate\Support\Facades\Auth; // Para el usuario logueado
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
class DashboardController extends Controller
⋮----
public function index()
⋮----
// --- Obtener Datos para Tarjetas de Resumen (KPIs) ---
$totalStudents = Alumno::count();
$availableTeachers = Profesor::count();
// CÁLCULOS DE CURSOS
$totalCourses = Curso::count();
$inactiveCourses = Curso::where('fecha_fin', '<', now())->count(); // Cursos cuya fecha_fin ya pasó
// CÁLCULO DE PREINSCRITOS
$pendingPreEnrollments = PreinscritoSepe::where('estado', 'Pendiente')->count(); // Asegúrate que tu seeder crea algunos con este estado
// --- Obtener Datos para Gráficos ---
// En DashboardController.php
// --- NUEVO: 1. Enrollment Trends (Datos Dinámicos) ---
// 1.1. Generar el rango de los últimos 6 meses de forma robusta
⋮----
for ($i = 5; $i >= 0; $i--) { // Iterar desde hace 5 meses hasta el mes actual
$date = Carbon::now()->subMonths($i);
$enrollmentTrends->put($date->format('Y-m'), 0); // La clave es 'YYYY-MM', el valor inicial es 0
⋮----
// Con este bucle, no se necesita sortKeys() porque se insertan en orden cronológico
// 1.2. Realizar la consulta a la BD (se mantiene igual)
$newStudentsData = Alumno::select(
DB::raw("TO_CHAR(created_at, 'YYYY-MM') as month"),
DB::raw('count(*) as total')
⋮----
// La fecha de inicio del filtro debe coincidir con el primer mes que generamos
->where('created_at', '>=', Carbon::now()->subMonths(5)->startOfMonth())
->groupBy('month')
->orderBy('month', 'asc')
->pluck('total', 'month');
// 1.3. Combinar los datos (se mantiene igual)
// Esto llenará los valores para los meses que sí tuvieron actividad
$enrollmentTrends = $enrollmentTrends->merge($newStudentsData);
// 1.4. Preparar los datos finales para la vista (se mantiene igual)
$enrollmentLabels = $enrollmentTrends->keys()->map(function ($monthString) {
return Carbon::createFromFormat('Y-m', $monthString)->translatedFormat('F');
})->values()->toArray();
$enrollmentData = $enrollmentTrends->values()->toArray();
// --- FIN NUEVO CÓDIGO ---
// 2. Pre-enrollment Status (Doughnut)
// Usa los mismos nombres de estado que en tu seeder y tabla
⋮----
'pending' => PreinscritoSepe::where('estado', 'Pendiente')->count(),
'approved' => PreinscritoSepe::where('estado', 'Convertido')->count(), // 'Approved' en el gráfico es 'Convertido' en los datos
'rejected' => PreinscritoSepe::where('estado', 'Rechazado')->count(),
⋮----
// 3. Students per Course (Barras)
$topCourses = Curso::withCount('alumnos')
->orderBy('alumnos_count', 'desc')
->take(9) // Tomar los 9 cursos con más alumnos para que coincida con tu gráfico de ejemplo
->get();
$studentsPerCourseLabels = $topCourses->pluck('nombre');
$studentsPerCourseData = $topCourses->pluck('alumnos_count');
// --- Obtener Datos para la Tabla de Aplicaciones Recientes ---
$recentPreEnrollments = PreinscritoSepe::latest('created_at')->take(5)->get();
// Pasar todas las variables a la vista
⋮----
// KPIs
⋮----
// Gráficos
⋮----
// Tabla
```

## File: app/Http/Controllers/Admin/EventoController.php
```php
namespace App\Http\Controllers\Admin;
use App\Http\Controllers\Controller;
use App\Models\Models\Evento;
use Illuminate\Http\Request;
class EventoController extends Controller
⋮----
/**
     * Display a listing of the resource.
     */
public function index()
⋮----
// Placeholder temporal
⋮----
/**
     * Show the form for creating a new resource.
     */
public function create()
⋮----
//
⋮----
/**
     * Store a newly created resource in storage.
     */
public function store(Request $request)
⋮----
/**
     * Display the specified resource.
     */
public function show(Evento $evento)
⋮----
/**
     * Show the form for editing the specified resource.
     */
public function edit(Evento $evento)
⋮----
/**
     * Update the specified resource in storage.
     */
public function update(Request $request, Evento $evento)
⋮----
/**
     * Remove the specified resource from storage.
     */
public function destroy(Evento $evento)
```

## File: app/Http/Controllers/Admin/PreinscritoSepeController.php
```php
namespace App\Http\Controllers\Admin;
use App\Http\Controllers\Controller;
use App\Models\PreinscritoSepe;
use App\Models\Alumno;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Carbon\Carbon;
use Illuminate\Validation\Rule;
use App\Rules\NotExistsInTables;
class PreinscritoSepeController extends Controller
⋮----
public function index(Request $request)
⋮----
$searchTerm = $request->input('search');
$filtroEstadoPre = $request->input('estado_pre');
$query = PreinscritoSepe::query();
⋮----
$query->where(function ($q) use ($lowerSearchTerm) {
$q->where(DB::raw('LOWER(nombre)'), 'LIKE', "%{$lowerSearchTerm}%")
->orWhere(DB::raw('LOWER(apellido1)'), 'LIKE', "%{$lowerSearchTerm}%")
->orWhere(DB::raw('LOWER(dni)'), 'LIKE', "%{$lowerSearchTerm}%")
->orWhere(DB::raw('LOWER(email)'), 'LIKE', "%{$lowerSearchTerm}%");
⋮----
$query->where('estado', $filtroEstadoPre);
⋮----
$preinscritos = $query->orderBy('fecha_importacion', 'desc')
->orderBy('created_at', 'desc')
->paginate(7)
->appends($request->query());
$totalPreinscritos = PreinscritoSepe::count();
$preinscritosPendientes = PreinscritoSepe::where('estado', 'Pendiente')->count();
$importadosHoy = PreinscritoSepe::whereRaw('DATE(COALESCE(fecha_importacion, created_at)) = ?', [Carbon::today()->toDateString()])->count();
$preinscritosConvertidos = PreinscritoSepe::where('estado', 'Convertido')->count();
$opcionesEstadoPre = PreinscritoSepe::select('estado')
->whereNotNull('estado')
->where('estado', '!=', '')
->distinct()
->orderBy('estado')
->pluck('estado');
⋮----
/**
     * Muestra el formulario para crear un nuevo Preinscrito.
     */
public function create()
⋮----
Log::info("Accediendo a PreinscritoSepeController@create");
// Opciones para los <select> del formulario
⋮----
public function store(Request $request)
⋮----
Log::info("Datos recibidos para crear Preinscrito:", $request->all());
⋮----
$validatedData = $request->validate([
⋮----
'unique:preinscritos_sepe,dni', // Regla 'unique' simple para 'store'
⋮----
'sexo' => ['nullable', 'string', Rule::in($opcionesValidasSexo)],
⋮----
'nivel_formativo' => ['nullable', 'string', Rule::in($opcionesValidasNivelFormativo)],
'situacion_laboral' => ['nullable', 'string', Rule::in($opcionesValidasSituacionLaboral)],
'estado' => ['required', 'string', Rule::in($opcionesValidasEstadoPreinscrito)],
⋮----
$validatedData['fecha_importacion'] = Carbon::parse($validatedData['fecha_importacion'])->format('Y-m-d H:i:s');
⋮----
PreinscritoSepe::create($validatedData);
return redirect()->route('admin.preinscritos.index')->with('success', 'Preinscrito añadido correctamente.');
⋮----
Log::error("Error al crear PreinscritoSepe: " . $e->getMessage(), ['exception' => $e]);
return redirect()->back()->withInput()->with('error', 'Hubo un error al guardar el preinscrito.');
⋮----
/**
     * Muestra el recurso PreinscritoSepe especificado.
     */
public function show(PreinscritoSepe $preinscrito) // Route Model Binding
⋮----
Log::info("Mostrando detalles para Preinscrito ID: " . $preinscrito->id);
// No hay relaciones complejas que cargar para un preinscrito por ahora,
// a menos que lo hayas asociado a un curso de interés, etc.
⋮----
/**
     * Muestra el formulario para editar el Preinscrito especificado.
     */
public function edit(PreinscritoSepe $preinscrito) // Route Model Binding
⋮----
Log::info("Accediendo a PreinscritoSepeController@edit para preinscrito ID " . $preinscrito->id);
// Pasa las opciones necesarias para los <select> en tu edit.blade.php
⋮----
/**
     * Actualiza el Preinscrito especificado en el almacenamiento.
     */
public function update(Request $request, PreinscritoSepe $preinscrito)
⋮----
Log::info("Recibiendo datos para PreinscritoSepe@update para ID " . $preinscrito->id, $request->all());
⋮----
Rule::unique('preinscritos_sepe', 'dni')->ignore($preinscrito->id), // Correcto para update
⋮----
Rule::unique('preinscritos_sepe', 'email')->ignore($preinscrito->id), // Correcto para update
⋮----
Rule::unique('preinscritos_sepe', 'num_seguridad_social')->ignore($preinscrito->id), // Correcto para update
⋮----
if ($request->filled('fecha_importacion')) {
$validatedData['fecha_importacion'] = Carbon::parse($request->input('fecha_importacion'))->format('Y-m-d H:i:s');
⋮----
if ($request->has('fecha_importacion') && !$request->filled('fecha_importacion')) {
⋮----
$preinscrito->update($validatedData);
return redirect()->route('admin.preinscritos.show', $preinscrito->id)
->with('success', 'Preinscrito actualizado correctamente.');
⋮----
Log::error("Error al actualizar PreinscritoSepe ID " . $preinscrito->id . ": " . $e->getMessage(), ['exception' => $e]);
return redirect()->back()->withInput()->with('error', 'Hubo un error al actualizar el preinscrito.');
⋮----
/**
     * Elimina el Preinscrito especificado del almacenamiento.
     */
public function destroy(PreinscritoSepe $preinscrito) // Route Model Binding
⋮----
Log::info("Intentando eliminar Preinscrito ID: {$preinscrito->id}");
⋮----
$preinscrito->delete();
Log::info("Preinscrito ID {$preinscrito->id} ('{$nombreCompleto}') eliminado.");
return redirect()->route('admin.preinscritos.index')->with('success', "Preinscrito '{$nombreCompleto}' eliminado correctamente.");
⋮----
Log::error("Error al eliminar Preinscrito ID {$preinscrito->id}: " . $e->getMessage());
return redirect()->route('admin.preinscritos.index')->with('error', 'No se pudo eliminar el preinscrito.');
⋮----
/**
     * Convierte un PreinscritoSepe a Alumno.
     */
public function convertirAAlumno(PreinscritoSepe $preinscrito)
⋮----
Log::info("Intentando convertir Preinscrito ID {$preinscrito->id} a Alumno.");
/* -----------------------------------------------------------------
         | 1) Cortocircuito si YA está convertido
         *-----------------------------------------------------------------*/
⋮----
return back()->with('error', 'Este preinscrito ya fue convertido.');
⋮----
/* -----------------------------------------------------------------
         | 2) Comprobar si existe otro alumno con mismo DNI o e-mail
         *-----------------------------------------------------------------*/
$alumnoExistente = Alumno::where('dni', $preinscrito->dni)
->orWhere(function ($q) use ($preinscrito) {
⋮----
$q->where('email', $preinscrito->email);
⋮----
->first();
⋮----
Log::warning("Conversión abortada: duplicado DNI/Email (Alumno ID {$alumnoExistente->id}).");
return back()->with('error',
⋮----
/* -----------------------------------------------------------------
         | 3) Preparar datos para el nuevo alumno
         *-----------------------------------------------------------------*/
⋮----
'estado'              => 'Activo',   // estado inicial en la tabla alumnos
⋮----
/* -----------------------------------------------------------------
         | 4) Ejecución atómica
         *-----------------------------------------------------------------*/
DB::beginTransaction();
⋮----
// 4a. Crear alumno
$alumno = Alumno::create($datosNuevoAlumno);
// 4b. Marcar preinscrito
$preinscrito->update([
⋮----
DB::commit();
Log::info("Preinscrito ID {$preinscrito->id} -> Alumno ID {$alumno->id} OK.");
⋮----
->route('admin.alumnos.show', $alumno->id)
->with('success',
⋮----
DB::rollBack();
Log::error("Error al convertir Preinscrito ID {$preinscrito->id}: {$e->getMessage()}",
```

## File: app/Http/Controllers/Admin/ProfesorController.php
```php
namespace App\Http\Controllers\Admin;
use App\Http\Controllers\Controller;
use App\Models\Profesor;
use App\Models\Curso; // Necesario para el KPI de cursos por profesor
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB; // Para búsqueda insensible
use Illuminate\Support\Facades\Log;
class ProfesorController extends Controller
⋮----
public function index(Request $request)
⋮----
$searchTerm = $request->input('search');
$filtroEspecialidad = $request->input('especialidad'); // Para el nuevo filtro
$query = Profesor::query();
// Aplicar filtro de búsqueda por nombre, DNI, email, etc.
⋮----
$query->where(function ($q) use ($lowerSearchTerm) {
$q->where(DB::raw('LOWER(nombre)'), 'LIKE', "%{$lowerSearchTerm}%")
->orWhere(DB::raw('LOWER(apellido1)'), 'LIKE', "%{$lowerSearchTerm}%")
->orWhere(DB::raw('LOWER(apellido2)'), 'LIKE', "%{$lowerSearchTerm}%")
->orWhere(DB::raw('LOWER(dni)'), 'LIKE', "%{$lowerSearchTerm}%")
->orWhere(DB::raw('LOWER(email)'), 'LIKE', "%{$lowerSearchTerm}%");
// Podrías añadir búsqueda por especialidad aquí también si quieres que el campo de texto busque en especialidades
// ->orWhere(DB::raw('LOWER(especialidad)'), 'LIKE', "%{$lowerSearchTerm}%");
⋮----
// NUEVO: Aplicar filtro por Especialidad
⋮----
$query->where('especialidad', $filtroEspecialidad);
⋮----
$profesores = $query->withCount('cursos') // NUEVO: Contar cursos para mostrar en la tabla
->orderBy('apellido1', 'asc')
->orderBy('nombre', 'asc')
->paginate(7) // Ajusta a 7 para que quepa como en la imagen
->appends($request->query()); // Mantener todos los parámetros de la URL en la paginación
$totalProfesores = Profesor::count();
// NUEVO: Obtener opciones para el filtro de especialidad
$opcionesEspecialidad = Profesor::select('especialidad')
->whereNotNull('especialidad')
->where('especialidad', '!=', '')
->distinct()
->orderBy('especialidad')
->pluck('especialidad');
⋮----
$totalEspecialidades = $opcionesEspecialidad->count();
// KPIs (Ejemplos basados en la imagen)
// Media Cursos/Profesor: Necesitaríamos el total de cursos asignados
// Esto es un cálculo más complejo, por ahora un placeholder o un cálculo simple.
// $totalCursosAsignados = Curso::whereNotNull('profesor_id')->count();
// $mediaCursosPorProfesor = ($totalProfesores > 0) ? round($totalCursosAsignados / $totalProfesores, 1) : 0;
// Por simplicidad, usaremos un placeholder hasta tener una mejor lógica para "cursos asignados a ESTOS profesores"
// Cálculo más preciso para media de cursos
$profesoresConCursos = Profesor::withCount('cursos')->get();
$totalCursosAsignados = $profesoresConCursos->sum('cursos_count');
⋮----
'opcionesEspecialidad',   // Pasar opciones de filtro
'filtroEspecialidad',     // Pasar filtro seleccionado
'totalProfesores',        // KPI
'mediaCursosPorProfesor', // KPI
'totalEspecialidades',    // KPI
'activosEsteMes'          // KPI
⋮----
// ... Asegúrate que los otros métodos CRUD (create, store, show, edit, update, destroy)
//     están presentes, aunque sea con un return "" o return view("...") vacío por ahora,
//     para que las rutas resource no den error si se intenta acceder a ellas.
//     Ya los implementaste antes, así que deberían estar bien.
public function create()
⋮----
// Podrías pasar listas de opciones para <selects> si las tienes (ej: tipos de titulación, especialidades fijas)
⋮----
//return view('admin.profesores.create');
⋮----
/**
 * Almacena un nuevo recurso Profesor creado en el almacenamiento.
 */
public function store(Request $request)
⋮----
$validatedData = $request->validate([
⋮----
Profesor::create($validatedData);
return redirect()->route('admin.profesores.index')
->with('success', '¡Profesor añadido correctamente!');
⋮----
// Debes hacer un cambio similar en el método update(), recordando añadir la
// excepción del ID actual si el campo es 'unique', aunque para 'titulacion_academica'
// o 'especialidad' no suelen ser únicos.
public function update(Request $request, Profesor $profesore)
⋮----
'unique:profesores,dni,' . $profesore->id, // Ignora el DNI del profesor actual
⋮----
$profesore->update($validatedData);
return redirect()->route('admin.profesores.show', $profesore->id)
->with('success', '¡Profesor actualizado correctamente!');
⋮----
public function destroy(Profesor $profesore) // Asegúrate que la variable es $profesore
⋮----
if ($profesore->cursos()->count() > 0) {
⋮----
->with('error', "No se puede eliminar el profesor '{$profesore->nombre} {$profesore->apellido1}' porque tiene cursos asignados. Reasigna o elimina esos cursos primero.");
⋮----
$profesore->delete(); // Intento de eliminación
⋮----
->with('success', "Profesor '{$nombreCompleto}' eliminado correctamente.");
⋮----
// Loguear el error real para más detalles
\Illuminate\Support\Facades\Log::error("Error al eliminar profesor (QueryException) ID {$profesore->id}: " . $e->getMessage());
⋮----
->with('error', 'No se pudo eliminar el profesor. Error de base de datos o restricción de integridad.');
⋮----
\Illuminate\Support\Facades\Log::error("Error inesperado al eliminar profesor ID {$profesore->id}: " . $e->getMessage());
⋮----
->with('error', 'Ocurrió un error inesperado al intentar eliminar el profesor.');
⋮----
/**
 * Muestra el recurso Profesor especificado.
 */
public function show(Profesor $profesore) // Route Model Binding
⋮----
// Cargar la relación 'cursos' para tener acceso a los cursos que imparte
// el profesor en la vista de detalles.
$profesore->load('cursos');
⋮----
// En app/Http/Controllers/Admin/ProfesorController.php
public function edit(Profesor $profesore) // Route Model Binding
⋮----
// Si necesitaras pasar opciones para <select> (ej: lista de especialidades o titulaciones
// definidas centralmente), las obtendrías aquí y las pasarías con compact().
$opcionesTitulacion = Profesor::TITULACIONES_VALIDAS; // Si las tienes como constante en el modelo
⋮----
// return view('admin.profesores.edit', compact('profesore', 'opcionesTitulacion', 'opcionesEspecialidad'));
```

## File: app/Http/Controllers/Admin/ScheduleController.php
```php
namespace App\Http\Controllers\Admin;
use App\Http\Controllers\Controller;
use App\Http\Requests\StoreScheduleRequest;
use App\Http\Requests\UpdateScheduleRequest;
use App\Models\Schedule;
use App\Models\Curso;
use App\Models\Profesor;
use App\Models\TimeSlot;
use Carbon\Carbon;
class ScheduleController extends Controller
⋮----
/**
     * Muestra la vista principal del calendario.
     */
public function index()
⋮----
/**
     * Obtiene y formatea los eventos para FullCalendar,
     * alineado con la migración real.
     */
public function fetchEvents()
⋮----
$schedules = Schedule::with(['curso.profesor'])->get();
$events = $schedules->map(function ($schedule) {
⋮----
// rrule.js espera un entero para 'byday' (0=Lunes, 6=Domingo).
// Mapeamos nuestro valor de la BD (0=Domingo, 1=Lunes) al formato de rrule.js.
⋮----
$byday = $dbToRruleDay[$schedule->dia_semana] ?? 0; // Por defecto Lunes si hay error.
$dtstart = $schedule->curso->fecha_inicio->format('Y-m-d') . 'T' . $schedule->hora_inicio;
$until = $schedule->curso->fecha_fin->format('Y-m-d');
⋮----
'duration' => Carbon::parse($schedule->hora_inicio)->diff(Carbon::parse($schedule->hora_fin))->format('%H:%I:%S'),
'backgroundColor' => $this->stringToColor($schedule->curso->nombre),
'borderColor'     => $this->stringToColor($schedule->curso->nombre, -20),
⋮----
})->filter();
return response()->json($events);
⋮----
/**
     * Helper para generar un color consistente a partir de un string.
     */
private function stringToColor($str, $lightnessAdjustment = 0)
```

## File: app/Http/Controllers/Auth/AuthenticatedSessionController.php
```php
namespace App\Http\Controllers\Auth;
use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\LoginRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;
class AuthenticatedSessionController extends Controller
⋮----
/**
     * Display the login view.
     */
public function create(): View
⋮----
/**
     * Handle an incoming authentication request.
     */
public function store(LoginRequest $request): RedirectResponse
⋮----
$request->authenticate();
$request->session()->regenerate();
return redirect()->intended(route('admin.dashboard', absolute: false));
⋮----
/**
     * Destroy an authenticated session.
     */
public function destroy(Request $request): RedirectResponse
⋮----
Auth::guard('web')->logout();
$request->session()->invalidate();
$request->session()->regenerateToken();
```

## File: app/Http/Controllers/Auth/ConfirmablePasswordController.php
```php
namespace App\Http\Controllers\Auth;
use App\Http\Controllers\Controller;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\ValidationException;
use Illuminate\View\View;
class ConfirmablePasswordController extends Controller
⋮----
/**
     * Show the confirm password view.
     */
public function show(): View
⋮----
/**
     * Confirm the user's password.
     */
public function store(Request $request): RedirectResponse
⋮----
if (! Auth::guard('web')->validate([
'email' => $request->user()->email,
⋮----
throw ValidationException::withMessages([
⋮----
$request->session()->put('auth.password_confirmed_at', time());
return redirect()->intended(route('dashboard', absolute: false));
```

## File: app/Http/Controllers/Auth/EmailVerificationNotificationController.php
```php
namespace App\Http\Controllers\Auth;
use App\Http\Controllers\Controller;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
class EmailVerificationNotificationController extends Controller
⋮----
/**
     * Send a new email verification notification.
     */
public function store(Request $request): RedirectResponse
⋮----
if ($request->user()->hasVerifiedEmail()) {
return redirect()->intended(route('dashboard', absolute: false));
⋮----
$request->user()->sendEmailVerificationNotification();
return back()->with('status', 'verification-link-sent');
```

## File: app/Http/Controllers/Auth/EmailVerificationPromptController.php
```php
namespace App\Http\Controllers\Auth;
use App\Http\Controllers\Controller;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;
class EmailVerificationPromptController extends Controller
⋮----
/**
     * Display the email verification prompt.
     */
public function __invoke(Request $request): RedirectResponse|View
⋮----
return $request->user()->hasVerifiedEmail()
? redirect()->intended(route('dashboard', absolute: false))
```

## File: app/Http/Controllers/Auth/NewPasswordController.php
```php
namespace App\Http\Controllers\Auth;
use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Auth\Events\PasswordReset;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Password;
use Illuminate\Support\Str;
use Illuminate\Validation\Rules;
use Illuminate\View\View;
class NewPasswordController extends Controller
⋮----
/**
     * Display the password reset view.
     */
public function create(Request $request): View
⋮----
/**
     * Handle an incoming new password request.
     *
     * @throws \Illuminate\Validation\ValidationException
     */
public function store(Request $request): RedirectResponse
⋮----
$request->validate([
⋮----
'password' => ['required', 'confirmed', Rules\Password::defaults()],
⋮----
// Here we will attempt to reset the user's password. If it is successful we
// will update the password on an actual user model and persist it to the
// database. Otherwise we will parse the error and return the response.
$status = Password::reset(
$request->only('email', 'password', 'password_confirmation', 'token'),
⋮----
$user->forceFill([
'password' => Hash::make($request->password),
'remember_token' => Str::random(60),
])->save();
⋮----
// If the password was successfully reset, we will redirect the user back to
// the application's home authenticated view. If there is an error we can
// redirect them back to where they came from with their error message.
⋮----
? redirect()->route('login')->with('status', __($status))
: back()->withInput($request->only('email'))
->withErrors(['email' => __($status)]);
```

## File: app/Http/Controllers/Auth/PasswordController.php
```php
namespace App\Http\Controllers\Auth;
use App\Http\Controllers\Controller;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules\Password;
class PasswordController extends Controller
⋮----
/**
     * Update the user's password.
     */
public function update(Request $request): RedirectResponse
⋮----
$validated = $request->validateWithBag('updatePassword', [
⋮----
'password' => ['required', Password::defaults(), 'confirmed'],
⋮----
$request->user()->update([
'password' => Hash::make($validated['password']),
⋮----
return back()->with('status', 'password-updated');
```

## File: app/Http/Controllers/Auth/PasswordResetLinkController.php
```php
namespace App\Http\Controllers\Auth;
use App\Http\Controllers\Controller;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Password;
use Illuminate\View\View;
class PasswordResetLinkController extends Controller
⋮----
/**
     * Display the password reset link request view.
     */
public function create(): View
⋮----
/**
     * Handle an incoming password reset link request.
     *
     * @throws \Illuminate\Validation\ValidationException
     */
public function store(Request $request): RedirectResponse
⋮----
$request->validate([
⋮----
// We will send the password reset link to this user. Once we have attempted
// to send the link, we will examine the response then see the message we
// need to show to the user. Finally, we'll send out a proper response.
$status = Password::sendResetLink(
$request->only('email')
⋮----
? back()->with('status', __($status))
: back()->withInput($request->only('email'))
->withErrors(['email' => __($status)]);
```

## File: app/Http/Controllers/Auth/RegisteredUserController.php
```php
namespace App\Http\Controllers\Auth;
use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules;
use Illuminate\View\View;
class RegisteredUserController extends Controller
⋮----
/**
     * Display the registration view.
     */
public function create(): View
⋮----
/**
     * Handle an incoming registration request.
     *
     * @throws \Illuminate\Validation\ValidationException
     */
public function store(Request $request): RedirectResponse
⋮----
$request->validate([
⋮----
'password' => ['required', 'confirmed', Rules\Password::defaults()],
⋮----
$user = User::create([
⋮----
'password' => Hash::make($request->password),
⋮----
Auth::login($user);
```

## File: app/Http/Controllers/Auth/VerifyEmailController.php
```php
namespace App\Http\Controllers\Auth;
use App\Http\Controllers\Controller;
use Illuminate\Auth\Events\Verified;
use Illuminate\Foundation\Auth\EmailVerificationRequest;
use Illuminate\Http\RedirectResponse;
class VerifyEmailController extends Controller
⋮----
/**
     * Mark the authenticated user's email address as verified.
     */
public function __invoke(EmailVerificationRequest $request): RedirectResponse
⋮----
if ($request->user()->hasVerifiedEmail()) {
return redirect()->intended(route('dashboard', absolute: false).'?verified=1');
⋮----
if ($request->user()->markEmailAsVerified()) {
event(new Verified($request->user()));
```

## File: app/Http/Controllers/Controller.php
```php
namespace App\Http\Controllers;
abstract class Controller
⋮----
//
```

## File: app/Http/Controllers/EventoController.php
```php
namespace App\Http\Controllers;
use Illuminate\Http\Request;
class EventoController extends Controller
⋮----
/**
     * Display a listing of the resource.
     */
public function index()
⋮----
/**
     * Show the form for creating a new resource.
     */
public function create()
⋮----
//
⋮----
/**
     * Store a newly created resource in storage.
     */
public function store(Request $request)
⋮----
/**
     * Display the specified resource.
     */
public function show(string $id)
⋮----
/**
     * Show the form for editing the specified resource.
     */
public function edit(string $id)
⋮----
/**
     * Update the specified resource in storage.
     */
public function update(Request $request, string $id)
⋮----
/**
     * Remove the specified resource from storage.
     */
public function destroy(string $id)
```

## File: app/Http/Controllers/ProfileController.php
```php
namespace App\Http\Controllers;
use App\Http\Requests\ProfileUpdateRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Illuminate\View\View;
class ProfileController extends Controller
⋮----
/**
     * Display the user's profile form.
     */
public function edit(Request $request): View
⋮----
'user' => $request->user(),
⋮----
/**
     * Update the user's profile information.
     */
public function update(ProfileUpdateRequest $request): RedirectResponse
⋮----
$request->user()->fill($request->validated());
if ($request->user()->isDirty('email')) {
$request->user()->email_verified_at = null;
⋮----
$request->user()->save();
return Redirect::route('profile.edit')->with('status', 'profile-updated');
⋮----
/**
     * Delete the user's account.
     */
public function destroy(Request $request): RedirectResponse
⋮----
$request->validateWithBag('userDeletion', [
⋮----
$user = $request->user();
Auth::logout();
$user->delete();
$request->session()->invalidate();
$request->session()->regenerateToken();
return Redirect::to('/');
```

## File: app/Http/Requests/Auth/LoginRequest.php
```php
namespace App\Http\Requests\Auth;
use Illuminate\Auth\Events\Lockout;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Support\Str;
use Illuminate\Validation\ValidationException;
class LoginRequest extends FormRequest
⋮----
/**
     * Determine if the user is authorized to make this request.
     */
public function authorize(): bool
⋮----
/**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
public function rules(): array
⋮----
/**
     * Attempt to authenticate the request's credentials.
     *
     * @throws \Illuminate\Validation\ValidationException
     */
public function authenticate(): void
⋮----
$this->ensureIsNotRateLimited();
if (! Auth::attempt($this->only('email', 'password'), $this->boolean('remember'))) {
RateLimiter::hit($this->throttleKey());
throw ValidationException::withMessages([
⋮----
RateLimiter::clear($this->throttleKey());
⋮----
/**
     * Ensure the login request is not rate limited.
     *
     * @throws \Illuminate\Validation\ValidationException
     */
public function ensureIsNotRateLimited(): void
⋮----
if (! RateLimiter::tooManyAttempts($this->throttleKey(), 5)) {
⋮----
$seconds = RateLimiter::availableIn($this->throttleKey());
⋮----
/**
     * Get the rate limiting throttle key for the request.
     */
public function throttleKey(): string
⋮----
return Str::transliterate(Str::lower($this->string('email')).'|'.$this->ip());
```

## File: app/Http/Requests/ProfileUpdateRequest.php
```php
namespace App\Http\Requests;
use App\Models\User;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;
class ProfileUpdateRequest extends FormRequest
⋮----
/**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
public function rules(): array
⋮----
Rule::unique(User::class)->ignore($this->user()->id),
```

## File: app/Http/Requests/StoreCursoRequest.php
```php
namespace App\Http\Requests;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;
class StoreCursoRequest extends FormRequest
⋮----
public function authorize(): bool
⋮----
return true; // Permitimos que cualquier usuario autenticado pueda intentar crear
⋮----
public function rules(): array
⋮----
// --- AÑADE Y/O COMPLETA ESTOS CAMPOS ---
⋮----
Rule::unique('cursos', 'codigo') // Asegura que el código sea único en la tabla 'cursos'
⋮----
'descripcion' => 'nullable|string|max:5000', // Un límite más alto para descripciones
```

## File: app/Http/Requests/StoreScheduleRequest.php
```php
namespace App\Http\Requests;
use App\Rules\NoScheduleOverlap;
use App\Rules\SufficientCourseDuration;
use Illuminate\Foundation\Http\FormRequest;
class StoreScheduleRequest extends FormRequest
⋮----
public function authorize(): bool
⋮----
public function rules(): array
⋮----
/// Aplicamos la nueva regla al curso_id
```

## File: app/Http/Requests/UpdateCursoRequest.php
```php
namespace App\Http\Requests;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;
class UpdateCursoRequest extends FormRequest
⋮----
public function authorize(): bool
⋮----
return true; // Permitimos que cualquier usuario autenticado pueda intentar editar
⋮----
public function rules(): array
⋮----
// Obtener el ID del curso desde la ruta (ej: /cursos/15/edit)
$cursoId = $this->route('curso')->id;
⋮----
// Campos que ya funcionaban
⋮----
// --- AÑADE Y/O COMPLETA ESTOS CAMPOS ---
⋮----
// Ignora la regla 'unique' para el curso que se está editando
Rule::unique('cursos', 'codigo')->ignore($cursoId)
```

## File: app/Http/Requests/UpdateScheduleRequest.php
```php
namespace App\Http\Requests;
use App\Rules\NoScheduleOverlap;
use App\Rules\SufficientCourseDuration;
use Illuminate\Foundation\Http\FormRequest;
class UpdateScheduleRequest extends FormRequest
⋮----
public function authorize(): bool
⋮----
public function rules(): array
⋮----
// Las reglas son idénticas a las de creación.
// La lógica para manejar duplicados o conflictos se gestiona en el controlador.
⋮----
// Pasamos el ID del horario actual al constructor de la regla
```

## File: app/Models/Alumno.php
```php
namespace App\Models;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
class Alumno extends Model
⋮----
/**
     * Los atributos que son asignables masivamente.
     *
     * @var array<int, string>
     */
protected $fillable = [
⋮----
protected $table = 'alumnos'; // Ya lo tienes, si es necesario
/**
    * Obtiene todos los registros de inscripción (tabla alumno_curso) para este alumno.
    */
public function inscripciones(): HasMany
⋮----
// Busca registros en 'alumno_curso' donde 'alumno_id' coincida con el ID de este alumno.
return $this->hasMany(AlumnoCurso::class);
⋮----
/**
    * Obtiene los cursos en los que está inscrito directamente este alumno.
    */
public function cursos(): BelongsToMany
⋮----
// Define una relación muchos-a-muchos con el modelo Curso.
// El segundo argumento es el nombre de la tabla pivote.
// Laravel inferirá las claves foráneas 'alumno_id' y 'curso_id' en la tabla pivote.
// Si quisieras acceder a columnas extra de la tabla pivote (como 'nota', 'estado'),
// usarías ->withPivot('nota', 'estado').
return $this->belongsToMany(Curso::class, 'alumno_curso')
->withPivot('fecha_inscripcion', 'nota', 'estado') // Opcional: para acceder a datos de la pivote
->withTimestamps(); // Opcional: si la tabla pivote tiene created_at/updated_at y quieres que Eloquent los maneje
```

## File: app/Models/AlumnoCurso.php
```php
namespace App\Models;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
class AlumnoCurso extends Model
⋮----
protected $table = 'alumno_curso';
/**
     * Los atributos que son asignables masivamente.
     *
     * @var array<int, string>
     */
protected $fillable = [
'alumno_id',        // Clave foránea
'curso_id',         // Clave foránea
⋮----
/**
    * Obtiene el alumno asociado a esta inscripción.
    */
public function alumno(): BelongsTo
⋮----
// Busca la clave foránea 'alumno_id' en esta tabla ('alumno_curso').
return $this->belongsTo(Alumno::class);
⋮----
/**
    * Obtiene el curso asociado a esta inscripción.
    */
public function curso(): BelongsTo
⋮----
// Busca la clave foránea 'curso_id' en esta tabla ('alumno_curso').
return $this->belongsTo(Curso::class);
```

## File: app/Models/Curso.php
```php
namespace App\Models;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
class Curso extends Model
⋮----
// Aquí pueden ir tus propiedades $fillable, $hidden, relaciones, etc.
protected $table = 'cursos'; // Nombre de la tabla en la base de datos
/**
     * Los atributos que son asignables masivamente.
     *
     * @var array<int, string>
     */
protected $fillable = [
⋮----
'profesor_id', // Incluir la clave foránea si se asigna masivamente
⋮----
/**
     * Los atributos que deben ser convertidos a tipos nativos.
     * Esto es útil para que las fechas se traten como objetos Carbon.
     * @var array<string, string>
     */
protected $casts = [
⋮----
/**
    * Obtiene el profesor que imparte este curso.
    */
public function profesor(): BelongsTo
⋮----
// Laravel busca automáticamente una columna 'profesor_id' en esta tabla ('cursos')
// para enlazarla con la tabla 'profesores'.
return $this->belongsTo(Profesor::class);
⋮----
/**
    * Obtiene todos los registros de inscripción (tabla alumno_curso) para este curso.
    */
public function inscripciones(): HasMany
⋮----
// Busca registros en 'alumno_curso' donde 'curso_id' coincida con el ID de este curso.
return $this->hasMany(AlumnoCurso::class);
⋮----
/**
    * Obtiene los alumnos inscritos directamente en este curso.
    */
public function alumnos(): BelongsToMany
⋮----
// Define la relación inversa muchos-a-muchos.
return $this->belongsToMany(Alumno::class, 'alumno_curso')
->withPivot('fecha_inscripcion', 'nota', 'estado') // Mismas opciones que antes
->withTimestamps(); // Mismas opciones que antes
⋮----
/**
    * Obtiene las franjas horarias asociadas a este curso.
    * @return \Illuminate\Database\Eloquent\Relations\HasMany
    * @throws \Illuminate\Database\Eloquent\Relations\RelationNotFoundException
    * Esta relación es 1-a-1, ya que cada curso tiene una única franja horaria.
    */
public function schedules()
⋮----
return $this->hasMany(Schedule::class, 'curso_id');
```

## File: app/Models/Evento.php
```php
namespace App\Models;
use Illuminate\Database\Eloquent\Model;
class Evento extends Model
⋮----
//
```

## File: app/Models/PreinscritoSepe.php
```php
namespace App\Models;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
class PreinscritoSepe extends Model
⋮----
protected $table = 'preinscritos_sepe';
protected $fillable = [
⋮----
'sexo',                 // Añadido
⋮----
'num_seguridad_social', // Añadido
⋮----
'estado',               // Añadido
'fecha_importacion',    // Añadido
⋮----
protected $casts = [
⋮----
// Aquí podrías añadir relaciones si los preinscritos se asocian a algo más (ej: un curso deseado)
```

## File: app/Models/Profesor.php
```php
namespace App\Models;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
class Profesor extends Model
⋮----
/**
     * La tabla asociada con el modelo.
     *
     * @var string
     */
protected $table = 'profesores'; // <-- ¡AÑADIR ESTA LÍNEA!
// Aquí pueden ir tus propiedades $fillable, $hidden, relaciones, etc.
// protected $fillable = [...];
/**
     * Los atributos que son asignables masivamente.
     *
     * @var array<int, string>
     */
protected $fillable = [
⋮----
// No incluir 'id', 'created_at', 'updated_at'
⋮----
/**
    * Obtiene los cursos impartidos por este profesor.
    */
public function cursos(): HasMany
⋮----
// Laravel busca automáticamente la clave foránea 'profesor_id' en la tabla 'cursos'
// porque el método está en el modelo 'Profesor'.
return $this->hasMany(Curso::class);
⋮----
/**
     * Obtiene los horarios asignados a este profesor.
     *  @return \Illuminate\Database\Eloquent\Relations\HasMany
     *  @throws \Illuminate\Database\Eloquent\Relations\RelationNotFoundException
     * 
     */
public function schedules()
⋮----
return $this->hasMany(Schedule::class, 'profesor_id');
```

## File: app/Models/Schedule.php
```php
namespace App\Models;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
class Schedule extends Model
⋮----
protected $table = 'schedules';
protected $fillable = [
⋮----
/* — Relaciones inversas — */
public function curso()
⋮----
return $this->belongsTo(Curso::class, 'curso_id');
⋮----
public function profesor()
⋮----
// CORRECCIÓN: Asegúrate de que aquí se referencia a App\Models\Profesor
return $this->belongsTo(Profesor::class, 'profesor_id');
⋮----
public function timeSlot()
⋮----
return $this->belongsTo(TimeSlot::class);
```

## File: app/Models/TimeSlot.php
```php
namespace App\Models;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
class TimeSlot extends Model
⋮----
protected $table = 'time_slots';      // ← explícito, por claridad
protected $fillable = ['weekday', 'start_time', 'end_time', 'room'];
/* Relación 1-a-1 (o 1-a-muchos si permites duplicar) */
public function schedule()
⋮----
return $this->hasOne(Schedule::class);
```

## File: app/Models/User.php
```php
namespace App\Models;
// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
class User extends Authenticatable
⋮----
/** @use HasFactory<\Database\Factories\UserFactory> */
⋮----
/**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
protected $fillable = [
⋮----
/**
     * The attributes that should be hidden for serialization.
     *
     * @var list<string>
     */
protected $hidden = [
⋮----
/**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
protected function casts(): array
```

## File: app/Providers/AppServiceProvider.php
```php
namespace App\Providers;
use Illuminate\Support\ServiceProvider;
class AppServiceProvider extends ServiceProvider
⋮----
/**
     * Register any application services.
     */
public function register(): void
⋮----
//
⋮----
/**
     * Bootstrap any application services.
     */
public function boot(): void
```

## File: app/Rules/NoScheduleOverlap.php
```php
namespace App\Rules;
// IMPORTAMOS LAS INTERFACES NECESARIAS
use Illuminate\Contracts\Validation\Rule;
use Illuminate\Contracts\Validation\DataAwareRule; // <-- CORRECCIÓN 1: Importar DataAwareRule
use App\Models\Schedule;
class NoScheduleOverlap implements Rule, DataAwareRule // <-- CORRECCIÓN 2: Implementar DataAwareRule
⋮----
/**
     * Todos los datos del formulario.
     * @var array
     */
protected $data = [];
/**
     * El ID del horario que estamos editando, para ignorarlo en la comprobación.
     * @var int|null
     */
protected $scheduleIdToIgnore;
public function __construct($scheduleIdToIgnore = null)
⋮----
/**
     * Set the data under validation.
     * Este método AHORA SÍ será llamado por Laravel antes de 'passes()'.
     *
     * @param  array  $data
     * @return $this
     */
public function setData(array $data)
⋮----
/**
     * Determine if the validation rule passes.
     */
public function passes($attribute, $value)
⋮----
// Extraemos los datos del array $this->data
⋮----
$startTime = $value; // El valor del campo actual (start_time)
⋮----
// Si falta algún dato esencial, la regla no puede ejecutarse, pero otras reglas lo capturarán.
⋮----
$query = Schedule::query()
->join('time_slots', 'schedules.time_slot_id', '=', 'time_slots.id')
->where('time_slots.weekday', $weekday)
// La condición clave para detectar solapamiento de tiempo:
// (start1 < end2) AND (end1 > start2)
->where('time_slots.start_time', '<', $endTime)
->where('time_slots.end_time', '>', $startTime)
->where(function ($q) use ($profesorId, $room) {
$q->where('schedules.profesor_id', $profesorId)
->orWhere('time_slots.room', $room);
⋮----
$query->where('schedules.id', '!=', $this->scheduleIdToIgnore);
⋮----
return !$query->exists();
⋮----
/**
     * Get the validation error message.
     */
public function message()
```

## File: app/Rules/NotExistsInTables.php
```php
namespace App\Rules;
use Illuminate\Contracts\Validation\InvokableRule; // Para la nueva sintaxis de __invoke
use Illuminate\Support\Facades\DB; // Para interactuar con la base de datos
class NotExistsInTables implements InvokableRule
⋮----
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
⋮----
/**
     * Run the validation rule.
     *
     * @param  string  $attribute El nombre del campo que se está validando (ej: 'dni', 'email')
     * @param  mixed  $value El valor del campo que se está validando
     * @param  \Closure(string): \Illuminate\Translation\PotentiallyTranslatedString  $fail La función de callback para marcar el fallo
     * @return void
     */
public function __invoke($attribute, $value, $fail)
⋮----
// Solo realizar la verificación si el valor no está vacío.
// Esto hace que la regla sea compatible con 'nullable' si se desea.
⋮----
// Validar que la configuración del check es correcta
⋮----
// Podrías lanzar una excepción aquí o loguear un error de configuración de la regla
continue; // Saltar este check si está mal configurado
⋮----
$exists = DB::table($check['table'])
->where($check['column'], $value)
// Si las tablas usan SoftDeletes y quieres ignorar los borrados lógicamente:
// ->whereNull('deleted_at') // Descomenta si aplica
->exists();
⋮----
// Personalizar el mensaje de error usando el label proporcionado
$fail(str_replace([':attribute', ':entity'], [$attribute, $check['label']], $this->messageFormat));
return; // Detener la validación en la primera coincidencia encontrada
```

## File: app/Rules/SufficientCourseDuration.php
```php
namespace App\Rules;
use Illuminate\Contracts\Validation\Rule;
use Illuminate\Contracts\Validation\DataAwareRule;
use App\Models\Curso;
use App\Models\Schedule;
use Carbon\Carbon;
class SufficientCourseDuration implements Rule, DataAwareRule
⋮----
protected $data = [];
protected $scheduleIdToIgnore = null;
protected $courseTotalHours = 0;
public function __construct($scheduleIdToIgnore = null)
⋮----
public function setData(array $data)
⋮----
public function passes($attribute, $value)
⋮----
// Si faltan datos básicos, otras reglas se encargarán. No fallamos aquí.
⋮----
// 1. Obtener la duración total del curso
$curso = Curso::find($cursoId);
⋮----
// Si el curso no tiene horas definidas, no podemos validar.
⋮----
// 2. Calcular la duración del nuevo bloque de horario en horas
$newHours = Carbon::parse($startTime)->diffInMinutes(Carbon::parse($endTime)) / 60.0;
// 3. Calcular la suma de horas de los horarios YA existentes para este curso
$existingHours = Schedule::query()
->where('curso_id', $cursoId)
->when($this->scheduleIdToIgnore, function ($query) {
// Si estamos editando, excluimos el horario actual de la suma
$query->where('id', '!=', $this->scheduleIdToIgnore);
⋮----
->join('time_slots', 'schedules.time_slot_id', '=', 'time_slots.id')
->sum(DB::raw('EXTRACT(EPOCH FROM (time_slots.end_time - time_slots.start_time)) / 3600'));
// 4. Comprobar si el total excede la duración del curso
⋮----
public function message()
```

## File: app/View/Components/AppLayout.php
```php
namespace App\View\Components;
use Illuminate\View\Component;
use Illuminate\View\View;
class AppLayout extends Component
⋮----
/**
     * Get the view / contents that represents the component.
     */
public function render(): View
```

## File: app/View/Components/GuestLayout.php
```php
namespace App\View\Components;
use Illuminate\View\Component;
use Illuminate\View\View;
class GuestLayout extends Component
⋮----
/**
     * Get the view / contents that represents the component.
     */
public function render(): View
```

## File: bootstrap/cache/.gitignore
```
*
!.gitignore
```

## File: bootstrap/app.php
```php
use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;
return Application::configure(basePath: dirname(__DIR__))
->withRouting(
⋮----
->withMiddleware(function (Middleware $middleware) {
//
⋮----
->withExceptions(function (Exceptions $exceptions) {
⋮----
})->create();
```

## File: bootstrap/providers.php
```php

```

## File: config/app.php
```php
/*
    |--------------------------------------------------------------------------
    | Application Name
    |--------------------------------------------------------------------------
    |
    | This value is the name of your application, which will be used when the
    | framework needs to place the application's name in a notification or
    | other UI elements where an application name needs to be displayed.
    |
    */
⋮----
/*
    |--------------------------------------------------------------------------
    | Application Environment
    |--------------------------------------------------------------------------
    |
    | This value determines the "environment" your application is currently
    | running in. This may determine how you prefer to configure various
    | services the application utilizes. Set this in your ".env" file.
    |
    */
⋮----
/*
    |--------------------------------------------------------------------------
    | Application Debug Mode
    |--------------------------------------------------------------------------
    |
    | When your application is in debug mode, detailed error messages with
    | stack traces will be shown on every error that occurs within your
    | application. If disabled, a simple generic error page is shown.
    |
    */
⋮----
/*
    |--------------------------------------------------------------------------
    | Application URL
    |--------------------------------------------------------------------------
    |
    | This URL is used by the console to properly generate URLs when using
    | the Artisan command line tool. You should set this to the root of
    | the application so that it's available within Artisan commands.
    |
    */
⋮----
/*
    |--------------------------------------------------------------------------
    | Application Timezone
    |--------------------------------------------------------------------------
    |
    | Here you may specify the default timezone for your application, which
    | will be used by the PHP date and date-time functions. The timezone
    | is set to "UTC" by default as it is suitable for most use cases.
    |
    */
⋮----
/*
    |--------------------------------------------------------------------------
    | Application Locale Configuration
    |--------------------------------------------------------------------------
    |
    | The application locale determines the default locale that will be used
    | by Laravel's translation / localization methods. This option can be
    | set to any locale for which you plan to have translation strings.
    |
    */
⋮----
/*
    |--------------------------------------------------------------------------
    | Encryption Key
    |--------------------------------------------------------------------------
    |
    | This key is utilized by Laravel's encryption services and should be set
    | to a random, 32 character string to ensure that all encrypted values
    | are secure. You should do this prior to deploying the application.
    |
    */
⋮----
/*
    |--------------------------------------------------------------------------
    | Maintenance Mode Driver
    |--------------------------------------------------------------------------
    |
    | These configuration options determine the driver used to determine and
    | manage Laravel's "maintenance mode" status. The "cache" driver will
    | allow maintenance mode to be controlled across multiple machines.
    |
    | Supported drivers: "file", "cache"
    |
    */
```

## File: config/auth.php
```php
/*
    |--------------------------------------------------------------------------
    | Authentication Defaults
    |--------------------------------------------------------------------------
    |
    | This option defines the default authentication "guard" and password
    | reset "broker" for your application. You may change these values
    | as required, but they're a perfect start for most applications.
    |
    */
⋮----
/*
    |--------------------------------------------------------------------------
    | Authentication Guards
    |--------------------------------------------------------------------------
    |
    | Next, you may define every authentication guard for your application.
    | Of course, a great default configuration has been defined for you
    | which utilizes session storage plus the Eloquent user provider.
    |
    | All authentication guards have a user provider, which defines how the
    | users are actually retrieved out of your database or other storage
    | system used by the application. Typically, Eloquent is utilized.
    |
    | Supported: "session"
    |
    */
⋮----
/*
    |--------------------------------------------------------------------------
    | User Providers
    |--------------------------------------------------------------------------
    |
    | All authentication guards have a user provider, which defines how the
    | users are actually retrieved out of your database or other storage
    | system used by the application. Typically, Eloquent is utilized.
    |
    | If you have multiple user tables or models you may configure multiple
    | providers to represent the model / table. These providers may then
    | be assigned to any extra authentication guards you have defined.
    |
    | Supported: "database", "eloquent"
    |
    */
⋮----
// 'users' => [
//     'driver' => 'database',
//     'table' => 'users',
// ],
⋮----
/*
    |--------------------------------------------------------------------------
    | Resetting Passwords
    |--------------------------------------------------------------------------
    |
    | These configuration options specify the behavior of Laravel's password
    | reset functionality, including the table utilized for token storage
    | and the user provider that is invoked to actually retrieve users.
    |
    | The expiry time is the number of minutes that each reset token will be
    | considered valid. This security feature keeps tokens short-lived so
    | they have less time to be guessed. You may change this as needed.
    |
    | The throttle setting is the number of seconds a user must wait before
    | generating more password reset tokens. This prevents the user from
    | quickly generating a very large amount of password reset tokens.
    |
    */
⋮----
/*
    |--------------------------------------------------------------------------
    | Password Confirmation Timeout
    |--------------------------------------------------------------------------
    |
    | Here you may define the amount of seconds before a password confirmation
    | window expires and users are asked to re-enter their password via the
    | confirmation screen. By default, the timeout lasts for three hours.
    |
    */
```

## File: config/cache.php
```php
use Illuminate\Support\Str;
⋮----
/*
    |--------------------------------------------------------------------------
    | Default Cache Store
    |--------------------------------------------------------------------------
    |
    | This option controls the default cache store that will be used by the
    | framework. This connection is utilized if another isn't explicitly
    | specified when running a cache operation inside the application.
    |
    */
⋮----
/*
    |--------------------------------------------------------------------------
    | Cache Stores
    |--------------------------------------------------------------------------
    |
    | Here you may define all of the cache "stores" for your application as
    | well as their drivers. You may even define multiple stores for the
    | same cache driver to group types of items stored in your caches.
    |
    | Supported drivers: "array", "database", "file", "memcached",
    |                    "redis", "dynamodb", "octane", "null"
    |
    */
⋮----
// Memcached::OPT_CONNECT_TIMEOUT => 2000,
⋮----
/*
    |--------------------------------------------------------------------------
    | Cache Key Prefix
    |--------------------------------------------------------------------------
    |
    | When utilizing the APC, database, memcached, Redis, and DynamoDB cache
    | stores, there might be other applications using the same cache. For
    | that reason, you may prefix every cache key to avoid collisions.
    |
    */
'prefix' => env('CACHE_PREFIX', Str::slug(env('APP_NAME', 'laravel'), '_').'_cache_'),
```

## File: config/database.php
```php
use Illuminate\Support\Str;
⋮----
/*
    |--------------------------------------------------------------------------
    | Default Database Connection Name
    |--------------------------------------------------------------------------
    |
    | Here you may specify which of the database connections below you wish
    | to use as your default connection for database operations. This is
    | the connection which will be utilized unless another connection
    | is explicitly specified when you execute a query / statement.
    |
    */
⋮----
/*
    |--------------------------------------------------------------------------
    | Database Connections
    |--------------------------------------------------------------------------
    |
    | Below are all of the database connections defined for your application.
    | An example configuration is provided for each database system which
    | is supported by Laravel. You're free to add / remove connections.
    |
    */
⋮----
// 'encrypt' => env('DB_ENCRYPT', 'yes'),
// 'trust_server_certificate' => env('DB_TRUST_SERVER_CERTIFICATE', 'false'),
⋮----
/*
    |--------------------------------------------------------------------------
    | Migration Repository Table
    |--------------------------------------------------------------------------
    |
    | This table keeps track of all the migrations that have already run for
    | your application. Using this information, we can determine which of
    | the migrations on disk haven't actually been run on the database.
    |
    */
⋮----
/*
    |--------------------------------------------------------------------------
    | Redis Databases
    |--------------------------------------------------------------------------
    |
    | Redis is an open source, fast, and advanced key-value store that also
    | provides a richer body of commands than a typical key-value system
    | such as Memcached. You may define your connection settings here.
    |
    */
⋮----
'prefix' => env('REDIS_PREFIX', Str::slug(env('APP_NAME', 'laravel'), '_').'_database_'),
```

## File: config/filesystems.php
```php
/*
    |--------------------------------------------------------------------------
    | Default Filesystem Disk
    |--------------------------------------------------------------------------
    |
    | Here you may specify the default filesystem disk that should be used
    | by the framework. The "local" disk, as well as a variety of cloud
    | based disks are available to your application for file storage.
    |
    */
⋮----
/*
    |--------------------------------------------------------------------------
    | Filesystem Disks
    |--------------------------------------------------------------------------
    |
    | Below you may configure as many filesystem disks as necessary, and you
    | may even configure multiple disks for the same driver. Examples for
    | most supported storage drivers are configured here for reference.
    |
    | Supported drivers: "local", "ftp", "sftp", "s3"
    |
    */
⋮----
/*
    |--------------------------------------------------------------------------
    | Symbolic Links
    |--------------------------------------------------------------------------
    |
    | Here you may configure the symbolic links that will be created when the
    | `storage:link` Artisan command is executed. The array keys should be
    | the locations of the links and the values should be their targets.
    |
    */
```

## File: config/logging.php
```php
use Monolog\Handler\NullHandler;
use Monolog\Handler\StreamHandler;
use Monolog\Handler\SyslogUdpHandler;
use Monolog\Processor\PsrLogMessageProcessor;
⋮----
/*
    |--------------------------------------------------------------------------
    | Default Log Channel
    |--------------------------------------------------------------------------
    |
    | This option defines the default log channel that is utilized to write
    | messages to your logs. The value provided here should match one of
    | the channels present in the list of "channels" configured below.
    |
    */
⋮----
/*
    |--------------------------------------------------------------------------
    | Deprecations Log Channel
    |--------------------------------------------------------------------------
    |
    | This option controls the log channel that should be used to log warnings
    | regarding deprecated PHP and library features. This allows you to get
    | your application ready for upcoming major versions of dependencies.
    |
    */
⋮----
/*
    |--------------------------------------------------------------------------
    | Log Channels
    |--------------------------------------------------------------------------
    |
    | Here you may configure the log channels for your application. Laravel
    | utilizes the Monolog PHP logging library, which includes a variety
    | of powerful log handlers and formatters that you're free to use.
    |
    | Available drivers: "single", "daily", "slack", "syslog",
    |                    "errorlog", "monolog", "custom", "stack"
    |
    */
```

## File: config/mail.php
```php
/*
    |--------------------------------------------------------------------------
    | Default Mailer
    |--------------------------------------------------------------------------
    |
    | This option controls the default mailer that is used to send all email
    | messages unless another mailer is explicitly specified when sending
    | the message. All additional mailers can be configured within the
    | "mailers" array. Examples of each type of mailer are provided.
    |
    */
⋮----
/*
    |--------------------------------------------------------------------------
    | Mailer Configurations
    |--------------------------------------------------------------------------
    |
    | Here you may configure all of the mailers used by your application plus
    | their respective settings. Several examples have been configured for
    | you and you are free to add your own as your application requires.
    |
    | Laravel supports a variety of mail "transport" drivers that can be used
    | when delivering an email. You may specify which one you're using for
    | your mailers below. You may also add additional mailers if needed.
    |
    | Supported: "smtp", "sendmail", "mailgun", "ses", "ses-v2",
    |            "postmark", "resend", "log", "array",
    |            "failover", "roundrobin"
    |
    */
⋮----
// 'message_stream_id' => env('POSTMARK_MESSAGE_STREAM_ID'),
// 'client' => [
//     'timeout' => 5,
// ],
⋮----
/*
    |--------------------------------------------------------------------------
    | Global "From" Address
    |--------------------------------------------------------------------------
    |
    | You may wish for all emails sent by your application to be sent from
    | the same address. Here you may specify a name and address that is
    | used globally for all emails that are sent by your application.
    |
    */
```

## File: config/queue.php
```php
/*
    |--------------------------------------------------------------------------
    | Default Queue Connection Name
    |--------------------------------------------------------------------------
    |
    | Laravel's queue supports a variety of backends via a single, unified
    | API, giving you convenient access to each backend using identical
    | syntax for each. The default queue connection is defined below.
    |
    */
⋮----
/*
    |--------------------------------------------------------------------------
    | Queue Connections
    |--------------------------------------------------------------------------
    |
    | Here you may configure the connection options for every queue backend
    | used by your application. An example configuration is provided for
    | each backend supported by Laravel. You're also free to add more.
    |
    | Drivers: "sync", "database", "beanstalkd", "sqs", "redis", "null"
    |
    */
⋮----
/*
    |--------------------------------------------------------------------------
    | Job Batching
    |--------------------------------------------------------------------------
    |
    | The following options configure the database and table that store job
    | batching information. These options can be updated to any database
    | connection and table which has been defined by your application.
    |
    */
⋮----
/*
    |--------------------------------------------------------------------------
    | Failed Queue Jobs
    |--------------------------------------------------------------------------
    |
    | These options configure the behavior of failed queue job logging so you
    | can control how and where failed jobs are stored. Laravel ships with
    | support for storing failed jobs in a simple file or in a database.
    |
    | Supported drivers: "database-uuids", "dynamodb", "file", "null"
    |
    */
```

## File: config/services.php
```php
/*
    |--------------------------------------------------------------------------
    | Third Party Services
    |--------------------------------------------------------------------------
    |
    | This file is for storing the credentials for third party services such
    | as Mailgun, Postmark, AWS and more. This file provides the de facto
    | location for this type of information, allowing packages to have
    | a conventional file to locate the various service credentials.
    |
    */
```

## File: config/session.php
```php
use Illuminate\Support\Str;
⋮----
/*
    |--------------------------------------------------------------------------
    | Default Session Driver
    |--------------------------------------------------------------------------
    |
    | This option determines the default session driver that is utilized for
    | incoming requests. Laravel supports a variety of storage options to
    | persist session data. Database storage is a great default choice.
    |
    | Supported: "file", "cookie", "database", "apc",
    |            "memcached", "redis", "dynamodb", "array"
    |
    */
⋮----
/*
    |--------------------------------------------------------------------------
    | Session Lifetime
    |--------------------------------------------------------------------------
    |
    | Here you may specify the number of minutes that you wish the session
    | to be allowed to remain idle before it expires. If you want them
    | to expire immediately when the browser is closed then you may
    | indicate that via the expire_on_close configuration option.
    |
    */
⋮----
/*
    |--------------------------------------------------------------------------
    | Session Encryption
    |--------------------------------------------------------------------------
    |
    | This option allows you to easily specify that all of your session data
    | should be encrypted before it's stored. All encryption is performed
    | automatically by Laravel and you may use the session like normal.
    |
    */
⋮----
/*
    |--------------------------------------------------------------------------
    | Session File Location
    |--------------------------------------------------------------------------
    |
    | When utilizing the "file" session driver, the session files are placed
    | on disk. The default storage location is defined here; however, you
    | are free to provide another location where they should be stored.
    |
    */
⋮----
/*
    |--------------------------------------------------------------------------
    | Session Database Connection
    |--------------------------------------------------------------------------
    |
    | When using the "database" or "redis" session drivers, you may specify a
    | connection that should be used to manage these sessions. This should
    | correspond to a connection in your database configuration options.
    |
    */
⋮----
/*
    |--------------------------------------------------------------------------
    | Session Database Table
    |--------------------------------------------------------------------------
    |
    | When using the "database" session driver, you may specify the table to
    | be used to store sessions. Of course, a sensible default is defined
    | for you; however, you're welcome to change this to another table.
    |
    */
⋮----
/*
    |--------------------------------------------------------------------------
    | Session Cache Store
    |--------------------------------------------------------------------------
    |
    | When using one of the framework's cache driven session backends, you may
    | define the cache store which should be used to store the session data
    | between requests. This must match one of your defined cache stores.
    |
    | Affects: "apc", "dynamodb", "memcached", "redis"
    |
    */
⋮----
/*
    |--------------------------------------------------------------------------
    | Session Sweeping Lottery
    |--------------------------------------------------------------------------
    |
    | Some session drivers must manually sweep their storage location to get
    | rid of old sessions from storage. Here are the chances that it will
    | happen on a given request. By default, the odds are 2 out of 100.
    |
    */
⋮----
/*
    |--------------------------------------------------------------------------
    | Session Cookie Name
    |--------------------------------------------------------------------------
    |
    | Here you may change the name of the session cookie that is created by
    | the framework. Typically, you should not need to change this value
    | since doing so does not grant a meaningful security improvement.
    |
    */
⋮----
Str::slug(env('APP_NAME', 'laravel'), '_').'_session'
⋮----
/*
    |--------------------------------------------------------------------------
    | Session Cookie Path
    |--------------------------------------------------------------------------
    |
    | The session cookie path determines the path for which the cookie will
    | be regarded as available. Typically, this will be the root path of
    | your application, but you're free to change this when necessary.
    |
    */
⋮----
/*
    |--------------------------------------------------------------------------
    | Session Cookie Domain
    |--------------------------------------------------------------------------
    |
    | This value determines the domain and subdomains the session cookie is
    | available to. By default, the cookie will be available to the root
    | domain and all subdomains. Typically, this shouldn't be changed.
    |
    */
⋮----
/*
    |--------------------------------------------------------------------------
    | HTTPS Only Cookies
    |--------------------------------------------------------------------------
    |
    | By setting this option to true, session cookies will only be sent back
    | to the server if the browser has a HTTPS connection. This will keep
    | the cookie from being sent to you when it can't be done securely.
    |
    */
⋮----
/*
    |--------------------------------------------------------------------------
    | HTTP Access Only
    |--------------------------------------------------------------------------
    |
    | Setting this value to true will prevent JavaScript from accessing the
    | value of the cookie and the cookie will only be accessible through
    | the HTTP protocol. It's unlikely you should disable this option.
    |
    */
⋮----
/*
    |--------------------------------------------------------------------------
    | Same-Site Cookies
    |--------------------------------------------------------------------------
    |
    | This option determines how your cookies behave when cross-site requests
    | take place, and can be used to mitigate CSRF attacks. By default, we
    | will set this value to "lax" to permit secure cross-site requests.
    |
    | See: https://developer.mozilla.org/en-US/docs/Web/HTTP/Headers/Set-Cookie#samesitesamesite-value
    |
    | Supported: "lax", "strict", "none", null
    |
    */
⋮----
/*
    |--------------------------------------------------------------------------
    | Partitioned Cookies
    |--------------------------------------------------------------------------
    |
    | Setting this value to true will tie the cookie to the top-level site for
    | a cross-site context. Partitioned cookies are accepted by the browser
    | when flagged "secure" and the Same-Site attribute is set to "none".
    |
    */
```

## File: database/factories/AlumnoCursoFactory.php
```php
namespace Database\Factories;
use App\Models\AlumnoCurso; // Verifica la ruta del modelo
use App\Models\Alumno; // Necesario
use App\Models\Curso; // Necesario
use Illuminate\Database\Eloquent\Factories\Factory;
class AlumnoCursoFactory extends Factory
⋮----
protected $model = AlumnoCurso::class;
public function definition(): array
⋮----
// ESTO ES PROBLEMÁTICO: Genera IDs al azar, sin verificar
// si el par ya existe o si el curso está lleno.
// ¡La lógica real DEBE estar en el Seeder!
$alumnoId = Alumno::inRandomOrder()->first()?->id;
$cursoId = Curso::inRandomOrder()->first()?->id;
⋮----
throw new \Exception("Asegúrate de que AlumnoSeeder y CursoSeeder se ejecutan primero.");
⋮----
$estado = fake()->randomElement(['Inscrito', 'Completado', 'Baja', 'Pendiente']);
$nota = ($estado === 'Completado') ? fake()->randomFloat(2, 4, 10) : null; // Nota solo si completado
⋮----
'fecha_inscripcion' => fake()->dateTimeBetween('-1 year', 'now')->format('Y-m-d'),
```

## File: database/factories/AlumnoFactory.php
```php
namespace Database\Factories;
use App\Models\Alumno; // Verifica la ruta del modelo
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;
class AlumnoFactory extends Factory
⋮----
protected $model = Alumno::class;
public function definition(): array
⋮----
$sexo = fake()->randomElement(['Hombre', 'Mujer']);
$nombre = ($sexo === 'Hombre') ? fake()->firstNameMale() : fake()->firstNameFemale();
⋮----
// Genera una fecha/hora aleatoria dentro de los últimos 6 meses
$fechaCreacion = fake()->dateTimeBetween('-6 months', 'now');
⋮----
'apellido1' => fake()->lastName(),
'apellido2' => fake()->optional(0.7)->lastName(),
'dni' => fake()->unique()->numerify('########') . fake()->randomLetter(),
//'num_seguridad_social' => fake()->optional(0.8)->unique()->numerify('##/########/##'), // Opcional
'num_seguridad_social' => fake()->boolean(80) // 80% de probabilidad de que sea true
? fake()->unique()->numerify('##/########/##') // Si es true, genera el número único
: null, // Si es false (20%), asigna null
'fecha_nacimiento' => fake()->dateTimeBetween('-50 years', '-16 years')->format('Y-m-d'),
⋮----
'direccion' => fake()->streetAddress(),
'cp' => fake()->postcode(),
'localidad' => fake()->city(),
'provincia' => fake()->state(), // O usa lista de provincias españolas
// --- ¡CORREGIR ESTA LÍNEA TAMBIÉN! ---
// Original (incorrecta): 'telefono' => fake()->optional(0.9)->unique()->numerify('6########'),
'telefono' => fake()->boolean(90) // 90% de probabilidad de tener teléfono
? fake()->unique()->numerify('6########') // Si es true, genera
: null, // Si es false (10%), asigna null
'email' => fake()->unique()->safeEmail(),
'nacionalidad' => fake()->randomElement(['Española', 'Portuguesa', 'Marroquí', 'Colombiana', 'Otra']),
'situacion_laboral' => fake()->randomElement($situacion),
'nivel_formativo' => fake()->randomElement($nivel),
'estado' => fake()->randomElement(['Activo', 'Inactivo', 'Baja', 'Pendiente']), // Ejemplo de estados
⋮----
'updated_at' => $fechaCreacion, // Usualmente, para datos de prueba, la fecha de actualización es la misma que la de creación
```

## File: database/factories/CursoFactory.php
```php
namespace Database\Factories;
use App\Models\Curso; // Verifica la ruta del modelo
use App\Models\Profesor; // Necesario para asignar profesor
use Illuminate\Database\Eloquent\Factories\Factory;
use Carbon\Carbon;
class CursoFactory extends Factory
⋮----
protected $model = Curso::class;
public function definition(): array
⋮----
// Asegurarse que existen profesores antes de ejecutar este factory
$profesorId = Profesor::inRandomOrder()->first()?->id; // Obtiene el ID de un profesor al azar
// Si no hay profesores, lanza un error o retorna null/default ID? Depende de tu lógica.
// Para evitar errores, el ProfesorSeeder DEBE ejecutarse antes.
⋮----
// Podrías crear un profesor aquí si no existe, pero es mejor asegurar el orden en DatabaseSeeder
throw new \Exception("No se encontraron profesores para asignar al curso. Asegúrate de ejecutar ProfesorSeeder primero.");
⋮----
$fechaInicio = fake()->dateTimeBetween('+1 week', '+6 months');
$duracionDias = fake()->numberBetween(30, 180); // Duración en días
$fechaFin = (clone $fechaInicio)->modify("+$duracionDias days");
⋮----
'nombre' => fake()->catchPhrase() . ' ' . fake()->jobTitle(), // Nombre de curso inventado
'codigo' => fake()->unique()->bothify('??###??'), // Código único
'descripcion' => fake()->paragraph(3),
'modalidad' => fake()->randomElement($modalidades),
'nivel' => fake()->randomElement($niveles),
'requisitos' => fake()->sentence(10),
'fecha_inicio' => $fechaInicio->format('Y-m-d'),
'fecha_fin' => $fechaFin->format('Y-m-d'),
'horas_totales' => fake()->numberBetween(40, 600),
'horario' => fake()->randomElement($horarios),
'centros' => fake()->randomElement($centros),
'profesor_id' => $profesorId, // Asigna el ID del profesor obtenido
'plazas_maximas' => fake()->numberBetween(15, 25), // Plazas entre 15 y 25
⋮----
/**
     * Indica que el curso debe tener fechas en el pasado (finalizado).
     *
     * @return \Illuminate\Database\Eloquent\Factories\Factory
     */
public function finalizado()
⋮----
return $this->state(function (array $attributes) {
// Generar fechas de inicio y fin que estén en el pasado
$fechaFinPasada = Carbon::instance(fake()->dateTimeBetween('-1 year', '-1 week')); // Fecha fin entre hace 1 año y hace 1 semana
$duracionDias = fake()->numberBetween(30, 180);
$fechaInicioPasada = $fechaFinPasada->copy()->subDays($duracionDias); // Restar días para obtener inicio
⋮----
'fecha_inicio' => $fechaInicioPasada->format('Y-m-d'),
'fecha_fin' => $fechaFinPasada->format('Y-m-d'),
```

## File: database/factories/PreinscritoSepeFactory.php
```php
namespace Database\Factories;
use App\Models\PreinscritoSepe; // Verifica la ruta del modelo
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;
class PreinscritoSepeFactory extends Factory
⋮----
protected $model = PreinscritoSepe::class;
public function definition(): array
⋮----
$estadosPreinscrito = ['Pendiente', 'Contactado', 'Interesado', 'No Interesado', 'Convertido']; // Ajusta tus estados
⋮----
'nombre' => fake()->firstName(),
'apellido1' => fake()->lastName(),
'apellido2' => fake()->optional(0.7)->lastName(),
'dni' => fake()->unique()->numerify('########') . fake()->randomLetter(),
'fecha_nacimiento' => fake()->dateTimeBetween('-60 years', '-16 years')->format('Y-m-d'),
'telefono' => fake()->boolean(90) ? fake()->unique()->numerify('6########') : null,
'email' => fake()->boolean(80) ? fake()->unique()->safeEmail() : null,
'direccion' => fake()->boolean(70) ? fake()->streetAddress() : null,
'localidad' => fake()->city(),
'provincia' => fake()->state(), // O usa una lista de provincias españolas
'cp' => fake()->boolean(80) ? fake()->postcode() : null,
'nacionalidad' => fake()->randomElement(['Española', 'Comunitaria', 'Extracomunitaria', 'Otra']),
'situacion_laboral' => fake()->randomElement($situacion),
'nivel_formativo' => fake()->randomElement($nivel),
'fecha_importacion' => fake()->dateTimeThisYear(), // O now() si quieres que siempre sea la fecha actual
'estado' => fake()->randomElement($estadosPreinscrito), // Asegúrate que el campo 'estado' existe en tu $fillable del modelo
```

## File: database/factories/ProfesorFactory.php
```php
namespace Database\Factories;
use App\Models\Profesor; // Asegúrate que la ruta a tu modelo es correcta
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str; // Para el DNI de ejemplo
/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Profesor>
 */
class ProfesorFactory extends Factory
⋮----
/**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
protected $model = Profesor::class; // Especifica el modelo aquí también si es necesario
/**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
public function definition(): array
⋮----
// Lista de titulaciones y especialidades de ejemplo
⋮----
// Generar sexo para usar nombres apropiados
$sexo = fake()->randomElement(['Hombre', 'Mujer']);
$nombre = ($sexo === 'Hombre') ? fake()->firstNameMale() : fake()->firstNameFemale();
⋮----
'apellido1' => fake()->lastName(),
'apellido2' => fake()->optional(0.7)->lastName(), // 70% de probabilidad de tener segundo apellido
// DNI: formato realista (8 números + letra), pero letra aleatoria (no calculada)
// unique() asegura que no se repitan DNI en esta ejecución del seeder
'dni' => fake()->unique()->numerify('########') . fake()->randomLetter(),
// NUSS: formato realista, pero números aleatorios
'num_seguridad_social' => fake()->unique()->numerify('##/########/##'),
// Fecha de nacimiento para edades entre 28 y 65 años
'fecha_nacimiento' => fake()->dateTimeBetween('-65 years', '-28 years')->format('Y-m-d'),
⋮----
'direccion' => fake()->streetAddress(),
// Teléfono móvil español realista
'telefono' => fake()->unique()->numerify('6########'), // Empieza por 6
// Email único basado en nombre/apellido
'email' => fake()->unique()->safeEmail(),
'titulacion_academica' => fake()->randomElement($titulaciones),
'especialidad' => fake()->randomElement($especialidades),
// created_at y updated_at son manejados automáticamente por Eloquent
```

## File: database/factories/UserFactory.php
```php
namespace Database\Factories;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\User>
 */
class UserFactory extends Factory
⋮----
/**
     * The current password being used by the factory.
     */
protected static ?string $password;
/**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
public function definition(): array
⋮----
'name' => fake()->name(),
'email' => fake()->unique()->safeEmail(),
⋮----
'password' => static::$password ??= Hash::make('password'),
'remember_token' => Str::random(10),
⋮----
/**
     * Indicate that the model's email address should be unverified.
     */
public function unverified(): static
⋮----
return $this->state(fn (array $attributes) => [
```

## File: database/migrations/0001_01_01_000000_create_users_table.php
```php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
⋮----
/**
     * Run the migrations.
     */
public function up(): void
⋮----
Schema::create('users', function (Blueprint $table) {
$table->id();
$table->string('name');
$table->string('email')->unique();
$table->timestamp('email_verified_at')->nullable();
$table->string('password');
$table->rememberToken();
$table->timestamps();
⋮----
Schema::create('password_reset_tokens', function (Blueprint $table) {
$table->string('email')->primary();
$table->string('token');
$table->timestamp('created_at')->nullable();
⋮----
Schema::create('sessions', function (Blueprint $table) {
$table->string('id')->primary();
$table->foreignId('user_id')->nullable()->index();
$table->string('ip_address', 45)->nullable();
$table->text('user_agent')->nullable();
$table->longText('payload');
$table->integer('last_activity')->index();
⋮----
/**
     * Reverse the migrations.
     */
public function down(): void
⋮----
Schema::dropIfExists('users');
Schema::dropIfExists('password_reset_tokens');
Schema::dropIfExists('sessions');
```

## File: database/migrations/0001_01_01_000001_create_cache_table.php
```php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
⋮----
/**
     * Run the migrations.
     */
public function up(): void
⋮----
Schema::create('cache', function (Blueprint $table) {
$table->string('key')->primary();
$table->mediumText('value');
$table->integer('expiration');
⋮----
Schema::create('cache_locks', function (Blueprint $table) {
⋮----
$table->string('owner');
⋮----
/**
     * Reverse the migrations.
     */
public function down(): void
⋮----
Schema::dropIfExists('cache');
Schema::dropIfExists('cache_locks');
```

## File: database/migrations/0001_01_01_000002_create_jobs_table.php
```php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
⋮----
/**
     * Run the migrations.
     */
public function up(): void
⋮----
Schema::create('jobs', function (Blueprint $table) {
$table->id();
$table->string('queue')->index();
$table->longText('payload');
$table->unsignedTinyInteger('attempts');
$table->unsignedInteger('reserved_at')->nullable();
$table->unsignedInteger('available_at');
$table->unsignedInteger('created_at');
⋮----
Schema::create('job_batches', function (Blueprint $table) {
$table->string('id')->primary();
$table->string('name');
$table->integer('total_jobs');
$table->integer('pending_jobs');
$table->integer('failed_jobs');
$table->longText('failed_job_ids');
$table->mediumText('options')->nullable();
$table->integer('cancelled_at')->nullable();
$table->integer('created_at');
$table->integer('finished_at')->nullable();
⋮----
Schema::create('failed_jobs', function (Blueprint $table) {
⋮----
$table->string('uuid')->unique();
$table->text('connection');
$table->text('queue');
⋮----
$table->longText('exception');
$table->timestamp('failed_at')->useCurrent();
⋮----
/**
     * Reverse the migrations.
     */
public function down(): void
⋮----
Schema::dropIfExists('jobs');
Schema::dropIfExists('job_batches');
Schema::dropIfExists('failed_jobs');
```

## File: database/migrations/2025_04_19_203310_create_profesores_table.php
```php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
⋮----
/**
     * Run the migrations.
     */
public function up()
⋮----
Schema::create('profesores', function (Blueprint $table) {
$table->id();
$table->string('nombre', 100);
$table->string('apellido1', 100);
$table->string('apellido2', 100)->nullable();
$table->string('dni', 15)->unique();
$table->string('num_seguridad_social', 20)->nullable();
$table->date('fecha_nacimiento')->nullable();
$table->string('sexo', 10)->nullable();
$table->text('direccion')->nullable();
$table->string('telefono', 20)->nullable();
$table->string('email', 100)->nullable();
$table->string('titulacion_academica', 150)->nullable();
$table->string('especialidad', 100)->nullable();
$table->timestamps();
⋮----
/**
     * Reverse the migrations.
     */
public function down(): void
⋮----
Schema::dropIfExists('profesores');
```

## File: database/migrations/2025_04_19_203323_create_alumnos_table.php
```php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
⋮----
/**
     * Run the migrations.
     */
public function up()
⋮----
Schema::create('alumnos', function (Blueprint $table) {
$table->id();
$table->string('nombre', 100);
$table->string('apellido1', 100);
$table->string('apellido2', 100)->nullable();
$table->string('dni', 15)->unique();
$table->string('num_seguridad_social', 20)->nullable();
$table->date('fecha_nacimiento');
$table->string('sexo', 10)->nullable();
$table->text('direccion')->nullable();
$table->string('cp', 10)->nullable();
$table->string('localidad', 100)->nullable();
$table->string('provincia', 100)->nullable();
$table->string('telefono', 20)->nullable();
$table->string('email', 100)->nullable();
$table->string('nacionalidad', 50)->nullable();
$table->string('situacion_laboral', 100)->nullable();
$table->string('nivel_formativo', 100)->nullable();
$table->timestamps();
⋮----
/**
     * Reverse the migrations.
     */
public function down(): void
⋮----
Schema::dropIfExists('alumnos');
```

## File: database/migrations/2025_04_19_203334_create_cursos_table.php
```php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
⋮----
/**
     * Run the migrations.
     */
public function up()
⋮----
Schema::create('cursos', function (Blueprint $table) {
$table->id();
$table->string('nombre', 255);
$table->string('codigo', 20)->nullable();
$table->text('descripcion')->nullable();
$table->string('modalidad', 50)->nullable();
$table->string('nivel', 50)->nullable();
$table->text('requisitos')->nullable();
$table->date('fecha_inicio')->nullable();
$table->date('fecha_fin')->nullable();
$table->integer('horas_totales')->nullable();
$table->string('horario', 100)->nullable();
$table->string('centros', 255)->nullable();
$table->integer('plazas_maximas')->default(20);
// --- ÚNICA Y CORRECTA DEFINICIÓN PARA PROFESOR_ID ---
$table->foreignId('profesor_id')
->nullable() // O quita nullable si es obligatorio
->constrained('profesores') // Especifica la tabla a la que hace referencia
->nullOnDelete(); // O tu política preferida en eliminación
$table->timestamps();
⋮----
/**
     * Reverse the migrations.
     */
public function down(): void
⋮----
Schema::dropIfExists('cursos');
```

## File: database/migrations/2025_04_19_203344_create_alumno_curso_table.php
```php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
⋮----
/**
     * Run the migrations.
     */
public function up()
⋮----
Schema::create('alumno_curso', function (Blueprint $table) {
$table->id();
$table->foreignId('alumno_id')->constrained('alumnos');
$table->foreignId('curso_id')->constrained('cursos');
$table->date('fecha_inscripcion')->default(now());
$table->decimal('nota', 4, 2)->nullable();
$table->string('estado', 50)->nullable();
$table->unique(['alumno_id', 'curso_id']);
$table->timestamps();
⋮----
/**
     * Reverse the migrations.
     */
public function down(): void
⋮----
Schema::dropIfExists('alumno_curso');
```

## File: database/migrations/2025_04_19_203353_create_preinscritos_sepe_table.php
```php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
⋮----
/**
     * Run the migrations.
     */
public function up()
⋮----
Schema::create('preinscritos_sepe', function (Blueprint $table) {
$table->id();
$table->string('nombre', 100)->nullable();
$table->string('apellido1', 100)->nullable();
$table->string('apellido2', 100)->nullable();
$table->string('dni', 15)->nullable();
$table->date('fecha_nacimiento')->nullable();
$table->string('telefono', 20)->nullable();
$table->string('email', 100)->nullable();
$table->text('direccion')->nullable();
$table->string('localidad', 100)->nullable();
$table->string('provincia', 100)->nullable();
$table->string('cp', 10)->nullable();
$table->string('nacionalidad', 50)->nullable();
$table->string('situacion_laboral', 100)->nullable();
$table->string('nivel_formativo', 100)->nullable();
$table->timestamp('fecha_importacion')->useCurrent();
$table->timestamps();
⋮----
/**
     * Reverse the migrations.
     */
public function down(): void
⋮----
Schema::dropIfExists('preinscritos_sepe');
```

## File: database/migrations/2025_05_17_213845_add_estado_to_alumnos_table.php
```php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
⋮----
/**
     * Run the migrations.
     */
public function up(): void
⋮----
// En el método up() de la nueva migración
Schema::table('alumnos', function (Blueprint $table) {
$table->string('estado')->nullable()->after('nivel_formativo'); // O después de la columna que prefieras
// Podrías poner un default: ->default('Activo');
⋮----
/**
     * Reverse the migrations.
     */
public function down(): void
⋮----
// En el método down()
⋮----
$table->dropColumn('estado');
```

## File: database/migrations/2025_06_03_124951_add_estado_to_preinscritos_sepe_table.php
```php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
⋮----
/**
     * Run the migrations.
     */
public function up(): void
⋮----
Schema::table('preinscritos_sepe', function (Blueprint $table) {
$table->string('estado')->nullable()->after('nivel_formativo');
⋮----
/**
     * Reverse the migrations.
     */
public function down(): void
⋮----
$table->dropColumn('estado');
```

## File: database/migrations/2025_06_04_123326_add_num_seguridad_social_to_preinscritos_sepe_table.php
```php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
⋮----
public function up()
⋮----
Schema::table('preinscritos_sepe', function (Blueprint $table) {
$table->string('num_seguridad_social', 20)->nullable();
⋮----
public function down()
⋮----
$table->dropColumn('num_seguridad_social');
```

## File: database/migrations/2025_06_04_170305_add_sexo_to_preinscritos_sepe_table.php
```php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
⋮----
public function up()
⋮----
Schema::table('preinscritos_sepe', function (Blueprint $table) {
$table->string('sexo', 20)->nullable();
⋮----
public function down()
⋮----
$table->dropColumn('sexo');
```

## File: database/migrations/2025_06_15_193251_create_time_slots_table.php
```php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
⋮----
/**
     * Run the migrations.
     */
public function up(): void
⋮----
Schema::create('time_slots', function (Blueprint $table) {
// Clave primaria
$table->id();
// Día de la semana (0 = domingo, 6 = sábado)
$table->tinyInteger('weekday');
// Hora de inicio y de fin
$table->time('start_time');
$table->time('end_time');
// Aula en la que se imparte la clase
$table->string('room', 50);
// Marcas de tiempo (created_at, updated_at)
$table->timestamps();
// Índice compuesto para búsquedas rápidas por día, hora y aula
$table->index(['weekday', 'start_time', 'room']);
⋮----
/**
     * Reverse the migrations.
     */
public function down(): void
⋮----
Schema::dropIfExists('time_slots');
```

## File: database/migrations/2025_06_15_193659_create_schedules_table.php
```php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
⋮----
/**
     * Run the migrations.
     */
public function up(): void
⋮----
Schema::create('schedules', function (Blueprint $table) {
$table->id();
// Relación con el curso
$table->foreignId('curso_id')
->constrained('cursos')
->onDelete('cascade');
// Columnas para los detalles del horario
$table->tinyInteger('dia_semana'); // 1=Lunes, 2=Martes...
$table->time('hora_inicio');
$table->time('hora_fin');
$table->string('aula')->nullable();
// Relación opcional con un profesor específico para esta franja
$table->foreignId('profesor_id')
->nullable()
->constrained('profesores')
->onDelete('set null');
// Timestamps (created_at y updated_at)
$table->timestamps();
⋮----
/**
     * Reverse the migrations.
     */
public function down(): void
⋮----
Schema::dropIfExists('schedules');
```

## File: database/seeders/AlumnoCursoSeeder.php
```php
namespace Database\Seeders;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Alumno;
use App\Models\Curso;
use App\Models\AlumnoCurso;
use Illuminate\Support\Facades\DB; // Para consultas eficientes
use Carbon\Carbon;                 // Para manipulación de fechas
class AlumnoCursoSeeder extends Seeder
⋮----
/**
     * Ejecuta los seeds para la tabla alumno_curso.
     * Intenta asignar cursos a alumnos de forma aleatoria,
     * respetando las plazas máximas y evitando duplicados.
     */
public function run(): void
⋮----
$this->command->info("----------------------------------------");
$this->command->info("Iniciando Seeder: Asignando cursos a alumnos...");
⋮----
// 1. Obtener los IDs de los alumnos existentes
$alumnosIds = Alumno::pluck('id');
// 2. Obtener los cursos existentes con los datos necesarios
// Usamos all() para asegurar que tenemos los objetos completos, luego indexamos por ID.
$cursos = Curso::all()->keyBy('id');
// 3. Verificar si hay datos suficientes para continuar
if ($alumnosIds->isEmpty() || $cursos->isEmpty()) {
$this->command->warn("-> No se pueden crear inscripciones. Asegúrate de que existen alumnos y cursos creados por los seeders anteriores.");
⋮----
$this->command->line("-> Encontrados " . $alumnosIds->count() . " alumnos y " . $cursos->count() . " cursos.");
// 4. Preparar datos para validaciones y batch insert
// Array para guardar las nuevas inscripciones a insertar
⋮----
// Mapa para buscar rápidamente inscripciones existentes (evitar violación UNIQUE)
// Clave: "alumnoId-cursoId", Valor: true
$inscripcionesExistentesMap = AlumnoCurso::select('alumno_id', 'curso_id')->get()->mapWithKeys(function ($item) {
⋮----
$this->command->line("-> Encontradas " . $inscripcionesExistentesMap->count() . " inscripciones previas (si se ejecuta sin migrate:fresh).");
// Mapa para llevar la cuenta de inscritos actuales por curso (respetar plazas máximas)
// Clave: curso_id, Valor: numero_de_inscritos_o_pendientes
$cursosConInscritosMap = AlumnoCurso::select('curso_id', DB::raw('count(*) as total'))
->whereIn('estado', ['Inscrito', 'Pendiente']) // Solo contar los que ocupan plaza activa
->groupBy('curso_id')
->pluck('total', 'curso_id');
// 5. Definir parámetros para el proceso de asignación
⋮----
$maxInscripcionesPorAlumno = 3; // Límite de cuántos cursos intentaremos asignar a cada alumno
$this->command->info("-> Intentando asignar hasta $maxInscripcionesPorAlumno cursos por alumno...");
// 6. Iterar sobre cada alumno para intentar asignarle cursos
⋮----
// Barajar los cursos disponibles para variar las asignaciones
$cursosDisponibles = $cursos->shuffle();
// Iterar sobre los cursos barajados para este alumno
⋮----
// Si ya hemos asignado el máximo permitido a este alumno, pasamos al siguiente
⋮----
break; // Salir del bucle de cursos para este alumno
⋮----
// --- Controles de Seguridad y Lógica de Negocio ---
// a) Control EXPLÍCITO contra IDs de curso inválidos (<= 0)
⋮----
$this->command->error("-> ¡Saltando! Detectado curso_id inválido o no numérico: [" . $cursoId . "] para Alumno ID: [$alumnoId]. Revisar lógica de obtención de cursos.");
continue; // Pasar al siguiente curso
⋮----
// b) Construir clave única para verificar duplicados
⋮----
if ($inscripcionesExistentesMap->has($claveUnica)) {
// $this->command->line("-> Saltando: Alumno [$alumnoId] ya tiene registro para Curso [$cursoId]."); // Descomentar para debug detallado
continue; // Ya existe, probar siguiente curso
⋮----
// c) Verificar plazas disponibles
$inscritosActuales = $cursosConInscritosMap->get($cursoId, 0); // Obtener inscritos actuales, 0 si no hay
⋮----
// $this->command->line("-> Saltando: Curso [$cursoId] lleno (Plazas: {$curso->plazas_maximas}, Inscritos: {$inscritosActuales})."); // Descomentar para debug detallado
continue; // Curso lleno, probar siguiente curso
⋮----
// --- Preparación de Datos para la Nueva Inscripción ---
// d) Generar estado y nota aleatorios
$estado = fake()->randomElement(['Inscrito', 'Completado', 'Pendiente']);
$nota = ($estado === 'Completado') ? fake()->randomFloat(2, 4, 10) : null;
// e) Generar fecha de inscripción válida usando Carbon
⋮----
$fechaInicioCursoObj = Carbon::parse($curso->fecha_inicio);
$fechaFinCursoObj = Carbon::parse($curso->fecha_fin);
$inicioRangoInscripcion = $fechaInicioCursoObj->copy()->subMonth(); // Restar un mes de forma segura
// Asegurar que el rango sea válido
if ($inicioRangoInscripcion->greaterThan($fechaFinCursoObj)) {
⋮----
$fechaInscripcion = fake()->dateTimeBetween(
⋮----
)->format('Y-m-d');
⋮----
// Capturar posible error de parseo de fecha si los datos son incorrectos
$this->command->error("-> Error al procesar fechas para Curso ID [$cursoId]: " . $e->getMessage());
$fechaInscripcion = now()->format('Y-m-d'); // Usar fecha actual como fallback
⋮----
// f) Añadir la nueva inscripción al array para el batch insert
⋮----
'curso_id' => $cursoId,          // Usar el ID del curso actual
⋮----
'created_at' => now(),        // Necesario para ::insert()
'updated_at' => now(),        // Necesario para ::insert()
⋮----
// --- Actualizar contadores internos para las siguientes iteraciones ---
$inscripcionesExistentesMap->put($claveUnica, true);        // Marcar como "existente" para este run
$cursosConInscritosMap->put($cursoId, $inscritosActuales + 1); // Incrementar contador de inscritos para este curso
$cursosAsignadosAEsteAlumno++;                             // Incrementar contador para este alumno
$inscripcionesCreadasContador++;                           // Incrementar contador global
} // Fin loop interno (cursos)
} // Fin loop externo (alumnos)
// 7. Realizar la inserción masiva si hay inscripciones para crear
⋮----
$this->command->info("-> Preparando inserción de [$inscripcionesCreadasContador] nuevas inscripciones...");
// Usar insert() para alto rendimiento en inserciones masivas
AlumnoCurso::insert($inscripcionesACrear);
$this->command->info("-> ¡Inserción completada!");
⋮----
$this->command->info("-> No se crearon nuevas inscripciones (posiblemente ya existían o cursos llenos).");
⋮----
$this->command->info("Seeder AlumnoCursoSeeder finalizado.");
```

## File: database/seeders/AlumnoSeeder.php
```php
namespace Database\Seeders;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Alumno; // Importar modelo
class AlumnoSeeder extends Seeder
⋮----
public function run(): void
⋮----
$cantidad = 50; // Define cuántos alumnos crear
$this->command->info("Creando $cantidad alumnos de ejemplo...");
Alumno::factory()->count($cantidad)->create();
$this->command->info("¡$cantidad alumnos creados!");
```

## File: database/seeders/CursoSeeder.php
```php
namespace Database\Seeders;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Curso; // Importar modelo
class CursoSeeder extends Seeder
⋮----
public function run(): void
⋮----
$cantidad = 15; // Define cuántos cursos crear
$this->command->info("Creando $cantidad cursos de ejemplo...");
Curso::factory()->count($cantidad)->create();
$this->command->info("¡$cantidad cursos creados!");
```

## File: database/seeders/DatabaseSeeder.php
```php
namespace Database\Seeders;
use Illuminate\Database\Seeder;
class DatabaseSeeder extends Seeder
⋮----
/**
     * Seed the application's database.
     */
public function run(): void
⋮----
$this->command->info("Iniciando el proceso de Seeding...");
// Llamamos a todos los seeders en un único array, en el orden correcto de dependencias.
$this->call([
// 1. Entidades base que no dependen de otras (excepto User).
⋮----
// 2. Entidades que dependen de las anteriores.
CursoSeeder::class,          // Depende de Profesores.
// 3. Tablas pivote o de relación.
AlumnoCursoSeeder::class,    // Depende de Alumnos y Cursos.
// 4. Seeder de Horarios.
//    Este seeder ya crea los TimeSlots que necesita, por lo que no es
//    necesario llamar a TimeSlotSeeder por separado.
⋮----
$this->command->info("¡Seeding completado con éxito!");
```

## File: database/seeders/PreinscritoSepeSeeder.php
```php
namespace Database\Seeders;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\PreinscritoSepe; // Importar modelo
class PreinscritoSepeSeeder extends Seeder
⋮----
public function run(): void
⋮----
$cantidad = 25; // Define cuántos preinscritos crear
$this->command->info("Creando $cantidad preinscritos de ejemplo...");
PreinscritoSepe::factory()->count($cantidad)->create();
$this->command->info("¡$cantidad preinscritos creados!");
```

## File: database/seeders/ProfesorSeeder.php
```php
namespace Database\Seeders;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Profesor; // Importa tu modelo Profesor
class ProfesorSeeder extends Seeder
⋮----
/**
     * Run the database seeds.
     */
public function run(): void
⋮----
// Mensaje informativo (opcional)
$this->command->info('Creando 12 profesores de ejemplo...');
// Usar el Factory para crear 12 registros de Profesor
Profesor::factory()->count(12)->create();
$this->command->info('¡12 profesores creados!');
```

## File: database/seeders/ScheduleSeeder.php
```php
namespace Database\Seeders;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Curso;
use App\Models\Profesor;
use App\Models\Schedule;
class ScheduleSeeder extends Seeder
⋮----
/**
     * Run the database seeds.
     */
public function run(): void
⋮----
$this->command->info('----------------------------------------');
$this->command->info('Iniciando Seeder: Creando horarios de prueba...');
⋮----
// Limpiamos la tabla para evitar duplicados en ejecuciones repetidas
Schedule::truncate();
// Obtenemos todos los cursos y profesores para no consultar en cada iteración
$cursos = Curso::all();
$profesores = Profesor::all();
if ($cursos->isEmpty() || $profesores->isEmpty()) {
$this->command->error('No se pueden crear horarios porque no hay cursos o profesores. Ejecuta los otros seeders primero.');
⋮----
$dias = [1, 2, 3, 4, 5]; // Lunes a Viernes
⋮----
$cursoAleatorio = $cursos->random();
⋮----
Schedule::create([
⋮----
'profesor_id' => $profesores->random()->id,
⋮----
'hora_fin' => date('H:i:s', strtotime($horaInicioAleatoria . ' +2 hours')), // Duración de 2 horas
⋮----
$this->command->info('¡20 franjas horarias creadas con éxito!');
⋮----
$this->command->info('Seeder de Horarios finalizado.');
```

## File: database/seeders/TimeSlotSeeder.php
```php
namespace Database\Seeders;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
class TimeSlotSeeder extends Seeder
⋮----
/**
     * Run the database seeds.
     */
public function run(): void
⋮----
/*
     * PROPÓSITO
     * Generar 6 días (lunes-sábado) × 8 franjas de 2 horas (09-11, 11-13…)
     * Aula fija “Aula 101” para el ejemplo.
     */
// Array con horas de inicio
⋮----
foreach (range(1, 6) as $weekday) {               // 1 = lunes, 6 = sábado
⋮----
$end = \Carbon\Carbon::parse($start)->addHours(2)->format('H:i');
\App\Models\TimeSlot::updateOrCreate(
```

## File: database/seeders/UserSeeder.php
```php
namespace Database\Seeders;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\User; // Importar User
use Illuminate\Support\Facades\Hash; // Importar Hash
class UserSeeder extends Seeder
⋮----
/**
     * Run the database seeds.
     */
public function run(): void
⋮----
$this->command->info('Creando/verificando usuario administrador...');
User::firstOrCreate(
['email' => 'admin@admin.com'], // El email que quieres
⋮----
'name' => 'Admin Principal', // El nombre que quieres
'password' => Hash::make('admin'), // La contraseña que quieres (hasheada)
'email_verified_at' => now() // Marcar como verificado
⋮----
$this->command->info('Usuario admin@admin.com procesado.');
// Opcional: Crear otros usuarios de prueba con factory
// User::factory()->count(10)->create();
```

## File: database/.gitignore
```
*.sqlite*
```

## File: public/.htaccess
```
<IfModule mod_rewrite.c>
    <IfModule mod_negotiation.c>
        Options -MultiViews -Indexes
    </IfModule>

    RewriteEngine On

    # Handle Authorization Header
    RewriteCond %{HTTP:Authorization} .
    RewriteRule .* - [E=HTTP_AUTHORIZATION:%{HTTP:Authorization}]

    # Handle X-XSRF-Token Header
    RewriteCond %{HTTP:x-xsrf-token} .
    RewriteRule .* - [E=HTTP_X_XSRF_TOKEN:%{HTTP:X-XSRF-Token}]

    # Redirect Trailing Slashes If Not A Folder...
    RewriteCond %{REQUEST_FILENAME} !-d
    RewriteCond %{REQUEST_URI} (.+)/$
    RewriteRule ^ %1 [L,R=301]

    # Send Requests To Front Controller...
    RewriteCond %{REQUEST_FILENAME} !-d
    RewriteCond %{REQUEST_FILENAME} !-f
    RewriteRule ^ index.php [L]
</IfModule>
```

## File: public/index.php
```php
use Illuminate\Foundation\Application;
use Illuminate\Http\Request;
// die('SI VES ESTE MENSAJE, EL VOLUMEN DE DOCKER FUNCIONA.');
⋮----
// Determine if the application is in maintenance mode...
⋮----
// Register the Composer autoloader...
⋮----
// Bootstrap Laravel and handle the request...
/** @var Application $app */
⋮----
$app->handleRequest(Request::capture());
```

## File: public/robots.txt
```
User-agent: *
Disallow:
```

## File: resources/css/admin.css
```css
body {
⋮----
background-color: #f4f7f6; /* Un gris muy claro, similar al de la imagen */
⋮----
overflow-x: hidden; /* Evitar scroll horizontal innecesario */
⋮----
.admin-layout-wrapper { /* Nuevo div contenedor */
.sidebar {
⋮----
width: 260px; /* Ancho de la sidebar de referencia */
background-color: #ffffff; /* Fondo blanco */
border-right: 1px solid #e5e7eb; /* Borde sutil (Tailwind gray-200) */
⋮----
.sidebar-header {
⋮----
padding: 1.5rem 1.25rem; /* py-6 px-5 */
⋮----
.sidebar-header .app-name {
⋮----
font-size: 1.125rem; /* text-lg */
font-weight: 600; /* font-semibold */
color: #1f2937; /* Tailwind gray-800 */
⋮----
.sidebar-header .app-subtitle {
⋮----
font-size: 0.75rem; /* text-xs */
color: #6b7280; /* Tailwind gray-500 */
⋮----
.sidebar-nav {
⋮----
padding-top: 1rem; /* pt-4 */
⋮----
.sidebar-nav .nav-link {
⋮----
padding: 0.75rem 1.25rem; /* py-3 px-5 */
font-size: 0.875rem; /* text-sm */
font-weight: 500; /* font-medium */
color: #4b5563; /* Tailwind gray-600 */
border-radius: 0.375rem; /* rounded-md */
margin: 0 0.75rem 0.25rem 0.75rem; /* mx-3 mb-1 */
⋮----
.sidebar-nav .nav-link:hover {
⋮----
background-color: #f3f4f6; /* Tailwind gray-100 */
⋮----
.sidebar-nav .nav-link.active {
⋮----
background-color: #e0e7ff; /* Tailwind indigo-100 (un azul claro) */
color: #4338ca; /* Tailwind indigo-700 */
⋮----
.sidebar-nav .nav-link .bi {
⋮----
margin-right: 0.75rem; /* mr-3 */
⋮----
width: 20px; /* Para alinear bien */
⋮----
.main-content {
⋮----
padding: 1.5rem; /* p-6 */
/* margin-left ya no es necesario con flexbox en el wrapper */
⋮----
.content-header {
⋮----
background-color: #ffffff; /* Fondo blanco para el header */
padding: 1rem 1.5rem; /* py-4 px-6 */
border-radius: 0.5rem; /* rounded-lg */
box-shadow: 0 1px 3px 0 rgba(0, 0, 0, 0.1), 0 1px 2px -1px rgba(0, 0, 0, 0.1); /* shadow-md */
margin-bottom: 1.5rem; /* mb-6 */
⋮----
/* Ajustes para responsive (ocultar sidebar en móvil, etc.) */
⋮----
.admin-layout-wrapper {
⋮----
/* No se necesita margin-left: 0; aquí */
⋮----
/* Podrías añadir un botón para mostrar/ocultar la sidebar en móvil */
⋮----
/* resources/css/app.css o admin.css */
.form-input {
.form-select {
.form-input-error {
/* ... otras clases de botones si no las tienes globales ... */
.btn-indigo-tailwind {
.btn-secondary-tailwind {
```

## File: resources/css/app.css
```css
/* resources/css/app.css */
/* Importar estilos personalizados ANTES de Tailwind */
/* Aunque parezca contraintuitivo, Tailwind podrá sobrescribir esto si es necesario */
/* debido a la especificidad o a las capas (@layer) si se usan. */
@import "dashboard-admin.css"; /* <-- AÑADE ESTA LÍNEA */
/* @import "welcome.css"; */
/* Directivas de Tailwind */
@tailwind base;
@tailwind components;
@tailwind utilities;
/* Aquí puedes añadir más CSS personalizado si quieres */
/* Asegurar que el body y html ocupen todo el alto */
html, body {
/* Centrar verticalmente el contenido */
.min-h-screen {
```

## File: resources/css/dashboard-admin.css
```css
/* Sidebar */
#sidebarMenu {
#sidebarMenu .nav-link {
#sidebarMenu .nav-link.active,
#sidebarMenu .nav-link i {
/* Estilos generales para las tarjetas del dashboard */
/*.card {
    border-radius: 1rem;
    border: none;  
    box-shadow: 0 0.5rem 1rem rgba(0, 0, 0, 0.05);  
}*/
/*.card-header {
    border-bottom: 1px solid #f1f1f1;
    background: #fff;
    font-weight: 600; 
    padding: 0.75rem 1.25rem;  
}*/
/* Estilos para las tarjetas de resumen (KPIs) */
.d-flex i {
⋮----
/* Asegurar que los iconos tengan un tamaño consistente si Bootstrap no lo hace */
/* font-size: 2rem; */ /* Ya tienes fs-2, esto es un ejemplo si necesitaras override */
line-height: 1; /* Mejor alineación vertical */
⋮----
.card-title {
⋮----
font-size: 0.9rem; /* Título de tarjeta un poco más pequeño */
color: #6c757d; /* Color grisáceo */
⋮----
.fs-4.fw-bold {
⋮----
color: #343a40; /* Color oscuro para el número */
⋮----
/* Estilos para los contenedores de gráficos */
#asistenciaChart, #generoChart {
⋮----
max-height: 280px; /* Limitar altura máxima de los gráficos */
```

## File: resources/css/login.css
```css
body, html {
#particles-js {
.form-container {
.input-group {
.input-icon {
.input-field {
.input-field:focus {
.input-label {
.login-btn {
.login-btn:hover {
.login-btn:active {
.forgot-link {
.forgot-link:hover {
.checkbox-custom {
.logo-image {
.content-wrapper {
.footer-icons a {
.footer-icons a:hover {
.footer-text {
.footer-text a {
.footer-text a:hover {
```

## File: resources/js/app.js
```javascript
//import '@fullcalendar/core/main.css';
import '../css/admin.css'; // Ajusta la ruta si es diferente
⋮----
Alpine.start();
```

## File: resources/js/bootstrap.js
```javascript
// Ejemplo: Inicializar todos los tooltips manualmente
const tooltipTriggerList = document.querySelectorAll('[data-bs-toggle="tooltip"]')
const tooltipList = [...tooltipTriggerList].map(tooltipTriggerEl => new bootstrap.Tooltip(tooltipTriggerEl))
```

## File: resources/js/particles-config.js
```javascript
// Particles.js configuration
export function initParticles() {
if (document.getElementById('particles-js')) {
particlesJS('particles-js', {
⋮----
// Para inicializar automáticamente
document.addEventListener('DOMContentLoaded', initParticles);
```

## File: resources/js/schedules.js
```javascript
document.addEventListener('DOMContentLoaded', function() {
var calendarEl = document.getElementById('calendar');
var calendar = new Calendar(calendarEl, {
⋮----
const titleEl = info.el.querySelector('.fc-event-title');
⋮----
titleEl.insertAdjacentHTML('afterend', extraContent);
⋮----
calendar.render();
```

## File: resources/views/admin/alumnos/create.blade.php
```php

```

## File: resources/views/admin/alumnos/edit.blade.php
```php

```

## File: resources/views/admin/alumnos/index.blade.php
```php

```

## File: resources/views/admin/alumnos/show.blade.php
```php

```

## File: resources/views/admin/cursos/create.blade.php
```php

```

## File: resources/views/admin/cursos/edit.blade.php
```php

```

## File: resources/views/admin/cursos/index.blade.php
```php

```

## File: resources/views/admin/cursos/show.blade.php
```php

```

## File: resources/views/admin/preinscritos/create.blade.php
```php

```

## File: resources/views/admin/preinscritos/edit.blade.php
```php

```

## File: resources/views/admin/preinscritos/index_error_placeholder.blade.php
```php

```

## File: resources/views/admin/preinscritos/index.blade.php
```php

```

## File: resources/views/admin/preinscritos/show.blade.php
```php

```

## File: resources/views/admin/profesores/create.blade.php
```php

```

## File: resources/views/admin/profesores/edit.blade.php
```php

```

## File: resources/views/admin/profesores/index.blade.php
```php

```

## File: resources/views/admin/profesores/show.blade.php
```php

```

## File: resources/views/admin/schedules/create.blade.php
```php

```

## File: resources/views/admin/schedules/edit.blade.php
```php

```

## File: resources/views/admin/schedules/index.blade.php
```php

```

## File: resources/views/admin/dashboard.blade.php
```php

```

## File: resources/views/auth/confirm-password.blade.php
```php

```

## File: resources/views/auth/forgot-password.blade.php
```php

```

## File: resources/views/auth/login.blade.php
```php

```

## File: resources/views/auth/register.blade.php
```php

```

## File: resources/views/auth/reset-password.blade.php
```php

```

## File: resources/views/auth/verify-email.blade.php
```php

```

## File: resources/views/components/application-logo.blade.php
```php

```

## File: resources/views/components/auth-session-status.blade.php
```php

```

## File: resources/views/components/convert-modal.blade.php
```php

```

## File: resources/views/components/danger-button.blade.php
```php

```

## File: resources/views/components/delete-modal.blade.php
```php

```

## File: resources/views/components/desinscribir-modal.blade.php
```php

```

## File: resources/views/components/dropdown-link.blade.php
```php

```

## File: resources/views/components/dropdown.blade.php
```php

```

## File: resources/views/components/input-error.blade.php
```php

```

## File: resources/views/components/input-label.blade.php
```php

```

## File: resources/views/components/modal.blade.php
```php

```

## File: resources/views/components/nav-link.blade.php
```php

```

## File: resources/views/components/primary-button.blade.php
```php

```

## File: resources/views/components/responsive-nav-link.blade.php
```php

```

## File: resources/views/components/secondary-button.blade.php
```php

```

## File: resources/views/components/text-input.blade.php
```php

```

## File: resources/views/layouts/admin.blade.php
```php

```

## File: resources/views/layouts/app.blade.php
```php

```

## File: resources/views/layouts/guest.blade.php
```php

```

## File: resources/views/layouts/navigation.blade.php
```php

```

## File: resources/views/profile/partials/delete-user-form.blade.php
```php

```

## File: resources/views/profile/partials/update-password-form.blade.php
```php

```

## File: resources/views/profile/partials/update-profile-information-form.blade.php
```php

```

## File: resources/views/profile/edit.blade.php
```php

```

## File: resources/views/vendor/pagination/bootstrap-4.blade.php
```php

```

## File: resources/views/vendor/pagination/bootstrap-5.blade.php
```php

```

## File: resources/views/vendor/pagination/default.blade.php
```php

```

## File: resources/views/vendor/pagination/semantic-ui.blade.php
```php

```

## File: resources/views/vendor/pagination/simple-bootstrap-4.blade.php
```php

```

## File: resources/views/vendor/pagination/simple-bootstrap-5.blade.php
```php

```

## File: resources/views/vendor/pagination/simple-default.blade.php
```php

```

## File: resources/views/vendor/pagination/simple-tailwind.blade.php
```php

```

## File: resources/views/vendor/pagination/tailwind.blade.php
```php

```

## File: resources/views/welcome.blade.php
```php

```

## File: routes/auth.php
```php
use App\Http\Controllers\Auth\AuthenticatedSessionController;
use App\Http\Controllers\Auth\ConfirmablePasswordController;
use App\Http\Controllers\Auth\EmailVerificationNotificationController;
use App\Http\Controllers\Auth\EmailVerificationPromptController;
use App\Http\Controllers\Auth\NewPasswordController;
use App\Http\Controllers\Auth\PasswordController;
use App\Http\Controllers\Auth\PasswordResetLinkController;
use App\Http\Controllers\Auth\RegisteredUserController;
use App\Http\Controllers\Auth\VerifyEmailController;
use Illuminate\Support\Facades\Route;
Route::middleware('guest')->group(function () {
Route::get('register', [RegisteredUserController::class, 'create'])
->name('register');
Route::post('register', [RegisteredUserController::class, 'store']);
Route::get('login', [AuthenticatedSessionController::class, 'create'])
->name('login');
Route::post('login', [AuthenticatedSessionController::class, 'store']);
Route::get('forgot-password', [PasswordResetLinkController::class, 'create'])
->name('password.request');
Route::post('forgot-password', [PasswordResetLinkController::class, 'store'])
->name('password.email');
Route::get('reset-password/{token}', [NewPasswordController::class, 'create'])
->name('password.reset');
Route::post('reset-password', [NewPasswordController::class, 'store'])
->name('password.store');
⋮----
Route::middleware('auth')->group(function () {
Route::get('verify-email', EmailVerificationPromptController::class)
->name('verification.notice');
Route::get('verify-email/{id}/{hash}', VerifyEmailController::class)
->middleware(['signed', 'throttle:6,1'])
->name('verification.verify');
Route::post('email/verification-notification', [EmailVerificationNotificationController::class, 'store'])
->middleware('throttle:6,1')
->name('verification.send');
Route::get('confirm-password', [ConfirmablePasswordController::class, 'show'])
->name('password.confirm');
Route::post('confirm-password', [ConfirmablePasswordController::class, 'store']);
Route::put('password', [PasswordController::class, 'update'])->name('password.update');
Route::post('logout', [AuthenticatedSessionController::class, 'destroy'])
->name('logout');
```

## File: routes/console.php
```php
use Illuminate\Foundation\Inspiring;
use Illuminate\Support\Facades\Artisan;
Artisan::command('inspire', function () {
$this->comment(Inspiring::quote());
})->purpose('Display an inspiring quote');
```

## File: routes/web.php
```php
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
// --- Controladores Estándar (ej: Breeze / Perfil) ---
use App\Http\Controllers\ProfileController;
// --- Controladores del Panel de Administración ---
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\CursoController;
use App\Http\Controllers\Admin\AlumnoController;
use App\Http\Controllers\Admin\ProfesorController;
use App\Http\Controllers\Admin\EventoController;
use App\Http\Controllers\Admin\PreinscritoSepeController; // Asegúrate que el nombre es exacto
use App\Http\Controllers\Admin\ScheduleController;   // ← IMPORTANTE
/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
*/
// --- Ruta de Bienvenida Pública ---
Route::get('/', function () {
// Si un usuario autenticado va a la raíz, redirigirlo al admin dashboard (o a su dashboard de usuario si tuvieras uno)
if (Auth::check()) {
return redirect()->route('admin.dashboard'); // Asumiendo que todos los logueados van al admin
⋮----
})->name('welcome');
// --- Rutas de Autenticación (Login, Registro, Logout, etc.) ---
// Esta línea carga las rutas definidas en routes/auth.php (generado por Breeze)
⋮----
// --- Rutas que Requieren Autenticación ---
Route::middleware(['auth', 'verified'])->group(function () {
// --- Rutas de Perfil de Usuario ---
Route::prefix('profile')->name('profile.')->group(function () {
Route::get('/', [ProfileController::class, 'edit'])->name('edit');
Route::patch('/', [ProfileController::class, 'update'])->name('update');
Route::delete('/', [ProfileController::class, 'destroy'])->name('destroy');
⋮----
// --- Grupo para Rutas Específicas de Administración ---
Route::prefix('admin')
->name('admin.')
->middleware(['auth', 'verified'])
// Si quieres un middleware de autorización específico para admin (basado en roles/permisos),
// lo añadirías aquí además del 'auth' y 'verified' del grupo padre.
// Ejemplo: ->middleware(['can:access-admin-panel'])
->group(function () {
// Dashboard de Administración
Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
// Recursos CRUD para Administración
Route::resource('profesores', ProfesorController::class);
Route::resource('alumnos', AlumnoController::class);
Route::resource('cursos', CursoController::class);
Route::resource('eventos', EventoController::class);
Route::resource('preinscritos', PreinscritoSepeController::class); // Asegúrate que este controlador existe
Route::resource('schedules', ScheduleController::class);
// --- AÑADE ESTA LÍNEA PARA EL CALENDARIO ---
Route::get('schedule', [\App\Http\Controllers\Admin\ScheduleController::class, 'index'])->name('schedule.index');
Route::get('schedule/events', [\App\Http\Controllers\Admin\ScheduleController::class, 'fetchEvents'])->name('schedule.events');
// Ruta para convertir preinscrito
Route::post('/preinscritos/{preinscrito}/convertir', [PreinscritoSepeController::class, 'convertirAAlumno'])
->name('preinscritos.convertir');
// Ruta para desinscribir un alumno de un curso
Route::delete('/alumnos/{alumno}/cursos/{curso}', [AlumnoController::class, 'desinscribirCurso'])->name('alumnos.cursos.desinscribir');
// Ruta GET para obtener los cursos disponibles para un alumno (para el modal AJAX)
Route::get('/alumnos/{alumno}/cursos-disponibles', [AlumnoController::class, 'getCursosDisponibles'])->name('alumnos.cursos.disponibles');
// Ruta POST para procesar la inscripción del alumno en un curso
Route::post('/alumnos/{alumno}/inscribir', [AlumnoController::class, 'inscribirCurso'])->name('alumnos.cursos.inscribir');
// Placeholders para otras secciones de admin
Route::get('/reportes', function () { return 'Admin Reportes (Pendiente)'; })->name('reportes.index');
Route::get('/finanzas', function () { return 'Admin Finanzas (Pendiente)'; })->name('finanzas.index');
Route::get('/configuracion', function () { return 'Admin Configuración (Pendiente)'; })->name('configuracion.index');
// Define una ruta DELETE para desvincular un curso de un alumno
⋮----
}); // --- Fin del grupo admin ---
}); // --- Fin del grupo principal 'auth', 'verified' ---
// --- Ruta de Simulación de Login (SOLO PARA DESARROLLO LOCAL) ---
Route::get('/login-dev', function () {
if (!app()->environment('local')) {
return redirect()->route('login'); // En producción, siempre al login real
⋮----
$user = User::firstOrCreate(
['email' => 'admin@admin.com'], // Usuario admin de prueba
⋮----
'password' => bcrypt('password'), // Contraseña de prueba
⋮----
Auth::login($user);
request()->session()->regenerate();
return redirect()->intended(route('admin.dashboard'));
})->name('login.dev');
```

## File: storage/app/private/.gitignore
```
*
!.gitignore
```

## File: storage/app/public/.gitignore
```
*
!.gitignore
```

## File: storage/app/.gitignore
```
*
!private/
!public/
!.gitignore
```

## File: storage/framework/cache/data/.gitignore
```
*
!.gitignore
```

## File: storage/framework/cache/.gitignore
```
*
!data/
!.gitignore
```

## File: storage/framework/sessions/.gitignore
```
*
!.gitignore
```

## File: storage/framework/testing/.gitignore
```
*
!.gitignore
```

## File: storage/framework/views/.gitignore
```
*
!.gitignore
```

## File: storage/framework/.gitignore
```
compiled.php
config.php
down
events.scanned.php
maintenance.php
routes.php
routes.scanned.php
schedule-*
services.json
```

## File: tests/Feature/Auth/AuthenticationTest.php
```php
namespace Tests\Feature\Auth;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
class AuthenticationTest extends TestCase
⋮----
public function test_login_screen_can_be_rendered(): void
⋮----
$response = $this->get('/login');
$response->assertStatus(200);
⋮----
public function test_users_can_authenticate_using_the_login_screen(): void
⋮----
$user = User::factory()->create();
$response = $this->post('/login', [
⋮----
$this->assertAuthenticated();
$response->assertRedirect(route('dashboard', absolute: false));
⋮----
public function test_users_can_not_authenticate_with_invalid_password(): void
⋮----
$this->post('/login', [
⋮----
$this->assertGuest();
⋮----
public function test_users_can_logout(): void
⋮----
$response = $this->actingAs($user)->post('/logout');
⋮----
$response->assertRedirect('/');
```

## File: tests/Feature/Auth/EmailVerificationTest.php
```php
namespace Tests\Feature\Auth;
use App\Models\User;
use Illuminate\Auth\Events\Verified;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Event;
use Illuminate\Support\Facades\URL;
use Tests\TestCase;
class EmailVerificationTest extends TestCase
⋮----
public function test_email_verification_screen_can_be_rendered(): void
⋮----
$user = User::factory()->unverified()->create();
$response = $this->actingAs($user)->get('/verify-email');
$response->assertStatus(200);
⋮----
public function test_email_can_be_verified(): void
⋮----
Event::fake();
$verificationUrl = URL::temporarySignedRoute(
⋮----
now()->addMinutes(60),
⋮----
$response = $this->actingAs($user)->get($verificationUrl);
Event::assertDispatched(Verified::class);
$this->assertTrue($user->fresh()->hasVerifiedEmail());
$response->assertRedirect(route('dashboard', absolute: false).'?verified=1');
⋮----
public function test_email_is_not_verified_with_invalid_hash(): void
⋮----
$this->actingAs($user)->get($verificationUrl);
$this->assertFalse($user->fresh()->hasVerifiedEmail());
```

## File: tests/Feature/Auth/PasswordConfirmationTest.php
```php
namespace Tests\Feature\Auth;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
class PasswordConfirmationTest extends TestCase
⋮----
public function test_confirm_password_screen_can_be_rendered(): void
⋮----
$user = User::factory()->create();
$response = $this->actingAs($user)->get('/confirm-password');
$response->assertStatus(200);
⋮----
public function test_password_can_be_confirmed(): void
⋮----
$response = $this->actingAs($user)->post('/confirm-password', [
⋮----
$response->assertRedirect();
$response->assertSessionHasNoErrors();
⋮----
public function test_password_is_not_confirmed_with_invalid_password(): void
⋮----
$response->assertSessionHasErrors();
```

## File: tests/Feature/Auth/PasswordResetTest.php
```php
namespace Tests\Feature\Auth;
use App\Models\User;
use Illuminate\Auth\Notifications\ResetPassword;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Notification;
use Tests\TestCase;
class PasswordResetTest extends TestCase
⋮----
public function test_reset_password_link_screen_can_be_rendered(): void
⋮----
$response = $this->get('/forgot-password');
$response->assertStatus(200);
⋮----
public function test_reset_password_link_can_be_requested(): void
⋮----
Notification::fake();
$user = User::factory()->create();
$this->post('/forgot-password', ['email' => $user->email]);
Notification::assertSentTo($user, ResetPassword::class);
⋮----
public function test_reset_password_screen_can_be_rendered(): void
⋮----
Notification::assertSentTo($user, ResetPassword::class, function ($notification) {
$response = $this->get('/reset-password/'.$notification->token);
⋮----
public function test_password_can_be_reset_with_valid_token(): void
⋮----
Notification::assertSentTo($user, ResetPassword::class, function ($notification) use ($user) {
$response = $this->post('/reset-password', [
⋮----
->assertSessionHasNoErrors()
->assertRedirect(route('login'));
```

## File: tests/Feature/Auth/PasswordUpdateTest.php
```php
namespace Tests\Feature\Auth;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Hash;
use Tests\TestCase;
class PasswordUpdateTest extends TestCase
⋮----
public function test_password_can_be_updated(): void
⋮----
$user = User::factory()->create();
⋮----
->actingAs($user)
->from('/profile')
->put('/password', [
⋮----
->assertSessionHasNoErrors()
->assertRedirect('/profile');
$this->assertTrue(Hash::check('new-password', $user->refresh()->password));
⋮----
public function test_correct_password_must_be_provided_to_update_password(): void
⋮----
->assertSessionHasErrorsIn('updatePassword', 'current_password')
```

## File: tests/Feature/Auth/RegistrationTest.php
```php
namespace Tests\Feature\Auth;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
class RegistrationTest extends TestCase
⋮----
public function test_registration_screen_can_be_rendered(): void
⋮----
$response = $this->get('/register');
$response->assertStatus(200);
⋮----
public function test_new_users_can_register(): void
⋮----
$response = $this->post('/register', [
⋮----
$this->assertAuthenticated();
$response->assertRedirect(route('dashboard', absolute: false));
```

## File: tests/Feature/ExampleTest.php
```php
namespace Tests\Feature;
// use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
class ExampleTest extends TestCase
⋮----
/**
     * A basic test example.
     */
public function test_the_application_returns_a_successful_response(): void
⋮----
$response = $this->get('/');
$response->assertStatus(200);
```

## File: tests/Feature/ProfileTest.php
```php
namespace Tests\Feature;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
class ProfileTest extends TestCase
⋮----
public function test_profile_page_is_displayed(): void
⋮----
$user = User::factory()->create();
⋮----
->actingAs($user)
->get('/profile');
$response->assertOk();
⋮----
public function test_profile_information_can_be_updated(): void
⋮----
->patch('/profile', [
⋮----
->assertSessionHasNoErrors()
->assertRedirect('/profile');
$user->refresh();
$this->assertSame('Test User', $user->name);
$this->assertSame('test@example.com', $user->email);
$this->assertNull($user->email_verified_at);
⋮----
public function test_email_verification_status_is_unchanged_when_the_email_address_is_unchanged(): void
⋮----
$this->assertNotNull($user->refresh()->email_verified_at);
⋮----
public function test_user_can_delete_their_account(): void
⋮----
->delete('/profile', [
⋮----
->assertRedirect('/');
$this->assertGuest();
$this->assertNull($user->fresh());
⋮----
public function test_correct_password_must_be_provided_to_delete_account(): void
⋮----
->from('/profile')
⋮----
->assertSessionHasErrorsIn('userDeletion', 'password')
⋮----
$this->assertNotNull($user->fresh());
```

## File: tests/Unit/ExampleTest.php
```php
namespace Tests\Unit;
use PHPUnit\Framework\TestCase;
class ExampleTest extends TestCase
⋮----
/**
     * A basic test example.
     */
public function test_that_true_is_true(): void
⋮----
$this->assertTrue(true);
```

## File: tests/TestCase.php
```php
namespace Tests;
use Illuminate\Foundation\Testing\TestCase as BaseTestCase;
abstract class TestCase extends BaseTestCase
⋮----
//
```

## File: .editorconfig
```
root = true

[*]
charset = utf-8
end_of_line = lf
indent_size = 4
indent_style = space
insert_final_newline = true
trim_trailing_whitespace = true

[*.md]
trim_trailing_whitespace = false

[*.{yml,yaml}]
indent_size = 2

[docker-compose.yml]
indent_size = 4
```

## File: .env.example
```
APP_NAME=Laravel
APP_ENV=local
APP_KEY=
APP_DEBUG=true
APP_URL=http://localhost

APP_LOCALE=en
APP_FALLBACK_LOCALE=en
APP_FAKER_LOCALE=en_US

APP_MAINTENANCE_DRIVER=file
# APP_MAINTENANCE_STORE=database

PHP_CLI_SERVER_WORKERS=4

BCRYPT_ROUNDS=12

LOG_CHANNEL=stack
LOG_STACK=single
LOG_DEPRECATIONS_CHANNEL=null
LOG_LEVEL=debug

DB_CONNECTION=sqlite
# DB_HOST=127.0.0.1
# DB_PORT=3306
# DB_DATABASE=laravel
# DB_USERNAME=root
# DB_PASSWORD=

SESSION_DRIVER=database
SESSION_LIFETIME=120
SESSION_ENCRYPT=false
SESSION_PATH=/
SESSION_DOMAIN=null

BROADCAST_CONNECTION=log
FILESYSTEM_DISK=local
QUEUE_CONNECTION=database

CACHE_STORE=database
# CACHE_PREFIX=

MEMCACHED_HOST=127.0.0.1

REDIS_CLIENT=phpredis
REDIS_HOST=127.0.0.1
REDIS_PASSWORD=null
REDIS_PORT=6379

MAIL_MAILER=log
MAIL_SCHEME=null
MAIL_HOST=127.0.0.1
MAIL_PORT=2525
MAIL_USERNAME=null
MAIL_PASSWORD=null
MAIL_FROM_ADDRESS="hello@example.com"
MAIL_FROM_NAME="${APP_NAME}"

AWS_ACCESS_KEY_ID=
AWS_SECRET_ACCESS_KEY=
AWS_DEFAULT_REGION=us-east-1
AWS_BUCKET=
AWS_USE_PATH_STYLE_ENDPOINT=false

VITE_APP_NAME="${APP_NAME}"
```

## File: .gitattributes
```
* text=auto eol=lf

*.blade.php diff=html
*.css diff=css
*.html diff=html
*.md diff=markdown
*.php diff=php

/.github export-ignore
CHANGELOG.md export-ignore
.styleci.yml export-ignore
```

## File: .gitignore
```
# Dependency directories
/node_modules
/vendor

# Environment files
.env
.env.*
!.env.example

# Laravel specific
/.phpunit.cache
/public/build
/public/hot
/public/storage
/storage/*.key
/storage/app/public
/storage/pail
/bootstrap/cache/*
!bootstrap/cache/.gitkeep

# Testing
.phpunit.result.cache
Coverage/

# IDE files
/.fleet
/.idea
/.nova
/.vscode
/.zed
.phpactor.json

# Package manager
npm-debug.log*
yarn-debug.log*
yarn-error.log*
package-lock.json
yarn.lock

# Logs
*.log
logs/
storage/logs/*
!storage/logs/.gitkeep

# Temporary files
*.tmp
*.temp
*.swp
*.swo
*~

# OS generated files
.DS_Store
.DS_Store?
._*
.Spotlight-V100
.Trashes
ehthumbs.db
Thumbs.db

# Docker
docker-compose.override.yml

# Auth
/auth.json

# Homestead
Homestead.json
Homestead.yaml

# Warp
.Warp
/scripts
/.warp

# Imagenes
/public/images/

# docs
/personal_docs/*.md
GEMINI.md
```

## File: artisan
```
#!/usr/bin/env php
<?php

use Illuminate\Foundation\Application;
use Symfony\Component\Console\Input\ArgvInput;

define('LARAVEL_START', microtime(true));

// Register the Composer autoloader...
require __DIR__.'/vendor/autoload.php';

// Bootstrap Laravel and handle the command...
/** @var Application $app */
$app = require_once __DIR__.'/bootstrap/app.php';

$status = $app->handleCommand(new ArgvInput);

exit($status);
```

## File: composer.json
```json
{
    "$schema": "https://getcomposer.org/schema.json",
    "name": "laravel/laravel",
    "type": "project",
    "description": "The skeleton application for the Laravel framework.",
    "keywords": ["laravel", "framework"],
    "license": "MIT",
    "require": {
        "php": "^8.2",
        "laravel/framework": "^12.0",
        "laravel/tinker": "^2.10.1"
    },
    "require-dev": {
        "fakerphp/faker": "^1.23",
        "laravel/breeze": "^2.3",
        "laravel/pail": "^1.2.2",
        "laravel/pint": "^1.13",
        "laravel/sail": "^1.41",
        "mockery/mockery": "^1.6",
        "nunomaduro/collision": "^8.6",
        "phpunit/phpunit": "^11.5.3"
    },
    "autoload": {
        "psr-4": {
            "App\\": "app/",
            "Database\\Factories\\": "database/factories/",
            "Database\\Seeders\\": "database/seeders/"
        }
    },
    "autoload-dev": {
        "psr-4": {
            "Tests\\": "tests/"
        }
    },
    "scripts": {
        "post-autoload-dump": [
            "Illuminate\\Foundation\\ComposerScripts::postAutoloadDump",
            "@php artisan package:discover --ansi"
        ],
        "post-update-cmd": [
            "@php artisan vendor:publish --tag=laravel-assets --ansi --force"
        ],
        "post-root-package-install": [
            "@php -r \"file_exists('.env') || copy('.env.example', '.env');\""
        ],
        "post-create-project-cmd": [
            "@php artisan key:generate --ansi",
            "@php -r \"file_exists('database/database.sqlite') || touch('database/database.sqlite');\"",
            "@php artisan migrate --graceful --ansi"
        ],
        "dev": [
            "Composer\\Config::disableProcessTimeout",
            "npx concurrently -c \"#93c5fd,#c4b5fd,#fb7185,#fdba74\" \"php artisan serve\" \"php artisan queue:listen --tries=1\" \"php artisan pail --timeout=0\" \"npm run dev\" --names=server,queue,logs,vite"
        ],
        "test": [
            "@php artisan config:clear --ansi",
            "@php artisan test"
        ]
    },
    "extra": {
        "laravel": {
            "dont-discover": []
        }
    },
    "config": {
        "optimize-autoloader": true,
        "preferred-install": "dist",
        "sort-packages": true,
        "allow-plugins": {
            "pestphp/pest-plugin": true,
            "php-http/discovery": true
        }
    },
    "minimum-stability": "stable",
    "prefer-stable": true
}
```

## File: docker-compose.yml
```yaml
services:
  db:
    image: postgres:14-alpine
    container_name: centro_db
    restart: unless-stopped
    environment:
      POSTGRES_DB: ${DB_DATABASE:-centro_formacion}
      POSTGRES_USER: ${DB_USERNAME:-usuario}
      POSTGRES_PASSWORD: ${DB_PASSWORD:-password}
    volumes:
      - db_data:/var/lib/postgresql/data
    ports:
      - "49000:5432" # o el puerto que prefieras
    healthcheck:
      test: ["CMD-SHELL", "pg_isready -U ${DB_USERNAME:-usuario} -d ${DB_DATABASE:-centro_formacion}"]
      interval: 10s
      timeout: 5s
      retries: 5
  app:
    build:
      context: .
      dockerfile: Dockerfile
    container_name: centro_app
    restart: unless-stopped
    working_dir: /var/www/html
    volumes:
      - .:/var/www/html
    ports:
      - "8000:8000" # PHP artisan serve
      - "5173:5173" # Vite o PHP artisan serve
    depends_on:
      db:
        condition: service_healthy
    env_file:
      - ./.env
volumes:
  db_data:
```

## File: Dockerfile
```dockerfile
# Cambia la versión de PHP a 8.3
FROM php:8.3-fpm-alpine

WORKDIR /var/www/html

# Instalar dependencias PHP y Node.js/npm
# (Mismas dependencias que antes)
RUN apk update && apk add --no-cache \
    libpq-dev \
    git \
    zip \
    unzip \
    nodejs \
    npm \
    autoconf \
    g++ \
    make \
    # Instalar extensiones PHP
    && docker-php-ext-install pdo pdo_pgsql \
    # Instalar extensión Redis para PHP
    && pecl install redis \
    && docker-php-ext-enable redis \
    # Limpiar caché de apk
    && rm -rf /var/cache/apk/*

# Instalar Composer
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

# Copiar código (manejado por volumen en desarrollo)
# COPY ./src /var/www/html

# Exponer puerto para FPM
EXPOSE 9000

# Comando por defecto (opcional si está en docker-compose.yml)
# CMD ["php-fpm"]
```

## File: package.json
```json
{
    "private": true,
    "type": "module",
    "scripts": {
        "build": "vite build",
        "dev": "vite"
    },
    "devDependencies": {
        "@tailwindcss/forms": "^0.5.2",
        "@tailwindcss/vite": "^4.0.0",
        "alpinejs": "^3.4.2",
        "autoprefixer": "^10.4.2",
        "axios": "^1.8.2",
        "concurrently": "^9.0.1",
        "laravel-vite-plugin": "^1.2.0",
        "postcss": "^8.4.31",
        "tailwindcss": "^3.1.0",
        "vite": "^6.2.4"
    },
    "dependencies": {
        "@fullcalendar/core": "^6.1.17",
        "@fullcalendar/daygrid": "^6.1.17",
        "@fullcalendar/rrule": "^6.1.18",
        "@fullcalendar/timegrid": "^6.1.17",
        "rrule": "^2.8.1"
    }
}
```

## File: phpunit.xml
```xml
<?xml version="1.0" encoding="UTF-8"?>
<phpunit xmlns:xsi="http://www.w3.org/2001/XMLSchema-instance"
         xsi:noNamespaceSchemaLocation="vendor/phpunit/phpunit/phpunit.xsd"
         bootstrap="vendor/autoload.php"
         colors="true"
>
    <testsuites>
        <testsuite name="Unit">
            <directory>tests/Unit</directory>
        </testsuite>
        <testsuite name="Feature">
            <directory>tests/Feature</directory>
        </testsuite>
    </testsuites>
    <source>
        <include>
            <directory>app</directory>
        </include>
    </source>
    <php>
        <env name="APP_ENV" value="testing"/>
        <env name="APP_MAINTENANCE_DRIVER" value="file"/>
        <env name="BCRYPT_ROUNDS" value="4"/>
        <env name="CACHE_STORE" value="array"/>
        <env name="DB_CONNECTION" value="sqlite"/>
        <env name="DB_DATABASE" value=":memory:"/>
        <env name="MAIL_MAILER" value="array"/>
        <env name="PULSE_ENABLED" value="false"/>
        <env name="QUEUE_CONNECTION" value="sync"/>
        <env name="SESSION_DRIVER" value="array"/>
        <env name="TELESCOPE_ENABLED" value="false"/>
    </php>
</phpunit>
```

## File: postcss.config.js
```javascript

```

## File: start-dev-fixed.sh
```bash
#!/bin/bash
# --- Script para iniciar el entorno de desarrollo Laravel con Docker DENTRO de WSL ---
# Definimos códigos de color para los mensajes
GREEN="\033[0;32m"
RED="\033[0;31m"
YELLOW="\033[0;33m"
BLUE="\033[0;34m"
CYAN="\033[0;36m"
NC="\033[0m" # Sin color
# Función para limpiar procesos al salir
cleanup() {
    echo -e "\n${YELLOW}🧹 Limpiando procesos...${NC}"
    if [ ! -z "$LARAVEL_PID" ]; then
        kill $LARAVEL_PID 2>/dev/null
    fi
    if [ ! -z "$VITE_PID" ]; then
        kill $VITE_PID 2>/dev/null
    fi
    echo -e "${GREEN}✅ Limpieza completada${NC}"
}
# Registrar función de limpieza para cuando se termine el script
trap cleanup EXIT
# 1. Verificar que estamos en la raíz del proyecto (buscando docker-compose.yml)
if [ ! -f "docker-compose.yml" ] && [ ! -f "docker-compose.yaml" ]; then
    echo -e "${RED}❌ No se encontró docker-compose.yml o docker-compose.yaml${NC}"
    echo -e "${YELLOW}Asegúrate de ejecutar este script desde la raíz de tu proyecto.${NC}"
    exit 1
fi
# 2. Verificar que existe 'artisan' en la raíz (lógica simplificada para la nueva estructura)
if [ ! -f "artisan" ]; then
    echo -e "${RED}❌ No se encontró el archivo 'artisan'.${NC}"
    echo -e "${YELLOW}Este no parece ser un proyecto Laravel válido.${NC}"
    exit 1
fi
echo -e "${GREEN}🚀 Iniciando entorno de desarrollo Laravel...${NC}"
echo -e "${CYAN}📍 Ubicación: $(pwd)${NC}"
# 3. Levantar los contenedores
echo -e "${BLUE}🐳 Levantando contenedores con 'docker-compose up -d'...${NC}"
docker-compose up -d
# Esperar un poco a que los servicios se estabilicen
sleep 5
# 3.1. Verificar si hay problemas con las dependencias de npm
echo -e "${YELLOW}🔍 Verificando estado de las dependencias de npm...${NC}"
npm_test_result=$(docker-compose exec -T app npm run dev --dry-run 2>&1 || echo "error")
if echo "$npm_test_result" | grep -q "Cannot find module.*rollup"; then
    echo -e "${YELLOW}⚠️  Detectado problema con dependencias de rollup. Reinstalando...${NC}"
    docker-compose exec -T app rm -rf package-lock.json node_modules
    docker-compose exec -T app npm install
    echo -e "${GREEN}✅ Dependencias reinstaladas${NC}"
fi
# 4. Iniciar el servidor Laravel usando nohup
echo -e "${BLUE}🌐 Iniciando servidor Laravel (puerto 8000)...${NC}"
nohup docker-compose exec -T app php artisan serve --host=0.0.0.0 --port=8000 > laravel.log 2>&1 &
LARAVEL_PID=$!
# Esperar un momento
sleep 3
# 5. Iniciar el dev server de npm usando nohup
echo -e "${CYAN}⚡ Iniciando npm dev server...${NC}"
nohup docker-compose exec -T app npm run dev > vite.log 2>&1 &
VITE_PID=$!
# Esperar un poco para que los servicios se inicialicen
sleep 5
# Verificar que los procesos estén funcionando
echo -e "${BLUE}📊 Verificando servicios...${NC}"
# Verificar Laravel
if kill -0 $LARAVEL_PID 2>/dev/null; then
    echo -e "${GREEN}✅ Servidor Laravel: Funcionando (PID: $LARAVEL_PID)${NC}"
else
    echo -e "${RED}❌ Servidor Laravel: Error al iniciar${NC}"
    echo -e "${YELLOW}Ver log: tail -f laravel.log${NC}"
fi
# Verificar Vite
if kill -0 $VITE_PID 2>/dev/null; then
    echo -e "${GREEN}✅ Vite Dev Server: Funcionando (PID: $VITE_PID)${NC}"
else
    echo -e "${RED}❌ Vite Dev Server: Error al iniciar${NC}"
    echo -e "${YELLOW}Ver log: tail -f vite.log${NC}"
fi
echo -e "\n${GREEN}✅ Entorno iniciado:${NC}"
echo -e "   ${CYAN}🌐 Laravel: http://localhost:8000${NC}"
echo -e "   ${CYAN}⚡ Vite Dev Server ejecutándose${NC}"
echo -e "\n${YELLOW}📋 Comandos útiles:${NC}"
echo -e "   ${NC}Ver logs de Laravel: tail -f laravel.log"
echo -e "   ${NC}Ver logs de Vite: tail -f vite.log"
echo -e "   ${NC}Detener servicios: docker-compose down"
echo -e "   ${NC}Reiniciar dependencias npm: docker-compose exec app npm install"
echo -e "\n${BLUE}💡 Los servicios seguirán ejecutándose en segundo plano.${NC}"
echo -e "${BLUE}   Presiona Ctrl+C para detener este script (los servicios continuarán).${NC}"
# Mantener el script corriendo para mostrar logs en tiempo real si se desea
read -p $'\n'"${CYAN}¿Quieres ver los logs en tiempo real? (y/n): ${NC}" -n 1 -r
echo
if [[ $REPLY =~ ^[Yy]$ ]]; then
    echo -e "${BLUE}📊 Mostrando logs en tiempo real (Ctrl+C para salir)...${NC}"
    tail -f laravel.log vite.log
fi
```

## File: tailwind.config.js
```javascript
/** @type {import('tailwindcss').Config} */
```

## File: task.json
```json
{
"_comentario": "“Run Task” (Ctrl+Shift+P y luego “Tasks: Run Task”).",    
"version": "2.0.0",
"tasks": [
{
"label": "Ajustar permisos del proyecto",
"type": "shell",
"command": "sudo chown -R user1234:user1234 /home/user1234/proyectos/proyecto-laravel",
"problemMatcher": []
}
]
}
```

## File: vite.config.js
```javascript
export default defineConfig({
⋮----
laravel({
⋮----
'resources/css/login.css',  // Añade tu nuevo CSS
⋮----
'resources/js/particles-config.js',  // Añade tu nuevo JS
⋮----
// --- Añadir esta sección ---
⋮----
host: '0.0.0.0', // Escucha en todas las interfaces de red
port: 5173,      // Puerto estándar de Vite
⋮----
host: 'localhost', // El host que usará el navegador para conectar a HMR
⋮----
usePolling: true, // ¡ESTA ES LA LÍNEA MÁGICA!
⋮----
// --- Fin de la sección ---
```
