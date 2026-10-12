<?php

namespace Database\Seeders;

use App\Models\FoodLabel;
use App\Models\FoodLabelMenu;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Database\Seeder;

class FoodLabelMultiConditionSeeder extends Seeder
{
    /**
     * Run the database seeds with rich, realistic multi-condition daily data.
     */
    public function run(): void
    {
        $admin = User::first() ?? User::factory()->create([
            'name' => 'Admin SPPG Kauman Somoroto',
            'email' => 'admin@labelgizi.test',
            'username' => 'admin',
        ]);

        $today = Carbon::today();
        $yesterday = Carbon::yesterday();
        $twoDaysAgo = Carbon::today()->subDays(2);
        $tomorrow = Carbon::tomorrow();

        $dataSets = [
            // =========================================================
            // HARI INI (TODAY) — 5 KONDISI LENGKAP UNTUK FITUR SWIPE
            // =========================================================
            [
                'title' => 'Paket Menu Porsi Besar — Ayam Bakar Madu & Tahu Kukus',
                'date' => $today->format('Y-m-d'),
                'condition' => FoodLabel::CONDITION_PORSI_BESAR,
                'description' => 'Paket makanan bergizi porsi besar lengkap kaya protein hewani, serat sayuran kukus, buah tropis segar, dan kalsium susu alami.',
                'energy' => 685.00,
                'protein' => 27.50,
                'fat' => 19.80,
                'carbohydrate' => 86.40,
                'fiber' => 6.80,
                'limit_hours' => 4.0,
                'time_start' => '08:00',
                'time_end' => '12:00',
                'status' => 'published',
                'published_at' => $today->copy()->setHour(7)->setMinute(30),
                'menus' => [
                    'Nasi Putih Pulen Organik (200 gram)',
                    'Ayam Fillet Bakar Madu Gurih (90 gram)',
                    'Tahu Sutra Bumbu Semur Kecap Manis',
                    'Sup Sayur Campur (Wortel, Buncis & Jagung Pipil)',
                    'Buah Pisang Barangan Segar',
                    'Susu UHT Rendah Lemak (200 ml)',
                ],
            ],
            [
                'title' => 'Paket Menu Porsi Kecil — Ayam Suwir Mentega & Labu Siam',
                'date' => $today->format('Y-m-d'),
                'condition' => FoodLabel::CONDITION_PORSI_KECIL,
                'description' => 'Paket porsi terukur dirancang khusus untuk pemenuhan gizi anak usia awal tanpa sisa makanan berlebih.',
                'energy' => 450.00,
                'protein' => 18.20,
                'fat' => 12.50,
                'carbohydrate' => 58.00,
                'fiber' => 4.50,
                'limit_hours' => 4.0,
                'time_start' => '08:00',
                'time_end' => '12:00',
                'status' => 'published',
                'published_at' => $today->copy()->setHour(7)->setMinute(35),
                'menus' => [
                    'Nasi Putih Pulen (100 gram)',
                    'Ayam Suwir Saus Mentega Gurih (50 gram)',
                    'Tahu Kukus Kaldu Ayam Bening',
                    'Tumis Sayur Labu Siam & Jagung Manis',
                    'Buah Pepaya Potong Manis',
                ],
            ],
            [
                'title' => 'Paket Bebas Alergen — Daging Sapi Rempah & Tempe Kunyit',
                'date' => $today->format('Y-m-d'),
                'condition' => FoodLabel::CONDITION_ALERGI,
                'description' => 'Menu khusus hipoalergenik: 100% bebas telur, bebas susu sapi, bebas olahan kacang tanah, dan bebas olahan laut (seafood).',
                'energy' => 590.00,
                'protein' => 23.50,
                'fat' => 15.00,
                'carbohydrate' => 76.50,
                'fiber' => 5.50,
                'limit_hours' => 4.0,
                'time_start' => '08:00',
                'time_end' => '12:00',
                'status' => 'published',
                'published_at' => $today->copy()->setHour(7)->setMinute(40),
                'menus' => [
                    'Nasi Putih Organik Bebas Gluten (150 gram)',
                    'Daging Sapi Cincang Saus Rempah Non-Alergen',
                    'Tempe Kedelai Murni Kukus Bumbu Kunyit',
                    'Sayur Bening Bayam Jagung Manis',
                    'Buah Melon Segar Potong',
                ],
            ],
            [
                'title' => 'Paket Nutrisi Balita — Nasi Tim Ayam Halus & Puree Wortel',
                'date' => $today->format('Y-m-d'),
                'condition' => FoodLabel::CONDITION_BALITA,
                'description' => 'Tekstur lembut, mudah dicerna, rendah sodium, serta kaya seng dan zat besi untuk pertumbuhan sel otak dan tubuh balita.',
                'energy' => 360.00,
                'protein' => 14.80,
                'fat' => 9.50,
                'carbohydrate' => 48.00,
                'fiber' => 3.20,
                'limit_hours' => 3.0,
                'time_start' => '08:00',
                'time_end' => '11:00',
                'status' => 'published',
                'published_at' => $today->copy()->setHour(7)->setMinute(45),
                'menus' => [
                    'Nasi Tim Kaldu Ayam Kampung Lembek (100 gram)',
                    'Ayam Cincang Halus Kukus Wortel',
                    'Tahu Sutra Masak Kuah Sayur Gurih',
                    'Sup Labu Kuning & Brokoli Halus',
                    'Buah Pisang Cavendish Halus Keruk',
                ],
            ],
            [
                'title' => 'Paket Khusus Busui & Bumil — Ikan Kakap & Sup Daun Katuk',
                'date' => $today->format('Y-m-d'),
                'condition' => FoodLabel::CONDITION_BUSUI_BUMIL,
                'description' => 'Diformulasikan tinggi asam folat, kalsium, zat besi pencegah anemia, dan daun katuk alami untuk kelancaran masa laktasi.',
                'energy' => 780.00,
                'protein' => 32.50,
                'fat' => 22.00,
                'carbohydrate' => 98.00,
                'fiber' => 7.50,
                'limit_hours' => 4.0,
                'time_start' => '08:00',
                'time_end' => '12:00',
                'status' => 'published',
                'published_at' => $today->copy()->setHour(7)->setMinute(50),
                'menus' => [
                    'Nasi Beras Merah & Putih Campur (200 gram)',
                    'Ikan Kakap Fillet Kukus Jahe & Serai',
                    'Sup Daun Katuk, Oyong & Jagung Manis (Pelancar ASI)',
                    'Tumis Tempe & Kacang Panjang Sumber Asam Folat',
                    'Buah Jeruk Manis & Kurma',
                    'Susu Segar Khusus Kalsium Tinggi (200 ml)',
                ],
            ],

            // =========================================================
            // KEMARIN (YESTERDAY) — 5 KONDISI LENGKAP HISTORIS
            // =========================================================
            [
                'title' => 'Paket Kemarin Porsi Besar — Semur Daging & Telur Rebus',
                'date' => $yesterday->format('Y-m-d'),
                'condition' => FoodLabel::CONDITION_PORSI_BESAR,
                'description' => 'Sajian menu gizi seimbang dengan kombinasi protein hewani daging sapi semur rempah dan telur ayam kampung.',
                'energy' => 670.00,
                'protein' => 26.00,
                'fat' => 18.50,
                'carbohydrate' => 84.00,
                'fiber' => 6.20,
                'limit_hours' => 4.0,
                'time_start' => '08:00',
                'time_end' => '12:00',
                'status' => 'published',
                'published_at' => $yesterday->copy()->setHour(7)->setMinute(30),
                'menus' => [
                    'Nasi Putih Pulen Beras Ramos (200 gram)',
                    'Semur Daging Sapi Lada Rempah',
                    'Telur Ayam Rebus Utuh Bumbu Kecap',
                    'Sayur Tumis Buncis & Jagung Manis',
                    'Buah Semangka Merah Segar',
                ],
            ],
            [
                'title' => 'Paket Kemarin Porsi Kecil — Daging Suwir & Tahu Orek',
                'date' => $yesterday->format('Y-m-d'),
                'condition' => FoodLabel::CONDITION_PORSI_KECIL,
                'description' => 'Paket porsi hemat kalori dengan komposisi makronutrien ideal untuk konsumsi ringan harian.',
                'energy' => 460.00,
                'protein' => 19.00,
                'fat' => 13.00,
                'carbohydrate' => 59.00,
                'fiber' => 4.20,
                'limit_hours' => 4.0,
                'time_start' => '08:00',
                'time_end' => '12:00',
                'status' => 'published',
                'published_at' => $yesterday->copy()->setHour(7)->setMinute(35),
                'menus' => [
                    'Nasi Putih Pulen (100 gram)',
                    'Daging Sapi Suwir Bumbu Semur Manis',
                    'Tahu Orek Gurih Tidak Pedas',
                    'Tumis Wortel & Buncis Iris',
                    'Buah Jeruk Pontianak Manis',
                ],
            ],
            [
                'title' => 'Paket Kemarin Bebas Alergen — Ayam Kukus Bumbu Jahe',
                'date' => $yesterday->format('Y-m-d'),
                'condition' => FoodLabel::CONDITION_ALERGI,
                'description' => 'Bebas alergen umum, aman bagi anak dengan riwayat alergi protein hewani laut, susu laktosa, dan kedelai.',
                'energy' => 580.00,
                'protein' => 24.00,
                'fat' => 14.50,
                'carbohydrate' => 75.00,
                'fiber' => 5.20,
                'limit_hours' => 4.0,
                'time_start' => '08:00',
                'time_end' => '12:00',
                'status' => 'published',
                'published_at' => $yesterday->copy()->setHour(7)->setMinute(40),
                'menus' => [
                    'Nasi Putih Organik',
                    'Ayam Fillet Kukus Kuah Jahe Bening',
                    'Sup Jamur Tiram & Jagung Pipil',
                    'Kentang Panggang Daun Seledri',
                    'Buah Apel Malang Segar',
                ],
            ],
            [
                'title' => 'Paket Nutrisi Kemarin Balita — Bubur Manado Labu & Fillet Ikan',
                'date' => $yesterday->format('Y-m-d'),
                'condition' => FoodLabel::CONDITION_BALITA,
                'description' => 'Bubur lunak sari sayuran dan daging ikan fillet kaya DHA untuk mendukung perkembangan kognitif balita.',
                'energy' => 350.00,
                'protein' => 15.00,
                'fat' => 8.80,
                'carbohydrate' => 46.50,
                'fiber' => 3.00,
                'limit_hours' => 3.0,
                'time_start' => '08:00',
                'time_end' => '11:00',
                'status' => 'published',
                'published_at' => $yesterday->copy()->setHour(7)->setMinute(45),
                'menus' => [
                    'Bubur Beras Pulen Labu Kuning Halus',
                    'Ikan Gurame Fillet Cincang Kukus',
                    'Puree Brokoli & Wortel Kukus',
                    'Tahu Putih Masak Kuah Kaldu Sayur',
                    'Buah Pepaya Masak Keruk Lembut',
                ],
            ],
            [
                'title' => 'Paket Kemarin Busui & Bumil — Sup Ikan Salmon & Daun Kelor',
                'date' => $yesterday->format('Y-m-d'),
                'condition' => FoodLabel::CONDITION_BUSUI_BUMIL,
                'description' => 'Kaya asam lemak esensial omega-3 dan antioksidan daun kelor untuk optimalisasi imunitas ibu dan anak.',
                'energy' => 760.00,
                'protein' => 31.00,
                'fat' => 21.50,
                'carbohydrate' => 95.00,
                'fiber' => 7.20,
                'limit_hours' => 4.0,
                'time_start' => '08:00',
                'time_end' => '12:00',
                'status' => 'published',
                'published_at' => $yesterday->copy()->setHour(7)->setMinute(50),
                'menus' => [
                    'Nasi Beras Merah Organik (200 gram)',
                    'Sup Ikan Kuah Bening Daun Kelor Segar',
                    'Tahu Bacem Bakar Tradisional',
                    'Tumis Bayam Bawang Putih',
                    'Buah Naga Merah Potong',
                    'Susu Kedelai Alami (200 ml)',
                ],
            ],

            // =========================================================
            // 2 HARI LALU — 3 KONDISI
            // =========================================================
            [
                'title' => 'Paket Ikan Nila Bakar Bumbu Kuning — Porsi Besar',
                'date' => $twoDaysAgo->format('Y-m-d'),
                'condition' => FoodLabel::CONDITION_PORSI_BESAR,
                'description' => 'Menu sumber protein air tawar dengan rempah kunyit alami anti-inflamasi.',
                'energy' => 650.00,
                'protein' => 26.50,
                'fat' => 17.00,
                'carbohydrate' => 82.00,
                'fiber' => 6.00,
                'limit_hours' => 4.0,
                'time_start' => '08:00',
                'time_end' => '12:00',
                'status' => 'published',
                'published_at' => $twoDaysAgo->copy()->setHour(7)->setMinute(30),
                'menus' => [
                    'Nasi Putih Pulen (200 gram)',
                    'Ikan Nila Fillet Bakar Bumbu Kuning',
                    'Sayur Asem Segar Jawa Timuran',
                    'Tempe Mendoan Panggang Tanpa Minyak Berlebih',
                    'Buah Pisang Raja Segar',
                ],
            ],
            [
                'title' => 'Paket Porsi Kecil Ikan Nila Fillet',
                'date' => $twoDaysAgo->format('Y-m-d'),
                'condition' => FoodLabel::CONDITION_PORSI_KECIL,
                'description' => 'Porsi terukur menu ikan nila dan sayur asam segar.',
                'energy' => 440.00,
                'protein' => 17.50,
                'fat' => 11.50,
                'carbohydrate' => 56.00,
                'fiber' => 4.00,
                'limit_hours' => 4.0,
                'time_start' => '08:00',
                'time_end' => '12:00',
                'status' => 'published',
                'published_at' => $twoDaysAgo->copy()->setHour(7)->setMinute(35),
                'menus' => [
                    'Nasi Putih Pulen (100 gram)',
                    'Ikan Nila Fillet Kukus Bumbu Rempah',
                    'Sayur Bening Jagung Pipil & Bayam',
                    'Tempe Kukus Bumbu Tradisional',
                    'Buah Pepaya Segar',
                ],
            ],
            [
                'title' => 'Paket Tim Ikan Nila & Sayur Labu Balita',
                'date' => $twoDaysAgo->format('Y-m-d'),
                'condition' => FoodLabel::CONDITION_BALITA,
                'description' => 'Menu tim lembut ikan nila tanpa duri untuk balita.',
                'energy' => 340.00,
                'protein' => 14.00,
                'fat' => 8.50,
                'carbohydrate' => 45.00,
                'fiber' => 2.80,
                'limit_hours' => 3.0,
                'time_start' => '08:00',
                'time_end' => '11:00',
                'status' => 'published',
                'published_at' => $twoDaysAgo->copy()->setHour(7)->setMinute(40),
                'menus' => [
                    'Nasi Tim Kaldu Ikan Nila Halus',
                    'Fillet Ikan Nila Kukus Duri Bersih Cincang',
                    'Sup Sayur Wortel & Labu Siam Halus',
                    'Tahu Sutra Kukus Masak Kaldu',
                    'Buah Pisang Keruk Halus',
                ],
            ],

            // =========================================================
            // BESOK (TOMORROW) — RENCANA DRAFT & TERJADWAL
            // =========================================================
            [
                'title' => 'Rencana Menu Esok — Rolade Daging & Sup Jamur Salju',
                'date' => $tomorrow->format('Y-m-d'),
                'condition' => FoodLabel::CONDITION_PORSI_BESAR,
                'description' => 'Persiapan menu porsi besar esok hari berbasis olahan daging cincang dan sup sayur jamur bernutrisi tinggi.',
                'energy' => 640.00,
                'protein' => 25.00,
                'fat' => 17.50,
                'carbohydrate' => 80.00,
                'fiber' => 5.80,
                'limit_hours' => 4.0,
                'time_start' => '08:00',
                'time_end' => '12:00',
                'status' => 'draft',
                'published_at' => null,
                'menus' => [
                    'Nasi Putih Pulen (200 gram)',
                    'Rolade Daging Sapi Saus Asam Manis',
                    'Sup Jamur Salju & Wortel Bening',
                    'Perkedel Tahu Kukus Panggang',
                    'Buah Semangka Merah',
                ],
            ],
            [
                'title' => 'Rencana Menu Esok Balita — Nasi Tim Daging Halus & Brokoli',
                'date' => $tomorrow->format('Y-m-d'),
                'condition' => FoodLabel::CONDITION_BALITA,
                'description' => 'Persiapan menu balita esok hari dengan tekstur lembut.',
                'energy' => 350.00,
                'protein' => 14.50,
                'fat' => 9.00,
                'carbohydrate' => 47.00,
                'fiber' => 3.00,
                'limit_hours' => 3.0,
                'time_start' => '08:00',
                'time_end' => '11:00',
                'status' => 'draft',
                'published_at' => null,
                'menus' => [
                    'Nasi Tim Kaldu Sapi Halus',
                    'Daging Sapi Giling Kukus Lembut',
                    'Sup Puree Wortel & Brokoli',
                    'Buah Pepaya Halus',
                ],
            ],
        ];

        foreach ($dataSets as $data) {
            // Check if record with same title and menu_date already exists
            $existing = FoodLabel::where('menu_date', $data['date'])
                ->where('food_condition', $data['condition'])
                ->first();

            if ($existing) {
                $existing->update([
                    'title' => $data['title'],
                    'description' => $data['description'],
                    'energy' => $data['energy'],
                    'protein' => $data['protein'],
                    'fat' => $data['fat'],
                    'carbohydrate' => $data['carbohydrate'],
                    'fiber' => $data['fiber'],
                    'consumption_limit_hours' => $data['limit_hours'],
                    'consumption_time_start' => $data['time_start'],
                    'consumption_time_end' => $data['time_end'],
                    'status' => $data['status'],
                    'published_at' => $data['published_at'],
                ]);
                $label = $existing;
                $label->menus()->delete();
            } else {
                $slug = FoodLabel::generateUniqueSlug($data['title'], $data['date']);
                $label = FoodLabel::create([
                    'title' => $data['title'],
                    'slug' => $slug,
                    'menu_date' => $data['date'],
                    'food_condition' => $data['condition'],
                    'description' => $data['description'],
                    'energy' => $data['energy'],
                    'protein' => $data['protein'],
                    'fat' => $data['fat'],
                    'carbohydrate' => $data['carbohydrate'],
                    'fiber' => $data['fiber'],
                    'consumption_limit_hours' => $data['limit_hours'],
                    'consumption_time_start' => $data['time_start'],
                    'consumption_time_end' => $data['time_end'],
                    'status' => $data['status'],
                    'published_at' => $data['published_at'],
                    'created_by' => $admin->id,
                ]);
            }

            foreach ($data['menus'] as $order => $menuName) {
                FoodLabelMenu::create([
                    'food_label_id' => $label->id,
                    'name' => $menuName,
                    'sort_order' => $order + 1,
                ]);
            }
        }
    }
}
