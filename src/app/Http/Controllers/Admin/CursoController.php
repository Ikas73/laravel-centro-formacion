<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Curso; // Importa el modelo Curso
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB; // Si planeas usar DB::raw
use Illuminate\Support\Facades\Log;

class CursoController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        // Lógica temporal para que la ruta funcione
    // Antes: $this->command->info("Accediendo a CursoController@index");
    Log::info("Accediendo a CursoController@index"); // <--- CAMBIADO A Log::info()

        

        // Por ahora, solo devolvemos una vista simple o un string
        // return "Página de lista de Cursos (Pendiente)";

        // O si ya tienes una vista placeholder:
        // $cursos = Curso::paginate(10);
        // return view('admin.cursos.index', compact('cursos'));

        // **SIMPLEMENTE PARA EVITAR EL ERROR AHORA, HAZ ESTO:**
        // Si no tienes la vista admin.cursos.index creada, esto podría dar otro error (View not found).
        // Si es así, crea un archivo vacío resources/views/admin/cursos/index.blade.php
        // o simplemente devuelve un string por ahora.
        if (view()->exists('admin.cursos.index')) {
            $cursos = Curso::paginate(10); // Descomenta cuando tengas datos reales
            // return view('admin.cursos.index', compact('cursos'));
            return view('admin.cursos.index', ['cursos' => Curso::paginate(10)]); // Para probar
        } else {
            // Crea un archivo temporal si no existe la vista para evitar otro error
            // resources/views/admin/cursos/index.blade.php
            // con contenido: @extends('layouts.admin') @section('content') <p>Lista Cursos</p> @endsection
            return "Vista para admin.cursos.index no encontrada aún. Debes crearla en resources/views/admin/cursos/index.blade.php";
        }
    }

    // Aquí deberían estar los otros métodos generados por --resource
    // public function create() { /* ... */ }
    // public function store(Request $request) { /* ... */ }
    // public function show(Curso $curso) { /* ... */ }
    // public function edit(Curso $curso) { /* ... */ }
    // public function update(Request $request, Curso $curso) { /* ... */ }
    // public function destroy(Curso $curso) { /* ... */ }
}