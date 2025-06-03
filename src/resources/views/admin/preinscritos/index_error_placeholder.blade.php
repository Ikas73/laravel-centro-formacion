@extends('layouts.admin')
@section('title', 'Error Preinscritos')
@section('page-title', 'Error al Cargar Preinscritos')
@section('content')
    <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative" role="alert">
        <strong class="font-bold">¡Error!</strong>
        <span class="block sm:inline">{{ $errorMessage ?? 'Ocurrió un error desconocido.' }}</span>
        <p class="text-xs mt-2">Revisa `storage/logs/laravel.log` para más detalles.</p>
    </div>
@endsection