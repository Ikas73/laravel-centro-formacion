<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth; // Necesario para la simulación de login
use App\Models\User;                 // Necesario para la simulación de login

/*
|--------------------------------------------------------------------------
| Controladores
|--------------------------------------------------------------------------
|
| Importa todos los controladores que usarás en tus rutas.
| Separa los controladores de Admin para mayor claridad.
|
*/

// --- Controladores Estándar (ej: Breeze / Perfil) ---
use App\Http\Controllers\ProfileController;

// --- Controladores del Panel de Administración ---
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\CursoController;
use App\Http\Controllers\Admin\AlumnoController;
use App\Http\Controllers\Admin\ProfesorController;
use App\Http\Controllers\Admin\EventoController;
// Añade aquí otros controladores de Admin a medida que los crees
// use App\Http\Controllers\Admin\PreinscritoController;
// use App\Http\Controllers\Admin\ReporteController;
// use App\Http\Controllers\Admin\FinanzaController;
// use App\Http\Controllers\Admin\ConfiguracionController;


/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Aquí es donde puedes registrar rutas web para tu aplicación. Estas
| rutas son cargadas por RouteServiceProvider dentro de un grupo que
| contiene el middleware "web". ¡Crea algo genial!
|
*/




// --- Rutas Protegidas (Requieren Autenticación) ---
// Todas las rutas dentro de este grupo requerirán que el usuario haya iniciado sesión.
// El middleware 'verified' es opcional, solo si usas la verificación de email de Laravel.
Route::middleware(['auth', 'verified'])->group(function () {

    // --- Rutas de Inicio (Dashboard) ---
    // Ruta principal de bienvenida
    Route::get('/', function () {
        return view('welcome');
        })->name('welcome'); // Es buena práctica nombrar todas las rutas

    // --- Rutas de Perfil de Usuario (Estándar, fuera del prefijo /admin) ---
    Route::prefix('profile')->name('profile.')->group(function () {
        Route::get('/', [ProfileController::class, 'edit'])->name('edit');
        Route::patch('/', [ProfileController::class, 'update'])->name('update');
        Route::delete('/', [ProfileController::class, 'destroy'])->name('destroy');
    });


    // --- Grupo para Rutas Específicas de Administración ---
    Route::prefix('admin') // URL base será /admin/...
          ->name('admin.')   // Nombre de ruta base será admin... (ej: admin.dashboard)
          // ->middleware(['can:access-admin']) // Opcional: Añade aquí middleware de autorización específico para admin si tienes roles/permisos
          ->group(function () {

            // Dashboard de Administración
            Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

            // Recursos CRUD para Administración
            Route::resource('profesores', ProfesorController::class);
            Route::resource('alumnos', AlumnoController::class);
            Route::resource('cursos', CursoController::class);
            Route::resource('eventos', EventoController::class);
            // Route::resource('preinscritos', PreinscritoController::class); // Descomenta cuando implementes

            // Rutas para otras secciones (apuntando a controladores o closures temporales)
            Route::get('/reportes', function () { return 'Admin Reportes (Pendiente)'; })->name('reportes.index'); // O usa ReporteController::class, 'index'
            Route::get('/finanzas', function () { return 'Admin Finanzas (Pendiente)'; })->name('finanzas.index'); // O usa FinanzaController::class, 'index'
            Route::get('/configuracion', function () { return 'Admin Configuración (Pendiente)'; })->name('configuracion.index'); // O usa ConfiguracionController::class, 'index'

            // Puedes añadir más rutas específicas de admin aquí...

          }); // --- Fin del grupo admin ---

}); // --- Fin del grupo auth ---


// --- Rutas de Autenticación (Login, Registro, Logout, etc.) ---
// ¡IMPORTANTE! Esta línea carga las rutas definidas en routes/auth.php
// que generalmente son creadas por Laravel Breeze, Jetstream o UI.
// Estas rutas incluyen la ruta nombrada 'logout' que necesitas.
require __DIR__.'/auth.php';


// --- Ruta de Simulación de Login (SOLO PARA DESARROLLO LOCAL) ---
// Permite saltar el login durante el desarrollo para acceder rápidamente al panel.
// Asegúrate de que NO esté activa en producción.
// En routes/web.php
    Route::get('/login-dev', function () {
        if (!app()->environment('local')) {
            return redirect()->route('login');
        }

        $user = User::where('email', 'admin@admin.com')->first(); // Busca el usuario

        if ($user) {
            Auth::login($user); // Loguea si existe
            request()->session()->regenerate();
            return redirect()->intended(route('admin.dashboard'));
        } else {
            // Informar que el usuario no se encontró (debería haber sido creado por el seeder)
            return "Error: Usuario admin@admin.com no encontrado. ¿Se ejecutó 'php artisan migrate:fresh --seed'?";
        }

    })->name('login.dev');