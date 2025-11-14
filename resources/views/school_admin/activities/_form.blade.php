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
    <textarea name="description" id="description" rows="4" class="form-control @error('description') is-invalid @enderror">{{ old('description', $activity->description ?? '') }}</textarea>
    @error('description')
        <div class="invalid-feedback">{{ $message }}</div>
    @enderror
</div>

<div class="mb-3">
    <label for="resource_assignment" class="form-label">Asignación de Recursos:</label>
    <textarea name="resource_assignment" id="resource_assignment" rows="4" class="form-control @error('resource_assignment') is-invalid @enderror" placeholder="Describe los recursos necesarios para la actividad">{{ old('resource_assignment', $activity->resource_assignment ?? '') }}</textarea>
    @error('resource_assignment')
        <div class="invalid-feedback">{{ $message }}</div>
    @enderror
</div>

<div class="mb-3">
    <label for="example_assignment" class="form-label">Asignación de Ejemplos:</label>
    <textarea name="example_assignment" id="example_assignment" rows="4" class="form-control @error('example_assignment') is-invalid @enderror" placeholder="Proporciona ejemplos de la actividad">{{ old('example_assignment', $activity->example_assignment ?? '') }}</textarea>
    @error('example_assignment')
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
