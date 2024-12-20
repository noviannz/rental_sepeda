<?php

namespace App\Http\Controllers\Api;

use App\Models\User;
use App\Models\Wallet;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules\Password;

class UserController extends Controller
{
    public function registerAdmin(Request $request)
    {
        $request->validate([
            'name' => ['required', 'string'],
            'email' => ['required', 'string', 'email', 'unique:users'],
            'password' => ['required', 'confirmed', Password::min(8)],
        ]);

        DB::table('users')->insert([
            'name' => $request->name,
            'email' => $request->email,
            'email_verified_at' => now(),
            'password' => Hash::make($request->password),
            'remember_token' => Str::random(10),
            'role' => 'admin',
            'plain_token' => Str::random(60),
        ]);

        return response()->json(['message' => 'Admin registered successfully'], 201);
    }

    public function registerUser(Request $request)
    {
        $request->validate([
            'name' => ['required', 'string'],
            'email' => ['required', 'string', 'email', 'unique:users'],
        ]);

        $id = DB::table('users')->insertGetId([
            'name' => $request->name,
            'email' => $request->email,
            'email_verified_at' => now(),
            'password' => Hash::make('12345678'),
            'remember_token' => Str::random(10),
            'role' => 'user',
            'plain_token' => '',
        ]);

        Wallet::create([
            'user_id' => $id,
            'balance' => 0, // Saldo awal 0
            'last_updated' => now(),
        ]);

        $user = User::find($id);
        $plain_token = $user->createToken('machine-to-machine-token')
            ->plainTextToken;
        $user->plain_token = $plain_token;
        $user->save();
        return response()->json([
            'token' => $plain_token,
            'message' => 'Berhasil'
        ], 200);
    }

    public function login(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);
        // Attempt to find the user by email
        $user = User::where('email', $request->email)
            ->where('role', 'admin')->first();
        // Verify if user exists and password is correct
        if (
            !$user ||
            !Hash::check($request->password, $user->password)
        ) {
            return response()->json([
                'message' => 'Invalid login credentials'
            ], 401);
        }
        // Create a new Sanctum token for the user
        $token = $user->createToken('API Token')->plainTextToken;
        // Return the token
        return response()->json([
            'token' => $token,
            'message' => 'Login successful'
        ]);
    }

    public function logout(Request $request)
    {
        // Validasi token yang ada
        $user = $request->user();

        if (!$user) {
            return response()->json([
                'message' => 'No user found'
            ], 401);
        }

        // Hapus token saat ini
        $user->currentAccessToken()->delete();

        return response()->json([
            'message' => 'Logged out successfully'
        ], 200);
    }

    public function user_token(Request $request)
    {
        $email = $request->get('email', '');
        $user = User::where('email', $email)->first();

        if ($user === null) {
            return response()->json([
                'message' => 'User not found',
                'email' => $email
            ], 404);
        }

        return response()->json([
            'message' => 'Token retrieved successfully',
            'token' => $user->plain_token,
            'email' => $email
        ], 200);
    }

    public function list(Request $request)
    {
        $page = $request->input('page', 0);
        $page_size = $request->input('page_size', 10);
        return response()->json([
            'message' => 'Berhasil',
            'users' => User::skip($page * $page_size)->take($page_size)
                ->select('id', 'name', 'email', 'role')->get(),
        ], 200);
    }
}
