@extends('layouts.app')

@section('content')
<div class="container">
    <h1>Progress Records</h1>

    @if(session('success'))
        <div class="alert alert-success mt-3">{{ session('success') }}</div>
    @endif

    <table class="table mt-3">
        <thead>
            <tr>
                <th>Course</th>
                <th>User</th>
                <th>Progress (%)</th>
            </tr>
        </thead>
        <tbody>
            @foreach($progressRecords as $progress)
            <tr>
                <td>{{ $progress->course->name }}</td>
                <td>{{ $progress->user->name }}</td>
                <td>{{ $progress->progress }}%</td>
            </tr>
            @endforeach
        </tbody>
    </table>
</div>
@endsection
