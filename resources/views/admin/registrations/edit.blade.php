@extends('layouts.admin')
@section('title','Edit Registration')
@section('content')
<form method="POST" action="{{ route('registrations.update',$registration) }}">
  @csrf @method('PUT')
  <div class="mb-3"><label>User</label><select name="user_id" class="form-select">@foreach($users as $u)<option value="{{ $u->id }}" {{ $u->id==$registration->user_id?'selected':'' }}>{{ $u->name }}</option>@endforeach</select></div>
  <div class="mb-3"><label>Session</label><select name="event_session_id" class="form-select">@foreach($sessions as $s)<option value="{{ $s->id }}" {{ $s->id==$registration->event_session_id?'selected':'' }}>{{ $s->title }}</option>@endforeach</select></div>
  <div class="mb-3"><label>Payment Status</label><select name="payment_status" class="form-select"><option value="belum" {{ $registration->payment_status=='belum'?'selected':'' }}>belum</option><option value="proses" {{ $registration->payment_status=='proses'?'selected':'' }}>proses</option><option value="disetujui" {{ $registration->payment_status=='disetujui'?'selected':'' }}>disetujui</option></select></div>
  <div class="mb-3"><label>Payment Proof</label><input name="payment_proof" class="form-control" value="{{ $registration->payment_proof }}"></div>
  <button class="btn btn-primary">Update</button> <a href="{{ route('registrations.index') }}" class="btn btn-secondary">Back</a>
</form>
@endsection
