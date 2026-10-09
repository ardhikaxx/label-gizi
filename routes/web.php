<?php

use App\Http\Controllers\Admin\ActivityLogController;
use App\Http\Controllers\Admin\AuthController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\FoodLabelController;
use App\Http\Controllers\Admin\SettingController;
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\PublicLabelController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Public Routes (Akses Masyarakat Umum - Tanpa Login)
|--------------------------------------------------------------------------
*/
Route::get('/', [PublicLabelController::class, 'index'])->name('public.home');
Route::get('/labels', [PublicLabelController::class, 'catalog'])->name('public.labels');
Route::get('/labels/{slug}', [PublicLabelController::class, 'show'])->name('public.labels.show');
Route::get('/labels/{slug}/cetak', [PublicLabelController::class, 'print'])->name('public.labels.print');
Route::get('/tentang-gizi', [PublicLabelController::class, 'about'])->name('public.about');

/*
|--------------------------------------------------------------------------
| Admin Authentication Routes (Guest Only)
|--------------------------------------------------------------------------
*/
Route::middleware('admin.guest')->prefix('admin')->name('admin.')->group(function () {
    Route::get('/login', [AuthController::class, 'showLoginForm'])->name('login');
    Route::post('/login', [AuthController::class, 'login'])->name('login.submit');
});

/*
|--------------------------------------------------------------------------
| Protected Admin Routes (Wajib Login & Status Aktif)
|--------------------------------------------------------------------------
*/
Route::middleware('admin.auth')->prefix('admin')->name('admin.')->group(function () {
    // Logout
    Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

    // Dashboard
    Route::get('/', fn () => redirect()->route('admin.dashboard'));
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

    // Label Export (placed before resource to prevent slug collision)
    Route::get('/labels/export', [FoodLabelController::class, 'exportCsv'])->name('labels.export');

    // Label Lifecycle Actions
    Route::post('/labels/{label}/publish', [FoodLabelController::class, 'publish'])->name('labels.publish');
    Route::post('/labels/{label}/unpublish', [FoodLabelController::class, 'unpublish'])->name('labels.unpublish');
    Route::post('/labels/{label}/archive', [FoodLabelController::class, 'archive'])->name('labels.archive');
    Route::post('/labels/{label}/duplicate', [FoodLabelController::class, 'duplicate'])->name('labels.duplicate');
    Route::get('/labels/{label}/preview', [FoodLabelController::class, 'preview'])->name('labels.preview');

    // Food Labels Resource
    Route::resource('labels', FoodLabelController::class);

    // User Management (Admin Accounts)
    Route::get('/users', [UserController::class, 'index'])->name('users.index');
    Route::post('/users', [UserController::class, 'store'])->name('users.store');
    Route::put('/users/{user}', [UserController::class, 'update'])->name('users.update');
    Route::put('/users/{user}/password', [UserController::class, 'updatePassword'])->name('users.password');
    Route::post('/users/{user}/toggle-status', [UserController::class, 'toggleStatus'])->name('users.toggle-status');
    Route::delete('/users/{user}', [UserController::class, 'destroy'])->name('users.destroy');

    // Application Settings
    Route::get('/settings', [SettingController::class, 'index'])->name('settings.index');
    Route::put('/settings', [SettingController::class, 'update'])->name('settings.update');

    // Activity Logs
    Route::get('/activities', [ActivityLogController::class, 'index'])->name('activities.index');
});
