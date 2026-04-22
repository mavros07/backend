@push('head')
  <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@24,400,0,0" />
  <style>
    .material-symbols-outlined { font-variation-settings: 'FILL' 0, 'wght' 400, 'GRAD' 0, 'opsz' 24; }
    .anx-canvas {
      --anx-navy-deep: #040d18;
      --anx-shadow-elevated: 0 1px 0 rgba(255, 255, 255, 0.72) inset, 0 1px 2px rgba(11, 31, 58, 0.05), 0 16px 48px -16px rgba(11, 31, 58, 0.18);
      --anx-shadow-soft: 0 1px 3px rgba(11, 31, 58, 0.06), 0 8px 24px -8px rgba(11, 31, 58, 0.1);
      background: linear-gradient(180deg, #eef2f8 0%, #f7f9fc 32%, #f4f6fa 100%);
    }
    .anx-glass-toolbar {
      background: linear-gradient(135deg, rgba(255, 255, 255, 0.92) 0%, rgba(247, 249, 252, 0.88) 100%);
      backdrop-filter: blur(16px);
      -webkit-backdrop-filter: blur(16px);
      box-shadow: 0 1px 0 rgba(255, 255, 255, 0.9) inset, var(--anx-shadow-soft);
    }
    .anx-kpi-card {
      background: linear-gradient(155deg, #ffffff 0%, #f8fafc 48%, #f0f3f8 100%);
      box-shadow: var(--anx-shadow-elevated);
      border: 1px solid rgba(11, 31, 58, 0.08);
    }
    .anx-kpi-metric { font-variant-numeric: tabular-nums; letter-spacing: -0.03em; }
    .anx-card {
      background: linear-gradient(180deg, #ffffff 0%, #fafbfd 100%);
      box-shadow: var(--anx-shadow-soft);
      border: 1px solid rgba(11, 31, 58, 0.07);
    }
    .anx-card-hero {
      background: linear-gradient(165deg, #ffffff 0%, #f5f7fb 55%, #eef1f7 100%);
      box-shadow: 0 1px 0 rgba(255, 255, 255, 0.65) inset, 0 20px 50px -18px rgba(11, 31, 58, 0.2);
      border: 1px solid rgba(11, 31, 58, 0.08);
    }
    .anx-bar-track {
      background: linear-gradient(180deg, #e8ecf2 0%, #f2f4f7 100%);
      box-shadow: inset 0 1px 2px rgba(11, 31, 58, 0.06);
    }
    .anx-table-head {
      background: linear-gradient(180deg, rgba(245, 247, 251, 0.95) 0%, rgba(238, 242, 248, 0.98) 100%);
    }
    .anx-table-row:hover td {
      background: linear-gradient(90deg, rgba(11, 31, 58, 0.03) 0%, rgba(11, 31, 58, 0.015) 100%);
    }
    .anx-pill-positive { box-shadow: 0 1px 2px rgba(168, 126, 89, 0.12); }
    .anx-donut-glow { filter: drop-shadow(0 2px 8px rgba(11, 31, 58, 0.08)); }
    .anx-gauge-glow { filter: drop-shadow(0 4px 12px rgba(168, 126, 89, 0.15)); }
  </style>
@endpush

<x-app-layout>
  <x-slot name="header">
    <h1 class="truncate text-lg font-bold tracking-tight text-zinc-900">{{ __('Analytics') }}</h1>
  </x-slot>

  <div
    class="anx-canvas text-on-surface relative mx-auto min-h-screen w-full max-w-7xl px-6 py-12 antialiased md:px-10"
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
        'lineChart' => $lineChart,
        'topPages' => $topPages,
        'topListings' => $topListings,
        'topReferrers' => $topReferrers,
        'deviceBreakdown' => $deviceBreakdown,
      ]),
    })"
  >
    <header class="mb-10 flex flex-col items-start justify-between gap-8 md:flex-row md:items-center">
      <div>
        <h2 class="text-3xl font-black tracking-tight text-[#061018] drop-shadow-[0_1px_0_rgba(255,255,255,0.5)]">{{ __('Analytics Overview') }}</h2>
        <p class="mt-2 max-w-xl text-sm leading-relaxed text-on-surface-variant">{{ __('Global luxury automotive market performance') }}</p>
      </div>
      <div class="flex w-full flex-col gap-4 md:w-auto md:min-w-0 md:flex-row md:items-center md:gap-4">
        <div class="anx-glass-toolbar flex min-w-0 flex-1 flex-col gap-3 rounded-2xl border border-[#0a1628]/10 p-3 sm:flex-row sm:flex-wrap sm:items-center sm:gap-x-3 sm:gap-y-2 sm:p-4">
          <div class="flex shrink-0 items-center gap-2 rounded-lg bg-[#0b1f3a]/[0.06] px-3 py-1.5 text-xs font-semibold uppercase tracking-wider text-[#0b1f3a]">
            <span class="material-symbols-outlined text-base text-primary-container">filter_list</span>
            <span>{{ __('Date Range') }}</span>
          </div>
          <div class="flex min-w-0 flex-wrap items-center gap-2 border-t border-[#0a1628]/5 pt-3 sm:border-t-0 sm:pt-0">
            <input type="date" x-model="startDate" class="max-w-[10.5rem] rounded-lg border border-[#0a1628]/12 bg-white/95 px-2.5 py-2 text-xs text-on-surface shadow-sm transition hover:border-primary-container/40 focus:border-primary-container focus:outline-none focus:ring-2 focus:ring-primary-container/20 sm:text-sm">
            <span class="text-[11px] font-medium text-on-surface-variant">{{ __('to') }}</span>
            <input type="date" x-model="endDate" class="max-w-[10.5rem] rounded-lg border border-[#0a1628]/12 bg-white/95 px-2.5 py-2 text-xs text-on-surface shadow-sm transition hover:border-primary-container/40 focus:border-primary-container focus:outline-none focus:ring-2 focus:ring-primary-container/20 sm:text-sm">
          </div>
          <div class="flex flex-wrap gap-1.5 border-t border-[#0a1628]/5 pt-3 sm:border-t-0 sm:border-l sm:pl-3 sm:pt-0">
            <template x-for="opt in [7,30,90]" :key="opt">
              <button
                type="button"
                @click="applyPreset(opt)"
                class="rounded-lg px-3 py-1.5 text-[11px] font-bold tracking-wide transition sm:text-xs"
                :class="range === opt ? 'bg-primary-container text-white shadow-md shadow-[#0b1f3a]/25' : 'border border-[#0a1628]/10 bg-white/80 text-on-surface-variant hover:border-primary-container/30 hover:bg-white'"
              >
                <span x-text="opt + 'd'"></span>
              </button>
            </template>
          </div>
          <button type="button" @click="load()" class="ml-auto rounded-lg bg-primary-container px-4 py-2 text-xs font-semibold text-white shadow-md shadow-[#0b1f3a]/30 transition hover:brightness-110 sm:text-sm">{{ __('Apply') }}</button>
        </div>
        <a
          :href="`{{ route('admin.analytics.index') }}?range=${range}&export=csv&start_date=${startDate}&end_date=${endDate}`"
          class="inline-flex shrink-0 items-center justify-center gap-2 rounded-xl bg-primary-container px-6 py-2.5 text-sm font-semibold text-white shadow-lg shadow-[#0b1f3a]/25 transition hover:brightness-110"
        >
          <span class="material-symbols-outlined text-sm">download</span>
          <span>{{ __('Export Data') }}</span>
        </a>
      </div>
    </header>

    <section class="mb-10 grid grid-cols-1 gap-6 md:grid-cols-2 lg:grid-cols-4">
      <div class="anx-kpi-card flex flex-col rounded-2xl p-6 md:p-7">
        <div class="mb-5 flex items-start justify-between gap-2">
          <span class="text-[10px] font-bold uppercase tracking-[0.2em] text-on-surface-variant">{{ __('Total Page Views') }}</span>
          <span class="rounded-full px-2.5 py-1 text-[10px] font-bold tabular-nums" :class="kpiPillClass(state.kpiDeltas?.views)" x-text="formatKpiDelta(state.kpiDeltas?.views)"></span>
        </div>
        <div class="anx-kpi-metric text-[2rem] font-semibold leading-none tracking-tight text-[#061018] md:text-[2.125rem]" x-text="num(state.summary.total_views)"></div>
        <div class="anx-bar-track mt-4 h-1.5 w-full overflow-hidden rounded-full">
          <div class="h-full rounded-full bg-gradient-to-r from-primary-container to-[#152a45] shadow-sm transition-all duration-500" :style="`width:${kpiBarWidth(1)}%`"></div>
        </div>
      </div>
      <div class="anx-kpi-card flex flex-col rounded-2xl p-6 md:p-7">
        <div class="mb-5 flex items-start justify-between gap-2">
          <span class="text-[10px] font-bold uppercase tracking-[0.2em] text-on-surface-variant">{{ __('Unique Sessions') }}</span>
          <span class="rounded-full px-2.5 py-1 text-[10px] font-bold tabular-nums" :class="kpiPillClass(state.kpiDeltas?.sessions)" x-text="formatKpiDelta(state.kpiDeltas?.sessions)"></span>
        </div>
        <div class="anx-kpi-metric text-[2rem] font-semibold leading-none tracking-tight text-[#061018] md:text-[2.125rem]" x-text="num(state.summary.unique_sessions)"></div>
        <div class="anx-bar-track mt-4 h-1.5 w-full overflow-hidden rounded-full">
          <div class="h-full rounded-full bg-gradient-to-r from-on-tertiary-container to-[#c49a6c] shadow-sm transition-all duration-500" :style="`width:${kpiBarWidth(2)}%`"></div>
        </div>
      </div>
      <div class="anx-kpi-card flex flex-col rounded-2xl p-6 md:p-7">
        <div class="mb-5 flex items-start justify-between gap-2">
          <span class="text-[10px] font-bold uppercase tracking-[0.2em] text-on-surface-variant">{{ __('Unique Pages Visited') }}</span>
          <span class="rounded-full px-2.5 py-1 text-[10px] font-bold tabular-nums" :class="kpiPillClass(state.kpiDeltas?.pages)" x-text="formatKpiDelta(state.kpiDeltas?.pages)"></span>
        </div>
        <div class="anx-kpi-metric text-[2rem] font-semibold leading-none tracking-tight text-[#061018] md:text-[2.125rem]" x-text="num(state.summary.unique_pages)"></div>
        <div class="anx-bar-track mt-4 h-1.5 w-full overflow-hidden rounded-full">
          <div class="h-full rounded-full bg-gradient-to-r from-error to-[#d32f2f] shadow-sm transition-all duration-500" :style="`width:${kpiBarWidth(3)}%`"></div>
        </div>
      </div>
      <div class="anx-kpi-card flex flex-col rounded-2xl p-6 md:p-7">
        <div class="mb-5 flex items-start justify-between gap-2">
          <span class="text-[10px] font-bold uppercase tracking-[0.2em] text-on-surface-variant">{{ __('Top Listing') }}</span>
          <span class="rounded-full border border-on-tertiary-container/20 bg-gradient-to-br from-on-tertiary-container/15 to-on-tertiary-container/5 px-2.5 py-1 text-[10px] font-bold text-on-tertiary-container shadow-sm">{{ __('Hot') }}</span>
        </div>
        <div class="anx-kpi-metric truncate text-xl font-semibold tracking-tight text-[#061018]" x-text="topListingTitle()"></div>
        <p class="mt-2 text-[11px] font-medium leading-snug text-on-surface-variant">
          <span x-show="!topListingViews()">—</span>
          <span x-show="topListingViews() && Number(range) === 1"><span x-text="num(topListingViews())"></span> {{ __('views today') }}</span>
          <span x-show="topListingViews() && Number(range) !== 1"><span x-text="num(topListingViews())"></span> {{ __('views in this range') }}</span>
        </p>
      </div>
    </section>

    <section class="mb-10">
      <div class="anx-card-hero rounded-2xl p-6 md:p-8">
        <div class="mb-8 flex flex-col items-start justify-between gap-5 md:flex-row md:items-center">
          <div>
            <h3 class="text-lg font-bold tracking-tight text-[#061018]">{{ __('Traffic Analytics') }}</h3>
            <p class="mt-1.5 text-sm leading-relaxed text-on-surface-variant" x-text="subTraffic()"></p>
          </div>
          <div class="flex flex-wrap gap-5">
            <div class="flex items-center gap-2.5 rounded-full border border-[#0a1628]/8 bg-white/60 px-3 py-1.5 shadow-sm">
              <span class="h-2.5 w-2.5 rounded-full bg-gradient-to-br from-primary-container to-[#152a45] shadow-sm"></span>
              <span class="text-[11px] font-semibold uppercase tracking-wider text-on-surface-variant">{{ __('Views') }}</span>
            </div>
            <div class="flex items-center gap-2.5 rounded-full border border-[#0a1628]/8 bg-white/60 px-3 py-1.5 shadow-sm">
              <span class="h-2.5 w-2.5 rounded-full bg-gradient-to-br from-on-tertiary-container to-[#8a6645] shadow-sm"></span>
              <span class="text-[11px] font-semibold uppercase tracking-wider text-on-surface-variant">{{ __('Sessions') }}</span>
            </div>
          </div>
        </div>
        <div class="relative flex h-[300px] w-full items-end gap-1.5 sm:gap-2">
          <svg class="pointer-events-none absolute inset-0 z-0 h-full w-full" :viewBox="lineChartViewBox()" preserveAspectRatio="none" aria-hidden="true">
            <defs>
              <linearGradient id="anx-area-fill" x1="0" y1="0" x2="0" y2="1">
                <stop offset="0%" stop-color="#0b1f3a" stop-opacity="0.14" />
                <stop offset="100%" stop-color="#0b1f3a" stop-opacity="0" />
              </linearGradient>
              <linearGradient id="anx-line-stroke" x1="0" y1="0" x2="1" y2="0">
                <stop offset="0%" stop-color="#0b1f3a" />
                <stop offset="100%" stop-color="#1a3a5c" />
              </linearGradient>
            </defs>
            <path fill="url(#anx-area-fill)" :d="state.lineChart?.view_area_path || ''" class="transition-opacity" :class="!state.lineChart?.view_area_path ? 'opacity-0' : ''"></path>
            <path fill="none" stroke="url(#anx-line-stroke)" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round" vector-effect="non-scaling-stroke" :d="state.lineChart?.view_path || ''" class="opacity-90"></path>
            <path fill="none" stroke="#a87e59" stroke-width="1.75" stroke-dasharray="5 4" stroke-linecap="round" stroke-linejoin="round" vector-effect="non-scaling-stroke" :d="state.lineChart?.session_path || ''" class="opacity-75"></path>
          </svg>
          <template x-for="(bar, bi) in trendBarsList()" :key="bi">
            <div
              class="relative z-10 min-h-[8%] flex-1 origin-bottom rounded-t-md shadow-sm transition-all duration-300 hover:brightness-[1.02] sm:hover:scale-y-[1.04]"
              :class="bar.highlight ? 'bg-gradient-to-t from-primary-container via-[#0f2844] to-[#152a45] ring-1 ring-[#0b1f3a]/20' : 'bg-gradient-to-t from-surface-container-low to-[#e8ecf1] ring-1 ring-[#0a1628]/06'"
              :style="'height:' + (bar.h || 20) + '%'"
            ></div>
          </template>
        </div>
        <div class="mt-6 flex justify-between gap-1 overflow-x-auto border-t border-[#0a1628]/06 pt-4 text-[10px] font-bold uppercase tracking-widest text-outline">
          <template x-for="(lab, i) in (state.trendXLabels || sevenTickLabels())" :key="i">
            <span x-text="lab" class="min-w-0 shrink-0 px-0.5 text-center first:text-left last:text-right"></span>
          </template>
        </div>
      </div>
    </section>

    <section class="mb-10 grid grid-cols-1 gap-6 lg:grid-cols-2">
      <div class="anx-card rounded-2xl p-6 md:p-8">
        <h3 class="mb-8 text-xs font-bold uppercase tracking-[0.18em] text-on-surface-variant">{{ __('Traffic Distribution') }}</h3>
        <div class="flex flex-col items-center gap-10 sm:flex-row sm:items-center">
          <div class="relative h-44 w-44 shrink-0 sm:h-40 sm:w-40">
            <svg class="anx-donut-glow h-full w-full -rotate-90" viewBox="0 0 160 160" aria-hidden="true">
              <circle class="text-[#dde2ea]" cx="80" cy="80" r="70" fill="transparent" stroke="currentColor" stroke-width="11"></circle>
              <template x-for="(arc, ai) in donutArcs().arcs" :key="ai">
                <circle
                  class="transition-colors"
                  :class="arc.cls"
                  cx="80"
                  cy="80"
                  r="70"
                  fill="transparent"
                  stroke="currentColor"
                  stroke-linecap="round"
                  stroke-width="11"
                  :stroke-dasharray="arc.dasharray"
                  :stroke-dashoffset="arc.offset"
                ></circle>
              </template>
            </svg>
            <div class="pointer-events-none absolute inset-0 flex flex-col items-center justify-center rounded-full bg-gradient-to-b from-white/40 to-transparent">
              <span class="text-[1.65rem] font-bold tabular-nums tracking-tight text-[#061018]" x-text="deviceTotalPct() + '%'"></span>
              <span class="mt-0.5 text-[8px] font-bold uppercase tracking-[0.2em] text-on-surface-variant">{{ __('Global') }}</span>
            </div>
          </div>
          <div class="w-full flex-1 space-y-5">
            <template x-for="(row, di) in (state.deviceBreakdown || [])" :key="row.label">
              <div class="flex items-center justify-between gap-3 border-b border-[#0a1628]/05 pb-4 last:border-0 last:pb-0">
                <div class="flex min-w-0 items-center gap-3">
                  <span class="h-2.5 w-2.5 shrink-0 rounded-full shadow-sm" :class="deviceDotClass(di)"></span>
                  <span class="text-sm font-medium text-[#1a1d21]" x-text="row.label"></span>
                </div>
                <span class="shrink-0 text-sm font-bold tabular-nums text-[#061018]" x-text="(row.percentage || 0) + '%'"></span>
              </div>
            </template>
          </div>
        </div>
      </div>

      <div class="anx-card rounded-2xl p-6 md:p-8">
        <h3 class="mb-8 text-xs font-bold uppercase tracking-[0.18em] text-on-surface-variant">{{ __('Referrer Performance') }}</h3>
        <div class="space-y-7" x-show="state.topReferrers && state.topReferrers.length" x-cloak>
          <template x-for="(row, ri) in state.topReferrers" :key="row.referrer_host || ri">
            <div class="space-y-2.5">
              <div class="flex justify-between gap-2 text-sm font-medium text-[#1a1d21]">
                <span class="min-w-0 truncate" x-text="row.referrer_host"></span>
                <span class="shrink-0 tabular-nums text-on-surface-variant" x-text="num(row.views)"></span>
              </div>
              <div class="anx-bar-track h-2.5 w-full rounded-full">
                <div
                  class="h-full rounded-full shadow-sm transition-all duration-500"
                  :class="referrerBarGradient(ri)"
                  :style="`width: ${refWidth(row.views)}%`"
                ></div>
              </div>
            </div>
          </template>
        </div>
        <div class="space-y-7" x-show="!state.topReferrers || !state.topReferrers.length" x-cloak>
          <div class="space-y-2.5">
            <div class="flex justify-between text-sm font-medium text-[#1a1d21]"><span>Google Search</span><span class="tabular-nums">42,100</span></div>
            <div class="anx-bar-track h-2.5 w-full rounded-full">
              <div class="h-full w-[85%] rounded-full bg-gradient-to-r from-primary-container to-[#152a45] shadow-sm"></div>
            </div>
          </div>
          <div class="space-y-2.5">
            <div class="flex justify-between text-sm font-medium text-[#1a1d21]"><span>Direct Link</span><span class="tabular-nums">12,400</span></div>
            <div class="anx-bar-track h-2.5 w-full rounded-full">
              <div class="h-full w-[40%] rounded-full bg-gradient-to-r from-on-tertiary-container to-[#8a6645] shadow-sm"></div>
            </div>
          </div>
          <div class="space-y-2.5">
            <div class="flex justify-between text-sm font-medium text-[#1a1d21]"><span>Instagram Ads</span><span class="tabular-nums">8,900</span></div>
            <div class="anx-bar-track h-2.5 w-full rounded-full">
              <div class="h-full w-[25%] rounded-full bg-gradient-to-r from-primary-container/50 to-primary-container/30 shadow-sm"></div>
            </div>
          </div>
        </div>
      </div>
    </section>

    <section class="anx-card mb-10 overflow-hidden rounded-2xl">
      <div class="flex flex-col gap-4 border-b border-[#0a1628]/06 bg-gradient-to-r from-[#f8fafc] to-white px-6 py-6 sm:flex-row sm:items-end sm:justify-between md:px-8">
        <div>
          <h3 class="text-lg font-bold tracking-tight text-[#061018]">{{ __('Most Visited Pages') }}</h3>
          <p class="mt-1.5 text-sm text-on-surface-variant">{{ __('Listing performance and viewer conversion') }}</p>
        </div>
        <a href="{{ route('admin.analytics.index') }}" class="inline-flex items-center gap-1 self-start text-xs font-bold uppercase tracking-widest text-primary-container transition hover:text-[#152a45] sm:self-auto">
          {{ __('Full View') }} <span class="material-symbols-outlined text-sm">arrow_forward</span>
        </a>
      </div>
      <div class="px-4 pb-6 pt-2 md:px-6">
        <div class="overflow-x-auto rounded-xl border border-[#0a1628]/06 bg-white/50">
          <table class="w-full min-w-[600px] border-collapse text-left">
            <thead>
              <tr class="anx-table-head border-b border-[#0a1628]/08 text-[10px] font-bold uppercase tracking-widest text-on-surface-variant">
                <th class="px-5 py-4 md:px-6">{{ __('Page title') }}</th>
                <th class="px-5 py-4 md:px-6">{{ __('Views') }}</th>
                <th class="px-5 py-4 md:px-6">{{ __('Avg. time') }}</th>
                <th class="px-5 py-4 md:px-6">{{ __('Bounce rate') }}</th>
                <th class="px-5 py-4 md:px-6">{{ __('Performance') }}</th>
              </tr>
            </thead>
            <tbody class="divide-y divide-[#0a1628]/06">
              <template x-for="row in (state.topPages || [])" :key="row.path">
                <tr class="anx-table-row transition-colors duration-150">
                  <td class="px-5 py-4 text-sm font-medium text-[#1a1d21] md:px-6 md:py-5" x-text="pathTitle(row)"></td>
                  <td class="px-5 py-4 text-sm tabular-nums text-[#1a1d21] md:px-6 md:py-5" x-text="num(row.views)"></td>
                  <td class="px-5 py-4 text-sm text-on-surface-variant md:px-6 md:py-5">—</td>
                  <td class="px-5 py-4 text-sm tabular-nums text-[#1a1d21] md:px-6 md:py-5" x-text="bounceProxy(row) + '%'"></td>
                  <td class="px-5 py-4 md:px-6 md:py-5">
                    <div class="flex min-w-[10rem] items-center gap-3 sm:min-w-0">
                      <div class="anx-bar-track h-2 w-28 shrink-0 overflow-hidden rounded-full">
                        <div class="h-full rounded-full shadow-sm transition-all duration-500" :class="perfBarClass(performanceScore(row))" :style="`width: ${performanceScore(row)}%`"></div>
                      </div>
                      <span class="w-9 shrink-0 text-right text-xs font-bold tabular-nums" :class="perfTextClass(performanceScore(row))" x-text="performanceScore(row) + '%'"></span>
                    </div>
                  </td>
                </tr>
              </template>
            </tbody>
          </table>
        </div>
        <p class="px-2 py-6 text-center text-sm text-on-surface-variant" x-show="!(state.topPages && state.topPages.length)">{{ __('No page data in this range yet') }}</p>
      </div>
    </section>

    <section class="mb-10 grid grid-cols-1 gap-6 lg:grid-cols-2">
      <div class="anx-card rounded-2xl p-6 md:p-8">
        <h3 class="mb-10 text-xs font-bold uppercase tracking-[0.18em] text-on-surface-variant">{{ __('Top Car Listings') }}</h3>
        <div class="flex h-52 items-end justify-between gap-3 px-2 sm:gap-4 sm:px-4">
          <template x-for="(row, li) in listingSlots()" :key="li">
            <div class="flex min-w-0 flex-1 flex-col items-center gap-3">
              <div
                class="w-full rounded-t-md shadow-inner shadow-black/5 ring-1 ring-[#0a1628]/5 transition-transform duration-300 hover:scale-[1.02]"
                :class="row.vehicle_slug && isTopListingMax(row) ? 'bg-gradient-to-t from-primary-container via-[#0f2844] to-[#152a45]' : 'bg-gradient-to-t from-primary-container/35 to-primary-container/12'"
                :style="`height: ${row.h}%;`"
              ></div>
              <span
                class="text-[10px] font-bold tracking-wide"
                :class="row.vehicle_slug && isTopListingMax(row) ? 'text-[#061018]' : 'text-outline'"
                x-text="row.label"
              ></span>
            </div>
          </template>
        </div>
      </div>

      <div class="anx-card flex flex-col items-center rounded-2xl p-6 text-center md:p-8">
        <h3 class="mb-8 w-full text-left text-xs font-bold uppercase tracking-[0.18em] text-on-surface-variant">{{ __('User Engagement Ratio') }}</h3>
        <div class="relative flex h-52 w-52 shrink-0 items-center justify-center">
          <svg class="anx-gauge-glow absolute inset-0 h-full w-full -rotate-90" viewBox="0 0 192 192" aria-hidden="true">
            <circle
              class="text-[#dde2ea]"
              cx="96"
              cy="96"
              r="80"
              fill="transparent"
              stroke="currentColor"
              stroke-dasharray="502"
              stroke-dashoffset="125"
              stroke-linecap="round"
              stroke-width="9"
            />
            <circle
              class="text-on-tertiary-container"
              cx="96"
              cy="96"
              r="80"
              fill="transparent"
              stroke="currentColor"
              stroke-dasharray="502"
              :stroke-dashoffset="engagementGaugeOffset()"
              stroke-linecap="round"
              stroke-width="9"
            />
          </svg>
          <div class="relative z-10 rounded-full bg-gradient-to-b from-white/90 to-transparent px-4 py-3">
            <div class="text-[2.25rem] font-black leading-none tracking-tighter text-[#061018]" x-text="engagementRatio().toFixed(1) + '%'"></div>
            <div class="mt-1 text-[10px] font-bold uppercase tracking-widest text-outline">{{ __('Efficiency') }}</div>
          </div>
        </div>
        <p class="mt-6 max-w-xs text-xs leading-relaxed text-on-surface-variant">
          {{ __('Your platform engagement is') }} <span class="font-semibold text-on-tertiary-container">12% {{ __('higher') }}</span> {{ __('than the luxury industry average this quarter.') }}
        </p>
      </div>
    </section>

    <section class="anx-card mb-10 rounded-2xl p-6 md:p-8">
      <div class="mb-8 flex flex-col items-start justify-between gap-5 md:flex-row md:items-center">
        <h3 class="text-lg font-bold tracking-tight text-[#061018]">{{ __('Daily Activity: Views vs Sessions') }}</h3>
        <div class="flex flex-wrap gap-5">
          <div class="flex items-center gap-2 rounded-full border border-[#0a1628]/08 bg-white/70 px-3 py-1.5">
            <div class="h-2.5 w-2.5 rounded-sm bg-gradient-to-br from-primary-container to-[#152a45]"></div>
            <span class="text-xs font-medium text-on-surface-variant">{{ __('Views') }}</span>
          </div>
          <div class="flex items-center gap-2 rounded-full border border-[#0a1628]/08 bg-white/70 px-3 py-1.5">
            <div class="h-2.5 w-2.5 rounded-sm bg-gradient-to-br from-on-tertiary-container/40 to-on-tertiary-container/25"></div>
            <span class="text-xs font-medium text-on-surface-variant">{{ __('Sessions') }}</span>
          </div>
        </div>
      </div>
      <div class="flex h-64 items-end gap-2 px-1 sm:gap-3 sm:px-3">
        <template x-for="(day, wi) in weeklyBars()" :key="wi">
          <div class="flex h-full min-w-0 flex-1 flex-col justify-end gap-px">
            <div class="w-full rounded-t-sm bg-gradient-to-t from-on-tertiary-container/35 to-on-tertiary-container/20 shadow-sm ring-1 ring-[#0a1628]/05" :style="`height: ${day.sH}%`"></div>
            <div class="w-full rounded-t-sm bg-gradient-to-t from-primary-container to-[#152a45] shadow-md ring-1 ring-[#0b1f3a]/15" :style="`height: ${day.vH}%`"></div>
            <span class="mt-3 text-center text-[9px] font-bold uppercase tracking-wide text-outline" x-text="day.label"></span>
          </div>
        </template>
      </div>
    </section>
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
        lineChartViewBox() {
          const lc = this.state?.lineChart;
          if (lc && lc.width && lc.height) {
            return `0 0 ${lc.width} ${lc.height}`;
          }
          return '0 0 1200 320';
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
            return 'border border-[#0a1628]/06 bg-surface-container-low/90 text-on-surface-variant';
          }
          if (v < 0) {
            return 'border border-error/20 bg-error/10 text-error';
          }
          if (v > 0) {
            return 'anx-pill-positive border border-on-tertiary-container/20 bg-gradient-to-br from-on-tertiary-container/14 to-on-tertiary-container/5 text-on-tertiary-container';
          }
          return 'border border-[#0a1628]/06 bg-surface-container-low/90 text-on-surface-variant';
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
        referrerBarGradient(i) {
          const mod = i % 3;
          if (mod === 0) {
            return 'bg-gradient-to-r from-primary-container to-[#152a45]';
          }
          if (mod === 1) {
            return 'bg-gradient-to-r from-on-tertiary-container to-[#8a6645]';
          }
          return 'bg-gradient-to-r from-primary-container/55 to-primary-container/35';
        },
        donutArcs() {
          const rows = this.state.deviceBreakdown || [];
          const C = 2 * Math.PI * 70;
          const order = [
            { label: 'Desktop', cls: 'text-primary-container' },
            { label: 'Mobile', cls: 'text-on-tertiary-container' },
            { label: 'Tablet', cls: 'text-surface-container-high' },
          ];
          let cumPct = 0;
          const arcs = [];
          for (const o of order) {
            const pct = Number(rows.find((x) => x.label === o.label)?.percentage || 0);
            if (pct <= 0) {
              continue;
            }
            const len = (pct / 100) * C;
            const gap = Math.max(0.01, C - len);
            arcs.push({
              cls: o.cls,
              dasharray: `${len} ${gap}`,
              offset: -(cumPct / 100) * C,
            });
            cumPct += pct;
          }
          return { arcs, C };
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
            return 'bg-gradient-to-r from-on-tertiary-container to-[#8a6645]';
          }
          if (n >= 50) {
            return 'bg-gradient-to-r from-primary-container to-[#152a45]';
          }
          return 'bg-gradient-to-r from-primary-container/75 to-primary-container/55';
        },
        perfTextClass(n) {
          if (n >= 90) {
            return 'text-on-tertiary-container';
          }
          return 'text-m3-ink';
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
