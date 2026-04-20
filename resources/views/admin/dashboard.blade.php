<x-app-layout>
  <x-slot name="header">
    <div>
      <div class="text-[11px] font-bold uppercase tracking-[0.18em] text-zinc-500">{{ __('Admin') }}</div>
      <div class="text-xl font-bold tracking-tight text-zinc-900">{{ __('Overview') }}</div>
    </div>
  </x-slot>

  <div class="space-y-10">
    <div class="relative overflow-hidden rounded-2xl border border-zinc-200/80 bg-white p-8 shadow-[0_20px_50px_-24px_rgba(0,0,0,0.15)] ring-1 ring-black/[0.03]">
      <div class="pointer-events-none absolute -right-16 -top-24 h-48 w-48 rounded-full bg-amber-400/10 blur-3xl"></div>
      <p class="relative max-w-2xl text-base leading-relaxed text-zinc-600">
        {{ __('Operations snapshot for your dealership site. Moderate inventory, accounts, and content from one console—the same tooling your vendors use for their own listings.') }}
      </p>
    </div>

    <div class="grid grid-cols-1 gap-5 sm:grid-cols-2 xl:grid-cols-4">
      <div class="rounded-2xl border border-zinc-200/90 bg-white p-6 shadow-sm ring-1 ring-black/[0.02] transition hover:shadow-md">
        <div class="flex items-start justify-between gap-3">
          <span class="text-[11px] font-bold uppercase tracking-wider text-zinc-500">{{ __('Total listings') }}</span>
          <span class="flex h-10 w-10 items-center justify-center rounded-xl bg-zinc-900 text-amber-400 shadow-inner">
            <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"/></svg>
          </span>
        </div>
        <p class="mt-4 text-4xl font-bold tabular-nums tracking-tight text-zinc-900">{{ $stats['total_listings'] ?? 0 }}</p>
      </div>
      <div class="rounded-2xl border border-amber-200/80 bg-gradient-to-br from-amber-50 to-white p-6 shadow-sm ring-1 ring-amber-500/10 transition hover:shadow-md">
        <div class="flex items-start justify-between gap-3">
          <span class="text-[11px] font-bold uppercase tracking-wider text-amber-900/80">{{ __('Pending review') }}</span>
          <span class="flex h-10 w-10 items-center justify-center rounded-xl bg-amber-500 text-zinc-900 shadow-sm">
            <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
          </span>
        </div>
        <p class="mt-4 text-4xl font-bold tabular-nums tracking-tight text-amber-950">{{ $stats['pending_listings'] ?? 0 }}</p>
      </div>
      <div class="rounded-2xl border border-emerald-200/80 bg-gradient-to-br from-emerald-50 to-white p-6 shadow-sm ring-1 ring-emerald-500/10 transition hover:shadow-md">
        <div class="flex items-start justify-between gap-3">
          <span class="text-[11px] font-bold uppercase tracking-wider text-emerald-900/80">{{ __('Approved live') }}</span>
          <span class="flex h-10 w-10 items-center justify-center rounded-xl bg-emerald-500 text-white shadow-sm">
            <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>
          </span>
        </div>
        <p class="mt-4 text-4xl font-bold tabular-nums tracking-tight text-emerald-950">{{ $stats['approved_listings'] ?? 0 }}</p>
      </div>
      <div class="rounded-2xl border border-violet-200/80 bg-gradient-to-br from-violet-50 to-white p-6 shadow-sm ring-1 ring-violet-500/10 transition hover:shadow-md">
        <div class="flex items-start justify-between gap-3">
          <span class="text-[11px] font-bold uppercase tracking-wider text-violet-900/80">{{ __('Users') }}</span>
          <span class="flex h-10 w-10 items-center justify-center rounded-xl bg-violet-600 text-white shadow-sm">
            <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"/></svg>
          </span>
        </div>
        <p class="mt-4 text-4xl font-bold tabular-nums tracking-tight text-violet-950">{{ $stats['users_count'] ?? 0 }}</p>
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
