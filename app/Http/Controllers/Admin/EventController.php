<?php
namespace App\Http\Controllers\Admin;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Event;

class EventController extends Controller
{
    public function index() { $events = Event::latest()->paginate(10); return view('admin.events.index', compact('events')); }
    public function create() { return view('admin.events.create'); }
    public function store(Request $r) {
        $r->validate(['title'=>'required']);
        Event::create($r->only(['title','description','date','location']));
        return redirect()->route('events.index')->with('success','Event created.');
    }
    public function edit(Event $event) { return view('admin.events.edit', compact('event')); }
    public function update(Request $r, Event $event) {
        $r->validate(['title'=>'required']);
        $event->update($r->only(['title','description','date','location']));
        return redirect()->route('events.index')->with('success','Event updated.');
    }
    public function destroy(Event $event) { $event->delete(); return redirect()->route('events.index')->with('success','Event deleted.'); }
}
