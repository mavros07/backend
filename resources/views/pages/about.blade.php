@extends('layouts.site')

@section('content')
  @php
    $brand = config('app.name', 'Motors');
    $heroImg = \App\Support\VehicleImageUrl::url($sections['hero_image'] ?? 'asset/images/media/about-hero-bg.jpg');
    $welcomeImg = \App\Support\VehicleImageUrl::url($sections['welcome_image'] ?? 'asset/images/media/about-welcome.jpg');
    $valuesImg = \App\Support\VehicleImageUrl::url($sections['values_image'] ?? 'asset/images/media/about-values.jpg');

    $valuesList = preg_split('/\r\n|\r|\n/', (string) ($sections['values_list'] ?? '')) ?: [];
    $valuesList = collect($valuesList)->map(fn ($s) => trim((string) $s))->filter()->values();

    $galleryKeys = ['gallery_image_1','gallery_image_2','gallery_image_3','gallery_image_4','gallery_image_5','gallery_image_6'];
    $gallery = collect($galleryKeys)
      ->map(fn ($k) => trim((string) ($sections[$k] ?? '')))
      ->filter(fn ($p) => $p !== '')
      ->map(fn ($p) => \App\Support\VehicleImageUrl::url($p))
      ->values();

    $team = collect([1,2,3,4])->map(function ($i) use ($sections) {
      return [
        'photo' => trim((string) ($sections['team_'.$i.'_photo'] ?? '')),
        'name' => trim((string) ($sections['team_'.$i.'_name'] ?? '')),
        'role' => trim((string) ($sections['team_'.$i.'_role'] ?? '')),
        'email' => trim((string) ($sections['team_'.$i.'_email'] ?? '')),
        'phone' => trim((string) ($sections['team_'.$i.'_phone'] ?? '')),
      ];
    })->filter(fn ($m) => $m['name'] !== '')->values();

    $testimonials = collect([1, 2, 3])->map(function ($i) use ($sections) {
      return [
        'title' => trim((string) ($sections['testimonial_'.$i.'_title'] ?? '')),
        'body' => trim((string) ($sections['testimonial_'.$i.'_body'] ?? '')),
        'author' => trim((string) ($sections['testimonial_'.$i.'_author'] ?? '')),
        'brand' => trim((string) ($sections['testimonial_'.$i.'_brand'] ?? '')),
      ];
    })->filter(fn ($t) => $t['title'] !== '' || $t['body'] !== '' || $t['author'] !== '')->values();
  @endphp

  {{-- Hero (Motors-style simple banner) --}}
  <section class="relative overflow-hidden bg-white">
    <div class="absolute inset-0">
      <img src="{{ $heroImg }}" alt="" class="h-full w-full object-cover" />
      <div class="absolute inset-0 bg-black/45"></div>
    </div>
    <div class="relative mx-auto max-w-6xl px-6 py-16 text-white md:py-20">
      <h1 class="font-headline text-4xl font-black uppercase tracking-tight md:text-5xl">{{ $sections['heading'] ?? ($page->title ?? 'About Us') }}</h1>
      @if (!empty($sections['intro']) || !empty($page->meta_description))
        <p class="mt-4 max-w-3xl text-sm text-white/85 md:text-base">{{ $sections['intro'] ?? $page->meta_description }}</p>
      @endif
    </div>
  </section>

  {{-- Welcome --}}
  <section class="bg-white py-16">
    <div class="mx-auto max-w-6xl px-6">
      <div class="grid grid-cols-1 gap-10 md:grid-cols-2 md:items-start">
        <div class="overflow-hidden rounded">
          <img src="{{ $welcomeImg }}" alt="" class="h-auto w-full object-cover" loading="lazy" decoding="async" />
        </div>
        <div>
          <h3 class="font-headline text-2xl font-black uppercase tracking-tight text-slate-900 md:text-3xl">
            {{ __('WELCOME TO THE') }} <span class="text-primary">{{ strtoupper($brand) }}</span>
          </h3>
          @if (!empty($sections['welcome_subtitle']))
            <h5 class="mt-4 text-[15px] font-semibold leading-relaxed text-slate-700">{{ $sections['welcome_subtitle'] }}</h5>
          @endif
          @if (!empty($sections['welcome_body']))
            <p class="mt-5 text-[15px] leading-[1.9] text-slate-600">{{ $sections['welcome_body'] }}</p>
          @endif
          @if (!empty($sections['welcome_signature']))
            <p class="mt-4 text-sm italic text-slate-500">{{ $sections['welcome_signature'] }}</p>
          @endif
        </div>
      </div>
    </div>
  </section>

  {{-- Core values --}}
  <section class="bg-white py-16">
    <div class="mx-auto max-w-6xl px-6">
      <div class="grid grid-cols-1 gap-10 md:grid-cols-2 md:items-start">
        <div>
          <h3 class="font-headline text-2xl font-black uppercase tracking-tight text-slate-900 md:text-3xl">{{ $sections['values_title'] ?? __('CORE VALUES') }}</h3>
          <hr class="mt-4 border-slate-200" />
          @if (!empty($sections['values_body']))
            <p class="mt-6 text-sm leading-[2] text-slate-500">{{ $sections['values_body'] }}</p>
          @endif
          @if ($valuesList->isNotEmpty())
            <ul class="mt-5 list-disc pl-5 text-[15px] leading-[2] text-slate-700">
              @foreach ($valuesList as $item)
                <li>{{ $item }}</li>
              @endforeach
            </ul>
          @endif
        </div>
        <div class="overflow-hidden rounded">
          <img src="{{ $valuesImg }}" alt="" class="h-auto w-full object-cover" loading="lazy" decoding="async" />
        </div>
      </div>
    </div>
  </section>

  {{-- Media gallery (carousel strip) --}}
  @if ($gallery->isNotEmpty())
    @php
      $galleryPages = $gallery->chunk(4)->values();
    @endphp
    <section class="bg-[#2e3133] py-24 px-6 md:px-12 lg:px-24">
      <div class="mx-auto w-full max-w-7xl">
        <div class="text-center mb-16">
          <h2 class="motors-orange-underline text-white font-headline text-3xl md:text-4xl font-extrabold tracking-tight uppercase">
            {{ $sections['gallery_title'] ?? __('MEDIA GALLERY') }}
          </h2>
        </div>

        <div class="motors-carousel motors-carousel--gallery" data-simple-carousel data-carousel-type="gallery-pages">
          <div class="motors-carousel-viewport overflow-hidden" data-carousel-viewport>
            <div class="motors-carousel-track flex gap-0" data-carousel-track>
              @foreach ($galleryPages as $page)
                <div class="w-full shrink-0" data-carousel-slide>
                  <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-1">
                    @foreach ($page as $img)
                      <a href="{{ $img }}" target="_blank" rel="noopener noreferrer" class="aspect-[4/3] overflow-hidden group cursor-pointer block bg-black/10">
                        <img src="{{ $img }}" alt="{{ __('Gallery image') }}" data-gallery-image class="w-full h-full object-cover transition-transform duration-700 group-hover:scale-110" loading="lazy" decoding="async" />
                      </a>
                    @endforeach
                  </div>
                </div>
              @endforeach
            </div>
          </div>

          <div class="motors-gallery-controls flex items-center justify-center mt-12 gap-8">
            <button type="button" class="motors-gallery-chevron" data-carousel-prev aria-label="{{ __('Previous') }}">
              <span class="material-symbols-outlined text-3xl">chevron_left</span>
            </button>
            <div class="motors-gallery-dots flex items-center gap-3" data-carousel-dots></div>
            <button type="button" class="motors-gallery-chevron" data-carousel-next aria-label="{{ __('Next') }}">
              <span class="material-symbols-outlined text-3xl">chevron_right</span>
            </button>
          </div>
        </div>
      </div>
    </section>
  @endif

  {{-- Advantages + Testimonials --}}
  <section class="bg-white py-16">
    <div class="mx-auto max-w-6xl px-6">
      <div class="grid grid-cols-1 gap-10 md:grid-cols-2 md:items-start">
        <div>
          <h3 class="font-headline text-2xl font-black uppercase tracking-tight text-slate-900 md:text-3xl">{{ $sections['advantages_title'] ?? __('OUR ADVANTAGES') }}</h3>
          <hr class="mt-4 border-slate-200" />
          <div class="mt-6 space-y-3">
            @foreach ([1,2,3] as $i)
              @php
                $t = trim((string) ($sections['adv_'.$i.'_title'] ?? ''));
                $b = trim((string) ($sections['adv_'.$i.'_body'] ?? ''));
              @endphp
              @if ($t !== '')
                <details class="rounded border border-slate-200 bg-white p-4 open:shadow-sm">
                  <summary class="cursor-pointer list-none">
                    <div class="flex items-center justify-between gap-4">
                      <span class="text-sm font-bold text-slate-900">{{ $t }}</span>
                      <span class="material-symbols-outlined text-base text-slate-500">expand_more</span>
                    </div>
                  </summary>
                  @if ($b !== '')
                    <p class="mt-3 text-[15px] leading-[1.9] text-slate-600">{{ $b }}</p>
                  @endif
                </details>
              @endif
            @endforeach
          </div>
        </div>

        <div>
          <h3 class="font-headline text-2xl font-black uppercase tracking-tight text-slate-900 md:text-3xl">{{ $sections['testimonials_title'] ?? __('CUSTOMER TESTIMONIALS') }}</h3>
          <hr class="mt-4 border-slate-200" />

          @if ($testimonials->isNotEmpty())
            <div class="motors-carousel motors-carousel--testimonials relative mt-6" data-simple-carousel data-carousel-type="testimonials">
              <div class="motors-carousel-viewport overflow-hidden" data-carousel-viewport>
                <div class="motors-carousel-track flex gap-4" data-carousel-track>
                @foreach ($testimonials as $t)
                  <div class="w-full shrink-0 rounded border border-slate-200 bg-white p-5" data-carousel-slide>
                    @if ($t['title'] !== '')
                      <h5 class="text-[15px] font-bold text-slate-900">{{ $t['title'] }}</h5>
                    @endif
                    @if ($t['body'] !== '')
                      <p class="mt-3 text-[15px] leading-[1.9] text-slate-600">{{ $t['body'] }}</p>
                    @endif
                    <div class="mt-4 flex items-center justify-between gap-4 text-sm">
                      <div class="font-semibold text-slate-900">{{ $t['author'] !== '' ? $t['author'] : '—' }}</div>
                      @if ($t['brand'] !== '')
                        <div class="text-slate-500">{{ $t['brand'] }}</div>
                      @endif
                    </div>
                  </div>
                @endforeach
                </div>
              </div>

              <button type="button" class="motors-carousel-nav motors-carousel-prev" data-carousel-prev aria-label="{{ __('Previous') }}">
                <span class="material-symbols-outlined text-[20px]">chevron_left</span>
              </button>
              <button type="button" class="motors-carousel-nav motors-carousel-next" data-carousel-next aria-label="{{ __('Next') }}">
                <span class="material-symbols-outlined text-[20px]">chevron_right</span>
              </button>

              <div class="motors-carousel-dots mt-4 flex justify-center gap-2" data-carousel-dots></div>
            </div>
          @endif
        </div>
      </div>
    </div>
  </section>

  {{-- Our Team removed per requirements (About is section-fields only; no team block). --}}

  {{-- Intentionally do NOT render $page->content_html on About.
       This page is section-fields only (no Elementor/HTML dumps). --}}
@endsection