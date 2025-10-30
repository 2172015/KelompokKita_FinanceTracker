@extends('layouts.admin')
@section('title', 'Create Event')

@section('content')
<h2>Create Event</h2>
<form method="POST" action="{{ route('events.store') }}">
  @csrf
  <div class="mb-3">
    <label>Name</label>
    <input type="text" name="name" class="form-control" required>
  </div>
  <div class="mb-3">
    <label>Date</label>
    <input type="date" name="date" class="form-control" required>
  </div>
  <div class="mb-3">
    <label>Description</label>
    <textarea name="description" class="form-control"></textarea>
  </div>
  <button type="submit" class="btn btn-success">Save</button>
</form>
@endsection
