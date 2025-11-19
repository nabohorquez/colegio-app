@csrf
<div class="row">
    <div class="col-md-6 mb-3">
        <label for="student_id" class="form-label">Estudiante <span class="text-danger">*</span></label>
        <select name="student_id" id="student_id" class="form-control @error('student_id') is-invalid @enderror" required>
            <option value="">-- Selecciona un estudiante --</option>
            @foreach($students as $student)
                <option value="{{ $student->id }}" 
                    {{ old('student_id', $grade->student_id ?? $selectedStudent ?? '') == $student->id ? 'selected' : '' }}>
                    {{ $student->full_name }} (Grado: {{ $student->grade }})
                </option>
            @endforeach
        </select>
        @error('student_id')
            <div class="invalid-feedback">{{ $message }}</div>
        @enderror
    </div>

    <div class="col-md-6 mb-3">
        <label for="subject_id" class="form-label">Asignatura <span class="text-danger">*</span></label>
        <select name="subject_id" id="subject_id" class="form-control @error('subject_id') is-invalid @enderror" required>
            <option value="">-- Selecciona una asignatura --</option>
            @foreach($subjects as $subject)
                <option value="{{ $subject->id }}" {{ old('subject_id', $grade->subject_id ?? '') == $subject->id ? 'selected' : '' }}>
                    {{ $subject->nombre_materia }}
                </option>
            @endforeach
        </select>
        @error('subject_id')
            <div class="invalid-feedback">{{ $message }}</div>
        @enderror
    </div>
</div>

<div class="card mb-4">
    <div class="card-header bg-light">
        <h6 class="mb-0">Calificaciones (Escala 0-5)</h6>
    </div>
    <div class="card-body">
        <div class="row">
            <div class="col-md-4 mb-3">
                <label for="partial_1" class="form-label">Calificación 1er Parcial</label>
                <input type="number" name="partial_1" id="partial_1" step="0.1" min="0" max="5" 
                    value="{{ old('partial_1', $grade->partial_1 ?? '') }}" 
                    class="form-control @error('partial_1') is-invalid @enderror"
                    placeholder="0.0">
                @error('partial_1')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <div class="col-md-4 mb-3">
                <label for="partial_2" class="form-label">Calificación 2do Parcial</label>
                <input type="number" name="partial_2" id="partial_2" step="0.1" min="0" max="5" 
                    value="{{ old('partial_2', $grade->partial_2 ?? '') }}" 
                    class="form-control @error('partial_2') is-invalid @enderror"
                    placeholder="0.0">
                @error('partial_2')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <div class="col-md-4 mb-3">
                <label for="final_grade" class="form-label">Calificación Final</label>
                <input type="number" name="final_grade" id="final_grade" step="0.1" min="0" max="5" 
                    value="{{ old('final_grade', $grade->final_grade ?? '') }}" 
                    class="form-control @error('final_grade') is-invalid @enderror"
                    placeholder="0.0">
                @error('final_grade')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>
        </div>
    </div>
</div>

<div class="mb-3">
    <label for="observations" class="form-label">Observaciones/Comentarios</label>
    <textarea name="observations" id="observations" rows="4" class="form-control @error('observations') is-invalid @enderror"
        placeholder="Agrega notas o observaciones adicionales sobre el desempeño del estudiante">{{ old('observations', $grade->observations ?? '') }}</textarea>
    @error('observations')
        <div class="invalid-feedback">{{ $message }}</div>
    @enderror
</div>

<div class="d-flex gap-2">
    <button type="submit" class="btn btn-primary">
        <i class="fas fa-save"></i> Guardar Calificación
    </button>
    <a href="{{ route('student-grades.index') }}" class="btn btn-secondary">
        <i class="fas fa-times"></i> Cancelar
    </a>
</div>
