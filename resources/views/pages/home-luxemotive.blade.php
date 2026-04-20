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
    <div class="bg-[#232628] p-8 shadow-2xl rounded-lg">
      <form method="get" action="{{ route('inventory.index') }}" class="flex flex-col md:flex-row items-center gap-4">
        <div class="flex items-center gap-3 text-white mb-4 md:mb-0 md:mr-6">
          <span class="material-symbols-outlined text-3xl">search_insights</span>
          <span class="font-headline font-bold text-xl uppercase tracking-tight">{{ $s['home_search_label'] ?? 'Lorem ipsum — search inventory' }}</span>
        </div>
        <div class="flex-1 grid grid-cols-1 md:grid-cols-3 gap-4 w-full">
          <select name="condition" class="bg-white border-none rounded font-medium text-sm py-3 px-4 focus:ring-2 focus:ring-primary appearance-none">
            <option value="">Condition</option>
            <option value="new" @selected(($filters['condition'] ?? '') === 'new')>New</option>
            <option value="used" @selected(($filters['condition'] ?? '') === 'used')>Used</option>
          </select>
          <select name="make" class="bg-white border-none rounded font-medium text-sm py-3 px-4 focus:ring-2 focus:ring-primary appearance-none">
            <option value="">Make</option>
            @foreach (($filterOptions['makes'] ?? collect()) as $make)
              <option value="{{ $make }}" @selected(($filters['make'] ?? '') === $make)>{{ $make }}</option>
            @endforeach
          </select>
          <select name="model" class="bg-white border-none rounded font-medium text-sm py-3 px-4 focus:ring-2 focus:ring-primary appearance-none">
            <option value="">Model</option>
            @foreach (($filterOptions['models'] ?? collect()) as $model)
              <option value="{{ $model }}" @selected(($filters['model'] ?? '') === $model)>{{ $model }}</option>
            @endforeach
          </select>
        </div>
        <div class="flex gap-2 w-full md:w-auto">
          <button class="bg-primary text-on_surface px-8 py-3 font-bold tracking-widest text-sm flex items-center justify-center hover:bg-yellow-400 transition-colors uppercase rounded w-full md:w-auto" type="submit">
            <span class="material-symbols-outlined mr-2 text-xl">search</span> Search
          </button>
          <a href="{{ route('inventory.index') }}" class="bg-[#3a3f43] text-white px-4 py-3 rounded hover:bg-slate-700 transition-colors">
            <span class="material-symbols-outlined text-xl">restart_alt</span>
          </a>
        </div>
      </form>
    </div>
  </section>

  <section class="py-24 bg-white">
    <div class="container mx-auto px-8">
      <div class="text-center mb-16">
        <h2 class="font-headline font-black text-4xl tracking-tight text-on_surface uppercase inline-block section-line">{{ $s['recent_title'] ?? 'Lorem dolor sit amet' }}</h2>
        <p class="text-slate-500 mt-4 max-w-lg mx-auto">{{ $s['recent_subtitle'] ?? 'Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat.' }}</p>
      </div>
      <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
        @forelse ($recentVehicles as $vehicle)
          @php
            $img = $vehicle->images->first();
            $url = $img ? \App\Support\VehicleImageUrl::url($img->path) : \App\Support\PlaceholderMedia::url('asset/images/media/home-recent-fallback.jpg');
          @endphp
          <a href="{{ route('inventory.show', ['slug' => $vehicle->slug]) }}" class="bg-[#232628] rounded-lg overflow-hidden group cursor-pointer border border-slate-800 block">
            <div class="relative aspect-[16/10] overflow-hidden">
              <img alt="{{ $vehicle->title }}" class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-500" src="{{ $url }}"/>
              <div class="absolute bottom-0 right-0 bg-[#3b63d6] text-white px-4 py-2 font-bold flex flex-col items-end">
                <span class="text-[10px] opacity-80 leading-none">Lorem price</span>
                <span class="text-lg">${{ number_format((float) $vehicle->price, 0, '.', ',') }}</span>
              </div>
            </div>
            <div class="p-6">
              <h3 class="text-white font-headline font-bold text-lg mb-4 uppercase">{{ $vehicle->title }}</h3>
              <div class="flex justify-between text-slate-400 text-[11px] font-bold border-t border-slate-700 pt-4">
                <span class="flex items-center gap-1.5"><span class="material-symbols-outlined text-[16px]">speed</span> {{ number_format((int) ($vehicle->mileage ?? 0)) }} mi</span>
                <span class="flex items-center gap-1.5"><span class="material-symbols-outlined text-[16px]">settings_input_component</span> {{ strtoupper((string) ($vehicle->transmission ?? 'AUTO')) }}</span>
                <span class="flex items-center gap-1.5"><span class="material-symbols-outlined text-[16px]">calendar_today</span> {{ $vehicle->year ?? '—' }}</span>
              </div>
            </div>
          </a>
        @empty
          <p class="col-span-full text-center text-slate-500">Lorem ipsum: no listings yet. Seed or approve inventory to populate this grid.</p>
        @endforelse
      </div>
    </div>
  </section>

  <section class="flex flex-col md:flex-row h-[500px]">
    <div class="flex-1 relative overflow-hidden group flex items-center justify-center text-center p-12">
      <div class="absolute inset-0 bg-cover bg-center" style="background-image: url('{{ $ctaLeftBg }}');"></div>
      <div class="absolute inset-0 bg-black/60 group-hover:bg-black/40 transition-all duration-500"></div>
      <div class="relative z-10 text-white">
        <span class="material-symbols-outlined text-4xl mb-4">directions_car</span>
        <h3 class="font-headline font-black text-3xl md:text-4xl mb-6 tracking-tight uppercase">{{ $s['cta_left_title'] ?? 'Lorem ipsum dolor' }}</h3>
        <p class="max-w-xs mx-auto mb-10 opacity-90 leading-relaxed">{{ $s['cta_left_body'] ?? 'Sit amet, consectetur adipiscing elit.' }}</p>
        <a href="{{ route('inventory.index') }}" class="bg-[#4a69e2] text-white px-10 py-4 font-bold text-xs tracking-widest uppercase rounded shadow-xl hover:bg-blue-700 transition-all inline-block">Lorem link</a>
      </div>
    </div>
    <div class="flex-1 relative overflow-hidden group flex items-center justify-center text-center p-12">
      <div class="absolute inset-0 bg-cover bg-center" style="background-image: url('{{ $ctaRightBg }}');"></div>
      <div class="absolute inset-0 bg-[#ffb129]/80 group-hover:bg-[#ffb129]/70 transition-all duration-500"></div>
      <div class="relative z-10 text-slate-900">
        <span class="material-symbols-outlined text-4xl mb-4">sell</span>
        <h3 class="font-headline font-black text-3xl md:text-4xl mb-6 tracking-tight uppercase">{{ $s['cta_right_title'] ?? 'Consectetur adipiscing' }}</h3>
        <p class="max-w-xs mx-auto mb-10 opacity-90 leading-relaxed">{{ $s['cta_right_body'] ?? 'Elit sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.' }}</p>
        <a href="{{ auth()->check() ? route('dashboard.vehicles.create') : route('register') }}" class="bg-[#4a69e2] text-white px-10 py-4 font-bold text-xs tracking-widest uppercase rounded shadow-xl hover:bg-blue-700 transition-all inline-block">Lorem action</a>
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

  <section class="py-32 bg-slate-50 overflow-hidden">
    <div class="container mx-auto px-8 max-w-6xl">
      <div class="bg-white rounded-2xl shadow-2xl p-16 flex flex-col md:flex-row items-center justify-between relative">
        <div class="flex flex-col gap-24 text-left z-10">
          <div><span class="font-headline font-black text-6xl text-slate-900 block leading-none">{{ max(0, $approvedCount) }}</span><span class="font-bold text-[11px] tracking-[0.2em] text-slate-400 uppercase mt-4 block">Lorem — listings</span></div>
          <div><span class="font-headline font-black text-6xl text-slate-900 block leading-none">00</span><span class="font-bold text-[11px] tracking-[0.2em] text-slate-400 uppercase mt-4 block">Lorem — metric two</span></div>
        </div>
        <div class="my-12 md:my-0 scale-110"><img class="w-64 md:w-80 h-auto drop-shadow-2xl" src="{{ $statsCar }}" alt=""/></div>
        <div class="flex flex-col gap-24 text-right z-10">
          <div><span class="font-headline font-black text-6xl text-slate-900 block leading-none">00</span><span class="font-bold text-[11px] tracking-[0.2em] text-slate-400 uppercase mt-4 block">Lorem — metric three</span></div>
          <div><span class="font-headline font-black text-6xl text-slate-900 block leading-none">00</span><span class="font-bold text-[11px] tracking-[0.2em] text-slate-400 uppercase mt-4 block">Lorem — metric four</span></div>
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

  <section class="bg-primary py-10">
    <div class="container mx-auto px-8 flex flex-col md:flex-row justify-between items-center gap-6">
      <div class="flex items-center gap-4 text-on_surface">
        <span class="material-symbols-outlined text-3xl">help</span>
        <h3 class="font-headline font-bold text-xl tracking-tight uppercase">Lorem ipsum — questions?</h3>
      </div>
      <div class="flex items-center gap-10">
        <div class="flex items-center gap-3"><span class="material-symbols-outlined text-slate-800">call</span><p class="font-headline font-black text-2xl text-slate-900">{{ $dealerPhone ?? '' }}</p></div>
        <a href="{{ route('contact') }}" class="bg-white/20 border border-slate-900/10 text-slate-900 px-8 py-3 font-bold tracking-widest text-xs uppercase hover:bg-white/40 transition-all rounded inline-flex items-center"><span class="material-symbols-outlined text-sm align-middle mr-1">mail</span> Lorem contact</a>
      </div>
    </div>
  </section>
@endsection
