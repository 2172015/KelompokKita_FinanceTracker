@extends('layouts.admin')
@section('title','Edit Event')
@section('content')
<form method="POST" action="{{ route('events.update', $event) }}">
  @csrf @method('PUT')
  <div class="mb-3"><label>Title</label><input name="title" value="{{ $event->title }}" class="form-control" required></div>
  <div class="mb-3"><label>Date</label><input type="date" name="date" value="{{ $event->date }}" class="form-control"></div>
  <div class="mb-3"><label>Location</label><input name="location" value="{{ $event->location }}" class="form-control"></div>
  <div class="mb-3"><label>Description</label><textarea name="description" class="form-control">{{ $event->description }}</textarea></div>
  <button class="btn btn-primary">Update</button>
  <a href="{{ route('events.index') }}" class="btn btn-secondary">Back</a>
</form>
@endsection
