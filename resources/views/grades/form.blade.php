@extends('layouts.app-menu')

@section('title', 'Grado')

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
                isset($grade) && $grade
                    ? route('grades.update', $grade->id) 
                    : route('grades.create')
            }}" method="post"
        >
            @csrf
            @if(isset($grade) && $grade)
                @method('PUT')
            @endif
            
            <div class="mb-3">
                <label for="nombre_grado" class="form-label">Nombre del Grado</label>
                <input type="text" class="form-control" id="nombre_grado" name="nombre_grado"
                    value="{{ $grade->nombre_grado ?? '' }}" required
                >
            </div>
            
            <div class="mb-3">
                <label for="nivel" class="form-label">Nivel</label>
                <input type="text" class="form-control" id="nivel" name="nivel"
                    value="{{ $grade->nivel ?? '' }}" required
                >
            </div>
            
            <div class="mb-3 form-check">
                <input type="checkbox" class="form-check-input" id="estado" name="estado" 
                    {{ (isset($grade) && !$grade->estado) ? '' : 'checked' }}
                >
                <label class="form-check-label" for="estado">
                    Activo
                </label>
            </div>
            
            <button type="submit" class="btn btn-primary">Guardar</button>
            <a href="{{ route('grades.index') }}" class="btn btn-warning">Regresar</a>
        </form>
    </div>
@endsection
