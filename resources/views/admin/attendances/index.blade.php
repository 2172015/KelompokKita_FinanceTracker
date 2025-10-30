@extends('layouts.app')

@section('content')
<div class="container mt-4">
    <div class="d-flex justify-content-between align-items-center mb-3">
        <h2>Daftar Kehadiran</h2>
        <a href="{{ route('attendances.create') }}" class="btn btn-primary">Tambah</a>
    </div>

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <table class="table table-bordered table-hover">
        <thead class="table-light">
            <tr>
                <th>#</th>
                <th>Peserta</th>
                <th>Sesi</th>
                <th>Waktu</th>
                <th>Status</th>
                <th>Aksi</th>
            </tr>
        </thead>
        <tbody>
            @forelse($attendances as $att)
            <tr>
                <td>{{ $loop->iteration }}</td>
                <td>{{ $att->registration->user->name }}</td>
                <td>{{ $att->eventSession->title }}</td>
                <td>{{ $att->attendance_time ?? '-' }}</td>
                <td>{{ ucfirst($att->status) }}</td>
                <td>
                    <a href="{{ route('attendances.edit', $att->id) }}" class="btn btn-sm btn-warning">Edit</a>
                    <form action="{{ route('attendances.destroy', $att->id) }}" method="POST" class="d-inline">
                        @csrf @method('DELETE')
                        <button class="btn btn-sm btn-danger" onclick="return confirm('Hapus data ini?')">Hapus</button>
                    </form>
                </td>
            </tr>
            @empty
            <tr><td colspan="6" class="text-center">Belum ada data.</td></tr>
            @endforelse
        </tbody>
    </table>

    {{ $attendances->links() }}
</div>
@endsection
