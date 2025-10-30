@extends('layouts.app')

@section('content')
<div class="container mt-4">
    <h2>Edit Sesi Event</h2>

    <form action="{{ route('event-sessions.update', $eventSession->id) }}" method="POST">
        @csrf @method('PUT')

        <div class="mb-3">
            <label>Event</label>
            <select name="event_id" class="form-select">
                @foreach($events as $event)
                    <option value="{{ $event->id }}" {{ $event->id == $eventSession->event_id ? 'selected' : '' }}>
                        {{ $event->title }}
                    </option>
                @endforeach
            </select>
        </div>

        <div class="mb-3">
            <label>Judul</label>
            <input type="text" name="title" class="form-control" value="{{ $eventSession->title }}" required>
        </div>

        <div class="mb-3">
            <label>Pembicara</label>
            <input type="text" name="speaker" class="form-control" value="{{ $eventSession->speaker }}">
        </div>

        <div class="mb-3">
            <label>Deskripsi</label>
            <textarea name="description" class="form-control">{{ $eventSession->description }}</textarea>
        </div>

        <div class="row mb-3">
            <div class="col">
                <label>Waktu Mulai</label>
                <input type="datetime-local" name="start_time" class="form-control"
                    value="{{ date('Y-m-d\TH:i', strtotime($eventSession->start_time)) }}" required>
            </div>
            <div class="col">
                <label>Waktu Selesai</label>
                <input type="datetime-local" name="end_time" class="form-control"
                    value="{{ date('Y-m-d\TH:i', strtotime($eventSession->end_time)) }}" required>
            </div>
        </div>

        <div class="mb-3">
            <label>Harga</label>
            <input type="number" name="price" class="form-control" value="{{ $eventSession->price }}">
        </div>

        <button type="submit" class="btn btn-primary">Perbarui</button>
        <a href="{{ route('event-sessions.index') }}" class="btn btn-secondary">Kembali</a>
    </form>
</div>
@endsection
