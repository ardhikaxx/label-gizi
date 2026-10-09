<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\ActivityLog;
use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Support\Str;
use Illuminate\View\View;

class AuthController extends Controller
{
    /**
     * Display the admin login form.
     */
    public function showLoginForm(): View|RedirectResponse
    {
        if (Auth::check()) {
            return redirect()->route('admin.dashboard');
        }

        return view('admin.auth.login');
    }

    /**
     * Handle an admin authentication attempt.
     */
    public function login(Request $request): RedirectResponse
    {
        $credentials = $request->validate([
            'login' => ['required', 'string'],
            'password' => ['required', 'string'],
            'remember' => ['nullable', 'boolean'],
        ], [
            'login.required' => 'Email atau username administrator wajib diisi.',
            'password.required' => 'Kata sandi wajib diisi.',
        ]);

        $throttleKey = Str::transliterate(Str::lower($credentials['login']).'|'.$request->ip());

        // Check rate limiter (5 attempts per minute)
        if (RateLimiter::tooManyAttempts($throttleKey, 5)) {
            $seconds = RateLimiter::availableIn($throttleKey);

            return back()
                ->withInput($request->only('login'))
                ->with('error', "Terlalu banyak percobaan masuk yang gagal. Silakan coba lagi dalam {$seconds} detik.");
        }

        // Determine if login input is email or username
        $loginField = filter_var($credentials['login'], FILTER_VALIDATE_EMAIL) ? 'email' : 'username';

        // Check if user exists and is active
        $user = User::where($loginField, $credentials['login'])->first();

        if (! $user || ! $user->isActive()) {
            RateLimiter::hit($throttleKey, 60);

            if ($user && ! $user->isActive()) {
                return back()
                    ->withInput($request->only('login'))
                    ->with('error', 'Akun administrator Anda telah dinonaktifkan. Silakan hubungi pengelola sistem.');
            }

            return back()
                ->withInput($request->only('login'))
                ->with('error', 'Kombinasi email/username dan kata sandi tidak cocok.');
        }

        $attemptCredentials = [
            $loginField => $credentials['login'],
            'password' => $credentials['password'],
            'is_active' => true,
        ];

        $remember = (bool) $request->boolean('remember');

        if (! Auth::attempt($attemptCredentials, $remember)) {
            RateLimiter::hit($throttleKey, 60);

            return back()
                ->withInput($request->only('login'))
                ->with('error', 'Kombinasi email/username dan kata sandi tidak cocok.');
        }

        // Authentication passed
        RateLimiter::clear($throttleKey);
        $request->session()->regenerate();

        // Update last login timestamp
        $user->forceFill(['last_login_at' => now()])->saveQuietly();

        // Record activity log
        ActivityLog::record(
            'login',
            "Administrator {$user->name} ({$user->email}) berhasil masuk ke dashboard.",
            $user
        );

        return redirect()->intended(route('admin.dashboard'))
            ->with('success', "Selamat datang kembali, {$user->name}!");
    }

    /**
     * Log the admin user out of the application.
     */
    public function logout(Request $request): RedirectResponse
    {
        $user = Auth::user();

        if ($user) {
            ActivityLog::record(
                'logout',
                "Administrator {$user->name} ({$user->email}) keluar dari sistem.",
                $user
            );
        }

        Auth::logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('admin.login')
            ->with('success', 'Anda telah berhasil keluar dari sesi administrator.');
    }
}
