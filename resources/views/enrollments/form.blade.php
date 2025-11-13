@extends('layouts.app-menu')

@section('title', 'Matrícula')

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
                isset($enrollment) && $enrollment
                    ? route('enrollments.update', $enrollment->id) 
                    : route('enrollments.create')
            }}" method="post"
        >
            @csrf
            @if(isset($enrollment) && $enrollment)
                @method('PUT')
            @endif
            
            <div class="mb-3">
                <label for="estudiante_id" class="form-label">Estudiante</label>
                <select class="form-control" id="estudiante_id" name="estudiante_id" required>
                    <option value="">Seleccionar estudiante...</option>
                    @foreach($students as $student)
                        <option value="{{ $student->id }}" 
                            {{ (isset($enrollment) && $enrollment->estudiante_id == $student->id) ? 'selected' : '' }}>
                            {{ $student->full_name }}
                        </option>
                    @endforeach
                </select>
            </div>
            
            <div class="mb-3">
                <label for="grado_id" class="form-label">Grado</label>
                <select class="form-control" id="grado_id" name="grado_id" required>
                    <option value="">Seleccionar grado...</option>
                    @foreach($grades as $grade)
                        <option value="{{ $grade->id }}" 
                            {{ (isset($enrollment) && $enrollment->grado_id == $grade->id) ? 'selected' : '' }}>
                            {{ $grade->nombre_grado }}
                        </option>
                    @endforeach
                </select>
            </div>
            
            <div class="mb-3">
                <label for="tipo_matricula_id" class="form-label">Tipo de Matrícula</label>
                <select class="form-control" id="tipo_matricula_id" name="tipo_matricula_id" required>
                    <option value="">Seleccionar tipo...</option>
                    @foreach($enrollmentTypes as $type)
                        <option value="{{ $type->id }}" 
                            {{ (isset($enrollment) && $enrollment->tipo_matricula_id == $type->id) ? 'selected' : '' }}>
                            {{ $type->nombre_tipo }}
                        </option>
                    @endforeach
                </select>
            </div>
            
            <div class="mb-3">
                <label for="forma_pago" class="form-label">Forma de Pago</label>
                <input type="text" class="form-control" id="forma_pago" name="forma_pago"
                    value="{{ $enrollment->forma_pago ?? 'mensual' }}" required
                >
            </div>
            
            <div class="mb-3">
                <label for="fecha" class="form-label">Fecha</label>
                <input type="date" class="form-control" id="fecha" name="fecha"
                    value="{{ isset($enrollment) && $enrollment->fecha ? $enrollment->fecha->format('Y-m-d') : now()->format('Y-m-d') }}" required
                >
            </div>
            
            <div class="mb-3 form-check">
                <input type="checkbox" class="form-check-input" id="estado" name="estado" 
                    {{ (isset($enrollment) && !$enrollment->estado) ? '' : 'checked' }}
                >
                <label class="form-check-label" for="estado">
                    Activo
                </label>
            </div>
            
            <button type="submit" class="btn btn-primary">Guardar</button>
            <a href="{{ route('enrollments.index') }}" class="btn btn-warning">Regresar</a>
        </form>
    </div>
@endsection
