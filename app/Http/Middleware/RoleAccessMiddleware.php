<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\Auth;
use Spatie\Permission\Exceptions\UnauthorizedException;

class RoleAccessMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next, ...$roles): Response
    {
        // Cek apakah pengguna sudah login
        if (!Auth::check()) {
            // Hindari redirect loop jika sudah di rute login
            if ($request->is('login')) {
                return $next($request);
            }
            return redirect('/login')->with('error', 'Silakan login untuk melanjutkan.');
        }

        // Jika tidak ada peran yang diberikan, lanjutkan request
        if (empty($roles)) {
            return $next($request);
        }

        // Cek apakah pengguna memiliki salah satu peran yang diizinkan
        if (Auth::user()->hasAnyRole($roles)) {
            return $next($request);
        }

        // Jika tidak memiliki peran, kembalikan 403 Forbidden
        abort(403, 'Akses ditolak: Anda tidak memiliki izin untuk mengakses halaman ini.');
        
        //return $next($request);
    }
}
