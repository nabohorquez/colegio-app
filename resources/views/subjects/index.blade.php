@extends('layouts.app-menu')

@section('title', 'Materias - Sistema Escolar')

@section('content-principal')
    <div class="d-flex justify-content-between align-items-center welcome-header">
        <div>
            <h1>Materias</h1>
            <p>Gestiona el catálogo de materias</p>
        </div>
        <a href="{{ route('subjects.viewCreate') }}" class="btn btn-primary">
            <i class="fas fa-plus me-2"></i>Nueva Materia
        </a>
    </div>

    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show">
            <i class="fas fa-check-circle me-2"></i>{{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif

    @if(session('error'))
        <div class="alert alert-danger alert-dismissible fade show">
            <i class="fas fa-exclamation-circle me-2"></i>{{ session('error') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif

    <div class="section-card">
        <div class="card-body">
            @if($subjects->count() > 0)
                <div class="table-responsive">
                    <table class="table">
                        <thead>
                            <tr>
                                <th>Nombre</th>
                                <th>Descripción</th>
                                <th>Estado</th>
                                <th>Acciones</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($subjects as $subject)
                                <tr>
                                    <td><strong>{{ $subject->nombre_materia }}</strong></td>
                                    <td>{{ Str::limit($subject->descripcion, 50) }}</td>
                                    <td>
                                        <span class="badge {{ $subject->estado ? 'bg-success' : 'bg-secondary' }}">
                                            {{ $subject->estado ? 'Activo' : 'Inactivo' }}
                                        </span>
                                    </td>
                                    <td>
                                        <div class="btn-group btn-group-sm">
                                            <a href="{{ route('subjects.getById', $subject->id) }}" class="btn btn-outline-primary" title="Editar">
                                                <i class="fas fa-edit"></i>
                                            </a>
                                            <form action="{{ route('subjects.delete', $subject->id) }}" method="POST" style="display:inline;">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-outline-danger" title="Eliminar" onclick="return confirm('¿Eliminar esta materia?')">
                                                    <i class="fas fa-trash"></i>
                                                </button>
                                            </form>
                                        </div>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            @else
                <div class="text-center py-5">
                    <i class="fas fa-inbox fa-3x text-muted mb-3" style="display: block;"></i>
                    <p class="text-muted">No hay materias registradas</p>
                </div>
            @endif
        </div>
    </div>
@endsection
