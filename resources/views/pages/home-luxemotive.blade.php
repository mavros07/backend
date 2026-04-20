@extends('layouts.site')

@push('head')
  @include('partials.luxemotive-home-assets')
@endpush

@php
  $brand = config('app.name', 'LUXEMOTIVE');
  $hero = $heroVehicle ?? null;
  $heroTitle = $hero ? $hero->title : 'Mercedes-Benz AMG GT 2017';
  $heroBg =
    $hero && $hero->images->isNotEmpty()
      ? \App\Support\VehicleImageUrl::url($hero->images->first()->path)
      : asset('asset/images/media/demo/01-6-1-1.jpg');
  /** @var int Monthly payment line in hero (matches reference layout) */
  $heroMonthly = 320;
@endphp

@section('content')
  {{-- Design-reference blocks only; shared chrome is partials.header / partials.footer via layouts.site --}}
  <div class="luxemotive-home-scope bg-background text-on-background font-body antialiased">
  <!-- Hero (offset for theme fixed header + top bar) -->
  <section class="relative flex min-h-[85vh] items-center overflow-hidden pt-[100px] md:pt-[120px]">
    <div
      class="absolute inset-0 bg-cover bg-center"
      style="background-image: url('{{ e($heroBg) }}');"
    ></div>
    <div class="absolute inset-0 hero-gradient"></div>
    <div class="relative z-10 container mx-auto px-8 text-center">
      <h1
        class="font-headline text-4xl font-black uppercase leading-tight tracking-tight text-white md:text-6xl lg:text-8xl"
      >
        {{ $heroTitle }}
      </h1>
      <p class="mt-6 text-2xl font-bold uppercase tracking-widest text-primary md:text-3xl">
        ${{ number_format($heroMonthly) }}
        <span class="text-xl text-white">/mo for 36 months</span>
      </p>
    </div>
  </section>

  <!-- Search -->
  <section class="relative z-20 -mt-16 container mx-auto px-8">
    <div class="rounded-lg bg-[#232628] p-8 shadow-2xl">
      <form method="get" action="{{ route('inventory.index') }}" class="flex flex-col items-center gap-4 md:flex-row">
        <div class="mb-4 flex items-center gap-3 text-white md:mb-0 md:mr-6">
          <span class="material-symbols-outlined text-3xl">search_insights</span>
          <span class="font-headline text-xl font-bold uppercase tracking-tight">Search inventory</span>
        </div>
        <div class="grid w-full flex-1 grid-cols-1 gap-4 md:grid-cols-3">
          <select
            name="condition"
            class="appearance-none rounded border-none bg-white px-4 py-3 text-sm font-medium focus:ring-2 focus:ring-primary"
          >
            <option value="">Condition</option>
            <option value="new" @selected(($filters['condition'] ?? '') === 'new')>New cars</option>
            <option value="used" @selected(($filters['condition'] ?? '') === 'used')>Used cars</option>
          </select>
          <select
            name="make"
            class="appearance-none rounded border-none bg-white px-4 py-3 text-sm font-medium focus:ring-2 focus:ring-primary"
          >
            <option value="">Make</option>
            @foreach (($filterOptions['makes'] ?? collect()) as $make)
              <option value="{{ $make }}" @selected(($filters['make'] ?? '') === $make)>{{ $make }}</option>
            @endforeach
          </select>
          <select
            name="model"
            class="appearance-none rounded border-none bg-white px-4 py-3 text-sm font-medium focus:ring-2 focus:ring-primary"
          >
            <option value="">Model</option>
            @foreach (($filterOptions['models'] ?? collect()) as $model)
              <option value="{{ $model }}" @selected(($filters['model'] ?? '') === $model)>{{ $model }}</option>
            @endforeach
          </select>
        </div>
        <div class="flex w-full gap-2 md:w-auto">
          <button
            type="submit"
            class="flex w-full items-center justify-center rounded bg-primary px-8 py-3 text-sm font-bold uppercase tracking-widest text-on-primary-container transition-colors hover:bg-yellow-400 md:w-auto"
          >
            <span class="material-symbols-outlined mr-2 text-xl">search</span>
            Search
          </button>
          <a
            href="{{ route('inventory.index') }}"
            class="flex items-center justify-center rounded bg-[#3a3f43] px-4 py-3 text-white transition-colors hover:bg-slate-700"
            title="Reset filters"
          >
            <span class="material-symbols-outlined text-xl">restart_alt</span>
          </a>
        </div>
      </form>
    </div>
  </section>

  <!-- Recent cars -->
  <section class="bg-white py-24">
    <div class="container mx-auto px-8">
      <div class="mb-16 text-center">
        <h2 class="section-line font-headline inline-block text-4xl font-black uppercase tracking-tight text-on-background">
          Recent <span class="text-primary">cars</span>
        </h2>
        <p class="mx-auto mt-4 max-w-lg text-slate-500">
          Curabitur tellus leo, euismod sit amet gravida at, egestas sed commodo.
        </p>
      </div>

      <div class="grid grid-cols-1 gap-8 md:grid-cols-2 lg:grid-cols-3">
        @forelse ($recentVehicles as $vehicle)
          @php
            $cover = $vehicle->images->first();
            $coverUrl = $cover ? \App\Support\VehicleImageUrl::url($cover->path) : asset('asset/images/media/demo/01-7-1-1.jpg');
            $trans = $vehicle->transmission ? strtoupper(\Illuminate\Support\Str::limit($vehicle->transmission, 12, '')) : 'AUTO';
          @endphp
          <a
            href="{{ route('inventory.show', ['slug' => $vehicle->slug]) }}"
            class="group cursor-pointer overflow-hidden rounded-lg border border-slate-800 bg-[#232628]"
          >
            <div class="relative aspect-[16/10] overflow-hidden">
              <img
                src="{{ $coverUrl }}"
                alt="{{ $vehicle->title }}"
                class="h-full w-full object-cover transition-transform duration-500 group-hover:scale-105"
                loading="lazy"
              />
              <div
                class="absolute bottom-0 right-0 flex flex-col items-end bg-[#3b63d6] px-4 py-2 font-bold text-white"
              >
                <span class="text-[10px] leading-none opacity-80">Buy online</span>
                @if ($vehicle->price !== null)
                  <span class="text-lg">${{ number_format((float) $vehicle->price, 0, '.', ',') }}</span>
                @else
                  <span class="text-lg">Ask</span>
                @endif
              </div>
            </div>
            <div class="p-6">
              <h3 class="mb-4 font-headline text-lg font-bold uppercase text-white">
                {{ $vehicle->title }}
              </h3>
              <div
                class="flex justify-between border-t border-slate-700 pt-4 text-[11px] font-bold text-slate-400"
              >
                <span class="flex items-center gap-1.5">
                  <span class="material-symbols-outlined text-[16px]">speed</span>
                  {{ number_format((int) ($vehicle->mileage ?? 0)) }} MI
                </span>
                <span class="flex items-center gap-1.5">
                  <span class="material-symbols-outlined text-[16px]">settings_input_component</span>
                  {{ $trans }}
                </span>
                <span class="flex items-center gap-1.5">
                  <span class="material-symbols-outlined text-[16px]">calendar_today</span>
                  {{ $vehicle->year ?? '—' }}
                </span>
              </div>
            </div>
          </a>
        @empty
          <div class="col-span-full rounded-lg border border-dashed border-slate-300 bg-slate-50 p-12 text-center">
            <p class="font-headline text-lg font-bold text-slate-700">No vehicles available yet</p>
            <p class="mt-2 text-slate-500">Seed the database or approve listings in the admin panel.</p>
            <a
              href="{{ route('inventory.index') }}"
              class="mt-6 inline-block rounded bg-primary px-8 py-3 text-sm font-bold uppercase tracking-wider text-on-primary-container"
            >View inventory</a>
          </div>
        @endforelse
      </div>
    </div>
  </section>

  <!-- Dual CTA -->
  <section class="flex h-[500px] flex-col md:flex-row">
    <div
      class="group relative flex flex-1 items-center justify-center overflow-hidden p-12 text-center"
    >
      <div
        class="absolute inset-0 bg-cover bg-center"
        style="background-image: url('{{ asset('asset/images/media/demo/01-10-1.jpg') }}');"
      ></div>
      <div class="absolute inset-0 bg-black/60 transition-all duration-500 group-hover:bg-black/40"></div>
      <div class="relative z-10 text-white">
        <span class="material-symbols-outlined mb-4 text-4xl">directions_car</span>
        <h3 class="mb-6 font-headline text-4xl font-black uppercase tracking-tight">Looking for a car?</h3>
        <p class="mx-auto mb-10 max-w-xs leading-relaxed opacity-90">
          Our cars are delivered fully-registered with all requirements completed. We'll deliver your car wherever you are.
        </p>
        <a
          href="{{ route('inventory.index') }}"
          class="inline-block rounded bg-[#4a69e2] px-10 py-4 text-xs font-bold uppercase tracking-widest text-white shadow-xl transition-colors hover:bg-blue-700"
        >Inventory</a>
      </div>
    </div>
    <div
      class="group relative flex flex-1 items-center justify-center overflow-hidden p-12 text-center"
    >
      <div
        class="absolute inset-0 bg-cover bg-center"
        style="background-image: url('{{ asset('asset/images/media/demo/01-24-1.jpg') }}');"
      ></div>
      <div
        class="absolute inset-0 bg-[#ffb129]/80 transition-all duration-500 group-hover:bg-[#ffb129]/70"
      ></div>
      <div class="relative z-10 text-slate-900">
        <span class="material-symbols-outlined mb-4 text-4xl">sell</span>
        <h3 class="mb-6 font-headline text-4xl font-black uppercase tracking-tight">Want to sell a car?</h3>
        <p class="mx-auto mb-10 max-w-xs leading-relaxed opacity-90">
          Receive the absolute best value for your trade-in vehicle. We even handle all paperwork. Schedule appointment!
        </p>
        @auth
          <a
            href="{{ route('dashboard.vehicles.create') }}"
            class="inline-block rounded bg-[#4a69e2] px-10 py-4 text-xs font-bold uppercase tracking-widest text-white shadow-xl transition-colors hover:bg-blue-700"
          >Sell your car</a>
        @else
          <a
            href="{{ route('register') }}"
            class="inline-block rounded bg-[#4a69e2] px-10 py-4 text-xs font-bold uppercase tracking-widest text-white shadow-xl transition-colors hover:bg-blue-700"
          >Sell your car</a>
        @endauth
      </div>
    </div>
  </section>

  <!-- Features -->
  <section class="border-b border-slate-200 bg-surface-container-low py-24">
    <div class="container mx-auto grid grid-cols-1 gap-8 px-8 md:grid-cols-3">
      <div
        class="flex flex-col items-center rounded border border-slate-100 bg-white p-10 text-center shadow-sm"
      >
        <div class="mb-6 rounded-full bg-slate-50 p-4">
          <span class="material-symbols-outlined text-2xl text-primary">stars</span>
        </div>
        <h4 class="mb-4 font-headline text-lg font-bold uppercase tracking-tight">Wide range of brands</h4>
        <p class="text-sm leading-relaxed text-slate-500">
          With a robust selection of popular vehicles on hand, as well as leading vehicles from BMW and Ford.
        </p>
      </div>
      <div
        class="flex flex-col items-center rounded border border-slate-100 bg-white p-10 text-center shadow-sm"
      >
        <div class="mb-6 rounded-full bg-slate-50 p-4">
          <span class="material-symbols-outlined text-2xl text-primary">groups</span>
        </div>
        <h4 class="mb-4 font-headline text-lg font-bold uppercase tracking-tight">Trusted process</h4>
        <p class="text-sm leading-relaxed text-slate-500">
          Every listing is reviewed so buyers see clear details and real photos.
        </p>
      </div>
      <div
        class="flex flex-col items-center rounded border border-slate-100 bg-white p-10 text-center shadow-sm"
      >
        <div class="mb-6 rounded-full bg-slate-50 p-4">
          <span class="material-symbols-outlined text-2xl text-primary">build</span>
        </div>
        <h4 class="mb-4 font-headline text-lg font-bold uppercase tracking-tight">Service &amp; maintenance</h4>
        <p class="text-sm leading-relaxed text-slate-500">
          Our stress-free finance department that can find financial solutions to save you money.
        </p>
      </div>
    </div>
  </section>

  <!-- Testimonial -->
  <section class="relative bg-inverse-surface py-24 stats-bg">
    <div class="absolute inset-0 bg-black/70"></div>
    <div class="container relative z-10 mx-auto flex flex-col items-center px-8 text-center">
      <div class="mb-6 h-24 w-24 overflow-hidden rounded-full border-4 border-white">
        <img
          src="{{ asset('asset/images/branding/footer-2.jpg') }}"
          alt="Customer"
          class="h-full w-full object-cover"
        />
      </div>
      <h6 class="mb-1 font-headline text-xl font-bold uppercase tracking-widest text-white">Robert Frost</h6>
      <p class="mb-8 text-xs font-bold uppercase text-primary">Teacher</p>
      <p class="font-headline max-w-3xl text-2xl font-light italic leading-relaxed text-white">
        "Lorem ipsum dolor sit amet, consectetur adipiscing elit. In fringilla, velit id laoreet hendrerit, sapien nisl
        varius dolor, eu consequat erat augue in eros. Fusce non orci vitae eros porta consequat non at ante. Etiam et
        ligula quam."
      </p>
    </div>
  </section>

  <!-- Stats -->
  <section class="overflow-hidden bg-slate-50 py-32">
    <div class="container mx-auto max-w-6xl px-8">
      <div
        class="relative flex flex-col items-center justify-between rounded-2xl bg-white p-16 shadow-2xl md:flex-row"
      >
        <div class="z-10 flex flex-col gap-24 text-left">
          <div>
            <span class="font-headline block text-6xl font-black leading-none text-slate-900">17600</span>
            <span class="mt-4 block text-[11px] font-bold uppercase tracking-[0.2em] text-slate-400">Cars for sale</span>
          </div>
          <div>
            <span class="font-headline block text-6xl font-black leading-none text-slate-900">6230</span>
            <span class="mt-4 block text-[11px] font-bold uppercase tracking-[0.2em] text-slate-400">Visitors per day</span>
          </div>
        </div>
        <div class="my-12 scale-110 md:my-0">
          <img
            class="h-auto w-64 drop-shadow-2xl md:w-80"
            src="{{ asset('asset/images/media/demo/01-6-1-1.jpg') }}"
            alt=""
          />
        </div>
        <div class="z-10 flex flex-col gap-24 text-right">
          <div>
            <span class="font-headline block text-6xl font-black leading-none text-slate-900">3500</span>
            <span class="mt-4 block text-[11px] font-bold uppercase tracking-[0.2em] text-slate-400">Dealer reviews</span>
          </div>
          <div>
            <span class="font-headline block text-6xl font-black leading-none text-slate-900">2250</span>
            <span class="mt-4 block text-[11px] font-bold uppercase tracking-[0.2em] text-slate-400">Verified dealers</span>
          </div>
        </div>
      </div>
    </div>
  </section>

  <!-- Welcome -->
  <section class="bg-white py-32">
    <div class="container mx-auto flex flex-col items-center px-8 text-center">
      <h2 class="mb-8 font-headline text-4xl font-black uppercase tracking-tight">
        Welcome to <span class="text-primary">{{ $brand }}</span>
      </h2>
      <p class="mb-12 max-w-3xl font-body text-lg leading-relaxed text-slate-500">
        With specialists on hand for every step of buying and owning a vehicle, {{ $brand }} brings together curated
        inventory, transparent listings, and responsive support—so you can browse with confidence and reach out when you
        are ready to move forward.
      </p>
      <div
        class="flex h-20 w-20 cursor-pointer items-center justify-center rounded-full bg-[#4a69e2] shadow-lg transition-transform hover:scale-110"
      >
        <span class="material-symbols-outlined ml-1 text-4xl text-white" style="font-variation-settings: 'FILL' 1">
          play_arrow
        </span>
      </div>
    </div>
  </section>

  <!-- Bottom banner -->
  <section class="bg-primary py-10">
    <div class="container mx-auto flex flex-col items-center justify-between gap-6 px-8 md:flex-row">
      <div class="flex items-center gap-4 text-on-primary-container">
        <span class="material-symbols-outlined text-3xl">help</span>
        <h3 class="font-headline text-xl font-bold uppercase tracking-tight">Have questions? Feel free to ask…</h3>
      </div>
      <div class="flex flex-col items-center gap-6 md:flex-row md:gap-10">
        <div class="flex items-center gap-3">
          <span class="material-symbols-outlined text-slate-800">call</span>
          <p class="font-headline text-2xl font-black text-slate-900">{{ $dealerPhone ?? '+1 878-9674-4455' }}</p>
        </div>
        <a
          href="{{ route('contact') }}"
          class="rounded border border-slate-900/10 bg-white/20 px-8 py-3 text-xs font-bold uppercase tracking-widest text-slate-900 transition-colors hover:bg-white/40"
        >
          <span class="material-symbols-outlined mr-1 align-middle text-sm">mail</span>
          Feedback
        </a>
      </div>
    </div>
  </section>

  </div>
@endsection
