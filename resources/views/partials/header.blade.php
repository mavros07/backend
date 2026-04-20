@php
  $compareCount = \App\Support\Compare::count();
  $site = $site ?? [];
  $dealerPhone = $site['dealer_phone'] ?? '+1 212-226-3126';
  $dealerAddress = $site['dealer_address'] ?? '1840 E Garvey Ave South West Covina, CA 91791';
  $dealerHoursLabel = $site['dealer_hours_label'] ?? 'Work Hours';
  $socialFacebook = $site['social_facebook'] ?? 'https://www.facebook.com/';
  $socialInstagram = $site['social_instagram'] ?? 'https://www.instagram.com/';
  $socialLinkedin = $site['social_linkedin'] ?? 'https://www.linkedin.com/';
  $socialYoutube = $site['social_youtube'] ?? 'https://www.youtube.com/';
@endphp

<div id="stm-boats-header" class="listing-nontransparent-header">
  <div id="top-bar">
    <div class="container">
      <div class="clearfix top-bar-wrapper">
        <div class="pull-left">
          <div class="pull-left currency-switcher">
            <div class="stm-multiple-currency-wrap">
              <select data-translate="Currency (%s)" data-class="stm-multi-currency" name="stm-multi-currency">
                <option value="$-1">Currency (USD)</option>
                <option value="€-1.1">Euro</option>
              </select>
            </div>
          </div>
        </div>

        <div class="stm-boats-top-bar-right clearfix">
          <div class="stm-boats-top-bar-centered clearfix">
            <ul class="top-bar-info clearfix">
              <li><i class="far fa-calendar-check"></i> {{ $dealerHoursLabel }}</li>
              <li>
                <span id="top-bar-address" class="">
                  <i class="stm-service-icon-pin_big"></i>
                  {{ $dealerAddress }}
                </span>
              </li>
              <li><i class="fas fa-phone"></i> {{ $dealerPhone }}</li>
            </ul>

            <div class="header-top-bar-socs">
              <ul class="clearfix">
                <li>
                  <a href="{{ $socialFacebook }}" target="_blank" rel="noreferrer">
                    <i class="fab fa-facebook"></i>
                  </a>
                </li>
                <li>
                  <a href="{{ $socialInstagram }}" target="_blank" rel="noreferrer">
                    <i class="fab fa-instagram"></i>
                  </a>
                </li>
                <li>
                  <a href="{{ $socialLinkedin }}" target="_blank" rel="noreferrer">
                    <i class="fab fa-linkedin"></i>
                  </a>
                </li>
                <li>
                  <a href="{{ $socialYoutube }}" target="_blank" rel="noreferrer">
                    <i class="fab fa-youtube-play"></i>
                  </a>
                </li>
              </ul>
            </div>
          </div>

          <div class="clearfix top-bar-wrapper">
            <!--LANGS-->
          </div>
        </div>
      </div>
    </div>
  </div>

  <div id="header">
    <div class="header-listing header-listing-fixed listing-nontransparent-header">
      <div class="container header-inner-content">
        <div class="listing-logo-main" style="margin-top: 6px;">
          <a class="bloglogo" href="{{ route('home') }}">
            <img
              src="{{ asset('asset/images/branding/logo.svg') }}"
              style="width: 140px; height: auto;"
              title="Home"
              alt="{{ config('app.name') }}"
            />
          </a>
        </div>

        <div class="listing-service-right clearfix">
          <div class="listing-right-actions">
            <div class="pull-right hdn-767">
              <a class="lOffer-compare compare-cta" href="{{ route('compare') }}" title="View compared items">
                <span class="heading-font">Compare</span>
                <i class="stm-boats-icon-compare-boats list-icon"></i>
                <span class="list-badge">
                  <span class="stm-current-cars-in-compare">{{ $compareCount }}</span>
                </span>
              </a>
            </div>
          </div>

          <ul class="listing-menu clearfix">
            <li class="menu-item menu-item-type-custom menu-item-object-custom">
              <a href="{{ route('home') }}">Home</a>
            </li>
            <li class="menu-item menu-item-type-custom menu-item-object-custom">
              <a href="{{ route('about') }}">About Us</a>
            </li>
            <li class="menu-item menu-item-type-custom menu-item-object-custom">
              <a href="{{ route('contact') }}">Contact Us</a>
            </li>
            <li class="menu-item menu-item-type-custom menu-item-object-custom">
              <a href="{{ route('faq') }}">FAQ</a>
            </li>
            <li class="menu-item menu-item-type-custom menu-item-object-custom">
              <a href="{{ route('inventory.index') }}">Inventory</a>
            </li>
            @auth
              <li class="menu-item menu-item-type-custom menu-item-object-custom">
                <a href="{{ route('dashboard.favorites.index') }}">Saved</a>
              </li>
            @endauth
          </ul>
        </div>
      </div>
    </div>
  </div>
</div>

<div class="stm-boats-mobile-header">
  <a class="bloglogo" href="{{ route('home') }}">
    <img
      src="{{ asset('asset/images/branding/logo.svg') }}"
      style="width: 140px; height: auto;"
      title="Home"
      alt="{{ config('app.name') }}"
    />
  </a>

  <div class="stm-menu-boats-trigger">
    <span></span>
    <span></span>
    <span></span>
  </div>
</div>

<div class="stm-boats-mobile-menu">
  <div class="inner">
    <div class="inner-content">
      <ul class="listing-menu heading-font clearfix">
        <li class="menu-item menu-item-type-custom menu-item-object-custom">
          <a href="{{ route('home') }}">Home</a>
        </li>
        <li class="menu-item menu-item-type-custom menu-item-object-custom">
          <a href="{{ route('about') }}">About Us</a>
        </li>
        <li class="menu-item menu-item-type-custom menu-item-object-custom">
          <a href="{{ route('contact') }}">Contact Us</a>
        </li>
        <li class="menu-item menu-item-type-custom menu-item-object-custom">
          <a href="{{ route('faq') }}">FAQ</a>
        </li>
        <li class="menu-item menu-item-type-custom menu-item-object-custom">
          <a href="{{ route('inventory.index') }}">Inventory</a>
        </li>
        @auth
          <li class="menu-item menu-item-type-custom menu-item-object-custom">
            <a href="{{ route('dashboard.favorites.index') }}">Saved</a>
          </li>
        @endauth
        <li class="menu-item menu-item-type-custom menu-item-object-custom">
          <a href="{{ route('compare') }}">Compare</a>
        </li>
      </ul>

      <div id="top-bar-mobile">
        <div class="stm-boats-top-bar-centered clearfix">
          <ul class="top-bar-info clearfix">
            <li><i class="far fa-calendar-check"></i> {{ $dealerHoursLabel }}</li>
            <li>
              <span id="top-bar-address-mobile" class="">
                <i class="stm-service-icon-pin_big"></i>
                {{ $dealerAddress }}
              </span>
            </li>
            <li><i class="fas fa-phone"></i> {{ $dealerPhone }}</li>
          </ul>

          <div class="header-top-bar-socs">
            <ul class="clearfix">
              <li>
                <a href="{{ $socialFacebook }}" target="_blank" rel="noreferrer">
                  <i class="fab fa-facebook"></i>
                </a>
              </li>
              <li>
                <a href="{{ $socialInstagram }}" target="_blank" rel="noreferrer">
                  <i class="fab fa-instagram"></i>
                </a>
              </li>
              <li>
                <a href="{{ $socialLinkedin }}" target="_blank" rel="noreferrer">
                  <i class="fab fa-linkedin"></i>
                </a>
              </li>
              <li>
                <a href="{{ $socialYoutube }}" target="_blank" rel="noreferrer">
                  <i class="fab fa-youtube-play"></i>
                </a>
              </li>
            </ul>
          </div>
        </div>

        <div class="clearfix top-bar-wrapper">
          <!--LANGS-->
        </div>
      </div>
    </div>
  </div>
</div>

