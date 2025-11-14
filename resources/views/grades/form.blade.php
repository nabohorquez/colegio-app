@extends('layouts.app-menu')

@section('title', '{{ isset($grade) ? "Editar" : "Crear" }} Grado - Sistema Escolar')

@section('content-principal')
    <div class="welcome-header">
        <h1>{{ isset($grade) ? 'Editar' : 'Crear' }} Grado</h1>
        <p>{{ isset($grade) ? 'Modifica los datos del grado' : 'Agrega un nuevo grado al sistema' }}</p>
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
                    isset($grade) && $grade
                        ? route('grades.update', $grade->id) 
                        : route('grades.create')
                }}" method="post"
            >
                @csrf
                @if(isset($grade) && $grade)
                    @method('PUT')
                @endif
                
                <div class="row">
                    <div class="col-md-6 mb-4">
                        <label for="nombre_grado" class="form-label">Nombre del Grado</label>
                        <input type="text" class="form-control @error('nombre_grado') is-invalid @enderror" 
                            id="nombre_grado" name="nombre_grado"
                            value="{{ $grade->nombre_grado ?? old('nombre_grado') }}" 
                            placeholder="Ej: Primero Básico"
                            required
                        >
                        @error('nombre_grado')
                            <div class="invalid-feedback d-block">{{ $message }}</div>
                        @enderror
                    </div>
                    
                    <div class="col-md-6 mb-4">
                        <label for="nivel" class="form-label">Nivel</label>
                        <input type="text" class="form-control @error('nivel') is-invalid @enderror" 
                            id="nivel" name="nivel"
                            value="{{ $grade->nivel ?? old('nivel') }}" 
                            placeholder="Ej: Primaria"
                            required
                        >
                        @error('nivel')
                            <div class="invalid-feedback d-block">{{ $message }}</div>
                        @enderror
                    </div>
                </div>
                
                <div class="mb-4">
                    <div class="form-check">
                        <input type="hidden" name="estado" value="false">
                        <input type="checkbox" class="form-check-input" id="estado" name="estado" value="true"
                            {{ (isset($grade) && $grade->estado) ? 'checked' : '' }}
                        >
                        <label class="form-check-label" for="estado">
                            <strong>Grado Activo</strong>
                            <small class="text-muted d-block">Los grados inactivos no aparecerán en listados</small>
                        </label>
                    </div>
                </div>
                
                <div class="d-flex gap-2">
                    <button type="submit" class="btn btn-primary">
                        <i class="fas fa-save me-2"></i>Guardar
                    </button>
                    <a href="{{ route('grades.index') }}" class="btn btn-outline-secondary">
                        <i class="fas fa-arrow-left me-2"></i>Regresar
                    </a>
                </div>
            </form>
        </div>
    </div>
@endsection
