

<?php $__env->startSection('title', 'Grado'); ?>

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

        <form action="<?php echo e(isset($grade) && $grade
                    ? route('grades.update', $grade->id) 
                    : route('grades.create')); ?>" method="post"
        >
            <?php echo csrf_field(); ?>
            <?php if(isset($grade) && $grade): ?>
                <?php echo method_field('PUT'); ?>
            <?php endif; ?>
            
            <div class="mb-3">
                <label for="nombre_grado" class="form-label">Nombre del Grado</label>
                <input type="text" class="form-control" id="nombre_grado" name="nombre_grado"
                    value="<?php echo e($grade->nombre_grado ?? ''); ?>" required
                >
            </div>
            
            <div class="mb-3">
                <label for="nivel" class="form-label">Nivel</label>
                <input type="text" class="form-control" id="nivel" name="nivel"
                    value="<?php echo e($grade->nivel ?? ''); ?>" required
                >
            </div>
            
            <div class="mb-3 form-check">
                <input type="checkbox" class="form-check-input" id="estado" name="estado" 
                    <?php echo e((isset($grade) && !$grade->estado) ? '' : 'checked'); ?>

                >
                <label class="form-check-label" for="estado">
                    Activo
                </label>
            </div>
            
            <button type="submit" class="btn btn-primary">Guardar</button>
            <a href="<?php echo e(route('grades.index')); ?>" class="btn btn-warning">Regresar</a>
        </form>
    </div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app-menu', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\xampp\htdocs\colegio-app\resources\views/grades/form.blade.php ENDPATH**/ ?>