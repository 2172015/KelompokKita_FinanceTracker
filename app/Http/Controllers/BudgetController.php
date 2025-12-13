<?php

namespace App\Http\Controllers;

use App\Models\Budget;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class BudgetController extends Controller
{
    // Hapus Index, Create, Store, Destroy (Tidak dipakai lagi)

    public function edit($id)
    {
        // Pastikan budget milik user yang login (via relasi account)
        $budget = Budget::whereHas('account', function($q) {
            $q->where('user_id', Auth::id());
        })->findOrFail($id);

        return view('index.budgets.edit', compact('budget'));
    }

    public function update(Request $request, $id)
    {
        $budget = Budget::findOrFail($id);
        
        // Validasi Keamanan (Milik User Sendiri)
        if ($budget->account->user_id != Auth::id()) {
            abort(403);
        }
    
        $request->validate([
            'maximum_expense' => 'required|numeric|min:0',
            'target_balance'  => 'required|numeric|min:0', // Tambahan
            'minimum_balance' => 'required|numeric|min:0', // Tambahan
            'budgets_notes'   => 'nullable|string',
        ]);
    
        $budget->update([
            'maximum_expense' => $request->maximum_expense,
            'target_balance'  => $request->target_balance,
            'minimum_balance' => $request->minimum_balance,
            'budgets_notes'   => $request->budgets_notes,
        ]);
    
        return redirect()->route('dashboard')->with('success', 'Rencana Budget berhasil diperbarui!');
    }
}