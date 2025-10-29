@extends('layouts.app-menu')

@section('title', 'Modules - AcademicSoftware')

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
                    ? route('modules.create') : route('modules.update', $module->id)
            }}" method="post"
        >
            @csrf
            @if(Str::after(Route::currentRouteName(), '.') != 'viewCreate')
                @method('PUT')
            @endif
            <div class="mb-3">
                <label for="module_name" class="form-label">Nombre del modulo</label>
                <input type="text" class="form-control" id="module_name" name="module_name"
                    value="{{ $module->page_name ?? '' }}" required
                >
            </div>
            <div class="mb-3">
                <label for="description" class="form-label">Descripción</label>
                <textarea class="form-control" id="description" name="description"
                    rows="3" required
                >{{ $module->description ?? '' }}</textarea>
            </div>
            <div class="mb-3">
                <label for="route" class="form-label">Ruta</label>
                <input type="text" class="form-control" id="route" name="route"
                    value="{{ $module->route ?? '' }}"
                >
            </div>
            <button type="submit" class="btn btn-primary">Guardar</button>
            <a href="{{route('modules.index')}}" class="btn btn-warning">Regresar</a>
        </form>
    </div>
@endsection
