@extends('layouts.app')

@section('content')
<div class="container">
    <h1>Enrollments</h1>

    @if(session('success'))
        <div class="alert alert-success mt-3">{{ session('success') }}</div>
    @endif

    <table class="table mt-3">
        <thead>
            <tr>
                <th>User</th>
                <th>Course</th>
                <th>Enrollment Date</th>
            </tr>
        </thead>
        <tbody>
            @foreach($enrollments as $enrollment)
            <tr>
                <td>{{ $enrollment->user->name }}</td>
                <td>{{ $enrollment->course->name }}</td>
                <td>{{ $enrollment->created_at }}</td>
            </tr>
            @endforeach
        </tbody>
    </table>
</div>
@endsection
