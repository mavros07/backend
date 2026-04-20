@extends('layouts.site')

@php
  $site = $site ?? [];
  $address = $site['dealer_address'] ?? '1840 E Garvey Ave South West Covina, CA 91791';
  $salesPhone = $site['dealer_sales_phone'] ?? '(888) 354-1781';
  $hours = $site['dealer_sales_hours'] ?? "Mon - Fri: 09:00AM - 09:00PM\nSaturday: 09:00AM - 07:00PM\nSunday: Closed";
@endphp

@section('content')
  @if(session('status'))
    <div class="max-w-5xl mx-auto px-4 pt-8"><div class="p-4 bg-green-100 text-green-900 rounded">{{ session('status') }}</div></div>
  @endif

  @if($errors->any())
    <div class="max-w-5xl mx-auto px-4 pt-8"><div class="p-4 bg-red-100 text-red-900 rounded"><ul class="list-disc pl-5">@foreach($errors->all() as $err)<li>{{ $err }}</li>@endforeach</ul></div></div>
  @endif

  <section class="relative min-h-[700px] flex items-center justify-center py-20 px-4 overflow-hidden">
    <img src="{{ asset('asset/images/media/contact-hero-bg.jpg') }}" alt="" class="absolute inset-0 h-full w-full object-cover" />
    <div class="absolute inset-0 bg-black/30"></div>
    <div class="relative w-full max-w-5xl bg-white shadow-2xl rounded-sm p-10 md:p-16">
      <h1 class="font-headline text-4xl md:text-5xl font-black mb-12 tracking-tight text-slate-900">CONTACT US</h1>
      <form class="grid grid-cols-1 md:grid-cols-2 gap-x-8 gap-y-6" method="post" action="{{ route('contact.submit') }}">
        @csrf
        <div class="space-y-2"><label class="text-[13px] font-bold text-slate-900">First Name*</label><input name="first_name" class="w-full bg-[#ebf1f7] border-none p-4 rounded-sm text-sm focus:ring-1 focus:ring-motors_blue" placeholder="Enter your first name" type="text" value="{{ old('first_name') }}" required /></div>
        <div class="space-y-2 md:row-span-3"><label class="text-[13px] font-bold text-slate-900">Comment</label><textarea name="message" class="w-full bg-[#ebf1f7] border-none p-4 rounded-sm text-sm focus:ring-1 focus:ring-motors_blue h-[calc(100%-28px)]" placeholder="Enter your message..." rows="8" required>{{ old('message') }}</textarea></div>
        <div class="space-y-2"><label class="text-[13px] font-bold text-slate-900">Last Name*</label><input name="last_name" class="w-full bg-[#ebf1f7] border-none p-4 rounded-sm text-sm focus:ring-1 focus:ring-motors_blue" placeholder="Enter your last name" type="text" value="{{ old('last_name') }}" required /></div>
        <div class="space-y-2"><label class="text-[13px] font-bold text-slate-900">Email*</label><input name="email" class="w-full bg-[#ebf1f7] border-none p-4 rounded-sm text-sm focus:ring-1 focus:ring-motors_blue" placeholder="email@domain.com" type="email" value="{{ old('email') }}" required /></div>
        <div class="space-y-2"><label class="text-[13px] font-bold text-slate-900">Phone</label><input name="phone" class="w-full bg-[#ebf1f7] border-none p-4 rounded-sm text-sm focus:ring-1 focus:ring-motors_blue" placeholder="Phone number" type="tel" value="{{ old('phone') }}" /></div>
        <div class="md:col-span-2 flex flex-col md:flex-row items-center justify-between gap-6 mt-8"><label class="flex items-center gap-3 cursor-pointer"><input class="w-4 h-4 border-none bg-[#ebf1f7] text-motors_blue rounded-sm focus:ring-0" type="checkbox"/><span class="text-[13px] text-slate-500">Subscribe and get latest updates by email</span></label><button class="bg-motors_blue text-white px-14 py-4 font-bold text-sm rounded shadow-lg hover:brightness-110 transition-all uppercase tracking-widest" type="submit">SUBMIT</button></div>
      </form>
    </div>
  </section>

  <section class="bg-white py-24">
    <div class="max-w-7xl mx-auto px-6 grid grid-cols-1 lg:grid-cols-12 gap-12">
      <div class="lg:col-span-4 space-y-8">
        <div class="flex bg-slate-900 text-white font-bold text-[13px] uppercase tracking-wider">
          <button class="flex-1 py-4 bg-white text-slate-900 border-t-2 border-motors_orange" data-contact-tab="parts" type="button">PARTS</button>
          <button class="flex-1 py-4 hover:bg-slate-800 transition-colors" data-contact-tab="sales" type="button">SALES</button>
          <button class="flex-1 py-4 hover:bg-slate-800 transition-colors" data-contact-tab="renting" type="button">RENTING</button>
        </div>

        @foreach(['parts','sales','renting'] as $panel)
          <div class="space-y-10 pt-4 {{ $loop->first ? '' : 'hidden' }}" data-contact-panel="{{ $panel }}">
            <div class="flex items-start gap-6"><div class="w-12 h-12 shrink-0 border-2 border-motors_orange rounded-full flex items-center justify-center text-motors_orange"><span class="material-symbols-outlined text-2xl">location_on</span></div><div><h4 class="font-bold text-[14px] text-slate-900 mb-1 uppercase">Address</h4><p class="text-slate-500 text-[14px] leading-relaxed">{!! nl2br(e($address)) !!}</p></div></div>
            <div class="flex items-start gap-6"><div class="w-12 h-12 shrink-0 border-2 border-motors_orange rounded-full flex items-center justify-center text-motors_orange"><span class="material-symbols-outlined text-2xl">call</span></div><div><h4 class="font-bold text-[14px] text-slate-900 mb-1 uppercase">Sales Phone</h4><p class="text-slate-500 text-[14px]">{{ $salesPhone }}</p></div></div>
            <div class="flex items-start gap-6"><div class="w-12 h-12 shrink-0 border-2 border-motors_orange rounded-full flex items-center justify-center text-motors_orange"><span class="material-symbols-outlined text-2xl">schedule</span></div><div><h4 class="font-bold text-[14px] text-slate-900 mb-1 uppercase">Sales Hours</h4><div class="text-slate-500 text-[14px] space-y-1">{!! nl2br(e($hours)) !!}</div></div></div>
          </div>
        @endforeach
      </div>

      <div class="lg:col-span-8 h-[550px] relative rounded shadow-lg overflow-hidden grayscale contrast-125 border border-gray-100">
        <img alt="Map" class="w-full h-full object-cover" src="{{ asset('asset/images/media/contact-map.jpg') }}"/>
        <div class="absolute inset-0 pointer-events-none border-[12px] border-white/10"></div>
      </div>
    </div>
  </section>
@endsection