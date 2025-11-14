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
                <select class="form-control" id="forma_pago" name="forma_pago" required>
                    <option value="">Seleccionar forma de pago...</option>
                    <option value="efectivo" {{ (isset($enrollment) && $enrollment->forma_pago == 'efectivo') ? 'selected' : '' }}>Efectivo</option>
                    <option value="cheque" {{ (isset($enrollment) && $enrollment->forma_pago == 'cheque') ? 'selected' : '' }}>Cheque</option>
                    <option value="transferencia" {{ (isset($enrollment) && $enrollment->forma_pago == 'transferencia') ? 'selected' : '' }}>Transferencia</option>
                    <option value="tarjeta de crédito" {{ (isset($enrollment) && $enrollment->forma_pago == 'tarjeta de crédito') ? 'selected' : '' }}>Tarjeta de Crédito</option>
                </select>
            </div>
            
            <div class="mb-3">
                <label for="costo" class="form-label">Costo de Matrícula</label>
                <input type="number" step="0.01" class="form-control" id="costo" name="costo"
                    value="{{ $enrollment->costo ?? '500000' }}"
                >
            </div>
            
            <div class="mb-3">
                <label for="estado_pago" class="form-label">Estado de Pago</label>
                <select class="form-control" id="estado_pago" name="estado_pago" required>
                    <option value="pendiente" {{ (isset($enrollment) && $enrollment->estado_pago == 'pendiente') ? 'selected' : '' }}>Pendiente</option>
                    <option value="parcial" {{ (isset($enrollment) && $enrollment->estado_pago == 'parcial') ? 'selected' : '' }}>Parcial</option>
                    <option value="pagado" {{ (isset($enrollment) && $enrollment->estado_pago == 'pagado') ? 'selected' : '' }}>Pagado</option>
                </select>
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
