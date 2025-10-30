@extends('layouts.app')

@section('content')
<div class="container mt-4">
    <h2>Tambah Registrasi</h2>
    <form action="{{ route('registrations.store') }}" method="POST">
        @csrf
        <div class="mb-3">
            <label>Peserta</label>
            <select name="user_id" class="form-select" required>
                @foreach($users as $user)
                    <option value="{{ $user->id }}">{{ $user->name }}</option>
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
            <label>Status Pembayaran</label>
            <select name="payment_status" class="form-select">
                <option value="belum">Belum</option>
                <option value="proses">Proses</option>
                <option value="disetujui">Disetujui</option>
            </select>
        </div>

        <div class="mb-3">
            <label>Bukti Pembayaran</label>
            <input type="text" name="payment_proof" class="form-control">
        </div>

        <button class="btn btn-success">Simpan</button>
        <a href="{{ route('registrations.index') }}" class="btn btn-secondary">Kembali</a>
    </form>
</div>
@endsection
