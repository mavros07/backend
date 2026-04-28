@extends('layouts.site')

@push('head')
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@500;600;700;800&family=Open+Sans:wght@400;500;600;700&display=swap" rel="stylesheet">
@endpush

@section('content')
@php
  $images = $vehicle->images ?? collect();
  $cover = $images->first();
  $galleryUrls = $images->map(fn ($img) => \App\Support\VehicleImageUrl::url($img->path))->values();
  $thumbUrls = $galleryUrls->take(5);
  $moreCount = max(0, $galleryUrls->count() - $thumbUrls->count());
  $msrp = $vehicle->msrp;
  $price = $vehicle->price;
  $saving = (!is_null($price) && !is_null($msrp) && $msrp > $price) ? ($msrp - $price) : null;
  $overview = $vehicle->overview ?: $vehicle->description;
  $techSpecs = is_array($vehicle->tech_specs) ? $vehicle->tech_specs : [];
  $mapQuery = trim((string) ($sellerProfile['map_location'] ?? $vehicle->location ?? ''));
  $financePrice = (int) ($vehicle->finance_price ?: $vehicle->price ?: 0);
  $financeRate = (float) ($vehicle->finance_interest_rate ?: 3);
  $financeTerm = (int) ($vehicle->finance_term_months ?: 24);
  $financeDown = (int) ($vehicle->finance_down_payment ?: 350);
@endphp

<div class="vehicle-detail-page bg-black text-white font-['Open_Sans']">
  <main class="max-w-7xl mx-auto px-6 py-10">
    <section class="flex flex-col md:flex-row justify-between items-start md:items-center mb-8 gap-6 border-b border-white/10 pb-8">
      <div>
        <div class="text-[#ffb129] text-sm font-bold uppercase tracking-widest mb-1">{{ $vehicle->body_type ?: 'Vehicle' }}</div>
        <h1 class="text-4xl md:text-5xl font-black uppercase font-['Montserrat']">{{ $vehicle->year ?: '' }}</h1>
      </div>
      <div class="flex flex-wrap md:flex-nowrap items-stretch shadow-xl w-full md:w-auto">
        <div class="bg-[#3b5998] p-4 flex flex-col justify-center min-w-[140px] text-center border-r border-white/10">
          <div class="text-[10px] uppercase font-bold opacity-70">Buy for</div>
          <div class="text-2xl font-black">{{ !is_null($price) ? '$'.number_format((int) $price) : 'ASK' }}</div>
        </div>
        <div class="bg-[#3b5998] p-4 flex flex-col justify-center min-w-[140px] text-center">
          <div class="text-[10px] uppercase font-bold opacity-70">MSRP</div>
          <div class="text-2xl font-black">{{ !is_null($msrp) ? '$'.number_format((int) $msrp) : 'N/A' }}</div>
        </div>
        @if ($saving)
          <div class="bg-black/20 p-2 flex items-center px-4">
            <span class="text-[10px] font-bold uppercase text-[#ffb129]">Instant Savings: ${{ number_format((int) $saving) }}</span>
          </div>
        @endif
      </div>
    </section>

    <section class="grid grid-cols-1 lg:grid-cols-3 gap-10">
      <div class="lg:col-span-2">
        <div class="relative" data-vehicle-detail-gallery>
          <div class="absolute top-4 left-0 flex flex-col gap-2 z-10">
            @if (!empty($vehicle->video_url))
              <span class="bg-white/20 backdrop-blur-md text-[10px] font-bold px-3 py-1 flex items-center gap-1"><span class="material-symbols-outlined text-[14px]">videocam</span> 1 VIDEO</span>
            @endif
            @if ($vehicle->is_special)
              <span class="bg-[#ffb129] text-[#191c1e] text-[10px] font-black px-6 py-1 italic uppercase tracking-tighter w-fit transform -skew-x-12 -ml-2">SPECIAL</span>
            @endif
          </div>
          <div class="absolute top-4 right-4 flex gap-2 z-10">
            <button class="bg-black/50 p-2 rounded-sm" type="button" onclick="window.print()"><span class="material-symbols-outlined text-sm">print</span></button>
            @auth
              <form method="post" action="{{ route('favorites.toggle', ['vehicle' => $vehicle->id]) }}">
                @csrf
                <button class="bg-black/50 p-2 rounded-sm" type="submit"><span class="material-symbols-outlined text-sm">{{ $isFavorited ? 'favorite' : 'favorite_border' }}</span></button>
              </form>
            @endauth
          </div>
          @if ($cover)
            <img src="{{ \App\Support\VehicleImageUrl::url($cover->path) }}" alt="{{ $vehicle->title }}" class="w-full aspect-[16/9] object-cover rounded-sm mb-4" data-vehicle-detail-main>
          @endif
          @if ($thumbUrls->isNotEmpty())
            <div class="grid grid-cols-6 gap-2">
              @foreach ($thumbUrls as $index => $url)
                <button type="button" class="w-full aspect-video object-cover border-2 {{ $index === 0 ? 'border-[#ffb129] is-active' : 'border-transparent opacity-70 hover:opacity-100' }}" data-vehicle-detail-thumb data-full="{{ $url }}">
                  <img src="{{ $url }}" alt="" class="w-full h-full object-cover">
                </button>
              @endforeach
              @if ($moreCount > 0)
                <div class="bg-[#232628] flex items-center justify-center text-xs font-bold">+{{ $moreCount }}</div>
              @endif
            </div>
          @endif
        </div>

        <div class="mt-12">
          <h2 class="text-2xl font-black uppercase mb-6 font-['Montserrat']">Vehicle overview</h2>
          <div class="text-gray-400 text-sm leading-relaxed space-y-6">
            <p class="whitespace-pre-line">{{ $overview ?: 'No overview available for this vehicle.' }}</p>
            @if (!empty($vehicle->description))
              <div class="flex gap-4 items-start bg-[#232628] p-6 border-l-4 border-[#ffb129]">
                <span class="material-symbols-outlined text-[#ffb129] text-3xl">info</span>
                <p class="italic">{{ \Illuminate\Support\Str::limit(strip_tags($vehicle->description), 260) }}</p>
              </div>
            @endif
          </div>
        </div>

        <div class="mt-12">
          <h3 class="text-xs font-bold uppercase tracking-widest text-[#ffb129] mb-4">Extra features</h3>
          <h4 class="text-lg font-black uppercase mb-6 font-['Montserrat']">Extra Features</h4>
          <div class="grid grid-cols-1 md:grid-cols-2 gap-y-3">
            @forelse (($vehicle->features ?? []) as $feature)
              <div class="flex items-center gap-3 text-xs"><span class="material-symbols-outlined text-[#ffb129] text-[16px]">check_circle</span> {{ $feature }}</div>
            @empty
              <div class="text-xs text-gray-400">No extra features provided.</div>
            @endforelse
          </div>
        </div>
      </div>

      <aside class="space-y-8">
        <div class="bg-[#191c1e] border border-white/5 p-8 rounded-sm">
          <h3 class="text-[10px] font-bold uppercase tracking-widest text-gray-500 mb-6">Dealer info</h3>
          <div class="flex items-center gap-4 mb-6">
            <div class="w-12 h-12 rounded-full border-2 border-[#ffb129] bg-[#30353a]"></div>
            <div>
              <div class="font-bold text-sm">{{ $sellerProfile['name'] ?? 'Dealer' }}</div>
              <div class="text-[10px] text-gray-500 uppercase font-bold">{{ $vehicle->isStaffListing() ? 'Dealer' : 'Private Seller' }}</div>
            </div>
          </div>
          <div class="w-full bg-[#1e2124] py-3 px-4 text-sm font-bold flex items-center justify-between">
            <span>{{ $sellerProfile['phone'] ?? '-' }}</span>
            <span class="text-[10px] text-[#ffb129] uppercase font-bold">Show Number</span>
          </div>
        </div>

        <div class="bg-[#1e2124] overflow-hidden rounded-sm">
          <table class="w-full text-xs">
            <tbody>
              <tr class="border-b border-white/5"><td class="p-4 text-gray-500 font-bold uppercase">Body</td><td class="p-4 font-bold text-right">{{ $vehicle->body_type ?: 'N/A' }}</td></tr>
              <tr class="border-b border-white/5"><td class="p-4 text-gray-500 font-bold uppercase">Mileage</td><td class="p-4 font-bold text-right">{{ $vehicle->mileage ? number_format((int) $vehicle->mileage).'mi' : 'N/A' }}</td></tr>
              <tr class="border-b border-white/5"><td class="p-4 text-gray-500 font-bold uppercase">Transmission</td><td class="p-4 font-bold text-right text-[#ffb129]">{{ $vehicle->transmission ?: 'N/A' }}</td></tr>
              <tr class="border-b border-white/5"><td class="p-4 text-gray-500 font-bold uppercase">Fuel Type</td><td class="p-4 font-bold text-right">{{ $vehicle->fuel_type ?: 'N/A' }}</td></tr>
              <tr class="border-b border-white/5"><td class="p-4 text-gray-500 font-bold uppercase">Engine</td><td class="p-4 font-bold text-right">{{ $vehicle->engine_size ?: 'N/A' }}</td></tr>
              <tr><td class="p-4 text-gray-500 font-bold uppercase">Year</td><td class="p-4 font-bold text-right">{{ $vehicle->year ?: 'N/A' }}</td></tr>
            </tbody>
          </table>
        </div>

        <div class="flex items-center justify-center gap-8 py-6 border-y border-white/10">
          <div class="text-center"><div class="text-3xl font-black">{{ $vehicle->city_mpg ?: 'N/A' }}</div><div class="text-[10px] font-bold text-gray-500 uppercase">City MPG</div></div>
          <div class="bg-[#ffb129] p-4 rounded-full"><span class="material-symbols-outlined text-[#191c1e] text-3xl">local_gas_station</span></div>
          <div class="text-center"><div class="text-3xl font-black">{{ $vehicle->hwy_mpg ?: 'N/A' }}</div><div class="text-[10px] font-bold text-gray-500 uppercase">HWY MPG</div></div>
        </div>

        <div class="bg-[#191c1e] p-8 border border-white/5" data-finance-calculator
             data-price="{{ $financePrice }}"
             data-rate="{{ $financeRate }}"
             data-term="{{ $financeTerm }}"
             data-down="{{ $financeDown }}">
          <h3 class="text-sm font-black uppercase flex items-center gap-2 mb-8"><span class="material-symbols-outlined text-[#ffb129]">calculate</span> Financing calculator</h3>
          <div class="space-y-6">
            <div class="space-y-2"><label class="text-[10px] font-bold uppercase text-gray-500">Vehicle price ($)</label><input class="w-full bg-white text-[#191c1e] font-bold py-2.5 px-4 rounded-sm border-none" type="number" data-finance-input="price"></div>
            <div class="space-y-2"><label class="text-[10px] font-bold uppercase text-gray-500">Interest rate (%)</label><input class="w-full bg-white text-[#191c1e] font-bold py-2.5 px-4 rounded-sm border-none" type="number" step="0.01" data-finance-input="rate"></div>
            <div class="space-y-2"><label class="text-[10px] font-bold uppercase text-gray-500">Loan term (month)</label><input class="w-full bg-white text-[#191c1e] font-bold py-2.5 px-4 rounded-sm border-none" type="number" data-finance-input="term"></div>
            <div class="space-y-2"><label class="text-[10px] font-bold uppercase text-gray-500">Down payment ($)</label><input class="w-full bg-white text-[#191c1e] font-bold py-2.5 px-4 rounded-sm border-none" type="number" data-finance-input="down"></div>
            <button class="w-full bg-[#3b5998] py-3 text-xs font-black uppercase tracking-tighter hover:bg-[#4b71be] transition-colors" type="button" data-finance-calc-btn>Calculate</button>
            <div class="pt-6 border-t border-white/10 space-y-2">
              <div class="flex justify-between text-xs"><span class="text-gray-500">Monthly Payment</span><span class="font-black text-[#ffb129]" data-finance-result>$0</span></div>
              <div class="flex justify-between text-xs"><span class="text-gray-500">Total Interest Payment</span><span class="font-black text-[#ffb129]" data-finance-total-interest>$0</span></div>
              <div class="flex justify-between text-xs"><span class="text-gray-500">Total Amount to Pay</span><span class="font-black text-[#ffb129]" data-finance-total-amount>$0</span></div>
            </div>
          </div>
        </div>
      </aside>
    </section>

    <section class="mt-20 space-y-12">
      <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-12">
        <div>
          <h3 class="flex items-center gap-2 text-sm font-black uppercase mb-6"><span class="material-symbols-outlined text-[#ffb129]">settings</span> Engine</h3>
          <div class="space-y-4 text-xs">
            <div class="flex justify-between border-b border-white/5 pb-2"><span class="text-gray-500 uppercase font-bold">Layout</span><span class="font-bold">{{ $techSpecs['engine_layout'] ?? $vehicle->engine_layout ?: 'N/A' }}</span></div>
            <div class="flex justify-between border-b border-white/5 pb-2"><span class="text-gray-500 uppercase font-bold">Engine volume</span><span class="font-bold">{{ $techSpecs['engine_volume'] ?? $vehicle->engine_size ?: 'N/A' }}</span></div>
            <div class="flex justify-between border-b border-white/5 pb-2"><span class="text-gray-500 uppercase font-bold">Type of drive</span><span class="font-bold">{{ $techSpecs['drive_type'] ?? $vehicle->drive ?: 'N/A' }}</span></div>
          </div>
        </div>
        <div>
          <h3 class="flex items-center gap-2 text-sm font-black uppercase mb-6"><span class="material-symbols-outlined text-[#ffb129]">speed</span> Performance</h3>
          <div class="space-y-4 text-xs">
            <div class="flex justify-between border-b border-white/5 pb-2"><span class="text-gray-500 uppercase font-bold">Top track speed</span><span class="font-bold">{{ $techSpecs['top_speed'] ?? $vehicle->top_track_speed ?: 'N/A' }}</span></div>
            <div class="flex justify-between border-b border-white/5 pb-2"><span class="text-gray-500 uppercase font-bold">0 - 70 mph</span><span class="font-bold">{{ $techSpecs['zero_to_70'] ?? $vehicle->zero_to_sixty ?: 'N/A' }}</span></div>
          </div>
        </div>
        <div>
          <h3 class="flex items-center gap-2 text-sm font-black uppercase mb-6"><span class="material-symbols-outlined text-[#ffb129]">settings_input_component</span> Transmission</h3>
          <div class="space-y-4 text-xs">
            <div class="flex justify-between border-b border-white/5 pb-2"><span class="text-gray-500 uppercase font-bold">Type</span><span class="font-bold">{{ $vehicle->transmission ?: 'N/A' }}</span></div>
            <div class="flex justify-between border-b border-white/5 pb-2"><span class="text-gray-500 uppercase font-bold">Number of gears</span><span class="font-bold">{{ $techSpecs['transmission_gears'] ?? $vehicle->number_of_gears ?: 'N/A' }}</span></div>
          </div>
        </div>
      </div>
    </section>

    <section class="mt-24">
      <h2 class="text-3xl font-black uppercase mb-10 font-['Montserrat']">Location</h2>
      @if ($mapQuery !== '')
        <div class="w-full h-[400px] bg-[#232628] relative overflow-hidden">
          <iframe
            title="Dealer location map"
            class="w-full h-full opacity-70 grayscale"
            loading="lazy"
            referrerpolicy="no-referrer-when-downgrade"
            src="https://maps.google.com/maps?q={{ urlencode($mapQuery) }}&t=&z=13&ie=UTF8&iwloc=&output=embed"></iframe>
          <div class="absolute inset-0 flex items-center justify-center pointer-events-none">
            <div class="bg-[#ffb129] text-[#191c1e] p-2 rounded-full"><span class="material-symbols-outlined text-4xl">location_on</span></div>
          </div>
        </div>
      @endif
      <div class="mt-16 bg-[#191c1e] p-8 md:p-12 border border-white/5">
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-16">
          <div class="space-y-8">
            <h3 class="text-2xl font-black uppercase font-['Montserrat']">Contact Information</h3>
            <p class="text-gray-400 text-sm">This vehicle listing is powered by live seller data and synced from the listing editor.</p>
            <div class="space-y-4">
              <div class="flex items-center gap-4"><div class="bg-[#ffb129] p-2 rounded-full"><span class="material-symbols-outlined text-[#191c1e] text-lg">location_on</span></div><span class="text-sm font-bold">{{ $sellerProfile['address'] ?? $vehicle->location ?: 'N/A' }}</span></div>
              <div class="flex items-center gap-4"><div class="bg-[#ffb129] p-2 rounded-full"><span class="material-symbols-outlined text-[#191c1e] text-lg">phone</span></div><span class="text-sm font-bold">{{ $sellerProfile['phone'] ?? 'N/A' }}</span></div>
              <div class="flex items-center gap-4"><div class="bg-[#ffb129] p-2 rounded-full"><span class="material-symbols-outlined text-[#191c1e] text-lg">mail</span></div><span class="text-sm font-bold">{{ $sellerProfile['email'] ?? 'N/A' }}</span></div>
            </div>
          </div>
          @if ($vehicle->status === 'approved')
            <div class="space-y-6">
              <h3 class="text-xl font-black uppercase flex items-center gap-2 font-['Montserrat']"><span class="material-symbols-outlined text-[#ffb129]">send</span> Message to vendor</h3>
              <form method="post" action="{{ route('inventory.inquiry', ['slug' => $vehicle->slug]) }}" class="space-y-4">
                @csrf
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                  <div class="space-y-1"><label class="text-[10px] font-bold uppercase text-gray-500">Your name*</label><input class="w-full bg-white text-[#191c1e] py-3 px-4 rounded-sm border-none" type="text" name="sender_name" value="{{ old('sender_name', auth()->user()?->name) }}" required></div>
                  <div class="space-y-1"><label class="text-[10px] font-bold uppercase text-gray-500">Your telephone number*</label><input class="w-full bg-white text-[#191c1e] py-3 px-4 rounded-sm border-none" type="text" name="sender_phone" value="{{ old('sender_phone') }}"></div>
                </div>
                <div class="space-y-1"><label class="text-[10px] font-bold uppercase text-gray-500">Email*</label><input class="w-full bg-white text-[#191c1e] py-3 px-4 rounded-sm border-none" type="email" name="sender_email" value="{{ old('sender_email', auth()->user()?->email) }}" required></div>
                <div class="space-y-1"><label class="text-[10px] font-bold uppercase text-gray-500">Your message</label><textarea class="w-full bg-white text-[#191c1e] py-3 px-4 rounded-sm border-none" rows="4" name="message" required>{{ old('message') }}</textarea></div>
                <button class="bg-[#3b5998] px-10 py-3 text-xs font-black uppercase tracking-tighter hover:bg-[#4b71be] transition-colors" type="submit">Submit</button>
              </form>
            </div>
          @endif
        </div>
      </div>
    </section>

    @if ($similarVehicles->isNotEmpty())
      <section class="mt-24 pt-12 border-t border-white/10">
        <div class="flex justify-between items-center mb-10">
          <a class="text-[10px] font-bold uppercase tracking-widest flex items-center gap-2 hover:text-[#ffb129]" href="{{ route('inventory.index') }}"><span class="material-symbols-outlined text-[14px]">arrow_back</span> Search results</a>
          <div class="flex gap-2">
            <button class="w-10 h-10 border border-white/20 flex items-center justify-center hover:border-[#ffb129]" type="button" data-carousel-prev><span class="material-symbols-outlined">chevron_left</span></button>
            <button class="w-10 h-10 border border-white/20 flex items-center justify-center hover:border-[#ffb129]" type="button" data-carousel-next><span class="material-symbols-outlined">chevron_right</span></button>
          </div>
        </div>
        <div data-simple-carousel data-carousel-type="similar-cars">
          <div class="overflow-hidden" data-carousel-viewport>
            <div class="flex gap-6 transition-transform duration-300" data-carousel-track>
              @foreach ($similarVehicles as $item)
                @php $itemCover = $item->images->first(); @endphp
                <article class="bg-[#191c1e] group min-w-full md:min-w-[calc(50%-12px)] lg:min-w-[calc(25%-18px)]" data-carousel-slide>
                  <a href="{{ route('inventory.show', ['slug' => $item->slug]) }}">
                    <div class="relative overflow-hidden aspect-[4/3]">
                      @if ($item->is_special)
                        <div class="absolute top-2 left-0 bg-[#3b5998] text-white text-[10px] font-bold px-4 py-1 italic uppercase transform -skew-x-12 -ml-1 z-10">SPECIAL</div>
                      @endif
                      @if ($itemCover)
                        <img class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-500" src="{{ \App\Support\VehicleImageUrl::url($itemCover->path) }}" alt="{{ $item->title }}">
                      @endif
                      <div class="absolute bottom-0 left-0 right-0 bg-[#3b5998]/90 p-2 text-center">
                        <span class="text-[10px] font-bold">Our price {{ !is_null($item->price) ? '$'.number_format((int) $item->price) : 'ASK' }} @if($item->msrp)<span class="opacity-50">MSRP ${{ number_format((int) $item->msrp) }}</span>@endif</span>
                      </div>
                    </div>
                    <div class="p-4"><h4 class="text-xs font-bold uppercase">{{ ($item->make ?: '').' '.($item->model ?: '').' '.($item->year ?: '') }}</h4></div>
                  </a>
                </article>
              @endforeach
            </div>
          </div>
        </div>
      </section>
    @endif
  </main>
</div>
@endsection