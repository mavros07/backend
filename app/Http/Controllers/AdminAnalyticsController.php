<?php

namespace App\Http\Controllers;

use App\Models\SiteTrafficEvent;
use Carbon\Carbon;
use Carbon\CarbonPeriod;
use Illuminate\Support\Collection;
use Illuminate\View\View;

class AdminAnalyticsController extends Controller
{
    public function index(): View
    {
        $days = 90;
        $end = now();
        $start = now()->subDays($days - 1)->startOfDay();

        $baseQuery = SiteTrafficEvent::query()->betweenDates($start, $end);

        $totalViews = (clone $baseQuery)->count();
        $uniqueSessions = (clone $baseQuery)->whereNotNull('session_id')->distinct('session_id')->count('session_id');
        $uniquePages = (clone $baseQuery)->distinct('path')->count('path');
        $topReferrer = (clone $baseQuery)->whereNotNull('referrer_host')->selectRaw('referrer_host, COUNT(*) as views')->groupBy('referrer_host')->orderByDesc('views')->first();

        $trendRows = (clone $baseQuery)
            ->selectRaw('DATE(viewed_at) as day, COUNT(*) as views')
            ->groupByRaw('DATE(viewed_at)')
            ->orderByRaw('DATE(viewed_at)')
            ->get()
            ->keyBy('day');

        $dailyTrend = $this->buildDailyTrend($start, $end, $trendRows);

        $topPages = (clone $baseQuery)
            ->selectRaw('path, COUNT(*) as views, COUNT(DISTINCT session_id) as sessions')
            ->groupBy('path')
            ->orderByDesc('views')
            ->limit(10)
            ->get();

        $topListings = (clone $baseQuery)
            ->whereNotNull('vehicle_slug')
            ->selectRaw('vehicle_slug, COUNT(*) as views, COUNT(DISTINCT session_id) as sessions')
            ->groupBy('vehicle_slug')
            ->orderByDesc('views')
            ->limit(10)
            ->get();

        return view('admin.analytics.index', [
            'rangeDays' => $days,
            'summary' => [
                'total_views' => $totalViews,
                'unique_sessions' => $uniqueSessions,
                'unique_pages' => $uniquePages,
                'top_referrer' => $topReferrer?->referrer_host,
                'top_referrer_views' => (int) ($topReferrer?->views ?? 0),
            ],
            'dailyTrend' => $dailyTrend,
            'topPages' => $topPages,
            'topListings' => $topListings,
        ]);
    }

    /**
     * @param  \Illuminate\Support\Collection<int, mixed>  $trendRows
     * @return array<int, array{date:string,label:string,views:int}>
     */
    protected function buildDailyTrend(Carbon $start, Carbon $end, Collection $trendRows): array
    {
        $rows = [];
        foreach (CarbonPeriod::create($start, $end) as $day) {
            $dateKey = $day->format('Y-m-d');
            $rows[] = [
                'date' => $dateKey,
                'label' => $day->format('M j'),
                'views' => (int) ($trendRows->get($dateKey)->views ?? 0),
            ];
        }

        return $rows;
    }
}
