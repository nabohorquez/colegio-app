

<?php $__env->startSection('title', 'Sistema Escolar'); ?>

<?php $__env->startSection('content'); ?>
<!-- Navbar -->
<nav class="navbar navbar-expand-lg" aria-label="Main navigation">
    <div class="container-fluid px-4">
        <a class="navbar-brand" href="<?php echo e(route('dashboard')); ?>">
            <i class="fas fa-school"></i>Mi Colegio
        </a>

        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>

        <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav ms-auto">
                <li class="nav-item">
                    <button class="nav-link theme-toggle" id="themeToggle" title="Cambiar tema">
                        <i class="fas fa-moon"></i>
                    </button>
                </li>
                <li class="nav-item dropdown">
                    <button class="nav-link dropdown-toggle" id="navbarDropdown" data-bs-toggle="dropdown" aria-expanded="false">
                        <i class="fas fa-user-circle me-2"></i><?php echo e(Auth::user()->name); ?>

                    </button>
                    <ul class="dropdown-menu dropdown-menu-end">
                        <li>
                            <a class="dropdown-item" href="#">
                                <i class="fas fa-user-circle me-2"></i>Mi Perfil
                            </a>
                        </li>
                        <li>
                            <a class="dropdown-item" href="#">
                                <i class="fas fa-cog me-2"></i>Configuración
                            </a>
                        </li>
                        <li><hr class="dropdown-divider"></li>
                        <li>
                            <a class="dropdown-item text-danger" href="<?php echo e(route('logout')); ?>"
                                onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                                <i class="fas fa-sign-out-alt me-2"></i>Cerrar Sesión
                            </a>
                        </li>
                    </ul>
                </li>
            </ul>
        </div>
    </div>
</nav>

<div class="container-fluid">
    <div class="row">
        <!-- Sidebar -->
        <div class="col-md-3 col-lg-2 p-0 d-none d-md-block">
            <div class="sidebar">
                <div class="menu-header">
                    <i class="fas fa-bars me-2"></i>Menú
                </div>
                <nav class="nav flex-column" aria-label="dashboard">
                    <?php
                        $currentRoute = Route::currentRouteName();
                        $currentBase = $currentRoute ? Str::before($currentRoute, '.') : '';
                    ?>
                    <?php if(empty($modules)): ?>
                        <a class="nav-link <?php echo e($currentBase == 'dashboard' ? 'active' : ''); ?>" href="<?php echo e(route('dashboard')); ?>">
                            <i class="fas fa-home"></i>
                            <span>Dashboard</span>
                        </a>
                    <?php else: ?>
                        <?php $__currentLoopData = $modules; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $module): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <?php
                                $moduleRoute = $module->route ?? '';
                            ?>
                            <?php if(empty($module->sub_pages)): ?>
                                <a
                                    class="nav-link <?php echo e(($moduleRoute && Route::has($moduleRoute) && $currentBase == Str::before($moduleRoute, '.')) ? 'active' : ''); ?> <?php echo e((!$moduleRoute || !Route::has($moduleRoute)) ? 'disabled' : ''); ?>"
                                    href="<?php echo e(($moduleRoute && Route::has($moduleRoute)) ? route($moduleRoute) : '#'); ?>"
                                >
                                    <i class="fas fa-book"></i>
                                    <span><?php echo e($module->page_name); ?></span>
                                </a>
                            <?php else: ?>
                                <a class="nav-link" href="#module-<?php echo e($module->id); ?>" data-bs-toggle="collapse" aria-expanded="false">
                                    <i class="fas fa-folder"></i>
                                    <span><?php echo e($module->page_name); ?></span>
                                </a>
                                <div class="collapse" id="module-<?php echo e($module->id); ?>">
                                    <?php $__currentLoopData = $module->sub_pages; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $sub_page): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                        <?php $subRoute = $sub_page->route ?? ''; ?>
                                        <?php if(empty($sub_page->components)): ?>
                                            <a 
                                                class="nav-link <?php echo e(($subRoute && Route::has($subRoute) && $currentBase == Str::before($subRoute, '.')) ? 'active' : ''); ?> <?php echo e((!$subRoute || !Route::has($subRoute)) ? 'disabled' : ''); ?>" 
                                                href="<?php echo e(($subRoute && Route::has($subRoute)) ? route($subRoute) : '#'); ?>"
                                            >
                                                <i class="fas fa-file"></i>
                                                <span><?php echo e($sub_page->page_name); ?></span>
                                            </a>
                                        <?php else: ?>
                                            <a class="nav-link" href="#subpage-<?php echo e($sub_page->id); ?>" data-bs-toggle="collapse" aria-expanded="false">
                                                <i class="fas fa-file"></i>
                                                <span><?php echo e($sub_page->page_name); ?></span>
                                            </a>
                                            <div class="collapse" id="subpage-<?php echo e($sub_page->id); ?>">
                                                <?php $__currentLoopData = $sub_page->components; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $component): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                    <?php $compRoute = $component->route ?? ''; ?>
                                                    <a
                                                        class="nav-link <?php echo e(($compRoute && Route::has($compRoute) && $currentBase == Str::before($compRoute, '.')) ? 'active' : ''); ?> <?php echo e((!$compRoute || !Route::has($compRoute)) ? 'disabled' : ''); ?>"
                                                        href="<?php echo e(($compRoute && Route::has($compRoute)) ? route($compRoute) : '#'); ?>"
                                                    >
                                                        <i class="fas fa-cube"></i>
                                                        <span><?php echo e($component->page_name); ?></span>
                                                    </a>
                                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                            </div>
                                        <?php endif; ?>
                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                </div>
                            <?php endif; ?>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    <?php endif; ?>
                </nav>
            </div>
        </div>

        <!-- Main Content -->
        <div class="col-md-9 col-lg-10 main-content">
            <?php echo $__env->yieldContent('content-principal'); ?>
        </div>
    </div>
</div>

<!-- Logout Form -->
<form id="logout-form" action="<?php echo e(route('logout')); ?>" method="POST" class="d-none">
    <?php echo csrf_field(); ?>
</form>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\xampp\htdocs\colegio-app\resources\views/layouts/app-menu.blade.php ENDPATH**/ ?>