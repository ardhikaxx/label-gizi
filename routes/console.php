<?php

use App\Models\FoodLabel;
use Illuminate\Foundation\Inspiring;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Schedule;

Artisan::command('inspire', function () {
    $this->comment(Inspiring::quote());
})->purpose('Display an inspiring quote');

Artisan::command('labels:publish-scheduled', function () {
    $count = FoodLabel::publishDueScheduledLabels();
    $this->info("Berhasil menerbitkan {$count} label makanan terjadwal yang telah tiba waktu tanggal menunya.");
})->purpose('Menerbitkan label makanan berstatus terjadwal yang tanggal menunya telah tiba');

Schedule::command('labels:publish-scheduled')
    ->everyFifteenMinutes()
    ->name('publish-due-food-labels');
