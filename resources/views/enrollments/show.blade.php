@extends('layouts.app')

@section('content')
<div class="container">
    <h1>Enrollment Details</h1>

    <p><strong>User:</strong> {{ $enrollment->user->name }}</p>
    <p><strong>Course:</strong> {{ $enrollment->course->name }}</p>
    <p><strong>Enrollment Date:</strong> {{ $enrollment->created_at }}</p>
</div>
@endsection
