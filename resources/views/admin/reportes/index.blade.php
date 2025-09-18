<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Reportes') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-8 text-gray-900 text-center">
                    
                    <!-- Icono SVG de un gráfico -->
                    <svg class="mx-auto h-24 w-24 text-gray-300" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M3 13.125C3 12.504 3.504 12 4.125 12h2.25c.621 0 1.125.504 1.125 1.125v6.75C7.5 20.496 6.996 21 6.375 21h-2.25A1.125 1.125 0 0 1 3 19.875v-6.75ZM9.75 8.625c0-.621.504-1.125 1.125-1.125h2.25c.621 0 1.125.504 1.125 1.125v11.25c0 .621-.504 1.125-1.125 1.125h-2.25a1.125 1.125 0 0 1-1.125-1.125V8.625ZM16.5 4.125c0-.621.504-1.125 1.125-1.125h2.25C20.496 3 21 3.504 21 4.125v15.75c0 .621-.504 1.125-1.125 1.125h-2.25a1.125 1.125 0 0 1-1.125-1.125V4.125Z" />
                    </svg>

                    <!-- Título -->
                    <h3 class="mt-4 text-2xl font-bold text-gray-800">
                        Sección de Reportes en Desarrollo
                    </h3>
                    
                    <!-- Mensaje -->
                    <p class="mt-2 text-md text-gray-600">
                        Estamos trabajando para construir potentes herramientas de análisis y visualización de datos.
                    </p>
                    <p class="mt-1 text-md text-gray-600">
                        ¡Vuelve pronto para descubrir los nuevos informes!
                    </p>

                </div>
            </div>
        </div>
    </div>
</x-app-layout>