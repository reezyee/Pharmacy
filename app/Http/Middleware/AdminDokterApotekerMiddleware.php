<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AdminDokterApotekerMiddleware
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
        if (Auth::check() && (Auth::user()->role->name === 'Admin' || Auth::user()->role->name === 'Dokter' || Auth::user()->role->name === 'Apoteker')) {
            return $next($request);
        }

        return redirect()->route('home')->with('error', 'Akses ditolak. Anda tidak memiliki izin yang diperlukan.');
    }
}