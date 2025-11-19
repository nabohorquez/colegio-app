

<?php $__env->startSection('title', 'Crear Empleado - AcademicSoftware'); ?>

<?php $__env->startSection('content-principal'); ?>
<div class="container mt-5">
    <h2 class="mb-4">Registrar Nuevo Empleado</h2>

    <?php if($errors->any()): ?>
        <div class="alert alert-danger">
            <strong>Errores encontrados:</strong>
            <ul class="mb-0">
                <?php $__currentLoopData = $errors->all(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $error): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <li><?php echo e($error); ?></li>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            </ul>
        </div>
    <?php endif; ?>

    <form action="<?php echo e(route('employees.create')); ?>" method="POST" id="formCreateEmployee">
        <?php echo csrf_field(); ?>

        <div class="row">

            <!-- Nombre -->
            <div class="col-md-6 mb-3">
                <label class="form-label">Nombre</label>
                <input type="text" name="first_name" class="form-control" required>
            </div>

            <!-- Apellido -->
            <div class="col-md-6 mb-3">
                <label class="form-label">Apellido</label>
                <input type="text" name="last_name" class="form-control" required>
            </div>

            <!-- Correo -->
            <div class="col-md-6 mb-3">
                <label class="form-label">Correo</label>
                <input type="email" name="email" class="form-control" required>
            </div>

            <!-- Usuario -->
            <div class="col-md-6 mb-3">
                <label class="form-label">Nombre de usuario</label>
                <input type="text" name="username" class="form-control" required>
            </div>

            <!-- Contraseña -->
            <div class="col-md-6 mb-3">
                <label class="form-label">Contraseña</label>
                <input type="password" name="password" class="form-control" required minlength="6">
            </div>

            <!-- Género -->
            <div class="col-md-6 mb-3">
                <label class="form-label">Género</label>
                <select name="gender" class="form-control" required>
                    <option value="">Seleccione...</option>
                    <option value="F">Femenino</option>
                    <option value="M">Masculino</option>
                    <option value="X">Otro</option>
                </select>
            </div>

            <!-- Estado Civil -->
            <div class="col-md-6 mb-3">
                <label class="form-label">Estado Civil</label>
                <select name="marital_status" class="form-control" required>
                    <option value="">Seleccione...</option>
                    <option value="SOLTERO">Soltero</option>
                    <option value="CASADO">Casado</option>
                    <option value="DIVORCIADO">Divorciado</option>
                    <option value="UNION LIBRE">Unión Libre</option>
                    <option value="VIUDO">Viudo</option>
                </select>
            </div>

        </div>

        <hr>
        <h5>Contactos</h5>

        <div id="contacts_container"></div>

        <button type="button" id="btnAddContact" class="btn btn-secondary btn-sm mt-2">
            <i class="fas fa-plus"></i> Agregar contacto
        </button>

        <hr>

        <div class="d-flex justify-content-end">
            <a href="<?php echo e(route('employees.index')); ?>" class="btn btn-secondary me-2">Cancelar</a>
            <button type="submit" class="btn btn-primary">Guardar</button>
        </div>

    </form>
</div>

<!-- Script para contactos dinámicos -->
<script>
document.addEventListener("DOMContentLoaded", () => {

    const contactsContainer = document.getElementById("contacts_container");

    function addContactField(type = "", value = "") {
        const div = document.createElement("div");
        div.classList.add("row", "mb-2", "contact-row");

        div.innerHTML = `
            <div class="col-md-4">
                <select name="contacts[][type]" class="form-control" required>
                    <option value="telefono" ${type === "telefono" ? "selected" : ""}>Teléfono</option>
                    <option value="correo" ${type === "correo" ? "selected" : ""}>Correo</option>
                </select>
            </div>

            <div class="col-md-6">
                <input type="text" name="contacts[][value]" class="form-control" value="${value}" required>
            </div>

            <div class="col-md-2">
                <button type="button" class="btn btn-danger btn-sm btn-remove-contact">
                    <i class="fas fa-trash"></i>
                </button>
            </div>
        `;

        div.querySelector(".btn-remove-contact").addEventListener("click", () => div.remove());
        contactsContainer.appendChild(div);
    }

    document.getElementById("btnAddContact").addEventListener("click", () => {
        addContactField();
    });
});
</script>

<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app-menu', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\xampp\htdocs\colegio-app\resources\views/employees/create.blade.php ENDPATH**/ ?>