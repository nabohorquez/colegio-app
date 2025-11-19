@extends('layouts.app-menu')

@section('title', 'Calificaciones de Estudiantes - Sistema Escolar')

@section('content-principal')
<div class="d-flex justify-content-between align-items-center welcome-header">
    <div>
        <h1>
            <i class="fas fa-star me-2"></i>Calificaciones de Estudiantes
        </h1>
        <p class="text-secondary">Gestionar calificaciones por estudiante y asignatura</p>
    </div>
    <div>
        <a href="{{ route('student-grades.create') }}" class="btn btn-primary">
            <i class="fas fa-plus-circle me-2"></i>Nueva Calificación
        </a>
    </div>
</div>

    <!-- Tabla de Calificaciones -->
    <div class="section-card">
        <div class="card-header">
            <h5>
                <i class="fas fa-list me-2"></i>Listado de Calificaciones
            </h5>
        </div>
        <div class="card-body">
            @if(session('success'))
                <div class="alert alert-success alert-dismissible fade show" role="alert">
                    <i class="fas fa-check-circle me-2"></i>{{ session('success') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
            @endif

            @if(session('error'))
                <div class="alert alert-danger alert-dismissible fade show" role="alert">
                    <i class="fas fa-exclamation-circle me-2"></i>{{ session('error') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
            @endif

            @if($grades->count() > 0)
                <div class="table-responsive">
                    <table class="table">
                        <thead>
                            <tr>
                                <th>Estudiante</th>
                                <th>Asignatura</th>
                                <th>Parcial 1</th>
                                <th>Parcial 2</th>
                                <th>Nota Final</th>
                                <th>Estado</th>
                                <th>Acciones</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($grades as $grade)
                                <tr>
                                    <td>
                                        <strong>{{ $grade->student->full_name ?? 'N/A' }}</strong>
                                        <br>
                                        <small class="text-secondary">{{ $grade->student->document ?? 'N/A' }}</small>
                                    </td>
                                    <td>{{ $grade->subject->nombre_materia ?? 'N/A' }}</td>
                                    <td>
                                        @if($grade->partial_1)
                                            <span class="badge bg-primary">{{ number_format($grade->partial_1, 1) }}</span>
                                        @else
                                            <span class="badge bg-secondary">-</span>
                                        @endif
                                    </td>
                                    <td>
                                        @if($grade->partial_2)
                                            <span class="badge bg-primary">{{ number_format($grade->partial_2, 1) }}</span>
                                        @else
                                            <span class="badge bg-secondary">-</span>
                                        @endif
                                    </td>
                                    <td>
                                        @if($grade->final_grade)
                                            @if($grade->final_grade >= 3.0)
                                                <span class="badge bg-success fs-6 px-2 py-2">{{ number_format($grade->final_grade, 1) }}</span>
                                            @else
                                                <span class="badge bg-danger fs-6 px-2 py-2">{{ number_format($grade->final_grade, 1) }}</span>
                                            @endif
                                        @else
                                            <span class="badge bg-secondary">-</span>
                                        @endif
                                    </td>
                                    <td>
                                        @php
                                            $status = $grade->final_grade ? ($grade->final_grade >= 3.0 ? 'APROBADO' : 'REPROBADO') : 'PENDIENTE';
                                            $badgeClass = $status === 'APROBADO' ? 'bg-success' : ($status === 'REPROBADO' ? 'bg-danger' : 'bg-warning');
                                        @endphp
                                        <span class="badge {{ $badgeClass }}">{{ $status }}</span>
                                    </td>
                                    <td>
                                        <div class="btn-group btn-group-sm" role="group">
                                            <a href="{{ route('student-grades.show', $grade->id) }}" class="btn btn-outline-primary" title="Ver">
                                                <i class="fas fa-eye"></i>
                                            </a>
                                            <a href="{{ route('student-grades.edit', $grade->id) }}" class="btn btn-outline-warning" title="Editar">
                                                <i class="fas fa-edit"></i>
                                            </a>
                                            <button type="button" class="btn btn-outline-danger" onclick="deleteGrade({{ $grade->id }})" title="Eliminar">
                                                <i class="fas fa-trash"></i>
                                            </button>
                                        </div>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>

                <!-- Paginación -->
                <div class="d-flex justify-content-center mt-4">
                    {{ $grades->links() }}
                </div>
            @else
                <div class="text-center py-5">
                    <i class="fas fa-inbox fa-3x text-secondary mb-3" style="display: block;"></i>
                    <p class="text-secondary mb-0">No hay calificaciones registradas aún</p>
                    <small class="text-tertiary">¡Comienza creando la primera calificación!</small>
                </div>
            @endif
        </div>
    </div>
<script>
function deleteGrade(id) {
    if (confirm('¿Estás seguro de que deseas eliminar esta calificación?')) {
        const form = document.createElement('form');
        form.method = 'POST';
        form.action = '{{ url("/student-grades") }}/' + id;
        
        const token = document.createElement('input');
        token.type = 'hidden';
        token.name = '_token';
        token.value = '{{ csrf_token() }}';
        
        const method = document.createElement('input');
        method.type = 'hidden';
        method.name = '_method';
        method.value = 'DELETE';
        
        form.appendChild(token);
        form.appendChild(method);
        document.body.appendChild(form);
        form.submit();
    }
}
</script>
@endsection
