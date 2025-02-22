@extends('layouts.app')

@section('content')
<div class="container">
    @if(isset($user) && $user->profile_picture)
        <img src="{{ asset('storage/' . $user->profile_picture) }}" alt="profile_picture" class="profile-picture-circle">
    @endif
    <h2>User Details</h2>
    <p><strong>Title:</strong> {{ $user->title }}</p>
    <p><strong>Full Name:</strong> {{ $user->getFullNameLong() }}</p>
    <p><strong>Email:</strong> {{ $user->email }}</p>
    <p><strong>Role:</strong> {{ $user->role->name ?? 'N/A' }}</p>
    <p><strong>Department:</strong> {{ $user->department->name ?? 'N/A' }}</p>

    @can('update', $user)
        <a href="{{ route('users.edit', $user->id) }}" class="btn btn-warning btn-sm d-block mb-2">{{ __('users.edit') }}</a>
    @endcan
    @can('delete', $user)
        @if (auth()->user()->id !== $user->id)
            <form action="{{ route('users.destroy', $user->id) }}" method="POST" style="display: inline-block;">
                @csrf
                @method('DELETE')
                <button type="submit" class="btn btn-danger btn-sm d-block mb-2" onclick="return confirm('Are you sure?')">{{ __('users.delete') }}</button>
            </form>
        @endif
    @endcan
    @if($canViewSensitiveDocs)
        <div class="mt-4">
            <h5>{{ __('users.sensitive_documents') }}</h5>
            <p>{{ __('users.contains_sensitive_docs') }}</p>
            @if(isset($user) && $user->cv_path)
                <a href="{{ asset('storage/' . $user->cv_path) }}" target="_blank">{{ __('users.download_cv') }}</a>
            @endif

            @if(isset($user) && $user->cover_letter)
                <a href="{{ asset('storage/' . $user->cover_letter) }}" target="_blank">{{ __('users.download_cover_letter') }}</a>
            @endif
        </div>
    @endif
</div>
@endsection
