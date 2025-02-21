@extends('layouts.app')

@section('content')
<div class="container">
    <h1>{{ $course->name }}</h1>
    <p>{{ $course->description }}</p>

    <form action="{{ route('courses.enroll', $course->id) }}" method="POST">
        @csrf
        <button type="submit" class="btn btn-primary">Enroll in Course</button>
    </form>

    <h3>Your Progress</h3>
    <form action="{{ route('courses.progress', $course->id) }}" method="POST">
        @csrf
        <div class="form-group">
            <label for="progress">Progress (%)</label>
            <input type="number" id="progress" name="progress" class="form-control" min="0" max="100" required>
        </div>
        <button type="submit" class="btn btn-success">Update Progress</button>
    </form>
</div>
@endsection
