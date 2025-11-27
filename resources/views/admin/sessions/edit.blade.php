@extends('layouts.admin')
@section('title','Edit Session')
@section('content')
<form method="POST" action="{{ route('event-sessions.update',$eventSession) }}">
  @csrf @method('PUT')
  <div class="mb-3">
    <label>Event</label>
    <select name="event_id" class="form-select" required>
      @foreach($events as $ev)
        <option value="{{ $ev->id }}" {{ $ev->id == $eventSession->event_id ? 'selected' : '' }}>{{ $ev->title }}</option>
      @endforeach
    </select>
  </div>
  <div class="mb-3"><label>Title</label><input name="title" class="form-control" value="{{ $eventSession->title }}" required></div>
  <div class="mb-3"><label>Speaker</label><input name="speaker" class="form-control" value="{{ $eventSession->speaker }}"></div>
  <div class="mb-3"><label>Start</label><input type="datetime-local" name="start_time" class="form-control" value="{{ date('Y-m-d\TH:i', strtotime($eventSession->start_time)) }}" required></div>
  <div class="mb-3"><label>End</label><input type="datetime-local" name="end_time" class="form-control" value="{{ date('Y-m-d\TH:i', strtotime($eventSession->end_time)) }}" required></div>
  <div class="mb-3"><label>Price</label><input type="number" name="price" class="form-control" value="{{ $eventSession->price }}"></div>
  <div class="mb-3"><label>Description</label><textarea name="description" class="form-control">{{ $eventSession->description }}</textarea></div>
  <button class="btn btn-primary">Update</button> <a class="btn btn-secondary" href="{{ route('event-sessions.index') }}">Back</a>
</form>
@endsection
