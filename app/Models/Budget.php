<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Budget extends Model
{
    use HasFactory;

    // Tabel budgets di script SQL Anda TIDAK memiliki created_at/updated_at
    public $timestamps = false;

    protected $fillable = [
        'starting_balance',
        'target_balance',
        'maximum_expense',
        'minimum_balance',
        'name',
        'budgets_notes',
        'category_id',
    ];

    protected $casts = [
        'starting_balance' => 'decimal:2',
        'target_balance' => 'decimal:2',
        'maximum_expense' => 'decimal:2',
        'minimum_balance' => 'decimal:2',
    ];

    // Relasi: Budget terhubung ke satu Kategori
    public function category()
    {
        return $this->belongsTo(Category::class);
    }
}
