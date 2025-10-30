@extends('layouts.app')

@section('content')
<div class="container mt-4">
    <h2>Tambah Kehadiran</h2>
    <form action="{{ route('attendances.store') }}" method="POST">
        @csrf
        <div class="mb-3">
            <label>Registrasi Peserta</label>
            <select name="registration_id" class="form-select" required>
                @foreach($registrations as $reg)
                    <option value="{{ $reg->id }}">{{ $reg->user->name }}</option>
                @endforeach
            </select>
        </div>

        <div class="mb-3">
            <label>Sesi Event</label>
            <select name="event_session_id" class="form-select" required>
                @foreach($sessions as $session)
                    <option value="{{ $session->id }}">{{ $session->title }}</option>
                @endforeach
            </select>
        </div>

        <div class="mb-3">
            <label>Waktu Kehadiran</label>
            <input type="datetime-local" name="attendance_time" class="form-control">
        </div>

        <div class="mb-3">
            <label>Status</label>
            <select name="status" class="form-select">
                <option value="absen">Absen</option>
                <option value="hadir">Hadir</option>
            </select>
        </div>

        <button class="btn btn-success">Simpan</button>
        <a href="{{ route('attendances.index') }}" class="btn btn-secondary">Kembali</a>
    </form>
</div>
@endsection
