@extends('layouts.app')

@section('title', 'Edit Session')

@section('content')
<h1>Edit Session</h1>
<form method="POST" action="{{ route('sessions.update', $session->id) }}">
    @csrf @method('PUT')
    <div class="mb-3">
        <label>Title</label>
        <input type="text" name="title" class="form-control" value="{{ $session->title }}" required>
    </div>
    <div class="mb-3">
        <label>Speaker</label>
        <input type="text" name="speaker" class="form-control" value="{{ $session->speaker }}" required>
    </div>
    <div class="mb-3">
        <label>Date</label>
        <input type="date" name="date" class="form-control" value="{{ $session->date }}" required>
    </div>
    <div class="mb-3">
        <label>Time</label>
        <input type="time" name="time" class="form-control" value="{{ $session->time }}" required>
    </div>
    <button type="submit" class="btn btn-primary">Update</button>
</form>
@endsection
