@php
    $brandName = ! empty(trim((string) ($site['site_display_name'] ?? ''))) ? trim((string) $site['site_display_name']) : config('app.name', 'Laravel');
    $logoPath = $site['logo_path'] ?? $site['logo_url'] ?? null;
    $panelPath = trim((string) ($site['auth_panel_image_path'] ?? ''));
    $authPanelFallback = public_path('asset/images/media/placeholder-lorem.svg');
    $useAuthPanelFallback = $panelPath === '' && is_file($authPanelFallback);
@endphp
<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
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
    <body class="font-sans text-gray-900 antialiased">
        <div class="flex min-h-screen flex-col bg-zinc-100 md:h-screen md:flex-row md:overflow-hidden">
            {{-- Form: 60% width on md+, vertically centered; full width on mobile --}}
            <div class="flex min-h-screen w-full flex-1 flex-col justify-center px-6 py-12 sm:px-10 md:min-h-0 md:w-[60%] md:max-w-none md:flex-none md:py-16">
                <div class="mx-auto w-full max-w-md">
                    <a href="/" class="inline-flex items-center gap-3">
                        @if (! empty($logoPath))
                            <img
                                src="{{ \App\Support\VehicleImageUrl::url($logoPath) }}"
                                alt="{{ $brandName }}"
                                class="h-14 w-14 rounded-lg object-contain"
                            />
                        @else
                            <span class="inline-flex h-14 w-14 items-center justify-center rounded-lg bg-zinc-900 text-lg font-bold text-white">
                                {{ strtoupper(\Illuminate\Support\Str::substr($brandName, 0, 1)) }}
                            </span>
                        @endif
                        <span class="text-lg font-semibold tracking-tight text-zinc-900">{{ $brandName }}</span>
                    </a>

                    <div class="mt-8 overflow-hidden rounded-lg bg-white p-6 shadow-md sm:p-8">
                        {{ $slot }}
                    </div>
                </div>
            </div>

            {{-- Image: 40% width, full height of viewport; hidden on small screens --}}
            <div class="relative hidden min-h-0 bg-zinc-900 md:block md:h-full md:min-h-0 md:w-[40%] md:flex-none md:self-stretch">
                @if ($panelPath !== '')
                    <img
                        src="{{ \App\Support\VehicleImageUrl::url($panelPath) }}"
                        alt=""
                        class="absolute inset-0 h-full w-full object-cover"
                    />
                    <div class="absolute inset-0 bg-gradient-to-t from-black/50 via-black/10 to-transparent"></div>
                @elseif ($useAuthPanelFallback)
                    <img
                        src="{{ asset('asset/images/media/placeholder-lorem.svg') }}"
                        alt=""
                        class="absolute inset-0 h-full w-full object-cover opacity-90"
                    />
                    <div class="absolute inset-0 bg-gradient-to-t from-black/40 via-transparent to-zinc-900/80"></div>
                @else
                    <div class="absolute inset-0 bg-gradient-to-br from-zinc-700 via-zinc-900 to-black"></div>
                @endif
            </div>
        </div>
        @stack('body-end')
    </body>
</html>
