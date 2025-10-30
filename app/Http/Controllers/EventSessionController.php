<?php

namespace App\Http\Controllers;

use App\Models\Event;
use App\Models\EventSession;
use Illuminate\Http\Request;

class EventSessionController extends Controller
{
    public function index()
    {
        $sessions = EventSession::with('event')->latest()->paginate(10);
        return view('admin.event_sessions.index', compact('sessions'));
    }

    public function create()
    {
        $events = Event::all();
        return view('admin.event_sessions.create', compact('events'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'event_id' => 'required|exists:events,id',
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'speaker' => 'nullable|string|max:255',
            'start_time' => 'required|date',
            'end_time' => 'required|date|after:start_time',
            'price' => 'nullable|integer|min:0',
        ]);

        EventSession::create($validated);
        return redirect()->route('event-sessions.index')->with('success', 'Sesi event berhasil ditambahkan.');
    }

    public function edit(EventSession $eventSession)
    {
        $events = Event::all();
        return view('admin.event_sessions.edit', compact('eventSession', 'events'));
    }

    public function update(Request $request, EventSession $eventSession)
    {
        $validated = $request->validate([
            'event_id' => 'required|exists:events,id',
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'speaker' => 'nullable|string|max:255',
            'start_time' => 'required|date',
            'end_time' => 'required|date|after:start_time',
            'price' => 'nullable|integer|min:0',
        ]);

        $eventSession->update($validated);
        return redirect()->route('event-sessions.index')->with('success', 'Sesi event berhasil diperbarui.');
    }

    public function destroy(EventSession $eventSession)
    {
        $eventSession->delete();
        return redirect()->route('event-sessions.index')->with('success', 'Sesi event berhasil dihapus.');
    }
}
