@extends('layouts.app')

@section('title', 'Sessions')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-3">
    <h1>Sessions</h1>
    <a href="{{ route('sessions.create') }}" class="btn btn-primary">Add Session</a>
</div>

@if (session('success'))
    <div class="alert alert-success">{{ session('success') }}</div>
@endif

<table class="table table-bordered">
    <thead>
        <tr>
            <th>ID</th>
            <th>Event ID</th>
            <th>Title</th>
            <th>Speaker</th>
            <th>Date</th>
            <th>Time</th>
            <th>Action</th>
        </tr>
    </thead>
    <tbody>
        @foreach ($sessions as $session)
        <tr>
            <td>{{ $session->id }}</td>
            <td>{{ $session->event_id }}</td>
            <td>{{ $session->title }}</td>
            <td>{{ $session->speaker }}</td>
            <td>{{ $session->date }}</td>
            <td>{{ $session->time }}</td>
            <td>
                <a href="{{ route('sessions.show', $session->id) }}" class="btn btn-sm btn-info">Show</a>
                <a href="{{ route('sessions.edit', $session->id) }}" class="btn btn-sm btn-warning">Edit</a>
                <form action="{{ route('sessions.destroy', $session->id) }}" method="POST" class="d-inline">
                    @csrf @method('DELETE')
                    <button class="btn btn-sm btn-danger" onclick="return confirm('Delete this session?')">Delete</button>
                </form>
            </td>
        </tr>
        @endforeach
    </tbody>
</table>
@endsection
