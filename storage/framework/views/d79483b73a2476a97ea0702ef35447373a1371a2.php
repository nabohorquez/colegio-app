

<?php $__env->startSection('title', 'Roles - AcademicSoftware'); ?>

<?php $__env->startSection('content-principal'); ?>
    <div class="container mt-5">
        <h2 class="mb-4">Lista de Roles</h2>
        <table class="table table-bordered" id="rolesTable" style="max-width: 5000px;">
            <thead>
                <tr>
                    <?php if(in_array('edit', $permissions) || in_array('delete', $permissions)): ?>
                        <th>Acciones</th>
                    <?php endif; ?>
                    <th>Nombre</th>
                    <th>Descripción</th>
                </tr>
            </thead>
            <tbody>
                <?php $__currentLoopData = $roles; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $role): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <tr>
                        <?php if(in_array('edit', $permissions) || in_array('delete', $permissions)): ?>
                            <td class="d-flex justify-content-center">
                                <?php if(in_array('edit', $permissions)): ?>
                                    <button
                                        class="btn btn-sm btn-warning me-2"
                                        title="Editar"
                                        data-id="<?php echo e($role->id); ?>"
                                    >
                                        <i class="fas fa-edit"></i>
                                    </button>
                                <?php endif; ?>
                                <?php if(in_array('delete', $permissions)): ?>
                                    <button
                                        class="btn btn-sm btn-danger"
                                        title="Eliminar"
                                        data-id="<?php echo e($role->id); ?>"
                                    >
                                        <i class="fas fa-trash-alt"></i>
                                    </button>
                                <?php endif; ?>
                            </td>
                        <?php endif; ?>
                        <td><?php echo e($role->rol_name); ?></td>
                        <td><?php echo e($role->description); ?></td>
                    </tr>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            </tbody>
        </table>
    </div>

    <div>
        <?php if(in_array('create', $permissions)): ?>
            <button
                class="btn btn-primary position-fixed rounded-circle"
                style="bottom: 20px; right: 20px;"
                type="button"
                title="Adicionar"
            >
                <i class="fas fa-plus h1 text-align-center m-0 my-1"></i>
            </button>
        <?php endif; ?>
    </div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app-menu', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\xampp\htdocs\colegio-app\resources\views/roles/index.blade.php ENDPATH**/ ?>