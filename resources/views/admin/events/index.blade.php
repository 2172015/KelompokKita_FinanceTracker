@extends('layouts.admin')
@section('title','Events')
@section('content')
<div class="mb-3 d-flex justify-content-between">
  <h3>Events</h3>
  <a href="{{ route('events.create') }}" class="btn btn-sm btn-primary">+ New Event</a>
</div>

@if(session('success'))<div class="alert alert-success">{{ session('success') }}</div>@endif

<table class="table table-dark table-striped">
  <thead>
    <tr><th>#</th><th>Title</th><th>Date</th><th>Location</th><th>Actions</th></tr>
  </thead>
  <tbody>
    @foreach($events as $e)
    <tr>
      <td>{{ $loop->iteration }}</td>
      <td>{{ $e->title }}</td>
      <td>{{ $e->date }}</td>
      <td>{{ $e->location }}</td>
      <td>
        <a class="btn btn-sm btn-warning" href="{{ route('events.edit',$e) }}">Edit</a>
        <form method="POST" action="{{ route('events.destroy',$e) }}" class="d-inline">@csrf @method('DELETE')<button class="btn btn-sm btn-danger" onclick="return confirm('Delete?')">Delete</button></form>
      </td>
    </tr>
    @endforeach
  </tbody>
</table>

{{ $events->links() }}
@endsection
