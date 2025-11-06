@extends('layouts.app')

@section('title', 'Enrollment Type Details')

@section('content')
<div class="container py-4">
    <h3>{{ $type->name }}</h3>
    <p><strong>Code:</strong> {{ $type->code }}</p>
    <p><strong>Fee:</strong> {{ number_format($type->fee, 2) }}</p>
    <p><strong>Active:</strong> {{ $type->is_active ? 'Yes' : 'No' }}</p>
    <p><strong>Description:</strong></p>
    <p>{{ $type->description }}</p>

    <a href="{{ route('enrollment-types.index') }}" class="btn btn-secondary">Back</a>
</div>
@endsection
