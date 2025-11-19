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
        <label for="subject" class="form-label">Asignatura <span class="text-danger">*</span></label>
        <select name="subject" id="subject" class="form-control @error('subject') is-invalid @enderror" required>
            <option value="">-- Selecciona una asignatura --</option>
            @foreach($subjects as $subject)
                <option value="{{ $subject }}" {{ old('subject', $grade->subject ?? '') == $subject ? 'selected' : '' }}>
                    {{ $subject }}
                </option>
            @endforeach
            <option value="" {{ old('subject', $grade->subject ?? '') === '' ? 'selected' : '' }}>-- Otra --</option>
        </select>
        @error('subject')
            <div class="invalid-feedback">{{ $message }}</div>
        @enderror
    </div>
</div>

<div class="row">
    <div class="col-md-6 mb-3">
        <label for="academic_period" class="form-label">Período Académico <span class="text-danger">*</span></label>
        <select name="academic_period" id="academic_period" class="form-control @error('academic_period') is-invalid @enderror" required>
            <option value="">-- Selecciona un período --</option>
            @foreach($academicPeriods as $period)
                <option value="{{ $period }}" {{ old('academic_period', $grade->academic_period ?? '') == $period ? 'selected' : '' }}>
                    {{ $period }}
                </option>
            @endforeach
        </select>
        @error('academic_period')
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
                <label for="first_partial" class="form-label">Calificación 1er Parcial</label>
                <input type="number" name="first_partial" id="first_partial" step="0.01" min="0" max="5" 
                    value="{{ old('first_partial', $grade->first_partial ?? '') }}" 
                    class="form-control @error('first_partial') is-invalid @enderror"
                    placeholder="0.00">
                @error('first_partial')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <div class="col-md-4 mb-3">
                <label for="second_partial" class="form-label">Calificación 2do Parcial</label>
                <input type="number" name="second_partial" id="second_partial" step="0.01" min="0" max="5" 
                    value="{{ old('second_partial', $grade->second_partial ?? '') }}" 
                    class="form-control @error('second_partial') is-invalid @enderror"
                    placeholder="0.00">
                @error('second_partial')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <div class="col-md-4 mb-3">
                <label for="final_grade" class="form-label">Calificación Final</label>
                <input type="number" name="final_grade" id="final_grade" step="0.01" min="0" max="5" 
                    value="{{ old('final_grade', $grade->final_grade ?? '') }}" 
                    class="form-control @error('final_grade') is-invalid @enderror"
                    placeholder="0.00">
                @error('final_grade')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>
        </div>
    </div>
</div>

<div class="mb-3">
    <label for="notes" class="form-label">Observaciones/Comentarios</label>
    <textarea name="notes" id="notes" rows="4" class="form-control @error('notes') is-invalid @enderror"
        placeholder="Agrega notas o observaciones adicionales sobre el desempeño del estudiante">{{ old('notes', $grade->notes ?? '') }}</textarea>
    @error('notes')
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
