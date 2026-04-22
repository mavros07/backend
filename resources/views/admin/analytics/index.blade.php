@push('head')
  <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@24,400,0,0" />
  <style>
    .material-symbols-outlined { font-variation-settings: 'FILL' 0, 'wght' 400, 'GRAD' 0, 'opsz' 24; }
    .anx-glass-card { background: rgba(255, 255, 255, 0.72); backdrop-filter: blur(20px); }
  </style>
@endpush

<x-app-layout>
  <x-slot name="header">
    <h1 class="truncate text-lg font-bold tracking-tight text-zinc-900">{{ __('Analytics') }}</h1>
  </x-slot>

  {{-- Matches sample main canvas: max-w-7xl, surface bg, section cards with border + shadow-sm --}}
  <div
    class="anx-canvas text-on-surface relative mx-auto w-full max-w-7xl bg-surface px-4 pb-12 antialiased md:px-10"
    style="font-family: Inter, system-ui, sans-serif"
    x-data="analyticsPage({
      trafficSubTemplate: @js(__('User engagement and volume over the last :count days', ['count' => '__N__'])),
      endpoint: '{{ route('admin.analytics.data') }}',
      range: {{ $rangeDays }},
      startDate: '{{ $startDate }}',
      endDate: '{{ $endDate }}',
      initial: @js([
        'rangeDays' => $rangeDays,
        'summary' => $summary,
        'kpiDeltas' => $kpiDeltas,
        'dailyTrend' => $dailyTrend,
        'trendBars' => $trendBars,
        'trendXLabels' => $trendXLabels,
        'topPages' => $topPages,
        'topListings' => $topListings,
        'topReferrers' => $topReferrers,
        'deviceBreakdown' => $deviceBreakdown,
      ]),
    })"
  >
    {{-- Dashboard header (sample): title row + date range cluster + export --}}
    <div class="mb-10 flex flex-col items-start justify-between gap-6 md:flex-row md:items-center">
      <div>
        <h2 class="text-3xl font-black tracking-tight text-[#0B1F3A]">{{ __('Analytics overview') }}</h2>
        <p class="mt-1 text-on-surface-variant">{{ __('Global luxury automotive market performance') }}</p>
      </div>
      <div class="flex w-full flex-col gap-3 sm:w-auto sm:flex-row sm:items-center sm:gap-4">
        <div class="anx-glass-card flex flex-wrap items-center gap-2 rounded-xl border border-surface-container px-3 py-2 shadow-sm ring-1 ring-black/[0.03] sm:gap-3 sm:px-4">
          <span class="material-symbols-outlined text-on-surface text-base">filter_list</span>
          <span class="text-on-surface font-semibold text-sm">{{ __('Date range') }}</span>
          <input type="date" x-model="startDate" class="border-outline-variant/80 text-on-surface max-w-[11rem] rounded-lg border bg-white px-2 py-1 text-xs sm:text-sm">
          <span class="text-on-surface-variant text-xs">{{ __('to') }}</span>
          <input type="date" x-model="endDate" class="border-outline-variant/80 text-on-surface max-w-[11rem] rounded-lg border bg-white px-2 py-1 text-xs sm:text-sm">
          <div class="flex flex-wrap gap-1">
            <template x-for="opt in [7,30,90]" :key="opt">
              <button
                type="button"
                @click="applyPreset(opt)"
                class="rounded-lg border px-2 py-1 text-[11px] font-bold tracking-wide sm:px-3 sm:text-xs"
                :class="range === opt ? 'border-primary-container bg-primary-container text-white' : 'border-surface-container-low bg-surface-container-lowest text-on-surface-variant'"
              >
                <span x-text="opt + 'd'"></span>
              </button>
            </template>
          </div>
          <button type="button" @click="load()" class="bg-primary-container hover:opacity-90 rounded-lg px-3 py-1.5 text-xs font-semibold text-white transition-opacity sm:text-sm">{{ __('Apply') }}</button>
        </div>
        <a
          :href="`{{ route('admin.analytics.index') }}?range=${range}&export=csv&start_date=${startDate}&end_date=${endDate}`"
          class="bg-primary-container hover:opacity-90 inline-flex items-center justify-center gap-2 rounded-xl px-6 py-2 text-sm font-semibold text-white transition-opacity"
        >
          <span class="material-symbols-outlined text-base">download</span>
          <span>{{ __('Export data') }}</span>
        </a>
      </div>
    </div>

    {{-- Section 1: KPI cards (sample: shadow-sm border border-surface-container) --}}
    <div class="mb-10 grid grid-cols-1 gap-6 md:grid-cols-2 lg:grid-cols-4">
      <div class="rounded-2xl border border-surface-container bg-surface-container-lowest p-6 shadow-sm">
        <div class="mb-4 flex items-start justify-between">
          <span class="text-on-surface-variant text-[10px] font-bold uppercase tracking-widest">{{ __('Total page views') }}</span>
          <span class="rounded-full px-2 py-1 text-[10px] font-bold" :class="kpiPillClass(state.kpiDeltas?.views)" x-text="formatKpiDelta(state.kpiDeltas?.views)"></span>
        </div>
        <div class="text-m3-ink text-3xl font-medium tracking-tight" x-text="num(state.summary.total_views)"></div>
        <div class="mt-2 h-1 w-full overflow-hidden rounded-full bg-surface-container-low">
          <div class="h-full bg-primary-container transition-all" :style="`width:${kpiBarWidth(1)}%`"></div>
        </div>
      </div>
      <div class="rounded-2xl border border-surface-container bg-surface-container-lowest p-6 shadow-sm">
        <div class="mb-4 flex items-start justify-between">
          <span class="text-on-surface-variant text-[10px] font-bold uppercase tracking-widest">{{ __('Unique sessions') }}</span>
          <span class="rounded-full px-2 py-1 text-[10px] font-bold" :class="kpiPillClass(state.kpiDeltas?.sessions)" x-text="formatKpiDelta(state.kpiDeltas?.sessions)"></span>
        </div>
        <div class="text-m3-ink text-3xl font-medium tracking-tight" x-text="num(state.summary.unique_sessions)"></div>
        <div class="mt-2 h-1 w-full overflow-hidden rounded-full bg-surface-container-low">
          <div class="bg-on-tertiary-container h-full transition-all" :style="`width:${kpiBarWidth(2)}%`"></div>
        </div>
      </div>
      <div class="rounded-2xl border border-surface-container bg-surface-container-lowest p-6 shadow-sm">
        <div class="mb-4 flex items-start justify-between">
          <span class="text-on-surface-variant text-[10px] font-bold uppercase tracking-widest">{{ __('Unique pages visited') }}</span>
          <span class="rounded-full px-2 py-1 text-[10px] font-bold" :class="kpiPillClass(state.kpiDeltas?.pages)" x-text="formatKpiDelta(state.kpiDeltas?.pages)"></span>
        </div>
        <div class="text-m3-ink text-3xl font-medium tracking-tight" x-text="num(state.summary.unique_pages)"></div>
        <div class="mt-2 h-1 w-full overflow-hidden rounded-full bg-surface-container-low">
          <div class="h-full bg-error transition-all" :style="`width:${kpiBarWidth(3)}%`"></div>
        </div>
      </div>
      <div class="rounded-2xl border border-surface-container bg-surface-container-lowest p-6 shadow-sm">
        <div class="mb-4 flex items-start justify-between">
          <span class="text-on-surface-variant text-[10px] font-bold uppercase tracking-widest">{{ __('Top listing') }}</span>
          <span class="text-on-tertiary-container rounded-full bg-on-tertiary-container/10 px-2 py-1 text-[10px] font-bold">{{ __('Hot') }}</span>
        </div>
        <div class="text-m3-ink truncate text-xl font-medium tracking-tight" x-text="topListingTitle()"></div>
        <p class="text-on-surface-variant mt-1 text-[10px]">
          <span x-show="!topListingViews()">—</span>
          <span x-show="topListingViews() && Number(range) === 1"><span x-text="num(topListingViews())"></span> {{ __('views today') }}</span>
          <span x-show="topListingViews() && Number(range) !== 1"><span x-text="num(topListingViews())"></span> {{ __('views in this range') }}</span>
        </p>
      </div>
    </div>

    {{-- Section 2: Traffic trend (sample: hero shadow card, responsive title row) --}}
    <div class="mb-10">
      <div class="rounded-2xl bg-surface-container-lowest p-8 shadow-[0px_24px_48px_-12px_rgba(11,31,58,0.08)]">
        <div class="mb-10 flex flex-col items-start justify-between gap-4 md:flex-row md:items-center">
          <div>
            <h3 class="text-lg font-bold tracking-tight text-m3-ink">{{ __('Traffic analytics') }}</h3>
            <p class="text-sm text-on-surface-variant" x-text="subTraffic()"></p>
          </div>
          <div class="flex flex-wrap gap-4">
            <div class="flex items-center gap-2">
              <span class="h-3 w-3 rounded-full bg-primary-container"></span>
              <span class="text-xs font-semibold uppercase tracking-wider text-on-surface-variant">{{ __('Views') }}</span>
            </div>
            <div class="flex items-center gap-2">
              <span class="h-3 w-3 rounded-full bg-on-tertiary-container"></span>
              <span class="text-xs font-semibold uppercase tracking-wider text-on-surface-variant">{{ __('Sessions') }}</span>
            </div>
          </div>
        </div>
        <div class="relative flex h-[300px] w-full items-end gap-2">
          <svg class="absolute inset-0 h-full w-full opacity-20" viewBox="0 0 100 100" preserveAspectRatio="none" aria-hidden="true">
            <path class="text-primary-container" d="M0 80 Q 25 20, 50 50 T 100 10" fill="none" stroke="currentColor" stroke-width="2"></path>
          </svg>
          <template x-for="(bar, bi) in trendBarsList()" :key="bi">
            <div
              class="relative z-10 min-h-[8%] flex-1 rounded-t-lg transition-all hover:brightness-[0.97]"
              :class="bar.highlight ? 'bg-primary-container' : 'bg-surface-container-low'"
              :style="'height:' + (bar.h || 20) + '%'"
            ></div>
          </template>
        </div>
        <div class="mt-4 flex justify-between overflow-x-auto text-[10px] font-bold uppercase tracking-widest text-outline">
          <template x-for="(lab, i) in (state.trendXLabels || sevenTickLabels())" :key="i">
            <span x-text="lab" class="min-w-0 shrink-0 px-0.5 text-center first:text-left last:text-right"></span>
          </template>
        </div>
      </div>
    </div>

    {{-- Sections 3 & 4 --}}
    <div class="mb-10 grid grid-cols-1 gap-6 lg:grid-cols-2">
      <div class="rounded-2xl border border-surface-container bg-surface-container-lowest p-8 shadow-sm">
        <h3 class="mb-8 text-sm font-bold uppercase tracking-widest text-on-surface-variant">{{ __('Traffic distribution') }}</h3>
        <div class="flex flex-col items-center gap-10 sm:flex-row">
          <div class="relative h-40 w-40 shrink-0">
            <div class="h-full w-full rounded-full" :style="donutStyle()"></div>
            <div class="pointer-events-none absolute inset-0 flex flex-col items-center justify-center">
              <span class="text-2xl font-bold text-m3-ink" x-text="deviceTotalPct() + '%'"></span>
              <span class="text-on-surface-variant text-[8px] font-bold uppercase tracking-widest">{{ __('Global') }}</span>
            </div>
          </div>
          <div class="flex-1 space-y-4">
            <template x-for="(row, di) in (state.deviceBreakdown || [])" :key="row.label">
              <div class="flex items-center justify-between">
                <div class="flex min-w-0 items-center gap-3">
                  <span class="h-2 w-2 shrink-0 rounded-full" :class="deviceDotClass(di)"></span>
                  <span class="text-on-surface text-sm font-medium" x-text="row.label"></span>
                </div>
                <span class="text-m3-ink text-sm font-bold" x-text="(row.percentage || 0) + '%'"></span>
              </div>
            </template>
          </div>
        </div>
      </div>

      <div class="rounded-2xl border border-surface-container bg-surface-container-lowest p-8 shadow-sm">
        <h3 class="mb-8 text-sm font-bold uppercase tracking-widest text-on-surface-variant">{{ __('Referrer performance') }}</h3>
        <div class="space-y-6" x-show="state.topReferrers && state.topReferrers.length" x-cloak>
          <template x-for="(row, ri) in state.topReferrers" :key="row.referrer_host || ri">
            <div class="space-y-2">
              <div class="text-on-surface flex justify-between text-sm font-medium">
                <span class="min-w-0 truncate" x-text="row.referrer_host"></span>
                <span x-text="num(row.views)"></span>
              </div>
              <div class="bg-surface-container-low h-2 w-full rounded-full">
                <div class="h-full rounded-full" :class="referrerBarClass(ri)" :style="`width: ${refWidth(row.views)}%`"></div>
              </div>
            </div>
          </template>
        </div>
        <div class="space-y-6" x-show="!state.topReferrers || !state.topReferrers.length" x-cloak>
          <div class="space-y-2">
            <div class="text-on-surface flex justify-between text-sm font-medium"><span>Google Search</span><span>42,100</span></div>
            <div class="bg-surface-container-low h-2 w-full rounded-full">
              <div class="bg-primary-container h-full w-[85%] rounded-full"></div>
            </div>
          </div>
          <div class="space-y-2">
            <div class="text-on-surface flex justify-between text-sm font-medium"><span>Direct Link</span><span>12,400</span></div>
            <div class="bg-surface-container-low h-2 w-full rounded-full">
              <div class="bg-on-tertiary-container h-full w-[40%] rounded-full"></div>
            </div>
          </div>
          <div class="space-y-2">
            <div class="text-on-surface flex justify-between text-sm font-medium"><span>Instagram Ads</span><span>8,900</span></div>
            <div class="bg-surface-container-low h-2 w-full rounded-full">
              <div class="bg-primary-container/40 h-full w-[25%] rounded-full"></div>
            </div>
          </div>
        </div>
      </div>
    </div>

    {{-- Section 5: table --}}
    <div class="mb-10 overflow-hidden rounded-2xl border border-surface-container bg-surface-container-lowest shadow-sm">
      <div class="flex items-end justify-between p-8 pb-0">
        <div>
          <h3 class="text-lg font-bold tracking-tight text-m3-ink">{{ __('Most visited pages') }}</h3>
          <p class="text-sm text-on-surface-variant">{{ __('Listing performance and viewer conversion') }}</p>
        </div>
        <a href="{{ route('admin.analytics.index') }}" class="text-primary-container flex items-center gap-1 self-start text-xs font-bold uppercase tracking-widest hover:opacity-90 sm:self-auto">
          {{ __('Full view') }} <span class="material-symbols-outlined text-sm">arrow_forward</span>
        </a>
      </div>
      <div class="p-4">
        <div class="overflow-x-auto">
          <table class="w-full min-w-[600px] border-collapse text-left">
            <thead>
              <tr class="border-b border-surface-container-low text-[10px] font-bold uppercase tracking-widest text-on-surface-variant">
                <th class="px-6 py-4">{{ __('Page title') }}</th>
                <th class="px-6 py-4">{{ __('Views') }}</th>
                <th class="px-6 py-4">{{ __('Avg. time') }}</th>
                <th class="px-6 py-4">{{ __('Bounce rate') }}</th>
                <th class="px-6 py-4">{{ __('Performance') }}</th>
              </tr>
            </thead>
            <tbody class="divide-y divide-surface-container-low/30">
              <template x-for="row in (state.topPages || [])" :key="row.path">
                <tr class="transition-colors hover:bg-surface-container-low/50">
                  <td class="px-6 py-5 text-sm font-medium text-on-surface" x-text="pathTitle(row)"></td>
                  <td class="px-6 py-5 text-sm text-on-surface" x-text="num(row.views)"></td>
                  <td class="px-6 py-5 text-sm text-on-surface-variant">—</td>
                  <td class="px-6 py-5 text-sm text-on-surface" x-text="bounceProxy(row) + '%'"></td>
                  <td class="px-6 py-5">
                    <div class="flex min-w-[10rem] items-center gap-2 sm:min-w-0">
                      <div class="bg-surface-container-low h-1.5 w-24 overflow-hidden rounded-full">
                        <div class="h-full rounded-full" :class="perfBarClass(performanceScore(row))" :style="`width: ${performanceScore(row)}%`"></div>
                      </div>
                      <span class="w-8 shrink-0 text-xs font-bold" :class="perfTextClass(performanceScore(row))" x-text="performanceScore(row) + '%'"></span>
                    </div>
                  </td>
                </tr>
              </template>
            </tbody>
          </table>
        </div>
        <p class="text-on-surface-variant px-2 py-3 text-center text-sm" x-show="!(state.topPages && state.topPages.length)">{{ __('No page data in this range yet') }}</p>
      </div>
    </div>

    {{-- Sections 6 & 7 --}}
    <div class="mb-10 grid grid-cols-1 gap-6 lg:grid-cols-2">
      <div class="rounded-2xl border border-surface-container bg-surface-container-lowest p-8 shadow-sm">
        <h3 class="mb-10 text-sm font-bold uppercase tracking-widest text-on-surface-variant">{{ __('Top car listings') }}</h3>
        <div class="flex h-48 items-end justify-between gap-4 px-4">
          <template x-for="(row, li) in listingSlots()" :key="li">
            <div class="flex min-w-0 flex-1 flex-col items-center gap-3">
              <div
                class="w-full rounded-t-lg"
                :class="row.vehicle_slug && isTopListingMax(row) ? 'bg-primary-container' : 'bg-primary-container/20'"
                :style="`height: ${row.h}%;`"
              ></div>
              <span
                class="text-[10px] font-bold"
                :class="row.vehicle_slug && isTopListingMax(row) ? 'text-m3-ink' : 'text-outline'"
                x-text="row.label"
              ></span>
            </div>
          </template>
        </div>
      </div>

      <div class="flex flex-col items-center rounded-2xl border border-surface-container bg-surface-container-lowest p-8 text-center shadow-sm">
        <h3 class="mb-6 w-full text-left text-sm font-bold uppercase tracking-widest text-on-surface-variant">{{ __('User engagement ratio') }}</h3>
        <div class="relative flex h-48 w-48 shrink-0 items-center justify-center">
          <svg class="absolute inset-0 h-full w-full -rotate-90" viewBox="0 0 192 192">
            <circle
              class="text-surface-container-low"
              cx="96"
              cy="96"
              r="80"
              fill="transparent"
              stroke="currentColor"
              stroke-dasharray="502"
              stroke-dashoffset="125"
              stroke-linecap="round"
              stroke-width="8"
            />
            <circle
              class="text-on-tertiary-container"
              cx="96"
              cy="96"
              r="80"
              fill="transparent"
              stroke="currentColor"
              :stroke-dasharray="502"
              :stroke-dashoffset="engagementGaugeOffset()"
              stroke-linecap="round"
              stroke-width="8"
            />
          </svg>
          <div class="z-10">
            <div class="text-4xl font-black tracking-tighter text-m3-ink" x-text="engagementRatio().toFixed(1) + '%'"></div>
            <div class="text-[10px] font-bold uppercase tracking-widest text-outline">{{ __('Efficiency') }}</div>
          </div>
        </div>
        <p class="text-on-surface-variant mt-4 max-w-xs text-xs leading-relaxed">
          {{ __('Your platform engagement is') }} <span class="text-on-tertiary-container font-bold">12% {{ __('higher') }}</span> {{ __('than the luxury industry average this quarter.') }}
        </p>
      </div>
    </div>

    {{-- Section 8 --}}
    <div class="mb-10 rounded-2xl border border-surface-container bg-surface-container-lowest p-8 shadow-sm">
      <div class="mb-10 flex flex-col items-start justify-between gap-4 md:flex-row md:items-center">
        <h3 class="text-lg font-bold tracking-tight text-m3-ink">{{ __('Daily activity: views vs sessions') }}</h3>
        <div class="flex gap-4">
          <div class="flex items-center gap-2">
            <div class="h-3 w-3 rounded-sm bg-primary-container"></div>
            <span class="text-xs font-medium text-on-surface-variant">{{ __('Views') }}</span>
          </div>
          <div class="flex items-center gap-2">
            <div class="h-3 w-3 rounded-sm bg-on-tertiary-container/30"></div>
            <span class="text-xs font-medium text-on-surface-variant">{{ __('Sessions') }}</span>
          </div>
        </div>
      </div>
      <div class="flex h-64 items-end gap-3 px-2">
        <template x-for="(day, wi) in weeklyBars()" :key="wi">
          <div class="flex h-full min-w-0 flex-1 flex-col justify-end gap-1">
            <div class="w-full rounded-sm bg-on-tertiary-container/30" :style="`height: ${day.sH}%`"></div>
            <div class="bg-primary-container w-full rounded-sm" :style="`height: ${day.vH}%`"></div>
            <span class="text-outline mt-4 text-center text-[9px] font-bold uppercase" x-text="day.label"></span>
          </div>
        </template>
      </div>
    </div>
  </div>

  <script>
    function analyticsPage(config) {
      return {
        trafficSubTemplate: config.trafficSubTemplate,
        endpoint: config.endpoint,
        range: config.range,
        startDate: config.startDate,
        endDate: config.endDate,
        state: config.initial,
        subTraffic() {
          const n = this.state?.rangeDays != null ? this.state.rangeDays : this.range;
          return (this.trafficSubTemplate || '').replace('__N__', String(n));
        },
        sevenTickLabels() {
          const t = (this.state.trendXLabels || []).length ? this.state.trendXLabels : ['—', '—', '—', '—', '—', '—', '—'];
          return t.slice(0, 7);
        },
        trendBarsList() {
          const b = this.state?.trendBars;
          if (b && b.length) {
            return b;
          }
          const demo = [60, 45, 80, 65, 50, 95, 75, 60, 40, 85, 70, 55];
          return demo.map((h, i) => ({ h, highlight: i === 5 }));
        },
        formatKpiDelta(v) {
          if (v === null || v === undefined) {
            return '—';
          }
          if (v === 0) {
            return '0%';
          }
          return (v > 0 ? '+' : '') + v.toFixed(1) + '%';
        },
        kpiPillClass(v) {
          if (v === null || v === undefined) {
            return 'text-on-surface-variant bg-surface-container-low';
          }
          if (v < 0) {
            return 'bg-error/10 text-error';
          }
          if (v > 0) {
            return 'text-on-tertiary-container bg-on-tertiary-container/10';
          }
          return 'text-on-surface-variant bg-surface-container-low';
        },
        kpiBarWidth(slot) {
          const s = this.state?.summary || {};
          const d = Math.max(1, Number(this.range) || 90);
          const v = Number(s.total_views || 0);
          const u = Number(s.unique_sessions || 0);
          const p = Number(s.unique_pages || 0);
          if (slot === 1) {
            return Math.min(100, Math.round((v / d / 5) * 100)) || 4;
          }
          if (slot === 2) {
            return Math.min(100, Math.round((u / d / 2) * 100)) || 4;
          }
          if (slot === 3) {
            return Math.min(100, Math.round(p * 4)) || 4;
          }
          return 0;
        },
        topListingTitle() {
          const row = (this.state.topListings && this.state.topListings[0]) || null;
          if (!row) {
            return '—';
          }
          const slug = String(row.vehicle_slug || '');
          if (!slug) {
            return '—';
          }
          return slug
            .split('-')
            .filter(Boolean)
            .map((w) => w.charAt(0).toUpperCase() + w.slice(1))
            .join(' ');
        },
        topListingViews() {
          const row = (this.state.topListings && this.state.topListings[0]) || null;
          return row ? row.views : 0;
        },
        engagementGaugeOffset() {
          return 502 * (1 - this.engagementRatio() / 100);
        },
        deviceTotalPct() {
          const rows = this.state.deviceBreakdown || [];
          const t = rows.reduce((a, b) => a + Number(b.percentage || 0), 0);
          if (t < 0.5) {
            return 100;
          }
          return Math.min(100, Math.round(t));
        },
        deviceDotClass(i) {
          return ['bg-primary-container', 'bg-on-tertiary-container', 'bg-surface-container-high'][i % 3];
        },
        referrerBarClass(i) {
          return ['bg-primary-container', 'bg-on-tertiary-container', 'bg-primary-container/40'][i % 3];
        },
        donutStyle() {
          const rows = this.state.deviceBreakdown || [];
          const d = Number(rows.find((r) => r.label === 'Desktop')?.percentage || 0);
          const m = Number(rows.find((r) => r.label === 'Mobile')?.percentage || 0);
          const t = Number(rows.find((r) => r.label === 'Tablet')?.percentage || 0);
          if (d + m + t < 0.5) {
            return { background: 'conic-gradient(#e6e8eb 0% 100%)' };
          }
          const a1 = d;
          const a2 = d + m;
          return { background: `conic-gradient(#0B1F3A 0% ${a1}%, #a87e59 ${a1}% ${a2}%, #e6e8eb ${a2}% 100%)` };
        },
        pathTitle(row) {
          const p = String(row.path || '/');
          const label = row.label;
          if (p === '/' && label) {
            return label;
          }
          return p.startsWith('/') ? p : '/' + p;
        },
        performanceScore(row) {
          const v = Number(row.views || 0);
          const s = Number(row.sessions || 0);
          if (!s || !v) {
            return 0;
          }
          return Math.max(0, Math.min(100, Math.round((s / v) * 100)));
        },
        perfBarClass(n) {
          if (n >= 90) {
            return 'bg-on-tertiary-container';
          }
          if (n >= 50) {
            return 'bg-primary-container';
          }
          return 'bg-primary-container/70';
        },
        perfTextClass(n) {
          if (n >= 90) {
            return 'text-on-tertiary-container';
          }
          if (n >= 50) {
            return 'text-m3-ink';
          }
          return 'text-on-tertiary-container';
        },
        isTopListingMax(row) {
          const rows = (this.state.topListings || []).filter((r) => r.vehicle_slug);
          if (!rows.length) {
            return false;
          }
          const maxV = Math.max(...rows.map((r) => Number(r.views || 0)));
          return Number(row.views || 0) === maxV;
        },
        listingSlots() {
          const top = (this.state.topListings || []).slice(0, 5);
          const labels = ['911', 'F40', 'DB5', 'E-Type', 'GTR'];
          const hDemo = [60, 85, 100, 45, 70];
          const out = [];
          for (let i = 0; i < 5; i += 1) {
            if (top[i]) {
              const max = Math.max(1, ...top.map((r) => Number(r.views || 0)));
              out.push({
                vehicle_slug: top[i].vehicle_slug,
                h: Math.max(8, Math.round((Number(top[i].views || 0) / max) * 100)),
                label: this.listingShortCode(top[i].vehicle_slug),
              });
            } else {
              out.push({ vehicle_slug: null, h: hDemo[i], label: labels[i] });
            }
          }
          return out;
        },
        listingShortCode(slug) {
          const parts = String(slug || '').split('-').filter(Boolean);
          return (parts.length ? (parts.length >= 2 ? parts[parts.length - 1] : parts[0]) : '—').toUpperCase();
        },
        async load() {
          const qs = new URLSearchParams({ range: this.range, start_date: this.startDate, end_date: this.endDate });
          const res = await fetch(`${this.endpoint}?${qs.toString()}`, { headers: { 'X-Requested-With': 'XMLHttpRequest' } });
          if (!res.ok) {
            return;
          }
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
          const list = this.state.topReferrers || [];
          const max = Math.max(1, ...list.map((r) => Number(r.views || 0)));
          return Math.max(4, Math.round((Number(v || 0) / max) * 100));
        },
        bounceProxy(row) {
          const views = Number(row.views || 0);
          const sessions = Number(row.sessions || 0);
          if (!sessions) {
            return 0;
          }
          const depth = views / sessions;
          return Math.max(0, Math.min(100, Math.round((1 / depth) * 100)));
        },
        engagementRatio() {
          const bounce = Number(this.state.summary?.bounce_rate || 0);
          return Math.max(0, Math.min(100, 100 - bounce));
        },
        weeklyBars() {
          const points = (this.state.dailyTrend || []).slice(-7);
          if (points.length === 0) {
            return [
              { label: 'MON', sH: 20, vH: 40 },
              { label: 'TUE', sH: 15, vH: 55 },
              { label: 'WED', sH: 25, vH: 60 },
              { label: 'THU', sH: 10, vH: 80 },
              { label: 'FRI', sH: 20, vH: 45 },
              { label: 'SAT', sH: 30, vH: 30 },
              { label: 'SUN', sH: 15, vH: 25 },
            ];
          }
          const maxV = Math.max(1, ...points.map((p) => Number(p.views || 0)));
          const maxS = Math.max(1, ...points.map((p) => Number(p.sessions || 0)));
          return points.map((p) => {
            const raw = p.label || '';
            const short = (raw.length >= 3 ? raw.slice(0, 3) : raw).toUpperCase();
            return {
              label: short,
              vH: Math.max(6, Math.round((Number(p.views || 0) / maxV) * 100)),
              sH: Math.max(4, Math.round((Number(p.sessions || 0) / maxS) * 30)),
            };
          });
        }
      };
    }
  </script>
</x-app-layout>
