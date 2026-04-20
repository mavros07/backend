@extends('layouts.site')

@php
  $hero = $heroVehicle ?? null;
  $brand = config('app.name', 'LUXEMOTIVE');
  $heroTitle = $hero?->title ?? 'Mercedes-Benz AMG GT 2017';
  $heroBg = $hero?->images?->first()?->path
      ? \App\Support\VehicleImageUrl::url($hero->images->first()->path)
      : asset('asset/images/media/home-hero-main.jpg');
  $ctaLeftBg = asset('asset/images/media/home-cta-left.jpg');
  $ctaRightBg = asset('asset/images/media/home-cta-right.jpg');
  $statsBg = asset('asset/images/media/home-stats-bg.jpg');
  $testimonialAvatar = asset('asset/images/media/home-testimonial-avatar.jpg');
  $statsCar = asset('asset/images/media/home-stats-car.jpg');
@endphp

@section('content')
  <section class="relative h-[85vh] flex items-center overflow-hidden">
    <div class="absolute inset-0 bg-cover bg-center" style="background-image: url('{{ e($heroBg) }}');"></div>
    <div class="absolute inset-0 hero-gradient"></div>
    <div class="relative z-10 container mx-auto px-8 text-center">
      <h1 class="text-white font-headline font-black text-4xl md:text-7xl leading-tight tracking-tight uppercase">{{ $heroTitle }}</h1>
      <p class="text-primary font-bold tracking-widest mt-6 text-3xl uppercase">$320 <span class="text-white text-xl">/mo for 36 months</span></p>
    </div>
  </section>

  <section class="container mx-auto px-8 -mt-16 relative z-20">
    <div class="bg-[#232628] p-8 shadow-2xl rounded-lg">
      <form method="get" action="{{ route('inventory.index') }}" class="flex flex-col md:flex-row items-center gap-4">
        <div class="flex items-center gap-3 text-white mb-4 md:mb-0 md:mr-6">
          <span class="material-symbols-outlined text-3xl">search_insights</span>
          <span class="font-headline font-bold text-xl uppercase tracking-tight">Search Inventory</span>
        </div>
        <div class="flex-1 grid grid-cols-1 md:grid-cols-3 gap-4 w-full">
          <select name="condition" class="bg-white border-none rounded font-medium text-sm py-3 px-4 focus:ring-2 focus:ring-primary appearance-none">
            <option value="">Condition</option>
            <option value="new" @selected(($filters['condition'] ?? '') === 'new')>New Cars</option>
            <option value="used" @selected(($filters['condition'] ?? '') === 'used')>Used Cars</option>
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
        <h2 class="font-headline font-black text-4xl tracking-tight text-on_surface uppercase inline-block section-line">RECENT <span class="text-primary">CARS</span></h2>
        <p class="text-slate-500 mt-4 max-w-lg mx-auto">Curabitur tellus leo, euismod sit amet gravida at, egestas sed commodo.</p>
      </div>
      <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
        @forelse ($recentVehicles as $vehicle)
          @php
            $img = $vehicle->images->first();
            $url = $img ? \App\Support\VehicleImageUrl::url($img->path) : asset('asset/images/media/home-recent-fallback.jpg');
          @endphp
          <a href="{{ route('inventory.show', ['slug' => $vehicle->slug]) }}" class="bg-[#232628] rounded-lg overflow-hidden group cursor-pointer border border-slate-800 block">
            <div class="relative aspect-[16/10] overflow-hidden">
              <img alt="{{ $vehicle->title }}" class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-500" src="{{ $url }}"/>
              <div class="absolute bottom-0 right-0 bg-[#3b63d6] text-white px-4 py-2 font-bold flex flex-col items-end">
                <span class="text-[10px] opacity-80 leading-none">BUY ONLINE</span>
                <span class="text-lg">${{ number_format((float) $vehicle->price, 0, '.', ',') }}</span>
              </div>
            </div>
            <div class="p-6">
              <h3 class="text-white font-headline font-bold text-lg mb-4 uppercase">{{ $vehicle->title }}</h3>
              <div class="flex justify-between text-slate-400 text-[11px] font-bold border-t border-slate-700 pt-4">
                <span class="flex items-center gap-1.5"><span class="material-symbols-outlined text-[16px]">speed</span> {{ number_format((int) ($vehicle->mileage ?? 0)) }} MI</span>
                <span class="flex items-center gap-1.5"><span class="material-symbols-outlined text-[16px]">settings_input_component</span> {{ strtoupper((string) ($vehicle->transmission ?? 'AUTO')) }}</span>
                <span class="flex items-center gap-1.5"><span class="material-symbols-outlined text-[16px]">calendar_today</span> {{ $vehicle->year ?? '----' }}</span>
              </div>
            </div>
          </a>
        @empty
          <p class="col-span-full text-center text-slate-500">No vehicles available.</p>
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
        <h3 class="font-headline font-black text-4xl mb-6 tracking-tight uppercase">LOOKING FOR A CAR?</h3>
        <p class="max-w-xs mx-auto mb-10 opacity-90 leading-relaxed">Our cars are delivered fully-registered with all requirements completed. We'll deliver your car wherever you are.</p>
        <a href="{{ route('inventory.index') }}" class="bg-[#4a69e2] text-white px-10 py-4 font-bold text-xs tracking-widest uppercase rounded shadow-xl hover:bg-blue-700 transition-all inline-block">INVENTORY</a>
      </div>
    </div>
    <div class="flex-1 relative overflow-hidden group flex items-center justify-center text-center p-12">
      <div class="absolute inset-0 bg-cover bg-center" style="background-image: url('{{ $ctaRightBg }}');"></div>
      <div class="absolute inset-0 bg-[#ffb129]/80 group-hover:bg-[#ffb129]/70 transition-all duration-500"></div>
      <div class="relative z-10 text-slate-900">
        <span class="material-symbols-outlined text-4xl mb-4">sell</span>
        <h3 class="font-headline font-black text-4xl mb-6 tracking-tight uppercase">WANT TO SELL A CAR?</h3>
        <p class="max-w-xs mx-auto mb-10 opacity-90 leading-relaxed">Receive the absolute best value for your trade-in vehicle. We even handle all paperwork. Schedule appointment!</p>
        <a href="{{ auth()->check() ? route('dashboard.vehicles.create') : route('register') }}" class="bg-[#4a69e2] text-white px-10 py-4 font-bold text-xs tracking-widest uppercase rounded shadow-xl hover:bg-blue-700 transition-all inline-block">SELL YOUR CAR</a>
      </div>
    </div>
  </section>

  <section class="py-24 bg-surface-container-low border-b border-slate-200">
    <div class="container mx-auto px-8 grid grid-cols-1 md:grid-cols-3 gap-8">
      <div class="bg-white p-10 rounded shadow-sm border border-slate-100 flex flex-col items-center text-center">
        <div class="bg-slate-50 p-4 rounded-full mb-6"><span class="material-symbols-outlined text-primary text-2xl">stars</span></div>
        <h4 class="font-headline font-bold text-lg mb-4 uppercase tracking-tight">WIDE RANGE OF BRANDS</h4>
        <p class="text-slate-500 text-sm leading-relaxed">With a robust selection of popular vehicles on hand, as well as leading vehicles from BMW and Ford.</p>
      </div>
      <div class="bg-white p-10 rounded shadow-sm border border-slate-100 flex flex-col items-center text-center">
        <div class="bg-slate-50 p-4 rounded-full mb-6"><span class="material-symbols-outlined text-primary text-2xl">groups</span></div>
        <h4 class="font-headline font-bold text-lg mb-4 uppercase tracking-tight">TRUSTED BY THOUSANDS</h4>
        <p class="text-slate-500 text-sm leading-relaxed">10 new offers every day. 350 offers on site, trusted by a community of thousands of users.</p>
      </div>
      <div class="bg-white p-10 rounded shadow-sm border border-slate-100 flex flex-col items-center text-center">
        <div class="bg-slate-50 p-4 rounded-full mb-6"><span class="material-symbols-outlined text-primary text-2xl">build</span></div>
        <h4 class="font-headline font-bold text-lg mb-4 uppercase tracking-tight">SERVICE &amp; MAINTENANCE</h4>
        <p class="text-slate-500 text-sm leading-relaxed">Our stress-free finance department that can find financial solutions to save you money.</p>
      </div>
    </div>
  </section>

  <section class="bg-inverse-surface py-24 relative" style="background-image:url('{{ $statsBg }}');background-size:cover;background-position:center;">
    <div class="absolute inset-0 bg-black/70"></div>
    <div class="container mx-auto px-8 relative z-10 flex flex-col items-center text-center">
      <div class="w-24 h-24 rounded-full border-4 border-white overflow-hidden mb-6"><img alt="Robert Frost" class="w-full h-full object-cover" src="{{ $testimonialAvatar }}"/></div>
      <h6 class="text-white font-headline font-bold text-xl uppercase tracking-widest mb-1">ROBERT FROST</h6>
      <p class="text-primary font-bold text-xs uppercase mb-8">Teacher</p>
      <p class="text-white font-headline font-light text-2xl italic max-w-3xl leading-relaxed">"Lorem ipsum dolor sit amet, consectetur adipiscing elit. In fringilla, velit id laoreet hendrerit, sapien nisl varius dolor, eu consequat erat augue in eros. Fusce non orci vitae eros porta consequat non at ante. Etiam et ligula quam."</p>
    </div>
  </section>

  <section class="py-32 bg-slate-50 overflow-hidden">
    <div class="container mx-auto px-8 max-w-6xl">
      <div class="bg-white rounded-2xl shadow-2xl p-16 flex flex-col md:flex-row items-center justify-between relative">
        <div class="flex flex-col gap-24 text-left z-10">
          <div><span class="font-headline font-black text-6xl text-slate-900 block leading-none">17600</span><span class="font-bold text-[11px] tracking-[0.2em] text-slate-400 uppercase mt-4 block">CARS FOR SALE</span></div>
          <div><span class="font-headline font-black text-6xl text-slate-900 block leading-none">6230</span><span class="font-bold text-[11px] tracking-[0.2em] text-slate-400 uppercase mt-4 block">VISITORS PER DAY</span></div>
        </div>
        <div class="my-12 md:my-0 scale-110"><img class="w-64 md:w-80 h-auto drop-shadow-2xl" src="{{ $statsCar }}" alt="Top down silver car"/></div>
        <div class="flex flex-col gap-24 text-right z-10">
          <div><span class="font-headline font-black text-6xl text-slate-900 block leading-none">3500</span><span class="font-bold text-[11px] tracking-[0.2em] text-slate-400 uppercase mt-4 block">DEALER REVIEWS</span></div>
          <div><span class="font-headline font-black text-6xl text-slate-900 block leading-none">2250</span><span class="font-bold text-[11px] tracking-[0.2em] text-slate-400 uppercase mt-4 block">VERIFIED DEALERS</span></div>
        </div>
      </div>
    </div>
  </section>

  <section class="py-32 bg-white">
    <div class="container mx-auto px-8 flex flex-col items-center text-center">
      <h2 class="font-headline font-black text-4xl tracking-tight mb-8 uppercase">WELCOME TO <span class="text-primary">{{ strtoupper($brand) }}</span></h2>
      <p class="max-w-3xl text-slate-500 leading-relaxed font-body text-lg mb-12">With specialists on hand to help with any part of the car shopping or vehicle ownership experience, {{ $brand }} provides financing, car service and a great selection of vehicles for luxury car shoppers.</p>
      <div class="w-20 h-20 bg-[#4a69e2] rounded-full flex items-center justify-center cursor-pointer hover:scale-110 transition-transform shadow-lg"><span class="material-symbols-outlined text-white text-4xl ml-1" style="font-variation-settings: 'FILL' 1;">play_arrow</span></div>
    </div>
  </section>

  <section class="bg-primary py-10">
    <div class="container mx-auto px-8 flex flex-col md:flex-row justify-between items-center gap-6">
      <div class="flex items-center gap-4 text-on_surface">
        <span class="material-symbols-outlined text-3xl">help</span>
        <h3 class="font-headline font-bold text-xl tracking-tight uppercase">HAVE QUESTIONS? FEEL FREE TO ASK...</h3>
      </div>
      <div class="flex items-center gap-10">
        <div class="flex items-center gap-3"><span class="material-symbols-outlined text-slate-800">call</span><p class="font-headline font-black text-2xl text-slate-900">{{ $dealerPhone ?? '+1 878-9674-4455' }}</p></div>
        <a href="{{ route('contact') }}" class="bg-white/20 border border-slate-900/10 text-slate-900 px-8 py-3 font-bold tracking-widest text-xs uppercase hover:bg-white/40 transition-all rounded inline-flex items-center"><span class="material-symbols-outlined text-sm align-middle mr-1">mail</span> FEEDBACK</a>
      </div>
    </div>
  </section>
@endsection