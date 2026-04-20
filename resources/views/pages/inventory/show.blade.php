@extends('layouts.site')

@section('content')
  @php
    $vehicle = $vehicle ?? null;
    $images = $vehicle?->images ?? collect();
    $cover = $images->first();
    $isFavorited = $isFavorited ?? false;
  @endphp

  <section class="bg-black text-white py-12">
    <div class="max-w-7xl mx-auto px-6">
      <p class="text-primary text-xs font-bold uppercase tracking-[0.2em]">{{ $sections['heading'] ?? ($page?->title ?? 'Vehicle Detail') }}</p>
      <h1 class="font-headline text-4xl font-black uppercase mt-3">{{ $vehicle?->title }}</h1>
      @if (!empty($sections['intro']) || !empty($page?->meta_description))
        <p class="mt-3 text-sm text-slate-300 max-w-2xl">{{ $sections['intro'] ?? $page->meta_description }}</p>
      @endif
    </div>
  </section>

  <section class="max-w-7xl mx-auto px-6 py-10">
    @if (!empty($page?->content_html))
      <div class="mb-8 rounded-lg border border-slate-200 bg-white p-6 prose prose-slate max-w-none">
        {!! $page->content_html !!}
      </div>
    @endif

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
      <div class="lg:col-span-2 space-y-6">
        <div class="bg-white rounded-lg border border-slate-200 overflow-hidden">
          @if ($images->isNotEmpty())
            <img id="inv-gallery-main" src="{{ \App\Support\VehicleImageUrl::url($cover?->path) }}" alt="{{ $vehicle?->title }}" class="w-full h-[460px] object-cover" />
            <div class="grid grid-cols-4 md:grid-cols-6 gap-2 p-3 bg-slate-100">
              @foreach ($images as $img)
                <a href="#" data-full="{{ \App\Support\VehicleImageUrl::url($img->path) }}" class="inv-gallery-thumb block overflow-hidden rounded"><img src="{{ \App\Support\VehicleImageUrl::url($img->path) }}" alt="" class="w-full h-16 object-cover" /></a>
              @endforeach
            </div>
          @else
            <div class="h-[460px] bg-slate-200 flex items-center justify-center text-slate-500">No image</div>
          @endif
        </div>

        <div class="bg-white rounded-lg border border-slate-200 p-6">
          <h2 class="font-headline text-xl font-black uppercase mb-4">Description</h2>
          <p class="text-slate-600 leading-relaxed">{{ $vehicle?->description ?? 'No description available.' }}</p>
        </div>

        @if (is_array($vehicle?->features) && count($vehicle->features) > 0)
          <div class="bg-white rounded-lg border border-slate-200 p-6">
            <h2 class="font-headline text-xl font-black uppercase mb-4">Features</h2>
            <ul class="grid grid-cols-1 md:grid-cols-2 gap-2 text-slate-700 text-sm">
              @foreach ($vehicle->features as $feature)
                <li class="flex items-start gap-2"><span class="material-symbols-outlined text-primary text-base">check_circle</span><span>{{ $feature }}</span></li>
              @endforeach
            </ul>
          </div>
        @endif
      </div>

      <aside class="space-y-6">
        <div class="bg-[#232628] text-white rounded-lg p-6">
          <p class="text-xs uppercase tracking-wider text-slate-300">Our Price</p>
          <p class="font-headline text-4xl font-black text-primary mt-2">@if(!is_null($vehicle?->price))${{ number_format($vehicle->price, 0, '.', ',') }}@else Ask @endif</p>
          <div class="mt-6 space-y-3 text-sm">
            <p><span class="text-slate-400">Mileage:</span> {{ number_format((int) ($vehicle?->mileage ?? 0)) }} mi</p>
            <p><span class="text-slate-400">Fuel:</span> {{ $vehicle?->fuel_type ?? 'N/A' }}</p>
            <p><span class="text-slate-400">Transmission:</span> {{ $vehicle?->transmission ?? 'N/A' }}</p>
            <p><span class="text-slate-400">Body:</span> {{ $vehicle?->body_type ?? 'N/A' }}</p>
            <p><span class="text-slate-400">Location:</span> {{ $vehicle?->location ?? 'N/A' }}</p>
          </div>
          <a href="{{ route('inventory.index') }}" class="mt-6 inline-flex w-full items-center justify-center border border-white/30 rounded px-4 py-2 text-xs font-bold uppercase tracking-wider hover:bg-white/10">Back to Inventory</a>
          @auth
            <form class="mt-3" method="post" action="{{ route('favorites.toggle', ['vehicle' => $vehicle->id]) }}">@csrf<button type="submit" class="w-full bg-motors_blue py-2 rounded text-xs font-bold uppercase tracking-wider">{{ $isFavorited ? 'Remove from Saved' : 'Save Listing' }}</button></form>
          @endauth
        </div>

        @if ($vehicle->status === 'approved')
          <div class="bg-white rounded-lg border border-slate-200 p-6">
            <h2 class="font-headline text-lg font-black uppercase mb-4">Contact Seller</h2>
            <form method="post" action="{{ route('inventory.inquiry', ['slug' => $vehicle->slug]) }}" class="space-y-3">
              @csrf
              <input type="text" name="sender_name" value="{{ old('sender_name', auth()->user()?->name) }}" class="w-full bg-slate-100 border-none rounded px-4 py-3 text-sm" placeholder="Your name" required />
              <input type="email" name="sender_email" value="{{ old('sender_email', auth()->user()?->email) }}" class="w-full bg-slate-100 border-none rounded px-4 py-3 text-sm" placeholder="Email" required />
              <textarea name="message" rows="4" class="w-full bg-slate-100 border-none rounded px-4 py-3 text-sm" placeholder="Message" required>{{ old('message') }}</textarea>
              <button type="submit" class="w-full bg-motors_blue text-white py-3 rounded text-xs font-bold uppercase tracking-wider">Send Message</button>
            </form>
          </div>
        @endif
      </aside>
    </div>
  </section>

  @if ($images->isNotEmpty())
    <script>
      document.querySelectorAll('.inv-gallery-thumb').forEach(function (item) {
        item.addEventListener('click', function (e) {
          e.preventDefault();
          var main = document.getElementById('inv-gallery-main');
          if (!main) return;
          var next = item.getAttribute('data-full');
          if (next) main.setAttribute('src', next);
        });
      });
    </script>
  @endif
@endsection