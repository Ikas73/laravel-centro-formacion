{{-- resources/views/settings/partials/academic-years-list.blade.php --}}

<section>
    <header class="flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4">
        <div>
            <h2 class="text-lg font-medium text-gray-900">
                Años Académicos
            </h2>
            <p class="mt-1 text-sm text-gray-600">
                Gestiona los ciclos escolares y sus periodos de evaluación.
            </p>
        </div>
        <a href="{{ route('settings.academic-years.create') }}" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded whitespace-nowrap">
            {{ __('Crear Nuevo Año') }}
        </a>
    </header>

    <div class="mt-6 overflow-x-auto">
        <table class="min-w-full divide-y divide-gray-200">
            <thead class="bg-gray-50">
                <tr>
                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Nombre</th>
                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Fecha Inicio</th>
                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Fecha Fin</th>
                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Activo</th>
                    <th scope="col" class="relative px-6 py-3"><span class="sr-only">Acciones</span></th>
                </tr>
            </thead>
            <tbody class="bg-white divide-y divide-gray-200">
                @forelse ($academicYears as $academicYear)
                    <tr>
                        <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">{{ $academicYear->name }}</td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">{{ \Carbon\Carbon::parse($academicYear->start_date)->format('d/m/Y') }}</td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">{{ \Carbon\Carbon::parse($academicYear->end_date)->format('d/m/Y') }}</td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            @if ($academicYear->is_active)
                                <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-green-100 text-green-800">Sí</span>
                            @else
                                <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-gray-100 text-gray-800">No</span>
                            @endif
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                            <a href="{{ route('settings.academic-years.show', $academicYear) }}" class="text-indigo-600 hover:text-indigo-900">Gestionar Periodos</a>
                            <form action="{{ route('settings.academic-years.destroy', $academicYear) }}" method="POST" class="inline-block ml-4" onsubmit="return confirm('¿Estás seguro de que quieres eliminar este año académico? Esta acción no se puede deshacer.');">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="text-red-600 hover:text-red-900">Eliminar</button>
                            </form>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="5" class="px-6 py-4 text-center text-gray-500">
                            No se han creado años académicos todavía.
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</section>