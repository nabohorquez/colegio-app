@extends('layouts.app-menu')

@section('title', 'Paginas - AcademicSoftware')

@section('content-principal')
    <div class="container mt-5">
        <h2 class="mb-4">Lista de Paginas</h2>
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
        <table class="table table-bordered" id="modulesTable" style="max-width: 5000px;">
            <thead>
                <tr>
                    @if(in_array('edit', $permissions) || in_array('delete', $permissions))
                        <th>Acciones</th>
                    @endif
                    <th>Modulo</th>
                    <th>Nombre</th>
                    <th>Descripción</th>
                    <th>Ruta</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($pagesTable as $page)
                    <tr>
                        @if(in_array('edit', $permissions) || in_array('delete', $permissions))
                            <td class="d-flex justify-content-center">
                                @if(in_array('edit', $permissions))
                                    <a href="{{ route('pages.getById', $page->id) }}" class="btn btn-sm btn-warning me-2" title="Editar"><i class="fas fa-edit"></i></a>
                                @endif
                                @if(in_array('delete', $permissions))
                                    <form action="{{ route('pages.delete', $page->id) }}" method="POST" style="display:inline;">
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
                        <td>{{ $page->module_name }}</td>
                        <td>{{ $page->page_name }}</td>
                        <td>{{ $page->description }}</td>
                        <td>{{ $page->route }}</td>
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
                <a href="{{ route('pages.viewCreate') }}">
                    <i class="fas fa-plus h1 text-align-center m-0 my-1 text-white"></i>
                </a>
            </button>
        @endif
    </div>
@endsection
