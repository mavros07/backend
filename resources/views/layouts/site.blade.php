<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="scroll-smooth">
  <head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>{{ $title ?? config('app.name') }}</title>
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

    <base href="/" />

    <script src="https://cdn.tailwindcss.com?plugins=forms,container-queries"></script>
    <link href="https://fonts.googleapis.com/css2?family=Epilogue:wght@400;700;800;900&family=Work+Sans:wght@400;500;600;700&family=Inter:wght@400;500;600;700;800&display=swap" rel="stylesheet" />
    <link href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:wght,FILL@100..700,0..1&display=swap" rel="stylesheet" />
    <script id="tailwind-config">
      tailwind.config = {
        darkMode: 'class',
        theme: {
          extend: {
            colors: {
              "on-error-container": "#93000a",
              "on-primary-fixed-variant": "#624000",
              "on-primary-container": "#6c4700",
              "primary-container": "#ffb129",
              "primary-fixed": "#ffddb2",
              "surface-container-lowest": "#ffffff",
              "on-primary": "#ffffff",
              "background": "#f8f9fc",
              "surface-bright": "#f8f9fc",
              "outline-variant": "#d7c4ad",
              "tertiary-container": "#bec0c3",
              "surface-container-highest": "#e1e2e5",
              "on-secondary-container": "#003461",
              "on-primary-fixed": "#291800",
              "secondary-container": "#459eff",
              "inverse-surface": "#2e3133",
              "surface-variant": "#e1e2e5",
              "on-surface": "#191c1e",
              "on-secondary-fixed-variant": "#004883",
              "tertiary": "#5c5f61",
              "error": "#ba1a1a",
              "tertiary-fixed": "#e1e2e5",
              "secondary": "#0060ab",
              "on-tertiary-container": "#4c4f51",
              "surface-tint": "#815500",
              "primary": "#815500",
              "on-tertiary": "#ffffff",
              "on-background": "#191c1e",
              "surface": "#f8f9fc",
              "surface-container-high": "#e7e8eb",
              "on-error": "#ffffff",
              "surface-dim": "#d8dadc",
              "on-secondary-fixed": "#001c39",
              "surface-container-low": "#f2f4f6",
              "inverse-on-surface": "#eff1f3",
              "on-surface-variant": "#524534",
              "primary-fixed-dim": "#ffb94c",
              "on-secondary": "#ffffff",
              "tertiary-fixed-dim": "#c5c7c9",
              "secondary-fixed": "#d3e3ff",
              "on-tertiary-fixed-variant": "#444749",
              "outline": "#847561",
              "inverse-primary": "#ffb94c",
              "surface-container": "#eceef0",
              "secondary-fixed-dim": "#a3c9ff",
              "error-container": "#ffdad6",
              "on-tertiary-fixed": "#191c1e",
              // Keep some legacy aliases for compatibility if needed
              brand_blue: '#4e77ed',
              brand_orange: '#f9a825',
            },
            borderRadius: {
              DEFAULT: '0.125rem',
              lg: '0.25rem',
              xl: '0.5rem',
              full: '0.75rem',
            },
            fontFamily: {
              headline: ['Epilogue', 'sans-serif'],
              display: ['Epilogue', 'sans-serif'],
              body: ['Work Sans', 'sans-serif'],
              label: ['Inter', 'sans-serif'],
            },
          },
        },
      };
    </script>
    <link rel="stylesheet" href="{{ asset('asset/css/site.css') }}" />
    @stack('head')
  </head>

  <body class="bg-page_bg font-body text-on_surface selection:bg-brand_blue/20 {{ $bodyClass ?? '' }}">
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