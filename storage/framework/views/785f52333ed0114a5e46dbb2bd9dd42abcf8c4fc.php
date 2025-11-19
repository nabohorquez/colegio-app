

<?php $__env->startSection('title', 'Editar Actividad'); ?>

<?php $__env->startSection('content-principal'); ?>
<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <h3 class="mb-4">Editar Actividad</h3>

            <div class="card">
                <div class="card-body">
                    <form action="<?php echo e(route('activities.update', $activity->id)); ?>" method="POST">
                        <?php echo method_field('PUT'); ?>
                        <?php echo $__env->make('school_admin.activities._form', ['activity' => $activity], \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app-menu', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\xampp\htdocs\colegio-app\resources\views/school_admin/activities/edit.blade.php ENDPATH**/ ?>