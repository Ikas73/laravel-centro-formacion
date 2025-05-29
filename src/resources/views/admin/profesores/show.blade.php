{{-- En admin/profesores/show.blade.php --}}
@if ($profesor->relationLoaded('cursos') && $profesor->cursos->count() > 0)
    <h3 class="text-xl font-semibold ... mt-8 ...">Cursos Impartidos</h3>
    <ul>
        @foreach ($profesor->cursos as $curso)
            <li><a href="{{ route('admin.cursos.show', $curso->id) }}">{{ $curso->nombre }}</a> ({{ $curso->codigo }})</li>
        @endforeach
    </ul>
@else
    <p>Este profesor no tiene cursos asignados actualmente.</p>
@endif