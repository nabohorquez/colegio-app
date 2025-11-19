@extends('layouts.app-menu')

@section('title', 'Editar Calificación - Sistema Escolar')

@section('content-principal')
<div class="d-flex justify-content-between align-items-center welcome-header">
    <div>
        <h1>
            <i class="fas fa-edit me-2"></i>Editar Calificación
        </h1>
        <p class="text-secondary">Modifica los datos de la calificación</p>
    </div>
</div>

<div class="section-card">
    <div class="card-body">
        @if($errors->any())
            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                <strong>Errores de validación:</strong>
                <ul class="mb-0 mt-2">
                    @foreach($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        @endif

        <form action="{{ route('student-grades.update', $grade->id) }}" method="POST">
            @csrf
            @method('PUT')

            <div class="row">
                <!-- Estudiante -->
                <div class="col-md-6 mb-3">
                    <label class="form-label" for="student_id">Estudiante <span class="text-danger">*</span></label>
                    <select id="student_id" name="student_id" class="form-control @error('student_id') is-invalid @enderror" required>
                        <option value="">-- Selecciona un estudiante --</option>
                        @foreach($students as $student)
                            <option value="{{ $student->id }}" 
                                @if(old('student_id', $grade->student_id) == $student->id) selected @endif>
                                {{ $student->full_name }} ({{ $student->grade ?? 'N/A' }})
                            </option>
                        @endforeach
                    </select>
                    @error('student_id')<span class="invalid-feedback">{{ $message }}</span>@enderror
                </div>

                <!-- Asignatura -->
                <div class="col-md-6 mb-3">
                    <label class="form-label" for="subject_id">Asignatura <span class="text-danger">*</span></label>
                    <select id="subject_id" name="subject_id" class="form-control @error('subject_id') is-invalid @enderror" required>
                        <option value="">-- Selecciona una asignatura --</option>
                        @foreach($subjects as $subject)
                            <option value="{{ $subject->id }}" 
                                @if(old('subject_id', $grade->subject_id) == $subject->id) selected @endif>
                                {{ $subject->nombre_materia }}
                            </option>
                        @endforeach
                    </select>
                    @error('subject_id')<span class="invalid-feedback">{{ $message }}</span>@enderror
                </div>

                <!-- Parcial 1 -->
                <div class="col-md-4 mb-3">
                    <label class="form-label" for="partial_1">Nota Parcial 1 (0-5)</label>
                    <input type="number" id="partial_1" name="partial_1" class="form-control @error('partial_1') is-invalid @enderror" 
                        step="0.1" min="0" max="5" value="{{ old('partial_1', $grade->partial_1) }}" placeholder="Ej: 4.5">
                    @error('partial_1')<span class="invalid-feedback">{{ $message }}</span>@enderror
                </div>

                <!-- Parcial 2 -->
                <div class="col-md-4 mb-3">
                    <label class="form-label" for="partial_2">Nota Parcial 2 (0-5)</label>
                    <input type="number" id="partial_2" name="partial_2" class="form-control @error('partial_2') is-invalid @enderror" 
                        step="0.1" min="0" max="5" value="{{ old('partial_2', $grade->partial_2) }}" placeholder="Ej: 4.2">
                    @error('partial_2')<span class="invalid-feedback">{{ $message }}</span>@enderror
                </div>

                <!-- Nota Final -->
                <div class="col-md-4 mb-3">
                    <label class="form-label" for="final_grade">Nota Final (0-5)</label>
                    <input type="number" id="final_grade" name="final_grade" class="form-control @error('final_grade') is-invalid @enderror" 
                        step="0.1" min="0" max="5" value="{{ old('final_grade', $grade->final_grade) }}" placeholder="Ej: 4.35">
                    @error('final_grade')<span class="invalid-feedback">{{ $message }}</span>@enderror
                </div>

                <!-- Observaciones -->
                <div class="col-12 mb-3">
                    <label class="form-label" for="observations">Observaciones</label>
                    <textarea id="observations" name="observations" class="form-control @error('observations') is-invalid @enderror" 
                        rows="3" placeholder="Comentarios sobre el desempeño del estudiante" maxlength="500">{{ old('observations', $grade->observations) }}</textarea>
                    <small class="form-text text-secondary">Máximo 500 caracteres</small>
                    @error('observations')<span class="invalid-feedback">{{ $message }}</span>@enderror
                </div>
            </div>

            <!-- Botones -->
            <div class="mt-4">
                <div class="btn-group" role="group">
                    <button type="submit" class="btn btn-primary">
                        <i class="fas fa-save me-2"></i>Actualizar
                    </button>
                    <a href="{{ route('student-grades.index') }}" class="btn btn-secondary">
                        <i class="fas fa-times me-2"></i>Cancelar
                    </a>
                </div>
            </div>
        </form>
    </div>
</div>
@endsection
