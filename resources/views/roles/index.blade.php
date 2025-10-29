@extends('layouts.app-menu')

@section('title', 'Roles - AcademicSoftware')

@section('content-principal')
    <div class="container mt-5">
        <h2 class="mb-4">Lista de Roles</h2>
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
                                    <button
                                        class="btn btn-sm btn-warning me-2"
                                        title="Editar"
                                        data-id="{{ $role->id }}"
                                    >
                                        <i class="fas fa-edit"></i>
                                    </button>
                                @endif
                                @if(in_array('delete', $permissions))
                                    <button
                                        class="btn btn-sm btn-danger"
                                        title="Eliminar"
                                        data-id="{{ $role->id }}"
                                    >
                                        <i class="fas fa-trash-alt"></i>
                                    </button>
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
                <i class="fas fa-plus h1 text-align-center m-0 my-1"></i>
            </button>
        @endif
    </div>
@endsection
