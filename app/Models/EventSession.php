<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class EventSession extends Model
{
    use HasFactory;

    protected $fillable = [
        'event_id',
        'name',
        'start_time',
        'end_time',
    ];

    /**
     * Relasi: Session milik satu Event.
     */
    public function event()
    {
        return $this->belongsTo(Event::class);
    }

    /**
     * Relasi: Session memiliki banyak attendance scan.
     */
    public function attendances()
    {
        return $this->hasMany(Attendance::class, 'session_id');
    }
}
