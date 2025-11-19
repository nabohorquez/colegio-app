

<?php $__env->startSection('title', '<?php echo e(isset($enrollment) ? "Editar" : "Crear"); ?> Matrícula - Sistema Escolar'); ?>

<?php $__env->startSection('content-principal'); ?>
    <div class="welcome-header">
        <h1><?php echo e(isset($enrollment) ? 'Editar' : 'Crear'); ?> Matrícula</h1>
        <p><?php echo e(isset($enrollment) ? 'Modifica los datos de la matrícula' : 'Registra una nueva matrícula'); ?></p>
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
            <form action="<?php echo e(isset($enrollment) && $enrollment
                        ? route('enrollments.update', $enrollment->id) 
                        : route('enrollments.create')); ?>" method="post"
            >
                <?php echo csrf_field(); ?>
                <?php if(isset($enrollment) && $enrollment): ?>
                    <?php echo method_field('PUT'); ?>
                <?php endif; ?>
                
                <!-- Información del Estudiante -->
                <div class="row">
                    <div class="col-md-6 mb-4">
                        <label for="estudiante_id" class="form-label">Estudiante</label>
                        <select class="form-control <?php $__errorArgs = ['estudiante_id'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" 
                            id="estudiante_id" name="estudiante_id" required>
                            <option value="">Seleccionar estudiante...</option>
                            <?php $__currentLoopData = $students; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $student): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <option value="<?php echo e($student->id); ?>" 
                                    <?php echo e((isset($enrollment) && $enrollment->estudiante_id == $student->id) ? 'selected' : ''); ?>>
                                    <?php echo e($student->first_name); ?> <?php echo e($student->last_name); ?>

                                </option>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        </select>
                        <?php $__errorArgs = ['estudiante_id'];
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
                    
                    <div class="col-md-6 mb-4">
                        <label for="grado_id" class="form-label">Grado</label>
                        <select class="form-control <?php $__errorArgs = ['grado_id'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" 
                            id="grado_id" name="grado_id" required>
                            <option value="">Seleccionar grado...</option>
                            <?php $__currentLoopData = $grades; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $grade): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <option value="<?php echo e($grade->id); ?>" 
                                    <?php echo e((isset($enrollment) && $enrollment->grado_id == $grade->id) ? 'selected' : ''); ?>>
                                    <?php echo e($grade->nombre_grado); ?>

                                </option>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        </select>
                        <?php $__errorArgs = ['grado_id'];
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
                </div>

                <!-- Tipo de Matrícula -->
                <div class="row">
                    <div class="col-md-6 mb-4">
                        <label for="tipo_matricula_id" class="form-label">Tipo de Matrícula</label>
                        <select class="form-control <?php $__errorArgs = ['tipo_matricula_id'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" 
                            id="tipo_matricula_id" name="tipo_matricula_id" required>
                            <option value="">Seleccionar tipo...</option>
                            <?php $__currentLoopData = $enrollmentTypes; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $type): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <option value="<?php echo e($type->id); ?>" 
                                    <?php echo e((isset($enrollment) && $enrollment->tipo_matricula_id == $type->id) ? 'selected' : ''); ?>>
                                    <?php echo e($type->nombre_tipo); ?>

                                </option>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        </select>
                        <?php $__errorArgs = ['tipo_matricula_id'];
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
                    
                    <div class="col-md-6 mb-4">
                        <label for="fecha" class="form-label">Fecha de Matrícula</label>
                        <input type="date" class="form-control <?php $__errorArgs = ['fecha'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" 
                            id="fecha" name="fecha"
                            value="<?php echo e(isset($enrollment) && $enrollment->fecha ? $enrollment->fecha->format('Y-m-d') : now()->format('Y-m-d')); ?>" 
                            required
                        >
                        <?php $__errorArgs = ['fecha'];
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
                </div>

                <!-- Información de Pago -->
                <div class="row">
                    <div class="col-md-6 mb-4">
                        <label for="forma_pago" class="form-label">Forma de Pago</label>
                        <select class="form-control <?php $__errorArgs = ['forma_pago'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" 
                            id="forma_pago" name="forma_pago" required>
                            <option value="">Seleccionar forma de pago...</option>
                            <option value="efectivo" <?php echo e((isset($enrollment) && $enrollment->forma_pago == 'efectivo') ? 'selected' : ''); ?>>Efectivo</option>
                            <option value="cheque" <?php echo e((isset($enrollment) && $enrollment->forma_pago == 'cheque') ? 'selected' : ''); ?>>Cheque</option>
                            <option value="transferencia" <?php echo e((isset($enrollment) && $enrollment->forma_pago == 'transferencia') ? 'selected' : ''); ?>>Transferencia</option>
                            <option value="tarjeta de crédito" <?php echo e((isset($enrollment) && $enrollment->forma_pago == 'tarjeta de crédito') ? 'selected' : ''); ?>>Tarjeta de Crédito</option>
                        </select>
                        <?php $__errorArgs = ['forma_pago'];
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
                    
                    <div class="col-md-6 mb-4">
                        <label for="costo" class="form-label">Costo de Matrícula</label>
                        <div class="input-group">
                            <span class="input-group-text">$</span>
                            <input type="number" step="0.01" class="form-control <?php $__errorArgs = ['costo'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" 
                                id="costo" name="costo"
                                value="<?php echo e($enrollment->costo ?? '500000'); ?>"
                                placeholder="0.00"
                            >
                        </div>
                        <?php $__errorArgs = ['costo'];
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
                </div>

                <div class="mb-4">
                    <label for="estado_pago" class="form-label">Estado de Pago</label>
                    <select class="form-control <?php $__errorArgs = ['estado_pago'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" 
                        id="estado_pago" name="estado_pago" required>
                        <option value="pendiente" <?php echo e((isset($enrollment) && $enrollment->estado_pago == 'pendiente') ? 'selected' : ''); ?>>Pendiente</option>
                        <option value="parcial" <?php echo e((isset($enrollment) && $enrollment->estado_pago == 'parcial') ? 'selected' : ''); ?>>Pagado Parcialmente</option>
                        <option value="pagado" <?php echo e((isset($enrollment) && $enrollment->estado_pago == 'pagado') ? 'selected' : ''); ?>>Pagado Completamente</option>
                    </select>
                    <?php $__errorArgs = ['estado_pago'];
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
                            <?php echo e((isset($enrollment) && $enrollment->estado) ? 'checked' : ''); ?>

                        >
                        <label class="form-check-label" for="estado">
                            <strong>Matrícula Activa</strong>
                            <small class="text-muted d-block">Las matrículas inactivas aparecerán como canceladas</small>
                        </label>
                    </div>
                </div>
                
                <div class="d-flex gap-2">
                    <button type="submit" class="btn btn-primary">
                        <i class="fas fa-save me-2"></i>Guardar
                    </button>
                    <a href="<?php echo e(route('enrollments.index')); ?>" class="btn btn-outline-secondary">
                        <i class="fas fa-arrow-left me-2"></i>Regresar
                    </a>
                </div>
            </form>
        </div>
    </div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app-menu', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\xampp\htdocs\colegio-app\resources\views/enrollments/form.blade.php ENDPATH**/ ?>