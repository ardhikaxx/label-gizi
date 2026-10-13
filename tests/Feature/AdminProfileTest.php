<?php

use App\Models\ActivityLog;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

beforeEach(function () {
    $this->admin = User::factory()->create([
        'is_active' => true,
        'name' => 'Admin Test',
        'username' => 'admintest',
        'email' => 'admin@test.com',
        'password' => Hash::make('Password1'),
    ]);
});

test('admin dapat mengakses halaman profil sendiri', function () {
    $response = $this->actingAs($this->admin)->get(route('admin.profile.show'));

    $response->assertStatus(200);
    $response->assertSee('Profil Saya');
    $response->assertSee($this->admin->name);
    $response->assertSee($this->admin->email);
});

test('tamu tidak bisa mengakses halaman profil', function () {
    $response = $this->get(route('admin.profile.show'));

    $response->assertRedirect(route('admin.login'));
});

test('admin dapat memperbarui informasi profil', function () {
    $response = $this->actingAs($this->admin)->put(route('admin.profile.update'), [
        'name' => 'Nama Baru',
        'username' => 'usernamebaru',
        'email' => 'baru@test.com',
    ]);

    $response->assertRedirect(route('admin.profile.show'));
    $response->assertSessionHas('success');

    $this->admin->refresh();
    expect($this->admin->name)->toBe('Nama Baru');
    expect($this->admin->username)->toBe('usernamebaru');
    expect($this->admin->email)->toBe('baru@test.com');
});

test('memperbarui profil dicatat di log aktivitas', function () {
    $this->actingAs($this->admin)->put(route('admin.profile.update'), [
        'name' => 'Nama Log',
        'username' => 'usernamelogtest',
        'email' => 'log@test.com',
    ]);

    $this->assertDatabaseHas('activity_logs', [
        'action' => 'update_profile',
        'user_id' => $this->admin->id,
    ]);
});

test('validasi profil gagal jika email sudah digunakan user lain', function () {
    $other = User::factory()->create(['email' => 'lain@test.com', 'is_active' => true]);

    $response = $this->actingAs($this->admin)->put(route('admin.profile.update'), [
        'name' => 'Admin Test',
        'username' => 'admintest',
        'email' => $other->email,
    ]);

    $response->assertSessionHasErrors('email');
});

test('admin dapat mengganti kata sandi sendiri dengan kata sandi saat ini yang benar', function () {
    $response = $this->actingAs($this->admin)->put(route('admin.profile.password'), [
        'current_password' => 'Password1',
        'password' => 'NewPassword9',
        'password_confirmation' => 'NewPassword9',
    ]);

    $response->assertRedirect(route('admin.profile.show'));
    $response->assertSessionHas('success');

    $this->admin->refresh();
    expect(Hash::check('NewPassword9', $this->admin->password))->toBeTrue();
});

test('ganti kata sandi gagal jika kata sandi saat ini salah', function () {
    $response = $this->actingAs($this->admin)->put(route('admin.profile.password'), [
        'current_password' => 'SalahSekali123',
        'password' => 'NewPassword9',
        'password_confirmation' => 'NewPassword9',
    ]);

    $response->assertSessionHasErrors('current_password');
});

test('ganti kata sandi gagal jika konfirmasi tidak cocok', function () {
    $response = $this->actingAs($this->admin)->put(route('admin.profile.password'), [
        'current_password' => 'Password1',
        'password' => 'NewPassword9',
        'password_confirmation' => 'BedaBanget9',
    ]);

    $response->assertSessionHasErrors('password');
});

test('ganti kata sandi dicatat di log aktivitas', function () {
    $this->actingAs($this->admin)->put(route('admin.profile.password'), [
        'current_password' => 'Password1',
        'password' => 'LogPassword9',
        'password_confirmation' => 'LogPassword9',
    ]);

    $this->assertDatabaseHas('activity_logs', [
        'action' => 'change_own_password',
        'user_id' => $this->admin->id,
    ]);
});
