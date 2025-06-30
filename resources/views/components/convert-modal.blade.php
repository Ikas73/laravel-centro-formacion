{{-- Modal de confirmación para convertir un preinscrito en alumno --}}
@props([
    'title' => 'Convertir Preinscrito',
    'body'  => '¿Estás seguro de que quieres convertir este preinscrito en alumno? Esta acción no se puede deshacer.'
])

<div id="convertModal"
     class="fixed inset-0 bg-gray-600 bg-opacity-50 overflow-y-auto h-full w-full z-50 hidden">
    <div class="relative top-20 mx-auto p-6 border w-full max-w-md shadow-lg rounded-xl bg-white">
        <div class="mt-3 text-center">
            <div class="mx-auto flex items-center justify-center h-12 w-12 rounded-full bg-green-100 mb-4">
                <i class="bi bi-person-plus-fill text-green-600 text-xl"></i>
            </div>

            <h3 class="text-lg font-semibold text-gray-900 mb-2">{{ $title }}</h3>

            <div class="text-sm text-gray-500 mb-4">
                {!! $body !!}
            </div>

            <div class="flex justify-center space-x-4">
                {{-- Botón cancelar --}}
                <button type="button"
                        onclick="closeConvertModal()"
                        class="px-4 py-2 bg-gray-200 text-gray-800 text-sm font-medium rounded-lg
                               hover:bg-gray-300 transition-colors duration-200 focus:outline-none
                               focus:ring-2 focus:ring-offset-2 focus:ring-gray-500">
                    Cancelar
                </button>

                {{-- Formulario que enviará el POST de conversión --}}
                <form id="convertForm" method="POST">
                    @csrf
                    <button type="submit"
                            class="px-4 py-2 bg-green-600 text-white text-sm font-medium rounded-lg
                                   hover:bg-green-700 transition-colors duration-200 focus:outline-none
                                   focus:ring-2 focus:ring-offset-2 focus:ring-green-500">
                        Sí, Convertir
                    </button>
                </form>
            </div>
        </div>
    </div>
</div>
