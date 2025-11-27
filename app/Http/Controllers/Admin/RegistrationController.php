<?php
namespace App\Http\Controllers\Admin;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Registration;
use App\Models\User;
use App\Models\EventSession;

class RegistrationController extends Controller
{
    public function index() { $registrations = Registration::with(['user','eventSession.event'])->latest()->paginate(10); return view('admin.registrations.index', compact('registrations')); }
    public function create() { $users = User::all(); $sessions = EventSession::all(); return view('admin.registrations.create', compact('users','sessions')); }
    public function store(Request $r) {
        $r->validate(['user_id'=>'required|exists:users,id','event_session_id'=>'required|exists:event_sessions,id']);
        Registration::create($r->only(['user_id','event_session_id','payment_status','payment_proof']));
        return redirect()->route('registrations.index')->with('success','Registration created.');
    }
    public function edit(Registration $registration) { $users = User::all(); $sessions = EventSession::all(); return view('admin.registrations.edit', compact('registration','users','sessions')); }
    public function update(Request $r, Registration $registration) {
        $r->validate(['user_id'=>'required|exists:users,id','event_session_id'=>'required|exists:event_sessions,id']);
        $registration->update($r->only(['user_id','event_session_id','payment_status','payment_proof']));
        return redirect()->route('registrations.index')->with('success','Registration updated.');
    }
    public function destroy(Registration $registration) { $registration->delete(); return redirect()->route('registrations.index')->with('success','Registration deleted.'); }
    public function show(Registration $registration) { return view('admin.registrations.show', compact('registration')); }
}
