@extends('layouts.app')

@section('content')
<div class="container">
    <h2>User Details</h2>
    <p><strong>Title:</strong> {{ $user->title }}</p>
    <p><strong>Full Name:</strong> {{ $user->getFullNameLong() }}</p>
    <p><strong>Email:</strong> {{ $user->email }}</p>
    <p><strong>Role:</strong> {{ $user->role->name ?? 'N/A' }}</p>
    <p><strong>Department:</strong> {{ $user->department->name ?? 'N/A' }}</p>

    <a href="{{ route('users.edit', $user->id) }}" class="btn btn-warning">Edit</a>
    <form action="{{ route('users.destroy', $user->id) }}" method="POST" class="d-inline" onsubmit="return confirm('Are you sure?');">
        @csrf
        @method('DELETE')
        <button class="btn btn-danger">Delete</button>
    </form>
</div>
@endsection
