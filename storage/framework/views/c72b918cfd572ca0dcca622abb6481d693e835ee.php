

<?php $__env->startSection('title', 'Modules - AcademicSoftware'); ?>

<?php $__env->startSection('content-principal'); ?>
    <div class="container mt-5">
        <?php if($errors->any()): ?>
            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                <ul>
                    <?php $__currentLoopData = $errors->all(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $error): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <li><?php echo e($error); ?></li>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </ul>
            </div>
        <?php endif; ?>

        <form action="<?php echo e(Str::after(Route::currentRouteName(), '.') == 'viewCreate'
                    ? route('modules.create') : route('modules.update', $module->id)); ?>" method="post"
        >
            <?php echo csrf_field(); ?>
            <?php if(Str::after(Route::currentRouteName(), '.') != 'viewCreate'): ?>
                <?php echo method_field('PUT'); ?>
            <?php endif; ?>
            <div class="mb-3">
                <label for="module_name" class="form-label">Nombre del modulo</label>
                <input type="text" class="form-control" id="module_name" name="module_name"
                    value="<?php echo e($module->page_name ?? ''); ?>" required
                >
            </div>
            <div class="mb-3">
                <label for="description" class="form-label">Descripción</label>
                <textarea class="form-control" id="description" name="description"
                    rows="3" required
                ><?php echo e($module->description ?? ''); ?></textarea>
            </div>
            <div class="mb-3">
                <label for="route" class="form-label">Ruta</label>
                <input type="text" class="form-control" id="route" name="route"
                    value="<?php echo e($module->route ?? ''); ?>"
                >
            </div>
            <button type="submit" class="btn btn-primary">Guardar</button>
            <a href="<?php echo e(route('modules.index')); ?>" class="btn btn-warning">Regresar</a>
        </form>
    </div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app-menu', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\laragon\www\Propios\colegio-app\resources\views/modules/form.blade.php ENDPATH**/ ?>