@extends('layouts.app-menu')

@section('title', 'Temas')

@section('content-principal')
    <div class="container">
        <div class="row">
            <div class="col-12">
                <div class="card mb-3">
                    <div class="card-body">
                        <h3 class="card-title">Temas</h3>
                        <p>¡Hola, {{ $nombre ?? 'usuario' }}! Esta es la página de administración de temas.</p>

                        <!-- Aquí puedes añadir la tabla/lista de temas -->
                        <div class="mt-3">
                            <p class="text-muted">(Aún no hay datos — añade un modelo Topic y pásalo desde el controlador.)</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection