@extends('layouts.app-menu')

@section('title', '{{ isset($subject) ? "Editar" : "Crear" }} Materia - Sistema Escolar')

@section('content-principal')
    <div class="welcome-header">
        <h1>{{ isset($subject) ? 'Editar' : 'Crear' }} Materia</h1>
        <p>{{ isset($subject) ? 'Modifica los datos de la materia' : 'Agrega una nueva materia al sistema' }}</p>
    </div>

    @if ($errors->any())
        <div class="alert alert-danger alert-dismissible fade show">
            <strong>Errores de validación:</strong>
            <ul class="mb-0 mt-2">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif

    <div class="section-card">
        <div class="card-body">
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
                
                <div class="mb-4">
                    <label for="nombre_materia" class="form-label">Nombre de la Materia</label>
                    <input type="text" class="form-control @error('nombre_materia') is-invalid @enderror" 
                        id="nombre_materia" name="nombre_materia"
                        value="{{ $subject->nombre_materia ?? old('nombre_materia') }}" 
                        placeholder="Ej: Matemáticas"
                        required
                    >
                    @error('nombre_materia')
                        <div class="invalid-feedback d-block">{{ $message }}</div>
                    @enderror
                </div>
                
                <div class="mb-4">
                    <label for="descripcion" class="form-label">Descripción</label>
                    <textarea class="form-control @error('descripcion') is-invalid @enderror" 
                        id="descripcion" name="descripcion"
                        rows="4"
                        placeholder="Describe brevemente el contenido de esta materia"
                    >{{ $subject->descripcion ?? old('descripcion') }}</textarea>
                    @error('descripcion')
                        <div class="invalid-feedback d-block">{{ $message }}</div>
                    @enderror
                </div>
                
                <div class="mb-4">
                    <div class="form-check">
                        <input type="hidden" name="estado" value="false">
                        <input type="checkbox" class="form-check-input" id="estado" name="estado" value="true"
                            {{ (isset($subject) && $subject->estado) ? 'checked' : '' }}
                        >
                        <label class="form-check-label" for="estado">
                            <strong>Materia Activa</strong>
                            <small class="text-muted d-block">Las materias inactivas no aparecerán en listados</small>
                        </label>
                    </div>
                </div>
                
                <div class="d-flex gap-2">
                    <button type="submit" class="btn btn-primary">
                        <i class="fas fa-save me-2"></i>Guardar
                    </button>
                    <a href="{{ route('subjects.index') }}" class="btn btn-outline-secondary">
                        <i class="fas fa-arrow-left me-2"></i>Regresar
                    </a>
                </div>
            </form>
        </div>
    </div>
@endsection
