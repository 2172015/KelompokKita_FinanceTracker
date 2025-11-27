@extends('layouts.admin')
@section('title','Create Event')
@section('content')
<form method="POST" action="{{ route('events.store') }}">
  @csrf
  <div class="mb-3"><label>Title</label><input name="title" class="form-control" required></div>
  <div class="mb-3"><label>Date</label><input type="date" name="date" class="form-control"></div>
  <div class="mb-3"><label>Location</label><input name="location" class="form-control"></div>
  <div class="mb-3"><label>Description</label><textarea name="description" class="form-control"></textarea></div>
  <button class="btn btn-success">Save</button>
  <a href="{{ route('events.index') }}" class="btn btn-secondary">Back</a>
</form>
@endsection
