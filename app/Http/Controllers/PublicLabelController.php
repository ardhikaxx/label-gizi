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
        // Auto-publish any scheduled labels whose date has arrived
        FoodLabel::publishDueScheduledLabels();

        $today = Carbon::today()->format('Y-m-d');
        $requestedDate = $request->query('date');

        if (! empty($requestedDate) && preg_match('/^\d{4}-\d{2}-\d{2}$/', $requestedDate)) {
            $targetDate = $requestedDate;
        } else {
            $targetDate = $today;
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

        $todayLabel = $sortedLabels->first();
        $primarySlide = $slides->first();

        return view('public.index', [
            'slides' => $slides,
            'todayLabel' => $todayLabel,
            'todayLabels' => $sortedLabels,
            'targetDate' => $targetDate,
            'settings' => $settings,
            'institutionName' => ApplicationSetting::get('institution_name', 'SPPG PONOROGO KAUMAN SOMOROTO - Badan Gizi Nasional'),
            'menuDateFormatted' => $primarySlide ? $primarySlide['menuDateFormatted'] : 'Menu '.Carbon::parse($targetDate)->isoFormat('dddd, D MMMM Y'),
            'menuItemsFormatted' => $primarySlide ? $primarySlide['menuItemsFormatted'] : '',
            'nutrition' => $primarySlide ? $primarySlide['nutrition'] : [
                'energy' => '-',
                'protein' => '-',
                'fat' => '-',
                'carbohydrate' => '-',
                'fiber' => '-',
            ],
            'consumptionNotice' => $primarySlide ? $primarySlide['consumptionNotice'] : '',
            'consumptionTimeRange' => $primarySlide ? $primarySlide['consumptionTimeRange'] : '',
            'dishImageUrl' => $primarySlide ? $primarySlide['dishImageUrl'] : asset('images/default-menu.jpg'),
            'allConditions' => FoodLabel::CONDITIONS,
        ]);
    }
}
