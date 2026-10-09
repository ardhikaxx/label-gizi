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

test('public visitors can browse catalog and search by keyword', function () {
    $label1 = FoodLabel::factory()->create([
        'title' => 'Paket Semur Daging Gurih',
        'status' => 'published',
    ]);
    FoodLabelMenu::create(['food_label_id' => $label1->id, 'name' => 'Semur Daging Sapi', 'sort_order' => 1]);

    $label2 = FoodLabel::factory()->create([
        'title' => 'Paket Sayur Lodeh Tahu',
        'status' => 'published',
    ]);
    FoodLabelMenu::create(['food_label_id' => $label2->id, 'name' => 'Sayur Lodeh', 'sort_order' => 1]);

    $response = $this->get(route('public.labels', ['search' => 'Semur']));

    $response->assertStatus(200);
    $response->assertSee('Paket Semur Daging Gurih');
    $response->assertDontSee('Paket Sayur Lodeh Tahu');
});

test('public visitors can filter catalog by date', function () {
    $targetDate = '2026-11-15';
    $label = FoodLabel::factory()->create([
        'title' => 'Menu Tanggal Khusus',
        'menu_date' => $targetDate,
        'status' => 'published',
    ]);

    $otherLabel = FoodLabel::factory()->create([
        'title' => 'Menu Tanggal Lain',
        'menu_date' => '2026-11-20',
        'status' => 'published',
    ]);

    $response = $this->get(route('public.labels', ['date' => $targetDate]));

    $response->assertStatus(200);
    $response->assertSee('Menu Tanggal Khusus');
    $response->assertDontSee('Menu Tanggal Lain');
});

test('public visitors can view details of a published food label', function () {
    $label = FoodLabel::factory()->create([
        'title' => 'Detail Menu Bergizi Sehat',
        'status' => 'published',
        'energy' => 610,
        'protein' => 25.5,
        'consumption_limit_hours' => 4.0,
    ]);
    FoodLabelMenu::create([
        'food_label_id' => $label->id,
        'name' => 'Nasi Merah Organik',
        'sort_order' => 1,
    ]);

    $response = $this->get(route('public.labels.show', $label->slug));

    $response->assertStatus(200);
    $response->assertSee('Detail Menu Bergizi Sehat');
    $response->assertSee('Nasi Merah Organik');
    $response->assertSee('Maksimal 4 jam setelah pengantaran');
});

test('public visitors cannot view draft food labels', function () {
    $draftLabel = FoodLabel::factory()->draft()->create([
        'title' => 'Menu Rahasia Draft',
    ]);

    $response = $this->get(route('public.labels.show', $draftLabel->slug));

    $response->assertStatus(404);
});

test('public visitors cannot view archived food labels', function () {
    $archivedLabel = FoodLabel::factory()->archived()->create([
        'title' => 'Menu Arsip Masa Lalu',
    ]);

    $response = $this->get(route('public.labels.show', $archivedLabel->slug));

    $response->assertStatus(404);
});

test('public visitors can view printable sticker view of published label', function () {
    $label = FoodLabel::factory()->create([
        'title' => 'Menu Siap Cetak',
        'status' => 'published',
    ]);
    FoodLabelMenu::create(['food_label_id' => $label->id, 'name' => 'Menu Cetak 1', 'sort_order' => 1]);

    $response = $this->get(route('public.labels.print', $label->slug));

    $response->assertStatus(200);
    $response->assertSee('Menu Siap Cetak');
    $response->assertSee('INFORMASI NILAI GIZI');
});

test('public visitors can view about nutrition page', function () {
    $response = $this->get(route('public.about'));

    $response->assertStatus(200);
    $response->assertSee('Tentang Informasi Label Gizi');
});
