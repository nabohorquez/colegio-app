@extends('layouts.app-menu')

@section('title', 'Ver Actividad')

@section('content-principal')
<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <div class="d-flex justify-content-between align-items-center mb-4">
                <h3 class="mb-0">{{ $activity->title }}</h3>
                <div>
                    <a href="{{ route('school.activities.edit', $activity->id) }}" class="btn btn-warning btn-sm">
                        <i class="fas fa-edit"></i> Editar
                    </a>
                    <a href="{{ route('school.activities.index') }}" class="btn btn-secondary btn-sm">
                        <i class="fas fa-arrow-left"></i> Volver
                    </a>
                </div>
            </div>

            <div class="card">
                <div class="card-body">
                    <div class="row mb-4">
                        <div class="col-md-8">
                            <h5 class="text-muted">Descripción</h5>
                            <p>{{ $activity->description ?? 'Sin descripción' }}</p>
                        </div>
                        <div class="col-md-4">
                            <div class="card bg-light">
                                <div class="card-body">
                                    <h6 class="card-title">Información</h6>
                                    <p><strong>Creado por:</strong> {{ $activity->creator->first_name ?? '' }} {{ $activity->creator->last_name ?? '' }}</p>
                                    <p><strong>Fecha de creación:</strong> {{ $activity->created_at->format('d/m/Y H:i') }}</p>
                                    @if($activity->updated_at->ne($activity->created_at))
                                        <p><strong>Última actualización:</strong> {{ $activity->updated_at->format('d/m/Y H:i') }}</p>
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
