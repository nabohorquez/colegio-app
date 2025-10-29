@extends('layouts.app-menu')

@section('title', 'Roles - AcademicSoftware')

@section('content-principal')
    <div class="container mt-5">
        <form action="" method="post">
            @csrf
            <div class="mb-3">
                <label for="rol_name" class="form-label">Nombre del Rol</label>
                <input type="text" class="form-control" id="rol_name" name="rol_name" required>
            </div>
            <div class="mb-3">
                <label for="description" class="form-label">Descripción</label>
                <textarea class="form-control" id="description" name="description" rows="3" required></textarea>
            </div>
            <button type="submit" class="btn btn-primary">Guardar</button>
        </form>
    </div>
@endsection
