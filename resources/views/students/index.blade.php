@extends('layouts.app-menu')

@section('title', 'Estudiantes - AcademicSoftware')

@section('content-principal')
<div class="container mt-5">
    <h2 class="mb-4">Lista de Estudiantes</h2>

    <table class="table table-bordered" id="studentsTable">
        <thead class="table-light">
            <tr>
                @if(in_array('edit', $permissions) || in_array('delete', $permissions))
                    <th>Acciones</th>
                @endif
                <th>Nombre</th>
                <th>Grado</th>
                <th>Documento</th>
                <th>Correo Institucional</th>
                <th>Acudiente</th>
            </tr>
        </thead>
        <tbody>
            @foreach($students as $student)
                <tr>
                    @if(in_array('edit', $permissions) || in_array('delete', $permissions))
                        <td class="d-flex justify-content-center">
                            <a href="{{ route('school.grades.student', $student->id) }}" 
                               class="btn btn-sm btn-info me-2" title="Ver Calificaciones">
                                <i class="fas fa-chart-bar"></i>
                            </a>
                            @if(in_array('edit', $permissions))
                                <button class="btn btn-sm btn-warning me-2 btn-edit"
                                    data-id="{{ $student->id }}" title="Editar">
                                    <i class="fas fa-edit"></i>
                                </button>
                            @endif
                            @if(in_array('delete', $permissions))
                                <button class="btn btn-sm btn-danger btn-delete"
                                    data-id="{{ $student->id }}" title="Eliminar">
                                    <i class="fas fa-trash-alt"></i>
                                </button>
                            @endif
                        </td>
                    @endif
                    <td>{{ $student->full_name }}</td>
                    <td>{{ $student->grade }}</td>
                    <td>{{ $student->document ?? '—' }}</td>
                    <td>{{ $student->institutional_email }}</td>
                    <td>{{ $student->guardian->full_name ?? 'Sin asignar' }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>
</div>

@if(in_array('create', $permissions))
    <button class="btn btn-primary position-fixed rounded-circle"
        style="bottom: 20px; right: 20px;" id="btnNewStudent" title="Adicionar">
        <i class="fas fa-plus h1 m-0 my-1"></i>
    </button>
@endif


<!-- ✅ MODAL CREAR / EDITAR -->
<div class="modal fade" id="modalStudent" tabindex="-1">
    <div class="modal-dialog modal-lg modal-dialog-scrollable">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="studentModalTitle">Nuevo Estudiante</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>

            <div class="modal-body">
                <form id="formStudent">
                    <input type="hidden" id="student_id">

                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Nombre</label>
                            <input type="text" id="first_name" class="form-control" required>
                        </div>

                        <div class="col-md-6 mb-3">
                            <label class="form-label">Apellido</label>
                            <input type="text" id="last_name" class="form-control" required>
                        </div>

                        <div class="col-md-4 mb-3">
                            <label class="form-label">Fecha de Nacimiento</label>
                            <input type="date" id="birth_date" class="form-control">
                        </div>

                        <div class="col-md-4 mb-3">
                            <label class="form-label">Documento</label>
                            <input type="number" id="document" class="form-control">
                        </div>

                        <div class="col-md-4 mb-3">
    <label class="form-label">Grado</label>
    <select id="grade" class="form-control" required>
        <option value="">Seleccione...</option>
        @foreach([6,7,8,9,10,11] as $g)
            <option value="{{ $g }}A">{{ $g }}A</option>
            <option value="{{ $g }}B">{{ $g }}B</option>
            <option value="{{ $g }}C">{{ $g }}C</option>
        @endforeach
    </select>
</div>


                        <div class="col-md-6 mb-3">
                            <label class="form-label">Acudiente</label>
                            <select id="guardian_id" class="form-control">
                                <option value="">-- Sin asignar --</option>
                                @foreach($guardians as $g)
                                    <option value="{{ $g->id }}">{{ $g->full_name }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>

                </form>
            </div>

            <div class="modal-footer">
                <button class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                <button class="btn btn-primary" id="btnSaveStudent">Guardar</button>
            </div>
        </div>
    </div>
</div>


<script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<script>
document.addEventListener("DOMContentLoaded", () => {
    const modal = new bootstrap.Modal(document.getElementById('modalStudent'));

    function resetForm() {
        document.getElementById('formStudent').reset();
        document.getElementById('student_id').value = '';
    }

    // ✅ Abrir modal crear
    document.getElementById('btnNewStudent')?.addEventListener('click', () => {
        resetForm();
        document.getElementById('studentModalTitle').innerText = 'Nuevo Estudiante';
        modal.show();
    });

    // ✅ Editar estudiante
    document.querySelectorAll('.btn-edit').forEach(btn => {
        btn.addEventListener('click', async () => {
            resetForm();
            const id = btn.dataset.id;
            document.getElementById('studentModalTitle').innerText = 'Editar Estudiante';

            const res = await fetch(`/students/${id}`);
            const data = await res.json();

            document.getElementById('student_id').value = data.id;
            document.getElementById('first_name').value = data.first_name;
            document.getElementById('last_name').value = data.last_name;
            document.getElementById('birth_date').value = data.birth_date ?? '';
            document.getElementById('document').value = data.document ?? '';
            document.getElementById('grade').value = data.grade;
            document.getElementById('guardian_id').value = data.guardian_id ?? '';

            modal.show();
        });
    });

    // ✅ Guardar estudiante (crear / editar)
    document.getElementById('btnSaveStudent').addEventListener('click', async () => {
        const id = document.getElementById('student_id').value;
        const method = id ? 'PUT' : 'POST';
        const url = id ? `/students/${id}` : `/students`;

        const payload = {
            first_name: document.getElementById('first_name').value,
            last_name: document.getElementById('last_name').value,
            birth_date: document.getElementById('birth_date').value,
            document: document.getElementById('document').value,
            grade: document.getElementById('grade').value,
            guardian_id: document.getElementById('guardian_id').value,
        };

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
            Swal.fire('Éxito', result.message, 'success').then(() => location.reload());
        } else {
            Swal.fire('Error', result.message, 'error');
        }
    });

    // ✅ Eliminar estudiante
    document.querySelectorAll('.btn-delete').forEach(btn => {
        btn.addEventListener('click', async () => {
            const id = btn.dataset.id;
            const confirm = await Swal.fire({
                title: '¿Eliminar estudiante?',
                text: 'Esta acción no se puede deshacer',
                icon: 'warning',
                showCancelButton: true,
                confirmButtonText: 'Sí, eliminar',
                cancelButtonText: 'Cancelar'
            });
            if (!confirm.isConfirmed) return;

            const res = await fetch(`/students/${id}`, {
                method: 'DELETE',
                headers: {
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
                }
            });

            const result = await res.json();
            if (res.ok) {
                Swal.fire('Eliminado', result.message, 'success').then(() => location.reload());
            } else {
                Swal.fire('Error', result.message, 'error');
            }
        });
    });
});
</script>

@endsection
