@extends('layouts.admin')
@section('title', 'Events')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-3">
  <h2>Events</h2>
  <a href="{{ route('events.create') }}" class="btn btn-primary">+ Add Event</a>
</div>

@if(session('success'))
  <div class="alert alert-success">{{ session('success') }}</div>
@endif

<table class="table table-bordered">
  <thead class="table-light">
    <tr>
      <th>#</th>
      <th>Name</th>
      <th>Date</th>
      <th>Description</th>
      <th>Actions</th>
    </tr>
  </thead>
  <tbody>
    @foreach($events as $event)
    <tr>
      <td>{{ $loop->iteration }}</td>
      <td>{{ $event->name }}</td>
      <td>{{ $event->date }}</td>
      <td>{{ $event->description }}</td>
      <td>
        <a href="{{ route('events.edit', $event) }}" class="btn btn-warning btn-sm">Edit</a>
        <form action="{{ route('events.destroy', $event) }}" method="POST" class="d-inline">
          @csrf @method('DELETE')
          <button class="btn btn-danger btn-sm">Delete</button>
        </form>
      </td>
    </tr>
    @endforeach
  </tbody>
</table>
@endsection
