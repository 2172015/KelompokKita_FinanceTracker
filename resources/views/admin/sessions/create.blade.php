@extends('layouts.admin')
@section('title','Create Session')
@section('content')
<form method="POST" action="{{ route('event-sessions.store') }}">
  @csrf
  <div class="mb-3">
    <label>Event</label>
    <select name="event_id" class="form-select" required>
      <option value="">-- choose --</option>
      @foreach($events as $ev)<option value="{{ $ev->id }}">{{ $ev->title }}</option>@endforeach
    </select>
  </div>
  <div class="mb-3"><label>Title</label><input name="title" class="form-control" required></div>
  <div class="mb-3"><label>Speaker</label><input name="speaker" class="form-control"></div>
  <div class="mb-3"><label>Start</label><input type="datetime-local" name="start_time" class="form-control" required></div>
  <div class="mb-3"><label>End</label><input type="datetime-local" name="end_time" class="form-control" required></div>
  <div class="mb-3"><label>Price</label><input type="number" name="price" class="form-control" value="0"></div>
  <div class="mb-3"><label>Description</label><textarea name="description" class="form-control"></textarea></div>
  <button class="btn btn-success">Save</button> <a class="btn btn-secondary" href="{{ route('event-sessions.index') }}">Back</a>
</form>
@endsection
