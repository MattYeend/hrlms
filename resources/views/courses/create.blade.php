@extends('layouts.app')

@section('content')
<div class="container">
    <h1>Create Course</h1>

    <form action="{{ route('courses.store') }}" method="POST">
        @csrf
        <div class="form-group">
            <label for="name">Course Name</label>
            <input type="text" id="name" name="name" class="form-control" required>
        </div>

        <div class="form-group">
            <label for="description">Course Description</label>
            <textarea id="description" name="description" class="form-control" required></textarea>
        </div>

        <button type="submit" class="btn btn-success">Create Course</button>
    </form>
</div>
@endsection
