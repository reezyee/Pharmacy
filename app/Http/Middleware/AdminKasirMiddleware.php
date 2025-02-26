<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use App\Models\Role;

class AdminKasirMiddleware
{
    /**
     * Handle an incoming request.
     */
    public function handle(Request $request, Closure $next): Response
    {
        $user = auth()->user();

        if (!$user) {
            abort(403, 'Anda harus login.');
        }

        // Ambil nama role berdasarkan role_id
        $role = $user->role ? strtolower($user->role->name) : null;

        if (!in_array($role, ['admin', 'kasir'])) {
            abort(403, 'Akses ditolak.');
        }

        return $next($request);
    }
}
