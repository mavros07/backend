<!DOCTYPE html>
<html class="light" lang="{{ str_replace('_', '-', app()->getLocale()) }}">
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
    <link
      href="https://fonts.googleapis.com/css2?family=Epilogue:wght@400;700;800;900&family=Work+Sans:wght@300;400;500;600&family=Inter:wght@400;600;800&display=swap"
      rel="stylesheet"
    />
    <link
      href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:wght,FILL@100..700,0..1&display=swap"
      rel="stylesheet"
    />
    <script src="https://cdn.tailwindcss.com?plugins=forms,container-queries"></script>
    <script id="tailwind-config">
      tailwind.config = {
        darkMode: 'class',
        theme: {
          extend: {
            colors: {
              'inverse-surface': '#232628',
              'on-secondary': '#ffffff',
              'outline-variant': '#d7c4ad',
              'tertiary-container': '#bec0c3',
              'on-tertiary-fixed-variant': '#444749',
              'secondary-fixed-dim': '#a3c9ff',
              'on-primary-fixed-variant': '#624000',
              'secondary-container': '#459eff',
              'on-secondary-fixed': '#001c39',
              secondary: '#0060ab',
              'surface-container': '#eceef0',
              'on-secondary-container': '#003461',
              'on-secondary-fixed-variant': '#004883',
              'inverse-primary': '#ffb94c',
              'primary-fixed-dim': '#ffb94c',
              'on-primary': '#ffffff',
              error: '#ba1a1a',
              'surface-container-lowest': '#ffffff',
              primary: '#ffb129',
              'surface-variant': '#e1e2e5',
              'on-tertiary': '#ffffff',
              'inverse-on-surface': '#eff1f3',
              'surface-container-low': '#f2f4f6',
              tertiary: '#5c5f61',
              'surface-dim': '#d8dadc',
              'primary-fixed': '#ffddb2',
              'primary-container': '#ffb129',
              surface: '#ffffff',
              'on-error-container': '#93000a',
              'on-primary-container': '#232628',
              'surface-tint': '#ffb129',
              'secondary-fixed': '#d3e3ff',
              'on-tertiary-container': '#4c4f51',
              outline: '#847561',
              'tertiary-fixed-dim': '#c5c7c9',
              'on-background': '#232628',
              'on-error': '#ffffff',
              'surface-bright': '#f8f9fc',
              'tertiary-fixed': '#e1e2e5',
              'error-container': '#ffdad6',
              background: '#ffffff',
              'on-surface': '#232628',
              'surface-container-high': '#e7e8eb',
              'on-tertiary-fixed': '#191c1e',
              'on-primary-fixed': '#291800',
              'surface-container-highest': '#f0f2f5',
              'on-surface-variant': '#524534',
            },
            borderRadius: {
              DEFAULT: '4px',
              lg: '8px',
              xl: '12px',
              full: '9999px',
            },
            fontFamily: {
              headline: ['Epilogue', 'system-ui', 'sans-serif'],
              body: ['Work Sans', 'system-ui', 'sans-serif'],
              label: ['Inter', 'system-ui', 'sans-serif'],
            },
          },
        },
      };
    </script>
    <style>
      .material-symbols-outlined {
        font-variation-settings: 'FILL' 0, 'wght' 400, 'GRAD' 0, 'opsz' 24;
      }
      .hero-gradient {
        background: linear-gradient(180deg, rgba(35, 38, 40, 0.5) 0%, rgba(35, 38, 40, 0.2) 100%);
      }
      .section-line {
        position: relative;
      }
      .section-line::after {
        content: '';
        position: absolute;
        bottom: -15px;
        left: 50%;
        transform: translateX(-50%);
        width: 50px;
        height: 3px;
        background-color: #ffb129;
      }
      .stats-bg {
        background-image: url('https://lh3.googleusercontent.com/aida-public/AB6AXuAtzOrMxv34w0a1iVMYHwMqfYMmJ6ZC5xS7IYi2vfEDIckK5RSiJoqyRLdBevA3Dvv0SVPuqouh4DaN2LWNJOgFzrt6KxJbVAF6a_UpzBaEJRVO0X3_7m7wi_-aOLf5oPqsc2Rd5LFbow0ghNr6mxCXEeO5VQ9rkdvfM-7sAM4ulNJjEUf_IAfTXhHU9sj6HK_SxBjA8tHF9zT1jOx59a36YjVrp6lAxcylS8PsDXWV5naerX7MTJHXV5cmlEdbW8uIMQwKS1Y2R2w');
        background-size: cover;
        background-position: center;
      }
    </style>
    @stack('head')
  </head>
  <body class="bg-background text-on-background font-body antialiased">
    @yield('content')
    @stack('scripts')
  </body>
</html>
