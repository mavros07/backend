@php
  $site = $site ?? [];
  $brandName = config('app.name', 'Console');
  $logoPath = $site['logo_path'] ?? $site['logo_url'] ?? null;
  $user = Auth::user();
  $n = trim((string) ($user->name ?? 'User'));
  $initials = strtoupper(substr($n, 0, 1).(str_contains($n, ' ') ? substr($n, (int) strrpos($n, ' ') + 1, 1) : ''));
  $initials = strlen($initials) > 2 ? substr($initials, 0, 2) : $initials;

  $navItems = [
      [
          'route' => 'admin.dashboard',
          'match' => 'admin.dashboard',
          'label' => __('Overview'),
          'icon' => 'M4 5a1 1 0 011-1h4a1 1 0 011 1v4a1 1 0 01-1 1H5a1 1 0 01-1-1V5zM14 5a1 1 0 011-1h4a1 1 0 011 1v4a1 1 0 01-1 1h-4a1 1 0 01-1-1V5zM4 15a1 1 0 011-1h4a1 1 0 011 1v4a1 1 0 01-1 1H5a1 1 0 01-1-1v-4zM14 15a1 1 0 011-1h4a1 1 0 011 1v4a1 1 0 01-1 1h-4a1 1 0 01-1-1v-4z',
      ],
      [
          'route' => 'dashboard.vehicles.index',
          'match' => 'dashboard.vehicles.*',
          'label' => __('All listings'),
          'icon' => 'M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10',
      ],
      [
          'route' => 'admin.users.index',
          'match' => 'admin.users.*',
          'label' => __('Users & vendors'),
          'icon' => 'M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z',
      ],
      [
          'route' => 'admin.pages.index',
          'match' => 'admin.pages.*',
          'label' => __('Pages'),
          'icon' => 'M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z',
      ],
      [
          'route' => 'admin.media.index',
          'match' => 'admin.media.*',
          'label' => __('Media'),
          'icon' => 'M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z',
      ],
  ];
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
    <style>[x-cloak]{display:none!important}</style>
    @include('partials.vite-assets')
  </head>
  <body
    class="antialiased text-slate-900"
    style="font-family: Inter, ui-sans-serif, system-ui, sans-serif;"
    x-data="{
      sidebarCompact: (() => { try { return localStorage.getItem('mt_admin_sb') === '1'; } catch (e) { return false; } })(),
      mobileOpen: false,
      toggleSidebar() {
        this.sidebarCompact = !this.sidebarCompact;
        try { localStorage.setItem('mt_admin_sb', this.sidebarCompact ? '1' : '0'); } catch (e) {}
      },
    }"
  >
    <div class="flex min-h-screen flex-col bg-[#f2f4f7] lg:flex-row">
      {{-- Mobile overlay --}}
      <div
        class="fixed inset-0 z-40 bg-slate-900/40 backdrop-blur-sm lg:hidden"
        x-show="mobileOpen"
        x-cloak
        x-transition.opacity
        @click="mobileOpen = false"
      ></div>

      <aside
        class="fixed inset-y-0 left-0 z-50 flex h-full max-h-[100dvh] w-64 min-w-0 flex-col border-r border-slate-200 bg-white shadow-sm transition-[width] duration-200 ease-out lg:static lg:max-h-none lg:translate-x-0"
        :class="[
          mobileOpen ? 'translate-x-0' : '-translate-x-full lg:translate-x-0',
          sidebarCompact ? 'lg:w-[4.25rem]' : 'lg:w-64',
        ]"
      >
        {{-- Brand row --}}
        <div class="flex h-14 shrink-0 items-center gap-2 border-b border-slate-200 px-3">
          <a
            href="{{ route('admin.dashboard') }}"
            class="flex min-w-0 flex-1 items-center gap-2.5 overflow-hidden rounded-lg py-1.5 pl-0.5 hover:bg-slate-50"
            @click="mobileOpen = false"
            title="{{ $brandName }}"
          >
            @if (!empty($logoPath))
              <img src="{{ \App\Support\VehicleImageUrl::url($logoPath) }}" alt="" class="h-8 w-8 shrink-0 rounded-md object-contain" />
            @else
              <span class="flex h-8 w-8 shrink-0 items-center justify-center rounded-md bg-amber-400 text-xs font-bold text-slate-900">{{ strtoupper(\Illuminate\Support\Str::substr($brandName, 0, 1)) }}</span>
            @endif
            <span class="truncate text-sm font-semibold text-slate-900" x-show="!sidebarCompact">{{ $brandName }}</span>
          </a>
          <button
            type="button"
            class="hidden shrink-0 rounded-md p-2 text-slate-500 hover:bg-slate-100 hover:text-slate-800 lg:inline-flex"
            @click="toggleSidebar()"
            title="{{ __('Toggle sidebar width') }}"
          >
            <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 16h7"/>
            </svg>
          </button>
          <button type="button" class="rounded-md p-2 text-slate-500 hover:bg-slate-100 lg:hidden" @click="mobileOpen = false" aria-label="{{ __('Close menu') }}">
            <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg>
          </button>
        </div>

        {{-- Scrollable nav (min-h-0 fixes flex overflow) --}}
        <nav class="min-h-0 flex-1 space-y-1 overflow-y-auto overflow-x-hidden p-2 text-[13px] font-medium leading-snug" aria-label="{{ __('Admin navigation') }}">
          @foreach ($navItems as $item)
            @php $active = request()->routeIs($item['match']); @endphp
            <a
              href="{{ route($item['route']) }}"
              @click="mobileOpen = false"
              title="{{ $item['label'] }}"
              class="flex items-center gap-3 rounded-lg px-2.5 py-2.5 transition-colors {{ $active ? 'bg-amber-50 text-slate-900 shadow-sm ring-1 ring-amber-200/80' : 'text-slate-600 hover:bg-slate-100 hover:text-slate-900' }}"
              :class="sidebarCompact ? 'justify-center px-2' : ''"
            >
              <svg class="h-5 w-5 shrink-0 {{ $active ? 'text-amber-700' : 'text-slate-400' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="{{ $item['icon'] }}"/>
              </svg>
              <span class="min-w-0 flex-1 truncate" x-show="!sidebarCompact">{{ $item['label'] }}</span>
            </a>
          @endforeach

          <div class="my-2 border-t border-slate-100 pt-2" role="separator"></div>

          <a
            href="{{ route('inventory.index') }}"
            target="_blank"
            rel="noopener noreferrer"
            @click="mobileOpen = false"
            title="{{ __('Public site') }}"
            class="flex items-center gap-3 rounded-lg px-2.5 py-2.5 text-slate-500 transition-colors hover:bg-slate-100 hover:text-slate-800"
            :class="sidebarCompact ? 'justify-center px-2' : ''"
          >
            <svg class="h-5 w-5 shrink-0 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14"/>
            </svg>
            <span class="min-w-0 flex-1 truncate" x-show="!sidebarCompact">{{ __('Public site') }}</span>
          </a>
        </nav>

        {{-- User --}}
        <div class="shrink-0 border-t border-slate-200 bg-slate-50 p-2">
          <div class="flex items-center gap-2.5 rounded-lg p-1.5" :class="sidebarCompact ? 'flex-col' : ''">
            <div class="flex h-10 w-10 shrink-0 items-center justify-center rounded-full bg-slate-200 text-[11px] font-bold uppercase text-slate-700" title="{{ $user->name }}">
              {{ $initials }}
            </div>
            <div class="min-w-0 flex-1" x-show="!sidebarCompact">
              <div class="truncate text-sm font-semibold text-slate-900">{{ $user->name }}</div>
              <div class="truncate text-xs text-slate-500">{{ $user->email }}</div>
            </div>
          </div>
          <div class="mt-2 grid grid-cols-2 gap-1.5" x-show="!sidebarCompact">
            <a href="{{ route('profile.edit') }}" @click="mobileOpen = false" class="rounded-md border border-slate-200 bg-white px-2 py-2 text-center text-xs font-semibold text-slate-700 hover:bg-white hover:ring-1 hover:ring-slate-200">{{ __('Profile') }}</a>
            <form method="POST" action="{{ route('logout') }}" class="contents">
              @csrf
              <button type="submit" class="rounded-md border border-rose-200/80 bg-white px-2 py-2 text-xs font-semibold text-rose-700 hover:bg-rose-50">{{ __('Log out') }}</button>
            </form>
          </div>
          <div class="mt-1 flex flex-col gap-0.5" x-show="sidebarCompact" x-cloak>
            <a href="{{ route('profile.edit') }}" class="flex justify-center rounded-md py-2 text-slate-600 hover:bg-white" title="{{ __('Profile') }}">
              <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/></svg>
            </a>
            <form method="POST" action="{{ route('logout') }}">
              @csrf
              <button type="submit" class="flex w-full justify-center rounded-md py-2 text-rose-600 hover:bg-white" title="{{ __('Log out') }}">
                <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"/></svg>
              </button>
            </form>
          </div>
        </div>
      </aside>

      <div class="flex min-h-0 min-w-0 flex-1 flex-col">
        <header class="sticky top-0 z-30 flex h-14 shrink-0 items-center gap-3 border-b border-slate-200 bg-white px-4 shadow-sm sm:px-6">
          <button type="button" class="inline-flex rounded-md border border-slate-200 bg-white p-2 text-slate-600 hover:bg-slate-50 lg:hidden" @click="mobileOpen = true" aria-label="{{ __('Open menu') }}">
            <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"/></svg>
          </button>
          <div class="min-w-0 flex-1">
            @isset($header)
              <div class="text-slate-900">{{ $header }}</div>
            @else
              <span class="truncate text-base font-semibold text-slate-900">{{ $brandName }}</span>
            @endif
          </div>
        </header>

        <main class="min-h-0 flex-1">
          {{ $slot }}
        </main>
      </div>
    </div>
  </body>
</html>
