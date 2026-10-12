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
     * Display the public landing page with multi-condition slides for the day.
     */
    public function index(Request $request): View
    {
        $today = Carbon::today()->format('Y-m-d');
        $requestedDate = $request->query('date');

        if (! empty($requestedDate) && preg_match('/^\d{4}-\d{2}-\d{2}$/', $requestedDate)) {
            $targetDate = $requestedDate;
        } else {
            // Check if today has published labels
            $todayExists = FoodLabel::published()->whereDate('menu_date', $today)->exists();

            if ($todayExists) {
                $targetDate = $today;
            } else {
                // Fallback to latest published label date
                $latestDate = FoodLabel::published()->max('menu_date');
                $targetDate = $latestDate ? Carbon::parse($latestDate)->format('Y-m-d') : $today;
            }
        }

        // Fetch all published food labels for target date
        $labels = FoodLabel::with('menus')
            ->published()
            ->whereDate('menu_date', $targetDate)
            ->get();

        // Sort labels by canonical condition order:
        // 1. Porsi besar, 2. Porsi kecil, 3. Alergi, 4. Balita, 5. Busui dan Bumil
        $conditionOrder = array_flip(FoodLabel::CONDITIONS);
        $sortedLabels = $labels->sortBy(function (FoodLabel $label) use ($conditionOrder) {
            $cond = $label->food_condition ?: FoodLabel::CONDITION_PORSI_BESAR;

            return $conditionOrder[$cond] ?? 99;
        })->values();

        $settings = ApplicationSetting::getAllSettings();

        // Format each slide data
        $slides = $sortedLabels->map(function (FoodLabel $label) {
            $conditionName = $label->food_condition ?: FoodLabel::CONDITION_PORSI_BESAR;
            $menuDateFormatted = 'Menu '.$label->menu_date->isoFormat('dddd, D MMMM Y');

            $menuItemsFormatted = $label->menus->isNotEmpty()
                ? $label->menus->pluck('name')->map(function ($name) {
                    return trim(preg_replace('/\s*\([^)]*\)/', '', $name));
                })->filter()->join(', ')
                : 'Nasi, Sop Sayur, Lauk Bergizi, Buah Segar';

            $limitHours = (int) $label->consumption_limit_hours;
            if ($limitHours <= 0) {
                $limitHours = 4;
            }

            return [
                'id' => $label->id,
                'title' => $label->title,
                'condition' => $conditionName,
                'condition_badge_class' => $label->condition_badge_class,
                'menuDateFormatted' => $menuDateFormatted,
                'menuItemsFormatted' => $menuItemsFormatted,
                'nutrition' => [
                    'energy' => $label->formatNutrient($label->energy),
                    'protein' => $label->formatNutrient($label->protein),
                    'fat' => $label->formatNutrient($label->fat),
                    'carbohydrate' => $label->formatNutrient($label->carbohydrate),
                    'fiber' => $label->formatNutrient($label->fiber),
                ],
                'consumptionNotice' => "Makanan harap dikonsumsi maksimal {$limitHours} jam setelah diterima",
                'consumptionTimeRange' => $label->formatted_consumption_time_range,
                'dishImageUrl' => $label->image ? $label->image_url : asset('images/default-menu.jpg'),
                'hasCustomImage' => ! empty($label->image),
                'raw' => $label,
            ];
        });

        // Fallback default slide if no labels exist at all
        if ($slides->isEmpty()) {
            $defaultDateParsed = Carbon::parse($targetDate);
            $slides = collect([[
                'id' => 0,
                'title' => 'Menu Sajian Sehat Bergizi',
                'condition' => FoodLabel::CONDITION_PORSI_BESAR,
                'condition_badge_class' => 'bg-primary text-white',
                'menuDateFormatted' => 'Menu '.$defaultDateParsed->isoFormat('dddd, D MMMM Y'),
                'menuItemsFormatted' => 'Nasi, Sop Ayam Sayur, Tumis Tahu, Semangka',
                'nutrition' => [
                    'energy' => '301,9',
                    'protein' => '14,95',
                    'fat' => '10,29',
                    'carbohydrate' => '36,97',
                    'fiber' => '1,8',
                ],
                'consumptionNotice' => 'Makanan harap dikonsumsi maksimal 4 jam setelah diterima',
                'consumptionTimeRange' => 'Pukul : 08.00 – 12.00 WIB',
                'dishImageUrl' => asset('images/default-menu.jpg'),
                'hasCustomImage' => false,
                'raw' => null,
            ]]);
        }

        $todayLabel = $sortedLabels->first();
        $primarySlide = $slides->first();

        return view('public.index', [
            'slides' => $slides,
            'todayLabel' => $todayLabel,
            'todayLabels' => $sortedLabels,
            'targetDate' => $targetDate,
            'settings' => $settings,
            'menuDateFormatted' => $primarySlide['menuDateFormatted'],
            'menuItemsFormatted' => $primarySlide['menuItemsFormatted'],
            'nutrition' => $primarySlide['nutrition'],
            'consumptionNotice' => $primarySlide['consumptionNotice'],
            'consumptionTimeRange' => $primarySlide['consumptionTimeRange'],
            'dishImageUrl' => $primarySlide['dishImageUrl'],
            'allConditions' => FoodLabel::CONDITIONS,
        ]);
    }
}
