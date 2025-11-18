

<?php $__env->startSection('title', 'Tipo de Matrícula'); ?>

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

        <form action="<?php echo e(isset($enrollment_type) && $enrollment_type
                    ? route('enrollment-types.update', $enrollment_type->id) 
                    : route('enrollment-types.create')); ?>" method="post"
        >
            <?php echo csrf_field(); ?>
            <?php if(isset($enrollment_type) && $enrollment_type): ?>
                <?php echo method_field('PUT'); ?>
            <?php endif; ?>
            
            <div class="mb-3">
                <label for="nombre_tipo" class="form-label">Nombre del Tipo</label>
                <input type="text" class="form-control" id="nombre_tipo" name="nombre_tipo"
                    value="<?php echo e($enrollment_type->nombre_tipo ?? ''); ?>" required
                >
            </div>
            
            <div class="mb-3">
                <label for="descripcion" class="form-label">Descripción</label>
                <textarea class="form-control" id="descripcion" name="descripcion"
                    rows="3"><?php echo e($enrollment_type->descripcion ?? ''); ?></textarea>
            </div>
            
            <div class="mb-3 form-check">
                <input type="hidden" name="estado" value="false">
                <input type="checkbox" class="form-check-input" id="estado" name="estado" value="true"
                    <?php echo e((isset($enrollment_type) && $enrollment_type->estado) ? 'checked' : ''); ?>

                >
                <label class="form-check-label" for="estado">
                    Activo
                </label>
            </div>
            
            <button type="submit" class="btn btn-primary">Guardar</button>
            <a href="<?php echo e(route('enrollment-types.index')); ?>" class="btn btn-warning">Regresar</a>
        </form>
    </div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app-menu', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\xampp\htdocs\colegio-app\resources\views/enrollment_types/form.blade.php ENDPATH**/ ?>