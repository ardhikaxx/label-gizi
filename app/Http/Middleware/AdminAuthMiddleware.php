<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class AdminAuthMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  Closure(Request): (Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        if (! Auth::check()) {
            if ($request->expectsJson()) {
                return response()->json(['message' => 'Unauthenticated.'], 401);
            }

            return redirect()->guest(route('admin.login'))
                ->with('warning', 'Silakan masuk terlebih dahulu untuk mengakses area administrator.');
        }

        $user = Auth::user();

        // Enforce account active status
        if (! $user->isActive()) {
            Auth::logout();
            $request->session()->invalidate();
            $request->session()->regenerateToken();

            if ($request->expectsJson()) {
                return response()->json(['message' => 'Akun administrator Anda sedang dinonaktifkan.'], 403);
            }

            return redirect()->route('admin.login')
                ->with('error', 'Akun administrator Anda telah dinonaktifkan. Silakan hubungi pengelola sistem.');
        }

        return $next($request);
    }
}
