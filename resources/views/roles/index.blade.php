@extends('layouts.app-menu')

@section('title', 'Roles - AcademicSoftware')

@section('content-principal')
    <div class="container mt-5">
        <h2 class="mb-4">Lista de Roles</h2>

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

        @if ($errors->any())
            <div class="alert alert-danger">
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <table class="table table-bordered" id="rolesTable" style="max-width: 5000px;">
            <thead>
                <tr>
                    @if(in_array('edit', $permissions) || in_array('delete', $permissions))
                        <th>Acciones</th>
                    @endif
                    <th>Nombre</th>
                    <th>Descripción</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($roles as $role)
                    <tr>
                        @if(in_array('edit', $permissions) || in_array('delete', $permissions))
                            <td class="d-flex justify-content-center">
                                @if(in_array('edit', $permissions))
                                    <a href="{{ route('roles.getById', $role->id) }}" class="btn btn-sm btn-warning me-2" title="Editar"><i class="fas fa-edit"></i></a>
                                @endif
                                @if(in_array('delete', $permissions))
                                    <form action="{{ route('roles.delete', $role->id) }}" method="POST" style="display:inline;">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-sm btn-danger" title="Eliminar"
                                                onclick="return confirm('¿Estás seguro de que deseas eliminar este módulo?')">
                                            <i class="fas fa-trash-alt"></i>
                                        </button>
                                    </form>
                                @endif
                            </td>
                        @endif
                        <td>{{ $role->rol_name }}</td>
                        <td>{{ $role->description }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>

    <div>
        @if(in_array('create', $permissions))
            <button
                class="btn btn-primary position-fixed rounded-circle"
                style="bottom: 20px; right: 20px;"
                type="button"
                title="Adicionar"
            >
                <a href="{{ route('roles.viewCreate') }}">
                    <i class="fas fa-plus h1 text-align-center m-0 my-1 text-white"></i>
                </a>
            </button>
        @endif
    </div>
@endsection
