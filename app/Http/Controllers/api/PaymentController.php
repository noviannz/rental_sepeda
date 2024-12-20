<?php

namespace App\Http\Controllers\Api;

use App\Models\Payment;
use App\Models\Wallet;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class PaymentController extends Controller
{
    // Membuat pembayaran baru
    public function create(Request $request)
    {
        $request->validate([
            'rental_id' => 'required|exists:rentals,id',
            'amount' => 'required|numeric|min:0',
            'payment_type' => 'required|string',
        ]);

        // Jika menggunakan wallet sebagai metode pembayaran
        if ($request->payment_type === 'wallet') {
            $user = $request->user(); // Mendapatkan user dari token

            if (!$user) {
                return response()->json(['message' => 'User not authenticated'], 401);
            }

            $wallet = Wallet::where('user_id', $user->id)->first();

            if (!$wallet || $wallet->balance < $request->amount) {
                return response()->json(['message' => 'Insufficient wallet balance'], 400);
            }

            // Kurangi saldo dari wallet
            $wallet->balance -= $request->amount;
            $wallet->last_updated = now();
            $wallet->save();
        }

        $payment = Payment::create([
            'rental_id' => $request->rental_id,
            'payment_time' => now(),
            'amount' => $request->amount,
            'payment_type' => $request->payment_type,
            'status' => 'completed',
        ]);

        return response()->json($payment, 201);
    }
}
