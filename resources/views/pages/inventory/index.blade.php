@extends('layouts.site')

@section('content')
  @php
    $activeFilterCount = collect([
      'q',
      'condition',
      'body_type',
      'make',
      'model',
      'transmission',
      'fuel_type',
      'drive',
      'location',
      'vin',
      'exterior_color',
      'year_min',
      'year_max',
      'mileage_min',
      'mileage_max',
      'price_min',
      'price_max',
    ])->filter(fn ($k) => trim((string) ($filters[$k] ?? '')) !== '')->count();
  @endphp
  <div class="max-w-[1400px] mx-auto px-6 md:px-12 pb-20 pt-10 bg-black text-white min-h-screen">
    <section class="py-10 flex flex-col md:flex-row md:justify-between md:items-end border-b border-white/10 mb-8 gap-4">
      <div>
        <h1 class="text-2xl font-black font-headline uppercase tracking-tight">{{ $sections['heading'] ?? ($page?->title ?? 'Vehicles For Sale') }}</h1>
        @if (!empty($sections['intro']) || !empty($page?->meta_description))
          <p class="mt-2 text-sm text-slate-400 max-w-2xl">{{ $sections['intro'] ?? $page?->meta_description }}</p>
        @endif
      </div>
      <div class="flex items-center gap-6 flex-wrap">
        <div class="flex items-center gap-3">
          <span class="text-[10px] font-bold uppercase tracking-widest text-slate-400">Sort by:</span>
          <div class="relative">
            <select id="inventory-sort" name="sort" form="inventory-filter-form" class="bg-white border border-white/20 text-slate-900 font-medium text-xs px-4 py-2 pr-8 rounded-sm focus:ring-0 cursor-pointer appearance-none">
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
            $photo = $image ? \App\Support\VehicleImageUrl::url($image->path) : \App\Support\PlaceholderMedia::url($sections['fallback_image'] ?? 'asset/images/media/inventory-listing-fallback.jpg');
            $vehicleUrl = route('inventory.show', ['slug' => $vehicle->slug]);
          @endphp
          <article class="bg-card_bg overflow-hidden flex flex-col md:flex-row relative group">
            <div class="md:w-[320px] h-[240px] relative overflow-hidden shrink-0">
              <a href="{{ $vehicleUrl }}" class="block h-full w-full">
                <img class="w-full h-full object-cover" alt="{{ $vehicle->title }}" src="{{ $photo }}" />
              </a>
              @if($vehicle->is_special)
                <div class="sold-ribbon">Special</div>
              @endif
            </div>
            <div class="flex-1 p-6 flex flex-col justify-between">
              <div class="flex justify-between items-start gap-4">
                <div>
                  <a href="{{ $vehicleUrl }}" class="text-white text-xs font-bold uppercase tracking-wider font-body hover:text-primary transition-colors">{{ $vehicle->title ?? ($vehicle->model ?? 'Vehicle') }}</a>
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
                <a href="{{ $vehicleUrl }}" class="border border-white/20 hover:bg-white/5 px-4 py-2 rounded-full text-[10px] font-bold uppercase tracking-widest flex items-center gap-2"><span class="material-symbols-outlined text-[14px] text-primary">play_circle</span> Details</a>
                <form method="post" action="{{ route('compare.add', ['vehicle' => $vehicle->id]) }}">@csrf<button class="border border-white/20 hover:bg-white/5 px-4 py-2 rounded-full text-[10px] font-bold uppercase tracking-widest flex items-center gap-2" type="submit"><span class="material-symbols-outlined text-[14px] text-primary">compare_arrows</span> Add to Compare</button></form>
                <button class="js-share-listing border border-white/20 hover:bg-white/5 px-4 py-2 rounded-full text-[10px] font-bold uppercase tracking-widest flex items-center gap-2" type="button" data-share-url="{{ $vehicleUrl }}" data-share-title="{{ $vehicle->title }}"><span class="material-symbols-outlined text-[14px] text-primary">share</span> Share This</button>
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

      <aside class="hidden lg:block w-full lg:w-[280px] space-y-4 lg:sticky lg:top-6 lg:max-h-[calc(100vh-2rem)] lg:overflow-y-auto lg:py-[65px]">
        <h2 class="text-xl font-bold font-headline uppercase mb-4">Search Options</h2>
        <form id="inventory-filter-form" method="get" action="{{ route('inventory.index') }}" class="space-y-2">
          <div class="relative">
            <select name="condition" class="w-full bg-white border border-white/20 text-slate-900 text-[11px] font-bold uppercase px-4 py-3 appearance-none focus:border-brand_blue transition-colors"><option value="">Condition</option><option value="new" @selected(($filters['condition'] ?? '')==='new')>New</option><option value="used" @selected(($filters['condition'] ?? '')==='used')>Used</option></select>
            <span class="material-symbols-outlined absolute right-3 top-3 text-xs pointer-events-none">expand_more</span>
          </div>
          <div class="relative">
            <select name="body_type" class="w-full bg-white border border-white/20 text-slate-900 text-[11px] font-bold uppercase px-4 py-3 appearance-none focus:border-brand_blue transition-colors"><option value="">Body</option>@foreach(($filterOptions['body_types'] ?? collect()) as $bodyType)<option value="{{ $bodyType }}" @selected(($filters['body_type'] ?? '') === $bodyType)>{{ $bodyType }}</option>@endforeach</select>
            <span class="material-symbols-outlined absolute right-3 top-3 text-xs pointer-events-none">expand_more</span>
          </div>
          <div class="relative">
            <select name="make" class="w-full bg-white border border-white/20 text-slate-900 text-[11px] font-bold uppercase px-4 py-3 appearance-none focus:border-brand_blue transition-colors"><option value="">Make</option>@foreach(($filterOptions['makes'] ?? collect()) as $make)<option value="{{ $make }}" @selected(($filters['make'] ?? '') === $make)>{{ $make }}</option>@endforeach</select>
            <span class="material-symbols-outlined absolute right-3 top-3 text-xs pointer-events-none">expand_more</span>
          </div>
          <div class="relative">
            <select name="model" class="w-full bg-white border border-white/20 text-slate-900 text-[11px] font-bold uppercase px-4 py-3 appearance-none focus:border-brand_blue transition-colors"><option value="">Model</option>@foreach(($filterOptions['models'] ?? collect()) as $model)<option value="{{ $model }}" @selected(($filters['model'] ?? '') === $model)>{{ $model }}</option>@endforeach</select>
            <span class="material-symbols-outlined absolute right-3 top-3 text-xs pointer-events-none">expand_more</span>
          </div>
          <div class="relative">
            <select name="transmission" class="w-full bg-white border border-white/20 text-slate-900 text-[11px] font-bold uppercase px-4 py-3 appearance-none focus:border-brand_blue transition-colors"><option value="">Transmission</option>@foreach(($filterOptions['transmissions'] ?? collect()) as $transmission)<option value="{{ $transmission }}" @selected(($filters['transmission'] ?? '') === $transmission)>{{ $transmission }}</option>@endforeach</select>
            <span class="material-symbols-outlined absolute right-3 top-3 text-xs pointer-events-none">expand_more</span>
          </div>
          <div class="relative">
            <select name="fuel_type" class="w-full bg-white border border-white/20 text-slate-900 text-[11px] font-bold uppercase px-4 py-3 appearance-none focus:border-brand_blue transition-colors"><option value="">Fuel Type</option>@foreach(($filterOptions['fuel_types'] ?? collect()) as $fuel)<option value="{{ $fuel }}" @selected(($filters['fuel_type'] ?? '') === $fuel)>{{ $fuel }}</option>@endforeach</select>
            <span class="material-symbols-outlined absolute right-3 top-3 text-xs pointer-events-none">expand_more</span>
          </div>
          <div class="relative">
            <select name="drive" class="w-full bg-white border border-white/20 text-slate-900 text-[11px] font-bold uppercase px-4 py-3 appearance-none focus:border-brand_blue transition-colors"><option value="">Drive</option>@foreach(($filterOptions['drives'] ?? collect()) as $drive)<option value="{{ $drive }}" @selected(($filters['drive'] ?? '') === $drive)>{{ $drive }}</option>@endforeach</select>
            <span class="material-symbols-outlined absolute right-3 top-3 text-xs pointer-events-none">expand_more</span>
          </div>
          <div class="relative">
            <select name="exterior_color" class="w-full bg-white border border-white/20 text-slate-900 text-[11px] font-bold uppercase px-4 py-3 appearance-none focus:border-brand_blue transition-colors"><option value="">Exterior Color</option>@foreach(($filterOptions['exterior_colors'] ?? collect()) as $color)<option value="{{ $color }}" @selected(($filters['exterior_color'] ?? '') === $color)>{{ $color }}</option>@endforeach</select>
            <span class="material-symbols-outlined absolute right-3 top-3 text-xs pointer-events-none">expand_more</span>
          </div>
          <div class="relative"><input name="location" value="{{ $filters['location'] ?? '' }}" class="w-full bg-white border border-white/20 text-slate-900 text-[11px] font-bold uppercase px-10 py-3 focus:ring-0 focus:border-brand_blue transition-colors" placeholder="Any location" type="text"/><span class="material-symbols-outlined absolute left-3 top-3 text-xs text-slate-600">location_on</span></div>
          <div class="relative"><input name="vin" value="{{ $filters['vin'] ?? '' }}" class="w-full bg-white border border-white/20 text-slate-900 text-[11px] px-4 py-3 focus:ring-0 focus:border-brand_blue" placeholder="VIN" type="text"/></div>
          <div class="relative"><input name="q" value="{{ $filters['q'] ?? '' }}" class="w-full bg-white border border-white/20 text-slate-900 text-[11px] px-4 py-3 focus:ring-0 focus:border-brand_blue" placeholder="Search" type="text"/></div>
          <div class="grid grid-cols-2 gap-2">
            <input name="year_min" value="{{ $filters['year_min'] ?? '' }}" type="number" placeholder="Year min" class="w-full bg-white border border-white/20 text-slate-900 text-[11px] px-3 py-2" />
            <input name="year_max" value="{{ $filters['year_max'] ?? '' }}" type="number" placeholder="Year max" class="w-full bg-white border border-white/20 text-slate-900 text-[11px] px-3 py-2" />
          </div>
          <div class="grid grid-cols-2 gap-2">
            <input name="mileage_min" value="{{ $filters['mileage_min'] ?? '' }}" type="number" placeholder="Mileage min" class="w-full bg-white border border-white/20 text-slate-900 text-[11px] px-3 py-2" />
            <input name="mileage_max" value="{{ $filters['mileage_max'] ?? '' }}" type="number" placeholder="Mileage max" class="w-full bg-white border border-white/20 text-slate-900 text-[11px] px-3 py-2" />
          </div>
          <div class="grid grid-cols-2 gap-2">
            <input name="price_min" value="{{ $filters['price_min'] ?? '' }}" type="number" placeholder="Price min" class="w-full bg-white border border-white/20 text-slate-900 text-[11px] px-3 py-2" />
            <input name="price_max" value="{{ $filters['price_max'] ?? '' }}" type="number" placeholder="Price max" class="w-full bg-white border border-white/20 text-slate-900 text-[11px] px-3 py-2" />
          </div>
          <button class="w-full bg-brand_blue hover:bg-brand_blue/90 text-white font-bold py-3 uppercase text-[11px] tracking-widest flex items-center justify-center gap-2 mt-4" type="submit"><span class="material-symbols-outlined text-[16px]">search</span> Apply Filters</button>
          <a href="{{ route('inventory.index') }}" class="w-full bg-brand_blue hover:bg-brand_blue/90 text-white font-bold py-3 uppercase text-[11px] tracking-widest flex items-center justify-center gap-2 mt-2"><span class="material-symbols-outlined text-[16px]">restart_alt</span> Reset All</a>
        </form>
      </aside>
    </div>
  </div>

  <button id="mobile-filter-trigger" type="button" class="lg:hidden fixed bottom-0 inset-x-0 z-40 bg-brand_blue text-white px-6 py-4 font-bold uppercase tracking-widest text-xs shadow-[0_-6px_20px_rgba(0,0,0,0.3)]">
    Filters @if($activeFilterCount > 0) ({{ $activeFilterCount }}) @endif
  </button>
  <div id="mobile-filter-modal" class="lg:hidden fixed inset-0 z-50 hidden bg-black/70 p-4">
    <div class="mx-auto mt-4 flex max-h-[92vh] w-full max-w-xl flex-col overflow-hidden rounded-lg bg-[#111316] text-white">
      <div class="flex items-center justify-between border-b border-white/10 px-4 py-3">
        <h3 class="text-sm font-semibold uppercase tracking-widest">Search Options</h3>
        <button id="mobile-filter-close" type="button" class="text-white/70 hover:text-white">✕</button>
      </div>
      <div class="overflow-y-auto p-4">
        <form id="inventory-filter-form-mobile" method="get" action="{{ route('inventory.index') }}" class="space-y-2">
          <input type="hidden" name="sort" value="{{ $filters['sort'] ?? 'newest' }}" />
          <div class="relative"><select name="condition" class="w-full rounded-sm border border-white/20 bg-white px-4 py-3 text-[11px] font-bold uppercase text-slate-900 appearance-none"><option value="">Condition</option><option value="new" @selected(($filters['condition'] ?? '')==='new')>New</option><option value="used" @selected(($filters['condition'] ?? '')==='used')>Used</option></select><span class="material-symbols-outlined absolute right-3 top-3 text-xs text-slate-600 pointer-events-none">expand_more</span></div>
          <div class="relative"><select name="body_type" class="w-full rounded-sm border border-white/20 bg-white px-4 py-3 text-[11px] font-bold uppercase text-slate-900 appearance-none"><option value="">Body</option>@foreach(($filterOptions['body_types'] ?? collect()) as $bodyType)<option value="{{ $bodyType }}" @selected(($filters['body_type'] ?? '') === $bodyType)>{{ $bodyType }}</option>@endforeach</select><span class="material-symbols-outlined absolute right-3 top-3 text-xs text-slate-600 pointer-events-none">expand_more</span></div>
          <div class="relative"><select name="make" class="w-full rounded-sm border border-white/20 bg-white px-4 py-3 text-[11px] font-bold uppercase text-slate-900 appearance-none"><option value="">Make</option>@foreach(($filterOptions['makes'] ?? collect()) as $make)<option value="{{ $make }}" @selected(($filters['make'] ?? '') === $make)>{{ $make }}</option>@endforeach</select><span class="material-symbols-outlined absolute right-3 top-3 text-xs text-slate-600 pointer-events-none">expand_more</span></div>
          <div class="relative"><select name="model" class="w-full rounded-sm border border-white/20 bg-white px-4 py-3 text-[11px] font-bold uppercase text-slate-900 appearance-none"><option value="">Model</option>@foreach(($filterOptions['models'] ?? collect()) as $model)<option value="{{ $model }}" @selected(($filters['model'] ?? '') === $model)>{{ $model }}</option>@endforeach</select><span class="material-symbols-outlined absolute right-3 top-3 text-xs text-slate-600 pointer-events-none">expand_more</span></div>
          <div class="relative"><select name="transmission" class="w-full rounded-sm border border-white/20 bg-white px-4 py-3 text-[11px] font-bold uppercase text-slate-900 appearance-none"><option value="">Transmission</option>@foreach(($filterOptions['transmissions'] ?? collect()) as $transmission)<option value="{{ $transmission }}" @selected(($filters['transmission'] ?? '') === $transmission)>{{ $transmission }}</option>@endforeach</select><span class="material-symbols-outlined absolute right-3 top-3 text-xs text-slate-600 pointer-events-none">expand_more</span></div>
          <div class="relative"><select name="fuel_type" class="w-full rounded-sm border border-white/20 bg-white px-4 py-3 text-[11px] font-bold uppercase text-slate-900 appearance-none"><option value="">Fuel Type</option>@foreach(($filterOptions['fuel_types'] ?? collect()) as $fuel)<option value="{{ $fuel }}" @selected(($filters['fuel_type'] ?? '') === $fuel)>{{ $fuel }}</option>@endforeach</select><span class="material-symbols-outlined absolute right-3 top-3 text-xs text-slate-600 pointer-events-none">expand_more</span></div>
          <div class="relative"><select name="drive" class="w-full rounded-sm border border-white/20 bg-white px-4 py-3 text-[11px] font-bold uppercase text-slate-900 appearance-none"><option value="">Drive</option>@foreach(($filterOptions['drives'] ?? collect()) as $drive)<option value="{{ $drive }}" @selected(($filters['drive'] ?? '') === $drive)>{{ $drive }}</option>@endforeach</select><span class="material-symbols-outlined absolute right-3 top-3 text-xs text-slate-600 pointer-events-none">expand_more</span></div>
          <div class="relative"><select name="exterior_color" class="w-full rounded-sm border border-white/20 bg-white px-4 py-3 text-[11px] font-bold uppercase text-slate-900 appearance-none"><option value="">Exterior Color</option>@foreach(($filterOptions['exterior_colors'] ?? collect()) as $color)<option value="{{ $color }}" @selected(($filters['exterior_color'] ?? '') === $color)>{{ $color }}</option>@endforeach</select><span class="material-symbols-outlined absolute right-3 top-3 text-xs text-slate-600 pointer-events-none">expand_more</span></div>
          <input name="location" value="{{ $filters['location'] ?? '' }}" class="w-full rounded-sm border border-white/20 bg-white px-4 py-3 text-[11px] font-bold uppercase text-slate-900" placeholder="Any location" type="text"/>
          <input name="vin" value="{{ $filters['vin'] ?? '' }}" class="w-full rounded-sm border border-white/20 bg-white px-4 py-3 text-[11px] text-slate-900" placeholder="VIN" type="text"/>
          <input name="q" value="{{ $filters['q'] ?? '' }}" class="w-full rounded-sm border border-white/20 bg-white px-4 py-3 text-[11px] text-slate-900" placeholder="Search" type="text"/>
          <div class="grid grid-cols-2 gap-2"><input name="year_min" value="{{ $filters['year_min'] ?? '' }}" type="number" placeholder="Year min" class="w-full rounded-sm border border-white/20 bg-white px-3 py-2 text-[11px] text-slate-900" /><input name="year_max" value="{{ $filters['year_max'] ?? '' }}" type="number" placeholder="Year max" class="w-full rounded-sm border border-white/20 bg-white px-3 py-2 text-[11px] text-slate-900" /></div>
          <div class="grid grid-cols-2 gap-2"><input name="mileage_min" value="{{ $filters['mileage_min'] ?? '' }}" type="number" placeholder="Mileage min" class="w-full rounded-sm border border-white/20 bg-white px-3 py-2 text-[11px] text-slate-900" /><input name="mileage_max" value="{{ $filters['mileage_max'] ?? '' }}" type="number" placeholder="Mileage max" class="w-full rounded-sm border border-white/20 bg-white px-3 py-2 text-[11px] text-slate-900" /></div>
          <div class="grid grid-cols-2 gap-2"><input name="price_min" value="{{ $filters['price_min'] ?? '' }}" type="number" placeholder="Price min" class="w-full rounded-sm border border-white/20 bg-white px-3 py-2 text-[11px] text-slate-900" /><input name="price_max" value="{{ $filters['price_max'] ?? '' }}" type="number" placeholder="Price max" class="w-full rounded-sm border border-white/20 bg-white px-3 py-2 text-[11px] text-slate-900" /></div>
          <div class="sticky bottom-0 bg-[#111316] pt-4 pb-2 space-y-2">
            <button class="w-full bg-brand_blue hover:bg-brand_blue/90 text-white font-bold py-3 uppercase text-[11px] tracking-widest" type="submit">Apply Filters</button>
            <a href="{{ route('inventory.index') }}" class="w-full block text-center bg-brand_blue hover:bg-brand_blue/90 text-white font-bold py-3 uppercase text-[11px] tracking-widest">Reset All</a>
          </div>
        </form>
      </div>
    </div>
  </div>

  <script>
    (() => {
      const sort = document.getElementById('inventory-sort');
      const form = document.getElementById('inventory-filter-form');
      if (sort && form) {
        sort.addEventListener('change', () => form.submit());
      }

      const mobileTrigger = document.getElementById('mobile-filter-trigger');
      const mobileModal = document.getElementById('mobile-filter-modal');
      const mobileClose = document.getElementById('mobile-filter-close');
      if (mobileTrigger && mobileModal) {
        mobileTrigger.addEventListener('click', () => mobileModal.classList.remove('hidden'));
        mobileClose?.addEventListener('click', () => mobileModal.classList.add('hidden'));
        mobileModal.addEventListener('click', (event) => {
          if (event.target === mobileModal) mobileModal.classList.add('hidden');
        });
      }

      document.querySelectorAll('.js-share-listing').forEach((button) => {
        button.addEventListener('click', async () => {
          const shareUrl = button.getAttribute('data-share-url');
          const title = button.getAttribute('data-share-title') || 'Vehicle listing';
          if (!shareUrl) return;
          try {
            if (navigator.share) {
              await navigator.share({ title, url: shareUrl });
              return;
            }
            await navigator.clipboard.writeText(shareUrl);
            const original = button.innerHTML;
            button.innerHTML = '<span class="material-symbols-outlined text-[14px] text-primary">check</span> Copied';
            setTimeout(() => {
              button.innerHTML = original;
            }, 1400);
          } catch (_) {
            // Ignore user cancellation or clipboard restrictions.
          }
        });
      });
    })();
  </script>
@endsection