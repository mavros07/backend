@php
  $site = $site ?? [];
  $copyrightName = $site['copyright_line'] ?? config('app.name', 'REV AUTO GROUP');
  $socialFacebook = $site['social_facebook'] ?? '#';
  $socialInstagram = $site['social_instagram'] ?? '#';
  $socialLinkedin = $site['social_linkedin'] ?? '#';
  $socialYoutube = $site['social_youtube'] ?? '#';
  $dealerSalesHours = preg_split('/\r\n|\r|\n/', $site['dealer_sales_hours'] ?? "Monday - Friday: 09:00AM - 09:00PM\nSaturday: 09:00AM - 07:00PM\nSunday: Closed") ?: [];

  $aboutGalleryStr = \App\Models\PageSection::query()->where('page', 'about')->where('section_key', 'gallery')->value('content') ?? '[]';
  $aboutGallery = json_decode($aboutGalleryStr, true) ?? [];
  $footerGallery = array_slice($aboutGallery, 0, 4);
  $fallbacks = ['asset/images/media/footer-1.jpg', 'asset/images/media/footer-2.jpg', 'asset/images/media/footer-3.jpg', 'asset/images/media/footer-4.jpg'];
@endphp

<footer class="bg-[#1e2229] text-white pt-20 pb-10">
  <div class="max-w-7xl mx-auto px-6 grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-12 mb-20">
    <div class="space-y-6">
      <h4 class="text-brand_blue font-bold text-xs uppercase tracking-widest">{{ $copyrightName }}</h4>
      <p class="text-slate-400 text-[13px] leading-relaxed">Premium automotive retail experience. Redefining the way you browse and buy luxury vehicles with curated inventory and bespoke service.</p>
    </div>
    <div class="space-y-6">
      <h4 class="text-white font-bold text-xs uppercase tracking-widest">Photo Gallery</h4>
      <div class="grid grid-cols-4 gap-2">
        @for ($i = 0; $i < 4; $i++)
          @php
            $imgSrc = isset($footerGallery[$i]) ? \App\Support\VehicleImageUrl::url($footerGallery[$i]) : \App\Support\PlaceholderMedia::url($fallbacks[$i]);
          @endphp
          <img src="{{ $imgSrc }}" alt="Gallery Image {{ $i + 1 }}" class="w-full h-12 object-cover rounded-sm bg-slate-700" loading="lazy" />
        @endfor
      </div>
    </div>
    <div class="space-y-6">
      <h4 class="text-white font-bold text-xs uppercase tracking-widest">Latest Blog Posts</h4>
      <div class="space-y-4">
        <div>
          <p class="text-slate-300 text-[13px] font-medium">The Tesla Model S isn't the first truly autonomous car on the road...</p>
          <p class="text-brand_blue text-[11px] mt-1 font-bold">NO COMMENTS</p>
        </div>
      </div>
    </div>
    <div class="space-y-6">
      <h4 class="text-white font-bold text-xs uppercase tracking-widest">Social Network</h4>
      <div class="flex gap-4">
        <a href="{{ $socialFacebook }}" class="w-10 h-10 bg-slate-700 rounded flex items-center justify-center hover:bg-brand_blue transition-colors"><span class="material-symbols-outlined text-sm">share</span></a>
        <a href="{{ $socialInstagram }}" class="w-10 h-10 bg-slate-700 rounded flex items-center justify-center hover:bg-brand_blue transition-colors"><span class="material-symbols-outlined text-sm">camera_alt</span></a>
        <a href="{{ $socialLinkedin }}" class="w-10 h-10 bg-slate-700 rounded flex items-center justify-center hover:bg-brand_blue transition-colors"><span class="material-symbols-outlined text-sm">group</span></a>
        <a href="{{ $socialYoutube }}" class="w-10 h-10 bg-slate-700 rounded flex items-center justify-center hover:bg-brand_blue transition-colors"><span class="material-symbols-outlined text-sm">play_arrow</span></a>
      </div>
    </div>
  </div>

  <div class="max-w-7xl mx-auto px-6 grid grid-cols-1 md:grid-cols-4 gap-8 py-10 border-y border-slate-700 mb-10">
    <div>
      <h4 class="font-bold text-xs uppercase mb-6 tracking-widest">Subscribe</h4>
      <div class="flex">
        <input class="bg-white text-slate-900 border-none px-4 py-3 text-[13px] w-full rounded-l-sm" placeholder="Enter your email..." type="email" />
        <button class="bg-brand_orange text-white px-4 flex items-center justify-center rounded-r-sm"><span class="material-symbols-outlined">send</span></button>
      </div>
    </div>
    <div>
      <h4 class="font-bold text-xs uppercase mb-6 tracking-widest">Sales Hours</h4>
      <div class="text-[12px] text-slate-400 space-y-1">@foreach ($dealerSalesHours as $line)<p>{{ $line }}</p>@endforeach</div>
    </div>
    <div>
      <h4 class="font-bold text-xs uppercase mb-6 tracking-widest">Service Hours</h4>
      <div class="text-[12px] text-slate-400 space-y-1">@foreach ($dealerSalesHours as $line)<p>{{ $line }}</p>@endforeach</div>
    </div>
    <div>
      <h4 class="font-bold text-xs uppercase mb-6 tracking-widest">Parts Hours</h4>
      <div class="text-[12px] text-slate-400 space-y-1">@foreach ($dealerSalesHours as $line)<p>{{ $line }}</p>@endforeach</div>
    </div>
  </div>

  <div class="max-w-7xl mx-auto px-6 flex flex-col md:flex-row justify-between items-center text-[11px] text-slate-500 font-bold uppercase tracking-widest">
    <p>&copy; {{ date('Y') }} {{ $copyrightName }}. All Rights Reserved.</p>
    <div class="flex items-center gap-6 mt-4 md:mt-0">
      <a class="hover:text-white transition-colors" href="#">Privacy Policy</a>
      <a class="hover:text-white transition-colors" href="#">Terms of Service</a>
    </div>
  </div>
</footer>