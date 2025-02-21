@extends('layouts.app')

@section('content')
<div class="container">
    <h1>{{ $department->name }}</h1>
    <p><strong>Lead:</strong> {{ $department->lead ? $department->lead->getName() : 'No Lead Assigned' }}</p>

    <a href="{{ route('departments.index') }}" class="btn btn-secondary">Back to List</a>
    <a href="{{ route('departments.edit', $department) }}" class="btn btn-warning">Edit</a>
    <form action="{{ route('departments.destroy', $department) }}" method="POST" class="d-inline" onsubmit="return confirm('Are you sure?')">
        @csrf
        @method('DELETE')
        <button type="submit" class="btn btn-danger">Delete</button>
    </form>
</div>
@endsection
