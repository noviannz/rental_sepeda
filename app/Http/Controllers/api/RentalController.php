<?php

namespace App\Http\Controllers\Api;

use App\Models\Rental;
use App\Models\Bike;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class RentalController extends Controller
{
    public function startRental(Request $request)
    {
        $request->validate([
            'user_id' => 'required|exists:users,id',
            'bike_id' => 'required|exists:bikes,id',
        ]);

        $bike = Bike::find($request->bike_id);

        if ($bike->status !== 'available') {
            return response()->json(['message' => 'Bike is not available'], 400);
        }

        $rental = Rental::create([
            'user_id' => $request->user_id,
            'bike_id' => $request->bike_id,
            'start_time' => now(),
            'status' => 'ongoing',
        ]);

        $bike->status = 'rented'; // Ubah status sepeda menjadi rented
        $bike->save();

        return response()->json([
            'message' => 'Rental started successfully',
            'rental' => $rental,
        ], 201);
    }

    public function endRental(Request $request, $id)
    {
        $rental = Rental::find($id);

        if (!$rental || $rental->status !== 'ongoing') {
            return response()->json(['message' => 'Rental not found or already completed'], 404);
        }

        $bike = $rental->bike;
        $bike->status = 'available'; // Ubah status sepeda menjadi available

        if ($request->has('location')) {
            $bike->location = $request->location; // Perbarui lokasi sepeda jika tersedia
        }

        $bike->save();

        // Menghitung total waktu penyewaan dalam jam (dengan minimal 1 jam)
        $rental->end_time = now();
        $start_time = $rental->start_time;
        $end_time = $rental->end_time;
        $total_hours = max(1, ceil($end_time->diffInMinutes($start_time) / 60)); // Pembulatan ke atas untuk hitungan jam

        // Menentukan tarif per jam (contoh: Rp10,000 per jam)
        $rate_per_hour = 10000;
        $total_amount = $total_hours * $rate_per_hour;

        $rental->update([
            'status' => 'completed',
            'end_time' => now(),
            'amount_deducted' => $total_amount,
        ]);

        return response()->json([
            'message' => 'Rental ended successfully',
            'rental' => $rental,
            'total_amount' => $total_amount,
        ], 200);
    }
}
