{{-- Componente <x-desinscribir-modal>
     Props:
     • id         => identificador único del modal (default: desinscribir-modal)
     • title      => título que se muestra en el encabezado
     • form       => id del <form> que se enviará al confirmar
     • confirmText|cancelText => textos de los botones
--}}
@props([
    'id'          => 'desinscribir-modal',
    'title'       => 'Desinscribir del curso',
    'form'        => null,            //  <── id del formulario oculto a disparar
    'confirmText' => 'Sí, desinscribir',
    'cancelText'  => 'Cancelar',
])

<div x-cloak
     x-data="{ open:false }"
     {{-- Escuchamos el evento global que abrirá el modal --}}
     @keydown.escape.window="open = false"
     x-on:open-modal.window="if ($event.detail === '{{ $id }}') open = true"
     x-on:close.window="open = false"
>
    <!-- FONDO OSCURO -------------------------------------------------------->
    <div x-show="open"
         class="fixed inset-0 z-40 bg-black/50"
         x-transition:enter="transition-opacity ease-out duration-200"
         x-transition:enter-start="opacity-0"
         x-transition:enter-end="opacity-100"
         x-transition:leave="transition-opacity ease-in duration-150"
         x-transition:leave-start="opacity-100"
         x-transition:leave-end="opacity-0">
    </div>

    <!-- DIALOGO ------------------------------------------------------------->
    <div x-show="open"
         class="fixed inset-0 z-50 flex items-center justify-center p-4"
         role="dialog" aria-modal="true" aria-labelledby="{{ $id }}-title"
         x-transition:enter="transition ease-out duration-200"
         x-transition:enter-start="opacity-0 scale-95"
         x-transition:enter-end="opacity-100 scale-100"
         x-transition:leave="transition ease-in duration-150"
         x-transition:leave-start="opacity-100 scale-100"
         x-transition:leave-end="opacity-0 scale-95">

        <div class="w-full max-w-lg rounded-lg bg-white shadow-xl dark:bg-gray-800">
            <!-- CABECERA -->
            <div class="flex items-start justify-between px-6 py-4 border-b border-gray-200">
                <h3 id="{{ $id }}-title" class="text-lg font-medium text-gray-900 dark:text-white">
                    {{ $title }}
                </h3>

                <button type="button"
                        class="text-gray-400 hover:text-gray-500 dark:hover:text-gray-300"
                        @click="open = false">
                    <span class="sr-only">Cerrar</span>
                    <svg class="w-6 h-6" viewBox="0 0 24 24" fill="none"
                         stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                        <path d="M6 18L18 6M6 6l12 12"/>
                    </svg>
                </button>
            </div>

            <!-- CONTENIDO -->
            <div class="px-6 py-5">
                {{ $slot }}
            </div>

            <!-- PIE -->
            <div class="flex flex-row-reverse space-x-reverse space-x-3 px-6 py-4 bg-gray-50 dark:bg-gray-700">
                <!-- CONFIRMAR -->
                <button type="button"
                        class="inline-flex justify-center rounded-md bg-red-600 px-4 py-2 text-sm
                               font-medium text-white shadow-sm hover:bg-red-700
                               focus:outline-none focus:ring-2 focus:ring-red-500 focus:ring-offset-2"
                        @click="
                            @if($form)
                                document.getElementById('{{ $form }}').submit()
                            @else
                                $dispatch('confirm-desinscribir')
                            @endif
                            open = false
                        ">
                    {{ $confirmText }}
                </button>

                <!-- CANCELAR -->
                <button type="button"
                        class="inline-flex justify-center rounded-md bg-white px-4 py-2 text-sm
                               font-medium text-gray-700 shadow-sm hover:bg-gray-50 ring-1 ring-inset ring-gray-300
                               focus:outline-none focus:ring-2 focus:ring-indigo-500"
                        @click="open = false">
                    {{ $cancelText }}
                </button>
            </div>
        </div>
    </div>
</div>
