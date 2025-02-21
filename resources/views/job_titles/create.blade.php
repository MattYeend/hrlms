@extends('layouts.app')

@section('content')
<div class="container">
    <h1>Create Job Title</h1>

    <form action="{{ route('job_titles.store') }}" method="POST">
        @csrf

        <div class="mb-3">
            <label for="name" class="form-label">Job Title Name</label>
            <input type="text" class="form-control" id="name" name="name" required>
        </div>

        <button type="submit" class="btn btn-success">Create</button>
        <a href="{{ route('job_titles.index') }}" class="btn btn-secondary">Cancel</a>
    </form>
</div>
@endsection
