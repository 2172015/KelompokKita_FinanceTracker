@extends('layouts.app')

@section('content')
<div class="container">

    <h1 class="mb-4">Events</h1>

    <a href="{{ route('events.create') }}" class="btn btn-primary mb-3">+ Add Event</a>

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <table class="table table-bordered">
        <thead>
            <tr>
                <th>Title</th>
                <th>Date</th>
                <th>Location</th>
                <th style="width: 180px">Actions</th>
            </tr>
        </thead>
        <tbody>
            @forelse ($events as $event)
                <tr>
                    <td>{{ $event->title }}</td>
                    <td>{{ $event->date ?? '-' }}</td>
                    <td>{{ $event->location ?? '-' }}</td>
                    <td>
                        <a href="{{ route('events.edit', $event->id) }}" class="btn btn-warning btn-sm">Edit</a>
                        
                        <form action="{{ route('events.destroy', $event->id) }}" method="POST"
                              onsubmit="return confirm('Delete this event?')" class="d-inline">
                            @csrf
                            @method('DELETE')
                            <button class="btn btn-danger btn-sm">Delete</button>
                        </form>

                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="4" class="text-center">No events found.</td>
                </tr>
            @endforelse
        </tbody>
    </table>

    {{ $events->links() }}

</div>
@endsection
