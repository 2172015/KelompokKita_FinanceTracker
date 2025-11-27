<?php
namespace App\Http\Controllers\Admin;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Attendance;
use App\Models\Registration;
use App\Models\EventSession;
use Carbon\Carbon;

class AttendanceController extends Controller
{
    public function index() { $attendances = Attendance::with(['registration.user','eventSession'])->latest()->paginate(10); return view('admin.attendances.index', compact('attendances')); }

    public function create() { $registrations = Registration::with('user')->get(); $sessions = EventSession::all(); return view('admin.attendances.create', compact('registrations','sessions')); }

    public function store(Request $r) {
        $r->validate(['registration_id'=>'required|exists:registrations,id','event_session_id'=>'required|exists:event_sessions,id','status'=>'required']);
        $data = $r->only(['registration_id','event_session_id','status']);
        $data['attendance_time'] = $r->attendance_time ? Carbon::parse($r->attendance_time) : now();
        Attendance::create($data);
        return redirect()->route('attendances.index')->with('success','Attendance recorded.');
    }

    public function edit(Attendance $attendance) { $registrations = Registration::with('user')->get(); $sessions = EventSession::all(); return view('admin.attendances.edit', compact('attendance','registrations','sessions')); }

    public function update(Request $r, Attendance $attendance) {
        $r->validate(['registration_id'=>'required|exists:registrations,id','event_session_id'=>'required|exists:event_sessions,id','status'=>'required']);
        $attendance->update($r->only(['registration_id','event_session_id','attendance_time','status']));
        return redirect()->route('attendances.index')->with('success','Attendance updated.');
    }

    public function destroy(Attendance $attendance) { $attendance->delete(); return redirect()->route('attendances.index')->with('success','Attendance deleted.'); }

    // optional: scan endpoint for QR code (simple)
    public function scan(Request $r) {
        $r->validate(['qr_code'=>'required|string']);
        // implement QR decode -> find registration/session -> create attendance
        return back()->with('success','QR processed (implement logic).');
    }
}
