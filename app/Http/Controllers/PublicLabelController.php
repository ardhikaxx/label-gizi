<?php

namespace App\Http\Controllers;

use App\Models\ApplicationSetting;
use App\Models\FoodLabel;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\View\View;

class PublicLabelController extends Controller
{
    /**
     * Display the public landing page.
     */
    public function index(Request $request): View
    {
        $today = Carbon::today()->format('Y-m-d');

        // Today's published label, fallback to latest published label
        $todayLabel = FoodLabel::with('menus')
            ->published()
            ->whereDate('menu_date', $today)
            ->latest('published_at')
            ->first();

        if (! $todayLabel) {
            $todayLabel = FoodLabel::with('menus')
                ->published()
                ->orderBy('menu_date', 'desc')
                ->first();
        }

        $settings = ApplicationSetting::getAllSettings();

        // Format data with fallback to reference example (contoh.jpeg)
        $menuDateFormatted = $todayLabel
            ? 'Menu '.$todayLabel->menu_date->isoFormat('dddd, D MMMM Y')
            : 'Menu Senin, 12 Oktober 2026';

        $menuItemsFormatted = ($todayLabel && $todayLabel->menus->isNotEmpty())
            ? $todayLabel->menus->pluck('name')->map(function ($name) {
                return trim(preg_replace('/\s*\([^)]*\)/', '', $name));
            })->filter()->join(', ')
            : 'Nasi, Sop Ayam Sayur, Tumis Tahu, Semangka';

        $nutrition = [
            'energy' => $todayLabel ? $todayLabel->formatNutrient($todayLabel->energy) : '301,9',
            'protein' => $todayLabel ? $todayLabel->formatNutrient($todayLabel->protein) : '14,95',
            'fat' => $todayLabel ? $todayLabel->formatNutrient($todayLabel->fat) : '10,29',
            'carbohydrate' => $todayLabel ? $todayLabel->formatNutrient($todayLabel->carbohydrate) : '36,97',
            'fiber' => $todayLabel ? $todayLabel->formatNutrient($todayLabel->fiber) : '1,8',
        ];

        $limitHours = $todayLabel ? (int) $todayLabel->consumption_limit_hours : 4;
        if ($limitHours <= 0) {
            $limitHours = 4;
        }

        $consumptionNotice = "Makanan harap dikonsumsi maksimal {$limitHours} jam setelah diterima";
        $consumptionTimeRange = $todayLabel
            ? $todayLabel->formatted_consumption_time_range
            : 'Pukul : 08.00 – 12.00 WIB';

        $dishImageUrl = ($todayLabel && $todayLabel->image)
            ? $todayLabel->image_url
            : asset('images/default-menu.jpg');

        return view('public.index', [
            'todayLabel' => $todayLabel,
            'settings' => $settings,
            'menuDateFormatted' => $menuDateFormatted,
            'menuItemsFormatted' => $menuItemsFormatted,
            'nutrition' => $nutrition,
            'consumptionNotice' => $consumptionNotice,
            'consumptionTimeRange' => $consumptionTimeRange,
            'dishImageUrl' => $dishImageUrl,
        ]);
    }
}
