@extends('layouts.app-menu')

@section('title', 'Editar Tema')

@section('content-principal')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">
                        <h3 class="card-title m-0">Editar Tema</h3>
                    </div>

                    <div class="card-body">
                        <form action="{{ route('school.topics.update', $topic) }}" method="POST">
                            @csrf
                            @method('PUT')

                            <div class="mb-3">
                                <label for="title" class="form-label">Título <span class="text-danger">*</span></label>
                                <input type="text" class="form-control @error('title') is-invalid @enderror" 
                                       id="title" name="title" value="{{ old('title', $topic->title) }}" required>
                                @error('title')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="mb-3">
                                <label for="description" class="form-label">Descripción</label>
                                <textarea class="form-control @error('description') is-invalid @enderror" 
                                          id="description" name="description" rows="4">{{ old('description', $topic->description) }}</textarea>
                                @error('description')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="d-flex justify-content-end gap-2">
                                <a href="{{ route('school.topics.index') }}" class="btn btn-secondary">Cancelar</a>
                                <button type="submit" class="btn btn-primary">Actualizar Tema</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection