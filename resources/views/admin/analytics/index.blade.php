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
  </style>
@endpush

@push('scripts')
  @vite(['resources/js/admin-analytics.js'])
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
    x-init="initCharts()"
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
        <div x-ref="trafficChart" class="min-h-[300px] w-full"></div>
      </div>
    </section>

    <section class="mb-10 grid grid-cols-1 gap-6 lg:grid-cols-2">
      <div class="anx-card rounded-2xl p-6 md:p-8">
        <h3 class="mb-8 text-xs font-bold uppercase tracking-[0.18em] text-on-surface-variant">{{ __('Traffic Distribution') }}</h3>
        <div class="flex flex-col items-center gap-10 sm:flex-row sm:items-center">
          <div class="w-full min-w-0 shrink-0 sm:w-[280px]">
            <div x-ref="donutChart" class="min-h-[260px] w-full"></div>
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
        <div x-ref="referrerChart" class="min-h-[220px] w-full"></div>
        <p class="mt-4 text-center text-sm text-on-surface-variant" x-show="!state.topReferrers || !state.topReferrers.length" x-cloak>{{ __('No referrer data in this range yet') }}</p>
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
        <h3 class="mb-6 text-xs font-bold uppercase tracking-[0.18em] text-on-surface-variant">{{ __('Top Car Listings') }}</h3>
        <div x-ref="listingsChart" class="min-h-[260px] w-full"></div>
        <p class="mt-4 text-center text-sm text-on-surface-variant" x-show="!hasVehicleListings()" x-cloak>{{ __('No listing views in this range yet') }}</p>
      </div>

      <div class="anx-card flex flex-col rounded-2xl p-6 md:p-8">
        <h3 class="mb-6 w-full text-left text-xs font-bold uppercase tracking-[0.18em] text-on-surface-variant">{{ __('User Engagement Ratio') }}</h3>
        <div class="flex flex-col items-center">
          <div x-ref="gaugeChart" class="min-h-[280px] w-full max-w-sm"></div>
        </div>
        <p class="mt-4 max-w-xs text-center text-xs leading-relaxed text-on-surface-variant lg:self-center">
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
      <div x-ref="dailyChart" class="min-h-[280px] w-full px-1 sm:px-3"></div>
    </section>
  </div>

</x-app-layout>
