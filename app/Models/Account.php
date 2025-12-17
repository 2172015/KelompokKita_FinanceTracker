<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Account extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'balance',
        'user_id',
    ];

    protected $casts = [
        'balance' => 'decimal:2',
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
