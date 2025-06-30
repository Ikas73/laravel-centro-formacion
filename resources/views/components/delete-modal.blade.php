{{-- resources/views/components/delete-modal.blade.php --}}

@props(['title' => 'Eliminar Registro', 'body' => '¿Estás seguro de que quieres eliminar este registro? Esta acción no se puede deshacer.'])

<div id="deleteModal" class="fixed inset-0 bg-gray-600 bg-opacity-50 overflow-y-auto h-full w-full z-50 hidden">
    <div class="relative top-20 mx-auto p-6 border w-full max-w-md shadow-lg rounded-xl bg-white">
        <div class="mt-3 text-center">
            <div class="mx-auto flex items-center justify-center h-12 w-12 rounded-full bg-red-100 mb-4">
                <i class="bi bi-exclamation-triangle text-red-600 text-xl"></i>
            </div>
            <h3 class="text-lg font-semibold text-gray-900 mb-2">{{ $title }}</h3>
            <div class="text-sm text-gray-500 mb-4">
                {!! $body !!} {{-- Usamos !!} para permitir HTML en el body si es necesario --}}
            </div>
            <div class="flex justify-center space-x-4">
                <button type="button"
                        onclick="closeDeleteModal()"
                        class="px-4 py-2 bg-gray-200 text-gray-800 text-sm font-medium rounded-lg hover:bg-gray-300 transition-colors duration-200 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-gray-500">
                    Cancelar
                </button>
                {{-- El formulario para enviar la petición DELETE --}}
                <form id="deleteForm" method="POST">
                    @csrf
                    @method('DELETE')
                    <button type="submit"
                            class="px-4 py-2 bg-red-600 text-white text-sm font-medium rounded-lg hover:bg-red-700 transition-colors duration-200 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-red-500">
                        Sí, Eliminar
                    </button>
                </form>
            </div>
        </div>
    </div>
</div>