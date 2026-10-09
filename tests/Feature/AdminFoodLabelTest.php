<?php

use App\Models\FoodLabel;
use App\Models\FoodLabelMenu;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\File;

beforeEach(function () {
    $this->admin = User::factory()->create(['is_active' => true]);
});

test('admin can access dashboard and view statistics', function () {
    FoodLabel::factory()->count(3)->create(['status' => 'published']);
    FoodLabel::factory()->count(2)->draft()->create();

    $response = $this->actingAs($this->admin)->get(route('admin.dashboard'));

    $response->assertStatus(200);
    $response->assertSee('Ringkasan Sistem & Statistik');
    $response->assertSee('Total Label');
});

test('create label form starts with blank menu item input and no pre-filled items', function () {
    $response = $this->actingAs($this->admin)->get(route('admin.labels.create'));

    $response->assertStatus(200);
    $response->assertDontSee('Nasi Putih Organik');
    $response->assertDontSee('value="Ayam Fillet Bakar Madu"', false);
    $response->assertDontSee('Tumis Sayur Buncis Jagung Manis');
});

test('admin can store a new food label as draft with partial data', function () {
    $data = [
        'action' => 'draft',
        'title' => 'Menu Draft Rencana Pekan Depan',
        'menu_date' => Carbon::tomorrow()->format('Y-m-d'),
        'recipient_group' => 'Siswa SD',
        'description' => 'Dalam tahap perumusan gizi.',
        'energy' => 0,
        'protein' => 0,
        'fat' => 0,
        'carbohydrate' => 0,
        'fiber' => 0,
        'consumption_limit_hours' => 4.0,
        'menus' => ['Nasi Putih'],
    ];

    $response = $this->actingAs($this->admin)->post(route('admin.labels.store'), $data);

    $response->assertRedirect(route('admin.labels.index'));
    $this->assertDatabaseHas('food_labels', [
        'title' => 'Menu Draft Rencana Pekan Depan',
        'status' => 'draft',
    ]);
});

test('publishing a label requires at least one menu item and positive nutrients', function () {
    $invalidData = [
        'action' => 'publish',
        'title' => 'Menu Tanpa Makanan',
        'menu_date' => Carbon::today()->format('Y-m-d'),
        'energy' => 0,
        'protein' => 0,
        'fat' => 0,
        'carbohydrate' => 0,
        'fiber' => 0,
        'consumption_limit_hours' => 0,
        'menus' => [],
    ];

    $response = $this->actingAs($this->admin)->post(route('admin.labels.store'), $invalidData);

    $response->assertSessionHasErrors(['menus', 'consumption_limit_hours']);
});

test('admin can save and immediately publish a valid food label', function () {
    $validData = [
        'action' => 'publish',
        'title' => 'Paket Lengkap Menu Sehat Terbit',
        'menu_date' => Carbon::today()->format('Y-m-d'),
        'recipient_group' => 'Siswa SD',
        'description' => 'Paket terverifikasi penuh.',
        'energy' => 620.5,
        'protein' => 24.0,
        'fat' => 17.5,
        'carbohydrate' => 76.0,
        'fiber' => 6.0,
        'consumption_limit_hours' => 4.0,
        'menus' => [
            'Nasi Putih Pulen',
            'Ayam Suwir Kecap',
            'Tumis Buncis Jagung Manis',
            'Buah Pisang Segar',
        ],
    ];

    $response = $this->actingAs($this->admin)->post(route('admin.labels.store'), $validData);

    $response->assertRedirect(route('admin.labels.index'));
    $this->assertDatabaseHas('food_labels', [
        'title' => 'Paket Lengkap Menu Sehat Terbit',
        'status' => 'published',
        'energy' => 620.5,
    ]);

    $label = FoodLabel::where('title', 'Paket Lengkap Menu Sehat Terbit')->first();
    expect($label->menus)->toHaveCount(4);
});

test('admin can update an existing label', function () {
    $label = FoodLabel::factory()->create([
        'title' => 'Judul Lama',
        'status' => 'published',
    ]);
    FoodLabelMenu::create(['food_label_id' => $label->id, 'name' => 'Menu Lama', 'sort_order' => 1]);

    $updateData = [
        'action' => 'publish',
        'title' => 'Judul Baru Diperbarui',
        'menu_date' => $label->menu_date->format('Y-m-d'),
        'recipient_group' => 'Umum',
        'energy' => 650,
        'protein' => 25,
        'fat' => 18,
        'carbohydrate' => 78,
        'fiber' => 6,
        'consumption_limit_hours' => 3.5,
        'menus' => ['Menu Baru 1', 'Menu Baru 2'],
    ];

    $response = $this->actingAs($this->admin)->put(route('admin.labels.update', $label), $updateData);

    $response->assertRedirect(route('admin.labels.show', $label));
    $this->assertDatabaseHas('food_labels', [
        'id' => $label->id,
        'title' => 'Judul Baru Diperbarui',
    ]);

    $label->refresh();
    expect($label->menus)->toHaveCount(2);
});

test('admin can duplicate an existing label into a new draft', function () {
    $original = FoodLabel::factory()->create([
        'title' => 'Paket Asli',
        'status' => 'published',
        'energy' => 600,
    ]);
    FoodLabelMenu::create(['food_label_id' => $original->id, 'name' => 'Menu Asli 1', 'sort_order' => 1]);
    FoodLabelMenu::create(['food_label_id' => $original->id, 'name' => 'Menu Asli 2', 'sort_order' => 2]);

    $response = $this->actingAs($this->admin)->post(route('admin.labels.duplicate', $original));

    $response->assertStatus(302);
    $this->assertDatabaseHas('food_labels', [
        'title' => 'Paket Asli (Salinan)',
        'status' => 'draft',
    ]);

    $copy = FoodLabel::where('title', 'Paket Asli (Salinan)')->first();
    expect($copy->menus)->toHaveCount(2);
});

test('admin can publish and unpublish a label', function () {
    $label = FoodLabel::factory()->draft()->create([
        'energy' => 500,
        'consumption_limit_hours' => 4.0,
    ]);
    FoodLabelMenu::create(['food_label_id' => $label->id, 'name' => 'Item 1', 'sort_order' => 1]);

    // Publish
    $resPublish = $this->actingAs($this->admin)->post(route('admin.labels.publish', $label));
    $resPublish->assertStatus(302);
    expect($label->fresh()->status)->toBe('published');

    // Unpublish
    $resUnpublish = $this->actingAs($this->admin)->post(route('admin.labels.unpublish', $label));
    $resUnpublish->assertStatus(302);
    expect($label->fresh()->status)->toBe('draft');
});

test('admin can archive and delete a label', function () {
    $label = FoodLabel::factory()->create(['status' => 'published']);

    // Archive
    $this->actingAs($this->admin)->post(route('admin.labels.archive', $label));
    expect($label->fresh()->status)->toBe('archived');

    // Delete (Soft Delete)
    $this->actingAs($this->admin)->delete(route('admin.labels.destroy', $label));
    $this->assertSoftDeleted('food_labels', ['id' => $label->id]);
});

test('admin can export food labels to CSV safely', function () {
    FoodLabel::factory()->create([
        'title' => '=SUM(A1:A10)', // dangerous CSV injection candidate
        'status' => 'published',
    ]);

    $response = $this->actingAs($this->admin)->get(route('admin.labels.export'));

    $response->assertStatus(200);
    $response->assertHeader('content-type', 'text/csv; charset=UTF-8');

    // Verify formula injection sanitization: leading character should be escaped with single quote
    $content = $response->streamedContent();
    expect($content)->toContain("'=SUM(A1:A10)");
});

test('admin can upload food image converted to webp and stream it without storage link', function () {
    $uploadedFile = UploadedFile::fake()->image('makanan-sehat.jpg', 1200, 900);

    $data = [
        'action' => 'publish',
        'title' => 'Menu Bergizi Dengan Foto',
        'menu_date' => Carbon::today()->format('Y-m-d'),
        'energy' => 550,
        'protein' => 20,
        'fat' => 15,
        'carbohydrate' => 70,
        'fiber' => 5,
        'consumption_limit_hours' => 4.0,
        'menus' => ['Nasi Uduk Sehat', 'Ayam Panggang Suwir'],
        'image' => $uploadedFile,
    ];

    $response = $this->actingAs($this->admin)->post(route('admin.labels.store'), $data);
    $response->assertRedirect(route('admin.labels.index'));

    $label = FoodLabel::where('title', 'Menu Bergizi Dengan Foto')->first();
    expect($label)->not->toBeNull()
        ->and($label->image)->not->toBeNull()
        ->and($label->image)->toEndWith('.webp');

    $savedFilePath = storage_path('uploads/food-labels/'.$label->image);
    expect(File::exists($savedFilePath))->toBeTrue();

    // Verify streaming route without storage:link
    $streamResponse = $this->get('/uploads/food-labels/'.$label->image);
    $streamResponse->assertStatus(200);
    $streamResponse->assertHeader('Content-Type', 'image/webp');
    expect($streamResponse->headers->get('Cache-Control'))->toContain('max-age=31536000')->toContain('immutable');

    // Clean up file
    if (File::exists($savedFilePath)) {
        File::delete($savedFilePath);
    }
});

test('admin can replace and delete uploaded food image', function () {
    $fileA = UploadedFile::fake()->image('gambar_pertama.png', 800, 600);

    $label = FoodLabel::factory()->create([
        'title' => 'Menu Uji Ganti Foto',
        'status' => 'published',
    ]);
    FoodLabelMenu::create(['food_label_id' => $label->id, 'name' => 'Menu 1', 'sort_order' => 1]);

    // 1. Upload initial image
    $updateData1 = [
        'action' => 'publish',
        'title' => 'Menu Uji Ganti Foto',
        'menu_date' => $label->menu_date->format('Y-m-d'),
        'energy' => 500,
        'protein' => 20,
        'fat' => 10,
        'carbohydrate' => 60,
        'fiber' => 4,
        'consumption_limit_hours' => 3.0,
        'menus' => ['Menu 1'],
        'image' => $fileA,
    ];

    $this->actingAs($this->admin)->put(route('admin.labels.update', $label), $updateData1);
    $label->refresh();
    $fileAPath = storage_path('uploads/food-labels/'.$label->image);
    expect(File::exists($fileAPath))->toBeTrue();
    $firstImageName = $label->image;

    // 2. Replace with second image
    $fileB = UploadedFile::fake()->image('gambar_kedua.jpg', 600, 400);
    $updateData2 = array_merge($updateData1, ['image' => $fileB]);

    $this->actingAs($this->admin)->put(route('admin.labels.update', $label), $updateData2);
    $label->refresh();

    // Old image must be removed from disk
    expect(File::exists($fileAPath))->toBeFalse()
        ->and($label->image)->not->toBe($firstImageName);

    $fileBPath = storage_path('uploads/food-labels/'.$label->image);
    expect(File::exists($fileBPath))->toBeTrue();

    // 3. Remove image using remove_image checkbox
    $updateData3 = array_merge($updateData1, ['remove_image' => '1', 'image' => null]);
    $this->actingAs($this->admin)->put(route('admin.labels.update', $label), $updateData3);
    $label->refresh();

    expect($label->image)->toBeNull()
        ->and(File::exists($fileBPath))->toBeFalse();
});

test('admin can delete label image via deleteImage route', function () {
    $file = UploadedFile::fake()->image('gambar.png', 500, 500);

    $label = FoodLabel::factory()->create([
        'title' => 'Menu Uji Delete Route',
        'status' => 'published',
    ]);
    FoodLabelMenu::create(['food_label_id' => $label->id, 'name' => 'Menu 1', 'sort_order' => 1]);

    $this->actingAs($this->admin)->put(route('admin.labels.update', $label), [
        'action' => 'publish',
        'title' => 'Menu Uji Delete Route',
        'menu_date' => $label->menu_date->format('Y-m-d'),
        'energy' => 500,
        'protein' => 20,
        'fat' => 10,
        'carbohydrate' => 60,
        'fiber' => 4,
        'consumption_limit_hours' => 3.0,
        'menus' => ['Menu 1'],
        'image' => $file,
    ]);

    $label->refresh();
    $filePath = storage_path('uploads/food-labels/'.$label->image);
    expect(File::exists($filePath))->toBeTrue();

    $response = $this->actingAs($this->admin)->delete(route('admin.labels.delete-image', $label));
    $response->assertStatus(302);

    $label->refresh();
    expect($label->image)->toBeNull()
        ->and(File::exists($filePath))->toBeFalse();
});
