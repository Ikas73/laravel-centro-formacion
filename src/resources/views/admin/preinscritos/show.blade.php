@extends('layouts.admin')

@section('title', 'Detalles del Preinscrito: ' . $preinscrito->nombre . ' ' . $preinscrito->apellido1)
@section('page-title', 'Detalles del Preinscrito')

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
        {{-- Cabecera con Nombre e Info Principal --}}
        <div class="flex flex-col md:flex-row items-center md:items-start mb-6 pb-6 border-b border-gray-200">
            <div class="flex-shrink-0 mb-4 md:mb-0 md:mr-8">
                @php
                    $inicialNombre = (!empty($preinscrito->nombre)) ? $preinscrito->nombre[0] : '';
                    $inicialApellido = (!empty($preinscrito->apellido1)) ? $preinscrito->apellido1[0] : '';
                    $nombreParaAvatar = trim($inicialNombre . $inicialApellido);
                    if (empty($nombreParaAvatar)) { $nombreParaAvatar = 'P'; } // Preinscrito
                @endphp
                <img class="h-32 w-32 rounded-full object-cover shadow-md ring-2 ring-sky-200"
                     src="https://ui-avatars.com/api/?name={{ urlencode($nombreParaAvatar) }}&size=128&background=0EA5E9&color=FFFFFF&bold=true"
                     alt="Avatar de {{ $preinscrito->nombre ?? 'Preinscrito' }}">
            </div>
            <div class="text-center md:text-left">
                <h2 class="text-3xl font-bold text-gray-900">{{ $preinscrito->nombre }} {{ $preinscrito->apellido1 }} {{ $preinscrito->apellido2 ?? '' }}</h2>
                <p class="text-md text-gray-600 mt-1">DNI/NIE: {{ $preinscrito->dni ?? 'N/A' }}</p>
                <p class="text-sm text-gray-500 mt-1">{{ $preinscrito->email ?? 'Email no especificado' }}</p>
                 @if($preinscrito->estado)
                    @php
                        $estadoPre = $preinscrito->estado;
                        $badgeColorPre = 'bg-gray-100 text-gray-800'; // Default
                        if ($estadoPre === 'Pendiente') $badgeColorPre = 'bg-yellow-100 text-yellow-800';
                        elseif ($estadoPre === 'Contactado') $badgeColorPre = 'bg-blue-100 text-blue-800';
                        elseif ($estadoPre === 'Interesado') $badgeColorPre = 'bg-teal-100 text-teal-800'; // Ejemplo
                        elseif ($estadoPre === 'Convertido') $badgeColorPre = 'bg-green-100 text-green-800';
                        elseif ($estadoPre === 'Rechazado') $badgeColorPre = 'bg-red-100 text-red-800';
                    @endphp
                    <div class="mt-2">
                        <span class="px-3 py-1 inline-flex text-sm leading-5 font-semibold rounded-full {{ $badgeColorPre }}">
                            Estado: {{ $estadoPre }}
                        </span>
                    </div>
                @endif
            </div>
        </div>

        {{-- Detalles Adicionales en Grid --}}
        <h3 class="text-xl font-semibold text-gray-800 mb-4 mt-6">Información Detallada</h3>
        <dl class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-x-6 gap-y-4 text-sm">
            <div class="bg-gray-50 p-3 rounded-lg"><dt class="font-medium text-gray-500">Teléfono</dt><dd class="mt-1 text-gray-900">{{ $preinscrito->telefono ?? 'No especificado' }}</dd></div>
            <div class="bg-gray-50 p-3 rounded-lg"><dt class="font-medium text-gray-500">Fecha de Nacimiento</dt><dd class="mt-1 text-gray-900">{{ $preinscrito->fecha_nacimiento ? $preinscrito->fecha_nacimiento->format('d/m/Y') : 'No especificada' }}</dd></div>
            <div class="bg-gray-50 p-3 rounded-lg"><dt class="font-medium text-gray-500">Nacionalidad</dt><dd class="mt-1 text-gray-900">{{ $preinscrito->nacionalidad ?? 'No especificada' }}</dd></div>
            <div class="bg-gray-50 p-3 rounded-lg"><dt class="font-medium text-gray-500">Nivel Formativo</dt><dd class="mt-1 text-gray-900">{{ $preinscrito->nivel_formativo ?? 'No especificado' }}</dd></div>
            <div class="bg-gray-50 p-3 rounded-lg"><dt class="font-medium text-gray-500">Situación Laboral</dt><dd class="mt-1 text-gray-900">{{ $preinscrito->situacion_laboral ?? 'No especificada' }}</dd></div>
            <div class="bg-gray-50 p-3 rounded-lg"><dt class="font-medium text-gray-500">Fecha de Importación/Registro</dt><dd class="mt-1 text-gray-900">{{ $preinscrito->fecha_importacion ? $preinscrito->fecha_importacion->format('d/m/Y H:i') : ($preinscrito->created_at ? $preinscrito->created_at->format('d/m/Y H:i') : 'N/A') }}</dd></div>
            <div class="bg-gray-50 p-3 rounded-lg md:col-span-3"><dt class="font-medium text-gray-500">Dirección</dt><dd class="mt-1 text-gray-900">{{ $preinscrito->direccion ?? 'No especificada' }}</dd></div>
            <div class="bg-gray-50 p-3 rounded-lg"><dt class="font-medium text-gray-500">Código Postal</dt><dd class="mt-1 text-gray-900">{{ $preinscrito->cp ?? 'No especificado' }}</dd></div>
            <div class="bg-gray-50 p-3 rounded-lg"><dt class="font-medium text-gray-500">Localidad</dt><dd class="mt-1 text-gray-900">{{ $preinscrito->localidad ?? 'No especificada' }}</dd></div>
            <div class="bg-gray-50 p-3 rounded-lg"><dt class="font-medium text-gray-500">Provincia</dt><dd class="mt-1 text-gray-900">{{ $preinscrito->provincia ?? 'No especificada' }}</dd></div>
            {{-- Si tenías num_seguridad_social para preinscritos, añadirlo aquí --}}
            {{-- <div class="bg-gray-50 p-3 rounded-lg"><dt class="font-medium text-gray-500">Nº Seg. Social</dt><dd class="mt-1 text-gray-900">{{ $preinscrito->num_seguridad_social ?? 'N/A' }}</dd></div> --}}
        </dl>

        {{-- Botones de Acción --}}
        <div class="mt-8 pt-6 border-t border-gray-200 flex flex-col sm:flex-row justify-end gap-4">
            {{-- Botón Convertir a Alumno --}}
            <form action="{{ route('admin.preinscritos.convertir', $preinscrito->id) }}" method="POST" onsubmit="return confirm('¿Estás seguro de convertir este preinscrito en un alumno formal?');" class="w-full sm:w-auto">
                @csrf
                <button type="submit"
                        class="w-full px-6 py-2.5 text-sm font-medium text-white bg-green-600 border border-transparent rounded-lg shadow-sm hover:bg-green-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-green-500 transition-colors">
                    <i class="bi bi-person-plus-fill mr-2"></i>Convertir a Alumno
                </button>
            </form>

            <a href="{{ route('admin.preinscritos.index') }}"
               class="px-6 py-2.5 text-sm font-medium text-gray-700 bg-white border border-gray-300 rounded-lg shadow-sm hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 transition-colors text-center">
                Volver a la Lista
            </a>
            <a href="{{ route('admin.preinscritos.edit', $preinscrito->id) }}"
               class="px-6 py-2.5 text-sm font-medium text-white bg-indigo-600 border border-transparent rounded-lg shadow-sm hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 transition-colors text-center">
                Editar Preinscrito
            </a>
            {{-- Botón de Eliminar (si quieres tenerlo también en la vista de detalles) --}}
            {{-- <form action="{{ route('admin.preinscritos.destroy', $preinscrito->id) }}" method="POST" class="inline" onsubmit="return confirm('¿Seguro que quieres eliminar este preinscrito?');">
                @csrf @method('DELETE')
                <button type="submit" class="px-6 py-2.5 text-sm font-medium text-white bg-red-600 hover:bg-red-700 rounded-lg shadow-sm">Eliminar</button>
            </form> --}}
        </div>
    </div>
@endsection

@push('scripts')
    {{-- No se necesitan scripts específicos para esta vista por ahora --}}
@endpush