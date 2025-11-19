@extends('layouts.app-menu')

@section('title', 'Editar Calificación')

@section('content-principal')
    <div class="container-fluid">
        <div class="row">
            <div class="col-lg-8 mx-auto">
                <div class="d-flex justify-content-between align-items-center mb-4">
                    <h3 class="mb-0">Editar Calificación</h3>
                    <a href="{{ route('student-grades.index') }}" class="btn btn-secondary btn-sm">
                        <i class="fas fa-arrow-left"></i> Volver
                    </a>
                </div>

                <div class="card">
                    <div class="card-body">
                        <form action="{{ route('student-grades.update', $grade->id) }}" method="POST">
                            @method('PUT')
                            @include('school_admin.grades._form', ['grade' => $grade])
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
