<?php

use App\Models\User;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

test('pengunjung dapat mengakses formulir lupa kata sandi', function () {
    $response = $this->get(route('admin.password.request'));

    $response->assertStatus(200);
    $response->assertSee('Lupa Kata Sandi');
    $response->assertSee('Alamat Email Administrator');
});

test('admin yang sudah login dialihkan dari halaman lupa kata sandi ke dashboard', function () {
    $admin = User::factory()->create(['is_active' => true]);

    $response = $this->actingAs($admin)->get(route('admin.password.request'));

    $response->assertRedirect(route('admin.dashboard'));
});

test('verifikasi email gagal jika email tidak diisi atau format tidak valid', function () {
    $response = $this->from(route('admin.password.request'))->post(route('admin.password.email'), [
        'email' => 'bukan-email',
    ]);

    $response->assertRedirect(route('admin.password.request'));
    $response->assertSessionHasErrors('email');
});

test('verifikasi email gagal jika email tidak terdaftar di database', function () {
    $response = $this->from(route('admin.password.request'))->post(route('admin.password.email'), [
        'email' => 'tidak-ada@labelgizi.test',
    ]);

    $response->assertRedirect(route('admin.password.request'));
    $response->assertSessionHasErrors('email');
    $response->assertSessionHas('error');
});

test('verifikasi email gagal jika akun administrator berstatus nonaktif', function () {
    $user = User::factory()->create([
        'email' => 'nonaktif@labelgizi.test',
        'is_active' => false,
    ]);

    $response = $this->from(route('admin.password.request'))->post(route('admin.password.email'), [
        'email' => $user->email,
    ]);

    $response->assertRedirect(route('admin.password.request'));
    $response->assertSessionHasErrors('email');
    $response->assertSessionHas('error');
});

test('verifikasi email berhasil untuk email yang ada di database dan diarahkan ke halaman reset password', function () {
    $user = User::factory()->create([
        'email' => 'petugas@labelgizi.test',
        'is_active' => true,
    ]);

    $response = $this->post(route('admin.password.email'), [
        'email' => $user->email,
    ]);

    $this->assertDatabaseHas('password_reset_tokens', [
        'email' => $user->email,
    ]);

    $record = DB::table('password_reset_tokens')->where('email', $user->email)->first();
    expect($record)->not->toBeNull();

    // Pastikan diarahkan ke halaman reset password
    $response->assertRedirect();
    $targetUrl = $response->headers->get('Location');
    expect($targetUrl)->toContain('/admin/reset-password/');
    expect($targetUrl)->toContain('email='.urlencode($user->email));
});

test('pengunjung dapat melihat formulir ubah kata sandi dengan token yang valid', function () {
    $user = User::factory()->create([
        'email' => 'valid@labelgizi.test',
        'is_active' => true,
    ]);

    $rawToken = Str::random(64);
    DB::table('password_reset_tokens')->insert([
        'email' => $user->email,
        'token' => hash('sha256', $rawToken),
        'created_at' => now(),
    ]);

    $response = $this->get(route('admin.password.reset', [
        'token' => $rawToken,
        'email' => $user->email,
    ]));

    $response->assertStatus(200);
    $response->assertSee('Ubah Kata Sandi Baru');
    $response->assertSee($user->email);
    $response->assertSee('name="password"', false);
    $response->assertSee('name="password_confirmation"', false);
});

test('halaman ubah kata sandi menolak token yang tidak cocok atau tidak ada', function () {
    $response = $this->get(route('admin.password.reset', [
        'token' => 'token-salah-12345',
        'email' => 'tidakcocok@labelgizi.test',
    ]));

    $response->assertRedirect(route('admin.password.request'));
    $response->assertSessionHas('error');
});

test('halaman ubah kata sandi menolak token yang kedaluwarsa', function () {
    $user = User::factory()->create([
        'email' => 'expired@labelgizi.test',
        'is_active' => true,
    ]);

    $rawToken = Str::random(64);
    DB::table('password_reset_tokens')->insert([
        'email' => $user->email,
        'token' => hash('sha256', $rawToken),
        'created_at' => Carbon::now()->subHours(2),
    ]);

    $response = $this->get(route('admin.password.reset', [
        'token' => $rawToken,
        'email' => $user->email,
    ]));

    $response->assertRedirect(route('admin.password.request'));
    $response->assertSessionHas('error');
});

test('pengguna berhasil mengubah kata sandi baru dan diarahkan ke halaman login', function () {
    $user = User::factory()->create([
        'email' => 'resetme@labelgizi.test',
        'password' => Hash::make('OldPassword123!'),
        'is_active' => true,
    ]);

    $rawToken = Str::random(64);
    DB::table('password_reset_tokens')->insert([
        'email' => $user->email,
        'token' => hash('sha256', $rawToken),
        'created_at' => now(),
    ]);

    $response = $this->post(route('admin.password.update'), [
        'token' => $rawToken,
        'email' => $user->email,
        'password' => 'KataSandiBaru2026!',
        'password_confirmation' => 'KataSandiBaru2026!',
    ]);

    // Diarahkan ke halaman login
    $response->assertRedirect(route('admin.login'));
    $response->assertSessionHas('success');

    // Password di database terupdate
    $user->refresh();
    expect(Hash::check('KataSandiBaru2026!', $user->password))->toBeTrue();

    // Token dihapus dari database
    $this->assertDatabaseMissing('password_reset_tokens', [
        'email' => $user->email,
    ]);

    // Aktivitas dicatat di log aktivitas
    $this->assertDatabaseHas('activity_logs', [
        'action' => 'reset_password',
        'user_id' => $user->id,
    ]);

    // Admin dapat langsung login dengan kata sandi baru
    $loginResponse = $this->post(route('admin.login.submit'), [
        'login' => $user->email,
        'password' => 'KataSandiBaru2026!',
    ]);
    $loginResponse->assertRedirect(route('admin.dashboard'));
    $this->assertAuthenticatedAs($user);
});

test('ubah kata sandi baru gagal jika konfirmasi tidak cocok', function () {
    $user = User::factory()->create([
        'email' => 'mismatch@labelgizi.test',
        'is_active' => true,
    ]);

    $rawToken = Str::random(64);
    DB::table('password_reset_tokens')->insert([
        'email' => $user->email,
        'token' => hash('sha256', $rawToken),
        'created_at' => now(),
    ]);

    $response = $this->from(route('admin.password.reset', ['token' => $rawToken, 'email' => $user->email]))
        ->post(route('admin.password.update'), [
            'token' => $rawToken,
            'email' => $user->email,
            'password' => 'KataSandiBaru2026!',
            'password_confirmation' => 'KataSandiLainBeda!',
        ]);

    $response->assertRedirect();
    $response->assertSessionHasErrors('password');
});

test('ubah kata sandi baru gagal jika panjang kata sandi kurang dari 8 karakter', function () {
    $user = User::factory()->create([
        'email' => 'shortpwd@labelgizi.test',
        'is_active' => true,
    ]);

    $rawToken = Str::random(64);
    DB::table('password_reset_tokens')->insert([
        'email' => $user->email,
        'token' => hash('sha256', $rawToken),
        'created_at' => now(),
    ]);

    $response = $this->post(route('admin.password.update'), [
        'token' => $rawToken,
        'email' => $user->email,
        'password' => 'short1',
        'password_confirmation' => 'short1',
    ]);

    $response->assertSessionHasErrors('password');
});
