@extends('layouts.admin')
@section('title','Event Sessions')
@section('content')
<div class="mb-3 d-flex justify-content-between">
  <h3>Sessions</h3>
  <a href="{{ route('event-sessions.create') }}" class="btn btn-sm btn-primary">+ New Session</a>
</div>

@if(session('success'))<div class="alert alert-success">{{ session('success') }}</div>@endif

<table class="table table-dark table-striped">
<thead><tr><th>#</th><th>Event</th><th>Title</th><th>Speaker</th><th>Start</th><th>End</th><th>Price</th><th>Actions</th></tr></thead>
<tbody>
  @foreach($sessions as $s)
  <tr>
    <td>{{ $loop->iteration }}</td>
    <td>{{ $s->event->title ?? '-' }}</td>
    <td>{{ $s->title }}</td>
    <td>{{ $s->speaker ?? '-' }}</td>
    <td>{{ $s->start_time }}</td>
    <td>{{ $s->end_time }}</td>
    <td>{{ $s->price }}</td>
    <td>
      <a class="btn btn-sm btn-warning" href="{{ route('event-sessions.edit',$s) }}">Edit</a>
      <form method="POST" action="{{ route('event-sessions.destroy',$s) }}" class="d-inline">@csrf @method('DELETE')<button class="btn btn-sm btn-danger" onclick="return confirm('Delete?')">Delete</button></form>
    </td>
  </tr>
  @endforeach
</tbody>
</table>

{{ $sessions->links() }}
@endsection
