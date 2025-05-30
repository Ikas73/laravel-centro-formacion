{{-- resources/views/admin/cursos/index.blade.php --}}
@extends('layouts.admin')
@section('title', 'Cursos')
@section('page-title', 'Lista de Cursos') {{-- Para el header del layout --}}
@section('content')
    <p>Contenido de la lista de cursos (pendiente de implementar).</p>
    {{-- Para probar si los datos llegan:
    @isset($cursos)
        <p>Número de cursos: {{ $cursos->count() }}</p>
    @endisset
    --}}
@endsection