@extends('layouts.app-menu')

@section('title', 'Temas')

@section('content-principal')
    <div class="container">
        <div class="row">
            <div class="col-12">
                <div class="card mb-3">
                    <div class="card-body">
                        <div class="d-flex justify-content-between align-items-center mb-3">
                            <h3 class="card-title m-0">Temas</h3>
                            <small class="text-muted">Administrador</small>
                        </div>

                        <p>¡Hola, {{ $nombre ?? 'usuario' }}! Aquí tienes la lista de temas.</p>

                        <!-- Tabla de temas -->
                        <div class="table-responsive mt-3">
                            <table class="table table-bordered">
                                <thead>
                                    <tr>
                                        <th style="width:160px">Acciones</th>
                                        <th>Título</th>
                                        <th>Descripción</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse($topics ?? [] as $topic)
                                        <tr>
                                            <td class="d-flex justify-content-center">
                                                <a href="#" class="btn btn-sm btn-info me-2" title="Ver"><i class="fas fa-eye"></i></a>
                                                <a href="#" class="btn btn-sm btn-warning me-2" title="Editar"><i class="fas fa-edit"></i></a>
                                                <form action="#" method="POST" style="display:inline;">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="btn btn-sm btn-danger" title="Eliminar" onclick="return confirm('¿Estás seguro de que deseas eliminar este tema?')">
                                                        <i class="fas fa-trash-alt"></i>
                                                    </button>
                                                </form>
                                            </td>
                                            <td>{{ $topic->title }}</td>
                                            <td>{{ $topic->description }}</td>
                                        </tr>
                                    @empty
                                        <tr>
                                            <td colspan="3" class="text-center text-muted">No hay temas registrados.</td>
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
        <a href="#" class="btn btn-primary position-fixed rounded-circle" style="bottom: 20px; right: 20px;" title="Adicionar">
            <i class="fas fa-plus h1 text-align-center m-0 my-1"></i>
        </a>
    </div>
@endsection