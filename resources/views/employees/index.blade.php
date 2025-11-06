@extends('layouts.app-menu')

@section('title', 'Empleados - AcademicSoftware')

@section('content-principal')
    <div class="container mt-5">
        <h2 class="mb-4">Lista de Empleados</h2>
        <table class="table table-bordered" id="employeesTable">
            <thead>
                <tr>
                    @if(in_array('edit', $permissions) || in_array('delete', $permissions))
                        <th>Acciones</th>
                    @endif
                    <th>Nombre</th>
                    <th>Correo</th>
                    <th>Usuario</th>
                    <th>Género</th>
                    <th>Estado Civil</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($employees as $employee)
                    <tr>
                        @if(in_array('edit', $permissions) || in_array('delete', $permissions))
                            <td class="d-flex justify-content-center">
                                @if(in_array('edit', $permissions))
                                    <button
                                        class="btn btn-sm btn-warning me-2 btn-edit"
                                        title="Editar"
                                        data-id="{{ $employee->id }}"
                                    >
                                        <i class="fas fa-edit"></i>
                                    </button>
                                @endif
                                @if(in_array('delete', $permissions))
                                    <button
                                        data-id="{{ $employee->id }}"
                                        class="btn btn-sm btn-danger btn-delete"
                                        title="Eliminar"
                                    >
                                        <i class="fas fa-trash-alt"></i>
                                    </button>
                                @endif
                            </td>
                        @endif
                        <td>{{ $employee->user->full_name ?? $employee->user->name }}</td>
                        <td>{{ $employee->user->email }}</td>
                        <td>{{ $employee->user->username }}</td>
                        <td>{{ $employee->gender }}</td>
                        <td>{{ $employee->marital_status }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>

    @if(in_array('create', $permissions))
        <a href="{{ route('employees.viewCreate') }}"
            class="btn btn-primary position-fixed rounded-circle"
            style="bottom: 20px; right: 20px;"
            title="Adicionar"
        >
            <i class="fas fa-plus h1 m-0 my-1"></i>
        </a>
    @endif


    <!-- ✅ MODAL EDITAR EMPLEADO (ÚNICO Y FUNCIONAL) -->
    <div class="modal fade" id="modalEditEmployee" tabindex="-1">
        <div class="modal-dialog modal-lg modal-dialog-scrollable">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Editar Empleado</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>

                <div class="modal-body">
                    <form id="formEditEmployee">
                        <input type="hidden" id="edit_employee_id">

                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label class="form-label">Nombre</label>
                                <input type="text" id="edit_first_name" class="form-control" required>
                            </div>

                            <div class="col-md-6 mb-3">
                                <label class="form-label">Apellido</label>
                                <input type="text" id="edit_last_name" class="form-control" required>
                            </div>

                            <div class="col-md-6 mb-3">
                                <label class="form-label">Correo</label>
                                <input type="email" id="edit_email" class="form-control" required>
                            </div>

                            <div class="col-md-6 mb-3">
                                <label class="form-label">Usuario</label>
                                <input type="text" id="edit_username" class="form-control" required>
                            </div>

                            <div class="col-md-6 mb-3">
                                <label class="form-label">Género</label>
                                <select id="edit_gender" class="form-control" required>
                                    <option value="F">Femenino</option>
                                    <option value="M">Masculino</option>
                                    <option value="X">Otro</option>
                                </select>
                            </div>

                            <div class="col-md-6 mb-3">
                                <label class="form-label">Estado Civil</label>
                                <select id="edit_marital_status" class="form-control" required>
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
                        <div id="edit_contacts_container"></div>

                        <button type="button" id="btnAddContactEdit" class="btn btn-secondary btn-sm mt-2">
                            <i class="fas fa-plus"></i> Agregar contacto
                        </button>

                    </form>
                </div>

                <div class="modal-footer">
                    <button class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                    <button class="btn btn-primary" id="btnSaveEdit">Guardar cambios</button>
                </div>
            </div>
        </div>
    </div>


    <!-- ✅ SweetAlert2 -->
    <script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <!-- ✅ SCRIPT FUNCIONAL (SIN DUPLICADOS) -->
    <script>
    document.addEventListener("DOMContentLoaded", () => {

        const modal = new bootstrap.Modal(document.getElementById('modalEditEmployee'));
        const contactsContainer = document.getElementById('edit_contacts_container');

        // ✅ CLICK BOTÓN EDITAR
        document.querySelectorAll(".btn-edit").forEach(btn => {
            btn.addEventListener("click", async (e) => {
                const id = e.currentTarget.getAttribute("data-id");
                loadEmployee(id);
            });
        });
        // ✅ CLICK BOTÓN ELIMINAR
document.querySelectorAll(".btn-delete").forEach(btn => {
    btn.addEventListener("click", () => {
        const id = btn.getAttribute("data-id");

        Swal.fire({
            title: '¿Eliminar empleado?',
            text: "Esta acción no se puede deshacer",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonText: 'Sí, eliminar',
            cancelButtonText: 'Cancelar'
        }).then(async (result) => {
            if (result.isConfirmed) {
                const response = await fetch(`/employees/${id}`, {
                    method: "DELETE",
                    headers: {
                        "X-CSRF-TOKEN": document.querySelector('meta[name="csrf-token"]').getAttribute("content")
                    }
                });

                const data = await response.json();

                if (response.ok) {
                    Swal.fire('Eliminado', data.message, 'success')
                        .then(() => location.reload());
                } else {
                    Swal.fire('Error', data.message, 'error');
                }
            }
        });
    });
});
        // ✅ CARGAR DATOS EN MODAL
        async function loadEmployee(id) {
            try {
                const response = await fetch(`/employees/${id}`);
                if (!response.ok) throw await response.json();

                const data = await response.json();

                document.getElementById('edit_employee_id').value = data.employee.id;
                document.getElementById('edit_first_name').value = data.user.first_name ?? '';
                document.getElementById('edit_last_name').value = data.user.last_name ?? '';
                document.getElementById('edit_email').value = data.user.email ?? '';
                document.getElementById('edit_username').value = data.user.username ?? '';
                document.getElementById('edit_gender').value = data.employee.gender ?? '';
                document.getElementById('edit_marital_status').value = data.employee.marital_status ?? '';

                // ✅ LIMPIAR CONTACTOS
                contactsContainer.innerHTML = '';
                data.contacts.forEach(c => addContactField(c.type, c.value));

                modal.show();
            } catch (err) {
                Swal.fire('Error', 'No se pudo cargar el empleado', 'error');
            }
        }

        // ✅ AGREGAR CONTACTO DINÁMICO
        document.getElementById("btnAddContactEdit").addEventListener("click", () => {
            addContactField();
        });

        function addContactField(type = '', value = '') {
            const div = document.createElement('div');
            div.classList.add('row', 'mb-2', 'contact-row');

            div.innerHTML = `
                <div class="col-md-4">
                    <select class="form-control contact-type">
                        <option value="telefono" ${type === 'telefono' ? 'selected' : ''}>Teléfono</option>
                        <option value="correo" ${type === 'correo' ? 'selected' : ''}>Correo</option>
                    </select>
                </div>
                <div class="col-md-6">
                    <input type="text" class="form-control contact-value" value="${value}" required>
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

        // ✅ GUARDAR CAMBIOS
        document.getElementById("btnSaveEdit").addEventListener("click", async () => {

            const id = document.getElementById('edit_employee_id').value;

            const contacts = [];
            document.querySelectorAll(".contact-row").forEach(row => {
                contacts.push({
                    type: row.querySelector(".contact-type").value,
                    value: row.querySelector(".contact-value").value
                });
            });

            const payload = {
                first_name: document.getElementById('edit_first_name').value,
                last_name: document.getElementById('edit_last_name').value,
                email: document.getElementById('edit_email').value,
                username: document.getElementById('edit_username').value,
                gender: document.getElementById('edit_gender').value,
                marital_status: document.getElementById('edit_marital_status').value,
                contacts
            };

            try {
                const response = await fetch(`/employees/${id}`, {
                    method: "PUT",
                    headers: {
                        "Content-Type": "application/json",
                        "X-CSRF-TOKEN": document.querySelector('meta[name="csrf-token"]').getAttribute("content")
                    },
                    body: JSON.stringify(payload)
                });

                if (!response.ok) {
                    const err = await response.json();
                    throw err;
                }

                Swal.fire({
                    icon: 'success',
                    title: 'Actualizado correctamente',
                    timer: 1500,
                    showConfirmButton: false
                }).then(() => location.reload());

            } catch (err) {
                let msg = err.message ?? 'Error al actualizar';
                Swal.fire('Error', msg, 'error');
            }
        });

    });
    </script>
@endsection
