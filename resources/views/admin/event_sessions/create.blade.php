@extends('layouts.app')

@section('content')
<div class="container mt-4">
    <h2>Tambah Sesi Event</h2>

    <form action="{{ route('event-sessions.store') }}" method="POST">
        @csrf
        <div class="mb-3">
            <label>Event</label>
            <select name="event_id" class="form-select">
                <option value="">-- Pilih Event --</option>
                @foreach($events as $event)
                    <option value="{{ $event->id }}">{{ $event->title }}</option>
                @endforeach
            </select>
        </div>

        <div class="mb-3">
            <label>Judul</label>
            <input type="text" name="title" class="form-control" required>
        </div>

        <div class="mb-3">
            <label>Pembicara</label>
            <input type="text" name="speaker" class="form-control">
        </div>

        <div class="mb-3">
            <label>Deskripsi</label>
            <textarea name="description" class="form-control"></textarea>
        </div>

        <div class="row mb-3">
            <div class="col">
                <label>Waktu Mulai</label>
                <input type="datetime-local" name="start_time" class="form-control" required>
            </div>
            <div class="col">
                <label>Waktu Selesai</label>
                <input type="datetime-local" name="end_time" class="form-control" required>
            </div>
        </div>

        <div class="mb-3">
            <label>Harga</label>
            <input type="number" name="price" class="form-control" value="0">
        </div>

        <button type="submit" class="btn btn-success">Simpan</button>
        <a href="{{ route('event-sessions.index') }}" class="btn btn-secondary">Kembali</a>
    </form>
</div>
@endsection
