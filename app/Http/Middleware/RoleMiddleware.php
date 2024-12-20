<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class RoleMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle(Request $request, Closure $next)
    {
        // Periksa apakah pengguna sudah login
        if (Auth::check()) {
            // Validasi apakah pengguna memiliki peran admin
            if (Auth::user()->role === 'admin') {
                return $next($request); // Lanjutkan permintaan
            }
        }

        // Jika pengguna tidak memiliki akses
        return response()->json(
            ['message' => 'Unauthorized access. Admin privileges required.'],
            403
        );
    }
}
