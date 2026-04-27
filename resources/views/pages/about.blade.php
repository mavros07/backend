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

    $testimonials = collect([1, 2, 3])->map(function ($i) use ($sections) {
      return [
        'title' => trim((string) ($sections['testimonial_'.$i.'_title'] ?? '')),
        'body' => trim((string) ($sections['testimonial_'.$i.'_body'] ?? '')),
        'author' => trim((string) ($sections['testimonial_'.$i.'_author'] ?? '')),
        'brand' => trim((string) ($sections['testimonial_'.$i.'_brand'] ?? '')),
      ];
    })->filter(fn ($t) => $t['title'] !== '' || $t['body'] !== '' || $t['author'] !== '')->values();
  @endphp

  {{-- Hero Section (Motors Dealer Two Style) --}}
  <section class="relative min-h-[400px] flex items-center overflow-hidden bg-slate-900 py-20 md:py-32">
    <div class="absolute inset-0 z-0">
      <img src="{{ $heroImg }}" alt="" class="h-full w-full object-cover" />
      <div class="absolute inset-0 bg-black/50"></div>
    </div>
    <div class="container relative z-10 mx-auto px-6">
      <div class="max-w-3xl">
        @if (!empty($sections['kicker']))
          <span class="inline-block bg-primary px-3 py-1 text-[11px] font-bold uppercase tracking-widest text-white mb-6">
            {{ $sections['kicker'] }}
          </span>
        @endif
        <h1 class="font-headline text-4xl font-black uppercase tracking-tight text-white md:text-6xl lg:text-7xl">
          {{ $sections['heading'] ?? ($page->title ?? 'About Us') }}
        </h1>
        @if (!empty($sections['intro']) || !empty($page->meta_description))
          <p class="mt-6 text-lg leading-relaxed text-white/90 md:text-xl">
            {{ $sections['intro'] ?? $page->meta_description }}
          </p>
        @endif

        <div class="mt-10 flex flex-wrap gap-4">
          @if (!empty($sections['hero_primary_cta_text']))
            <a href="{{ $sections['hero_primary_cta_href'] ?? '/inventory' }}" class="inline-flex h-12 items-center justify-center bg-primary px-8 text-sm font-bold uppercase tracking-wider text-white transition-colors hover:bg-primary/90">
              {{ $sections['hero_primary_cta_text'] }}
            </a>
          @endif
          @if (!empty($sections['hero_secondary_cta_text']))
            <a href="{{ $sections['hero_secondary_cta_href'] ?? '/contact' }}" class="inline-flex h-12 items-center justify-center border-2 border-white px-8 text-sm font-bold uppercase tracking-wider text-white transition-all hover:bg-white hover:text-slate-900">
              {{ $sections['hero_secondary_cta_text'] }}
            </a>
          @endif
        </div>
      </div>
    </div>
  </section>

  {{-- Welcome Section --}}
  <section class="bg-white py-16 md:py-24">
    <div class="container mx-auto px-6">
      <div class="grid grid-cols-1 gap-12 lg:grid-cols-2 lg:items-center">
        <div class="relative group">
            <div class="absolute -inset-4 bg-primary/10 rounded-2xl scale-95 opacity-0 group-hover:scale-100 group-hover:opacity-100 transition-all duration-500"></div>
            <img src="{{ $welcomeImg }}" alt="{{ $sections['welcome_title'] ?? 'Welcome' }}" class="relative z-10 w-full rounded-xl shadow-2xl shadow-slate-200/50 object-cover aspect-[4/3] lg:aspect-square" loading="lazy" />
        </div>
        <div>
          <div class="mb-8">
            <h2 class="font-headline text-3xl font-black uppercase tracking-tight text-slate-900 md:text-4xl">
              @php
                $welcomeTitle = $sections['welcome_title'] ?? 'Welcome to Motors';
                $words = explode(' ', $welcomeTitle);
                $lastWord = array_pop($words);
                $firstPart = implode(' ', $words);
              @endphp
              {{ $firstPart }} <span class="text-primary">{{ $lastWord }}</span>
            </h2>
            <div class="motors-colored-separator mt-4 !justify-start">
              <div class="first-long"></div>
              <div class="last-short"></div>
            </div>
          </div>

          @if (!empty($sections['welcome_subtitle']))
            <h4 class="text-lg font-bold italic leading-relaxed text-slate-800 md:text-xl">
              "{{ $sections['welcome_subtitle'] }}"
            </h4>
          @endif

          @if (!empty($sections['welcome_body']))
            <div class="mt-6 space-y-4 text-base leading-relaxed text-slate-600 md:text-lg">
              {!! nl2br(e($sections['welcome_body'])) !!}
            </div>
          @endif

          @if (!empty($sections['welcome_signature']))
            <div class="mt-10 flex items-center gap-4">
               <div class="h-px w-12 bg-slate-300"></div>
               <p class="font-headline text-sm font-bold uppercase tracking-wider text-slate-500">
                 {{ $sections['welcome_signature'] }}
               </p>
            </div>
          @endif
        </div>
      </div>
    </div>
  </section>

  {{-- Advantages Section --}}
  <section class="bg-slate-50 py-16 md:py-24">
    <div class="container mx-auto px-6">
      <div class="mb-16 text-center">
        <h2 class="font-headline text-3xl font-black uppercase tracking-tight text-slate-900 md:text-4xl">
          {{ $sections['advantages_title'] ?? __('OUR ADVANTAGES') }}
        </h2>
        <div class="motors-colored-separator mt-4">
          <div class="first-long"></div>
          <div class="last-short"></div>
        </div>
      </div>

      <div class="grid grid-cols-1 gap-8 md:grid-cols-3">
        @foreach ([1, 2, 3] as $i)
          @php
            $icon = trim((string) ($sections['adv_'.$i.'_icon'] ?? ''));
            $title = trim((string) ($sections['adv_'.$i.'_title'] ?? ''));
            $body = trim((string) ($sections['adv_'.$i.'_body'] ?? ''));
          @endphp
          @if ($title !== '')
            <div class="group bg-white p-8 text-center shadow-sm transition-all hover:-translate-y-2 hover:shadow-xl">
              <div class="mx-auto mb-6 flex h-20 w-20 items-center justify-center rounded-full bg-slate-50 text-primary transition-colors group-hover:bg-primary group-hover:text-white">
                <span class="material-symbols-outlined text-4xl">
                  {{ $icon !== '' ? $icon : 'check_circle' }}
                </span>
              </div>
              <h3 class="font-headline text-lg font-black uppercase tracking-tight text-slate-900">{{ $title }}</h3>
              @if ($body !== '')
                <p class="mt-4 text-sm leading-relaxed text-slate-500">{{ $body }}</p>
              @endif
            </div>
          @endif
        @endforeach
      </div>
    </div>
  </section>

  {{-- Core Values Section --}}
  <section class="bg-white py-16 md:py-24">
    <div class="container mx-auto px-6">
      <div class="grid grid-cols-1 gap-12 lg:grid-cols-2 lg:items-center">
        <div class="order-2 lg:order-1">
          <h2 class="font-headline text-3xl font-black uppercase tracking-tight text-slate-900 md:text-4xl">
            {{ $sections['values_title'] ?? __('CORE VALUES') }}
          </h2>
          <div class="motors-colored-separator mt-4 !justify-start">
            <div class="first-long"></div>
            <div class="last-short"></div>
          </div>
          @if (!empty($sections['values_body']))
            <p class="mt-8 text-base leading-relaxed text-slate-600 md:text-lg">
              {{ $sections['values_body'] }}
            </p>
          @endif
          @if ($valuesList->isNotEmpty())
            <ul class="mt-8 space-y-4">
              @foreach ($valuesList as $item)
                <li class="flex items-start gap-3">
                  <span class="material-symbols-outlined text-primary mt-0.5">check_circle</span>
                  <span class="text-base font-medium text-slate-700">{{ $item }}</span>
                </li>
              @endforeach
            </ul>
          @endif
        </div>
        <div class="order-1 lg:order-2">
            <img src="{{ $valuesImg }}" alt="{{ $sections['values_title'] ?? 'Core Values' }}" class="w-full rounded-xl shadow-xl object-cover aspect-[4/3]" loading="lazy" />
        </div>
      </div>
    </div>
  </section>

  {{-- Media Gallery --}}
  @if ($gallery->isNotEmpty())
    @php
      $galleryPages = $gallery->chunk(4)->values();
    @endphp
    <section class="bg-[#232628] py-20 px-6">
      <div class="container mx-auto">
        <div class="text-center mb-16">
          <h2 class="font-headline text-3xl font-black uppercase tracking-tight text-white md:text-4xl">
            {{ $sections['gallery_title'] ?? __('MEDIA GALLERY') }}
          </h2>
          <div class="motors-colored-separator mt-4">
            <div class="first-long"></div>
            <div class="last-short"></div>
          </div>
        </div>

        <div class="motors-carousel" data-simple-carousel data-carousel-type="gallery-pages">
          <div class="motors-carousel-viewport overflow-hidden" data-carousel-viewport>
            <div class="motors-carousel-track flex" data-carousel-track>
              @foreach ($galleryPages as $pageChunk)
                <div class="w-full shrink-0 px-2" data-carousel-slide>
                  <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4">
                    @foreach ($pageChunk as $img)
                      <div class="group relative aspect-[4/3] overflow-hidden rounded bg-black/20">
                        <img src="{{ $img }}" alt="Gallery" data-gallery-image class="h-full w-full object-cover transition-transform duration-700 group-hover:scale-110" />
                        <div class="absolute inset-0 bg-primary/40 opacity-0 group-hover:opacity-100 transition-opacity duration-300 flex items-center justify-center">
                           <span class="material-symbols-outlined text-white text-4xl">zoom_in</span>
                        </div>
                      </div>
                    @endforeach
                  </div>
                </div>
              @endforeach
            </div>
          </div>

          <div class="mt-12 flex items-center justify-center gap-6">
            <button type="button" class="motors-gallery-chevron" data-carousel-prev>
              <span class="material-symbols-outlined text-3xl">chevron_left</span>
            </button>
            <div class="motors-gallery-dots flex gap-2" data-carousel-dots></div>
            <button type="button" class="motors-gallery-chevron" data-carousel-next>
              <span class="material-symbols-outlined text-3xl">chevron_right</span>
            </button>
          </div>
        </div>
      </div>
    </section>
  @endif

  {{-- Testimonials --}}
  <section class="bg-slate-50 py-16 md:py-24">
    <div class="container mx-auto px-6">
       <div class="mb-16 text-center">
        <h2 class="font-headline text-3xl font-black uppercase tracking-tight text-slate-900 md:text-4xl">
          {{ $sections['testimonials_title'] ?? __('CUSTOMER TESTIMONIALS') }}
        </h2>
        <div class="motors-colored-separator mt-4">
          <div class="first-long"></div>
          <div class="last-short"></div>
        </div>
      </div>

      @if ($testimonials->isNotEmpty())
        <div class="motors-carousel relative" data-simple-carousel data-carousel-type="testimonials">
          <div class="motors-carousel-viewport overflow-hidden" data-carousel-viewport>
            <div class="motors-carousel-track flex" data-carousel-track>
              @foreach ($testimonials as $t)
                <div class="w-full shrink-0 px-4" data-carousel-slide>
                  <div class="mx-auto max-w-3xl bg-white p-10 shadow-xl shadow-slate-200/50 rounded-lg text-center relative overflow-hidden">
                    {{-- Decorative quote icon --}}
                    <span class="material-symbols-outlined absolute -top-4 -left-4 text-9xl text-slate-50 select-none">format_quote</span>
                    
                    @if ($t['title'] !== '')
                      <h5 class="relative z-10 text-xl font-bold text-slate-900">{{ $t['title'] }}</h5>
                    @endif
                    @if ($t['body'] !== '')
                      <p class="relative z-10 mt-6 text-lg italic leading-relaxed text-slate-600">"{{ $t['body'] }}"</p>
                    @endif
                    <div class="relative z-10 mt-10 flex flex-col items-center gap-2">
                       <span class="h-1 w-12 bg-primary rounded-full"></span>
                       <div class="text-base font-black uppercase tracking-tight text-slate-900">{{ $t['author'] }}</div>
                       @if ($t['brand'] !== '')
                         <div class="text-sm font-bold text-primary">{{ $t['brand'] }}</div>
                       @endif
                    </div>
                  </div>
                </div>
              @endforeach
            </div>
          </div>

          <button type="button" class="motors-carousel-nav motors-carousel-prev !-left-4 lg:!-left-8" data-carousel-prev>
            <span class="material-symbols-outlined">chevron_left</span>
          </button>
          <button type="button" class="motors-carousel-nav motors-carousel-next !-right-4 lg:!-right-8" data-carousel-next>
            <span class="material-symbols-outlined">chevron_right</span>
          </button>

          <div class="mt-10 flex justify-center gap-2" data-carousel-dots></div>
        </div>
      @endif
    </div>
  </section>

@endsection