<?php

namespace App\Http\Controllers\Api;

use App\Models\Station;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class StationController extends Controller
{
    // Mendapatkan semua stasiun
    public function index()
    {
        return response()->json(Station::all(), 200);
    }

    // Mendapatkan detail stasiun
    public function show($id)
    {
        $station = Station::find($id);

        if (!$station) {
            return response()->json(['message' => 'Station not found'], 404);
        }

        return response()->json($station, 200);
    }

    // Menambahkan stasiun baru
    public function store(Request $request)
    {
        // Mengatur nama dan lokasi untuk stasiun pertama dan kedua
        $stationCount = Station::count() + 1;

        if ($stationCount == 1) {
            $stationName = 'Kalicari Rental Bike';
            $stationLocation = 'Kalicari';
        } elseif ($stationCount == 2) {
            $stationName = 'USM Rental Bike';
            $stationLocation = 'Universitas Semarang';
        } else {
            // Untuk stasiun selanjutnya, nama dan lokasi diatur otomatis
            $stationName = 'Station ' . chr(64 + $stationCount); // Membuat nama seperti "Station C", "Station D", dll.
            $stationLocation = 'Location ' . $stationCount;
        }

        // Membuat stasiun baru
        $station = Station::create([
            'station_name' => $stationName,
            'location' => $stationLocation,
            'capacity' => $request->input('capacity', 20), // Kapasitas default 20 jika tidak diberikan
        ]);

        return response()->json([
            'message' => 'Station created successfully',
            'station' => $station,
        ], 201);
    }

    // Memperbarui data stasiun
    public function update(Request $request, $id)
    {
        $station = Station::find($id);

        if (!$station) {
            return response()->json(['message' => 'Station not found'], 404);
        }

        // Perbarui kapasitas atau data lain jika diperlukan
        $station->update([
            'capacity' => $request->input('capacity', $station->capacity),
        ]);

        return response()->json([
            'message' => 'Station updated successfully',
            'station' => $station,
        ], 200);
    }

    // Menghapus stasiun
    public function destroy($id)
    {
        $station = Station::find($id);

        if (!$station) {
            return response()->json(['message' => 'Station not found'], 404);
        }

        $station->delete();
        return response()->json(['message' => 'Station deleted successfully'], 200);
    }
}
