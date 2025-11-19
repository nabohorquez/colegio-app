@extends('layouts.app-menu')

@section('title', 'Detalles del Tema')

@section('content-principal')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">
                        <div class="d-flex justify-content-between align-items-center">
                            <h3 class="card-title m-0">{{ $topic->title }}</h3>
                            <div>
                                <a href="{{ route('topics.edit', $topic) }}" class="btn btn-sm btn-warning">
                                    <i class="fas fa-edit"></i> Editar
                                </a>
                                <a href="{{ route('topics.index') }}" class="btn btn-sm btn-secondary">
                                    <i class="fas fa-arrow-left"></i> Volver
                                </a>
                            </div>
                        </div>
                    </div>

                    <div class="card-body">
                        <div class="mb-4">
                            <h5 class="text-muted mb-2">Descripción</h5>
                            <p class="mb-0">{{ $topic->description ?: 'Sin descripción' }}</p>
                        </div>

                        <hr>

                        <div class="row">
                            <div class="col-md-6">
                                <h5 class="text-muted mb-2">Creado por</h5>
                                <p>{{ $topic->creator->name }}</p>
                            </div>
                            <div class="col-md-6">
                                <h5 class="text-muted mb-2">Fecha de creación</h5>
                                <p>{{ $topic->created_at->format('d/m/Y H:i') }}</p>
                            </div>
                            @if($topic->updated_at != $topic->created_at)
                                <div class="col-md-6">
                                    <h5 class="text-muted mb-2">Última actualización</h5>
                                    <p>{{ $topic->updated_at->format('d/m/Y H:i') }}</p>
                                </div>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection