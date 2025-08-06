## **Módulo de Configuración (`Settings`)**

---

### 1. Resumen (`Settings`)

**Es el cimiento de todo el sistema.**

**Justificación:**
Este módulo no es simplemente una funcionalidad más; define las reglas de negocio y los parámetros operativos bajo los cuales todos los demás módulos funcionarán. Intentar construir cualquier otra cosa sin esto sería como construir un edificio sin planos ni cimientos.

- **Dependencia Funcional Crítica:**
  - El módulo de **Conflictos** necesita saber las horas de la jornada escolar y la duración de los bloques de clase para detectar solapamientos.
  - El módulo de **Reportes** debe filtrar toda la información por el **Año Académico** y los **Periodos de Evaluación** aquí definidos.
  - La funcionalidad de **Alertas** debe saber a qué **Roles** (ej: "System Administrator") debe enviar notificaciones.
- **Seguridad (RBAC):** La implementación de **Roles y Permisos** es lo primero que se debe establecer. Define quién puede hacer qué en todo el sistema. Construir funcionalidades sin un sistema de autorización definido desde el principio es una receta para el desastre y el retrabajo masivo.

**Resultado al finalizar este paso:** Tendrás el esqueleto y el sistema nervioso central de tu aplicación. Podrás definir cómo se comporta la institución a nivel digital y quién tiene permiso para interactuar con ella.

---

Excelente. Entiendo perfectamente la solicitud. Necesitas un plano de construcción detallado, una guía de arquitectura y ejecución para el **Módulo de Configuración**, dirigida a un desarrollador. El enfoque será modular, incremental y verificable, permitiendo construir y probar cada componente de forma aislada antes de ensamblarlo.

Como Arquitecto de Software Senior, este es el tipo de documento que prepararía para un equipo de desarrollo. Procedamos.

---

### **Documento de Diseño y Ejecución: Módulo de Configuración (`Settings`)**

**Proyecto:** Sistema de Gestión Educativa
**Módulo:** `Settings` (v1.0)
**Destinatario:** Equipo de Desarrollo Backend/Full-Stack
**Autor:** Arquitecto de Software Senior

#### **1. Visión General y Principios Arquitectónicos**

El módulo de Configuración es el **núcleo fundacional** del sistema. Su correcta implementación no es negociable, ya que establece el contexto operativo y de seguridad para todas las futuras funcionalidades.

**Principios Clave:**

1.  **Seguridad por Defecto:** El acceso debe estar restringido al máximo nivel de autorización. Usaremos Policies de Laravel para un control granular.
2.  **Modularidad y Aislamiento:** Cada sección de la configuración (Institución, Académico, Roles) se desarrollará como un componente lo más independiente posible.
3.  **Rendimiento:** Las configuraciones se cargarán una vez al inicio del ciclo de vida de la aplicación o se accederá a ellas a través de un sistema de caché eficiente para no sobrecargar la base de datos en cada petición.
4.  **Testabilidad:** Cada Hito debe concluir con un conjunto de pruebas automatizadas (Feature Tests) que validen su funcionalidad y sus reglas de seguridad.

---

### **Hito 0: Cimientos - Roles y Permisos (RBAC)**

**Objetivo:** Establecer el sistema de control de acceso basado en roles. Este es el prerrequisito para CUALQUIER otra funcionalidad. Es un bloque independiente y el más crítico.

**Justificación Técnica:** Antes de poder decir "sólo los administradores pueden cambiar el nombre de la escuela", necesitamos una forma robusta de definir qué es un "administrador" y qué significa "poder cambiar".

#### **Pasos de Ejecución Detallados (Hito 0):**

1.  **Instalación del Paquete RBAC:**

    - Instalar el estándar de la industria: `spatie/laravel-permission`.
    - Ejecutar en la terminal: `composer require spatie/laravel-permission`
    - Publicar el archivo de migración: `php artisan vendor:publish --provider="Spatie\Permission\PermissionServiceProvider"`
    - Ejecutar la migración para crear las tablas `roles`, `permissions`, `model_has_roles`, `model_has_permissions`, `role_has_permissions`: `php artisan migrate`

2.  **Integración con el Modelo `User`:**

    - En tu modelo `App\Models\User`, añade el trait `HasRoles`:

    ```php
    use Spatie\Permission\Traits\HasRoles;

    class User extends Authenticatable
    {
        use HasFactory, Notifiable, HasRoles;
        // ... resto del modelo
    }
    ```

3.  **Creación de Roles y Permisos Iniciales (Seeders):**

    - Crear un Seeder para los datos fundamentales: `php artisan make:seeder RolesAndPermissionsSeeder`
    - Dentro del método `run()` del Seeder (`database/seeders/RolesAndPermissionsSeeder.php`):

    ````php
    use Spatie\Permission\Models\Role;
    use Spatie\Permission\Models\Permission;

    // Resetear roles y permisos cacheados
    app()[\Spatie\Permission\PermissionRegistrar::class]->forgetCachedPermissions();

    // Crear Permisos
    Permission::create(['name' => 'access_settings']);
    Permission::create(['name' => 'manage_roles']);
    Permission::create(['name' => 'manage_academic_settings']);
    Permission::create(['name' => 'manage_institution_settings']);

    // Crear Roles y Asignar Permisos
    $adminRole = Role::create(['name' => 'System Administrator']);
    $adminRole->givePermissionTo(Permission::all()); // El admin puede todo

    $secretaryRole = Role::create(['name' => 'Secretary']);
    // Por ahora, la secretaria no tiene permisos de configuración.

    $teacherRole = Role::create(['name' => 'Teacher']);
    // Los profesores tampoco.
    ```    *   Añade este Seeder al `DatabaseSeeder.php` y ejecuta `php artisan db:seed`.

    ````

4.  **Creación de un Usuario Administrador para Pruebas:**
    - Crea un Factory para el usuario o un Seeder para crear un usuario de prueba y asignarle el rol de administrador.
    ```php
    // En un UserSeeder o similar
    $adminUser = \App\Models\User::factory()->create([
        'name' => 'Admin User',
        'email' => 'admin@eastbridge.com',
        'password' => bcrypt('password'),
    ]);
    $adminUser->assignRole('System Administrator');
    ```

#### **Punto de Verificación (Hito 0):**

- **Pruebas Manuales:**
  1.  Verifica que las 5 tablas de `spatie/laravel-permission` existen en la base de datos.
  2.  Verifica que la tabla `roles` contiene "System Administrator", "Secretary", etc.
  3.  Verifica que puedes asignar un rol a un usuario usando `tinker`: `$user->assignRole('System Administrator');` y verificarlo con `$user->hasRole('System Administrator');` (devuelve `true`).
- **Pruebas Automatizadas (Feature Tests):**
  - Crea un test: `php artisan make:test AuthorizationTest`
  - Añade métodos de prueba como:
  ```php
  public function test_user_can_be_assigned_a_role()
  {
      $user = User::factory()->create();
      $role = Role::create(['name' => 'Test Role']);
      $user->assignRole($role);
      $this->assertTrue($user->hasRole('Test Role'));
  }
  ```
  - **¡Este Hito está completo y verificado!**

---

### **Hito 1: Parámetros Simples de la Institución (Clave-Valor)**

**Objetivo:** Crear la funcionalidad para gestionar configuraciones simples como "nombre de la escuela" o "teléfono". Se usará un enfoque de tabla `key-value` para máxima flexibilidad.

**Justificación Técnica:** Este enfoque es ideal para configuraciones que no tienen lógica compleja asociada. Evita tener que añadir una nueva columna a una tabla cada vez que se necesita un nuevo parámetro simple.

#### **Pasos de Ejecución Detallados (Hito 1):**

1.  **Modelo y Migración:**

    - Crea un modelo y su migración: `php artisan make:model Setting -m`
    - En el archivo de migración (`database/migrations/..._create_settings_table.php`):

    ```php
    Schema::create('settings', function (Blueprint $table) {
        $table->string('key')->primary(); // La clave es única
        $table->text('value')->nullable();
        $table->timestamps();
    });
    ```

    - Ejecuta `php artisan migrate`.

2.  **Controlador y Rutas:**

    - Crea un controlador: `php artisan make:controller Settings/InstitutionSettingsController`
    - En `routes/web.php`, define las rutas, protegidas por middleware de autorización:

    ```php
    Route::middleware(['auth', 'can:manage_institution_settings'])->prefix('settings')->group(function () {
        Route::get('/institution', [InstitutionSettingsController::class, 'index'])->name('settings.institution.index');
        Route::post('/institution', [InstitutionSettingsController::class, 'update'])->name('settings.institution.update');
    });
    ```

3.  **Lógica de Negocio (Service Layer):**

    - Para mantener los controladores limpios, crea un Service. Crea una carpeta `app/Services`.
    - En `app/Services/SettingsService.php`:

    ```php
    class SettingsService
    {
        public function update(array $data)
        {
            foreach ($data as $key => $value) {
                Setting::updateOrCreate(['key' => $key], ['value' => $value]);
            }
        }

        public function get($key, $default = null)
        {
            return Setting::where('key', $key)->first()?->value ?? $default;
        }
    }
    ```

    - En el `InstitutionSettingsController`, inyecta este servicio y úsalo.

4.  **Vistas (Blade):**

    - Crea la vista en `resources/views/settings/institution/index.blade.php`.
    - Será un formulario que envíe una petición `POST` a la ruta `settings.institution.update`.

    ```html
    <form action="{{ route('settings.institution.update') }}" method="POST">
      @csrf
      <label for="school_name">Nombre de la Institución</label>
      <input
        type="text"
        name="school_name"
        value="{{ $settingsService->get('school_name') }}"
      />

      <label for="school_address">Dirección</label>
      <input
        type="text"
        name="school_address"
        value="{{ $settingsService->get('school_address') }}"
      />

      <button type="submit">Guardar Cambios</button>
    </form>
    ```

#### **Punto de Verificación (Hito 1):**

- **Pruebas Manuales:**
  1.  Inicia sesión como un usuario **sin** el rol de admin. Intenta acceder a `/settings/institution`. Deberías recibir un error 403 (Forbidden).
  2.  Inicia sesión como **admin**. Accede a la página, llena los campos y guarda. Verifica que los datos se guardan en la tabla `settings` y que se muestran correctamente al recargar la página.
- **Pruebas Automatizadas (Feature Tests):**

  - Crea un test: `php artisan make:test Settings/InstitutionSettingsTest`

  ```php
  public function test_unauthenticated_user_cannot_access_institution_settings()
  {
      $this->get(route('settings.institution.index'))->assertRedirect('/login');
  }

  public function test_unauthorized_user_cannot_access_institution_settings()
  {
      $user = User::factory()->create(); // No es admin
      $this->actingAs($user)->get(route('settings.institution.index'))->assertForbidden();
  }

  public function test_admin_can_update_institution_settings()
  {
      $admin = User::factory()->create()->assignRole('System Administrator');
      $this->actingAs($admin)
           ->post(route('settings.institution.update'), [
               'school_name' => 'East Bridge High School',
           ]);
      $this->assertDatabaseHas('settings', [
          'key' => 'school_name',
          'value' => 'East Bridge High School'
      ]);
  }
  ```

  - **¡Hito 1 completado y verificado! Los dos bloques son independientes pero ahora están conectados por el RBAC.**

---

### **Hito 2: Gestión de Años Académicos y Periodos**

**Objetivo:** Implementar la gestión de los años académicos (ciclos escolares) y sus periodos de evaluación (trimestres, semestres). Esta es una lógica más compleja que no encaja en un modelo clave-valor.

**Justificación Técnica:** Estos son datos estructurados con relaciones y lógica de negocio (ej: solo un año puede estar "activo", las fechas de los periodos deben estar dentro del año académico). Requieren sus propias tablas.

#### **Pasos de Ejecución Detallados (Hito 2):**

1.  **Modelos y Migraciones:**

    - `php artisan make:model AcademicYear -m`
    - Migración para `academic_years`:

    ```php
    Schema::create('academic_years', function (Blueprint $table) {
        $table->id();
        $table->string('name'); // Ej: "Ciclo 2024-2025"
        $table->date('start_date');
        $table->date('end_date');
        $table->boolean('is_active')->default(false);
        $table->timestamps();
    });
    ```

    - `php artisan make:model GradingPeriod -m`
    - Migración para `grading_periods`:

    ```php
    Schema::create('grading_periods', function (Blueprint $table) {
        $table->id();
        $table->foreignId('academic_year_id')->constrained()->onDelete('cascade');
        $table->string('name'); // Ej: "Primer Trimestre"
        $table->date('start_date');
        $table->date('end_date');
        $table->timestamps();
    });
    ```

    - Ejecuta `php artisan migrate`.

2.  **Controladores, Rutas y Lógica:**

    - Crea un `AcademicSettingsController`.
    - Define las rutas bajo el middleware `can:manage_academic_settings`. Necesitarás rutas para listar, crear, guardar, editar y actualizar los años académicos y sus periodos (rutas de tipo `resource` son ideales aquí).
    - **Lógica de Negocio Crítica:** Cuando un `AcademicYear` se marca como `is_active = true`, asegúrate de que todos los demás se marcan como `false`. Esto se puede hacer en un `Service` o usando Observers de Eloquent en el modelo `AcademicYear`.

    ```php
    // En App\Models\AcademicYear.php
    protected static function boot()
    {
        parent::boot();
        static::saving(function ($model) {
            if ($model->is_active) {
                self::where('id', '!=', $model->id)->update(['is_active' => false]);
            }
        });
    }
    ```

3.  **Vistas (Blade):**
    - Crea las vistas CRUD necesarias. La página principal `settings/academic/index.blade.php` mostrará una tabla de años académicos. Al hacer clic en uno, se podría ir a otra vista para gestionar sus periodos de calificación.

#### **Punto de Verificación (Hito 2):**

- **Pruebas Manuales:**
  1.  Como admin, crea un nuevo Año Académico.
  2.  Crea otro y márcalo como activo. Verifica que el anterior se desactiva automáticamente.
  3.  Añade periodos de calificación a un año académico.
- **Pruebas Automatizadas (Feature Tests):**
  - Crea un test: `php artisan make:test Settings/AcademicSettingsTest`
  ```php
  public function test_admin_can_create_an_academic_year() { ... }
  public function test_activating_one_year_deactivates_others() { ... }
  public function test_a_teacher_cannot_manage_academic_settings() { ... }
  ```
  - **¡Hito 2 completado y verificado!**

---

### **Hito 3: Ensamblaje Final y Configuración Global**

**Objetivo:** Unificar los componentes en una sola interfaz de usuario con pestañas y hacer que las configuraciones clave estén disponibles globalmente en la aplicación de manera eficiente.

#### **Pasos de Ejecución Detallados (Hito 3):**

1.  **Vista de Ensamblaje (Layout):**

    - Crea una vista principal `resources/views/settings/index.blade.php`.
    - Esta vista tendrá la estructura de navegación por pestañas (Pestaña "Institución", Pestaña "Académico", Pestaña "Roles y Permisos").
    - El contenido de cada pestaña se puede cargar dinámicamente o incluir desde las vistas parciales creadas en los hitos anteriores.

2.  **Disponibilidad Global de las Configuraciones (Helper y Middleware):**
    - Para evitar consultar la BBDD constantemente, crearemos un singleton y un helper.
    - **Crea un Service Provider:** `php artisan make:provider SettingsServiceProvider`
    - En `app/Providers/SettingsServiceProvider.php`, en el método `register()`:
    ```php
    $this->app->singleton(SettingsService::class, function ($app) {
        // Aquí se puede añadir lógica de caché para no golpear la BBDD
        return new SettingsService();
    });
    ```
    - Registra el provider en `config/app.php`.
    - **Crea un helper global:** En `app/helpers.php` (créalo si no existe y regístralo en `composer.json` en `autoload/files`):
    ```php
    if (! function_exists('setting')) {
        function setting($key, $default = null) {
            return app(App\Services\SettingsService::class)->get($key, $default);
        }
    }
    ```
    - Ahora, desde cualquier parte del código, puedes usar `setting('school_name')` para obtener el valor.

#### **Punto de Verificación (Hito 3):**

- **Pruebas Manuales:**

  1.  Navega a la página principal de configuración. Deberías ver las pestañas.
  2.  Haz clic en cada pestaña y verifica que se muestra el contenido correcto de los hitos anteriores.
  3.  Usa `tinker` para comprobar que el helper `setting('school_name')` funciona.
  4.  Usa el helper en una vista del `Dashboard`, por ejemplo, para mostrar el nombre de la escuela en el título. `<h1>{{ setting('school_name', 'Mi Escuela') }}</h1>`. Verifica que se muestra.

- **Pruebas Automatizadas:**
  - Un test que verifique que el helper devuelve el valor correcto de la base de datos.

---
