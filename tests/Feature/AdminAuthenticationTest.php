<?php

use App\Models\User;
use Illuminate\Support\Facades\Hash;

test('unauthenticated visitors are redirected to admin login when accessing admin routes', function () {
    $response = $this->get(route('admin.dashboard'));
    $response->assertRedirect(route('admin.login'));

    $response2 = $this->get(route('admin.labels.index'));
    $response2->assertRedirect(route('admin.login'));

    $response3 = $this->get(route('admin.users.index'));
    $response3->assertRedirect(route('admin.login'));
});

test('admin can log in using email address', function () {
    $user = User::factory()->create([
        'email' => 'admin.test@labelgizi.test',
        'password' => Hash::make('Secret12345!'),
        'is_active' => true,
    ]);

    $response = $this->post(route('admin.login.submit'), [
        'login' => 'admin.test@labelgizi.test',
        'password' => 'Secret12345!',
    ]);

    $response->assertRedirect(route('admin.dashboard'));
    $this->assertAuthenticatedAs($user);
});

test('admin can log in using username', function () {
    $user = User::factory()->create([
        'username' => 'supergizi',
        'password' => Hash::make('Secret12345!'),
        'is_active' => true,
    ]);

    $response = $this->post(route('admin.login.submit'), [
        'login' => 'supergizi',
        'password' => 'Secret12345!',
    ]);

    $response->assertRedirect(route('admin.dashboard'));
    $this->assertAuthenticatedAs($user);
});

test('admin login fails with wrong password', function () {
    $user = User::factory()->create([
        'email' => 'admin.wrong@labelgizi.test',
        'password' => Hash::make('CorrectPassword123'),
        'is_active' => true,
    ]);

    $response = $this->from(route('admin.login'))->post(route('admin.login.submit'), [
        'login' => 'admin.wrong@labelgizi.test',
        'password' => 'WrongPassword',
    ]);

    $response->assertRedirect(route('admin.login'));
    $response->assertSessionHas('error');
    $this->assertGuest();
});

test('inactive admin cannot log in', function () {
    $user = User::factory()->create([
        'email' => 'inactive@labelgizi.test',
        'password' => Hash::make('Secret12345!'),
        'is_active' => false,
    ]);

    $response = $this->from(route('admin.login'))->post(route('admin.login.submit'), [
        'login' => 'inactive@labelgizi.test',
        'password' => 'Secret12345!',
    ]);

    $response->assertRedirect(route('admin.login'));
    $response->assertSessionHas('error');
    $this->assertGuest();
});

test('authenticated admin cannot see login form and is redirected to dashboard', function () {
    $user = User::factory()->create(['is_active' => true]);

    $response = $this->actingAs($user)->get(route('admin.login'));

    $response->assertRedirect(route('admin.dashboard'));
});

test('admin can log out safely', function () {
    $user = User::factory()->create(['is_active' => true]);

    $response = $this->actingAs($user)->post(route('admin.logout'));

    $response->assertRedirect(route('admin.login'));
    $this->assertGuest();
});
