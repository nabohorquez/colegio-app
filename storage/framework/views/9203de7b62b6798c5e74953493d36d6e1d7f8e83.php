

<?php $__env->startSection('title', 'School Administration'); ?>

<?php $__env->startSection('content-principal'); ?>
<div class="container-fluid mt-4">
    <div class="row mb-4">
        <div class="col-12">
            <h2 class="mb-1">
                <i class="fas fa-building me-2"></i>School Administration
            </h2>
            <p class="text-muted">Welcome to the school administration module. Select an option below to get started.</p>
        </div>
    </div>

    <div class="row g-4">
        <!-- Employees Card -->
        <div class="col-md-6 col-lg-4">
            <div class="card h-100 shadow-sm hover-card">
                <div class="card-body text-center">
                    <i class="fas fa-users fa-3x mb-3" style="color: #28a745;"></i>
                    <h5 class="card-title">Employees</h5>
                    <p class="card-text text-muted">Manage school employees and their information.</p>
                    <a href="<?php echo e(route('employees.index')); ?>" class="btn btn-success btn-sm">
                        <i class="fas fa-arrow-right me-2"></i>Manage
                    </a>
                </div>
            </div>
        </div>

        <!-- Students Card -->
        <div class="col-md-6 col-lg-4">
            <div class="card h-100 shadow-sm hover-card">
                <div class="card-body text-center">
                    <i class="fas fa-graduation-cap fa-3x mb-3" style="color: #ffc107;"></i>
                    <h5 class="card-title">Students</h5>
                    <p class="card-text text-muted">Manage student records and registrations.</p>
                    <a href="<?php echo e(route('students.index')); ?>" class="btn btn-warning btn-sm">
                        <i class="fas fa-arrow-right me-2"></i>Manage
                    </a>
                </div>
            </div>
        </div>

        <!-- Guardians Card -->
        <div class="col-md-6 col-lg-4">
            <div class="card h-100 shadow-sm hover-card">
                <div class="card-body text-center">
                    <i class="fas fa-user-shield fa-3x mb-3" style="color: #17a2b8;"></i>
                    <h5 class="card-title">Guardians</h5>
                    <p class="card-text text-muted">Manage student guardians and their contacts.</p>
                    <a href="<?php echo e(route('guardians.index')); ?>" class="btn btn-info btn-sm">
                        <i class="fas fa-arrow-right me-2"></i>Manage
                    </a>
                </div>
            </div>
        </div>

        <!-- Roles Card -->
        <div class="col-md-6 col-lg-4">
            <div class="card h-100 shadow-sm hover-card">
                <div class="card-body text-center">
                    <i class="fas fa-shield-alt fa-3x mb-3" style="color: #6f42c1;"></i>
                    <h5 class="card-title">Roles</h5>
                    <p class="card-text text-muted">Manage user roles and permissions.</p>
                    <a href="<?php echo e(route('roles.index')); ?>" class="btn btn-purple btn-sm" style="background-color: #6f42c1; border-color: #6f42c1;">
                        <i class="fas fa-arrow-right me-2"></i>Manage
                    </a>
                </div>
            </div>
        </div>

        <!-- Pages Card -->
        <div class="col-md-6 col-lg-4">
            <div class="card h-100 shadow-sm hover-card">
                <div class="card-body text-center">
                    <i class="fas fa-file-alt fa-3x mb-3" style="color: #e74c3c;"></i>
                    <h5 class="card-title">Pages</h5>
                    <p class="card-text text-muted">Manage system pages and access control.</p>
                    <a href="<?php echo e(route('pages.index')); ?>" class="btn btn-danger btn-sm">
                        <i class="fas fa-arrow-right me-2"></i>Manage
                    </a>
                </div>
            </div>
        </div>

        <!-- Enrollment Types Card -->
        <div class="col-md-6 col-lg-4">
            <div class="card h-100 shadow-sm hover-card">
                <div class="card-body text-center">
                    <i class="fas fa-receipt fa-3x mb-3" style="color: #3498db;"></i>
                    <h5 class="card-title">Tipos de Matrículas</h5>
                    <p class="card-text text-muted">Manage enrollment types and categories.</p>
                    <a href="<?php echo e(route('enrollment-types.index')); ?>" class="btn btn-info btn-sm">
                        <i class="fas fa-arrow-right me-2"></i>Manage
                    </a>
                </div>
            </div>
        </div>

        <!-- Enrollments Card -->
        <div class="col-md-6 col-lg-4">
            <div class="card h-100 shadow-sm hover-card">
                <div class="card-body text-center">
                    <i class="fas fa-pen-fancy fa-3x mb-3" style="color: #9b59b6;"></i>
                    <h5 class="card-title">Matrículas</h5>
                    <p class="card-text text-muted">Manage student enrollments and registrations.</p>
                    <a href="<?php echo e(route('enrollments.index')); ?>" class="btn btn-sm" style="background-color: #9b59b6; border-color: #9b59b6; color: white;">
                        <i class="fas fa-arrow-right me-2"></i>Manage
                    </a>
                </div>
            </div>
        </div>

        <!-- Grades Card -->
        <div class="col-md-6 col-lg-4">
            <div class="card h-100 shadow-sm hover-card">
                <div class="card-body text-center">
                    <i class="fas fa-book fa-3x mb-3" style="color: #f39c12;"></i>
                    <h5 class="card-title">Grados</h5>
                    <p class="card-text text-muted">Manage school grades and levels.</p>
                    <a href="<?php echo e(route('grades.index')); ?>" class="btn btn-warning btn-sm">
                        <i class="fas fa-arrow-right me-2"></i>Manage
                    </a>
                </div>
            </div>
        </div>

        <!-- Subjects Card -->
        <div class="col-md-6 col-lg-4">
            <div class="card h-100 shadow-sm hover-card">
                <div class="card-body text-center">
                    <i class="fas fa-chalkboard fa-3x mb-3" style="color: #1abc9c;"></i>
                    <h5 class="card-title">Materias</h5>
                    <p class="card-text text-muted">Manage academic subjects and courses.</p>
                    <a href="<?php echo e(route('subjects.index')); ?>" class="btn btn-sm" style="background-color: #1abc9c; border-color: #1abc9c; color: white;">
                        <i class="fas fa-arrow-right me-2"></i>Manage
                    </a>
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
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.app-menu', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\laragon\www\Propios\colegio-app\resources\views/school_admin/index.blade.php ENDPATH**/ ?>