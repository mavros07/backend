<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="scroll-smooth">
  <head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    @php
      $site = $site ?? [];
      $siteDisplayName = ! empty(trim((string) ($site['site_display_name'] ?? ''))) ? trim((string) $site['site_display_name']) : config('app.name');
    @endphp
    <title>@if(!empty($title ?? null)){{ $title }} | @endif{{ $siteDisplayName }}</title>
    @if (!empty($metaDescription))
      <meta name="description" content="{{ $metaDescription }}" />
    @endif
    @if (!empty($canonicalUrl))
      <link rel="canonical" href="{{ $canonicalUrl }}" />
    @endif
    @if (!empty($ogTitle))
      <meta property="og:title" content="{{ $ogTitle }}" />
      <meta property="og:description" content="{{ $ogDescription ?? $metaDescription ?? '' }}" />
      <meta property="og:type" content="website" />
      <meta property="og:url" content="{{ $ogUrl ?? $canonicalUrl ?? url()->current() }}" />
      @if (!empty($ogImage))
        <meta property="og:image" content="{{ $ogImage }}" />
      @endif
      <meta name="twitter:card" content="summary_large_image" />
    @endif


    <script src="https://cdn.tailwindcss.com?plugins=forms,container-queries"></script>
    <link href="https://fonts.googleapis.com/css2?family=Epilogue:wght@400;700;800;900&family=Work+Sans:wght@400;500;600;700&family=Inter:wght@400;500;600;700;800&display=swap" rel="stylesheet" />
    <link href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:wght,FILL@100..700,0..1&display=swap" rel="stylesheet" />
    <script id="tailwind-config">
      tailwind.config = {
        darkMode: 'class',
        theme: {
          extend: {
            colors: {
              primary: '#ffb129',
              brand_blue: '#4e77ed',
              brand_orange: '#f9a825',
              card_bg: 'rgba(34,39,45,0.95)',
              sold_red: '#e94343',
              on_surface: '#191c1e',
              page_bg: '#f8f9fc',
            },
            fontFamily: {
              headline: ['Epilogue', 'sans-serif'],
              body: ['Work Sans', 'sans-serif'],
              label: ['Inter', 'sans-serif'],
            },
          },
        },
      };
    </script>
    <link rel="stylesheet" href="{{ asset('asset/css/site.css') }}" />
    @if (!empty($site['favicon_path'] ?? ''))
      <link rel="icon" href="{{ \App\Support\VehicleImageUrl::url($site['favicon_path']) }}" />
    @endif
    @stack('head')
  </head>

  <body class="bg-page_bg font-body text-on_surface selection:bg-brand_blue/20 {{ $bodyClass ?? '' }}">
    <!-- Global Loading Screen -->
    <div id="global-loader" class="fixed inset-0 z-[99999] flex flex-col items-center justify-center bg-[#1E2229] transition-opacity duration-700 ease-in-out">
      <div class="relative flex items-center justify-center">
        <!-- Spinner -->
        <svg class="h-20 w-20 animate-spin text-brand_orange" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
          <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="2"></circle>
          <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
        </svg>
        <span class="absolute material-symbols-outlined text-white text-3xl">directions_car</span>
      </div>
      <!-- Fading Site Name -->
      <div class="mt-8 animate-pulse text-center font-headline text-2xl font-black italic tracking-widest text-white uppercase">
        {{ strtoupper($siteDisplayName) }}
      </div>
    </div>
    <script>
      window.addEventListener('load', function() {
        const loader = document.getElementById('global-loader');
        if (loader) {
          loader.classList.add('opacity-0');
          setTimeout(() => {
              loader.style.display = 'none';
          }, 700);
        }
      });
    </script>

    @include('partials.header')
    {{-- Header is sticky (dealer-style top strip + nav); no artificial pt-* needed — avoids hero/content hiding under a fixed bar --}}
    <main id="main">
      @yield('content')
    </main>
    @include('partials.footer')
    <script src="{{ asset('asset/js/main.js') }}" defer></script>
    @stack('scripts')
  </body>
</html>