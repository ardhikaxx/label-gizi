<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\ActivityLog;
use App\Models\FoodLabel;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\View\View;

class DashboardController extends Controller
{
    /**
     * Show the admin application dashboard.
     */
    public function index(): View
    {
        // Real database statistics
        $stats = [
            'total_labels' => FoodLabel::count(),
            'published_labels' => FoodLabel::published()->count(),
            'draft_labels' => FoodLabel::draft()->count(),
            'scheduled_labels' => FoodLabel::scheduled()->count(),
            'archived_labels' => FoodLabel::archived()->count(),
            'total_users' => User::count(),
        ];

        // Today's published food labels
        $today = Carbon::today()->format('Y-m-d');
        $todayLabels = FoodLabel::with(['menus', 'creator'])
            ->published()
            ->whereDate('menu_date', $today)
            ->latest('published_at')
            ->get();

        // Recent labels across all statuses
        $recentLabels = FoodLabel::with(['menus', 'creator'])
            ->latest('updated_at')
            ->take(6)
            ->get();

        // Recent administrative activity logs
        $recentActivities = ActivityLog::with('user')
            ->latest('created_at')
            ->take(7)
            ->get();

        // Chart 1: Monthly publications over past 6 months
        $months = [];
        $monthlyCounts = [];
        for ($i = 5; $i >= 0; $i--) {
            $monthDate = Carbon::now()->subMonths($i);
            $monthKey = $monthDate->format('M Y');
            $months[] = $monthKey;

            $count = FoodLabel::published()
                ->whereYear('published_at', $monthDate->year)
                ->whereMonth('published_at', $monthDate->month)
                ->count();
            $monthlyCounts[] = $count;
        }

        // Chart 2: Status distribution
        $statusDistribution = [
            'labels' => ['Dipublikasikan', 'Draft', 'Terjadwal', 'Diarsipkan'],
            'data' => [
                $stats['published_labels'],
                $stats['draft_labels'],
                $stats['scheduled_labels'],
                $stats['archived_labels'],
            ],
        ];

        return view('admin.dashboard.index', [
            'stats' => $stats,
            'todayLabels' => $todayLabels,
            'recentLabels' => $recentLabels,
            'recentActivities' => $recentActivities,
            'chartMonths' => $months,
            'chartMonthlyCounts' => $monthlyCounts,
            'statusDistribution' => $statusDistribution,
        ]);
    }
}
