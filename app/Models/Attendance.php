<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Attendance extends Model
{
    use HasFactory;

    protected $fillable = [
        'registration_id',
        'session_id',
        'scan_time',
    ];

    /**
     * Relasi: Attendance milik satu registrasi.
     */
    public function registration()
    {
        return $this->belongsTo(Registration::class);
    }

    /**
     * Relasi: Attendance milik satu sesi.
     */
    public function session()
    {
        return $this->belongsTo(EventSession::class);
    }
}
