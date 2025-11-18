@extends('layouts.app-menu')

@section('title', '{{ isset($enrollment) ? "Editar" : "Crear" }} Matrícula - Sistema Escolar')

@section('content-principal')
    <div class="welcome-header">
        <h1>{{ isset($enrollment) ? 'Editar' : 'Crear' }} Matrícula</h1>
        <p>{{ isset($enrollment) ? 'Modifica los datos de la matrícula' : 'Registra una nueva matrícula' }}</p>
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
                    isset($enrollment) && $enrollment
                        ? route('enrollments.update', $enrollment->id) 
                        : route('enrollments.create')
                }}" method="post"
            >
                @csrf
                @if(isset($enrollment) && $enrollment)
                    @method('PUT')
                @endif
                
                <!-- Información del Estudiante -->
                <div class="row">
                    <div class="col-md-6 mb-4">
                        <label for="estudiante_id" class="form-label">Estudiante</label>
                        <select class="form-control @error('estudiante_id') is-invalid @enderror" 
                            id="estudiante_id" name="estudiante_id" required>
                            <option value="">Seleccionar estudiante...</option>
                            @foreach($students as $student)
                                <option value="{{ $student->id }}" 
                                    {{ (isset($enrollment) && $enrollment->estudiante_id == $student->id) ? 'selected' : '' }}>
                                    {{ $student->first_name }} {{ $student->last_name }}
                                </option>
                            @endforeach
                        </select>
                        @error('estudiante_id')
                            <div class="invalid-feedback d-block">{{ $message }}</div>
                        @enderror
                    </div>
                    
                    <div class="col-md-6 mb-4">
                        <label for="grado_id" class="form-label">Grado</label>
                        <select class="form-control @error('grado_id') is-invalid @enderror" 
                            id="grado_id" name="grado_id" required>
                            <option value="">Seleccionar grado...</option>
                            @foreach($grades as $grade)
                                <option value="{{ $grade->id }}" 
                                    {{ (isset($enrollment) && $enrollment->grado_id == $grade->id) ? 'selected' : '' }}>
                                    {{ $grade->nombre_grado }}
                                </option>
                            @endforeach
                        </select>
                        @error('grado_id')
                            <div class="invalid-feedback d-block">{{ $message }}</div>
                        @enderror
                    </div>
                </div>

                <!-- Tipo de Matrícula -->
                <div class="row">
                    <div class="col-md-6 mb-4">
                        <label for="tipo_matricula_id" class="form-label">Tipo de Matrícula</label>
                        <select class="form-control @error('tipo_matricula_id') is-invalid @enderror" 
                            id="tipo_matricula_id" name="tipo_matricula_id" required>
                            <option value="">Seleccionar tipo...</option>
                            @foreach($enrollmentTypes as $type)
                                <option value="{{ $type->id }}" 
                                    {{ (isset($enrollment) && $enrollment->tipo_matricula_id == $type->id) ? 'selected' : '' }}>
                                    {{ $type->nombre_tipo }}
                                </option>
                            @endforeach
                        </select>
                        @error('tipo_matricula_id')
                            <div class="invalid-feedback d-block">{{ $message }}</div>
                        @enderror
                    </div>
                    
                    <div class="col-md-6 mb-4">
                        <label for="fecha" class="form-label">Fecha de Matrícula</label>
                        <input type="date" class="form-control @error('fecha') is-invalid @enderror" 
                            id="fecha" name="fecha"
                            value="{{ isset($enrollment) && $enrollment->fecha ? $enrollment->fecha->format('Y-m-d') : now()->format('Y-m-d') }}" 
                            required
                        >
                        @error('fecha')
                            <div class="invalid-feedback d-block">{{ $message }}</div>
                        @enderror
                    </div>
                </div>

                <!-- Información de Pago -->
                <div class="row">
                    <div class="col-md-6 mb-4">
                        <label for="forma_pago" class="form-label">Forma de Pago</label>
                        <select class="form-control @error('forma_pago') is-invalid @enderror" 
                            id="forma_pago" name="forma_pago" required>
                            <option value="">Seleccionar forma de pago...</option>
                            <option value="efectivo" {{ (isset($enrollment) && $enrollment->forma_pago == 'efectivo') ? 'selected' : '' }}>Efectivo</option>
                            <option value="cheque" {{ (isset($enrollment) && $enrollment->forma_pago == 'cheque') ? 'selected' : '' }}>Cheque</option>
                            <option value="transferencia" {{ (isset($enrollment) && $enrollment->forma_pago == 'transferencia') ? 'selected' : '' }}>Transferencia</option>
                            <option value="tarjeta de crédito" {{ (isset($enrollment) && $enrollment->forma_pago == 'tarjeta de crédito') ? 'selected' : '' }}>Tarjeta de Crédito</option>
                        </select>
                        @error('forma_pago')
                            <div class="invalid-feedback d-block">{{ $message }}</div>
                        @enderror
                    </div>
                    
                    <div class="col-md-6 mb-4">
                        <label for="costo" class="form-label">Costo de Matrícula</label>
                        <div class="input-group">
                            <span class="input-group-text">$</span>
                            <input type="number" step="0.01" class="form-control @error('costo') is-invalid @enderror" 
                                id="costo" name="costo"
                                value="{{ $enrollment->costo ?? '500000' }}"
                                placeholder="0.00"
                            >
                        </div>
                        @error('costo')
                            <div class="invalid-feedback d-block">{{ $message }}</div>
                        @enderror
                    </div>
                </div>

                <div class="mb-4">
                    <label for="estado_pago" class="form-label">Estado de Pago</label>
                    <select class="form-control @error('estado_pago') is-invalid @enderror" 
                        id="estado_pago" name="estado_pago" required>
                        <option value="pendiente" {{ (isset($enrollment) && $enrollment->estado_pago == 'pendiente') ? 'selected' : '' }}>Pendiente</option>
                        <option value="parcial" {{ (isset($enrollment) && $enrollment->estado_pago == 'parcial') ? 'selected' : '' }}>Pagado Parcialmente</option>
                        <option value="pagado" {{ (isset($enrollment) && $enrollment->estado_pago == 'pagado') ? 'selected' : '' }}>Pagado Completamente</option>
                    </select>
                    @error('estado_pago')
                        <div class="invalid-feedback d-block">{{ $message }}</div>
                    @enderror
                </div>
                
                <div class="mb-4">
                    <div class="form-check">
                        <input type="hidden" name="estado" value="false">
                        <input type="checkbox" class="form-check-input" id="estado" name="estado" value="true"
                            {{ (isset($enrollment) && $enrollment->estado) ? 'checked' : '' }}
                        >
                        <label class="form-check-label" for="estado">
                            <strong>Matrícula Activa</strong>
                            <small class="text-muted d-block">Las matrículas inactivas aparecerán como canceladas</small>
                        </label>
                    </div>
                </div>
                
                <div class="d-flex gap-2">
                    <button type="submit" class="btn btn-primary">
                        <i class="fas fa-save me-2"></i>Guardar
                    </button>
                    <a href="{{ route('enrollments.index') }}" class="btn btn-outline-secondary">
                        <i class="fas fa-arrow-left me-2"></i>Regresar
                    </a>
                </div>
            </form>
        </div>
    </div>
@endsection
