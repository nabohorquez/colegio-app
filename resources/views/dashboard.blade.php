@extends('layouts.app-menu')

@section('title', 'Roles - AcademicSoftware')

@section('content-principal')
    <div class="main-content p-4">
        <!-- Welcome Section -->
        <div class="row mb-4">
            <div class="col-12">
                <h1 class="h3 text-dark">¡Bienvenido, {{ Auth::user()->name }}!</h1>
                <p class="text-muted">Gestiona tus cuentas de cobro de manera eficiente</p>
            </div>
        </div>
        <div class="row mb-4">
            @if(session('success'))
                <div class="col-12 alert alert-success">{{ session('success') }}</div>
            @endif
            @if(session('error'))
                <div class="col-12 alert alert-danger">{{ session('error') }}</div>
            @endif
        </div>

        <!-- Statistics Cards -->
        <div class="row mb-4">
            <div class="col-md-3 mb-3">
                <div class="card border-0 shadow-sm h-100">
                    <div class="card-body text-center">
                        <div class="text-primary mb-2">
                            <i class="fas fa-file-invoice fa-2x"></i>
                        </div>
                        <h5 class="card-title">Total Cuentas</h5>
                        <h3 class="text-primary">0</h3>
                        <small class="text-muted">Cuentas registradas</small>
                    </div>
                </div>
            </div>

            <div class="col-md-3 mb-3">
                <div class="card border-0 shadow-sm h-100">
                    <div class="card-body text-center">
                        <div class="text-success mb-2">
                            <i class="fas fa-check-circle fa-2x"></i>
                        </div>
                        <h5 class="card-title">Pagadas</h5>
                        <h3 class="text-success">0</h3>
                        <small class="text-muted">Cuentas pagadas</small>
                    </div>
                </div>
            </div>

            <div class="col-md-3 mb-3">
                <div class="card border-0 shadow-sm h-100">
                    <div class="card-body text-center">
                        <div class="text-warning mb-2">
                            <i class="fas fa-clock fa-2x"></i>
                        </div>
                        <h5 class="card-title">Pendientes</h5>
                        <h3 class="text-warning">0</h3>
                        <small class="text-muted">Por cobrar</small>
                    </div>
                </div>
            </div>

            <div class="col-md-3 mb-3">
                <div class="card border-0 shadow-sm h-100">
                    <div class="card-body text-center">
                        <div class="text-info mb-2">
                            <i class="fas fa-dollar-sign fa-2x"></i>
                        </div>
                        <h5 class="card-title">Total Facturado</h5>
                        <h3 class="text-info">$0</h3>
                        <small class="text-muted">Este mes</small>
                    </div>
                </div>
            </div>
        </div>

        <!-- Quick Actions -->
        <div class="row mb-4">
            <div class="col-12">
                <div class="card border-0 shadow-sm">
                    <div class="card-header bg-white">
                        <h5 class="card-title mb-0">
                            <i class="fas fa-rocket me-2"></i>Acciones Rápidas
                        </h5>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-4 mb-3">
                                <a href="#" class="btn btn-primary btn-lg w-100">
                                    <i class="fas fa-plus-circle me-2"></i>
                                    Nueva Cuenta de Cobro
                                </a>
                            </div>
                            <div class="col-md-4 mb-3">
                                <a href="#" class="btn btn-outline-primary btn-lg w-100">
                                    <i class="fas fa-user-plus me-2"></i>
                                    Agregar Cliente
                                </a>
                            </div>
                            <div class="col-md-4 mb-3">
                                <a href="#" class="btn btn-outline-primary btn-lg w-100">
                                    <i class="fas fa-chart-line me-2"></i>
                                    Ver Reportes
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Recent Activity -->
        <div class="row">
            <div class="col-12">
                <div class="card border-0 shadow-sm">
                    <div class="card-header bg-white">
                        <h5 class="card-title mb-0">
                            <i class="fas fa-history me-2"></i>Actividad Reciente
                        </h5>
                    </div>
                    <div class="card-body">
                        <div class="text-center py-4">
                            <i class="fas fa-inbox fa-3x text-muted mb-3"></i>
                            <p class="text-muted">No hay actividad reciente para mostrar.</p>
                            <p class="text-muted">¡Comienza creando tu primera cuenta de cobro!</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
