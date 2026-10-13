<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\ActivityLog;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Support\Str;
use Illuminate\View\View;

class PasswordResetController extends Controller
{
    /**
     * Tampilkan formulir permintaan lupa kata sandi (input email).
     */
    public function showForgotForm(): View
    {
        return view('admin.auth.forgot-password');
    }

    /**
     * Verifikasi email di database dan arahkan ke formulir reset kata sandi.
     */
    public function sendResetLink(Request $request): RedirectResponse
    {
        $request->validate([
            'email' => ['required', 'email', 'max:255'],
        ], [
            'email.required' => 'Alamat email wajib diisi.',
            'email.email' => 'Format alamat email tidak valid.',
            'email.max' => 'Alamat email maksimal 255 karakter.',
        ]);

        $throttleKey = 'forgot-password|'.$request->ip();

        if (RateLimiter::tooManyAttempts($throttleKey, 5)) {
            $seconds = RateLimiter::availableIn($throttleKey);

            return back()
                ->withInput()
                ->with('error', "Terlalu banyak percobaan verifikasi. Silakan coba lagi dalam {$seconds} detik.");
        }

        RateLimiter::hit($throttleKey, 60);

        $user = User::where('email', $request->email)->first();

        if (! $user) {
            return back()
                ->withInput()
                ->withErrors(['email' => 'Alamat email tidak terdaftar dalam sistem administrator.'])
                ->with('error', 'Alamat email tidak ditemukan dalam database sistem.');
        }

        if (! $user->isActive()) {
            return back()
                ->withInput()
                ->withErrors(['email' => 'Akun administrator ini berstatus nonaktif.'])
                ->with('error', 'Akun administrator ini dinonaktifkan. Silakan hubungi pengelola sistem.');
        }

        // Generate token reset yang aman
        $rawToken = Str::random(64);
        $hashedToken = hash('sha256', $rawToken);

        // Simpan token ke tabel password_reset_tokens
        DB::table('password_reset_tokens')->updateOrInsert(
            ['email' => $user->email],
            [
                'token' => $hashedToken,
                'created_at' => now(),
            ]
        );

        RateLimiter::clear($throttleKey);

        // Langsung arahkan ke halaman reset password sesuai alur permintaan
        return redirect()->route('admin.password.reset', [
            'token' => $rawToken,
            'email' => $user->email,
        ])->with('success', 'Email berhasil diverifikasi! Silakan buat kata sandi baru Anda.');
    }

    /**
     * Tampilkan formulir pembuatan kata sandi baru.
     */
    public function showResetForm(Request $request, string $token): View|RedirectResponse
    {
        $email = $request->query('email');

        if (! $email) {
            return redirect()->route('admin.password.request')
                ->with('error', 'Permintaan tidak valid. Silakan masukkan email Anda kembali.');
        }

        $record = DB::table('password_reset_tokens')
            ->where('email', $email)
            ->first();

        if (! $record || ! hash_equals($record->token, hash('sha256', $token))) {
            return redirect()->route('admin.password.request')
                ->with('error', 'Tautan reset kata sandi tidak valid atau tidak cocok. Silakan verifikasi email kembali.');
        }

        // Cek kedaluwarsa token (60 menit)
        if (Carbon::parse($record->created_at)->addMinutes(60)->isPast()) {
            DB::table('password_reset_tokens')->where('email', $email)->delete();

            return redirect()->route('admin.password.request')
                ->with('error', 'Sesi reset kata sandi telah kedaluwarsa (lebih dari 60 menit). Silakan ulangi proses.');
        }

        return view('admin.auth.reset-password', [
            'token' => $token,
            'email' => $email,
        ]);
    }

    /**
     * Simpan kata sandi baru dan arahkan pengguna ke halaman login.
     */
    public function resetPassword(Request $request): RedirectResponse
    {
        $request->validate([
            'token' => ['required', 'string'],
            'email' => ['required', 'email'],
            'password' => ['required', 'string', 'min:8', 'confirmed'],
        ], [
            'token.required' => 'Token reset kata sandi tidak valid.',
            'email.required' => 'Alamat email wajib diisi.',
            'email.email' => 'Format email tidak valid.',
            'password.required' => 'Kata sandi baru wajib diisi.',
            'password.min' => 'Kata sandi baru minimal terdiri dari 8 karakter.',
            'password.confirmed' => 'Konfirmasi kata sandi baru tidak cocok.',
        ]);

        $record = DB::table('password_reset_tokens')
            ->where('email', $request->email)
            ->first();

        if (! $record || ! hash_equals($record->token, hash('sha256', $request->token))) {
            return redirect()->route('admin.password.request')
                ->with('error', 'Token reset kata sandi tidak valid. Silakan ajukan ulang permintaan.');
        }

        if (Carbon::parse($record->created_at)->addMinutes(60)->isPast()) {
            DB::table('password_reset_tokens')->where('email', $request->email)->delete();

            return redirect()->route('admin.password.request')
                ->with('error', 'Sesi reset kata sandi telah kedaluwarsa. Silakan ajukan ulang.');
        }

        $user = User::where('email', $request->email)->first();

        if (! $user) {
            return redirect()->route('admin.password.request')
                ->with('error', 'Pengguna tidak ditemukan dalam sistem.');
        }

        // Perbarui kata sandi pengguna
        $user->update([
            'password' => Hash::make($request->password),
        ]);

        // Hapus token reset dari tabel setelah berhasil digunakan
        DB::table('password_reset_tokens')->where('email', $request->email)->delete();

        // Catat di log aktivitas sistem
        ActivityLog::record(
            'reset_password',
            "Administrator {$user->name} ({$user->email}) berhasil mereset kata sandi melalui alur lupa kata sandi.",
            $user,
            null,
            $user->id
        );

        return redirect()->route('admin.login')
            ->with('success', 'Kata sandi Anda berhasil diperbarui! Silakan masuk menggunakan kata sandi baru Anda.');
    }
}
