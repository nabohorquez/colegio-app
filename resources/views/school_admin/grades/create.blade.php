@extends('layouts.app-menu')

@section('title', 'Asignar Nueva Calificación')

@section('content-principal')
    <div class="container-fluid">
        <div class="row">
            <div class="col-lg-8 mx-auto">
                <div class="d-flex justify-content-between align-items-center mb-4">
                    <h3 class="mb-0">Asignar Nueva Calificación al Estudiante</h3>
                    <a href="{{ route('school.grades.index') }}" class="btn btn-secondary btn-sm">
                        <i class="fas fa-arrow-left"></i> Volver
                    </a>
                </div>

                <div class="card">
                    <div class="card-body">
                        <form action="{{ route('school.grades.store') }}" method="POST">
                            @include('school_admin.grades._form')
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
