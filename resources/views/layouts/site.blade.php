<!DOCTYPE html>
<html lang="en-US" class="no-js stm-site-preloader">
  <head>
    <script>
      /* static snapshot: dismiss theme preloader */
      (function () {
        var e = document.documentElement;
        e.classList.remove('stm-site-preloader');
        e.classList.add('stm-site-preloaded');
      })();
    </script>

    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=no" />
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

    <link rel="stylesheet" href="{{ asset('asset/css/vendor-icons.css') }}" />
    @if (!empty($vendorCss))
      <link rel="stylesheet" href="{{ asset($vendorCss) }}" />
    @endif
    <link rel="stylesheet" href="{{ asset('asset/css/main.css') }}" />

    <style>
      :root {
        --mvl-primary-color: #cc6119;
        --mvl-secondary-color: #6c98e1;
        --mvl-secondary-color-dark: #5a7db6;
        --mvl-third-color: #232628;
        --mvl-fourth-color: #153e4d;

        --motors-accent-color: #1280df;
        --motors-accent-color-alpha: rgba(18, 128, 223, 0.5);
        --motors-accent-color-highalpha: rgba(18, 128, 223, 0.7);
        --motors-accent-color-lowalpha: rgba(18, 128, 223, 0.3);
        --motors-accent-color-super-lowalpha: rgba(18, 128, 223, 0.1);
        --motors-bg-shade: #f0f3f7;
        --motors-bg-color: #ffffff;
        --motors-bg-lowalpha-color: rgba(255, 255, 255, 0.3);
        --motors-bg-alpha-color: rgba(255, 255, 255, 0.5);
        --motors-bg-highalpha-color: rgba(255, 255, 255, 0.7);
        --motors-bg-contrast: #35475a;
        --motors-bg-lowestalpha-contrast: rgba(53, 71, 90, 0.1);
        --motors-bg-lowalpha-contrast: rgba(53, 71, 90, 0.3);
        --motors-bg-alpha-contrast: rgba(53, 71, 90, 0.5);
        --motors-bg-highalpha-contrast: rgba(53, 71, 90, 0.7);
        --motors-bg-highestalpha-contrast: rgba(53, 71, 90, 0.9);
        --motors-text-color: #010101;
        --motors-contrast-text-color: #ffffff;
        --motors-text-highalpha-color: rgba(1, 1, 1, 0.7);
        --motors-text-highestalpha-color: rgba(1, 1, 1, 0.8);
        --motors-text-alpha-color: rgba(1, 1, 1, 0.5);
        --motors-contrast-text-lowestalpha-color: rgba(255, 255, 255, 0.1);
        --motors-contrast-text-lowalpha-color: rgba(255, 255, 255, 0.3);
        --motors-contrast-text-highalpha-color: rgba(255, 255, 255, 0.7);
        --motors-contrast-text-highestalpha-color: rgba(255, 255, 255, 0.8);
        --motors-text-lowalpha-color: rgba(1, 1, 1, 0.3);
        --motors-text-lowestalpha-color: rgba(1, 1, 1, 0.1);
        --motors-contrast-text-alpha-color: rgba(255, 255, 255, 0.5);
        --motors-border-color: rgba(1, 1, 1, 0.15);
        --motors-contrast-border-color: rgba(255, 255, 255, 0.15);
        --motors-spec-badge-color: #fab637;
        --motors-sold-badge-color: #fc4e4e;
        --motors-error-bg-color: rgba(255, 127, 127, 1);
        --motors-notice-bg-color: #fbc45d;
        --motors-success-bg-color: #dbf2a2;
        --motors-error-text-color: rgba(244, 43, 43, 1);
        --motors-notice-text-color: #e4961a;
        --motors-success-text-color: #5eac3f;
        --motors-filter-inputs-color: #f6f7f9;
      }
    </style>

    @stack('head')
  </head>

  <body class="{{ $bodyClass ?? '' }}" ontouchstart="">
    <div id="wrapper">
      @include('partials.header')

      <div id="main">
        @yield('content')
      </div>

      @include('partials.footer')
    </div>

    <script src="{{ asset('asset/js/main.js') }}"></script>
    @stack('scripts')
  </body>
</html>

