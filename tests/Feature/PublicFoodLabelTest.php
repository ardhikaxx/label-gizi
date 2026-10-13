<?php

use App\Models\FoodLabel;
use App\Models\FoodLabelMenu;
use Carbon\Carbon;

test('public visitors can view landing page with lightweight webp templates', function () {
    $response = $this->get(route('public.home'));

    $response->assertStatus(200);
    $response->assertSee('Sajian Menu Hari Ini');
    $response->assertSee(asset('images/page-desktop.webp'));
    $response->assertSee(asset('images/page-mobile.webp'));
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

test('public visitors can see 5 different food conditions on the same date with swipe carousel elements', function () {
    $today = Carbon::today()->format('Y-m-d');
    $conditions = [
        'Porsi besar',
        'Porsi kecil',
        'Alergi',
        'Balita',
        'Busui dan Bumil',
    ];

    foreach ($conditions as $index => $condition) {
        $label = FoodLabel::factory()->create([
            'title' => 'Menu Spesial '.$condition,
            'menu_date' => $today,
            'food_condition' => $condition,
            'status' => 'published',
            'energy' => 400 + ($index * 50),
        ]);

        FoodLabelMenu::create([
            'food_label_id' => $label->id,
            'name' => 'Hidangan '.$condition,
            'sort_order' => 1,
        ]);
    }

    $response = $this->get(route('public.home'));

    $response->assertStatus(200);

    // Verify all 5 conditions are rendered in the condition box and pills
    foreach ($conditions as $condition) {
        $response->assertSee($condition);
        $response->assertSee('Menu Spesial '.$condition);
        $response->assertSee('Hidangan '.$condition);
    }

    // Verify condition box markup & carousel controls exist
    $response->assertSee('desktop-condition-box');
    $response->assertSee('mobile-condition-box');
    $response->assertDontSee('KONDISI MAKANAN');
    $response->assertDontSee('condition-nav-pills');
    $response->assertSee('carousel-track');
    $response->assertSee('carousel-arrow-prev');
    $response->assertSee('carousel-arrow-next');
});
