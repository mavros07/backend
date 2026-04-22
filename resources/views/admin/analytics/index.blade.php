@push('head')
  <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@24,400,0,0" />
  <style>
    .material-symbols-outlined {
      font-variation-settings: 'FILL' 0, 'wght' 400, 'GRAD' 0, 'opsz' 24;
    }
  </style>
@endpush

<x-app-layout>
  <x-slot name="header">
    <div class="flex w-full flex-wrap items-center justify-between gap-4">
      <div>
        <div class="text-[10px] font-bold uppercase tracking-[0.2em] text-zinc-500">{{ __('Admin') }}</div>
        <h2 class="text-xl font-black tracking-tight text-[#0B1F3A] dark:text-white">{{ __('Analytics') }}</h2>
      </div>
      <div class="hidden items-center gap-6 text-xs font-semibold uppercase tracking-wider text-zinc-500 lg:flex">
        <span class="hover:text-[#0B1F3A] dark:hover:text-zinc-200">{{ __('Portfolio') }}</span>
        <span class="hover:text-[#0B1F3A] dark:hover:text-zinc-200">{{ __('Valuation') }}</span>
        <span class="hover:text-[#0B1F3A] dark:hover:text-zinc-200">{{ __('Trends') }}</span>
      </div>
      <div class="flex items-center gap-2 sm:gap-3">
        <span class="inline-flex items-center gap-2 rounded-xl bg-zinc-100 px-3 py-2 text-sm font-semibold text-zinc-800 sm:px-4">
          <span class="material-symbols-outlined text-base text-zinc-600">filter_list</span>
          <span class="hidden sm:inline">{{ __('Date Range') }}</span>
        </span>
        <a
          :href="`{{ route('admin.analytics.index') }}?range=${range}&export=csv&start_date=${startDate}&end_date=${endDate}`"
          class="inline-flex items-center rounded-xl bg-[#0B1F3A] px-4 py-2 text-sm font-semibold text-white transition-opacity hover:opacity-90 sm:px-6"
        >{{ __('Export Data') }}</a>
      </div>
    </div>
  </x-slot>

  <div
    class="relative -mx-4 -mt-8 -mb-8 min-h-[calc(100dvh-4.5rem)] bg-[#F7F9FC] px-4 py-6 pb-12 text-[#191c1e] sm:-mx-6 sm:px-6 lg:-mx-10 lg:px-10"
    x-data="analyticsPage({
      endpoint: '{{ route('admin.analytics.data') }}',
      range: {{ $rangeDays }},
      startDate: '{{ $startDate }}',
      endDate: '{{ $endDate }}',
      initial: @js([
        'summary' => $summary,
        'kpiDeltas' => $kpiDeltas,
        'lineChart' => $lineChart,
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
    <div class="mb-8 rounded-2xl border border-[#e0e3e6]/60 bg-white/90 p-5 shadow-sm backdrop-blur-sm">
      <div class="flex flex-wrap items-end gap-3">
        <div class="flex items-center gap-2">
          <label class="text-[10px] font-bold uppercase tracking-widest text-[#44474d]">{{ __('Start') }}</label>
          <input type="date" x-model="startDate" class="rounded-lg border border-[#c4c6ce] bg-white px-2 py-1.5 text-sm text-[#191c1e]">
        </div>
        <div class="flex items-center gap-2">
          <label class="text-[10px] font-bold uppercase tracking-widest text-[#44474d]">{{ __('End') }}</label>
          <input type="date" x-model="endDate" class="rounded-lg border border-[#c4c6ce] bg-white px-2 py-1.5 text-sm text-[#191c1e]">
        </div>
        <div class="flex items-center gap-1.5">
          <template x-for="opt in [7,30,90]" :key="opt">
            <button
              type="button"
              @click="applyPreset(opt)"
              class="rounded-lg border px-3 py-1.5 text-xs font-bold tracking-wide"
              :class="range === opt ? 'border-[#0B1F3A] bg-[#0B1F3A] text-white' : 'border-[#e0e3e6] bg-white text-[#44474d]'"
            >
              <span x-text="opt + 'D'"></span>
            </button>
          </template>
        </div>
        <button type="button" @click="load()" class="rounded-lg bg-[#0B1F3A] px-4 py-2 text-sm font-semibold text-white hover:opacity-90">{{ __('Apply') }}</button>
      </div>
    </div>

    {{-- Section 1: KPI (sample: surface-container-lowest, no card shadow) --}}
    <div class="mb-10 grid grid-cols-1 gap-6 md:grid-cols-2 lg:grid-cols-4">
      <div class="rounded-2xl bg-white p-6">
        <div class="mb-4 flex items-start justify-between">
          <span class="text-[10px] font-bold uppercase tracking-widest text-[#44474d]">{{ __('Total Page Views') }}</span>
          <span
            class="rounded-full px-2 py-1 text-[10px] font-bold"
            :class="kpiPillClass(state.kpiDeltas?.views)"
            x-text="formatKpiDelta(state.kpiDeltas?.views)"
          ></span>
        </div>
        <div class="text-3xl font-medium tracking-tight text-[#000615]" x-text="num(state.summary.total_views)"></div>
        <div class="mt-2 h-1 w-full overflow-hidden rounded-full bg-[#f2f4f7]">
          <div class="h-full rounded-full bg-[#0B1F3A] transition-all" :style="`width:${kpiBarWidth(1)}%`"></div>
        </div>
      </div>
      <div class="rounded-2xl bg-white p-6">
        <div class="mb-4 flex items-start justify-between">
          <span class="text-[10px] font-bold uppercase tracking-widest text-[#44474d]">{{ __('Unique Sessions') }}</span>
          <span
            class="rounded-full px-2 py-1 text-[10px] font-bold"
            :class="kpiPillClass(state.kpiDeltas?.sessions)"
            x-text="formatKpiDelta(state.kpiDeltas?.sessions)"
          ></span>
        </div>
        <div class="text-3xl font-medium tracking-tight text-[#000615]" x-text="num(state.summary.unique_sessions)"></div>
        <div class="mt-2 h-1 w-full overflow-hidden rounded-full bg-[#f2f4f7]">
          <div class="h-full rounded-full bg-[#a87e59] transition-all" :style="`width:${kpiBarWidth(2)}%`"></div>
        </div>
      </div>
      <div class="rounded-2xl bg-white p-6">
        <div class="mb-4 flex items-start justify-between">
          <span class="text-[10px] font-bold uppercase tracking-widest text-[#44474d]">{{ __('Unique Pages Visited') }}</span>
          <span
            class="rounded-full px-2 py-1 text-[10px] font-bold"
            :class="kpiPillClass(state.kpiDeltas?.pages)"
            x-text="formatKpiDelta(state.kpiDeltas?.pages)"
          ></span>
        </div>
        <div class="text-3xl font-medium tracking-tight text-[#000615]" x-text="num(state.summary.unique_pages)"></div>
        <div class="mt-2 h-1 w-full overflow-hidden rounded-full bg-[#f2f4f7]">
          <div class="h-full rounded-full bg-[#ba1a1a] transition-all" :style="`width:${kpiBarWidth(3)}%`"></div>
        </div>
      </div>
      <div class="rounded-2xl bg-white p-6">
        <div class="mb-4 flex items-start justify-between">
          <span class="text-[10px] font-bold uppercase tracking-widest text-[#44474d]">{{ __('Top listing') }}</span>
          <span class="rounded-full bg-[#a87e59]/10 px-2 py-1 text-[10px] font-bold text-[#a87e59]">{{ __('Hot') }}</span>
        </div>
        <div class="truncate text-xl font-medium tracking-tight text-[#000615]" x-text="topListingTitle()"></div>
        <p class="mt-1 text-[10px] text-[#44474d]">
          <span x-text="num(topListingViews())"></span> {{ __('views in period') }}
        </p>
      </div>
    </div>

    {{-- Traffic trend --}}
    <div class="mb-10">
      <div class="rounded-2xl bg-white p-8 shadow-[0px_24px_48px_-12px_rgba(11,31,58,0.08)]">
        <div class="mb-8 flex flex-col justify-between gap-4 sm:mb-10 sm:flex-row sm:items-center">
          <div>
            <h3 class="text-lg font-bold tracking-tight text-[#000615]">{{ __('Traffic Analytics') }}</h3>
            <p class="text-sm text-[#44474d]">{{ __('User engagement and volume over the selected range') }}</p>
          </div>
          <div class="flex flex-wrap gap-4">
            <div class="flex items-center gap-2">
              <span class="h-3 w-3 shrink-0 rounded-full bg-[#0B1F3A]"></span>
              <span class="text-xs font-semibold uppercase tracking-wider text-[#44474d]">{{ __('Views') }}</span>
            </div>
            <div class="flex items-center gap-2">
              <span class="h-3 w-3 shrink-0 rounded-full bg-[#a87e59]"></span>
              <span class="text-xs font-semibold uppercase tracking-wider text-[#44474d]">{{ __('Sessions') }}</span>
            </div>
          </div>
        </div>
        {{-- Sample: 100×100 mock curve at opacity-20, then live area/line chart, then 12 flex bars (gap-2, hover) --}}
        <div class="relative h-[300px] w-full">
          <svg
            class="pointer-events-none absolute inset-0 z-0 h-full w-full opacity-20"
            viewBox="0 0 100 100"
            preserveAspectRatio="none"
            aria-hidden="true"
          >
            <path
              class="text-[#0B1F3A]"
              d="M0 80 Q 25 20, 50 50 T 100 10"
              fill="none"
              stroke="currentColor"
              stroke-width="2"
            ></path>
          </svg>
          <svg
            :viewBox="`0 0 ${state.lineChart?.width || 1200} ${state.lineChart?.height || 320}`"
            class="pointer-events-none absolute inset-0 z-[1] h-full w-full"
            preserveAspectRatio="xMidYMid meet"
          >
            <defs>
              <linearGradient id="anViewsFill" x1="0" x2="0" y1="0" y2="1">
                <stop offset="0%" stop-color="#0b1f3a" stop-opacity="0.18" />
                <stop offset="100%" stop-color="#0b1f3a" stop-opacity="0" />
              </linearGradient>
            </defs>
            <path :d="state.lineChart?.view_area_path" fill="url(#anViewsFill)"></path>
            <path :d="state.lineChart?.view_path" fill="none" stroke="#0b1f3a" stroke-width="3"></path>
            <path
              :d="state.lineChart?.session_path"
              fill="none"
              stroke="#a87e59"
              stroke-width="2.5"
              stroke-dasharray="8 5"
            ></path>
          </svg>
          <div class="absolute inset-0 z-[2] flex items-end gap-2">
            <template x-for="(bar, idx) in (state.trendBars || defaultTrendBars())" :key="idx">
              <div
                class="min-w-0 flex-1 origin-bottom rounded-t-lg transition-all duration-200 ease-out hover:brightness-95"
                :class="[
                  bar?.highlight ? 'bg-[#0B1F3A]' : 'bg-[#f2f4f7]',
                  'origin-bottom hover:scale-y-105',
                ]"
                :style="`height: ${bar?.h || 50}%;`"
              ></div>
            </template>
          </div>
        </div>
        <div class="mt-4 flex justify-between text-[10px] font-bold uppercase tracking-widest text-[#75777e]">
          <template x-for="(lab, i) in (state.trendXLabels || [])" :key="i">
            <span x-text="lab" class="min-w-0 flex-1 text-center first:text-left last:text-right"></span>
          </template>
        </div>
      </div>
    </div>

    <div class="mb-10 grid grid-cols-1 gap-6 lg:grid-cols-2">
      {{-- Donut --}}
      <div class="rounded-2xl bg-white p-8 shadow-sm">
        <h3 class="mb-8 text-sm font-bold uppercase tracking-widest text-[#44474d]">{{ __('Traffic distribution') }}</h3>
        <div class="flex flex-col items-center gap-8 sm:flex-row sm:items-center sm:gap-10">
          <div class="relative h-40 w-40 shrink-0">
            <div
              class="h-full w-full rounded-full"
              :style="donutStyle()"
            ></div>
            <div class="pointer-events-none absolute inset-0 flex flex-col items-center justify-center text-center">
              <span class="text-2xl font-bold text-[#000615]" x-text="deviceTotalPct() + '%'"></span>
              <span class="text-[8px] font-bold uppercase tracking-widest text-[#44474d]">{{ __('Global') }}</span>
            </div>
          </div>
          <div class="w-full min-w-0 flex-1 space-y-4">
            <template x-for="(row, di) in (state.deviceBreakdown || [])" :key="row.label">
              <div class="flex items-center justify-between">
                <div class="flex min-w-0 items-center gap-3">
                  <span
                    class="h-2 w-2 shrink-0 rounded-full"
                    :class="deviceDotClass(di)"
                  ></span>
                  <span class="text-sm font-medium text-[#191c1e]" x-text="row.label"></span>
                </div>
                <span class="text-sm font-bold text-[#000615]" x-text="(row.percentage || 0) + '%'"></span>
              </div>
            </template>
          </div>
        </div>
      </div>

      {{-- Referrers --}}
      <div class="rounded-2xl bg-white p-8 shadow-sm">
        <h3 class="mb-8 text-sm font-bold uppercase tracking-widest text-[#44474d]">{{ __('Referrer performance') }}</h3>
        <div class="space-y-6">
          <template x-for="(row, ri) in (state.topReferrers || [])" :key="row.referrer_host || ri">
            <div class="space-y-2">
              <div class="flex justify-between text-sm font-medium text-[#191c1e]">
                <span class="min-w-0 truncate" x-text="row.referrer_host"></span>
                <span x-text="num(row.views)"></span>
              </div>
              <div class="h-2 w-full rounded-full bg-[#f2f4f7]">
                <div
                  class="h-2 rounded-full"
                  :class="referrerBarClass(ri)"
                  :style="`width: ${refWidth(row.views)}%`"
                ></div>
              </div>
            </div>
          </template>
        </div>
        <div class="mt-4 space-y-6" x-show="!state.topReferrers || !state.topReferrers.length" x-cloak>
          <div class="space-y-2">
            <div class="flex justify-between text-sm font-medium text-[#191c1e]"><span>—</span><span>0</span></div>
            <div class="h-2 w-full rounded-full bg-[#f2f4f7]">
              <div class="h-2 w-[35%] rounded-full bg-[#0B1F3A]"></div>
            </div>
          </div>
        </div>
        <p class="mt-3 text-center text-xs text-[#44474d] sm:text-left" x-show="!state.topReferrers || !state.topReferrers.length" x-cloak>
          {{ __('No referrer data yet. Bars fill when visits include a referrer host.') }}
        </p>
      </div>
    </div>

    {{-- Table --}}
    <div class="mb-10 overflow-hidden rounded-2xl bg-white shadow-sm">
      <div class="flex flex-col justify-between gap-4 p-8 pb-0 sm:flex-row sm:items-end">
        <div>
          <h3 class="text-lg font-bold tracking-tight text-[#000615]">{{ __('Most visited pages') }}</h3>
          <p class="text-sm text-[#44474d]">{{ __('Listing performance and viewer conversion') }}</p>
          <p class="mt-1 text-xs text-[#44474d]/80">{{ __('Avg. time is shown when that metric is available.') }}</p>
        </div>
        <a href="{{ route('admin.analytics.index') }}" class="inline-flex items-center gap-1 self-start text-xs font-bold uppercase tracking-widest text-[#0B1F3A] hover:opacity-80 sm:self-auto">
          {{ __('Full view') }} <span class="material-symbols-outlined text-base">arrow_forward</span>
        </a>
      </div>
      <div class="p-4">
        <div class="overflow-x-auto">
          <table class="w-full border-collapse text-left">
            <thead>
              <tr class="border-b border-[#f2f4f7] text-[10px] font-bold uppercase tracking-widest text-[#44474d]">
                <th class="px-4 py-4 sm:px-6">{{ __('Page title') }}</th>
                <th class="px-4 py-4 sm:px-6">{{ __('Views') }}</th>
                <th class="px-4 py-4 sm:px-6">{{ __('Avg. time') }}</th>
                <th class="px-4 py-4 sm:px-6">{{ __('Bounce rate') }}</th>
                <th class="px-4 py-4 sm:px-6">{{ __('Performance') }}</th>
              </tr>
            </thead>
            <tbody class="divide-y divide-[#f2f4f7]/30">
              <template x-for="row in (state.topPages || [])" :key="row.path">
                <tr class="transition-colors hover:bg-[#f2f4f7]/50">
                  <td class="max-w-[200px] px-4 py-5 text-sm font-medium text-[#191c1e] sm:max-w-md" x-text="pathTitle(row)"></td>
                  <td class="whitespace-nowrap px-4 py-5 text-sm" x-text="num(row.views)"></td>
                  <td class="whitespace-nowrap px-4 py-5 text-sm text-[#44474d]">—</td>
                  <td class="whitespace-nowrap px-4 py-5 text-sm" x-text="bounceProxy(row) + '%'"></td>
                  <td class="px-4 py-5">
                    <div class="flex min-w-[10rem] items-center gap-2 sm:min-w-0">
                      <div class="h-1.5 w-24 min-w-0 flex-1 overflow-hidden rounded-full bg-[#f2f4f7] sm:w-24">
                        <div
                          class="h-full rounded-full"
                          :class="perfBarClass(performanceScore(row))"
                          :style="`width: ${performanceScore(row)}%`"
                        ></div>
                      </div>
                      <span
                        class="w-8 shrink-0 text-xs font-bold"
                        :class="perfTextClass(performanceScore(row))"
                        x-text="performanceScore(row) + '%'"
                      ></span>
                    </div>
                  </td>
                </tr>
              </template>
            </tbody>
          </table>
        </div>
        <p class="px-2 py-3 text-center text-sm text-[#44474d]" x-show="!(state.topPages && state.topPages.length)">{{ __('No page data in this range yet—table fills as traffic is recorded.') }}</p>
      </div>
    </div>

    <div class="mb-10 grid grid-cols-1 gap-6 lg:grid-cols-2">
      <div class="rounded-2xl bg-white p-8 shadow-sm">
        <h3 class="mb-8 text-sm font-bold uppercase tracking-widest text-[#44474d] sm:mb-10">{{ __('Top car listings') }}</h3>
        <div class="flex h-48 items-end justify-between gap-2 px-2 sm:gap-4">
          <template x-for="(row, li) in topListingsShort()" :key="row.vehicle_slug || li">
            <div class="flex min-w-0 flex-1 flex-col items-center gap-3">
              <div
                class="w-full rounded-t-lg transition-all duration-200"
                :class="isTopListingMax(row) ? 'bg-[#0B1F3A]' : 'bg-[#0B1F3A]/20'"
                :style="`height: ${listingBarHeight(row)}%`"
              ></div>
              <span
                class="w-full truncate text-center text-[10px] font-bold text-[#75777e]"
                :class="isTopListingMax(row) ? 'text-[#000615]' : ''"
                x-text="listingShortCode(row.vehicle_slug)"
              ></span>
            </div>
          </template>
        </div>
        <p class="mt-3 text-center text-xs text-[#44474d] sm:text-left" x-show="!topListingsShort().length">{{ __('Listings will appear as inventory pages receive views.') }}</p>
      </div>

      <div class="flex flex-col items-center rounded-2xl bg-white p-8 text-center shadow-sm">
        <h3 class="mb-6 w-full text-left text-sm font-bold uppercase tracking-widest text-[#44474d]">{{ __('User engagement ratio') }}</h3>
        <div class="relative flex h-48 w-48 shrink-0 items-center justify-center">
          <svg class="absolute inset-0 h-full w-full -rotate-90" viewBox="0 0 192 192">
            <circle cx="96" cy="96" r="80" fill="none" stroke="#e6e8eb" stroke-width="8" pathLength="100" stroke-dasharray="100" stroke-dashoffset="0" />
            <circle
              cx="96"
              cy="96"
              r="80"
              fill="none"
              stroke="#a87e59"
              stroke-width="8"
              stroke-linecap="round"
              pathLength="100"
              :stroke-dasharray="100"
              :stroke-dashoffset="100 - engagementRatio()"
            />
          </svg>
          <div class="relative z-10">
            <div class="text-4xl font-black tracking-tighter text-[#000615]" x-text="engagementRatio().toFixed(1) + '%'"></div>
            <div class="text-[10px] font-bold uppercase tracking-widest text-[#75777e]">{{ __('Efficiency') }}</div>
          </div>
        </div>
        <p class="mt-4 max-w-xs text-xs leading-relaxed text-[#44474d]">
          {{ __('Your platform engagement is') }}
          <span class="font-bold text-[#a87e59]" x-text="engagementBlurb()"></span>
          {{ __('the luxury industry average (illustrative benchmark).') }}
        </p>
      </div>
    </div>

    <div class="rounded-2xl bg-white p-8 shadow-sm">
      <div class="mb-8 flex flex-col justify-between gap-4 sm:mb-10 sm:flex-row sm:items-center">
        <h3 class="text-lg font-bold tracking-tight text-[#000615]">{{ __('Daily Activity: Views vs Sessions') }}</h3>
        <div class="flex flex-wrap gap-4">
          <div class="flex items-center gap-2">
            <div class="h-3 w-3 rounded-sm bg-[#0B1F3A]"></div>
            <span class="text-xs font-medium text-[#44474d]">{{ __('Views') }}</span>
          </div>
          <div class="flex items-center gap-2">
            <div class="h-3 w-3 rounded-sm bg-[#a87e59]/40"></div>
            <span class="text-xs font-medium text-[#44474d]">{{ __('Sessions') }}</span>
          </div>
        </div>
      </div>
      <div class="flex h-64 max-w-full items-end gap-3">
        <template x-for="(day, wi) in weeklyBars()" :key="wi">
          <div class="flex h-full min-w-0 flex-1 flex-col justify-end gap-1">
            <div class="w-full rounded-sm bg-[#a87e59]/30" :style="`height: ${day.sH}%`"></div>
            <div class="w-full rounded-sm bg-[#0B1F3A]" :style="`height: ${day.vH}%`"></div>
            <span class="mt-4 text-center text-[9px] font-bold uppercase text-[#75777e]" x-text="day.label"></span>
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
        defaultTrendBars() {
          return [
            { h: 60, highlight: false },
            { h: 45, highlight: false },
            { h: 80, highlight: false },
            { h: 65, highlight: false },
            { h: 50, highlight: false },
            { h: 95, highlight: true },
            { h: 75, highlight: false },
            { h: 60, highlight: false },
            { h: 40, highlight: false },
            { h: 85, highlight: false },
            { h: 70, highlight: false },
            { h: 55, highlight: false }
          ];
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
          if (v === null || v === undefined) return 'bg-[#e0e3e6]/50 text-[#44474d]';
          if (v > 0) return 'bg-[#a87e59]/10 text-[#a87e59]';
          if (v < 0) return 'bg-[#ba1a1a]/10 text-[#ba1a1a]';
          return 'bg-[#e0e3e6]/50 text-[#44474d]';
        },
        kpiBarWidth(slot) {
          const s = this.state?.summary || {};
          const d = Math.max(1, Number(this.range) || 90);
          const v = Number(s.total_views || 0);
          const u = Number(s.unique_sessions || 0);
          const p = Number(s.unique_pages || 0);
          if (slot === 1) return Math.min(100, Math.round((v / d / 5) * 100));
          if (slot === 2) return Math.min(100, Math.round((u / d / 2) * 100));
          if (slot === 3) return Math.min(100, Math.round(p * 4));
          return 0;
        },
        topListingTitle() {
          const row = (this.state.topListings && this.state.topListings[0]) || null;
          if (!row) return '—';
          const slug = String(row.vehicle_slug || '');
          if (!slug) return '—';
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
        deviceTotalPct() {
          const rows = this.state.deviceBreakdown || [];
          const t = rows.reduce((a, b) => a + Number(b.percentage || 0), 0);
          if (t < 0.5) {
            return 100;
          }
          return Math.min(100, Math.round(t));
        },
        deviceDotClass(i) {
          const c = ['bg-[#0B1F3A]', 'bg-[#a87e59]', 'bg-[#e6e8eb]'];
          return c[i % 3];
        },
        referrerBarClass(i) {
          const c = ['bg-[#0B1F3A]', 'bg-[#a87e59]', 'bg-[#0B1F3A]/40'];
          return c[i % 3];
        },
        donutStyle() {
          const rows = this.state.deviceBreakdown || [];
          const d = Number(rows.find((r) => r.label === 'Desktop')?.percentage || 0);
          const m = Number(rows.find((r) => r.label === 'Mobile')?.percentage || 0);
          const t = Number(rows.find((r) => r.label === 'Tablet')?.percentage || 0);
          if (d + m + t < 0.5) {
            return {
              background: 'conic-gradient(#e6e8eb 0% 100%)'
            };
          }
          const a0 = 0;
          const a1 = d;
          const a2 = d + m;
          return {
            background: `conic-gradient(#0B1F3A ${a0}% ${a1}%, #a87e59 ${a1}% ${a2}%, #e6e8eb ${a2}% 100%)`
          };
        },
        pathTitle(row) {
          const p = String(row.path || '/');
          const label = row.label;
          if (p === '/' && label) return label;
          return p.startsWith('/') ? p : '/' + p;
        },
        performanceScore(row) {
          const v = Number(row.views || 0);
          const s = Number(row.sessions || 0);
          if (!s || !v) return 0;
          const x = (s / v) * 100;
          return Math.max(0, Math.min(100, Math.round(x)));
        },
        perfBarClass(n) {
          if (n >= 85) return 'bg-[#0B1F3A]';
          if (n >= 50) return 'bg-[#0B1F3A]/80';
          return 'bg-[#a87e59]';
        },
        perfTextClass(n) {
          if (n >= 85) return 'text-[#000615]';
          if (n >= 50) return 'text-[#0B1F3A]';
          return 'text-[#a87e59]';
        },
        isTopListingMax(row) {
          const rows = this.topListingsShort();
          if (!rows.length) return false;
          const maxV = Math.max(...rows.map((r) => Number(r.views || 0)));
          return Number(row.views || 0) === maxV;
        },
        async load() {
          const qs = new URLSearchParams({
            range: this.range,
            start_date: this.startDate,
            end_date: this.endDate
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
          const list = this.state.topReferrers || [];
          const max = Math.max(1, ...list.map((r) => Number(r.views || 0)));
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
        listingBarHeight(row) {
          const rows = this.topListingsShort();
          if (!rows.length) return 0;
          const max = Math.max(1, ...rows.map((r) => Number(r.views || 0)));
          return Math.max(8, Math.round((Number(row.views || 0) / max) * 100));
        },
        listingShortCode(slug) {
          const parts = String(slug || '').split('-').filter(Boolean);
          return (parts.length ? (parts.length >= 2 ? parts[parts.length - 1] : parts[0]) : '—').toUpperCase();
        },
        engagementRatio() {
          const bounce = Number(this.state.summary?.bounce_rate || 0);
          return Math.max(0, Math.min(100, 100 - bounce));
        },
        engagementBlurb() {
          const er = this.engagementRatio();
          const industry = 66.4;
          const d = er - industry;
          const pct = Math.abs(Math.round(d * 10) / 10);
          if (d >= 0.5) {
            return `${pct}% higher than`;
          }
          if (d <= -0.5) {
            return `${pct}% lower than`;
          }
          return 'in line with';
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
              { label: 'SUN', sH: 15, vH: 25 }
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
              sH: Math.max(4, Math.round((Number(p.sessions || 0) / maxS) * 45))
            };
          });
        }
      };
    }
  </script>
</x-app-layout>
