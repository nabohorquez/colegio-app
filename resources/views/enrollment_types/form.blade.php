@extends('layouts.app-menu')

@section('title', 'Tipo de Matrícula')

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
                isset($enrollment_type) && $enrollment_type
                    ? route('enrollment-types.update', $enrollment_type->id) 
                    : route('enrollment-types.create')
            }}" method="post"
        >
            @csrf
            @if(isset($enrollment_type) && $enrollment_type)
                @method('PUT')
            @endif
            
            <div class="mb-3">
                <label for="nombre_tipo" class="form-label">Nombre del Tipo</label>
                <input type="text" class="form-control" id="nombre_tipo" name="nombre_tipo"
                    value="{{ $enrollment_type->nombre_tipo ?? '' }}" required
                >
            </div>
            
            <div class="mb-3">
                <label for="descripcion" class="form-label">Descripción</label>
                <textarea class="form-control" id="descripcion" name="descripcion"
                    rows="3">{{ $enrollment_type->descripcion ?? '' }}</textarea>
            </div>
            
            <div class="mb-3 form-check">
                <input type="hidden" name="estado" value="false">
                <input type="checkbox" class="form-check-input" id="estado" name="estado" value="true"
                    {{ (isset($enrollment_type) && $enrollment_type->estado) ? 'checked' : '' }}
                >
                <label class="form-check-label" for="estado">
                    Activo
                </label>
            </div>
            
            <button type="submit" class="btn btn-primary">Guardar</button>
            <a href="{{ route('enrollment-types.index') }}" class="btn btn-warning">Regresar</a>
        </form>
    </div>
@endsection
