<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Event extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'description',
        'location',
        'price',
        'quota',
        'start_date',
        'end_date',
    ];

    /**
     * Relasi: Event memiliki banyak sesi.
     */
    public function sessions()
    {
        return $this->hasMany(Session::class);
    }

    /**
     * Relasi: Event memiliki banyak registrasi.
     */
    public function registrations()
    {
        return $this->hasMany(Registration::class);
    }
}
