<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Attendance extends Model
{
    use HasFactory;

    protected $fillable = [
        'registration_id',
        'event_session_id',
        'attendance_time',
        'status',
    ];

    public function registration()
    {
        return $this->belongsTo(Registration::class);
    }

    public function eventSession()
    {
        return $this->belongsTo(EventSession::class);
    }
}
