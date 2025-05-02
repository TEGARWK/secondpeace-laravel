<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PelangganAuth
{
    /**
     * Handle an incoming request.
     */
    public function handle(Request $request, Closure $next)
    {
        if (Auth::check() && Auth::user()->role === 'pelanggan') {
            return $next($request);
        }

        return redirect()->route('login.pelanggan')->withErrors([
            'akses' => 'Hanya pelanggan yang bisa mengakses halaman ini.',
        ]);
    }
}
