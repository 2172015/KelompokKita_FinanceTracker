<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Transaction extends Model
{
    use HasFactory;

    // Tabel transactions di script SQL Anda TIDAK memiliki created_at/updated_at
    public $timestamps = false; 

    protected $fillable = [
        'amount',
        'type', // ENUM: 'income', 'expense'
        'date',
        'transaction_notes',
        'account_id',
        'category_id',
    ];

    // Agar kolom date otomatis dibaca sebagai Carbon Object
    protected $casts = [
        'date' => 'date',
        'amount' => 'decimal:2',
    ];

    // Relasi: Transaksi milik satu Akun
    public function account()
    {
        return $this->belongsTo(Account::class);
    }

    // Relasi: Transaksi masuk ke satu Kategori
    public function category()
    {
        return $this->belongsTo(Category::class);
    }
}
