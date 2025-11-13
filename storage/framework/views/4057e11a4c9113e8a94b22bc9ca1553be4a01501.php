

<?php $__env->startSection('title', 'Matrículas'); ?>

<?php $__env->startSection('content-principal'); ?>
    <div class="container mt-5">
        <h2 class="mb-4">Lista de Matrículas</h2>
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
        <table class="table table-bordered" id="enrollmentsTable" style="max-width: 100%; overflow-x: auto;">
            <thead>
                <tr>
                    <th>Acciones</th>
                    <th>Estudiante</th>
                    <th>Grado</th>
                    <th>Tipo de Matrícula</th>
                    <th>Forma de Pago</th>
                    <th>Fecha</th>
                    <th>Estado</th>
                </tr>
            </thead>
            <tbody>
                <?php $__currentLoopData = $enrollments; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $enrollment): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <tr>
                        <td class="d-flex justify-content-center">
                            <a href="<?php echo e(route('enrollments.getById', $enrollment->id)); ?>" class="btn btn-sm btn-warning me-2" title="Editar"><i class="fas fa-edit"></i></a>
                            <form action="<?php echo e(route('enrollments.delete', $enrollment->id)); ?>" method="POST" style="display:inline;">
                                <?php echo csrf_field(); ?>
                                <?php echo method_field('DELETE'); ?>
                                <button type="submit" class="btn btn-sm btn-danger" title="Eliminar"
                                        onclick="return confirm('¿Estás seguro de que deseas eliminar esta matrícula?')">
                                    <i class="fas fa-trash-alt"></i>
                                </button>
                            </form>
                        </td>
                        <td><?php echo e($enrollment->student ? $enrollment->student->full_name : 'N/A'); ?></td>
                        <td><?php echo e($enrollment->grade ? $enrollment->grade->nombre_grado : 'N/A'); ?></td>
                        <td><?php echo e($enrollment->enrollmentType ? $enrollment->enrollmentType->nombre_tipo : 'N/A'); ?></td>
                        <td><?php echo e($enrollment->forma_pago); ?></td>
                        <td><?php echo e($enrollment->fecha->format('d/m/Y')); ?></td>
                        <td>
                            <span class="badge <?php echo e($enrollment->estado ? 'bg-success' : 'bg-danger'); ?>">
                                <?php echo e($enrollment->estado ? 'Activo' : 'Inactivo'); ?>

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
            <a href="<?php echo e(route('enrollments.viewCreate')); ?>">
                <i class="fas fa-plus h1 text-align-center m-0 my-1 text-white"></i>
            </a>
        </button>
    </div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app-menu', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\xampp\htdocs\colegio-app\resources\views/enrollments/index.blade.php ENDPATH**/ ?>