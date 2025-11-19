

<?php $__env->startSection('title', 'Gestión de Actividades'); ?>

<?php $__env->startSection('content-principal'); ?>
    <div class="container-fluid">
        <div class="row mb-4">
            <div class="col-12">
                <div class="d-flex justify-content-between align-items-center">
                    <h3 class="mb-0">Actividades Escolares</h3>
                    <a href="<?php echo e(route('activities.create')); ?>" class="btn btn-primary">
                        <i class="fas fa-plus"></i> Crear Nueva Actividad
                    </a>
                </div>
            </div>
        </div>

    <?php if($message = Session::get('success')): ?>
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                <strong>Éxito:</strong> <?php echo e($message); ?>

                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        <?php endif; ?>

        <div class="card">
            <div class="card-body">
                <?php if($activities->count() > 0): ?>
                    <div class="table-responsive">
                        <table class="table table-hover table-sm">
                            <thead class="table-light">
                                <tr>
                                    <th>Título</th>
                                    <th>Descripción</th>
                                    <th>Recursos</th>
                                    <th>Ejemplos</th>
                                    <th>Creado por</th>
                                    <th>Fecha</th>
                                    <th>Acciones</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php $__currentLoopData = $activities; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $activity): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <tr>
                                    <td><strong><?php echo e($activity->title); ?></strong></td>
                                    <td><?php echo e(Str::limit($activity->description, 40)); ?></td>
                                    <td>
                                        <?php if($activity->resource_assignment): ?>
                                            <small class="badge bg-info">Sí</small>
                                        <?php else: ?>
                                            <small class="badge bg-secondary">No</small>
                                        <?php endif; ?>
                                    </td>
                                    <td>
                                        <?php if($activity->example_assignment): ?>
                                            <small class="badge bg-info">Sí</small>
                                        <?php else: ?>
                                            <small class="badge bg-secondary">No</small>
                                        <?php endif; ?>
                                    </td>
                                    <td><?php echo e($activity->creator->first_name ?? ""); ?> <?php echo e($activity->creator->last_name ?? ""); ?></td>
                                    <td><?php echo e($activity->created_at->format("d/m/Y")); ?></td>
                                    <td>
                                        <a href="<?php echo e(route('activities.edit', $activity->id)); ?>" class="btn btn-sm btn-warning" title="Editar">
                                            <i class="fas fa-edit"></i>
                                        </a>
                                        <form action="<?php echo e(route('activities.destroy', $activity->id)); ?>" method="POST" class="d-inline" onsubmit="return confirm('¿Estás seguro de que deseas eliminar esta actividad?');">
                                            <?php echo csrf_field(); ?>
                                            <?php echo method_field('DELETE'); ?>
                                            <button type="submit" class="btn btn-sm btn-danger" title="Eliminar">
                                                <i class="fas fa-trash"></i>
                                            </button>
                                        </form>
                                    </td>
                                </tr>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            </tbody>
                        </table>
                    </div>
                    <div class="mt-3">
                        <?php echo e($activities->links()); ?>

                    </div>
                <?php else: ?>
                    <div class="alert alert-info">
                        No hay actividades registradas. <a href="<?php echo e(route('activities.create')); ?>">Crear una nueva</a>
                    </div>
                <?php endif; ?>
            </div>
        </div>
    </div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app-menu', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\Users\USER\OneDrive\Universidad\U Cundinamarca\Semestre 6\Ing. Software II\Colegio - Principal\colegio-app\resources\views/school_admin/activities/index.blade.php ENDPATH**/ ?>