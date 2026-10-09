<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreUserRequest;
use App\Http\Requests\UpdateUserRequest;
use App\Models\ActivityLog;
use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\View\View;

class UserController extends Controller
{
    /**
     * Display a listing of admin users.
     */
    public function index(Request $request): View
    {
        $search = $request->query('search');

        $query = User::query();

        if (! empty($search)) {
            $query->where(function ($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                    ->orWhere('email', 'like', "%{$search}%")
                    ->orWhere('username', 'like', "%{$search}%");
            });
        }

        $users = $query->orderBy('name', 'asc')->paginate(10)->withQueryString();

        return view('admin.users.index', [
            'users' => $users,
            'search' => $search,
        ]);
    }

    /**
     * Store a newly created admin user in storage.
     */
    public function store(StoreUserRequest $request): RedirectResponse
    {
        $validated = $request->validated();

        $user = User::create([
            'name' => $validated['name'],
            'email' => $validated['email'],
            'username' => $validated['username'],
            'password' => Hash::make($validated['password']),
            'is_active' => $request->boolean('is_active', true),
            'email_verified_at' => now(),
        ]);

        ActivityLog::record(
            'create_user',
            "Administrator baru ditambahkan: {$user->name} ({$user->email})",
            $user
        );

        return redirect()->route('admin.users.index')
            ->with('success', "Akun administrator '{$user->name}' berhasil ditambahkan.");
    }

    /**
     * Update the specified admin user in storage.
     */
    public function update(UpdateUserRequest $request, User $user): RedirectResponse
    {
        $validated = $request->validated();

        $user->update([
            'name' => $validated['name'],
            'email' => $validated['email'],
            'username' => $validated['username'],
        ]);

        ActivityLog::record(
            'update_user',
            "Data profil administrator {$user->name} diperbarui.",
            $user
        );

        return redirect()->route('admin.users.index')
            ->with('success', "Data administrator '{$user->name}' berhasil diperbarui.");
    }

    /**
     * Update the password for an admin user.
     */
    public function updatePassword(Request $request, User $user): RedirectResponse
    {
        $request->validate([
            'password' => ['required', 'string', 'min:8', 'confirmed'],
        ], [
            'password.required' => 'Kata sandi baru wajib diisi.',
            'password.min' => 'Kata sandi baru minimal terdiri dari 8 karakter.',
            'password.confirmed' => 'Konfirmasi kata sandi baru tidak cocok.',
        ]);

        $user->update([
            'password' => Hash::make($request->password),
        ]);

        ActivityLog::record(
            'change_password',
            "Kata sandi administrator {$user->name} diatur ulang.",
            $user
        );

        return redirect()->route('admin.users.index')
            ->with('success', "Kata sandi administrator '{$user->name}' berhasil diperbarui.");
    }

    /**
     * Toggle active/inactive status for an admin user.
     */
    public function toggleStatus(User $user): RedirectResponse
    {
        // Safeguard: Cannot deactivate self
        if ($user->id === Auth::id()) {
            return back()->with('error', 'Anda tidak dapat menonaktifkan akun Anda sendiri.');
        }

        // Safeguard: Cannot deactivate the last active admin
        if ($user->isActive()) {
            $activeCount = User::where('is_active', true)->count();
            if ($activeCount <= 1) {
                return back()->with('error', 'Tidak dapat menonaktifkan akun ini karena merupakan satu-satunya administrator aktif.');
            }
        }

        $newStatus = ! $user->is_active;
        $user->update(['is_active' => $newStatus]);

        $statusText = $newStatus ? 'diaktifkan' : 'dinonaktifkan';

        ActivityLog::record(
            'toggle_status',
            "Status administrator {$user->name} diubah menjadi {$statusText}.",
            $user
        );

        return back()->with('success', "Akun administrator '{$user->name}' berhasil {$statusText}.");
    }

    /**
     * Remove the specified admin user from storage.
     */
    public function destroy(User $user): RedirectResponse
    {
        // Safeguard: Cannot delete self
        if ($user->id === Auth::id()) {
            return back()->with('error', 'Anda tidak dapat menghapus akun Anda sendiri yang sedang aktif.');
        }

        // Safeguard: Cannot delete the last active admin
        $activeCount = User::where('is_active', true)->count();
        if ($user->isActive() && $activeCount <= 1) {
            return back()->with('error', 'Tidak dapat menghapus satu-satunya administrator aktif yang tersisa di sistem.');
        }

        $name = $user->name;
        $user->delete();

        ActivityLog::record(
            'delete_user',
            "Akun administrator {$name} dihapus dari sistem.",
            null
        );

        return redirect()->route('admin.users.index')
            ->with('success', "Akun administrator '{$name}' berhasil dihapus.");
    }
}
