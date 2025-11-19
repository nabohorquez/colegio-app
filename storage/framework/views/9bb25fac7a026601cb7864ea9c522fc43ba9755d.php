

<?php $__env->startSection('title', 'Calificaciones de Estudiantes - Sistema Escolar'); ?>

<?php $__env->startSection('content-principal'); ?>
<div class="d-flex justify-content-between align-items-center welcome-header">
    <div>
        <h1>
            <i class="fas fa-star me-2"></i>Calificaciones de Estudiantes
        </h1>
        <p class="text-secondary">Gestionar calificaciones por estudiante y asignatura</p>
    </div>
    <div>
        <a href="<?php echo e(route('student-grades.create')); ?>" class="btn btn-primary">
            <i class="fas fa-plus-circle me-2"></i>Nueva Calificación
        </a>
    </div>
</div>

    <!-- Tabla de Calificaciones -->
    <div class="section-card">
        <div class="card-header">
            <h5>
                <i class="fas fa-list me-2"></i>Listado de Calificaciones
            </h5>
        </div>
        <div class="card-body">
            <?php if(session('success')): ?>
                <div class="alert alert-success alert-dismissible fade show" role="alert">
                    <i class="fas fa-check-circle me-2"></i><?php echo e(session('success')); ?>

                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
            <?php endif; ?>

            <?php if(session('error')): ?>
                <div class="alert alert-danger alert-dismissible fade show" role="alert">
                    <i class="fas fa-exclamation-circle me-2"></i><?php echo e(session('error')); ?>

                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
            <?php endif; ?>

            <?php if($grades->count() > 0): ?>
                <div class="table-responsive">
                    <table class="table">
                        <thead>
                            <tr>
                                <th>Estudiante</th>
                                <th>Asignatura</th>
                                <th>Parcial 1</th>
                                <th>Parcial 2</th>
                                <th>Nota Final</th>
                                <th>Estado</th>
                                <th>Acciones</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php $__currentLoopData = $grades; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $grade): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <tr>
                                    <td>
                                        <strong><?php echo e($grade->student->full_name ?? 'N/A'); ?></strong>
                                        <br>
                                        <small class="text-secondary"><?php echo e($grade->student->document ?? 'N/A'); ?></small>
                                    </td>
                                    <td><?php echo e($grade->subject->nombre_materia ?? 'N/A'); ?></td>
                                    <td>
                                        <?php if($grade->partial_1): ?>
                                            <span class="badge bg-primary"><?php echo e(number_format($grade->partial_1, 1)); ?></span>
                                        <?php else: ?>
                                            <span class="badge bg-secondary">-</span>
                                        <?php endif; ?>
                                    </td>
                                    <td>
                                        <?php if($grade->partial_2): ?>
                                            <span class="badge bg-primary"><?php echo e(number_format($grade->partial_2, 1)); ?></span>
                                        <?php else: ?>
                                            <span class="badge bg-secondary">-</span>
                                        <?php endif; ?>
                                    </td>
                                    <td>
                                        <?php if($grade->final_grade): ?>
                                            <?php if($grade->final_grade >= 3.0): ?>
                                                <span class="badge bg-success fs-6 px-2 py-2"><?php echo e(number_format($grade->final_grade, 1)); ?></span>
                                            <?php else: ?>
                                                <span class="badge bg-danger fs-6 px-2 py-2"><?php echo e(number_format($grade->final_grade, 1)); ?></span>
                                            <?php endif; ?>
                                        <?php else: ?>
                                            <span class="badge bg-secondary">-</span>
                                        <?php endif; ?>
                                    </td>
                                    <td>
                                        <?php
                                            $status = $grade->final_grade ? ($grade->final_grade >= 3.0 ? 'APROBADO' : 'REPROBADO') : 'PENDIENTE';
                                            $badgeClass = $status === 'APROBADO' ? 'bg-success' : ($status === 'REPROBADO' ? 'bg-danger' : 'bg-warning');
                                        ?>
                                        <span class="badge <?php echo e($badgeClass); ?>"><?php echo e($status); ?></span>
                                    </td>
                                    <td>
                                        <div class="btn-group btn-group-sm" role="group">
                                            <a href="<?php echo e(route('student-grades.show', $grade->id)); ?>" class="btn btn-outline-primary" title="Ver">
                                                <i class="fas fa-eye"></i>
                                            </a>
                                            <a href="<?php echo e(route('student-grades.edit', $grade->id)); ?>" class="btn btn-outline-warning" title="Editar">
                                                <i class="fas fa-edit"></i>
                                            </a>
                                            <button type="button" class="btn btn-outline-danger" onclick="deleteGrade(<?php echo e($grade->id); ?>)" title="Eliminar">
                                                <i class="fas fa-trash"></i>
                                            </button>
                                        </div>
                                    </td>
                                </tr>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        </tbody>
                    </table>
                </div>

                <!-- Paginación -->
                <div class="d-flex justify-content-center mt-4">
                    <?php echo e($grades->links()); ?>

                </div>
            <?php else: ?>
                <div class="text-center py-5">
                    <i class="fas fa-inbox fa-3x text-secondary mb-3" style="display: block;"></i>
                    <p class="text-secondary mb-0">No hay calificaciones registradas aún</p>
                    <small class="text-tertiary">¡Comienza creando la primera calificación!</small>
                </div>
            <?php endif; ?>
        </div>
    </div>
<script>
function deleteGrade(id) {
    if (confirm('¿Estás seguro de que deseas eliminar esta calificación?')) {
        const form = document.createElement('form');
        form.method = 'POST';
        form.action = '<?php echo e(url("/student-grades")); ?>/' + id;
        
        const token = document.createElement('input');
        token.type = 'hidden';
        token.name = '_token';
        token.value = '<?php echo e(csrf_token()); ?>';
        
        const method = document.createElement('input');
        method.type = 'hidden';
        method.name = '_method';
        method.value = 'DELETE';
        
        form.appendChild(token);
        form.appendChild(method);
        document.body.appendChild(form);
        form.submit();
    }
}
</script>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app-menu', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\xampp\htdocs\colegio-app\resources\views/student_grades/index.blade.php ENDPATH**/ ?>