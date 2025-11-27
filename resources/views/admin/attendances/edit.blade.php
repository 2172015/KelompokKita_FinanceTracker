@extends('layouts.admin')
@section('title','Edit Attendance')
@section('content')
<form method="POST" action="{{ route('attendances.update',$attendance) }}">
  @csrf @method('PUT')
  <div class="mb-3"><label>Registration</label><select name="registration_id" class="form-select">@foreach($registrations as $reg)<option value="{{ $reg->id }}" {{ $reg->id==$attendance->registration_id?'selected':'' }}>{{ $reg->user->name ?? '—' }}</option>@endforeach</select></div>
  <div class="mb-3"><label>Session</label><select name="event_session_id" class="form-select">@foreach($sessions as $s)<option value="{{ $s->id }}" {{ $s->id==$attendance->event_session_id?'selected':'' }}>{{ $s->title }}</option>@endforeach</select></div>
  <div class="mb-3"><label>Attendance Time</label><input type="datetime-local" name="attendance_time" class="form-control" value="{{ $attendance->attendance_time ? date('Y-m-d\TH:i', strtotime($attendance->attendance_time)) : '' }}"></div>
  <div class="mb-3"><label>Status</label><select name="status" class="form-select"><option value="absen" {{ $attendance->status=='absen'?'selected':'' }}>absen</option><option value="hadir" {{ $attendance->status=='hadir'?'selected':'' }}>hadir</option></select></div>
  <button class="btn btn-primary">Update</button> <a href="{{ route('attendances.index') }}" class="btn btn-secondary">Back</a>
</form>
@endsection
