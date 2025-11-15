@extends('layouts.app-menu')

@section('title', 'Detalles de Calificación')

@section('content-principal')
    <div class="container-fluid">
        <div class="row">
            <div class="col-12">
                <div class="d-flex justify-content-between align-items-center mb-4">
                    <h3 class="mb-0">Detalles de Calificación</h3>
                    <div>
                        <a href="{{ route('school.grades.edit', $grade->id) }}" class="btn btn-warning btn-sm">
                            <i class="fas fa-edit"></i> Editar
                        </a>
                        <a href="{{ route('school.grades.index') }}" class="btn btn-secondary btn-sm">
                            <i class="fas fa-arrow-left"></i> Volver
                        </a>
                    </div>
                </div>

                <div class="row">
                    <div class="col-lg-8">
                        <div class="card mb-3">
                            <div class="card-header bg-primary text-white">
                                <h5 class="mb-0">Información del Estudiante</h5>
                            </div>
                            <div class="card-body">
                                <div class="row mb-3">
                                    <div class="col-md-6">
                                        <h6 class="text-muted">Nombre del Estudiante</h6>
                                        <p class="h5">{{ $grade->student->full_name }}</p>
                                    </div>
                                    <div class="col-md-6">
                                        <h6 class="text-muted">Grado/Nivel</h6>
                                        <p class="h5">{{ $grade->student->grade }}</p>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-6">
                                        <h6 class="text-muted">Correo Institucional</h6>
                                        <p>{{ $grade->student->institutional_email }}</p>
                                    </div>
                                    <div class="col-md-6">
                                        <h6 class="text-muted">Fecha de Nacimiento</h6>
                                        <p>{{ $grade->student->birth_date ? $grade->student->birth_date->format('d/m/Y') : 'N/A' }}</p>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="card mb-3">
                            <div class="card-header bg-info text-white">
                                <h5 class="mb-0">Información Académica</h5>
                            </div>
                            <div class="card-body">
                                <div class="row mb-3">
                                    <div class="col-md-6">
                                        <h6 class="text-muted">Asignatura</h6>
                                        <p class="h5">{{ $grade->subject }}</p>
                                    </div>
                                    <div class="col-md-6">
                                        <h6 class="text-muted">Período Académico</h6>
                                        <p class="h5"><span class="badge bg-info">{{ $grade->academic_period }}</span></p>
                                    </div>
                                </div>

                                <hr>

                                <div class="row mb-3">
                                    <div class="col-md-4 text-center">
                                        <h6 class="text-muted">Calificación 1er Parcial</h6>
                                        @if($grade->first_partial)
                                            <p class="h4">
                                                <span class="badge bg-primary">{{ $grade->first_partial }}</span>
                                            </p>
                                        @else
                                            <p class="text-muted">No asignada</p>
                                        @endif
                                    </div>
                                    <div class="col-md-4 text-center">
                                        <h6 class="text-muted">Calificación 2do Parcial</h6>
                                        @if($grade->second_partial)
                                            <p class="h4">
                                                <span class="badge bg-primary">{{ $grade->second_partial }}</span>
                                            </p>
                                        @else
                                            <p class="text-muted">No asignada</p>
                                        @endif
                                    </div>
                                    <div class="col-md-4 text-center">
                                        <h6 class="text-muted">Calificación Final</h6>
                                        @if($grade->final_grade)
                                            <p class="h4">
                                                <span class="badge bg-success">{{ $grade->final_grade }}</span>
                                            </p>
                                        @else
                                            <p class="text-muted">No asignada</p>
                                        @endif
                                    </div>
                                </div>

                                @if($grade->notes)
                                    <hr>
                                    <h6 class="text-muted">Observaciones</h6>
                                    <p>{{ $grade->notes }}</p>
                                @endif
                            </div>
                        </div>
                    </div>

                    <div class="col-lg-4">
                        <div class="card bg-light mb-3">
                            <div class="card-header">
                                <h6 class="mb-0">Estado & Desempeño</h6>
                            </div>
                            <div class="card-body">
                                <h6 class="text-muted">Estado</h6>
                                @if($grade->status === 'passed')
                                    <p class="mb-3">
                                        <span class="badge bg-success px-3 py-2">APROBADO</span>
                                    </p>
                                @elseif($grade->status === 'failed')
                                    <p class="mb-3">
                                        <span class="badge bg-danger px-3 py-2">REPROBADO</span>
                                    </p>
                                @else
                                    <p class="mb-3">
                                        <span class="badge bg-warning px-3 py-2">PENDIENTE</span>
                                    </p>
                                @endif

                                <h6 class="text-muted">Promedio Parcial</h6>
                                @if($grade->average_partial)
                                    <p class="h5"><strong>{{ $grade->average_partial }}</strong></p>
                                @else
                                    <p class="text-muted">No disponible</p>
                                @endif
                            </div>
                        </div>

                        <div class="card bg-light">
                            <div class="card-header">
                                <h6 class="mb-0">Información de Auditoría</h6>
                            </div>
                            <div class="card-body">
                                <p>
                                    <strong>Asignada por:</strong><br>
                                    {{ $grade->creator->first_name ?? '' }} {{ $grade->creator->last_name ?? '' }}
                                </p>
                                <p>
                                    <strong>Creada:</strong><br>
                                    {{ $grade->created_at->format('d/m/Y H:i') }}
                                </p>
                                @if($grade->updated_at->ne($grade->created_at))
                                    <p>
                                        <strong>Última actualización:</strong><br>
                                        {{ $grade->updated_at->format('d/m/Y H:i') }}
                                    </p>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
