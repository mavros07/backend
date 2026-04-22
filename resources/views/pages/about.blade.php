@extends('layouts.site')

@section('content')
  <section class="relative overflow-hidden py-20">
    <img src="{{ \App\Support\PlaceholderMedia::url($sections['hero_image'] ?? 'asset/images/media/about-hero-bg.jpg') }}" alt="" class="absolute inset-0 h-full w-full object-cover" />
    <div class="absolute inset-0 bg-gradient-to-r from-black/85 via-black/70 to-black/55"></div>
    <div class="relative z-10 max-w-6xl mx-auto px-6 text-white">
      <p class="text-primary font-bold text-xs tracking-[0.2em] uppercase">{{ $sections['kicker'] ?? 'Our Story' }}</p>
      <h1 class="font-headline text-5xl font-black mt-3 uppercase">{{ $sections['heading'] ?? ($page->title ?? 'About Us') }}</h1>
      @if (!empty($sections['intro']) || !empty($page->meta_description))
        <p class="max-w-3xl mt-6 text-slate-300">{{ $sections['intro'] ?? $page->meta_description }}</p>
      @endif
    </div>
  </section>

  <section class="max-w-6xl mx-auto px-6 py-16">
    <div class="bg-white rounded-xl shadow-sm border border-slate-200 p-8 md:p-12 prose prose-slate max-w-none">
      {!! $page->content_html !!}
    </div>
  </section>
@endsection