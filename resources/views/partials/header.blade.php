@php
  $site = $site ?? [];
  $currencyUi = $currencyUi ?? ['default' => 'USD', 'selected' => 'USD', 'supported' => ['USD' => 'US Dollar'], 'symbols' => ['USD' => '$']];
  $brandName = ! empty(trim((string) ($site['site_display_name'] ?? ''))) ? trim((string) $site['site_display_name']) : config('app.name', 'Site');
  $logoPath = $site['logo_path'] ?? $site['logo_url'] ?? null;
  $hoursLabel = trim((string) ($site['dealer_hours_label'] ?? '')) ?: __('Work Hours');
  $hoursLines = preg_split('/\r\n|\r|\n/', (string) ($site['dealer_sales_hours'] ?? '')) ?: [];
  $hoursSnippet = trim((string) ($hoursLines[0] ?? ''));
  $address = trim((string) ($site['dealer_address'] ?? ''));
  $phone = trim((string) ($site['dealer_phone'] ?? ''));
  if ($phone === '') {
      $phone = trim((string) ($site['dealer_sales_phone'] ?? ''));
  }
  $currencyCode = strtoupper((string) ($currencyUi['selected'] ?? 'USD'));
  $currencySymbols = is_array($currencyUi['symbols'] ?? null) ? $currencyUi['symbols'] : ['USD' => '$'];
  $currencyLabel = __('Currency') . ' (' . $currencyCode . ')';
  $socialFacebook = trim((string) ($site['social_facebook'] ?? ''));
  $socialInstagram = trim((string) ($site['social_instagram'] ?? ''));
  $socialLinkedin = trim((string) ($site['social_linkedin'] ?? ''));
  $socialYoutube = trim((string) ($site['social_youtube'] ?? ''));
  $compareCount = \App\Support\Compare::count();
  $isHome = request()->routeIs('home') || request()->routeIs('faq') || request()->routeIs('about');
  $inventoryUrl = route('inventory.index');
  $inventoryNigeriaUrl = route('inventory.index', ['q' => 'Nigeria']);
  $inventoryForeignUrl = route('inventory.index', ['q' => 'United States']);
  $inventoryActive = request()->routeIs('inventory.index');
  $qRaw = strtolower((string) request('q', ''));
  $inventoryMegaActive = $inventoryActive && $qRaw === '';
  $nigeriaActive = $inventoryActive && str_contains($qRaw, 'nigeria');
  $foreignActive = $inventoryActive && str_contains($qRaw, 'united states');
@endphp

{{-- Motors dealer-two inspired public header: https://motors.stylemixthemes.com/elementor-dealer-two/ --}}
<header class="{{ $isHome ? 'fixed inset-x-0 top-0 is-home-header' : 'sticky top-0' }} z-50 shadow-[0_6px_20px_rgba(0,0,0,0.16)]" data-site-header>
  @if ($isHome)
    <style>
      [data-site-header].is-home-header { box-shadow: none; }
      [data-site-header].is-home-header [data-site-header-main] { background-color: transparent; border-color: transparent; }
      [data-site-header].is-home-header.is-scrolled { box-shadow: 0 6px 20px rgba(0, 0, 0, 0.14); }
      [data-site-header].is-home-header.is-scrolled [data-site-header-main] { background-color: rgba(255, 255, 255, 0.74); border-color: rgba(15, 23, 42, 0.16); backdrop-filter: blur(10px); }
      [data-site-header].is-home-header.is-scrolled [data-header-logo],
      [data-site-header].is-home-header.is-scrolled [data-header-icon],
      [data-site-header].is-home-header.is-scrolled [data-header-action-text],
      [data-site-header].is-home-header.is-scrolled [data-header-menu-icon] { color: #111827 !important; }
      [data-site-header].is-home-header.is-scrolled [data-header-nav-link] { color: rgba(17, 24, 39, 0.92) !important; }
      [data-site-header].is-home-header.is-scrolled [data-header-nav-link]:hover { color: #111827 !important; }
      [data-site-header].is-home-header.is-scrolled [data-header-menu-button],
      [data-site-header].is-home-header.is-scrolled [data-header-account-link] { border-color: rgba(15, 23, 42, 0.2) !important; }
      [data-site-header].is-home-header.is-scrolled [data-header-account-link] { color: #111827 !important; background-color: rgba(255, 255, 255, 0.35) !important; }
    </style>
  @endif
  @if (request()->routeIs('about'))
    <style>
      [data-site-header].is-home-header [data-header-logo],
      [data-site-header].is-home-header [data-header-icon],
      [data-site-header].is-home-header [data-header-action-text],
      [data-site-header].is-home-header [data-header-menu-icon] { color: #111827 !important; }
      [data-site-header].is-home-header [data-header-nav-link] { color: rgba(17, 24, 39, 0.92) !important; }
      [data-site-header].is-home-header [data-header-nav-link]:hover { color: #111827 !important; }
      [data-site-header].is-home-header [data-header-menu-button],
      [data-site-header].is-home-header [data-header-account-link] { border-color: rgba(15, 23, 42, 0.2) !important; }
      [data-site-header].is-home-header [data-header-account-link] { color: #111827 !important; background-color: rgba(255, 255, 255, 0.28) !important; }
    </style>
  @endif
  <div class="h-10 border-b border-white/10 bg-[#232628]">
    <div class="mx-auto flex h-full w-full max-w-[1280px] items-center justify-between px-4 sm:px-6 lg:px-8">
      <div class="relative">
        <button type="button" class="inline-flex items-center gap-1 text-[11px] font-bold uppercase tracking-[0.05em] text-white/70 hover:text-white" data-currency-toggle>
          <span data-currency-label>{{ $currencyLabel }}</span>
          <span class="material-symbols-outlined text-[16px]">keyboard_arrow_down</span>
        </button>
        <div class="absolute left-0 top-full z-30 mt-2 hidden min-w-[200px] rounded-md border border-white/10 bg-[#181b1f] p-2 shadow-xl" data-currency-menu>
          @foreach (($currencyUi['supported'] ?? ['USD' => 'US Dollar']) as $code => $name)
            <button type="button" class="block w-full rounded px-3 py-2 text-left text-[11px] font-semibold uppercase tracking-wide text-white/80 hover:bg-white/10 hover:text-white" data-currency-option="{{ $code }}">
              {{ $code }} - {{ $name }}
            </button>
          @endforeach
        </div>
      </div>

      <div class="hidden xl:flex items-center gap-6 text-[11px] font-semibold tracking-[0.01em] text-white/90">
        @if ($phone !== '')
          <a href="tel:{{ preg_replace('/[^\d+]/', '', $phone) }}" class="inline-flex items-center gap-1.5 text-white/90 hover:text-white">
            <span class="material-symbols-outlined text-[17px] text-[#1280DF]">call</span>
            <span>{{ $phone }}</span>
          </a>
        @endif
        @if ($address !== '')
          <span class="inline-flex min-w-0 items-center gap-1.5 text-white/80">
            <span class="material-symbols-outlined text-[17px] text-[#1280DF]">location_on</span>
            <span class="truncate max-w-[370px]">{{ $address }}</span>
          </span>
        @endif
        @if ($hoursSnippet !== '')
          <span class="inline-flex items-center gap-1.5 text-white/90">
            <span class="material-symbols-outlined text-[17px] text-[#1280DF]">schedule</span>
            <span>{{ $hoursLabel }}</span>
          </span>
        @endif
      </div>

      <div class="flex items-center gap-2.5">
        @foreach (['facebook' => $socialFacebook, 'instagram' => $socialInstagram, 'linkedin' => $socialLinkedin, 'youtube' => $socialYoutube] as $net => $url)
          @if (!empty($url) && $url !== '#')
            <a href="{{ $url }}" target="_blank" rel="noopener noreferrer" class="inline-flex h-7 w-7 items-center justify-center text-white/60 transition-colors hover:text-white" aria-label="{{ ucfirst($net) }}">
              <span class="material-symbols-outlined text-[18px]">
                @if ($net === 'facebook')
                  thumb_up
                @elseif ($net === 'instagram')
                  photo_camera
                @elseif ($net === 'linkedin')
                  group
                @else
                  smart_display
                @endif
              </span>
            </a>
          @endif
        @endforeach
      </div>
    </div>
  </div>

  <div class="h-[90px] transition-all duration-300 {{ $isHome ? 'border-b border-transparent bg-transparent' : 'border-b border-white/10 bg-[#232628]' }}" data-site-header-main>
    <div class="relative mx-auto flex h-full w-full max-w-[1280px] items-center justify-between px-4 sm:px-6 lg:px-8">
      <a href="{{ route('home') }}" class="relative z-20 flex min-w-0 shrink items-center xl:min-w-[10rem]">
        @if (!empty($logoPath))
          <img src="{{ \App\Support\VehicleImageUrl::url($logoPath) }}" alt="{{ $brandName }}" class="h-9 w-auto max-w-[160px] object-contain sm:h-10" />
        @else
          <span data-header-logo class="block max-w-[min(68vw,17rem)] truncate font-headline text-[26px] font-black italic leading-none tracking-tight text-white sm:max-w-[22rem] sm:text-[32px] lg:max-w-none lg:text-[36px]">{{ strtolower($brandName) }}</span>
        @endif
      </a>

      <nav class="pointer-events-none absolute left-1/2 top-1/2 z-10 hidden -translate-x-1/2 -translate-y-1/2 items-center justify-center gap-4 xl:flex xl:px-2 w-max" aria-label="{{ __('Primary') }}">
        <a href="{{ route('home') }}" data-header-nav-link class="pointer-events-auto inline-flex items-center border-b-2 pb-1.5 text-[13px] font-extrabold uppercase leading-none tracking-[0.07em] transition-colors whitespace-nowrap {{ request()->routeIs('home') ? 'border-[#1280DF] text-white' : 'border-transparent text-white/85 hover:text-[#1280DF]' }}">{{ __('Home') }}</a>

        {{-- Inventory mega dropdown (Nigerian / Foreign live under here) --}}
        <div class="pointer-events-auto relative flex items-end" data-header-inventory-dropdown>
          <a href="{{ $inventoryUrl }}" data-header-inventory-trigger data-header-nav-link class="inline-flex items-center gap-0.5 border-b-2 pb-1.5 text-[13px] font-extrabold uppercase leading-none tracking-[0.07em] transition-colors whitespace-nowrap {{ $inventoryActive ? 'border-[#1280DF] text-white' : 'border-transparent text-white/85 hover:text-[#1280DF]' }}" aria-expanded="false" aria-haspopup="true">
            <span>{{ __('Inventory') }}</span>
            <span class="material-symbols-outlined text-[18px] leading-none text-inherit" aria-hidden="true">expand_more</span>
          </a>
          <div class="absolute left-1/2 top-full z-[60] hidden w-max -translate-x-1/2 pt-2" data-header-inventory-panel role="region" aria-label="{{ __('Inventory categories') }}">
            <div class="w-[min(22rem,calc(100vw-2rem))] overflow-hidden rounded-xl border border-white/15 bg-[#191c1e]/95 shadow-2xl shadow-black/40 backdrop-blur-xl ring-1 ring-white/5">
              <div class="grid gap-px bg-white/10 p-px">
                <a href="{{ $inventoryUrl }}" class="group flex items-start justify-between gap-3 bg-[#232628] px-4 py-3 transition hover:bg-white/[0.06] {{ $inventoryMegaActive ? 'ring-1 ring-inset ring-[#1280DF]/50' : '' }}">
                  <div>
                    <span class="text-[13px] font-bold uppercase tracking-[0.06em] text-white group-hover:text-[#1280DF]">{{ __('All inventory') }}</span>
                    <p class="mt-1 text-xs font-medium text-white/50">{{ __('Browse every available vehicle.') }}</p>
                  </div>
                  <span class="material-symbols-outlined shrink-0 text-lg text-[#1280DF]/60 transition group-hover:translate-x-0.5 group-hover:text-[#1280DF]">chevron_right</span>
                </a>
                <a href="{{ $inventoryNigeriaUrl }}" class="group flex items-start justify-between gap-3 bg-[#232628] px-4 py-3 transition hover:bg-white/[0.06] {{ $nigeriaActive ? 'ring-1 ring-inset ring-[#1280DF]/50' : '' }}">
                  <div>
                    <span class="text-[13px] font-bold uppercase tracking-[0.06em] text-white group-hover:text-[#1280DF]">{{ __('Nigerian Used') }}</span>
                    <p class="mt-1 text-xs font-medium text-white/50">{{ __('Locally sourced Nigerian-used listings.') }}</p>
                  </div>
                  <span class="material-symbols-outlined shrink-0 text-lg text-[#1280DF]/60 transition group-hover:translate-x-0.5 group-hover:text-[#1280DF]">chevron_right</span>
                </a>
                <a href="{{ $inventoryForeignUrl }}" class="group flex items-start justify-between gap-3 bg-[#232628] px-4 py-3 transition hover:bg-white/[0.06] {{ $foreignActive ? 'ring-1 ring-inset ring-[#1280DF]/50' : '' }}">
                  <div>
                    <span class="text-[13px] font-bold uppercase tracking-[0.06em] text-white group-hover:text-[#1280DF]">{{ __('Foreign Used') }}</span>
                    <p class="mt-1 text-xs font-medium text-white/50">{{ __('Foreign-used imports and international stock.') }}</p>
                  </div>
                  <span class="material-symbols-outlined shrink-0 text-lg text-[#1280DF]/60 transition group-hover:translate-x-0.5 group-hover:text-[#1280DF]">chevron_right</span>
                </a>
              </div>
              <div class="border-t border-white/10 bg-white/[0.04] px-4 py-3">
                <a href="{{ $inventoryUrl }}" class="inline-flex items-center gap-1 text-[12px] font-extrabold uppercase tracking-[0.08em] text-[#1280DF] hover:text-white">{{ __('View full inventory') }}<span class="material-symbols-outlined text-base">arrow_forward</span></a>
              </div>
            </div>
          </div>
        </div>

        <a href="{{ route('about') }}" data-header-nav-link class="pointer-events-auto inline-flex items-center border-b-2 pb-1.5 text-[13px] font-extrabold uppercase leading-none tracking-[0.07em] transition-colors whitespace-nowrap {{ request()->routeIs('about') ? 'border-[#1280DF] text-white' : 'border-transparent text-white/85 hover:text-[#1280DF]' }}">{{ __('About') }}</a>
        <a href="{{ route('faq') }}" data-header-nav-link class="pointer-events-auto inline-flex items-center border-b-2 pb-1.5 text-[13px] font-extrabold uppercase leading-none tracking-[0.07em] transition-colors whitespace-nowrap {{ request()->routeIs('faq') ? 'border-[#1280DF] text-white' : 'border-transparent text-white/85 hover:text-[#1280DF]' }}">{{ __('FAQ') }}</a>
        <a href="{{ route('contact') }}" data-header-nav-link class="pointer-events-auto inline-flex items-center border-b-2 pb-1.5 text-[13px] font-extrabold uppercase leading-none tracking-[0.07em] transition-colors whitespace-nowrap {{ request()->routeIs('contact') ? 'border-[#1280DF] text-white' : 'border-transparent text-white/85 hover:text-[#1280DF]' }}">{{ __('Contact') }}</a>
      </nav>

      <div class="relative z-20 flex shrink-0 items-center justify-end gap-2 sm:gap-4">
        {{-- Compare + My account: desktop xl+ only (mobile finds them inside the sidebar after nav links). --}}
        <a href="{{ route('compare') }}" class="group hidden items-center gap-2 xl:inline-flex" title="{{ __('Compare vehicles') }}">
          <span data-header-action-text class="hidden text-[11px] font-extrabold uppercase tracking-[0.06em] text-white transition-colors group-hover:text-[#1280DF] xl:inline">{{ __('Compare') }}</span>
          <span class="relative ml-0 inline-flex">
            <span data-header-icon class="material-symbols-outlined text-[24px] text-white transition-colors group-hover:text-[#1280DF] xl:text-[24px]">speed</span>
            <span class="absolute -right-1 -top-1 inline-flex h-4 min-w-4 items-center justify-center rounded-full bg-[#1280DF] px-1 text-[10px] font-extrabold text-white">{{ $compareCount }}</span>
          </span>
        </a>

        @php
          $myAccountUrl = auth()->check() ? route('dashboard') : route('login');
        @endphp
        <a href="{{ $myAccountUrl }}" data-header-account-link class="hidden h-9 items-center justify-center rounded border border-white/15 bg-white/[0.06] px-3.5 text-center text-[13px] font-extrabold uppercase leading-none tracking-[0.07em] text-white/90 shadow-none backdrop-blur-sm transition hover:bg-white/10 xl:inline-flex" title="{{ __('My account') }}">
          {{ __('My account') }}
        </a>

        <button data-header-menu-button class="inline-flex h-11 w-11 items-center justify-center rounded border border-white/15 text-white hover:bg-white/10 xl:hidden" type="button" data-mobile-menu-toggle aria-label="{{ __('Menu') }}">
          <span data-header-menu-icon class="material-symbols-outlined text-2xl">menu</span>
        </button>
      </div>
    </div>
  </div>
</header>

<div class="fixed inset-0 z-[55] hidden bg-black/55 xl:hidden" data-mobile-menu-overlay aria-hidden="true"></div>
<div class="fixed right-0 top-0 z-[60] flex h-full w-[min(22rem,calc(100vw-2rem))] translate-x-full flex-col bg-[#232628] shadow-2xl transition-transform duration-200 ease-out xl:hidden" data-mobile-menu-panel id="site-mobile-nav">
  <div class="flex h-16 shrink-0 items-center justify-between border-b border-white/10 px-4">
    <span class="font-headline text-lg font-black italic text-white">{{ strtolower($brandName) }}</span>
    <button type="button" class="inline-flex h-10 w-10 items-center justify-center rounded-md text-white/80 hover:bg-white/10 hover:text-white" data-mobile-menu-close aria-label="{{ __('Close') }}">
      <span class="material-symbols-outlined text-2xl">close</span>
    </button>
  </div>
  <nav class="flex flex-1 flex-col gap-1 overflow-y-auto px-4 py-4" aria-label="{{ __('Mobile') }}">
    <a href="{{ route('home') }}" class="rounded-sm px-3 py-3 text-sm font-bold uppercase tracking-[0.06em] text-white/90 transition hover:bg-white/10 hover:text-white">{{ __('Home') }}</a>
    <div class="rounded-sm border border-white/10 bg-white/[0.03] px-2 py-2">
      <a href="{{ $inventoryUrl }}" class="block px-2 py-2 text-sm font-bold uppercase tracking-[0.06em] text-white transition hover:bg-white/10">{{ __('Inventory') }}</a>
      <a href="{{ $inventoryNigeriaUrl }}" class="block px-4 py-2 text-xs font-bold uppercase tracking-[0.06em] text-white/75 transition hover:bg-white/10 hover:text-white">{{ __('Nigerian Used') }}</a>
      <a href="{{ $inventoryForeignUrl }}" class="block px-4 py-2 text-xs font-bold uppercase tracking-[0.06em] text-white/75 transition hover:bg-white/10 hover:text-white">{{ __('Foreign Used') }}</a>
    </div>
    <a href="{{ route('about') }}" class="rounded-sm px-3 py-3 text-sm font-bold uppercase tracking-[0.06em] text-white/90 transition hover:bg-white/10 hover:text-white">{{ __('About') }}</a>
    <a href="{{ route('faq') }}" class="rounded-sm px-3 py-3 text-sm font-bold uppercase tracking-[0.06em] text-white/90 transition hover:bg-white/10 hover:text-white">{{ __('FAQ') }}</a>
    <a href="{{ route('contact') }}" class="rounded-sm px-3 py-3 text-sm font-bold uppercase tracking-[0.06em] text-white/90 transition hover:bg-white/10 hover:text-white">{{ __('Contact') }}</a>

    <div class="mt-5 border-t border-white/10 pt-4">
      <div class="flex flex-col gap-2">
        <a href="{{ route('compare') }}" class="flex items-center justify-between rounded-md border border-white/15 bg-white/5 px-3 py-3 text-sm font-black uppercase tracking-[0.06em] text-white transition hover:bg-white/10">
          <span class="inline-flex items-center gap-2">
            <span class="material-symbols-outlined text-[22px] text-[#1280DF]">speed</span>
            {{ __('Compare') }}
          </span>
          <span class="inline-flex h-6 min-w-6 items-center justify-center rounded-full bg-[#1280DF] px-2 text-xs font-extrabold">{{ $compareCount }}</span>
        </a>
        <a href="{{ auth()->check() ? route('dashboard') : route('login') }}" class="flex h-11 items-center justify-center rounded border border-white/15 bg-white/[0.06] px-3 text-sm font-extrabold uppercase tracking-[0.07em] text-white/90 backdrop-blur-sm transition hover:bg-white/10">{{ __('My account') }}</a>
        @auth
          <form method="post" action="{{ route('logout') }}">
            @csrf
            <button type="submit" class="w-full rounded-sm border border-white/10 px-3 py-3 text-sm font-bold uppercase tracking-[0.06em] text-white/90 transition hover:bg-white/10 hover:text-white flex items-center justify-between">
              <span>{{ __('Logout') }}</span><span class="material-symbols-outlined text-xl">logout</span>
            </button>
          </form>
        @endauth
      </div>
    </div>

    @if ($address !== '' || $phone !== '')
      <div class="mt-5 border-t border-white/10 pt-4 text-xs text-white/70">
        @if ($address !== '')
          <p class="line-clamp-2">{{ $address }}</p>
        @endif
        @if ($phone !== '')
          <a href="tel:{{ preg_replace('/[^\d+]/', '', $phone) }}" class="mt-2 inline-flex text-sm font-semibold text-[#4ea3ff] hover:text-white">{{ $phone }}</a>
        @endif
      </div>
    @endif
  </nav>
</div>

<input type="hidden" id="currency-select-endpoint" value="{{ route('currency.select') }}">

<script>
  (() => {
    const toggle = document.querySelector('[data-currency-toggle]');
    const menu = document.querySelector('[data-currency-menu]');
    if (!toggle || !menu) return;

    toggle.addEventListener('click', () => menu.classList.toggle('hidden'));
    document.addEventListener('click', (e) => {
      if (!menu.contains(e.target) && !toggle.contains(e.target)) menu.classList.add('hidden');
    });
    menu.querySelectorAll('[data-currency-option]').forEach((btn) => {
      btn.addEventListener('click', async () => {
        const code = btn.getAttribute('data-currency-option');
        if (!code) return;
        const endpoint = document.getElementById('currency-select-endpoint')?.value;
        if (!endpoint) return;
        const token = document.querySelector('meta[name="csrf-token"]')?.getAttribute('content') || '{{ csrf_token() }}';
        toggle.setAttribute('aria-busy', 'true');
        toggle.setAttribute('disabled', 'disabled');
        menu.querySelectorAll('[data-currency-option]').forEach((b) => b.setAttribute('disabled', 'disabled'));
        try {
          const res = await fetch(endpoint, {
            method: 'POST',
            credentials: 'same-origin',
            headers: {'Content-Type': 'application/json', 'X-CSRF-TOKEN': token, 'Accept': 'application/json'},
            body: JSON.stringify({ currency: code }),
          });
          const data = await res.json().catch(() => ({}));
          if (!res.ok || !data.success) return;
          menu.classList.add('hidden');
          window.location.reload();
        } finally {
          toggle.removeAttribute('aria-busy');
          toggle.removeAttribute('disabled');
          menu.querySelectorAll('[data-currency-option]').forEach((b) => b.removeAttribute('disabled'));
        }
      });
    });
  })();
</script>
