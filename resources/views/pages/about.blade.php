@extends('layouts.site')

@section('content')
  @php
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
  @endphp

  <section class="relative overflow-hidden py-20 md:py-24">
    <img src="{{ $heroImg }}" alt="" class="absolute inset-0 h-full w-full object-cover" />
    <div class="absolute inset-0 bg-gradient-to-r from-black/90 via-black/70 to-black/50"></div>
    <div class="absolute inset-0 bg-[radial-gradient(circle_at_20%_20%,rgba(255,177,41,0.22),transparent_55%)]"></div>
    <div class="relative z-10 mx-auto max-w-6xl px-6 text-white">
      <p class="text-primary font-bold text-xs tracking-[0.22em] uppercase">{{ $sections['kicker'] ?? 'Our Story' }}</p>
      <h1 class="mt-3 font-headline text-4xl font-black uppercase tracking-tight sm:text-5xl md:text-6xl">
        {{ $sections['heading'] ?? ($page->title ?? 'About Us') }}
      </h1>
      @if (!empty($sections['intro']) || !empty($page->meta_description))
        <p class="mt-6 max-w-3xl text-sm leading-relaxed text-slate-200/90 sm:text-base">
          {{ $sections['intro'] ?? $page->meta_description }}
        </p>
      @endif

      <div class="mt-10 flex flex-col gap-3 sm:flex-row sm:items-center">
        @php
          $primaryHref = trim((string) ($sections['hero_primary_cta_href'] ?? '/inventory')) ?: '/inventory';
          $secondaryHref = trim((string) ($sections['hero_secondary_cta_href'] ?? '/contact')) ?: '/contact';
          $primaryUrl = \Illuminate\Support\Str::startsWith($primaryHref, ['http://', 'https://']) ? $primaryHref : url($primaryHref);
          $secondaryUrl = \Illuminate\Support\Str::startsWith($secondaryHref, ['http://', 'https://']) ? $secondaryHref : url($secondaryHref);
        @endphp
        <a href="{{ $primaryUrl }}" class="inline-flex items-center justify-center rounded bg-primary px-8 py-3 text-xs font-black uppercase tracking-[0.18em] text-on_surface shadow-lg transition hover:bg-yellow-400">
          {{ $sections['hero_primary_cta_text'] ?? __('Browse Inventory') }}
        </a>
        <a href="{{ $secondaryUrl }}" class="inline-flex items-center justify-center rounded border border-white/20 bg-white/5 px-8 py-3 text-xs font-black uppercase tracking-[0.18em] text-white backdrop-blur transition hover:bg-white/10">
          {{ $sections['hero_secondary_cta_text'] ?? __('Contact') }}
        </a>
      </div>
    </div>
  </section>

  <section class="bg-[#0b0e12] py-16 md:py-20">
    <div class="mx-auto grid max-w-6xl grid-cols-1 gap-10 px-6 md:grid-cols-2 md:items-center">
      <div class="relative overflow-hidden rounded-2xl border border-white/10 bg-white/5 shadow-[0_20px_60px_rgba(0,0,0,0.45)]">
        <img src="{{ $welcomeImg }}" alt="" class="h-full w-full object-cover" />
        <div class="absolute inset-0 bg-gradient-to-t from-black/50 via-black/0 to-black/0"></div>
      </div>
      <div class="text-white">
        <h2 class="font-headline text-3xl font-black uppercase tracking-tight md:text-4xl">{{ $sections['welcome_title'] ?? __('Welcome') }}</h2>
        <p class="mt-4 text-sm font-semibold uppercase tracking-[0.16em] text-primary/95">{{ $sections['welcome_subtitle'] ?? '' }}</p>
        <p class="mt-5 text-sm leading-relaxed text-slate-200/90 sm:text-base">{{ $sections['welcome_body'] ?? '' }}</p>
        @if (!empty($sections['welcome_signature']))
          <p class="mt-6 text-xs font-bold uppercase tracking-[0.2em] text-slate-300/90">{{ $sections['welcome_signature'] }}</p>
        @endif
      </div>
    </div>
  </section>

  <section class="bg-black py-16 md:py-20">
    <div class="mx-auto grid max-w-6xl grid-cols-1 gap-10 px-6 md:grid-cols-2 md:items-center">
      <div class="text-white">
        <h2 class="font-headline text-3xl font-black uppercase tracking-tight md:text-4xl">{{ $sections['values_title'] ?? __('Core Values') }}</h2>
        <p class="mt-4 text-sm leading-relaxed text-slate-200/90 sm:text-base">{{ $sections['values_body'] ?? '' }}</p>

        @if ($valuesList->isNotEmpty())
          <ul class="mt-6 grid gap-3">
            @foreach ($valuesList as $item)
              <li class="flex items-start gap-3 rounded-xl border border-white/10 bg-white/5 px-4 py-3">
                <span class="material-symbols-outlined mt-0.5 text-primary">check_circle</span>
                <span class="text-sm font-semibold text-slate-100/95">{{ $item }}</span>
              </li>
            @endforeach
          </ul>
        @endif
      </div>

      <div class="relative overflow-hidden rounded-2xl border border-white/10 bg-white/5 shadow-[0_20px_60px_rgba(0,0,0,0.45)]">
        <img src="{{ $valuesImg }}" alt="" class="h-full w-full object-cover" />
        <div class="absolute inset-0 bg-gradient-to-t from-black/50 via-black/0 to-black/0"></div>
      </div>
    </div>
  </section>

  @if ($gallery->isNotEmpty())
    <section class="bg-[#0b0e12] py-16 md:py-20">
      <div class="mx-auto max-w-6xl px-6">
        <div class="flex items-end justify-between gap-6">
          <h2 class="font-headline text-3xl font-black uppercase tracking-tight text-white md:text-4xl">{{ $sections['gallery_title'] ?? __('Media Gallery') }}</h2>
          <a href="{{ route('inventory.index') }}" class="hidden text-xs font-bold uppercase tracking-[0.18em] text-primary hover:text-yellow-400 sm:inline-flex">{{ __('View inventory') }} →</a>
        </div>
        <div class="mt-8 grid grid-cols-2 gap-4 sm:grid-cols-3">
          @foreach ($gallery as $img)
            <a href="{{ $img }}" target="_blank" rel="noopener noreferrer" class="group relative overflow-hidden rounded-2xl border border-white/10 bg-white/5 shadow-sm">
              <img src="{{ $img }}" alt="" class="h-40 w-full object-cover transition-transform duration-500 group-hover:scale-105 sm:h-44" loading="lazy" decoding="async" />
              <div class="pointer-events-none absolute inset-0 bg-gradient-to-t from-black/45 via-black/0 to-black/0 opacity-70"></div>
            </a>
          @endforeach
        </div>
      </div>
    </section>
  @endif

  <section class="bg-black py-16 md:py-20">
    <div class="mx-auto max-w-6xl px-6">
      <h2 class="font-headline text-3xl font-black uppercase tracking-tight text-white md:text-4xl">{{ $sections['advantages_title'] ?? __('Our Advantages') }}</h2>
      <div class="mt-8 grid grid-cols-1 gap-4 md:grid-cols-2">
        @foreach ([1,2,3] as $i)
          @php
            $t = trim((string) ($sections['adv_'.$i.'_title'] ?? ''));
            $b = trim((string) ($sections['adv_'.$i.'_body'] ?? ''));
          @endphp
          @if ($t !== '')
            <details class="group rounded-2xl border border-white/10 bg-white/5 p-5 text-white open:bg-white/[0.07]">
              <summary class="flex cursor-pointer list-none items-center justify-between gap-4">
                <span class="text-sm font-black uppercase tracking-[0.14em]">{{ $t }}</span>
                <span class="material-symbols-outlined text-white/60 transition-transform group-open:rotate-180">expand_more</span>
              </summary>
              @if ($b !== '')
                <p class="mt-4 text-sm leading-relaxed text-slate-200/90">{{ $b }}</p>
              @endif
            </details>
          @endif
        @endforeach
      </div>
    </div>
  </section>

  @if ($team->isNotEmpty())
    <section class="bg-[#0b0e12] py-16 md:py-20">
      <div class="mx-auto max-w-6xl px-6">
        <h2 class="font-headline text-3xl font-black uppercase tracking-tight text-white md:text-4xl">{{ $sections['team_title'] ?? __('Our Team') }}</h2>
        <div class="mt-8 grid grid-cols-1 gap-5 sm:grid-cols-2 lg:grid-cols-4">
          @foreach ($team as $m)
            @php
              $photoUrl = \App\Support\VehicleImageUrl::url($m['photo'] !== '' ? $m['photo'] : 'asset/images/media/team-placeholder.jpg');
            @endphp
            <div class="overflow-hidden rounded-2xl border border-white/10 bg-white/5 text-white shadow-sm">
              <div class="relative aspect-[4/3] overflow-hidden">
                <img src="{{ $photoUrl }}" alt="" class="h-full w-full object-cover" loading="lazy" decoding="async" />
                <div class="absolute inset-0 bg-gradient-to-t from-black/55 via-black/0 to-black/0"></div>
              </div>
              <div class="p-4">
                <div class="text-sm font-black uppercase tracking-[0.14em]">{{ $m['name'] }}</div>
                @if ($m['role'] !== '')
                  <div class="mt-1 text-xs font-semibold uppercase tracking-[0.18em] text-primary/95">{{ $m['role'] }}</div>
                @endif
                <div class="mt-3 grid gap-1.5 text-xs text-slate-200/90">
                  @if ($m['email'] !== '')
                    <a href="mailto:{{ $m['email'] }}" class="inline-flex items-center gap-2 hover:text-white">
                      <span class="material-symbols-outlined text-[16px] text-white/50">mail</span>
                      <span class="truncate">{{ $m['email'] }}</span>
                    </a>
                  @endif
                  @if ($m['phone'] !== '')
                    <a href="tel:{{ preg_replace('/\\s+/', '', $m['phone']) }}" class="inline-flex items-center gap-2 hover:text-white">
                      <span class="material-symbols-outlined text-[16px] text-white/50">call</span>
                      <span class="truncate">{{ $m['phone'] }}</span>
                    </a>
                  @endif
                </div>
              </div>
            </div>
          @endforeach
        </div>
      </div>
    </section>
  @endif

  @if (!empty($page?->content_html))
    <section class="bg-black py-10">
      <div class="mx-auto max-w-6xl px-6">
        <details class="rounded-2xl border border-white/10 bg-white/5 p-5 text-white">
          <summary class="flex cursor-pointer list-none items-center justify-between gap-4">
            <span class="text-sm font-black uppercase tracking-[0.14em]">{{ __('Additional content') }}</span>
            <span class="material-symbols-outlined text-white/60">expand_more</span>
          </summary>
          <div class="prose prose-invert mt-5 max-w-none">
            {!! $page->content_html !!}
          </div>
        </details>
      </div>
    </section>
  @endif
@endsection