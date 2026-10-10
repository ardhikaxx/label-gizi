<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\ActivityLog;
use App\Models\ApplicationSetting;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class SettingController extends Controller
{
    /**
     * Show the application settings form.
     */
    public function index(): View
    {
        $settings = ApplicationSetting::all()->keyBy('key');

        return view('admin.settings.index', [
            'settings' => $settings,
        ]);
    }

    /**
     * Update application settings.
     */
    public function update(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'app_name' => ['required', 'string', 'max:100'],
            'institution_name' => ['required', 'string', 'max:200'],
            'default_consumption_time_start' => ['nullable', 'string', 'max:10'],
            'default_consumption_time_end' => ['nullable', 'string', 'max:10'],
            'default_consumption_time_range' => ['nullable', 'string', 'max:100'],
            'contact_email' => ['nullable', 'email', 'max:150'],
            'contact_phone' => ['nullable', 'string', 'max:50'],
            'footer_text' => ['nullable', 'string', 'max:500'],
            'hero_title' => ['nullable', 'string', 'max:200'],
            'hero_subtitle' => ['nullable', 'string', 'max:500'],
            'education_title' => ['nullable', 'string', 'max:200'],
            'education_text' => ['nullable', 'string', 'max:2000'],
        ], [
            'app_name.required' => 'Nama aplikasi wajib diisi.',
            'institution_name.required' => 'Nama instansi/pengelola wajib diisi.',
            'contact_email.email' => 'Format email kontak tidak valid.',
        ]);

        foreach ($validated as $key => $value) {
            if ($value === null) {
                continue;
            }

            $group = match ($key) {
                'contact_email', 'contact_phone' => 'contact',
                default => 'general',
            };
            $type = in_array($key, ['footer_text', 'hero_subtitle', 'education_text']) ? 'text' : 'string';

            ApplicationSetting::set($key, $value, $type, $group);
        }

        ActivityLog::record(
            'update_settings',
            'Pengaturan sistem dan identitas aplikasi diperbarui oleh administrator.'
        );

        return back()->with('success', 'Pengaturan aplikasi berhasil disimpan dan diperbarui.');
    }
}
