<?php

namespace App\Http\Controllers;

use App\Models\Attendance;
use App\Models\Registration;
use App\Models\EventSession;
use Illuminate\Http\Request;

class AttendanceController extends Controller
{
    public function index()
    {
        $attendances = Attendance::with(['registration.user', 'eventSession'])->latest()->paginate(10);
        return view('admin.attendances.index', compact('attendances'));
    }

    public function create()
    {
        $registrations = Registration::with('user')->get();
        $sessions = EventSession::all();
        return view('admin.attendances.create', compact('registrations', 'sessions'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'registration_id' => 'required|exists:registrations,id',
            'event_session_id' => 'required|exists:event_sessions,id',
            'attendance_time' => 'nullable|date',
            'status' => 'required|string',
        ]);

        Attendance::create($validated);
        return redirect()->route('attendances.index')->with('success', 'Data kehadiran berhasil ditambahkan.');
    }

    public function edit(Attendance $attendance)
    {
        $registrations = Registration::with('user')->get();
        $sessions = EventSession::all();
        return view('admin.attendances.edit', compact('attendance', 'registrations', 'sessions'));
    }

    public function update(Request $request, Attendance $attendance)
    {
        $validated = $request->validate([
            'registration_id' => 'required|exists:registrations,id',
            'event_session_id' => 'required|exists:event_sessions,id',
            'attendance_time' => 'nullable|date',
            'status' => 'required|string',
        ]);

        $attendance->update($validated);
        return redirect()->route('attendances.index')->with('success', 'Data kehadiran berhasil diperbarui.');
    }

    public function destroy(Attendance $attendance)
    {
        $attendance->delete();
        return redirect()->route('attendances.index')->with('success', 'Data kehadiran berhasil dihapus.');
    }
}
