@extends('layouts.app')

@section('content')
<div class="container">
    <h1>Edit Department</h1>

    <form action="{{ route('departments.update', $department) }}" method="POST">
        @csrf
        @method('PUT')

        <div class="mb-3">
            <label for="name" class="form-label">Department Name</label>
            <input type="text" class="form-control" id="name" name="name" value="{{ $department->name }}" required>
        </div>

        <div class="mb-3">
            <label for="lead_id" class="form-label">Department Lead</label>
            <select class="form-control" id="lead_id" name="lead_id">
                <option value="">Select Lead</option>
                @foreach($users as $user)
                    <option value="{{ $user->id }}" {{ $department->lead_id == $user->id ? 'selected' : '' }}>
                        {{ $user->getName() }}
                    </option>
                @endforeach
            </select>
        </div>

        <button type="submit" class="btn btn-success">Update</button>
        <a href="{{ route('departments.index') }}" class="btn btn-secondary">Cancel</a>
    </form>
</div>
@endsection
