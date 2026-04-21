<x-app-layout>
  <x-slot name="header">
    <div>
      <div class="text-[11px] font-bold uppercase tracking-[0.18em] text-zinc-500">{{ __('Admin') }}</div>
      <div class="text-xl font-bold tracking-tight text-zinc-900">{{ __('Analytics') }}</div>
    </div>
  </x-slot>

  @php
    $maxViews = max(1, collect($dailyTrend)->max('views'));
  @endphp

  <div class="space-y-8">
    <div class="grid grid-cols-1 gap-4 sm:grid-cols-2 xl:grid-cols-4">
      <div class="rounded-2xl border border-zinc-200 bg-white p-5 shadow-sm">
        <div class="text-[11px] font-bold uppercase tracking-wider text-zinc-500">{{ __('Total views (last :days days)', ['days' => $rangeDays]) }}</div>
        <p class="mt-3 text-3xl font-bold tracking-tight text-zinc-900">{{ number_format($summary['total_views']) }}</p>
      </div>
      <div class="rounded-2xl border border-zinc-200 bg-white p-5 shadow-sm">
        <div class="text-[11px] font-bold uppercase tracking-wider text-zinc-500">{{ __('Unique sessions') }}</div>
        <p class="mt-3 text-3xl font-bold tracking-tight text-zinc-900">{{ number_format($summary['unique_sessions']) }}</p>
      </div>
      <div class="rounded-2xl border border-zinc-200 bg-white p-5 shadow-sm">
        <div class="text-[11px] font-bold uppercase tracking-wider text-zinc-500">{{ __('Unique pages') }}</div>
        <p class="mt-3 text-3xl font-bold tracking-tight text-zinc-900">{{ number_format($summary['unique_pages']) }}</p>
      </div>
      <div class="rounded-2xl border border-zinc-200 bg-white p-5 shadow-sm">
        <div class="text-[11px] font-bold uppercase tracking-wider text-zinc-500">{{ __('Top referrer') }}</div>
        @if (!empty($summary['top_referrer']))
          <p class="mt-3 truncate text-lg font-semibold text-zinc-900">{{ $summary['top_referrer'] }}</p>
          <p class="mt-1 text-sm text-zinc-500">{{ number_format($summary['top_referrer_views']) }} {{ __('views') }}</p>
        @else
          <p class="mt-3 text-sm text-zinc-500">{{ __('No referrer data yet.') }}</p>
        @endif
      </div>
    </div>

    <div class="rounded-2xl border border-zinc-200 bg-white p-6 shadow-sm">
      <h2 class="text-sm font-bold uppercase tracking-[0.15em] text-zinc-500">{{ __('Traffic trend') }}</h2>
      @if (collect($dailyTrend)->sum('views') > 0)
        <div class="mt-5 overflow-x-auto pb-2">
          <div class="flex min-w-max items-end gap-1.5">
          @foreach ($dailyTrend as $day)
            <div class="group flex w-3 flex-col items-center justify-end">
              <progress class="h-36 w-3 overflow-hidden rounded-full [appearance:none] [&::-webkit-progress-bar]:bg-zinc-100 [&::-webkit-progress-value]:bg-gradient-to-t [&::-webkit-progress-value]:from-amber-400 [&::-webkit-progress-value]:to-amber-600 [&::-moz-progress-bar]:bg-amber-500/90" value="{{ $day['views'] }}" max="{{ $maxViews }}"></progress>
              <span class="mt-2 whitespace-nowrap text-[10px] text-zinc-400 opacity-0 transition group-hover:opacity-100">{{ $day['label'] }}</span>
              <span class="text-[10px] font-semibold text-zinc-600 opacity-0 transition group-hover:opacity-100">{{ $day['views'] }}</span>
            </div>
          @endforeach
          </div>
        </div>
      @else
        <p class="mt-4 text-sm text-zinc-500">{{ __('No traffic captured yet for this period.') }}</p>
      @endif
    </div>

    <div class="grid grid-cols-1 gap-6 xl:grid-cols-2">
      <div class="rounded-2xl border border-zinc-200 bg-white p-6 shadow-sm">
        <h2 class="text-sm font-bold uppercase tracking-[0.15em] text-zinc-500">{{ __('Most visited pages') }}</h2>
        <div class="mt-4 space-y-3">
          @forelse ($topPages as $row)
            <div class="flex items-center justify-between gap-4 rounded-lg border border-zinc-100 bg-zinc-50 px-3 py-2">
              <span class="truncate text-sm font-medium text-zinc-800">{{ $row->path }}</span>
              <span class="shrink-0 text-sm font-semibold text-zinc-600">{{ number_format((int) $row->views) }}</span>
            </div>
          @empty
            <p class="text-sm text-zinc-500">{{ __('No page traffic data yet.') }}</p>
          @endforelse
        </div>
      </div>

      <div class="rounded-2xl border border-zinc-200 bg-white p-6 shadow-sm">
        <h2 class="text-sm font-bold uppercase tracking-[0.15em] text-zinc-500">{{ __('Most visited listings') }}</h2>
        <div class="mt-4 space-y-3">
          @forelse ($topListings as $row)
            <div class="flex items-center justify-between gap-4 rounded-lg border border-zinc-100 bg-zinc-50 px-3 py-2">
              <span class="truncate text-sm font-medium text-zinc-800">{{ $row->vehicle_slug }}</span>
              <span class="shrink-0 text-sm font-semibold text-zinc-600">{{ number_format((int) $row->views) }}</span>
            </div>
          @empty
            <p class="text-sm text-zinc-500">{{ __('No listing traffic data yet.') }}</p>
          @endforelse
        </div>
      </div>
    </div>
  </div>
</x-app-layout>
