@extends('layouts.app')

@section('content')
<div class="container">
    <h1>Edit Course</h1>

    <form action="{{ route('courses.update', $course->id) }}" method="POST">
        @csrf
        @method('PUT')
        <div class="form-group">
            <label for="name">Course Name</label>
            <input type="text" id="name" name="name" class="form-control" value="{{ $course->name }}" required>
        </div>

        <div class="form-group">
            <label for="description">Course Description</label>
            <textarea id="description" name="description" class="form-control" required>{{ $course->description }}</textarea>
        </div>

        <button type="submit" class="btn btn-warning">Update Course</button>
    </form>
</div>
@endsection
