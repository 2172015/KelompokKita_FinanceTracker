@extends('layouts.app')

@section('content')
<div class="container mt-4">
    <div class="d-flex justify-content-between align-items-center mb-3">
        <h2>Daftar Registrasi</h2>
        <a href="{{ route('registrations.create') }}" class="btn btn-primary">Tambah</a>
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
                <th>Status Pembayaran</th>
                <th>Bukti</th>
                <th>Aksi</th>
            </tr>
        </thead>
        <tbody>
            @forelse($registrations as $reg)
            <tr>
                <td>{{ $loop->iteration }}</td>
                <td>{{ $reg->user->name }}</td>
                <td>{{ $reg->eventSession->title }}</td>
                <td>{{ ucfirst($reg->payment_status) }}</td>
                <td>{{ $reg->payment_proof ?? '-' }}</td>
                <td>
                    <a href="{{ route('registrations.edit', $reg->id) }}" class="btn btn-sm btn-warning">Edit</a>
                    <form action="{{ route('registrations.destroy', $reg->id) }}" method="POST" class="d-inline">
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

    {{ $registrations->links() }}
</div>
@endsection
