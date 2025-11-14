@extends('layouts.app-menu')

@section('title', 'Gestión de Actividades')

@section('content-principal')
    <div class="container-fluid">
        <div class="row mb-4">
            <div class="col-12">
                <div class="d-flex justify-content-between align-items-center">
                    <h3 class="mb-0">Actividades Escolares</h3>
                    <a href="{{ route('school.activities.create') }}" class="btn btn-primary">
                        <i class="fas fa-plus"></i> Crear Nueva Actividad
                    </a>
                </div>
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
                @if($activities->count() > 0)
                    <div class="table-responsive">
                        <table class="table table-hover table-sm">
                            <thead class="table-light">
                                <tr>
                                    <th>Título</th>
                                    <th>Descripción</th>
                                    <th>Recursos</th>
                                    <th>Ejemplos</th>
                                    <th>Creado por</th>
                                    <th>Fecha</th>
                                    <th>Acciones</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($activities as $activity)
                                <tr>
                                    <td><strong>{{ $activity->title }}</strong></td>
                                    <td>{{ Str::limit($activity->description, 40) }}</td>
                                    <td>
                                        @if($activity->resource_assignment)
                                            <small class="badge bg-info">Sí</small>
                                        @else
                                            <small class="badge bg-secondary">No</small>
                                        @endif
                                    </td>
                                    <td>
                                        @if($activity->example_assignment)
                                            <small class="badge bg-info">Sí</small>
                                        @else
                                            <small class="badge bg-secondary">No</small>
                                        @endif
                                    </td>
                                    <td>{{ $activity->creator->first_name ?? "" }} {{ $activity->creator->last_name ?? "" }}</td>
                                    <td>{{ $activity->created_at->format("d/m/Y") }}</td>
                                    <td>
                                        <a href="{{ route('school.activities.edit', $activity->id) }}" class="btn btn-sm btn-warning" title="Editar">
                                            <i class="fas fa-edit"></i>
                                        </a>
                                        <form action="{{ route('school.activities.destroy', $activity->id) }}" method="POST" class="d-inline" onsubmit="return confirm('¿Estás seguro de que deseas eliminar esta actividad?');">
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
                        {{ $activities->links() }}
                    </div>
                @else
                    <div class="alert alert-info">
                        No hay actividades registradas. <a href="{{ route('school.activities.create') }}">Crear una nueva</a>
                    </div>
                @endif
            </div>
        </div>
    </div>
@endsection
