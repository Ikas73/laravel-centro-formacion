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
use App\Http\Controllers\Admin\ScheduleController;   // ← IMPORTANTE
use App\Http\Controllers\Settings\InstitutionSettingsController;
use App\Http\Controllers\Settings\AcademicYearController;
use App\Http\Controllers\Settings\GradingPeriodController;


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

    // --- Rutas de Perfil de Usuario (sin cambios) ---
    Route::prefix('profile')->name('profile.')->group(function () {
        Route::get('/', [ProfileController::class, 'edit'])->name('edit');
        Route::patch('/', [ProfileController::class, 'update'])->name('update');
        Route::delete('/', [ProfileController::class, 'destroy'])->name('destroy');
    });

    // --- Grupo para Rutas Específicas de Administración (sin cambios en este bloque) ---
    Route::prefix('admin')
          ->name('admin.')
          ->group(function () { // 'auth' y 'verified' ya se aplican por el grupo padre

            // Dashboard de Administración
            Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

            // ... (todas tus rutas de admin: profesores, alumnos, cursos, etc., permanecen igual) ...
            Route::resource('profesores', ProfesorController::class);
            Route::resource('alumnos', AlumnoController::class);
            Route::resource('cursos', CursoController::class);
            Route::resource('eventos', EventoController::class);
            Route::resource('preinscritos', PreinscritoSepeController::class);
            // --- RUTAS DE SCHEDULES (ORDEN CORRECTO) ---
            Route::post('schedules/check-conflict', [ScheduleController::class, 'checkConflict'])->name('schedules.checkConflict');

            // 1. Ruta específica para 'conflicts' se define PRIMERO.
            Route::get('schedules/conflicts', [ScheduleController::class, 'showConflicts'])->name('schedules.conflicts');

            // 2. Ruta resource, que es más genérica, se define DESPUÉS.
            Route::resource('schedules', ScheduleController::class);

            Route::get('schedule', [\App\Http\Controllers\Admin\ScheduleController::class, 'index'])->name('schedule.index');
            Route::get('schedule/events', [\App\Http\Controllers\Admin\ScheduleController::class, 'fetchEvents'])->name('schedule.events');
            Route::post('/preinscritos/{preinscrito}/convertir', [PreinscritoSepeController::class, 'convertirAAlumno'])->name('preinscritos.convertir');
            Route::delete('/alumnos/{alumno}/cursos/{curso}', [AlumnoController::class, 'desinscribirCurso'])->name('alumnos.cursos.desinscribir');
            Route::get('/alumnos/{alumno}/cursos-disponibles', [AlumnoController::class, 'getCursosDisponibles'])->name('alumnos.cursos.disponibles');
            Route::post('/alumnos/{alumno}/inscribir', [AlumnoController::class, 'inscribirCurso'])->name('alumnos.cursos.inscribir');
            Route::get('/reportes', function () { return 'admin.reportes.index'; })->name('reportes.index');
            Route::get('/finanzas', function () { return 'Admin Finanzas (Pendiente)'; })->name('finanzas.index');
            Route::get('/configuracion', function () { return 'Admin Configuración (Pendiente)'; })->name('configuracion.index');

    }); // --- Fin del grupo admin ---

    // --- GRUPO PARA RUTAS DE CONFIGURACIÓN (MODIFICADO) ---
    // El middleware 'can:access_settings' se aplica a todo el grupo
    Route::middleware(['can:access_settings'])->prefix('settings')->name('settings.')->group(function () {
        
        // 1. (NUEVO) Ruta principal para la vista unificada con pestañas.
        Route::get('/', [InstitutionSettingsController::class, 'index'])->name('index');

        // 2. (MODIFICADO) Rutas para la pestaña "Institution".
        //    Ya no necesitan su propio prefijo, solo el middleware de autorización específico.
        Route::middleware(['can:manage_institution_settings'])->group(function () {
            // La ruta GET '/institution' ya no es necesaria, la maneja la ruta principal 'index'.
            // La ruta POST ahora no tiene prefijo, es simplemente 'settings.institution.update'.
            Route::post('/institution', [InstitutionSettingsController::class, 'update'])->name('institution.update');
        });

        // 3. (MODIFICADO) Rutas para la pestaña "Academic".
        //    Se protegen con su propio middleware y se mantienen como resource.
        Route::middleware(['can:manage_academic_settings'])->group(function () {
            Route::resource('academic-years', AcademicYearController::class);
            Route::resource('grading-periods', GradingPeriodController::class)->except(['index', 'show']); // No necesitamos vistas separadas para estos
        });

    }); // --- Fin del grupo settings ---

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

