@extends('layouts.app')

@section('content')
<div class="container mt-4">
    <div class="d-flex justify-content-between align-items-center mb-3">
        <h2>Daftar Sesi Event</h2>
        <a href="{{ route('event-sessions.create') }}" class="btn btn-primary">Tambah Sesi</a>
    </div>

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <table class="table table-bordered table-hover">
        <thead class="table-light">
            <tr>
                <th>#</th>
                <th>Event</th>
                <th>Judul</th>
                <th>Pembicara</th>
                <th>Waktu Mulai</th>
                <th>Waktu Selesai</th>
                <th>Harga</th>
                <th>Aksi</th>
            </tr>
        </thead>
        <tbody>
            @forelse($sessions as $session)
            <tr>
                <td>{{ $loop->iteration }}</td>
                <td>{{ $session->event->title }}</td>
                <td>{{ $session->title }}</td>
                <td>{{ $session->speaker ?? '-' }}</td>
                <td>{{ $session->start_time }}</td>
                <td>{{ $session->end_time }}</td>
                <td>Rp {{ number_format($session->price, 0, ',', '.') }}</td>
                <td>
                    <a href="{{ route('event-sessions.edit', $session->id) }}" class="btn btn-sm btn-warning">Edit</a>
                    <form action="{{ route('event-sessions.destroy', $session->id) }}" method="POST" class="d-inline">
                        @csrf @method('DELETE')
                        <button class="btn btn-sm btn-danger" onclick="return confirm('Hapus sesi ini?')">Hapus</button>
                    </form>
                </td>
            </tr>
            @empty
            <tr><td colspan="8" class="text-center">Belum ada sesi event.</td></tr>
            @endforelse
        </tbody>
    </table>

    {{ $sessions->links() }}
</div>
@endsection
