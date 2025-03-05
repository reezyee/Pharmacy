<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class NonPelangganMiddleware
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
        if (Auth::check() && Auth::user()->role->name !== 'Pelanggan') {
            return $next($request);
        }

        return redirect()->route('home')->with('error', 'Akses ditolak. Halaman ini hanya untuk Admin, Dokter, Apoteker, atau Kasir.');
    }
}
