@extends('layouts.app-menu')

@section('title', 'Editar Contenido')

@section('content-principal')
    <div class="container-fluid">
        <div class="row">
            <div class="col-lg-8 mx-auto">
                <div class="d-flex justify-content-between align-items-center mb-4">
                    <h3 class="mb-0">Editar Contenido</h3>
                    <a href="{{ route('contents.index') }}" class="btn btn-secondary btn-sm">
                        <i class="fas fa-arrow-left"></i> Volver
                    </a>
                </div>
                <div class="card">
                    <div class="card-body">
                        <form action="{{ route('contents.update', $content->id) }}" method="POST">
                            @method('PUT')
                            @include('school_admin.contents._form')
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
