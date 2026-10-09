<?php

use App\Models\ActivityLog;
use App\Models\ApplicationSetting;
use App\Models\User;

beforeEach(function () {
    $this->admin = User::factory()->create(['is_active' => true]);
});

test('admin can view settings page', function () {
    $response = $this->actingAs($this->admin)->get(route('admin.settings.index'));

    $response->assertStatus(200);
    $response->assertSee('Pengaturan Sistem');
});

test('admin can update application settings', function () {
    $data = [
        'app_name' => 'Label Gizi Nusantara',
        'institution_name' => 'Badan Gizi Sehat Nasional',
        'contact_email' => 'info@gizi.go.id',
        'contact_phone' => '+62 811-2233-4455',
        'footer_text' => 'Transparansi gizi untuk generasi emas Indonesia.',
        'hero_title' => 'Label Pangan Bergizi Lengkap',
        'hero_subtitle' => 'Ketahui komposisi makanan bergizi Anda.',
        'education_title' => 'Pentingnya Gizi Seimbang',
        'education_text' => 'Gizi seimbang mencakup zat gizi makro dan mikro yang memadai.',
    ];

    $response = $this->actingAs($this->admin)->put(route('admin.settings.update'), $data);

    $response->assertStatus(302);
    expect(ApplicationSetting::get('app_name'))->toBe('Label Gizi Nusantara');
    expect(ApplicationSetting::get('contact_email'))->toBe('info@gizi.go.id');
});

test('admin can view activity logs with filter', function () {
    ActivityLog::record('login', 'Admin telah login ke sistem.', null, null, $this->admin->id);
    ActivityLog::record('create_label', 'Label makanan baru dibuat.', null, null, $this->admin->id);

    $response = $this->actingAs($this->admin)->get(route('admin.activities.index'));

    $response->assertStatus(200);
    $response->assertSee('Audit Trail');
    $response->assertSee('Admin telah login ke sistem.');

    $filteredResponse = $this->actingAs($this->admin)->get(route('admin.activities.index', ['action' => 'login']));
    $filteredResponse->assertStatus(200);
    $filteredResponse->assertSee('Admin telah login ke sistem.');
});
