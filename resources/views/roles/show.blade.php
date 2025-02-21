@extends('layouts.app')

@section('content')
<div class="container">
    <h1>{{ $role->name }}</h1>
    <p><strong>Description:</strong> {{ $role->description }}</p>

    <a href="{{ route('roles.index') }}" class="btn btn-secondary">Back to List</a>
    <a href="{{ route('roles.edit', $role) }}" class="btn btn-warning">Edit</a>
    <form action="{{ route('roles.destroy', $role) }}" method="POST" class="d-inline" onsubmit="return confirm('Are you sure?')">
        @csrf
        @method('DELETE')
        <button type="submit" class="btn btn-danger">Delete</button>
    </form>
</div>
@endsection
