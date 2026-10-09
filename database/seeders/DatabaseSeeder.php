<?php

namespace Database\Seeders;

use App\Models\ActivityLog;
use App\Models\ApplicationSetting;
use App\Models\FoodLabel;
use App\Models\FoodLabelMenu;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // 1. Initial Admin User (idempotent, supports environment configuration)
        $adminEmail = env('ADMIN_EMAIL', 'admin@labelgizi.test');
        $adminUsername = env('ADMIN_USERNAME', 'admin');
        $adminPassword = env('ADMIN_PASSWORD', 'password');

        $admin = User::firstOrCreate(
            ['email' => $adminEmail],
            [
                'name' => 'Administrator Label Gizi',
                'username' => $adminUsername,
                'password' => Hash::make($adminPassword),
                'is_active' => true,
                'email_verified_at' => now(),
            ]
        );

        // 2. Application Settings
        $settings = [
            [
                'key' => 'app_name',
                'value' => 'Label Gizi',
                'type' => 'string',
                'group' => 'general',
                'label' => 'Nama Aplikasi',
            ],
            [
                'key' => 'institution_name',
                'value' => 'Pusat Distribusi Makanan Bergizi Sehat',
                'type' => 'string',
                'group' => 'general',
                'label' => 'Nama Instansi / Pengelola',
            ],
            [
                'key' => 'contact_email',
                'value' => 'layanan@labelgizi.go.id',
                'type' => 'string',
                'group' => 'contact',
                'label' => 'Email Kontak',
            ],
            [
                'key' => 'contact_phone',
                'value' => '+62 812-3456-7890',
                'type' => 'string',
                'group' => 'contact',
                'label' => 'Nomor Telepon Kontak',
            ],
            [
                'key' => 'footer_text',
                'value' => 'Sistem Informasi Label Makanan Bergizi — Transparansi Pangan Sehat untuk Generasi Indonesia Kuat.',
                'type' => 'text',
                'group' => 'general',
                'label' => 'Teks Footer',
            ],
            [
                'key' => 'hero_title',
                'value' => 'Informasi Label Makanan Bergizi Gratis',
                'type' => 'string',
                'group' => 'general',
                'label' => 'Judul Hero Landing Page',
            ],
            [
                'key' => 'hero_subtitle',
                'value' => 'Transparansi kandungan gizi, rincian menu harian, dan petunjuk batas akhir konsumsi makanan untuk kesehatan dan keamanan pangan masyarakat.',
                'type' => 'text',
                'group' => 'general',
                'label' => 'Subjudul Hero Landing Page',
            ],
            [
                'key' => 'education_title',
                'value' => 'Mengapa Informasi Gizi dan Batas Konsumsi Penting?',
                'type' => 'string',
                'group' => 'general',
                'label' => 'Judul Bagian Edukasi Gizi',
            ],
            [
                'key' => 'education_text',
                'value' => 'Setiap porsi makanan dirancang untuk memenuhi standar zat gizi makro yang dibutuhkan tubuh: energi sebagai bahan bakar aktivitas, protein untuk pertumbuhan jaringan sel, lemak esensial, karbohidrat, serta serat untuk pencernaan sehat. Batas waktu konsumsi dihitung secara cermat sejak pengantaran untuk menjaga higienitas dan memastikan makanan dinikmati dalam kondisi segar dan aman.',
                'type' => 'text',
                'group' => 'general',
                'label' => 'Teks Bagian Edukasi Gizi',
            ],
        ];

        foreach ($settings as $setting) {
            ApplicationSetting::updateOrCreate(
                ['key' => $setting['key']],
                $setting
            );
        }

        // 3. Sample Food Labels (only if none exist)
        if (FoodLabel::count() === 0) {
            // Label 1: Today's Menu (Published)
            $today = Carbon::today();
            $label1 = FoodLabel::create([
                'title' => 'Paket Menu Bergizi Siang - Ayam Bakar Madu',
                'slug' => FoodLabel::generateUniqueSlug('Paket Menu Bergizi Siang - Ayam Bakar Madu', $today),
                'menu_date' => $today->format('Y-m-d'),
                'description' => 'Paket makanan bergizi lengkap kaya protein hewani, serat sayuran kukus, buah tropis, dan kalsium susu alami.',
                'energy' => 625.50,
                'protein' => 24.50,
                'fat' => 18.00,
                'carbohydrate' => 78.50,
                'fiber' => 6.20,
                'consumption_limit_hours' => 4.0,
                'status' => 'published',
                'published_at' => now(),
                'created_by' => $admin->id,
            ]);

            $menus1 = [
                'Nasi Putih Pulen Organik (150 gram)',
                'Ayam Panggang Fillet Saus Kecap Madu',
                'Tumis Sayur Buncis, Jagung Manis & Wortel',
                'Buah Pisang Barangan Segar',
                'Susu UHT Plain Rendah Lemak (200 ml)',
            ];
            foreach ($menus1 as $index => $menuName) {
                FoodLabelMenu::create([
                    'food_label_id' => $label1->id,
                    'name' => $menuName,
                    'sort_order' => $index + 1,
                ]);
            }

            // Label 2: Yesterday's Menu (Published)
            $yesterday = Carbon::yesterday();
            $label2 = FoodLabel::create([
                'title' => 'Paket Menu Sehat Daging Cincang & Tahu Sutra',
                'slug' => FoodLabel::generateUniqueSlug('Paket Menu Sehat Daging Cincang & Tahu Sutra', $yesterday),
                'menu_date' => $yesterday->format('Y-m-d'),
                'description' => 'Menu gizi seimbang dengan kombinasi protein hewani daging sapi cincang bergizi tinggi dan nabati tahu sutra.',
                'energy' => 590.00,
                'protein' => 22.00,
                'fat' => 16.50,
                'carbohydrate' => 74.00,
                'fiber' => 5.50,
                'consumption_limit_hours' => 3.5,
                'status' => 'published',
                'published_at' => $yesterday->copy()->setHour(7),
                'created_by' => $admin->id,
            ]);

            $menus2 = [
                'Nasi Putih Beras Ramos',
                'Semur Daging Sapi Cincang Saus Rempah',
                'Tahu Sutra Kukus Tabur Daun Bawang',
                'Setup Sayur Brokoli & Wortel Segar',
                'Buah Jeruk Manis Segar',
            ];
            foreach ($menus2 as $index => $menuName) {
                FoodLabelMenu::create([
                    'food_label_id' => $label2->id,
                    'name' => $menuName,
                    'sort_order' => $index + 1,
                ]);
            }

            // Label 3: Tomorrow's Menu (Draft / Persiapan)
            $tomorrow = Carbon::tomorrow();
            $label3 = FoodLabel::create([
                'title' => 'Paket Menu Ikan Gurame Asam Manis Sehat',
                'slug' => FoodLabel::generateUniqueSlug('Paket Menu Ikan Gurame Asam Manis Sehat', $tomorrow),
                'menu_date' => $tomorrow->format('Y-m-d'),
                'description' => 'Persiapan menu gizi tinggi asam lemak omega-3 dari ikan gurame fillet dan serat bayam.',
                'energy' => 610.00,
                'protein' => 26.00,
                'fat' => 17.00,
                'carbohydrate' => 75.00,
                'fiber' => 5.80,
                'consumption_limit_hours' => 4.0,
                'status' => 'draft',
                'created_by' => $admin->id,
            ]);

            $menus3 = [
                'Nasi Putih Pulen',
                'Gurame Fillet Saus Tomat Asam Manis Alami',
                'Sayur Bening Bayam Jagung Manis',
                'Tempe Bacem Bakar Tradisional',
                'Buah Potong Semangka Merah',
            ];
            foreach ($menus3 as $index => $menuName) {
                FoodLabelMenu::create([
                    'food_label_id' => $label3->id,
                    'name' => $menuName,
                    'sort_order' => $index + 1,
                ]);
            }

            // 4. Initial Activity Logs
            ActivityLog::record(
                'init',
                'Sistem Label Gizi diinisialisasi dengan data awal dan pengaturan aplikasi.',
                $label1,
                null,
                $admin->id
            );
        }

        // 5. Historical sample published labels for trend chart visualization (past 5 months)
        if (FoodLabel::where('menu_date', '<', Carbon::now()->startOfMonth())->count() === 0) {
            $historyMonths = [
                ['sub_months' => 5, 'count' => 2, 'title' => 'Menu Bergizi Sehat Periode Mei'],
                ['sub_months' => 4, 'count' => 3, 'title' => 'Menu Bergizi Sehat Periode Juni'],
                ['sub_months' => 3, 'count' => 4, 'title' => 'Menu Bergizi Sehat Periode Juli'],
                ['sub_months' => 2, 'count' => 5, 'title' => 'Menu Bergizi Sehat Periode Agustus'],
                ['sub_months' => 1, 'count' => 6, 'title' => 'Menu Bergizi Sehat Periode September'],
            ];

            foreach ($historyMonths as $hist) {
                for ($h = 1; $h <= $hist['count']; $h++) {
                    $histDate = Carbon::now()->startOfMonth()->subMonths($hist['sub_months'])->addDays($h * 4);
                    $histLabel = FoodLabel::create([
                        'title' => "{$hist['title']} #{$h}",
                        'slug' => FoodLabel::generateUniqueSlug("{$hist['title']} #{$h}", $histDate),
                        'menu_date' => $histDate->format('Y-m-d'),
                        'description' => 'Menu makanan bergizi seimbang historis untuk pemenuhan zat gizi penerima.',
                        'energy' => 600.00 + ($h * 12),
                        'protein' => 22.00 + $h,
                        'fat' => 16.00 + ($h * 0.4),
                        'carbohydrate' => 74.00 + $h,
                        'fiber' => 5.50 + ($h * 0.2),
                        'consumption_limit_hours' => 4.0,
                        'status' => 'published',
                        'published_at' => $histDate->copy()->setHour(8),
                        'created_by' => $admin->id,
                    ]);

                    FoodLabelMenu::create([
                        'food_label_id' => $histLabel->id,
                        'name' => 'Nasi Pulen & Lauk Bergizi Lengkap',
                        'sort_order' => 1,
                    ]);
                    FoodLabelMenu::create([
                        'food_label_id' => $histLabel->id,
                        'name' => 'Sayuran Segar & Buah Musiman',
                        'sort_order' => 2,
                    ]);
                }
            }
        }
    }
}
