<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\ActivityLog;
use Illuminate\Http\Request;
use Illuminate\View\View;

class ActivityLogController extends Controller
{
    /**
     * Display a listing of administrative activity logs.
     */
    public function index(Request $request): View
    {
        $action = $request->query('action');
        $search = $request->query('search');

        $query = ActivityLog::with('user');

        if (! empty($action)) {
            $query->where('action', $action);
        }

        if (! empty($search)) {
            $query->where(function ($q) use ($search) {
                $q->where('description', 'like', "%{$search}%")
                    ->orWhere('ip_address', 'like', "%{$search}%")
                    ->orWhereHas('user', function ($uq) use ($search) {
                        $uq->where('name', 'like', "%{$search}%")
                            ->orWhere('email', 'like', "%{$search}%");
                    });
            });
        }

        $logs = $query->latest('created_at')->paginate(20)->withQueryString();

        // Distinct actions for filter
        $availableActions = ActivityLog::distinct()->pluck('action');

        return view('admin.activities.index', [
            'logs' => $logs,
            'availableActions' => $availableActions,
            'currentAction' => $action,
            'search' => $search,
        ]);
    }
}
