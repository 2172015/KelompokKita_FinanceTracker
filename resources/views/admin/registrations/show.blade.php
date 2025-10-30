@extends('layouts.app')

@section('title', 'Registration Detail')

@section('content')
<h1>Registration #{{ $registration->id }}</h1>
<ul class="list-group">
    <li class="list-group-item"><strong>User:</strong> {{ $registration->user->name ?? 'N/A' }}</li>
    <li class="list-group-item"><strong>Event:</strong> {{ $registration->event->name ?? 'N/A' }}</li>
    <li class="list-group-item"><strong>Status:</strong> {{ $registration->status }}</li>
</ul>
<a href="{{ route('registrations.index') }}" class="btn btn-secondary mt-3">Back</a>
@endsection
