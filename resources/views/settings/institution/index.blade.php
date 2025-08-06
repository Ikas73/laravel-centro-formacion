<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Institution Settings') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200">
                    @if (session('success'))
                        <div class="alert alert-success mb-4">
                            {{ session('success') }}
                        </div>
                    @endif

                    <form action="{{ route('settings.institution.update') }}" method="POST">
                        @csrf
                        <div class="mb-4">
                            <label for="school_name" class="block text-gray-700 text-sm font-bold mb-2">Nombre de la Institución</label>
                            <input type="text" name="school_name" id="school_name" value="{{ $settingsService->get('school_name') }}" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline">
                        </div>

                        <div class="mb-4">
                            <label for="school_address" class="block text-gray-700 text-sm font-bold mb-2">Dirección</label>
                            <input type="text" name="school_address" id="school_address" value="{{ $settingsService->get('school_address') }}" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline">
                        </div>

                        <button type="submit" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline">
                            Guardar Cambios
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
