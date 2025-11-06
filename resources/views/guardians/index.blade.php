@extends('layouts.app-menu')

@section('title', 'Acudientes - AcademicSoftware')

@section('content-principal')
<div class="container mt-5">
    <h2 class="mb-4">Lista de Acudientes</h2>
    <table class="table table-bordered" id="guardiansTable">
        <thead>
        <tr>
            @if(in_array('edit', $permissions) || in_array('delete', $permissions))
                <th>Acciones</th>
            @endif
            <th>Nombre</th>
            <th>Correo</th>
            <th>Género</th>
            <th>Estado Civil</th>
            <th class="text-center" style="width: 120px;">Estudiantes</th>
        </tr>
        </thead>
        <tbody>
        @foreach ($guardians as $guardian)
            <tr>
                @if(in_array('edit', $permissions) || in_array('delete', $permissions))
                    <td class="d-flex justify-content-center">
                        @if(in_array('edit', $permissions))
                            <button
                                class="btn btn-sm btn-warning me-2 btn-edit"
                                title="Editar"
                                data-id="{{ $guardian->id }}">
                                <i class="fas fa-edit"></i>
                            </button>
                        @endif
                        @if(in_array('delete', $permissions))
                            <button
                                class="btn btn-sm btn-danger btn-delete"
                                title="Eliminar"
                                data-id="{{ $guardian->id }}">
                                <i class="fas fa-trash-alt"></i>
                            </button>
                        @endif
                    </td>
                @endif

                <td>{{ $guardian->first_name }} {{ $guardian->last_name }}</td>
                <td>{{ $guardian->email }}</td>
                <td>{{ $guardian->gender }}</td>
                <td>{{ $guardian->marital_status }}</td>

                {{-- Badge centrado; clickeable si > 0 --}}
                <td class="text-center">
                    @php $count = $guardian->students->count(); @endphp
                    @if($count > 0)
                        <button
                            class="btn btn-link p-0 badge-button"
                            data-id="{{ $guardian->id }}"
                            title="Ver estudiantes">
                            <span class="badge rounded-pill bg-primary">{{ $count }}</span>
                        </button>
                    @else
                        <span class="badge rounded-pill bg-secondary">0</span>
                    @endif
                </td>
            </tr>
        @endforeach
        </tbody>
    </table>
</div>

@if(in_array('create', $permissions))
    <button
        class="btn btn-primary position-fixed rounded-circle"
        style="bottom: 20px; right: 20px;"
        id="btnNewGuardian"
        title="Adicionar">
        <i class="fas fa-plus h1 m-0 my-1"></i>
    </button>
@endif

<!-- ✅ MODAL REUTILIZABLE (CREAR / EDITAR) -->
<div class="modal fade" id="modalGuardian" tabindex="-1">
    <div class="modal-dialog modal-lg modal-dialog-scrollable">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="guardianModalTitle">Nuevo Acudiente</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>

            <div class="modal-body">
                <form id="formGuardian">
                    <input type="hidden" id="guardian_id">

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
                            <label class="form-label">Correo</label>
                            <input type="email" id="email" class="form-control" required>
                        </div>

                        <div class="col-md-6 mb-3">
                            <label class="form-label">Género</label>
                            <select id="gender" class="form-control">
                                <option value="">Seleccione</option>
                                <option value="F">Femenino</option>
                                <option value="M">Masculino</option>
                                <option value="X">Otro</option>
                            </select>
                        </div>

                        <div class="col-md-6 mb-3">
                            <label class="form-label">Estado Civil</label>
                            <select id="marital_status" class="form-control">
                                <option value="">Seleccione</option>
                                <option value="Soltero">Soltero</option>
                                <option value="Casado">Casado</option>
                                <option value="Divorciado">Divorciado</option>
                                <option value="Unión Libre">Unión Libre</option>
                                <option value="Viudo">Viudo</option>
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
                    <h5>Asignar Estudiantes</h5>

                    <!-- Select2 para búsqueda -->
                    <div class="mb-3">
                        <select id="studentSelector" style="width:100%"></select>
                    </div>

                    <!-- Contenedor de estudiantes seleccionados -->
                    <div id="selected_students_container"></div>
                </form>
            </div>

            <div class="modal-footer">
                <button class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                <button class="btn btn-primary" id="btnSaveGuardian">Guardar</button>
            </div>
        </div>
    </div>
</div>

<!-- ✅ MODAL DETALLE DE ESTUDIANTES (por badge) -->
<div class="modal fade" id="modalGuardianStudents" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Estudiantes asignados</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <ul class="list-group" id="students_detail_list"></ul>
            </div>
        </div>
    </div>
</div>

{{-- SweetAlert2 --}}
<script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>
{{-- jQuery (requerido por Select2) --}}
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
{{-- Select2 --}}
<link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet"/>
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>

<script>
document.addEventListener("DOMContentLoaded", () => {
    const modal = new bootstrap.Modal(document.getElementById('modalGuardian'));
    const modalStudents = new bootstrap.Modal(document.getElementById('modalGuardianStudents'));
    const contactsContainer = document.getElementById('contacts_container');
    const selectedStudentsContainer = document.getElementById('selected_students_container');

    // =======================
    // Helpers
    // =======================
    function resetForm() {
        document.getElementById('formGuardian').reset();
        document.getElementById('guardian_id').value = '';
        contactsContainer.innerHTML = '';
        selectedStudentsContainer.innerHTML = '';
        // Limpia Select2
        $('#studentSelector').val(null).trigger('change');
    }

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
                <input type="text" class="form-control contact-value" value="${value}">
            </div>
            <div class="col-md-2">
                <button type="button" class="btn btn-danger btn-sm btn-remove-contact"><i class="fas fa-trash"></i></button>
            </div>`;
        div.querySelector('.btn-remove-contact').addEventListener('click', () => div.remove());
        contactsContainer.appendChild(div);
    }

    function studentRow({ id, full_name, relationship = '' }) {
        const row = document.createElement('div');
        row.classList.add('row', 'align-items-center', 'mb-2', 'student-selected-row');
        row.dataset.studentId = id;

        row.innerHTML = `
            <div class="col-md-6">
                <input type="hidden" class="student-id" value="${id}">
                <span class="fw-semibold">${full_name}</span>
            </div>
            <div class="col-md-4">
                <select class="form-control student-relationship" required>
                    <option value="">Parentesco...</option>
                    <option value="Padre" ${relationship === 'Padre' ? 'selected' : ''}>Padre</option>
                    <option value="Madre" ${relationship === 'Madre' ? 'selected' : ''}>Madre</option>
                    <option value="Otro" ${relationship === 'Otro' ? 'selected' : ''}>Otro</option>
                </select>
            </div>
            <div class="col-md-2 text-end">
                <button type="button" class="btn btn-outline-danger btn-sm btn-remove-student">
                    <i class="fas fa-times"></i>
                </button>
            </div>
        `;
        row.querySelector('.btn-remove-student').addEventListener('click', () => row.remove());
        return row;
    }

    function alreadySelected(studentId) {
        return !!selectedStudentsContainer.querySelector(`.student-selected-row[data-student-id="${studentId}"]`);
    }

    // =======================
    // Select2 (carga de estudiantes)
    // =======================
    // Lista global desde Blade (id, first_name, last_name, document, grade)
    @php
        $studentsArray = [];
        foreach ($students as $s) {
            $studentsArray[] = [
                'id' => $s->id,
                'full_name' => trim(($s->first_name ?? '') . ' ' . ($s->last_name ?? '')),
                'document' => $s->document,
                'grade' => $s->grade
            ];
        }
    @endphp
    const studentsData = @json($studentsArray);

    $('#studentSelector').select2({
        placeholder: 'Buscar estudiante...',
        allowClear: true,
        data: studentsData.map(s => ({
            id: s.id,
            text: `${s.full_name}${s.document ? ' · ' + s.document : ''}${s.grade ? ' · ' + s.grade : ''}`
        }))
    });

    // Al seleccionar un estudiante => agregar fila si no está
    $('#studentSelector').on('select2:select', function (e) {
        const id = e.params.data.id;
        const data = studentsData.find(s => String(s.id) === String(id));
        if (!data) return;

        if (alreadySelected(id)) {
            // ya está, solo limpiar selector
            $('#studentSelector').val(null).trigger('change');
            return;
        }
        selectedStudentsContainer.appendChild(studentRow({ id: data.id, full_name: data.full_name }));
        // limpia el select
        $('#studentSelector').val(null).trigger('change');
    });

    // =======================
    // Abrir modal: Nuevo
    // =======================
    document.getElementById('btnNewGuardian')?.addEventListener('click', () => {
        resetForm();
        document.getElementById('guardianModalTitle').innerText = 'Nuevo Acudiente';
        modal.show();
    });

    // =======================
    // Editar acudiente (cargar datos)
    // =======================
    document.querySelectorAll('.btn-edit').forEach(btn => {
        btn.addEventListener('click', async () => {
            try {
                resetForm();
                const id = btn.dataset.id;
                document.getElementById('guardianModalTitle').innerText = 'Editar Acudiente';

                const res = await fetch(`/guardians/${id}`);
                if (!res.ok) throw await res.json();
                const data = await res.json();

                const g = data.guardian;
                document.getElementById('guardian_id').value = g.id;
                document.getElementById('first_name').value = g.first_name ?? '';
                document.getElementById('last_name').value = g.last_name ?? '';
                document.getElementById('email').value = g.email ?? '';
                document.getElementById('gender').value = g.gender ?? '';
                document.getElementById('marital_status').value = g.marital_status ?? '';

                // contactos
                contactsContainer.innerHTML = '';
                (data.contacts || []).forEach(c => addContactField(c.type, c.value));

                // estudiantes (precargar)
                selectedStudentsContainer.innerHTML = '';
                (data.students || []).forEach(s => {
                    const rel = s.relationship || ''; // si tu controlador devuelve relationship
                    selectedStudentsContainer.appendChild(studentRow({
                        id: s.id,
                        full_name: s.full_name,
                        relationship: rel
                    }));
                });

                modal.show();
            } catch (err) {
                Swal.fire('Error', 'No se pudo cargar el acudiente', 'error');
            }
        });
    });

    // =======================
    // Ver detalle de estudiantes (badge)
    // =======================
    document.querySelectorAll('.badge-button').forEach(b => {
        b.addEventListener('click', async () => {
            try {
                const id = b.dataset.id;
                const res = await fetch(`/guardians/${id}`);
                const data = await res.json();

                const list = document.getElementById('students_detail_list');
                list.innerHTML = '';

                (data.students || []).forEach(s => {
                    const li = document.createElement('li');
                    li.className = 'list-group-item';
                    const parts = [
                        s.full_name || '',
                        s.document ? `Doc: ${s.document}` : null,
                        s.grade ? `Grado: ${s.grade}` : null
                    ].filter(Boolean);
                    li.textContent = parts.join('  |  ');
                    list.appendChild(li);
                });

                modalStudents.show();
            } catch {
                Swal.fire('Error', 'No se pudo cargar el detalle', 'error');
            }
        });
    });

    // =======================
    // Guardar (crear/editar)
    // =======================
    document.getElementById('btnSaveGuardian').addEventListener('click', async () => {
        const id = document.getElementById('guardian_id').value;
        const method = id ? 'PUT' : 'POST';
        const url = id ? `/guardians/${id}` : `/guardians`;

        // build contactos
        const contacts = [];
        document.querySelectorAll('.contact-row').forEach(row => {
            contacts.push({
                type: row.querySelector('.contact-type').value,
                value: row.querySelector('.contact-value').value
            });
        });

        // build estudiantes (ids + relationship)
        const students = [];
        selectedStudentsContainer.querySelectorAll('.student-selected-row').forEach(row => {
            const sid = row.querySelector('.student-id').value;
            const rel = row.querySelector('.student-relationship').value;
            if (sid) students.push({ id: Number(sid), relationship: rel || null });
        });

        const payload = {
            first_name: document.getElementById('first_name').value,
            last_name: document.getElementById('last_name').value,
            email: document.getElementById('email').value,
            gender: document.getElementById('gender').value,
            marital_status: document.getElementById('marital_status').value,
            contacts,
            // Para 1:N simple del controlador actual, si éste espera solo IDs:
            students: students.map(s => s.id)
            // Si decides guardar relationship en students (columna 'relationship'),
            // ya mandamos también el arreglo completo en 'students' con {id, relationship}
            // y deberás ajustar el controlador para leerlo.
        };

        try {
            const res = await fetch(url, {
                method,
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
                },
                body: JSON.stringify(payload)
            });

            const result = await res.json();
            if (res.ok) {
                Swal.fire({
                    icon: 'success',
                    title: result.message || 'Guardado',
                    timer: 1500,
                    showConfirmButton: false
                }).then(() => location.reload());
            } else {
                Swal.fire('Error', result.message || 'Error al guardar', 'error');
            }
        } catch (e) {
            Swal.fire('Error', 'No se pudo guardar', 'error');
        }
    });

    // =======================
    // Eliminar
    // =======================
    document.querySelectorAll('.btn-delete').forEach(btn => {
        btn.addEventListener('click', async () => {
            const id = btn.dataset.id;
            const confirm = await Swal.fire({
                title: '¿Eliminar acudiente?',
                text: 'Esta acción no se puede deshacer',
                icon: 'warning',
                showCancelButton: true,
                confirmButtonText: 'Sí, eliminar',
                cancelButtonText: 'Cancelar'
            });
            if (!confirm.isConfirmed) return;

            try {
                const res = await fetch(`/guardians/${id}`, {
                    method: 'DELETE',
                    headers: {
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
                    }
                });
                const result = await res.json();
                if (res.ok) {
                    Swal.fire('Eliminado', result.message || 'Acudiente eliminado', 'success')
                        .then(() => location.reload());
                } else {
                    Swal.fire('Error', result.message || 'No se pudo eliminar', 'error');
                }
            } catch {
                Swal.fire('Error', 'No se pudo eliminar', 'error');
            }
        });
    });

    // =======================
    // Agregar contacto
    // =======================
    document.getElementById('btnAddContact').addEventListener('click', () => addContactField());
});
</script>
@endsection
