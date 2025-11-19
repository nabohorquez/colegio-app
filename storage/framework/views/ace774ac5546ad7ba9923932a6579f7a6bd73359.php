

<?php $__env->startSection('title', '<?php echo e(isset($subject) ? "Editar" : "Crear"); ?> Materia - Sistema Escolar'); ?>

<?php $__env->startSection('content-principal'); ?>
    <div class="welcome-header">
        <h1><?php echo e(isset($subject) ? 'Editar' : 'Crear'); ?> Materia</h1>
        <p><?php echo e(isset($subject) ? 'Modifica los datos de la materia' : 'Agrega una nueva materia al sistema'); ?></p>
    </div>

    <?php if($errors->any()): ?>
        <div class="alert alert-danger alert-dismissible fade show">
            <strong>Errores de validación:</strong>
            <ul class="mb-0 mt-2">
                <?php $__currentLoopData = $errors->all(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $error): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <li><?php echo e($error); ?></li>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            </ul>
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    <?php endif; ?>

    <div class="section-card">
        <div class="card-body">
            <form action="<?php echo e(isset($subject) && $subject
                        ? route('subjects.update', $subject->id) 
                        : route('subjects.create')); ?>" method="post"
            >
                <?php echo csrf_field(); ?>
                <?php if(isset($subject) && $subject): ?>
                    <?php echo method_field('PUT'); ?>
                <?php endif; ?>
                
                <div class="mb-4">
                    <label for="nombre_materia" class="form-label">Nombre de la Materia</label>
                    <input type="text" class="form-control <?php $__errorArgs = ['nombre_materia'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" 
                        id="nombre_materia" name="nombre_materia"
                        value="<?php echo e($subject->nombre_materia ?? old('nombre_materia')); ?>" 
                        placeholder="Ej: Matemáticas"
                        required
                    >
                    <?php $__errorArgs = ['nombre_materia'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                        <div class="invalid-feedback d-block"><?php echo e($message); ?></div>
                    <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                </div>
                
                <div class="mb-4">
                    <label for="descripcion" class="form-label">Descripción</label>
                    <textarea class="form-control <?php $__errorArgs = ['descripcion'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" 
                        id="descripcion" name="descripcion"
                        rows="4"
                        placeholder="Describe brevemente el contenido de esta materia"
                    ><?php echo e($subject->descripcion ?? old('descripcion')); ?></textarea>
                    <?php $__errorArgs = ['descripcion'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                        <div class="invalid-feedback d-block"><?php echo e($message); ?></div>
                    <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                </div>
                
                <div class="mb-4">
                    <div class="form-check">
                        <input type="hidden" name="estado" value="false">
                        <input type="checkbox" class="form-check-input" id="estado" name="estado" value="true"
                            <?php echo e((isset($subject) && $subject->estado) ? 'checked' : ''); ?>

                        >
                        <label class="form-check-label" for="estado">
                            <strong>Materia Activa</strong>
                            <small class="text-muted d-block">Las materias inactivas no aparecerán en listados</small>
                        </label>
                    </div>
                </div>
                
                <div class="d-flex gap-2">
                    <button type="submit" class="btn btn-primary">
                        <i class="fas fa-save me-2"></i>Guardar
                    </button>
                    <a href="<?php echo e(route('subjects.index')); ?>" class="btn btn-outline-secondary">
                        <i class="fas fa-arrow-left me-2"></i>Regresar
                    </a>
                </div>
            </form>
        </div>
    </div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app-menu', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\xampp\htdocs\colegio-app\resources\views/subjects/form.blade.php ENDPATH**/ ?>