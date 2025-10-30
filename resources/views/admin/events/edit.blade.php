@extends('layouts.admin')
@section('title', 'Edit Event')

@section('content')
<h2>Edit Event</h2>
<form method="POST" action="{{ route('events.update', $event) }}">
  @csrf @method('PUT')
  <div class="mb-3">
    <label>Name</label>
    <input type="text" name="name" value="{{ $event->name }}" class="form-control" required>
  </div>
  <div class="mb-3">
    <label>Date</label>
    <input type="date" name="date" value="{{ $event->date }}" class="form-control" required>
  </div>
  <div class="mb-3">
    <label>Description</label>
    <textarea name="description" class="form-control">{{ $event->description }}</textarea>
  </div>
  <button type="submit" class="btn btn-primary">Update</button>
</form>
@endsection
