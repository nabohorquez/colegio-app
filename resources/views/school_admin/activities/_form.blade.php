@csrf
<div class="mb-3">
    <label for="title" class="form-label">Título:</label>
    <input type="text" name="title" id="title" value="{{ old('title', $activity->title ?? '') }}" class="form-control @error('title') is-invalid @enderror" required>
    @error('title')
        <div class="invalid-feedback">{{ $message }}</div>
    @enderror
</div>

<div class="mb-3">
    <label for="description" class="form-label">Descripción:</label>
    <textarea name="description" id="description" rows="5" class="form-control @error('description') is-invalid @enderror">{{ old('description', $activity->description ?? '') }}</textarea>
    @error('description')
        <div class="invalid-feedback">{{ $message }}</div>
    @enderror
</div>

<div class="d-flex gap-2">
    <button type="submit" class="btn btn-primary">
        <i class="fas fa-save"></i> Guardar Actividad
    </button>
    <a href="{{ route('school.activities.index') }}" class="btn btn-secondary">
        <i class="fas fa-times"></i> Cancelar
    </a>
</div>
