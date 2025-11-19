@extends('layouts.app-menu')

@section('title', 'Crear Nueva Actividad')

@section('content-principal')
<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <h3 class="mb-4">Crear Nueva Actividad</h3>

            <div class="card">
                <div class="card-body">
                    <form action="{{ route('activities.store') }}" method="POST">
                        @include('school_admin.activities._form')
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
