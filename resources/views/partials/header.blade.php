@php
  $site = $site ?? [];
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
  $currencyLabel = trim((string) ($site['currency_label'] ?? '')) ?: __('Currency (USD)');
  $socialFacebook = trim((string) ($site['social_facebook'] ?? ''));
  $socialInstagram = trim((string) ($site['social_instagram'] ?? ''));
  $socialLinkedin = trim((string) ($site['social_linkedin'] ?? ''));
  $socialYoutube = trim((string) ($site['social_youtube'] ?? ''));
  $compareCount = \App\Support\Compare::count();
  $isHome = request()->routeIs('home') || request()->routeIs('faq') || request()->routeIs('about');
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
      [data-site-header].is-home-header.is-scrolled [data-header-bag-count],
      [data-site-header].is-home-header.is-scrolled [data-header-menu-icon] { color: #111827 !important; }
      [data-site-header].is-home-header.is-scrolled [data-header-nav-link] { color: rgba(17, 24, 39, 0.92) !important; }
      [data-site-header].is-home-header.is-scrolled [data-header-nav-link]:hover { color: #111827 !important; }
      [data-site-header].is-home-header.is-scrolled [data-header-menu-button] { border-color: rgba(15, 23, 42, 0.2) !important; }
    </style>
  @endif
  @if (request()->routeIs('about'))
    <style>
      [data-site-header].is-home-header [data-header-logo],
      [data-site-header].is-home-header [data-header-icon],
      [data-site-header].is-home-header [data-header-action-text],
      [data-site-header].is-home-header [data-header-bag-count],
      [data-site-header].is-home-header [data-header-menu-icon] { color: #111827 !important; }
      [data-site-header].is-home-header [data-header-nav-link] { color: rgba(17, 24, 39, 0.92) !important; }
      [data-site-header].is-home-header [data-header-nav-link]:hover { color: #111827 !important; }
      [data-site-header].is-home-header [data-header-menu-button] { border-color: rgba(15, 23, 42, 0.2) !important; }
    </style>
  @endif
  <div class="h-10 border-b border-white/10 bg-[#232628]">
    <div class="mx-auto flex h-full w-full max-w-[1280px] items-center justify-between px-4 sm:px-6 lg:px-8">
      <button type="button" class="inline-flex items-center gap-1 text-[11px] font-bold uppercase tracking-[0.05em] text-white/70 hover:text-white">
        <span>{{ $currencyLabel }}</span>
        <span class="material-symbols-outlined text-[16px]">keyboard_arrow_down</span>
      </button>

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
        @foreach ([
          ['route' => 'home', 'label' => __('Home')],
          ['route' => 'inventory.index', 'label' => __('Inventory')],
          ['url' => route('inventory.index', ['condition' => 'used', 'location' => 'nigeria']), 'label' => __('Nigerian Used')],
          ['url' => route('inventory.index', ['condition' => 'used', 'location' => 'united states']), 'label' => __('Foreign Used')],
          ['route' => 'about', 'label' => __('About')],
          ['route' => 'faq', 'label' => __('FAQ')],
          ['route' => 'contact', 'label' => __('Contact')],
        ] as $item)
          @php
            $r = $item['route'] ?? null;
            $url = $item['url'] ?? route($r);
            if ($r) {
                $active = match ($r) {
                  'home' => request()->routeIs('home'),
                  'inventory.index' => request()->routeIs('inventory.*') && !request()->has('location'),
                  default => request()->routeIs($r),
                };
            } else {
                $active = str_contains(urldecode(request()->fullUrl()), urldecode($url));
            }
          @endphp
          <a href="{{ $url }}" data-header-nav-link class="pointer-events-auto inline-flex items-center border-b-2 pb-1.5 text-[13px] font-extrabold uppercase leading-none tracking-[0.07em] transition-colors whitespace-nowrap {{ $active ? 'border-[#1280DF] text-white' : 'border-transparent text-white/85 hover:text-[#1280DF]' }}">
            <span>{{ $item['label'] }}</span>
          </a>
        @endforeach
      </nav>

      <div class="relative z-20 flex shrink-0 items-center gap-3 sm:gap-6">
        <a href="{{ route('compare') }}" class="group hidden items-center gap-2 xl:inline-flex" title="{{ __('Compare vehicles') }}">
          <span data-header-action-text class="text-[11px] font-extrabold uppercase tracking-[0.06em] text-white transition-colors group-hover:text-[#1280DF]">{{ __('Compare') }}</span>
          <span class="relative ml-0.5 inline-flex">
            <span data-header-icon class="material-symbols-outlined text-[24px] text-white transition-colors group-hover:text-[#1280DF]">speed</span>
            <span class="absolute -right-1 -top-1 inline-flex h-4 min-w-4 items-center justify-center rounded-full bg-[#1280DF] px-1 text-[10px] font-extrabold text-white">{{ $compareCount }}</span>
          </span>
        </a>

        <span class="relative hidden xl:inline-flex border-l border-white/15 pl-5">
          <span data-header-icon class="material-symbols-outlined text-[27px] text-white">shopping_bag</span>
          <span data-header-bag-count class="absolute left-1/2 top-1/2 -translate-x-1/2 -translate-y-[22%] text-[10px] font-bold text-white">0</span>
        </span>

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
    @foreach ([
      ['route' => 'home', 'label' => __('Home')],
      ['route' => 'inventory.index', 'label' => __('Inventory')],
      ['url' => route('inventory.index', ['condition' => 'used', 'location' => 'nigeria']), 'label' => __('Nigerian Used')],
      ['url' => route('inventory.index', ['condition' => 'used', 'location' => 'united states']), 'label' => __('Foreign Used')],
      ['route' => 'about', 'label' => __('About')],
      ['route' => 'faq', 'label' => __('FAQ')],
      ['route' => 'compare', 'label' => __('Compare')],
      ['route' => 'contact', 'label' => __('Contact')],
    ] as $item)
      @php
        $url = $item['url'] ?? route($item['route']);
      @endphp
      <a href="{{ $url }}" class="rounded-sm px-3 py-3 text-sm font-bold uppercase tracking-[0.06em] text-white/90 transition hover:bg-white/10 hover:text-white">{{ $item['label'] }}</a>
    @endforeach
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
