@php
  $site = $site ?? [];
  $brandName = config('app.name', 'Site');
  $logoPath = $site['logo_path'] ?? $site['logo_url'] ?? null;
@endphp

<nav class="bg-[#111111] border-b border-white/5 fixed top-0 w-full z-50 px-6 md:px-12 h-16 flex justify-between items-center">
  <div class="flex items-center gap-8">
    <a href="{{ route('home') }}" class="text-2xl font-black italic tracking-tighter text-white font-headline leading-none">
      @if (!empty($logoPath))
        <img src="{{ \App\Support\VehicleImageUrl::url($logoPath) }}" alt="{{ $brandName }}" class="h-8 w-auto" />
      @else
        {{ strtolower($brandName) }}
      @endif
    </a>
    <div class="hidden md:flex items-center gap-6 text-[11px] font-bold uppercase tracking-wider">
      <a class="text-white hover:text-brand_blue transition-colors" href="{{ route('home') }}">Home</a>
      <a class="text-white hover:text-brand_blue transition-colors" href="{{ route('inventory.index') }}">Inventory</a>
      <a class="text-white hover:text-brand_blue transition-colors" href="{{ route('about') }}">About</a>
      <a class="text-white hover:text-brand_blue transition-colors" href="{{ route('faq') }}">FAQ</a>
      <a class="text-white hover:text-brand_blue transition-colors" href="{{ route('compare') }}">Compare</a>
      <a class="text-white hover:text-brand_blue transition-colors" href="{{ route('contact') }}">Contact</a>
    </div>
  </div>

  <button class="md:hidden text-white" type="button" data-mobile-menu-toggle>
    <span class="material-symbols-outlined">menu</span>
  </button>
</nav>

<div class="fixed inset-0 z-40 hidden bg-black/70 md:hidden" data-mobile-menu-overlay></div>
<div class="fixed right-0 top-0 z-50 h-full w-72 translate-x-full bg-[#111111] p-6 text-white transition-transform md:hidden" data-mobile-menu-panel>
  <div class="mb-6 flex items-center justify-between">
    <p class="font-headline text-xl font-black italic">{{ strtolower($brandName) }}</p>
    <button type="button" data-mobile-menu-close><span class="material-symbols-outlined">close</span></button>
  </div>
  <div class="flex flex-col gap-4 text-sm font-bold uppercase tracking-wide">
    <a href="{{ route('home') }}">Home</a>
    <a href="{{ route('inventory.index') }}">Inventory</a>
    <a href="{{ route('about') }}">About</a>
    <a href="{{ route('faq') }}">FAQ</a>
    <a href="{{ route('compare') }}">Compare</a>
    <a href="{{ route('contact') }}">Contact</a>
  </div>
</div>
