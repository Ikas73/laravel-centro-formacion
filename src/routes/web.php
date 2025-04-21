<?php

use Illuminate\Support\Facades\Route;

// --- Importa TODOS los controladores que necesitas ---
use App\Http\Controllers\ProfileController;   // Para el perfil (Breeze)
use App\Http\Controllers\CursoController;    // Para cursos
use App\Http\Controllers\AlumnoController;   // Para alumnos
use App\Http\Controllers\ProfesorController; // Para profesores
// No necesitas DashboardController si usas la función abajo, pero sí si lo cambias

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
*/

// Ruta pública de bienvenida
Route::get('/', function () {
    // Podrías redirigir a login/dashboard aquí si prefieres
    return view('welcome');
});

// Rutas que requieren autenticación
Route::middleware(['auth', 'verified'])->group(function () { // 'verified' es opcional (requiere verificación email)

    // Ruta del Dashboard
    Route::get('/dashboard', function () {
        return view('dashboard');
    })->name('dashboard');

    // Rutas del perfil de usuario (de Breeze)
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    // Rutas de Recursos CRUD para tu aplicación
    Route::resource('cursos', CursoController::class);
    Route::resource('alumnos', AlumnoController::class);
    Route::resource('profesores', ProfesorController::class);

});

// --- Carga las rutas de autenticación de Breeze ---
// Asegúrate que el archivo routes/auth.php existe
// require __DIR__.'/auth.php';