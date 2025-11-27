@extends('layouts.admin')

@section('title', 'Dashboard')

@section('content')
<div class="row">
    <div class="col-md-3">
        <div class="card card-dark p-4">
            <h5>Total Events</h5>
            <h3>{{ $totalEvents }}</h3>
        </div>
    </div>
    <div class="col-md-3">
        <div class="card card-dark p-4">
            <h5>Total Sessions</h5>
            <h3>{{ $totalSessions }}</h3>
        </div>
    </div>
    <div class="col-md-3">
        <div class="card card-dark p-4">
            <h5>Total Registrations</h5>
            <h3>{{ $totalRegistrations }}</h3>
        </div>
    </div>
    <div class="col-md-3">
        <div class="card card-dark p-4">
            <h5>Total Attendance</h5>
            <h3>{{ $totalAttendance }}</h3>
        </div>
    </div>
</div>
@endsection
