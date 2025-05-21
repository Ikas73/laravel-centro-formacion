<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>

    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=Nunito+Sans:wght@400;500;600;700&display=swap" rel="stylesheet" />
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet">

     <!-- Importar estilos y scripts con Vite -->
     @vite(['resources/css/app.css', 'resources/css/login.css', 'resources/js/app.js', 'resources/js/particles-config.js'])
    
    
</head>
<body class="font-sans antialiased">
    <!-- Particles.js Container -->
    <div id="particles-js"></div>

    <div class="content-wrapper min-h-screen flex flex-col items-center justify-center py-12 px-4 sm:px-6 lg:px-8">
        <div class="sm:mx-auto sm:w-full sm:max-w-md mb-6 flex flex-col items-center">
            <img src="{{ asset('images/centro-formacion-logo.png') }}" alt="Centro de Formación" class="logo-image mb-5">
            <h1 class="text-2xl font-bold text-white" style="text-shadow: 0 0 10px rgba(0, 225, 255, 0.6);">Centro de Formación</h1>
        </div>

        <div class="form-container w-full sm:max-w-md overflow-hidden">
            <div class="px-6 py-8 sm:px-10 sm:py-10">
                {{ $slot }}
            </div>
        </div>
        
        <div class="mt-6 text-center footer-text">
            © 2025 Centro de Formación · 
            <a href="#">Ayuda</a> · 
            <a href="#">Contacto</a>
        </div>
    </div>

    <!-- Particles.js -->
    <script src="https://cdn.jsdelivr.net/particles.js/2.0.0/particles.min.js"></script>
    
</body>
</html>