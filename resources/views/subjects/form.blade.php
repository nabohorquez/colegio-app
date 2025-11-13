@extends('layouts.app-menu')

@section('title', 'Materia')

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
                isset($subject) && $subject
                    ? route('subjects.update', $subject->id) 
                    : route('subjects.create')
            }}" method="post"
        >
            @csrf
            @if(isset($subject) && $subject)
                @method('PUT')
            @endif
            
            <div class="mb-3">
                <label for="nombre_materia" class="form-label">Nombre de la Materia</label>
                <input type="text" class="form-control" id="nombre_materia" name="nombre_materia"
                    value="{{ $subject->nombre_materia ?? '' }}" required
                >
            </div>
            
            <div class="mb-3">
                <label for="descripcion" class="form-label">Descripción</label>
                <textarea class="form-control" id="descripcion" name="descripcion"
                    rows="3">{{ $subject->descripcion ?? '' }}</textarea>
            </div>
            
            <div class="mb-3 form-check">
                <input type="checkbox" class="form-check-input" id="estado" name="estado" 
                    {{ (isset($subject) && !$subject->estado) ? '' : 'checked' }}
                >
                <label class="form-check-label" for="estado">
                    Activo
                </label>
            </div>
            
            <button type="submit" class="btn btn-primary">Guardar</button>
            <a href="{{ route('subjects.index') }}" class="btn btn-warning">Regresar</a>
        </form>
    </div>
@endsection
