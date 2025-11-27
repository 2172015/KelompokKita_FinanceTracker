@extends('layouts.admin')
@section('title','Create Attendance')
@section('content')
<form method="POST" action="{{ route('attendances.store') }}">
  @csrf
  <div class="mb-3"><label>Registration</label><select name="registration_id" class="form-select">@foreach($registrations as $reg)<option value="{{ $reg->id }}">{{ $reg->user->name ?? '—' }} — {{ $reg->eventSession->title ?? '—' }}</option>@endforeach</select></div>
  <div class="mb-3"><label>Session</label><select name="event_session_id" class="form-select">@foreach($sessions as $s)<option value="{{ $s->id }}">{{ $s->title }}</option>@endforeach</select></div>
  <div class="mb-3"><label>Attendance Time</label><input type="datetime-local" name="attendance_time" class="form-control"></div>
  <div class="mb-3"><label>Status</label><select name="status" class="form-select"><option value="absen">absen</option><option value="hadir">hadir</option></select></div>
  <button class="btn btn-success">Save</button> <a href="{{ route('attendances.index') }}" class="btn btn-secondary">Back</a>
</form>
@endsection
