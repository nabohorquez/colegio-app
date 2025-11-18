

<?php $__env->startSection('title', 'Iniciar Sesión - Sistema Escolar'); ?>

<?php $__env->startSection('content'); ?>
    <div class="login-container">
        <div class="login-wrapper">
            <div class="login-card">
                <!-- Header -->
                <div class="login-header">
                    <div class="school-logo">
                        <i class="fas fa-graduation-cap"></i>
                    </div>
                    <h1>AcademicSoftware</h1>
                    <p class="subtitle">Sistema de Gestión Educativa Integral</p>
                </div>

                <!-- Errors -->
                <?php if($errors->any()): ?>
                    <div class="alert alert-danger alert-dismissible fade show" role="alert">
                        <i class="fas fa-exclamation-circle me-2"></i><strong>Error de autenticación</strong>
                        <ul class="mb-0 mt-2">
                            <?php $__currentLoopData = $errors->all(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $error): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <li><?php echo e($error); ?></li>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        </ul>
                        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                    </div>
                <?php endif; ?>

                <!-- Form -->
                <form method="POST" action="<?php echo e(route('login.post')); ?>" class="login-form">
                    <?php echo csrf_field(); ?>

                    <div class="form-group">
                        <label for="email">
                            <i class="fas fa-envelope me-2"></i>Correo Electrónico
                        </label>
                        <input 
                            type="email" 
                            class="form-control <?php $__errorArgs = ['email'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>"
                            id="email" 
                            name="email" 
                            value="<?php echo e(old('email')); ?>" 
                            required 
                            autocomplete="email"
                            autofocus
                            placeholder="tu@colegio.com"
                        >
                        <?php $__errorArgs = ['email'];
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

                    <div class="form-group">
                        <label for="password">
                            <i class="fas fa-lock me-2"></i>Contraseña
                        </label>
                        <input 
                            type="password" 
                            class="form-control <?php $__errorArgs = ['password'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>"
                            id="password" 
                            name="password" 
                            required 
                            autocomplete="current-password"
                            placeholder="••••••••"
                        >
                        <?php $__errorArgs = ['password'];
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

                    <div class="form-check">
                        <input 
                            type="checkbox" 
                            class="form-check-input" 
                            id="remember" 
                            name="remember"
                        >
                        <label class="form-check-label" for="remember">
                            <i class="fas fa-check me-1"></i>Recordarme en este navegador
                        </label>
                    </div>

                    <button type="submit" class="btn-login">
                        <i class="fas fa-sign-in-alt me-2"></i>Iniciar Sesión
                    </button>
                </form>

                <!-- Footer -->
                <div class="login-footer">
                    <p>¿No tienes cuenta? <a href="<?php echo e(route('register')); ?>"><i class="fas fa-user-plus me-1"></i>Solicita una aquí</a></p>
                </div>
            </div>
        </div>
    </div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\laragon\www\Propios\colegio-app\resources\views/auth/login.blade.php ENDPATH**/ ?>