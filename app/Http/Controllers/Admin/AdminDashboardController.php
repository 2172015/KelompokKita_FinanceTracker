<?php
namespace App\Http\Controllers\Admin;
use App\Http\Controllers\Controller;
use App\Models\Event;
use App\Models\EventSession;
use App\Models\Registration;
use App\Models\Attendance;

class AdminDashboardController extends Controller
{
    public function index()
    {
        $totalEvents = Event::count();
        $totalSessions = EventSession::count();
        $totalRegistrations = Registration::count();
        $totalAttendance = Attendance::count();

        return view('admin.dashboard', compact('totalEvents','totalSessions','totalRegistrations','totalAttendance'));
    }
}
