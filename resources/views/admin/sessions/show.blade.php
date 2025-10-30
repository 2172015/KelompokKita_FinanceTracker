@extends('layouts.app')

@section('title', 'Session Details')

@section('content')
<h1>{{ $session->title }}</h1>
<ul class="list-group">
    <li class="list-group-item"><strong>Speaker:</strong> {{ $session->speaker }}</li>
    <li class="list-group-item"><strong>Date:</strong> {{ $session->date }}</li>
    <li class="list-group-item"><strong>Time:</strong> {{ $session->time }}</li>
</ul>
<a href="{{ route('sessions.index') }}" class="btn btn-secondary mt-3">Back</a>
@endsection
