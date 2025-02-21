@extends('layouts.app')

@section('content')
<div class="container">
    <h1>Progress Details</h1>

    <p><strong>Course:</strong> {{ $progress->course->name }}</p>
    <p><strong>User:</strong> {{ $progress->user->name }}</p>
    <p><strong>Progress:</strong> {{ $progress->progress }}%</p>
</div>
@endsection
