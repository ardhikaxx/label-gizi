<?php

namespace App\Http\Controllers;

use App\Models\ApplicationSetting;
use App\Models\FoodLabel;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
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

    /**
     * Display the full catalog of published food labels with search, filters, and pagination.
     */
    public function catalog(Request $request): View
    {
        $search = $request->query('search');
        $date = $request->query('date');

        $query = FoodLabel::with('menus')
            ->published();

        if (! empty($search)) {
            $query->search($search);
        }

        if (! empty($date)) {
            $query->forDate($date);
        }

        $labels = $query->orderBy('menu_date', 'desc')
            ->paginate(9)
            ->withQueryString();

        $settings = ApplicationSetting::getAllSettings();

        return view('public.catalog', [
            'labels' => $labels,
            'search' => $search,
            'date' => $date,
            'settings' => $settings,
        ]);
    }

    /**
     * Display a single food label in full detail.
     */
    public function show(string $slug): View
    {
        $query = FoodLabel::with(['menus', 'creator'])
            ->where('slug', $slug);

        // If not logged-in as admin, only show published labels
        if (! Auth::check()) {
            $query->published();
        }

        $label = $query->firstOrFail();

        $settings = ApplicationSetting::getAllSettings();

        return view('public.show', [
            'label' => $label,
            'settings' => $settings,
            'isPreview' => ! $label->isPublished(),
        ]);
    }

    /**
     * Printable view of the food label sticker.
     */
    public function print(string $slug): View
    {
        $query = FoodLabel::with(['menus', 'creator'])
            ->where('slug', $slug);

        if (! Auth::check()) {
            $query->published();
        }

        $label = $query->firstOrFail();
        $settings = ApplicationSetting::getAllSettings();

        return view('public.print', [
            'label' => $label,
            'settings' => $settings,
        ]);
    }

    /**
     * Informational page regarding nutrition education and consumption limits.
     */
    public function about(): View
    {
        $settings = ApplicationSetting::getAllSettings();

        return view('public.about', [
            'settings' => $settings,
        ]);
    }
}
