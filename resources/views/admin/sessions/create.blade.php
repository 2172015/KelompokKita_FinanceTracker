@extends('layouts.app')

@section('title', 'Add Session')

@section('content')
<h1>Add Session</h1>
<form method="POST" action="{{ route('sessions.store') }}">
    @csrf
    <div class="mb-3">
        <label>Event ID</label>
        <input type="number" name="event_id" class="form-control" required>
    </div>
    <div class="mb-3">
        <label>Title</label>
        <input type="text" name="title" class="form-control" required>
    </div>
    <div class="mb-3">
        <label>Speaker</label>
        <input type="text" name="speaker" class="form-control" required>
    </div>
    <div class="mb-3">
        <label>Date</label>
        <input type="date" name="date" class="form-control" required>
    </div>
    <div class="mb-3">
        <label>Time</label>
        <input type="time" name="time" class="form-control" required>
    </div>
    <button type="submit" class="btn btn-success">Save</button>
</form>
@endsection
