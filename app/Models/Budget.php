<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Budget extends Model
{
    use HasFactory;

    public $timestamps = false;

    protected $fillable = [
        'account_id',       // Kunci utama relasi
        'name',
        'starting_balance',
        'target_balance',   // (Opsional) Target saldo yang ingin dicapai
        'maximum_expense',  // Batas pengeluaran untuk akun ini
        'minimum_balance',  // (Opsional) Saldo minimal jaga-jaga
        'budgets_notes',
    ];

    protected $casts = [
        'starting_balance' => 'decimal:2',
        'target_balance'   => 'decimal:2',
        'maximum_expense'  => 'decimal:2',
        'minimum_balance'  => 'decimal:2',
    ];

    // Relasi: Budget terhubung ke satu Kategori
    public function account()
    {
        return $this->belongsTo(Account::class);
    }
}
