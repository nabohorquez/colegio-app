@extends('layouts.app-menu')

@section('title', 'Modulos - AcademicSoftware')

@section('content-principal')
    <div class="container mt-5">
        <h2 class="mb-4">Lista de Módulos</h2>
        @if(session('success'))
            <div class="alert alert-success">{{ session('success') }}</div>
        @endif
        @if(session('error'))
            <div class="alert alert-danger">{{ session('error') }}</div>
        @endif
        <table class="table table-bordered" id="modulesTable" style="max-width: 5000px;">
            <thead>
                <tr>
                    @if(in_array('edit', $permissions) || in_array('delete', $permissions))
                        <th>Acciones</th>
                    @endif
                    <th>Nombre</th>
                    <th>Descripción</th>
                    <th>Ruta</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($modulesTable as $module)
                    <tr>
                        @if(in_array('edit', $permissions) || in_array('delete', $permissions))
                            <td class="d-flex justify-content-center">
                                @if(in_array('edit', $permissions))
                                    <button
                                        class="btn btn-sm btn-warning me-2"
                                        title="Editar"
                                        data-id="{{ $module->id }}"
                                    >
                                        <a href="{{ route('modules.getById', $module->id) }}"><i class="fas fa-edit"></i></a>
                                    </button>
                                @endif
                                @if(in_array('delete', $permissions))
                                    <button
                                        class="btn btn-sm btn-danger"
                                        title="Eliminar"
                                        data-id="{{ $module->id }}"
                                    >
                                        <a href="{{ route('modules.delete', $module->id) }}"><i class="fas fa-trash-alt"></i></a>
                                    </button>
                                @endif
                            </td>
                        @endif
                        <td>{{ $module->page_name }}</td>
                        <td>{{ $module->description }}</td>
                        <td>{{ $module->route }}</td>
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
                <a href="{{ route('modules.viewCreate') }}">
                    <i class="fas fa-plus h1 text-align-center m-0 my-1 text-white"></i>
                </a>
            </button>
        @endif
    </div>
@endsection
