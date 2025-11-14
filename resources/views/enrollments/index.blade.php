@extends('layouts.app-menu')

@section('title', 'Matrículas - Sistema Escolar')

@section('content-principal')
    <div class="d-flex justify-content-between align-items-center welcome-header">
        <div>
            <h1>Matrículas</h1>
            <p>Gestiona las matrículas de estudiantes</p>
        </div>
        <a href="{{ route('enrollments.viewCreate') }}" class="btn btn-primary">
            <i class="fas fa-plus me-2"></i>Nueva Matrícula
        </a>
    </div>

    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show">
            <i class="fas fa-check-circle me-2"></i>{{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif

    @if(session('error'))
        <div class="alert alert-danger alert-dismissible fade show">
            <i class="fas fa-exclamation-circle me-2"></i>{{ session('error') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif

    <div class="section-card">
        <div class="card-body">
            @if($enrollments->count() > 0)
                <div class="table-responsive">
                    <table class="table">
                        <thead>
                            <tr>
                                <th>Estudiante</th>
                                <th>Grado</th>
                                <th>Tipo Matrícula</th>
                                <th>Forma Pago</th>
                                <th>Costo</th>
                                <th>Estado Pago</th>
                                <th>Fecha</th>
                                <th>Acciones</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($enrollments as $enrollment)
                                <tr>
                                    <td><strong>{{ $enrollment->student->first_name ?? 'N/A' }}</strong></td>
                                    <td>{{ $enrollment->grade->nombre_grado ?? 'N/A' }}</td>
                                    <td><span class="badge bg-info">{{ $enrollment->enrollmentType->nombre_tipo ?? 'N/A' }}</span></td>
                                    <td>{{ ucfirst($enrollment->forma_pago) }}</td>
                                    <td>${{ number_format($enrollment->costo ?? 0, 2) }}</td>
                                    <td>
                                        @php
                                            $statusBg = match($enrollment->estado_pago ?? 'pendiente') {
                                                'pagado' => 'bg-success',
                                                'parcial' => 'bg-warning',
                                                default => 'bg-danger'
                                            };
                                        @endphp
                                        <span class="badge {{ $statusBg }}">{{ ucfirst($enrollment->estado_pago ?? 'pendiente') }}</span>
                                    </td>
                                    <td>{{ $enrollment->fecha ? $enrollment->fecha->format('d/m/Y') : 'N/A' }}</td>
                                    <td>
                                        <div class="btn-group btn-group-sm">
                                            <a href="{{ route('enrollments.getById', $enrollment->id) }}" class="btn btn-outline-primary" title="Editar">
                                                <i class="fas fa-edit"></i>
                                            </a>
                                            <form action="{{ route('enrollments.delete', $enrollment->id) }}" method="POST" style="display:inline;">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-outline-danger" title="Eliminar" onclick="return confirm('¿Eliminar esta matrícula?')">
                                                    <i class="fas fa-trash"></i>
                                                </button>
                                            </form>
                                        </div>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            @else
                <div class="text-center py-5">
                    <i class="fas fa-inbox fa-3x text-muted mb-3" style="display: block;"></i>
                    <p class="text-muted">No hay matrículas registradas</p>
                </div>
            @endif
        </div>
    </div>
@endsection
