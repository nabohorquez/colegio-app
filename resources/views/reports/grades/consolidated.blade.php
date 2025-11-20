@extends('layouts.app-menu')

@section('title', 'Roles - AcademicSoftware')

@section('content-principal')
<div class="container-fluid py-4">
    <!-- Header -->
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h2 class="mb-1">
                <i class="fas fa-file-invoice me-2"></i>Reporte Consolidado de Notas
            </h2>
            <p class="text-muted mb-0">Resumen de notas finales por estudiante y materia</p>
        </div>
        <div>
            <button onclick="window.print()" class="btn btn-primary">
                <i class="fas fa-print me-2"></i>Imprimir
            </button>
            <a href="{{ route('reports.grades.detailed') }}" class="btn btn-outline-secondary">
                <i class="fas fa-list me-2"></i>Ver Detallado
            </a>
        </div>
    </div>

    <!-- Estadísticas -->
    <div class="row mb-4">
        <div class="col-md-3">
            <div class="card text-center border-primary">
                <div class="card-body">
                    <h3 class="mb-0 text-primary">{{ $statistics['total_students'] }}</h3>
                    <p class="mb-0 text-muted">Estudiantes</p>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card text-center border-info">
                <div class="card-body">
                    <h3 class="mb-0 text-info">{{ $statistics['total_subjects'] }}</h3>
                    <p class="mb-0 text-muted">Materias</p>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card text-center border-success">
                <div class="card-body">
                    <h3 class="mb-0 text-success">{{ $statistics['approved'] }}</h3>
                    <p class="mb-0 text-muted">Aprobados</p>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card text-center border-danger">
                <div class="card-body">
                    <h3 class="mb-0 text-danger">{{ $statistics['failed'] }}</h3>
                    <p class="mb-0 text-muted">Reprobados</p>
                </div>
            </div>
        </div>
    </div>

    <!-- Promedio General -->
    <div class="alert alert-info mb-4">
        <div class="d-flex align-items-center justify-content-center">
            <i class="fas fa-chart-line fa-2x me-3"></i>
            <div>
                <h5 class="mb-0">Promedio General: <strong>{{ number_format($statistics['average'], 2) }}</strong></h5>
                <small>Calculado sobre todas las notas finales registradas</small>
            </div>
        </div>
    </div>

    <!-- Filtros -->
    <div class="card mb-4">
        <div class="card-header">
            <h5 class="mb-0"><i class="fas fa-filter me-2"></i>Filtros</h5>
        </div>
        <div class="card-body">
            <form method="GET" action="{{ route('reports.grades.consolidated') }}" class="row g-3">
                <div class="col-md-4">
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
                <div class="col-md-4">
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
                <div class="col-md-2">
                    <label for="status" class="form-label">Estado</label>
                    <select name="status" id="status" class="form-select">
                        <option value="">Todos</option>
                        <option value="aprobado" {{ request('status') == 'aprobado' ? 'selected' : '' }}>Aprobado</option>
                        <option value="reprobado" {{ request('status') == 'reprobado' ? 'selected' : '' }}>Reprobado</option>
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
                    No se encontraron calificaciones finales con los filtros seleccionados.
                </div>
            @else
                <div class="table-responsive">
                    <table class="table table-hover table-striped">
                        <thead class="table-dark">
                            <tr>
                                <th>#</th>
                                <th>Estudiante</th>
                                <th>Materia</th>
                                <th>Profesor</th>
                                <th class="text-center">Nota Final</th>
                                <th class="text-center">Estado</th>
                                <th>Fecha Registro</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($grades as $index => $grade)
                                <tr class="{{ $grade->final_grade < 3.0 ? 'table-danger' : '' }}">
                                    <td>{{ $index + 1 }}</td>
                                    <td>
                                        <div class="fw-bold">{{ $grade->student->first_name }} {{ $grade->student->last_name }}</div>
                                        <small class="text-muted">Doc: {{ $grade->student->document }}</small>
                                    </td>
                                    <td>
                                        <span class="badge bg-secondary">{{ $grade->subject->nombre_materia }}</span>
                                    </td>
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
                                        <span class="badge {{ $grade->final_grade >= 3.0 ? 'bg-success' : 'bg-danger' }} fs-5">
                                            {{ number_format($grade->final_grade, 1) }}
                                        </span>
                                    </td>
                                    <td class="text-center">
                                        @if($grade->final_grade >= 3.0)
                                            <span class="badge bg-success">
                                                <i class="fas fa-check-circle me-1"></i>APROBADO
                                            </span>
                                        @else
                                            <span class="badge bg-danger">
                                                <i class="fas fa-times-circle me-1"></i>REPROBADO
                                            </span>
                                        @endif
                                    </td>
                                    <td>
                                        <small>{{ $grade->created_at->format('d/m/Y H:i') }}</small>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                        <tfoot class="table-light">
                            <tr>
                                <td colspan="4" class="text-end fw-bold">Promedio:</td>
                                <td class="text-center fw-bold">
                                    <span class="badge bg-primary fs-5">
                                        {{ number_format($grades->avg('final_grade'), 2) }}
                                    </span>
                                </td>
                                <td colspan="2"></td>
                            </tr>
                        </tfoot>
                    </table>
                </div>

                <!-- Gráfico de Distribución -->
                <div class="mt-4">
                    <h5>Distribución de Notas</h5>
                    <div class="row">
                        <div class="col-md-12">
                            <div class="progress" style="height: 30px;">
                                @php
                                    $total = $grades->count();
                                    $approved = $grades->where('final_grade', '>=', 3.0)->count();
                                    $failed = $grades->where('final_grade', '<', 3.0)->count();
                                    $approvedPercent = $total > 0 ? ($approved / $total) * 100 : 0;
                                    $failedPercent = $total > 0 ? ($failed / $total) * 100 : 0;
                                @endphp
                                <div class="progress-bar bg-success" role="progressbar" 
                                     style="width: {{ $approvedPercent }}%" 
                                     aria-valuenow="{{ $approvedPercent }}" aria-valuemin="0" aria-valuemax="100">
                                    Aprobados: {{ number_format($approvedPercent, 1) }}%
                                </div>
                                <div class="progress-bar bg-danger" role="progressbar" 
                                     style="width: {{ $failedPercent }}%" 
                                     aria-valuenow="{{ $failedPercent }}" aria-valuemin="0" aria-valuemax="100">
                                    Reprobados: {{ number_format($failedPercent, 1) }}%
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            @endif
        </div>
    </div>
</div>

<style>
    @media print {
        .btn, .card-header, nav, .no-print, .progress {
            display: none !important;
        }
        .card {
            border: none !important;
            box-shadow: none !important;
        }
        .table-danger {
            background-color: #f8d7da !important;
        }
    }
</style>
@endsection
