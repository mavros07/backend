{{--
  Admin shell inspired by Stay Eazi (sidebar + main + top bar): light sidebar, grouped nav,
  user block at bottom, soft gray canvas. Icons stay inline SVG (no Font Awesome) to avoid extra deps.
--}}
@php
  $site = $site ?? [];
  $brandName = config('app.name', 'Console');
  $logoPath = $site['logo_path'] ?? $site['logo_url'] ?? null;
  $user = Auth::user();
  $n = trim((string) ($user->name ?? 'User'));
  $initials = strtoupper(substr($n, 0, 1).(str_contains($n, ' ') ? substr($n, (int) strrpos($n, ' ') + 1, 1) : ''));
  $contentNavOpen = request()->routeIs('admin.pages.*', 'admin.media.*');
@endphp
<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ isset($title) ? $title.' — ' : '' }}{{ $brandName }}</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
    @include('partials.vite-assets')
  </head>
  <body
    class="antialiased text-slate-900"
    style="font-family: Inter, ui-sans-serif, system-ui, sans-serif;"
    x-data="{
      sidebarCompact: (() => { try { return localStorage.getItem('mt_admin_sb') === '1'; } catch (e) { return false; } })(),
      mobileOpen: false,
      contentOpen: {{ $contentNavOpen ? 'true' : 'false' }},
      toggleSidebar() {
        this.sidebarCompact = !this.sidebarCompact;
        try { localStorage.setItem('mt_admin_sb', this.sidebarCompact ? '1' : '0'); } catch (e) {}
      },
    }"
  >
    <div class="dashboard-container flex min-h-screen bg-[#f2f4f7] lg:flex-row">
      {{-- Mobile overlay --}}
      <div
        class="fixed inset-0 z-40 bg-slate-900/40 backdrop-blur-sm lg:hidden"
        x-show="mobileOpen"
        x-transition.opacity
        @click="mobileOpen = false"
      ></div>

      <aside
        class="fixed inset-y-0 left-0 z-50 flex flex-col border-r border-slate-200 bg-white shadow-[0_1px_3px_rgba(0,0,0,0.08)] transition-all duration-200 lg:static lg:translate-x-0"
        :class="[
          mobileOpen ? 'translate-x-0' : '-translate-x-full lg:translate-x-0',
          sidebarCompact ? 'w-[4.5rem]' : 'w-64',
        ]"
      >
        <div class="flex h-14 shrink-0 items-center justify-between gap-2 border-b border-slate-200 px-3">
          <a href="{{ route('admin.dashboard') }}" class="flex min-w-0 flex-1 items-center gap-2 overflow-hidden rounded-lg px-1 py-1 hover:bg-slate-50" title="{{ $brandName }}">
            @if (!empty($logoPath))
              <img src="{{ \App\Support\VehicleImageUrl::url($logoPath) }}" alt="" class="h-8 w-auto shrink-0 rounded object-contain" />
            @else
              <span class="flex h-9 w-9 shrink-0 items-center justify-center rounded-lg bg-amber-400 text-sm font-bold text-slate-900">{{ strtoupper(\Illuminate\Support\Str::substr($brandName, 0, 1)) }}</span>
            @endif
            <span x-show="!sidebarCompact" x-transition class="truncate text-sm font-bold text-slate-900">{{ $brandName }}</span>
          </a>
          <button
            type="button"
            class="hidden rounded-md p-2 text-slate-600 hover:bg-slate-100 lg:inline-flex"
            @click="toggleSidebar()"
            title="{{ __('Toggle sidebar') }}"
          >
            <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h7"/></svg>
          </button>
          <button type="button" class="rounded-md p-2 text-slate-600 hover:bg-slate-100 lg:hidden" @click="mobileOpen = false" aria-label="{{ __('Close menu') }}">
            <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg>
          </button>
        </div>

        <nav class="sidebar-menu flex-1 space-y-0.5 overflow-y-auto p-2 text-sm font-medium">
          @php
            $mk = fn ($active) => $active
              ? 'border-l-4 border-amber-500 bg-amber-50 text-slate-900'
              : 'border-l-4 border-transparent text-slate-600 hover:bg-slate-50 hover:text-slate-900';
          @endphp

          <a href="{{ route('admin.dashboard') }}" @click="mobileOpen = false" class="{{ $mk(request()->routeIs('admin.dashboard')) }} flex items-center gap-3 rounded-r-lg py-2.5 pl-2 pr-2" title="{{ __('Overview') }}">
            <svg class="h-5 w-5 shrink-0 text-slate-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 5a1 1 0 011-1h4a1 1 0 011 1v4a1 1 0 01-1 1H5a1 1 0 01-1-1V5zM14 5a1 1 0 011-1h4a1 1 0 011 1v4a1 1 0 01-1 1h-4a1 1 0 01-1-1V5zM4 15a1 1 0 011-1h4a1 1 0 011 1v4a1 1 0 01-1 1H5a1 1 0 01-1-1v-4zM14 15a1 1 0 011-1h4a1 1 0 011 1v4a1 1 0 01-1 1h-4a1 1 0 01-1-1v-4z"/></svg>
            <span x-show="!sidebarCompact" x-transition class="truncate">{{ __('Overview') }}</span>
          </a>
          <a href="{{ route('dashboard.vehicles.index') }}" @click="mobileOpen = false" class="{{ $mk(request()->routeIs('dashboard.vehicles.*')) }} flex items-center gap-3 rounded-r-lg py-2.5 pl-2 pr-2" title="{{ __('All listings') }}">
            <svg class="h-5 w-5 shrink-0 text-slate-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"/></svg>
            <span x-show="!sidebarCompact" x-transition class="truncate">{{ __('All listings') }}</span>
          </a>
          <a href="{{ route('admin.users.index') }}" @click="mobileOpen = false" class="{{ $mk(request()->routeIs('admin.users.*')) }} flex items-center gap-3 rounded-r-lg py-2.5 pl-2 pr-2" title="{{ __('Users & vendors') }}">
            <svg class="h-5 w-5 shrink-0 text-slate-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"/></svg>
            <span x-show="!sidebarCompact" x-transition class="truncate">{{ __('Users & vendors') }}</span>
          </a>

          {{-- Collapsible group (Stay Eazi-style menu-group) --}}
          <div class="pt-1">
            <button
              type="button"
              @click="contentOpen = !contentOpen"
              class="flex w-full items-center gap-3 rounded-r-lg border-l-4 border-transparent py-2.5 pl-2 pr-2 text-left text-slate-600 hover:bg-slate-50"
              title="{{ __('Content') }}"
            >
              <svg class="h-5 w-5 shrink-0 text-slate-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"/></svg>
              <span x-show="!sidebarCompact" class="flex flex-1 items-center justify-between truncate">
                <span>{{ __('Content') }}</span>
                <svg class="h-4 w-4 text-slate-400 transition" :class="contentOpen ? 'rotate-90' : ''" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/></svg>
              </span>
            </button>
            <div x-show="contentOpen || sidebarCompact" class="space-y-0.5 pl-1 pt-0.5">
              <a href="{{ route('admin.pages.index') }}" @click="mobileOpen = false" class="{{ $mk(request()->routeIs('admin.pages.*')) }} ml-6 flex items-center gap-2 rounded-r-lg py-2 pl-2 pr-2 text-sm" title="{{ __('Pages') }}">
                <svg class="h-4 w-4 shrink-0 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/></svg>
                <span x-show="!sidebarCompact" x-transition class="truncate">{{ __('Pages') }}</span>
              </a>
              <a href="{{ route('admin.media.index') }}" @click="mobileOpen = false" class="{{ $mk(request()->routeIs('admin.media.*')) }} ml-6 flex items-center gap-2 rounded-r-lg py-2 pl-2 pr-2 text-sm" title="{{ __('Media') }}">
                <svg class="h-4 w-4 shrink-0 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>
                <span x-show="!sidebarCompact" x-transition class="truncate">{{ __('Media') }}</span>
              </a>
            </div>
          </div>

          <a href="{{ route('inventory.index') }}" target="_blank" rel="noopener" @click="mobileOpen = false" class="mt-2 flex items-center gap-3 rounded-r-lg border-l-4 border-transparent py-2.5 pl-2 pr-2 text-slate-500 hover:bg-slate-50" title="{{ __('Public site') }}">
            <svg class="h-5 w-5 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14"/></svg>
            <span x-show="!sidebarCompact" x-transition>{{ __('Public site') }}</span>
          </a>
        </nav>

        <div class="mt-auto border-t border-slate-200 bg-slate-50/80 p-3">
          <div class="flex items-center gap-3">
            <div class="flex h-10 w-10 shrink-0 items-center justify-center rounded-full bg-slate-200 text-xs font-bold text-slate-700" title="{{ $user->name }}">
              {{ strlen($initials) > 2 ? substr($initials, 0, 2) : $initials }}
            </div>
            <div x-show="!sidebarCompact" x-transition class="min-w-0 flex-1">
              <div class="truncate text-sm font-semibold text-slate-900">{{ $user->name }}</div>
              <div class="truncate text-xs text-slate-500">{{ $user->email }}</div>
            </div>
          </div>
          <div x-show="!sidebarCompact" x-transition class="mt-3 flex gap-2">
            <a href="{{ route('profile.edit') }}" @click="mobileOpen = false" class="flex-1 rounded-md border border-slate-200 bg-white px-2 py-1.5 text-center text-xs font-semibold text-slate-700 hover:bg-slate-50">{{ __('Profile') }}</a>
            <form method="POST" action="{{ route('logout') }}" class="flex-1">
              @csrf
              <button type="submit" class="w-full rounded-md border border-rose-200 bg-white px-2 py-1.5 text-xs font-semibold text-rose-700 hover:bg-rose-50">{{ __('Log out') }}</button>
            </form>
          </div>
          <div x-show="sidebarCompact" x-transition class="mt-2 flex flex-col gap-1">
            <a href="{{ route('profile.edit') }}" class="flex justify-center rounded-md p-2 text-slate-600 hover:bg-white" title="{{ __('Profile') }}">
              <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/></svg>
            </a>
            <form method="POST" action="{{ route('logout') }}">
              @csrf
              <button type="submit" class="flex w-full justify-center rounded-md p-2 text-rose-600 hover:bg-white" title="{{ __('Log out') }}">
                <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"/></svg>
              </button>
            </form>
          </div>
        </div>
      </aside>

      <div class="main-content-area flex min-h-screen min-w-0 flex-1 flex-col">
        <header class="top-header sticky top-0 z-30 flex h-14 items-center justify-between gap-4 border-b border-slate-200 bg-white px-4 shadow-[0_1px_3px_rgba(0,0,0,0.06)] sm:px-6">
          <div class="flex min-w-0 flex-1 items-center gap-3">
            <button type="button" class="inline-flex rounded-md border border-slate-200 bg-white p-2 text-slate-600 shadow-sm hover:bg-slate-50 lg:hidden" @click="mobileOpen = true" aria-label="{{ __('Open menu') }}">
              <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"/></svg>
            </button>
            @isset($header)
              <div class="min-w-0 text-slate-900">{{ $header }}</div>
            @else
              <span class="truncate text-base font-semibold text-slate-900">{{ $brandName }}</span>
            @endif
          </div>
        </header>

        <main class="content-area flex-1">
          {{ $slot }}
        </main>
      </div>
    </div>
  </body>
</html>
