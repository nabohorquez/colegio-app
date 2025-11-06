@extends('layouts.app')

@section('title', 'Edit Enrollment Type')

@section('content')
<div class="container py-4">
    <h3>Edit Enrollment Type</h3>

    <form action="{{ route('enrollment-types.update', $type) }}" method="POST">
        @method('PUT')
        @include('modules.enrollment_types._form')
        <div class="mt-3">
            <button class="btn btn-primary">Update</button>
            <a href="{{ route('enrollment-types.index') }}" class="btn btn-secondary">Cancel</a>
        </div>
    </form>
</div>
@endsection
