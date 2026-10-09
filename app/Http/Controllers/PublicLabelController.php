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

        return view('public.index', [
            'todayLabel' => $todayLabel,
            'settings' => $settings,
        ]);
    }
}
