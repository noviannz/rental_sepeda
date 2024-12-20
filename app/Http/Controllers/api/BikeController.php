<?php

namespace App\Http\Controllers\Api;

use App\Models\Bike;
use App\Models\Station;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class BikeController extends Controller
{
    // Mendapatkan semua sepeda
    public function index()
    {
        return response()->json(Bike::all(), 200);
    }

    // Mendapatkan detail sepeda
    public function show($id)
    {
        $bike = Bike::find($id);

        if (!$bike) {
            return response()->json(['message' => 'Bike not found'], 404);
        }

        return response()->json($bike, 200);
    }

    // Menambahkan sepeda baru
    public function store(Request $request)
    {
        $request->validate([
            'station_id' => 'required|exists:stations,id',
        ]);

        $station = Station::find($request->station_id);

        $bike = Bike::create([
            'bike_code' => 'BK' . now()->timestamp, // Kode unik berdasarkan timestamp
            'status' => 'available',               // Status default
            'location' => $station->location,      // Lokasi otomatis dari stasiun
        ]);

        return response()->json([
            'message' => 'Bike created successfully',
            'bike' => $bike,
        ], 201);
    }

    // Memperbarui data sepeda
    public function update(Request $request, $id)
    {
        $bike = Bike::find($id);

        if (!$bike) {
            return response()->json(['message' => 'Bike not found'], 404);
        }

        $bike->update($request->all());
        return response()->json($bike, 200);
    }

    // Menghapus sepeda
    public function destroy($id)
    {
        $bike = Bike::find($id);

        if (!$bike) {
            return response()->json(['message' => 'Bike not found'], 404);
        }

        $bike->delete();
        return response()->json(['message' => 'Bike deleted successfully'], 200);
    }
}
