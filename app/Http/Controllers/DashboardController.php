<?php

namespace App\Http\Controllers;

use App\Models\Booking;
use App\Models\PageView;
use App\Models\Service;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index(Request $request)
    {
        $user = $request->user();

        if ($user->isProvider()) {
            $services = $user->services()->withCount('bookings')->get();
            $bookings = Booking::whereHas('service', fn ($q) => $q->where('provider_id', $user->id))
                ->with('service', 'client')
                ->latest()
                ->get();

            return view('dashboard.provider', compact('services', 'bookings'));
        }

        $bookings = $user->bookings()->with('service.provider')->latest()->get();

        return view('dashboard.client', compact('bookings'));
    }

    public function stats()
    {
        $totalViews = PageView::count();
        $todayViews = PageView::whereDate('visited_at', today())->count();
        $uniqueVisitorsToday = PageView::whereDate('visited_at', today())->distinct('ip_hash')->count('ip_hash');

        $topPages = PageView::selectRaw('path, count(*) as views')
            ->groupBy('path')
            ->orderByDesc('views')
            ->limit(10)
            ->get();

        $last7Days = PageView::selectRaw('DATE(visited_at) as day, count(*) as views')
            ->where('visited_at', '>=', now()->subDays(6)->startOfDay())
            ->groupBy('day')
            ->orderBy('day')
            ->get();

        return view('dashboard.stats', compact('totalViews', 'todayViews', 'uniqueVisitorsToday', 'topPages', 'last7Days'));
    }
}
