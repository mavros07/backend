<x-app-layout>
  <x-slot name="header">
    <div class="flex w-full items-center justify-between gap-4">
      <div>
        <div class="text-[11px] font-bold uppercase tracking-[0.18em] text-zinc-500">{{ __('Admin') }}</div>
        <div class="text-xl font-black tracking-tight text-[#0B1F3A]">{{ __('Analytics') }}</div>
      </div>
      <div class="hidden items-center gap-5 text-xs font-semibold uppercase tracking-wider text-zinc-500 lg:flex">
        <span>{{ __('Portfolio') }}</span>
        <span>{{ __('Valuation') }}</span>
        <span>{{ __('Trends') }}</span>
      </div>
      <div class="flex items-center gap-2">
        <button type="button" class="rounded-xl bg-zinc-100 px-4 py-2 text-sm font-semibold text-zinc-700">{{ __('Date Range') }}</button>
        <a :href="`{{ route('admin.analytics.index') }}?range=${range}&export=csv&start_date=${startDate}&end_date=${endDate}`" class="rounded-xl bg-[#0B1F3A] px-5 py-2 text-sm font-semibold text-white">{{ __('Export Data') }}</a>
      </div>
    </div>
  </x-slot>

  <div
    x-data="analyticsPage({
      endpoint: '{{ route('admin.analytics.data') }}',
      range: {{ $rangeDays }},
      startDate: '{{ $startDate }}',
      endDate: '{{ $endDate }}',
      initial: @js([
        'summary' => $summary,
        'lineChart' => $lineChart,
        'topPages' => $topPages,
        'topListings' => $topListings,
        'topReferrers' => $topReferrers,
        'deviceBreakdown' => $deviceBreakdown,
      ]),
    })"
    class="space-y-8"
  >
    <div class="rounded-2xl border border-zinc-200 bg-white p-5">
      <div class="flex flex-wrap items-end gap-3">
        <div class="flex items-center gap-2">
          <label class="text-xs font-bold uppercase tracking-wider text-zinc-500">{{ __('Start') }}</label>
          <input type="date" x-model="startDate" class="rounded-lg border-zinc-300 text-sm">
        </div>
        <div class="flex items-center gap-2">
          <label class="text-xs font-bold uppercase tracking-wider text-zinc-500">{{ __('End') }}</label>
          <input type="date" x-model="endDate" class="rounded-lg border-zinc-300 text-sm">
        </div>
        <div class="flex items-center gap-2">
          <template x-for="opt in [7,30,90]" :key="opt">
            <button type="button" @click="applyPreset(opt)" class="rounded-lg border px-3 py-1.5 text-xs font-semibold" :class="range===opt ? 'border-[#0B1F3A] bg-[#0B1F3A] text-white':'border-zinc-200 text-zinc-600'">
              <span x-text="opt + 'D'"></span>
            </button>
          </template>
        </div>
        <button type="button" @click="load()" class="rounded-lg bg-[#0B1F3A] px-4 py-2 text-sm font-semibold text-white">{{ __('Apply') }}</button>
      </div>
    </div>

    <div class="grid grid-cols-1 gap-6 md:grid-cols-2 xl:grid-cols-4">
      <div class="rounded-2xl bg-zinc-50 p-6">
        <div class="flex justify-between">
          <span class="text-[10px] font-bold uppercase tracking-widest text-zinc-500">{{ __('Total Page Views') }}</span>
          <span class="rounded-full bg-zinc-200 px-2 py-1 text-[10px] font-bold text-zinc-700" x-text="range + 'D'"></span>
        </div>
        <div class="mt-3 text-3xl font-medium tracking-tight text-[#0B1F3A]" x-text="num(state.summary.total_views)"></div>
      </div>
      <div class="rounded-2xl bg-zinc-50 p-6">
        <span class="text-[10px] font-bold uppercase tracking-widest text-zinc-500">{{ __('Unique Sessions') }}</span>
        <div class="mt-3 text-3xl font-medium tracking-tight text-[#0B1F3A]" x-text="num(state.summary.unique_sessions)"></div>
      </div>
      <div class="rounded-2xl bg-zinc-50 p-6">
        <span class="text-[10px] font-bold uppercase tracking-widest text-zinc-500">{{ __('Unique Pages Visited') }}</span>
        <div class="mt-3 text-3xl font-medium tracking-tight text-[#0B1F3A]" x-text="num(state.summary.unique_pages)"></div>
      </div>
      <div class="rounded-2xl bg-zinc-50 p-6">
        <span class="text-[10px] font-bold uppercase tracking-widest text-zinc-500">{{ __('Top Referrer') }}</span>
        <div class="mt-3 truncate text-lg font-medium tracking-tight text-[#0B1F3A]" x-text="state.summary.top_referrer || 'N/A'"></div>
      </div>
    </div>

    <div class="rounded-2xl bg-white p-8 shadow-[0px_24px_48px_-12px_rgba(11,31,58,0.08)]">
      <div class="mb-6 flex items-center justify-between">
        <div>
          <h3 class="text-lg font-bold tracking-tight text-[#0B1F3A]">{{ __('Traffic Analytics') }}</h3>
          <p class="text-sm text-zinc-500">{{ __('User engagement and volume over selected range') }}</p>
        </div>
      </div>
      <svg :viewBox="`0 0 ${state.lineChart.width} ${state.lineChart.height}`" class="h-[300px] w-full">
        <defs>
          <linearGradient id="viewsFillLive" x1="0" x2="0" y1="0" y2="1">
            <stop offset="0%" stop-color="#0b1f3a" stop-opacity="0.22"/>
            <stop offset="100%" stop-color="#0b1f3a" stop-opacity="0"/>
          </linearGradient>
        </defs>
        <path :d="state.lineChart.view_area_path" fill="url(#viewsFillLive)"></path>
        <path :d="state.lineChart.view_path" fill="none" stroke="#0b1f3a" stroke-width="3.5"></path>
        <path :d="state.lineChart.session_path" fill="none" stroke="#a87e59" stroke-width="2.5" stroke-dasharray="8 6"></path>
      </svg>
    </div>

    <div class="grid grid-cols-1 gap-6 lg:grid-cols-2">
      <div class="rounded-2xl bg-white p-8">
        <h3 class="mb-6 text-sm font-bold uppercase tracking-widest text-zinc-500">{{ __('Traffic Distribution') }}</h3>
        <template x-for="row in state.deviceBreakdown" :key="row.label">
          <div class="mb-3 flex items-center justify-between text-sm">
            <span x-text="row.label"></span>
            <span class="font-bold" x-text="row.percentage + '%'"></span>
          </div>
        </template>
      </div>
      <div class="rounded-2xl bg-white p-8">
        <h3 class="mb-6 text-sm font-bold uppercase tracking-widest text-zinc-500">{{ __('Referrer Performance') }}</h3>
        <template x-for="row in state.topReferrers" :key="row.referrer_host">
          <div class="mb-4">
            <div class="mb-1 flex justify-between text-sm"><span x-text="row.referrer_host"></span><span x-text="num(row.views)"></span></div>
            <div class="h-2 rounded-full bg-zinc-100">
              <div class="h-2 rounded-full bg-[#0B1F3A]" :style="`width:${refWidth(row.views)}%`"></div>
            </div>
          </div>
        </template>
      </div>
    </div>

    <div class="rounded-2xl bg-white p-6">
      <h3 class="mb-4 text-lg font-bold tracking-tight text-[#0B1F3A]">{{ __('Most Visited Pages') }}</h3>
      <div class="overflow-x-auto">
        <table class="w-full text-left">
          <thead>
            <tr class="border-b text-[10px] uppercase tracking-widest text-zinc-500">
              <th class="px-3 py-3">{{ __('Page Title') }}</th>
              <th class="px-3 py-3">{{ __('Views') }}</th>
              <th class="px-3 py-3">{{ __('Sessions') }}</th>
              <th class="px-3 py-3">{{ __('Bounce proxy') }}</th>
            </tr>
          </thead>
          <tbody>
            <template x-for="row in state.topPages" :key="row.path">
              <tr class="border-b border-zinc-100">
                <td class="px-3 py-3 text-sm font-medium" x-text="row.label || row.path"></td>
                <td class="px-3 py-3 text-sm" x-text="num(row.views)"></td>
                <td class="px-3 py-3 text-sm" x-text="num(row.sessions)"></td>
                <td class="px-3 py-3 text-sm" x-text="bounceProxy(row) + '%'"></td>
              </tr>
            </template>
          </tbody>
        </table>
      </div>
    </div>

    <div class="grid grid-cols-1 gap-6 lg:grid-cols-2">
      <div class="rounded-2xl bg-white p-8">
        <h3 class="mb-8 text-sm font-bold uppercase tracking-widest text-zinc-500">{{ __('Top Car Listings') }}</h3>
        <div class="flex h-52 items-end justify-between gap-3 px-2">
          <template x-for="row in topListingsShort()" :key="row.vehicle_slug">
            <div class="flex-1 text-center">
              <div class="w-full rounded-t-lg bg-[#0B1F3A]/20" :style="`height:${listingBarHeight(row.views)}px`"></div>
              <span class="mt-2 block truncate text-[10px] font-bold uppercase tracking-wide text-zinc-500" x-text="listingShortCode(row.vehicle_slug)"></span>
            </div>
          </template>
        </div>
      </div>

      <div class="rounded-2xl bg-white p-8">
        <h3 class="mb-6 text-sm font-bold uppercase tracking-widest text-zinc-500">{{ __('User Engagement Ratio') }}</h3>
        <div class="flex items-center justify-center">
          <div class="relative h-44 w-44">
            <svg class="h-44 w-44 -rotate-90" viewBox="0 0 176 176">
              <circle cx="88" cy="88" r="72" fill="none" stroke="#e5e7eb" stroke-width="10"></circle>
              <circle cx="88" cy="88" r="72" fill="none" stroke="#a87e59" stroke-width="10" stroke-linecap="round" :stroke-dasharray="`${engagementRatio() * 4.52} 452`"></circle>
            </svg>
            <div class="absolute inset-0 flex flex-col items-center justify-center">
              <div class="text-4xl font-black tracking-tight text-[#0B1F3A]" x-text="engagementRatio().toFixed(1) + '%'"></div>
              <div class="text-[10px] font-bold uppercase tracking-widest text-zinc-500">{{ __('Efficiency') }}</div>
            </div>
          </div>
        </div>
      </div>
    </div>

    <div class="rounded-2xl bg-white p-8">
      <div class="mb-8 flex items-center justify-between">
        <h3 class="text-lg font-bold tracking-tight text-[#0B1F3A]">{{ __('Daily Activity: Views vs Sessions') }}</h3>
      </div>
      <div class="flex h-64 items-end gap-3">
        <template x-for="day in weeklyBars()" :key="day.label">
          <div class="flex flex-1 flex-col justify-end gap-1">
            <div class="w-full rounded-sm bg-[#a87e59]/30" :style="`height:${day.sessions}px`"></div>
            <div class="w-full rounded-sm bg-[#0B1F3A]" :style="`height:${day.views}px`"></div>
            <span class="mt-2 text-center text-[10px] font-bold uppercase tracking-widest text-zinc-500" x-text="day.label"></span>
          </div>
        </template>
      </div>
    </div>
  </div>

  <script>
    function analyticsPage(config) {
      return {
        endpoint: config.endpoint,
        range: config.range,
        startDate: config.startDate,
        endDate: config.endDate,
        state: config.initial,
        async load() {
          const qs = new URLSearchParams({
            range: this.range,
            start_date: this.startDate,
            end_date: this.endDate,
          });
          const res = await fetch(`${this.endpoint}?${qs.toString()}`, { headers: { 'X-Requested-With': 'XMLHttpRequest' } });
          if (!res.ok) return;
          this.state = await res.json();
        },
        applyPreset(days) {
          this.range = days;
          const end = new Date();
          const start = new Date();
          start.setDate(end.getDate() - (days - 1));
          this.startDate = start.toISOString().slice(0, 10);
          this.endDate = end.toISOString().slice(0, 10);
          this.load();
        },
        num(v) {
          return new Intl.NumberFormat().format(v || 0);
        },
        refWidth(v) {
          const max = Math.max(...(this.state.topReferrers || []).map(r => Number(r.views || 0)), 1);
          return Math.max(4, Math.round((Number(v || 0) / max) * 100));
        },
        bounceProxy(row) {
          const views = Number(row.views || 0);
          const sessions = Number(row.sessions || 0);
          if (!sessions) return 0;
          const depth = views / sessions;
          return Math.max(0, Math.min(100, Math.round((1 / depth) * 100)));
        },
        topListingsShort() {
          return (this.state.topListings || []).slice(0, 5);
        },
        listingBarHeight(views) {
          const rows = this.topListingsShort();
          const max = Math.max(...rows.map(r => Number(r.views || 0)), 1);
          return Math.max(36, Math.round((Number(views || 0) / max) * 180));
        },
        listingShortCode(slug) {
          const parts = String(slug || '').split('-').filter(Boolean);
          return parts.slice(-1)[0] || 'N/A';
        },
        engagementRatio() {
          const bounce = Number(this.state.summary?.bounce_rate || 0);
          return Math.max(0, Math.min(100, 100 - bounce));
        },
        weeklyBars() {
          const points = (this.state.dailyTrend || []).slice(-7);
          const maxViews = Math.max(...points.map(p => Number(p.views || 0)), 1);
          const maxSessions = Math.max(...points.map(p => Number(p.sessions || 0)), 1);
          return points.map(p => ({
            label: (p.label || '').slice(0, 3).toUpperCase(),
            views: Math.max(20, Math.round((Number(p.views || 0) / maxViews) * 160)),
            sessions: Math.max(12, Math.round((Number(p.sessions || 0) / maxSessions) * 80)),
          }));
        },
      }
    }
  </script>
</x-app-layout>
