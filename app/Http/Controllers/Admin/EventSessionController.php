<?php
namespace App\Http\Controllers\Admin;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\EventSession;
use App\Models\Event;

class EventSessionController extends Controller
{
    public function index() { $sessions = EventSession::with('event')->latest()->paginate(10); return view('admin.sessions.index', compact('sessions')); }
    public function create() { $events = Event::all(); return view('admin.sessions.create', compact('events')); }
    public function store(Request $r) {
        $r->validate([
            'event_id'=>'required|exists:events,id',
            'title'=>'required',
            'start_time'=>'required|date',
            'end_time'=>'required|date|after:start_time'
        ]);
        EventSession::create($r->only(['event_id','title','description','speaker','start_time','end_time','price']));
        return redirect()->route('event-sessions.index')->with('success','Session created.');
    }
    public function edit(EventSession $eventSession) { $events = Event::all(); return view('admin.sessions.edit', compact('eventSession','events')); }
    public function update(Request $r, EventSession $eventSession) {
        $r->validate(['title'=>'required','start_time'=>'required|date','end_time'=>'required|date|after:start_time']);
        $eventSession->update($r->only(['event_id','title','description','speaker','start_time','end_time','price']));
        return redirect()->route('event-sessions.index')->with('success','Session updated.');
    }
    public function destroy(EventSession $eventSession) { $eventSession->delete(); return redirect()->route('event-sessions.index')->with('success','Session deleted.'); }
}
