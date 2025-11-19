@extends('layouts.app-menu')

@section('title', 'Administración del Colegio')

@section('content-principal')
<div class="container-fluid mt-4">
    <div class="row mb-4">
        <div class="col-12">
            <h2 class="mb-1">
                <i class="fas fa-building me-2"></i>Administración del Colegio
            </h2>
            <p class="text-muted">Bienvenido al módulo de administración escolar. Selecciona una opción a continuación para comenzar.</p>
        </div>
    </div>

    <!-- Sección 1: Gestión de Usuarios -->
    <div class="mb-5">
        <h4 class="mb-3">
            <i class="fas fa-users me-2"></i>Gestión de Usuarios
        </h4>
        <div class="row g-4">
            <!-- Tarjeta Empleados -->
            <div class="col-md-6 col-lg-4">
                <div class="card h-100 shadow-sm hover-card">
                    <div class="card-body text-center">
                        <i class="fas fa-user-tie fa-3x mb-3" style="color: #28a745;"></i>
                        <h5 class="card-title">Empleados</h5>
                        <p class="card-text text-muted">Gestiona empleados del colegio.</p>
                        <a href="{{ route('employees.index') }}" class="btn btn-success btn-sm">
                            <i class="fas fa-arrow-right me-2"></i>Gestionar
                        </a>
                    </div>
                </div>
            </div>

            <!-- Tarjeta Estudiantes -->
            <div class="col-md-6 col-lg-4">
                <div class="card h-100 shadow-sm hover-card">
                    <div class="card-body text-center">
                        <i class="fas fa-graduation-cap fa-3x mb-3" style="color: #ffc107;"></i>
                        <h5 class="card-title">Estudiantes</h5>
                        <p class="card-text text-muted">Gestiona registros de estudiantes.</p>
                        <a href="{{ route('students.index') }}" class="btn btn-warning btn-sm">
                            <i class="fas fa-arrow-right me-2"></i>Gestionar
                        </a>
                    </div>
                </div>
            </div>

            <!-- Tarjeta Acudientes -->
            <div class="col-md-6 col-lg-4">
                <div class="card h-100 shadow-sm hover-card">
                    <div class="card-body text-center">
                        <i class="fas fa-user-shield fa-3x mb-3" style="color: #17a2b8;"></i>
                        <h5 class="card-title">Acudientes</h5>
                        <p class="card-text text-muted">Gestiona acudientes y contactos.</p>
                        <a href="{{ route('guardians.index') }}" class="btn btn-info btn-sm">
                            <i class="fas fa-arrow-right me-2"></i>Gestionar
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Sección 2: Administración Académica -->
    <div class="mb-5">
        <h4 class="mb-3">
            <i class="fas fa-book me-2"></i>Administración Académica
        </h4>
        <div class="row g-4">
            <!-- Tarjeta Tipos de Matrículas -->
            <div class="col-md-6 col-lg-4">
                <div class="card h-100 shadow-sm hover-card">
                    <div class="card-body text-center">
                        <i class="fas fa-receipt fa-3x mb-3" style="color: #3498db;"></i>
                        <h5 class="card-title">Tipos de Matrículas</h5>
                        <p class="card-text text-muted">Gestiona tipos de matrículas y categorías.</p>
                        <a href="{{ route('enrollment-types.index') }}" class="btn btn-info btn-sm">
                            <i class="fas fa-arrow-right me-2"></i>Gestionar
                        </a>
                    </div>
                </div>
            </div>

            <!-- Tarjeta Matrículas -->
            <div class="col-md-6 col-lg-4">
                <div class="card h-100 shadow-sm hover-card">
                    <div class="card-body text-center">
                        <i class="fas fa-pen-fancy fa-3x mb-3" style="color: #9b59b6;"></i>
                        <h5 class="card-title">Matrículas</h5>
                        <p class="card-text text-muted">Gestiona matrículas de estudiantes.</p>
                        <a href="{{ route('enrollments.index') }}" class="btn btn-sm" style="background-color: #9b59b6; border-color: #9b59b6; color: white;">
                            <i class="fas fa-arrow-right me-2"></i>Gestionar
                        </a>
                    </div>
                </div>
            </div>

            <!-- Tarjeta Grados -->
            <div class="col-md-6 col-lg-4">
                <div class="card h-100 shadow-sm hover-card">
                    <div class="card-body text-center">
                        <i class="fas fa-book fa-3x mb-3" style="color: #f39c12;"></i>
                        <h5 class="card-title">Grados</h5>
                        <p class="card-text text-muted">Gestiona niveles educativos.</p>
                        <a href="{{ route('grades.index') }}" class="btn btn-warning btn-sm">
                            <i class="fas fa-arrow-right me-2"></i>Gestionar
                        </a>
                    </div>
                </div>
            </div>

            <!-- Tarjeta Materias -->
            <div class="col-md-6 col-lg-4">
                <div class="card h-100 shadow-sm hover-card">
                    <div class="card-body text-center">
                        <i class="fas fa-chalkboard fa-3x mb-3" style="color: #1abc9c;"></i>
                        <h5 class="card-title">Materias</h5>
                        <p class="card-text text-muted">Gestiona asignaturas y cursos.</p>
                        <a href="{{ route('subjects.index') }}" class="btn btn-sm" style="background-color: #1abc9c; border-color: #1abc9c; color: white;">
                            <i class="fas fa-arrow-right me-2"></i>Gestionar
                        </a>
                    </div>
                </div>
            </div>

            <!-- Tarjeta Contenidos -->
            <div class="col-md-6 col-lg-4">
                <div class="card h-100 shadow-sm hover-card">
                    <div class="card-body text-center">
                        <i class="fas fa-file-alt fa-3x mb-3" style="color: #2ecc71;"></i>
                        <h5 class="card-title">Contenidos</h5>
                        <p class="card-text text-muted">Gestiona temas y contenidos académicos.</p>
                        <a href="{{ route('topics.index') }}" class="btn btn-sm" style="background-color: #2ecc71; border-color: #2ecc71; color: white;">
                            <i class="fas fa-arrow-right me-2"></i>Gestionar
                        </a>
                    </div>
                </div>
            </div>

            <!-- Tarjeta Actividades -->
            <div class="col-md-6 col-lg-4">
                <div class="card h-100 shadow-sm hover-card">
                    <div class="card-body text-center">
                        <i class="fas fa-tasks fa-3x mb-3" style="color: #e74c3c;"></i>
                        <h5 class="card-title">Actividades</h5>
                        <p class="card-text text-muted">Gestiona actividades y tareas académicas.</p>
                        <a href="{{ route('activities.index') }}" class="btn btn-danger btn-sm">
                            <i class="fas fa-arrow-right me-2"></i>Gestionar
                        </a>
                    </div>
                </div>
            </div>

            <!-- Tarjeta Calificaciones -->
            <div class="col-md-6 col-lg-4">
                <div class="card h-100 shadow-sm hover-card">
                    <div class="card-body text-center">
                        <i class="fas fa-star fa-3x mb-3" style="color: #f1c40f;"></i>
                        <h5 class="card-title">Calificaciones</h5>
                        <p class="card-text text-muted">Asigna notas por estudiante y materia.</p>
                        <a href="{{ route('student-grades.index') }}" class="btn btn-sm" style="background-color: #f1c40f; border-color: #f1c40f; color: #333;">
                            <i class="fas fa-arrow-right me-2"></i>Gestionar
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Sección 3: Configuración del Sistema -->
    <div class="mb-5">
        <h4 class="mb-3">
            <i class="fas fa-cog me-2"></i>Configuración del Sistema
        </h4>
        <div class="row g-4">
            <!-- Tarjeta Roles -->
            <div class="col-md-6 col-lg-4">
                <div class="card h-100 shadow-sm hover-card">
                    <div class="card-body text-center">
                        <i class="fas fa-shield-alt fa-3x mb-3" style="color: #6f42c1;"></i>
                        <h5 class="card-title">Roles</h5>
                        <p class="card-text text-muted">Gestiona roles y permisos del sistema.</p>
                        <a href="{{ route('roles.index') }}" class="btn btn-purple btn-sm" style="background-color: #6f42c1; border-color: #6f42c1;">
                            <i class="fas fa-arrow-right me-2"></i>Gestionar
                        </a>
                    </div>
                </div>
            </div>

            <!-- Tarjeta Páginas -->
            <div class="col-md-6 col-lg-4">
                <div class="card h-100 shadow-sm hover-card">
                    <div class="card-body text-center">
                        <i class="fas fa-sitemap fa-3x mb-3" style="color: #e74c3c;"></i>
                        <h5 class="card-title">Páginas</h5>
                        <p class="card-text text-muted">Gestiona páginas y estructura.</p>
                        <a href="{{ route('pages.index') }}" class="btn btn-danger btn-sm">
                            <i class="fas fa-arrow-right me-2"></i>Gestionar
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
    .hover-card {
        transition: transform 0.3s ease, box-shadow 0.3s ease;
    }

    .hover-card:hover {
        transform: translateY(-5px);
        box-shadow: 0 0.5rem 1rem rgba(0, 0, 0, 0.15) !important;
    }

    .btn-purple {
        background-color: #6f42c1;
        border-color: #6f42c1;
        color: white;
    }

    .btn-purple:hover {
        background-color: #5a32a3;
        border-color: #5a32a3;
    }
</style>
@endsection