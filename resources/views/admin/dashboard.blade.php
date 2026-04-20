<x-app-layout>
  <x-slot name="header">
    <div>
      <div class="text-[11px] font-bold uppercase tracking-wider text-slate-500">{{ __('Admin') }}</div>
      <div class="text-lg font-bold leading-tight text-slate-900">{{ __('Overview') }}</div>
    </div>
  </x-slot>

  <div class="p-4 sm:p-6 lg:p-8">
    <p class="mb-6 max-w-3xl text-sm leading-relaxed text-slate-600">{{ __('Site-wide metrics and shortcuts. Approve or edit every vehicle under All listings—the same hub vendors use for their own stock.') }}</p>

    <div class="grid grid-cols-1 gap-4 sm:grid-cols-2 xl:grid-cols-4">
      <div class="rounded-xl border border-slate-200 bg-gradient-to-br from-white to-slate-50 p-6 shadow-sm">
        <div class="flex items-center gap-3">
          <span class="flex h-10 w-10 items-center justify-center rounded-lg bg-slate-900">
            <svg class="h-5 w-5 text-amber-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"/></svg>
          </span>
          <div class="text-xs font-semibold uppercase tracking-wide text-slate-500">{{ __('Total listings') }}</div>
        </div>
        <div class="mt-3 text-3xl font-bold text-slate-900">{{ $stats['total_listings'] ?? 0 }}</div>
      </div>
      <div class="rounded-xl border border-amber-200 bg-gradient-to-br from-amber-50 to-amber-100/80 p-6 shadow-sm">
        <div class="flex items-center gap-3">
          <span class="flex h-10 w-10 items-center justify-center rounded-lg bg-amber-500">
            <svg class="h-5 w-5 text-slate-900" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
          </span>
          <div class="text-xs font-semibold uppercase tracking-wide text-amber-900">{{ __('Pending review') }}</div>
        </div>
        <div class="mt-3 text-3xl font-bold text-amber-950">{{ $stats['pending_listings'] ?? 0 }}</div>
      </div>
      <div class="rounded-xl border border-emerald-200 bg-gradient-to-br from-emerald-50 to-emerald-100/80 p-6 shadow-sm">
        <div class="flex items-center gap-3">
          <span class="flex h-10 w-10 items-center justify-center rounded-lg bg-emerald-500">
            <svg class="h-5 w-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>
          </span>
          <div class="text-xs font-semibold uppercase tracking-wide text-emerald-900">{{ __('Approved live') }}</div>
        </div>
        <div class="mt-3 text-3xl font-bold text-emerald-950">{{ $stats['approved_listings'] ?? 0 }}</div>
      </div>
      <div class="rounded-xl border border-violet-200 bg-gradient-to-br from-violet-50 to-violet-100/60 p-6 shadow-sm">
        <div class="flex items-center gap-3">
          <span class="flex h-10 w-10 items-center justify-center rounded-lg bg-violet-600">
            <svg class="h-5 w-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"/></svg>
          </span>
          <div class="text-xs font-semibold uppercase tracking-wide text-violet-900">{{ __('Users') }}</div>
        </div>
        <div class="mt-3 text-3xl font-bold text-violet-950">{{ $stats['users_count'] ?? 0 }}</div>
      </div>
    </div>

    <div class="mt-8 grid grid-cols-1 gap-4 md:grid-cols-2 xl:grid-cols-3">
      <a href="{{ route('dashboard.vehicles.index') }}" class="group flex flex-col rounded-xl border border-slate-200 bg-white p-6 shadow-sm transition hover:border-amber-400 hover:shadow-md">
        <span class="text-xs font-semibold uppercase tracking-wide text-slate-500">{{ __('Moderation') }}</span>
        <span class="mt-2 text-lg font-bold text-slate-900">{{ __('All vehicle listings') }}</span>
        <span class="mt-4 text-sm font-medium text-amber-600">{{ __('Review, approve, edit →') }}</span>
      </a>

      <a href="{{ route('admin.users.index') }}" class="group flex flex-col rounded-xl border border-slate-200 bg-white p-6 shadow-sm transition hover:border-violet-300 hover:shadow-md">
        <span class="text-xs font-semibold uppercase tracking-wide text-slate-500">{{ __('Accounts') }}</span>
        <span class="mt-2 text-lg font-bold text-slate-900">{{ __('Users & vendors') }}</span>
        <span class="mt-4 text-sm font-medium text-violet-600">{{ __('Roles & access →') }}</span>
      </a>

      <a href="{{ route('admin.pages.index') }}" class="group flex flex-col rounded-xl border border-slate-200 bg-white p-6 shadow-sm transition hover:border-sky-300 hover:shadow-md">
        <span class="text-xs font-semibold uppercase tracking-wide text-slate-500">{{ __('Content') }}</span>
        <span class="mt-2 text-lg font-bold text-slate-900">{{ __('Page editors') }}</span>
        <span class="mt-4 text-sm font-medium text-sky-600">{{ __('CMS pages →') }}</span>
      </a>

      <a href="{{ route('admin.media.index') }}" class="group flex flex-col rounded-xl border border-slate-200 bg-white p-6 shadow-sm transition hover:border-slate-400 hover:shadow-md">
        <span class="text-xs font-semibold uppercase tracking-wide text-slate-500">{{ __('Assets') }}</span>
        <span class="mt-2 text-lg font-bold text-slate-900">{{ __('Media library') }}</span>
        <span class="mt-4 text-sm font-medium text-slate-600">{{ __('Uploads →') }}</span>
      </a>

      <a href="{{ route('inventory.index') }}" target="_blank" rel="noopener" class="group flex flex-col rounded-xl border border-slate-200 bg-white p-6 shadow-sm transition hover:border-emerald-300 hover:shadow-md">
        <span class="text-xs font-semibold uppercase tracking-wide text-slate-500">{{ __('Public') }}</span>
        <span class="mt-2 text-lg font-bold text-slate-900">{{ __('Live inventory') }}</span>
        <span class="mt-4 text-sm font-medium text-emerald-600">{{ __('Open storefront →') }}</span>
      </a>
    </div>
  </div>
</x-app-layout>
