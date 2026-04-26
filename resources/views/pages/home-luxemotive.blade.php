@extends('layouts.site')

@php
  $s = $sections ?? [];
  $heroTitle = $s['hero_title'] ?? 'Lorem ipsum dolor sit amet';
  $heroSubtitle = $s['hero_subtitle'] ?? 'Consectetur adipiscing elit';
  $heroBg = \App\Support\PlaceholderMedia::url($s['hero_image'] ?? 'asset/images/media/home-hero-main.jpg');
  $dealerCtaBg = \App\Support\PlaceholderMedia::url($s['dealer_cta_bg'] ?? 'asset/images/media/home-cta-left.jpg');
  $testimonialBg = \App\Support\PlaceholderMedia::url($s['testimonial_bg_image'] ?? 'asset/images/media/home-stats-bg.jpg');
  $testimonialAvatar = \App\Support\PlaceholderMedia::url('asset/images/media/home-testimonial-avatar.jpg');
  $statsCar = \App\Support\PlaceholderMedia::url($s['stats_center_image'] ?? 'asset/images/media/home-stats-car.jpg');
  $heroCtaHref = $s['hero_cta_href'] ?? '/inventory';
  $heroCtaUrl = \Illuminate\Support\Str::startsWith($heroCtaHref, ['http://', 'https://']) ? $heroCtaHref : url($heroCtaHref);
  $ctaLeftHref = $s['cta_left_button_href'] ?? '/inventory';
  $ctaLeftUrl = \Illuminate\Support\Str::startsWith($ctaLeftHref, ['http://', 'https://']) ? $ctaLeftHref : url($ctaLeftHref);
  $ctaRightHref = $s['cta_right_button_href'] ?? (auth()->check() ? '/dashboard/vehicles/create' : '/register');
  $ctaRightUrl = \Illuminate\Support\Str::startsWith($ctaRightHref, ['http://', 'https://']) ? $ctaRightHref : url($ctaRightHref);
  $approvedCount = (int) ($approvedListingCount ?? 0);
  $statsM2 = max(0, (int) preg_replace('/\D/', '', (string) ($s['stats_metric_2_value'] ?? '0')));
  $statsM3 = max(0, (int) preg_replace('/\D/', '', (string) ($s['stats_metric_3_value'] ?? '0')));
  $statsM4 = max(0, (int) preg_replace('/\D/', '', (string) ($s['stats_metric_4_value'] ?? '0')));
  $testimonialOverlay = min(0.95, max(0.0, (float) ($s['testimonial_overlay_opacity'] ?? 0.55)));
  $leftCtaIcon = preg_replace('/[^a-z0-9_]/', '', strtolower((string) ($s['dealer_cta_left_icon'] ?? 'directions_car'))) ?: 'directions_car';
  $rightCtaIcon = preg_replace('/[^a-z0-9_]/', '', strtolower((string) ($s['dealer_cta_right_icon'] ?? 'sell'))) ?: 'sell';
  $recentTitleRaw = trim((string) ($s['recent_title'] ?? 'RECENT CARS'));
  $recentTitleParts = preg_split('/\s+/', $recentTitleRaw) ?: ['RECENT', 'CARS'];
  $recentLastWord = array_pop($recentTitleParts) ?: 'CARS';
  $recentFirstWords = trim(implode(' ', $recentTitleParts));
  $welcomeVideoRaw = trim((string) ($s['welcome_video_url'] ?? ''));
  $welcomeYoutubeWatch = null;
  if ($welcomeVideoRaw !== '') {
    if (preg_match('/(?:youtube\.com\/(?:watch\?v=|embed\/)|youtu\.be\/)([a-zA-Z0-9_-]{11})/', $welcomeVideoRaw, $m)) {
      $welcomeYoutubeWatch = 'https://www.youtube.com/watch?v=' . $m[1];
    } elseif (preg_match('/^[a-zA-Z0-9_-]{11}$/', $welcomeVideoRaw)) {
      $welcomeYoutubeWatch = 'https://www.youtube.com/watch?v=' . $welcomeVideoRaw;
    }
  }
@endphp

@section('content')
  {{-- Homepage does not render legacy WordPress/Elementor HTML here. Use Admin → Page Editors → Home for section copy and optional Content HTML on other pages. --}}

  <section class="relative flex min-h-[94vh] items-start overflow-hidden pt-28 md:min-h-[100vh] md:pt-36">
    <div class="absolute inset-0 bg-cover bg-center" style="background-image: url('{{ e($heroBg) }}');"></div>
    <div class="absolute inset-0 hero-gradient"></div>
    <div class="relative z-10 container mx-auto px-8 text-center">
      <h1 class="text-white font-headline font-black text-4xl md:text-7xl leading-tight tracking-tight uppercase">{{ $heroTitle }}</h1>
      <p class="text-primary font-bold tracking-widest mt-6 text-xl md:text-3xl uppercase">{{ $heroSubtitle }}</p>
      <a href="{{ $heroCtaUrl }}" class="mt-10 inline-block bg-primary text-on_surface px-10 py-4 font-bold text-xs tracking-widest uppercase rounded shadow-lg hover:bg-yellow-400 transition-colors">
        {{ $s['hero_cta_text'] ?? 'Lorem CTA' }}
      </a>
    </div>
  </section>

  <section class="container mx-auto max-w-5xl px-4 sm:px-6 md:px-8 -mt-16 relative z-20">
    <div class="rounded-lg bg-[#232628] p-6 shadow-2xl ring-1 ring-black/20 md:p-8">
      <form method="get" action="{{ route('inventory.index') }}" class="space-y-4">
        <div class="flex items-center gap-2.5 text-white">
          <span class="material-symbols-outlined text-[28px] text-primary">search_insights</span>
          <span class="font-headline text-[20px] font-black uppercase tracking-tight">{{ $s['home_search_label'] ?? 'Search inventory' }}</span>
        </div>
        <div class="flex flex-col gap-4 md:flex-row md:items-center">
          <div class="grid flex-1 grid-cols-1 gap-4 md:grid-cols-3">
            <select name="condition" class="appearance-none rounded border-none bg-white px-4 py-3 text-sm font-semibold text-slate-700 focus:ring-2 focus:ring-primary">
              <option value="">Condition</option>
              <option value="new" @selected(($filters['condition'] ?? '') === 'new')>New</option>
              <option value="used" @selected(($filters['condition'] ?? '') === 'used')>Used</option>
            </select>
            <select name="make" class="appearance-none rounded border-none bg-white px-4 py-3 text-sm font-semibold text-slate-700 focus:ring-2 focus:ring-primary">
              <option value="">Make</option>
              @foreach (($filterOptions['makes'] ?? collect()) as $make)
                <option value="{{ $make }}" @selected(($filters['make'] ?? '') === $make)>{{ $make }}</option>
              @endforeach
            </select>
            <select name="model" class="appearance-none rounded border-none bg-white px-4 py-3 text-sm font-semibold text-slate-700 focus:ring-2 focus:ring-primary">
              <option value="">Model</option>
              @foreach (($filterOptions['models'] ?? collect()) as $model)
                <option value="{{ $model }}" @selected(($filters['model'] ?? '') === $model)>{{ $model }}</option>
              @endforeach
            </select>
          </div>
          <div class="flex gap-2 w-full md:w-auto">
            <button class="w-full rounded bg-primary px-8 py-3 text-sm font-bold uppercase tracking-widest text-on_surface transition-colors hover:bg-yellow-400 md:w-auto flex items-center justify-center" type="submit">
              <span class="material-symbols-outlined mr-2 text-xl">search</span> Search
            </button>
            <a href="{{ route('inventory.index') }}" class="bg-[#3a3f43] text-white px-4 py-3 rounded hover:bg-slate-700 transition-colors">
              <span class="material-symbols-outlined text-xl">restart_alt</span>
            </a>
          </div>
        </div>
      </form>
    </div>
  </section>

  <section class="bg-[#f4f5f7] py-16 md:py-20">
    <div class="container mx-auto max-w-[1240px] px-6 md:px-8">
      <div class="mb-10 md:mb-12 text-center">
        <h2 class="font-headline font-black text-4xl tracking-tight text-on_surface uppercase inline-block section-line">
          @if($recentFirstWords !== '')
            <span class="text-on_surface">{{ $recentFirstWords }}</span>
          @endif
          <span class="text-primary">{{ $recentLastWord }}</span>
        </h2>
        <p class="mt-3 max-w-xl mx-auto text-sm md:text-base text-slate-500">{{ $s['recent_subtitle'] ?? 'Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat.' }}</p>
      </div>
      <div class="grid grid-cols-1 gap-6 md:grid-cols-2 lg:grid-cols-3">
        @forelse ($recentVehicles as $vehicle)
          @php
            $img = $vehicle->images->first();
            $url = $img ? \App\Support\VehicleImageUrl::url($img->path) : \App\Support\PlaceholderMedia::url('asset/images/media/home-recent-fallback.jpg');
          @endphp
          <a href="{{ route('inventory.show', ['slug' => $vehicle->slug]) }}" class="group block overflow-hidden rounded-sm border border-slate-500/50 bg-[#232628] shadow-md transition hover:shadow-xl">
            <div class="relative aspect-[16/9] overflow-hidden">
              <img alt="{{ $vehicle->title }}" class="h-full w-full object-cover transition-transform duration-500 group-hover:scale-105" src="{{ $url }}"/>
              @if ($vehicle->is_special)
                <div class="pointer-events-none absolute -right-8 top-3 rotate-45 bg-[#3b63d6] px-10 py-1 text-[10px] font-bold uppercase tracking-wider text-white shadow-md">{{ __('Special') }}</div>
              @endif
            </div>
            <div class="border-t-2 border-[#3b63d6]/90 bg-[#31363c] px-4 pb-3.5 pt-3">
              <div class="flex items-start justify-between gap-2">
                <h3 class="line-clamp-1 min-w-0 flex-1 pr-1 font-headline text-[18px] md:text-[20px] font-black leading-tight text-white uppercase tracking-tight">{{ $vehicle->title }}</h3>
                <div class="shrink-0 rounded-sm bg-[#3b63d6] px-2 py-1 text-right text-white shadow-sm">
                  <div class="text-[8px] font-bold uppercase leading-none tracking-wide opacity-85">Buy online</div>
                  <div class="mt-0.5 text-[18px] font-black leading-none">${{ number_format((float) $vehicle->price, 0, '.', ',') }}</div>
                </div>
              </div>
              <div class="mt-2.5 flex flex-wrap items-center gap-x-4 gap-y-1 border-t border-slate-500/40 pt-2 text-[10px] md:text-[11px] font-semibold text-slate-300/95">
                <span class="flex items-center gap-1"><span class="material-symbols-outlined text-[14px]">speed</span> {{ number_format((int) ($vehicle->mileage ?? 0)) }} mi</span>
                <span class="flex items-center gap-1"><span class="material-symbols-outlined text-[14px]">settings_input_component</span> {{ strtoupper((string) ($vehicle->transmission ?? 'AUTO')) }}</span>
                <span class="flex items-center gap-1"><span class="material-symbols-outlined text-[14px]">calendar_today</span> {{ $vehicle->year ?? '—' }}</span>
              </div>
            </div>
          </a>
        @empty
          <p class="col-span-full text-center text-slate-500">Lorem ipsum: no listings yet. Seed or approve inventory to populate this grid.</p>
        @endforelse
      </div>
    </div>
  </section>

  <section
    class="relative bg-cover bg-center py-14 md:py-[4.5rem]"
    style="background-image: linear-gradient(rgba(255,255,255,0.12), rgba(255,255,255,0.12)), url('{{ e($dealerCtaBg) }}');"
  >
    <div class="mx-auto grid max-w-[1020px] grid-cols-1 gap-[18px] px-5 md:grid-cols-2">
      <div class="flex min-h-[260px] flex-col justify-start bg-white px-8 py-9 text-left shadow-[0_10px_25px_rgba(0,0,0,0.08)] md:min-h-[305px] md:px-10 md:py-10">
        <span class="material-symbols-outlined mb-7 text-5xl text-[#222]">{{ $leftCtaIcon }}</span>
        <h3 class="font-headline text-xl font-extrabold uppercase leading-snug tracking-tight text-[#101010] md:text-[22px]">{{ $s['cta_left_title'] ?? 'Looking for a car?' }}</h3>
        <p class="mt-4 max-w-[26rem] text-[15px] leading-[1.8] text-[#5c6670]">{{ $s['cta_left_body'] ?? '' }}</p>
        <a href="{{ $ctaLeftUrl }}" class="mt-8 inline-block bg-[#4b6ff7] px-8 py-3.5 text-[13px] font-bold uppercase tracking-wide text-white transition-colors hover:bg-[#3457e7]">{{ $s['cta_left_button_text'] ?? 'Inventory' }}</a>
      </div>
      <div class="flex min-h-[260px] flex-col justify-start bg-[#efb12c] px-8 py-9 text-left shadow-[0_10px_25px_rgba(0,0,0,0.08)] md:min-h-[305px] md:px-10 md:py-10">
        <span class="material-symbols-outlined mb-7 text-5xl text-[#222]">{{ $rightCtaIcon }}</span>
        <h3 class="font-headline text-xl font-extrabold uppercase leading-snug tracking-tight text-[#101010] md:text-[22px]">{{ $s['cta_right_title'] ?? 'Want to sell a car?' }}</h3>
        <p class="mt-4 max-w-[26rem] text-[15px] leading-[1.8] text-[#fff4d6]">{{ $s['cta_right_body'] ?? '' }}</p>
        <a href="{{ $ctaRightUrl }}" class="mt-8 inline-block bg-[#4b6ff7] px-8 py-3.5 text-[13px] font-bold uppercase tracking-wide text-white transition-colors hover:bg-[#3457e7]">{{ $s['cta_right_button_text'] ?? 'Sell your car' }}</a>
      </div>
    </div>
  </section>

  <section class="py-24 bg-surface-container-low border-b border-slate-200">
    <div class="container mx-auto px-8 grid grid-cols-1 md:grid-cols-3 gap-8">
      <div class="bg-white p-10 rounded shadow-sm border border-slate-100 flex flex-col items-center text-center">
        <div class="bg-slate-50 p-4 rounded-full mb-6"><span class="material-symbols-outlined text-primary text-2xl">stars</span></div>
        <h4 class="font-headline font-bold text-lg mb-4 uppercase tracking-tight">{{ $s['feat1_title'] ?? 'Lorem ipsum' }}</h4>
        <p class="text-slate-500 text-sm leading-relaxed">{{ $s['feat1_body'] ?? 'Dolor sit amet, consectetur adipiscing elit.' }}</p>
      </div>
      <div class="bg-white p-10 rounded shadow-sm border border-slate-100 flex flex-col items-center text-center">
        <div class="bg-slate-50 p-4 rounded-full mb-6"><span class="material-symbols-outlined text-primary text-2xl">groups</span></div>
        <h4 class="font-headline font-bold text-lg mb-4 uppercase tracking-tight">{{ $s['feat2_title'] ?? 'Dolor sit amet' }}</h4>
        <p class="text-slate-500 text-sm leading-relaxed">{{ $s['feat2_body'] ?? 'Sed cursus ante dapibus diam. Sed nisi.' }}</p>
      </div>
      <div class="bg-white p-10 rounded shadow-sm border border-slate-100 flex flex-col items-center text-center">
        <div class="bg-slate-50 p-4 rounded-full mb-6"><span class="material-symbols-outlined text-primary text-2xl">build</span></div>
        <h4 class="font-headline font-bold text-lg mb-4 uppercase tracking-tight">{{ $s['feat3_title'] ?? 'Consectetur elit' }}</h4>
        <p class="text-slate-500 text-sm leading-relaxed">{{ $s['feat3_body'] ?? 'Fusce nec tellus sed augue semper porta.' }}</p>
      </div>
    </div>
  </section>

  <section class="relative bg-inverse-surface bg-cover bg-center py-24" style="background-image:url('{{ e($testimonialBg) }}');">
    <div class="absolute inset-0" style="background-color: rgba(0,0,0,{{ $testimonialOverlay }});"></div>
    <div class="container relative z-10 mx-auto flex flex-col items-center px-8 text-center">
      <div class="mb-6 h-24 w-24 overflow-hidden rounded-full border-4 border-white"><img alt="" class="h-full w-full object-cover" src="{{ $testimonialAvatar }}"/></div>
      <h6 class="mb-1 font-headline text-xl font-bold uppercase tracking-widest text-white">{{ strtoupper($s['testimonial_name'] ?? 'Lorem Ipsum') }}</h6>
      <p class="mb-8 text-xs font-bold uppercase text-primary">{{ $s['testimonial_role'] ?? 'Lorem role' }}</p>
      <p class="max-w-3xl font-headline text-2xl font-light italic leading-relaxed text-white">&ldquo;{{ $s['testimonial_quote'] ?? 'Lorem ipsum dolor sit amet, consectetur adipiscing elit.' }}&rdquo;</p>
    </div>
  </section>

  <section class="overflow-hidden bg-slate-50 py-16 md:py-32">
    <div class="container mx-auto max-w-6xl px-4 sm:px-6 md:px-8">
      <div class="relative rounded-2xl bg-white p-6 shadow-2xl md:p-16" data-home-stats-root>
        <div class="grid grid-cols-1 items-center gap-8 md:grid-cols-[1fr_auto_1fr] md:gap-10">
          <div class="grid gap-8 text-center md:gap-16 md:text-left">
            <div>
              <span class="font-headline block text-6xl font-black leading-none text-slate-900" data-count-up data-target="{{ max(0, $approvedCount) }}">0</span>
              <span class="mt-4 block text-[11px] font-bold uppercase tracking-[0.2em] text-slate-400">{{ $s['stats_metric_1_label'] ?? 'Listings' }}</span>
            </div>
            <div>
              <span class="font-headline block text-6xl font-black leading-none text-slate-900" data-count-up data-target="{{ $statsM2 }}">0</span>
              <span class="mt-4 block text-[11px] font-bold uppercase tracking-[0.2em] text-slate-400">{{ $s['stats_metric_2_label'] ?? 'Metric two' }}</span>
            </div>
          </div>
          <div class="mx-auto"><img class="h-auto w-52 drop-shadow-2xl sm:w-64 md:w-80" src="{{ $statsCar }}" alt=""/></div>
          <div class="grid gap-8 text-center md:gap-16 md:text-right">
            <div>
              <span class="font-headline block text-6xl font-black leading-none text-slate-900" data-count-up data-target="{{ $statsM3 }}">0</span>
              <span class="mt-4 block text-[11px] font-bold uppercase tracking-[0.2em] text-slate-400">{{ $s['stats_metric_3_label'] ?? 'Metric three' }}</span>
            </div>
            <div>
              <span class="font-headline block text-6xl font-black leading-none text-slate-900" data-count-up data-target="{{ $statsM4 }}">0</span>
              <span class="mt-4 block text-[11px] font-bold uppercase tracking-[0.2em] text-slate-400">{{ $s['stats_metric_4_label'] ?? 'Metric four' }}</span>
            </div>
          </div>
        </div>
      </div>
    </div>
  </section>

  <section class="bg-white py-32">
    <div class="container mx-auto flex flex-col items-center px-8 text-center">
      <h2 class="mb-8 font-headline text-4xl font-black uppercase tracking-tight">{{ $s['welcome_title'] ?? 'Lorem ipsum welcome block' }}</h2>
      <p class="mb-12 max-w-3xl font-body text-lg leading-relaxed text-slate-500">{{ $s['welcome_body'] ?? 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Duis sagittis ipsum. Praesent mauris.' }}</p>
      @if ($welcomeYoutubeWatch)
        <a href="{{ $welcomeYoutubeWatch }}" target="_blank" rel="noopener noreferrer" class="flex h-20 w-20 items-center justify-center rounded-full bg-[#4a69e2] shadow-lg transition-transform hover:scale-110" aria-label="{{ __('Watch video') }}">
          <span class="material-symbols-outlined ml-1 text-4xl text-white" style="font-variation-settings: 'FILL' 1;">play_arrow</span>
        </a>
      @else
        <div class="flex h-20 w-20 cursor-not-allowed items-center justify-center rounded-full bg-slate-300 shadow-lg opacity-60" title="{{ __('Add a YouTube URL in Admin → Pages → Home') }}">
          <span class="material-symbols-outlined ml-1 text-4xl text-white" style="font-variation-settings: 'FILL' 1;">play_arrow</span>
        </div>
      @endif
    </div>
  </section>

  <section class="bg-primary py-8 md:py-10">
    <div class="container mx-auto flex flex-col items-stretch justify-between gap-5 px-4 sm:px-6 md:flex-row md:items-center md:gap-6 md:px-8">
      <div class="flex items-center gap-3 text-on_surface md:gap-4">
        <span class="material-symbols-outlined text-3xl">help</span>
        <h3 class="font-headline text-lg font-bold tracking-tight uppercase md:text-xl">Lorem ipsum — questions?</h3>
      </div>
      <div class="flex w-full flex-col gap-3 sm:flex-row sm:items-center sm:justify-between md:w-auto md:gap-6">
        <div class="flex items-center gap-2.5"><span class="material-symbols-outlined text-slate-800">call</span><p class="font-headline text-xl font-black text-slate-900 sm:text-2xl">{{ $dealerPhone ?? '' }}</p></div>
        <a href="{{ route('contact') }}" class="inline-flex items-center justify-center rounded border border-slate-900/10 bg-white/20 px-6 py-3 text-xs font-bold uppercase tracking-widest text-slate-900 transition-all hover:bg-white/40 sm:px-8"><span class="material-symbols-outlined mr-1 text-sm align-middle">mail</span> Lorem contact</a>
      </div>
    </div>
  </section>
@endsection
