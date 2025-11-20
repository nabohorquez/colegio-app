@csrf
<div class="row">
    <div class="col-md-6 mb-3">
        <label for="title" class="form-label">Título <span class="text-danger">*</span></label>
        <input type="text" name="title" id="title" class="form-control @error('title') is-invalid @enderror" value="{{ old('title', $content->title ?? '') }}" required>
        @error('title')
            <div class="invalid-feedback">{{ $message }}</div>
        @enderror
    </div>
    <div class="col-md-6 mb-3">
        <label for="subject_id" class="form-label">Asignatura <span class="text-danger">*</span></label>
        <select name="subject_id" id="subject_id" class="form-control @error('subject_id') is-invalid @enderror" required>
            <option value="">-- Selecciona una asignatura --</option>
            @foreach($subjects as $subject)
                <option value="{{ $subject->id }}" {{ old('subject_id', $content->subject_id ?? '') == $subject->id ? 'selected' : '' }}>{{ $subject->name }}</option>
            @endforeach
        </select>
        @error('subject_id')
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
                <option value="{{ $period }}" {{ old('academic_period', $content->academic_period ?? '') == $period ? 'selected' : '' }}>{{ $period }}</option>
            @endforeach
        </select>
        @error('academic_period')
            <div class="invalid-feedback">{{ $message }}</div>
        @enderror
    </div>
</div>
<div class="mb-3">
    <label for="description" class="form-label">Descripción</label>
    <textarea name="description" id="description" rows="4" class="form-control @error('description') is-invalid @enderror" placeholder="Agrega una descripción o contenido detallado">{{ old('description', $content->description ?? '') }}</textarea>
    @error('description')
        <div class="invalid-feedback">{{ $message }}</div>
    @enderror
</div>
<div class="d-flex gap-2">
    <button type="submit" class="btn btn-primary">
        <i class="fas fa-save"></i> Guardar Contenido
    </button>
    <a href="{{ route('contents.index') }}" class="btn btn-secondary">
        <i class="fas fa-times"></i> Cancelar
    </a>
</div>
