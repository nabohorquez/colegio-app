@extends('layouts.app-menu')

@section('title', 'Dashboard - Sistema Escolar')

@section('content-principal')
    <div class="welcome-header">
        <h1>¡Bienvenido, {{ Auth::user()->name }}!</h1>
        <p>Gestiona tu institución educativa de forma eficiente</p>
    </div>

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

    <!-- Estadísticas Principales -->
    <div class="row mb-4">
        <div class="col-md-6 col-lg-3 mb-3">
            <div class="stat-card text-primary">
                <div class="icon">
                    <i class="fas fa-users"></i>
                </div>
                <h6>Estudiantes</h6>
                <div class="number">{{ \App\Models\student::count() }}</div>
                <small class="text-muted">Matriculados</small>
            </div>
        </div>

        <div class="col-md-6 col-lg-3 mb-3">
            <div class="stat-card text-success">
                <div class="icon">
                    <i class="fas fa-graduation-cap"></i>
                </div>
                <h6>Grados</h6>
                <div class="number">{{ \App\Models\Grade::count() }}</div>
                <small class="text-muted">Activos</small>
            </div>
        </div>

        <div class="col-md-6 col-lg-3 mb-3">
            <div class="stat-card text-warning">
                <div class="icon">
                    <i class="fas fa-book"></i>
                </div>
                <h6>Materias</h6>
                <div class="number">{{ \App\Models\Subject::count() }}</div>
                <small class="text-muted">Disponibles</small>
            </div>
        </div>

        <div class="col-md-6 col-lg-3 mb-3">
            <div class="stat-card text-info">
                <div class="icon">
                    <i class="fas fa-file-invoice"></i>
                </div>
                <h6>Matrículas</h6>
                <div class="number">{{ \App\Models\Enrollment::count() }}</div>
                <small class="text-muted">Registradas</small>
            </div>
        </div>
    </div>

    <!-- Acciones Rápidas -->
    <div class="row mb-4">
        <div class="col-12">
            <div class="section-card">
                <div class="card-header">
                    <h5>
                        <i class="fas fa-bolt me-2"></i>Acciones Rápidas
                    </h5>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-4 mb-3">
                            <a href="{{ route('enrollments.index') }}" class="btn btn-primary w-100">
                                <i class="fas fa-plus-circle me-2"></i>
                                Matrículas
                            </a>
                        </div>
                        <div class="col-md-4 mb-3">
                            <button type="button" class="btn btn-outline-primary w-100" data-bs-toggle="modal" data-bs-target="#modalNewStudent">
                                <i class="fas fa-user-plus me-2"></i>
                                Nuevo Estudiante
                            </button>
                        </div>
                        <div class="col-md-4 mb-3">
                            <a href="{{ route('grades.index') }}" class="btn btn-outline-primary w-100">
                                <i class="fas fa-list me-2"></i>
                                Ver Grados
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Últimas Matrículas -->
    <div class="row">
        <div class="col-12">
            <div class="section-card">
                <div class="card-header">
                    <h5>
                        <i class="fas fa-clock me-2"></i>Últimas Matrículas
                    </h5>
                </div>
                <div class="card-body">
                    @php
                        $enrollments = \App\Models\Enrollment::with(['student', 'grade', 'enrollmentType'])
                            ->orderBy('created_at', 'desc')
                            ->limit(5)
                            ->get();
                    @endphp

                    @if($enrollments->count() > 0)
                        <div class="table-responsive">
                            <table class="table">
                                <thead>
                                    <tr>
                                        <th>Estudiante</th>
                                        <th>Grado</th>
                                        <th>Tipo Matrícula</th>
                                        <th>Fecha</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($enrollments as $enrollment)
                                        <tr>
                                            <td>
                                                <strong>{{ $enrollment->student->first_name ?? 'N/A' }}</strong>
                                            </td>
                                            <td>{{ $enrollment->grade->nombre_grado ?? 'N/A' }}</td>
                                            <td>
                                                <span class="badge bg-info">
                                                    {{ $enrollment->enrollmentType->nombre_tipo ?? 'N/A' }}
                                                </span>
                                            </td>
                                            <td>{{ $enrollment->created_at->format('d/m/Y') }}</td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    @else
                        <div class="text-center py-5">
                            <i class="fas fa-inbox fa-3x text-muted mb-3" style="display: block;"></i>
                            <p class="text-muted mb-0">No hay matrículas registradas aún</p>
                            <small class="text-muted">¡Comienza creando tu primera matrícula!</small>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>

    <!-- Modal Crear Estudiante -->
    <div class="modal fade" id="modalNewStudent" tabindex="-1">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header border-0">
                    <h5 class="modal-title">Nuevo Estudiante</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <form id="formNewStudent">
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label class="form-label">Nombre</label>
                                <input type="text" id="first_name" class="form-control" required>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label class="form-label">Apellido</label>
                                <input type="text" id="last_name" class="form-control" required>
                            </div>

                            <div class="col-md-6 mb-3">
                                <label class="form-label">Documento</label>
                                <input type="text" id="document" class="form-control">
                            </div>
                            <div class="col-md-6 mb-3">
                                <label class="form-label">Fecha de Nacimiento</label>
                                <input type="date" id="birth_date" class="form-control">
                            </div>

                            <div class="col-md-6 mb-3">
                                <label class="form-label">Grado</label>
                                <select id="grade" class="form-control" required>
                                    <option value="">Seleccione un grado...</option>
                                    @foreach(\App\Models\Grade::where('estado', true)->get() as $grade)
                                        <option value="{{ $grade->nombre_grado }}">{{ $grade->nombre_grado }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label class="form-label">Acudiente</label>
                                <select id="guardian_id" class="form-control">
                                    <option value="">Sin asignar</option>
                                    @foreach(\App\Models\Guardian::all() as $g)
                                        <option value="{{ $g->id }}">{{ $g->full_name }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                    </form>
                </div>
                <div class="modal-footer border-0">
                    <button class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                    <button class="btn btn-primary" id="btnSaveNewStudent">Guardar</button>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script>
        document.addEventListener("DOMContentLoaded", () => {
            const modal = new bootstrap.Modal(document.getElementById('modalNewStudent'));

            document.getElementById('btnSaveNewStudent').addEventListener('click', async () => {
                const payload = {
                    first_name: document.getElementById('first_name').value,
                    last_name: document.getElementById('last_name').value,
                    birth_date: document.getElementById('birth_date').value,
                    document: document.getElementById('document').value,
                    grade: document.getElementById('grade').value,
                    guardian_id: document.getElementById('guardian_id').value,
                };

                const res = await fetch('/students', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
                    },
                    body: JSON.stringify(payload)
                });

                const result = await res.json();
                if (res.ok) {
                    Swal.fire('Éxito', result.message, 'success').then(() => location.reload());
                } else {
                    Swal.fire('Error', result.message || 'Error al guardar', 'error');
                }
            });
        });
    </script>
@endsection
