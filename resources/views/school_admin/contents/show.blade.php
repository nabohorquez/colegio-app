@extends('layouts.app-menu')

@section('title', 'Detalle de Contenido')

@section('content-principal')
    <div class="container-fluid">
        <div class="row">
            <div class="col-lg-8 mx-auto">
                <div class="d-flex justify-content-between align-items-center mb-4">
                    <h3 class="mb-0">Detalle de Contenido</h3>
                    <a href="{{ route('contents.index') }}" class="btn btn-secondary btn-sm">
                        <i class="fas fa-arrow-left"></i> Volver
                    </a>
                </div>
                <div class="card">
                    <div class="card-body">
                        <h5 class="mb-3"><strong>Título:</strong> {{ $content->title }}</h5>
                        <p><strong>Asignatura:</strong> {{ $content->subject->name ?? '-' }}</p>
                        <p><strong>Período Académico:</strong> <span class="badge bg-info">{{ $content->academic_period }}</span></p>
                        <p><strong>Descripción:</strong><br>{{ $content->description }}</p>
                        <hr>
                        <p><strong>Creado por:</strong> {{ $content->creator->name ?? '-' }}</p>
                        <p><strong>Fecha de creación:</strong> {{ $content->created_at->format('d/m/Y H:i') }}</p>
                        @if($content->updated_at->ne($content->created_at))
                            <p><strong>Última actualización:</strong> {{ $content->updated_at->format('d/m/Y H:i') }}</p>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
