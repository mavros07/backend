<div class="stm-elementor_listings_grid view_type_grid style_1">
  <div class="listing-car-items-units" id="selg-home-recent-cars">
    <div class="listing-car-items listing-cars-grid text-center clearfix">
      @forelse ($vehicles as $vehicle)
        @php
          $hover = ($vehicle->images ?? collect())->slice(0, 5)->values();
          $cover = $hover->first();
        @endphp
        <div class="dp-in">
          <div class="listing-car-item">
            <div class="listing-car-item-inner">
              <a
                href="{{ route('inventory.show', ['slug' => $vehicle->slug]) }}"
                class="rmv_txt_drctn"
                title="View full information about {{ $vehicle->title }}"
              >
                <div class="text-center">
                  <div class="image dp-in">
                    <div class="interactive-hoverable">
                      <div class="hoverable-wrap">
                        @forelse ($hover as $idx => $img)
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
                              style="width:100%; aspect-ratio: 350 / 221; background:#f0f3f7; display:flex; align-items:center; justify-content:center;"
                            >
                              <span class="heading-font" style="opacity:.7;">No image</span>
                            </div>
                          </div>
                        @endforelse

                        <div class="stm-badge-directory heading-font">Special</div>
                      </div>

                      @if ($hover->isNotEmpty())
                        <div class="hoverable-indicators">
                          @foreach ($hover as $idx => $img)
                            <div class="indicator {{ $idx === 0 ? 'active' : '' }}"></div>
                          @endforeach
                        </div>
                      @endif
                    </div>
                  </div>
                </div>

                <div class="listing-car-item-meta">
                  <div class="car-meta-top heading-font clearfix">
                    <div class="sell-online-wrap price">
                      <div class="normal-price">
                        <span class="normal_font">BUY ONLINE</span>
                        <span class="heading-font">
                          @if (!is_null($vehicle->price))
                            ${{ number_format($vehicle->price, 0, '.', ' ') }}
                          @endif
                        </span>
                      </div>
                    </div>

                    <div class="car-title" data-max-char="24">
                      {{ $vehicle->model ?: $vehicle->title }}
                    </div>
                  </div>

                  <div class="car-meta-bottom">
                    <ul>
                      <li>
                        <i class="stm-icon-road"></i>
                        <span>{{ $vehicle->mileage ?? 0 }}</span>
                        <span>mi</span>
                      </li>
                      <li>
                        <i class="stm-icon-transmission_fill"></i>
                        <span>{{ $vehicle->transmission ?: 'Automatic' }}</span>
                      </li>
                      <li>
                        <i class="stm-icon-fuel"></i>
                        <span>{{ $vehicle->fuel_type ?: 'N/A' }}</span>
                      </li>
                    </ul>
                  </div>
                </div>
              </a>
            </div>
          </div>
        </div>
      @empty
        <div class="stm-listings-empty">
          <span class="stm-listings-empty__not-found">No vehicles found</span>
        </div>
      @endforelse
    </div>
  </div>
</div>
