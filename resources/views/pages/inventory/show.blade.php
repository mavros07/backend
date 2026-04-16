@extends('layouts.site')

@section('content')
  @php
    $vehicle = $vehicle ?? null;
    $images = $vehicle?->images ?? collect();
    $cover = $images->first();
    $isFavorited = $isFavorited ?? false;
  @endphp

  <div class="stm-single-car-page single-listings-template">
    <div class="container">
      @if(session('status'))
        <div style="padding:12px 16px; margin-bottom:16px; background:var(--motors-success-bg-color,#dbf2a2); border-radius:6px;">
          {{ session('status') }}
        </div>
      @endif

      @if($errors->any())
        <div style="padding:12px 16px; margin-bottom:16px; background:var(--motors-error-bg-color); border-radius:6px; color:var(--motors-error-text-color);">
          <ul style="margin:0; padding-left:18px;">
            @foreach($errors->all() as $err)
              <li>{{ $err }}</li>
            @endforeach
          </ul>
        </div>
      @endif
      <div class="stm-listing-single-price-title heading-font clearfix">
        <div class="stm-single-title-wrap">
          <h1 class="title">
            <div class="labels">{{ $vehicle?->model ?? '' }}</div>
            {{ $vehicle?->year ?? '' }}
          </h1>
        </div>
      </div>

      <div class="row">
        <div class="col-md-8">
          <div class="motors-elementor-single-listing-gallery video-left badge-left-top display-thumbnails">
            <div class="swiper-container motors-elementor-big-gallery">
              <div class="swiper-wrapper">
                @forelse($images as $img)
                  <div class="stm-single-image swiper-slide">
                    <a href="{{ asset($img->path) }}" class="stm_fancybox" rel="stm-car-gallery">
                      <img src="{{ asset($img->path) }}" class="img-responsive wp-post-image" alt="" decoding="async" />
                    </a>
                  </div>
                @empty
                  <div class="stm-single-image swiper-slide">
                    <div class="img-responsive wp-post-image" style="width:100%; aspect-ratio: 795 / 463; background: #f0f3f7; display:flex; align-items:center; justify-content:center;">
                      <span class="heading-font" style="opacity:.7;">No image</span>
                    </div>
                  </div>
                @endforelse
              </div>
            </div>
          </div>

          <div style="margin-top: 18px;">
            <h4 class="heading-font">Details</h4>
            <ul class="list-unstyled" style="padding-left: 0; line-height: 1.8;">
              @if($vehicle?->condition)
                <li><strong>Condition:</strong> {{ ucfirst($vehicle->condition) }}</li>
              @endif
              @if($vehicle?->location)
                <li><strong>Location:</strong> {{ $vehicle->location }}</li>
              @endif
              @if($vehicle?->engine_size)
                <li><strong>Engine:</strong> {{ $vehicle->engine_size }}</li>
              @endif
              @if($vehicle?->body_type)
                <li><strong>Body:</strong> {{ $vehicle->body_type }}</li>
              @endif
              @if($vehicle?->drive)
                <li><strong>Drive:</strong> {{ $vehicle->drive }}</li>
              @endif
            </ul>
          </div>

          @if(is_array($vehicle?->features) && count($vehicle->features) > 0)
            <div style="margin-top: 18px;">
              <h4 class="heading-font">Features</h4>
              <ul style="padding-left: 18px; line-height: 1.8;">
                @foreach($vehicle->features as $feature)
                  <li>{{ $feature }}</li>
                @endforeach
              </ul>
            </div>
          @endif

          <div style="margin-top: 18px;">
            <h4 class="heading-font">Description</h4>
            <p>{{ $vehicle?->description ?? '' }}</p>
          </div>
        </div>

        <div class="col-md-4">
          <div class="stm-single-car-page-data">
            <div class="single-car-prices">
              <div class="single-regular-sale-price">
                <table>
                  <tr>
                    <td colspan="2" style="border: 0; padding-bottom: 5px;" align="center">
                      <span class="labeled">PRICE</span>
                    </td>
                  </tr>
                  <tr>
                    <td>
                      <div class="regular-price-with-sale">
                        <strong class="h4">
                          @if(!is_null($vehicle?->price))
                            ${{ number_format($vehicle->price, 0, '.', ' ') }}
                          @endif
                        </strong>
                      </div>
                    </td>
                  </tr>
                </table>
              </div>
            </div>

            <div class="stm_single_car_mpg" style="margin-top: 18px;">
              <div class="row">
                <div class="col-xs-6">
                  <div class="mpg-unit">
                    <span class="name">Mileage</span>
                    <span class="value">{{ $vehicle?->mileage ?? '' }}</span>
                  </div>
                </div>
                <div class="col-xs-6">
                  <div class="mpg-unit">
                    <span class="name">Fuel</span>
                    <span class="value">{{ $vehicle?->fuel_type ?? '' }}</span>
                  </div>
                </div>
              </div>
            </div>

            <div style="margin-top: 18px;">
              <a class="button" href="{{ route('inventory.index') }}">Back to Inventory</a>
            </div>

            @auth
              <div style="margin-top: 14px;">
                <form method="post" action="{{ route('favorites.toggle', ['vehicle' => $vehicle->id]) }}">
                  @csrf
                  <button type="submit" class="button" style="width:100%;">
                    {{ $isFavorited ? 'Remove from saved' : 'Save listing' }}
                  </button>
                </form>
              </div>
            @endauth

            @if($vehicle->status === 'approved')
              <div style="margin-top: 22px; padding-top: 18px; border-top: 1px solid var(--motors-border-color);">
                <h4 class="heading-font" style="margin-top:0;">Contact seller</h4>
                <p style="opacity:0.8; font-size: 13px; line-height: 1.5;">Send a message about this vehicle. The seller will reply to your email.</p>
                <form method="post" action="{{ route('inventory.inquiry', ['slug' => $vehicle->slug]) }}">
                  @csrf
                  <div style="margin-bottom:10px;">
                    <label class="heading-font" style="display:block; font-size:12px; margin-bottom:4px;">Your name</label>
                    <input type="text" name="sender_name" value="{{ old('sender_name', auth()->user()?->name) }}" class="form-control" required />
                  </div>
                  <div style="margin-bottom:10px;">
                    <label class="heading-font" style="display:block; font-size:12px; margin-bottom:4px;">Email</label>
                    <input type="email" name="sender_email" value="{{ old('sender_email', auth()->user()?->email) }}" class="form-control" required />
                  </div>
                  <div style="margin-bottom:12px;">
                    <label class="heading-font" style="display:block; font-size:12px; margin-bottom:4px;">Message</label>
                    <textarea name="message" class="form-control" rows="4" required>{{ old('message') }}</textarea>
                  </div>
                  <button type="submit" class="button" style="width:100%;">Send message</button>
                </form>
              </div>
            @endif
          </div>
        </div>
      </div>
    </div>
  </div>
@endsection

