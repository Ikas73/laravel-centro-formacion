@push('styles')
<link href="{{ asset('css/welcome.css') }}" rel="stylesheet">
@endpush

@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center mt-5">
        <div class="col-md-10 col-lg-8">
            <div class="card shadow-sm border-0 rounded-4 text-center p-5">
                <div class="card-body">
                    <i class="bi bi-mortarboard-fill text-success display-1 mb-4"></i>
                    <h1 class="card-title display-6 fw-bold mb-3 mt-4">
                        {{ config('app.name', 'Centro de Fromación') }}
                    </h1>
                    <p class="card-text lead text-muted mb-4">
                        Bienvenido al sistema de gestión. Accede para administrar cursos, alumnos y profesores.
                    </p>
                    <div class="d-flex justify-content-center gap-3 mb-4 flex-wrap">
                        <a href="{{ route('dashboard') }}" class="square-btn btn-primary">
                            <i class="bi bi-speedometer2"></i>
                            <span>Panel</span>
                        </a>
                        <a href="{{ route('cursos.index') }}" class="square-btn btn-primary">
                            <i class="bi bi-journal-bookmark-fill"></i>
                            <span>Cursos</span>
                        </a>
                        <a href="{{ route('alumnos.index') }}" class="square-btn btn-primary">
                            <i class="bi bi-people-fill"></i>
                            <span>Alumnos</span>
                        </a>
                        <a href="{{ route('profesores.index') }}" class="square-btn btn-primary">
                            <i class="bi bi-person-badge-fill"></i>
                            <span>Profesores</span>
                        </a>
                    </div>
                </div>
                <div class="card-footer bg-transparent border-0 mt-3">
                    <small class="text-muted">© {{ date('Y') }} Centro de Formación · <a href="#">Ayuda</a></small>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
