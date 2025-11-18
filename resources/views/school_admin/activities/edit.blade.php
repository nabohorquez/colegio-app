@extends('layouts.app-menu')

@section('title', 'Editar Actividad')

@section('content-principal')
<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <h3 class="mb-4">Editar Actividad</h3>

            <div class="card">
                <div class="card-body">
                    <form action="{{ route('school.activities.update', $activity->id) }}" method="POST">
                        @method('PUT')
                        @include('school_admin.activities._form', ['activity' => $activity])
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
