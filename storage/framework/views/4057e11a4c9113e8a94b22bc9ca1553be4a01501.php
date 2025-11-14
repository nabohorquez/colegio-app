

<?php $__env->startSection('title', 'Matrículas - Sistema Escolar'); ?>

<?php $__env->startSection('content-principal'); ?>
    <div class="d-flex justify-content-between align-items-center welcome-header">
        <div>
            <h1>Matrículas</h1>
            <p>Gestiona las matrículas de estudiantes</p>
        </div>
        <a href="<?php echo e(route('enrollments.viewCreate')); ?>" class="btn btn-primary">
            <i class="fas fa-plus me-2"></i>Nueva Matrícula
        </a>
    </div>

    <?php if(session('success')): ?>
        <div class="alert alert-success alert-dismissible fade show">
            <i class="fas fa-check-circle me-2"></i><?php echo e(session('success')); ?>

            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    <?php endif; ?>

    <?php if(session('error')): ?>
        <div class="alert alert-danger alert-dismissible fade show">
            <i class="fas fa-exclamation-circle me-2"></i><?php echo e(session('error')); ?>

            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    <?php endif; ?>

    <div class="section-card">
        <div class="card-body">
            <?php if($enrollments->count() > 0): ?>
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
                            <?php $__currentLoopData = $enrollments; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $enrollment): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <tr>
                                    <td><strong><?php echo e($enrollment->student->first_name ?? 'N/A'); ?></strong></td>
                                    <td><?php echo e($enrollment->grade->nombre_grado ?? 'N/A'); ?></td>
                                    <td><span class="badge bg-info"><?php echo e($enrollment->enrollmentType->nombre_tipo ?? 'N/A'); ?></span></td>
                                    <td><?php echo e(ucfirst($enrollment->forma_pago)); ?></td>
                                    <td>$<?php echo e(number_format($enrollment->costo ?? 0, 2)); ?></td>
                                    <td>
                                        <?php
                                            $statusBg = match($enrollment->estado_pago ?? 'pendiente') {
                                                'pagado' => 'bg-success',
                                                'parcial' => 'bg-warning',
                                                default => 'bg-danger'
                                            };
                                        ?>
                                        <span class="badge <?php echo e($statusBg); ?>"><?php echo e(ucfirst($enrollment->estado_pago ?? 'pendiente')); ?></span>
                                    </td>
                                    <td><?php echo e($enrollment->fecha ? $enrollment->fecha->format('d/m/Y') : 'N/A'); ?></td>
                                    <td>
                                        <div class="btn-group btn-group-sm">
                                            <a href="<?php echo e(route('enrollments.getById', $enrollment->id)); ?>" class="btn btn-outline-primary" title="Editar">
                                                <i class="fas fa-edit"></i>
                                            </a>
                                            <form action="<?php echo e(route('enrollments.delete', $enrollment->id)); ?>" method="POST" style="display:inline;">
                                                <?php echo csrf_field(); ?>
                                                <?php echo method_field('DELETE'); ?>
                                                <button type="submit" class="btn btn-outline-danger" title="Eliminar" onclick="return confirm('¿Eliminar esta matrícula?')">
                                                    <i class="fas fa-trash"></i>
                                                </button>
                                            </form>
                                        </div>
                                    </td>
                                </tr>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        </tbody>
                    </table>
                </div>
            <?php else: ?>
                <div class="text-center py-5">
                    <i class="fas fa-inbox fa-3x text-muted mb-3" style="display: block;"></i>
                    <p class="text-muted">No hay matrículas registradas</p>
                </div>
            <?php endif; ?>
        </div>
    </div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app-menu', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\xampp\htdocs\colegio-app\resources\views/enrollments/index.blade.php ENDPATH**/ ?>