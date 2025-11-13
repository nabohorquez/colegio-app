

<?php $__env->startSection('title', 'Materias'); ?>

<?php $__env->startSection('content-principal'); ?>
    <div class="container mt-5">
        <h2 class="mb-4">Lista de Materias</h2>
        <?php if(session('success')): ?>
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                <?php echo e(session('success')); ?>

            </div>
        <?php endif; ?>
        <?php if(session('error')): ?>
            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                <?php echo e(session('error')); ?>

            </div>
        <?php endif; ?>
        <table class="table table-bordered" id="subjectsTable">
            <thead>
                <tr>
                    <th>Acciones</th>
                    <th>Nombre</th>
                    <th>Descripción</th>
                    <th>Estado</th>
                </tr>
            </thead>
            <tbody>
                <?php $__currentLoopData = $subjects; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $subject): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <tr>
                        <td class="d-flex justify-content-center">
                            <a href="<?php echo e(route('subjects.getById', $subject->id)); ?>" class="btn btn-sm btn-warning me-2" title="Editar"><i class="fas fa-edit"></i></a>
                            <form action="<?php echo e(route('subjects.delete', $subject->id)); ?>" method="POST" style="display:inline;">
                                <?php echo csrf_field(); ?>
                                <?php echo method_field('DELETE'); ?>
                                <button type="submit" class="btn btn-sm btn-danger" title="Eliminar"
                                        onclick="return confirm('¿Estás seguro de que deseas eliminar esta materia?')">
                                    <i class="fas fa-trash-alt"></i>
                                </button>
                            </form>
                        </td>
                        <td><?php echo e($subject->nombre_materia); ?></td>
                        <td><?php echo e($subject->descripcion); ?></td>
                        <td>
                            <span class="badge <?php echo e($subject->estado ? 'bg-success' : 'bg-danger'); ?>">
                                <?php echo e($subject->estado ? 'Activo' : 'Inactivo'); ?>

                            </span>
                        </td>
                    </tr>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            </tbody>
        </table>
    </div>

    <div>
        <button
            class="btn btn-primary position-fixed rounded-circle"
            style="bottom: 20px; right: 20px;"
            type="button"
            title="Adicionar"
        >
            <a href="<?php echo e(route('subjects.viewCreate')); ?>">
                <i class="fas fa-plus h1 text-align-center m-0 my-1 text-white"></i>
            </a>
        </button>
    </div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app-menu', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\xampp\htdocs\colegio-app\resources\views/subjects/index.blade.php ENDPATH**/ ?>