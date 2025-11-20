

<?php $__env->startSection('title', 'Dashboard - Sistema Escolar'); ?>

<?php $__env->startSection('content-principal'); ?>
    <div class="welcome-header">
        <h1>¡Bienvenido, <?php echo e(Auth::user()->name); ?>!</h1>
        <p>
            <?php
                $userRole = Auth::user()->roles->first()?->rol_name ?? 'Usuario';
            ?>
            <?php if(str_contains(strtolower($userRole), 'estudiante')): ?>
                Consulta tus calificaciones y actividades académicas
            <?php else: ?>
                Gestiona tu institución educativa de forma eficiente
            <?php endif; ?>
        </p>
    </div>

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

    <?php
        $isStudent = Auth::user()->roles->where('rol_name', 'like', '%Estudiante%')->count() > 0;
    ?>

    <?php if($isStudent): ?>
        <!-- DASHBOARD PARA ESTUDIANTES -->
        <div class="row mb-4">
            <div class="col-md-6 col-lg-4 mb-3">
                <div class="stat-card text-info">
                    <div class="icon">
                        <i class="fas fa-file-contract"></i>
                    </div>
                    <h6>Mis Matrículas</h6>
                    <?php
                        $student = \App\Models\student::where('user_id', Auth::id())->first();
                        $enrollments = $student ? $student->enrollments->count() : 0;
                    ?>
                    <div class="number"><?php echo e($enrollments); ?></div>
                    <small class="text-muted">Activas</small>
                </div>
            </div>

            <div class="col-md-6 col-lg-4 mb-3">
                <div class="stat-card text-success">
                    <div class="icon">
                        <i class="fas fa-star"></i>
                    </div>
                    <h6>Mis Calificaciones</h6>
                    <?php
                        $grades = $student ? $student->grades->count() : 0;
                    ?>
                    <div class="number"><?php echo e($grades); ?></div>
                    <small class="text-muted">Registradas</small>
                </div>
            </div>

            <div class="col-md-6 col-lg-4 mb-3">
                <div class="stat-card text-warning">
                    <div class="icon">
                        <i class="fas fa-tasks"></i>
                    </div>
                    <h6>Actividades</h6>
                    <?php
                        $activities = \App\Models\Activity::count();
                    ?>
                    <div class="number"><?php echo e($activities); ?></div>
                    <small class="text-muted">Disponibles</small>
                </div>
            </div>
        </div>

        <!-- Sección: Mis Calificaciones -->
        <div class="row mb-4">
            <div class="col-12">
                <div class="section-card">
                    <div class="card-header">
                        <h5>
                            <i class="fas fa-star me-2"></i>Mis Calificaciones
                        </h5>
                    </div>
                    <div class="card-body">
                        <?php if($student && $student->grades->count() > 0): ?>
                            <div class="table-responsive">
                                <table class="table">
                                    <thead>
                                        <tr>
                                            <th>Materia</th>
                                            <th>Período</th>
                                            <th>Nota 1er Parcial</th>
                                            <th>Nota 2do Parcial</th>
                                            <th>Nota Final</th>
                                            <th>Estado</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php $__currentLoopData = $student->grades; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $grade): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                            <tr>
                                                <td><?php echo e($grade->subject); ?></td>
                                                <td><?php echo e($grade->academic_period); ?></td>
                                                <td>
                                                    <?php if($grade->first_partial): ?>
                                                        <span class="badge bg-info"><?php echo e($grade->first_partial); ?></span>
                                                    <?php else: ?>
                                                        <span class="text-muted">-</span>
                                                    <?php endif; ?>
                                                </td>
                                                <td>
                                                    <?php if($grade->second_partial): ?>
                                                        <span class="badge bg-info"><?php echo e($grade->second_partial); ?></span>
                                                    <?php else: ?>
                                                        <span class="text-muted">-</span>
                                                    <?php endif; ?>
                                                </td>
                                                <td>
                                                    <?php if($grade->final_grade): ?>
                                                        <span class="badge bg-success"><?php echo e($grade->final_grade); ?></span>
                                                    <?php else: ?>
                                                        <span class="text-muted">-</span>
                                                    <?php endif; ?>
                                                </td>
                                                <td>
                                                    <?php if($grade->status === 'passed'): ?>
                                                        <span class="badge bg-success">Aprobado</span>
                                                    <?php elseif($grade->status === 'failed'): ?>
                                                        <span class="badge bg-danger">Reprobado</span>
                                                    <?php else: ?>
                                                        <span class="badge bg-warning">Pendiente</span>
                                                    <?php endif; ?>
                                                </td>
                                            </tr>
                                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                    </tbody>
                                </table>
                            </div>
                        <?php else: ?>
                            <div class="text-center py-5">
                                <i class="fas fa-inbox fa-3x text-muted mb-3" style="display: block;"></i>
                                <p class="text-muted mb-0">No tienes calificaciones registradas aún</p>
                            </div>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
        </div>

        <!-- Sección: Actividades Disponibles -->
        <div class="row">
            <div class="col-12">
                <div class="section-card">
                    <div class="card-header">
                        <h5>
                            <i class="fas fa-tasks me-2"></i>Actividades Disponibles
                        </h5>
                    </div>
                    <div class="card-body">
                        <?php
                            $activities = \App\Models\Activity::limit(5)->get();
                        ?>
                        <?php if($activities->count() > 0): ?>
                            <div class="row">
                                <?php $__currentLoopData = $activities; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $activity): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <div class="col-md-6 mb-3">
                                        <div class="card">
                                            <div class="card-body">
                                                <h6 class="card-title"><?php echo e($activity->title); ?></h6>
                                                <p class="card-text text-muted"><?php echo e(Str::limit($activity->description, 100)); ?></p>
                                                <small class="text-muted">
                                                    <i class="fas fa-user me-1"></i>
                                                    <?php echo e($activity->creator->name ?? 'N/A'); ?>

                                                </small>
                                            </div>
                                        </div>
                                    </div>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            </div>
                        <?php else: ?>
                            <div class="text-center py-5">
                                <i class="fas fa-inbox fa-3x text-muted mb-3" style="display: block;"></i>
                                <p class="text-muted mb-0">No hay actividades disponibles</p>
                            </div>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
        </div>

    <?php else: ?>
        <!-- DASHBOARD PARA ADMINISTRADORES -->
        <!-- Estadísticas Principales -->
        <div class="row mb-4">
            <div class="col-md-6 col-lg-3 mb-3">
                <div class="stat-card text-primary">
                    <div class="icon">
                        <i class="fas fa-users"></i>
                    </div>
                    <h6>Estudiantes</h6>
                    <div class="number"><?php echo e(\App\Models\student::count()); ?></div>
                    <small class="text-muted">Matriculados</small>
                </div>
            </div>

            <div class="col-md-6 col-lg-3 mb-3">
                <div class="stat-card text-success">
                    <div class="icon">
                        <i class="fas fa-graduation-cap"></i>
                    </div>
                    <h6>Grados</h6>
                    <div class="number"><?php echo e(\App\Models\Grade::count()); ?></div>
                    <small class="text-muted">Activos</small>
                </div>
            </div>

            <div class="col-md-6 col-lg-3 mb-3">
                <div class="stat-card text-warning">
                    <div class="icon">
                        <i class="fas fa-book"></i>
                    </div>
                    <h6>Materias</h6>
                    <div class="number"><?php echo e(\App\Models\Subject::count()); ?></div>
                    <small class="text-muted">Disponibles</small>
                </div>
            </div>

            <div class="col-md-6 col-lg-3 mb-3">
                <div class="stat-card text-info">
                    <div class="icon">
                        <i class="fas fa-file-invoice"></i>
                    </div>
                    <h6>Matrículas</h6>
                    <div class="number"><?php echo e(\App\Models\Enrollment::count()); ?></div>
                    <small class="text-muted">Registradas</small>
                </div>
            </div>
        </div>

        <!-- Acciones Rápidas -->
        <div class="row mb-4">
            <div class="col-12">
                <div class="section-card">
                    <div class="card-header">
                        <h5>
                            <i class="fas fa-bolt me-2"></i>Acciones Rápidas
                        </h5>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-4 mb-3">
                                <a href="<?php echo e(route('enrollments.index')); ?>" class="btn btn-primary w-100">
                                    <i class="fas fa-plus-circle me-2"></i>
                                    Matrículas
                                </a>
                            </div>
                            <div class="col-md-4 mb-3">
                                <button type="button" class="btn btn-outline-primary w-100" data-bs-toggle="modal" data-bs-target="#modalNewStudent">
                                    <i class="fas fa-user-plus me-2"></i>
                                    Nuevo Estudiante
                                </button>
                            </div>
                            <div class="col-md-4 mb-3">
                                <a href="<?php echo e(route('grades.index')); ?>" class="btn btn-outline-primary w-100">
                                    <i class="fas fa-list me-2"></i>
                                    Ver Grados
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Últimas Matrículas -->
        <div class="row">
            <div class="col-12">
                <div class="section-card">
                    <div class="card-header">
                        <h5>
                            <i class="fas fa-clock me-2"></i>Últimas Matrículas
                        </h5>
                    </div>
                    <div class="card-body">
                        <?php
                            $enrollments = \App\Models\Enrollment::with(['student', 'grade', 'enrollmentType'])
                                ->orderBy('created_at', 'desc')
                                ->limit(5)
                                ->get();
                        ?>

                        <?php if($enrollments->count() > 0): ?>
                            <div class="table-responsive">
                                <table class="table">
                                    <thead>
                                        <tr>
                                            <th>Estudiante</th>
                                            <th>Grado</th>
                                            <th>Tipo Matrícula</th>
                                            <th>Fecha</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php $__currentLoopData = $enrollments; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $enrollment): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                            <tr>
                                                <td>
                                                    <strong><?php echo e($enrollment->student->first_name ?? 'N/A'); ?></strong>
                                                </td>
                                                <td><?php echo e($enrollment->grade->nombre_grado ?? 'N/A'); ?></td>
                                                <td>
                                                    <span class="badge bg-info">
                                                        <?php echo e($enrollment->enrollmentType->nombre_tipo ?? 'N/A'); ?>

                                                    </span>
                                                </td>
                                                <td><?php echo e($enrollment->created_at->format('d/m/Y')); ?></td>
                                            </tr>
                                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                    </tbody>
                                </table>
                            </div>
                        <?php else: ?>
                            <div class="text-center py-5">
                                <i class="fas fa-inbox fa-3x text-muted mb-3" style="display: block;"></i>
                                <p class="text-muted mb-0">No hay matrículas registradas aún</p>
                                <small class="text-muted">¡Comienza creando tu primera matrícula!</small>
                            </div>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
        </div>

    <?php endif; ?>

    <!-- Modal Crear Estudiante (solo para administradores) -->
    <?php if(!$isStudent): ?>
    <div class="modal fade" id="modalNewStudent" tabindex="-1">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header border-0">
                    <h5 class="modal-title">Nuevo Estudiante</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <form id="formNewStudent">
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label class="form-label">Nombre</label>
                                <input type="text" id="first_name" class="form-control" required>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label class="form-label">Apellido</label>
                                <input type="text" id="last_name" class="form-control" required>
                            </div>

                            <div class="col-md-6 mb-3">
                                <label class="form-label">Documento</label>
                                <input type="text" id="document" class="form-control">
                            </div>
                            <div class="col-md-6 mb-3">
                                <label class="form-label">Fecha de Nacimiento</label>
                                <input type="date" id="birth_date" class="form-control">
                            </div>

                            <div class="col-md-6 mb-3">
                                <label class="form-label">Grado</label>
                                <select id="grade" class="form-control" required>
                                    <option value="">Seleccione un grado...</option>
                                    <?php $__currentLoopData = \App\Models\Grade::where('estado', true)->get(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $grade): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                        <option value="<?php echo e($grade->nombre_grado); ?>"><?php echo e($grade->nombre_grado); ?></option>
                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                </select>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label class="form-label">Acudiente</label>
                                <select id="guardian_id" class="form-control">
                                    <option value="">Sin asignar</option>
                                    <?php $__currentLoopData = \App\Models\Guardian::all(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $g): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                        <option value="<?php echo e($g->id); ?>"><?php echo e($g->full_name); ?></option>
                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                </select>
                            </div>
                        </div>
                    </form>
                </div>
                <div class="modal-footer border-0">
                    <button class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                    <button class="btn btn-primary" id="btnSaveNewStudent">Guardar</button>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script>
        document.addEventListener("DOMContentLoaded", () => {
            const modal = new bootstrap.Modal(document.getElementById('modalNewStudent'));

            document.getElementById('btnSaveNewStudent').addEventListener('click', async () => {
                const first_name = document.getElementById('first_name').value;
                const last_name = document.getElementById('last_name').value;
                const grade = document.getElementById('grade').value;

                if (!first_name || !last_name || !grade) {
                    Swal.fire('Validación', 'Por favor completa los campos requeridos', 'warning');
                    return;
                }

                const payload = {
                    first_name: first_name,
                    last_name: last_name,
                    birth_date: document.getElementById('birth_date').value,
                    document: document.getElementById('document').value,
                    grade: grade,
                    guardian_id: document.getElementById('guardian_id').value || null,
                };

                try {
                    const res = await fetch('<?php echo e(route("students.store")); ?>', {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json',
                            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
                        },
                        body: JSON.stringify(payload)
                    });

                    const result = await res.json();
                    
                    if (res.ok || res.status === 201) {
                        Swal.fire('Éxito', result.message || 'Estudiante guardado correctamente', 'success').then(() => {
                            location.reload();
                        });
                    } else {
                        let errorMsg = result.message || 'Error al guardar';
                        if (result.errors) {
                            errorMsg = Object.values(result.errors).flat().join('\n');
                        }
                        Swal.fire('Error', errorMsg, 'error');
                        console.error('Response:', result);
                    }
                } catch (error) {
                    Swal.fire('Error', 'Error en la solicitud: ' + error.message, 'error');
                    console.error('Error:', error);
                }
            });
        });
    </script>
    <?php endif; ?>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app-menu', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\Users\USER\OneDrive\Universidad\U Cundinamarca\Semestre 6\Ing. Software II\Colegio - Principal\colegio-app\resources\views/dashboard.blade.php ENDPATH**/ ?>