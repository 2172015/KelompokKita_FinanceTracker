@extends('layouts.admin')

@section('title', 'Scan Attendance')

@section('content')
<div class="container mt-4">

    <h2 class="mb-4 fw-bold">Scan QR Code Kehadiran</h2>

    {{-- Alert pesan sukses atau error --}}
    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    @if(session('error'))
        <div class="alert alert-danger">{{ session('error') }}</div>
    @endif


    {{-- Form Scan QR --}}
    <div class="card shadow-sm mb-4">
        <div class="card-body">

            <form action="{{ route('attendance.scan') }}" method="POST">
                @csrf

                <label class="form-label fw-bold">Masukkan Kode QR / Token Presensi</label>
                <input 
                    type="text" 
                    name="qr_code" 
                    class="form-control mb-3"
                    placeholder="Tempelkan hasil scan QR di sini..."
                    required
                >

                <label class="form-label fw-bold">Pilih Sesi Event</label>
                <select class="form-select mb-3" name="event_session_id" required>
                    <option value="">-- Pilih Sesi --</option>

                    @foreach($sessions as $session)
                        <option value="{{ $session->id }}">
                            {{ $session->event->title }} — {{ $session->session_name }}
                            ({{ $session->start_time }} - {{ $session->end_time }})
                        </option>
                    @endforeach

                </select>

                <button type="submit" class="btn btn-primary px-4 mt-2">
                    Scan Kehadiran
                </button>
            </form>
        </div>
    </div>


    {{-- Tabel Riwayat Kehadiran --}}
    <div class="card shadow-sm">
        <div class="card-header fw-bold">
            Riwayat Scan Kehadiran
        </div>

        <div class="card-body">
            <table class="table table-bordered align-middle">
                <thead class="table-light">
                    <tr>
                        <th>#</th>
                        <th>Nama Peserta</th>
                        <th>Event</th>
                        <th>Sesi</th>
                        <th>Waktu Scan</th>
                    </tr>
                </thead>

                <tbody>
                    @foreach($attendances as $i => $att)
                        <tr>
                            <td>{{ $i + 1 }}</td>
                            <td>{{ $att->registration->user->name }}</td>
                            <td>{{ $att->registration->event->title }}</td>
                            <td>{{ $att->session->session_name }}</td>
                            <td>{{ $att->created_at->format('d M Y H:i') }}</td>
                        </tr>
                    @endforeach

                    @if($attendances->count() == 0)
                        <tr>
                            <td colspan="5" class="text-center text-muted">
                                Belum ada data presensi.
                            </td>
                        </tr>
                    @endif
                </tbody>
            </table>
        </div>
    </div>

</div>
@endsection
