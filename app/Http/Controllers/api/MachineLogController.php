<?php

namespace App\Http\Controllers\Api;

use App\Models\MachineLog;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class MachineLogController extends Controller
{
    // Menampilkan semua log
    public function index()
    {
        return response()->json(MachineLog::all(), 200);
    }

    // Menampilkan log tertentu
    public function show($id)
    {
        $log = MachineLog::find($id);

        if (!$log) {
            return response()->json(['message' => 'Log not found'], 404);
        }

        return response()->json($log, 200);
    }
}
