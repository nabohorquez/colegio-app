

<?php $__env->startSection('title', 'Administrador de Temas'); ?>

<?php $__env->startSection('content-principal'); ?>
    <div class="container">
        <div class="row">
            <div class="col-12">
                <div class="card mb-3">
                    <div class="card-body">
                        <div class="d-flex justify-content-between align-items-center mb-3">
                            <h3 class="card-title m-0">Administrador de Temas</h3>
                            <span class="badge bg-primary"><?php echo e($topics->count()); ?> temas</span>
                        </div>

                        <?php if(session('success')): ?>
                            <div class="alert alert-success alert-dismissible fade show" role="alert">
                                <?php echo e(session('success')); ?>

                                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                            </div>
                        <?php endif; ?>

                        <!-- Tabla de temas -->
                        <div class="table-responsive mt-3">
                            <table class="table table-hover">
                                <thead>
                                    <tr>
                                        <th style="width:160px">Acciones</th>
                                        <th>Título</th>
                                        <th>Descripción</th>
                                        <th>Creado por</th>
                                        <th>Fecha de creación</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php $__empty_1 = true; $__currentLoopData = $topics; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $topic): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                                        <tr>
                                            <td>
                                            <div class="d-flex gap-1">
                                                <a href="<?php echo e(route('school.topics.show', $topic)); ?>" class="btn btn-sm btn-info" title="Ver">
                                                    <i class="fas fa-eye"></i>
                                                </a>
                                                <a href="<?php echo e(route('school.topics.edit', $topic)); ?>" class="btn btn-sm btn-warning" title="Editar">
                                                    <i class="fas fa-edit"></i>
                                                </a>
                                                <form action="<?php echo e(route('school.topics.destroy', $topic)); ?>" method="POST" class="d-inline">
                                                    <?php echo csrf_field(); ?>
                                                    <?php echo method_field('DELETE'); ?>
                                                    <button type="submit" class="btn btn-sm btn-danger" title="Eliminar" 
                                                            onclick="return confirm('¿Estás seguro de que deseas eliminar este tema?')">
                                                        <i class="fas fa-trash-alt"></i>
                                                    </button>
                                                </form>
                                            </div>
                                            </td>
                                            <td><?php echo e($topic->title); ?></td>
                                            <td><?php echo e(Str::limit($topic->description, 100)); ?></td>
                                            <td><?php echo e($topic->creator->name); ?></td>
                                            <td><?php echo e($topic->created_at->format('d/m/Y H:i')); ?></td>
                                        </tr>
                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                                        <tr>
                                            <td colspan="5" class="text-center text-muted py-4">
                                                <i class="fas fa-book-open fa-2x mb-2"></i>
                                                <p class="mb-0">No hay temas registrados.</p>
                                            </td>
                                        </tr>
                                    <?php endif; ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div>
        <a href="<?php echo e(route('school.topics.create')); ?>" class="btn btn-primary position-fixed rounded-circle" style="bottom: 20px; right: 20px;" title="Adicionar tema">
            <i class="fas fa-plus h1 text-align-center m-0 my-1"></i>
        </a>
    </div>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.app-menu', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\xampp\htdocs\colegio-app\resources\views/school_admin/topics/index.blade.php ENDPATH**/ ?>