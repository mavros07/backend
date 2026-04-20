@php
  $site = $site ?? [];
  $brandName = config('app.name', 'Console');
  $logoPath = $site['logo_path'] ?? $site['logo_url'] ?? null;
  $user = Auth::user();
  $n = trim((string) ($user->name ?? 'User'));
  $initials = strtoupper(substr($n, 0, 1).(str_contains($n, ' ') ? substr($n, (int) strrpos($n, ' ') + 1, 1) : ''));
  $initials = strlen($initials) > 2 ? substr($initials, 0, 2) : $initials;

  $navItems = [
      ['route' => 'admin.dashboard', 'match' => 'admin.dashboard', 'label' => __('Overview'), 'icon' => 'M4 5a1 1 0 011-1h4a1 1 0 011 1v4a1 1 0 01-1 1H5a1 1 0 01-1-1V5zM14 5a1 1 0 011-1h4a1 1 0 011 1v4a1 1 0 01-1 1h-4a1 1 0 01-1-1V5zM4 15a1 1 0 011-1h4a1 1 0 011 1v4a1 1 0 01-1 1H5a1 1 0 01-1-1v-4zM14 15a1 1 0 011-1h4a1 1 0 011 1v4a1 1 0 01-1 1h-4a1 1 0 01-1-1v-4z'],
      ['route' => 'dashboard.vehicles.index', 'match' => 'dashboard.vehicles.*', 'label' => __('All listings'), 'icon' => 'M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10'],
      ['route' => 'admin.users.index', 'match' => 'admin.users.*', 'label' => __('Users & vendors'), 'icon' => 'M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z'],
      ['route' => 'admin.pages.index', 'match' => 'admin.pages.*', 'label' => __('Pages'), 'icon' => 'M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z'],
      ['route' => 'admin.media.index', 'match' => 'admin.media.*', 'label' => __('Media'), 'icon' => 'M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z'],
  ];
@endphp
<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="h-full">
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
    class="h-full antialiased bg-zinc-100 text-zinc-900"
    style="font-family:Inter,system-ui,sans-serif"
    x-data="{
      /** Mobile drawer */
      drawerOpen: false,
      /** Desktop: false = full width sidebar (16rem), true = icon rail (~4.5rem) */
      railMode: (() => { try { return localStorage.getItem('mt_admin_rail') === '1'; } catch (e) { return false; } })(),
      openDrawer() { this.drawerOpen = true; document.body.classList.add('overflow-hidden'); },
      closeDrawer() { this.drawerOpen = false; document.body.classList.remove('overflow-hidden'); },
      toggleRail() {
        this.railMode = !this.railMode;
        try { localStorage.setItem('mt_admin_rail', this.railMode ? '1' : '0'); } catch (e) {}
      },
    }"
    @keydown.escape.window="closeDrawer()"
    @resize.window="if (window.innerWidth >= 1024) closeDrawer()"
  >
    {{-- Mobile overlay --}}
    <div
      class="fixed inset-0 z-[90] bg-black/60 backdrop-blur-[2px] transition-opacity lg:hidden"
      x-show="drawerOpen"
      x-cloak
      x-transition.opacity.duration.200ms
      @click="closeDrawer()"
      aria-hidden="true"
    ></div>

    <div class="flex min-h-full min-h-[100dvh] w-full max-w-[100vw] overflow-x-hidden lg:min-h-screen">
      {{--
        Sidebar: MOBILE = fixed drawer | DESKTOP = in-flow (relative) so it NEVER covers main content.
        Critical: lg:relative lg:shrink-0 — not position:fixed on large screens.
      --}}
      <aside
        class="fixed inset-y-0 left-0 z-[100] flex h-[100dvh] max-h-[100dvh] w-[min(18rem,calc(100vw-3rem))] flex-col overflow-hidden border-r border-white/10 bg-[#0a0d12] shadow-2xl transition-[transform,width] duration-300 ease-out lg:relative lg:z-0 lg:h-screen lg:max-h-none lg:shrink-0 lg:shadow-none"
        :class="[
          drawerOpen ? 'translate-x-0' : '-translate-x-full lg:translate-x-0',
          railMode ? 'lg:w-[4.5rem]' : 'lg:w-64',
        ]"
      >
        {{-- Brand --}}
        <div class="flex h-16 shrink-0 items-center gap-2 border-b border-white/10 px-4">
          <a href="{{ route('admin.dashboard') }}" class="flex min-w-0 flex-1 items-center gap-3" @click="closeDrawer()">
            @if (!empty($logoPath))
              <img src="{{ \App\Support\VehicleImageUrl::url($logoPath) }}" alt="" class="h-9 w-9 shrink-0 rounded-lg object-contain ring-1 ring-white/10" />
            @else
              <span class="flex h-9 w-9 shrink-0 items-center justify-center rounded-lg bg-gradient-to-br from-amber-400 to-amber-600 text-sm font-bold text-zinc-900 shadow-lg shadow-amber-500/20">{{ strtoupper(\Illuminate\Support\Str::substr($brandName, 0, 1)) }}</span>
            @endif
            <div class="min-w-0" x-show="!railMode" x-cloak>
              <div class="truncate text-sm font-bold tracking-tight text-white">{{ $brandName }}</div>
              <div class="truncate text-[10px] font-semibold uppercase tracking-[0.2em] text-zinc-500">{{ __('Dealer console') }}</div>
            </div>
          </a>
          <button
            type="button"
            class="hidden h-10 w-10 shrink-0 items-center justify-center rounded-lg text-zinc-400 transition hover:bg-white/5 hover:text-white lg:flex"
            @click="toggleRail()"
            :title="railMode ? '{{ __('Expand menu') }}' : '{{ __('Collapse to icons') }}'"
          >
            <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 19l-7-7 7-7m8 14l-7-7 7-7"/>
            </svg>
          </button>
          <button type="button" class="flex h-10 w-10 shrink-0 items-center justify-center rounded-lg text-zinc-400 hover:bg-white/5 hover:text-white lg:hidden" @click="closeDrawer()" aria-label="{{ __('Close') }}">
            <svg class="h-6 w-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg>
          </button>
        </div>

        <nav class="min-h-0 flex-1 space-y-1 overflow-y-auto overflow-x-hidden px-3 py-4" aria-label="{{ __('Admin') }}">
          @foreach ($navItems as $item)
            @php $active = request()->routeIs($item['match']); @endphp
            <a
              href="{{ route($item['route']) }}"
              @click="closeDrawer()"
              title="{{ $item['label'] }}"
              class="group flex items-center gap-3 rounded-xl border-l-[3px] py-3 pl-2 pr-3 text-[13px] font-semibold transition-all {{ $active ? 'border-amber-400 bg-amber-500/15 text-amber-300' : 'border-transparent text-zinc-400 hover:bg-white/[0.06] hover:text-white' }}"
              :class="railMode ? 'justify-center px-2' : ''"
            >
              <svg class="h-5 w-5 shrink-0 {{ $active ? 'text-amber-400' : 'text-zinc-500 group-hover:text-zinc-300' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="{{ $item['icon'] }}"/>
              </svg>
              <span class="min-w-0 flex-1 truncate" x-show="!railMode">{{ $item['label'] }}</span>
            </a>
          @endforeach

          <div class="my-4 border-t border-white/10"></div>

          <a
            href="{{ route('inventory.index') }}"
            target="_blank"
            rel="noopener noreferrer"
            @click="closeDrawer()"
            class="flex items-center gap-3 rounded-xl px-3 py-3 text-[13px] font-semibold text-zinc-500 transition hover:bg-white/[0.06] hover:text-white"
            :class="railMode ? 'justify-center' : ''"
            title="{{ __('Public site') }}"
          >
            <svg class="h-5 w-5 shrink-0 text-zinc-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14"/>
            </svg>
            <span class="truncate" x-show="!railMode">{{ __('Public site') }}</span>
          </a>
        </nav>

        <div class="shrink-0 border-t border-white/10 bg-black/20 p-4">
          <div class="flex items-center gap-3" :class="railMode ? 'flex-col' : ''">
            <div class="flex h-11 w-11 shrink-0 items-center justify-center rounded-full bg-gradient-to-br from-zinc-700 to-zinc-800 text-[11px] font-bold uppercase tracking-wide text-amber-400 ring-2 ring-white/10">
              {{ $initials }}
            </div>
            <div class="min-w-0 flex-1" x-show="!railMode" x-cloak>
              <p class="truncate text-sm font-semibold text-white">{{ $user->name }}</p>
              <p class="truncate text-xs text-zinc-500">{{ $user->email }}</p>
            </div>
          </div>
          <div class="mt-3 grid grid-cols-2 gap-2" x-show="!railMode" x-cloak>
            <a href="{{ route('profile.edit') }}" @click="closeDrawer()" class="rounded-lg bg-white/5 py-2.5 text-center text-xs font-bold text-white ring-1 ring-white/10 transition hover:bg-white/10">{{ __('Profile') }}</a>
            <form method="POST" action="{{ route('logout') }}" class="contents">
              @csrf
              <button type="submit" class="rounded-lg bg-red-500/10 py-2.5 text-xs font-bold text-red-400 ring-1 ring-red-400/30 transition hover:bg-red-500/20">{{ __('Log out') }}</button>
            </form>
          </div>
          <div class="mt-2 flex flex-col gap-1" x-show="railMode" x-cloak>
            <a href="{{ route('profile.edit') }}" class="flex justify-center rounded-lg py-2 text-zinc-400 hover:text-white" title="{{ __('Profile') }}">
              <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/></svg>
            </a>
            <form method="POST" action="{{ route('logout') }}">
              @csrf
              <button type="submit" class="flex w-full justify-center rounded-lg py-2 text-red-400 hover:text-red-300" title="{{ __('Log out') }}">
                <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"/></svg>
              </button>
            </form>
          </div>
        </div>
      </aside>

      {{-- Main column: always full remaining width; never sits under sidebar on lg+ --}}
      <div class="flex min-w-0 flex-1 flex-col lg:min-h-screen">
        <header class="sticky top-0 z-40 flex h-16 shrink-0 items-center gap-4 border-b border-zinc-200/80 bg-white/95 px-4 shadow-sm backdrop-blur-md sm:px-6 lg:px-8">
          <button
            type="button"
            class="inline-flex h-11 w-11 shrink-0 items-center justify-center rounded-xl border border-zinc-200 bg-white text-zinc-700 shadow-sm transition hover:bg-zinc-50 lg:hidden"
            @click="openDrawer()"
            aria-label="{{ __('Menu') }}"
          >
            <svg class="h-6 w-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"/></svg>
          </button>
          <div class="min-w-0 flex-1">
            @isset($header)
              <div class="text-zinc-900">{{ $header }}</div>
            @else
              <p class="truncate text-lg font-bold tracking-tight text-zinc-900">{{ $brandName }}</p>
              <p class="truncate text-xs font-medium uppercase tracking-wider text-zinc-500">{{ __('Signed in') }} · {{ $user->email }}</p>
            @endif
          </div>
        </header>

        <main class="flex-1 bg-gradient-to-b from-zinc-100 to-zinc-50">
          <div class="mx-auto max-w-[1600px] px-4 py-8 sm:px-6 lg:px-10">
            {{ $slot }}
          </div>
        </main>
      </div>
    </div>

  </body>
</html>
