@extends('layouts.admin')
@section('title','Registration Detail')
@section('content')
<div class="card card-dark p-3">
  <h4>Registration #{{ $registration->id }}</h4>
  <p><strong>User:</strong> {{ $registration->user->name ?? '-' }}</p>
  <p><strong>Session:</strong> {{ $registration->eventSession->title ?? '-' }}</p>
  <p><strong>Payment:</strong> {{ $registration->payment_status }}</p>
  <p><strong>Proof:</strong> {{ $registration->payment_proof ?? '-' }}</p>
  <a class="btn btn-secondary" href="{{ route('registrations.index') }}">Back</a>
</div>
@endsection
