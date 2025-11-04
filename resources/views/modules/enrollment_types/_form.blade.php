<!-- resources/views/modules/enrollment_types/_form.blade.php -->
@csrf

<div class="mb-3">
    <label for="name" class="form-label">Name</label>
    <input id="name" name="name" value="{{ old('name', $type->name ?? '') }}" class="form-control @error('name') is-invalid @enderror" required>
    @error('name') <div class="invalid-feedback">{{ $message }}</div> @enderror
</div>

<div class="mb-3">
    <label for="code" class="form-label">Code</label>
    <input id="code" name="code" value="{{ old('code', $type->code ?? '') }}" class="form-control @error('code') is-invalid @enderror">
    @error('code') <div class="invalid-feedback">{{ $message }}</div> @enderror
</div>

<div class="mb-3">
    <label for="description" class="form-label">Description</label>
    <textarea id="description" name="description" class="form-control">{{ old('description', $type->description ?? '') }}</textarea>
</div>

<div class="mb-3">
    <label for="fee" class="form-label">Fee</label>
    <input id="fee" name="fee" type="number" step="0.01" value="{{ old('fee', $type->fee ?? 0) }}" class="form-control @error('fee') is-invalid @enderror" required>
    @error('fee') <div class="invalid-feedback">{{ $message }}</div> @enderror
</div>

<div class="form-check mb-3">
    <input class="form-check-input" type="checkbox" id="is_active" name="is_active" {{ old('is_active', $type->is_active ?? true) ? 'checked' : '' }}>
    <label class="form-check-label" for="is_active">Active</label>
</div>
