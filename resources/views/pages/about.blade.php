@extends('layouts.site')

@section('content')
@php
    $heroImg = \App\Support\VehicleImageUrl::url($sections['hero_image'] ?? 'asset/images/media/about-hero-bg.jpg');
    $valGrid1 = \App\Support\VehicleImageUrl::url($sections['values_grid_1'] ?? 'asset/images/media/about-values-1.jpg');
    $valGrid2 = \App\Support\VehicleImageUrl::url($sections['values_grid_2'] ?? 'asset/images/media/about-values-2.jpg');
    $valGrid3 = \App\Support\VehicleImageUrl::url($sections['values_grid_3'] ?? 'asset/images/media/about-values-3.jpg');
    $valGrid4 = \App\Support\VehicleImageUrl::url($sections['values_grid_4'] ?? 'asset/images/media/about-values-4.jpg');

    $galleryKeys = ['gallery_image_1','gallery_image_2','gallery_image_3','gallery_image_4'];
    $gallery = collect($galleryKeys)
      ->map(fn ($k) => trim((string) ($sections[$k] ?? '')))
      ->filter(fn ($p) => $p !== '')
      ->map(fn ($p) => \App\Support\VehicleImageUrl::url($p))
      ->values();

    $tBody = trim((string) ($sections['testimonial_1_body'] ?? ''));
    $tAuthor = trim((string) ($sections['testimonial_1_author'] ?? ''));
    $tBrand = trim((string) ($sections['testimonial_1_brand'] ?? ''));

    $team = collect([1, 2, 3, 4])->map(function ($i) use ($sections) {
      return [
        'photo' => \App\Support\VehicleImageUrl::url(trim((string) ($sections['team_'.$i.'_photo'] ?? ''))),
        'name' => trim((string) ($sections['team_'.$i.'_name'] ?? '')),
        'role' => trim((string) ($sections['team_'.$i.'_role'] ?? '')),
      ];
    })->filter(fn ($m) => $m['name'] !== '')->values();
@endphp

<style>
    .material-symbols-outlined {
        font-variation-settings: 'FILL' 0, 'wght' 400, 'GRAD' 0, 'opsz' 24;
    }
    .metallic-gradient {
        background: linear-gradient(135deg, #815500 0%, #ffb129 100%);
    }
</style>

<!-- Hero Section -->
<section class="relative min-h-screen pt-20 flex items-center overflow-hidden">
    <div class="flex flex-col md:flex-row w-full h-full">
        <div class="w-full md:w-1/2 relative h-[500px] md:h-screen">
            <img alt="Hero Image" class="w-full h-full object-cover" src="{{ $heroImg }}"/>
            <div class="absolute bottom-12 right-0 bg-primary-container text-on-primary-container px-8 py-6 flex flex-col items-center justify-center transform translate-x-1/4">
                <span class="text-4xl font-black font-headline">{{ $sections['hero_stat_value'] ?? '25+' }}</span>
                <span class="text-xs font-bold font-label tracking-tighter uppercase">{{ $sections['hero_stat_label'] ?? 'Years of Excellence' }}</span>
            </div>
        </div>
        <div class="w-full md:w-1/2 flex items-center px-12 md:px-24 py-20 bg-white">
            <div class="max-w-xl">
                <h2 class="text-sm font-label font-bold text-primary tracking-[0.3em] uppercase mb-4">Established {{ $sections['established_year'] ?? '1999' }}</h2>
                <h1 class="text-6xl md:text-8xl font-black font-display text-on-surface leading-[0.9] mb-8 uppercase">
                    @php
                        $heading = $sections['heading'] ?? 'WELCOME TO THE MOTORS';
                        // Split into "WELCOME TO" and "THE MOTORS"
                        if (str_contains($heading, 'THE MOTORS')) {
                            $parts = explode('THE MOTORS', $heading);
                            $firstPart = trim($parts[0]);
                            $lastPart = 'THE MOTORS';
                        } else {
                            $words = explode(' ', $heading);
                            $lastPart = array_pop($words);
                            $firstPart = implode(' ', $words);
                        }
                    @endphp
                    {!! nl2br(e($firstPart)) !!} <br/>
                    <span class="text-primary-container">{{ $lastPart }}</span>
                </h1>
                <p class="text-lg font-body text-on-surface-variant leading-relaxed mb-10">
                    {{ $sections['intro'] ?? 'Experience the pinnacle of automotive engineering and white-glove service.' }}
                </p>
                @if(!empty($sections['hero_primary_cta_text']))
                <a href="{{ $sections['hero_primary_cta_href'] ?? '#' }}" class="inline-block px-10 py-4 border-2 border-on-surface text-on-surface font-bold font-label uppercase tracking-widest hover:bg-on-surface hover:text-white transition-all text-center">
                    {{ $sections['hero_primary_cta_text'] }}
                </a>
                @endif
            </div>
        </div>
    </div>
</section>

<!-- Core Values -->
<section class="py-32 bg-surface-container-low overflow-hidden">
    <div class="max-w-7xl mx-auto px-8 grid grid-cols-1 md:grid-cols-2 gap-20 items-center">
        <div>
            <h2 class="text-5xl font-black font-headline text-on-surface mb-12 tracking-tight uppercase">
                @php
                    $vTitle = $sections['values_title'] ?? 'CORE VALUES';
                    $vWords = explode(' ', $vTitle);
                    $vLast = array_pop($vWords);
                    $vFirst = implode(' ', $vWords);
                @endphp
                {{ $vFirst }} <span class="text-primary">{{ $vLast }}</span>
            </h2>
            <div class="space-y-10">
                @foreach([1, 2, 3] as $i)
                    @php
                        $vT = $sections['val_'.$i.'_title'] ?? '';
                        $vB = $sections['val_'.$i.'_body'] ?? '';
                    @endphp
                    @if($vT)
                    <div class="flex items-start gap-6 group">
                        <div class="mt-1 flex-shrink-0 w-8 h-8 flex items-center justify-center bg-primary-container text-on-primary-container">
                            <span class="material-symbols-outlined font-bold">check</span>
                        </div>
                        <div>
                            <h3 class="text-xl font-bold font-headline mb-2 uppercase tracking-wide">{{ $vT }}</h3>
                            <p class="text-on-surface-variant font-body">{{ $vB }}</p>
                        </div>
                    </div>
                    @endif
                @endforeach
            </div>
        </div>
        <div class="grid grid-cols-2 gap-4 h-[600px]">
            <div class="space-y-4 pt-12">
                <div class="h-1/2 overflow-hidden bg-slate-200">
                    <img alt="Value 1" class="w-full h-full object-cover grayscale hover:grayscale-0 transition-all duration-700" src="{{ $valGrid1 }}"/>
                </div>
                <div class="h-1/2 overflow-hidden bg-slate-200">
                    <img alt="Value 2" class="w-full h-full object-cover" src="{{ $valGrid2 }}"/>
                </div>
            </div>
            <div class="space-y-4">
                <div class="h-1/2 overflow-hidden bg-slate-200">
                    <img alt="Value 3" class="w-full h-full object-cover" src="{{ $valGrid3 }}"/>
                </div>
                <div class="h-1/2 overflow-hidden bg-slate-200 relative">
                    <div class="absolute inset-0 bg-primary/20 mix-blend-multiply"></div>
                    <img alt="Value 4" class="w-full h-full object-cover" src="{{ $valGrid4 }}"/>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Media Gallery -->
<section class="py-32 bg-inverse-surface text-white">
    <div class="max-w-7xl mx-auto px-8">
        <div class="flex flex-col items-center mb-16">
            <h2 class="text-4xl font-black font-headline mb-4 tracking-widest uppercase">{{ $sections['gallery_title'] ?? 'Media Gallery' }}</h2>
            <div class="w-24 h-1.5 bg-primary-container"></div>
        </div>
        <div class="relative group">
            <div class="grid grid-cols-1 md:grid-cols-4 gap-4">
                @foreach($gallery as $img)
                <div class="h-80 bg-slate-800 overflow-hidden group/item cursor-pointer @if($loop->iteration == 3) border-t-4 border-primary-container @endif">
                    <img alt="Gallery" class="w-full h-full object-cover transition-transform duration-700 group-hover/item:scale-110" src="{{ $img }}"/>
                </div>
                @endforeach
            </div>
            <!-- Carousel Nav -->
            <button class="absolute -left-4 top-1/2 -translate-y-1/2 w-12 h-12 bg-primary-container text-on-primary-container flex items-center justify-center shadow-xl opacity-0 group-hover:opacity-100 transition-opacity">
                <span class="material-symbols-outlined">chevron_left</span>
            </button>
            <button class="absolute -right-4 top-1/2 -translate-y-1/2 w-12 h-12 bg-primary-container text-on-primary-container flex items-center justify-center shadow-xl opacity-0 group-hover:opacity-100 transition-opacity">
                <span class="material-symbols-outlined">chevron_right</span>
            </button>
            <div class="flex justify-center gap-3 mt-10">
                <div class="w-10 h-1 bg-primary-container"></div>
                <div class="w-10 h-1 bg-white/20"></div>
                <div class="w-10 h-1 bg-white/20"></div>
            </div>
        </div>
    </div>
</section>

<!-- Quick Links -->
<section class="py-20 bg-surface">
    <div class="max-w-7xl mx-auto px-8 grid grid-cols-1 md:grid-cols-3 gap-8">
        @foreach([1, 2, 3] as $i)
            @php
                $qT = $sections['adv_'.$i.'_title'] ?? '';
                $qB = $sections['adv_'.$i.'_body'] ?? '';
                $qI = $sections['adv_'.$i.'_icon'] ?? 'directions_car';
                $qH = $sections['adv_'.$i.'_href'] ?? '#';
            @endphp
            @if($qT)
            <div class="bg-surface-container-low p-10 flex flex-col items-center text-center group hover:bg-white transition-all shadow-xl shadow-transparent hover:shadow-slate-200 @if($i == 2) border-b-4 border-primary @endif">
                <div class="w-16 h-16 bg-surface-container-highest rounded-full flex items-center justify-center text-primary mb-6 transition-colors group-hover:bg-primary-container group-hover:text-on-primary-container">
                    <span class="material-symbols-outlined text-3xl">{{ $qI }}</span>
                </div>
                <h3 class="text-xl font-black font-headline mb-4 uppercase">{{ $qT }}</h3>
                <p class="text-on-surface-variant font-body mb-8">{{ $qB }}</p>
                <a class="font-label font-bold text-sm uppercase tracking-widest text-primary hover:underline flex items-center gap-2" href="{{ $qH }}">
                    {{ str_contains($qT, 'sell') ? 'Appraise Now' : (str_contains($qT, 'new car') ? 'Browse Inventory' : 'Book Appointment') }} <span class="material-symbols-outlined text-sm">arrow_forward</span>
                </a>
            </div>
            @endif
        @endforeach
    </div>
</section>

<!-- Testimonials -->
<section class="py-32 bg-inverse-surface relative overflow-hidden">
    <div class="absolute top-0 right-0 p-20 opacity-5">
        <span class="material-symbols-outlined text-[300px]" style="font-variation-settings: 'FILL' 1;">format_quote</span>
    </div>
    <div class="max-w-4xl mx-auto px-8 text-center relative z-10">
        <span class="material-symbols-outlined text-primary-container text-6xl mb-8" style="font-variation-settings: 'FILL' 1;">format_quote</span>
        <p class="text-3xl font-light font-body text-white leading-relaxed italic mb-12">
            "{{ $tBody }}"
        </p>
        <div class="flex flex-col items-center">
            <h4 class="text-lg font-bold font-headline text-white uppercase tracking-widest mb-1">{{ $tAuthor }}</h4>
            <p class="text-primary-container text-sm font-label font-semibold tracking-tighter uppercase">{{ $tBrand }}</p>
        </div>
        <div class="mt-16 text-3xl font-black font-display text-white/20 italic tracking-tighter uppercase">
            {{ config('app.name') }}
        </div>
    </div>
</section>

<!-- Our Team -->
<section class="py-32 bg-white">
    <div class="max-w-7xl mx-auto px-8">
        <h2 class="text-5xl font-black font-headline text-on-surface mb-20 tracking-tighter text-center uppercase">
            @php
                $teamTitle = $sections['team_title'] ?? 'OUR TEAM';
                $tWords = explode(' ', $teamTitle);
                $tLast = array_pop($tWords);
                $tFirst = implode(' ', $tWords);
            @endphp
            {{ $tFirst }} <span class="text-primary">{{ $tLast }}</span>
        </h2>
        <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-4 gap-8">
            @foreach($team as $m)
            <div class="group cursor-pointer">
                <div class="aspect-[3/4] mb-6 overflow-hidden bg-slate-100 grayscale hover:grayscale-0 transition-all duration-500">
                    <img alt="{{ $m['name'] }}" class="w-full h-full object-cover group-hover:scale-105 transition-transform" src="{{ $m['photo'] }}"/>
                </div>
                <h3 class="text-xl font-bold font-headline uppercase">{{ $m['name'] }}</h3>
                <p class="text-on-surface-variant font-label text-sm font-medium tracking-wide uppercase">{{ $m['role'] }}</p>
            </div>
            @endforeach
        </div>
    </div>
</section>

@endsection