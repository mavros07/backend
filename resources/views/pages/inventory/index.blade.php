@extends('layouts.site')

@section('content')
  <div class="container">
    <div class="stm-car-listing-sort-units stm-car-listing-directory-sort-units clearfix">
      <div class="stm-listing-directory-title">
        <div class="stm-listing-directory-total-matches total stm-secondary-color heading-font">
          <span>{{ isset($vehicles) ? $vehicles->total() : 0 }}</span>
          matches
        </div>
      </div>
    </div>

    <form method="get" action="{{ route('inventory.index') }}" class="mb-6" style="padding:16px; background:#f6f7f9; border-radius:8px;">
      @include('pages.partials.inventory-filters-fields', [
        'filters' => $filters,
        'filterOptions' => $filterOptions,
        'submitLabel' => 'Apply filters',
        'useSearchIcon' => false,
      ])
    </form>

    <div class="motors-elementor-inventory-search-results" id="listings-result" data-custom-img-size="stm-img-796-466">
      <div class="stm-isotope-sorting stm-isotope-sorting-main stm-isotope-sorting-list">
        @foreach($vehicles as $vehicle)
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
                  <div class="stm-badge-directory heading-font">Special</div>

                  <div class="hoverable-wrap">
                    @forelse($hover as $idx => $img)
                      <div class="hoverable-unit {{ $idx === 0 ? 'active' : '' }}">
                        <div class="thumb">
                          <img
                            loading="lazy"
                            decoding="async"
                            src="{{ asset($img->path) }}"
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

              <div class="actions" style="margin-top: 10px;">
                <form method="post" action="{{ route('compare.add', ['vehicle' => $vehicle->id]) }}">
                  @csrf
                  <button type="submit" class="button">
                    Add to compare
                  </button>
                </form>
              </div>
            </div>
          </div>
        @endforeach

        @if($vehicles->total() === 0)
          <div class="stm-listings-empty">
            <span class="stm-listings-empty__not-found">No vehicles found</span>
          </div>
        @endif
      </div>
    </div>

    @if($vehicles->hasPages())
      <div style="margin: 24px 0 40px;">
        {{ $vehicles->links() }}
      </div>
    @endif
  </div>
@endsection

