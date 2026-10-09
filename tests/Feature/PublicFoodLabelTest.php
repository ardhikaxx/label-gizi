<?php

use App\Models\FoodLabel;
use App\Models\FoodLabelMenu;
use Carbon\Carbon;

test('public visitors can view landing page', function () {
    $response = $this->get(route('public.home'));

    $response->assertStatus(200);
    $response->assertSee('Sajian Menu Hari Ini');
});

test('public visitors can view published labels on homepage', function () {
    $label = FoodLabel::factory()->create([
        'title' => 'Menu Ayam Goreng Madu Spesial',
        'status' => 'published',
        'menu_date' => Carbon::today()->format('Y-m-d'),
        'energy' => 650,
    ]);
    FoodLabelMenu::create([
        'food_label_id' => $label->id,
        'name' => 'Ayam Fillet Madu',
        'sort_order' => 1,
    ]);

    $response = $this->get(route('public.home'));

    $response->assertStatus(200);
    $response->assertSee('Menu Ayam Goreng Madu Spesial');
    $response->assertSee('650');
});

test('public visitors can view food photo when available', function () {
    $label = FoodLabel::factory()->create([
        'title' => 'Menu Dengan Foto Lengkap',
        'status' => 'published',
        'menu_date' => Carbon::today()->format('Y-m-d'),
        'image' => 'sample_foto.webp',
    ]);
    FoodLabelMenu::create([
        'food_label_id' => $label->id,
        'name' => 'Menu 1',
        'sort_order' => 1,
    ]);

    $response = $this->get(route('public.home'));

    $response->assertStatus(200);
    $response->assertSee('Menu Dengan Foto Lengkap');
    $response->assertSee(url('uploads/food-labels/sample_foto.webp'));
});

test('legacy routes redirect to homepage', function () {
    $resCatalog = $this->get(route('public.labels'));
    $resCatalog->assertRedirect(route('public.home'));

    $resAbout = $this->get(route('public.about'));
    $resAbout->assertRedirect(route('public.home'));

    $resShow = $this->get(route('public.labels.show', 'any-slug'));
    $resShow->assertRedirect(route('public.home'));

    $resPrint = $this->get(route('public.labels.print', 'any-slug'));
    $resPrint->assertRedirect(route('public.home'));
});
