@extends('layouts.app-menu')

@section('title', 'Matrículas')

@section('content-principal')
    <div class="container mt-5">
        <h2 class="mb-4">Lista de Matrículas</h2>
        @if(session('success'))
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                {{ session('success') }}
            </div>
        @endif
        @if(session('error'))
            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                {{ session('error') }}
            </div>
        @endif
        <table class="table table-bordered" id="enrollmentsTable" style="max-width: 100%; overflow-x: auto;">
            <thead>
                <tr>
                    <th>Acciones</th>
                    <th>Estudiante</th>
                    <th>Grado</th>
                    <th>Tipo de Matrícula</th>
                    <th>Forma de Pago</th>
                    <th>Costo</th>
                    <th>Estado de Pago</th>
                    <th>Fecha</th>
                    <th>Estado</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($enrollments as $enrollment)
                    <tr>
                        <td class="d-flex justify-content-center">
                            <a href="{{ route('enrollments.getById', $enrollment->id) }}" class="btn btn-sm btn-warning me-2" title="Editar"><i class="fas fa-edit"></i></a>
                            <form action="{{ route('enrollments.delete', $enrollment->id) }}" method="POST" style="display:inline;">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-sm btn-danger" title="Eliminar"
                                        onclick="return confirm('¿Estás seguro de que deseas eliminar esta matrícula?')">
                                    <i class="fas fa-trash-alt"></i>
                                </button>
                            </form>
                        </td>
                        <td>{{ $enrollment->student ? $enrollment->student->full_name : 'N/A' }}</td>
                        <td>{{ $enrollment->grade ? $enrollment->grade->nombre_grado : 'N/A' }}</td>
                        <td>{{ $enrollment->enrollmentType ? $enrollment->enrollmentType->nombre_tipo : 'N/A' }}</td>
                        <td>{{ ucfirst($enrollment->forma_pago) }}</td>
                        <td>${{ number_format($enrollment->costo ?? 0, 2) }}</td>
                        <td>
                            <span class="badge {{ $enrollment->estado_pago == 'pagado' ? 'bg-success' : ($enrollment->estado_pago == 'parcial' ? 'bg-warning' : 'bg-danger') }}">
                                {{ ucfirst($enrollment->estado_pago ?? 'N/A') }}
                            </span>
                        </td>
                        <td>{{ $enrollment->fecha ? $enrollment->fecha->format('d/m/Y') : 'N/A' }}</td>
                        <td>
                            <span class="badge {{ $enrollment->estado ? 'bg-success' : 'bg-danger' }}">
                                {{ $enrollment->estado ? 'Activo' : 'Inactivo' }}
                            </span>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>

    <div>
        <button
            class="btn btn-primary position-fixed rounded-circle"
            style="bottom: 20px; right: 20px;"
            type="button"
            title="Adicionar"
        >
            <a href="{{ route('enrollments.viewCreate') }}">
                <i class="fas fa-plus h1 text-align-center m-0 my-1 text-white"></i>
            </a>
        </button>
    </div>
@endsection
