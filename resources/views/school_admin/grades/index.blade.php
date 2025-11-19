@extends('layouts.app-menu')

@section('title', 'Gestión de Calificaciones')

@section('content-principal')
    <div class="container-fluid">
        <div class="row mb-4">
            <div class="col-12">
                <div class="d-flex justify-content-between align-items-center">
                    <h3 class="mb-0"><i class="fas fa-graduation-cap"></i> Gestión de Calificaciones</h3>
                    <a href="{{ route('student-grades.create') }}" class="btn btn-primary">
                        <i class="fas fa-plus"></i> Asignar Nueva Calificación
                    </a>
                </div>
            </div>
        </div>

        @if ($message = Session::get('success'))
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                <strong>Éxito:</strong> {{ $message }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif

        <!-- Barra de Búsqueda -->
        <div class="row mb-4">
            <div class="col-12">
                <div class="input-group">
                    <span class="input-group-text"><i class="fas fa-search"></i></span>
                    <input type="text" id="studentSearch" class="form-control" placeholder="Buscar estudiante por nombre...">
                </div>
            </div>
        </div>

        <div class="row">
            @forelse($students as $student)
                <div class="col-12 mb-3 student-card">
                    <div class="card h-100 shadow-sm">
                        <div class="card-header bg-primary text-white" data-bs-toggle="collapse" href="#grades-{{ $student->id }}" role="button" aria-expanded="false" style="cursor: pointer;">
                            <div class="d-flex justify-content-between align-items-center">
                                <div>
                                    <h6 class="mb-0"><i class="fas fa-user-graduate"></i> {{ $student->full_name }}</h6>
                                    <small>Grado: {{ $student->grade }}</small>
                                </div>
                                <button class="btn btn-sm btn-light" type="button" data-bs-toggle="collapse" 
                                        data-bs-target="#grades-{{ $student->id }}" aria-expanded="false">
                                    <i class="fas fa-chevron-down"></i>
                                </button>
                            </div>
                        </div>

                        <div class="collapse" id="grades-{{ $student->id }}" data-bs-parent="#student-accordion">
                            <div class="card-body p-0">
                                @if($student->grades->count() > 0)
                                    <div class="accordion accordion-flush" id="subject-accordion-{{ $student->id }}">
                                        @foreach($student->grades->groupBy('subject') as $subject => $grades)
                                            <div class="accordion-item">
                                                <h2 class="accordion-header" id="subject-header-{{ $student->id }}-{{ Str::slug($subject) }}">
                                                    <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#subject-body-{{ $student->id }}-{{ Str::slug($subject) }}">
                                                        <i class="fas fa-book me-2"></i> {{ $subject }}
                                                    </button>
                                                </h2>
                                                <div id="subject-body-{{ $student->id }}-{{ Str::slug($subject) }}" class="accordion-collapse collapse" data-bs-parent="#subject-accordion-{{ $student->id }}">
                                                    <div class="accordion-body p-0">
                                                        <ul class="list-group list-group-flush">
                                                            @foreach($grades->sortBy('academic_period') as $grade)
                                                                <li class="list-group-item">
                                                                    <div class="d-flex justify-content-between align-items-center">
                                                                        <div>
                                                                            <span class="fw-bold">{{ $grade->academic_period }}</span>
                                                                            <small class="text-muted ms-2">
                                                                                1er: <span class="badge bg-info">{{ $grade->first_partial ?? '-' }}</span> |
                                                                                2do: <span class="badge bg-info">{{ $grade->second_partial ?? '-' }}</span> |
                                                                                Final: <span class="badge bg-success">{{ $grade->final_grade ?? '-' }}</span>
                                                                            </small>
                                                                        </div>
                                                                        <div>
                                                                            @if($grade->status === 'passed')
                                                                                <span class="badge bg-success">Aprobado</span>
                                                                            @elseif($grade->status === 'failed')
                                                                                <span class="badge bg-danger">Reprobado</span>
                                                                            @else
                                                                                <span class="badge bg-warning">Pendiente</span>
                                                                            @endif
                                                                        </div>
                                                                    </div>
                                                                    <div class="d-flex gap-1 mt-2">
                                                                        <a href="{{ route('student-grades.edit', $grade->id) }}" class="btn btn-sm btn-warning flex-grow-1" title="Editar Calificación">
                                                                            <i class="fas fa-edit"></i> Editar
                                                                        </a>
                                                                        <form action="{{ route('student-grades.destroy', $grade->id) }}" method="POST" class="d-inline flex-grow-1" onsubmit="return confirm('¿Estás seguro de que deseas eliminar esta calificación de {{ $grade->subject }}?');">
                                                                            @csrf
                                                                            @method('DELETE')
                                                                            <button type="submit" class="btn btn-sm btn-danger w-100" title="Eliminar">
                                                                                <i class="fas fa-trash"></i> Eliminar
                                                                            </button>
                                                                        </form>
                                                                    </div>
                                                                </li>
                                                            @endforeach
                                                        </ul>
                                                    </div>
                                                </div>
                                            </div>
                                        @endforeach
                                    </div>
                                @else
                                    <div class="card-body text-center text-muted">
                                        <small>
                                            <i class="fas fa-inbox"></i> Sin calificaciones registradas
                                        </small>
                                    </div>
                                @endif
                                <div class="card-footer bg-light">
                                    <a href="{{ route('student-grades.create', ['student_id' => $student->id]) }}" 
                                       class="btn btn-sm btn-primary w-100">
                                        <i class="fas fa-plus"></i> Agregar Calificación
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            @empty
                <div class="col-12">
                    <div class="alert alert-info text-center">
                        <i class="fas fa-info-circle"></i> No hay estudiantes registrados.
                    </div>
                </div>
            @endforelse
        </div>
    </div>

    <style>
        .card {
            transition: transform 0.2s, box-shadow 0.2s;
        }
        .card:hover {
            transform: translateY(-5px);
            box-shadow: 0 8px 16px rgba(0,0,0,0.15) !important;
        }
        .list-group-item {
            border-left: 3px solid #e9ecef;
        }
        .list-group-item:hover {
            background-color: #f8f9fa;
            border-left-color: #0d6efd;
        }
    </style>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const searchInput = document.getElementById('studentSearch');
            const studentCards = document.querySelectorAll('.student-card');

            searchInput.addEventListener('keyup', function(e) {
                const searchTerm = e.target.value.toLowerCase();

                studentCards.forEach(card => {
                    const studentName = card.querySelector('h6').textContent.toLowerCase();
                    
                    if (studentName.includes(searchTerm)) {
                        card.style.display = '';
                    } else {
                        card.style.display = 'none';
                    }
                });
            });
        });
    </script>
@endsection
