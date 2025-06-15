<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'Admin Panel') - {{ config('app.name', 'Laravel') }}</title>

    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">

    @vite(['resources/css/app.css', 'resources/js/app.js'])
    {{-- Si tienes un admin.css específico, impórtalo aquí también --}}
    {{-- @vite(['resources/css/admin.css']) --}}

    @stack('styles')

    
</head>

<body class="font-sans antialiased">

    <div class="admin-layout-wrapper"> {{-- Nuevo contenedor --}}

        <!-- ======================= Sidebar ======================= -->
        <nav id="sidebarMenu" class="sidebar">
            <div class="sidebar-header">
                 <a class="text-decoration-none" href="{{ route('admin.dashboard') }}">
                     {{-- Puedes usar un <img> si tienes un logo gráfico --}}
                     {{-- <img src="{{ asset('images/logo-east-bridge.png') }}" alt="East Bridge Logo" class="h-8 w-auto mb-1"> --}}
                     <span class="app-name">EAST BRIDGE</span>
                     <span class="app-subtitle block">High School Dashboard</span>
                 </a>
            </div>

            <div class="sidebar-nav">
                <ul class="nav flex-column">
                    <li class="nav-item">
                        <a class="nav-link {{ request()->routeIs('admin.dashboard') ? 'active' : '' }}" href="{{ route('admin.dashboard') }}">
                            <i class="bi bi-grid-1x2-fill"></i>Dashboard
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link {{ request()->routeIs('admin.alumnos.*') ? 'active' : '' }}" href="{{ route('admin.alumnos.index') }}">
                            <i class="bi bi-people-fill"></i>Students
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link {{ request()->routeIs('admin.profesores.*') ? 'active' : '' }}" href="{{ route('admin.profesores.index') }}">
                            <i class="bi bi-person-video3"></i>Teachers
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link {{ request()->routeIs('admin.cursos.*') ? 'active' : '' }}" href="{{ route('admin.cursos.index') }}">
                            <i class="bi bi-collection-fill"></i>Courses
                        </a>
                    </li>
                    <li class="nav-item">
                        {{-- Necesitarás crear la ruta admin.preinscritos.index --}}
                        <a class="nav-link {{ request()->routeIs('admin.preinscritos.*') ? 'active' : '' }}" href="{{ route('admin.preinscritos.index') }}">
                            <i class="bi bi-person-check-fill"></i>Preinscritos
                        </a>
                    </li>
                    <li class="nav-item">
                        {{-- Necesitarás crear la ruta admin.schedule.index --}}
                        <a class="nav-link {{ request()->routeIs('admin.schedule.*') ? 'active' : '' }}" href="#">
                            <i class="bi bi-calendar3-week-fill"></i>Schedule
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link {{ request()->routeIs('admin.reportes.*') ? 'active' : '' }}" href="{{ route('admin.reportes.index') }}">
                            <i class="bi bi-file-earmark-bar-graph-fill"></i>Reports
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link {{ request()->routeIs('admin.configuracion.*') ? 'active' : '' }}" href="{{ route('admin.configuracion.index') }}">
                            <i class="bi bi-gear-fill"></i>Settings
                        </a>
                    </li>
                    {{-- Aquí puedes añadir los otros enlaces que faltan como Events, Messages, Announcements --}}
                    {{-- Y el enlace de Logout si quieres que esté en la sidebar --}}
                </ul>
            </div>
        </nav>

        <!-- ===================== Contenido Principal ===================== -->
        <main class="main-content">

            <!-- Header Interno (Título de la página, Búsqueda Opcional, Notificaciones, Usuario) -->
            <header class="content-header">
               {{-- Título de la página actual (puede venir de @yield('header-title') o de la vista) --}}
               {{-- Para el dashboard: "Dashboard Overview" ya está en la vista dashboard.blade.php --}}
               <div>
                   {{-- Placeholder si quisieras un título dinámico aquí --}}
                   {{-- <h1 class="text-xl font-semibold text-gray-700">@yield('header-title', 'Page Title')</h1> --}}
               </div>

               {{-- Iconos y Avatar/Dropdown de Usuario (Ejemplo similar al de Breeze) --}}
               <div class="flex items-center"> {{-- ms-auto para empujar a la derecha --}}
                   {{-- Icono de Notificaciones (Ejemplo) --}}
                   <a href="#" class="text-gray-500 hover:text-gray-700 me-4 position-relative">
                       <i class="bi bi-bell-fill fs-5"></i>
                       <span class="position-absolute top-0 start-100 translate-middle p-1 bg-danger border border-light rounded-circle" style="font-size: 0.5rem;">
                            <span class="visually-hidden">Nuevas alertas</span>
                       </span>
                   </a>

                   {{-- Dropdown de Usuario --}}
       @auth
       {{-- En layouts/admin.blade.php, dentro del @auth --}}
<div x-data="{ open: false }" class="relative"> {{-- <--- ¡AÑADIDO X-DATA AQUÍ! --}}
    {{-- Botón que activa el dropdown --}}
    <button @click="open = !open" class="flex items-center text-sm font-medium text-gray-700 hover:text-gray-900 focus:outline-none transition duration-150 ease-in-out">
        <i class="bi bi-person-circle text-2xl mr-2"></i>
        <div class="text-left">
            <span class="block">{{ Auth::user()->name }}</span>
            <span class="block text-xs text-gray-500">System Administrator</span>
        </div>
        <svg class="ml-2 -mr-0.5 h-4 w-4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
            <path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd" />
        </svg>
    </button>

    {{-- Menú del Dropdown --}}
    <div x-show="open"
         x-transition:enter="transition ease-out duration-100"
         x-transition:enter-start="transform opacity-0 scale-95"
         x-transition:enter-end="transform opacity-100 scale-100"
         x-transition:leave="transition ease-in duration-75"
         x-transition:leave-start="transform opacity-100 scale-100"
         x-transition:leave-end="transform opacity-0 scale-95"
         class="absolute right-0 mt-2 w-48 rounded-md shadow-lg py-1 bg-white ring-1 ring-black ring-opacity-5 focus:outline-none z-50"
         style="display: none;" {{-- Alpine maneja esto, display:none es fallback --}}
         @click.away="open = false">
        <a href="{{ route('profile.edit') }}" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">Mi Perfil</a>
        <a href="{{ route('admin.configuracion.index') }}" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">Configuración</a>
        <div class="border-t border-gray-100 my-1"></div> {{-- Ajustado my-1 para un pequeño margen --}}
        <form method="POST" action="{{ route('logout') }}">
            @csrf
            <button type="submit" class="block w-full text-left px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">
                Salir
            </button>
        </form>
    </div>
</div>
                    @else
                        <a href="{{ route('login') }}" class="text-sm text-gray-700 underline">Log in</a>
                    @endauth
               </div>
            </header>

            <!-- Contenido específico de la página actual -->
            <div class="mt-0"> {{-- Eliminado margen superior si el header ya tiene inferior --}}
                @yield('content')
            </div>

             <footer class="pt-4 mt-4 text-muted border-top small">
                © {{ date('Y') }} {{ config('app.name', 'Centro Formación') }}
            </footer>

        </main>
    </div>

    @stack('scripts')
    
    {{-- ... otros scripts que puedas tener ... --}}
    <script>
        // Función para ABRIR el modal y configurar su contenido
    function confirmDelete(actionUrl, itemName) {
        const deleteForm = document.getElementById('deleteForm');
        const deleteModal = document.getElementById('deleteModal');
        const modalBody = deleteModal.querySelector('.text-sm.text-gray-500'); // Selector más específico para el cuerpo del mensaje

        if(deleteForm && deleteModal && modalBody) {
            // Establecer la acción del formulario
            deleteForm.action = actionUrl;
            // Construir el cuerpo del mensaje dinámicamente
            modalBody.innerHTML = `¿Estás seguro de que quieres eliminar a <strong class="font-semibold text-gray-700">${itemName}</strong>? <br> Esta acción no se puede deshacer.`;
            // Mostrar el modal
            deleteModal.classList.remove('hidden');
        } else {
            console.error('Elementos del modal de eliminación no encontrados.');
        }
    }

    // Función para CERRAR el modal
    function closeDeleteModal() {
        const deleteModal = document.getElementById('deleteModal');
        if (deleteModal) {
            deleteModal.classList.add('hidden');
        }
    }

    // (Opcional) Cerrar modal con la tecla ESC
    document.addEventListener('keydown', function(event) {
        if (event.key === 'Escape' && !document.getElementById('deleteModal').classList.contains('hidden')) {
            closeDeleteModal();
        }
    });
    </script>
</body>


</html>