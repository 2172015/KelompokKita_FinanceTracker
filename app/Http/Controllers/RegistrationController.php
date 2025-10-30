<?php

namespace App\Http\Controllers;

use App\Models\Registration;
use App\Models\User;
use App\Models\EventSession;
use Illuminate\Http\Request;

class RegistrationController extends Controller
{
    public function index()
    {
        $registrations = Registration::with(['user', 'eventSession'])->latest()->paginate(10);
        return view('admin.registrations.index', compact('registrations'));
    }

    public function create()
    {
        $users = User::all();
        $sessions = EventSession::all();
        return view('admin.registrations.create', compact('users', 'sessions'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'user_id' => 'required|exists:users,id',
            'event_session_id' => 'required|exists:event_sessions,id',
            'payment_status' => 'required|string',
            'payment_proof' => 'nullable|string',
        ]);

        Registration::create($validated);
        return redirect()->route('registrations.index')->with('success', 'Registrasi berhasil ditambahkan.');
    }

    public function edit(Registration $registration)
    {
        $users = User::all();
        $sessions = EventSession::all();
        return view('admin.registrations.edit', compact('registration', 'users', 'sessions'));
    }

    public function update(Request $request, Registration $registration)
    {
        $validated = $request->validate([
            'user_id' => 'required|exists:users,id',
            'event_session_id' => 'required|exists:event_sessions,id',
            'payment_status' => 'required|string',
            'payment_proof' => 'nullable|string',
        ]);

        $registration->update($validated);
        return redirect()->route('registrations.index')->with('success', 'Registrasi berhasil diperbarui.');
    }

    public function destroy(Registration $registration)
    {
        $registration->delete();
        return redirect()->route('registrations.index')->with('success', 'Registrasi berhasil dihapus.');
    }
}
