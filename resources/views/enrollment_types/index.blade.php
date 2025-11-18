@extends('layouts.app-menu')

@section('title', 'Tipos de Matrículas')

@section('content-principal')
    <div class="container mt-5">
        <h2 class="mb-4">Lista de Tipos de Matrículas</h2>
        @if(session('success'))
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                {{ session('success') }}
            </div>
        @endif
        @if(session('error'))
            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                {{ session('error') }}
            </div>
        @endif
        <table class="table table-bordered" id="enrollmentTypesTable">
            <thead>
                <tr>
                    <th>Acciones</th>
                    <th>Nombre</th>
                    <th>Descripción</th>
                    <th>Estado</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($enrollment_types as $enrollmentType)
                    <tr>
                        <td class="d-flex justify-content-center">
                            <a href="{{ route('enrollment-types.getById', $enrollmentType->id) }}" class="btn btn-sm btn-warning me-2" title="Editar"><i class="fas fa-edit"></i></a>
                            <form action="{{ route('enrollment-types.delete', $enrollmentType->id) }}" method="POST" style="display:inline;">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-sm btn-danger" title="Eliminar"
                                        onclick="return confirm('¿Estás seguro de que deseas eliminar este tipo de matrícula?')">
                                    <i class="fas fa-trash-alt"></i>
                                </button>
                            </form>
                        </td>
                        <td>{{ $enrollmentType->nombre_tipo }}</td>
                        <td>{{ $enrollmentType->descripcion }}</td>
                        <td>
                            <span class="badge {{ $enrollmentType->estado ? 'bg-success' : 'bg-danger' }}">
                                {{ $enrollmentType->estado ? 'Activo' : 'Inactivo' }}
                            </span>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>

    <div>
        <button
            class="btn btn-primary position-fixed rounded-circle"
            style="bottom: 20px; right: 20px;"
            type="button"
            title="Adicionar"
        >
            <a href="{{ route('enrollment-types.viewCreate') }}">
                <i class="fas fa-plus h1 text-align-center m-0 my-1 text-white"></i>
            </a>
        </button>
    </div>
@endsection
