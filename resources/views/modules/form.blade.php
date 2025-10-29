@extends('layouts.app-menu')

@section('title', 'Modules - AcademicSoftware')

@section('content-principal')
    <div class="container mt-5">
        <form action="" method="post">
            @csrf
            <div class="mb-3">
                <label for="module_name" class="form-label">Nombre del modulo</label>
                <input type="text" class="form-control" id="module_name" name="module_name" required>
            </div>
            <div class="mb-3">
                <label for="description" class="form-label">Descripción</label>
                <textarea class="form-control" id="description" name="description" rows="3" required></textarea>
            </div>
            <div class="mb-3">
                <label for="route" class="form-label">Ruta</label>
                <input type="text" class="form-control" id="route" name="route" required>
            </div>
            <button type="submit" class="btn btn-primary">Guardar</button>
        </form>
    </div>
@endsection
