<?php

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
    }
    return view('welcome');
})->name('welcome');


// --- Rutas de Autenticación (Login, Registro, Logout, etc.) ---
// Esta línea carga las rutas definidas en routes/auth.php (generado por Breeze)
require __DIR__.'/auth.php';


// --- Rutas que Requieren Autenticación ---
Route::middleware(['auth', 'verified'])->group(function () {

    // --- Rutas de Perfil de Usuario ---
    Route::prefix('profile')->name('profile.')->group(function () {
        Route::get('/', [ProfileController::class, 'edit'])->name('edit');
        Route::patch('/', [ProfileController::class, 'update'])->name('update');
        Route::delete('/', [ProfileController::class, 'destroy'])->name('destroy');
    });

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

            // Ruta para convertir preinscrito
            Route::post('/preinscritos/{preinscrito}/convertir', [PreinscritoSepeController::class, 'convertirAAlumno'])
                  ->name('preinscritos.convertir');

            // Placeholders para otras secciones de admin
            Route::get('/reportes', function () { return 'Admin Reportes (Pendiente)'; })->name('reportes.index');
            Route::get('/finanzas', function () { return 'Admin Finanzas (Pendiente)'; })->name('finanzas.index');
            Route::get('/configuracion', function () { return 'Admin Configuración (Pendiente)'; })->name('configuracion.index');
          }); // --- Fin del grupo admin ---

}); // --- Fin del grupo principal 'auth', 'verified' ---


// --- Ruta de Simulación de Login (SOLO PARA DESARROLLO LOCAL) ---
Route::get('/login-dev', function () {
    if (!app()->environment('local')) {
        return redirect()->route('login'); // En producción, siempre al login real
    }

    $user = User::firstOrCreate(
        ['email' => 'admin@admin.com'], // Usuario admin de prueba
        [
            'name' => 'Admin Dev',
            'password' => bcrypt('password'), // Contraseña de prueba
            'email_verified_at' => now()
        ]
    );
    Auth::login($user);
    request()->session()->regenerate();
    return redirect()->intended(route('admin.dashboard'));
})->name('login.dev');