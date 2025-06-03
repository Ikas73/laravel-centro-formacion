<x-app-layout>
    {{-- Fondo con gradiente mejorado y más inmersivo --}}
    <div class="bg-gradient-to-br from-blue-50 via-gray-100 to-indigo-50 dark:from-gray-900 dark:via-gray-800 dark:to-blue-900 min-h-screen flex items-center justify-center py-14 px-4 sm:px-6 lg:px-8 transition-all duration-300">
        <div class="w-full max-w-2xl lg:max-w-4xl"> {{-- Aumentado el ancho máximo para mejor balance en pantallas grandes --}}

            {{-- Tarjeta con diseño refinado y sombras más sutiles --}}
            <div class="bg-white dark:bg-gray-800 shadow-lg hover:shadow-xl transition-shadow duration-300 rounded-3xl text-center p-8 md:p-10 border border-gray-100 dark:border-gray-700"> 

                {{-- Contenedor del logo mejorado con animación sutil --}}
                <div class="mb-8 transform transition-transform duration-500 hover:scale-105"> 
                    <img src="{{ asset('images/logo-centro.svg') }}"
                        alt="Logo Centro de Formación"
                        class="inline-block w-auto h-[9rem] rounded-xl p-3 bg-gradient-to-br from-blue-50 to-indigo-100 dark:from-blue-900 dark:to-indigo-800 shadow-md">
                </div>

                {{-- Título con mejor jerarquía visual y tipografía optimizada --}}
                <h1 class="text-3xl lg:text-4xl font-bold mb-4 bg-clip-text text-transparent bg-gradient-to-r from-gray-800 to-gray-600 dark:from-gray-100 dark:to-blue-100">
                    {{ config('app.name', 'Centro de Formación') }}
                </h1>

                {{-- Descripción con mejor legibilidad --}}
                <p class="text-lg text-gray-600 dark:text-gray-300 mb-10 max-w-2xl mx-auto leading-relaxed">
                    Bienvenido al sistema de gestión. Accede para administrar cursos, alumnos y profesores de manera eficiente e intuitiva.
                </p>

                {{-- Contenedor de botones con nuevo diseño y disposición --}}
<div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6 mb-10 px-4">

    {{-- Botón Panel con diseño mejorado y efecto brillante --}}
    <a href="{{ route('admin.dashboard') }}"
       class="group relative flex flex-col items-center justify-center rounded-2xl bg-white dark:bg-gray-800 text-gray-700 dark:text-gray-200 font-medium text-lg p-6 h-[150px] border border-blue-100 dark:border-blue-900 shadow-md hover:shadow-blue-200 dark:hover:shadow-blue-900/20 transition-all duration-300 overflow-hidden">
        {{-- Barra superior de color --}}
        <div class="absolute top-0 left-0 w-full h-1 bg-[#166871]"></div>
        
        {{-- Efecto brillante con animación --}}
        <div class="absolute -inset-1 bg-gradient-to-r from-transparent via-blue-200/40 to-transparent opacity-0 group-hover:opacity-100 blur-sm group-hover:animate-shine transition-opacity duration-500"></div>
        
        {{-- Contenido principal --}}
        <div class="relative flex flex-col items-center z-10">
            <div class="mb-4 relative bg-gradient-to-br from-[#166871] to-[#0d4d56] p-4 rounded-xl text-white transform transition-transform duration-300 group-hover:scale-110 group-hover:rotate-3 shadow-lg shadow-blue-500/20">
                {{-- Icono de Dashboard --}}
                <svg xmlns="http://www.w3.org/2000/svg" class="w-9 h-9" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.75" d="M4 5a1 1 0 011-1h14a1 1 0 011 1v2a1 1 0 01-1 1H5a1 1 0 01-1-1V5zM4 13a1 1 0 011-1h6a1 1 0 011 1v6a1 1 0 01-1 1H5a1 1 0 01-1-1v-6zM16 13a1 1 0 011-1h2a1 1 0 011 1v6a1 1 0 01-1 1h-2a1 1 0 01-1-1v-6z" />
                </svg>
            </div>
            <span class="tracking-wide font-semibold text-gray-800 dark:text-gray-200">Panel</span>
        </div>
        
        {{-- Gradiente inferior --}}
        <div class="absolute bottom-0 left-0 w-full h-24 bg-gradient-to-t from-blue-50/80 to-transparent dark:from-blue-900/20 dark:to-transparent transform transition-transform duration-500 group-hover:translate-y-1"></div>
    </a>
    
    {{-- Botón Cursos con diseño mejorado y efecto brillante --}}
    <a href="{{ route('admin.cursos.index') }}"
       class="group relative flex flex-col items-center justify-center rounded-2xl bg-white dark:bg-gray-800 text-gray-700 dark:text-gray-200 font-medium text-lg p-6 h-[150px] border border-indigo-100 dark:border-indigo-900 shadow-md hover:shadow-indigo-200 dark:hover:shadow-indigo-900/20 transition-all duration-300 overflow-hidden">
        {{-- Barra superior de color --}}
        <div class="absolute top-0 left-0 w-full h-1 bg-[#294c79]"></div>
        
        {{-- Efecto brillante con animación --}}
        <div class="absolute -inset-1 bg-gradient-to-r from-transparent via-indigo-200/40 to-transparent opacity-0 group-hover:opacity-100 blur-sm group-hover:animate-shine transition-opacity duration-500"></div>
        
        {{-- Contenido principal --}}
        <div class="relative flex flex-col items-center z-10">
            <div class="mb-4 relative bg-gradient-to-br from-[#294c79] to-[#1a3255] p-4 rounded-xl text-white transform transition-transform duration-300 group-hover:scale-110 group-hover:rotate-3 shadow-lg shadow-indigo-500/20">
                {{-- Icono de Libro/Cursos --}}
                <svg xmlns="http://www.w3.org/2000/svg" class="w-9 h-9" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.75" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253" />
                </svg>
            </div>
            <span class="tracking-wide font-semibold text-gray-800 dark:text-gray-200">Cursos</span>
        </div>
        
        {{-- Gradiente inferior --}}
        <div class="absolute bottom-0 left-0 w-full h-24 bg-gradient-to-t from-indigo-50/80 to-transparent dark:from-indigo-900/20 dark:to-transparent transform transition-transform duration-500 group-hover:translate-y-1"></div>
    </a>
    
    {{-- Botón Alumnos con diseño mejorado y efecto brillante --}}
    <a href="{{ route('admin.alumnos.index') }}"
       class="group relative flex flex-col items-center justify-center rounded-2xl bg-white dark:bg-gray-800 text-gray-700 dark:text-gray-200 font-medium text-lg p-6 h-[150px] border border-purple-100 dark:border-purple-900 shadow-md hover:shadow-purple-200 dark:hover:shadow-purple-900/20 transition-all duration-300 overflow-hidden">
        {{-- Barra superior de color --}}
        <div class="absolute top-0 left-0 w-full h-1 bg-[#294c79]"></div>
        
        {{-- Efecto brillante con animación --}}
        <div class="absolute -inset-1 bg-gradient-to-r from-transparent via-purple-200/40 to-transparent opacity-0 group-hover:opacity-100 blur-sm group-hover:animate-shine transition-opacity duration-500"></div>
        
        {{-- Contenido principal --}}
        <div class="relative flex flex-col items-center z-10">
            <div class="mb-4 relative bg-gradient-to-br from-[#294c79] to-[#1a3255] p-4 rounded-xl text-white transform transition-transform duration-300 group-hover:scale-110 group-hover:rotate-3 shadow-lg shadow-purple-500/20">
                {{-- Icono de Alumnos --}}
                <svg xmlns="http://www.w3.org/2000/svg" class="w-9 h-9" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.75" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z" />
                </svg>
            </div>
            <span class="tracking-wide font-semibold text-gray-800 dark:text-gray-200">Alumnos</span>
        </div>
        
        {{-- Gradiente inferior --}}
        <div class="absolute bottom-0 left-0 w-full h-24 bg-gradient-to-t from-purple-50/80 to-transparent dark:from-purple-900/20 dark:to-transparent transform transition-transform duration-500 group-hover:translate-y-1"></div>
    </a>
    
    {{-- Botón Profesores con icono de graduado y efecto brillante --}}
    <a href="{{ route('admin.profesores.index') }}"
       class="group relative flex flex-col items-center justify-center rounded-2xl bg-white dark:bg-gray-800 text-gray-700 dark:text-gray-200 font-medium text-lg p-6 h-[150px] border border-green-100 dark:border-green-900 shadow-md hover:shadow-green-200 dark:hover:shadow-green-900/20 transition-all duration-300 overflow-hidden">
        {{-- Barra superior de color --}}
        <div class="absolute top-0 left-0 w-full h-1 bg-[#294c79]"></div>
        
        {{-- Efecto brillante con animación --}}
        <div class="absolute -inset-1 bg-gradient-to-r from-transparent via-green-200/40 to-transparent opacity-0 group-hover:opacity-100 blur-sm group-hover:animate-shine transition-opacity duration-500"></div>
        
        {{-- Contenido principal --}}
        <div class="relative flex flex-col items-center z-10">
            <div class="mb-4 relative bg-gradient-to-br from-[#294c79] to-[#1a3255] p-4 rounded-xl text-white transform transition-transform duration-300 group-hover:scale-110 group-hover:rotate-3 shadow-lg shadow-green-500/20">
                {{-- Icono de sombrero de graduado --}}
                <svg xmlns="http://www.w3.org/2000/svg" class="w-9 h-9" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.75" d="M12 14l9-5-9-5-9 5 9 5z" />
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.75" d="M12 14l6.16-3.422a12.083 12.083 0 01.665 6.479A11.952 11.952 0 0012 20.055a11.952 11.952 0 00-6.824-2.998 12.078 12.078 0 01.665-6.479L12 14z" />
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.75" d="M12 14v4" />
                </svg>
            </div>
            <span class="tracking-wide font-semibold text-gray-800 dark:text-gray-200">Profesores</span>
        </div>
        
        {{-- Gradiente inferior --}}
        <div class="absolute bottom-0 left-0 w-full h-24 bg-gradient-to-t from-green-50/80 to-transparent dark:from-green-900/20 dark:to-transparent transform transition-transform duration-500 group-hover:translate-y-1"></div>
    </a>
</div>

                {{-- Footer de la Tarjeta mejorado --}}
                <div class="mt-6 pt-5 border-t border-gray-200 dark:border-gray-700">
                    <div class="flex justify-center items-center flex-wrap gap-4">
                        <small class="text-gray-500 dark:text-gray-400">
                            © {{ date('Y') }} Centro de Formación
                        </small>
                        <div class="flex space-x-4">
                            <a href="#" class="text-blue-600 dark:text-blue-400 hover:text-blue-800 dark:hover:text-blue-300 hover:underline transition-colors duration-200 text-sm">Ayuda</a>
                            <a href="#" class="text-blue-600 dark:text-blue-400 hover:text-blue-800 dark:hover:text-blue-300 hover:underline transition-colors duration-200 text-sm">Contacto</a>
                        </div>
                    </div>
                </div>
            </div> {{-- Fin card --}}
        </div> {{-- Fin col --}}
    </div> {{-- Fin Contenedor Principal --}}

</x-app-layout>