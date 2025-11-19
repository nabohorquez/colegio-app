

<?php $__env->startSection('title', 'Roles - AcademicSoftware'); ?>

<?php $__env->startSection('content-principal'); ?>
    <div class="container mt-5">
        <?php if($errors->any()): ?>
            <div class="alert alert-danger">
                <ul>
                    <?php $__currentLoopData = $errors->all(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $error): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <li><?php echo e($error); ?></li>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </ul>
            </div>
        <?php endif; ?>

        <form action="<?php echo e(Str::after(Route::currentRouteName(), '.') == 'viewCreate'
                    ? route('roles.create') : route('roles.update', $role->id)); ?>" method="post"
        >
            <?php echo csrf_field(); ?>
            <?php if(Str::after(Route::currentRouteName(), '.') != 'viewCreate'): ?>
                <?php echo method_field('PUT'); ?>
            <?php endif; ?>

            <div class="mb-3">
                <label for="rol_name" class="form-label">Nombre del Rol</label>
                <input type="text" class="form-control" id="rol_name" name="rol_name" value="<?php echo e($role->rol_name ?? ''); ?>" required>
            </div>
            <div class="mb-3">
                <label for="description" class="form-label">Descripción</label>
                <textarea class="form-control" id="description" name="description" rows="3" required><?php echo e($role->description ?? ''); ?></textarea>
            </div>

            <div class="mb-3 mt-5">
                <h5 class="form-label d-block">Permisos por módulo</h5>
                <div class="row g-3">
                    <ul class="nav nav-tabs" id="moduleTabs">
                        <?php $__currentLoopData = $modules; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $module): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <li class="nav-item">
                                <button
                                    class="nav-link"
                                    id="<?php echo e($module->id); ?>-tab"
                                    data-bs-toggle="tab"
                                    data-bs-target="#<?php echo e($module->id); ?>-tab-pane"
                                    type="button"
                                    role="tab"
                                    aria-controls="<?php echo e($module->id); ?>-tab-pane"
                                >
                                    <?php echo e($module->page_name); ?>

                                </button>
                            </li>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </ul>
                    <div class="tab-content" id="pagesByModuleTabContent">
                        <?php $__currentLoopData = $modules; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $module): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <div
                                class="tab-pane fade row"
                                id="<?php echo e($module->id); ?>-tab-pane"
                                role="tabpanel"
                                aria-labelledby="<?php echo e($module->id); ?>-tab"
                                tabindex="<?php echo e($module->id); ?>"
                            >
                                <div class="col-12 justify-content-end d-flex mx-2 row">
                                    <div class="d-flex col-sm-12 col-md-6 col-lg-4" role="search">
                                        <input class="form-control me-2" type="search"
                                            placeholder="Buscar pagina" aria-label="Search"
                                            oninput="filterPagesByModule('<?php echo e(Str::slug($module->id)); ?>', this.value)"
                                            id="searchField"
                                        />
                                    </div>
                                    <div class="form-check mb-2 col-sm-12 col-md-6 col-lg-4">
                                        <input
                                            class="mx-1 form-check-input permission-item permission-<?php echo e(Str::slug($module->id)); ?>"
                                            type="checkbox" name="permissionAll" value="<?php echo e($module->id); ?>"
                                            id="permissionAll<?php echo e($module->id); ?>"
                                            onchange="checkedAllModule('<?php echo e(Str::slug($module->id)); ?>', this.checked)"
                                        >
                                        <label class="form-check-label"
                                            for="permissionAll<?php echo e($module->id); ?>">Seleccionar todo</label>
                                    </div>
                                </div>
                                <div class="col-12 row">
                                    <?php if(!$module->sub_pages || count($module->sub_pages) === 0): ?>
                                        <h6 class="fw-semibold col-12 label-page-module-<?php echo e(Str::slug($module->id)); ?>"
                                            data-etiqueta="<?php echo e($module->page_name); ?>"
                                            data-page="<?php echo e(Str::slug($module->id)); ?>"
                                            data-module="<?php echo e(Str::slug($module->id)); ?>"
                                        >
                                            <?php echo e($module->page_name); ?>

                                        </h6>
                                        <?php $__currentLoopData = $permissions; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key => $permission): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                            <div class="col-sm-6 col-md-3 col-lg-3 permission-row"
                                                data-etiqueta="<?php echo e($module->page_name); ?>"
                                                data-page="<?php echo e(Str::slug($module->id)); ?>"
                                                data-module="<?php echo e(Str::slug($module->id)); ?>"
                                            >
                                                <div class="form-check mb-2">
                                                    <input
                                                        class="form-check-input permission-item permission-<?php echo e(Str::slug($module->id)); ?>"
                                                        type="checkbox" name="permissions[]" value="<?php echo e($module->id); ?>-<?php echo e($key); ?>"
                                                        id="modulePermission<?php echo e($key); ?>"
                                                        onchange="updateModuleCheckboxState('<?php echo e(Str::slug($module->id)); ?>')"
                                                        <?php echo e(isset($pagePermissions[$module->id]) && in_array($key, $pagePermissions[$module->id]) ? 'checked' : ''); ?>

                                                    >
                                                    <label class="form-check-label"
                                                        for="modulePermission<?php echo e($key); ?>"><?php echo e($permission); ?></label>
                                                </div>
                                            </div>
                                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                    <?php else: ?>
                                        <?php $__currentLoopData = $module->sub_pages; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $sub_page): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                            <h6 class="fw-semibold col-12 label-sub-page-module-<?php echo e(Str::slug($module->id)); ?>"
                                                data-etiqueta="<?php echo e($sub_page->page_name); ?>"
                                                data-page="<?php echo e(Str::slug($sub_page->id)); ?>"
                                                data-module="<?php echo e(Str::slug($module->id)); ?>"
                                            >
                                                <?php echo e($sub_page->page_name); ?>

                                            </h6>
                                            <?php $__currentLoopData = $permissions; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key => $permission): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                <div class="col-sm-6 col-md-3 col-lg-3 permission-row"
                                                    data-etiqueta="<?php echo e($sub_page->page_name); ?>"
                                                    data-page="<?php echo e(Str::slug($sub_page->id)); ?>"
                                                    data-module="<?php echo e(Str::slug($module->id)); ?>"
                                                >
                                                    <div class="form-check mb-2">
                                                        <input
                                                            class="form-check-input permission-item permission-<?php echo e(Str::slug($module->id)); ?> sub-page-<?php echo e(Str::slug($sub_page->id)); ?>"
                                                            type="checkbox" name="permissions[]" value="<?php echo e($sub_page->id); ?>-<?php echo e($key); ?>"
                                                            id="subPagePermission<?php echo e($key); ?>"
                                                            onchange="updateModuleCheckboxState('<?php echo e(Str::slug($module->id)); ?>')"
                                                            <?php echo e(isset($pagePermissions[$sub_page->id]) && in_array($key, $pagePermissions[$sub_page->id]) ? 'checked' : ''); ?>

                                                        >
                                                        <label class="form-check-label"
                                                            for="subPagePermission<?php echo e($key); ?>"><?php echo e($permission); ?></label>
                                                    </div>
                                                </div>
                                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                    <?php endif; ?>
                                </div>
                            </div>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </div>
                </div>
            </div>

            <button type="submit" class="btn btn-primary">Guardar</button>
        </form>
    </div>

    <?php $__env->startPush('scripts'); ?>
        <script src="<?php echo e(asset('js/role/form.js')); ?>"></script>
    <?php $__env->stopPush(); ?>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app-menu', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\xampp\htdocs\colegio-app\resources\views/roles/form.blade.php ENDPATH**/ ?>