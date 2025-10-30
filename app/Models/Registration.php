<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Registration extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'event_session_id',
        'payment_status',
        'payment_proof',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function eventSession()
    {
        return $this->belongsTo(EventSession::class);
    }

    public function attendances()
    {
        return $this->hasMany(Attendance::class);
    }
}
