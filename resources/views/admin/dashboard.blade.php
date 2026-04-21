<x-app-layout>
  <x-slot name="header">
    <div>
      <div class="text-[11px] font-bold uppercase tracking-[0.18em] text-zinc-500">{{ __('Admin') }}</div>
      <div class="text-xl font-bold tracking-tight text-zinc-900">{{ __('Overview') }}</div>
    </div>
  </x-slot>

  <div class="space-y-10">
    <div class="grid grid-cols-1 gap-5 sm:grid-cols-2 xl:grid-cols-4">
      <div class="rounded-2xl border border-zinc-200/90 bg-white p-6 shadow-sm ring-1 ring-black/[0.02] transition hover:shadow-md">
        <div class="flex items-start justify-between gap-3">
          <span class="text-[11px] font-bold uppercase tracking-wider text-zinc-500">{{ __('Total listings') }}</span>
          <span class="flex h-10 w-10 items-center justify-center rounded-lg border border-zinc-200 bg-zinc-50 text-zinc-600">
            <svg class="h-5 w-5" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24" aria-hidden="true"><path stroke-linecap="round" stroke-linejoin="round" d="M6 6.878V6a2.25 2.25 0 012.25-2.25h9.75A2.25 2.25 0 0120.25 6v.878m-15.75 1.5h15m-15 0a2.25 2.25 0 00-2.25 2.25v9.75A2.25 2.25 0 005.25 21h13.5a2.25 2.25 0 002.25-2.25v-9.75a2.25 2.25 0 00-2.25-2.25h-15z"/></svg>
          </span>
        </div>
        <p class="mt-4 text-4xl font-bold tabular-nums tracking-tight text-zinc-900">{{ $stats['total_listings'] ?? 0 }}</p>
      </div>
      <div class="rounded-2xl border border-zinc-200/90 bg-white p-6 shadow-sm ring-1 ring-black/[0.02] transition hover:shadow-md">
        <div class="flex items-start justify-between gap-3">
          <span class="text-[11px] font-bold uppercase tracking-wider text-zinc-500">{{ __('Pending review') }}</span>
          <span class="flex h-10 w-10 items-center justify-center rounded-lg border border-zinc-200 bg-zinc-50 text-zinc-600">
            <svg class="h-5 w-5" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24" aria-hidden="true"><path stroke-linecap="round" stroke-linejoin="round" d="M12 6v6h4.5m4.5 0a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
          </span>
        </div>
        <p class="mt-4 text-4xl font-bold tabular-nums tracking-tight text-zinc-900">{{ $stats['pending_listings'] ?? 0 }}</p>
      </div>
      <div class="rounded-2xl border border-zinc-200/90 bg-white p-6 shadow-sm ring-1 ring-black/[0.02] transition hover:shadow-md">
        <div class="flex items-start justify-between gap-3">
          <span class="text-[11px] font-bold uppercase tracking-wider text-zinc-500">{{ __('Approved live') }}</span>
          <span class="flex h-10 w-10 items-center justify-center rounded-lg border border-zinc-200 bg-zinc-50 text-zinc-600">
            <svg class="h-5 w-5" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24" aria-hidden="true"><path stroke-linecap="round" stroke-linejoin="round" d="M9 12.75L11.25 15 15 9.75M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
          </span>
        </div>
        <p class="mt-4 text-4xl font-bold tabular-nums tracking-tight text-zinc-900">{{ $stats['approved_listings'] ?? 0 }}</p>
      </div>
      <div class="rounded-2xl border border-zinc-200/90 bg-white p-6 shadow-sm ring-1 ring-black/[0.02] transition hover:shadow-md">
        <div class="flex items-start justify-between gap-3">
          <span class="text-[11px] font-bold uppercase tracking-wider text-zinc-500">{{ __('Users') }}</span>
          <span class="flex h-10 w-10 items-center justify-center rounded-lg border border-zinc-200 bg-zinc-50 text-zinc-600">
            <svg class="h-5 w-5" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24" aria-hidden="true"><path stroke-linecap="round" stroke-linejoin="round" d="M15 19.128a9.38 9.38 0 002.625.372 9.337 9.337 0 004.121-.952 4.125 4.125 0 00-7.533-2.493M15 19.128v-.003c0-1.113-.285-2.16-.786-3.07M15 19.128v.106A12.318 12.318 0 018.624 21c-2.331 0-4.512-.645-6.374-1.766l-.001-.109a6.375 6.375 0 0111.964-3.07M12 6.375a3.375 3.375 0 11-6.75 0 3.375 3.375 0 016.75 0zm8.25 2.25a2.625 2.625 0 11-5.25 0 2.625 2.625 0 015.25 0z"/></svg>
          </span>
        </div>
        <p class="mt-4 text-4xl font-bold tabular-nums tracking-tight text-zinc-900">{{ $stats['users_count'] ?? 0 }}</p>
      </div>
    </div>

    <div>
      <h2 class="text-sm font-bold uppercase tracking-[0.15em] text-zinc-500">{{ __('Shortcuts') }}</h2>
      <div class="mt-4 grid grid-cols-1 gap-4 md:grid-cols-2 xl:grid-cols-3">
        <a href="{{ route('dashboard.vehicles.index') }}" class="group relative overflow-hidden rounded-2xl border border-zinc-200 bg-white p-6 shadow-sm ring-1 ring-black/[0.03] transition hover:border-amber-300/80 hover:shadow-lg">
          <span class="text-[11px] font-bold uppercase tracking-wider text-zinc-500">{{ __('Inventory') }}</span>
          <span class="mt-2 block text-lg font-bold text-zinc-900">{{ __('All vehicle listings') }}</span>
          <span class="mt-4 inline-flex items-center text-sm font-semibold text-amber-600 group-hover:text-amber-700">{{ __('Open →') }}</span>
        </a>
        <a href="{{ route('admin.users.index') }}" class="group relative overflow-hidden rounded-2xl border border-zinc-200 bg-white p-6 shadow-sm ring-1 ring-black/[0.03] transition hover:border-violet-300/80 hover:shadow-lg">
          <span class="text-[11px] font-bold uppercase tracking-wider text-zinc-500">{{ __('Accounts') }}</span>
          <span class="mt-2 block text-lg font-bold text-zinc-900">{{ __('Users & vendors') }}</span>
          <span class="mt-4 inline-flex items-center text-sm font-semibold text-violet-600 group-hover:text-violet-700">{{ __('Open →') }}</span>
        </a>
        <a href="{{ route('admin.pages.index') }}" class="group relative overflow-hidden rounded-2xl border border-zinc-200 bg-white p-6 shadow-sm ring-1 ring-black/[0.03] transition hover:border-sky-300/80 hover:shadow-lg">
          <span class="text-[11px] font-bold uppercase tracking-wider text-zinc-500">{{ __('Content') }}</span>
          <span class="mt-2 block text-lg font-bold text-zinc-900">{{ __('Page editors') }}</span>
          <span class="mt-4 inline-flex items-center text-sm font-semibold text-sky-600 group-hover:text-sky-700">{{ __('Open →') }}</span>
        </a>
        <a href="{{ route('admin.media.index') }}" class="group relative overflow-hidden rounded-2xl border border-zinc-200 bg-white p-6 shadow-sm ring-1 ring-black/[0.03] transition hover:border-zinc-400 hover:shadow-lg">
          <span class="text-[11px] font-bold uppercase tracking-wider text-zinc-500">{{ __('Assets') }}</span>
          <span class="mt-2 block text-lg font-bold text-zinc-900">{{ __('Media library') }}</span>
          <span class="mt-4 inline-flex items-center text-sm font-semibold text-zinc-600 group-hover:text-zinc-800">{{ __('Open →') }}</span>
        </a>
        <a href="{{ route('inventory.index') }}" target="_blank" rel="noopener" class="group relative overflow-hidden rounded-2xl border border-zinc-200 bg-white p-6 shadow-sm ring-1 ring-black/[0.03] transition hover:border-emerald-300/80 hover:shadow-lg">
          <span class="text-[11px] font-bold uppercase tracking-wider text-zinc-500">{{ __('Public') }}</span>
          <span class="mt-2 block text-lg font-bold text-zinc-900">{{ __('Live inventory') }}</span>
          <span class="mt-4 inline-flex items-center text-sm font-semibold text-emerald-600 group-hover:text-emerald-700">{{ __('Open site →') }}</span>
        </a>
      </div>
    </div>
  </div>
</x-app-layout>
