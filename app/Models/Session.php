<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Session extends Model
{
    protected $fillable = [
        'event_id',
        'title',
        'speaker',
        'start_time',
        'end_time',
        'price'
    ];

    public function event()
    {
        return $this->belongsTo(Event::class);
    }
}
