

<?php $__env->startSection('title', 'Paginas - AcademicSoftware'); ?>

<?php $__env->startSection('content-principal'); ?>
    <div class="container mt-5">
        <h2 class="mb-4">Lista de Paginas</h2>
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
        <table class="table table-bordered" id="modulesTable" style="max-width: 5000px;">
            <thead>
                <tr>
                    <?php if(in_array('edit', $permissions) || in_array('delete', $permissions)): ?>
                        <th>Acciones</th>
                    <?php endif; ?>
                    <th>Modulo</th>
                    <th>Nombre</th>
                    <th>Descripción</th>
                    <th>Ruta</th>
                </tr>
            </thead>
            <tbody>
                <?php $__currentLoopData = $pagesTable; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $page): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <tr>
                        <?php if(in_array('edit', $permissions) || in_array('delete', $permissions)): ?>
                            <td class="d-flex justify-content-center">
                                <?php if(in_array('edit', $permissions)): ?>
                                    <a href="<?php echo e(route('pages.getById', $page->id)); ?>" class="btn btn-sm btn-warning me-2" title="Editar"><i class="fas fa-edit"></i></a>
                                <?php endif; ?>
                                <?php if(in_array('delete', $permissions)): ?>
                                    <form action="<?php echo e(route('pages.delete', $page->id)); ?>" method="POST" style="display:inline;">
                                        <?php echo csrf_field(); ?>
                                        <?php echo method_field('DELETE'); ?>
                                        <button type="submit" class="btn btn-sm btn-danger" title="Eliminar"
                                                onclick="return confirm('¿Estás seguro de que deseas eliminar este módulo?')">
                                            <i class="fas fa-trash-alt"></i>
                                        </button>
                                    </form>
                                <?php endif; ?>
                            </td>
                        <?php endif; ?>
                        <td><?php echo e($page->module_name); ?></td>
                        <td><?php echo e($page->page_name); ?></td>
                        <td><?php echo e($page->description); ?></td>
                        <td><?php echo e($page->route); ?></td>
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
                <a href="<?php echo e(route('pages.viewCreate')); ?>">
                    <i class="fas fa-plus h1 text-align-center m-0 my-1 text-white"></i>
                </a>
            </button>
        <?php endif; ?>
    </div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app-menu', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\xampp\htdocs\colegio-app\resources\views/pages/index.blade.php ENDPATH**/ ?>