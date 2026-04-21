<x-app-layout>
  <x-slot name="header">
    <div>
      <div class="text-[11px] font-bold uppercase tracking-[0.18em] text-zinc-500">{{ __('Admin') }}</div>
      <div class="text-xl font-bold tracking-tight text-zinc-900">{{ __('Analytics') }}</div>
    </div>
  </x-slot>

  @php
    $deviceA = $deviceBreakdown[0] ?? ['label' => 'Desktop', 'value' => 0, 'percentage' => 0];
    $deviceB = $deviceBreakdown[1] ?? ['label' => 'Mobile', 'value' => 0, 'percentage' => 0];
    $deviceC = $deviceBreakdown[2] ?? ['label' => 'Tablet', 'value' => 0, 'percentage' => 0];
    $circumference = 439.82;
    $dashA = round(($deviceA['percentage'] / 100) * $circumference, 2);
    $dashB = round(($deviceB['percentage'] / 100) * $circumference, 2);
    $dashC = max(0, round($circumference - $dashA - $dashB, 2));
    $offsetB = -$dashA;
    $offsetC = -($dashA + $dashB);
  @endphp

  <div class="space-y-8">
    <div class="flex flex-wrap items-center justify-between gap-3 rounded-2xl border border-zinc-200/80 bg-white p-4 shadow-[0_16px_40px_-32px_rgba(15,23,42,0.35)]">
      <div>
        <p class="text-sm font-semibold text-zinc-900">{{ __('Analytics controls') }}</p>
        <p class="text-xs text-zinc-500">{{ __('Switch range or export the trend data.') }}</p>
      </div>
      <div class="flex items-center gap-2">
        @foreach ([7, 30, 90] as $rangeOption)
          <a href="{{ route('admin.analytics.index', ['range' => $rangeOption]) }}" class="rounded-lg border px-3 py-1.5 text-xs font-semibold {{ $rangeDays === $rangeOption ? 'border-indigo-300 bg-indigo-50 text-indigo-700' : 'border-zinc-200 text-zinc-600 hover:bg-zinc-50' }}">
            {{ $rangeOption }}D
          </a>
        @endforeach
        <a href="{{ route('admin.analytics.index', ['range' => $rangeDays, 'export' => 'csv']) }}" class="rounded-lg border border-zinc-900 bg-zinc-900 px-3 py-1.5 text-xs font-semibold text-white hover:bg-zinc-700">
          {{ __('Export CSV') }}
        </a>
      </div>
    </div>

    <div class="grid grid-cols-1 gap-5 md:grid-cols-2 xl:grid-cols-4">
      <div class="rounded-2xl border border-indigo-100/70 bg-gradient-to-br from-white to-indigo-50/60 p-6 shadow-[0_20px_45px_-28px_rgba(37,99,235,0.45)]">
        <div class="flex items-center justify-between">
          <p class="text-[11px] font-semibold uppercase tracking-[0.14em] text-zinc-500">{{ __('Total page views') }}</p>
          <span class="rounded-full bg-indigo-100 px-2 py-1 text-[10px] font-bold text-indigo-700">90D</span>
        </div>
        <p class="mt-4 text-4xl font-bold tracking-tight text-zinc-900">{{ number_format($summary['total_views']) }}</p>
      </div>
      <div class="rounded-2xl border border-zinc-200/80 bg-white p-6 shadow-[0_18px_40px_-30px_rgba(0,0,0,0.3)]">
        <p class="text-[11px] font-semibold uppercase tracking-[0.14em] text-zinc-500">{{ __('Unique sessions') }}</p>
        <p class="mt-4 text-4xl font-bold tracking-tight text-zinc-900">{{ number_format($summary['unique_sessions']) }}</p>
        <p class="mt-2 text-xs text-zinc-500">{{ __('Average views/session') }}: <span class="font-semibold text-zinc-700">{{ $summary['avg_views_per_session'] }}</span></p>
      </div>
      <div class="rounded-2xl border border-zinc-200/80 bg-white p-6 shadow-[0_18px_40px_-30px_rgba(0,0,0,0.3)]">
        <p class="text-[11px] font-semibold uppercase tracking-[0.14em] text-zinc-500">{{ __('Unique pages visited') }}</p>
        <p class="mt-4 text-4xl font-bold tracking-tight text-zinc-900">{{ number_format($summary['unique_pages']) }}</p>
        <p class="mt-2 text-xs text-zinc-500">{{ __('Bounce rate') }}: <span class="font-semibold text-zinc-700">{{ $summary['bounce_rate'] }}%</span></p>
      </div>
      <div class="rounded-2xl border border-zinc-200/80 bg-white p-6 shadow-[0_18px_40px_-30px_rgba(0,0,0,0.3)]">
        <p class="text-[11px] font-semibold uppercase tracking-[0.14em] text-zinc-500">{{ __('Top referrer') }}</p>
        @if (!empty($summary['top_referrer']))
          <p class="mt-4 truncate text-xl font-bold tracking-tight text-zinc-900">{{ $summary['top_referrer'] }}</p>
          <p class="mt-2 text-xs font-semibold text-zinc-500">{{ number_format($summary['top_referrer_views']) }} {{ __('views') }}</p>
        @else
          <p class="mt-4 text-sm text-zinc-500">{{ __('No referrer data yet.') }}</p>
        @endif
      </div>
    </div>

    <div class="grid grid-cols-1 gap-6 xl:grid-cols-3">
      <div class="xl:col-span-2 rounded-2xl border border-zinc-200/80 bg-white p-6 shadow-[0_24px_56px_-34px_rgba(15,23,42,0.35)]">
        <div class="mb-6 flex flex-wrap items-center justify-between gap-3">
          <div>
            <h2 class="text-lg font-bold tracking-tight text-zinc-900">{{ __('Traffic analytics') }}</h2>
            <p class="text-sm text-zinc-500">{{ __('Views and sessions trend for the last :days days', ['days' => $rangeDays]) }}</p>
          </div>
          <div class="flex items-center gap-4 text-xs font-semibold uppercase tracking-wide text-zinc-500">
            <span class="inline-flex items-center gap-2"><span class="h-2.5 w-2.5 rounded-full bg-indigo-600"></span>{{ __('Views') }}</span>
            <span class="inline-flex items-center gap-2"><span class="h-2.5 w-2.5 rounded-full bg-sky-500"></span>{{ __('Sessions') }}</span>
          </div>
        </div>

        @if (collect($dailyTrend)->sum('views') > 0)
          <div class="rounded-xl border border-zinc-100 bg-zinc-50/70 p-3">
            <svg viewBox="0 0 {{ $lineChart['width'] }} {{ $lineChart['height'] }}" class="h-[300px] w-full">
              <defs>
                <linearGradient id="viewsFill" x1="0" x2="0" y1="0" y2="1">
                  <stop offset="0%" stop-color="#4f46e5" stop-opacity="0.28"/>
                  <stop offset="100%" stop-color="#4f46e5" stop-opacity="0"/>
                </linearGradient>
              </defs>
              <path d="{{ $lineChart['view_area_path'] }}" fill="url(#viewsFill)"></path>
              <path d="{{ $lineChart['view_path'] }}" fill="none" stroke="#4f46e5" stroke-width="4" stroke-linecap="round"></path>
              <path d="{{ $lineChart['session_path'] }}" fill="none" stroke="#0ea5e9" stroke-width="3" stroke-linecap="round" stroke-dasharray="10 8"></path>
            </svg>
            <div class="mt-3 grid grid-cols-2 gap-2 text-[11px] font-semibold uppercase tracking-wide text-zinc-500 sm:grid-cols-4">
              @foreach ($lineChart['labels'] as $label)
                <span>{{ $label['label'] }}</span>
              @endforeach
            </div>
          </div>
        @else
          <p class="text-sm text-zinc-500">{{ __('No traffic captured yet for this period.') }}</p>
        @endif
      </div>

      <div class="rounded-2xl border border-zinc-200/80 bg-white p-6 shadow-[0_24px_56px_-34px_rgba(15,23,42,0.35)]">
        <h3 class="text-sm font-bold uppercase tracking-[0.15em] text-zinc-500">{{ __('Traffic distribution') }}</h3>
        <div class="mt-6 flex items-center gap-6">
          <div class="relative h-36 w-36">
            <svg viewBox="0 0 160 160" class="h-36 w-36 -rotate-90">
              <circle cx="80" cy="80" r="70" fill="none" stroke="#e4e4e7" stroke-width="16"></circle>
              <circle cx="80" cy="80" r="70" fill="none" stroke="#4f46e5" stroke-width="16" stroke-linecap="round" stroke-dasharray="{{ $dashA }} {{ $circumference }}"></circle>
              <circle cx="80" cy="80" r="70" fill="none" stroke="#0ea5e9" stroke-width="16" stroke-linecap="round" stroke-dasharray="{{ $dashB }} {{ $circumference }}" stroke-dashoffset="{{ $offsetB }}"></circle>
              <circle cx="80" cy="80" r="70" fill="none" stroke="#f59e0b" stroke-width="16" stroke-linecap="round" stroke-dasharray="{{ $dashC }} {{ $circumference }}" stroke-dashoffset="{{ $offsetC }}"></circle>
            </svg>
            <div class="absolute inset-[25%] rounded-full bg-white"></div>
            <div class="absolute inset-0 flex items-center justify-center text-sm font-bold text-zinc-700">100%</div>
          </div>
          <div class="space-y-3">
            @foreach ($deviceBreakdown as $row)
              <div class="flex items-center justify-between gap-4 text-sm">
                <span class="font-medium text-zinc-700">{{ $row['label'] }}</span>
                <span class="font-bold text-zinc-900">{{ $row['percentage'] }}%</span>
              </div>
            @endforeach
          </div>
        </div>
      </div>
    </div>

    <div class="grid grid-cols-1 gap-6 xl:grid-cols-2">
      <div class="rounded-2xl border border-zinc-200/80 bg-white p-6 shadow-[0_24px_56px_-34px_rgba(15,23,42,0.35)]">
        <h3 class="text-sm font-bold uppercase tracking-[0.15em] text-zinc-500">{{ __('Referrer performance') }}</h3>
        <div class="mt-6 space-y-4">
          @php $topRefViews = max(1, (int) ($topReferrers->max('views') ?? 0)); @endphp
          @forelse ($topReferrers as $row)
            <div>
              <div class="mb-1 flex items-center justify-between text-sm">
                <span class="truncate font-medium text-zinc-700">{{ $row->referrer_host }}</span>
                <span class="font-semibold text-zinc-900">{{ number_format((int) $row->views) }}</span>
              </div>
              <progress class="h-2 w-full overflow-hidden rounded-full [appearance:none] [&::-webkit-progress-bar]:bg-zinc-100 [&::-webkit-progress-value]:bg-gradient-to-r [&::-webkit-progress-value]:from-indigo-600 [&::-webkit-progress-value]:to-sky-500 [&::-moz-progress-bar]:bg-indigo-500" value="{{ (int) $row->views }}" max="{{ $topRefViews }}"></progress>
            </div>
          @empty
            <p class="text-sm text-zinc-500">{{ __('No referrer data yet.') }}</p>
          @endforelse
        </div>
      </div>

      <div class="rounded-2xl border border-zinc-200/80 bg-white p-6 shadow-[0_24px_56px_-34px_rgba(15,23,42,0.35)]">
        <h3 class="text-sm font-bold uppercase tracking-[0.15em] text-zinc-500">{{ __('Top car listings') }}</h3>
        <div class="mt-6 flex h-52 items-end gap-3">
          @php $maxListingViews = max(1, (int) ($topListings->max('views') ?? 0)); @endphp
          @forelse ($topListings->take(6) as $row)
            <div class="flex-1 text-center">
              @php
                $barHeight = max(16, (int) round(((int) $row->views / $maxListingViews) * 180));
                $barY = 180 - $barHeight;
              @endphp
              <svg viewBox="0 0 30 180" class="mx-auto h-[180px] w-full max-w-[30px]">
                <rect x="0" y="{{ $barY }}" width="30" height="{{ $barHeight }}" rx="6" fill="#4f46e5"></rect>
              </svg>
              <p class="mt-2 truncate text-[10px] font-semibold uppercase tracking-wide text-zinc-500">{{ \Illuminate\Support\Str::limit($row->vehicle_slug, 12, '') }}</p>
            </div>
          @empty
            <p class="text-sm text-zinc-500">{{ __('No listing traffic data yet.') }}</p>
          @endforelse
        </div>
      </div>
    </div>

    <div class="rounded-2xl border border-zinc-200/80 bg-white p-6 shadow-[0_24px_56px_-34px_rgba(15,23,42,0.35)]">
      <div class="mb-4 flex items-center justify-between">
        <h3 class="text-lg font-bold tracking-tight text-zinc-900">{{ __('Most visited pages') }}</h3>
        <span class="text-xs font-semibold uppercase tracking-[0.12em] text-zinc-500">{{ __('Live ranking') }}</span>
      </div>
      <div class="overflow-x-auto">
        <table class="w-full min-w-[720px] border-separate border-spacing-y-2">
          <thead>
            <tr class="text-left text-[11px] font-bold uppercase tracking-[0.14em] text-zinc-500">
              <th class="px-3 py-2">{{ __('Page path') }}</th>
              <th class="px-3 py-2">{{ __('Views') }}</th>
              <th class="px-3 py-2">{{ __('Sessions') }}</th>
              <th class="px-3 py-2">{{ __('Session depth') }}</th>
              <th class="px-3 py-2">{{ __('Performance') }}</th>
            </tr>
          </thead>
          <tbody>
            @php $maxPageViews = max(1, (int) ($topPages->max('views') ?? 0)); @endphp
            @forelse ($topPages as $row)
              @php
                $depth = (int) $row->sessions > 0 ? round(((int) $row->views / (int) $row->sessions), 2) : 0;
                $score = (int) round(((int) $row->views / $maxPageViews) * 100);
              @endphp
              <tr class="rounded-xl bg-zinc-50/80 text-sm text-zinc-700">
                <td class="rounded-l-xl px-3 py-3 font-medium text-zinc-900">{{ $row->path }}</td>
                <td class="px-3 py-3 font-semibold">{{ number_format((int) $row->views) }}</td>
                <td class="px-3 py-3">{{ number_format((int) $row->sessions) }}</td>
                <td class="px-3 py-3">{{ $depth }}</td>
                <td class="rounded-r-xl px-3 py-3">
                  <div class="flex items-center gap-2">
                    <progress class="h-2 w-24 overflow-hidden rounded-full [appearance:none] [&::-webkit-progress-bar]:bg-zinc-200 [&::-webkit-progress-value]:bg-gradient-to-r [&::-webkit-progress-value]:from-indigo-600 [&::-webkit-progress-value]:to-sky-500 [&::-moz-progress-bar]:bg-indigo-500" value="{{ $score }}" max="100"></progress>
                    <span class="text-xs font-bold">{{ $score }}%</span>
                  </div>
                </td>
              </tr>
            @empty
              <tr><td colspan="5" class="px-3 py-4 text-sm text-zinc-500">{{ __('No page traffic data yet.') }}</td></tr>
            @endforelse
          </tbody>
        </table>
      </div>
    </div>
  </div>
</x-app-layout>
