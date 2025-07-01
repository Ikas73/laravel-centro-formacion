@extends('layouts.admin')

@section('title', 'Detalles del Curso: ' . $curso->nombre)
@section('page-title', 'Detalles del Curso')

@section('content')
    {{-- Bloque de Mensajes Flash --}}
    @if (session('success'))
        <div class="mb-6 px-4 py-3 rounded-lg relative bg-gradient-to-r from-green-50 to-green-100 border-l-4 border-green-400 text-green-800 shadow-sm animate-fadeIn" role="alert">
            <div class="flex items-center"><i class="bi bi-check-circle-fill text-green-500 mr-3"></i><div><strong class="font-semibold">¡Éxito!</strong> <p class="text-sm mt-1">{{ session('success') }}</p></div></div>
        </div>
    @endif
    @if (session('error'))
         <div class="mb-6 px-4 py-3 rounded-lg relative bg-gradient-to-r from-red-50 to-red-100 border-l-4 border-red-400 text-red-800 shadow-sm animate-fadeIn" role="alert">
            <div class="flex items-center"><i class="bi bi-exclamation-triangle-fill text-red-500 mr-3"></i><div><strong class="font-semibold">¡Atención!</strong> <p class="text-sm mt-1">{{ session('error') }}</p></div></div>
        </div>
    @endif

    <div class="bg-white p-6 md:p-8 rounded-xl shadow-lg border border-gray-200">
        {{-- Cabecera del Curso --}}
        <div class="mb-6 pb-6 border-b border-gray-200">
            <h2 class="text-3xl font-bold text-gray-900">{{ $curso->nombre }}</h2>
            <p class="text-md text-gray-600 mt-1">Código: {{ $curso->codigo ?? 'N/A' }}</p>
            @if($curso->profesor)
                <p class="text-sm text-gray-500 mt-1">
                    Impartido por:
                    <a href="{{ route('admin.profesores.show', $curso->profesor->id) }}" class="text-indigo-600 hover:underline">
                        {{ $curso->profesor->nombre }} {{ $curso->profesor->apellido1 }}
                    </a>
                </p>
            @else
                <p class="text-sm text-gray-500 mt-1">Profesor: No asignado</p>
            @endif
        </div>

        {{-- Detalles del Curso en Grid --}}
        <h3 class="text-xl font-semibold text-gray-800 mb-4">Información del Curso</h3>
        <dl class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-x-6 gap-y-4 text-sm mb-8">
            <div class="bg-gray-50 p-3 rounded-lg">
                <dt class="font-medium text-gray-500">Descripción</dt>
                <dd class="mt-1 text-gray-900">{{ $curso->descripcion ?? 'No especificada' }}</dd>
            </div>
            <div class="bg-gray-50 p-3 rounded-lg">
                <dt class="font-medium text-gray-500">Modalidad</dt>
                <dd class="mt-1 text-gray-900">{{ $curso->modalidad ?? 'N/A' }}</dd>
            </div>
            <div class="bg-gray-50 p-3 rounded-lg">
                <dt class="font-medium text-gray-500">Nivel</dt>
                <dd class="mt-1 text-gray-900">{{ $curso->nivel ?? 'No especificado' }}</dd>
            </div>
            <div class="bg-gray-50 p-3 rounded-lg">
                <dt class="font-medium text-gray-500">Requisitos</dt>
                <dd class="mt-1 text-gray-900">{{ $curso->requisitos ?? 'No especificados' }}</dd>
            </div>
            <div class="bg-gray-50 p-3 rounded-lg">
                <dt class="font-medium text-gray-500">Fecha de Inicio</dt>
                <dd class="mt-1 text-gray-900">{{ $curso->fecha_inicio ? $curso->fecha_inicio->format('d/m/Y') : 'N/A' }}</dd>
            </div>
            <div class="bg-gray-50 p-3 rounded-lg">
                <dt class="font-medium text-gray-500">Fecha de Fin</dt>
                <dd class="mt-1 text-gray-900">{{ $curso->fecha_fin ? $curso->fecha_fin->format('d/m/Y') : 'N/A' }}</dd>
            </div>
            <div class="bg-gray-50 p-3 rounded-lg">
                <dt class="font-medium text-gray-500">Horas Totales</dt>
                <dd class="mt-1 text-gray-900">{{ $curso->horas_totales ?? 'N/A' }}</dd>
            </div>
            {{-- La sección de horario ahora es una lista más grande y detallada --}}
<div class="bg-gray-50 p-4 rounded-lg md:col-span-2 lg:col-span-3">
    <dt class="font-medium text-gray-500 mb-2">Horarios Programados</dt>
    <dd class="mt-1 text-gray-900">
        {{-- Comprobamos si el curso tiene horarios en la tabla `schedules` --}}
        @if($curso->schedules->isNotEmpty())
            <ul class="space-y-2">
                @php
                    // Array para traducir el número del día a texto
                    $diasSemana = ['Domingo', 'Lunes', 'Martes', 'Miércoles', 'Jueves', 'Viernes', 'Sábado'];
                @endphp
                {{-- Recorremos cada franja horaria encontrada --}}
                @foreach($curso->schedules as $horario)
                    <li class="flex items-center justify-between p-2 bg-white rounded-md border border-gray-200">
                        <div>
                            <span class="font-semibold">{{ $diasSemana[$horario->dia_semana] }}</span>
                            de
                            <span class="font-mono text-sm bg-gray-100 px-1 rounded">{{ \Carbon\Carbon::parse($horario->hora_inicio)->format('H:i') }}</span>
                            a
                            <span class="font-mono text-sm bg-gray-100 px-1 rounded">{{ \Carbon\Carbon::parse($horario->hora_fin)->format('H:i') }}</span>
                        </div>
                        <div class="text-sm text-gray-600">
                            <i class="bi bi-geo-alt-fill text-gray-400"></i> {{ $horario->aula }}
                        </div>
                    </li>
                @endforeach
            </ul>
        @else
            {{-- Mensaje si no se encuentran horarios --}}
            <p class="text-gray-500 text-sm">No hay franjas horarias definidas para este curso.</p>
        @endif

        {{-- Enlace para añadir un nuevo horario (funcionalidad futura) --}}
        <div class="mt-4">
            <a href="{{-- route('admin.schedules.create', ['curso_id' => $curso->id]) --}}"
               class="text-sm font-medium text-indigo-600 hover:text-indigo-800 hover:underline">
                <i class="bi bi-plus-circle-fill"></i> Gestionar horarios de este curso
            </a>
        </div>
    </dd>
</div>
            <div class="bg-gray-50 p-3 rounded-lg">
                <dt class="font-medium text-gray-500">Centro(s)</dt>
                <dd class="mt-1 text-gray-900">{{ $curso->centros ?? 'No especificado' }}</dd>
            </div>
            <div class="bg-gray-50 p-3 rounded-lg">
                <dt class="font-medium text-gray-500">Plazas Máximas</dt>
                <dd class="mt-1 text-gray-900">{{ $curso->plazas_maximas }}</dd>
            </div>
            <div class="bg-gray-50 p-3 rounded-lg">
                <dt class="font-medium text-gray-500">Alumnos Inscritos</dt>
                <dd class="mt-1 text-gray-900 font-semibold">{{ $curso->alumnos->count() }} / {{ $curso->plazas_maximas }}</dd>
            </div>
        </dl>

        {{-- Sección de Alumnos Inscritos --}}
        <div class="mt-8 pt-6 border-t border-gray-200">
            <h3 class="text-xl font-semibold text-gray-800 mb-4">Alumnos Inscritos en este Curso</h3>
            @if ($curso->relationLoaded('alumnos') && $curso->alumnos->count() > 0)
                <div class="overflow-x-auto">
                    <table class="min-w-full divide-y divide-gray-200 text-sm">
                        <thead class="bg-gray-50">
                            <tr>
                                <th class="px-4 py-2 text-left font-medium text-gray-500 uppercase tracking-wider">Nombre Alumno</th>
                                <th class="px-4 py-2 text-left font-medium text-gray-500 uppercase tracking-wider">Email</th>
                                <th class="px-4 py-2 text-left font-medium text-gray-500 uppercase tracking-wider">Fecha Inscripción</th>
                                <th class="px-4 py-2 text-left font-medium text-gray-500 uppercase tracking-wider">Estado</th>
                                <th class="px-4 py-2 text-left font-medium text-gray-500 uppercase tracking-wider">Nota</th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-100">
                            @foreach ($curso->alumnos as $alumnoInscrito)
                                <tr>
                                    <td class="px-4 py-3 whitespace-nowrap">
                                        <a href="{{ route('admin.alumnos.show', $alumnoInscrito->id) }}" class="text-indigo-600 hover:underline">
                                            {{ $alumnoInscrito->nombre }} {{ $alumnoInscrito->apellido1 }}
                                        </a>
                                    </td>
                                    <td class="px-4 py-3 whitespace-nowrap text-gray-500">{{ $alumnoInscrito->email }}</td>
                                    <td class="px-4 py-3 whitespace-nowrap text-gray-500">{{ $alumnoInscrito->pivot->fecha_inscripcion ? \Carbon\Carbon::parse($alumnoInscrito->pivot->fecha_inscripcion)->format('d/m/Y') : 'N/A' }}</td>
                                    <td class="px-4 py-3 whitespace-nowrap">
                                        @php
                                            $estadoPivot = $alumnoInscrito->pivot->estado ?? 'Desconocido';
                                            $badgeColorPivot = 'bg-gray-100 text-gray-800';
                                            if ($estadoPivot === 'Inscrito') $badgeColorPivot = 'bg-blue-100 text-blue-800';
                                            elseif ($estadoPivot === 'Completado') $badgeColorPivot = 'bg-green-100 text-green-800';
                                            elseif ($estadoPivot === 'Pendiente') $badgeColorPivot = 'bg-yellow-100 text-yellow-800';
                                            elseif ($estadoPivot === 'Baja') $badgeColorPivot = 'bg-red-100 text-red-800';
                                        @endphp
                                        <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full {{ $badgeColorPivot }}">
                                            {{ $estadoPivot }}
                                        </span>
                                    </td>
                                    <td class="px-4 py-3 whitespace-nowrap text-gray-500">{{ $alumnoInscrito->pivot->nota ?? 'N/A' }}</td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            @else
                 <p class="text-sm text-gray-500">No hay alumnos inscritos en este curso actualmente.</p>
            @endif
        </div>

        {{-- Botones de Acción --}}
        <div class="mt-8 pt-6 border-t border-gray-200 flex flex-col sm:flex-row justify-end gap-3">
            <a href="{{ route('admin.cursos.index') }}"
               class="px-6 py-2.5 text-sm font-medium text-gray-700 bg-white border border-gray-300 rounded-lg shadow-sm hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 transition-colors text-center">
                Volver a la Lista
            </a>
            <a href="{{ route('admin.cursos.edit', $curso->id) }}"
               class="px-6 py-2.5 text-sm font-medium text-white bg-indigo-600 border border-transparent rounded-lg shadow-sm hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 transition-colors text-center">
                Editar Curso
            </a>
        </div>
    </div>
@endsection

@push('scripts')
    {{-- No se necesitan scripts específicos para esta vista por ahora --}}
@endpush