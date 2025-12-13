<?php

namespace App\Http\Controllers;

use App\Models\Category;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class CategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        // Ambil semua data kategori
        // Jika kategori bersifat global (semua user sama), gunakan Category::all()
        // Jika kategori per user, gunakan: Category::where('user_id', auth()->id())->get();
        $categories = Category::where('user_id', Auth::id())->get();

        // Arahkan ke folder resources/views/categories/categories.blade.php
        return view('index.categories.categories', compact('categories'));
    }

    /**
     * Show the form for creating a new resource.
     */
/**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        // Arahkan ke file view create yang akan kita buat
        return view('index.categories.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // 1. Validasi Input (PERBAIKAN DI SINI)
        $request->validate([
            'name' => [
                'required',
                'string',
                'max:50',
                // Cek unik hanya untuk user_id yang sedang login
                Rule::unique('categories')->where(function ($query) {
                    return $query->where('user_id', Auth::id());
                }),
            ],
        ], [
            'name.required' => 'Nama kategori tidak boleh kosong.',
            'name.unique' => 'Nama kategori ini sudah Anda miliki.',
        ]);

        // 2. Simpan ke Database
        Category::create([
            'name' => $request->name,
            'categories_balance' => 0,
            'user_id' => Auth::id(), 
        ]);

        // 3. Redirect kembali
        return redirect()->route('categories.index') 
                         ->with('success', 'Kategori berhasil ditambahkan!');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        // 1. Cari kategori
        $category = Category::findOrFail($id);

        // 2. CEK KEAMANAN: Apakah saldo sudah 0?
        if ($category->categories_balance != 0) {
            // Jika tidak 0, batalkan dan kembalikan dengan pesan error
            return back()->with('error', 'Gagal hapus! Kategori masih memiliki saldo (Rp ' . number_format($category->categories_balance) . '). Kosongkan saldo terlebih dahulu.');
        }

        // 3. Jika aman, lakukan penghapusan
        $category->delete();

        return back()->with('success', 'Kategori berhasil dihapus.');
    }
}
