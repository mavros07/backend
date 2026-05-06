@php
    $brandName = ! empty(trim((string) ($site['site_display_name'] ?? ''))) ? trim((string) $site['site_display_name']) : config('app.name', 'Laravel');
    $logoPath = trim((string) ($site['logo_path'] ?? ''));
    if ($logoPath === '') {
        $logoPath = trim((string) ($site['logo_url'] ?? ''));
    }
    $hasLogo = $logoPath !== '';
    $panelPath = trim((string) ($site['auth_panel_image_path'] ?? ''));
    $authPanelFallback = public_path('asset/images/media/placeholder-lorem.svg');
    $useAuthPanelFallback = $panelPath === '' && is_file($authPanelFallback);
@endphp
<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="h-full max-w-[100vw] overflow-x-hidden">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ $brandName }} — {{ __('Account') }}</title>
        <style>[x-cloak]{display:none!important}</style>

        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

        @include('partials.vite-assets')
    </head>
    <body class="h-full max-w-[100vw] overflow-x-hidden font-sans text-gray-900 antialiased">
        {{--
          Use CSS Grid (not flex) for the split: the panel <img> is position:absolute so it does not
          contribute to flex basis. In a row flex container that let the first column behave like 100%
          width and collapsed the form column to 0px. Grid assigns explicit column tracks (50/50 on md).
        --}}
        <div
            class="grid min-h-screen max-w-full min-w-0 grid-cols-1 grid-rows-[minmax(36vh,auto)_1fr] bg-zinc-100 sm:grid-rows-[minmax(40vh,auto)_1fr] md:h-screen md:min-h-0 md:grid-cols-2 md:grid-rows-1 md:overflow-hidden"
        >
            {{-- Left (desktop) / top (mobile): full-height background image --}}
            <div class="relative min-h-[36vh] min-w-0 overflow-hidden sm:min-h-[40vh] md:h-full md:min-h-0">
                @if ($panelPath !== '')
                    <img
                        src="{{ \App\Support\VehicleImageUrl::url($panelPath) }}"
                        alt=""
                        class="absolute inset-0 z-0 h-full w-full object-cover"
                        decoding="async"
                    />
                    <div class="pointer-events-none absolute inset-0 z-[1] bg-gradient-to-t from-black/45 via-black/15 to-transparent md:bg-gradient-to-r md:from-black/35 md:via-black/10 md:to-transparent" aria-hidden="true"></div>
                @elseif ($useAuthPanelFallback)
                    <img
                        src="{{ asset('asset/images/media/placeholder-lorem.svg') }}"
                        alt=""
                        class="absolute inset-0 z-0 h-full w-full object-cover opacity-95"
                    />
                    <div class="pointer-events-none absolute inset-0 z-[1] bg-gradient-to-t from-black/35 via-transparent to-zinc-900/70 md:bg-gradient-to-r md:from-zinc-900/50 md:via-transparent md:to-transparent" aria-hidden="true"></div>
                @else
                    <div class="absolute inset-0 z-0 bg-gradient-to-br from-zinc-600 via-zinc-800 to-zinc-950" aria-hidden="true"></div>
                @endif
            </div>

            {{-- Right (desktop) / bottom (mobile): sign-in / register --}}
            <div class="relative z-[2] flex min-h-0 min-w-0 flex-col justify-center px-6 py-10 sm:px-10 md:h-full md:min-h-0 md:overflow-y-auto md:overflow-x-hidden md:py-14 lg:px-12">
                <div class="mx-auto w-full min-w-0">
                    <a href="{{ url('/') }}" class="inline-flex max-w-full items-center {{ $hasLogo ? '' : 'justify-center md:justify-start' }}">
                        @if ($hasLogo)
                            <img
                                src="{{ \App\Support\VehicleImageUrl::url($logoPath) }}"
                                alt="{{ $brandName }}"
                                class="h-12 w-auto max-h-14 max-w-[min(100%,16rem)] object-contain sm:h-14 sm:max-h-16"
                            />
                        @else
                            <span class="text-center text-2xl font-bold tracking-tight text-zinc-900 sm:text-3xl md:text-left">{{ $brandName }}</span>
                        @endif
                    </a>

                    <div class="mt-8 overflow-hidden rounded-lg bg-white p-6 shadow-md sm:p-8">
                        {{ $slot }}
                    </div>
                </div>
            </div>
        </div>
        @stack('body-end')
    </body>
</html>
