@extends('layouts.site')

@section('content')
@php
  $vehicle = $vehicle ?? null;
  $images = $vehicle?->images ?? collect();
  $cover = $images->first();
  $isFavorited = $isFavorited ?? false;
@endphp

{{-- Hero Section --}}
<section class="bg-[#1E2229] text-white py-16 border-b border-white/5">
  <div class="max-w-7xl mx-auto px-6">
    <div class="flex flex-col md:flex-row md:items-end justify-between gap-6">
      <div class="space-y-4">
        <nav class="flex items-center gap-2 text-xs font-bold uppercase tracking-widest text-primary">
          <a href="{{ route('inventory.index') }}" class="hover:underline transition-all underline-offset-4">{{ __('Inventory') }}</a>
          <span class="text-white/30">/</span>
          <span>{{ $vehicle?->body_type ?? __('Vehicle') }}</span>
        </nav>
        <h1 class="font-headline text-4xl md:text-5xl lg:text-6xl font-black uppercase tracking-tight">
          {{ $vehicle?->title }}
        </h1>
        @if (!empty($sections['intro']) || !empty($page?->meta_description))
          <p class="text-slate-400 max-w-2xl text-lg leading-relaxed font-light">
            {{ $sections['intro'] ?? $page?->meta_description }}
          </p>
        @endif
      </div>
      <div class="flex items-center gap-4">
        @auth
          <form method="post" action="{{ route('favorites.toggle', ['vehicle' => $vehicle->id]) }}">
            @csrf
            <button type="submit" class="group flex items-center gap-3 bg-white/5 hover:bg-white/10 border border-white/10 px-6 py-3 rounded-full transition-all">
              <span class="material-symbols-outlined text-xl {{ $isFavorited ? 'fill-1 text-red-500' : 'text-white' }}">
                {{ $isFavorited ? 'favorite' : 'favorite_border' }}
              </span>
              <span class="text-xs font-bold uppercase tracking-wider">
                {{ $isFavorited ? __('Saved') : __('Save Listing') }}
              </span>
            </button>
          </form>
        @endauth
        <button onclick="window.print()" class="p-3 bg-white/5 hover:bg-white/10 border border-white/10 rounded-full transition-all text-white">
          <span class="material-symbols-outlined text-xl">print</span>
        </button>
      </div>
    </div>
  </div>
</section>

{{-- Main Grid --}}
<section class="max-w-7xl mx-auto px-6 py-12">
  <div class="grid grid-cols-1 lg:grid-cols-3 gap-12">
    
    {{-- Left: Gallery & Details --}}
    <div class="lg:col-span-2 space-y-10">
      
      {{-- Gallery --}}
      <div class="space-y-4">
        <div class="relative aspect-[16/9] bg-slate-900 rounded-2xl overflow-hidden shadow-2xl group">
          @if ($images->isNotEmpty())
            <img id="inv-gallery-main" 
                 src="{{ \App\Support\VehicleImageUrl::url($cover?->path) }}" 
                 alt="{{ $vehicle?->title }}" 
                 class="w-full h-full object-cover transition-transform duration-700 group-hover:scale-105" />
            
            @if($vehicle?->condition)
              <div class="absolute top-6 left-6 bg-primary text-black px-4 py-1 rounded-full text-xs font-black uppercase tracking-tighter">
                {{ $vehicle->condition }}
              </div>
            @endif
          @else
            <div class="w-full h-full flex flex-col items-center justify-center text-slate-500 gap-4">
              <span class="material-symbols-outlined text-6xl opacity-20">image_not_supported</span>
              <p class="font-bold uppercase tracking-widest text-sm">No images available</p>
            </div>
          @endif
        </div>

        @if ($images->count() > 1)
          <div class="flex gap-4 overflow-x-auto pb-2 scrollbar-hide">
            @foreach ($images as $img)
              <button 
                data-full="{{ \App\Support\VehicleImageUrl::url($img->path) }}" 
                class="inv-gallery-thumb flex-shrink-0 w-32 aspect-video rounded-xl overflow-hidden border-2 border-transparent hover:border-primary transition-all focus:border-primary outline-none">
                <img src="{{ \App\Support\VehicleImageUrl::url($img->path) }}" alt="" class="w-full h-full object-cover" />
              </button>
            @endforeach
          </div>
        @endif
      </div>

      {{-- CMS Content --}}
      @if (!empty($page?->content_html))
        <div class="prose prose-slate max-w-none bg-white p-8 rounded-2xl border border-slate-200 shadow-sm">
          {!! $page->content_html !!}
        </div>
      @endif

      {{-- Description --}}
      <div class="space-y-6">
        <div class="flex items-center gap-4">
          <h2 class="font-headline text-2xl font-black uppercase tracking-tight">{{ __('Overview') }}</h2>
          <div class="h-px flex-1 bg-slate-200"></div>
        </div>
        <div class="bg-white p-8 rounded-2xl border border-slate-200 shadow-sm leading-relaxed text-slate-600 text-lg">
          {{ $vehicle?->description ?? __('No description available for this vehicle.') }}
        </div>
      </div>

      {{-- Features --}}
      @if (is_array($vehicle?->features) && count($vehicle->features) > 0)
        <div class="space-y-6">
          <div class="flex items-center gap-4">
            <h2 class="font-headline text-2xl font-black uppercase tracking-tight">{{ __('Key Features') }}</h2>
            <div class="h-px flex-1 bg-slate-200"></div>
          </div>
          <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
            @foreach ($vehicle->features as $feature)
              <div class="flex items-center gap-4 bg-white p-4 rounded-xl border border-slate-200 shadow-sm hover:border-primary transition-colors">
                <div class="w-8 h-8 rounded-full bg-primary/10 flex items-center justify-center flex-shrink-0">
                  <span class="material-symbols-outlined text-primary text-lg">check</span>
                </div>
                <span class="font-bold text-slate-700 uppercase tracking-wide text-xs">{{ $feature }}</span>
              </div>
            @endforeach
          </div>
        </div>
      @endif

      {{-- Detailed Specifications --}}
      <div class="space-y-6">
        <div class="flex items-center gap-4">
          <h2 class="font-headline text-2xl font-black uppercase tracking-tight">{{ __('Full Specifications') }}</h2>
          <div class="h-px flex-1 bg-slate-200"></div>
        </div>
        <div class="grid grid-cols-1 md:grid-cols-2 gap-x-12 gap-y-2 bg-white p-8 rounded-2xl border border-slate-200 shadow-sm">
          @php
            $specs = [
              ['label' => __('Make'), 'value' => $vehicle?->make],
              ['label' => __('Model'), 'value' => $vehicle?->model],
              ['label' => __('Year'), 'value' => $vehicle?->year],
              ['label' => __('Condition'), 'value' => $vehicle?->condition ? strtoupper($vehicle->condition) : null],
              ['label' => __('Mileage'), 'value' => $vehicle?->mileage ? number_format($vehicle->mileage) . ' mi' : null],
              ['label' => __('Transmission'), 'value' => $vehicle?->transmission],
              ['label' => __('Fuel Type'), 'value' => $vehicle?->fuel_type],
              ['label' => __('Engine Size'), 'value' => $vehicle?->engine_size],
              ['label' => __('Drive'), 'value' => $vehicle?->drive],
              ['label' => __('Body Type'), 'value' => $vehicle?->body_type],
              ['label' => __('Exterior Color'), 'value' => $vehicle?->exterior_color],
              ['label' => __('Interior Color'), 'value' => $vehicle?->interior_color],
              ['label' => __('Location'), 'value' => $vehicle?->location],
              ['label' => __('VIN'), 'value' => $vehicle?->vin],
            ];
          @endphp
          @foreach($specs as $spec)
            @if(!empty($spec['value']))
              <div class="flex justify-between items-center py-3 border-b border-slate-100 last:border-0">
                <span class="text-slate-400 text-xs font-bold uppercase tracking-widest">{{ $spec['label'] }}</span>
                <span class="font-headline font-bold text-slate-900 uppercase tracking-tight">{{ $spec['value'] }}</span>
              </div>
            @endif
          @endforeach
        </div>
      </div>
    </div>

    {{-- Right: Sidebar --}}
    <aside class="space-y-8">
      {{-- Price & Core Specs --}}
      <div class="bg-[#232628] text-white rounded-3xl p-8 shadow-xl border border-white/5 relative overflow-hidden">
        <div class="absolute top-0 right-0 w-32 h-32 bg-primary/10 rounded-full blur-3xl -mr-16 -mt-16"></div>
        
        <p class="text-xs font-bold uppercase tracking-[0.2em] text-slate-400 mb-2">{{ __('Our Price') }}</p>
        <div class="flex items-baseline gap-2">
          <span class="font-headline text-5xl font-black text-primary italic">
            @if(!is_null($vehicle?->price))
              ${{ number_format($vehicle->price, 0, '.', ',') }}
            @else 
              {{ __('ASK') }}
            @endif
          </span>
          @if($vehicle?->price)
            <span class="text-xs text-slate-500 font-bold uppercase tracking-widest">+ {{ __('Tax & Fees') }}</span>
          @endif
        </div>

        <div class="mt-8 space-y-4">
          <div class="flex justify-between items-center py-3 border-b border-white/5">
            <span class="text-slate-400 text-xs font-bold uppercase tracking-widest">Mileage</span>
            <span class="font-headline text-lg font-bold">{{ number_format((int) ($vehicle?->mileage ?? 0)) }} <small class="text-[10px] text-slate-500 uppercase">mi</small></span>
          </div>
          <div class="flex justify-between items-center py-3 border-b border-white/5">
            <span class="text-slate-400 text-xs font-bold uppercase tracking-widest">Fuel Type</span>
            <span class="font-headline text-lg font-bold">{{ $vehicle?->fuel_type ?? 'N/A' }}</span>
          </div>
          <div class="flex justify-between items-center py-3 border-b border-white/5">
            <span class="text-slate-400 text-xs font-bold uppercase tracking-widest">Transmission</span>
            <span class="font-headline text-lg font-bold">{{ $vehicle?->transmission ?? 'N/A' }}</span>
          </div>
          <div class="flex justify-between items-center py-3 border-b border-white/5">
            <span class="text-slate-400 text-xs font-bold uppercase tracking-widest">Body Style</span>
            <span class="font-headline text-lg font-bold uppercase tracking-tighter">{{ $vehicle?->body_type ?? 'N/A' }}</span>
          </div>
          <div class="flex justify-between items-center py-3">
            <span class="text-slate-400 text-xs font-bold uppercase tracking-widest">Location</span>
            <span class="font-headline text-lg font-bold">{{ $vehicle?->location ?? 'N/A' }}</span>
          </div>
        </div>

        <div class="mt-8 grid grid-cols-2 gap-4">
           <div class="bg-white/5 rounded-2xl p-4 text-center border border-white/10">
              <span class="material-symbols-outlined text-primary mb-2">calendar_today</span>
              <p class="text-[10px] text-slate-500 uppercase font-bold tracking-widest">Year</p>
              <p class="font-headline font-black text-xl">{{ $vehicle?->year ?? 'N/A' }}</p>
           </div>
           <div class="bg-white/5 rounded-2xl p-4 text-center border border-white/10">
              <span class="material-symbols-outlined text-primary mb-2">palette</span>
              <p class="text-[10px] text-slate-500 uppercase font-bold tracking-widest">Color</p>
              <p class="font-headline font-black text-xl truncate px-1">{{ $vehicle?->exterior_color ?? 'N/A' }}</p>
           </div>
        </div>
      </div>

      {{-- Inquiry Form --}}
      @if ($vehicle?->status === 'approved')
        <div class="bg-white rounded-3xl p-8 shadow-xl border border-slate-200">
          <h3 class="font-headline text-2xl font-black uppercase tracking-tight mb-6 flex items-center gap-3">
            <span class="w-2 h-8 bg-primary rounded-full"></span>
            {{ __('Contact Seller') }}
          </h3>
          <form method="post" action="{{ route('inventory.inquiry', ['slug' => $vehicle->slug]) }}" class="space-y-4">
            @csrf
            <div class="space-y-2">
              <label class="text-[10px] font-black uppercase tracking-widest text-slate-400 ml-1">{{ __('Full Name') }}</label>
              <input type="text" name="sender_name" value="{{ old('sender_name', auth()->user()?->name) }}" 
                     class="w-full bg-slate-100 border-none rounded-2xl px-6 py-4 text-sm focus:ring-2 focus:ring-primary/20 transition-all" 
                     placeholder="{{ __('John Doe') }}" required />
            </div>
            <div class="space-y-2">
              <label class="text-[10px] font-black uppercase tracking-widest text-slate-400 ml-1">{{ __('Email Address') }}</label>
              <input type="email" name="sender_email" value="{{ old('sender_email', auth()->user()?->email) }}" 
                     class="w-full bg-slate-100 border-none rounded-2xl px-6 py-4 text-sm focus:ring-2 focus:ring-primary/20 transition-all" 
                     placeholder="{{ __('john@example.com') }}" required />
            </div>
            <div class="space-y-2">
              <label class="text-[10px] font-black uppercase tracking-widest text-slate-400 ml-1">{{ __('Your Message') }}</label>
              <textarea name="message" rows="4" 
                        class="w-full bg-slate-100 border-none rounded-2xl px-6 py-4 text-sm focus:ring-2 focus:ring-primary/20 transition-all resize-none" 
                        placeholder="{{ __('I\'m interested in this vehicle...') }}" required>{{ old('message') }}</textarea>
            </div>
            <button type="submit" class="w-full bg-[#1E2229] hover:bg-black text-white py-5 rounded-2xl font-black uppercase tracking-[0.2em] text-xs transition-all shadow-lg hover:shadow-primary/20 flex items-center justify-center gap-3 group">
              {{ __('Send Inquiry') }}
              <span class="material-symbols-outlined text-primary group-hover:translate-x-1 transition-transform">send</span>
            </button>
          </form>
          <p class="mt-4 text-[10px] text-slate-400 text-center uppercase tracking-widest font-bold">{{ __('Secure SSL encrypted message') }}</p>
        </div>
      @endif
      
      {{-- CTA / Sharing --}}
      <div class="bg-primary/5 rounded-3xl p-6 border border-primary/10 flex flex-col items-center text-center gap-4">
        <div class="w-12 h-12 rounded-full bg-primary flex items-center justify-center text-black">
          <span class="material-symbols-outlined">share</span>
        </div>
        <p class="text-xs font-black uppercase tracking-widest">{{ __('Share this listing') }}</p>
        <div class="flex gap-2">
          <button class="w-10 h-10 rounded-full bg-white border border-slate-200 flex items-center justify-center hover:text-primary transition-colors">
            <span class="material-symbols-outlined text-lg">link</span>
          </button>
          <button class="w-10 h-10 rounded-full bg-white border border-slate-200 flex items-center justify-center hover:text-blue-600 transition-colors">
             <i class="fab fa-facebook-f text-sm"></i>
          </button>
           <button class="w-10 h-10 rounded-full bg-white border border-slate-200 flex items-center justify-center hover:text-sky-400 transition-colors">
             <i class="fab fa-twitter text-sm"></i>
          </button>
        </div>
      </div>

    </aside>
  </div>
</section>

@if ($images->isNotEmpty())
  @push('scripts')
    <script>
      document.addEventListener('DOMContentLoaded', function() {
        const thumbs = document.querySelectorAll('.inv-gallery-thumb');
        const main = document.getElementById('inv-gallery-main');
        
        thumbs.forEach(thumb => {
          thumb.addEventListener('click', function() {
            // Update main image
            const fullUrl = this.getAttribute('data-full');
            if (fullUrl && main) {
              // Simple fade effect
              main.style.opacity = '0.4';
              setTimeout(() => {
                main.setAttribute('src', fullUrl);
                main.style.opacity = '1';
              }, 150);
            }
            
            // Highlight active thumb
            thumbs.forEach(t => t.classList.remove('border-primary'));
            this.classList.add('border-primary');
          });
        });
        
        // Initial active state
        if(thumbs.length > 0) thumbs[0].classList.add('border-primary');
      });
    </script>
  @endpush
@endif

@endsection