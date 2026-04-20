@extends('layouts.site')

@section('content')
  <section class="bg-gradient-to-r from-[#111] to-[#1f2329] py-20">
    <div class="max-w-6xl mx-auto px-6 text-white">
      <p class="text-primary font-bold text-xs tracking-[0.2em] uppercase">Need Help?</p>
      <h1 class="font-headline text-5xl font-black mt-3 uppercase">Frequently Asked Questions</h1>
      <p class="max-w-3xl mt-6 text-slate-300">{{ $page->meta_description }}</p>
    </div>
  </section>

  <section class="max-w-5xl mx-auto px-6 py-16">
    <div class="bg-white rounded-xl shadow-sm border border-slate-200 p-8 md:p-12 prose prose-slate max-w-none">
      {!! $page->content_html !!}
    </div>
  </section>
@endsection