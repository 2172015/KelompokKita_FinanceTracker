<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Attendance;

class AttendanceController extends Controller
{
    public function index()
    {
        $attendances = Attendance::all();
        return view('admin.attendance.index', compact('attendances'));
    }

    public function scan(Request $request)
    {
        $request->validate(['qr_code' => 'required|string']);
        // logika pemindaian QR di sini
        return back()->with('success', 'QR scanned successfully!');
    }
}
