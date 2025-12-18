<?php

namespace Tests\Feature;

use App\Models\User;
use App\Models\Account;
use App\Models\Category;
use App\Models\Transaction;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class TransactionTest extends TestCase
{
    // RefreshDatabase akan mereset DB setiap kali test jalan (migrasi ulang otomatis)
    use RefreshDatabase;

    public function test_user_can_create_transaction()
    {
        // 1. ARRANGE (Persiapan Data)
        // Buat User pura-pura
        $user = User::factory()->create();
        
        // Buat Akun & Kategori milik user tersebut
        // (Kita buat manual karena mungkin Anda belum setup Factory untuk Account/Category)
        $account = Account::create([
            'name' => 'Dompet Cash',
            'balance' => 1000000,
            'user_id' => $user->id
        ]);

        $category = Category::create([
            'name' => 'Makanan',
            'categories_balance' => 0,
            'user_id' => $user->id
        ]);

        // 2. ACT (Lakukan Aksi)
        // Login sebagai user tersebut, lalu post data ke route store
        $response = $this->actingAs($user)
                         ->post(route('transactions.store'), [
                             'date' => '2023-12-18',
                             'type' => 'expense',
                             'amount' => 50000,
                             'category_id' => $category->id,
                             'account_id' => $account->id,
                             'transaction_notes' => 'Beli Nasi Goreng Testing',
                         ]);

        // 3. ASSERT (Cek Hasil)
        // Pastikan tidak ada error dan di-redirect kembali (biasanya ke index)
        $response->assertSessionHasNoErrors();
        $response->assertRedirect(route('dashboard'));

        // Cek apakah data masuk ke tabel 'transactions'
        $this->assertDatabaseHas('transactions', [
            'amount' => 50000,
            'transaction_notes' => 'Beli Nasi Goreng Testing',
            'account_id' => $account->id,
        ]);

        // Cek apakah saldo akun berkurang (karena expense)
        // Saldo awal 1.000.000 - 50.000 = 950.000
        $this->assertDatabaseHas('accounts', [
            'id' => $account->id,
            'balance' => 950000
        ]);
    }

    public function test_user_can_delete_transaction_and_balance_is_restored()
    {
        // 1. ARRANGE: Siapkan User, Akun (Saldo 1 Juta), dan Transaksi Pengeluaran (100rb)
        $user = User::factory()->create();
        
        $account = Account::create([
            'name' => 'Bank BCA',
            'balance' => 900000, // Saldo sudah terpotong transaksi
            'user_id' => $user->id
        ]);

        $category = Category::create([
            'name' => 'Jajan',
            'categories_balance' => 0,
            'user_id' => $user->id
        ]);

        $transaction = Transaction::create([
            'account_id' => $account->id,
            'category_id' => $category->id,
            'amount' => 100000,
            'type' => 'expense',
            'date' => now(),
            'transaction_notes' => 'Akan dihapus',
        ]);

        // 2. ACT: Login & Hapus Transaksi
        $response = $this->actingAs($user)
                        ->delete(route('transactions.destroy', $transaction->id));

        // 3. ASSERT: Cek Hasil
        // Pastikan redirect back/sukses
        $response->assertSessionHasNoErrors();
        
        // Pastikan data hilang dari tabel transactions
        $this->assertDatabaseMissing('transactions', ['id' => $transaction->id]);

        // PENTING: Cek saldo akun. Harusnya kembali jadi 1.000.000 (900rb + 100rb)
        $this->assertDatabaseHas('accounts', [
            'id' => $account->id,
            'balance' => 1000000 
        ]);
    }

    public function test_user_cannot_delete_others_transaction()
    {
        // 1. Siapkan User A (Maling) dan User B (Korban)
        $userMaling = User::factory()->create();
        $userKorban = User::factory()->create();

        // 2. Buat Transaksi milik User B (Korban)
        $accountB = Account::create(['name' => 'Tabungan B', 'balance' => 50000, 'user_id' => $userKorban->id]);
        $categoryB = Category::create(['name' => 'Umum', 'categories_balance' => 0, 'user_id' => $userKorban->id]);
        
        $transactionMilikB = Transaction::create([
            'account_id' => $accountB->id,
            'category_id' => $categoryB->id,
            'amount' => 50000,
            'type' => 'expense',
            'date' => now(),
            'transaction_notes' => 'Rahasia',
        ]);

        // 3. ACT: Login sebagai User A, tapi coba hapus transaksi User B
        $response = $this->actingAs($userMaling)
                        ->delete(route('transactions.destroy', $transactionMilikB->id));

        // 4. ASSERT: Harus Gagal (403 Forbidden)
        $response->assertStatus(403);

        // Pastikan data transaksi MASIH ADA di database (tidak terhapus)
        $this->assertDatabaseHas('transactions', ['id' => $transactionMilikB->id]);
    }

    public function test_create_transaction_requires_validation()
    {
        $user = User::factory()->create();

        // Coba submit data KOSONG
        $response = $this->actingAs($user)
                        ->post(route('transactions.store'), []);

        // Harusnya ada error di session pada field berikut
        $response->assertSessionHasErrors(['amount', 'date', 'type', 'account_id', 'category_id']);
    }
}