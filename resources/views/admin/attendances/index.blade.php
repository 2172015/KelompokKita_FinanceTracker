@extends('layouts.admin')
@section('title','Attendances')
@section('content')
<div class="mb-3 d-flex justify-content-between">
  <h3>Attendances</h3>
  <a href="{{ route('attendances.create') }}" class="btn btn-sm btn-primary">+ New</a>
</div>
@if(session('success'))<div class="alert alert-success">{{ session('success') }}</div>@endif

<table class="table table-dark table-striped">
<thead><tr><th>#</th><th>User</th><th>Session</th><th>Time</th><th>Status</th><th>Actions</th></tr></thead>
<tbody>
  @foreach($attendances as $a)
  <tr>
    <td>{{ $loop->iteration }}</td>
    <td>{{ $a->registration->user->name ?? '-' }}</td>
    <td>{{ $a->eventSession->title ?? '-' }}</td>
    <td>{{ $a->attendance_time ?? '-' }}</td>
    <td>{{ $a->status }}</td>
    <td>
      <a class="btn btn-sm btn-warning" href="{{ route('attendances.edit',$a) }}">Edit</a>
      <form method="POST" action="{{ route('attendances.destroy',$a) }}" class="d-inline">@csrf @method('DELETE')<button class="btn btn-sm btn-danger" onclick="return confirm('Delete?')">Delete</button></form>
    </td>
  </tr>
  @endforeach
</tbody>
</table>
{{ $attendances->links() }}
@endsection
