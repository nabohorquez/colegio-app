

<?php $__env->startSection('title', 'Materia'); ?>

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

        <form action="<?php echo e(isset($subject) && $subject
                    ? route('subjects.update', $subject->id) 
                    : route('subjects.create')); ?>" method="post"
        >
            <?php echo csrf_field(); ?>
            <?php if(isset($subject) && $subject): ?>
                <?php echo method_field('PUT'); ?>
            <?php endif; ?>
            
            <div class="mb-3">
                <label for="nombre_materia" class="form-label">Nombre de la Materia</label>
                <input type="text" class="form-control" id="nombre_materia" name="nombre_materia"
                    value="<?php echo e($subject->nombre_materia ?? ''); ?>" required
                >
            </div>
            
            <div class="mb-3">
                <label for="descripcion" class="form-label">Descripción</label>
                <textarea class="form-control" id="descripcion" name="descripcion"
                    rows="3"><?php echo e($subject->descripcion ?? ''); ?></textarea>
            </div>
            
            <div class="mb-3 form-check">
                <input type="checkbox" class="form-check-input" id="estado" name="estado" 
                    <?php echo e((isset($subject) && !$subject->estado) ? '' : 'checked'); ?>

                >
                <label class="form-check-label" for="estado">
                    Activo
                </label>
            </div>
            
            <button type="submit" class="btn btn-primary">Guardar</button>
            <a href="<?php echo e(route('subjects.index')); ?>" class="btn btn-warning">Regresar</a>
        </form>
    </div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app-menu', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\xampp\htdocs\colegio-app\resources\views/subjects/form.blade.php ENDPATH**/ ?>