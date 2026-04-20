@extends('layouts.site')

@section('content')
  <div class="max-w-[1400px] mx-auto px-6 md:px-12 pb-20 pt-10 bg-black text-white min-h-screen">
    <section class="py-10 flex flex-col md:flex-row md:justify-between md:items-end border-b border-white/10 mb-8 gap-4">
      <div>
        <h1 class="text-2xl font-black font-headline uppercase tracking-tight">{{ $sections['heading'] ?? ($page?->title ?? 'Vehicles For Sale') }}</h1>
        @if (!empty($sections['intro']) || !empty($page?->meta_description))
          <p class="mt-2 text-sm text-slate-400 max-w-2xl">{{ $sections['intro'] ?? $page->meta_description }}</p>
        @endif
      </div>
      <div class="flex items-center gap-6 flex-wrap">
        <div class="flex items-center gap-3">
          <span class="text-[10px] font-bold uppercase tracking-widest text-slate-400">Sort by:</span>
          <div class="relative">
            <select name="sort" form="inventory-filter-form" class="bg-transparent border border-white/20 text-white font-medium text-xs px-4 py-2 pr-8 rounded-sm focus:ring-0 cursor-pointer appearance-none">
              <option value="newest" @selected(($filters['sort'] ?? 'newest') === 'newest')>Date: newest first</option>
              <option value="price_low" @selected(($filters['sort'] ?? '') === 'price_low')>Price: low to high</option>
              <option value="price_high" @selected(($filters['sort'] ?? '') === 'price_high')>Price: high to low</option>
              <option value="year_new" @selected(($filters['sort'] ?? '') === 'year_new')>Year: newest</option>
              <option value="year_old" @selected(($filters['sort'] ?? '') === 'year_old')>Year: oldest</option>
            </select>
            <span class="material-symbols-outlined absolute right-2 top-2 text-xs pointer-events-none">expand_more</span>
          </div>
        </div>
      </div>
    </section>

    @if (!empty($page?->content_html))
      <section class="mb-8 rounded bg-white/5 border border-white/10 p-6 prose prose-invert max-w-none">
        {!! $page->content_html !!}
      </section>
    @endif

    <div class="flex flex-col lg:flex-row gap-8">
      <div class="flex-1 space-y-6">
        @forelse ($vehicles as $vehicle)
          @php
            $image = $vehicle->images->first();
            $photo = $image ? \App\Support\VehicleImageUrl::url($image->path) : asset($sections['fallback_image'] ?? 'asset/images/media/inventory-listing-fallback.jpg');
          @endphp
          <article class="bg-card_bg overflow-hidden flex flex-col md:flex-row relative group">
            <div class="md:w-[320px] h-[240px] relative overflow-hidden shrink-0">
              <img class="w-full h-full object-cover" alt="{{ $vehicle->title }}" src="{{ $photo }}" />
              <div class="sold-ribbon">Special</div>
            </div>
            <div class="flex-1 p-6 flex flex-col justify-between">
              <div class="flex justify-between items-start gap-4">
                <div>
                  <h3 class="text-white text-xs font-bold uppercase tracking-wider font-body">{{ $vehicle->model ?? 'Vehicle' }}</h3>
                  <p class="text-3xl font-black font-headline leading-none mt-1">{{ $vehicle->year ?? '----' }}</p>
                </div>
                <div class="bg-brand_blue px-4 py-2 rounded-sm text-white font-bold text-xs uppercase text-right">
                  <span class="opacity-70 font-normal">Our Price</span>
                  @if (!is_null($vehicle->price))
                    ${{ number_format((float) $vehicle->price, 0, '.', ' ') }}
                  @else
                    Ask
                  @endif
                </div>
              </div>

              <div class="flex flex-wrap gap-8 mt-6">
                <div class="flex items-center gap-3">
                  <span class="material-symbols-outlined text-primary">speed</span>
                  <div>
                    <p class="text-[9px] text-slate-400 font-bold uppercase">Mileage</p>
                    <p class="text-[11px] font-bold">{{ number_format((int) ($vehicle->mileage ?? 0)) }} mi</p>
                  </div>
                </div>
                <div class="flex items-center gap-3">
                  <span class="material-symbols-outlined text-primary">local_gas_station</span>
                  <div>
                    <p class="text-[9px] text-slate-400 font-bold uppercase">Fuel Type</p>
                    <p class="text-[11px] font-bold">{{ $vehicle->fuel_type ?? 'N/A' }}</p>
                  </div>
                </div>
                <div class="flex items-center gap-3">
                  <span class="material-symbols-outlined text-primary">settings</span>
                  <div>
                    <p class="text-[9px] text-slate-400 font-bold uppercase">Engine</p>
                    <p class="text-[11px] font-bold">{{ $vehicle->engine_size ?? 'N/A' }}</p>
                  </div>
                </div>
              </div>

              <div class="flex flex-wrap gap-3 mt-6">
                <a href="{{ route('inventory.show', ['slug' => $vehicle->slug]) }}" class="border border-white/20 hover:bg-white/5 px-4 py-2 rounded-full text-[10px] font-bold uppercase tracking-widest flex items-center gap-2"><span class="material-symbols-outlined text-[14px] text-primary">play_circle</span> Details</a>
                <form method="post" action="{{ route('compare.add', ['vehicle' => $vehicle->id]) }}">@csrf<button class="border border-white/20 hover:bg-white/5 px-4 py-2 rounded-full text-[10px] font-bold uppercase tracking-widest flex items-center gap-2" type="submit"><span class="material-symbols-outlined text-[14px] text-primary">compare_arrows</span> Add to Compare</button></form>
                <button class="border border-white/20 hover:bg-white/5 px-4 py-2 rounded-full text-[10px] font-bold uppercase tracking-widest flex items-center gap-2" type="button"><span class="material-symbols-outlined text-[14px] text-primary">share</span> Share This</button>
              </div>
            </div>
          </article>
        @empty
          <div class="text-center py-12 text-slate-400">No vehicles found.</div>
        @endforelse

        @if($vehicles->hasPages())
          <div class="pt-8">{{ $vehicles->links() }}</div>
        @endif
      </div>

      <aside class="w-full lg:w-[280px] space-y-4">
        <h2 class="text-xl font-bold font-headline uppercase mb-4">Search Options</h2>
        <form id="inventory-filter-form" method="get" action="{{ route('inventory.index') }}" class="space-y-2">
          <div class="relative">
            <select name="condition" class="w-full bg-black border border-white/20 text-white text-[11px] font-bold uppercase px-4 py-3 appearance-none focus:border-brand_blue transition-colors"><option value="">Condition</option><option value="new" @selected(($filters['condition'] ?? '')==='new')>New</option><option value="used" @selected(($filters['condition'] ?? '')==='used')>Used</option></select>
            <span class="material-symbols-outlined absolute right-3 top-3 text-xs pointer-events-none">expand_more</span>
          </div>
          <div class="relative">
            <select name="body_type" class="w-full bg-black border border-white/20 text-white text-[11px] font-bold uppercase px-4 py-3 appearance-none focus:border-brand_blue transition-colors"><option value="">Body</option>@foreach(($filterOptions['body_types'] ?? collect()) as $bodyType)<option value="{{ $bodyType }}" @selected(($filters['body_type'] ?? '') === $bodyType)>{{ $bodyType }}</option>@endforeach</select>
            <span class="material-symbols-outlined absolute right-3 top-3 text-xs pointer-events-none">expand_more</span>
          </div>
          <div class="relative">
            <select name="make" class="w-full bg-black border border-white/20 text-white text-[11px] font-bold uppercase px-4 py-3 appearance-none focus:border-brand_blue transition-colors"><option value="">Make</option>@foreach(($filterOptions['makes'] ?? collect()) as $make)<option value="{{ $make }}" @selected(($filters['make'] ?? '') === $make)>{{ $make }}</option>@endforeach</select>
            <span class="material-symbols-outlined absolute right-3 top-3 text-xs pointer-events-none">expand_more</span>
          </div>
          <div class="relative">
            <select name="model" class="w-full bg-black border border-white/20 text-white text-[11px] font-bold uppercase px-4 py-3 appearance-none focus:border-brand_blue transition-colors"><option value="">Model</option>@foreach(($filterOptions['models'] ?? collect()) as $model)<option value="{{ $model }}" @selected(($filters['model'] ?? '') === $model)>{{ $model }}</option>@endforeach</select>
            <span class="material-symbols-outlined absolute right-3 top-3 text-xs pointer-events-none">expand_more</span>
          </div>
          <div class="relative">
            <select name="transmission" class="w-full bg-black border border-white/20 text-white text-[11px] font-bold uppercase px-4 py-3 appearance-none focus:border-brand_blue transition-colors"><option value="">Transmission</option>@foreach(($filterOptions['transmissions'] ?? collect()) as $transmission)<option value="{{ $transmission }}" @selected(($filters['transmission'] ?? '') === $transmission)>{{ $transmission }}</option>@endforeach</select>
            <span class="material-symbols-outlined absolute right-3 top-3 text-xs pointer-events-none">expand_more</span>
          </div>
          <div class="relative">
            <select name="fuel_type" class="w-full bg-black border border-white/20 text-white text-[11px] font-bold uppercase px-4 py-3 appearance-none focus:border-brand_blue transition-colors"><option value="">Fuel Type</option>@foreach(($filterOptions['fuel_types'] ?? collect()) as $fuel)<option value="{{ $fuel }}" @selected(($filters['fuel_type'] ?? '') === $fuel)>{{ $fuel }}</option>@endforeach</select>
            <span class="material-symbols-outlined absolute right-3 top-3 text-xs pointer-events-none">expand_more</span>
          </div>
          <div class="relative"><input name="location" value="{{ $filters['location'] ?? '' }}" class="w-full bg-black border border-white/20 text-white text-[11px] font-bold uppercase px-10 py-3 focus:ring-0 focus:border-brand_blue transition-colors" placeholder="Any location" type="text"/><span class="material-symbols-outlined absolute left-3 top-3 text-xs">location_on</span></div>
          <div class="relative"><input name="q" value="{{ $filters['q'] ?? '' }}" class="w-full bg-black border border-white/20 text-white text-[11px] px-4 py-3 focus:ring-0 focus:border-brand_blue" placeholder="Search" type="text"/></div>
          <div class="grid grid-cols-2 gap-2">
            <input name="price_min" value="{{ $filters['price_min'] ?? '' }}" type="number" placeholder="Min" class="w-full bg-black border border-white/20 text-white text-[11px] px-3 py-2" />
            <input name="price_max" value="{{ $filters['price_max'] ?? '' }}" type="number" placeholder="Max" class="w-full bg-black border border-white/20 text-white text-[11px] px-3 py-2" />
          </div>
          <button class="w-full bg-brand_blue hover:bg-brand_blue/90 text-white font-bold py-3 uppercase text-[11px] tracking-widest flex items-center justify-center gap-2 mt-4" type="submit"><span class="material-symbols-outlined text-[16px]">search</span> Apply Filters</button>
          <a href="{{ route('inventory.index') }}" class="w-full bg-brand_blue hover:bg-brand_blue/90 text-white font-bold py-3 uppercase text-[11px] tracking-widest flex items-center justify-center gap-2 mt-2"><span class="material-symbols-outlined text-[16px]">restart_alt</span> Reset All</a>
        </form>
      </aside>
    </div>
  </div>
@endsection