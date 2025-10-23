@extends('layouts.app-menu')

@section('title', 'Roles - AcademicSoftware')

@section('content-principal')
    <div class="container mt-5">
        <h2 class="mb-4">Lista de Roles</h2>
        <table class="table table-bordered" id="rolesTable" style="max-width: 5000px;">
            <thead>
                <tr>
                    <th>Acciones</th>
                    <th>Nombre</th>
                    <th>Descripción</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($roles as $role)
                    <tr>
                        <td class="d-flex justify-content-center">
                            <button
                                class="btn btn-sm btn-warning me-2"
                                title="Editar"
                                data-id="{{ $role->id }}"
                            >
                                <i class="fas fa-edit"></i>
                            </button>
                            <button
                                class="btn btn-sm btn-danger"
                                title="Eliminar"
                                data-id="{{ $role->id }}"
                            >
                                <i class="fas fa-trash-alt"></i>
                            </button>
                        </td>
                        <td>{{ $role->rol_name }}</td>
                        <td>{{ $role->description }}</td>
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
            <i class="fas fa-plus h1 text-align-center m-0 my-1"></i>
        </button>
    </div>
@endsection
