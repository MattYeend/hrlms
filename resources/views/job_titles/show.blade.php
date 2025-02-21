@extends('layouts.app')

@section('content')
<div class="container">
    <h1>{{ $jobTitle->name }}</h1>

    <a href="{{ route('job_titles.index') }}" class="btn btn-secondary">Back to List</a>
    <a href="{{ route('job_titles.edit', $jobTitle) }}" class="btn btn-warning">Edit</a>
    <form action="{{ route('job_titles.destroy', $jobTitle) }}" method="POST" class="d-inline" onsubmit="return confirm('Are you sure?')">
        @csrf
        @method('DELETE')
        <button type="submit" class="btn btn-danger">Delete</button>
    </form>
</div>
@endsection
