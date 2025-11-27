@extends('layouts.admin')
@section('title','Create Registration')
@section('content')
<form method="POST" action="{{ route('registrations.store') }}">
  @csrf
  <div class="mb-3">
    <label>User</label>
    <select name="user_id" class="form-select">
      @foreach($users as $u)<option value="{{ $u->id }}">{{ $u->name }}</option>@endforeach
    </select>
  </div>
  <div class="mb-3">
    <label>Session</label>
    <select name="event_session_id" class="form-select">@foreach($sessions as $s)<option value="{{ $s->id }}">{{ $s->title }}</option>@endforeach</select>
  </div>
  <div class="mb-3"><label>Payment Status</label><select name="payment_status" class="form-select"><option value="belum">belum</option><option value="proses">proses</option><option value="disetujui">disetujui</option></select></div>
  <div class="mb-3"><label>Payment Proof (path)</label><input name="payment_proof" class="form-control"></div>
  <button class="btn btn-success">Save</button> <a href="{{ route('registrations.index') }}" class="btn btn-secondary">Back</a>
</form>
@endsection
