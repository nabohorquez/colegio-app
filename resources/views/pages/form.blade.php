@extends('layouts.app-menu')

@section('title', 'Páginas - AcademicSoftware')

@section('content-principal')
    <div class="container mt-5">
        @if ($errors->any())
            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form action="{{
                Str::after(Route::currentRouteName(), '.') == 'viewCreate'
                    ? route('pages.create') : route('pages.update', $page->id)
            }}" method="post"
        >
            @csrf
            @if(Str::after(Route::currentRouteName(), '.') != 'viewCreate')
                @method('PUT')
            @endif
            <div class="mb-3">
                <label for="module_id" class="form-label">Nombre del modulo</label>
                <select name="module_id" id="module_id" class="form-select mb-3" required>
                    <option value="">Seleccione una opción</option>
                    @foreach($moduleOptions as $id => $name)
                        <option value="{{ $id }}"
                            {{ (isset($page) && ($page->id_father_page ?? '') == $id) ? 'selected' : '' }}
                        >
                            {{ $name }}
                        </option>
                    @endforeach
                </select>
            </div>
            <div class="mb-3">
                <label for="page_name" class="form-label">Nombre de la pagina</label>
                <input type="text" class="form-control" id="page_name" name="page_name"
                    value="{{ $page->page_name ?? '' }}" required
                >
            </div>
            <div class="mb-3">
                <label for="description" class="form-label">Descripción</label>
                <textarea class="form-control" id="description" name="description"
                    rows="3" required
                >{{ $page->description ?? '' }}</textarea>
            </div>
            <div class="mb-3">
                <label for="route" class="form-label">Ruta</label>
                <input type="text" class="form-control" id="route" name="route"
                    value="{{ $page->route ?? '' }}"
                >
            </div>
            <button type="submit" class="btn btn-primary">Guardar</button>
            <a href="{{route('pages.index')}}" class="btn btn-warning">Regresar</a>
        </form>
    </div>
@endsection
