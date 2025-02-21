@extends('layouts.app')

@section('content')
<div class="container">
    <h1>Job Titles</h1>
    <a href="{{ route('job_titles.create') }}" class="btn btn-primary mb-3">Create Job Title</a>

    @if (session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <table class="table table-bordered">
        <thead>
            <tr>
                <th>Name</th>
                <th>Description</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            @foreach($jobTitles as $jobTitle)
            <tr>
                <td>{{ $jobTitle->name }}</td>
                <td>
                    <a href="{{ route('job_titles.show', $jobTitle) }}" class="btn btn-info btn-sm">View</a>
                    <a href="{{ route('job_titles.edit', $jobTitle) }}" class="btn btn-warning btn-sm">Edit</a>
                    <form action="{{ route('job_titles.destroy', $jobTitle) }}" method="POST" class="d-inline" onsubmit="return confirm('Are you sure?')">
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
