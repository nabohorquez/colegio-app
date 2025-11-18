@extends('layouts.app-menu')

@section('title', 'Calificaciones del Estudiante')

@section('content-principal')
    <div class="container-fluid">
        <div class="row">
            <div class="col-12">
                <div class="d-flex justify-content-between align-items-center mb-4">
                    <div>
                        <h3 class="mb-0">Calificaciones de {{ $student->full_name }}</h3>
                        <small class="text-muted">Grado: {{ $student->grade }} | Correo: {{ $student->institutional_email }}</small>
                    </div>
                    <a href="{{ route('school.grades.index') }}" class="btn btn-secondary btn-sm">
                        <i class="fas fa-arrow-left"></i> Volver
                    </a>
                </div>

                @forelse($grades as $period => $periodGrades)
                    <div class="card mb-4">
                        <div class="card-header bg-primary text-white">
                            <h5 class="mb-0"><i class="fas fa-calendar"></i> Período: {{ $period }}</h5>
                        </div>
                        <div class="card-body p-0">
                            <div class="table-responsive">
                                <table class="table table-hover mb-0">
                                    <thead class="table-light">
                                        <tr>
                                            <th><i class="fas fa-book"></i> Asignatura</th>
                                            <th class="text-center">1er Parcial</th>
                                            <th class="text-center">2do Parcial</th>
                                            <th class="text-center">Promedio</th>
                                            <th class="text-center">Calificación Final</th>
                                            <th class="text-center">Estado</th>
                                            <th class="text-center">Acciones</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach($periodGrades as $grade)
                                            <tr>
                                                <td>
                                                    <strong>{{ $grade->subject }}</strong>
                                                </td>
                                                <td class="text-center">
                                                    @if($grade->first_partial)
                                                        <span class="badge bg-info">{{ $grade->first_partial }}</span>
                                                    @else
                                                        <span class="text-muted">-</span>
                                                    @endif
                                                </td>
                                                <td class="text-center">
                                                    @if($grade->second_partial)
                                                        <span class="badge bg-info">{{ $grade->second_partial }}</span>
                                                    @else
                                                        <span class="text-muted">-</span>
                                                    @endif
                                                </td>
                                                <td class="text-center">
                                                    @if($grade->average_partial)
                                                        <strong class="text-primary">{{ $grade->average_partial }}</strong>
                                                    @else
                                                        <span class="text-muted">-</span>
                                                    @endif
                                                </td>
                                                <td class="text-center">
                                                    @if($grade->final_grade)
                                                        <span class="badge bg-success px-3">{{ $grade->final_grade }}</span>
                                                    @else
                                                        <span class="text-muted">-</span>
                                                    @endif
                                                </td>
                                                <td class="text-center">
                                                    @if($grade->status === 'passed')
                                                        <span class="badge bg-success">Aprobado</span>
                                                    @elseif($grade->status === 'failed')
                                                        <span class="badge bg-danger">Reprobado</span>
                                                    @else
                                                        <span class="badge bg-warning">Pendiente</span>
                                                    @endif
                                                </td>
                                                <td class="text-center">
                                                    <div class="btn-group btn-group-sm" role="group">
                                                        <a href="{{ route('school.grades.show', $grade->id) }}" 
                                                           class="btn btn-info btn-sm" title="Ver detalles">
                                                            <i class="fas fa-eye"></i>
                                                        </a>
                                                        <a href="{{ route('school.grades.edit', $grade->id) }}" 
                                                           class="btn btn-warning btn-sm" title="Editar">
                                                            <i class="fas fa-edit"></i>
                                                        </a>
                                                        <button type="button" class="btn btn-danger btn-sm" 
                                                                onclick="confirmDelete({{ $grade->id }}, '{{ $grade->subject }}');"
                                                                title="Eliminar">
                                                            <i class="fas fa-trash"></i>
                                                        </button>
                                                    </div>
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                @empty
                    <div class="alert alert-info" role="alert">
                        <i class="fas fa-info-circle"></i> 
                        No hay calificaciones registradas para este estudiante.
                    </div>
                @endforelse
            </div>
        </div>
    </div>

    <!-- Delete Form (Hidden) -->
    <form id="deleteForm" method="POST" style="display:none;">
        @csrf
        @method('DELETE')
    </form>

    <script>
        function confirmDelete(gradeId, subject) {
            if (confirm(`¿Estás seguro de que deseas eliminar la calificación de ${subject}?`)) {
                document.getElementById('deleteForm').action = `{{ route('school.grades.destroy', '') }}/${gradeId}`;
                document.getElementById('deleteForm').submit();
            }
        }
    </script>
@endsection
