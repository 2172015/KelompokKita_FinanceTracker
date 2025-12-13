<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Account extends Model
{
    use HasFactory;

    // Menonaktifkan timestamps jika tabel tidak punya created_at/updated_at
    // Tapi di script Anda tabel ini TIDAK punya timestamp, jadi set false.
    public $timestamps = false;

    protected $fillable = [
        'name',
        'balance',
        'user_id',
    ];

    // Relasi: Akun dimiliki oleh satu User (Inverse One to Many)
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    // Relasi: Akun memiliki banyak Transaksi (One to Many)
    public function transactions()
    {
        return $this->hasMany(Transaction::class);
    }

    public function budget()
{
    // hasOne artinya satu akun cuma punya satu budget
    return $this->hasOne(Budget::class);
}
}
