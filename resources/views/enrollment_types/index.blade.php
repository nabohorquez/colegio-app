<!-- resources/views/modules/enrollment_types/index.blade.php -->
@extends('layouts.app')

@section('title', 'Enrollment Types')

@section('content')
<div class="container py-4">
    <div class="d-flex justify-content-between mb-3">
        <h3>Enrollment Types</h3>
        <a href="{{ route('enrollment-types.create') }}" class="btn btn-primary">New Type</a>
    </div>

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <table class="table table-striped">
        <thead>
            <tr>
                <th>Name</th>
                <th>Code</th>
                <th>Fee</th>
                <th>Active</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            @forelse($types as $type)
                <tr>
                    <td>{{ $type->name }}</td>
                    <td>{{ $type->code }}</td>
                    <td>{{ number_format($type->fee, 2) }}</td>
                    <td>{{ $type->is_active ? 'Yes' : 'No' }}</td>
                    <td>
                        <a href="{{ route('enrollment-types.edit', $type) }}" class="btn btn-sm btn-secondary">Edit</a>
                        <form action="{{ route('enrollment-types.destroy', $type) }}" method="POST" class="d-inline" onsubmit="return confirm('Are you sure?');">
                            @csrf
                            @method('DELETE')
                            <button class="btn btn-sm btn-danger">Delete</button>
                        </form>
                        <a href="{{ route('enrollment-types.show', $type) }}" class="btn btn-sm btn-info">View</a>
                    </td>
                </tr>
            @empty
                <tr><td colspan="5">No enrollment types found.</td></tr>
            @endforelse
        </tbody>
    </table>

    {{ $types->links() }}
</div>
@endsection
