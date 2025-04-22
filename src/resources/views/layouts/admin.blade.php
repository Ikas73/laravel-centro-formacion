{{-- // Archivo: resources/views/layouts/app.blade.php --}}
<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" data-bs-theme="light"> {{-- data-bs-theme para Bootstrap 5.3+ tema claro/oscuro --}}
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}"> {{-- Token CSRF para formularios y AJAX --}}

    <title>@yield('title', config('app.name', 'CRM Centro'))</title> {{-- Título dinámico o por defecto --}}

    <!-- Fuentes -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" /> {{-- Fuente predeterminada de Laravel --}}

    <!-- Iconos Bootstrap Icons (vía CDN) -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">

    <!-- Scripts y Estilos compilados por Vite -->
    {{-- Asegúrate de importar Bootstrap CSS/JS en tus archivos resources/css/app.css y resources/js/app.js --}}
    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <!-- Permite añadir estilos específicos desde las vistas hijas -->
    @stack('styles')
</head>
<body class="d-flex flex-column min-vh-100 font-sans antialiased bg-light"> {{-- Clases Bootstrap para layout de página completa y fondo --}}

    {{-- Incluir la Barra de Navegación --}}
    {{-- Puedes crear un archivo separado para la navbar y usar @include --}}
    {{-- Ejemplo: @include('layouts.partials.navbar') --}}
    {{-- O pega aquí el código de tu navbar directamente --}}
    <nav class="navbar navbar-expand-lg navbar-dark bg-success shadow-sm mb-4"> {{-- Ejemplo Navbar --}}
        <div class="container">
            <a class="navbar-brand fw-bold" href="{{ url('/') }}">
                 <i class="bi bi-mortarboard-fill me-2"></i>
                {{ config('app.name', 'Centro Formación') }}
            </a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#mainNavLayout" aria-controls="mainNavLayout" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="mainNavLayout">
                <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                    <li class="nav-item">
                        <a class="nav-link {{ request()->routeIs('dashboard') ? 'active' : '' }}" href="{{ route('dashboard') }}">Panel</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link {{ request()->routeIs('cursos.*') ? 'active' : '' }}" href="{{ route('cursos.index') }}">Cursos</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link {{ request()->routeIs('alumnos.*') ? 'active' : '' }}" href="{{ route('alumnos.index') ?? '#' }}">Alumnos</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link {{ request()->routeIs('profesores.*') ? 'active' : '' }}" href="{{ route('profesores.index') ?? '#' }}">Profesores</a>
                    </li>
                </ul>
                 <ul class="navbar-nav ms-auto mb-2 mb-lg-0">
                    @guest
                        @if (Route::has('login'))
                            <li class="nav-item">
                                <a class="nav-link" href="{{ route('login') }}">{{ __('Acceder') }}</a>
                            </li>
                        @endif
                         @if (Route::has('register'))
                            <li class="nav-item">
                                <a class="nav-link" href="{{ route('register') }}">{{ __('Registrarse') }}</a>
                            </li>
                        @endif
                    @else
                        <li class="nav-item dropdown">
                            <a id="navbarDropdown" class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>
                                {{ Auth::user()->name }}
                            </a>

                            <div class="dropdown-menu dropdown-menu-end" aria-labelledby="navbarDropdown">
                                <a class="dropdown-item" href="{{ route('profile.edit') }}"> {{-- Asumiendo ruta de Breeze --}}
                                    {{ __('Perfil') }}
                                </a>
                                <a class="dropdown-item" href="{{ route('logout') }}"
                                   onclick="event.preventDefault();
                                                 document.getElementById('logout-form').submit();">
                                    {{ __('Salir') }}
                                </a>

                                <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                                    @csrf
                                </form>
                            </div>
                        </li>
                    @endguest
                </ul>
            </div>
        </div>
    </nav>

    <!-- Contenido Principal de la Página -->
    <main class="flex-grow-1"> {{-- flex-grow-1 empuja el footer hacia abajo --}}
        @yield('content') {{-- Aquí se inyectará el contenido de las vistas hijas --}}
    </main>

    <!-- Footer -->
    <footer class="bg-dark text-white py-4 mt-auto"> {{-- mt-auto también ayuda a empujar al fondo --}}
        <div class="container">
            <div class="text-center text-secondary small">
                © {{ date('Y') }} {{ config('app.name', 'Centro Formación') }}. Todos los derechos reservados.
            </div>
        </div>
    </footer>

    <!-- Permite añadir scripts específicos desde las vistas hijas -->
    @stack('scripts')

</body>
</html>