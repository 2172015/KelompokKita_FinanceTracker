<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class CategorySeeder extends Seeder
{
    public function run(): void
    {
        // Sesuaikan dengan ID user Anda (misal ID 1)
        $userId = 2; 

        $categories = [
            ['name' => 'Gaji', 'user_id' => $userId, 'categories_balance' => 0],
            ['name' => 'Bonus', 'user_id' => $userId, 'categories_balance' => 0],
            ['name' => 'Makanan', 'user_id' => $userId, 'categories_balance' => 0],
            ['name' => 'Transportasi', 'user_id' => $userId, 'categories_balance' => 0],
            ['name' => 'Belanja', 'user_id' => $userId, 'categories_balance' => 0],
            ['name' => 'Tagihan', 'user_id' => $userId, 'categories_balance' => 0],
            ['name' => 'Hiburan', 'user_id' => $userId, 'categories_balance' => 0],
        ];

        DB::table('categories')->insert($categories);
    }
}