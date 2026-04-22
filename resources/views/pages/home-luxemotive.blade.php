@extends('layouts.site')

@php
  $s = $sections ?? [];
  $heroTitle = $s['hero_title'] ?? 'Lorem ipsum dolor sit amet';
  $heroSubtitle = $s['hero_subtitle'] ?? 'Consectetur adipiscing elit';
  $heroBg = \App\Support\PlaceholderMedia::url($s['hero_image'] ?? 'asset/images/media/home-hero-main.jpg');
  $ctaLeftBg = \App\Support\PlaceholderMedia::url($s['cta_left_image'] ?? 'asset/images/media/home-cta-left.jpg');
  $ctaRightBg = \App\Support\PlaceholderMedia::url($s['cta_right_image'] ?? 'asset/images/media/home-cta-right.jpg');
  $statsBg = \App\Support\PlaceholderMedia::url('asset/images/media/home-stats-bg.jpg');
  $testimonialAvatar = \App\Support\PlaceholderMedia::url('asset/images/media/home-testimonial-avatar.jpg');
  $statsCar = \App\Support\PlaceholderMedia::url('asset/images/media/home-stats-car.jpg');
  $heroCtaHref = $s['hero_cta_href'] ?? '/inventory';
  $heroCtaUrl = \Illuminate\Support\Str::startsWith($heroCtaHref, ['http://', 'https://']) ? $heroCtaHref : url($heroCtaHref);
  $approvedCount = (int) ($approvedListingCount ?? 0);
  $recentTitleRaw = trim((string) ($s['recent_title'] ?? 'RECENT CARS'));
  $recentTitleParts = preg_split('/\s+/', $recentTitleRaw) ?: ['RECENT', 'CARS'];
  $recentLastWord = array_pop($recentTitleParts) ?: 'CARS';
  $recentFirstWords = trim(implode(' ', $recentTitleParts));
@endphp

@section('content')
  {{-- Homepage does not render legacy WordPress/Elementor HTML here. Use Admin → Page Editors → Home for section copy and optional Content HTML on other pages. --}}

  <section class="relative h-[85vh] flex items-center overflow-hidden">
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

  <section class="container mx-auto px-8 -mt-16 relative z-20">
    <div class="rounded-lg bg-[#232628] p-7 shadow-2xl md:p-8 ring-1 ring-black/20">
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
              <div class="pointer-events-none absolute -right-8 top-3 rotate-45 bg-[#3b63d6] px-10 py-1 text-[10px] font-bold uppercase tracking-wider text-white shadow-md">Special</div>
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

  <section class="flex flex-col md:flex-row md:h-[500px]">
    <div class="relative flex min-h-[250px] flex-1 items-center justify-center overflow-hidden p-6 text-center group md:p-12">
      <div class="absolute inset-0 bg-cover bg-center" style="background-image: url('{{ $ctaLeftBg }}');"></div>
      <div class="absolute inset-0 m-0 my-px bg-black/60 p-0 transition-all duration-500 group-hover:bg-black/40"></div>
      <div class="relative z-10 text-white">
        <span class="material-symbols-outlined text-4xl mb-4">directions_car</span>
        <h3 class="mb-4 font-headline text-2xl font-black tracking-tight uppercase md:mb-6 md:text-4xl">{{ $s['cta_left_title'] ?? 'Lorem ipsum dolor' }}</h3>
        <p class="mx-auto mb-6 max-w-xs leading-relaxed opacity-90 md:mb-10">{{ $s['cta_left_body'] ?? 'Sit amet, consectetur adipiscing elit.' }}</p>
        <a href="{{ route('inventory.index') }}" class="inline-block rounded bg-[#4a69e2] px-8 py-3 text-xs font-bold uppercase tracking-widest text-white shadow-xl transition-all hover:bg-blue-700 md:px-10 md:py-4">Lorem link</a>
      </div>
    </div>
    <div class="relative flex min-h-[250px] flex-1 items-center justify-center overflow-hidden p-6 text-center group md:p-12">
      <div class="absolute inset-0 bg-cover bg-center" style="background-image: url('{{ $ctaRightBg }}');"></div>
      <div class="absolute inset-0 m-0 my-px bg-[#ffb129]/80 p-0 transition-all duration-500 group-hover:bg-[#ffb129]/70"></div>
      <div class="relative z-10 text-slate-900">
        <span class="material-symbols-outlined text-4xl mb-4">sell</span>
        <h3 class="mb-4 font-headline text-2xl font-black tracking-tight uppercase md:mb-6 md:text-4xl">{{ $s['cta_right_title'] ?? 'Consectetur adipiscing' }}</h3>
        <p class="mx-auto mb-6 max-w-xs leading-relaxed opacity-90 md:mb-10">{{ $s['cta_right_body'] ?? 'Elit sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.' }}</p>
        <a href="{{ auth()->check() ? route('dashboard.vehicles.create') : route('register') }}" class="inline-block rounded bg-[#4a69e2] px-8 py-3 text-xs font-bold uppercase tracking-widest text-white shadow-xl transition-all hover:bg-blue-700 md:px-10 md:py-4">Lorem action</a>
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

  <section class="bg-inverse-surface py-24 relative" style="background-image:url('{{ $statsBg }}');background-size:cover;background-position:center;">
    <div class="absolute inset-0 bg-black/70"></div>
    <div class="container mx-auto px-8 relative z-10 flex flex-col items-center text-center">
      <div class="w-24 h-24 rounded-full border-4 border-white overflow-hidden mb-6"><img alt="" class="w-full h-full object-cover" src="{{ $testimonialAvatar }}"/></div>
      <h6 class="text-white font-headline font-bold text-xl uppercase tracking-widest mb-1">{{ strtoupper($s['testimonial_name'] ?? 'Lorem Ipsum') }}</h6>
      <p class="text-primary font-bold text-xs uppercase mb-8">{{ $s['testimonial_role'] ?? 'Lorem role' }}</p>
      <p class="text-white font-headline font-light text-2xl italic max-w-3xl leading-relaxed">&ldquo;{{ $s['testimonial_quote'] ?? 'Lorem ipsum dolor sit amet, consectetur adipiscing elit.' }}&rdquo;</p>
    </div>
  </section>

  <section class="overflow-hidden bg-slate-50 py-16 md:py-32">
    <div class="container mx-auto max-w-6xl px-4 sm:px-6 md:px-8">
      <div class="relative rounded-2xl bg-white p-6 shadow-2xl md:p-16">
        <div class="grid grid-cols-1 items-center gap-8 md:grid-cols-[1fr_auto_1fr] md:gap-10">
          <div class="grid gap-8 text-center md:gap-16 md:text-left">
          <div><span class="font-headline font-black text-6xl text-slate-900 block leading-none">{{ max(0, $approvedCount) }}</span><span class="font-bold text-[11px] tracking-[0.2em] text-slate-400 uppercase mt-4 block">Lorem — listings</span></div>
          <div><span class="font-headline font-black text-6xl text-slate-900 block leading-none">00</span><span class="font-bold text-[11px] tracking-[0.2em] text-slate-400 uppercase mt-4 block">Lorem — metric two</span></div>
          </div>
          <div class="mx-auto"><img class="h-auto w-52 drop-shadow-2xl sm:w-64 md:w-80" src="{{ $statsCar }}" alt=""/></div>
          <div class="grid gap-8 text-center md:gap-16 md:text-right">
          <div><span class="font-headline font-black text-6xl text-slate-900 block leading-none">00</span><span class="font-bold text-[11px] tracking-[0.2em] text-slate-400 uppercase mt-4 block">Lorem — metric three</span></div>
          <div><span class="font-headline font-black text-6xl text-slate-900 block leading-none">00</span><span class="font-bold text-[11px] tracking-[0.2em] text-slate-400 uppercase mt-4 block">Lorem — metric four</span></div>
          </div>
        </div>
      </div>
    </div>
  </section>

  <section class="py-32 bg-white">
    <div class="container mx-auto px-8 flex flex-col items-center text-center">
      <h2 class="font-headline font-black text-4xl tracking-tight mb-8 uppercase">{{ $s['welcome_title'] ?? 'Lorem ipsum welcome block' }}</h2>
      <p class="max-w-3xl text-slate-500 leading-relaxed font-body text-lg mb-12">{{ $s['welcome_body'] ?? 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Duis sagittis ipsum. Praesent mauris.' }}</p>
      <div class="w-20 h-20 bg-[#4a69e2] rounded-full flex items-center justify-center cursor-pointer hover:scale-110 transition-transform shadow-lg"><span class="material-symbols-outlined text-white text-4xl ml-1" style="font-variation-settings: 'FILL' 1;">play_arrow</span></div>
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
