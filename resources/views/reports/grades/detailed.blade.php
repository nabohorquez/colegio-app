@extends('layouts.app-menu')

@section('title', 'Roles - AcademicSoftware')

@section('content-principal')
<div class="container-fluid py-4">
    <!-- Header -->
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h2 class="mb-1">
                <i class="fas fa-file-alt me-2"></i>Reporte Detallado de Notas
            </h2>
            <p class="text-muted mb-0">Vista detallada de todas las calificaciones por estudiante y materia</p>
        </div>
        <div>
            <button onclick="window.print()" class="btn btn-primary">
                <i class="fas fa-print me-2"></i>Imprimir
            </button>
            <a href="{{ route('reports.grades.consolidated') }}" class="btn btn-outline-secondary">
                <i class="fas fa-file-invoice me-2"></i>Ver Consolidado
            </a>
        </div>
    </div>

    <!-- Filtros -->
    <div class="card mb-4">
        <div class="card-header">
            <h5 class="mb-0"><i class="fas fa-filter me-2"></i>Filtros</h5>
        </div>
        <div class="card-body">
            <form method="GET" action="{{ route('reports.grades.detailed') }}" class="row g-3">
                <div class="col-md-5">
                    <label for="student_id" class="form-label">Estudiante</label>
                    <select name="student_id" id="student_id" class="form-select">
                        <option value="">Todos los estudiantes</option>
                        @foreach($students as $student)
                            <option value="{{ $student->id }}" {{ request('student_id') == $student->id ? 'selected' : '' }}>
                                {{ $student->first_name }} {{ $student->last_name }}
                            </option>
                        @endforeach
                    </select>
                </div>
                <div class="col-md-5">
                    <label for="subject_id" class="form-label">Materia</label>
                    <select name="subject_id" id="subject_id" class="form-select">
                        <option value="">Todas las materias</option>
                        @foreach($subjects as $subject)
                            <option value="{{ $subject->id }}" {{ request('subject_id') == $subject->id ? 'selected' : '' }}>
                                {{ $subject->nombre_materia }}
                            </option>
                        @endforeach
                    </select>
                </div>
                <div class="col-md-2 d-flex align-items-end">
                    <button type="submit" class="btn btn-primary w-100">
                        <i class="fas fa-search me-2"></i>Filtrar
                    </button>
                </div>
            </form>
        </div>
    </div>

    <!-- Tabla de Resultados -->
    <div class="card">
        <div class="card-body">
            @if($grades->isEmpty())
                <div class="alert alert-info text-center">
                    <i class="fas fa-info-circle me-2"></i>
                    No se encontraron calificaciones con los filtros seleccionados.
                </div>
            @else
                <div class="table-responsive">
                    <table class="table table-hover table-striped">
                        <thead class="table-dark">
                            <tr>
                                <th>Estudiante</th>
                                <th>Materia</th>
                                <th>Profesor</th>
                                <th class="text-center">Parcial 1</th>
                                <th class="text-center">Parcial 2</th>
                                <th class="text-center">Nota Final</th>
                                <th class="text-center">Estado</th>
                                <th>Observaciones</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($grades as $grade)
                                <tr>
                                    <td>
                                        <div class="fw-bold">{{ $grade->student->first_name }} {{ $grade->student->last_name }}</div>
                                        <small class="text-muted">{{ $grade->student->document }}</small>
                                    </td>
                                    <td>{{ $grade->subject->nombre_materia }}</td>
                                    <td>
                                        @if($grade->subject->employees->isNotEmpty())
                                            @foreach($grade->subject->employees as $employee)
                                                <div>{{ $employee->user->name }}</div>
                                            @endforeach
                                        @else
                                            <span class="text-muted">Sin asignar</span>
                                        @endif
                                    </td>
                                    <td class="text-center">
                                        @if($grade->partial_1)
                                            <span class="badge bg-info">{{ number_format($grade->partial_1, 1) }}</span>
                                        @else
                                            <span class="text-muted">-</span>
                                        @endif
                                    </td>
                                    <td class="text-center">
                                        @if($grade->partial_2)
                                            <span class="badge bg-info">{{ number_format($grade->partial_2, 1) }}</span>
                                        @else
                                            <span class="text-muted">-</span>
                                        @endif
                                    </td>
                                    <td class="text-center">
                                        @if($grade->final_grade)
                                            <span class="badge {{ $grade->final_grade >= 3.0 ? 'bg-success' : 'bg-danger' }} fs-6">
                                                {{ number_format($grade->final_grade, 1) }}
                                            </span>
                                        @else
                                            <span class="text-muted">Pendiente</span>
                                        @endif
                                    </td>
                                    <td class="text-center">
                                        @if($grade->final_grade)
                                            @if($grade->final_grade >= 3.0)
                                                <span class="badge bg-success">
                                                    <i class="fas fa-check-circle me-1"></i>APROBADO
                                                </span>
                                            @else
                                                <span class="badge bg-danger">
                                                    <i class="fas fa-times-circle me-1"></i>REPROBADO
                                                </span>
                                            @endif
                                        @else
                                            <span class="badge bg-secondary">PENDIENTE</span>
                                        @endif
                                    </td>
                                    <td>
                                        @if($grade->observations)
                                            <small>{{ Str::limit($grade->observations, 50) }}</small>
                                        @else
                                            <span class="text-muted">-</span>
                                        @endif
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>

                <!-- Resumen -->
                <div class="mt-3 p-3 bg-light rounded">
                    <div class="row text-center">
                        <div class="col-md-3">
                            <h5 class="mb-0">{{ $grades->count() }}</h5>
                            <small class="text-muted">Total Registros</small>
                        </div>
                        <div class="col-md-3">
                            <h5 class="mb-0">{{ $grades->unique('student_id')->count() }}</h5>
                            <small class="text-muted">Estudiantes</small>
                        </div>
                        <div class="col-md-3">
                            <h5 class="mb-0">{{ $grades->where('final_grade', '>=', 3.0)->count() }}</h5>
                            <small class="text-muted text-success">Aprobados</small>
                        </div>
                        <div class="col-md-3">
                            <h5 class="mb-0">{{ $grades->where('final_grade', '<', 3.0)->where('final_grade', '!=', null)->count() }}</h5>
                            <small class="text-muted text-danger">Reprobados</small>
                        </div>
                    </div>
                </div>
            @endif
        </div>
    </div>
</div>

<style>
    @media print {
        .btn, .card-header, nav, .no-print {
            display: none !important;
        }
        .card {
            border: none !important;
            box-shadow: none !important;
        }
    }
</style>
@endsection
