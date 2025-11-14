@extends('layouts.app-menu')

@section('title', 'Estudiantes - Sistema Escolar')

@section('content-principal')
    <div class="d-flex justify-content-between align-items-center welcome-header">
        <div>
            <h1>Estudiantes</h1>
            <p>Gestiona el registro de estudiantes</p>
        </div>
        @if(in_array('create', $permissions))
            <button class="btn btn-primary" id="btnNewStudent" title="Agregar estudiante">
                <i class="fas fa-plus me-2"></i>Nuevo Estudiante
            </button>
        @endif
    </div>

    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show">
            <i class="fas fa-check-circle me-2"></i>{{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif

    <!-- Tabla de Estudiantes -->
    <div class="section-card">
        <div class="card-body">
            @if($students->count() > 0)
                <div class="table-responsive">
                    <table class="table">
                        <thead>
                            <tr>
                                <th>Nombre</th>
                                <th>Documento</th>
                                <th>Grado</th>
                                <th>Acudiente</th>
                                <th>Email</th>
                                @if(in_array('edit', $permissions) || in_array('delete', $permissions))
                                    <th>Acciones</th>
                                @endif
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($students as $student)
                                <tr>
                                    <td><strong>{{ $student->first_name }} {{ $student->last_name }}</strong></td>
                                    <td>{{ $student->document ?? '—' }}</td>
                                    <td>
                                        <span class="badge bg-light text-dark">{{ $student->grade }}</span>
                                    </td>
                                    <td>{{ $student->guardian->full_name ?? 'Sin asignar' }}</td>
                                    <td>{{ $student->institutional_email }}</td>
                                    @if(in_array('edit', $permissions) || in_array('delete', $permissions))
                                        <td>
                                            <div class="btn-group btn-group-sm" role="group">
                                                @if(in_array('edit', $permissions))
                                                    <button class="btn btn-outline-primary btn-edit" data-id="{{ $student->id }}" title="Editar">
                                                        <i class="fas fa-edit"></i>
                                                    </button>
                                                @endif
                                                @if(in_array('delete', $permissions))
                                                    <button class="btn btn-outline-danger btn-delete" data-id="{{ $student->id }}" title="Eliminar">
                                                        <i class="fas fa-trash"></i>
                                                    </button>
                                                @endif
                                            </div>
                                        </td>
                                    @endif
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            @else
                <div class="text-center py-5">
                    <i class="fas fa-inbox fa-3x text-muted mb-3" style="display: block;"></i>
                    <p class="text-muted">No hay estudiantes registrados aún</p>
                    @if(in_array('create', $permissions))
                        <small class="text-muted">¡Crea el primero ahora!</small>
                    @endif
                </div>
            @endif
        </div>
    </div>

    <!-- Modal Crear/Editar -->
    <div class="modal fade" id="modalStudent" tabindex="-1">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header border-0">
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
                                    @foreach(\App\Models\Grade::where('estado', true)->get() as $grade)
                                        <option value="{{ $grade->nombre_grado }}">{{ $grade->nombre_grado }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label class="form-label">Acudiente</label>
                                <select id="guardian_id" class="form-control">
                                    <option value="">Sin asignar</option>
                                    @foreach($guardians as $g)
                                        <option value="{{ $g->id }}">{{ $g->full_name }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                    </form>
                </div>
                <div class="modal-footer border-0">
                    <button class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                    <button class="btn btn-primary" id="btnSaveStudent">Guardar</button>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script>
        document.addEventListener("DOMContentLoaded", () => {
            const modal = new bootstrap.Modal(document.getElementById('modalStudent'));

            function resetForm() {
                document.getElementById('formStudent').reset();
                document.getElementById('student_id').value = '';
            }

            document.getElementById('btnNewStudent')?.addEventListener('click', () => {
                resetForm();
                document.getElementById('studentModalTitle').innerText = 'Nuevo Estudiante';
                modal.show();
            });

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
                    document.getElementById('birth_date').value = data.birth_date || '';
                    document.getElementById('document').value = data.document || '';
                    document.getElementById('grade').value = data.grade;
                    document.getElementById('guardian_id').value = data.guardian_id || '';
                    modal.show();
                });
            });

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
