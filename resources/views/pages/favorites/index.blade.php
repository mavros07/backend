@extends('layouts.site')

@section('content')
  <div class="container">
    <div class="stm-listing-directory-title" style="margin: 24px 0 16px;">
      <h1 class="heading-font" style="margin: 0;">Saved listings</h1>
      <p style="opacity: 0.75; margin: 8px 0 0;">Vehicles you bookmarked from inventory.</p>
    </div>

    @if(session('status'))
      <div style="padding:12px 16px; margin-bottom:16px; background:var(--motors-success-bg-color,#dbf2a2); border-radius:6px;">
        {{ session('status') }}
      </div>
    @endif

    <div class="motors-elementor-inventory-search-results" id="listings-result" data-custom-img-size="stm-img-796-466">
      <div class="stm-isotope-sorting stm-isotope-sorting-main stm-isotope-sorting-list">
        @forelse($vehicles as $vehicle)
          @php
            $images = $vehicle->images ?? collect();
            $hover = $images->slice(0, 5);
          @endphp

          <div
            class="listing-list-loop stm-listing-directory-list-loop stm-isotope-listing-item all listing_is_active stm-special-car-top-on"
            data-price="{{ $vehicle->price ?? '' }}"
            data-mileage="{{ $vehicle->mileage ?? '' }}"
          >
            <div class="image">
              <a href="{{ route('inventory.show', ['slug' => $vehicle->slug]) }}" class="rmv_txt_drctn">
                <div class="image-inner interactive-hoverable">
                  <div class="stm-badge-directory heading-font">Saved</div>

                  <div class="hoverable-wrap">
                    @forelse($hover as $idx => $img)
                      <div class="hoverable-unit {{ $idx === 0 ? 'active' : '' }}">
                        <div class="thumb">
                          <img
                            loading="lazy"
                            decoding="async"
                            src="{{ \App\Support\VehicleImageUrl::url($img->path) }}"
                            class="img-responsive"
                            alt="{{ $vehicle->title }}"
                          />
                        </div>
                      </div>
                    @empty
                      <div class="hoverable-unit active">
                        <div
                          class="thumb img-responsive"
                          style="width:100%; aspect-ratio: 795 / 463; background: #f0f3f7; display:flex; align-items:center; justify-content:center;"
                        >
                          <span class="heading-font" style="opacity:.7;">No image</span>
                        </div>
                      </div>
                    @endforelse
                  </div>

                  @if($hover->isNotEmpty())
                    <div class="hoverable-indicators">
                      @foreach($hover as $idx => $img)
                        <div class="indicator {{ $idx === 0 ? 'active' : '' }}"></div>
                      @endforeach
                    </div>
                  @endif
                </div>
              </a>
            </div>

            <div class="content">
              <div class="meta-top">
                <div class="sell-online-wrap price">
                  <div class="normal-price">
                    <span class="normal_font">BUY CAR ONLINE</span>
                    <span class="heading-font">
                      @if(!is_null($vehicle->price))
                        ${{ number_format($vehicle->price, 0, '.', ' ') }}
                      @endif
                    </span>
                  </div>
                </div>
                <div class="title heading-font">
                  <a href="{{ route('inventory.show', ['slug' => $vehicle->slug]) }}" class="rmv_txt_drctn">
                    <div class="labels">{{ $vehicle->model ?? '' }}</div>
                    {{ $vehicle->year ?? '' }}
                  </a>
                </div>
              </div>

              <div class="meta-middle">
                <div class="meta-middle-row clearfix">
                  <div class="meta-middle-unit font-exists mileage">
                    <div class="meta-middle-unit-top">
                      <div class="icon"><i class="stm-icon-road"></i></div>
                      <div class="name">Mileage</div>
                    </div>
                    <div class="value">{{ $vehicle->mileage ?? '' }} mi</div>
                  </div>
                  <div class="meta-middle-unit meta-middle-divider"></div>

                  <div class="meta-middle-unit font-exists fuel">
                    <div class="meta-middle-unit-top">
                      <div class="icon"><i class="stm-icon-fuel"></i></div>
                      <div class="name">Fuel type</div>
                    </div>
                    <div class="value">{{ $vehicle->fuel_type ?? '' }}</div>
                  </div>
                  <div class="meta-middle-unit meta-middle-divider"></div>

                  <div class="meta-middle-unit font-exists engine">
                    <div class="meta-middle-unit-top">
                      <div class="icon"><i class="stm-icon-engine_fill"></i></div>
                      <div class="name">Transmission</div>
                    </div>
                    <div class="value">{{ $vehicle->transmission ?? '' }}</div>
                  </div>
                </div>
              </div>

              <div class="actions" style="margin-top: 10px; display:flex; gap:8px; flex-wrap:wrap;">
                <form method="post" action="{{ route('compare.add', ['vehicle' => $vehicle->id]) }}">
                  @csrf
                  <button type="submit" class="button">Add to compare</button>
                </form>
                <form method="post" action="{{ route('favorites.toggle', ['vehicle' => $vehicle->id]) }}">
                  @csrf
                  <button type="submit" class="button" style="background:#fff;color:#35475a;">Remove</button>
                </form>
              </div>
            </div>
          </div>
        @empty
          <div class="stm-listings-empty">
            <span class="stm-listings-empty__not-found">No saved vehicles yet.</span>
            <div style="margin-top:12px;">
              <a class="button" href="{{ route('inventory.index') }}">Browse inventory</a>
            </div>
          </div>
        @endforelse
      </div>
    </div>

    @if($vehicles->hasPages())
      <div style="margin: 24px 0 40px;">
        {{ $vehicles->links() }}
      </div>
    @endif
  </div>
@endsection
