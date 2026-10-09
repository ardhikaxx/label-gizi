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
            'contact_email' => ['required', 'email', 'max:150'],
            'contact_phone' => ['required', 'string', 'max:50'],
            'footer_text' => ['required', 'string', 'max:500'],
            'hero_title' => ['required', 'string', 'max:200'],
            'hero_subtitle' => ['required', 'string', 'max:500'],
            'education_title' => ['required', 'string', 'max:200'],
            'education_text' => ['required', 'string', 'max:2000'],
        ], [
            'app_name.required' => 'Nama aplikasi wajib diisi.',
            'institution_name.required' => 'Nama instansi/pengelola wajib diisi.',
            'contact_email.required' => 'Email kontak wajib diisi.',
            'contact_email.email' => 'Format email kontak tidak valid.',
            'contact_phone.required' => 'Nomor telepon kontak wajib diisi.',
            'footer_text.required' => 'Teks footer wajib diisi.',
            'hero_title.required' => 'Judul hero landing page wajib diisi.',
            'hero_subtitle.required' => 'Subjudul hero landing page wajib diisi.',
            'education_title.required' => 'Judul edukasi gizi wajib diisi.',
            'education_text.required' => 'Penjelasan edukasi gizi wajib diisi.',
        ]);

        foreach ($validated as $key => $value) {
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
