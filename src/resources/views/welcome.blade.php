{{-- Usar el layout app, que carga app.css (ahora solo con Tailwind) --}}
<x-app-layout>

    {{-- Ya no necesitamos @push('styles') para welcome.css --}}

    {{-- Fondo degradado aplicado al contenedor principal del layout si es necesario,
        o al body. Breeze ya aplica bg-gray-100 a un div en guest.blade.php,
        y app.blade.php podría tener otro fondo. Para replicar tu degradado,
        lo más fácil sería aplicarlo al body O a este div principal.
        NOTA: Los degradados complejos pueden necesitar CSS personalizado o plugins de Tailwind.
        Vamos a usar un fondo simple de Tailwind por ahora.
    --}}
    <div class="bg-gray-100 dark:bg-gray-900 min-h-screen flex items-center justify-center py-12 px-4 sm:px-6 lg:px-8">
        <div class="w-full max-w-2xl lg:max-w-3xl"> {{-- Ajustamos el ancho máximo --}}

            {{-- Tarjeta: Reemplazamos la clase 'card' por utilidades Tailwind --}}
            <div class="bg-[#cedbd7] shadow-xl rounded-3xl text-center p-6 md:p-10"> {{-- Fondo, sombra fuerte, borde muy redondeado, padding --}}

                {{-- Icono/Logo Personalizado como Imagen --}}
                <div class="mb-5"> {{-- Contenedor para margen --}}
                    <img src="{{ asset('images/logo-centro.svg') }}" {{-- Usa asset() para la ruta correcta --}}
                        alt="Logo Centro de Formación"         {{-- Texto alternativo importante --}}
                        class="inline-block w-auto h-[8.25rem] rounded-md p-2 bg-gradient-to-br from-blue-100 to-indigo-200 shadow-lg">
                        {{-- Clases Tailwind:
                            - inline-block: Para que funcione el margen/padding.
                            - h-20: Altura fija (ej: 5rem). w-auto ajustará el ancho. Ajusta el tamaño según necesites.
                            - rounded-full p-2 bg-gradient... shadow-lg: Estilos opcionales para un fondo/borde circular si la imagen no lo tiene. Si tu imagen ya es el icono final, usa solo 'h-20 w-auto'.
                        --}}
                </div>

                {{-- Título de la Tarjeta --}}

                {{-- Título --}}
                <h1 class="text-3xl lg:text-4xl font-bold mb-3 text-gray-800">
                    {{ config('app.name', 'Centro de Formación') }}
                </h1>

                {{-- Descripción --}}
                <p class="text-lg text-gray-600 mb-8">
                    Bienvenido al sistema de gestión. Accede para administrar cursos, alumnos y profesores.
                </p>

                {{-- Botones Cuadrados (Flexbox y clases Tailwind para cada botón) --}}
                <div class="flex justify-center gap-4 mb-6 flex-wrap">

                    {{-- Botón Panel --}}
                    <a href="{{ route('admin.dashboard') }}"
                       class="flex flex-col items-center justify-center w-[130px] h-[130px] rounded-2xl bg-[#166871] text-white font-semibold text-lg shadow-sm transition duration-150 ease-in-out hover:opacity-90 hover:shadow-lg transform hover:-translate-y-1.5 hover:scale-105 no-underline">
                       {{-- Clases: flex, tamaño fijo w/h, borde redondeado, color fondo/texto, peso/tamaño fuente, sombra, transición, efectos hover, sin subrayado --}}
                        <i class="bi bi-speedometer2 text-4xl mb-2"></i> {{-- Tamaño icono y margen --}}
                        <span>Panel</span>
                    </a>
                    {{-- Botón Cursos --}}
                    <a href="{{ route('admin.cursos.index') }}"
                       class="flex flex-col items-center justify-center w-[130px] h-[130px] rounded-2xl bg-[#294c79] text-white font-semibold text-lg shadow-sm transition duration-150 ease-in-out hover:opacity-90 hover:shadow-lg transform hover:-translate-y-1.5 hover:scale-105 no-underline">
                        <i class="bi bi-journal-bookmark-fill text-4xl mb-2"></i>
                        <span>Cursos</span>
                    </a>
                    {{-- Botón Alumnos --}}
                    <a href="{{ route('admin.alumnos.index') }}"
                       class="flex flex-col items-center justify-center w-[130px] h-[130px] rounded-2xl bg-[#294c79] text-white font-semibold text-lg shadow-sm transition duration-150 ease-in-out hover:opacity-90 hover:shadow-lg transform hover:-translate-y-1.5 hover:scale-105 no-underline">
                        <i class="bi bi-people-fill text-4xl mb-2"></i>
                        <span>Alumnos</span>
                    </a>
                    {{-- Botón Profesores --}}
                    <a href="{{ route('admin.profesores.index') }}"
                       class="flex flex-col items-center justify-center w-[130px] h-[130px] rounded-2xl bg-[#294c79] text-white font-semibold text-lg shadow-sm transition duration-150 ease-in-out hover:opacity-90 hover:shadow-lg transform hover:-translate-y-1.5 hover:scale-105 no-underline">
                        <i class="bi bi-person-badge-fill text-4xl mb-2"></i>
                        <span>Profesores</span>
                    </a>
                </div>

                {{-- Footer de la Tarjeta --}}
                <div class="mt-4 pt-4 border-t border-gray-200">
                    <small class="text-gray-500">
                        © {{ date('Y') }} Centro de Formación · <a href="#" class="text-blue-600 hover:underline">Ayuda</a>
                    </small>
                </div>
            </div> {{-- Fin card --}}
        </div> {{-- Fin col --}}
    </div> {{-- Fin Contenedor Principal --}}

</x-app-layout>