

<?php $__env->startSection('title', 'Matrícula'); ?>

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

        <form action="<?php echo e(isset($enrollment) && $enrollment
                    ? route('enrollments.update', $enrollment->id) 
                    : route('enrollments.create')); ?>" method="post"
        >
            <?php echo csrf_field(); ?>
            <?php if(isset($enrollment) && $enrollment): ?>
                <?php echo method_field('PUT'); ?>
            <?php endif; ?>
            
            <div class="mb-3">
                <label for="estudiante_id" class="form-label">Estudiante</label>
                <select class="form-control" id="estudiante_id" name="estudiante_id" required>
                    <option value="">Seleccionar estudiante...</option>
                    <?php $__currentLoopData = $students; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $student): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <option value="<?php echo e($student->id); ?>" 
                            <?php echo e((isset($enrollment) && $enrollment->estudiante_id == $student->id) ? 'selected' : ''); ?>>
                            <?php echo e($student->full_name); ?>

                        </option>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </select>
            </div>
            
            <div class="mb-3">
                <label for="grado_id" class="form-label">Grado</label>
                <select class="form-control" id="grado_id" name="grado_id" required>
                    <option value="">Seleccionar grado...</option>
                    <?php $__currentLoopData = $grades; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $grade): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <option value="<?php echo e($grade->id); ?>" 
                            <?php echo e((isset($enrollment) && $enrollment->grado_id == $grade->id) ? 'selected' : ''); ?>>
                            <?php echo e($grade->nombre_grado); ?>

                        </option>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </select>
            </div>
            
            <div class="mb-3">
                <label for="tipo_matricula_id" class="form-label">Tipo de Matrícula</label>
                <select class="form-control" id="tipo_matricula_id" name="tipo_matricula_id" required>
                    <option value="">Seleccionar tipo...</option>
                    <?php $__currentLoopData = $enrollmentTypes; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $type): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <option value="<?php echo e($type->id); ?>" 
                            <?php echo e((isset($enrollment) && $enrollment->tipo_matricula_id == $type->id) ? 'selected' : ''); ?>>
                            <?php echo e($type->nombre_tipo); ?>

                        </option>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </select>
            </div>
            
            <div class="mb-3">
                <label for="forma_pago" class="form-label">Forma de Pago</label>
                <select class="form-control" id="forma_pago" name="forma_pago" required>
                    <option value="">Seleccionar forma de pago...</option>
                    <option value="efectivo" <?php echo e((isset($enrollment) && $enrollment->forma_pago == 'efectivo') ? 'selected' : ''); ?>>Efectivo</option>
                    <option value="cheque" <?php echo e((isset($enrollment) && $enrollment->forma_pago == 'cheque') ? 'selected' : ''); ?>>Cheque</option>
                    <option value="transferencia" <?php echo e((isset($enrollment) && $enrollment->forma_pago == 'transferencia') ? 'selected' : ''); ?>>Transferencia</option>
                    <option value="tarjeta de crédito" <?php echo e((isset($enrollment) && $enrollment->forma_pago == 'tarjeta de crédito') ? 'selected' : ''); ?>>Tarjeta de Crédito</option>
                </select>
            </div>
            
            <div class="mb-3">
                <label for="costo" class="form-label">Costo de Matrícula</label>
                <input type="number" step="0.01" class="form-control" id="costo" name="costo"
                    value="<?php echo e($enrollment->costo ?? '500000'); ?>"
                >
            </div>
            
            <div class="mb-3">
                <label for="estado_pago" class="form-label">Estado de Pago</label>
                <select class="form-control" id="estado_pago" name="estado_pago" required>
                    <option value="pendiente" <?php echo e((isset($enrollment) && $enrollment->estado_pago == 'pendiente') ? 'selected' : ''); ?>>Pendiente</option>
                    <option value="parcial" <?php echo e((isset($enrollment) && $enrollment->estado_pago == 'parcial') ? 'selected' : ''); ?>>Parcial</option>
                    <option value="pagado" <?php echo e((isset($enrollment) && $enrollment->estado_pago == 'pagado') ? 'selected' : ''); ?>>Pagado</option>
                </select>
            </div>
            
            <div class="mb-3">
                <label for="fecha" class="form-label">Fecha</label>
                <input type="date" class="form-control" id="fecha" name="fecha"
                    value="<?php echo e(isset($enrollment) && $enrollment->fecha ? $enrollment->fecha->format('Y-m-d') : now()->format('Y-m-d')); ?>" required
                >
            </div>
            
            <div class="mb-3 form-check">
                <input type="checkbox" class="form-check-input" id="estado" name="estado" 
                    <?php echo e((isset($enrollment) && !$enrollment->estado) ? '' : 'checked'); ?>

                >
                <label class="form-check-label" for="estado">
                    Activo
                </label>
            </div>
            
            <button type="submit" class="btn btn-primary">Guardar</button>
            <a href="<?php echo e(route('enrollments.index')); ?>" class="btn btn-warning">Regresar</a>
        </form>
    </div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app-menu', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\xampp\htdocs\colegio-app\resources\views/enrollments/form.blade.php ENDPATH**/ ?>