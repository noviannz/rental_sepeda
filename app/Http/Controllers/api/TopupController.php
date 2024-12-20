<?php

namespace App\Http\Controllers\Api;

use App\Models\Topup;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class TopupController extends Controller
{
    // Menampilkan semua riwayat top-up
    public function index()
    {
        $topups = Topup::with('user')->get();

        return response()->json($topups, 200);
    }

    // Membuat top-up baru
    public function store(Request $request)
    {
        $request->validate([
            'user_id' => 'required|exists:users,id',
            'topup_amount' => 'required|integer|min:1',
        ]);

        $topup = Topup::create([
            'user_id' => $request->user_id,
            'topup_amount' => $request->topup_amount,
            'topup_time' => now(),
            'status' => 'pending', // Status default
        ]);

        return response()->json([
            'message' => 'Top-up created successfully',
            'topup' => $topup,
        ], 201);
    }
}
