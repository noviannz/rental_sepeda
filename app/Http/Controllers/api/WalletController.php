<?php

namespace App\Http\Controllers\Api;

use App\Models\Wallet;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class WalletController extends Controller
{
    // Mendapatkan detail saldo pengguna
    public function show($id)
    {
        $wallet = Wallet::where('user_id', $id)->first();

        if (!$wallet) {
            return response()->json(['message' => 'Wallet not found'], 404);
        }

        return response()->json($wallet, 200);
    }

    // Memperbarui saldo pengguna (misalnya setelah top-up)
    public function update(Request $request, $id)
{
    $request->validate([
        'topup_amount' => 'required|integer|min:1',
    ]);

    $wallet = Wallet::where('user_id', $id)->first();

    if (!$wallet) {
        // Tambahkan respons error jika wallet tidak ditemukan
        return response()->json(['message' => 'Wallet not found'], 404);
    }

    $wallet->balance += $request->topup_amount; // Tambahkan saldo otomatis
    $wallet->last_updated = now();
    $wallet->save();

    return response()->json([
        'message' => 'Top-up successful',
        'wallet' => $wallet,
    ], 200);
}

}
