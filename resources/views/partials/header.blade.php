@php
  $site = $site ?? [];
  $brandName = config('app.name', 'Site');
  $logoPath = $site['logo_path'] ?? $site['logo_url'] ?? null;
  $hoursLabel = $site['dealer_hours_label'] ?? __('Work Hours');
  $hoursLines = preg_split('/\r\n|\r|\n/', $site['dealer_sales_hours'] ?? "Mon – Fri: 09:00AM – 09:00PM\nSaturday: 09:00AM – 07:00PM\nSunday: Closed") ?: [];
  $hoursSnippet = $hoursLines[0] ?? '';
  $address = $site['dealer_address'] ?? '1840 E Garvey Ave South West Covina, CA 91791';
  $phone = $site['dealer_phone'] ?? $site['dealer_sales_phone'] ?? '+1 212-226-3126';
  $socialFacebook = $site['social_facebook'] ?? '#';
  $socialInstagram = $site['social_instagram'] ?? '#';
  $socialLinkedin = $site['social_linkedin'] ?? '#';
  $socialYoutube = $site['social_youtube'] ?? '#';
  $compareCount = \App\Support\Compare::count();
@endphp

{{-- Layout aligned with Motors dealer header pattern (top strip + primary bar): https://motors.stylemixthemes.com/elementor-dealer-two/ --}}
<header class="sticky top-0 z-50 shadow-[0_1px_0_rgba(0,0,0,0.06)]">
  {{-- Top bar — dark strip (#232628 matches Motors --mvl-third-color) --}}
  <div class="border-b border-white/5 bg-[#232628] text-[11px] font-semibold uppercase tracking-wide text-white/90">
    <div class="mx-auto flex max-w-7xl flex-wrap items-center justify-between gap-x-6 gap-y-2 px-4 py-2.5 sm:px-6 lg:px-8">
      <div class="flex min-w-0 flex-1 flex-wrap items-center gap-x-5 gap-y-1 text-white/85">
        @if ($hoursSnippet !== '')
          <span class="inline-flex items-center gap-1.5 shrink-0">
            <span class="material-symbols-outlined text-[16px] text-[#cc6119]" aria-hidden="true">schedule</span>
            <span class="hidden sm:inline">{{ $hoursLabel }}</span>
            <span class="sm:hidden">{{ \Illuminate\Support\Str::limit($hoursSnippet, 22) }}</span>
            <span class="hidden md:inline text-white/55 normal-case tracking-normal">· {{ $hoursSnippet }}</span>
          </span>
        @endif
        <span class="hidden min-w-0 lg:inline-flex items-start gap-1.5 text-white/80 normal-case tracking-normal">
          <span class="material-symbols-outlined mt-0.5 shrink-0 text-[16px] text-white/45" aria-hidden="true">location_on</span>
          <span class="truncate">{{ $address }}</span>
        </span>
        <a href="tel:{{ preg_replace('/[^\d+]/', '', $phone) }}" class="inline-flex items-center gap-1.5 text-white hover:text-[#cc6119] transition-colors shrink-0 normal-case tracking-normal">
          <span class="material-symbols-outlined text-[16px] text-white/55" aria-hidden="true">call</span>
          {{ $phone }}
        </a>
      </div>
      <div class="flex shrink-0 items-center gap-2">
        @foreach (['facebook' => $socialFacebook, 'instagram' => $socialInstagram, 'linkedin' => $socialLinkedin, 'youtube' => $socialYoutube] as $net => $url)
          @if (!empty($url) && $url !== '#')
            <a href="{{ $url }}" target="_blank" rel="noopener noreferrer" class="flex h-8 w-8 items-center justify-center rounded border border-white/10 text-white/75 transition hover:border-white/30 hover:bg-white/10 hover:text-white" aria-label="{{ ucfirst($net) }}">
              @if ($net === 'facebook')
                <svg class="h-3.5 w-3.5" fill="currentColor" viewBox="0 0 24 24" aria-hidden="true"><path d="M22 12c0-5.523-4.477-10-10-10S2 6.477 2 12c0 4.991 3.657 9.128 8.438 9.878v-6.987h-2.54V12h2.54V9.797c0-2.506 1.492-3.89 3.777-3.89 1.094 0 2.238.195 2.238.195v2.46h-1.26c-1.243 0-1.63.771-1.63 1.562V12h2.773l-.443 2.89h-2.33v6.988C18.343 21.128 22 16.991 22 12z"/></svg>
              @elseif ($net === 'instagram')
                <svg class="h-3.5 w-3.5" fill="currentColor" viewBox="0 0 24 24" aria-hidden="true"><path d="M12 2.163c3.204 0 3.584.012 4.85.07 3.252.148 4.771 1.691 4.919 4.919.058 1.265.069 1.645.069 4.849 0 3.205-.012 3.584-.069 4.849-.149 3.225-1.664 4.771-4.919 4.919-1.266.058-1.644.07-4.85.07-3.204 0-3.584-.012-4.849-.07-3.26-.149-4.771-1.699-4.919-4.92-.058-1.265-.07-1.644-.07-4.849 0-3.204.013-3.583.07-4.849.149-3.227 1.664-4.771 4.919-4.919 1.266-.057 1.645-.069 4.849-.069zm0-2.163c-3.259 0-3.667.014-4.947.072-4.358.2-6.78 2.618-6.98 6.98-.059 1.281-.073 1.689-.073 4.948 0 3.259.014 3.668.072 4.948.2 4.358 2.618 6.78 6.98 6.98 1.281.058 1.689.072 4.948.072 3.259 0 3.668-.014 4.948-.072 4.354-.2 6.782-2.618 6.979-6.98.059-1.28.073-1.689.073-4.948 0-3.259-.014-3.667-.072-4.947-.196-4.354-2.617-6.78-6.979-6.98-1.281-.059-1.69-.073-4.949-.073zm0 5.838c-3.403 0-6.162 2.759-6.162 6.162s2.759 6.163 6.162 6.163 6.162-2.759 6.162-6.163c0-3.403-2.759-6.162-6.162-6.162zm0 10.162c-2.209 0-4-1.79-4-4 0-2.209 1.791-4 4-4s4 1.791 4 4c0 2.21-1.791 4-4 4zm6.406-11.845c-.796 0-1.441.645-1.441 1.44s.645 1.44 1.441 1.44c.795 0 1.439-.645 1.439-1.44s-.644-1.44-1.439-1.44z"/></svg>
              @elseif ($net === 'linkedin')
                <svg class="h-3.5 w-3.5" fill="currentColor" viewBox="0 0 24 24" aria-hidden="true"><path d="M20.447 20.452h-3.554v-5.569c0-1.328-.027-3.037-1.852-3.037-1.853 0-2.136 1.445-2.136 2.939v5.667H9.351V9h3.414v1.561h.046c.477-.9 1.637-1.85 3.37-1.85 3.601 0 4.267 2.37 4.267 5.455v6.286zM5.337 7.433c-1.144 0-2.063-.926-2.063-2.065 0-1.138.92-2.063 2.063-2.063 1.14 0 2.064.925 2.064 2.063 0 1.139-.925 2.065-2.064 2.065zm1.782 13.019H3.555V9h3.564v11.452zM22.225 0H1.771C.792 0 0 .774 0 1.729v20.542C0 23.227.792 24 1.771 24h20.451C23.2 24 24 23.227 24 22.271V1.729C24 .774 23.2 0 22.222 0h.003z"/></svg>
              @else
                <svg class="h-3.5 w-3.5" fill="currentColor" viewBox="0 0 24 24" aria-hidden="true"><path d="M23.498 6.186a3.016 3.016 0 00-2.122-2.136C19.505 3.545 12 3.545 12 3.545s-7.505 0-9.377.505A3.017 3.017 0 00.502 6.186C0 8.07 0 12 0 12s0 3.93.502 5.814a3.016 3.016 0 002.122 2.136c1.871.505 9.376.505 9.376.505s7.505 0 9.377-.505a3.015 3.015 0 002.122-2.136c.502-1.884.502-5.814.502-5.814s0-3.93-.502-5.814zM9.545 15.568V8.432L15.818 12l-6.273 3.568z"/></svg>
              @endif
            </a>
          @endif
        @endforeach
      </div>
    </div>
  </div>

  {{-- Primary bar: logo + inline menu (Motors listing-header style), compare on the right --}}
  <div class="border-b border-slate-200 bg-white">
    <div class="mx-auto flex min-h-[5rem] max-w-7xl items-center justify-between gap-4 px-4 py-3 sm:px-6 lg:px-8">
      <div class="flex min-w-0 flex-1 items-center gap-6 lg:gap-10">
        <a href="{{ route('home') }}" class="flex shrink-0 items-center">
          @if (!empty($logoPath))
            <img src="{{ \App\Support\VehicleImageUrl::url($logoPath) }}" alt="{{ $brandName }}" class="h-10 w-auto max-w-[150px] object-contain sm:h-[52px]" />
          @else
            <span class="font-headline text-xl font-black italic tracking-tighter text-[#232628] sm:text-2xl">{{ strtolower($brandName) }}</span>
          @endif
        </a>

        <nav class="hidden min-w-0 flex-1 items-center justify-start gap-0.5 lg:flex xl:gap-1" aria-label="{{ __('Primary') }}">
          @foreach ([
            ['route' => 'home', 'label' => __('Home')],
            ['route' => 'inventory.index', 'label' => __('Inventory')],
            ['route' => 'about', 'label' => __('About')],
            ['route' => 'faq', 'label' => __('FAQ')],
            ['route' => 'contact', 'label' => __('Contact')],
          ] as $item)
            @php
              $r = $item['route'];
              $active = match ($r) {
                'home' => request()->routeIs('home'),
                'inventory.index' => request()->routeIs('inventory.*'),
                default => request()->routeIs($r),
              };
            @endphp
            <a
              href="{{ route($r) }}"
              class="whitespace-nowrap rounded-sm px-2.5 py-2 font-headline text-[13px] font-semibold uppercase tracking-wide transition-colors {{ $active ? 'text-[#1280DF]' : 'text-[#232628] hover:text-[#1280DF]' }}"
            >{{ $item['label'] }}</a>
          @endforeach
        </nav>
      </div>

      <div class="flex shrink-0 items-center gap-2 sm:gap-3">
        <a href="{{ route('compare') }}" class="{{ request()->routeIs('compare') ? 'border-[#1280DF] bg-[#1280DF]/5' : '' }} hidden items-center gap-2 rounded border border-slate-200 px-3 py-2 font-headline text-[11px] font-bold uppercase tracking-wider text-[#232628] transition hover:border-[#1280DF]/40 hover:bg-slate-50 lg:inline-flex" title="{{ __('Compare vehicles') }}">
          <span class="material-symbols-outlined text-[20px] text-[#1280DF]" aria-hidden="true">compare_arrows</span>
          <span>{{ __('Compare') }}</span>
          @if ($compareCount > 0)
            <span class="rounded-full bg-[#1280DF] px-1.5 py-0.5 text-[10px] font-bold text-white">{{ $compareCount }}</span>
          @endif
        </a>
        <button class="inline-flex h-11 w-11 items-center justify-center rounded border border-slate-200 text-[#232628] hover:bg-slate-50 lg:hidden" type="button" data-mobile-menu-toggle aria-label="{{ __('Menu') }}">
          <span class="material-symbols-outlined text-2xl">menu</span>
        </button>
      </div>
    </div>
  </div>
</header>

<div class="fixed inset-0 z-[55] hidden bg-black/50 lg:hidden" data-mobile-menu-overlay aria-hidden="true"></div>
<div class="fixed right-0 top-0 z-[60] flex h-full w-[min(20rem,calc(100vw-2rem))] translate-x-full flex-col border-l border-slate-200 bg-white shadow-2xl transition-transform duration-200 ease-out lg:hidden" data-mobile-menu-panel id="site-mobile-nav">
  <div class="flex min-h-[5rem] shrink-0 items-center justify-between border-b border-slate-200 px-4">
    <span class="font-headline text-lg font-black italic text-[#232628]">{{ strtolower($brandName) }}</span>
    <button type="button" class="inline-flex h-10 w-10 items-center justify-center rounded-md text-slate-600 hover:bg-slate-100" data-mobile-menu-close aria-label="{{ __('Close') }}">
      <span class="material-symbols-outlined text-2xl">close</span>
    </button>
  </div>
  <nav class="flex flex-1 flex-col gap-1 overflow-y-auto p-4" aria-label="{{ __('Mobile') }}">
    @foreach ([
      ['route' => 'home', 'label' => __('Home')],
      ['route' => 'inventory.index', 'label' => __('Inventory')],
      ['route' => 'about', 'label' => __('About')],
      ['route' => 'faq', 'label' => __('FAQ')],
      ['route' => 'compare', 'label' => __('Compare')],
      ['route' => 'contact', 'label' => __('Contact')],
    ] as $item)
      <a href="{{ route($item['route']) }}" class="rounded-lg px-3 py-3 font-headline text-sm font-semibold uppercase tracking-wide text-[#232628] hover:bg-slate-100">{{ $item['label'] }}</a>
    @endforeach
    <a href="{{ route('compare') }}" class="mt-2 inline-flex items-center gap-2 rounded-lg border border-slate-200 px-3 py-3 font-headline text-sm font-semibold uppercase tracking-wide text-[#232628]">
      <span class="material-symbols-outlined text-[#1280DF]">compare_arrows</span>
      {{ __('Compare') }}
      @if ($compareCount > 0)
        <span class="ml-auto rounded-full bg-[#1280DF] px-2 py-0.5 text-xs font-bold text-white">{{ $compareCount }}</span>
      @endif
    </a>
    <p class="mt-6 border-t border-slate-100 pt-4 text-[11px] leading-relaxed text-slate-500">{{ \Illuminate\Support\Str::limit($address, 80) }}</p>
    <a href="tel:{{ preg_replace('/[^\d+]/', '', $phone) }}" class="mt-2 text-sm font-semibold text-[#1280DF]">{{ $phone }}</a>
  </nav>
</div>
