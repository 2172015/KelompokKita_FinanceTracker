@extends('layouts.admin')
@section('title','Registrations')
@section('content')
<div class="mb-3 d-flex justify-content-between">
  <h3>Registrations</h3>
  <a href="{{ route('registrations.create') }}" class="btn btn-sm btn-primary">+ New</a>
</div>
@if(session('success'))<div class="alert alert-success">{{ session('success') }}</div>@endif

<table class="table table-dark table-striped">
<thead><tr><th>#</th><th>User</th><th>Session</th><th>Payment</th><th>Proof</th><th>Actions</th></tr></thead>
<tbody>
  @foreach($registrations as $r)
  <tr>
    <td>{{ $loop->iteration }}</td>
    <td>{{ $r->user->name ?? '—' }}</td>
    <td>{{ $r->eventSession->title ?? '—' }}</td>
    <td>{{ $r->payment_status }}</td>
    <td>{{ $r->payment_proof ?? '-' }}</td>
    <td>
      <a class="btn btn-sm btn-info" href="{{ route('registrations.show',$r) }}">Show</a>
      <a class="btn btn-sm btn-warning" href="{{ route('registrations.edit',$r) }}">Edit</a>
      <form method="POST" action="{{ route('registrations.destroy',$r) }}" class="d-inline">@csrf @method('DELETE')<button class="btn btn-sm btn-danger" onclick="return confirm('Delete?')">Delete</button></form>
    </td>
  </tr>
  @endforeach
</tbody>
</table>
{{ $registrations->links() }}
@endsection
