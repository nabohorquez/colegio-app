

<?php $__env->startSection('title', 'Detalle de Calificación - Sistema Escolar'); ?>

<?php $__env->startSection('content-principal'); ?>
<div class="d-flex justify-content-between align-items-center welcome-header">
    <div>
        <h1>
            <i class="fas fa-eye me-2"></i>Detalle de Calificación
        </h1>
        <p class="text-secondary">Información detallada de la calificación</p>
    </div>
    <div class="d-flex gap-2">
        <a href="<?php echo e(route('student-grades.edit', $grade->id)); ?>" class="btn btn-warning">
            <i class="fas fa-edit me-2"></i>Editar
        </a>
        <a href="<?php echo e(route('student-grades.index')); ?>" class="btn btn-secondary">
            <i class="fas fa-arrow-left me-2"></i>Volver
        </a>
    </div>
</div>

<div class="row">
    <!-- Información del Estudiante -->
    <div class="col-md-6 mb-4">
        <div class="section-card">
            <div class="card-header">
                <h5>
                    <i class="fas fa-user me-2"></i>Información del Estudiante
                </h5>
            </div>
            <div class="card-body">
                <div class="mb-3">
                    <label class="form-label text-secondary">Nombre Completo</label>
                    <p class="h6"><?php echo e($grade->student->full_name); ?></p>
                </div>
                <div class="mb-3">
                    <label class="form-label text-secondary">Documento</label>
                    <p class="h6"><?php echo e($grade->student->document ?? 'N/A'); ?></p>
                </div>
                <div class="mb-3">
                    <label class="form-label text-secondary">Grado</label>
                    <p class="h6"><span class="badge bg-primary"><?php echo e($grade->student->grade ?? 'N/A'); ?></span></p>
                </div>
                <div class="mb-3">
                    <label class="form-label text-secondary">Email Institucional</label>
                    <p class="h6"><?php echo e($grade->student->institutional_email); ?></p>
                </div>
            </div>
        </div>
    </div>

    <!-- Información Académica -->
    <div class="col-md-6 mb-4">
        <div class="section-card">
            <div class="card-header">
                <h5>
                    <i class="fas fa-book me-2"></i>Información Académica
                </h5>
            </div>
            <div class="card-body">
                <div class="mb-3">
                    <label class="form-label text-secondary">Asignatura</label>
                    <p class="h6"><?php echo e($grade->subject->nombre_materia ?? 'N/A'); ?></p>
                </div>
                <div class="mb-3">
                    <label class="form-label text-secondary">Nota Parcial 1</label>
                    <?php if($grade->partial_1): ?>
                        <p class="h6"><span class="badge bg-info fs-6 px-3 py-2"><?php echo e(number_format($grade->partial_1, 1)); ?></span></p>
                    <?php else: ?>
                        <p class="h6"><span class="badge bg-secondary">No asignada</span></p>
                    <?php endif; ?>
                </div>
                <div class="mb-3">
                    <label class="form-label text-secondary">Nota Parcial 2</label>
                    <?php if($grade->partial_2): ?>
                        <p class="h6"><span class="badge bg-info fs-6 px-3 py-2"><?php echo e(number_format($grade->partial_2, 1)); ?></span></p>
                    <?php else: ?>
                        <p class="h6"><span class="badge bg-secondary">No asignada</span></p>
                    <?php endif; ?>
                </div>
                <div class="mb-3">
                    <label class="form-label text-secondary">Nota Final</label>
                    <?php if($grade->final_grade): ?>
                        <?php if($grade->final_grade >= 3.0): ?>
                            <p class="h6"><span class="badge bg-success fs-6 px-3 py-2"><?php echo e(number_format($grade->final_grade, 1)); ?></span></p>
                        <?php else: ?>
                            <p class="h6"><span class="badge bg-danger fs-6 px-3 py-2"><?php echo e(number_format($grade->final_grade, 1)); ?></span></p>
                        <?php endif; ?>
                    <?php else: ?>
                        <p class="h6"><span class="badge bg-secondary">No asignada</span></p>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Estado y Observaciones -->
<div class="row">
    <div class="col-md-6 mb-4">
        <div class="section-card">
            <div class="card-header">
                <h5>
                    <i class="fas fa-info-circle me-2"></i>Estado
                </h5>
            </div>
            <div class="card-body">
                <?php
                    $status = $grade->final_grade ? ($grade->final_grade >= 3.0 ? 'APROBADO' : 'REPROBADO') : 'PENDIENTE';
                    $statusClass = $status === 'APROBADO' ? 'bg-success' : ($status === 'REPROBADO' ? 'bg-danger' : 'bg-warning');
                ?>
                <p class="h5"><span class="badge <?php echo e($statusClass); ?> fs-6 px-4 py-3"><?php echo e($status); ?></span></p>
            </div>
        </div>
    </div>

    <div class="col-md-6 mb-4">
        <div class="section-card">
            <div class="card-header">
                <h5>
                    <i class="fas fa-history me-2"></i>Auditoría
                </h5>
            </div>
            <div class="card-body">
                <div class="mb-2">
                    <label class="form-label text-secondary">Creado por</label>
                    <p class="h6"><?php echo e($grade->creator->name ?? 'Sistema'); ?></p>
                </div>
                <div class="mb-2">
                    <label class="form-label text-secondary">Fecha de Creación</label>
                    <p class="h6"><?php echo e($grade->created_at->format('d/m/Y H:i:s')); ?></p>
                </div>
                <div class="mb-2">
                    <label class="form-label text-secondary">Última Actualización</label>
                    <p class="h6"><?php echo e($grade->updated_at->format('d/m/Y H:i:s')); ?></p>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Observaciones -->
<?php if($grade->observations): ?>
    <div class="row">
        <div class="col-12 mb-4">
            <div class="section-card">
                <div class="card-header">
                    <h5>
                        <i class="fas fa-sticky-note me-2"></i>Observaciones
                    </h5>
                </div>
                <div class="card-body">
                    <p><?php echo e($grade->observations); ?></p>
                </div>
            </div>
        </div>
    </div>
<?php endif; ?>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app-menu', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\xampp\htdocs\colegio-app\resources\views/student_grades/show.blade.php ENDPATH**/ ?>