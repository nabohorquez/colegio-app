@extends('layouts.app')

@section('title', 'Create Enrollment Type')

@section('content')
<div class="container py-4">
    <h3>Create Enrollment Type</h3>

    <form action="{{ route('enrollment-types.store') }}" method="POST">
        @include('modules.enrollment_types._form')
        <div class="mt-3">
            <button class="btn btn-primary">Save</button>
            <a href="{{ route('enrollment-types.index') }}" class="btn btn-secondary">Cancel</a>
        </div>
    </form>
</div>
@endsection
