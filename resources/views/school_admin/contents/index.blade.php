@extends('layouts.app-menu')

@section('title', 'Gestión de Contenidos')

@section('content-principal')
    <div class="container-fluid">
        <div class="row mb-4">
            <div class="col-12 d-flex justify-content-between align-items-center">
                <h3 class="mb-0"><i class="fas fa-book"></i> Contenidos Académicos</h3>
                <a href="{{ route('contents.create') }}" class="btn btn-primary">
                    <i class="fas fa-plus"></i> Nuevo Contenido
                </a>
            </div>
        </div>
        @if ($message = Session::get('success'))
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                <strong>Éxito:</strong> {{ $message }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif
        <div class="card">
            <div class="card-body">
                @if($contents->count() > 0)
                    <div class="table-responsive">
                        <table class="table table-hover table-sm">
                            <thead class="table-light">
                                <tr>
                                    <th>Título</th>
                                    <th>Asignatura</th>
                                    <th>Período</th>
                                    <th>Creado por</th>
                                    <th>Fecha</th>
                                    <th>Acciones</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($contents as $content)
                                    <tr>
                                        <td><strong>{{ $content->title }}</strong></td>
                                        <td>{{ $content->subject->name ?? '-' }}</td>
                                        <td><span class="badge bg-info">{{ $content->academic_period }}</span></td>
                                        <td>{{ $content->creator->name ?? '-' }}</td>
                                        <td>{{ $content->created_at->format('d/m/Y') }}</td>
                                        <td>
                                            <a href="{{ route('contents.show', $content->id) }}" class="btn btn-sm btn-info" title="Ver">
                                                <i class="fas fa-eye"></i>
                                            </a>
                                            <a href="{{ route('contents.edit', $content->id) }}" class="btn btn-sm btn-warning" title="Editar">
                                                <i class="fas fa-edit"></i>
                                            </a>
                                            <form action="{{ route('contents.destroy', $content->id) }}" method="POST" class="d-inline" onsubmit="return confirm('¿Eliminar este contenido?');">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-sm btn-danger" title="Eliminar">
                                                    <i class="fas fa-trash"></i>
                                                </button>
                                            </form>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                    <div class="mt-3">
                        {{ $contents->links() }}
                    </div>
                @else
                    <div class="alert alert-info">
                        No hay contenidos registrados. <a href="{{ route('contents.create') }}">Agregar contenido</a>
                    </div>
                @endif
            </div>
        </div>
    </div>
@endsection
