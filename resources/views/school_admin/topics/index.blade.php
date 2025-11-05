@extends('layouts.app-menu')

@section('title', 'Gestión de Temas')

@section('content-principal')
    <div class="container">
        <div class="row">
            <div class="col-12">
                <div class="card mb-3">
                    <div class="card-body">
                        <div class="d-flex justify-content-between align-items-center mb-3">
                            <h3 class="card-title m-0">Temas</h3>
                            <span class="badge bg-primary">{{ $topics->count() }} temas</span>
                        </div>

                        @if(session('success'))
                            <div class="alert alert-success alert-dismissible fade show" role="alert">
                                {{ session('success') }}
                                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                            </div>
                        @endif

                        <!-- Tabla de temas -->
                        <div class="table-responsive mt-3">
                            <table class="table table-hover">
                                <thead>
                                    <tr>
                                        <th style="width:160px">Acciones</th>
                                        <th>Título</th>
                                        <th>Descripción</th>
                                        <th>Creado por</th>
                                        <th>Fecha de creación</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse($topics as $topic)
                                        <tr>
                                            <td class="d-flex gap-1">
                                                <a href="{{ route('topics.show', $topic) }}" class="btn btn-sm btn-info" title="Ver">
                                                    <i class="fas fa-eye"></i>
                                                </a>
                                                <a href="{{ route('topics.edit', $topic) }}" class="btn btn-sm btn-warning" title="Editar">
                                                    <i class="fas fa-edit"></i>
                                                </a>
                                                <form action="{{ route('topics.destroy', $topic) }}" method="POST" class="d-inline">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="btn btn-sm btn-danger" title="Eliminar" 
                                                            onclick="return confirm('¿Estás seguro de que deseas eliminar este tema?')">
                                                        <i class="fas fa-trash-alt"></i>
                                                    </button>
                                                </form>
                                            </td>
                                            <td>{{ $topic->title }}</td>
                                            <td>{{ Str::limit($topic->description, 100) }}</td>
                                            <td>{{ $topic->creator->name }}</td>
                                            <td>{{ $topic->created_at->format('d/m/Y H:i') }}</td>
                                        </tr>
                                    @empty
                                        <tr>
                                            <td colspan="5" class="text-center text-muted py-4">
                                                <i class="fas fa-book-open fa-2x mb-2"></i>
                                                <p class="mb-0">No hay temas registrados.</p>
                                            </td>
                                        </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div>
        <a href="{{ route('topics.create') }}" class="btn btn-primary position-fixed rounded-circle" style="bottom: 20px; right: 20px;" title="Adicionar tema">
            <i class="fas fa-plus h1 text-align-center m-0 my-1"></i>
        </a>
    </div>
@endsection