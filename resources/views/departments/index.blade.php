@extends('layouts.app')

@section('content')
<div class="container">
    <h1>Departments</h1>
    <a href="{{ route('departments.create') }}" class="btn btn-primary mb-3">Create Department</a>

    @if (session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <table class="table table-bordered">
        <thead>
            <tr>
                <th>Name</th>
                <th>Lead</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            @foreach($departments as $department)
            <tr>
                <td>{{ $department->name }}</td>
                <td>{{ $department->lead ? $department->lead->getName() : 'No Lead Assigned' }}</td>
                <td>
                    <a href="{{ route('departments.show', $department) }}" class="btn btn-info btn-sm">View</a>
                    <a href="{{ route('departments.edit', $department) }}" class="btn btn-warning btn-sm">Edit</a>
                    <form action="{{ route('departments.destroy', $department) }}" method="POST" class="d-inline" onsubmit="return confirm('Are you sure?')">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-danger btn-sm">Delete</button>
                    </form>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
</div>
@endsection
