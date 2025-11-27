<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Registration extends Model
{
    use HasFactory;

    protected $fillable = [
        'event_id',
        'user_id',
        'payment_proof',
        'payment_status',
        'qr_code_path',
    ];

    /**
     * Relasi: Registrasi milik satu Event.
     */
    public function event()
    {
        return $this->belongsTo(Event::class);
    }

    /**
     * Relasi: Registrasi milik satu User.
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Relasi: Registrasi memiliki banyak attendance.
     */
    public function attendances()
    {
        return $this->hasMany(Attendance::class);
    }
}
