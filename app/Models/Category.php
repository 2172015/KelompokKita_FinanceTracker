<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Category extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'categories_balance', // Sesuai nama kolom di SQL
        'user_id',
    ];

    protected $casts = [
        'categories_balance' => 'decimal:2',
    ];

    // Relasi: Kategori dimiliki oleh satu User
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    // Relasi: Kategori bisa ada di banyak Transaksi
    public function transactions()
    {
        return $this->hasMany(Transaction::class);
    }
}
