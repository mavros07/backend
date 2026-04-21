<?php

namespace App\Http\Controllers;

use App\Models\SiteTrafficEvent;
use Carbon\Carbon;
use Carbon\CarbonPeriod;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Arr;
use Illuminate\Support\Collection;
use Illuminate\View\View;

class AdminAnalyticsController extends Controller
{
    public function index(Request $request): View|Response
    {
        $days = (int) $request->integer('range', 90);
        if (! in_array($days, [7, 30, 90], true)) {
            $days = 90;
        }
        $end = now();
        $start = now()->subDays($days - 1)->startOfDay();

        $baseQuery = SiteTrafficEvent::query()->betweenDates($start, $end);

        $totalViews = (clone $baseQuery)->count();
        $uniqueSessions = (clone $baseQuery)->whereNotNull('session_id')->distinct('session_id')->count('session_id');
        $uniquePages = (clone $baseQuery)->distinct('path')->count('path');
        $topReferrer = (clone $baseQuery)->whereNotNull('referrer_host')->selectRaw('referrer_host, COUNT(*) as views')->groupBy('referrer_host')->orderByDesc('views')->first();

        $trendRows = (clone $baseQuery)
            ->selectRaw('DATE(viewed_at) as day, COUNT(*) as views, COUNT(DISTINCT session_id) as sessions')
            ->groupByRaw('DATE(viewed_at)')
            ->orderByRaw('DATE(viewed_at)')
            ->get()
            ->keyBy('day');

        $dailyTrend = $this->buildDailyTrend($start, $end, $trendRows);
        $lineChart = $this->buildLineChart($dailyTrend);

        $deviceBreakdown = $this->buildDeviceBreakdown(clone $baseQuery);

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

        $topReferrers = (clone $baseQuery)
            ->whereNotNull('referrer_host')
            ->selectRaw('referrer_host, COUNT(*) as views')
            ->groupBy('referrer_host')
            ->orderByDesc('views')
            ->limit(6)
            ->get();

        $sessionDepthRows = (clone $baseQuery)
            ->whereNotNull('session_id')
            ->selectRaw('session_id, COUNT(*) as views')
            ->groupBy('session_id')
            ->get();

        $bounceSessions = $sessionDepthRows->where('views', 1)->count();
        $bounceRate = $sessionDepthRows->isEmpty() ? 0.0 : ($bounceSessions / $sessionDepthRows->count()) * 100;
        $avgViewsPerSession = $sessionDepthRows->isEmpty() ? 0.0 : $sessionDepthRows->avg('views');

        if ($request->query('export') === 'csv') {
            return $this->csvExport($dailyTrend, $days);
        }

        return view('admin.analytics.index', [
            'rangeDays' => $days,
            'summary' => [
                'total_views' => $totalViews,
                'unique_sessions' => $uniqueSessions,
                'unique_pages' => $uniquePages,
                'top_referrer' => $topReferrer?->referrer_host,
                'top_referrer_views' => (int) ($topReferrer?->views ?? 0),
                'bounce_rate' => round($bounceRate, 1),
                'avg_views_per_session' => round((float) $avgViewsPerSession, 2),
            ],
            'dailyTrend' => $dailyTrend,
            'lineChart' => $lineChart,
            'deviceBreakdown' => $deviceBreakdown,
            'topPages' => $topPages,
            'topListings' => $topListings,
            'topReferrers' => $topReferrers,
        ]);
    }

    /**
     * @param  array<int, array{date:string,label:string,views:int,sessions:int}>  $dailyTrend
     */
    protected function csvExport(array $dailyTrend, int $days): Response
    {
        $lines = ['date,views,sessions'];
        foreach ($dailyTrend as $row) {
            $lines[] = implode(',', [$row['date'], $row['views'], $row['sessions']]);
        }

        return response(implode("\n", $lines), 200, [
            'Content-Type' => 'text/csv; charset=UTF-8',
            'Content-Disposition' => 'attachment; filename="analytics-'.$days.'d.csv"',
        ]);
    }

    /**
     * @param  \Illuminate\Support\Collection<int, mixed>  $trendRows
     * @return array<int, array{date:string,label:string,views:int,sessions:int}>
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
                'sessions' => (int) ($trendRows->get($dateKey)->sessions ?? 0),
            ];
        }

        return $rows;
    }

    /**
     * @param  array<int, array{date:string,label:string,views:int,sessions:int}>  $dailyTrend
     * @return array<string, mixed>
     */
    protected function buildLineChart(array $dailyTrend): array
    {
        $width = 1200.0;
        $height = 320.0;
        $paddingX = 24.0;
        $paddingY = 24.0;
        $usableWidth = $width - ($paddingX * 2);
        $usableHeight = $height - ($paddingY * 2);

        $maxValue = max(1, collect($dailyTrend)->max(fn (array $point): int => max($point['views'], $point['sessions'])));
        $count = max(1, count($dailyTrend));
        $stepX = $count === 1 ? 0 : ($usableWidth / ($count - 1));

        $viewPoints = [];
        $sessionPoints = [];

        foreach ($dailyTrend as $index => $point) {
            $x = $paddingX + ($stepX * $index);
            $viewY = $paddingY + ($usableHeight * (1 - ($point['views'] / $maxValue)));
            $sessionY = $paddingY + ($usableHeight * (1 - ($point['sessions'] / $maxValue)));
            $viewPoints[] = [$x, $viewY];
            $sessionPoints[] = [$x, $sessionY];
        }

        $viewPath = $this->toPath($viewPoints);
        $sessionPath = $this->toPath($sessionPoints);
        $viewAreaPath = $this->toAreaPath($viewPoints, $height - $paddingY);

        return [
            'width' => (int) $width,
            'height' => (int) $height,
            'max_value' => $maxValue,
            'view_path' => $viewPath,
            'view_area_path' => $viewAreaPath,
            'session_path' => $sessionPath,
            'labels' => Arr::only($dailyTrend, [0, (int) floor(($count - 1) / 3), (int) floor((($count - 1) * 2) / 3), $count - 1]),
        ];
    }

    /**
     * @return array<int, array{label:string,value:int,percentage:float,color:string}>
     */
    protected function buildDeviceBreakdown(Builder $query): array
    {
        $events = $query->select(['user_agent'])->get();

        $buckets = [
            'Desktop' => 0,
            'Mobile' => 0,
            'Tablet' => 0,
        ];

        foreach ($events as $event) {
            $ua = strtolower((string) $event->user_agent);
            if ($ua === '') {
                $buckets['Desktop']++;
                continue;
            }
            if (str_contains($ua, 'ipad') || str_contains($ua, 'tablet')) {
                $buckets['Tablet']++;
                continue;
            }
            if (str_contains($ua, 'mobile') || str_contains($ua, 'android') || str_contains($ua, 'iphone')) {
                $buckets['Mobile']++;
                continue;
            }
            $buckets['Desktop']++;
        }

        $total = max(1, array_sum($buckets));
        $colors = [
            'Desktop' => 'from-indigo-500 to-indigo-600',
            'Mobile' => 'from-emerald-500 to-emerald-600',
            'Tablet' => 'from-amber-500 to-amber-600',
        ];

        $out = [];
        foreach ($buckets as $label => $value) {
            $out[] = [
                'label' => $label,
                'value' => $value,
                'percentage' => round(($value / $total) * 100, 1),
                'color' => $colors[$label],
            ];
        }

        return $out;
    }

    /**
     * @param  array<int, array{0:float,1:float}>  $points
     */
    protected function toPath(array $points): string
    {
        if ($points === []) {
            return '';
        }

        $chunks = [];
        foreach ($points as $index => [$x, $y]) {
            $prefix = $index === 0 ? 'M' : 'L';
            $chunks[] = sprintf('%s%.2f %.2f', $prefix, $x, $y);
        }

        return implode(' ', $chunks);
    }

    /**
     * @param  array<int, array{0:float,1:float}>  $points
     */
    protected function toAreaPath(array $points, float $baselineY): string
    {
        if ($points === []) {
            return '';
        }

        $path = $this->toPath($points);
        $last = $points[count($points) - 1];
        $first = $points[0];

        return sprintf(
            '%s L%.2f %.2f L%.2f %.2f Z',
            $path,
            $last[0],
            $baselineY,
            $first[0],
            $baselineY
        );
    }
}
