

<?php $__env->startSection('title', 'Grados - Sistema Escolar'); ?>

<?php $__env->startSection('content-principal'); ?>
    <div class="d-flex justify-content-between align-items-center welcome-header">
        <div>
            <h1>Grados</h1>
            <p>Gestiona los grados disponibles</p>
        </div>
        <a href="<?php echo e(route('grades.viewCreate')); ?>" class="btn btn-primary">
            <i class="fas fa-plus me-2"></i>Nuevo Grado
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
            <?php if($grades->count() > 0): ?>
                <div class="table-responsive">
                    <table class="table">
                        <thead>
                            <tr>
                                <th>Nombre</th>
                                <th>Nivel</th>
                                <th>Estado</th>
                                <th>Acciones</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php $__currentLoopData = $grades; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $grade): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <tr>
                                    <td><strong><?php echo e($grade->nombre_grado); ?></strong></td>
                                    <td><?php echo e($grade->nivel); ?></td>
                                    <td>
                                        <span class="badge <?php echo e($grade->estado ? 'bg-success' : 'bg-secondary'); ?>">
                                            <?php echo e($grade->estado ? 'Activo' : 'Inactivo'); ?>

                                        </span>
                                    </td>
                                    <td>
                                        <div class="btn-group btn-group-sm">
                                            <a href="<?php echo e(route('grades.getById', $grade->id)); ?>" class="btn btn-outline-primary" title="Editar">
                                                <i class="fas fa-edit"></i>
                                            </a>
                                            <form action="<?php echo e(route('grades.delete', $grade->id)); ?>" method="POST" style="display:inline;">
                                                <?php echo csrf_field(); ?>
                                                <?php echo method_field('DELETE'); ?>
                                                <button type="submit" class="btn btn-outline-danger" title="Eliminar" onclick="return confirm('¿Eliminar este grado?')">
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
                    <p class="text-muted">No hay grados registrados</p>
                </div>
            <?php endif; ?>
        </div>
    </div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app-menu', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\xampp\htdocs\colegio-app\resources\views/grades/index.blade.php ENDPATH**/ ?>