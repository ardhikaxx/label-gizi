<?php

use App\Models\User;
use Illuminate\Support\Facades\Hash;

beforeEach(function () {
    $this->currentAdmin = User::factory()->create(['is_active' => true]);
});

test('admin can view user management listing', function () {
    $response = $this->actingAs($this->currentAdmin)->get(route('admin.users.index'));

    $response->assertStatus(200);
    $response->assertSee('Daftar Akun Administrator');
    $response->assertSee($this->currentAdmin->name);
});

test('admin can create a new administrator account', function () {
    $userData = [
        'name' => 'Dokter Gizi SpGK',
        'email' => 'dr.gizi@labelgizi.test',
        'username' => 'dr_gizi',
        'password' => 'PasswordAman123!',
        'password_confirmation' => 'PasswordAman123!',
        'is_active' => true,
    ];

    $response = $this->actingAs($this->currentAdmin)->post(route('admin.users.store'), $userData);

    $response->assertRedirect(route('admin.users.index'));
    $this->assertDatabaseHas('users', [
        'email' => 'dr.gizi@labelgizi.test',
        'username' => 'dr_gizi',
    ]);
});

test('admin cannot deactivate self', function () {
    $response = $this->actingAs($this->currentAdmin)->post(route('admin.users.toggle-status', $this->currentAdmin));

    $response->assertSessionHas('error');
    expect($this->currentAdmin->fresh()->is_active)->toBeTrue();
});

test('admin cannot deactivate the last active admin', function () {
    // Only current admin exists
    $otherUser = User::factory()->create(['is_active' => false]);

    $response = $this->actingAs($this->currentAdmin)->post(route('admin.users.toggle-status', $this->currentAdmin));

    $response->assertSessionHas('error');
    expect($this->currentAdmin->fresh()->is_active)->toBeTrue();
});

test('admin cannot delete self', function () {
    $response = $this->actingAs($this->currentAdmin)->delete(route('admin.users.destroy', $this->currentAdmin));

    $response->assertSessionHas('error');
    $this->assertDatabaseHas('users', ['id' => $this->currentAdmin->id]);
});

test('admin cannot delete the only active admin remaining', function () {
    // Only current admin is active
    User::factory()->count(2)->create(['is_active' => false]);

    $response = $this->actingAs($this->currentAdmin)->delete(route('admin.users.destroy', $this->currentAdmin));

    $response->assertSessionHas('error');
    $this->assertDatabaseHas('users', ['id' => $this->currentAdmin->id]);
});

test('admin can delete another admin if more than one active exists', function () {
    $secondAdmin = User::factory()->create(['is_active' => true]);

    $response = $this->actingAs($this->currentAdmin)->delete(route('admin.users.destroy', $secondAdmin));

    $response->assertRedirect(route('admin.users.index'));
    $this->assertDatabaseMissing('users', ['id' => $secondAdmin->id]);
});

test('admin can update password for an administrator', function () {
    $user = User::factory()->create(['is_active' => true]);

    $response = $this->actingAs($this->currentAdmin)->put(route('admin.users.password', $user), [
        'password' => 'NewPassword999!',
        'password_confirmation' => 'NewPassword999!',
    ]);

    $response->assertRedirect(route('admin.users.index'));
    expect(Hash::check('NewPassword999!', $user->fresh()->password))->toBeTrue();
});
