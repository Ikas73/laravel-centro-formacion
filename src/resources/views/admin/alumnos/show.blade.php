@extends('layouts.admin')

@section('title', 'Detalles del Alumno: ' . $alumno->nombre . ' ' . $alumno->apellido1)
@section('page-title', 'Detalles del Alumno')

@section('content')
<div class="bg-white p-6 md:p-8 rounded-lg shadow-lg">
    <div class="flex flex-col md:flex-row items-center md:items-start mb-6 pb-6 border-b border-gray-200">
        {{-- Avatar --}}
        <div class="flex-shrink-0 mb-4 md:mb-0 md:mr-8">
            <img class="h-32 w-32 rounded-full object-cover shadow-md" src="https://ui-avatars.com/api/?name={{ urlencode($alumno->nombre . ' ' . $alumno->apellido1) }}&size=128&color=7F9CF5&background=EBF4FF" alt="Avatar de {{ $alumno->nombre }}">
        </div>
        {{-- Información Principal --}}
        <div>
            <h2 class="text-3xl font-bold text-gray-800">{{ $alumno->nombre }} {{ $alumno->apellido1 }} {{ $alumno->apellido2 ?? '' }}</h2>
            <p class="text-md text-gray-500 mt-1">ID Alumno: {{ $alumno->dni ?? 'N/A' }}</p> {{-- O usa $alumno->id formateado si prefieres --}}
            <div class="mt-2">
                @php
                    $estado = $alumno->estado ?? 'Desconocido';
                    $badgeColor = 'bg-gray-200 text-gray-800';
                    if ($estado === 'Activo') $badgeColor = 'bg-green-100 text-green-800';
                    elseif ($estado === 'Inactivo') $badgeColor = 'bg-red-100 text-red-800';
                    elseif ($estado === 'Pendiente') $badgeColor = 'bg-yellow-100 text-yellow-800';
                    elseif ($estado === 'Baja') $badgeColor = 'bg-purple-100 text-purple-800'; // Ejemplo nuevo color para 'Baja'
                @endphp
                <span class="px-3 py-1 inline-flex text-sm leading-5 font-semibold rounded-full {{ $badgeColor }}">
                    {{ $estado }}
                </span>
            </div>
        </div>
    </div>

    {{-- Detalles Adicionales en Grid --}}
    <h3 class="text-xl font-semibold text-gray-700 mb-4 mt-6">Información Adicional</h3>
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
        <div>
            <dt class="text-sm font-medium text-gray-500">Email</dt>
            <dd class="mt-1 text-sm text-gray-900">{{ $alumno->email ?? 'No especificado' }}</dd>
        </div>
        <div>
            <dt class="text-sm font-medium text-gray-500">Fecha de Nacimiento</dt>
            <dd class="mt-1 text-sm text-gray-900">{{ $alumno->fecha_nacimiento ? \Carbon\Carbon::parse($alumno->fecha_nacimiento)->format('d/m/Y') : 'No especificada' }}</dd>
        </div>
        <div>
            <dt class="text-sm font-medium text-gray-500">Sexo</dt>
            <dd class="mt-1 text-sm text-gray-900">{{ $alumno->sexo ?? 'No especificado' }}</dd>
        </div>
        <div>
            <dt class="text-sm font-medium text-gray-500">Nivel Formativo</dt>
            <dd class="mt-1 text-sm text-gray-900">{{ $alumno->nivel_formativo ?? 'No especificado' }}</dd>
        </div>
        <div>
            <dt class="text-sm font-medium text-gray-500">Nº Seguridad Social</dt>
            <dd class="mt-1 text-sm text-gray-900">{{ $alumno->num_seguridad_social ?? 'No especificado' }}</dd>
        </div>
        <div>
            <dt class="text-sm font-medium text-gray-500">Dirección</dt>
            <dd class="mt-1 text-sm text-gray-900">{{ $alumno->direccion ?? 'No especificada' }}</dd>
        </div>
        <div>
            <dt class="text-sm font-medium text-gray-500">Código Postal</dt>
            <dd class="mt-1 text-sm text-gray-900">{{ $alumno->cp ?? 'No especificado' }}</dd>
        </div>
        <div>
            <dt class="text-sm font-medium text-gray-500">Localidad</dt>
            <dd class="mt-1 text-sm text-gray-900">{{ $alumno->localidad ?? 'No especificada' }}</dd>
        </div>
        <div>
            <dt class="text-sm font-medium text-gray-500">Provincia</dt>
            <dd class="mt-1 text-sm text-gray-900">{{ $alumno->provincia ?? 'No especificada' }}</dd>
        </div>
        <div>
            <dt class="text-sm font-medium text-gray-500">Teléfono</dt>
            <dd class="mt-1 text-sm text-gray-900">{{ $alumno->telefono ?? 'No especificado' }}</dd>
        </div>
         <div>
            <dt class="text-sm font-medium text-gray-500">Nacionalidad</dt>
            <dd class="mt-1 text-sm text-gray-900">{{ $alumno->nacionalidad ?? 'No especificada' }}</dd>
        </div>
         <div>
            <dt class="text-sm font-medium text-gray-500">Situación Laboral</dt>
            <dd class="mt-1 text-sm text-gray-900">{{ $alumno->situacion_laboral ?? 'No especificada' }}</dd>
        </div>
    </div>

    {{-- Sección de Cursos Inscritos (Opcional, si cargaste la relación) --}}
    @if ($alumno->relationLoaded('cursos') && $alumno->cursos->count() > 0)
        <h3 class="text-xl font-semibold text-gray-700 mb-4 mt-8 pt-6 border-t border-gray-200">Cursos Inscritos Historico</h3>
        <ul class="list-disc pl-5 space-y-1 text-sm text-gray-700">
            @foreach ($alumno->cursos as $cursoInscrito)
                <li>
                    <a href="{{ route('admin.cursos.show', $cursoInscrito->id) }}" class="text-blue-600 hover:underline">
                        {{ $cursoInscrito->nombre }}
                    </a>
                    (Estado: {{ $cursoInscrito->pivot->estado ?? 'N/A' }}, Nota: {{ $cursoInscrito->pivot->nota ?? 'N/A' }})
                    {{-- Para acceder a 'estado' y 'nota' de la tabla pivote, --}}
                    {{-- asegurate de haber usado ->withPivot('estado', 'nota') en la definición --}}
                    {{-- de la relación belongsToMany en el modelo Alumno. --}}
                </li>
            @endforeach
        </ul>
    @elseif($alumno->relationLoaded('cursos'))
         <p class="mt-8 pt-6 border-t border-gray-200 text-sm text-gray-500">Este alumno no tiene cursos registrados.</p>
    @endif


    {{-- Botones de Acción --}}
    <div class="mt-8 pt-6 border-t border-gray-200 flex justify-end gap-3">
        <a href="{{ route('admin.alumnos.index') }}"
           class="px-4 py-2 text-sm font-medium text-gray-700 bg-white border border-gray-300 rounded-md shadow-sm hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
            Volver a la Lista
        </a>
        <a href="{{ route('admin.alumnos.edit', $alumno->id) }}"
           class="px-4 py-2 text-sm font-medium text-white bg-indigo-600 border border-transparent rounded-md shadow-sm hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
            Editar Alumno
        </a>
    </div>
</div>
@endsection